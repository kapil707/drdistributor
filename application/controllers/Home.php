<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit','-1');
ini_set('post_max_size','500M');
ini_set('upload_max_filesize','500M');
ini_set('max_execution_time',36000);
class Home extends CI_Controller {

	public function login_check()
	{	
		//error_reporting(0);
		
		$url = ($_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http') . "://{$_SERVER['SERVER_NAME']}".str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
		/*if($url==constant('main_site') && $this->session->userdata('user_type')=="sales")
		{
			redirect(constant('main_site')."logout");
		}*/
		if($this->session->userdata('user_session')==""){
			redirect(constant('main_site')."login");			
		}
		if($this->session->userdata('user_type')=="corporate"){
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
	
	
	public function bankapi(){
		
		$curl = curl_init();
		
		curl_setopt_array($curl, array(
  CURLOPT_URL => "https://sandbox.apihub.citi.com/gcb/api/v1/accounts?nextStartIndex=REPLACE_THIS_VALUE",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
   "accept: application/json",
    "authorization: AAIkMzkwNmRkNmQtNTM0Yi00ZDIwLTgxZDctMGU3ODg0ODAxM2EzkSTZZ78iKXsZ",
    "client_id: 3906dd6d-534b-4d20-81d7-0e78848013a3",
    "uuid: 8245ccb3-3b91-44f5-3afc-22b89f92f1ea"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
	}
	public function test2(){
		$filename = 'uploads/manage_medicine_image/photo/resize/betnovate_n.png';

		if (file_exists($filename)) {
			$message = "The file $filename exists";
		} else {
			$message = "The file $filename does not exist";
		}
		echo $message;
	}
	public function test(){
		//system("start.bat");
		$this->load->view('home/test');
	}
	
	public function test_noti(){
		
		//error_reporting(0);
		define('API_ACCESS_KEY', 'AAAAdZCD4YU:APA91bFjmo0O-bWCz2ESy0EuG9lz0gjqhAatkakhxJmxK1XdNGEusI5s_vy7v7wT5TeDsjcQH0ZVooDiDEtOU64oTLZpfXqA8EOmGoPBpOCgsZnIZkoOLVgErCQ68i5mGL9T6jnzF7lO');
		
		$firebase_token[0] = "cicQY_KnC94:APA91bHSxrS-lqU9d8QHk5YzDW1ODO_rGr7rKHZS7XpXATaYi24yRhLcIcysTONGPkPLVGqM0ucWh-a9riRYozlsQd8hErA3k-dCQ5RLORT_lEbKhwLwr8wK5JYte6uMSBk69TRrSytt";
		
		$id = "1";
		$title = "Hello";
		$message = "Hello";
		$funtype = "100";
		$division = "";
		$company_full_name = "";
		$image = "";
		$itemid = "";
		
		foreach($firebase_token as $row){
			$token = $row;
			$data = array
			(
				'id'=>$id,
				'title'=>$title,
				'message'=>$message,
				'funtype'=>$funtype,
				'itemid'=>$itemid,
				'division'=>$division,
				'company_full_name'=>$company_full_name,
				'image'=>$image,
			);
				
			$fields = array
			(
				'to'=>$token,
				'data'=>$data,
			);

			$headers = array
			(
				'Authorization: key=' . API_ACCESS_KEY,
				'Content-Type: application/json'
			);
			#Send Reponse To FireBase Server	
			$ch = curl_init();
			curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
			curl_setopt( $ch,CURLOPT_POST, true );
			curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
			$result = curl_exec($ch);
			echo $result;
			curl_close($ch);
		}
	}
	
	public function home2(){
		$this->login_check();
		////error_reporting(0);		
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		$data["chemist_id"] = $this->session->userdata('user_altercode');
		
		$data["main_page_title"] = "Home";
		
		$top_flash = $this->Chemist_Model->top_flash();
		$top_flash = json_decode("[$top_flash]", true);
		$data["top_flash"] = $top_flash;

		$top_flash2 = $this->Chemist_Model->top_flash2();
		$top_flash2 = json_decode("[$top_flash2]", true);
		$data["top_flash2"] = $top_flash2;	

		$title1 = "Our top brands";
		$data["title1"] = $title1;	
		$result1 = $this->Chemist_Model->featured_brand_json();
		$result1 = json_decode("[$result1]", true);	
		$data["result1"] = $result1;

		$title2 = "New arrivals";
		$data["title2"] = $title2;	
		$result2 = $this->Chemist_Model->new_medicine_this_month();
		$result2 = json_decode("[$result2]", true);	
		$data["result2"] = $result2;

		$title3 = "Hot selling";
		$data["title3"] = $title3;	
		$result3 = $this->Chemist_Model->hot_selling_today_json();
		$result3 = json_decode("[$result3]", true);
		$data["result3"] = $result3;

		$title4 = "Must buy";
		$data["title4"] = $title4;	
		$result4 = $this->Chemist_Model->must_buy_medicines_json();
		$result4 = json_decode("[$result4]", true);
		$data["result4"] = $result4;
		
		$this->load->view('home/header2', $data);		
		$this->load->view('home/home2', $data);
		//$this->load->view('home/footer', $data);
	}
	
	public function index(){
		$this->login_check();
		////error_reporting(0);		
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		$data["chemist_id"] = $this->session->userdata('user_altercode');
		
		$data["main_page_title"] = "Home";
		
		$top_flash = $this->Chemist_Model->top_flash();
		$top_flash = json_decode("[$top_flash]", true);
		$data["top_flash"] = $top_flash;

		$top_flash2 = $this->Chemist_Model->top_flash2();
		$top_flash2 = json_decode("[$top_flash2]", true);
		$data["top_flash2"] = $top_flash2;		
		
		$this->load->view('home/header', $data);		
		$this->load->view('home/home', $data);
		$this->load->view('home/footer', $data);
	}

	public function account(){
		////error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		$data["chemist_id"] = $this->session->userdata('user_altercode');
		
		$data["main_page_title"] = "Account";
		$this->load->view('home/header', $data);		
		$this->load->view('home/account', $data);
	}

	public function change_account(){
		////error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		$data["chemist_id"] = $this->session->userdata('user_altercode');
		
		$data["main_page_title"] = "Update account";
		$user_type = $this->session->userdata('user_type');
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
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		$data["chemist_id"] = $this->session->userdata('user_altercode');
		
		$data["main_page_title"] = "Update image";
		$this->load->view('home/header', $data);		
		$this->load->view('home/change_image', $data);
	}
	
	public function change_password(){
		////error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		$data["chemist_id"] = $this->session->userdata('user_altercode');
		
		$data["main_page_title"] = "Update password";
		$this->load->view('home/header', $data);
		$this->load->view('home/change_password', $data);
	}
	
	public function medicine_category($itemcat,$company_full_name){
		////error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		$data["chemist_id"] = $this->session->userdata('user_altercode');
		
		$data["main_page_title"] = base64_decode($company_full_name);
		if(empty($this->session->userdata('user_session'))){
			redirect(base_url()."home");			
		}
		$data["itemcat"] = $itemcat;
		$data["company_full_name"] = base64_decode($company_full_name);
		$this->load->view('home/header', $data);		
		$this->load->view('home/medicine_category', $data);
	}
	
	public function featured_brand($compcode='',$division='',$company_full_name=''){
		////error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		$data["chemist_id"] = $this->session->userdata('user_altercode');
		
		$data["main_page_title"] = base64_decode($company_full_name);
		if($division=="not")
		{
			$division = "";
		}
		$data["compcode"] = $compcode;
		$data["division"] = $division;
		$data["company_full_name"] = base64_decode($company_full_name);
		$this->load->view('home/header', $data);		
		$this->load->view('home/featured_brand', $data);
	}
	
	public function search_medicine($chemist_id=""){
		////error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		
		$data["main_page_title"] = "Search medicines";
		$user_session 	= $this->session->userdata('user_session');
		$user_type 		= $this->session->userdata('user_type');
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

		
		if(!empty($this->session->userdata('user_temp_rec'))){
			/************jab table m oss id ko davai nahi ha to yha remove karta ha */
			$user_temp_rec = $_SESSION['user_temp_rec'];
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

			$user_profile = base_url()."user_profile/$row1->image";
			if($row1->image=="")
			{
				$user_profile = base_url()."img_v".constant('site_v')."/logo.png";
			}

			$data["chemist_image"]   = $user_profile;
		}
		
		$data["chemist_id"] = $chemist_id;
		$data["chemist_id_for_cart_total"] = $chemist_id;
		$this->load->view('home/header', $data);
		$this->load->view('home/search_medicine', $data);
	}
	
	public function select_chemist(){
		////error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		//$data["chemist_id"] = $this->session->userdata('user_altercode');
		
		$data["main_page_title"] = "Search chemist";
		$user_type = $this->session->userdata('user_type');
		if($user_type!="sales")
		{
			redirect(base_url().'home/search_medicine');
		}
		$data["chemist_id"] = "";
		$this->load->view('home/header', $data);
		$this->load->view('home/select_chemist', $data);
	}
	public function hot_deals(){
		////error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		$data["chemist_id"] = $this->session->userdata('user_altercode');
		
		$data["main_page_title"] = "hot_deals";	
		$this->load->view('home/header', $data);
		$this->load->view('home/hot_deals', $data);
	}
	
	public function draft_order_list($chemist_id=""){
		////error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		
		$data["page_cart"] = "1";
		$data["main_page_title"] = "Draft";
		$user_type = $_SESSION['user_type'];
		if($user_type=="sales" && empty($chemist_id))
		{
			redirect(base_url().'home/draft_order_list_sales');
		}
		$data["chemist_id_for_cart_total"] = $chemist_id;
		$data["chemist_id"] = $chemist_id;
		$this->load->view('home/header', $data);
		$this->load->view('home/draft_order_list', $data);		
	}
	
	public function draft_order_list_sales(){
		////error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		//$data["chemist_id"] = $this->session->userdata('user_altercode');
		
		$data["main_page_title"] = "Select chemist";
		$user_type = $this->session->userdata('user_type');
		if($user_type!="sales")
		{
			redirect(base_url().'home/draft_order_list');
		}
		$this->load->view('home/header', $data);
		$this->load->view('home/draft_order_list_sales', $data);
	}
	
	public function my_orders(){
		////error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		$data["chemist_id"] = $this->session->userdata('user_altercode');
		
		$data["main_page_title"] = "My orders";
		$this->load->view('home/header', $data);
		$this->load->view('home/my_orders', $data);
	}
	
	public function my_orders_view($id="")
	{	
		////error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		$data["chemist_id"] = $this->session->userdata('user_altercode');
		
		
		$data["main_page_title"] = "My orders";
		$data["id"] = base64_decode($id);
		$this->load->view('home/header', $data);
		$this->load->view('home/my_orders_view', $data);
	}
	
	public function my_invoice(){
		////error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		$data["chemist_id"] = $this->session->userdata('user_altercode');
		
		$data["main_page_title"] = "My invoices";
		$this->load->view('home/header', $data);
		$this->load->view('home/my_invoice',$data);
	}
	
	public function my_invoice_view($chemist_id="",$gstvno="")
	{
		////error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		//$data["chemist_id"] = $this->session->userdata('user_altercode');
		
		$data["main_page_title"] = "My invoices";
		
		$data["chemist_id"] = $chemist_id;
		$data["gstvno"] 	= $gstvno;
		
		$this->load->view('home/header', $data);
		$this->load->view('home/my_invoice_view',$data);
	}
	
	public function my_notification(){
		////error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		$data["chemist_id"] = $this->session->userdata('user_altercode');
		
		$data["main_page_title"] = "Notification";
		$this->load->view('home/header', $data);		
		$this->load->view('home/my_notification', $data);
	}
	public function my_notification_view($notification_id){
		////error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		$data["chemist_id"] = $this->session->userdata('user_altercode');
		
		$data["main_page_title"] = "Notification";
		$data["notification_id"] = base64_decode($notification_id);
		$this->load->view('home/header', $data);		
		$this->load->view('home/my_notification_view', $data);
	}

	public function track_order(){
		////error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		$data["chemist_id"] = $this->session->userdata('user_altercode');
		
		$data["main_page_title"] = "Track order";
		$this->load->view('home/header', $data);
		$this->load->view('home/track_order', $data);
	}
	
	/*******************************local_server******************/
	
	public function local_server_pendingorder(){
		//error_reporting(0);
		$this->login_check();
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		$data["chemist_id"] = $this->session->userdata('user_altercode');
		
		$user_type = $this->session->userdata('user_type');
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
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		$data["chemist_id"] = $this->session->userdata('user_altercode');
		
		$user_type = $this->session->userdata('user_type');
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
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		$data["chemist_id"] = $this->session->userdata('user_altercode');
		
		$user_type = $this->session->userdata('user_type');
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
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		$data["chemist_id"] = $this->session->userdata('user_altercode');
		
		$user_type = $this->session->userdata('user_type');
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
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		$data["chemist_id"] = $this->session->userdata('user_altercode');
		
		$user_type = $this->session->userdata('user_type');
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