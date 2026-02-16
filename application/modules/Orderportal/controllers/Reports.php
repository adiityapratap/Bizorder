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
                AND (opo.is_cancelled = 0 OR opo.is_cancelled IS NULL)
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
                AND (opo.is_cancelled = 0 OR opo.is_cancelled IS NULL)
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
                    COUNT(CASE WHEN (opo.is_cancelled = 0 OR opo.is_cancelled IS NULL) THEN opo.id ELSE NULL END) as item_count,
                    COUNT(CASE WHEN opo.is_cancelled = 1 THEN opo.id ELSE NULL END) as cancelled_item_count,
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
        // ✅ SOFT DELETE: Exclude cancelled items but show them separately
        $sql = "SELECT opo.*,
                       s.bed_no,
                       s.floor,
                       s.id as suite_id,
                       p.name as patient_name,
                       p.allergies as patient_allergies,
                       md.name as menu_name,
                       md.description as menu_description,
                       fc.name as category_name
                FROM orders_to_patient_options opo
                LEFT JOIN suites s ON s.id = opo.bed_id
                LEFT JOIN people p ON p.id = opo.patient_id
                LEFT JOIN menuDetails md ON md.id = opo.menu_id
                LEFT JOIN foodmenuconfig fc ON fc.id = opo.category_id AND fc.listtype = 'category'
                WHERE opo.order_id = ?
                AND (opo.is_cancelled = 0 OR opo.is_cancelled IS NULL)
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
     * Export Patient Report to Excel
     */
    public function exportPatientReport() {
        $from_date = $this->input->post('from_date') ?: date('Y-m-d', strtotime('-7 days'));
        $to_date = $this->input->post('to_date') ?: date('Y-m-d');
        
        // Get patient data with onboarding and discharge dates
        // Note: People table has suite_number and floor_number to link with suites
        $sql = "SELECT 
                p.id as patient_id,
                p.name as patient_name,
                p.suite_number,
                p.floor_number,
                p.allergies,
                p.dietary_preferences,
                p.special_instructions,
                p.date_onboarded as onboarded_date,
                p.date_of_discharge as discharge_date,
                p.status as patient_status,
                s.id as suite_id,
                s.bed_no as suite_number,
                s.status as suite_status,
                f.name as floor_name
            FROM people p
            LEFT JOIN suites s ON s.id = p.suite_number AND s.floor = p.floor_number AND s.is_deleted = 0
            LEFT JOIN foodmenuconfig f ON f.id = p.floor_number AND f.listtype = 'floor' AND f.is_deleted = 0
            WHERE p.id IS NOT NULL
            AND (
                (p.date_onboarded >= ? AND p.date_onboarded <= ?)
                OR (p.date_of_discharge >= ? AND p.date_of_discharge <= ?)
                OR (p.date_onboarded <= ? AND (p.date_of_discharge >= ? OR p.date_of_discharge IS NULL))
            )
            ORDER BY p.date_onboarded DESC, p.suite_number ASC";
        
        $query = $this->tenantDb->query($sql, [
            $from_date, $to_date,
            $from_date, $to_date,
            $from_date, $to_date
        ]);
        $patients = $query->result_array();
        
        // Prepare CSV data
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="patient_report_' . date('Y-m-d_His') . '.csv"');
        
        $output = fopen('php://output', 'w');
        
        // CSV Title
        fputcsv($output, ['Patient Report']);
        fputcsv($output, ['Date Range: ' . date('d M Y', strtotime($from_date)) . ' to ' . date('d M Y', strtotime($to_date))]);
        fputcsv($output, []); // Empty row
        
        // CSV Headers
        fputcsv($output, [
            'Suite Number',
            'Floor',
            'Patient Name',
            'Date Onboarded',
            'Date Discharged',
            'Status',
           
        ]);
        
        // CSV Data
        $total_active = 0;
        $total_discharged = 0;
        
        foreach ($patients as $patient) {
            $status = 'Unknown';
            if ($patient['patient_status'] == 1 || $patient['patient_status'] === '1') {
                $status = $patient['discharge_date'] ? 'Discharged' : 'Active';
                if ($status == 'Active') $total_active++;
                if ($status == 'Discharged') $total_discharged++;
            } else {
                $status = 'Inactive';
            }
            
            fputcsv($output, [
                $patient['suite_number'] ?: 'N/A',
                $patient['floor_name'] ?: 'N/A',
                $patient['patient_name'] ?: 'No Patient Assigned',
                $patient['onboarded_date'] ? date('d M Y', strtotime($patient['onboarded_date'])) : 'N/A',
                $patient['discharge_date'] ? date('d M Y', strtotime($patient['discharge_date'])) : 'N/A',
                $status,
               
            ]);
        }
        
        // Add summary
        fputcsv($output, []); // Empty row
        fputcsv($output, ['Summary']);
        fputcsv($output, ['Total Patients', count($patients)]);
        fputcsv($output, ['Active Patients', $total_active]);
        fputcsv($output, ['Discharged Patients', $total_discharged]);
        
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
    
    /**
     * Cancelled Orders Report - View all orders cancelled due to patient discharge
     * Shows audit trail of cancelled order items with patient/suite snapshots
     */
    public function cancelledOrders() {
        // Get date range from request or default to last 30 days
        $from_date = $this->input->get('from_date') ?: date('Y-m-d', strtotime('-30 days'));
        $to_date = $this->input->get('to_date') ?: date('Y-m-d');
        $reason_filter = $this->input->get('reason') ?: '';
        
        // Fetch cancelled order items
        $data['cancelled_items'] = $this->getCancelledOrderItems($from_date, $to_date, $reason_filter);
        
        // Get summary stats
        $data['summary'] = $this->getCancelledOrdersSummary($from_date, $to_date);
        
        // Get unique cancel reasons for filter dropdown
        $data['cancel_reasons'] = $this->getUniqueCancelReasons();
        
        // Pass filter values to view
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['reason_filter'] = $reason_filter;
        
        // Page title
        $data['page_title'] = 'Cancelled Orders Report';
        
        // Load views
        $this->load->view('general/header', $data);
        $this->load->view('Orderportal/Reports/cancelled_orders', $data);
        $this->load->view('general/footer', $data);
    }
    
    /**
     * Get cancelled order items with full details
     */
    private function getCancelledOrderItems($from_date, $to_date, $reason_filter = '') {
        $sql = "SELECT 
                    opo.id,
                    opo.order_id,
                    opo.bed_id,
                    opo.patient_id,
                    opo.menu_id,
                    opo.category_id,
                    opo.option_id,
                    opo.quantity,
                    opo.is_cancelled,
                    opo.cancel_reason,
                    opo.cancelled_at,
                    opo.cancelled_by,
                    opo.patient_name_snapshot,
                    opo.suite_name_snapshot,
                    o.date as order_date,
                    s.bed_no as suite_number,
                    fmc.name as floor_name,
                    fc.name as category_name,
                    md.name as menu_name,
                    mo.menu_option_name,
                    CONCAT(u.first_name, ' ', u.last_name) as cancelled_by_name
                FROM orders_to_patient_options opo
                LEFT JOIN orders o ON o.order_id = opo.order_id
                LEFT JOIN suites s ON s.id = opo.bed_id
                LEFT JOIN foodmenuconfig fmc ON fmc.id = s.floor
                LEFT JOIN foodmenuconfig fc ON fc.id = opo.category_id AND fc.listtype = 'category'
                LEFT JOIN menuDetails md ON md.id = opo.menu_id
                LEFT JOIN menu_options mo ON mo.id = opo.option_id
                LEFT JOIN Global_users u ON u.id = opo.cancelled_by
                WHERE opo.is_cancelled = 1
                AND opo.cancelled_at >= ?
                AND opo.cancelled_at <= ?";
        
        $params = [$from_date . ' 00:00:00', $to_date . ' 23:59:59'];
        
        if (!empty($reason_filter)) {
            $sql .= " AND opo.cancel_reason LIKE ?";
            $params[] = '%' . $reason_filter . '%';
        }
        
        $sql .= " ORDER BY opo.cancelled_at DESC, opo.order_id, opo.id";
        
        $query = $this->tenantDb->query($sql, $params);
        return $query->result_array();
    }
    
    /**
     * Get summary statistics for cancelled orders
     */
    private function getCancelledOrdersSummary($from_date, $to_date) {
        $sql = "SELECT 
                    COUNT(*) as total_cancelled_items,
                    COUNT(DISTINCT opo.order_id) as affected_orders,
                    COUNT(DISTINCT opo.bed_id) as affected_suites,
                    COUNT(DISTINCT opo.patient_id) as affected_patients,
                    SUM(opo.quantity) as total_quantity_cancelled
                FROM orders_to_patient_options opo
                WHERE opo.is_cancelled = 1
                AND opo.cancelled_at >= ?
                AND opo.cancelled_at <= ?";
        
        $query = $this->tenantDb->query($sql, [$from_date . ' 00:00:00', $to_date . ' 23:59:59']);
        return $query->row_array();
    }
    
    /**
     * Get unique cancel reasons for filter dropdown
     */
    private function getUniqueCancelReasons() {
        $sql = "SELECT DISTINCT cancel_reason 
                FROM orders_to_patient_options 
                WHERE is_cancelled = 1 
                AND cancel_reason IS NOT NULL 
                AND cancel_reason != ''
                ORDER BY cancel_reason";
        
        $query = $this->tenantDb->query($sql);
        return array_column($query->result_array(), 'cancel_reason');
    }
    
    /**
     * Export cancelled orders to CSV
     */
    public function exportCancelledOrders() {
        $from_date = $this->input->post('from_date') ?: date('Y-m-d', strtotime('-30 days'));
        $to_date = $this->input->post('to_date') ?: date('Y-m-d');
        $reason_filter = $this->input->post('reason') ?: '';
        
        $cancelled_items = $this->getCancelledOrderItems($from_date, $to_date, $reason_filter);
        
        // Prepare CSV data
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="cancelled_orders_report_' . date('Y-m-d_His') . '.csv"');
        
        $output = fopen('php://output', 'w');
        
        // CSV Title
        fputcsv($output, ['Cancelled Orders Report']);
        fputcsv($output, ['Date Range: ' . date('d M Y', strtotime($from_date)) . ' to ' . date('d M Y', strtotime($to_date))]);
        fputcsv($output, ['Generated: ' . date('d M Y H:i:s')]);
        fputcsv($output, []); // Empty row
        
        // CSV Headers
        fputcsv($output, [
            'Cancelled Date',
            'Order ID',
            'Order Date',
            'Suite/Bed',
            'Floor',
            'Patient Name (at cancellation)',
            'Category',
            'Menu Item',
            'Option',
            'Quantity',
            'Cancel Reason',
            'Cancelled By'
        ]);
        
        // CSV Data
        foreach ($cancelled_items as $item) {
            fputcsv($output, [
                $item['cancelled_at'] ? date('d M Y H:i', strtotime($item['cancelled_at'])) : 'N/A',
                $item['order_id'],
                $item['order_date'] ? date('d M Y', strtotime($item['order_date'])) : 'N/A',
                $item['suite_name_snapshot'] ?: $item['suite_number'] ?: 'N/A',
                $item['floor_name'] ?: 'N/A',
                $item['patient_name_snapshot'] ?: 'N/A',
                $item['category_name'] ?: 'N/A',
                $item['menu_name'] ?: 'N/A',
                $item['menu_option_name'] ?: 'N/A',
                $item['quantity'],
                $item['cancel_reason'] ?: 'N/A',
                $item['cancelled_by_name'] ?: 'System'
            ]);
        }
        
        fclose($output);
        exit;
    }
    
