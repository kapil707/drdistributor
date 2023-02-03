<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}
	public function index(){
		//error_reporting(0);
		redirect(base_url());
	}

	public function termsofservice() {
		//error_reporting(0);
		$data = "";
		
		$data["session_user_image"] = base_url()."img_v".constant('site_v')."/logo2.png";
		$data["session_user_fname"]     = "Guest";
		$data["session_user_altercode"] = "xxxxxx";
		$data["chemist_id"] = "";
		
		if(!empty($this->session->userdata('user_altercode')))
		{
			$data["session_user_image"] 	= $this->session->userdata('user_image');
			$data["session_user_fname"]     = $this->session->userdata('user_fname');
			$data["session_user_altercode"] = $this->session->userdata('user_altercode');
			$data["chemist_id"] = $this->session->userdata('user_altercode');
		}
		
		$this->load->view('home/header', $data);
	    $this->load->view('main_page/termsofservice', $data);
	}

	public function privacy_policy() {
		//error_reporting(0);
		
		$data["session_user_image"] = base_url()."img_v".constant('site_v')."/logo2.png";
		$data["session_user_fname"]     = "Guest";
		$data["session_user_altercode"] = "xxxxxx";
		$data["chemist_id"] = "";
		
		if(!empty($this->session->userdata('user_altercode')))
		{
			$data["session_user_image"] 	= $this->session->userdata('user_image');
			$data["session_user_fname"]     = $this->session->userdata('user_fname');
			$data["session_user_altercode"] = $this->session->userdata('user_altercode');
			$data["chemist_id"] = $this->session->userdata('user_altercode');
		}
		
		$this->load->view('home/header', $data);
	    $this->load->view('main_page/privacy_policy', $data);
	}

	public function register() {
		//error_reporting(0);
		$data["main_page_title"] = "Create account";
	    $this->load->view('main_page/register', $data);
	}
	
	public function login() {
		$this->session->sess_destroy();
		if($this->session->userdata('user_session')!=""){
			redirect('home');
		}
		$data["main_page_title"] = "Login";
	    $this->load->view('main_page/login', $data);
	}
	
	public function logout(){
		$this->session->sess_destroy();	
		//$this->session->unset_userdata('__ci_last_regenerate');
		/*$CI =& get_instance();
		$path = $CI->config->item('cache_path');

		$cache_path = ($path == '') ? APPPATH.'cache/' : $path;

		$handle = opendir($cache_path);
		while (($file = readdir($handle))!== FALSE) 
		{
			//Leave the directory protection alone
			if ($file != '.htaccess' && $file != 'index.html')
			{
				echo $cache_path.'/'.$file;
			   //@unlink($cache_path.'/'.$file);
			}
		}
		closedir($handle);*/

		setcookie("user_cart_total", "0", time() + (86400 * 30), "/");

		setcookie("user_type", "", time() + (86400 * 30), "/");
		setcookie("user_altercode", "", time() + (86400 * 30), "/");
		setcookie("user_password", "", time() + (86400 * 30), "/");
		setcookie("chemist_id", "", time() + (86400 * 30), "/");
		setcookie("user_session", "", time() + (86400 * 30), "/");

		redirect(constant('main_site'));
	}

	public function logout2(){
		$this->session->sess_destroy();	
		$this->session->unset_userdata('__ci_last_regenerate');
		redirect(base_url()."user/login");
	}
	
	public function invoice($chemist_id='',$invoice_id=''){
		
		$data["session_user_image"] = base_url()."img_v".constant('site_v')."/logo2.png";
		$data["session_user_fname"]     = "Guest";
		$data["session_user_altercode"] = "xxxxxx";
		
		$where = array('gstvno'=>$invoice_id,'altercode'=>$chemist_id);
		$this->db->where($where);
		$query = $this->db->get("tbl_invoice");
		$row   = $query->row();
		$data["item_id"] 		= $row->id;
		$data["user_altercode"] = $chemist_id;
		
		$data["main_page_title"] = $invoice_id;	
		$this->load->view('home/header', $data);		
		$this->load->view('main_page/my_invoice_details', $data);		
	}

	public function download_invoice($chemist_id='',$invoice_id='')
	{
		$where = array('gstvno'=>$invoice_id,'altercode'=>$chemist_id);
		$this->db->where($where);
		$query = $this->db->get("tbl_invoice");
		$row   = $query->row();
		if($row->id!="")
		{
			?>
			<script>
				window.location.href = "<?= base_url(); ?>upload_invoice/<?= $invoice_id ?>.xls";
				setTimeout(function() {window.history.back();}, 500);
			</script>
			<?php
		}
		else{
			?>
			<script>
				window.history.back();
			</script>
			<?php
		}	
	}

	public function download_invoice1($chemist_id='',$invoice_id='')
	{
		$where = array('gstvno'=>$invoice_id,'altercode'=>$chemist_id);
		$this->db->where($where);
		$query = $this->db->get("tbl_invoice");
		$row   = $query->row();
		if($row->id!="")
		{
			?>
			<script>
				window.location.href = "<?= base_url(); ?>upload_invoice/<?= $invoice_id ?>.xls";
				setTimeout(function() {window.close();}, 500);
			</script>
			<?php
		}
		else{
			?>
			<script>
				window.history.back();
			</script>
			<?php
		}	
	}

	public function download_order($order_id,$chemist_id)
	{
		$where = array('order_id'=>$order_id,'chemist_id'=>$chemist_id);
		$this->db->where($where);
		$query = $this->db->get("tbl_order");
		$row   = $query->row();
		$query = $query->result();
		if($row->id!="")
		{
			$where 			= array('altercode'=>$row->chemist_id);
			$users 			= $this->Scheme_Model->select_row("tbl_acm",$where);
			$acm_altercode 	= $users->altercode;
			$acm_name		= ucwords(strtolower($users->name));		
			$chemist_excle 	= "$acm_name ($acm_altercode)";
			$this->Order_Model->excel_save_order_to_server($query,$chemist_excle,"direct_download");
		}
		else{
			echo "error";
		}
	}
}
