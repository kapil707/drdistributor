<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit','-1');
ini_set('post_max_size','500M');
ini_set('upload_max_filesize','500M');
ini_set('max_execution_time',36000);
class Api_mobile36 extends CI_Controller {
	
	public function create_new($page_type)
	{
		header('Content-Type: text/html');		
		error_reporting(0);
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$chemist_code 	= $_GET["chemist_code"];
			$phone_number 	= $_GET["phone_number"];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$chemist_code 	= $_POST["chemist_code"];
			$phone_number 	= $_POST["phone_number"];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
			$items = $this->Chemist_Model->create_new($chemist_code,$phone_number);
		}
?>
[<?= $items;?>]
<?php
	}
	
	public function login($page_type)
	{
		header("Content-type: application/json; charset=utf-8");
		error_reporting(0);
		if($page_type=="get")
		{
			$submit		= $_GET['submit'];
			$user_name1 = $_GET['user_name1'];
			$password1 	= $_GET['password1'];
		}
		if($page_type=="post")
		{
			$submit		= $_POST['submit'];
			$user_name1 = $_POST['user_name1'];
			$password1 	= $_POST['password1'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
			$items = $this->Chemist_Model->login($user_name1,$password1);
?>
[<?= $items;?>]
<?php
		}
	}
	
	public function logout_online($page_type)
	{
		header("Content-type: application/json; charset=utf-8");
		error_reporting(0);
		if($page_type=="get")
		{
			$submit		= $_GET['submit'];
			$device_id	= $_GET['device_id'];
			$chemist_id = $_GET['chemist_id'];
			$user_type 	= $_GET['user_type'];
		}
		if($page_type=="post")
		{
			$submit		= $_POST['submit'];
			$device_id	= $_POST['device_id'];
			$chemist_id = $_POST['chemist_id'];
			$user_type 	= $_POST['user_type'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
			$this->db->query("delete from tbl_android_device_id where device_id='$device_id' and chemist_id='$chemist_id'  and user_type='$user_type'");
		}
	}
	
	public function user_account_api($page_type)
	{
		header("Content-type: application/json; charset=utf-8");
		error_reporting(0);
		if($page_type=="get")
		{
			$user_type		= $_GET['user_type'];
			$user_altercode = $_GET['user_altercode'];
		}
		if($page_type=="post")
		{
			$user_type		= $_POST['user_type'];
			$user_altercode = $_POST['user_altercode'];
		}
		$items = $this->Chemist_Model->user_account($user_type,$user_altercode);
?>
[<?= $items;?>]
<?php
	}
	
	public function user_image_upload($page_type)
	{
		header("Content-type: application/json; charset=utf-8");
		error_reporting(0);
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$image_path 	= $_POST['image_path'];
			$user_type 		= $_POST['user_type'];
			$user_altercode	= $_POST['user_altercode'];
			$user_code 		= $_POST['user_code'];
			
			$img_name     = time().$user_code."_".$user_type.".png";
			$user_profile = "user_profile/$img_name";			
			file_put_contents($user_profile,base64_decode($image_path));
			
			if($user_type=="chemist")
			{
				$this->db->query("update tbl_acm_other set image='$img_name' where code='$user_code'");
			}
			
			if($user_type=="sales")
			{
				
			}
			
			echo base_url().$user_profile;
		}
		else{
			echo "Not Uploaded";
		}
	}
	
	public function check_user_account_api($page_type)
	{
		header("Content-type: application/json; charset=utf-8");
		error_reporting(0);
		if($page_type=="get")
		{
			$user_type		= $_GET['user_type'];
			$user_altercode = $_GET['user_altercode'];
		}
		if($page_type=="post")
		{
			$user_type		= $_POST['user_type'];
			$user_altercode = $_POST['user_altercode'];
		}		
		$items = $this->Chemist_Model->check_user_account($user_type,$user_altercode);
?>
[<?= $items;?>]
    <?php
    }
	
	public function update_user_account_api($page_type)
	{
		header("Content-type: application/json; charset=utf-8");
		error_reporting(0);
		$items = "";
		if($page_type=="get")
		{
			$user_type		= $_GET['user_type'];
			$user_altercode = $_GET['user_altercode'];
			$user_phone 	= $_GET['user_phone'];
			$user_email 	= $_GET['user_email'];
			$user_address 	= $_GET['user_address'];
		}
		if($page_type=="post")
		{
			$user_type		= $_POST['user_type'];
			$user_altercode = $_POST['user_altercode'];
			$user_phone 	= $_POST['user_phone'];
			$user_email 	= $_POST['user_email'];
			$user_address 	= $_POST['user_address'];
		}
		$items = $this->Chemist_Model->update_user_account($user_type,$user_altercode,$user_phone,$user_email,$user_address);
?>
[<?= $items;?>]
<?php
	}
	
	public function change_password_api($page_type)
	{
		header("Content-type: application/json; charset=utf-8");
		error_reporting(0);
		if($page_type=="get")
		{
			$user_type		= $_GET['user_type'];
			$user_altercode = $_GET['user_altercode'];
			$old_password 	= $_GET['old_password'];
			$new_password 	= $_GET['new_password'];
		}
		if($page_type=="post")
		{
			$user_type		= $_POST['user_type'];
			$user_altercode = $_POST['user_altercode'];
			$old_password 	= $_POST['old_password'];
			$new_password 	= $_POST['new_password'];
		}
		if($user_type!="" && $user_altercode!="" && $old_password!="" && $new_password!="")
		{
			$items = $this->Chemist_Model->change_password($user_type,$user_altercode,$old_password,$new_password);
		}
?>
[<?= $items;?>]
<?php
	}
	
	public function main_function($page_type)
	{
		header("Content-type: application/json; charset=utf-8");
		error_reporting(0);
		//https://android.drdistributor.com/android/api_mobile32/main_function/get?device_id=ok&user_type=chemist&chemist_id=v153&user_code=6000&user_password=xxx&versioncode=32&firebase_token=ok&count_medicine=0&count_draft=0&getlatitude=xx&getlongitude=xx&gettime=10&getdate=2021-10-29
		
		$items = "";
		if($page_type=="get")
		{
			$firebase_token = $_GET["firebase_token"];
			$device_id		= $_GET["device_id"];
			$user_type 		= $_GET["user_type"];
			$chemist_id		= $_GET["chemist_id"];
			$user_code		= $_GET["user_code"];
			$user_password	= $_GET["user_password"];
			$count_medicine	= $_GET["count_medicine"];
			$count_draft	= $_GET["count_draft"];
			$versioncode	= $_GET["versioncode"];
			$getlatitude	= $_GET['getlatitude'];
			$getlongitude	= $_GET['getlongitude'];
			$gettime		= $_GET['gettime'];
			$getdate		= $_GET['getdate'];
		}
		if($page_type=="post")
		{
			$firebase_token = $_POST["firebase_token"];
			$device_id		= $_POST["device_id"];
			$user_type 		= $_POST["user_type"];
			$chemist_id		= $_POST["chemist_id"];
			$user_code		= $_POST["user_code"];
			$user_password	= $_POST["user_password"];
			$count_medicine	= $_POST["count_medicine"];
			$count_draft	= $_POST["count_draft"];
			$versioncode	= $_POST["versioncode"];
			$getlatitude	= $_POST['getlatitude'];
			$getlongitude	= $_POST['getlongitude'];
			$gettime		= $_POST['gettime'];
			$getdate		= $_POST['getdate'];
		}
		if($device_id!="")
		{
			$time			= time();
			$date			= date("Y-m-d");
			$datetime 		= time();
			$timei 			= date("i",$time);
			$timef  		= date("H:i",$time);
			
			$where1= array('device_id'=>$device_id,);
			$row = $this->Scheme_Model->select_row("tbl_android_device_id",$where1);
			$ratingbar = 1;
			if(empty($row->id))
			{
				$dt = array(
				'firebase_token'=>$firebase_token,
				'device_id'=>$device_id,
				'user_type'=>$user_type,
				'chemist_id'=>$chemist_id,
				'versioncode'=>$versioncode,
				'time'=>$time,
				'date'=>$date,
				'count_medicine'=>$count_medicine,
				'count_draft'=>$count_draft,
				'ratingbar'=>$ratingbar,
				'getlatitude'=>$getlatitude,
				'getlongitude'=>$getlongitude,
				'gettime'=>$gettime,
				'getdate'=>$getdate,
				);
				$this->Scheme_Model->insert_fun("tbl_android_device_id",$dt);
			}
			else
			{
				$ratingbar = $row->ratingbar;
				$ratingbar++;
				
				$dt = array(
				'firebase_token'=>$firebase_token,
				'device_id'=>$device_id,
				'user_type'=>$user_type,
				'chemist_id'=>$chemist_id,
				'versioncode'=>$versioncode,
				'time'=>$time,
				'date'=>$date,
				'count_medicine'=>$count_medicine,
				'count_draft'=>$count_draft,
				'ratingbar'=>$ratingbar,
				'getlatitude'=>$getlatitude,
				'getlongitude'=>$getlongitude,
				'gettime'=>$gettime,
				'getdate'=>$getdate,
				);
				$where = array('device_id'=>$device_id);
				$this->Scheme_Model->edit_fun("tbl_android_device_id",$dt,$where);
			}
			
			/*****ratingbarpage open hota ha iss code say ****/
			$ratingbarpage = 0;
			if(!empty($row->id))
			{
				if($row->ratingbar%10==0)
				{
					if($row->rating=="0")
					{
						$ratingbarpage = 1;
					}
				}
			}
			
			/********************************************************************/
			$logout = $clear_database = 0;
			if(!empty($row->id))
			{
				/*****versioncode same nahi ha to database clear ****/
				if($versioncode!=$row->versioncode)
				{
					$clear_database = 1;
				}				
				/*****admin say clear database karay to ****/
				if($row->clear_database==1)
				{
					$clear_database = $row->clear_database;
				}				
				/***************database clear ki command di ha to********************/
				if($clear_database==1)
				{
					$this->db->query("update tbl_android_device_id set clear_database='0' where device_id='$device_id'");
				}
				/***************logout ki command di ha to********************/
				if($row->logout==1)
				{
					$logout = 1;
					$this->db->query("update tbl_android_device_id set logout='0' where device_id='$device_id'");
				}
			}

			/***************broadcast message********************/
			$broadcast_status = $this->Scheme_Model->get_website_data("broadcast_status");
			$broadcast = $broadcast_title = "";
			if($broadcast_status=="1")
			{
				$broadcast_title = $this->Scheme_Model->get_website_data("broadcast_title");
				$broadcast = $this->Scheme_Model->get_website_data("broadcast_message");

				$broadcast_title = base64_encode($broadcast_title);
				$broadcast = base64_encode($broadcast);
			}
			
			/***************versioncode kya ha wo yaha say ata ha********************/
			$android_versioncode 	= $this->Scheme_Model->get_website_data("android_versioncode");
			
			
			/*****************update ke liya code*********************/
			$force_update 			= $this->Scheme_Model->get_website_data("force_update");
			$force_update_title 	= $this->Scheme_Model->get_website_data("force_update_title");
			$force_update_message	= $this->Scheme_Model->get_website_data("force_update_message");			
			$force_update_title 	= base64_encode($force_update_title);
			$force_update_message 	= base64_encode($force_update_message);
			
			/************mobile no or email aty h**************************/
			$android_mobile 		= $this->Scheme_Model->get_website_data("android_mobile");
			$android_email 			= $this->Scheme_Model->get_website_data("android_email");
			$android_whatsapp 		= $this->Scheme_Model->get_website_data("android_whatsapp");
			
			/************notificaion ke status ata ha**************************/
			$android_noti = 0;
			if($user_type == "chemist")
			{
				$where1= array('user_type'=>$user_type,'chemist_id'=>$chemist_id,'status'=>'0',);
				$row = $this->Scheme_Model->select_row("tbl_android_notification",$where1);
				if(!empty($row->id))
				{
					$android_noti = 1;
				}
			}
			
			/*******************website_menu_json*******************/
			$items0 = $this->Chemist_Model->website_menu_json_new();
			$items0 = "[$items0]";
			
			/*******************featured_brand_json******************/
			$title1 = "Our top brands";
			$items1 = $this->Chemist_Model->featured_brand_json_new();
			$items1 = "[$items1]";
			
			/**********************hot_selling_today_json************/
			$title2 = "New arrivals";
			$items2 = $this->Chemist_Model->new_medicine_this_month_json_new();
			$items2 = "[$items2]";
			
			/**********************must_buy_medicines_json************/
			$title3 = "Hot selling";
			$items3 = $this->Chemist_Model->hot_selling_today_json_new();
			$items3 = "[$items3]";

			/**********************short_medicines_available_now_json******/
			$title4 = "Must buy";
			$items4 = $this->Chemist_Model->must_buy_medicines_json();
			$items4 = "[$items4]";

			/**********************new 5 number box************/
			$title5 = "Frequently use";//"Short medicines available now";
			$items5 = $this->Chemist_Model->frequently_use_medicines_json();
			$items5 = "[$items5]";
			/***************************************************/
			
			/***************Under Construction**********************/
			$under_construction = $this->Scheme_Model->get_website_data("under_construction");
			$under_construction_message = "";
			if($under_construction == 1)
			{
				$under_construction_message = "Android App Under Construction";
			}
			$under_construction_message = base64_encode($under_construction_message);
			
$items .= <<<EOD
{"logout":"{$logout}","clear_database":"{$clear_database}","broadcast_title":"{$broadcast_title}","broadcast":"{$broadcast}","android_versioncode":"{$android_versioncode}","force_update":"{$force_update}","force_update_title":"{$force_update_title}","force_update_message":"{$force_update_message}","under_construction":"{$under_construction}","under_construction_message":"{$under_construction_message}","ratingbarpage":"{$ratingbarpage}","android_mobile":"{$android_mobile}","android_email":"{$android_email}","android_whatsapp":"{$android_whatsapp}","android_noti":"{$android_noti}","title1":"{$title1}","title2":"{$title2}","title3":"{$title3}","title4":"{$title4}","title5":"{$title5}","items0":$items0,"items1":$items1,"items2":$items2,"items3":$items3,"items4":$items4,"items5":$items5},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
		}
?>
[<?= $items;?>]
<?php
	}
	
	public function user_location_services($page_type)
	{
		header("Content-type: application/json; charset=utf-8");
		if($page_type=="get")
		{
			$device_id 		= $_GET["device_id"];
			$gettime 		= $_GET["gettime"];
			$getdate 		= $_GET["getdate"];
			$getlatitude 	= $_GET["getlatitude"];
			$getlongitude 	= $_GET["getlongitude"];
		}
		if($page_type=="post")
		{
			$device_id 		= $_POST["device_id"];
			$gettime 		= $_POST["gettime"];
			$getdate 		= $_POST["getdate"];
			$getlatitude 	= $_POST["getlatitude"];
			$getlongitude 	= $_POST["getlongitude"];
		}
		if($device_id!="")
		{
			//$this->db->query("update tbl_android_device_id set gettime='$gettime',getdate='$getdate',getlatitude='$getlatitude',getlongitude='$getlongitude' where device_id='$device_id'");
		}
	}
		
	public function search_chemist($page_type)
	{
		header("Content-type: application/json; charset=utf-8");
		error_reporting(0);
		$items = "";
		$session_id = "ok";
		if($page_type=="get")
		{
			$keyword 		= $_GET["keyword"];
		}
		if($page_type=="post")
		{
			$keyword 		= $_POST["keyword"];
		}
		if($session_id!="")
		{
			$items = $this->Chemist_Model->search_chemist($keyword);
?>
[<?= $items;?>]
<?php
		}
	}
	
	public function search_medicine($page_type)
	{
		header("Content-type: application/json; charset=utf-8");
		error_reporting(0);
		$items = "";
		$date_time = date('d-M h:i A');
		$session_id = $_REQUEST["session_id"] = "ok";
		if($page_type=="get")
		{
			$keyword 	= $_GET["keyword"];
		}
		if($page_type=="post")
		{
			$keyword 	= $_POST["keyword"];
		}
		if($keyword!="")
		{			
			$items = $this->Chemist_Model->search_medicine2($keyword);
		}
?>
[<?= $items;?>]
<?php
	}
	
	public function get_single_medicine_info($page_type)
	{
		error_reporting(0);
		if($page_type=="get")
		{
			$i_code 		= $_GET["i_code"];
			$chemist_id 	= $_GET["chemist_id"];
			$selesman_id 	= $_GET["selesman_id"];
			$user_type 		= $_GET["user_type"];
		}
		if($page_type=="post")
		{
			$i_code 		= $_POST["i_code"];
			$chemist_id 	= $_POST["chemist_id"];
			$selesman_id 	= $_POST["selesman_id"];
			$user_type 		= $_POST["user_type"];
		}
		$session_id = "ok";
		if($session_id!="")
		{
			$items = $this->Chemist_Model->get_single_medicine_info($i_code,$chemist_id,$selesman_id,$user_type);
?>
[<?= $items;?>]
<?php
		}
	}

	public function get_single_medicine_info_new($page_type)
	{
		error_reporting(0);
		if($page_type=="get")
		{
			$i_code 		= $_GET["i_code"];
			$chemist_id 	= $_GET["chemist_id"];
			$selesman_id 	= $_GET["selesman_id"];
			$user_type 		= $_GET["user_type"];
		}
		if($page_type=="post")
		{
			$i_code 		= $_POST["i_code"];
			$chemist_id 	= $_POST["chemist_id"];
			$selesman_id 	= $_POST["selesman_id"];
			$user_type 		= $_POST["user_type"];
		}
		$session_id = "ok";
		if($session_id!="")
		{
			$items = $this->Chemist_Model->get_single_medicine_info_new($i_code,$chemist_id,$selesman_id,$user_type);
?>
[<?= $items;?>]
<?php
		}
	}
	
	public function insert_temp_order($page_type)
	{
		header("Content-type: application/json; charset=utf-8");
		error_reporting(0);
		$items = "";
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$device_id		= $_GET['device_id'];
			$i_code 		= $_GET['i_code'];
			$quantity 		= $_GET['quantity'];
			$item_name 		= $_GET['item_name'];
			$sale_rate 		= $_GET['sale_rate'];
			$scheme 		= $_GET['scheme'];
			$chemist_id 	= $_GET['chemist_id'];
			$selesman_id 	= $_GET['selesman_id'];
			$user_type 		= $_GET['user_type'];
			$mobilenumber 	= $_GET['mobilenumber'];
			$modalnumber 	= $_GET['modalnumber'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$device_id		= $_POST['device_id'];
			$i_code 		= $_POST['i_code'];
			$quantity 		= $_POST['quantity'];
			$item_name 		= $_POST['item_name'];
			$sale_rate 		= $_POST['sale_rate'];
			$scheme 		= $_POST['scheme'];
			$chemist_id 	= $_POST['chemist_id'];
			$selesman_id 	= $_POST['selesman_id'];
			$user_type 		= $_POST['user_type'];
			$mobilenumber 	= $_POST['mobilenumber'];
			$modalnumber 	= $_POST['modalnumber'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
			$time = time();
			$date = date("Y-m-d",$time);
			$datetime = date("d-M-y H:i",$time);
			
			if($user_type=="sales")
			{
				$temp_rec = $user_type."_".$selesman_id."_".$chemist_id;				
			}
			else
			{
				$temp_rec = $user_type."_".$chemist_id;
			}
			
			$where = array('chemist_id'=>$chemist_id,'selesman_id'=>$selesman_id,'user_type'=>$user_type,'i_code'=>$i_code,'status'=>'0');
			$row = $this->Scheme_Model->select_row("drd_temp_rec",$where);

			$get_medicine_image	= 	$this->Chemist_Model->get_medicine_image($i_code);
			$image1 = $get_medicine_image[0];
			if($image1=="")
			{
				$image1 = "http://drdmail.xyz/uploads/newok.jpg";
			}
			
			$where = array('i_code'=>$i_code);
			$row1 = $this->Scheme_Model->select_row("tbl_medicine",$where);

			$order_type = "Android";
			
			$dt = array(
				'i_code'=>$i_code,
				'quantity'=>$quantity,
				
				'item_name'=>$item_name,
				'packing'=>$row1->packing,
				'expiry'=>$row1->expiry,
				'company_full_name'=>$row1->company_full_name,
				'sale_rate'=>$sale_rate,
				'scheme'=>$scheme,
				'image'=>$image1,

				'chemist_id'=>$chemist_id,
				'selesman_id'=>$selesman_id,
				'user_type'=>$user_type,
				'date'=>$date,
				'time'=>$time,
				'datetime'=>$datetime,
				'temp_rec'=>$temp_rec,
				'order_type'=>$order_type,
				'mobilenumber'=>$mobilenumber,
				'modalnumber'=>$modalnumber,
				'device_id'=>$device_id,
				);
			
			if($row->id=="")
			{
				$query = $this->Scheme_Model->insert_fun("drd_temp_rec",$dt);
			}
			else
			{
				$where1 = array('chemist_id'=>$chemist_id,'selesman_id'=>$selesman_id,'user_type'=>$user_type,'i_code'=>$i_code,'status'=>'0');
				$query = $this->Scheme_Model->edit_fun("drd_temp_rec",$dt,$where1);
			}
$items.= <<<EOD
{"i_code":"{$i_code}","datetime":"{$datetime}","modalnumber":"{$modalnumber}","chemist_id":"{$chemist_id}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
[<?= $items;?>]
<?php
		}
	}
	
	public function get_online_cart($page_type)
	{
		//https://android.drdistributor.com/android/Api_mobile32/get_online_cart/get?submit=98c08565401579448aad7c64033dcb4081906dcb&device_id=ab00b9ef610a4fa5&chemist_id=v153&selesman_id=&user_type=chemist&user_password=xxx
		header("Content-type: application/json; charset=utf-8");
		error_reporting(0);
		$items = "";
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$device_id		= $_GET['device_id'];
			$chemist_id 	= $_GET['chemist_id'];
			$selesman_id 	= $_GET['selesman_id'];
			$user_type 		= $_GET['user_type'];
			$user_password 	= $_GET['user_password'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$device_id		= $_POST['device_id'];
			$chemist_id 	= $_POST['chemist_id'];
			$selesman_id 	= $_POST['selesman_id'];
			$user_type 		= $_POST['user_type'];
			$user_password 	= $_POST['user_password'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		//iss query say button visble or disble hota ha plceorder ka
		$place_order_btn = $this->Order_Model->get_total_price_of_order($selesman_id,$chemist_id,$user_type,$user_password);
		$place_order_button  = $place_order_btn[0];
		$place_order_message = $place_order_btn[1];
		$place_order_message = base64_encode($place_order_message);
		if($submit==$submit1)
		{
			$where = array('chemist_id'=>$chemist_id,'selesman_id'=>$selesman_id,'user_type'=>$user_type,'status'=>'0');
			$query = $this->Scheme_Model->select_all_result("drd_temp_rec",$where);
			foreach($query as $row)
			{
				$i_code 		= $row->i_code;
				$quantity		= $row->quantity;
				$datetime		= $row->datetime;
				$modalnumber	= $row->modalnumber;
				$chemist_id	    = $row->chemist_id;
			
$items.= <<<EOD
{"i_code":"{$i_code}","quantity":"{$quantity}","datetime":"{$datetime}","modalnumber":"{$modalnumber}","chemist_id":"{$chemist_id}","place_order_button":"{$place_order_button}","place_order_message":"{$place_order_message}"},
EOD;
			}
			if($i_code=="")
			{
				// jab cart empty ha to
				$i_code = 0;
				$quantity = 0;
$items .= <<<EOD
{"i_code":"{$i_code}","quantity":"{$quantity}","datetime":"{$datetime}","modalnumber":"{$modalnumber}","chemist_id":"{$chemist_id}","place_order_button":"{$place_order_button}","place_order_message":"{$place_order_message}"},
EOD;
			}
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
[<?= $items;?>]
<?php
		}
	}
	
	// yha sirf home page ke liya ha jab sales man say login ho to chimist id uper say he aya ge
	public function get_online_cart2($page_type) 
	{
		header("Content-type: application/json; charset=utf-8");
		error_reporting(0);
		$items = "";
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$device_id		= $_GET['device_id'];
			$chemist_id 	= $_GET['chemist_id'];
			$user_type 		= $_GET['user_type'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$device_id		= $_POST['device_id'];
			$chemist_id 	= $_POST['chemist_id'];
			$user_type 		= $_POST['user_type'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
			if($user_type=="sales")
			{
				$where = array('selesman_id'=>$chemist_id,'user_type'=>$user_type,'status'=>'0');
			}
			else{
				$where = array('chemist_id'=>$chemist_id,'user_type'=>$user_type,'status'=>'0');
			}
			$query = $this->Scheme_Model->select_all_result("drd_temp_rec",$where);
			foreach($query as $row)
			{
				$i_code 		= $row->i_code;
				$quantity		= $row->quantity;
				$datetime		= $row->datetime;
				$modalnumber	= $row->modalnumber;
				$chemist_id	    = $row->chemist_id;
		
$items .= <<<EOD
{"i_code":"{$i_code}","quantity":"{$quantity}","datetime":"{$datetime}","modalnumber":"{$modalnumber}","chemist_id":"{$chemist_id}"},
EOD;
			}
			if($i_code=="")
			{
				// jab cart empty ha to
				$i_code = 0;
				$quantity = 0;
$items .= <<<EOD
{"i_code":"{$i_code}","quantity":"{$quantity}","datetime":"{$datetime}","modalnumber":"{$modalnumber}","chemist_id":"{$chemist_id}"},
EOD;
			}
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
[<?= $items;?>]
<?php
		}
	}
	
	public function download_cart_chemist($page_type)
	{
		header("Content-type: application/json; charset=utf-8");
		error_reporting(0);
		$items = "";
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$chemist_id 	= $_GET['chemist_id'];
			$user_type 		= $_GET['user_type'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$chemist_id 	= $_POST['chemist_id'];
			$user_type 		= $_POST['user_type'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
			$selesman_id = $chemist_id;
			$query = $this->db->query("select distinct chemist_id from drd_temp_rec where selesman_id='$selesman_id' and user_type='$user_type' and status='0' order by chemist_id asc")->result(); 
			foreach($query as $row)
			{
				$where 	= array('altercode'=>$row->chemist_id);
				$row1 	= $this->Scheme_Model->select_row("tbl_acm",$where);
				$id 	= $row1->id;
				$name 	= $row1->name;
				$code 	= $row1->code;
				$altercode = $row1->altercode;
				
				$where2 = array('code'=>$row1->code);
				$row2   = $this->Scheme_Model->select_row("tbl_acm_other",$where2);
				$image	=	"http://drdistributor.com/img_v31/logo.png";	
				if($row2->image!="")
				{
					$image = base_url()."user_profile/".$row2->image;
				}
				
$items .= <<<EOD
{"id":"{$id}","name":"{$name}","code":"{$code}","altercode":"{$altercode}","image":"{$image}"},
EOD;
			}
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
[<?= $items;?>]
<?php
		}
	}
	
	public function delete_temp_order($page_type)
	{
		header("Content-type: application/json; charset=utf-8");
		error_reporting(0);
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$i_code 		= $_GET['i_code'];
			$device_id		= $_GET['device_id'];
			$chemist_id 	= $_GET['chemist_id'];
			$selesman_id 	= $_GET['selesman_id'];
			$user_type 		= $_GET['user_type'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$i_code 		= $_POST['i_code'];
			$device_id		= $_POST['device_id'];
			$chemist_id 	= $_POST['chemist_id'];
			$selesman_id 	= $_POST['selesman_id'];
			$user_type 		= $_POST['user_type'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
			$where = array('chemist_id'=>$chemist_id,'selesman_id'=>$selesman_id,'user_type'=>$user_type,'i_code'=>$i_code,'status'=>'0');
			$query = $this->Scheme_Model->delete_fun("drd_temp_rec",$where);
			
			$result = "0";
			if($query)
			{
				$result = "1";
			}
			
$items .= <<<EOD
{"result":"{$result}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
[<?= $items;?>]
<?php
		}
	}
	
	public function deleteall_temp_order($page_type)
	{
		header("Content-type: application/json; charset=utf-8");
		error_reporting(0);
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$i_code 		= $_GET['i_code'];
			$device_id		= $_GET['device_id'];
			$chemist_id 	= $_GET['chemist_id'];
			$selesman_id 	= $_GET['selesman_id'];
			$user_type 		= $_GET['user_type'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$i_code 		= $_POST['i_code'];
			$device_id		= $_POST['device_id'];
			$chemist_id 	= $_POST['chemist_id'];
			$selesman_id 	= $_POST['selesman_id'];
			$user_type 		= $_POST['user_type'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
			$where = array('chemist_id'=>$chemist_id,'selesman_id'=>$selesman_id,'user_type'=>$user_type,'status'=>'0');
			$query = $this->Scheme_Model->delete_fun("drd_temp_rec",$where);
			
			$result = "0";
			if($query)
			{
				$result = "1";
			}
			
$items .= <<<EOD
{"result":"{$result}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
[<?= $items;?>]
<?php
		}
	}
	
	public function save_order_to_server($page_type)
	{
		header("Content-type: application/json; charset=utf-8");
		error_reporting(0);
		$items = "";
		if($page_type=="get")
		{			
			$submit			= $_GET['submit'];
			$chemist_id 	= $_GET['chemist_id'];
			$selesman_id 	= $_GET['selesman_id'];
			$user_type 		= $_GET['user_type'];			
			$user_password 	= $_GET["user_password"];
			$remarks 		= $_GET["remarks"];
			
			$latitude		= $_GET["latitude"];
			$longitude		= $_GET["longitude"];
			$mobilenumber	= $_GET["mobilenumber"];
			$modalnumber	= $_GET["modalnumber"];
			$device_id		= $_GET["device_id"];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$chemist_id 	= $_POST['chemist_id'];
			$selesman_id 	= $_POST['selesman_id'];
			$user_type 		= $_POST['user_type'];
			$user_password 	= $_POST["user_password"];
			$remarks 		= $_POST["remarks"];
			
			$latitude		= $_POST["latitude"];
			$longitude		= $_POST["longitude"];
			$mobilenumber	= $_POST["mobilenumber"];
			$modalnumber	= $_POST["modalnumber"];
			$device_id		= $_POST["device_id"];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{			
			$slice_type		= "";
			$slice_item		= "";

			$status = $this->Order_Model->save_order_to_server("Android",$slice_type,$slice_item,$remarks,$selesman_id,$chemist_id,$user_type,$user_password,$latitude,$longitude,$mobilenumber,$modalnumber,$device_id);
			$order_success = $status[0];
			$place_order_message = base64_encode($status[1]);			
$items .= <<<EOD
{"order_success":"{$order_success}","device_id":"{$device_id}","chemist_id":"{$chemist_id}","selesman_id":"{$selesman_id}","user_type":"{$user_type}","place_order_message":"{$place_order_message}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
[<?= $items;?>]
<?php
		}
	}
	
	/*********************html part ke liya sirf*************/
	public function my_orders_api()
	{
		header("Content-type: application/json; charset=utf-8");
		error_reporting(0);
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
	
	public function my_orders_view_api()
	{
		header("Content-type: application/json; charset=utf-8");
		error_reporting(0);
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
	
	public function my_notification_api()
	{
		header("Content-type: application/json; charset=utf-8");
		error_reporting(0);
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
	
	public function my_notification_view_api()
	{
		header("Content-type: application/json; charset=utf-8");
		error_reporting(0);
		$notification_id    = $_POST['notification_id'];
		if($notification_id!="")
		{
			$items = $this->Chemist_Model->my_notification_view($notification_id);
		}
?>
{"items":[<?= $items;?>]}<?php
	}
	
	public function my_invoices_api()
	{
		header("Content-type: application/json; charset=utf-8");
		error_reporting(0);
		$user_type 		= $_POST['user_type'];
		$user_altercode	= $_POST['user_altercode'];
		$lastid1	 	= $_POST["lastid1"];
		$items = $this->Chemist_Model->my_invoices($user_type,$user_altercode,$lastid1)
?>
{"items":[<?= $items;?>]}<?php
	}
	
	public function my_invoices_view()
	{
		header("Content-type: application/json; charset=utf-8");
		error_reporting(0);
		$user_type	 	= $_POST["user_type"];
		$user_altercode	= $_POST["user_altercode"];
		$gstvno	 		= $_POST["gstvno"];
		$items = $this->Chemist_Model->my_invoices_view($user_type,$user_altercode,$lastid1,$gstvno);
?>
{"items":[<?= $items;?>]}<?php
	}
	
	public function ratingbar_done($page_type)
	{
		header("Content-type: application/json; charset=utf-8");
		error_reporting(0);
		if($page_type=="get")
		{
			$device_id	= $_GET['device_id'];
			$rating 	= $_GET['rating'];
		}
		if($page_type=="post")
		{
			$device_id	= $_POST['device_id'];
			$rating 	= $_POST['rating'];
		}
		if($device_id)
		{
			$this->db->query("update tbl_android_device_id set rating='$rating' where device_id='$device_id'");
		}
	}
	
	public function ratingbar_review($page_type)
	{
		header("Content-type: application/json; charset=utf-8");
		error_reporting(0);
		if($page_type=="get")
		{
			$device_id	= $_GET['device_id'];
			$review 	= $_GET['review'];
		}
		if($page_type=="post")
		{
			$device_id	= $_POST['device_id'];
			$review 	= $_POST['review'];
		}
		if($device_id)
		{
			$this->db->query("update tbl_android_device_id set review='$review' where device_id='$device_id'");
			echo "Thank You To Sending Your Rating & Review.";
		}
	}
	
	public function featured_brand($page_type)
	{
		error_reporting(0);
		if($page_type=="get")
		{
			$compcode 		= $_GET["compcode"];
			$division 		= $_GET["division"];
			$orderby 		= $_GET["orderby"];
		}
		if($page_type=="post")
		{
			$compcode 		= $_POST["compcode"];
			$division 		= $_POST["division"];
			$orderby 		= $_POST["orderby"];
		}
		$session_id = "ok";
		if($session_id!="")
		{
			$items = $this->Chemist_Model->featured_brand($compcode,$division,$orderby);
?>
[<?= $items;?>]
<?php
		}
	}
	
	public function medicine_category($page_type)
	{
		error_reporting(0);
		if($page_type=="get")
		{
			$itemcat 		= $_GET["compcode"];
			$orderby 		= $_GET["orderby"];
		}
		if($page_type=="post")
		{
			$itemcat 		= $_POST["compcode"];
			$orderby 		= $_POST["orderby"];
		}
		$session_id = "ok";
		if($session_id!="")
		{
			$items = $this->Chemist_Model->medicine_category($itemcat,$orderby);
?>
[<?= $items;?>]
<?php
		}
	}
	
	public function track_my_order($page_type)
	{
		error_reporting(0);
		$items = "";
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$user_altercode	= $_GET['user_altercode'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$user_altercode	= $_POST['user_altercode'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
			/*$page_off 		= "2";
			$page_msg 		= "Thank you for ordering";
			$page_msg1 		= "Sit back and relax, Your Order will reach you on time.";
			$latitude 		= "28.5183163";
			$longitude 		= "77.279475";
			$biker_name		= "DR. Distributor";
			$biker_mobile	= "";
			$biker_image	= "";*/
			
			$where = array('chemist_id'=>$user_altercode);
			$row = $this->Scheme_Model->select_row("tbl_deliverby",$where);
			if($row->deliverby_altercode=="")
			{
				$page_off 		= "1";
				$page_msg 		= "You have not placed any order today.";
				$page_msg1 		= "Add your medicine and order now.";
				$latitude 		= "28.5183163";
				$longitude 		= "77.279475";
				$biker_name		= "DR. Distributor";
				$biker_mobile	= "";
				$biker_image	= "";
			}
			else
			{
				$where1 = array('altercode'=>$row->deliverby_altercode,'slcd'=>'SM',);
				$row1 = $this->Scheme_Model->select_row("tbl_master",$where1);

				$where2 = array('code'=>$row1->code);
				$row2 = $this->Scheme_Model->select_row("tbl_master_other",$where2);

				$page_off 		= "0";
				$page_msg 		= "Your order is on the way";
				$page_msg1 		= "Track your order on the map above, or call if needed.";
				$user_session 	= $row1->id;
				$latitude 		= $row2->latitude;
				$longitude 		= $row2->longitude;
				$biker_name		= trim($row1->name);
				$biker_mobile	= $row1->telephone;
				$biker_image	= "";
				
				if($latitude=="")
				{
					$latitude 		= "28.5183163";
					$longitude 		= "77.279475";
				}
			}
			
$items .= <<<EOD
{"user_session":"{$user_session}","latitude":"{$latitude}","longitude":"{$longitude}","page_off":"{$page_off}","page_msg":"{$page_msg}","page_msg1":"{$page_msg1}","biker_name":"{$biker_name}","biker_mobile":"{$biker_mobile}","biker_image":"{$biker_image}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
[<?= $items;?>]
<?php
		}
	}
}