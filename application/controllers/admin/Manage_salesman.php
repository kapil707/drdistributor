<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Manage_salesman extends CI_Controller {
	var $Page_title = "Manage salesman";
	var $Page_name  = "manage_salesman";
	var $Page_view  = "manage_salesman";
	var $Page_menu  = "manage_salesman";
	var $page_controllers = "manage_salesman";
	var $Page_tbl   = "tbl_users";
	public function index()
	{
		$page_controllers = $this->page_controllers;
		redirect("admin/$page_controllers/view");
	}
	public function add()
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
		$data['title1'] = $Page_title." || Add";
		$data['title2'] = "Add";
		$data['Page_name'] = $Page_name;
		$data['Page_menu'] = $Page_menu;	
		$this->breadcrumbs->push("Admin","admin/");
		$this->breadcrumbs->push("$Page_title","admin/$page_controllers/");
		$this->breadcrumbs->push("Add","admin/$page_controllers/add");		
		$tbl = $Page_tbl;
		$data['url_path'] = base_url()."uploads/$page_controllers/photo/";
		$upload_path = "./uploads/$page_controllers/photo/";	
		$system_ip = $this->input->ip_address();
		extract($_POST);
		if(isset($Submit))		{
			$message_db = "";
			$this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
			$this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
			$this->form_validation->set_rules('cust_email', 'Email', "required|trim|valid_email|is_unique[tbl_users.cust_email]",
			array(
			"is_unique"=>"<p class='font-bold  alert alert-danger m-b-sm'>This email address is already registered with us, Please use forgot password link in login or else register using a valid email address.</p>"
			));
			$this->form_validation->set_rules('cust_mobile','Mobile', "required|is_unique[tbl_users.cust_mobile]|callback_phone_check",
			array(
			"is_unique"=>"<p class='font-bold  alert alert-danger m-b-sm'>This mobile number is already registered with us, Please use forgot password link in login or else register using a valid mobile address.</p>"
			));
			$this->form_validation->set_rules('password','Password','trim|required|min_length[6]|alpha_numeric',
			array(
			"min_length"=>"<p class='font-bold  alert alert-danger m-b-sm'>Min 6 characters length is required.</p>"
			));
			if ($this->form_validation->run() == FALSE)
			{				$message = "Check Validation.";
				$this->session->set_flashdata("message_type","warning");
			}
			else
			{
				$time = time();
				$date = date("Y-m-d",$time);			
				if (!empty($_FILES["image"]["name"]))
				{
					$name1 = "photo";
					$imagename = $_FILES["image"]['name'];
					$uploadedfile = $_FILES["image"]['tmp_name'];
					$image = "";				
					$valid_formats = array("jpg", "png", "gif", "bmp","jpeg","PNG","JPG","JPEG","GIF","BMP");
					$ext = strtolower($this->Scheme_Model->getExtension($imagename));
					if(in_array($ext,$valid_formats))
					{
						//$ext = "jpg";
						$actual_image_name = $name1."_".time().".".$ext;
						$widthArray = array(300);
						foreach($widthArray as $newwidth)
						{
							$image = $this->Scheme_Model->compressImage($ext,$uploadedfile,$upload_path,$actual_image_name,$newwidth);
							$image = $newwidth."_".$image; 
						}
					}
				}
				else				{
					$image = "";
				}
				$customer_name = $firstname." ".$lastname;
				$user_role = "sales";
				$created_at = date('Y-m-d : h:m:s');
				$updated_at = date('Y-m-d : h:m:s');				
				$result = "";
				$dt = array(
				'customer_name'=>$customer_name,
				'firstname'=>$firstname,
				'lastname'=>$lastname,
				'cust_email'=>$cust_email,
				'cust_mobile'=>$cust_mobile,
				'is_active'=>$status,
				'user_role'=>$user_role,
				'created_at'=>$created_at,
				'updated_at'=>$updated_at,
				);
				$result = $this->Scheme_Model->insert_fun("tbl_users",$dt);
				if($result)
				{
					$customer_code = $this->get_customer_code($firstname." ".$lastname, $result);					
					$this->db->query("update tbl_users set customer_code='$customer_code' where id='$result'");					
					$password = md5($password);
					$dt = array(
					'customer_code'=>$customer_code,
					'password'=>$password,
					);
					$this->Scheme_Model->insert_fun("tbl_users_other",$dt);
					$message_db = "($property_title) -  Add Successfully.";
					$message = "Add Successfully.";
					$this->session->set_flashdata("message_type","success");
				}
				else
				{
					$message_db = "($property_title) - Not Add.";
					$message = "Not Add.";
					$this->session->set_flashdata("message_type","error");
				}
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
					redirect(base_url()."admin/$page_controllers/view");
				}
			}
		}		
		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/add",$data);
		$this->load->view("admin/header_footer/footer",$data);
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
		$query = $this->db->query("select * from $tbl order by id desc");
  		$data["result"] = $query->result();
		
		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/view",$data);
		$this->load->view("admin/header_footer/footer",$data);
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
		$upload_path = "./uploads/$page_controllers/photo/";
		$upload_thumbs_path = "./uploads/$page_controllers/photo/thumbs/";	
		$system_ip = $this->input->ip_address();		
		extract($_POST);
		if(isset($Submit))
		{
			$message_db = "";
			$this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
			$this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
			if($old_cust_email!=$cust_email)
			{
				$this->form_validation->set_rules('cust_email', 'Email', "required|trim|valid_email|is_unique[tbl_users.cust_email]",
				array(
				"is_unique"=>"<p class='font-bold  alert alert-danger m-b-sm'>This email address is already registered with us, Please use forgot password link in login or else register using a valid email address.</p>"
				));
			}
			if($old_cust_mobile!=$cust_mobile)
			{
				$this->form_validation->set_rules('cust_mobile','Mobile', "required|is_unique[tbl_users.cust_mobile]|callback_phone_check",
				array(
				"is_unique"=>"<p class='font-bold  alert alert-danger m-b-sm'>This mobile number is already registered with us, Please use forgot password link in login or else register using a valid mobile address.</p>"
				));
			}
			if($password!="")
			{
				if(md5($old_password)!=$password)
				{
					$this->form_validation->set_rules('password','Password','trim|required|min_length[6]|alpha_numeric',
					array(
					"min_length"=>"<p class='font-bold  alert alert-danger m-b-sm'>Min 6 characters length is required.</p>"
					));
				}
			}
			if ($this->form_validation->run() == FALSE)
			{
				$message = "Check Validation.";
				$this->session->set_flashdata("message_type","warning");
			}
			else
			{
				$time = time();
				$date = date("Y-m-d",$time);
				$where = array('id'=>$id);
				$customer_name = $firstname." ".$lastname;
				$user_role = "sales";
				$created_at = date('Y-m-d : h:m:s');
				$updated_at = date('Y-m-d : h:m:s');			
				$result = "";
				$dt = array(
				'customer_name'=>$customer_name,
				'firstname'=>$firstname,
				'lastname'=>$lastname,
				'cust_email'=>$cust_email,
				'cust_mobile'=>$cust_mobile,
				'is_active'=>$status,
				'user_role'=>$user_role,
				'created_at'=>$created_at,
				'updated_at'=>$updated_at,
				);
				$result = $this->Scheme_Model->edit_fun("tbl_users",$dt,$where);			
				if($result)
				{					$customer_code = $this->get_customer_code($firstname." ".$lastname, $result);				
					$this->db->query("update tbl_users set customer_code='$customer_code' where id='$id'");
					if($password!="")
					{
						if($old_password!=$password)
						{
							$password = md5($password);
						}					}
					else
					{						$password = $old_password;
					}
					$dt = array(
					'customer_code'=>$customer_code,
					'password'=>$password,
					);
					$where = array('customer_code'=>$old_customer_code);
					$this->Scheme_Model->edit_fun("tbl_users_other",$dt,$where);				
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
		$query = $this->db->query("select * from $tbl where id='$id'");
  		$data["result"] = $query->result();		
		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/edit",$data);
		$this->load->view("admin/header_footer/footer",$data);
	}	
	public function delete_rec()
	{
		$id = $_POST["id"];
		$Page_title = $this->Page_title;
		$Page_tbl = $this->Page_tbl;
		$result = $this->db->query("delete from $Page_tbl where id='$id'");
		if($result)
		{
			$message = "Delete Successfully.";
		}
		else
		{
			$message = "Not Delete.";
		}
		$message = $Page_title." - ".$message;
		$this->Admin_Model->Add_Activity_log($message);
		echo "ok";
	}	
	public function phone_check($str)
	{
		if($str!="")
		{
			if(preg_match('/^\(?[6-9]{1}\)?[0-9]{9}$/',$str))
			{
				return true;
			} else {
					$this->form_validation->set_message('phone_check', '%s '.$str.' is invalid format');
					return false;
			}
		}
	}
	function get_customer_code($customer_name, $id){
		$split_arr = preg_split( "/[\s,]/", $customer_name );
		$customer_code = "";
		foreach($split_arr as $name){
		$customer_code .= strtoupper($name[0]);
		}
		return $customer_code . $id;
	}
}