<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Manage_chemist extends CI_Controller {
	var $Page_title = "Manage chemist";
	var $Page_name  = "manage_chemist";
	var $Page_view  = "manage_chemist";
	var $Page_menu  = "manage_chemist";
	var $page_controllers = "manage_chemist";
	var $Page_tbl   = "tbl_acm";
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

		$query = $this->db->query("select * from $tbl");
  		$data["result"] = $query->result();

		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/view",$data);
		$this->load->view("admin/header_footer/footer",$data);
	}
	public function search_user($page_type)
	{
		error_reporting(0);
		header('Content-Type: application/json');
		$items = "";
		if($page_type=="get")
		{
			$search	= $_GET["search"];
		}
		if($page_type=="post")
		{
			$search	= $_POST["search"];
		}
		$query = $this->db->query("select * from tbl_acm where (altercode='$search' or name Like '%$search%') limit 100")->result();
		foreach($query as $row)
		{			
			$altercode = $row->altercode;
			$name = $row->name;
			$email = $row->email;
			$mobile = $row->mobile;
			$address = ($row->address).",".($row->address1).",".($row->address2).",".($row->address3);
			$id = $row->id;

			$name 		= base64_encode($name);
			$altercode 	= base64_encode($altercode);
			$email 		= base64_encode($email);
			$mobile 	= base64_encode($mobile);
			$address 	= base64_encode($address);

			$where= array('code'=>$row->code);
			$row1 = $this->Scheme_Model->select_row("tbl_acm_other",$where);
			$website_limit 	= $row1->website_limit;
			$android_limit 	= $row1->android_limit;
			$status 		= $row1->status;
			$block 			= $row1->block;
			$new_request    = $row1->new_request;
			$status_text 	= "Not Create Account";
			if($status=="0")
			{
				$status_text = "Inactive";
			}
			if($status=="1")
			{
				$status_text = "Active";
			}
			if($new_request=="1")
			{
				$status_text 	= "New Account Request";
			}
			if($block=="1")
			{
				$status_text = "Blocked";
			}

$items.= <<<EOD
{"id":"{$id}","altercode":"{$altercode}","name":"{$name}","email":"{$email}","mobile":"{$mobile}","website_limit":"{$website_limit}","android_limit":"{$android_limit}","status":"{$status_text}","address":"{$address}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}
		<?php
	}
	
	function clean($string) {
		$string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.
		$string = str_replace('-', '', $string); // Replaces all spaces with hyphens.
		return preg_replace('/[^A-Za-z0-9\#]/', '', $string); // Removes special chars.
	}
	
	public function edit($id)
	{
		error_reporting(0);
		/******************session***********************/
		$user_id = $this->session->userdata("user_id");
		$user_type = $this->session->userdata("user_type");
		/******************session***********************/	

		$Page_title = $this->Page_title;
		$Page_name 	= $this->Page_name;
		$Page_view 	= $this->Page_view;
		$Page_menu 	= $this->Page_menu;
		$Page_tbl 	= $this->Page_tbl;
		$page_controllers 	= $this->page_controllers;	

		$this->Admin_Model->permissions_check_or_set($Page_title,$Page_name,$user_type);	

		$data['title1'] = $Page_title." || Edit";
		$data['title2'] = "Edit";
		$data['Page_name'] = $Page_name;
		$data['Page_menu'] = $Page_menu;
		$this->breadcrumbs->push("Edit","admin/");
		$this->breadcrumbs->push("$Page_title","admin/$page_controllers/");
		$this->breadcrumbs->push("Edit","admin/$page_controllers/edit");

		$tbl = $Page_tbl;	

		$data['url_path'] = base_url()."uploads/$page_controllers/photo/";
		$upload_path = "./uploads/$page_controllers/photo/";		$upload_thumbs_path = "./uploads/$page_controllers/photo/thumbs/";

		$system_ip = $this->input->ip_address();
		$status = "";
		extract($_POST);
		if(isset($Submit))
		{
			$message_db = "";
			$time = time();
			$date = date("Y-m-d",$time);				

			$query = $this->db->query("select * from tbl_acm where id='$id'")->row();
			$code = $query->code;
			$altercode = $query->altercode;
			if($block=="1" || $status==0)
			{
				$this->user_logout_new($altercode);
			}

			if (!empty($_FILES["image"]["name"]))
			{
				$user_code 		= $code;
				$user_type 		= "chemist";
				$image_path   	= $_FILES['image']['tmp_name'];
				$img_name     	= time()."_".$user_code."_".$user_type.".png";
				$user_profile 	= "user_profile/$img_name";			
				move_uploaded_file($image_path,$user_profile);
				$image 			= $img_name;
			}
			else
			{
				$image 			= $old_image;
			}


			$result = "";
			$dt = array(
				'new_request'=>"0",
				'status'=>$status,
				'block'=>$block,
				'website_limit'=>$website_limit,
				'android_limit'=>$android_limit,
				'image'=>$image,
			);
			if($new_password!="")
			{
				$password =	$new_password;
				$this->send_email_for_password_create($code,$password);
				$password = md5($password);

				$dt = array(
					'new_request'=>"0",
					'status'=>$status,
					'block'=>$block,
					'website_limit'=>$website_limit,
					'android_limit'=>$android_limit,
					'password'=>$password,
				);
			}
			$where = array('code'=>$code);
			$result = $this->Scheme_Model->edit_fun("tbl_acm_other",$dt,$where);
			if($result)
			{
				$message_db = "$change_text - Edit Successfully.";
				$message = "Edit Successfully.";
				$this->session->set_flashdata("message_type","success");
			}
			else
			{
				$message_db = "$change_text - Not Add.";
				$message = "Not Add.";
				$this->session->set_flashdata("message_type","error");
			}
			if($message_db!="")
			{
				$message = $Page_title." - ".$message;
				$message_db = $Page_title." - ".$message_db;
				$this->session->set_flashdata("message_footer","yes");
				$this->session->set_flashdata("full_message",$message);
				$this->Admin_Model->Add_Activity_log($message_db);
				if($result)
				{
					redirect(current_url());
					//redirect(base_url()."admin/$page_controllers/view");
				}
			}
		}	

		$query = $this->db->query("select tbl_acm.altercode,tbl_acm.code,tbl_acm.name,tbl_acm_other.status,tbl_acm_other.block,tbl_acm_other.order_limit,tbl_acm_other.website_limit,tbl_acm_other.android_limit,tbl_acm_other.image from tbl_acm,tbl_acm_other where tbl_acm.code=tbl_acm_other.code and tbl_acm.id='$id' order by tbl_acm.id desc");
  		$data["result"] = $query->result();	
		$x = $query->result();	
		if(empty($x))
		{
			$query = $this->db->query("select * from tbl_acm where id='$id'")->row();
			$code = $query->code;
			if($code!="")
			{
				$this->db->query("insert into tbl_acm_other set code='$code'");
				redirect(current_url());
			}
		}

		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/edit",$data);
		$this->load->view("admin/header_footer/footer",$data);
	}

	public function send_email_for_password_create($code,$password)
	{
		$q = $this->db->query("select * from tbl_acm where code='$code' ")->row();
		if($q->altercode!="")
		{
			$name		= $q->name;
			$email_id 	= $q->email;
			$altercode 	= $q->altercode;
			$number 	= $q->mobile;
			if($number!="")
			{
				$w_message = "Hello $name ($altercode) \\n\\nLogin Details for Your online ordering system and android application are as below.\\n\\nUsername : $altercode \\nPassword : $password \\n\\nOn laptop or pc you can visit following link to start placing orders http://drdistributor.com/ \\n\\nPlease download our app from Google play store :   https://rb.gy/xo2qlk \\n\\nThanks D. R. Distributors Private Limited";
				$w_altercode 	= $altercode;
				
				$w_number 		= "+91".$number;
				$this->Message_Model->insert_whatsapp_message($w_number,$w_message,$w_altercode);
			}
			else
			{
				$err = "$name this user can not have any mobile number";
				$this->Email_Model->tbl_whatsapp_email_fail($number,$err,$altercode);
			}
			if($q->email!="")
			{
				$this->Email_Model->send_email_for_password_create($name,$email_id,$altercode,$password);
			}
			else
			{
				$err = "$name this user can not have any email address";
				$this->Email_Model->tbl_whatsapp_email_fail($email_id,$err,$altercode);
			}
		}
	}

	public function randomPassword() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}

	public function user_logout_new($altercode)
	{
		$this->db->query("update tbl_android_device_id set logout='1' where chemist_id='$altercode'");

		$this->db->query("delete from drd_login_time where user_altercode='$altercode'");
	}

	public function user_logout()
	{
		error_reporting(0);
		header('Content-Type: application/json');
		$altercode = $_POST["altercode"];
		$items = "";
		$response = "";
		if($altercode!="")
		{
			$this->db->query("update tbl_android_device_id set logout='1' where chemist_id='$altercode'");

			$this->db->query("delete from drd_login_time where user_altercode='$altercode'");
			$response = 1;
		}
$items.= <<<EOD
{"response":"{$response}"},
EOD;
if ($items != '') {
$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}
<?php
	}
}