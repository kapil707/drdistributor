<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Manage_allbiker_map extends CI_Controller {
	var $Page_title = "Manage AllBiker Map";
	var $Page_name  = "manage_allbiker_map";
	var $Page_view  = "manage_allbiker_map";
	var $Page_menu  = "manage_allbiker_map";
	var $page_controllers = "manage_allbiker_map";
	var $Page_tbl   = "tbl_order";
	public function index()
	{
		$page_controllers = $this->page_controllers;
		redirect("admin/$page_controllers/view");
	}
	
	public function view()
	{
		error_reporting(0);
		/******************session***********************/
		$user_id = $this->session->userdata("user_id");
		$user_type = $this->session->userdata("user_type");
		/******************session***********************/

		$_SESSION["latitude"] = 
		$_SESSION["longitude"] = "";	

		$Page_title = $this->Page_title;
		$Page_name 	= $this->Page_name;
		$Page_view 	= $this->Page_view;
		$Page_menu 	= $this->Page_menu;
		$Page_tbl 	= $this->Page_tbl;
		$page_controllers 	= $this->page_controllers;	

		$this->Admin_Model->permissions_check_or_set($Page_title,$Page_name,$user_type);	

		$data['title1'] = $Page_title." || View";
		$data['title2'] = "View";
		$data['Page_name'] = $Page_name;
		$data['Page_menu'] = $Page_menu;	

		$this->breadcrumbs->push("Admin","admin/");
		$this->breadcrumbs->push("$Page_title","admin/$page_controllers/");
		$this->breadcrumbs->push("View","admin/$page_controllers/view");		

		$tbl = $Page_tbl;	

		$data['url_path'] = base_url()."uploads/$page_controllers/photo/";
		$upload_path = "./uploads/$page_controllers/photo/";

		$vdt = date("Y-m-d");
		if($_POST["submit"])
		{
			$vdt = $_POST["vdt"];
			$data["vdt"] = $vdt;
		}
		$data["result"] = $this->db->query("SELECT tbl_master_other.latitude,tbl_master_other.longitude,tbl_master_other.date,tbl_master_other.time,tbl_master.altercode,tbl_master.name FROM `tbl_master_other`,tbl_master WHERE tbl_master.code=tbl_master_other.code and tbl_master_other.firebase_token!=''")->result();

		/*$altercode = "";
		if (!empty($_GET["altercode"])) {
			$altercode = $_GET["altercode"];
			$data["result"] = $this->db->query("SELECT * FROM `tbl_deliver_info` where user_altercode='$altercode' order by id asc")->result();
		}
		$data["altercode"] = $altercode;*/

		if (isset($_POST["Notification"])) {
			$altercode = $_POST["altercode"];

			define('API_ACCESS_KEY', 'AAAAdZCD4YU:APA91bFjmo0O-bWCz2ESy0EuG9lz0gjqhAatkakhxJmxK1XdNGEusI5s_vy7v7wT5TeDsjcQH0ZVooDiDEtOU64oTLZpfXqA8EOmGoPBpOCgsZnIZkoOLVgErCQ68i5mGL9T6jnzF7lO');

			$row = $this->db->query("SELECT tbl_master_other.firebase_token FROM `tbl_master_other`,tbl_master WHERE tbl_master.code=tbl_master_other.code and tbl_master_other.firebase_token!='' and tbl_master.altercode='$altercode'")->row();

			$id = "1";
			$title = "DRD";
			$message = "D R Distributors Pvt Ltd";
			$body = "D R Distributors Pvt Ltd";
			$funtype = "1000";
			$division = "";
			$company_full_name = "";
			$image = "";
			$itemid = "";
			
			$token = $row->firebase_token;
			$data = array
			(
				'id'=>$id,
				'title'=>$title,
				'message'=>$message,
				'body'=>$body,
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
			$result1 = curl_exec($ch);
			echo $result1;
			curl_close($ch);
		}

		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/view",$data);
		$this->load->view("admin/header_footer/footer",$data);
	}
	
	public function view2()
	{
		error_reporting(0);
		/******************session***********************/
		$user_id = $this->session->userdata("user_id");
		$user_type = $this->session->userdata("user_type");
		/******************session***********************/

		$_SESSION["latitude"] = 
		$_SESSION["longitude"] = "";	

		$Page_title = $this->Page_title;
		$Page_name 	= $this->Page_name;
		$Page_view 	= $this->Page_view;
		$Page_menu 	= $this->Page_menu;
		$Page_tbl 	= $this->Page_tbl;
		$page_controllers 	= $this->page_controllers;	

		$this->Admin_Model->permissions_check_or_set($Page_title,$Page_name,$user_type);	

		$data['title1'] = $Page_title." || View";
		$data['title2'] = "View";
		$data['Page_name'] = $Page_name;
		$data['Page_menu'] = $Page_menu;	

		$this->breadcrumbs->push("Admin","admin/");
		$this->breadcrumbs->push("$Page_title","admin/$page_controllers/");
		$this->breadcrumbs->push("View","admin/$page_controllers/view");		

		$tbl = $Page_tbl;	

		$data['url_path'] = base_url()."uploads/$page_controllers/photo/";
		$upload_path = "./uploads/$page_controllers/photo/";

		$data["dropdown"] = $this->db->query("SELECT tbl_master_other.latitude,tbl_master_other.longitude,tbl_master_other.date,tbl_master_other.time,tbl_master.altercode,tbl_master.name FROM `tbl_master_other`,tbl_master WHERE tbl_master.code=tbl_master_other.code and tbl_master_other.firebase_token!=''")->result();

		$vdt = date("d-F-Y");
		$altercode = "";
		if (!empty($_GET["altercode"])) {
			$altercode = $_GET["altercode"];
			if(!empty($_GET["vdt"])){
				$vdt 	= $_GET["vdt"];
				$vdt1 = date("Y-m-d", strtotime($vdt));
			} else {
				$vdt1 = date("Y-m-d", strtotime($vdt));
			}
			$data["result"] = $this->db->query("SELECT * FROM `tbl_deliver_info` where user_altercode='$altercode' and date='$vdt1' order by id asc")->result();
			$vdt 	= date("d-F-Y",strtotime($vdt));
		}
		$data["altercode"] = $altercode;
		$data["vdt"] = $vdt;

		if (isset($_GET["Notification"])) {
			$altercode = $_GET["altercode"];

			define('API_ACCESS_KEY', 'AAAAdZCD4YU:APA91bFjmo0O-bWCz2ESy0EuG9lz0gjqhAatkakhxJmxK1XdNGEusI5s_vy7v7wT5TeDsjcQH0ZVooDiDEtOU64oTLZpfXqA8EOmGoPBpOCgsZnIZkoOLVgErCQ68i5mGL9T6jnzF7lO');

			$row = $this->db->query("SELECT tbl_master_other.firebase_token FROM `tbl_master_other`,tbl_master WHERE tbl_master.code=tbl_master_other.code and tbl_master_other.firebase_token!='' and tbl_master.altercode='$altercode'")->row();

			$id = "1";
			$title = "DRD";
			$message = "D R Distributors Pvt Ltd";
			$body = "D R Distributors Pvt Ltd";
			$funtype = "1000";
			$division = "";
			$company_full_name = "";
			$image = "";
			$itemid = "";
			
			$token = $row->firebase_token;
			$data = array
			(
				'id'=>$id,
				'title'=>$title,
				'message'=>$message,
				'body'=>$body,
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
			$result1 = curl_exec($ch);
			echo $result1;
			curl_close($ch);
		}	

		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/view2",$data);
		$this->load->view("admin/header_footer/footer",$data);
	}
	
	public function tbl_order_id()
	{
		$q = $this->db->query("select order_id from tbl_order_id where id='1'")->row();
		$order_id = $q->order_id + 1;
		$this->db->query("update tbl_order_id set order_id='$order_id' where id='1'");
		return $order_id;
	}
	
	public function create_copy_order()
	{
		$order_id 		= $_POST["order_id"];
		$row = $this->db->query("select * from tbl_order where order_id='$order_id'")->row();
		$temp_rec 	= $row->temp_rec."_again";
		$this->db->query("update tbl_order set temp_rec='$temp_rec',download_status='0' where order_id='$order_id'");
		echo "ok";
		
		//$order_id_new 	= $this->tbl_order_id();
		/*$result = $this->db->query("select * from tbl_order where order_id='$order_id'")->result();
		foreach($result as $row)
		{
			$order_type = $row->order_type;
			$user_type 	= $row->user_type;
			$item_code 	= $row->item_code;
			$item_name 	= $row->item_name;
			$sale_rate 	= $row->sale_rate;
			$quantity 	= $row->quantity;
			$remarks 	= $row->remarks;
			$date 		= $row->date;
			$time 		= $row->time;
			$filename 	= $row->filename;
			$status 	= $row->status;
			$chemist_id = $row->chemist_id;
			$salesman_id = $row->salesman_id;
			$temp_rec 	= $row->temp_rec;
			$gstvno 	= $row->gstvno;
			$odt 		= $row->odt;
			$ordno_new = $row->ordno_new;
			
			$dt = array(
			'order_type'=>$order_type,
			'user_type'=>$user_type,
			'order_id'=>$order_id_new,
			'item_code'=>$item_code,
			'item_name'=>$item_name,
			'sale_rate'=>$sale_rate,
			'quantity'=>$quantity,
			'remarks'=>$remarks,
			'date'=>$date,
			'time'=>$time,
			'filename'=>$filename,
			'status'=>$status,
			'chemist_id'=>$chemist_id,
			'salesman_id'=>$salesman_id,
			'temp_rec'=>$temp_rec,
			'gstvno'=>$gstvno,
			'odt'=>$odt,
			'ordno_new'=>$ordno_new,
			);
			$this->Scheme_Model->insert_fun("tbl_order",$dt);
		}
		$this->db->query("delete from tbl_order where order_id='$order_id'");
		echo "ok";*/
	}
}