<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('common_model');
        // Check if user is logged in
        !$this->ion_auth->logged_in() ? redirect('auth/login', 'refresh') : '';
    }
    
    /**
     * Main reports index page
     * Shows order reports with filters
     */
    public function index()
{
    $data = [];

    $data['page_title'] = 'Order Reports';
    $data['pagefor']    = 'reports';

   
    $from_date = $this->input->post('from_date');
    $to_date   = $this->input->post('to_date');

    // Validate & set default dates (last 7 days)
    if (!isset($from_date) || empty($from_date)) {
        $from_date = date('Y-m-d', strtotime('-7 days'));
    }

    if (!isset($to_date) || empty($to_date)) {
        $to_date = date('Y-m-d');
    }

    $data['from_date'] = $from_date;
    $data['to_date']   = $to_date;

   
    $orders = $this->getOrdersReport($from_date, $to_date);
    $data['orders'] = (isset($orders) && is_array($orders)) ? $orders : [];

    
    $data['total_orders'] = count($data['orders']);
    $data['total_items']  = 0;

    if (!empty($data['orders'])) {
        foreach ($data['orders'] as $order) {
            if (isset($order['item_count'])) {
                $data['total_items'] += (int) $order['item_count'];
            }
        }
    }

    // Beds serviced per day
    $beds_per_day = $this->getBedsServicedPerDay($from_date, $to_date);
    $data['beds_per_day'] = (isset($beds_per_day) && is_array($beds_per_day)) ? $beds_per_day : [];

    // Total beds serviced in month
    $total_beds_month = $this->getTotalBedsServicedInMonth($from_date, $to_date);
    $data['total_beds_month'] = isset($total_beds_month) ? (int) $total_beds_month : 0;

   
    $this->load->view('general/header', $data);
    $this->load->view('Orderportal/Reports/index', $data);
    $this->load->view('general/footer', $data);
}

    
    /**
     * Get beds/suites serviced per day
     */
    private function getBedsServicedPerDay($from_date, $to_date) {
        $sql = "SELECT 
                    o.date as order_date,
                    COUNT(DISTINCT opo.bed_id) as beds_count
                FROM orders o
                INNER JOIN orders_to_patient_options opo ON opo.order_id = o.order_id
                INNER JOIN suites s ON s.id = opo.bed_id
                WHERE o.date >= ? AND o.date <= ?
                AND o.status != 0
                AND s.is_deleted = 0
                AND s.status = 1
                GROUP BY o.date
                ORDER BY o.date ASC";
        
        $query = $this->tenantDb->query($sql, [$from_date, $to_date]);
        return $query->result_array();
    }
    
    /**
     * Get total beds serviced in a month
     * Sums all beds from each day in the current month (month of to_date)
     */
    private function getTotalBedsServicedInMonth($from_date, $to_date) {
        // Get the current month (month of to_date)
        $month_start = date('Y-m-01', strtotime($to_date));
        $month_end = date('Y-m-t', strtotime($to_date));
        
        // Get beds per day for the current month
        $sql = "SELECT 
                    o.date as order_date,
                    COUNT(DISTINCT opo.bed_id) as beds_count
                FROM orders o
                INNER JOIN orders_to_patient_options opo ON opo.order_id = o.order_id
                INNER JOIN suites s ON s.id = opo.bed_id
                WHERE o.date >= ? AND o.date <= ?
                AND o.status != 0
                AND s.is_deleted = 0
                AND s.status = 1
                GROUP BY o.date
                ORDER BY o.date ASC";
        
        $query = $this->tenantDb->query($sql, [$month_start, $month_end]);
        $beds_per_day = $query->result_array();
        
        // Sum all beds from each day
        $total = 0;
        foreach ($beds_per_day as $day) {
            $total += (int)$day['beds_count'];
        }
        
        return $total;
    }
    
    /**
     * Get orders report data
     */
    private function getOrdersReport($from_date, $to_date) {
        $sql = "SELECT 
                    o.order_id,
                    o.date as order_date,
                    o.buttonType,
                    o.status,
                    o.workflow_status,
                    o.is_floor_consolidated,
                    o.date as created_at,
                    COUNT(opo.id) as item_count,
                    CONCAT(u.first_name, ' ', u.last_name) as created_by_name,
                    u.username as created_by_username
                FROM orders o
                LEFT JOIN orders_to_patient_options opo ON opo.order_id = o.order_id
                LEFT JOIN Global_users u ON u.id = o.added_by
                WHERE o.date >= ? AND o.date <= ?
                GROUP BY o.order_id
                ORDER BY o.order_id DESC";
        
        $query = $this->tenantDb->query($sql, [$from_date, $to_date]);
        return $query->result_array();
    }
    
    /**
     * Order detail report
     */
    public function orderDetail($order_id) {
        $data['page_title'] = 'Order Detail Report';
        $data['pagefor'] = 'reports';
        
        // Get order details with creator information
        $sql = "SELECT o.*, 
                       CONCAT(u.first_name, ' ', u.last_name) as created_by_name,
                       u.username as created_by_username
                FROM orders o
                LEFT JOIN Global_users u ON u.id = o.added_by
                WHERE o.order_id = ?";
        
        $query = $this->tenantDb->query($sql, [$order_id]);
        $order = $query->row_array();
        
        if (empty($order)) {
            show_404();
            return;
        }
        
        $data['order'] = $order;
        
        // Get order items with suite/bed and menu information
        // ✅ PATIENT ID FIX: JOIN on patient_id to get correct patient at order time
        $sql = "SELECT opo.*,
                       s.bed_no,
                       s.floor,
                       s.id as suite_id,
                       p.name as patient_name,
                       p.allergies as patient_allergies,
                       md.name as menu_name,
                       md.description as menu_description
                FROM orders_to_patient_options opo
                LEFT JOIN suites s ON s.id = opo.bed_id
                LEFT JOIN people p ON p.id = opo.patient_id
                LEFT JOIN menuDetails md ON md.id = opo.menu_id
                WHERE opo.order_id = ?
                ORDER BY s.floor, s.bed_no, opo.id";
        
        $query = $this->tenantDb->query($sql, [$order_id]);
        $data['order_items'] = $query->result_array();
        
        // Load views
        $this->load->view('general/header', $data);
        $this->load->view('Orderportal/Reports/order_detail', $data);
        $this->load->view('general/footer', $data);
    }
    
    /**
     * Export orders to Excel
     */
    public function exportOrders() {
        $from_date = $this->input->post('from_date') ?: date('Y-m-d', strtotime('-7 days'));
        $to_date = $this->input->post('to_date') ?: date('Y-m-d');
        
        $orders = $this->getOrdersReport($from_date, $to_date);
        
        // Prepare CSV data
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="order_report_' . date('Y-m-d_His') . '.csv"');
        
        $output = fopen('php://output', 'w');
        
        // CSV Headers
        fputcsv($output, [
            'Order ID',
            'Order Date',
            'Status',
            'Workflow Status',
            'Type',
            'Item Count',
            'Created By',
            'Created At'
        ]);
        
        // CSV Data
        foreach ($orders as $order) {
            fputcsv($output, [
                $order['order_id'],
                $order['order_date'],
                $order['status'],
                $order['workflow_status'] ?: 'N/A',
                $order['is_floor_consolidated'] == 1 ? 'Floor Consolidated' : 'Legacy',
                $order['item_count'],
                $order['created_by_name'] ?: $order['created_by_username'],
                $order['created_at']
            ]);
        }
        
        fclose($output);
        exit;
    }
    
    /**
     * Export beds serviced per day to Excel
     */
    public function exportBedsServiced() {
        $from_date = $this->input->post('from_date') ?: date('Y-m-d', strtotime('-7 days'));
        $to_date = $this->input->post('to_date') ?: date('Y-m-d');
        
        $beds_per_day = $this->getBedsServicedPerDay($from_date, $to_date);
        
        // Prepare CSV data
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="beds_serviced_report_' . date('Y-m-d_His') . '.csv"');
        
        $output = fopen('php://output', 'w');
        
        // CSV Title
        fputcsv($output, ['Beds (Suites) Serviced Per Day Report']);
        fputcsv($output, ['Date Range: ' . date('d M Y', strtotime($from_date)) . ' to ' . date('d M Y', strtotime($to_date))]);
        fputcsv($output, []); // Empty row
        
        // CSV Headers
        fputcsv($output, [
            'Date',
            'Day of Week',
            'Beds Serviced'
        ]);
        
        // CSV Data
        $total_beds = 0;
        foreach ($beds_per_day as $day) {
            $total_beds += $day['beds_count'];
            fputcsv($output, [
                date('d M Y', strtotime($day['order_date'])),
                date('l', strtotime($day['order_date'])),
                $day['beds_count']
            ]);
        }
        
        // Add summary
        fputcsv($output, []); // Empty row
        fputcsv($output, ['Total Days', count($beds_per_day)]);
        fputcsv($output, ['Total Beds Serviced', $total_beds]);
        fputcsv($output, ['Average Beds Per Day', count($beds_per_day) > 0 ? round($total_beds / count($beds_per_day), 2) : 0]);
        
        fclose($output);
        exit;
    }
    
    /**
     * List all order snapshots
     * Shows comprehensive view of all historical snapshots
     */
    public function snapshots() {
        try {
            $data['page_title'] = 'Order Snapshots - Historical Records';
            $data['pagefor'] = 'reports';
            
            // Load snapshot model
            $this->load->model('Snapshot_model');
            
            // Get filters
            $fromDate = $this->input->get('from_date') ?: date('Y-m-d', strtotime('-30 days'));
            $toDate = $this->input->get('to_date') ?: date('Y-m-d');
            $floorId = $this->input->get('floor_id') ?: null;
            
            // Get all snapshots with filters
            $snapshots = $this->Snapshot_model->getAllSnapshots($fromDate, $toDate, $floorId);
            $data['snapshots'] = is_array($snapshots) ? $snapshots : [];
            $data['from_date'] = $fromDate;
            $data['to_date'] = $toDate;
            $data['floor_id'] = $floorId;
            
            // Get floors for filter dropdown
            $floors = $this->common_model->fetchRecordsDynamically('foodmenuconfig', '*', [
                'listtype' => 'floor',
                'is_deleted' => '0'
            ]);
            $data['floors'] = is_array($floors) ? $floors : [];
            
            // Calculate statistics - safe array handling
            $data['total_snapshots'] = count($data['snapshots']);
            $data['total_orders'] = 0;
            if (!empty($data['snapshots']) && is_array($data['snapshots'])) {
                $orderIds = array_column($data['snapshots'], 'order_id');
                $data['total_orders'] = count(array_unique($orderIds));
            }
            
            // Load views
            $this->load->view('general/header', $data);
            $this->load->view('Reports/snapshots_list', $data);
            $this->load->view('general/footer', $data);
            
        } catch (Exception $e) {
            log_message('error', 'Snapshots page error: ' . $e->getMessage());
            show_error('Unable to load snapshots page. Please check if all required tables exist. Error: ' . $e->getMessage(), 500);
        }
    }
    
    /**
     * View historical order snapshot (immutable data)
     * 
     * @param int $snapshotId The order_snapshots.id
     */
    public function viewOrderSnapshot($snapshotId) {
        $data['page_title'] = 'Order Snapshot - Historical View';
        $data['pagefor'] = 'reports';
        
        // Load snapshot model
        $this->load->model('Snapshot_model');
        
        // Get complete snapshot
        $data['snapshot'] = $this->Snapshot_model->getOrderSnapshot($snapshotId);
        
        if (empty($data['snapshot'])) {
            $this->session->set_flashdata('error', 'Snapshot not found.');
            redirect('Orderportal/Reports');
            return;
        }
        
        // ✅ Fetch allergen names for converting IDs to names
        $conditionsAllergen = ['listtype' => 'allergen', 'is_deleted' => 0];
        $allergensData = $this->common_model->fetchRecordsDynamically('foodmenuconfig', ['id', 'name'], $conditionsAllergen);
        
        // Create allergen ID to name mapping
        $allergenMap = [];
        if (!empty($allergensData)) {
            foreach ($allergensData as $allergen) {
                $allergenMap[$allergen['id']] = $allergen['name'];
            }
        }
        $data['allergenMap'] = $allergenMap;
        
        // Load views
        $this->load->view('general/header', $data);
        $this->load->view('Reports/order_snapshot_view', $data);
        $this->load->view('general/footer', $data);
    }
    
    /**
     * View snapshot by original order ID
     * 
     * @param int $orderId The orders.order_id
     */
    public function viewOrderSnapshotByOrderId($orderId) {
        // Load snapshot model
        $this->load->model('Snapshot_model');
        
        // Get snapshot by order ID
        $snapshot = $this->Snapshot_model->getOrderSnapshotByOrderId($orderId);
        
        if (empty($snapshot)) {
            $this->session->set_flashdata('error', 'No snapshot found for this order. It may have been created before the snapshot system was implemented.');
            redirect('Orderportal/Reports');
            return;
        }
        
        // Redirect to the snapshot view
        redirect('Orderportal/Reports/viewOrderSnapshot/' . $snapshot['id']);
    }
    
}

