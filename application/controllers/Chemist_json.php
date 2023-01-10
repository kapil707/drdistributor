<?php
header('Content-Type: application/json');
defined('BASEPATH') OR exit('No direct script access allowed');
class Chemist_json extends CI_Controller {	
	
	public function create_new_api()
	{		
		//error_reporting(0);
		$chemist_code 	= $_POST["chemist_code"];
		$phone_number 	= $_POST["phone_number"];

		if($chemist_code!="" && $phone_number!="")
		{
			$items = $this->Chemist_Model->create_new($chemist_code,$phone_number);
		}
?>
{"items":[<?= $items;?>]}<?php
	}
	public function login_2(){
		//error_reporting(0);
		
		$user_name1 = "okok";
		$password1 = "sadfsaf";
		$data = '{"user_name1":"'.$user_name1.'","user_password":"'.$password1.'"}';
					
		$parmiter = '{"items":['.$data.']}';
		
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_URL =>"https://drdistributor.in/main/get_data",
		CURLOPT_RETURNTRANSFER=>true,
		CURLOPT_ENCODING =>"",
		CURLOPT_MAXREDIRS =>10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION =>CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS =>$parmiter,));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		print_r($response);
		$someArray = json_decode($response,true);
		print_r($someArray);
	}
	public function login_3(){
		//error_reporting(0);
		header("Content-type: application/json; charset=utf-8");
		$json_url = "http://49.205.182.192:7272/hello.php";
		$ch = curl_init($json_url);
		$options = array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER => array('Content-type: application/json'),
		);
		curl_setopt_array($ch,$options);
		$result = curl_exec($ch);
		print_r($result);
	}
	public function login_1(){
		header("Content-type: application/json; charset=utf-8");
		$user_name1 = "pathak.hitesh@gmail.com";
		$password1	= "123456";
		
		$data = '{"user_name1":"'.$user_name1.'","user_password":"'.$password1.'"}';
					
		$parmiter = '{"items":['.$data.']}';
		echo $json_url = constant('api_url')."login";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $json_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
		$output = curl_exec($ch);

		curl_close($ch);

		echo $output;
		
	}
	
	// done or check 21-02-16
	public function login(){
		//error_reporting(0);
		$user_name1 = $_POST["user_name1"];
		$password1	= $_POST["password1"];
		$submit 	= "98c08565401579448aad7c64033dcb4081906dcb";
		
		header('Content-Type: application/json');
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
		}
		else{
			$ret=1;
		}
		if($ret==1)
		{
?>
{"items":[<?= $items;?>]}<?php
		}
	}
	

	public function user_account_api(){
		//error_reporting(0);
		$user_type 		= $_POST['user_type'];
		$user_altercode	= $_POST['user_altercode'];
		
		if($user_type!="" && $user_altercode!="")
		{
			$items = $this->Chemist_Model->user_account($user_type,$user_altercode);
		}
?>
{"items":[<?= $items;?>]}<?php
	}

	public function check_user_account_api(){
		//error_reporting(0);
		$user_type 		= $_POST['user_type'];
		$user_altercode	= $_POST['user_altercode'];
		
		if($user_type!="" && $user_altercode!="")
		{
			$items = $this->Chemist_Model->check_user_account($user_type,$user_altercode);
		}
?>
{"items":[<?= $items;?>]}<?php
	}

	public function update_user_account_api(){
		//error_reporting(0);
		$user_type		= $_POST['user_type'];
		$user_altercode = $_POST['user_altercode'];
		$user_phone 	= $_POST['user_phone'];
		$user_email 	= $_POST['user_email'];
		$user_address 	= $_POST['user_address'];
		
		if($user_type!="" && $user_altercode!="")
		{
			$items = $this->Chemist_Model->update_user_account($user_type,$user_altercode,$user_phone,$user_email,$user_address);
		}
?>
{"items":[<?= $items;?>]}<?php
	}

	public function user_image_upload()
	{
		//error_reporting(0);
		$items = "";
		$status = "Something Wrong";
		$status1 = 0;
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$image_path 	= $_FILES['image_path']['tmp_name'];
			$user_type 		= $_POST['user_type'];
			$user_altercode	= $_POST['user_altercode'];

			if($user_type=="chemist")
			{
				$where= array('altercode'=>$user_altercode,'slcd'=>'CL');
				$row = $this->Scheme_Model->select_row("tbl_acm",$where);
				$user_code = $row->code;
			}

			if($user_type=="sales")
			{
				$where= array('customer_code'=>$user_altercode);
				$row = $this->Scheme_Model->select_row("tbl_users",$where);
				$user_code = $row->customer_code;
			}
			
			if($user_code!="")
			{
				$img_name     = time()."_".$user_code."_".$user_type.".png";
				$user_profile = constant('img_url_site')."user_profile/$img_name";			
				move_uploaded_file($image_path,$user_profile);
				
				if($user_type=="chemist")
				{
					$status1 = $this->db->query("update tbl_acm_other set image='$img_name' where code='$user_code'");
					$status = "Updated Successfully";
					$_SESSION['user_image'] = constant('img_url_site')."user_profile/$img_name";
				}
				
				if($user_type=="sales")
				{
					$status1 = $this->db->query("update tbl_users_other set image='$img_name' where customer_code='$user_code'");
					$status = "Updated Successfully";
					$_SESSION['user_image'] = constant('img_url_site')."user_profile/$img_name";
				}
			}
		}
