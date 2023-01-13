<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit','-1');
ini_set('post_max_size','500M');
ini_set('upload_max_filesize','500M');
ini_set('max_execution_time',36000);
class Home extends CI_Controller {
	public function salesman_chemist_add($chemist_id="",$next_page="")
	{
		if(!empty($_COOKIE["user_type"]))
		{
			$user_type = $_COOKIE["user_type"];
			if($user_type=="sales")
			{
				setcookie("chemist_id", $chemist_id, time() + (86400 * 30), "/");
				$next_page = base64_decode($next_page);
				if($next_page == constant('main_site')."login")
				{
					$next_page= "";
				}
				if($next_page == constant('main_site')."home/select_chemist")
				{
					$next_page= "";
				}
				if($next_page=="")
				{
					redirect(constant('main_site')."home");
				}
				else
				{
					redirect($next_page);
				}
			}
		}	
	}

	public function salesman_chemist_ck()
	{
		if(!empty($_COOKIE["user_type"]))
		{
			$user_type = $_COOKIE["user_type"];
			if($user_type=="sales" && empty($_COOKIE["chemist_id"]))
			{
				redirect(constant('main_site')."home/select_chemist");
			}
		}	
	}

	public function login_check()
	{	
		//error_reporting(0);
		
		$url = ($_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http') . "://{$_SERVER['SERVER_NAME']}".str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
		/*if($url==constant('main_site') && $this->session->userdata('user_type')=="sales")
		{
			redirect(constant('main_site')."logout");
		}*/
		if($_COOKIE["user_altercode"]==""){
			redirect(constant('main_site')."login");			
		}
		if($_COOKIE["user_type"]=="corporate"){
			redirect(constant('main_site')."logout");			
		}
		$under_construction = $this->Scheme_Model->get_website_data("under_construction");
		if($under_construction=="1")
		{
			redirect(base_url()."under_construction");
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
			
			redirect(constant('img_url_site')."home");
		}
		else{
			redirect(constant('main_site')."user/login");
		}
	}
	
	public function index(){
		$this->login_check();
		$this->salesman_chemist_ck();

		////error_reporting(0);		
		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		
		if(!empty($_COOKIE['user_type']))
		{
			$user_type = $_COOKIE['user_type'];
			$chemist_id = $_COOKIE['chemist_id'];
			if($user_type=="sales")
			{
				$data["session_user_fname"]     = "Code : ".$chemist_id." | <a href='".base_url()."home/select_chemist'> <img src='".base_url()."/img_v".constant('site_v')."/edit_icon_w.png' width='12px;' style='margin-top: 2px;margin-bottom: 2px;'></a>";
			}
		}
		
		$data["main_page_title"] = "Home";
		
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

		$user_type 		= $_COOKIE['user_type'];
		$user_altercode = $_COOKIE['user_altercode'];
		$user_password	= $_COOKIE['user_password'];
		
		$chemist_id 	= $_COOKIE['chemist_id'];

		$salesman_id = "";
		if($user_type=="sales")
		{
			$salesman_id 	= $user_altercode;
			$user_altercode = $chemist_id;
		}

		$result6 = $this->Chemist_Model->user_top_search_items($user_type,$user_altercode,$salesman_id);
		$result6 = json_decode("[$result6]", true);
		$data["result6"] = $result6;
		
		$this->load->view('home/header', $data);		
		$this->load->view('home/home', $data);
		$this->load->view('home/footer', $data);
	}

	public function account(){
		////error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		$data["chemist_id"] = $_COOKIE['user_altercode'];
		
		$data["main_page_title"] = "Account";
		$this->load->view('home/header', $data);		
		$this->load->view('home/account', $data);
	}

	public function change_account(){
		////error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		$data["chemist_id"] = $_COOKIE['user_altercode'];
		
		$data["main_page_title"] = "Update account";
		$user_type = $_COOKIE['user_type'];
		if($user_type=="sales")
		{
			redirect(base_url());
		}
		$this->load->view('home/header', $data);		
		$this->load->view('home/change_account', $data);
	}

	public function change_image(){
		////error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		$data["chemist_id"] = $_COOKIE['user_altercode'];
		
		$data["main_page_title"] = "Update image";
		$this->load->view('home/header', $data);		
		$this->load->view('home/change_image', $data);
	}
	
	public function change_password(){
		////error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		$data["chemist_id"] = $_COOKIE['user_altercode'];
		
		$data["main_page_title"] = "Update password";
		$this->load->view('home/header', $data);
		$this->load->view('home/change_password', $data);
	}
	
	public function medicine_category($item_page_type="",$item_code="",$item_division=""){
		////error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		$data["chemist_id"] = $_COOKIE['user_altercode'];
		
		$data["main_page_title"] = "Dr";
		if(empty($_COOKIE['user_session'])){
			redirect(base_url()."home");			
		}
		$data["item_page_type"] = $item_page_type;
		$data["item_code"] 		= $item_code;
		$data["item_division"] 	= $item_division;

		$data["company_full_name"] = "Dr";
		$this->load->view('home/header', $data);		
		$this->load->view('home/medicine_category', $data);
	}
	
	public function featured_brand($compcode='',$division=''){
		////error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		$data["chemist_id"] = $_COOKIE['user_altercode'];
		
		$data["main_page_title"] = "Dr";
		if($division=="not")
		{
			$division = "";
		}
		$data["compcode"] = $compcode;
		$data["division"] = $division;
		$data["company_full_name"] = "Dr";
		$this->load->view('home/header', $data);		
		$this->load->view('home/featured_brand', $data);
	}

	public function search_view_all()
	{
		$keyword = $_GET["keyword"];
		$data["keyword"]  = $keyword;

		$this->login_check();
		$this->salesman_chemist_ck();

		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		$data["chemist_id"] = $_COOKIE['user_altercode'];
		
		$data["main_page_title"] = "Search medicines";

		if(!empty($_COOKIE['user_type']))
		{
			$user_type = $_COOKIE['user_type'];
			$chemist_id = $_COOKIE['chemist_id'];
			if($user_type=="sales")
			{
				$data["session_user_fname"]     = "Code : ".$chemist_id." | <a href='".base_url()."home/select_chemist'> <img src='".base_url()."/img_v".constant('site_v')."/edit_icon_w.png' width='12px;' style='margin-top: 2px;margin-bottom: 2px;'></a>";
			}
		}

		$user_session 	= $_COOKIE['user_session'];
		$user_type 		= $_COOKIE['user_type'];
		$chemist_id 	= $_COOKIE['chemist_id'];
		$data["chemist_id"] = $chemist_id;
		if($user_type=="sales")
		{
			if(!empty($chemist_id))
			{
				$user_cart_total = $user_session."_".$user_type."_".$chemist_id;
				setcookie("user_temp_rec", $user_cart_total, time() + (86400 * 30), "/");
			}
		}
		else
		{
			$data["chemist_id"] = "";
		}

		
		if(!empty($_COOKIE['user_temp_rec'])){
			/************jab table m oss id ko davai nahi ha to yha remove karta ha */
			$user_temp_rec = $_COOKIE['user_temp_rec'];
			$this->db->query("delete from drd_temp_rec where temp_rec='$user_temp_rec' and status='0' and i_code='' ");
			/************************************************************************/
		}
		
		if(!empty($chemist_id))
		{
			$where = array('altercode'=>$chemist_id);
			$row = $this->Scheme_Model->select_row("tbl_acm",$where);
			$data["chemist_name"] = $row->name;
			$data["chemist_id"]   = $row->altercode;

			$where= array('code'=>$row->code);
			$row1 = $this->Scheme_Model->select_row("tbl_acm_other",$where);

			$user_profile = base_url()."img_v".constant('site_v')."/logo.png";
			if(!empty($row1->image)){
				$user_profile = base_url()."user_profile/".$row1->image;
				if(empty($row1->image))
				{
					$user_profile = base_url()."img_v".constant('site_v')."/logo.png";
				}
			}
			$data["chemist_image"]   = $user_profile;
		}
		
		$data["chemist_id"] = $chemist_id;
		$data["chemist_id_for_cart_total"] = $chemist_id;
		$this->load->view('home/header', $data);
		$this->load->view('home/search_view_all', $data);
	}
	
	public function search_medicine(){
		////error_reporting(0);
		$this->login_check();
		$this->salesman_chemist_ck();

		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		
		$data["main_page_title"] = "Search medicines";

		if(!empty($_COOKIE["user_type"]))
		{
			$user_type = $_COOKIE['user_type'];
			$chemist_id = $_COOKIE['chemist_id'];
			if($user_type=="sales")
			{
				$data["session_user_fname"]     = "Code : ".$chemist_id." | <a href='".base_url()."home/select_chemist'> <img src='".base_url()."/img_v".constant('site_v')."/edit_icon_w.png' width='12px;' style='margin-top: 2px;margin-bottom: 2px;'></a>";
			}
		}

		$user_session 	= $_COOKIE['user_session'];
		$user_type 		= $_COOKIE['user_type'];
		$chemist_id 	= $_COOKIE['chemist_id'];
		$data["chemist_id"] = $chemist_id;
		if($user_type=="sales")
		{
			if(!empty($chemist_id))
			{
				$user_temp_rec = $user_session."_".$user_type."_".$chemist_id;
				setcookie("user_temp_rec", $user_temp_rec, time() + (86400 * 30), "/");
			}
		}
		else
		{
			$data["chemist_id"] = "";
		}

		
		if(!empty($_COOKIE['user_temp_rec'])){
			/************jab table m oss id ko davai nahi ha to yha remove karta ha */
			$user_temp_rec = $_COOKIE['user_temp_rec'];
			$this->db->query("delete from drd_temp_rec where temp_rec='$user_temp_rec' and status='0' and i_code='' ");
			/************************************************************************/
		}
		
		if(!empty($chemist_id))
		{
			$where = array('altercode'=>$chemist_id);
			$row = $this->Scheme_Model->select_row("tbl_acm",$where);
			$data["chemist_name"] = $row->name;
			$data["chemist_id"]   = $row->altercode;

			$where= array('code'=>$row->code);
			$row1 = $this->Scheme_Model->select_row("tbl_acm_other",$where);

			$user_profile = base_url()."img_v".constant('site_v')."/logo.png";
			if(!empty($row1->image)){
				$user_profile = base_url()."user_profile/".$row1->image;
				if(empty($row1->image))
				{
					$user_profile = base_url()."img_v".constant('site_v')."/logo.png";
				}
			}
			$data["chemist_image"]   = $user_profile;
		}
		
		$data["chemist_id"] = $chemist_id;
		$data["chemist_id_for_cart_total"] = $chemist_id;
		$this->load->view('home/header', $data);
		$this->load->view('home/search_medicine', $data);
	}
	
	public function select_chemist(){
		error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		//$data["chemist_id"] = $_COOKIE['user_altercode'];
		
		$data["main_page_title"] = "Search chemist";
		$user_type = $_COOKIE['user_type'];
		if($user_type!="sales")
		{
			redirect(base_url().'home/search_medicine');
		}

		$data["next_page"] = base64_encode($_SERVER['HTTP_REFERER']);

		$data["chemist_id"] = "";
		$this->load->view('home/header', $data);
		$this->load->view('home/select_chemist', $data);
	}
	public function hot_deals(){
		////error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		$data["chemist_id"] = $_COOKIE['user_altercode'];
		
		$data["main_page_title"] = "hot_deals";	
		$this->load->view('home/header', $data);
		$this->load->view('home/hot_deals', $data);
	}
	
	public function draft_order_list($chemist_id=""){
		////error_reporting(0);
		$this->login_check();
		$this->salesman_chemist_ck();
		
		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		
		$data["page_cart"] = "1";
		$data["main_page_title"] = "Draft";

		if(!empty($_COOKIE['user_type']))
		{
			$user_type = $_COOKIE['user_type'];
			$chemist_id = $_COOKIE['chemist_id'];
			if($user_type=="sales")
			{
				$data["session_user_fname"]     = "Code : ".$chemist_id." | <a href='".base_url()."home/select_chemist'> <img src='".base_url()."/img_v".constant('site_v')."/edit_icon_w.png' width='12px;' style='margin-top: 2px;margin-bottom: 2px;'></a>";
			}
		}

		$user_session 	= $_COOKIE['user_session'];
		$user_type 		= $_COOKIE['user_type'];
		$chemist_id 	= $_COOKIE['chemist_id'];
		$data["chemist_id"] = $chemist_id;
		if($user_type=="sales")
		{
			if(empty($chemist_id))
			{
				redirect(base_url().'home/select_chemist');
			}
			else
			{
				$_SESSION['user_temp_rec'] = $user_session."_".$user_type."_".$chemist_id;
			}
		}
		else
		{
			$data["chemist_id"] = "";
		}
		
		$data["chemist_id_for_cart_total"] = $chemist_id;
		$data["chemist_id"] = $chemist_id;
		$this->load->view('home/header', $data);
		$this->load->view('home/my_cart', $data);		
	}

	public function my_cart(){
		////error_reporting(0);
		$this->login_check();
		$this->salesman_chemist_ck();
		
		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		
		$data["page_cart"] = "1";
		$data["main_page_title"] = "Draft";

		if(!empty($_COOKIE['user_type']))
		{
			$user_type = $_COOKIE['user_type'];
			$chemist_id = $_COOKIE['chemist_id'];
			if($user_type=="sales")
			{
				$data["session_user_fname"]     = "Code : ".$chemist_id." | <a href='".base_url()."home/select_chemist'> <img src='".base_url()."/img_v".constant('site_v')."/edit_icon_w.png' width='12px;' style='margin-top: 2px;margin-bottom: 2px;'></a>";
			}
		}

		$user_session 	= $_COOKIE['user_session'];
		$user_type 		= $_COOKIE['user_type'];
		$chemist_id 	= $_COOKIE['chemist_id'];
		$data["chemist_id"] = $chemist_id;
		if($user_type=="sales")
		{
			if(empty($chemist_id))
			{
				redirect(base_url().'home/select_chemist');
			}
			else
			{
				$_SESSION['user_temp_rec'] = $user_session."_".$user_type."_".$chemist_id;
			}
		}
		else
		{
			$data["chemist_id"] = "";
		}
		
		$data["chemist_id_for_cart_total"] = $chemist_id;
		$data["chemist_id"] = $chemist_id;
		$this->load->view('home/header', $data);
		$this->load->view('home/my_cart', $data);		
	}
	
	public function my_order(){
		////error_reporting(0);
		$this->login_check();
		$this->salesman_chemist_ck();

		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		$data["chemist_id"] = $_COOKIE['user_altercode'];
		
		$data["main_page_title"] = "My order";
		$this->load->view('home/header', $data);
		$this->load->view('home/my_order', $data);
	}
	
	public function my_order_details($item_id="")
	{	
		////error_reporting(0);
		$this->login_check();
		$this->salesman_chemist_ck();

		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		$data["chemist_id"] = $_COOKIE['user_altercode'];
		
		$data["main_page_title"] = "My order details";

		$data["item_id"] = ($item_id);

		$this->load->view('home/header', $data);
		$this->load->view('home/my_order_details', $data);
	}
	
	public function my_invoice(){
		////error_reporting(0);
		$this->login_check();
		$this->salesman_chemist_ck();

		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		$data["chemist_id"] = $_COOKIE['user_altercode'];
		
		$data["main_page_title"] = "My invoice";
		$this->load->view('home/header', $data);
		$this->load->view('home/my_invoice',$data);
	}

	public function my_invoice_details($item_id="")
	{
		////error_reporting(0);
		$this->login_check();
		$this->salesman_chemist_ck();

		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		//$data["chemist_id"] = $_COOKIE['user_altercode'];;
		
		$data["main_page_title"] = "My invoice details";
		
		$data["item_id"] = $item_id;
		
		$this->load->view('home/header', $data);
		$this->load->view('home/my_invoice_details',$data);
	}
	
	public function my_notification(){
		////error_reporting(0);
		$this->login_check();
		$this->salesman_chemist_ck();
		
		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		$data["chemist_id"] = $_COOKIE['user_altercode'];
		
		$data["main_page_title"] = "My notification";

		$this->load->view('home/header', $data);		
		$this->load->view('home/my_notification', $data);
	}
	public function my_notification_details($item_id=""){
		////error_reporting(0);
		$this->login_check();
		$this->salesman_chemist_ck();

		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		$data["chemist_id"] = $_COOKIE['user_altercode'];
		
		$data["main_page_title"] = "My notification details";
		
		$data["item_id"] = $item_id;

		$this->load->view('home/header', $data);		
		$this->load->view('home/my_notification_details', $data);
	}

	public function track_order(){
		////error_reporting(0);
		$this->login_check();
		$this->salesman_chemist_ck();

		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		$data["chemist_id"] = $_COOKIE['user_altercode'];
		
		$data["main_page_title"] = "Track order";
		$this->load->view('home/header', $data);
		$this->load->view('home/track_order', $data);
	}
	
	/*******************************local_server******************/
	
	public function local_server_pendingorder(){
		//error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		$data["chemist_id"] = $_COOKIE['user_altercode'];
		
		$user_type = $_COOKIE['user_type'];
		if($user_type!="sales")
		{
			redirect(base_url().'home');
		}
		$data["main_page_title"] = "Pending Order";	
		$this->load->view('home/header', $data);

		$date = date("H");
		if($date>=9 && $date<=19)
		{
			$this->load->view('home/local_server_pendingorder', $data);	
		}
		else
		{
			$this->load->view('corporate/server_offline',$data);
		}		
	}

	public function local_server_all_invoice(){
		//error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		$data["chemist_id"] = $_COOKIE['user_altercode'];
		
		$user_type = $_COOKIE['user_type'];
		if($user_type!="sales")
		{
			redirect(base_url().'home');
		}
		$data["main_page_title"] = "Invoice";	
		$this->load->view('home/header', $data);

		$date = date("H");
		if($date>=9 && $date<=19)
		{
			$this->load->view('home/local_server_all_invoice', $data);	
		}
		else
		{
			$this->load->view('corporate/server_offline',$data);
		}		
	}
	
	public function local_server_pickedby(){
		//error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		$data["chemist_id"] = $_COOKIE['user_altercode'];
		
		$user_type = $_COOKIE['user_type'];
		if($user_type!="sales")
		{
			redirect(base_url().'home');
		}
		$data["main_page_title"] = "Pickedby";	
		$this->load->view('home/header', $data);

		$date = date("H");
		if($date>=9 && $date<=19)
		{
			$this->load->view('home/local_server_pickedby', $data);	
		}
		else
		{
			$this->load->view('corporate/server_offline',$data);
		}		
	}
	
	public function local_server_deliverby(){
		//error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		$data["chemist_id"] = $_COOKIE['user_altercode'];
		
		$user_type = $_COOKIE['user_type'];
		if($user_type!="sales")
		{
			redirect(base_url().'home');
		}
		$data["main_page_title"] = "Deliverby";	
		$this->load->view('home/header', $data);

		$date = date("H");
		if($date>=9 && $date<=19)
		{
			$this->load->view('home/local_server_deliverby', $data);	
		}
		else
		{
			$this->load->view('corporate/server_offline',$data);
		}		
	}
	
	public function local_server_delivery_report(){
		//error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		$data["chemist_id"] = $_COOKIE['user_altercode'];
		
		$user_type = $_COOKIE['user_type'];
		if($user_type!="sales")
		{
			redirect(base_url().'home');
		}
		$data["main_page_title"] = "Delivery Report";	
		$this->load->view('home/header', $data);
		
		$date = date("H");
		if($date>=9 && $date<=19)
		{
			$this->load->view('home/local_server_delivery_report', $data);	
		}
		else
		{
			$this->load->view('corporate/server_offline',$data);
		}	
	}
}
?>