<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api_mobile_html45 extends CI_Controller {
	
	public function home(){
		//error_reporting(0);
		$data = "";
		
		////error_reporting(0);		
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		
		if(!empty($_SESSION["user_type"]))
		{
			$user_type = $this->session->userdata('user_type');
			$chemist_id = $this->session->userdata('chemist_id');
			if($user_type=="sales")
			{
				$data["session_user_fname"]     = "Code : ".$chemist_id." | <a href='".base_url()."home/select_chemist'> <img src='".base_url()."/img_v".constant('site_v')."/edit_icon_w.png' width='12px;' style='margin-top: 2px;margin-bottom: 2px;'></a>";
			}
		}
		
		$data["main_page_title"] = "Home";
		
		$top_flash = $this->Chemist_Model->top_flash();
		$top_flash = json_decode("[$top_flash]", true);
		$data["top_flash"] = $top_flash;

		$top_flash2 = $this->Chemist_Model->top_flash2();
		$top_flash2 = json_decode("[$top_flash2]", true);
		$data["top_flash2"] = $top_flash2;	

		$title0 = "Our top brands";
		$data["title0"] = $title0;	
		$result0 = $this->Chemist_Model->featured_brand_json_new();
		$result0 = json_decode("[$result0]", true);	
		$data["result0"] = $result0;

		$result1 = $this->Chemist_Model->new_medicine_this_month_json_new();
		$result1 = json_decode("[$result1]", true);	
		$data["result1"] = $result1;
	
		$result2 = $this->Chemist_Model->hot_selling_today_json_new();
		$result2 = json_decode("[$result2]", true);
		$data["result2"] = $result2;

		$result3 = $this->Chemist_Model->must_buy_medicines_json_new();
		$result3 = json_decode("[$result3]", true);
		$data["result3"] = $result3;

		$result4 = $this->Chemist_Model->frequently_use_medicines_json_new();
		$result4 = json_decode("[$result4]", true);
		$data["result4"] = $result4;

		$result5 = $this->Chemist_Model->stock_now_available();
		$result5 = json_decode("[$result5]", true);
		$data["result5"] = $result5;

		/**************************************************** */

		$user_type 		= $this->session->userdata('user_type');
		$user_altercode = $this->session->userdata('user_altercode');
		$user_password	= $this->session->userdata('user_password');	
		
		$chemist_id 	= $this->session->userdata('chemist_id');

		$salesman_id = "";
		if($user_type=="sales")
		{
			$salesman_id 	= $user_altercode;
			$user_altercode = $chemist_id;
		}

		$result6 = $this->Chemist_Model->user_top_search_items($user_type,$user_altercode,$salesman_id);
		$result6 = json_decode("[$result6]", true);
		$data["result6"] = $result6;
		
		$this->load->view('android/android45/header',$data);
		$this->load->view('android/android45/home',$data);
	}
	
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