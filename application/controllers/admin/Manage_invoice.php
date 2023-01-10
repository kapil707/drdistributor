<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Manage_invoice extends CI_Controller {
	var $Page_title = "Manage Invoice";
	var $Page_name  = "manage_invoice";
	var $Page_view  = "manage_invoice";
	var $Page_menu  = "manage_invoice";
	var $page_controllers = "manage_invoice";
	var $Page_tbl   = "tbl_sales_main";
	public function index()
	{
		$page_controllers = $this->page_controllers;
		redirect("admin/$page_controllers/view");
	}
	
	public function view()
	{
		error_reporting(0);
		/******************session***********************/
		$user_id = $this->session->userdata("user_id");
		$user_type = $this->session->userdata("user_type");
		/******************session***********************/

		$_SESSION["latitude"] = 
		$_SESSION["longitude"] = "";	

		$Page_title = $this->Page_title;
		$Page_name 	= $this->Page_name;
		$Page_view 	= $this->Page_view;
		$Page_menu 	= $this->Page_menu;
		$Page_tbl 	= $this->Page_tbl;
		$page_controllers 	= $this->page_controllers;	

		$this->Admin_Model->permissions_check_or_set($Page_title,$Page_name,$user_type);	

		$data['title1'] = $Page_title." || View";
		$data['title2'] = "View";
		$data['Page_name'] = $Page_name;
		$data['Page_menu'] = $Page_menu;	

		$this->breadcrumbs->push("Admin","admin/");
		$this->breadcrumbs->push("$Page_title","admin/$page_controllers/");
		$this->breadcrumbs->push("View","admin/$page_controllers/view");		

		$tbl = $Page_tbl;	

		$data['url_path'] = base_url()."uploads/$page_controllers/photo/";
		$upload_path = "./uploads/$page_controllers/photo/";

		$vdt = date("Y-m-d");
		if($_POST["submit"])
		{
			$vdt = $_POST["vdt"];
			$vdt 	= date("Y-m-d",strtotime($vdt));
		}
		$data["result"] = $this->Admin_Model->Manage_invoice_fun($vdt);	

		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/view",$data);
		$this->load->view("admin/header_footer/footer",$data);
	}
	
	public function view2($id)
	{
		error_reporting(0);
		/******************session***********************/
		$user_id = $this->session->userdata("user_id");
		$user_type = $this->session->userdata("user_type");
		/******************session***********************/

		$_SESSION["latitude"] = 
		$_SESSION["longitude"] = "";	

		$Page_title = $this->Page_title;
		$Page_name 	= $this->Page_name;
		$Page_view 	= $this->Page_view;
		$Page_menu 	= $this->Page_menu;
		$Page_tbl 	= $this->Page_tbl;
		$page_controllers 	= $this->page_controllers;	

		$this->Admin_Model->permissions_check_or_set($Page_title,$Page_name,$user_type);	

		$data['title1'] = $Page_title." || View";
		$data['title2'] = "View";
		$data['Page_name'] = $Page_name;
		$data['Page_menu'] = $Page_menu;	

		$this->breadcrumbs->push("Admin","admin/");
		$this->breadcrumbs->push("$Page_title","admin/$page_controllers/");
		$this->breadcrumbs->push("View","admin/$page_controllers/view");		

		$tbl = $Page_tbl;	

		$data['url_path'] = base_url()."uploads/$page_controllers/photo/";
		$upload_path = "./uploads/$page_controllers/photo/";

  		$data["result"] = $this->db->query("select * from tbl_sales where gstvno='$id' and mdatatype='insert'")->result();		

		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/view2",$data);
		$this->load->view("admin/header_footer/footer",$data);
	}
	
	public function tbl_order_id()
	{
		$q = $this->db->query("select order_id from tbl_order_id where id='1'")->row();
		$order_id = $q->order_id + 1;
		$this->db->query("update tbl_order_id set order_id='$order_id' where id='1'");
		return $order_id;
	}
	
	public function create_copy_order()
	{
		$order_id 		= $_POST["order_id"];
		$row = $this->db->query("select * from tbl_order where order_id='$order_id'")->row();
		$temp_rec 	= $row->temp_rec."_again";
		$this->db->query("update tbl_order set temp_rec='$temp_rec',download_status='0' where order_id='$order_id'");
		echo "ok";
		
		//$order_id_new 	= $this->tbl_order_id();
		/*$result = $this->db->query("select * from tbl_order where order_id='$order_id'")->result();
		foreach($result as $row)
		{
			$order_type = $row->order_type;
			$user_type 	= $row->user_type;
			$item_code 	= $row->item_code;
			$item_name 	= $row->item_name;
			$sale_rate 	= $row->sale_rate;
			$quantity 	= $row->quantity;
			$remarks 	= $row->remarks;
			$date 		= $row->date;
			$time 		= $row->time;
			$filename 	= $row->filename;
			$status 	= $row->status;
			$chemist_id = $row->chemist_id;
			$salesman_id = $row->salesman_id;
			$temp_rec 	= $row->temp_rec;
			$gstvno 	= $row->gstvno;
			$odt 		= $row->odt;
			$ordno_new = $row->ordno_new;
			
			$dt = array(
			'order_type'=>$order_type,
			'user_type'=>$user_type,
			'order_id'=>$order_id_new,
			'item_code'=>$item_code,
			'item_name'=>$item_name,
			'sale_rate'=>$sale_rate,
			'quantity'=>$quantity,
			'remarks'=>$remarks,
			'date'=>$date,
			'time'=>$time,
			'filename'=>$filename,
			'status'=>$status,
			'chemist_id'=>$chemist_id,
			'salesman_id'=>$salesman_id,
			'temp_rec'=>$temp_rec,
			'gstvno'=>$gstvno,
			'odt'=>$odt,
			'ordno_new'=>$ordno_new,
			);
			$this->Scheme_Model->insert_fun("tbl_order",$dt);
		}
		$this->db->query("delete from tbl_order where order_id='$order_id'");
		echo "ok";*/
	}
}