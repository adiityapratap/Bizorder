<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PHPMailer\PHPMailer\PHPMailer;

use Mpdf\Mpdf;

class Invoice extends MY_Controller
{
    public function __construct() 
    {   
      	parent::__construct();
        
        // Ensure we're using the correct tenant database (zeal) for bulk invoices
        if (!$this->session->userdata('tenantIdentifier')) {
            $this->session->set_userdata('tenantIdentifier', 'zenn');
        }
        
   	     $this->load->model('configfoodmenu_model');
   	     $this->load->model('common_model');
   	      $this->load->model('order_model');
   	      $this->load->model('general_model');
       !$this->ion_auth->logged_in() ? redirect('auth/login', 'refresh') : '';
        $this->POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $this->selected_location_id = $this->session->userdata('default_location_id');
        
        // Configure SMTP settings for email functionality
        $emailSettings = $this->general_model->fetchSmtpSettings('9999','9999');
        if ($emailSettings) {
            $this->configureSMTP($emailSettings);
        }
    }
    
    function dailyInvoice(){
        // FIXED: Show actual invoices instead of just orders
        
        // First, generate any missing invoices for delivered orders
        $generated = $this->order_model->generateMissingInvoices();
        if ($generated > 0) {
            $this->session->set_flashdata('success', "Generated {$generated} new invoices for delivered orders.");
        }
        
        // Get the actual invoice list
        $invoiceList = $this->order_model->getDailyInvoices();
        $data['orderLists'] = (isset($invoiceList) && !empty($invoiceList) ? $invoiceList : array());
        
        // Add debug info for development
        $data['debug_info'] = [
            'total_invoices' => count($invoiceList),
            'generated_new' => $generated
        ];
   
        $this->load->view('general/header');
        $this->load->view('Invoice/orderListDateWise',$data);   
        $this->load->view('general/footer'); 
    }
    
