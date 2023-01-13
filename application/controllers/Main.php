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

		if ($_SESSION["top_flash"] == "") {
			$_SESSION["top_flash"] = $this->Chemist_Model->top_flash();
		}
		$top_flash = $_SESSION["top_flash"];
		$top_flash = json_decode("[$top_flash]", true);
		$data["top_flash"] = $top_flash;

		if ($_SESSION["top_flash2"] == "") {
			$_SESSION["top_flash2"] = $this->Chemist_Model->top_flash2();
		}
		$top_flash2 = $_SESSION["top_flash2"];
		$top_flash2 = json_decode("[$top_flash2]", true);
		$data["top_flash2"] = $top_flash2;

		$title0 = "Our top brands";
		$data["title0"] = $title0;
		//$this->Chemist_Model->featured_brand_json_new();
		$featured_brand_json_new = fopen("json_api/featured_brand_json_new.json", "r") or die("Unable to open file!");
		echo fread($featured_brand_json_new,filesize($featured_brand_json_new));
		fclose($featured_brand_json_new);
		$result0 = $featured_brand_json_new;
		$result0 = json_decode("[$result0]", true);	
		$data["result0"] = $result0;


		if ($_SESSION["result1"] == "") {
			$_SESSION["result1"] = $this->Chemist_Model->new_medicine_this_month_json_new();
		}
		$result1 = $_SESSION["result1"];
		$result1 = json_decode("[$result1]", true);	
		$data["result1"] = $result1;

		if ($_SESSION["result2"] == "") {
			$_SESSION["result2"] = $this->Chemist_Model->hot_selling_today_json_new();
		}
		$result2 = $_SESSION["result2"];
		$result2 = json_decode("[$result2]", true);
		$data["result2"] = $result2;

		if ($_SESSION["result3"] == "") {
			$_SESSION["result3"] = $this->Chemist_Model->must_buy_medicines_json_new();
		}
		$result3 = $_SESSION["result3"];
		$result3 = json_decode("[$result3]", true);
		$data["result3"] = $result3;

		if ($_SESSION["result4"] == "") {
			$_SESSION["result4"] = $this->Chemist_Model->frequently_use_medicines_json_new();
		}
		$result4 = $_SESSION["result4"];
		$result4 = json_decode("[$result4]", true);
		$data["result4"] = $result4;
		
		if ($_SESSION["result5"] == "") {
			$_SESSION["result5"] = $this->Chemist_Model->stock_now_available();
		}
		$result5 = $_SESSION["result5"];
		$result5 = json_decode("[$result5]", true);
		$data["result5"] = $result5;

		$data["result6"] = "";
				
		$this->load->view('home/home', $data);
		$this->load->view('home/footer');
	}
}
?>