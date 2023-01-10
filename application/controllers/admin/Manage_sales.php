<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Manage_sales extends CI_Controller {
	var $Page_title = "Manage sales";
	var $Page_name  = "manage_sales";
	var $Page_view  = "manage_sales";
	var $Page_menu  = "manage_sales";
	var $page_controllers = "manage_sales";
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
		$vdt = $vdt1 = date("Y-m-d");
		if($_POST["submit"])
		{
			$i_code = $_POST["i_code"];
			$vdt = $_POST["vdt"];
			$vdt = DateTime::createFromFormat("d-M-yy" , $vdt);
			$vdt = $vdt->format('Y-m-d');
			$vdt1 = $_POST["vdt1"];
			$vdt1 = DateTime::createFromFormat("d-M-yy" , $vdt1);
			$vdt1 = $vdt1->format('Y-m-d');
		}
  		$data["result"] = $this->db->query("select * from tbl_sales where vdt>='$vdt' and vdt<='$vdt1' and itemc='$i_code'")->result();
		$vdt = DateTime::createFromFormat("Y-m-d",$vdt);
		$data["vdt"] = $vdt->format('d-M-yy');
		$vdt1 = DateTime::createFromFormat("Y-m-d",$vdt1);
		$data["vdt1"] = $vdt1->format('d-M-yy');
		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/view",$data);
		$this->load->view("admin/header_footer/footer",$data);
	}
	
	public function call_search_item()
	{		
		error_reporting(0);
		?><ul style="margin: 0px;padding: 0px;"><?php
		$item_name = $this->input->post('item_name');
		$result =  $this->db->query ("select id,i_code,item_name,item_code from tbl_medicine where item_name Like '$item_name%' or item_name Like '%$item_name' limit 50")->result();
		foreach($result as $row)
		{
			$i_code 	= $row->i_code;
			$item_name 	= ($row->item_name);
			$item_name1 = base64_encode($row->item_name);
			$item_code 	= ($row->item_code);
			?>
			<li style="list-style: none;margin: 5px;"><a href="javascript:additem(<?= $i_code ?>,'<?= $item_name1 ?>')"><?= $item_name ?> (<?= $item_code ?>)</a></li>
			<?php
		}
		?></ul><?php
	}
}