    /**
     * TEST ENDPOINT: Debug invoice system
     */
    function debugInvoiceSystem() {
        // SECURITY: Only allow in development/testing environments
        if (ENVIRONMENT === 'production') {
            show_404();
            return;
        }
        echo "<h2>Invoice System Debug</h2>";
        echo "<p>Current Date: " . date('Y-m-d H:i:s') . "</p>";
        
        // Check delivered orders
        $deliveredOrders = $this->common_model->fetchRecordsDynamically('orders', '*', [
            'status' => 4,
            'is_delivered' => 1,
            'buttonType' => 'sendorder'
        ]);
        
        echo "<h3>Delivered Orders (" . count($deliveredOrders) . "):</h3>";
        if (!empty($deliveredOrders)) {
            echo "<table border='1'>";
            echo "<tr><th>Order ID</th><th>Date</th><th>Dept ID</th><th>Status</th><th>Delivered</th></tr>";
            foreach ($deliveredOrders as $order) {
                echo "<tr>";
                echo "<td>{$order['order_id']}</td>";
                echo "<td>{$order['date']}</td>";
                echo "<td>{$order['dept_id']}</td>";
                echo "<td>{$order['status']}</td>";
                echo "<td>{$order['is_delivered']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No delivered orders found</p>";
        }
        
        // Generate missing invoices
        echo "<h3>Generating Missing Invoices...</h3>";
        $generated = $this->order_model->generateMissingInvoices();
        echo "<p>Generated: {$generated} invoices</p>";
        
        // Check current invoices
        $invoices = $this->order_model->getDailyInvoices();
        echo "<h3>Current Invoices (" . count($invoices) . "):</h3>";
        if (!empty($invoices)) {
            echo "<table border='1'>";
            echo "<tr><th>Invoice ID</th><th>Invoice Number</th><th>Order Date</th><th>Order ID</th><th>Status</th><th>Floor</th></tr>";
            foreach ($invoices as $invoice) {
                $statusText = ($invoice['status'] == 1) ? 'Pending' : (($invoice['status'] == 2) ? 'Paid' : 'Cancelled');
                echo "<tr>";
                echo "<td>{$invoice['invoice_id']}</td>";
                echo "<td>{$invoice['invoice_number']}</td>";
                echo "<td>{$invoice['date']}</td>";
                echo "<td>{$invoice['order_id']}</td>";
                echo "<td>{$statusText}</td>";
                echo "<td>{$invoice['floor_name']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No invoices found</p>";
        }
        
        echo "<hr>";
        echo "<p><a href='" . base_url('Orderportal/Invoice/dailyInvoice') . "'>Go to Invoice List</a></p>";
    }
    
    
       function viewInvoice($orderDate){
        
       $mpdf = new Mpdf();
       $invoiceOrderData = $this->order_model->fetchOrderForInvoice($orderDate); 
       
        
        $departmentSettingsData = $this->common_model->fetchRecordsDynamically('departmentSettings','','');
        
        // UPDATED: Get actual total suites serviced across all floors for this date
        $actualSuitesServiced = isset($invoiceOrderData[0]['total_bed_serviced']) ? (int)$invoiceOrderData[0]['total_bed_serviced'] : 0;
        
        // UPDATED: Get daily cost and minimum limit from settings (not from order table)
        $dailyCost = isset($departmentSettingsData[0]['daily_budget']) ? floatval($departmentSettingsData[0]['daily_budget']) : 0;
        $minimumLimit = isset($departmentSettingsData[0]['daily_limit']) ? intval($departmentSettingsData[0]['daily_limit']) : 40;
        
        // UPDATED: Apply billing logic - if total suites < minimum, bill for minimum suites
        $billablesuites = ($actualSuitesServiced < $minimumLimit) ? $minimumLimit : $actualSuitesServiced;
     
         
        $invoice_no = str_replace("-", "_", $orderDate);
        $data = [
            'invoice_no' => "#INV_".$invoice_no,
            'account_name' => isset($departmentSettingsData[0]['account_name']) ? $departmentSettingsData[0]['account_name'] : null,
            'account_no' => isset($departmentSettingsData[0]['account_no']) ? $departmentSettingsData[0]['account_no'] : null,
            'account_email' => isset($departmentSettingsData[0]['account_email']) ? $departmentSettingsData[0]['account_email'] : null,
            'bsb' => isset($departmentSettingsData[0]['bsb']) ? $departmentSettingsData[0]['bsb'] : null,
            'terms' => isset($departmentSettingsData[0]['terms']) ? $departmentSettingsData[0]['terms'] : null,
            'company_addr' => isset($departmentSettingsData[0]['company_addr']) ? $departmentSettingsData[0]['company_addr'] : null,
            'company_name' => isset($departmentSettingsData[0]['company_name']) ? $departmentSettingsData[0]['company_name'] : null,
            'abn' => isset($departmentSettingsData[0]['abn']) ? $departmentSettingsData[0]['abn'] : null,
            
            'hospital_company_name' => isset($departmentSettingsData[0]['hospital_company_name']) ? $departmentSettingsData[0]['hospital_company_name'] : null,
            'hospital_company_addr' => isset($departmentSettingsData[0]['hospital_company_addr']) ? $departmentSettingsData[0]['hospital_company_addr'] : null,
            'hospital_email' => isset($departmentSettingsData[0]['hospital_email']) ? $departmentSettingsData[0]['hospital_email'] : null,
            'hospital_phone' => isset($departmentSettingsData[0]['hospital_phone']) ? $departmentSettingsData[0]['hospital_phone'] : null,
            'hospital_abn' => isset($departmentSettingsData[0]['hospital_abn']) ? $departmentSettingsData[0]['hospital_abn'] : null,
   
            'date' => date('d-m-Y',strtotime($orderDate)),
            
            // UPDATED: Pass billing data from settings
            'actualSuitesServiced' => $actualSuitesServiced,
            'billableSuites' => $billablesuites,
            'dailyCost' => $dailyCost,
            'minimumLimit' => $minimumLimit,
            'floorsServiced' => isset($invoiceOrderData[0]['floors_serviced']) ? $invoiceOrderData[0]['floors_serviced'] : 'ALL',
            
            'invoiceData' => $invoiceOrderData,
            'departmentSettingsData' => $departmentSettingsData,
             
        ];
        
       
        $html = $this->load->view('Invoice/invoice', $data, TRUE);

        $mpdf->WriteHTML($html);
      $mpdf->Output('invoice.pdf', 'I');
        // $mpdf->Output('invoice.pdf', 'D');
        

    }
    
   
    
    
    
     function bulkInvoice(){
      
        $conditions['listtype'] = 'floor';
        $departmentListData = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions);
        $data['departments'] = $departmentListData;    
        
        $conditionsINV['is_deleted'] = 0;
        $bulkInvoiceList = $this->common_model->fetchRecordsDynamically('bulkInvoiceList','',$conditionsINV);
        
        // Sort by id DESC since created_at column doesn't exist
        if (!empty($bulkInvoiceList)) {
            usort($bulkInvoiceList, function($a, $b) {
                return $b['id'] - $a['id']; // Sort by ID descending (newest first)
            });
        }
        
        $data['invoiceLists'] = $bulkInvoiceList; 
        
        $this->load->view('general/header');
        $this->load->view('Invoice/bulkInvoiceLandingPage',$data);   
        $this->load->view('general/footer');
    }
    
    function generateBulkInvoice(){
        
     $start_date = $this->input->post('start_date');
     $end_date = $this->input->post('end_date');
     $start_date_formatted = date('dmy', strtotime($start_date));
     $end_date_formatted = date('dmy', strtotime($end_date));
     $invoice_id = "INV" . $start_date_formatted . $end_date_formatted;
     
      // first check if inv for same date has been created than do not include that day while generating Invoice
     // need to do later
     $bulkorderList   = $this->order_model->generateBulkInvoice(date('Y-m-d',strtotime($start_date)),date('Y-m-d',strtotime($end_date)));
     if(empty($bulkorderList)){
      echo  "<h3>No order exist for date selected</h3>";   exit;
     }
     
     $mpdf = new Mpdf();
    
          $invoiceListData['date_from'] = date('Y-m-d',strtotime($start_date));
          $invoiceListData['date_to'] = date('Y-m-d',strtotime($end_date));
          $invoiceListData['invoice_no'] = $invoice_id;
          $invoiceListData['date_generated'] = date('Y-m-d');
          $this->common_model->commonRecordCreate('bulkInvoiceList', $invoiceListData);   

         $departmentSettingsData = $this->common_model->fetchRecordsDynamically('departmentSettings','','');
        //   echo "<pre>"; print_r($bulkorderList); exit;

        $data = [
            'invoice_no' => $invoice_id,
            'order_date' => date('d-m-Y',strtotime($start_date)) .' To '.date('d-m-Y',strtotime($end_date)), 
            'account_name' => isset($departmentSettingsData[0]['account_name']) ? $departmentSettingsData[0]['account_name'] : null,
            'account_no' => isset($departmentSettingsData[0]['account_no']) ? $departmentSettingsData[0]['account_no'] : null,
            'account_email' => isset($departmentSettingsData[0]['account_email']) ? $departmentSettingsData[0]['account_email'] : null,
            'bsb' => isset($departmentSettingsData[0]['bsb']) ? $departmentSettingsData[0]['bsb'] : null,
            'terms' => isset($departmentSettingsData[0]['terms']) ? $departmentSettingsData[0]['terms'] : null,
            'company_addr' => isset($departmentSettingsData[0]['company_addr']) ? $departmentSettingsData[0]['company_addr'] : null,
            'company_name' => isset($departmentSettingsData[0]['company_name']) ? $departmentSettingsData[0]['company_name'] : null,
            'abn' => isset($departmentSettingsData[0]['abn']) ? $departmentSettingsData[0]['abn'] : null,
            'hospital_company_name' => isset($departmentSettingsData[0]['hospital_company_name']) ? $departmentSettingsData[0]['hospital_company_name'] : null,
            'hospital_company_addr' => isset($departmentSettingsData[0]['hospital_company_addr']) ? $departmentSettingsData[0]['hospital_company_addr'] : null,
            'hospital_email' => isset($departmentSettingsData[0]['hospital_email']) ? $departmentSettingsData[0]['hospital_email'] : null,
            'hospital_phone' => isset($departmentSettingsData[0]['hospital_phone']) ? $departmentSettingsData[0]['hospital_phone'] : null,
            'hospital_abn' => isset($departmentSettingsData[0]['hospital_abn']) ? $departmentSettingsData[0]['hospital_abn'] : null,
            'invoiceData' => $bulkorderList,
            'departmentSettingsData' => $departmentSettingsData,
        ];
        
       
        $html = $this->load->view('Invoice/bulkInvoice', $data, TRUE);
        $mpdf->WriteHTML($html);
        $mpdf->Output('invoice.pdf', 'I');
      
       $folder_path = APPPATH . 'BULK INVOICES/';
       if (!is_dir($folder_path)) {
        mkdir($folder_path, 0777, true); // Create the folder if it doesn't exist
       }
       
       $file_path = $folder_path . $invoice_id . '.pdf';
       $mpdf->Output($file_path, 'F'); 
       // $mpdf->Output('invoice.pdf', 'D');
        
        
    }
    
    function generateBulkInvoiceAjax(){
        // Set JSON content type header
        header('Content-Type: application/json');
        
        try {
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            
            // Validate input
            if (empty($start_date) || empty($end_date)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Start date and end date are required.'
                ]);
                return;
            }
            
            $start_date_formatted = date('dmy', strtotime($start_date));
            $end_date_formatted = date('dmy', strtotime($end_date));
            $invoice_id = "INV" . $start_date_formatted . $end_date_formatted;
            
            // Check if invoice already exists for this date range
            $existingInvoice = $this->common_model->fetchRecordsDynamically('bulkInvoiceList', '', [
                'invoice_no' => $invoice_id,
                'is_deleted' => 0
            ]);
            
            if (!empty($existingInvoice)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'An invoice for this date range already exists. Invoice No: ' . $invoice_id
                ]);
                return;
            }
            
            // Check for overlapping date ranges in existing invoices
            $overlappingInvoices = $this->tenantDb->query(
                "SELECT invoice_no, date_from, date_to FROM bulkInvoiceList 
                WHERE is_deleted = 0 
                AND (
                    (date_from <= ? AND date_to >= ?) OR
                    (date_from <= ? AND date_to >= ?) OR
                    (date_from >= ? AND date_to <= ?)
                )",
                [
                    date('Y-m-d', strtotime($start_date)), date('Y-m-d', strtotime($start_date)),
                    date('Y-m-d', strtotime($end_date)), date('Y-m-d', strtotime($end_date)),
                    date('Y-m-d', strtotime($start_date)), date('Y-m-d', strtotime($end_date))
                ]
            )->result_array();
            
            if (!empty($overlappingInvoices)) {
                $overlapping = $overlappingInvoices[0];
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Date range overlaps with existing invoice ' . $overlapping['invoice_no'] . 
                                ' (' . date('d-m-Y', strtotime($overlapping['date_from'])) . ' to ' . 
                                date('d-m-Y', strtotime($overlapping['date_to'])) . '). Please select a different date range.'
                ]);
                return;
            }
            
            // Get bulk order data
            $bulkorderList = $this->order_model->generateBulkInvoice(
                date('Y-m-d', strtotime($start_date)),
                date('Y-m-d', strtotime($end_date))
            );
            
            if (empty($bulkorderList)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No orders found for the selected date range (' . 
                                date('d-m-Y', strtotime($start_date)) . ' to ' . 
                                date('d-m-Y', strtotime($end_date)) . '). Please select a different date range.'
                ]);
                return;
            }
            
            // Create invoice record
            $invoiceListData = [
                'date_from' => date('Y-m-d', strtotime($start_date)),
                'date_to' => date('Y-m-d', strtotime($end_date)),
                'invoice_no' => $invoice_id,
                'date_generated' => date('Y-m-d'),
                'status' => 0 // Pending
            ];
            $this->common_model->commonRecordCreate('bulkInvoiceList', $invoiceListData);
            
            // Generate PDF
            $mpdf = new \Mpdf\Mpdf();
            $departmentSettingsData = $this->common_model->fetchRecordsDynamically('departmentSettings', '', '');
            
            // Get daily cost and minimum limit from settings (consistent with daily invoice)
            $dailyCost = isset($departmentSettingsData[0]['daily_budget']) ? floatval($departmentSettingsData[0]['daily_budget']) : 0;
            $minimumLimit = isset($departmentSettingsData[0]['daily_limit']) ? intval($departmentSettingsData[0]['daily_limit']) : 40;
            
            $data = [
                'invoice_no' => $invoice_id,
                'order_date' => date('d-m-Y', strtotime($start_date)) . ' to ' . date('d-m-Y', strtotime($end_date)),
                'start_date' => date('d-m-Y', strtotime($start_date)),
                'end_date' => date('d-m-Y', strtotime($end_date)),
                'date_from' => date('d-m-Y', strtotime($start_date)),
                'date_to' => date('d-m-Y', strtotime($end_date)),
                // Hospital/Client Details
                'hospital_name' => isset($departmentSettingsData[0]['hospital_name']) ? $departmentSettingsData[0]['hospital_name'] : null,
                'hospital_address' => isset($departmentSettingsData[0]['hospital_address']) ? $departmentSettingsData[0]['hospital_address'] : null,
                'hospital_email' => isset($departmentSettingsData[0]['hospital_email']) ? $departmentSettingsData[0]['hospital_email'] : null,
                'hospital_phone' => isset($departmentSettingsData[0]['hospital_phone']) ? $departmentSettingsData[0]['hospital_phone'] : null,
                'hospital_abn' => isset($departmentSettingsData[0]['hospital_abn']) ? $departmentSettingsData[0]['hospital_abn'] : null,
                'hospital_company_name' => isset($departmentSettingsData[0]['hospital_company_name']) ? $departmentSettingsData[0]['hospital_company_name'] : null,
                'hospital_company_addr' => isset($departmentSettingsData[0]['hospital_company_addr']) ? $departmentSettingsData[0]['hospital_company_addr'] : null,
                // Company Details (Bizorder)
                'company_name' => isset($departmentSettingsData[0]['company_name']) ? $departmentSettingsData[0]['company_name'] : null,
                'company_addr' => isset($departmentSettingsData[0]['company_addr']) ? $departmentSettingsData[0]['company_addr'] : null,
                'abn' => isset($departmentSettingsData[0]['abn']) ? $departmentSettingsData[0]['abn'] : null,
                // Bank Details
                'account_name' => isset($departmentSettingsData[0]['account_name']) ? $departmentSettingsData[0]['account_name'] : null,
                'account_no' => isset($departmentSettingsData[0]['account_no']) ? $departmentSettingsData[0]['account_no'] : null,
                'account_email' => isset($departmentSettingsData[0]['account_email']) ? $departmentSettingsData[0]['account_email'] : null,
                'bsb' => isset($departmentSettingsData[0]['bsb']) ? $departmentSettingsData[0]['bsb'] : null,
                'terms' => isset($departmentSettingsData[0]['terms']) ? $departmentSettingsData[0]['terms'] : null,
                // Billing Settings from departmentSettings
                'daily_cost' => $dailyCost,
                'minimum_limit' => $minimumLimit,
                // Invoice Data
                'invoiceData' => $bulkorderList,
                'departmentSettingsData' => $departmentSettingsData,
            ];
            
            $html = $this->load->view('Invoice/bulkInvoice', $data, TRUE);
            $mpdf->WriteHTML($html);
            
            // Save PDF file
            $folder_path = APPPATH . 'BULK INVOICES/';
            if (!is_dir($folder_path)) {
                mkdir($folder_path, 0777, true);
            }
            
            $file_path = $folder_path . $invoice_id . '.pdf';
            $mpdf->Output($file_path, 'F');
            
            // Return success response
            echo json_encode([
                'status' => 'success',
                'message' => 'Bulk invoice generated successfully! Invoice No: ' . $invoice_id,
                'invoice_no' => $invoice_id,
                'orders_count' => count($bulkorderList)
            ]);
            
        } catch (Exception $e) {
            log_message('error', "Error in generateBulkInvoiceAjax: " . $e->getMessage());
            echo json_encode([
                'status' => 'error',
                'message' => 'An error occurred while generating the invoice. Please try again.'
            ]);
        }
    }
    
