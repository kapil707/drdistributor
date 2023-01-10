<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Manage_fail_log extends CI_Controller {
	var $Page_title = "Manage Fail Log";		var $Page_name  = "manage_fail_log";
	var $Page_view  = "manage_fail_log";
	var $Page_menu  = "manage_fail_log";
	var $page_controllers = "manage_fail_log";
	var $Page_tbl   = "tbl_whatsapp_email_fail";
	public function index()
	{		$page_controllers = $this->page_controllers;
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
		$query = $this->db->query("select * from $tbl order by altercode asc");
  		$data["result"] = $query->result();	
		$this->load->view("admin/header_footer/header",$data);		$this->load->view("admin/$Page_view/view",$data);
		$this->load->view("admin/header_footer/footer",$data);
	}
}