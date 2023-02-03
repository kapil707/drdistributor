<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class under_construction extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//error_reporting(0);
		$under_construction = $this->Scheme_Model->get_website_data("under_construction");
		if($under_construction!="1")
		{
			redirect(base_url());
		}
	}
	
	public function index(){
		//error_reporting(0);	
		$this->load->view('home/under_construction');
	}
}
?>