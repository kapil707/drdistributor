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
		
		$this->load->view('home/header', $data);
		
		$top_flash = $this->Chemist_Model->top_flash();
		$top_flash = json_decode("[$top_flash]", true);
		$data["top_flash"] = $top_flash;

		$top_flash2 = $this->Chemist_Model->top_flash2();
		$top_flash2 = json_decode("[$top_flash2]", true);
		$data["top_flash2"] = $top_flash2;		
				
		$this->load->view('home/home', $data);
		$this->load->view('home/footer');
	}
}
?>