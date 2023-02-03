<?php
defined('BASEPATH') OR exit('No direct script access allowed');class Manage_chemist_request extends CI_Controller {
	var $Page_title = "Manage Chemist Request";
	var $Page_name  = "manage_chemist_request";
	var $Page_view  = "manage_chemist_request";
	var $Page_menu  = "manage_chemist_request";
	var $page_controllers = "manage_chemist_request";
	var $Page_tbl   = "tbl_new_password";
	public function index()
	{
		$page_controllers = $this->page_controllers;
		redirect("admin/$page_controllers/view");
	}
	public function view()
	{		error_reporting(0);
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
		$data['title2'] = "View";		$data['Page_name'] = $Page_name;
		$data['Page_menu'] = $Page_menu;
		$this->breadcrumbs->push("Admin","admin/");			$this->breadcrumbs->push("$Page_title","admin/$page_controllers/");
		$this->breadcrumbs->push("View","admin/$page_controllers/view");		
		$tbl = $Page_tbl;	
		$data['url_path'] = base_url()."uploads/$page_controllers/photo/";
		$upload_path = "./uploads/$page_controllers/photo/";
		
		extract($_POST);
		if(isset($Submit))
		{
			$this->db->query("delete from tbl_new_password where chemist_code='$code' ");
		}
		$query = $this->db->query("select tbl_acm.id,tbl_acm.code,tbl_acm.altercode,tbl_acm.name,tbl_acm.email,tbl_acm.mobile,tbl_acm.status,tbl_acm_other.exp_date,tbl_acm_other.status as status1 from tbl_acm,tbl_acm_other,tbl_new_password where tbl_acm.code=tbl_acm_other.code and tbl_acm.altercode=tbl_new_password.chemist_code order by tbl_acm.id desc");
  		$data["result"] = $query->result();
		$this->load->view("admin/header_footer/header",$data);		$this->load->view("admin/$Page_view/view",$data);
		$this->load->view("admin/header_footer/footer",$data);
	}	public function search_user($page_type)	{		error_reporting(0);		header('Content-Type: application/json');		if($page_type=="get")		{			$search	= $_GET["search"];		}		if($page_type=="post")		{			$search	= $_POST["search"];		}
		$query = $this->db->query("select tbl_acm.id,tbl_acm.address,tbl_acm.address1,tbl_acm.address2,tbl_acm.address3,tbl_acm.address3,tbl_acm.code,tbl_acm.altercode,tbl_acm.name,tbl_acm.email,tbl_acm.mobile,tbl_acm.status,tbl_acm_other.exp_date,tbl_acm_other.status as status1 from tbl_acm,tbl_acm_other where tbl_acm.code=tbl_acm_other.code and tbl_acm.altercode='$search' order by tbl_acm.id desc limit 10")->result();
		foreach($query as $row)
		{			
			$altercode = $row->altercode;
			$name = $row->name;
			$email = $row->email;
			$mobile = $row->mobile;
			$exp_date = date("d-F-Y", strtotime($row->exp_date));
			$status = $row->status;
			$address = base64_decode($row->address).",".base64_decode($row->address1).",".base64_decode($row->address2).",".base64_decode($row->address3);
			$id = $row->id;
			$name = base64_encode($name);
			$altercode = base64_encode($altercode);
			$email = base64_encode($email);
			$mobile = base64_encode($mobile);
			$address = base64_encode($address);
$items.= <<<EOD
{"id":"{$id}","altercode":"{$altercode}","name":"{$name}","email":"{$email}","mobile":"{$mobile}","exp_date":"{$exp_date}","status":"{$status}","address":"{$address}"},
EOD;
		}
				$query = $this->db->query("select tbl_acm.id,tbl_acm.address,tbl_acm.address1,tbl_acm.address2,tbl_acm.address3,tbl_acm.address3,tbl_acm.code,tbl_acm.altercode,tbl_acm.name,tbl_acm.email,tbl_acm.mobile,tbl_acm.status,tbl_acm_other.exp_date,tbl_acm_other.status as status1 from tbl_acm,tbl_acm_other where tbl_acm.code=tbl_acm_other.code and (tbl_acm.altercode like '%$search%' or tbl_acm.name like '%$search%') and tbl_acm.id!='$id' order by tbl_acm.id desc limit 10")->result();		foreach($query as $row)		{			$altercode = $row->altercode;			$name = $row->name;			$email = $row->email;			$mobile = $row->mobile;			$exp_date = date("d-F-Y", strtotime($row->exp_date));			$status = $row->status;
			$address = base64_decode($row->address).",".base64_decode($row->address1).",".base64_decode($row->address2).",".base64_decode($row->address3);			$id = $row->id;
			$name = base64_encode($name);
			$altercode = base64_encode($altercode);
			$email = base64_encode($email);
			$mobile = base64_encode($mobile);
			$address = base64_encode($address);$items.= <<<EOD{"id":"{$id}","altercode":"{$altercode}","name":"{$name}","email":"{$email}","mobile":"{$mobile}","exp_date":"{$exp_date}","status":"{$status}","address":"{$address}"},EOD;		}if ($items != '') {	$items = substr($items, 0, -1);}?>{"items":[<?= $items;?>]}		<?php	}
	
	function clean($string) {
		$string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.
		$string = str_replace('-', '', $string); // Replaces all spaces with hyphens.
		return preg_replace('/[^A-Za-z0-9\#]/', '', $string); // Removes special chars.
	}	
	public function send_email_for_password_create($code,$password)
	{
		$this->db->query("delete from tbl_new_password where chemist_code='$code' ");		$q = $this->db->query("select * from tbl_acm where code='$code' ")->row();
		if($q->altercode!="")
		{
			$name		= $q->name;
			$email_id 	= $q->email;
			$altercode 	= $q->altercode;
			$number 	= $q->mobile;
			if($q->mobile!="")
			{
				/*$msg = "Hello $q->name Your New Login Details is $q->altercode Password is $randompassword";
				$q->mobile = "9530005050";
				//$q->mobile = "7303229909";
				$this->auth_model->send_sms_fun($q->mobile,$msg);*/
			}
			else
			{
				$err = "$name this user can not have any mobile number";
				$this->Email_Model->tbl_whatsapp_email_fail($number,$err,$altercode);
			}
			if($q->email!="")
			{				$this->Email_Model->send_email_for_password_create($name,$email_id,$altercode,$password);
			}
			else
			{
				$err = "$name this user can not have any email address";
				$this->Email_Model->tbl_whatsapp_email_fail($email_id,$err,$altercode);
			}
		}
	}	
	public function password_create1(){
		error_reporting(0);
		$id = $_POST["id"];
		$password = strtolower($_POST["password"]);		
		$row = $this->db->query("select tbl_acm.code from tbl_acm,tbl_acm_other where tbl_acm.code=tbl_acm_other.code and tbl_acm.id='$id' order by tbl_acm.id desc")->row();		$code = $row->code;
		$this->send_email_for_password_create($code,$password);
		$password = md5($password);
		$this->db->query("update tbl_acm_other set password='$password' where code='$code'");
		echo "ok";
	}
	public function password_create2() {
		error_reporting(0);
		$id = $_POST["id"];
		$password = strtolower($this->randomPassword());	
		$row = $this->db->query("select tbl_acm.code from tbl_acm,tbl_acm_other where tbl_acm.code=tbl_acm_other.code and tbl_acm.id='$id' order by tbl_acm.id desc")->row();
		$code = $row->code;
		$this->send_email_for_password_create($code,$password);
		$password = md5($password);
		$this->db->query("update tbl_acm_other set password='$password' where code='$code'");
		echo "ok";
	}
	public function randomPassword() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];		}
		return implode($pass); //turn the array into a string
	}
}