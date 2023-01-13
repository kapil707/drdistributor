<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit','-1');
ini_set('post_max_size','500M');
ini_set('upload_max_filesize','500M');
ini_set('max_execution_time',36000);
class Main extends CI_Controller {

	public function login_check()
	{
		//error_reporting(0);
		if($this->session->userdata('user_session')!=""){
			redirect(base_url()."home");			
		}
		$under_construction = $this->Scheme_Model->get_website_data("under_construction");
		if($under_construction=="1")
		{
			redirect(base_url()."under_construction");
		}
	}
	
	public function index(){
		$this->login_check();
		////error_reporting(0);
		$data["main_page_title"] = "Home";
		$data["session_user_image"] = base_url()."img_v".constant('site_v')."/logo2.png";
		$data["session_user_fname"]     = "Guest";
		$data["session_user_altercode"] = "xxxxxx";
		$data["chemist_id"] = "";

		if($_COOKIE["user_altercode"]!=""){
			redirect(constant('main_site')."home");
		} else {
			setcookie("user_cart_total", "0", time() + (86400 * 30), "/");
		}
		
		$this->load->view('home/header', $data);

		/***************************************************/
		$top_flash = file_get_contents('./json_api/top_flash.json');
		$top_flash = json_decode("[$top_flash]", true);
		$data["top_flash"] = $top_flash;

		/***************************************************/
		$top_flash2 = file_get_contents('./json_api/top_flash2.json');
		$top_flash2 = json_decode("[$top_flash2]", true);
		$data["top_flash2"] = $top_flash2;

		/***************************************************/
		$title0 = "Our top brands";
		$data["title0"] = $title0;
		//$this->Chemist_Model->featured_brand_json_new();
		$result0 = file_get_contents('./json_api/featured_brand_json_new.json');
		$result0 = json_decode("[$result0]", true);	
		$data["result0"] = $result0;

		/***************************************************/
		$result1 = file_get_contents('./json_api/new_medicine_this_month_json_new.json');
		$result1 = json_decode("[$result1]", true);	
		$data["result1"] = $result1;

		/***************************************************/
		$result2 = file_get_contents('./json_api/hot_selling_today_json_new.json');
		$result2 = json_decode("[$result2]", true);
		$data["result2"] = $result2;

		/***************************************************/
		$result3 = file_get_contents('./json_api/must_buy_medicines_json_new.json');
		$result3 = json_decode("[$result3]", true);
		$data["result3"] = $result3;

		/***************************************************/
		$result4 = file_get_contents('./json_api/frequently_use_medicines_json_new.json');
		$result4 = json_decode("[$result4]", true);
		$data["result4"] = $result4;
		
		/***************************************************/
		$result5  = file_get_contents('./json_api/stock_now_available.json');
		$result5 = json_decode("[$result5]", true);
		$data["result5"] = $result5;

		/***************************************************/
		$data["result6"] = "";
				
		$this->load->view('home/home', $data);
		$this->load->view('home/footer');
	}
}
?>