public function download_invoice($invoice_no)
{
    try {
        $folder_path = APPPATH . 'BULK INVOICES/';
        $file_path = $folder_path . $invoice_no . '.pdf';
       
        if (file_exists($file_path)) {
            // File exists, serve it
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . basename($file_path) . '"');
            header('Content-Length: ' . filesize($file_path));
            readfile($file_path);
            exit;
        } else {
            // File doesn't exist - try to regenerate it
            log_message('error', "Invoice file not found: {$file_path}. Attempting to regenerate...");
            
            // Try to find the invoice in database and regenerate
            $conditions['invoice_no'] = $invoice_no;
            $conditions['is_deleted'] = 0;
            $invoiceData = $this->common_model->fetchRecordsDynamically('bulkInvoiceList', '', $conditions);
            
            if (!empty($invoiceData)) {
                // Invoice exists in database, regenerate the PDF
                $invoice = $invoiceData[0];
                $this->regenerateBulkInvoicePDF($invoice['date_from'], $invoice['date_to'], $invoice_no);
                
                // Check if file was created
                if (file_exists($file_path)) {
                    header('Content-Type: application/pdf');
                    header('Content-Disposition: inline; filename="' . basename($file_path) . '"');
                    header('Content-Length: ' . filesize($file_path));
                    readfile($file_path);
                    exit;
                } else {
                    throw new Exception('Failed to regenerate invoice PDF');
                }
            } else {
                throw new Exception('Invoice not found in database');
            }
        }
    } catch (Exception $e) {
        log_message('error', "Error in download_invoice: " . $e->getMessage());
        
        // Show user-friendly error page
        $this->load->view('general/header');
        $data['error_title'] = 'Invoice Not Available';
        $data['error_message'] = 'Sorry, the requested invoice could not be found or generated. Please contact support if this issue persists.';
        $data['invoice_no'] = $invoice_no;
        $this->load->view('Invoice/error', $data);
        $this->load->view('general/footer');
    }
}

