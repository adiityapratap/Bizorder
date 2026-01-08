<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class General_model extends CI_Model{
	
	function __construct() {
		parent::__construct();
	}
	public function validateLogin($username,$password)
	{
		$query=$this->db->query("SELECT * FROM user WHERE username = '" . $username . "' AND password='".sha1($password)."' AND auth_level != 3");
		$res=$query->result();
		return $res;
	}
	public function map_companies()
	{
		$query=$this->db->query("SELECT * FROM oc_companies");
		{
			$company_name=$this->db->escape($row->company_name);
			$abn=trim($row->abn)==''?"NULL":$this->db->escape($row->abn);
			$address=$this->db->escape($row->address);
			$this->db->query("INSERT INTO company VALUES (".$row->company_id.",".$company_name.",".$abn.",".$address.",".$row->status.",NOW())");
		}
	}
	public function map_departments()
	{
		$query=$this->db->query("SELECT * FROM oc_departments");
		foreach($query->result() as $row)
		{
			$dept_name=$this->db->escape($row->dept_name);
			$this->db->query("INSERT INTO department VALUES (".$row->dept_id.",".$row->company_id.",".$dept_name.",".$row->status.")");
		}
	}
	
	public function fetch_cust($cust_id){
	    
	    $query=$this->db->query("SELECT company_id FROM customer where customer_id =".$cust_id);
	    $res=$query->result();
	   
		return	$res=$res[0]->company_id;
	}
	public function map_customer()
	{
		$query=$this->db->query("SELECT * FROM oc_customer");
		foreach($query->result() as $row)
		{
			//id, firstname,lastname,email,phone,fax,date_added,company_id,department_id,customer_address,status
			$firstname=$this->db->escape($row->firstname);
			$lastname=$this->db->escape($row->lastname);
			$email=trim($row->email)==''?"NULL":$this->db->escape($row->email);
			$phone=trim($row->telephone)==''?"NULL":$this->db->escape($row->telephone);
			$fax=trim($row->fax)==''?"NULL":$this->db->escape($row->fax);
			$customer_address=trim($row->address)==''?"NULL":$this->db->escape($row->address);
			$cost_centre=empty($row->cost_center)?"NULL":$this->db->escape($row->cost_center);
			$this->db->query("INSERT INTO customer VALUES (".$row->customer_id.",".$firstname.",".$lastname.",".$email.",".$phone.",".$fax.",'".$row->date_added."',".$row->company_name.",".$row->department.",".$customer_address.",".$cost_centre.",".$row->status.")");
		}
	}
	public function map_product()
	{
		$query=$this->db->query("SELECT * FROM oc_product p JOIN oc_product_description pd ON p.product_id=pd.product_id");
		//product_id	product_name	product_description	product_tag	product_meta_keyword	product_desc_1	product_desc_2	product_desc_3	product_desc_4	product_desc_5	product_image	product_price	product_date_available	product_minimum	product_status	product_date_added	product_date_modified
		foreach($query->result() as $row)
		{
			$name=$this->db->escape($row->name);
			$desc=trim($row->description)==''?"NULL":$this->db->escape($row->description);
			$tag=trim($row->tag)==''?"NULL":$this->db->escape($row->tag);
			$meta=trim($row->meta_keyword)==''?"NULL":$this->db->escape($row->meta_keyword);
			$desc_1=trim($row->desc_1)==''?"NULL":$this->db->escape($row->desc_1);
			$desc_2=trim($row->desc_2)==''?"NULL":$this->db->escape($row->desc_2);
			$desc_3=trim($row->desc_3)==''?"NULL":$this->db->escape($row->desc_3);
			$desc_4=trim($row->desc_4)==''?"NULL":$this->db->escape($row->desc_4);
			$desc_5=trim($row->desc_5)==''?"NULL":$this->db->escape($row->desc_5);
			$image=trim($row->image)==''?"NULL":$row->image;
			$this->db->query("INSERT INTO product VALUES (".$row->product_id.",".$name.",".$desc.",".$tag.",".$meta.",".$desc_1.",".$desc_2.",".$desc_3.",".$desc_4.",".$desc_5.",'".$image."',".$row->price.",'".date("Y-m-d H:i:s",strtotime($row->date_available))."',".$row->minimum.",".$row->status.",'".$row->date_added."','".$row->date_modified."')");
		}
	}
	public function map_category()
	{
		$query=$this->db->query("SELECT * FROM oc_category_description cd JOIN oc_category c ON cd.category_id=c.category_id");
		foreach($query->result() as $row)
		{
			$name=$this->db->escape($row->name);
			$parent=$row->parent_id==0?"NULL":$row->parent_id;
			$this->db->query("INSERT INTO category VALUES (".$row->category_id.",".$parent.",".$name.")");
		}
	}
	public function map_product_category()
	{
		$query=$this->db->query("SELECT * FROM oc_product_to_category");
		foreach($query->result() as $row)
		{
			$this->db->query("INSERT INTO product_category VALUES (".$row->product_id.",".$row->category_id.")");
		}
	}
	public function map_option()
	{
		$query=$this->db->query("SELECT * FROM oc_option_description");
		foreach($query->result() as $row)
		{
			$name=$this->db->escape($row->name);
			$this->db->query("INSERT INTO options VALUES (".$row->option_id.",".$name.")");
		}
	}
	public function map_option_value()
	{
		$query=$this->db->query("SELECT * FROM oc_option_value_description ovd JOIN oc_option_value ov ON ovd.option_value_id=ov.option_value_id");
		foreach($query->result() as $row)
		{
			$name=$this->db->escape($row->name);
			$this->db->query("INSERT INTO option_value VALUES (".$row->option_value_id.",".$row->option_id.",".$name.",".$row->sort_order.")");
		}
	}
	public function map_coupon()
	{
		$query=$this->db->query("SELECT * FROM oc_coupon");
		foreach($query->result() as $row)
		{
			$name=$this->db->escape($row->name);
			$code=$this->db->escape($row->code);
			$this->db->query("INSERT INTO coupon VALUES (".$row->coupon_id.",".$code.",".$name.",".$row->discount.",'".$row->type."',".$row->status.")");
		}
	}
	public function map_product_option()
	{
		$query=$this->db->query("SELECT * FROM oc_product_option_value pov JOIN oc_product_option po ON po.product_option_id=pov.product_option_id");
		foreach($query->result() as $row)
		{
			$this->db->query("INSERT INTO product_option VALUES (".$row->product_option_value_id.",".$row->product_id.",".$row->option_value_id.",".$row->required.",".$row->price.",'".$row->price_prefix."')");
		}
	}
	public function map_order()
	{
		$query=$this->db->query("SELECT * FROM oc_order ord JOIN oc_customer cust ON (ord.firstname=cust.firstname AND ord.lastname=cust.lastname)");
//		echo "<pre>".print_r($query->result(),1);exit;
		foreach($query->result() as $row)
		{
			//	order_id	customer_id	shipping_method	pickup_delivery_notes	order_total	order_status	date_added	date_modified	delivery_date_time	selected_location	standing_order	cost_centre	order_comments	coupon_id
			$shipping=$row->shipping_method=="Delivery"?1:2;
			$comment=trim($row->comment)==''?"NULL":$this->db->escape($row->comment);
			$cost_centre=trim($row->cost_center)==''?"NULL":$this->db->escape($row->cost_center);
			$order_comment=trim($row->order_comments)==''?"NULL":$this->db->escape($row->order_comments);
			$selected_loc=trim($row->selected_location)==''?"NULL":$row->selected_location;
			$coupon=trim($row->coupon_id)==''?"NULL":$row->coupon_id;
			$this->db->query("INSERT INTO orders VALUES (".$row->order_id.",".$row->customer_id.",".$shipping.",".$comment.",".$row->total.",".$row->order_status_id.",'".$row->date_added."','".$row->date_modified."','".$row->delivery_date." ".$row->delivery_time."',".$selected_loc.",".$row->standing_order.",".$cost_centre.",".$order_comment.",".$coupon.",0,'".$row->telephone."','".$row->address."','".$row->email."')");
		}
	}
	public function map_order_product()
	{
		$query=$this->db->query("SELECT * FROM oc_order_product");
		foreach($query->result() as $row)
		{
			$this->db->query("INSERT INTO order_product VALUES (".$row->order_product_id.",".$row->order_id.",".$row->product_id.",".$row->quantity.",".$row->price.",".$row->total.")");
		}
	}
	public function map_locations()
	{
		$query=$this->db->query("SELECT * FROM zelocations");
		foreach($query->result_array() as $row)
		{
			$this->db->query("INSERT INTO store VALUES (".$row["location_id"].",'".$row["location_name"]."','".$row["address"]."')");
		}
	}
	public function fetch_companies()
	{
	     $userId = $this->session->userdata('user_id');
	    
	     if($userId == 8  || $userId == 9){
	       $query=$this->db->query("SELECT * FROM company where company_status != 0 ORDER BY company_name");  
	         
	     }else{
	       //echo "SELECT * FROM company where user_id = ".$userId." and company_status != 0 ORDER BY company_name"; exit;
	      $query=$this->db->query("SELECT * FROM company where user_id = ".$userId." and company_status != 0 ORDER BY company_name"); 
	      
	   //   $query=$this->db->query("SELECT * FROM company where   user_id = 0 ORDER BY company_name"); 
	         
	     }
		
		return $query->result();
	}
	
		public function fetch_old_companies()
	{
	    
	     $bendigodb = $this->load->database($this->session->userdata('username'), TRUE); 
		$query= "SELECT * FROM company ORDER BY company_name";
		 $query=$bendigodb->query($query);
		return $query->result();
	}
	
	public function fetch_departments($company_id = '')
	{
	    $userId = $this->session->userdata('user_id');
	    if(isset($company_id) && $company_id != ''){
	       // echo "SELECT * FROM department where company_id = ".$company_id." and user_id = ".$userId; 
	        $query=$this->db->query("SELECT department_id,department_name FROM department where company_id = ".$company_id." and user_id = ".$userId);
	    }else{
	        
	        $query=$this->db->query("SELECT * FROM department where user_id = ".$userId." ORDER BY department_name");
	    }
		
		
	
		return $query->result();
	}
	public function fetch_all_customers()
	{
	    $userId = $this->session->userdata('user_id');
	    if($userId == 8 || $userId == 9){
	        	$query=$this->db->query("SELECT * FROM customer where  status = 1  ORDER BY firstname"); 
	    }else{
	    	$query=$this->db->query("SELECT * FROM customer where user_id = ".$userId." and status = 1  ORDER BY firstname");
  
	    }
		
		
		return $query->result();
	}
	
	public function fetch_customers($id='')
	{ 
	    if($id == ''){
	    $userId = $this->session->userdata('user_id');
	    if($userId == 8 || $userId == 9){
	        	$query=$this->db->query("SELECT * FROM customer where  status = 1  ORDER BY firstname"); 
	    }else{
	    	$query=$this->db->query("SELECT * FROM customer where user_id = ".$userId." and status = 1  ORDER BY firstname");
  
	    }
	    }else{
	       
	        	$query=$this->db->query("SELECT * FROM customer where customer_id = ".$id." and status = 1 ");
	        
	    }
		
		
		return $query->result();
	}
	
	public function fetch_old_customers()
	{
	    
	    
	     $bendigodb = $this->load->database($this->session->userdata('username'), TRUE); 
	     
		 $query="SELECT * FROM customer where  status = 1  ORDER BY firstname";
		
		 $query=$bendigodb->query($query);
		 
		return $query->result();
	}
	
	public function fetch_dash_data()
	{
	    
	    
	    $opecartdb = $this->load->database('opecart', TRUE); 
	    
		$userId = $this->session->userdata('user_id');
		
		$query=$this->db->query("SELECT count(*) as deliveries_today FROM orders WHERE delivery_date_time BETWEEN '".date("Y-m-d",strtotime('now'))." 00:00:01"."' AND '".date("Y-m-d",strtotime('now'))." 23:59:59"."' and    order_status != 0 and user_id =$userId");
		$res['deliveries_today']=$query->result()[0]->deliveries_today;
		
		
		$sqll = "SELECT count(*) as deliveries_today_front FROM oc_order WHERE delivery_date BETWEEN '".date("Y-m-d",strtotime('now'))." 00:00:01"."' AND '".date("Y-m-d",strtotime('now'))." 23:59:59"."' and order_status_id != 0 and user_id =$userId";
		$query= $opecartdb->query($sqll);
	
		$res['deliveries_today_front']=$query->result()[0]->deliveries_today_front;
		
		
		$res['deliveries_today']  = ((int)$res['deliveries_today'] + (int)$res['deliveries_today_front']);
		
		
		$query=$this->db->query("SELECT count(*) as deliveries_month FROM orders WHERE delivery_date_time BETWEEN '".date("Y-m-d",strtotime('first day of this month'))." 00:00:01' AND '".date("Y-m-d",strtotime('last day of this month'))." 23:59:59'  and order_status != 0 and user_id =$userId ");
		$res['deliveries_this_month']=$query->result()[0]->deliveries_month;
		
		
		
		$sqll = "SELECT count(*) as deliveries_month_front FROM oc_order WHERE delivery_date BETWEEN '".date("Y-m-d",strtotime('first day of this month'))." 00:00:01' AND '".date("Y-m-d",strtotime('last day of this month'))." 23:59:59'  and  order_status_id != 0 and user_id =$userId ";
		$query= $opecartdb->query($sqll);
	
		
		$res['deliveries_this_month_front']=$query->result()[0]->deliveries_month_front;
		
		
		
		$res['deliveries_this_month']  = ((int)$res['deliveries_this_month'] + (int)$res['deliveries_this_month_front']);
		
		
		
		$query=$this->db->query("SELECT sum(order_total) as revenue_month FROM orders WHERE delivery_date_time BETWEEN '".date("Y-m-d",strtotime('first day of this month'))." 00:00:01' AND '".date("Y-m-d",strtotime('last day of this month'))." 23:59:59'  and  order_status != 0 and user_id =$userId");
	    $res['revenue_this_month']=($query->result()[0]->revenue_month);
		
		
		
		
		
		$sqll = "SELECT sum(total) as revenue_month FROM oc_order  WHERE delivery_date BETWEEN '".date("Y-m-d",strtotime('first day of this month'))." 00:00:01' AND '".date("Y-m-d",strtotime('last day of this month'))." 23:59:59'  and order_status_id != 0 and  user_id =$userId";
		
		
        
		$query= $opecartdb->query($sqll);
		
	
		
		$res['frontedn_order_revenue_this_month'] = ($query->result()[0]->revenue_month);
		
	
		
		$res['revenue_this_month']  = ((float)$res['revenue_this_month'] + (float)$res['frontedn_order_revenue_this_month']);
		
		
		
		
		$query=$this->db->query("SELECT sum(order_total) as total_unpaid FROM orders WHERE order_status !=3 and order_status !=0 and  user_id =$userId ");
		$res['total_unpaid']=($query->result()[0]->total_unpaid);
		
		
	    $sqllf = "SELECT sum(total) as total_unpaid_front FROM oc_order WHERE order_status_id !=3 and order_status_id !=0 and  user_id =$userId ";
        $query= $opecartdb->query($sqllf);
		
	$res['total_unpaid_front']=($query->result()[0]->total_unpaid_front);	
	
	$res['total_unpaid']  = ((float)$res['total_unpaid'] + (float)$res['total_unpaid_front']);
		
	/*	$query=$this->db->query("select o.*,c.*,v.*,s.* from orders o 
left JOIN customer c ON o.customer_id=c.customer_id  
LEFT JOIN cost_center s on o.cost_centre_id=s.cost_center_id
LEFT JOIN coupon v ON o.coupon_id=v.coupon_id 
LEFT JOIN company co ON c.company_id=co.company_id 
LEFT JOIN user_postcode up on o.postcode = up.postal_code where IF (o.user_id=0,up.user_id=1,o.user_id=1) and (o.postcode!='' or o.user_id='$userId')
ORDER BY `o`.`order_id` DESC  LIMIT 5"); */
$query =$this->db->query("select o.*,c.*,v.* from orders o 
left JOIN customer c ON o.customer_id=c.customer_id  
LEFT JOIN coupon v ON o.coupon_id=v.coupon_id 
LEFT JOIN company co ON c.company_id=co.company_id 
LEFT JOIN user_postcode up on o.postcode = up.postal_code 
where  o.user_id=$userId and o.order_status > 0 ORDER BY o.order_id desc limit 5");
		//$query->this->db->query("SELECT * FROM orders o, user_postcode up where o.delivery_date_time>='".date("Y-m-d",strtotime("now"))." 00:00:01"."' and o.postcode  = up.postal_code and up.user_id =$userId ORDER BY delivery_date_time asc ");
		$res['last_five']=$query->result();
		
		$query=$this->db->query("SELECT MONTHNAME(delivery_date_time) as month,YEAR(delivery_date_time) as year,sum(order_total) as order_count FROM orders o JOIN customer c on o.customer_id=c.customer_id join company co on co.company_id=c.company_id WHERE delivery_date_time>'".date("Y-m-d",strtotime('first day of this month last year'))."' GROUP BY year,month");
		$res['company_order']=$query->result();
		return $res;
	}
	public function new_company($name,$phone,$abn,$address)
	{
	     $userId = $this->session->userdata('user_id');
	     
		$name=$this->db->escape($name);
		$phone=$this->db->escape($phone);
		$abn=$this->db->escape($abn);
		$address=$this->db->escape($address);
		
// 	   echo "INSERT INTO company (user_id,company_name,company_phone,company_abn,company_address) VALUES (".$userId.",".$name.",".$phone.",".$abn.",".$address.")";
// 		exit;
		$this->db->query("INSERT INTO company (user_id,company_name,company_phone,company_abn,company_address) VALUES (".$userId.",".$name.",".$phone.",".$abn.",".$address.")");
	
		return $this->db->insert_id(); 
	
		
	}
	public function new_department($company_id,$department)
	{
	    $userId = $this->session->userdata('user_id');
	    
		$department=$this->db->escape($department);
		$this->db->query("INSERT INTO department (user_id,company_id,department_name) VALUES (".$userId.",".$company_id.",".$department.")");
	}
	public function new_customer($firstname,$lastname,$email,$phone,$fax,$address,$company,$department,$cost_centre)
	{
	    
	    $userId = $this->session->userdata('user_id');
	    
		$firstname=$this->db->escape($firstname);
		$lastname=$this->db->escape($lastname);
		if($email!='null')
			$email=$this->db->escape($email);
		if($phone!='null')
			$phone=$this->db->escape($phone);
		if($fax!='null')
			$fax=$this->db->escape($fax);
		if($address!='null')
			$address=$this->db->escape($address);
		if($cost_centre!='null')
			$cost_centre=$this->db->escape($cost_centre);
		$this->db->query("INSERT INTO customer (status,user_id,firstname,lastname,customer_email,customer_telephone,customer_fax,customer_address,company_id,department_id,customer_cost_centre) VALUES (1,".$userId.",".$firstname.",".$lastname.",".$email.",".$phone.",".$fax.",".$address.",".$company.",".$department.",".$cost_centre.")");
	}
	public function fetch_products($page)
	{
	    
	    	$userId = $this->session->userdata('user_id');
	  	
		$query=$this->db->query("SELECT p.product_id,p.product_name,p.product_description,p.product_desc_1,p.product_desc_2,p.product_desc_3,p.product_desc_4,p.product_desc_5,p.product_price,ph.heading,p.product_minimum,(select category_name from category c join product_category pc on pc.category_id=c.category_id where pc.product_id=p.product_id) as category_name FROM product p LEFT JOIN heading_product hp ON hp.product_id=p.product_id LEFT JOIN product_header ph ON ph.heading_id=hp.heading_id WHERE p.product_name NOT LIKE '*%' AND p.product_name NOT LIKE ''  AND ( p.user_id = ".$userId.") ORDER BY heading,CASE category_name WHEN 'miscellaneous' THEN 2 WHEN 'Breakfast' THEN 3 ELSE 1 END,trim(product_name) asc LIMIT ".(($page-1)*20).",20");
		$res=$query->result();
		if(!empty($res)){
			foreach($res as $row)
			{
				$query=$this->db->query("SELECT ov.name,ov.sort_order,ov.option_id,ov.option_value_id,po.option_price,po.option_price_prefix,po.option_required FROM product_option po JOIN option_value ov ON po.option_value_id=ov.option_value_id JOIN options o ON ov.option_id=o.option_id WHERE po.product_id=".$row->product_id);
				if(!empty($query->result()))
					$row->options=$query->result();
			}
		}
		return $res;
	}
	public function fetch_max_pages($table)
	{
		if($table=='product')
			$query=$this->db->query("SELECT * FROM product WHERE product_name NOT LIKE '*%' AND product_name NOT LIKE ''");
		return ceil($query->num_rows()/20);
	}
	public function fetch_stores()
	{
		$query=$this->db->query("SELECT * FROM store");
		return $query->result();
	}
	public function fetch_categories($category_id='')
	{
	    if($category_id != ''){
		    $query=$this->db->query("SELECT * FROM category WHERE category_id = '".$category_id."' AND status='1'");
	    }else{    
		    $query=$this->db->query("SELECT * FROM category WHERE status = 1 ORDER BY category_name asc");
	    }
		return $query->result();
	}
	public function save_category($data)
	{
	    $category_name = $data['category_name'];
	    $date_added = $data['date_added'];
		 $this->db->query("INSERT INTO category (category_name,date_added) VALUES ('".$category_name."','".$date_added."')");
		 return $this->db->insert_id();
		 
	}
	public function update_category($data,$category_id)
	{
	    $category_name = $data['category_name'];
	    $date_updated = $data['date_updated'];
		 $this->db->query("UPDATE category SET category_name='".$category_name."',date_updated='".$date_updated."' WHERE category_id=".$category_id);
	
		 
	}
	public function delete_category($category_id)
	{
	    $deleted_at = date('Y-m-d');
		 $this->db->query("UPDATE category SET status='0',deleted_at='".$deleted_at."' WHERE category_id=".$category_id);
	
	}
	public function fetch_suppliers($supplier_id='')
	{
	    if($supplier_id != ''){
		    $query=$this->db->query("SELECT * FROM supplier WHERE supplier_id = '".$supplier_id."' AND status='1'");
	    }else{
		    $query=$this->db->query("SELECT * FROM supplier WHERE status='1' ORDER BY supplier_name asc");
	    }
		return $query->result();
	}
	public function fetch_all_suppliers($supplier_id='')
	{
	    
		$query=$this->db->query("SELECT * FROM supplier ORDER BY supplier_name asc");
		return $query->result();
	}
	

	public function save_suppliers($supplier_name,$supplier_address)
	{
		 $this->db->query("INSERT INTO supplier (supplier_name,email_address) VALUES ('".$supplier_name."','".$supplier_address."')");
		 return $this->db->insert_id();
		 
	}
	public function fetch_products_for_category($category){
	    
	    	$userId = $this->session->userdata('user_id');
	    	
		$query=$this->db->query("SELECT p.*,hp.heading_id,heading,(select category_name from category where category_id=".$category.") as category_name FROM product_category pc JOIN product p ON p.product_id=pc.product_id LEFT JOIN heading_product hp ON hp.product_id=p.product_id LEFT JOIN product_header ph ON ph.heading_id=hp.heading_id WHERE category_id=".$category." AND (p.user_id = ".$userId ." OR p.user_id = 0) ORDER BY heading");
		$res=$query->result();
		if(!empty($res)){
			foreach($res as $row)
			{
				$query=$this->db->query("SELECT ov.name,ov.sort_order,ov.option_id,ov.option_value_id,po.option_price,po.option_price_prefix,po.option_required FROM product_option po JOIN option_value ov ON po.option_value_id=ov.option_value_id JOIN options o ON ov.option_id=o.option_id WHERE po.product_id=".$row->product_id);
				if(!empty($query->result()))
					$row->options=$query->result();
			}
		}
		return $res;
	}
	public function search_products($search){
		$search=strtolower($search);
		$search=str_replace("%20"," ",$search);
		$search=$this->db->escape_like_str($search);
			$userId = $this->session->userdata('user_id');
// 		echo "SELECT p.*,hp.heading_id,heading,(select category_name from category c where c.category_id=pc.category_id) as category_name FROM product_category pc RIGHT JOIN product p ON p.product_id=pc.product_id LEFT JOIN heading_product hp ON hp.product_id=p.product_id LEFT JOIN product_header ph ON ph.heading_id=hp.heading_id WHERE lcase(product_name) LIKE '%".$search."%' AND p.user_id = ".$userId ." OR p.user_id = 0 ORDER BY heading,LOCATE('".$search."',product_name),product_name"; exit;
		$query=$this->db->query("SELECT p.*,hp.heading_id,heading,(select category_name from category c where c.category_id=pc.category_id) as category_name FROM product_category pc RIGHT JOIN product p ON p.product_id=pc.product_id LEFT JOIN heading_product hp ON hp.product_id=p.product_id LEFT JOIN product_header ph ON ph.heading_id=hp.heading_id WHERE lcase(product_name) LIKE '%".$search."%' AND (p.user_id = ".$userId ." OR p.user_id = 0) ORDER BY heading,LOCATE('".$search."',product_name),product_name");
		$res=$query->result();
		if(!empty($res)){
			foreach($res as $row)
			{
				$query=$this->db->query("SELECT ov.name,ov.sort_order,ov.option_id,ov.option_value_id,po.option_price,po.option_price_prefix,po.option_required FROM product_option po JOIN option_value ov ON po.option_value_id=ov.option_value_id JOIN options o ON ov.option_id=o.option_id WHERE po.product_id=".$row->product_id);
				if(!empty($query->result()))
					$row->options=$query->result();
			}
		}
		return $res;
	}
	public function fetch_product_options($product_id)
	{
		$query=$this->db->query("SELECT p.product_name,p.product_price,o.name as option_title,ov.name as option_name,po.option_value_id,po.option_required,po.option_price,po.option_price_prefix,po.product_option_id,heading FROM product p JOIN product_option po ON p.product_id=po.product_id JOIN option_value ov ON ov.option_value_id=po.option_value_id JOIN options o ON o.option_id=ov.option_id LEFT JOIN heading_product hp ON hp.product_id=p.product_id LEFT JOIN product_header ph ON ph.heading_id=hp.heading_id WHERE p.product_id=".$product_id);
		return $query->result();
	}
	public function check_coupon_code($code)
	{
		$code=$this->db->escape($code);
		$query=$this->db->query("SELECT * FROM coupon WHERE status=1 AND coupon_code=".$code);
		if(empty($query->result()))
			return 0;
		else return $query->result();
	}
	public function new_coupon($coupon_code,$coupon_desc,$coupon_discount,$coupon_type)
	{
		$coupon_code=$this->db->escape($coupon_code);
		$coupon_desc=$this->db->escape($coupon_desc);
		$this->db->query("INSERT INTO coupon VALUES (null,".$coupon_code.",".$coupon_desc.",".$coupon_discount.",'".$coupon_type."',1)");
	}
	public function new_category($name){
		$this->db->query("INSERT INTO category VALUES (null,null,".$this->db->escape($name).")");
		return $this->db->insert_id();
	}
	public function add_new_product($product_heading,$product_name,$amount,$category,$description,$product_desc_1,$product_desc_2,$product_desc_3,$product_desc_4,$product_desc_5,$minimum,$options)
	{
	    	$userId = $this->session->userdata('user_id');
	    	
		//Check if heading is present
		if(!empty($product_heading)){
			//Check if it exists in database
			$query=$this->db->query("SELECT * FROM product_header WHERE heading=".$this->db->escape($product_heading));
			$res=$query->result();
			if(empty($res)){
				//It doesn't exist, add and get ID
				$this->db->query("INSERT INTO product_header (heading) VALUES (".$this->db->escape($product_heading).")");
				$heading=$this->db->insert_id();
			}
			else{
				//It exists
				$heading=$res[0]->heading_id;
			}
		}
		$description=empty($description)||trim($description)==''||trim($description)=='null'?'NULL':$this->db->escape($description);
		$product_desc_1=empty($product_desc_1)||trim($product_desc_1)==''||trim($product_desc_1)=='null'||trim($product_desc_1)=='NULL'?'NULL':$this->db->escape($product_desc_1);
		$product_desc_2=empty($product_desc_2)||trim($product_desc_2)==''||trim($product_desc_2)=='null'||trim($product_desc_2)=='NULL'?'NULL':$this->db->escape($product_desc_2);
		$product_desc_3=empty($product_desc_3)||trim($product_desc_3)==''||trim($product_desc_3)=='null'||trim($product_desc_3)=='NULL'?'NULL':$this->db->escape($product_desc_3);
		$product_desc_4=empty($product_desc_4)||trim($product_desc_4)==''||trim($product_desc_4)=='null'||trim($product_desc_4)=='NULL'?'NULL':$this->db->escape($product_desc_4);
		$product_desc_5=empty($product_desc_5)||trim($product_desc_5)==''||trim($product_desc_5)=='null'||trim($product_desc_5)=='NULL'?'NULL':$this->db->escape($product_desc_5);
		$this->db->query("INSERT INTO product (product_name,product_description,product_desc_1,product_desc_2,product_desc_3,product_desc_4,product_desc_5,product_price,product_minimum,product_status,user_id) VALUES (".$this->db->escape($product_name).",".$description.",".$product_desc_1.",".$product_desc_2.",".$product_desc_3.",".$product_desc_4.",".$product_desc_5.",".$amount.",".$minimum.",0,".$userId.")");
		$product_id=$this->db->insert_id();
		$this->db->query("INSERT INTO product_category VALUES (".$product_id.",".$category.")");
		if(!empty($product_heading)){
			//Also add to heading_product map
			$this->db->query("INSERT INTO heading_product(product_id,heading_id) VALUES (".$product_id.",".$heading.")");
		}
		//Also check if options are there
		if(!empty($options))
		{
			//Yes they are.
			//The array is of the form option_value_id=>price, add into product_option
			foreach($options as $option=>$price)
			{
				if($price<0){
					$price=$price*(-1);
					$prefix="-";
				}
				else $prefix="+";
				$this->db->query("INSERT INTO product_option (product_id,option_value_id,option_required,option_price,option_price_prefix) VALUES (".$product_id.",".$option.",1,".$price.",'".$prefix."')");
			}
		}
		$query=$this->db->query("SELECT p.product_id,hp.heading_id,p.product_name,p.product_price FROM product p LEFT JOIN heading_product hp ON hp.product_id=p.product_id WHERE p.product_id=".$product_id);
		return $query->result()[0];
	}
	public function fetch_product($product_id)
	{
		$query=$this->db->query("SELECT * FROM product p LEFT JOIN product_category pc ON p.product_id=pc.product_id LEFT JOIN heading_product hp ON hp.product_id=p.product_id LEFT JOIN product_header ph ON ph.heading_id=hp.heading_id WHERE p.product_id=".$product_id);
		return $query->result();
	}
	public function update_product($product_id,$product_name,$amount,$category,$description,$product_desc_1,$product_desc_2,$product_desc_3,$product_desc_4,$product_desc_5,$minimum,$heading)
	{
		//Check if heading string is not empty
		if(!empty($heading))
		{
			$query=$this->db->query("SELECT * FROM product_header ph WHERE heading=".$this->db->escape($heading));
			$res=$query->result();
			if(empty($res)){
				//Heading does not exist
				$query=$this->db->query("INSERT INTO product_header (heading) VALUES (".$this->db->escape($heading).")");
				$heading_id=$this->db->insert_id();
			}
			else{
				//Heading exists
				$heading_id=$res[0]->heading_id;
			}
			//Remove existing headings for this product, if any
			$this->db->query("DELETE FROM heading_product WHERE product_id=".$product_id);
			//Insert new heading
			$this->db->query("INSERT INTO heading_product (product_id,heading_id) VALUES (".$product_id.",".$heading_id.")");
		}
		//If empty, delete all headings
		else{
			$this->db->query("DELETE FROM heading_product WHERE product_id=".$product_id);
		}
		$description=empty($description)||trim($description)==''||trim($description)=='null'?'NULL':$this->db->escape($description);
		$product_desc_1=empty($product_desc_1)||trim($product_desc_1)==''||trim($product_desc_1)=='null'||trim($product_desc_1)=='NULL'?'NULL':$this->db->escape($product_desc_1);
		$product_desc_2=empty($product_desc_2)||trim($product_desc_2)==''||trim($product_desc_2)=='null'||trim($product_desc_5)=='NULL'?'NULL':$this->db->escape($product_desc_2);
		$product_desc_3=empty($product_desc_3)||trim($product_desc_3)==''||trim($product_desc_3)=='null'||trim($product_desc_4)=='NULL'?'NULL':$this->db->escape($product_desc_3);
		$product_desc_4=empty($product_desc_4)||trim($product_desc_4)==''||trim($product_desc_4)=='null'||trim($product_desc_3)=='NULL'?'NULL':$this->db->escape($product_desc_4);
		$product_desc_5=empty($product_desc_5)||trim($product_desc_5)==''||trim($product_desc_5)=='null'||trim($product_desc_2)=='NULL'?'NULL':$this->db->escape($product_desc_5);
		$this->db->query("UPDATE product SET product_name=".$this->db->escape($product_name).",product_description=".$description.",product_desc_1=".$product_desc_1.",product_desc_2=".$product_desc_2.",product_desc_3=".$product_desc_3.",product_desc_4=".$product_desc_4.",product_desc_5=".$product_desc_5.",product_price=".$amount.",product_minimum=".$minimum." WHERE product_id=".$product_id);
		$this->db->query("UPDATE product_category SET category_id=".$category." WHERE product_id=".$product_id);
		$query=$this->db->query("SELECT p.product_id,hp.heading_id FROM product p LEFT JOIN heading_product hp ON hp.product_id=p.product_id WHERE p.product_id=".$product_id);
		return $query->result()[0];
	}
	public function update_customer($customer_id,$phone,$email,$cc,$customer_status,$first_name,$last_name)
	{
		$this->db->query("UPDATE customer SET 	firstname=".$this->db->escape($first_name).", lastname=".$this->db->escape($last_name).", customer_telephone=".$this->db->escape($phone).",customer_email=".$this->db->escape($email).",customer_cost_centre=".$this->db->escape($cc).", status=".$this->db->escape($customer_status)." WHERE customer_id=".$customer_id);
	}
	public function del_customer($customer_id)
	{
		$this->db->query("DELETE FROM customer WHERE customer_id=".$customer_id);
	}
	public function del_row($id,$table_name)
	{
		$this->db->query("DELETE FROM ".$table_name." WHERE ".$table_name."_id =".$id);
	}
	public function update_dept($dept_id,$dept_name)
	{
	    
	    
		$this->db->query("UPDATE department SET department_name=".$this->db->escape($dept_name)." WHERE department_id=".$dept_id);
	}
	
	public function update_company($company_id,$company_name,$company_phone,$company_address,$abn)
	{
	    
	    
		$this->db->query("UPDATE company SET company_name = ". $this->db->escape($company_name).",company_phone=".$this->db->escape($company_phone).",company_address=".$this->db->escape($company_address).",company_abn=".$this->db->escape($abn)." WHERE company_id=".$company_id);
	}
	public function fetch_all_options()
	{
		$query=$this->db->query("SELECT * FROM option_value");
		return $query->result();
	}
	public function remove_option($product_option_id)
	{
		$this->db->query("DELETE FROM product_option WHERE product_option_id=".$product_option_id);
	}
	public function add_new_product_option($product_id,$option_value_id,$price,$option_required)
	{
		if($price<0){
			$prefix="-";
			$price=$price*(-1);
		}
		else $prefix="+";
		//Check if exists
		$query=$this->db->query("SELECT * FROM option_value ov JOIN product_option po ON ov.option_value_id=po.option_value_id WHERE po.option_value_id=".$option_value_id." AND product_id=".$product_id);
		if(!empty($query->result()))
			return 0;
		$this->db->query("INSERT INTO product_option (product_id,option_value_id,option_required,option_price,option_price_prefix) VALUES (".$product_id.",".$option_value_id.",".$option_required.",".$price.",'".$prefix."')");
		$query=$this->db->query("SELECT * FROM option_value ov JOIN product_option po ON ov.option_value_id=po.option_value_id WHERE po.option_value_id=".$option_value_id." AND product_id=".$product_id);
		return $query->result();
	}
	public function change_required_status($product_id,$status)
	{
		$this->db->query("UPDATE product_option SET option_required=".$status." WHERE product_id=".$product_id);
	}
	public function fetch_product_headings()
	{
		$ret=[];
		$query=$this->db->query("SELECT heading FROM product_header ORDER BY heading");
		$res=$query->result();
		foreach($res as $row)
			$ret[]=$row->heading; 
		return $ret;
	}
	public function add_option($option,$option_value) 
	{
		$query=$this->db->query("SELECT * FROM options WHERE name=".$this->db->escape($option));
		$res=$query->result();
		if(empty($res)){
			$this->db->query("INSERT INTO options VALUES (null,".$this->db->escape($option).")");
			$option_id=$this->db->insert_id();
		}
		else $option_id=$res[0]->option_id;
		$query=$this->db->query("SELECT max(sort_order) as sort_order FROM option_value WHERE option_id=".$option_id);
		$max=$query->result()[0]->sort_order;
		if(empty($max))
			$max=1;
		$this->db->query("INSERT INTO option_value VALUES (null,".$option_id.",".$this->db->escape($option_value).",".$max.")");
	}
	public function set_image($image,$table,$where)
	{
		$column=($table=='product'?'product_image':'image');
		$this->db->query("UPDATE ".$table." SET ".$column."='".$image."' WHERE ".$where);
	}
	
	
}
