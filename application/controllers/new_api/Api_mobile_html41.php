<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api_mobile_html41 extends CI_Controller {
	
	public function privacy_policy(){
		//error_reporting(0);
		$data = "";
		$this->load->view('android/android31/header',$data);
		$this->load->view('main_page/privacy_policy',$data);
	}
	
	public function termsofservice(){
		//error_reporting(0);
		$data = "";
		$this->load->view('android/android31/header',$data);
		$this->load->view('main_page/termsofservice',$data);
	}
	
	public function slider(){
		$where = "";//array('compcode'=>$compcode,);
		$query = $this->Scheme_Model->select_all_result("tbl_slider",$where,"id","asc");
		//$data['result'] = $this->db->query("select * from tbl_slider")->result();
		$data['result'] = $query;
		$this->load->view('android/android31/android_mobile_slider', $data);
	}
	public function slider2(){
		$where = "";//array('compcode'=>$compcode,);
		$query = $this->Scheme_Model->select_all_result("tbl_slider2",$where,"id","asc");
		//$data['result'] = $this->db->query("select * from tbl_slider2")->result();
		$data['result'] = $query;
		$this->load->view('android/android31/android_mobile_slider2', $data);
	}
	
	public function hot_deals(){
		//error_reporting(0);
		$user_type 				= $_GET['user_type'];
		$user_altercode			= $_GET['user_altercode'];
		//$lastid1				= $_GET['lastid1'];
		$data["user_type"] 		= $user_type;
		$data["user_altercode"] = $user_altercode;
		$this->load->view('android/android31/header',$data);
		$this->load->view('android/android31/hot_deals',$data);
	}
	
	public function my_orders(){
		//error_reporting(0);
		$user_type 				= $_GET['user_type'];
		$user_altercode			= $_GET['user_altercode'];
		//$lastid1				= $_GET['lastid1'];
		$data["user_type"] 		= $user_type;
		$data["user_altercode"] = $user_altercode;
		$this->load->view('android/android31/header',$data);
		$this->load->view('android/android31/my_orders',$data);
	}
	
	public function my_orders_view($order_id="",$user_type="",$user_altercode="")
	{	
		//error_reporting(0);
		$data["order_id"] 		= base64_decode($order_id);
		$data["user_type"] 		= base64_decode($user_type);
		$data["user_altercode"] = base64_decode($user_altercode);
		$this->load->view('android/android31/header',$data);
		$this->load->view('android/android31/my_orders_view',$data);
	}
	
	public function my_notification()
	{
		//error_reporting(0);
		$user_type 				= $_GET['user_type'];
		$user_altercode			= $_GET['user_altercode'];
		//$lastid1				= $_GET['lastid1'];
		$data["user_type"] 		= $user_type;
		$data["user_altercode"] = $user_altercode;
		//$data["lastid1"] 		= $lastid1;
		$this->load->view('android/android31/header',$data);
		$this->load->view('android/android31/my_notification',$data);
	}
	
	public function my_notification_view($notification_id)
	{
		//error_reporting(0);
		$data["notification_id"] = base64_decode($notification_id);
		$this->load->view('android/android31/header',$data);
		$this->load->view('android/android31/my_notification_view',$data);
	}
	
	public function my_invoice()
	{
		//error_reporting(0);
		$user_type 				= $_GET['user_type'];
		$user_altercode			= $_GET['user_altercode'];
		//$lastid1				= $_GET['lastid1'];
		$data["user_type"] 		= $user_type;
		$data["user_altercode"] = $user_altercode;
		//$data["lastid1"] 		= $lastid1;
		$this->load->view('android/android31/header',$data);
		$this->load->view('android/android31/my_invoice',$data);
	}
	
	public function my_invoices_view($user_altercode,$gstvno)
	{
		//error_reporting(0);
		$data["user_altercode"]= ($user_altercode);
		$data["gstvno"] = ($gstvno);
		$this->load->view('android/android31/header',$data);
		$this->load->view('android/android31/my_invoice_view',$data);
	}
}