private function regenerateBulkInvoicePDF($start_date, $end_date, $invoice_no) 
{
    try {
        // Get bulk order data for the date range
        $bulkorderList = $this->order_model->generateBulkInvoice($start_date, $end_date);
        
        if (empty($bulkorderList)) {
            throw new Exception('No order data found for date range');
        }
        
        $mpdf = new \Mpdf\Mpdf();
        $departmentSettingsData = $this->common_model->fetchRecordsDynamically('departmentSettings','','');
        
        // Get daily cost and minimum limit from settings (consistent with daily invoice)
        $dailyCost = isset($departmentSettingsData[0]['daily_budget']) ? floatval($departmentSettingsData[0]['daily_budget']) : 0;
        $minimumLimit = isset($departmentSettingsData[0]['daily_limit']) ? intval($departmentSettingsData[0]['daily_limit']) : 40;
        
        $data = [
            'invoice_no' => $invoice_no,
            'order_date' => date('d-m-Y', strtotime($start_date)) . ' to ' . date('d-m-Y', strtotime($end_date)),
            'start_date' => date('d-m-Y', strtotime($start_date)),
            'end_date' => date('d-m-Y', strtotime($end_date)),
            'date_from' => date('d-m-Y', strtotime($start_date)),
            'date_to' => date('d-m-Y', strtotime($end_date)),
            // Hospital/Client Details
            'hospital_name' => isset($departmentSettingsData[0]['hospital_name']) ? $departmentSettingsData[0]['hospital_name'] : null,
            'hospital_address' => isset($departmentSettingsData[0]['hospital_address']) ? $departmentSettingsData[0]['hospital_address'] : null,
            'hospital_email' => isset($departmentSettingsData[0]['hospital_email']) ? $departmentSettingsData[0]['hospital_email'] : null,
            'hospital_phone' => isset($departmentSettingsData[0]['hospital_phone']) ? $departmentSettingsData[0]['hospital_phone'] : null,
            'hospital_abn' => isset($departmentSettingsData[0]['hospital_abn']) ? $departmentSettingsData[0]['hospital_abn'] : null,
            'hospital_company_name' => isset($departmentSettingsData[0]['hospital_company_name']) ? $departmentSettingsData[0]['hospital_company_name'] : null,
            'hospital_company_addr' => isset($departmentSettingsData[0]['hospital_company_addr']) ? $departmentSettingsData[0]['hospital_company_addr'] : null,
            // Company Details (Bizorder)
            'company_name' => isset($departmentSettingsData[0]['company_name']) ? $departmentSettingsData[0]['company_name'] : null,
            'company_addr' => isset($departmentSettingsData[0]['company_addr']) ? $departmentSettingsData[0]['company_addr'] : null,
            'abn' => isset($departmentSettingsData[0]['abn']) ? $departmentSettingsData[0]['abn'] : null,
            // Bank Details
            'account_name' => isset($departmentSettingsData[0]['account_name']) ? $departmentSettingsData[0]['account_name'] : null,
            'account_no' => isset($departmentSettingsData[0]['account_no']) ? $departmentSettingsData[0]['account_no'] : null,
            'account_email' => isset($departmentSettingsData[0]['account_email']) ? $departmentSettingsData[0]['account_email'] : null,
            'bsb' => isset($departmentSettingsData[0]['bsb']) ? $departmentSettingsData[0]['bsb'] : null,
            'terms' => isset($departmentSettingsData[0]['terms']) ? $departmentSettingsData[0]['terms'] : null,
            // Billing Settings from departmentSettings
            'daily_cost' => $dailyCost,
            'minimum_limit' => $minimumLimit,
            // Invoice Data
            'invoiceData' => $bulkorderList,
            'departmentSettingsData' => $departmentSettingsData,
        ];
        
        $html = $this->load->view('Invoice/bulkInvoice', $data, TRUE);
        $mpdf->WriteHTML($html);
        
        // Save the PDF file
        $folder_path = APPPATH . 'BULK INVOICES/';
        if (!is_dir($folder_path)) {
            mkdir($folder_path, 0777, true);
        }
        
        $file_path = $folder_path . $invoice_no . '.pdf';
        $mpdf->Output($file_path, 'F');
        
        log_message('info', "Successfully regenerated invoice PDF: {$file_path}");
        
    } catch (Exception $e) {
        log_message('error', "Failed to regenerate invoice PDF: " . $e->getMessage());
        throw $e;
    }
}



    
    function sendInvoiceEmail() {
        // Set JSON content type header
        header('Content-Type: application/json');
        
        try {
            // Check if user is logged in for AJAX requests
            if (!$this->ion_auth->logged_in()) {
                echo json_encode(['status' => 'error', 'message' => 'Authentication required. Please refresh the page and try again.']);
                return;
            }
            
            $invoice_no = $this->input->post('invoice_id');
            $mailto = $this->input->post('mailto');
            
            // Validation
            if (empty($invoice_no) || empty($mailto)) {
                echo json_encode(['status' => 'error', 'message' => 'Invoice ID and email are required']);
                return;
            }
            
            // Validate email format
            if (!filter_var($mailto, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid email address format']);
                return;
            }
            
            // Rate limiting: Prevent sending same invoice to same email within 60 seconds
            $rate_limit_key = 'email_sent_' . md5($invoice_no . '_' . $mailto);
            $last_sent = $this->session->userdata($rate_limit_key);
            
            if ($last_sent && (time() - $last_sent) < 60) {
                $wait_time = 60 - (time() - $last_sent);
                echo json_encode(['status' => 'error', 'message' => "Please wait {$wait_time} seconds before sending another email for this invoice"]);
                return;
            }
            
            $folder_path = APPPATH . 'BULK INVOICES/';
            $file_path = $folder_path . $invoice_no . '.pdf';

            if (!file_exists($file_path)) {
                // Try to regenerate the invoice
                $conditions['invoice_no'] = $invoice_no;
                $conditions['is_deleted'] = 0;
                $invoiceData = $this->common_model->fetchRecordsDynamically('bulkInvoiceList', '', $conditions);
                
                if (!empty($invoiceData)) {
                    $invoice = $invoiceData[0];
                    $this->regenerateBulkInvoicePDF($invoice['date_from'], $invoice['date_to'], $invoice_no);
                    
                    if (!file_exists($file_path)) {
                        echo json_encode(['status' => 'error', 'message' => 'Invoice file could not be generated']);
                        return;
                    }
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Invoice not found']);
                    return;
                }
            }
            
            // Prepare email content
            $data['invoice_no'] = $invoice_no;
            $email_content = $this->load->view('Email/invoice', $data, TRUE);
            
            // Send email with PDF attachment
            $mailResult = $this->sendEmail($mailto, 'Invoice', $email_content, 'info@bizadmin.com.au', '', 'Bizorder', $file_path);

            if ($mailResult) {
                // Set rate limiting timestamp
                $this->session->set_userdata($rate_limit_key, time());
                echo json_encode(['status' => 'success', 'message' => 'Invoice sent successfully to ' . $mailto]);
            } else {
                echo json_encode(['status' => 'failed', 'message' => 'Unable to send invoice. Please check email configuration.']);
            }
            
        } catch (Exception $e) {
            log_message('error', 'Error in sendInvoiceEmail: ' . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'An error occurred while sending the invoice']);
        }
    }

    function sendPaymentLink(){
        // Set JSON content type header
        header('Content-Type: application/json');
        
        try {
            // Check if user is logged in for AJAX requests
            if (!$this->ion_auth->logged_in()) {
                echo json_encode(['status' => 'error', 'message' => 'Authentication required. Please refresh the page and try again.']);
                return;
            }
            
            $invoice_no = $this->input->post('invoice_id');
            $mailto = $this->input->post('mailto');
            
            if (empty($invoice_no) || empty($mailto)) {
                echo json_encode(['status' => 'error', 'message' => 'Invoice ID and email are required']);
                return;
            }
            
            // Rate limiting: Prevent sending same invoice to same email within 60 seconds
            $rate_limit_key = 'email_sent_' . md5($invoice_no . '_' . $mailto);
            $last_sent = $this->session->userdata($rate_limit_key);
            
            if ($last_sent && (time() - $last_sent) < 60) {
                $wait_time = 60 - (time() - $last_sent);
                echo json_encode(['status' => 'error', 'message' => "Please wait {$wait_time} seconds before sending another email for this invoice"]);
                return;
            }
            
            // Validate email format
            if (!filter_var($mailto, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid email address format']);
                return;
            }
            
            // Check if this is a daily invoice (new system) or bulk invoice (old system)
            $daily_invoice = $this->common_model->fetchRecordsDynamically('daily_invoices', ['order_date', 'order_id'], ['invoice_number' => $invoice_no]);
            
            if (!empty($daily_invoice)) {
                // New daily invoice system - generate PDF on the fly
                $orderDate = $daily_invoice[0]['order_date'];
                
                // Generate PDF content (same as viewInvoice function)
                $mpdf = new \Mpdf\Mpdf();
                $invoiceOrderData = $this->order_model->fetchOrderForInvoice($orderDate); 
                $departmentSettingsData = $this->common_model->fetchRecordsDynamically('departmentSettings','','');
                
                // UPDATED: Get actual total suites serviced across all floors for this date
                $actualSuitesServiced = isset($invoiceOrderData[0]['total_bed_serviced']) ? (int)$invoiceOrderData[0]['total_bed_serviced'] : 0;
                
                // UPDATED: Get daily cost and minimum limit from settings (not from order table)
                $dailyCost = isset($departmentSettingsData[0]['daily_budget']) ? floatval($departmentSettingsData[0]['daily_budget']) : 0;
                $minimumLimit = isset($departmentSettingsData[0]['daily_limit']) ? intval($departmentSettingsData[0]['daily_limit']) : 40;
                
                // UPDATED: Apply billing logic - if total suites < minimum, bill for minimum suites
                $billablesuites = ($actualSuitesServiced < $minimumLimit) ? $minimumLimit : $actualSuitesServiced;
                
                $invoice_display_no = str_replace("-", "_", $orderDate);
                $data = [
                    'invoice_no' => "#INV_".$invoice_display_no,
                    'account_name' => isset($departmentSettingsData[0]['account_name']) ? $departmentSettingsData[0]['account_name'] : null,
                    'account_no' => isset($departmentSettingsData[0]['account_no']) ? $departmentSettingsData[0]['account_no'] : null,
                    'account_email' => isset($departmentSettingsData[0]['account_email']) ? $departmentSettingsData[0]['account_email'] : null,
                    'bsb' => isset($departmentSettingsData[0]['bsb']) ? $departmentSettingsData[0]['bsb'] : null,
                    'terms' => isset($departmentSettingsData[0]['terms']) ? $departmentSettingsData[0]['terms'] : null,
                    'company_addr' => isset($departmentSettingsData[0]['company_addr']) ? $departmentSettingsData[0]['company_addr'] : null,
                    'company_name' => isset($departmentSettingsData[0]['company_name']) ? $departmentSettingsData[0]['company_name'] : null,
                    'abn' => isset($departmentSettingsData[0]['abn']) ? $departmentSettingsData[0]['abn'] : null,
                    'hospital_company_name' => isset($departmentSettingsData[0]['hospital_company_name']) ? $departmentSettingsData[0]['hospital_company_name'] : null,
                    'hospital_company_addr' => isset($departmentSettingsData[0]['hospital_company_addr']) ? $departmentSettingsData[0]['hospital_company_addr'] : null,
                    'hospital_email' => isset($departmentSettingsData[0]['hospital_email']) ? $departmentSettingsData[0]['hospital_email'] : null,
                    'hospital_phone' => isset($departmentSettingsData[0]['hospital_phone']) ? $departmentSettingsData[0]['hospital_phone'] : null,
                    'hospital_abn' => isset($departmentSettingsData[0]['hospital_abn']) ? $departmentSettingsData[0]['hospital_abn'] : null,
                    'date' => date('d-m-Y',strtotime($orderDate)),
                    
                    // UPDATED: Pass billing data from settings
                    'actualSuitesServiced' => $actualSuitesServiced,
                    'billableSuites' => $billablesuites,
                    'dailyCost' => $dailyCost,
                    'minimumLimit' => $minimumLimit,
                    'floorsServiced' => isset($invoiceOrderData[0]['floors_serviced']) ? $invoiceOrderData[0]['floors_serviced'] : 'ALL',
                    
                    'invoiceData' => $invoiceOrderData,
                    'departmentSettingsData' => $departmentSettingsData,
                ];
                
                $html = $this->load->view('Invoice/invoice', $data, TRUE);
                $mpdf->WriteHTML($html);
                
                // Save PDF to temporary file for email attachment
                $temp_folder = APPPATH . 'BULK INVOICES/';
                if (!is_dir($temp_folder)) {
                    mkdir($temp_folder, 0777, true);
                }
                $temp_file = $temp_folder . $invoice_no . '.pdf';
                $mpdf->Output($temp_file, 'F');
                
                // Create payment link (simplified - no encryption for now)
                $payment_link = base_url().'External/paymentLink/'.urlencode($invoice_no);
                
            } else {
                // Old bulk invoice system - use existing file
                $temp_folder = APPPATH . 'BULK INVOICES/';
                $temp_file = $temp_folder . $invoice_no . '.pdf';
                
                if (!file_exists($temp_file)) {
                    echo json_encode(['status' => 'error', 'message' => 'Invoice file not found']);
                    return;
                }
                
                $payment_link = base_url().'External/paymentLink/'.urlencode($invoice_no);
            }
            
            // Prepare email data
            $email_data['payment_link'] = $payment_link;
            $email_data['invoice_no'] = $invoice_no;
            
            $email_content = $this->load->view('Email/paymentLinkEmail', $email_data, TRUE);
            
            // Send email with PDF attachment
            $mailResult = $this->sendEmail($mailto, 'Invoice Payment Link', $email_content, 'info@bizadmin.com.au', '', 'Bizorder', $temp_file);
            
            if ($mailResult) {
                // Set rate limiting timestamp
                $this->session->set_userdata($rate_limit_key, time());
                echo json_encode(['status' => 'success', 'message' => 'Invoice sent successfully to ' . $mailto]);
            } else {
                echo json_encode(['status' => 'failed', 'message' => 'Unable to send invoice. Please check email configuration.']);
            }
            
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    function  markPayBulkInvoice(){
        // Clear any output buffers
        while (ob_get_level()) {
            ob_end_clean();
        }
        
        // Start fresh output buffer
        ob_start();
        
        // Set headers
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, must-revalidate');
        
        try {
            if (!$this->ion_auth->logged_in()) {
                $response = json_encode(['status' => 'error', 'message' => 'Authentication required']);
                ob_clean();
                echo $response;
                exit;
            }
            
            $invId = $this->input->post('invoice_id');
            
            // Validate invoice ID
            if (empty($invId)) {
                $response = json_encode(['status' => 'error', 'message' => 'Invoice ID is required']);
                ob_clean();
                echo $response;
                exit;
            }
            
            // Check if invoice exists
            $existingInvoice = $this->common_model->fetchRecordsDynamically('bulkInvoiceList', '', [
                'id' => $invId,
                'is_deleted' => 0
            ]);
            
            if (empty($existingInvoice)) {
                $response = json_encode(['status' => 'error', 'message' => 'Invoice not found']);
                ob_clean();
                echo $response;
                exit;
            }
            
            // Check if already paid
            if ($existingInvoice[0]['status'] == 1) {
                $response = json_encode(['status' => 'error', 'message' => 'Invoice is already marked as paid']);
                ob_clean();
                echo $response;
                exit;
            }
            
            // Update invoice status
            $data['status'] = 1;
            $updateResult = $this->common_model->commonRecordUpdate('bulkInvoiceList', 'id', $invId, $data);
            
            if ($updateResult) {
                $response = json_encode(['status' => 'success', 'message' => 'Invoice marked as paid successfully!']);
            } else {
                $response = json_encode(['status' => 'error', 'message' => 'Failed to update invoice status']);
            }
            
            // Clean output buffer and send response
            ob_clean();
            echo $response;
            exit;
            
        } catch (Exception $e) {
            log_message('error', "Error in markPayBulkInvoice: " . $e->getMessage());
            $response = json_encode(['status' => 'error', 'message' => 'An error occurred while updating the invoice']);
            ob_clean();
            echo $response;
            exit;
        }
    }
    
    function  cancelBulkInvoice(){
        // Clear any output buffers
        while (ob_get_level()) {
            ob_end_clean();
        }
        
        // Start fresh output buffer
        ob_start();
        
        // Set headers
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, must-revalidate');
        
        try {
            if (!$this->ion_auth->logged_in()) {
                $response = json_encode(['status' => 'error', 'message' => 'Authentication required']);
                ob_clean();
                echo $response;
                exit;
            }
            
            $invId = $this->input->post('invoice_id');
            
            // Validate invoice ID
            if (empty($invId)) {
                $response = json_encode(['status' => 'error', 'message' => 'Invoice ID is required']);
                ob_clean();
                echo $response;
                exit;
            }
            
            // Check if invoice exists
            $existingInvoice = $this->common_model->fetchRecordsDynamically('bulkInvoiceList', '', [
                'id' => $invId,
                'is_deleted' => 0
            ]);
            
            if (empty($existingInvoice)) {
                $response = json_encode(['status' => 'error', 'message' => 'Invoice not found']);
                ob_clean();
                echo $response;
                exit;
            }
            
            // Update invoice to cancelled/deleted
            $data['is_deleted'] = 1;
            $updateResult = $this->common_model->commonRecordUpdate('bulkInvoiceList', 'id', $invId, $data);
            
            if ($updateResult) {
                $response = json_encode(['status' => 'success', 'message' => 'Invoice cancelled successfully!']);
            } else {
                $response = json_encode(['status' => 'error', 'message' => 'Failed to cancel invoice']);
            }
            
            // Clean output buffer and send response
            ob_clean();
            echo $response;
            exit;
            
        } catch (Exception $e) {
            log_message('error', "Error in cancelBulkInvoice: " . $e->getMessage());
            $response = json_encode(['status' => 'error', 'message' => 'An error occurred while cancelling the invoice']);
            ob_clean();
            echo $response;
            exit;
        }
    }
    
    // Debug function to check authentication and database status
    function debugAuth() {
        // SECURITY: Only allow in development/testing environments
        if (ENVIRONMENT === 'production') {
            show_404();
            return;
        }
        $debug_info = [];
        
        // Check authentication
        $debug_info['is_logged_in'] = $this->ion_auth->logged_in();
        if ($this->ion_auth->logged_in()) {
            $user = $this->ion_auth->user()->row();
            $debug_info['user_email'] = $user->email;
            $debug_info['user_id'] = $user->id;
        }
        
        // Check session
        $debug_info['session_id'] = $this->session->session_id;
        $debug_info['session_data_count'] = count($this->session->all_userdata());
        
        // Check database connection
        try {
            $result = $this->common_model->fetchRecordsDynamically('bulkInvoiceList', '', ['is_deleted' => 0]);
            $debug_info['bulk_invoices_count'] = count($result);
            $debug_info['database_connection'] = 'OK';
        } catch (Exception $e) {
            $debug_info['database_error'] = $e->getMessage();
            $debug_info['database_connection'] = 'FAILED';
        }
        
        // Check SMTP settings
        try {
            $emailSettings = $this->general_model->fetchSmtpSettings('9999','9999');
            $debug_info['smtp_configured'] = !empty($emailSettings);
        } catch (Exception $e) {
            $debug_info['smtp_error'] = $e->getMessage();
        }
        
        echo json_encode($debug_info, JSON_PRETTY_PRINT);
    }
    
}

?>