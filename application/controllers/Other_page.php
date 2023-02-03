<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Other_page extends CI_Controller {
	public function drd_live_report()
	{
		$date = date("H");
		if($date>=9 && $date<=19)
		{
			$this->load->view('home/local_server_drd_live_report');	
		}
		else
		{
			$this->load->view('corporate/server_offline');
		}
	}
	
	public function local_server_all_invoice()
	{
		$date = date("H");
		if($date>=9 && $date<=19)
		{
			$this->load->view('home/local_server_all_invoice');	
		}
		else
		{
			$this->load->view('corporate/server_offline');
		}
	}
	
	public function local_server_pickedby()
	{
		$date = date("H");
		if($date>=9 && $date<=19)
		{
			$this->load->view('home/local_server_pickedby');	
		}
		else
		{
			$this->load->view('corporate/server_offline');
		}
	}
	
	public function local_server_deliverby()
	{
		$date = date("H");
		if($date>=9 && $date<=19)
		{
			$this->load->view('home/local_server_deliverby');	
		}
		else
		{
			$this->load->view('corporate/server_offline');
		}
	}
	
	public function local_server_delivery_report()
	{
		$date = date("H");
		if($date>=9 && $date<=19)
		{
			$this->load->view('home/local_server_delivery_report');	
		}
		else
		{
			$this->load->view('corporate/server_offline');
		}
	}
}