$items .= <<<EOD
{"status":"{$status}","status1":"{$status1}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
		?>
{"items":[<?= $items;?>]}<?php
	}

	public function check_old_password_api()
	{
		//error_reporting(0);
		$user_type		= $_POST['user_type'];
		$user_altercode = $_POST['user_altercode'];
		$old_password   = $_POST['old_password'];

		if($user_type!="" && $user_altercode!="" && $old_password!="")
		{
			$items = $this->Chemist_Model->check_old_password($user_type,$user_altercode,$old_password);
		}
?>
{"items":[<?= $items;?>]}<?php
	}

	public function change_password_api()
	{
		//error_reporting(0);
		$user_type		= $_POST['user_type'];
		$user_altercode = $_POST['user_altercode'];
		$old_password   = $_POST['old_password'];
		$new_password   = $_POST['new_password'];

		if($user_type!="" && $user_altercode!="" && $old_password!="" && $new_password!="")
		{
			$items = $this->Chemist_Model->change_password($user_type,$user_altercode,$old_password,$new_password);
		}
?>
{"items":[<?= $items;?>]}<?php
	}
	
	public function check_login_function(){
		//error_reporting(0);
		$user_type 			= $_SESSION['user_type'];
		$user_altercode		= $_SESSION['user_altercode'];
		
		/*if($user_altercode!="")
		{
			$row = $this->db->query("select id from drd_login_time where user_altercode='$user_altercode' and user_type='$user_type'")->row();
			if($row->id=="")
			{
?>
{"items":[{"count":"","status":"0","notiid":"","notititle":"","notibody":"","notitime":""}]}
<?php
			}
		}*/
	}
	
	// done or check 21-02-16
	public function main_function()
	{
		//error_reporting(0);
		/*******************website_menu_json*******************/
		$top_flash = $this->Chemist_Model->top_flash();
		$top_flash = "[$top_flash]";
		
		/*******************website_menu_json*******************/
		$top_flash2 = $this->Chemist_Model->top_flash2();
		$top_flash2 = "[$top_flash2]";
		
		
		/*******************website_menu_json*******************/
		$items0 = $this->Chemist_Model->website_menu();
		$items0 = "[$items0]";
		
		/*******************featured_brand_json******************/
		$title1 = "Our Top Brands";
		$items1 = $this->Chemist_Model->featured_brand_json();
		$items1 = "[$items1]";
		
		/**********************hot_selling_today_json************/
		$title2 = "Hot Selling Today";
		$items2 = $this->Chemist_Model->hot_selling_today_json();
		$items2 = "[$items2]";
		
		/**********************must_buy_medicines_json************/
		$title3 = "Must Buy Medicines";
		$items3 = $this->Chemist_Model->must_buy_medicines_json();
		$items3 = "[$items3]";

		/**********************short_medicines_available_now_json******/
		$title4 = "Short Medicines Available Now";
		$items4 = "";//$this->Chemist_Model->must_buy_medicines_json();
		$items4 = "[$items4]";


		/**********************new 5 number box************/
		$title5 = "New Box";
		$items5 = "";//$this->Chemist_Model->must_buy_medicines_json();
		$items5 = "[$items5]";
		/***************************************************/
$items .= <<<EOD
{"title1":"{$title1}","title2":"{$title2}","title3":"{$title3}","title4":"{$title4}","title5":"{$title5}","items0":$items0,"items1":$items1,"items2":$items2,"items3":$items3,"items4":$items4,"items5":$items5,"top_flash":$top_flash,"top_flash2":$top_flash2},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}<?php
	}

	
	// done or check 21-02-16
	public function my_orders_api(){
		//error_reporting(0);
		$user_type 		= $_POST['user_type'];
		$user_altercode	= $_POST['user_altercode'];
		$lastid1	 	= $_POST["lastid1"];
		
		if($user_type!="" && $user_altercode!="")
		{
			$items = $this->Chemist_Model->my_orders($user_type,$user_altercode,$lastid1);
		}
?>
{"items":[<?= $items;?>]}<?php
	}
	
	// done or check 21-02-16
	public function my_orders_view_api(){
		//error_reporting(0);
		$user_type 		= $_POST['user_type'];
		$user_altercode	= $_POST['user_altercode'];
		$order_id		= $_POST['order_id'];
		
		if($user_type!="" && $user_altercode!="" && $order_id!="")
		{
			$items = $this->Chemist_Model->my_orders_view($user_type,$user_altercode,$order_id);
		}
?>
{"items":[<?= $items;?>]}<?php
	}
	
	// done or check 21-02-16
	public function my_notification_api(){
		
		//error_reporting(0);
		$user_type 		= $_POST['user_type'];
		$user_altercode	= $_POST['user_altercode'];
		$lastid1	 	= $_POST["lastid1"];
		
		if($user_type!="" && $user_altercode!="")
		{
			$items = $this->Chemist_Model->my_notification($user_type,$user_altercode,$lastid1);
		}
?>
{"items":[<?= $items;?>]}<?php
	}
	
	public function my_notification_view_api(){
		//error_reporting(0);
		/*$user_type 		= $_POST['user_type'];
		$user_altercode		= $_POST['user_altercode'];*/
		$notification_id	= $_POST['notification_id'];
		
		if($notification_id!="")
		{
			$items = $this->Chemist_Model->my_notification_view($notification_id);
		}		
?>
{"items":[<?= $items;?>]}<?php
	}
	
	public function my_invoices_api(){
		
		//error_reporting(0);
		$user_type 		= $_POST['user_type'];
		$user_altercode	= $_POST['user_altercode'];
		$lastid1	 	= $_POST["lastid1"];
		
		if($user_type!="" && $user_altercode!="")
		{
			$items = $this->Chemist_Model->my_invoices($user_type,$user_altercode,$lastid1);
		}
?>
{"items":[<?= $items;?>]}<?php		
	}
	
	public function my_invoices_view_api(){
		//error_reporting(0);
		
		$user_type 		= $_POST['user_type'];
		$user_altercode	= $_POST['user_altercode'];
		$lastid1	 	= $_POST["lastid1"];
		$gstvno			= $_POST['gstvno'];
		
		if($user_type!="" && $user_altercode!="" && $gstvno!="")
		{
			$items = $this->Chemist_Model->my_invoices_view($user_type,$user_altercode,$gstvno);
		}
?>
{"items":[<?= $items;?>]}<?php
	}
	
	public function hot_deals_api(){
		//error_reporting(0);
		$user_type 		= $_SESSION['user_type'];
		$user_altercode	= $_SESSION['user_altercode'];
		
		if($user_type!="" && $user_altercode!="")
		{
			$items = $this->Chemist_Model->hot_deals($user_type,$user_altercode,$gstvno);
		}
?>
{"items":[<?= $items;?>]}<?php
	}
		
	public function draft_order_list_sales_api()
	{
		//error_reporting(0);	
		$items = "";	
		$user_altercode = $_SESSION['user_altercode'];
		$user_type 		= $_SESSION["user_type"];
		
		//$temp_rec = $this->get_temp_rec($chemist_id);
		if($user_type=="sales")
		{
			$selesman_id 	= $user_altercode;
			$query = $this->db->query("select distinct chemist_id from drd_temp_rec where selesman_id='$selesman_id' and user_type='$user_type' and status='0' order by chemist_id asc")->result();  
		}
		
		$total_price = $total_gst = $full_total = $total_qty = $total_fqty = 0;
		foreach($query as $row)
		{	
			$chemist_id = $row->chemist_id;
			$where = array('selesman_id'=>$selesman_id,'user_type'=>$user_type,'chemist_id'=>$chemist_id,'status'=>'0');
			$result = $this->Scheme_Model->select_all_result("drd_temp_rec",$where,'chemist_id','asc');
			$total = 0;
			$i = 0;
			foreach($result as $row1)
			{	
				$i++;
				$total = $total +($row1->quantity * $row1->sale_rate);
			}
			
			$total = number_format($total,2);
			
			$where = array('altercode'=>$chemist_id);
			$row1 = $this->Scheme_Model->select_row("tbl_acm",$where);
			$user_name  	= $row1->name;			
			$chemist_id 	= $row->chemist_id;
			$url 			= ($row->chemist_id);
			
			$where= array('code'=>$row1->code);
			$row1 = $this->Scheme_Model->select_row("tbl_acm_other",$where);

			$user_image = base_url()."img_v".constant('site_v')."/logo.png";
			if(!empty($row1->image))
			{
				$user_image = base_url()."user_profile/".$row1->image;
			}
			$order_items = $i;
			
$items.= <<<EOD
{"url":"{$url}","user_name":"{$user_name}","user_image":"{$user_image}","chemist_id":"{$chemist_id}","total":"{$total}","order_items":"{$order_items}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}        
?>
{"items":[<?= $items;?>]}
		<?php
	}
	
	
	public function featured_brand_api(){
		//error_reporting(0);
		$user_type 		= $_SESSION['user_type'];
		$user_altercode	= $_SESSION['user_altercode'];
		$compcode= $_POST['compcode'];
		$division= $_POST['division'];
		$orderby= $_POST['orderby'];
		
		if(constant('server_type')==0)
		{
			$items = $this->Chemist_Model->featured_brand($compcode,$division,$orderby);
?>
{"items":[<?= $items;?>]}<?php
		}
		else
		{		
			$data.= '{"user_type":"'.$user_type.'","user_altercode":"'.$user_altercode.'","compcode":"'.$compcode.'","division":"'.$division.'","orderby":"'.$orderby.'"}';
			
			
			/*if ($data != '') {
				$data = substr($data, 0, -1);
			}*/
			$parmiter = '{"items":['.$data.']}';
			
			$curl = curl_init();
			curl_setopt_array($curl, array(
			CURLOPT_URL =>constant('api_url')."api_website30/featured_brand_medicine_api",
			CURLOPT_RETURNTRANSFER=>true,
			CURLOPT_ENCODING =>"",
			CURLOPT_MAXREDIRS =>10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION =>CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS =>$parmiter,));
			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			print_r($response);
			$someArray = json_decode($response,true);
			//print_r($someArray);
			header('Content-Type: application/json');
		}
	}
	
	public function medicine_category_api(){
		//error_reporting(0);
		$itemcat		= $_POST['itemcat'];
		$orderby		= $_POST['orderby'];
		
		if($itemcat!="")
		{
			$items = $this->Chemist_Model->medicine_category($itemcat,$orderby);
?>
{"items":[<?= $items;?>]}<?php
		}
	}
}
?>