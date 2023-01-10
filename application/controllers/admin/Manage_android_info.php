<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Manage_android_info extends CI_Controller {
	var $Page_title = "Manage Android Info";	
	var $Page_name  = "manage_android_info";
	var $Page_view  = "manage_android_info";
	var $Page_menu  = "manage_android_info";
	var $page_controllers = "manage_android_info";
	var $Page_tbl   = "tbl_android_device_id";
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
		
		extract($_POST);
		if(isset($Submit1))
		{
			$where = array('id'=>$id1);				

			$result = "";
			$dt = array(
			'logout'=>"1",
			);
			$result = $this->Scheme_Model->edit_fun($tbl,$dt,$where);
		}
		
		if(isset($Submit2))
		{
			$where = array('id'=>$id2);				

			$result = "";
			$dt = array(
			'clear_database'=>"1",
			);
			$result = $this->Scheme_Model->edit_fun($tbl,$dt,$where);
		}

		$data['url_path'] = base_url()."uploads/$page_controllers/photo/";
		$upload_path = "./uploads/$page_controllers/photo/";			

		$query = $this->db->query("select * from $tbl order by time desc");
  		$data["result"] = $query->result();	

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

  		$data["result"] = $this->db->query("select * from tbl_order where order_id='$id'")->result();		

		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/view2",$data);
		$this->load->view("admin/header_footer/footer",$data);
	}
}