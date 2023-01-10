<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Manage_sales_deleted extends CI_Controller {
	var $Page_title = "Manage Sales Deleted";
	var $Page_name  = "manage_sales_deleted";
	var $Page_view  = "manage_sales_deleted";
	var $Page_menu  = "manage_sales_deleted";
	var $page_controllers = "manage_sales_deleted";
	var $Page_tbl   = "tbl_sales_deleted";
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
			$vdt = DateTime::createFromFormat("d-M-yy" , $vdt);
			$vdt = $vdt->format('Y-m-d');
		}
		$vdt1 = DateTime::createFromFormat("Y-m-d" , $vdt);
		$vdt1 = $vdt1->format('d-M-yy');
		$data["vdt1"] = $vdt1;
		$query = $this->db->query("select * from $tbl where (delete_descp='ITEM DELETE' or delete_descp='QTY.CHANGE') and vdt='$vdt' order by id desc");
  		$data["result"] = $query->result();		
		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/view",$data);
		$this->load->view("admin/header_footer/footer",$data);
	}	
}