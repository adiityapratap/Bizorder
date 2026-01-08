<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Store_model extends CI_Model{	
	function __construct() {
		parent::__construct();
	}
	public function fetch_categories()
	{
		$query=$this->db->query("SELECT * FROM category ORDER BY case when category_id=1 then 1 when category_id=2 then 2 when category_id=9 then 3 when category_id=11 then 4 when category_id=13 then 5 when category_id=7 then 6 when category_id=8 then 7 when category_id=6 then 8 when category_id=3 then 9 when category_id=4 then 10 when category_id=12 then 11 when category_id=10 then 12 else 13 end,category_name desc");
		return $query->result();
	}
	public function fetch_best_sellers()
	{
		$query=$this->db->query("SELECT op.product_id,sum(quantity),product_name,p.product_price,p.product_description,product_image,image,heading FROM order_product op JOIN orders o ON o.order_id=op.order_id JOIN product p ON op.product_id=p.product_id LEFT JOIN heading_product hp ON hp.product_id=p.product_id LEFT JOIN product_header ph ON ph.heading_id=hp.heading_id WHERE date_added>='".date("Y-m-d H:i",strtotime('monday this week'))."' AND date_added<='".date("Y-m-d H:i",strtotime("sunday this week"))."' GROUP BY op.product_id,product_name,p.product_price,p.product_description,product_image,image,heading ORDER BY sum(quantity) desc LIMIT 3");
		$res=$query->result();
		foreach($res as $row){
			if($row->product_price==0){
				//Check option price
				$query=$this->db->query("SELECT min(option_price) as option_price FROM product_option WHERE product_id=".$row->product_id);
				$row->option_price=$query->result()[0]->option_price;
			}
		}
		return $res;
	}
	public function fetch_whats_new()
	{
		$query=$this->db->query("SELECT p.product_id,product_name,p.product_price,p.product_description,product_image,image,heading FROM product p LEFT JOIN heading_product hp ON hp.product_id=p.product_id LEFT JOIN product_header ph ON ph.heading_id=hp.heading_id ORDER BY product_date_added desc LIMIT 3");
		$res=$query->result();
		foreach($res as $row){
			if($row->product_price==0){
				//Check option price
				$query=$this->db->query("SELECT min(option_price) as option_price FROM product_option WHERE product_id=".$row->product_id);
				$row->option_price=$query->result()[0]->option_price;
			}
		}
		return $res;
	}
	public function fetch_all_products($page,$cat)
	{
		if($cat==0){
			$whereCat="1";
		}
		else{
			$whereCat="category_id=".$cat;
		}
		$query=$this->db->query("SELECT p.product_id,product_name,p.product_price,p.product_description,product_image,image,heading FROM product p JOIN product_category pc ON p.product_id=pc.product_id LEFT JOIN heading_product hp ON hp.product_id=p.product_id LEFT JOIN product_header ph ON ph.heading_id=hp.heading_id WHERE ".$whereCat." ORDER BY heading,product_date_added desc");
		$res=$query->result();
		foreach($res as $row){
			if($row->product_price==0){
				//Check option price
				$query=$this->db->query("SELECT min(option_price) as option_price FROM product_option WHERE product_id=".$row->product_id);
				$row->option_price=$query->result()[0]->option_price;
			}
		}
		return $res;
	}
	public function fetch_max_pages($cat)
	{
		if($cat==0)
			$whereCat="1";
		else $whereCat="category_id=".$cat;
		$query=$this->db->query("SELECT p.product_id,product_name,p.product_price,p.product_description,product_image,image,heading FROM product p JOIN product_category pc ON p.product_id=pc.product_id LEFT JOIN heading_product hp ON hp.product_id=p.product_id LEFT JOIN product_header ph ON ph.heading_id=hp.heading_id WHERE ".$whereCat." ORDER BY heading,product_date_added desc");
		if($query->num_rows()==0)
			return 1;
		return ceil($query->num_rows()/20);
	}
	public function fetch_product($product_id)
	{
		$query=$this->db->query("SELECT p.product_id,p.product_name,p.product_description,p.product_desc_1,p.product_desc_2,p.product_desc_3,p.product_desc_4,p.product_desc_5,heading,product_price,product_image,image,p.product_minimum FROM product p JOIN product_category pc ON p.product_id=pc.product_id LEFT JOIN heading_product hp ON p.product_id=hp.product_id LEFT JOIN product_header ph ON hp.heading_id=ph.heading_id WHERE p.product_id=".$product_id);
		return $query->result();
	}
	public function fetch_options($product_id)
	{
		$query=$this->db->query("SELECT ov.name,po.option_value_id,po.product_option_id,po.option_price,po.option_price_prefix,ov.sort_order FROM product_option po JOIN option_value ov ON po.option_value_id=ov.option_value_id JOIN options o ON ov.option_id=o.option_id WHERE po.product_id=".$product_id." ORDER BY ov.sort_order");
		return $query->result();
	}
	public function fetch_customer($customer_id)
	{
		$query=$this->db->query("SELECT * FROM customer WHERE customer_id=".$customer_id);
		$res=$query->result()[0];
		if(empty($res->customer_telephone)){
			$query=$this->db->query("SELECT * FROM orders WHERE customer_id=".$customer_id." AND delivery_phone IS NOT NULL");
			if($query->num_rows()>0){
				$res->customer_telephone=$query->result()[0]->delivery_phone;
			}
		}
		return $res;
	}
	public function add_new_order($customer_id,$shipping_method,$delivery_notes,$order_status,$delivery_datetime,$selected_location,$standing_order,$cost_centre,$order_comments,$order_total,$delivery_address,$delivery_phone,$delivery_email)
	{
		if(empty($delivery_notes))
			$delivery_notes='null';
		else $delivery_notes=$this->db->escape($delivery_notes);
		if(empty($cost_centre))
			$cost_centre='null';
		else $cost_centre=$this->db->escape($cost_centre);
		if(empty($order_comments))
			$order_comments='null';
		else $order_comments=$this->db->escape($order_comments);
		if(empty($delivery_address))
			$delivery_address='null';
		else $delivery_address=$this->db->escape($delivery_address);
		$this->db->query("INSERT INTO orders (customer_id,shipping_method,pickup_delivery_notes,order_total,order_status,date_added,date_modified,delivery_date_time,selected_location,standing_order,cost_centre,order_comments,coupon_id,delivery_fee,delivery_phone,delivery_address,delivery_email,approval_comments) VALUES(".$customer_id.",".$shipping_method.",".$delivery_notes.",".$order_total.",".$order_status.",'".date("Y-m-d H:i",strtotime("now"))."','".date("Y-m-d H:i",strtotime("now"))."','".$delivery_datetime."',".$selected_location.",".$standing_order.",".$cost_centre.",".$order_comments.",null,0,'".$delivery_phone."',".$delivery_address.",'".$delivery_email."',null)");
		return $this->db->insert_id();
	}
	public function add_product($order_id,$product_id,$quantity,$price)
	{
		$this->db->query("INSERT INTO order_product (order_id,product_id,quantity,price,total) VALUES (".$order_id.",".$product_id.",".$quantity.",".$price.",".($quantity*$price).")");
		return $this->db->insert_id();
	}
	public function add_option($op_id,$po_id,$qty,$price,$total)
	{
		$this->db->query("INSERT INTO order_product_option (order_product_id,product_option_id,option_quantity,option_price,option_total) VALUES (".$op_id.",".$po_id.",".$qty.",".$price.",".$total.")");
	}
	public function mark_paid($order_id)
	{
		$this->db->query("UPDATE orders SET order_status=14 WHERE order_id=".$order_id);
	}
	public function get_order($order_id)
	{
		$query=$this->db->query("SELECT * FROM orders o JOIN customer c ON o.customer_id=c.customer_id WHERE order_id=".$order_id);
		return $query->result();
	}
	public function remove_order($order_id)
	{
		$this->db->query("DELETE FROM orders WHERE order_id=".$order_id);
	}
}
?>