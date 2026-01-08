<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Order_model extends CI_Model{
	
	function __construct() {
		parent::__construct();
	
	}
	
	
	public function fetchRecordsDynamically($table, $fields = array(), $conditions = array()) {
        // Select fields
        if (!empty($fields)) {
            $this->tenantDb->select(implode(',', $fields));
        } else {
            $this->tenantDb->select('*');
        }

        // From table
        $this->tenantDb->from($table);

        // Where conditions
        if (!empty($conditions)) {
            $this->tenantDb->where($conditions);
        }

        // Execute the query
        $query = $this->tenantDb->get();
// echo $lastQuery = $this->tenantDb->last_query(); exit;
        // Return the result
        return ($query ? $query->result_array() : '');
    }
    
   
     // place order for force order after manager approval
	
	public function getOrders($orderId){
	  $this->tenantDb->distinct();
	  $this->tenantDb->select('o.id as orderId,spb.cafe_unit_uom,spb.each_unit_uom,spb.tier_type,o.supplierComments,o.supplier_id,o.location_name,o.delivery_date,o.delivery_info,o.order_comments,o.location_id,o.order_total,od.product_id,od.qty,od.product_unit_price,od.total as productTotal,sp.product_name,sp.product_code,SL.supplier_name');
      $this->tenantDb->from('SUPPLIERS_orders o');
      $this->tenantDb->join('SUPPLIERS_orderDetails od', 'o.id = od.order_id', 'left');
      $this->tenantDb->join('SUPPLIERS_products sp', 'od.product_id = sp.product_id', 'left');
      $this->tenantDb->join('SUPPLIERS_productToBuilto spb', 'spb.product_id = od.product_id', 'left');
    //   $this->tenantDb->join('SUPPLIERS_product_UOM spu', 'spb.each_unit_uom = spu.product_UOM_id', 'left');
    //   $this->tenantDb->join('SUPPLIERS_product_UOM spu', 'spb.cafe_unit_uom = spu.product_UOM_id AND spb.tier_type = "t3"', 'left');
    //   $this->tenantDb->join('SUPPLIERS_product_UOM spu', 'spb.each_unit_uom = spu.product_UOM_id AND spb.tier_type = "t1"', 'left');
      $this->tenantDb->join('SUPPLIERS_suppliersList SL', 'o.supplier_id = SL.supplier_id', 'left');
      $this->tenantDb->where('o.id', $orderId);
      $this->tenantDb->where_in('o.status', array(1, 2 , 3));

      $query = $this->tenantDb->get();
    //  echo $lastQuery = $this->tenantDb->last_query(); exit;
      return ($query ? $query->result_array() : ''); 

	}

	
	public function updateOrder($orderID,$updateData){
	     $this->tenantDb->where('id', $orderID);
         $this->tenantDb->update('SUPPLIERS_orders', $updateData);
       
	}
	
	public function updateStock($supplier_id){
	  
	     $this->tenantDb->where('supplier_id', $supplier_id);
         $this->tenantDb->set('cafe_unit_uomCount', 0);
         $this->tenantDb->set('inner_unit_uomCount', 0);
         $this->tenantDb->set('orderQty', 0);
          $this->tenantDb->set('totalStockCountTotalValue', 0);
         $this->tenantDb->update('SUPPLIERS_productToBuilto');
	}
	
	public function updateStockDetails($supplier_id){
	    
	     $this->tenantDb->where('supplier_id', $supplier_id);
         $this->tenantDb->set('area_count', 0);
         $this->tenantDb->update('SUPPLIERS_productToBuiltoToAreaQty');
	     return true;
	}
	
	 public function getSupplierConfiguration($configureFor,$locationId=''){
	     $conditions = array(
	         'location' => $locationId,
	         );
	        ($configureFor !='' ? $conditions['configureFor'] = $configureFor : '');
	      
		   $builder = $this->tenantDb;
	       $query = $builder->select('id,data,configureFor')
                     ->where($conditions)
                     ->get('SUPPLIERS_configuration');
                      if ($query === false) {
                         return  $resultData =  array();
                      } else {
                      $resultData = $query->result_array();
                      }
      
                     return $resultData;
		}	
		
	public function getSuppliers($id='',$columnsToFetch,$location_id=''){
        if($columnsToFetch==''){
           $cols = '*'; 
        }else{
            $cols = $columnsToFetch;
        }
	   $query = "SELECT ".$cols." FROM `SUPPLIERS_suppliersList` WHERE status != 0 and is_deleted = 0 and location_id=".$location_id;
	 
      
	  if($id !=''){
	    $query .= " AND supplier_id = ".$id;
	  }
	 
        $query=$this->tenantDb->query($query);
              
     return ($query ? $query->result_array() : '');
       
        
	}	
	
	public function orderCommonUpdate($id,$data){
   $this->tenantDb->where('id', $id);
   $this->tenantDb->update('SUPPLIERS_orders', $data);   
	}
	
	public function getConfiguration($configureFor,$selected_location_id){
	     $conditions = array(
	         'location' => $selected_location_id,
	         );
	        ($configureFor !='' ? $conditions['configureFor'] = $configureFor : '');
	       // ($metaData !='' ? $conditions['metaData'] = $metaData : '');
	       //(isset($metaData) && $metaData !='' ? $conditions['metaData'] = $metaData : '');
		   $builder = $this->tenantDb;
	       $query = $builder->select('id,data,configureFor')
                     ->where($conditions)
                     ->get('SUPPLIERS_configuration');
                      if ($query === false) {
                         return  $resultData =  array();
                       } else {
                       $resultData = $query->result_array();
                       }
    //   echo $lastQuery = $this->tenantDb->last_query(); exit;
                     return $resultData;
		}
		
			
		
    public function supplierCommonUPdate($id,$data){
	$this->tenantDb->where('supplier_id', $id);
   $this->tenantDb->update('SUPPLIERS_suppliersList', $data);   
	}
	
	function resetStockCount($supplierId){
	    $this->tenantDb->where('supplier_id', $supplierId);
        $this->tenantDb->delete('SUPPLIERS_productToBuiltoToAreaQty');
        
        $this->tenantDb->where('supplier_id', $supplierId);
         $this->tenantDb->set('orderQty', 0);
         $this->tenantDb->set('totalStockCountTotalValue', 0);
         $this->tenantDb->update('SUPPLIERS_productToBuilto');
	    return true;
	}
	
	}
	?>