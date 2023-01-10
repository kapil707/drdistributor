<?php 
header("Content-type: application/json; charset=utf-8");
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit','-1');
ini_set('post_max_size','500M');
ini_set('upload_max_filesize','500M');
ini_set('max_execution_time',36000);
class Api_mobile41 extends CI_Controller {	
	public function create_new($page_type)
	{
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
	public function otp_resent_api($page_type)
	{
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$user_altercode = $_GET['user_altercode'];
			$user_password 	= $_GET['user_password'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$user_altercode = $_POST['user_altercode'];
			$user_password 	= $_POST['user_password'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
			$items = $this->Chemist_Model->otp_resent($user_altercode);
?>
[<?= $items;?>]
<?php
		}
	}
	public function login($page_type)
	{
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$user_altercode = $_GET['user_altercode'];
			$user_password 	= $_GET['user_password'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$user_altercode = $_POST['user_altercode'];
			$user_password 	= $_POST['user_password'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
			$items = $this->Chemist_Model->login($user_altercode,$user_password);
?>
[<?= $items;?>]
<?php
		}
	}
	
	public function logout_online($page_type)
	{
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
	
	public function new_user_account_api($page_type)
	{
		$items = "";
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$user_type		= $_GET['user_type'];
			$user_altercode = $_GET['user_altercode'];
			$user_password 	= $_GET['user_password'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$user_type		= $_POST['user_type'];
			$user_altercode = $_POST['user_altercode'];
			$user_password 	= $_POST['user_password'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
			if($user_type!="" && $user_altercode!="")
			{
				$items = $this->Chemist_Model->user_account($user_type,$user_altercode);
			}
		}
?>
[{"items":[<?= $items;?>]}]<?php
	}
	
	public function user_image_upload($page_type)
	{
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
			
			echo base_url().$user_profile;
		}
		else{
			echo "Not Uploaded";
		}
	}
	
	public function check_user_account_api($page_type)
	{
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
	
	public function home_page_api($page_type)
	{
		//https://drdistributor.com/new_api/api_mobile41/home_page_api/get?submit=98c08565401579448aad7c64033dcb4081906dcb&device_id=ok&user_altercode=v153&user_password=123123123&user_type=chemist&versioncode=32&firebase_token=ok&count_medicine=0&count_draft=0&getlatitude=xx&getlongitude=xx&gettime=10&getdate=2021-10-292021-10-29
		
		$items = "";
		if($page_type=="get")
		{
			$submit 		= $_GET["submit"];
			$phone_type 	= $_GET["phone_type"];
			$firebase_token = $_GET["firebase_token"];
			$device_id		= $_GET["device_id"];
			$user_type 		= $_GET["user_type"];
			$user_altercode	= $_GET["user_altercode"];
			$user_password	= $_GET["user_password"];
			$chemist_id		= $_GET["chemist_id"];

			$versioncode	= $_GET["versioncode"];
			$getlatitude	= $_GET['getlatitude'];
			$getlongitude	= $_GET['getlongitude'];
			$gettime		= $_GET['gettime'];
			$getdate		= $_GET['getdate'];
		}
		if($page_type=="post")
		{
			$submit 		= $_POST["submit"];
			$phone_type 	= $_POST["phone_type"];
			$firebase_token = $_POST["firebase_token"];
			$device_id		= $_POST["device_id"];
			$user_type 		= $_POST["user_type"];
			$user_altercode	= $_POST["user_altercode"];
			$user_password	= $_POST["user_password"];
			$chemist_id		= $_POST["chemist_id"];
			
			$versioncode	= $_POST["versioncode"];
			$getlatitude	= $_POST['getlatitude'];
			$getlongitude	= $_POST['getlongitude'];
			$gettime		= $_POST['gettime'];
			$getdate		= $_POST['getdate'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
			$login = $this->Chemist_Model->login($user_altercode,$user_password);

			$time			= time();
			$date			= date("Y-m-d");
			
			$where1= array('firebase_token'=>$firebase_token,'chemist_id'=>$user_altercode,'user_type'=>$user_type,);
			$row = $this->Scheme_Model->select_row("tbl_android_device_id",$where1);
			$ratingbar = 1;
			if(empty($row->id))
			{
				$dt = array(
				'firebase_token'=>$firebase_token,
				'device_id'=>$device_id,
				'user_type'=>$user_type,
				'chemist_id'=>$user_altercode,
				'versioncode'=>$versioncode,
				'time'=>$time,
				'date'=>$date,
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
				'chemist_id'=>$user_altercode,
				'versioncode'=>$versioncode,
				'time'=>$time,
				'date'=>$date,
				'ratingbar'=>$ratingbar,
				'getlatitude'=>$getlatitude,
				'getlongitude'=>$getlongitude,
				'gettime'=>$gettime,
				'getdate'=>$getdate,
				);
				$where = array('firebase_token'=>$firebase_token,'chemist_id'=>$user_altercode,'user_type'=>$user_type,);
				$this->db->update("tbl_android_device_id",$dt,$where);
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
			$versioncode 	= $this->Scheme_Model->get_website_data("android_versioncode");
			
			
			/*****************update ke liya code*********************/
			$force_update 			= $this->Scheme_Model->get_website_data("force_update");
			$force_update_title 	= $this->Scheme_Model->get_website_data("force_update_title");
			$force_update_message	= $this->Scheme_Model->get_website_data("force_update_message");			
			$force_update_title 	= base64_encode($force_update_title);
			$force_update_message 	= base64_encode($force_update_message);			
						
			/************notificaion ke status ata ha**************************/
			$android_noti = 0;
			if($user_type == "chemist")
			{
				$where1= array('user_type'=>$user_type,'chemist_id'=>$user_altercode,'status'=>'0',);
				$row = $this->Scheme_Model->select_row("tbl_android_notification",$where1);
				if(!empty($row->id))
				{
					$android_noti = 1;
				}
			}
			
			/*******************website_menu_json*******************/
			$menu_json = $this->Chemist_Model->website_menu_json_new();
			$menu_json = "[$menu_json]";
			
			/*******************featured_brand_json******************/
			$medicine_title0 = "Our top brands";
			$medicine_json0 = $this->Chemist_Model->featured_brand_json_new();
			$medicine_json0 = "[$medicine_json0]";
			
			/**********************hot_selling_today_json************/
			$medicine_json1 = $this->Chemist_Model->new_medicine_this_month_json_new();
			$medicine_json1 = "[$medicine_json1]";
			
			/**********************must_buy_medicines_json************/
			$medicine_json2 = $this->Chemist_Model->hot_selling_today_json_new();
			$medicine_json2 = "[$medicine_json2]";

			/**********************short_medicines_available_now_json******/
			$medicine_json3 = $this->Chemist_Model->must_buy_medicines_json_new();
			$medicine_json3 = "[$medicine_json3]";

			/**********************new 5 number box************/
			$medicine_json4 = $this->Chemist_Model->frequently_use_medicines_json_new();
			$medicine_json4 = "[$medicine_json4]";
			/***************************************************/

			/**********************new 5 number box************/
			$medicine_json5 = $this->Chemist_Model->stock_now_available();
			$medicine_json5 = "[$medicine_json5]";
			/***************************************************/

			/**********************new 6 number box************/
			$salesman_id = "";
			if($user_type=="sales")
			{
				$salesman_id 	= $user_altercode;
				$user_altercode = $chemist_id;
			}
			$medicine_json6 = $this->Chemist_Model->user_top_search_items($user_type,$user_altercode,$salesman_id);
			$medicine_json6 = "[$medicine_json6]";
			/***************************************************/
			
			/***************Under Construction**********************/
			$under_construction = $this->Scheme_Model->get_website_data("under_construction");
			$under_construction_message = "";
			if($under_construction == 1)
			{
				$under_construction_message = "Android App Under Construction";
			}
			$under_construction_message = base64_encode($under_construction_message);

			$salesman_id = "";
			if($user_type=="sales")
			{
				$salesman_id 	= $user_altercode;
				$user_altercode = $chemist_id;
			}

			$val = $this->Order_Model->my_cart_api($user_type,$user_altercode,$user_password,$salesman_id,"all","android");
			$user_cart_json0 = $val[0];
			$user_cart_json1 = $val[1];
			$user_cart_json0 = "[$user_cart_json0]";
			$user_cart_json1 = "[$user_cart_json1]";
			
$items .= <<<EOD
{"logout":"{$logout}","user_cart_json0":$user_cart_json0,"user_cart_json1":$user_cart_json1,"broadcast_title":"{$broadcast_title}","broadcast":"{$broadcast}","versioncode":"{$versioncode}","force_update":"{$force_update}","force_update_title":"{$force_update_title}","force_update_message":"{$force_update_message}","under_construction":"{$under_construction}","under_construction_message":"{$under_construction_message}","ratingbarpage":"{$ratingbarpage}","android_noti":"{$android_noti}","medicine_title0":"{$medicine_title0}","menu_json":$menu_json,"medicine_json0":$medicine_json0,"medicine_json1":$medicine_json1,"medicine_json2":$medicine_json2,"medicine_json3":$medicine_json3,"medicine_json4":$medicine_json4,"medicine_json5":$medicine_json5,"medicine_json6":$medicine_json6},
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
		
	public function chemist_search_api($page_type)
	{
		$items = "";
		if($page_type=="get")
		{
			$submit 		= $_GET["submit"];
			$keyword 		= $_GET["keyword"];
			$device_id		= $_GET['device_id'];
			$user_type 		= $_GET['user_type'];
			$user_altercode = $_GET['user_altercode'];
			$user_password 	= $_GET['user_password'];
		}
		if($page_type=="post")
		{
			$submit 		= $_POST["submit"];
			$keyword 		= $_POST["keyword"];
			$device_id		= $_POST['device_id'];
			$user_type 		= $_POST['user_type'];
			$user_altercode = $_POST['user_altercode'];
			$user_password 	= $_POST['user_password'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
			if(!empty($keyword)){
				$items = $this->Chemist_Model->chemist_search_api($user_type,$user_altercode,$keyword);
			}
		}
?>
[{"items":[<?= $items;?>]}]<?php

	}
	
	public function medicine_search_api($page_type)
	{
		$items = "";
		if($page_type=="get")
		{
			$submit 		= $_GET["submit"];
			$keyword 		= $_GET["keyword"];
			$device_id		= $_GET['device_id'];
			$user_type 		= $_GET['user_type'];
			$user_altercode = $_GET['user_altercode'];
			$user_password 	= $_GET['user_password'];
			$salesman_id 	= $_GET['salesman_id'];
		}
		if($page_type=="post")
		{
			$submit 		= $_POST["submit"];
			$keyword 		= $_POST["keyword"];
			$device_id		= $_POST['device_id'];
			$user_type 		= $_POST['user_type'];
			$user_altercode = $_POST['user_altercode'];
			$user_password 	= $_POST['user_password'];
			$salesman_id 	= $_POST['salesman_id'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{			
			if(!empty($keyword)){
				$items = $this->Chemist_Model->medicine_search_api($keyword);
			}
		}
?>
[{"items":[<?= $items;?>]}]<?php
	}

	public function medicine_details_api($page_type)
	{
		//https://drdistributor.com/new_api/api_mobile41/medicine_details_api/get?submit=98c08565401579448aad7c64033dcb4081906dcb&item_code=1093&user_type=chemist&user_altercode=v153
		$items = "";
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];			
			$user_type 		= $_GET['user_type'];
			$user_altercode = $_GET['user_altercode'];
			$user_password 	= $_GET['user_password'];

			$chemist_id 	= $_GET['chemist_id'];
			$item_code 		= $_GET["item_code"];	
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			
			$user_type 		= $_POST['user_type'];
			$user_altercode = $_POST['user_altercode'];
			$user_password 	= $_POST['user_password'];

			$chemist_id 	= $_POST['chemist_id'];
			$item_code 		= $_POST["item_code"];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
			$salesman_id = "";
			if($user_type=="sales")
			{
				$salesman_id 	= $user_altercode;
				$user_altercode	= $chemist_id;
			}

			$items = $this->Chemist_Model->medicine_details_api($user_type,$user_altercode,$salesman_id,$item_code);
		}
?>
[{"items":[<?= $items;?>]}]<?php
	}
	
	public function medicine_add_to_cart_api($page_type)
	{
		//https://drdweb.co.in/new_api/api_mobile41/medicine_add_to_cart_api/get?device_id=ok&user_altercode=v153&user_password=123123123&user_type=chemist&item_code=35&item_quantity=5&salesman_id=0&mobilenumber=0&modalnumber=i13&submit=98c08565401579448aad7c64033dcb4081906dcb
		$items = "";
		$status = "0";
		$user_cart_json0 = $user_cart_json1 = "";
		if($page_type=="get")
		{
			$submit					= $_GET['submit'];
			$device_id				= $_GET['device_id'];
			$mobilenumber 			= $_GET['mobilenumber'];
			$modalnumber 			= $_GET['modalnumber'];

			$item_code 				= $_GET['item_code'];
			$item_order_quantity 	= $_GET['item_order_quantity'];
			$order_type 			= $_GET['order_type'];

			$user_type 				= $_GET['user_type'];
			$user_altercode 		= $_GET['user_altercode'];
			$user_password  		= $_GET['user_password'];
			$chemist_id 			= $_GET['chemist_id'];

			$get_cart_list 			= $_GET['get_cart_list'];
		}
		
		if($page_type=="post")
		{
			$submit					= $_POST['submit'];
			$device_id				= $_POST['device_id'];
			$mobilenumber 			= $_POST['mobilenumber'];
			$modalnumber 			= $_POST['modalnumber'];

			$item_code 				= $_POST['item_code'];
			$item_order_quantity 	= $_POST['item_order_quantity'];
			$order_type 			= $_POST['order_type'];			

			$user_type 				= $_POST['user_type'];
			$user_altercode 		= $_POST['user_altercode'];
			$user_password  		= $_POST['user_password'];
			$chemist_id 			= $_POST['chemist_id'];

			$get_cart_list 			= $_POST['get_cart_list'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
			$salesman_id = "";
			if($user_type=="sales")
			{
				$salesman_id 	= $user_altercode;
				$user_altercode	= $chemist_id;
			}

			if(!empty($item_order_quantity))
			{
				$excel_number = "";		
				$status = $this->Chemist_Model->medicine_add_to_cart_api($user_type,$user_altercode,$salesman_id,$order_type,$item_code,$item_order_quantity,$mobilenumber,$modalnumber,$device_id,$excel_number);
			}
			
			if($get_cart_list==1)
			{
				$val = $this->Order_Model->my_cart_api($user_type,$user_altercode,$user_password,$salesman_id,"all","android");
				$user_cart_json0 = $val[0];
				$user_cart_json1 = $val[1];
			}
		}
$items= <<<EOD
{"status":"{$status}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
[{"items":[<?= $items;?>],"user_cart_json0":[<?= $user_cart_json0;?>],"user_cart_json1":[<?= $user_cart_json1;?>]}]<?php
	}

	public function delete_medicine_api($page_type)
	{			
		$items = "";
		$status = "";
		$user_cart_json0 = $user_cart_json1 = "";
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$device_id		= $_GET['device_id'];
			$item_code 		= $_GET['item_code'];
			$user_type 		= $_GET['user_type'];
			$user_altercode = $_GET['user_altercode'];
			$user_password 	= $_GET['user_password'];
			$chemist_id 	= $_GET['chemist_id'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$device_id		= $_POST['device_id'];
			$item_code 		= $_POST['item_code'];
			$user_type 		= $_POST['user_type'];
			$user_altercode = $_POST['user_altercode'];
			$user_password 	= $_POST['user_password'];
			$chemist_id 	= $_POST['chemist_id'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{		
			$salesman_id = "";
			if($user_type=="sales")
			{
				$salesman_id 	= $user_altercode;
				$user_altercode	= $chemist_id;
			}

			$status = $this->Chemist_Model->delete_medicine_api($user_type,$user_altercode,$salesman_id,$item_code);

			$val = $this->Order_Model->my_cart_api($user_type,$user_altercode,$user_password,$salesman_id,"all");
			$user_cart_json0 = $val[0];
			$user_cart_json1 = $val[1];
		}

$items= <<<EOD
{"status":"{$status}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
[{"items":[<?= $items;?>],"user_cart_json0":[<?= $user_cart_json0;?>],"user_cart_json1":[<?= $user_cart_json1;?>]}]<?php
	}

	public function delete_all_medicine_api($page_type)
	{			
		$items = "";
		$status = "";
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$device_id		= $_GET['device_id'];
			$user_type 		= $_GET['user_type'];
			$user_altercode = $_GET['user_altercode'];
			$user_password 	= $_GET['user_password'];
			$chemist_id 	= $_GET['chemist_id'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$device_id		= $_POST['device_id'];
			$user_type 		= $_POST['user_type'];
			$user_altercode = $_POST['user_altercode'];
			$user_password 	= $_POST['user_password'];
			$chemist_id 	= $_POST['chemist_id'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{		
			$salesman_id = "";
			if($user_type=="sales")
			{
				$salesman_id 	= $user_altercode;
				$user_altercode	= $chemist_id;
			}

			$status = $this->Chemist_Model->delete_all_medicine_api($user_type,$user_altercode,$salesman_id);
		}
$items= <<<EOD
{"status":"{$status}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
[{"items":[<?= $items;?>]}]<?php
	}
	
	public function my_cart_api($page_type)
	{
		//https://drdweb.co.in/new_api/api_mobile41/my_cart_api/get?submit=98c08565401579448aad7c64033dcb4081906dcb&chemist_id=v153&user_type=chemist&user_password=f5bb0c8de146c67b44babbf4e6584cc0&salesman_id=0
		$items = "";
		$other_items = "";
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$device_id		= $_GET['device_id'];
			$user_altercode = $_GET['user_altercode'];
			$user_password 	= $_GET['user_password'];
			$chemist_id 	= $_GET['chemist_id'];
			$user_type 		= $_GET['user_type'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$device_id		= $_POST['device_id'];
			$user_altercode = $_POST['user_altercode'];
			$user_password 	= $_POST['user_password'];
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
			$salesman_id = "";
			if($user_type=="sales")
			{
				$salesman_id 	= $user_altercode;
				$user_altercode = $chemist_id;
			}
			
			$val = $this->Order_Model->my_cart_api($user_type,$user_altercode,$user_password,$salesman_id,"all","android");
			$items = $val[0];
			$other_items = $val[1];
		}
?>
[{"items":[<?= $items;?>],"other_items":[<?= $other_items;?>]}]<?php
	}
	
	public function salesman_my_cart_api($page_type)
	{
		$items = "";
		$other_items = "";
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$device_id		= $_GET['device_id'];
			$user_type 		= $_GET['user_type'];
			$user_altercode = $_GET['user_altercode'];
			$user_password 	= $_GET['user_password'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$device_id		= $_POST['device_id'];
			$user_type 		= $_POST['user_type'];
			$user_altercode = $_POST['user_altercode'];
			$user_password 	= $_POST['user_password'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{	
			if($user_type!="" && $user_altercode!="")
			{		
				$items = $this->Order_Model->salesman_my_cart_api($user_type,$user_altercode);
			}
		}
?>
[{"items":[<?= $items;?>]}]<?php
	}

	public function place_order_api($page_type)
	{
		//https://drdweb.co.in/new_api/api_mobile41/my_place_order_api/get?submit=98c08565401579448aad7c64033dcb4081906dcb&user_altercode=v153&user_type=chemist&user_password=f5bb0c8de146c67b44babbf4e6584cc0&salesman_id=&latitude=0.0&longitude=0.0&mobilenumber=0&modalnumber=0&device_id=123
		$items = "";
		$status = "";
		$place_order_message = "";

		if($page_type=="get")
		{			
			$submit			= $_GET['submit'];
	
			$user_type 		= $_GET['user_type'];
			$user_altercode = $_GET['user_altercode'];		
			$user_password 	= $_GET["user_password"];
			$chemist_id 	= $_GET['chemist_id'];
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
			$user_type 		= $_POST['user_type'];
			$user_altercode = $_POST['user_altercode'];		
			$user_password 	= $_POST["user_password"];
			$chemist_id 	= $_POST['chemist_id'];
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

			$salesman_id = "";
			if($user_type=="sales")
			{
				$salesman_id 	= $user_altercode;
				$user_altercode = $chemist_id;
			}

			$val = $this->Order_Model->save_order_to_server("Android",$slice_type,$slice_item,$remarks,$salesman_id,$user_altercode,$user_type,$user_password,$latitude,$longitude,$mobilenumber,$modalnumber,$device_id);

			$status 				= $val[0];
			$place_order_message 	= $val[1];
		}			
$items .= <<<EOD
{"status":"{$status}","place_order_message":"{$place_order_message}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
[{"items":[<?= $items;?>]}]<?php
	}
	
	/*********************html part ke liya sirf*************/
	public function my_order_api($page_type)
	{
		if($page_type=="get")
		{
			$submit 		= $_GET['submit'];
			$user_type 		= $_GET['user_type'];
			$user_altercode	= $_GET['user_altercode'];
			$chemist_id		= $_GET['chemist_id'];
			$get_record	 	= $_GET["get_record"];
		}
		if($page_type=="post")
		{
			$submit 		= $_POST['submit'];
			$user_type 		= $_POST['user_type'];
			$user_altercode	= $_POST['user_altercode'];
			$chemist_id		= $_POST['chemist_id'];
			$get_record	 	= $_POST["get_record"];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1 && $user_type!="" && $user_altercode!="" && $get_record!="")
		{
			$salesman_id = "";
			if($user_type=="sales")
			{
				$salesman_id 	= $user_altercode;
				$user_altercode	= $chemist_id;
			}

			$items = $this->Chemist_Model->my_order_api($user_type,$user_altercode,$salesman_id,$get_record);
		}
?>
[{"items":[<?= $items;?>]}]<?php
	}
	
	public function my_order_details_api($page_type)
	{
		if($page_type=="get")
		{
			$submit 		= $_GET['submit'];
			$user_type 		= $_GET['user_type'];
			$user_altercode	= $_GET['user_altercode'];
			$chemist_id		= $_GET['chemist_id'];
			$item_id		= $_GET['item_id'];
		}
		if($page_type=="post")
		{
			$submit 		= $_POST['submit'];
			$user_type 		= $_POST['user_type'];
			$user_altercode	= $_POST['user_altercode'];
			$chemist_id		= $_POST['chemist_id'];
			$item_id		= $_POST['item_id'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);		
		if($submit==$submit1 && $user_type!="" && $user_altercode!="" && $item_id!="")
		{
			$salesman_id = "";
			if($user_type=="sales")
			{
				$salesman_id 	= $user_altercode;
				$user_altercode	= $chemist_id;
			}

			$items = $this->Chemist_Model->my_order_details_api($user_type,$user_altercode,$salesman_id,$item_id);
		}
?>
[{"items":[<?= $items;?>]}]<?php
	}
	
	public function my_invoice_api($page_type)
	{
		if($page_type=="get")
		{
			$submit 		= $_GET['submit'];
			$user_type 		= $_GET['user_type'];
			$user_altercode	= $_GET['user_altercode'];
			$chemist_id		= $_GET['chemist_id'];
			$get_record	 	= $_GET["get_record"];
		}
		if($page_type=="post")
		{
			$submit 		= $_POST['submit'];
			$user_type 		= $_POST['user_type'];
			$user_altercode	= $_POST['user_altercode'];
			$chemist_id		= $_POST['chemist_id'];
			$get_record	 	= $_POST["get_record"];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1 && $user_type!="" && $user_altercode!="" && $get_record!="")
		{
			$salesman_id = "";
			if($user_type=="sales")
			{
				$salesman_id 	= $user_altercode;
				$user_altercode	= $chemist_id;
			}

			$items = $this->Chemist_Model->my_invoice_api($user_type,$user_altercode,$salesman_id,$get_record);
		}
?>
[{"items":[<?= $items;?>]}]<?php
	}

	
	public function my_invoice_details_api($page_type)
	{
		$items = $delete_items = $download_url = $header_title = "";
		if($page_type=="get")
		{
			$submit 		= $_GET['submit'];
			$user_type 		= $_GET['user_type'];
			$user_altercode	= $_GET['user_altercode'];
			$chemist_id		= $_GET['chemist_id'];
			$item_id		= $_GET['item_id'];
		}
		if($page_type=="post")
		{
			$submit 		= $_POST['submit'];
			$user_type 		= $_POST['user_type'];
			$user_altercode	= $_POST['user_altercode'];
			$chemist_id		= $_POST['chemist_id'];
			$item_id		= $_POST['item_id'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);		
		if($submit==$submit1 && $user_type!="" && $user_altercode!="" && $item_id!="")
		{
			$salesman_id = "";
			if($user_type=="sales")
			{
				$salesman_id 	= $user_altercode;
				$user_altercode	= $chemist_id;
			}

			$val = $this->Chemist_Model->my_invoice_details_api($user_type,$user_altercode,$salesman_id,$item_id);

			$items			= $val[0];
			$delete_items 	= $val[1];
			$download_url 	= $val[2];
			$header_title 	= $val[3];
		}
?>
[{"items":[<?= $items;?>],"delete_items":[<?= $delete_items;?>],"download_url":[<?= $download_url;?>],"header_title":[<?= $header_title;?>]}]<?php
	}
	
	public function my_notification_api($page_type)
	{
		if($page_type=="get")
		{
			$submit 		= $_GET['submit'];
			$user_type 		= $_GET['user_type'];
			$user_altercode	= $_GET['user_altercode'];
			$chemist_id		= $_GET['chemist_id'];
			$get_record	 	= $_GET["get_record"];
		}
		if($page_type=="post")
		{
			$submit 		= $_POST['submit'];
			$user_type 		= $_POST['user_type'];
			$user_altercode	= $_POST['user_altercode'];
			$chemist_id		= $_POST['chemist_id'];
			$get_record	 	= $_POST["get_record"];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1 && $user_type!="" && $user_altercode!="" && $get_record!="")
		{
			$salesman_id = "";
			if($user_type=="sales")
			{
				$salesman_id 	= $user_altercode;
				$user_altercode	= $chemist_id;
			}
			
			$items = $this->Chemist_Model->my_notification_api($user_type,$user_altercode,$salesman_id,$get_record);
		}
?>
[{"items":[<?= $items;?>]}]<?php
	}
	
	public function my_notification_details_api($page_type)
	{
		if($page_type=="get")
		{
			$submit 		= $_GET['submit'];
			$user_type 		= $_GET['user_type'];
			$user_altercode	= $_GET['user_altercode'];
			$chemist_id		= $_GET['chemist_id'];
			$item_id		= $_GET['item_id'];
		}
		if($page_type=="post")
		{
			$submit 		= $_POST['submit'];
			$user_type 		= $_POST['user_type'];
			$user_altercode	= $_POST['user_altercode'];
			$chemist_id		= $_POST['chemist_id'];
			$item_id		= $_POST['item_id'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);		
		if($submit==$submit1 && $user_type!="" && $user_altercode!="" && $item_id!="")
		{
			$salesman_id = "";
			if($user_type=="sales")
			{
				$salesman_id 	= $user_altercode;
				$user_altercode	= $chemist_id;
			}

			$items = $this->Chemist_Model->my_notification_details_api($user_type,$user_altercode,$salesman_id,$item_id);
		}
?>
[{"items":[<?= $items;?>]}]<?php
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
	
	public function medicine_category_api($page_type)
	{
		//https://drdistributor.com/new_api/api_mobile41/medicine_category_api/get?user_altercode=v153&user_type=chemist&get_record=get_record&submit=98c08565401579448aad7c64033dcb4081906dcb&item_code=17237&item_page_type=medicine_category
		$items = "";
		if($page_type=="get")
		{
			$submit 		= $_GET['submit'];
			$user_type 		= $_GET['user_type'];
			$user_altercode	= $_GET['user_altercode'];
			$chemist_id		= $_GET['chemist_id'];
			

			$item_code 		= $_GET["item_code"];
			$item_division 	= $_GET["item_division"];
			$item_page_type	= $_GET["item_page_type"];
			$get_record 	= $_GET["get_record"];
		}
		if($page_type=="post")
		{
			$submit 		= $_POST['submit'];
			$user_type 		= $_POST['user_type'];
			$user_altercode	= $_POST['user_altercode'];
			$chemist_id		= $_POST['chemist_id'];

			$item_code 		= $_POST["item_code"];
			$item_division 	= $_POST["item_division"];
			$item_page_type	= $_POST["item_page_type"];
			$get_record 	= $_POST["get_record"];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);		
		if($submit==$submit1 && $user_type!="" && $user_altercode!="" && $item_page_type!="")
		{
			if($item_page_type=="medicine_category")
			{
				$items = $this->Chemist_Model->medicine_category_api($item_code,$get_record);
			}
			
			if($item_page_type=="featured_brand")
			{
				$items = $this->Chemist_Model->featured_brand_api($item_code,$item_division,$get_record);
			}

			if($item_page_type=="medicine_similar")
			{
				$items = $this->Chemist_Model->medicine_similar_api($item_code,$get_record);
			}

			/******************************************/
			if($item_page_type=="medicine_category1")
			{
				$items = $this->Chemist_Model->new_medicine_this_month_json_new();
			}

			if($item_page_type=="medicine_category2")
			{
				$items = $this->Chemist_Model->hot_selling_today_json_new();
			}

			if($item_page_type=="medicine_category3")
			{
				$items = $this->Chemist_Model->must_buy_medicines_json_new();
			}

			if($item_page_type=="medicine_category4")
			{
				$items = $this->Chemist_Model->frequently_use_medicines_json_new();
			}

			if($item_page_type=="medicine_category5")
			{
				$items = $this->Chemist_Model->stock_now_available();
			}

			if($item_page_type=="medicine_category6")
			{
				$salesman_id = "";
				if($user_type=="sales")
				{
					$salesman_id 	= $user_altercode;
					$user_altercode = $chemist_id;
				}

				$items = $this->Chemist_Model->user_top_search_items($user_type,$user_altercode,$salesman_id);
			}
		}
?>
[{"items":[<?= $items;?>]}]<?php
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