<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Corporate extends CI_Controller {

	public function login_check()
	{
		if($this->session->userdata('user_session')==""){
			redirect(base_url()."user/login");			
		}
	}
	
	public function insert_login($user_name1='',$password1=''){
		
		$items = $this->Chemist_Model->login($user_name1,$password1);
		$someArray = json_decode($items, true);
		
		$user_return 	= "user_return";
		$user_session 	= "user_session";
		$user_fname 	= "user_fname";
		$user_code 		= "user_code";
		$user_altercode = "user_altercode";
		$user_type 		= "user_type";
		$user_password 	= "user_password";
		$user_division 	= "user_division";
		$user_compcode 	= "user_compcode";
		$user_image 	= "user_image";
		if($someArray[$user_return]=="1")
		{
			$ret = $this->Chemist_Model->insert_value_on_session($someArray[$user_session],$someArray[$user_fname],$someArray[$user_code],$someArray[$user_altercode],$someArray[$user_type],$someArray[$user_password],$someArray[$user_division],$someArray[$user_compcode],$someArray[$user_image]);
			
			redirect(constant('img_url_site')."corporate");
		}
		else{
			redirect(constant('main_site')."user/login");
		}
	}
	
	public function index(){
		$this->login_check();
		//error_reporting(0);
		$data["main_page_title"] = "Corporate Home";
		$this->load->view('corporate/header', $data);		
		$this->load->view('corporate/home', $data);
		$this->load->view('corporate/footer', $data);
	}
	
	public function item_wise_report()
	{	
	    $this->login_check();
		//error_reporting(0);
		$data["user_session"]	=	base64_encode($_SESSION["user_session"]);
		$data["user_division"]	=	base64_encode($_SESSION["user_division"]);
		$data["user_compcode"]	=	base64_encode($_SESSION["user_compcode"]);
		
		$data["main_page_title"] = "Item wise report";
		$this->load->view('corporate/header', $data);
		
		$date = date("H");
		if($date>=9 && $date<=19)
		{
			$this->load->view('corporate/item_wise_report',$data);
		}
		else
		{
			$this->load->view('corporate/server_offline',$data);
		}
	}
	
	public function item_wise_report_month()
	{	
	    $this->login_check();
		//error_reporting(0);
		$data["user_session"]	=	base64_encode($_SESSION["user_session"]);
		$data["user_division"]	=	base64_encode($_SESSION["user_division"]);
		$data["user_compcode"]	=	base64_encode($_SESSION["user_compcode"]);
		
		$data["main_page_title"] = "Item wise report monthly";
		$this->load->view('corporate/header', $data);
		
		$date = date("H");
		if($date>=9 && $date<=19)
		{
			$this->load->view('corporate/item_wise_report_month',$data);
		}
		else
		{
			$this->load->view('corporate/server_offline',$data);
		}
	}
	
	public function chemist_wise_report()
	{	
	    $this->login_check();
		//error_reporting(0);
		$data["user_session"]	=	base64_encode($_SESSION["user_session"]);
		$data["user_division"]	=	base64_encode($_SESSION["user_division"]);
		$data["user_compcode"]	=	base64_encode($_SESSION["user_compcode"]);
		
		$data["main_page_title"] = "Chemist wise report";
		$this->load->view('corporate/header', $data);
		
		$date = date("H");
		if($date>=9 && $date<=19)
		{
			$this->load->view('corporate/chemist_wise_report',$data);
		}
		else
		{
			$this->load->view('corporate/server_offline',$data);
		}
	}
	
	public function chemist_wise_report_month()
	{	
	    $this->login_check();
		//error_reporting(0);
		$data["user_session"]	=	base64_encode($_SESSION["user_session"]);
		$data["user_division"]	=	base64_encode($_SESSION["user_division"]);
		$data["user_compcode"]	=	base64_encode($_SESSION["user_compcode"]);
		
		$data["main_page_title"] = "Chemist wise report monthly";
		$this->load->view('corporate/header', $data);
		
		$date = date("H");
		if($date>=9 && $date<=19)
		{
			$this->load->view('corporate/chemist_wise_report_month',$data);
		}
		else
		{
			$this->load->view('corporate/server_offline',$data);
		}
	}
	
	public function stock_and_sales_analysis()
	{	
	    $this->login_check();
		//error_reporting(0);
		$data["user_session"]	=	base64_encode($_SESSION["user_session"]);
		$data["user_division"]	=	base64_encode($_SESSION["user_division"]);
		$data["user_compcode"]	=	base64_encode($_SESSION["user_compcode"]);
		
		$data["main_page_title"] = "Stock and sales analysis";
		$this->load->view('corporate/header', $data);
		
		$date = date("H");
		if($date>=9 && $date<=19)
		{
			$this->load->view('corporate/stock_and_sales_analysis',$data);
		}
		else
		{
			$this->load->view('corporate/server_offline',$data);
		}
	}
}
?>