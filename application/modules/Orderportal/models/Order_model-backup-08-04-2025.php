<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Order_model extends CI_Model{
	

	function __construct() {
		parent::__construct();
	}
	
	function fetchOrderForChef() {
	    
    $this->tenantDb->select('oc.order_id,oc.status, md.name,md.id as menu_id, oc.qty,fmc.name as category_name');
    $this->tenantDb->from('order_to_chef as oc');
    $this->tenantDb->join('menuDetails as md', 'md.id = oc.menu_id', 'LEFT');
    $this->tenantDb->join('foodmenuconfig as fmc', 'fmc.id = oc.category_id', 'LEFT');
    $this->tenantDb->where('oc.order_date', date('Y-m-d'));
    $this->tenantDb->where('fmc.listtype', 'category');
    
    return $this->tenantDb->get()->result_array();
   }
   
   function fetchOrderWithOrderNotes(){
       
   $this->tenantDb->select('order_id');
   $this->tenantDb->from('orders');
   $this->tenantDb->where('date', date('Y-m-d')); 
   $todaysOrder = $this->tenantDb->get()->result_array();

     $orderIds = array_column($todaysOrder, 'order_id');

    if (!empty($orderIds)) {
    $this->tenantDb->select('op.order_id, op.bed_id, op.order_comment,bd.bed_no,fmc.name as floor');
    $this->tenantDb->from('orders_to_patient as op');
    $this->tenantDb->join('beds as bd', 'bd.id = op.bed_id', 'LEFT');
    $this->tenantDb->join('foodmenuconfig as fmc', 'fmc.id = bd.floor', 'LEFT');
    $this->tenantDb->where('op.order_comment !=', ''); 
    $this->tenantDb->where_in('op.order_id', $orderIds); 
    $this->tenantDb->group_by('op.bed_id');

    return $this->tenantDb->get()->result_array();
     } else {
    return []; 
    }

   }
   
   
   function fetchOrderForNurse($id,$fechDetailsBasedOnOrderId=false) {
       
    $this->tenantDb->select('o.order_id,o.is_delivered, op.order_data,o.buttonType,op.order_comment,op.bed_id,b.notes as bedNote');
    $this->tenantDb->from('orders as o');
    $this->tenantDb->join('orders_to_patient as op', 'op.order_id = o.order_id', 'LEFT');
    $this->tenantDb->join('beds as  b', 'b.id = op.bed_id', 'LEFT');
    if($fechDetailsBasedOnOrderId){ 
        // here $id is order_id actually
     $this->tenantDb->where('o.order_id', $id);   
    }else{
    $this->tenantDb->where('o.date', date('Y-m-d'));  
    $this->tenantDb->where('o.dept_id', $id);
    }
    
    
    return $this->tenantDb->get()->result_array();
   }
   
   
   function orderList($groupByDate=false){
       
    $this->tenantDb->select('o.order_id,o.dept_id, fmc.name,o.date,o.status');
    $this->tenantDb->from('orders as o');
    $this->tenantDb->join('foodmenuconfig as fmc', 'fmc.id = o.dept_id', 'LEFT');
    if($groupByDate){
     $this->tenantDb->group_by('o.date');    
    }
    
    $this->tenantDb->order_by('o.date', 'DESC');
    return $this->tenantDb->get()->result_array();
   }
   
   
   function fetchOrderForInvoice($orderDate) {
       
    $this->tenantDb->select('o.dept_id AS floor_id, fmc.name AS floor_name, o.order_id, o.is_delivered, o.budget, o.limits, o.date, COUNT(DISTINCT op.bed_id) AS total_bed_serviced');
    $this->tenantDb->from('orders AS o');
    $this->tenantDb->join('orders_to_patient AS op', 'op.order_id = o.order_id', 'left');
    $this->tenantDb->join('foodmenuconfig AS fmc', 'fmc.id = o.dept_id', 'left');
    $this->tenantDb->where('o.date', $orderDate);  
    $this->tenantDb->group_by(['o.order_id', 'o.dept_id', 'fmc.name', 'o.is_delivered', 'o.budget', 'o.limits', 'o.date']);
    return $this->tenantDb->get()->result_array();

     
//   echo $lastQuery = $this->tenantDb->last_query(); exit;
   }
   
   function fetchmenuDetailsFromId($menuIds){
       $menuIds = array_values($menuIds);
       $this->tenantDb->select('name');
       $this->tenantDb->from('menuDetails');
       $this->tenantDb->where_in('id', $menuIds);
       $query = $this->tenantDb->get();
       return $result = $query->result_array();
       
   }
   
   function generateBulkInvoice($startDate,$endDate){
       
$this->tenantDb->select('o.date, COUNT(op.order_id) as totalPatients,o.limits,o.budget');
$this->tenantDb->from('orders as o');
$this->tenantDb->join('orders_to_patient as op', 'op.order_id = o.order_id', 'LEFT');
$this->tenantDb->where("o.date BETWEEN '$startDate' AND '$endDate'");
$this->tenantDb->group_by('o.date');
return $this->tenantDb->get()->result_array();


   
   

   }

	
}
?>