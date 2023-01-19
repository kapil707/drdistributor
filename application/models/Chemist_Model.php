<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '-1');
ini_set('post_max_size', '100M');
ini_set('upload_max_filesize', '100M');
ini_set('max_execution_time', 36000);
require_once APPPATH."/third_party/PHPExcel.php";
class Chemist_Model extends CI_Model  
{ 	
	function new_clean($string) {
		$k= str_replace('\n', '<br>', $string);
		$k= preg_replace('/[^A-Za-z0-9\#]/', ' ', $k);
		return $k;
		//return preg_replace('/[^A-Za-z0-9\#]/', '', $string); // Removes special chars.
	}	
	public function create_new($chemist_code,$phone_number)
	{
		$items = "";		
		$status1 = "0";
		$query = $this->db->query("select * from tbl_acm where altercode='$chemist_code' and slcd='CL' limit 1")->row();
		if (empty($query->id))
		{
			$status = "User account doesn't exist.";
		}
		else
		{
			$code = $query->code;
			$row1 = $this->db->query("select * from tbl_acm_other where code='$code'")->row();
			if(empty($row1->id))
			{
				$new_request = 1;
				$dt = array(
				'code'=>$code,
				'new_request'=>$new_request,
				'order_limit'=>"500",
				'website_limit'=>"500",
				'android_limit'=>"500",
				'user_phone'=>$phone_number,
				'download_status'=>0,
				);
				$this->Scheme_Model->insert_fun("tbl_acm_other",$dt);

				$subject = "Request for New Account";
				$message = "Request for New Account <br><br>Chemist Code : $chemist_code <br><br>Phone Number : $phone_number";
				
				$email_function = "new_account";
				$mail_server = "";		
				$user_email_id = "vipul@drdindia.com";

				$date = date('Y-m-d');
				$time = date("H:i",time());

				$dt = array(
					'user_email_id'=>$user_email_id,
					'subject'=>$subject,
					'message'=>$message,
					'email_function'=>$email_function,
					'mail_server'=>$mail_server,
					'date'=>$date,
					'time'=>$time,
				);
				$x = $this->Scheme_Model->insert_fun("tbl_email_send",$dt);
				if($x){
					$status1 = "1";
					$status = "Thank you for submitting your request we will get in touch with you shortly.";
				}

				/******************group message******************************/
				$group1_message 	= "Request for New Account<br><br>Chemist Code : $chemist_code<br><br>Phone Number : $phone_number";
				$whatsapp_group1 = $this->Scheme_Model->get_website_data("whatsapp_group1");
				$this->Message_Model->insert_whatsapp_group_message($whatsapp_group1,$group1_message);

				$group2_message 	= $group1_message;
				$whatsapp_group2 = $this->Scheme_Model->get_website_data("whatsapp_group2");
				$this->Message_Model->insert_whatsapp_group_message($whatsapp_group2,$group2_message);
				/**********************************************************/
			}
			else{
				$status = "User account already exists.";
			}
		}
$items.= <<<EOD
{"status":"{$status}","status1":"{$status1}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}

	public function otp($altercode,$otp_sms)
	{
		$query = $this->db->query("select tbl_acm.id,tbl_acm.code,tbl_acm.altercode,tbl_acm.name,tbl_acm.address,tbl_acm.mobile,tbl_acm.invexport,tbl_acm.email,tbl_acm.status as status1,tbl_acm_other.status,tbl_acm_other.password as password,tbl_acm_other.exp_date,tbl_acm_other.block,tbl_acm_other.image from tbl_acm left join tbl_acm_other on tbl_acm.code = tbl_acm_other.code where tbl_acm.altercode='$altercode' and tbl_acm.code=tbl_acm_other.code limit 1")->row();
		if($query->altercode)
		{
			$w_number 		= "+91".$query->mobile;//$c_cust_mobile;
			$w_altercode 	= $altercode;
			$w_message 		= $otp_sms." is otp for D.R. distributor login. Do not share it with anyone.";
			$this->Message_Model->insert_whatsapp_message($w_number,$w_message,$w_altercode);

			$subject = "D.R. distributor OTP Verify";
			$message = $w_message;

			$subject = ($subject);
			$message = ($message);
			$email_function = "password";
			$mail_server = "";

			$date = date('Y-m-d');
			$time = date("H:i",time());

			$user_email_id = $query->email;
			if (filter_var($user_email_id, FILTER_VALIDATE_EMAIL)) {		
				$dt = array(
					'user_email_id'=>$user_email_id,
					'subject'=>$subject,
					'message'=>$message,
					'email_function'=>$email_function,
					'mail_server'=>$mail_server,
					'date'=>$date,
					'time'=>$time,
					);
				$this->Scheme_Model->insert_fun("tbl_email_send",$dt);
			}
			
			$mobile = $query->mobile;
			$email 	= $query->email;

			$mobile = str_repeat('*', strlen($mobile) - 3) . substr($mobile, -3);
			$x = explode("@",$email);
			$e1 = substr($x[0], 0, 2);
			$e2 = str_repeat('*', strlen($x[0]) - 4) . substr($x[0], -2);
			$email = $e1.$e2."@".$x[1];

			return "OTP has been sent to you  on your mobile number (".$mobile.") or email address (".$email."). Please enter it below.";
		}
	}

	public function otp_resent($altercode)
	{
		$otp_sms  		  	= rand(9999,99999);
		$otp_massage_txt  	= $this->otp($altercode,$otp_sms);

$items=<<<EOD
{"otp_sms":"{$otp_sms}","otp_massage_txt":"{$otp_massage_txt}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}

	public function login($user_name1,$password1,$type="")
	{		
		$otp_type  = "0";		
		$otp_sms = $otp_massage_txt = "";
		
		$user_session = $user_fname = $user_code = $user_altercode = $user_division = $user_compcode = $user_type = $user_image = "";
		$items = "";
		$defaultpassword= $this->Scheme_Model->get_website_data("defaultpassword");
		$user_return 	= 	"0";
		$user_alert 	= 	"Logic error.";
		if(!empty($user_name1) && !empty($password1))
		{
			$user_password = md5($password1);			

			$query = $this->db->query("select tbl_acm.id,tbl_acm.code,tbl_acm.altercode,tbl_acm.name,tbl_acm.address,tbl_acm.mobile,tbl_acm.invexport,tbl_acm.email,tbl_acm.status as status1,tbl_acm_other.status,tbl_acm_other.password as password,tbl_acm_other.exp_date,tbl_acm_other.block,tbl_acm_other.image from tbl_acm left join tbl_acm_other on tbl_acm.code = tbl_acm_other.code where tbl_acm.altercode='$user_name1' and tbl_acm.code=tbl_acm_other.code limit 1")->row();
			if (!empty($query->id))
			{
				if ($query->password == $user_password || $user_password==md5($defaultpassword))
				{
					if($query->block=="0" && $query->status=="1")
					{
						$user_session 	= 	$query->id;
						$user_fname		= 	ucwords(strtolower($query->name));
						$user_code	 	= 	$query->code;
						$user_altercode	= 	$query->altercode;

						$user_image 	= 	constant('main_site')."user_profile/".$query->image;
						if(empty($query->image))
						{
							$user_image = constant('main_site')."img_v".constant('site_v')."/logo.png";
						}
						$user_type 		= 	"chemist";
						$user_return 	= 	"1";
						$user_alert 	= 	"Logged in successfully";

						if($type=="mobile")
						{							
							$otp_type 			= "1";
							$otp_sms  		  	= rand(9999,99999);
							$otp_massage_txt  	= $this->otp($query->altercode,$otp_sms);
							$user_alert 	= 	"OTP sent successfully";
						}
					}
					else
					{
						$user_alert = "Can't Login due to technical issues.";
					}
				}
				else
				{
					$user_alert = "Invalid password";
				}
			}
			else
			{
				$query = $this->db->query("select u.id,u.customer_code,u.customer_name,u.cust_addr1,u.cust_mobile,u.cust_email,u.is_active,u.user_role,u.login_expiry,u.divison,u.company_name,lu.password,lu.image	from tbl_users u left join tbl_users_other lu on lu.customer_code = u.customer_code where lu.customer_code='$user_name1' limit 1")->row();
				if (!empty($query->id))
				{
					if ($query->password == $user_password || $user_password==md5($defaultpassword))
					{
						$user_session 	= 	$query->id;
						$user_fname		= 	ucwords(strtolower($query->customer_name));
						$user_image 	= 	constant('main_site')."user_profile/".$query->image;
						if(empty($query->image))
						{
							$user_image = constant('main_site')."img_v".constant('site_v')."/logo.png";
						}
						$user_code	 	= 	$query->customer_code;
						$user_altercode	= 	$query->customer_code;
						$user_type 		= 	"sales";
						$user_return 	= 	"1";
						$user_alert 	= 	"Logged in successfully";
					}
					else
					{
						$user_alert = "Invalid password";
					}
				}
				else
				{
					$query = $this->db->query("select tbl_staffdetail.compcode,tbl_staffdetail.division,tbl_staffdetail.id,tbl_staffdetail.code,tbl_staffdetail.degn as name, tbl_staffdetail.mobilenumber as mobile,tbl_staffdetail.memail as email,tbl_staffdetail_other.status,tbl_staffdetail_other.password from tbl_staffdetail left join tbl_staffdetail_other on tbl_staffdetail.code = tbl_staffdetail_other.code where tbl_staffdetail.memail='$user_name1' and tbl_staffdetail.code=tbl_staffdetail_other.code limit 1")->row();
					if (!empty($query->id))
					{
						if ($query->password == $user_password)
						{
							if($query->status==1)
							{
								$user_session 	= 	$query->id;
								$user_fname		= 	ucwords(strtolower($query->name));
								$user_code	 	= 	$query->code;
								$user_altercode	= 	$query->code;
								$user_type 		= 	"corporate";
								$user_return 	= 	"1";
								$user_alert 	= 	"Logged in successfully";
								$user_division	= 	$query->division;
								$user_compcode	= 	$query->compcode;
								$user_image = constant('img_url_site')."img_v".constant('site_v')."/logo.png";
							}
							else
							{
								$user_alert = "Access denied";
							}
						}
						else
						{
							$user_alert = "Invalid password";
						}
					}
					else{
						$user_alert = "Invalid username & password";
					}
				}
			}
		}
		

$items.= <<<EOD
{"user_session":"$user_session","user_fname":"$user_fname","user_code":"$user_code","user_altercode":"$user_altercode","user_type":"$user_type","user_password":"$user_password","user_alert":"$user_alert","user_image":"$user_image","user_return":"$user_return","user_division":"$user_division","user_compcode":"$user_compcode","otp_type":"$otp_type","otp_sms":"$otp_sms","otp_massage_txt":"$otp_massage_txt"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function insert_value_on_session($user_session='',$user_fname='',$user_code='',$user_altercode='',$user_type='',$user_password='',$user_division='',$user_compcode='',$user_image='') 
	{		
		$session_arr = array('user_session'=>$user_session,'user_fname'=>$user_fname,'user_code'=>$user_code,'user_altercode'=>$user_altercode,'user_type'=>$user_type,'user_password'=>$user_password,'user_division'=>$user_division,'user_compcode'=>$user_compcode,'user_image'=>$user_image);

		setcookie("user_session", $user_session, time() + (86400 * 30), "/");
		setcookie("user_fname", $user_fname, time() + (86400 * 30), "/");
		setcookie("user_code", $user_code, time() + (86400 * 30), "/");
		setcookie("user_altercode", $user_altercode, time() + (86400 * 30), "/");
		setcookie("user_type", $user_type, time() + (86400 * 30), "/");
		setcookie("user_password", $user_password, time() + (86400 * 30), "/");
		setcookie("user_division", $user_division, time() + (86400 * 30), "/");
		setcookie("user_compcode", $user_compcode, time() + (86400 * 30), "/");
		setcookie("user_image", $user_image, time() + (86400 * 30), "/");

		//$this->session->set_userdata($session_arr);
		
		$login_time = time();
		$update_time = date("YmdHi", strtotime("+15 minutes", $login_time));
		$row = $this->db->query("select * from drd_login_time where user_altercode='$user_altercode' and user_type='$user_type'")->row();
		if($row->id=="")
		{
			$this->db->query("insert into drd_login_time set user_altercode='$user_altercode',user_type='$user_type',login_time='$login_time',update_time='$update_time'");
		}
		else
		{
			$this->db->query("update drd_login_time set login_time='$login_time',update_time='$update_time' where user_altercode='$user_altercode' and user_type='$user_type'");
		}
		
		return "1";
	}

	public function user_account($user_type,$user_altercode)
	{
		$items = "";
		if($user_type=="chemist")
		{
			$row = $this->db->query("select * from tbl_acm where altercode='$user_altercode' and slcd='CL'")->row();
			if(!empty($row->id))
			{
				$id			= ($row->id);
				$name 		= (ucwords(strtolower($row->name)));
				$altercode  = ($row->altercode);
				$mobile 	= ($row->mobile);
				$email 		= ($row->email);
				$address 	= ($row->address);
				$gstno 		= ($row->gstno);				
				$where= array('code'=>$row->code);
				$row1 = $this->Scheme_Model->select_row("tbl_acm_other",$where);

				$user_profile = constant('img_url_site')."user_profile/$row1->image";
				if(empty($row1->image))
				{
					$user_profile = constant('img_url_site')."img_v".constant('site_v')."/logo.png";
				}
				$status		= ($row1->status);
				if($status)
				{
					$status = "Active";
				}
				else
				{
					$status = "Inactive";
				}
			}
		}
		
		if($user_type=="sales")
		{
			$row = $this->db->query("select * from tbl_users where customer_code='$user_altercode'")->row();
			if(!empty($row->id))
			{
				$id			= ($row->id);
				$name 		= (ucwords(strtolower($row->customer_name)));
				$altercode  = ($row->customer_code);
				$mobile 	= ($row->cust_mobile);
				$email 		= ($row->cust_email);
				$address 	= ($row->cust_addr1);
				$gstno 		= "";
				$status		= "1";

				$where= array('customer_code'=>$row->customer_code);
				$row1 = $this->Scheme_Model->select_row("tbl_users_other",$where);

				$user_profile = constant('img_url_site')."user_profile/$row1->image";
				if(empty($row1->image))
				{
					$user_profile = constant('img_url_site')."img_v".constant('site_v')."/logo.png";
				}
				if($status=="1")
				{
					$status = "Active";
				}
			}
		}
$items.= <<<EOD
{"id":"{$id}","name":"{$name}","altercode":"{$altercode}","mobile":"{$mobile}","email":"{$email}","address":"{$address}","gstno":"{$gstno}","status":"{$status}","user_profile":"{$user_profile}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}

	public function check_user_account($user_type,$user_altercode)
	{
		$items = "";
		if($user_type=="chemist")
		{
			$row = $this->db->query("select * from tbl_acm where altercode='$user_altercode' and slcd='CL'")->row();
			if($row->id!="")
			{
				$id			= ($row->id);
				$row1 = $this->db->query("select * from tbl_acm_other where code='$row->code'")->row();
				$user_phone		= ($row1->user_phone);
				$user_email		= ($row1->user_email);
				$user_address	= ($row1->user_address);
				$user_update	= ($row1->user_update);
			}
		}
		
		if($user_type=="sales")
		{
			$row = $this->db->query("select * from tbl_users where customer_code='$user_altercode'")->row();
			if($row->id!="")
			{
				$user_phone		= ($row->user_phone);
				$user_email		= ($row->user_email);
				$user_address	= ($row->user_address);
				$user_update	= ($row->user_update);
			}
		}
$items .= <<<EOD
{"user_phone":"{$user_phone}","user_email":"{$user_email}","user_address":"{$user_address}","user_update":"{$user_update}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function update_user_account($user_type,$user_altercode,$user_phone,$user_email,$user_address)
	{
		$items = "";
		$status = $status1 = "";
		if($user_type=="chemist")
		{
			$row = $this->db->query("select * from tbl_acm where altercode='$user_altercode' and slcd='CL'")->row();
			if($row->id!="")
			{
				$code = ($row->code);
				$this->db->query("update tbl_acm_other set user_phone='$user_phone',user_email='$user_email',user_address='$user_address',user_update='1' where code='$code'");
				$status = "Request has been sent. Your account will update soon.";
				$status1 = "1";
			}
			else
			{
				$status = "Logic error.";
			}
		}
		
		if($user_type=="sales")
		{
			$status1 = "";
			$row = $this->db->query("select * from tbl_users where customer_code='$user_altercode' and slcd='CL'")->row();
			if($row->id!="")
			{
				$code = ($row->customer_code);
				$this->db->query("update tbl_users_other set user_phone='$user_phone',user_email='$user_email',user_address='$user_address',user_update='1' where customer_code='$code'");
				$status = "Request has been sent";
				$status1 = "1";
			}
			else
			{
				$status = "Logic error.";
			}
		}
$items .= <<<EOD
{"status":"{$status}","status1":"{$status1}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}

	public function check_old_password($user_type,$user_altercode,$user_password)
	{
		$user_password = md5($user_password);
		$items = "";
		$status = "Oldpassword doesn't match";
		$status1 = "0";
		if($user_type=="chemist")
		{
			$query = $this->db->query("select tbl_acm.id,tbl_acm.code,tbl_acm.altercode,tbl_acm.name,tbl_acm.address,tbl_acm.mobile,tbl_acm.invexport,tbl_acm.email,tbl_acm.status as status1,tbl_acm_other.status,tbl_acm_other.password as password,tbl_acm_other.exp_date,tbl_acm_other.block,tbl_acm_other.image from tbl_acm left join tbl_acm_other on tbl_acm.code = tbl_acm_other.code where tbl_acm.altercode='$user_altercode' and tbl_acm.code=tbl_acm_other.code limit 1")->row();
			if ($query->id!="")
			{
				if ($query->password == $user_password && $query->block=="0" && $query->status=="1")
				{
					$status = "Oldpassword doesn't match";
					$status1 = "1";
				}
			}
		}
		
		if($user_type=="sales")
		{
			$query = $this->db->query("select u.id,u.customer_code,u.customer_name,u.cust_addr1,u.cust_mobile,u.cust_email,u.is_active,u.user_role,u.login_expiry,u.divison,u.company_name,lu.password	from tbl_users u left join tbl_users_other lu on lu.customer_code = u.customer_code where lu.customer_code='$user_altercode' limit 1")->row();
			if ($query->id!="")
			{
				if ($query->password == $user_password)
				{
					$status = "Oldpassword doesn't match";
					$status1 = "1";
				}
			}
		}
$items .= <<<EOD
{"status":"{$status}","status1":"{$status1}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}

	public function change_password($user_type,$user_altercode,$user_password,$new_password)
	{
		$user_password = md5($user_password);
		$items = "";
		$status = "Oldpassword doesn't match";
		$status1 = "0";
		if($user_type=="chemist")
		{
			$query = $this->db->query("select tbl_acm.id,tbl_acm.code,tbl_acm.altercode,tbl_acm.name,tbl_acm.address,tbl_acm.mobile,tbl_acm.invexport,tbl_acm.email,tbl_acm.status as status1,tbl_acm_other.status,tbl_acm_other.password as password,tbl_acm_other.exp_date,tbl_acm_other.block,tbl_acm_other.image from tbl_acm left join tbl_acm_other on tbl_acm.code = tbl_acm_other.code where tbl_acm.altercode='$user_altercode' and tbl_acm.code=tbl_acm_other.code limit 1")->row();
			if ($query->id!="")
			{
				if ($query->password == $user_password && $query->block=="0" && $query->status=="1")
				{
					$code = $query->code;
					$new_password = md5($new_password);
					$this->db->query("update tbl_acm_other set password='$new_password',download_status=0 where code='$code'");
					$status = "Updated successfully";
					$status1 = "1";
				}
				else
				{
					$status = "Oldpassword doesn't match";
				}
			}
			else
			{
				$status = "Logic error.";
			}
		}
		
		if($user_type=="sales")
		{
			$query = $this->db->query("select u.id,u.customer_code,u.customer_name,u.cust_addr1,u.cust_mobile,u.cust_email,u.is_active,u.user_role,u.login_expiry,u.divison,u.company_name,lu.password	from tbl_users u left join tbl_users_other lu on lu.customer_code = u.customer_code where lu.customer_code='$user_altercode' limit 1")->row();
			if ($query->id!="")
			{
				if ($query->password == $user_password)
				{
					$code = $query->customer_code;
					$new_password = md5($new_password);
					$this->db->query("update tbl_users_other set password='$new_password',download_status=0 where customer_code='$code'");
					$status = "Password Change Successfully";
					$status1 = "1";
				}
				else
				{
					$status = "Oldpassword doesn't match";
				}
			}
			else
			{
				$status = "Logic error.";
			}
		}
$items.= <<<EOD
{"status":"{$status}","status1":"{$status1}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}

	public function top_flash()
	{
		$items = "";
		$i = 1;
		$this->db->where("status=1");
		$this->db->order_by('RAND()');
		$query = $this->db->get("tbl_slider")->result();
		foreach ($query as $row)
		{
			if($i==1)
			{
				$id	=	"active";
			}
			else{
				$id = "";
			}
			$i++;
			$compname="";
			if($row->funtype=="1"){ 				
			}
			if($row->funtype=="2" || $row->funtype=="3"){
				$row->itemid = $row->compid; 
				$row1 = $this->db->query("select company_full_name from tbl_medicine where compcode='$row->itemid'")->row();
				$compname = ($row1->company_full_name);
			}
			$funtype	=	$row->funtype;
			$itemid	    =	$row->itemid;
			$division	=	$row->division;
			$image 		= 	constant('img_url_site')."uploads/manage_slider/photo/resize/".$row->image;
			
$items.= <<<EOD
{"id":"{$id}","funtype":"{$funtype}","itemid":"{$itemid}","division":"{$division}","image":"{$image}","compname":"{$compname}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function top_flash2()
	{
		//error_reporting(0);
		$items = "";
		$i = 1;
		$this->db->where("status=1");
		$this->db->order_by('RAND()');
		$query = $this->db->get("tbl_slider2")->result();
		foreach ($query as $row)
		{
			if($i==1)
			{
				$id	=	"active";
			}
			else{
				$id = "";
			}
			$i++;
			$compname="";
			if($row->funtype=="1"){			
			}
			if($row->funtype=="2" || $row->funtype=="3"){
				$row->itemid = $row->compid; 
				$row1 =  $this->db->query("select company_full_name from tbl_medicine where compcode='$row->itemid'")->row();
				//$compname = base64_decode($row1->company_full_name);
				$compname = ($row1->company_full_name);
			}
			$funtype	=	$row->funtype;
			$itemid	    =	$row->itemid;
			$division	=	$row->division;
			$image 		= 	constant('img_url_site')."uploads/manage_slider2/photo/resize/".$row->image;
			
$items.= <<<EOD
{"id":"{$id}","funtype":"{$funtype}","itemid":"{$itemid}","division":"{$division}","image":"{$image}","compname":"{$compname}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function search_medicine($keyword)
	{
		//error_reporting(0);
		$sameid = "";
		$items = "";
		$count = 0;
		$date_time = date('d-M h:i A');
		$items = "";
		$keyword = str_replace("'","",$keyword);
		$keyword_title = str_replace("-","",$keyword);
		$keyword_title = str_replace(".","",$keyword_title);
		$keyword_title = str_replace("`","",$keyword_title);
		$keyword_title = str_replace("'","",$keyword_title);
		$keyword_title = str_replace("/","",$keyword_title);
		$keyword_title = str_replace("(","",$keyword_title);
		$keyword_title = str_replace(")","",$keyword_title);
		$keyword_title = str_replace("%","",$keyword_title);
		$keyword_title = str_replace(",","",$keyword_title);		
		$keyword_title = str_replace("%20","",$keyword_title);
		$keyword_title = str_replace(" ","",$keyword_title);
		
		$keyword_name = str_replace("%20"," ",$keyword);
		
		$this->db->select("m.*");
		$this->db->where("(title='$keyword_title' or title like '".$keyword_title."%' or item_name='$keyword_title' or item_name='$keyword_name' or item_name like '".$keyword_name."%' or company_full_name='$keyword_title' or company_full_name like '".$keyword_name."%') and status=1");
		$this->db->limit(20);
		$this->db->order_by('m.item_name','asc');
		$query = $this->db->get("tbl_medicine as m")->result();
		foreach ($query as $row)
		{
			$id		=	$row->id;
			$items.=$this->search_medicine_new($row,$id,$count,$date_time);
			$count++;
			
			$sameid.= $id.",";
		}
		$sameid = substr($sameid,0,-1);
		if(!empty($sameid))
		{
			$sameid = " and m.id not in(".$sameid.")";
		}
		
		$this->db->select("m.*");
		$this->db->where("(title like '%".$keyword_title."%' or item_name like '%".$keyword_name."%' or company_full_name like '%".$keyword_name."%') and status=1 ".$sameid);
		$this->db->limit(20);
		$this->db->order_by('m.item_name','asc');
		$query = $this->db->get("tbl_medicine as m")->result();
		foreach ($query as $row)
		{
			$id	= $row->id;
			$items.=$this->search_medicine_new($row,$id,$count,$date_time);
			$count++;
		}
if ($items != ''){
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function search_medicine_new($row,$id,$count,$date_time)
	{
		$i_code				=	$row->i_code;
		$item_code			=	$row->item_code;
		$title				=	$row->title;
		$item_name			=	htmlentities(ucwords(strtolower($row->item_name)));
		$company_name		=	htmlentities(ucwords(strtolower($row->company_name)));
		$company_full_name 	=  	htmlentities(ucwords(strtolower($row->company_full_name)));
		$batchqty			=	$row->batchqty;
		$batch_no			=	htmlentities($row->batch_no);
		$packing			=	htmlentities($row->packing);
		$sale_rate			=	sprintf('%0.2f',round($row->sale_rate,2));
		$mrp				=	sprintf('%0.2f',round($row->mrp,2));
		$final_price		=	sprintf('%0.2f',round($row->final_price,2));
		$scheme				=	$row->salescm1."+".$row->salescm2;
		$expiry				=	$row->expiry;				
		$compcode 			=   $row->compcode;				
		$item_date 			=   $row->item_date;
		$margin 			=   round($row->margin);				
		$misc_settings		=   $row->misc_settings;
		$gstper				=	$row->gstper;
		$itemjoinid			=	$row->itemjoinid;
		$featured 			= 	$row->featured;
		$discount 			= 	$row->discount;
		
		if(empty($discount))
		{
			$discount = "4.5";
		}
		
		$description1 = $this->new_clean(trim($row->title2));
		$description2 = $this->new_clean(trim($row->description));
		$image1 = constant('img_url_site')."uploads/default_img.jpg";
		$image2 = constant('img_url_site')."uploads/default_img.jpg";
		$image3 = constant('img_url_site')."uploads/default_img.jpg";
		$image4 = constant('img_url_site')."uploads/default_img.jpg";
		if(!empty($row->image1))
		{
			$image1 = constant('img_url_site').$row->image1;
		}
		if(!empty($row->image2))
		{
			$image2 = constant('img_url_site').$row->image2;
		}
		if(!empty($row->image3))
		{
			$image3 = constant('img_url_site').$row->image3;
		}
		if(!empty($row->image4))
		{
			$image4 = constant('img_url_site').$row->image4;
		}
		
		$itemjoinid = "";
		$items1 = "";
		if($itemjoinid!="")
		{
			$itemjoinid1 = explode (",", $itemjoinid);
			foreach($itemjoinid1 as $item_code_n)
			{
				$items1.= $this->get_itemjoinid($item_code_n);
			}
			if (!empty($items1)) {
				$items1 = substr($items1, 0, -1);
			}
			
			if (!empty($items1)) {
				$items1 = ',"items1":['.$items1.']';
			} else{
				$itemjoinid = "";
				$items1 = ',"items1":""';
			}
		}
		else
		{
			$items1 = ',"items1":""';
		}
		/********************************************************/
		//$itemjoinid			=	base64_encode($row->itemjoinid);

$items= <<<EOD
{"count":"{$count}","i_code":"{$i_code}","item_code":"{$item_code}","date_time":"{$date_time}","title":"{$title}","item_name":"{$item_name}","company_name":"{$company_name}","company_full_name":"{$company_full_name}","image1":"{$image1}","image2":"{$image2}","image3":"{$image3}","image4":"{$image4}","description1":"{$description1}","description2":"{$description2}","batchqty":"{$batchqty}","sale_rate":"{$sale_rate}","mrp":"{$mrp}","final_price":"{$final_price}","batch_no":"{$batch_no}","packing":"{$packing}","expiry":"{$expiry}","scheme":"{$scheme}","margin":"{$margin}","featured":"{$featured}","gstper":"{$gstper}","discount":"{$discount}","misc_settings":"{$misc_settings}","itemjoinid":"{$itemjoinid}"$items1},
EOD;
		return $items;
	}


	public function medicine_search_api($keyword="",$search_type="",$get_record="")
	{
		//error_reporting(0);
		$sameid = "";
		$items = "";
		$count = 1;
		$date_time = date('d-M h:i A');
		$items = "";
		$keyword = str_replace("'","",$keyword);
		$keyword_title = str_replace("-","",$keyword);
		$keyword_title = str_replace(".","",$keyword_title);
		$keyword_title = str_replace("`","",$keyword_title);
		$keyword_title = str_replace("'","",$keyword_title);
		$keyword_title = str_replace("/","",$keyword_title);
		$keyword_title = str_replace("(","",$keyword_title);
		$keyword_title = str_replace(")","",$keyword_title);
		$keyword_title = str_replace("%","",$keyword_title);
		$keyword_title = str_replace(",","",$keyword_title);		
		$keyword_title = str_replace("%20","",$keyword_title);
		$keyword_title = str_replace(" ","",$keyword_title);
		
		$keyword_name = str_replace("%20"," ",$keyword);

		$this->db->select("m.*");
		$this->db->where("(title='$keyword_title' or title like '".$keyword_title."%' or item_name='$keyword_title' or item_name='$keyword_name' or item_name like '".$keyword_name."%') and status=1");
		if($search_type=="all")
		{
			$this->db->limit(12,$get_record);
			$this->db->order_by('m.item_name asc');
		}
		else
		{
			$this->db->limit(25);
			$this->db->order_by('m.batchqty desc','m.item_name asc');
		}
		$query = $this->db->get("tbl_medicine as m")->result();
		foreach ($query as $row)
		{
			$get_record++;
			$id		=	$row->id;
			$items.=$this->search_medicine2_new($row,$id,$count,$date_time,$get_record);
			$count++;
			
			$sameid.= $id.",";
		}
		$sameid = substr($sameid,0,-1);
		if(!empty($sameid))
		{
			$sameid = " and m.id not in(".$sameid.")";
		}
		
		$this->db->select("m.*");
		$this->db->where("(title like '%".$keyword_title."%' or item_name like '%".$keyword_name."%' or company_full_name like '%".$keyword_name."%' or packing like '".$keyword_name."' or title2 like '".$keyword_name."%' or description like '%".$keyword_name."' or company_full_name='$keyword_title' or company_full_name like '".$keyword_name."%') and status=1 ".$sameid);
		if($search_type=="all")
		{
			$this->db->limit(12,$get_record);
			$this->db->order_by('m.item_name asc');
		}
		else
		{
			$this->db->limit(25);
			$this->db->order_by('m.batchqty desc','m.item_name asc');
		}
		$query = $this->db->get("tbl_medicine as m")->result();
		foreach ($query as $row)
		{			
			$get_record++;
			$id	= $row->id;
			$items.=$this->search_medicine2_new($row,$id,$count,$date_time,$get_record);
			$count++;
		}
if ($items != ''){
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function search_medicine2_new($row,$id,$count,$date_time,$get_record)
	{
		$item_code			=	$row->i_code;
		$item_name			=	htmlentities(ucwords(strtolower($row->item_name)));
		$item_packing		=	htmlentities($row->packing);
		$item_expiry		=	htmlentities($row->expiry);
		$item_company		=	htmlentities(ucwords(strtolower($row->company_full_name)));
		$item_quantity		=	$row->batchqty;
		$item_ptr			=	sprintf('%0.2f',round($row->sale_rate,2));
		$item_mrp			=	sprintf('%0.2f',round($row->mrp,2));
		$item_price			=	sprintf('%0.2f',round($row->final_price,2));
		
		$item_description1  = 	htmlentities(trim($row->title2));
		$item_description1  =   $this->new_clean($item_description1);
		$item_image = constant('img_url_site')."uploads/default_img.jpg";
		if(!empty($row->image1))
		{
			$item_image = constant('img_url_site').$row->image1;
		}
		$item_image = str_replace(" ","%20",$item_image);

		$item_scheme		=	$row->salescm1."+".$row->salescm2;
		$item_margin 		=   round($row->margin);
		$item_featured 		= 	$row->featured;
		$misc_settings 		= 	$row->misc_settings;

		$item_stock = "";
		if($misc_settings=="#NRX" && $item_quantity>=10){
			$item_stock = "Available";
		}
		
		$similar_items = "";
		$itemjoinid = 	$row->itemjoinid;
		if($itemjoinid!="")
		{
			$similar_items = "View similar items";
		}

$items=<<<EOD
{"item_code":"{$item_code}","item_image":"{$item_image}","item_name":"{$item_name}","item_packing":"{$item_packing}","item_expiry":"{$item_expiry}","item_company":"{$item_company}","item_quantity":"{$item_quantity}","item_stock":"{$item_stock}","item_ptr":"{$item_ptr}","item_mrp":"{$item_mrp}","item_price":"{$item_price}","item_scheme":"{$item_scheme}","item_margin":"{$item_margin}","item_featured":"{$item_featured}","item_description1":"{$item_description1}","similar_items":"{$similar_items}","count":"{$count}","get_record":"{$get_record}"},
EOD;
		return $items;
	}
	
	public function import_order_dropdownbox($keyword,$item_mrp,$u_type="site")
	{
		$items = "";
		
		$keyword_title = str_replace("-","",$keyword);
		$keyword_title = str_replace(".","",$keyword_title);
		$keyword_title = str_replace("`","",$keyword_title);
		$keyword_title = str_replace("'","",$keyword_title);
		$keyword_title = str_replace("/","",$keyword_title);
		$keyword_title = str_replace("(","",$keyword_title);
		$keyword_title = str_replace(")","",$keyword_title);
		$keyword_title = str_replace("%","",$keyword_title);
		$keyword_title = str_replace(","," ",$keyword_title);

		$just_title    = $keyword_title;
		$just_title = str_replace("%20",",",$just_title);
		$just_title = str_replace(" ",",",$just_title);

		$keyword_title = str_replace("%20","",$keyword_title);
		$keyword_title = str_replace(" ","",$keyword_title);
		
		$keyword_name = str_replace("%20"," ",$keyword);
		
		$candi_0 = $candi_1 = $candi_2 = $candi_3 = $candi_4 = $candi_5 = $candi_6 = $candi_7 = $candi_8 = $candi_9 = "";
		/*********************************************************/
		$this->db->select("i_code,mrp");
		$this->db->where("(title like '".$keyword_title."%') and status='1' and batchqty!='0'");
		$this->db->order_by('item_name','asc');
		$this->db->limit(1);
		$query = $this->db->get("tbl_medicine")->result();
		$candi_0 = $this->import_order_dropdownbox_dt($query,"not","0");
		if(!empty($candi_0["i_code"]))
		{
			$items = $candi_0;
			//echo "ok00";
		}

		/*********************************************************/
		if(empty($candi_0["i_code"]))
		{
			$this->db->select("i_code,mrp");
			$this->db->where("(title like '".$keyword_title."%') and status='1'");
			$this->db->order_by('item_name','asc');
			$this->db->limit(1);
			$query = $this->db->get("tbl_medicine")->result();
			$candi_1 = $this->import_order_dropdownbox_dt($query,$item_mrp,"1");
			if(!empty($candi_1["i_code"]))
			{
				$items = $candi_1;
				//echo "ok01";
			}
		}
		
		/*********************************************************/
		if(empty($candi_1["i_code"]))
		{
			$this->db->select("i_code,mrp");
			$this->db->where("(item_name like '".$keyword_name."%' or title like '%".$keyword_title."%' or company_full_name like '".$keyword_name."%') and status='1'");
			$this->db->order_by('item_name','asc');
			$this->db->limit(1);
			$query = $this->db->get("tbl_medicine")->result();
			$candi_2 = $this->import_order_dropdownbox_dt($query,$item_mrp,"1");
			if(!empty($candi_2["i_code"]))
			{
				$items = $candi_2;
				//echo "ok02";
			}
		}
		
		if(empty($candi_0["i_code"]) && empty($candi_1["i_code"]) && empty($candi_2["i_code"]))
		{
			$value3 = $keyword_name;
			for($i=0;$i<strlen($keyword_name);$i++)
			{
				if(empty($candi_3))
				{
					$candi_3 = $this->import_order_dropdownbox_dt1($value3,$item_mrp,"1");
					$value3 = substr($value3, 0, -1);
				}
			}
			//echo "ok03";
		}
		
		if(empty($candi_0["i_code"]) && empty($candi_1["i_code"]) && empty($candi_2["i_code"]) && empty($candi_3["i_code"]))
		{
			$value4 = $keyword_name;
			for($i=0;$i<strlen($keyword_name);$i++)
			{
				if(empty($candi_4))
				{
					$candi_4 = $this->import_order_dropdownbox_dt2($value4,$item_mrp,"1");
					$value4 = substr($value4, 0, -1);
					if(strlen($value4)<6)
					{
						break;
					}
				}
			}
			//echo "ok04";
		}
		
		if(empty($candi_0["i_code"]) && empty($candi_1["i_code"]) && empty($candi_2["i_code"]) && empty($candi_3["i_code"]) && empty($candi_4["i_code"]))
		{
			$value5 = $keyword_title;
			for($i=0;$i<strlen($keyword_title);$i++)
			{
				if(empty($candi_5))
				{
					$candi_5 = $this->import_order_dropdownbox_dt2($value5,"not","0");
					$value5 = substr($value5, 0, -1);
					if(strlen($value5)<6)
					{
						break;
					}
				}
			}
			//echo "ok05";
		}
		
		if(!empty($candi_3["i_code"]))
		{
			$items = $candi_3;
		}
		
		if(!empty($candi_4["i_code"]))
		{
			$items = $candi_4;
		}
		if(!empty($candi_5["i_code"]))
		{
			$items = $candi_5;
		}
		/**** new crete by 26-03-2021****jab same name ki davi but def mrp h to*/
		if(empty($candi_0["i_code"]) && empty($candi_1["i_code"]) && empty($candi_2["i_code"]) && empty($candi_3["i_code"]) && empty($candi_4["i_code"]) && empty($candi_5["i_code"]))
		{
			$this->db->select("i_code,mrp");
			$this->db->where("(item_name='".$keyword_name."') and status='1'");
			$this->db->order_by('item_name','asc');
			$this->db->limit(1);
			$query = $this->db->get("tbl_medicine")->result();
			$candi_6 = $this->import_order_dropdownbox_dt($query,"not","0");
			//echo "ok061";
		}
		if(!empty($candi_6["i_code"]))
		{
			$items = $candi_6;
		}
		
		if($u_type=="admin")
		{	
			/**** new crete by 14-05-2021****jab same name ki davi but def mrp h to*/
			if(empty($candi_0["i_code"]) && empty($candi_1["i_code"]) && empty($candi_2["i_code"]) && empty($candi_3["i_code"]) && empty($candi_4["i_code"]) && empty($candi_5["i_code"]) && empty($candi_6["i_code"]))
			{
				$value7 = $keyword_title;
				for($i=0;$i<strlen($keyword_title);$i++)
				{
					if(empty($candi_7["i_code"]))
					{
						$candi_7 = $this->import_order_dropdownbox_dt1($value7,"not","0");
						$value7 = substr($value7, 0, -1);
						if(strlen($value7)<10)
						{
							break;
						}
					}
				}
				//echo "ok07";
			}
			if(!empty($candi_7["i_code"]))
			{
				$items = $candi_7;
			}
			
			/**** new crete by 20-10-2021****jab same name ki davi but def mrp h to*/
			if(empty($candi_0["i_code"]) && empty($candi_1["i_code"]) && empty($candi_2["i_code"]) && empty($candi_3["i_code"]) && empty($candi_4["i_code"]) && empty($candi_5["i_code"]) && empty($candi_6["i_code"]) && empty($candi_7["i_code"]))
			{
				$value8 = $keyword_title;
				$value8 = str_replace("*","",$value8);
				for($i=0;$i<strlen($keyword_title);$i++)
				{
					if(empty($candi_8["i_code"]))
					{
						$candi_8 = $this->import_order_dropdownbox_dt1($value8,$item_mrp,"1");
						$value8 = substr($value8, 0, -1);
						if(strlen($value8)<9)
						{
							break;
						}
					}
				}
				//echo "ok08";
			}
			if(!empty($candi_8["i_code"]))
			{
				$items = $candi_8;
			}
		}
		
		if($u_type=="site")
		{
			if(empty($candi_0["i_code"]) && empty($candi_1["i_code"]) && empty($candi_2["i_code"]) && empty($candi_3["i_code"]) && empty($candi_4["i_code"]) && empty($candi_5["i_code"]) && empty($candi_6["i_code"]))
			{
				$value7 = $keyword_title;
				for($i=0;$i<strlen($keyword_title);$i++)
				{
					if(empty($candi_7["i_code"]))
					{
						$candi_7 = $this->import_order_dropdownbox_dt1($value7,"not","0");
						$value7 = substr($value7, 0, -1);
						if(strlen($value7)<4)
						{
							break;
						}
					}
				}
				//echo "ok07";
			}
			if(!empty($candi_7["i_code"]))
			{
				$items = $candi_7;
			}
			/**** new crete by 20-10-2021****jab same name ki davi but def mrp h to*/
			if(empty($candi_0["i_code"]) && empty($candi_1["i_code"]) && empty($candi_2["i_code"]) && empty($candi_3["i_code"]) && empty($candi_4["i_code"]) && empty($candi_5["i_code"]) && empty($candi_6["i_code"]) && empty($candi_7["i_code"]))
			{
				$value8 = $keyword_title;
				$value8 = str_replace("*","",$value8);
				for($i=0;$i<strlen($keyword_title);$i++)
				{
					if(empty($candi_8["i_code"]))
					{
						$candi_8 = $this->import_order_dropdownbox_dt2($value8,"not","0");
						if(strlen($value8)<4)
						{
							break;
						}
					}
				}
				//echo "ok08";
			}
			if(!empty($candi_8["i_code"]))
			{
				$items = $candi_8;
			}
			
			/**** new crete by 20-10-2021****jab same name ki davi but def mrp h to*/
			if(empty($candi_0["i_code"]) && empty($candi_1["i_code"]) && empty($candi_2["i_code"]) && empty($candi_3["i_code"]) && empty($candi_4["i_code"]) && empty($candi_5["i_code"]) && empty($candi_6["i_code"]) && empty($candi_7["i_code"]) && empty($candi_8["i_code"]))
			{
				$value9 = $keyword_title;
				$value9 = str_replace("*","",$value9);
				for($i=strlen($value9);$i>0;$i--)
				{
					if(empty($candi_9["i_code"]))
					{
						$x = $i - strlen($value9);
						$value9_ = substr($value9, 0, $x);
						$candi_9 = $this->import_order_dropdownbox_dt2($value9_,"not","0");
					}
				}
				//echo "ok09";
			}
			if(!empty($candi_9["i_code"]))
			{
				$items = $candi_9;
			}
		}
		return $items;
	}
	
	public function import_order_dropdownbox_dt1($keyword,$item_mrp,$type)
	{		
		/*********************************************************/
		$this->db->select("i_code,mrp");
		$this->db->where("(item_name like '".$keyword."%' or title like '%".$keyword."%' or company_full_name like '".$keyword."%' ) and status='1'");
		$this->db->order_by('item_name','asc');
		$this->db->limit(1);
		$query = $this->db->get("tbl_medicine")->result();
		return $this->import_order_dropdownbox_dt($query,$item_mrp,$type);
	}
	
	public function import_order_dropdownbox_dt2($keyword,$item_mrp,$type)
	{		
		/*********************************************************/
		$this->db->select("i_code,mrp");
		$this->db->where("(title like '".$keyword."%' or title like '%".$keyword."%' or title like '%".$keyword."') and status='1'");
		$this->db->order_by('item_name','asc');
		$this->db->limit(1);
		$query = $this->db->get("tbl_medicine")->result();
		return $this->import_order_dropdownbox_dt($query,$item_mrp,$type);
	}

	public function import_order_dropdownbox_dt3($keyword,$item_mrp,$type)
	{		
		/*********************************************************/
		$keyword = explode(",", $keyword);
		$keyword = shuffle($keyword);
		$keyword_other = "";
		$this->db->select("i_code,mrp");
		foreach($keyword as $row)
		{
			$keyword_other.= "title like '".$row."%' or ";
		}
		echo $keyword_other = substr($keyword_other, 0, -3);die;
		$this->db->where($keyword_other."and status='1'");
		$this->db->order_by('item_name','asc');
		$this->db->limit(1);
		$query = $this->db->get("tbl_medicine")->result();
		return $this->import_order_dropdownbox_dt($query,$item_mrp,$type);
	}
	
	public function import_order_dropdownbox_dt($query,$item_mrp,$type)
	{
		if(empty($type)){
			$type = 0;
		}
		$ret["i_code"] = "";
		$ret["mrp"]  = $item_mrp;
		$ret["type"] = $type;
		foreach ($query as $row)
		{
			if(round($item_mrp)==round($row->mrp) || $item_mrp=="not")
			{
				$i_code	=	$row->i_code;
				$mrp	=	$row->mrp;						
				if($i_code!=0 && $i_code!=-1)
				{
					$ret["i_code"] = $i_code;
					$ret["mrp"] = $mrp;
					$ret["type"] = $type;
				}
			}
		}
		return $ret;
	}
	
	public function get_itemjoinid($item_code)
	{
		//error_reporting(0);
		$items2 = "";
		$this->db->select("m.*");
		$where = array('item_code'=>$item_code);
		$this->db->where($where);
		$row = $this->db->get("tbl_medicine as m")->row();
		if(!empty($row->id))
		{
			$item_code			=	$row->i_code;
			$item_name			=	ucwords(strtolower($row->item_name));
			$item_packing		=	$row->packing;
			$item_company 		=  	ucwords(strtolower($row->company_full_name));
			$item_quantity		=	$row->batchqty;
			$item_ptr			=	sprintf('%0.2f',round($row->sale_rate,2));
			$item_mrp			=	sprintf('%0.2f',round($row->mrp,2));
			$item_price			=	sprintf('%0.2f',round($row->final_price,2));
			
			$item_margin 		=   round($row->margin);
			$item_featured 		= 	$row->featured;

			$item_image  = constant('img_url_site')."uploads/default_img.jpg";
			if(!empty($row->image1))
			{
				$item_image = constant('img_url_site').$row->image1;
			}

			$item_header_title = "Similar items";
			$get_record = "";
			
$items2.= <<<EOD
{"item_code":"{$item_code}","item_image":"{$item_image}","item_name":"{$item_name}","item_packing":"{$item_packing}","item_company":"{$item_company}","item_quantity":"{$item_quantity}","item_mrp":"{$item_mrp}","item_ptr":"{$item_ptr}","item_price":"{$item_price}","item_margin":"{$item_margin}","item_featured":"{$item_featured}","item_header_title":"{$item_header_title}","get_record":"{$get_record}"},
EOD;
		}
		return $items2;
	}
	
	public function get_single_medicine_info($i_code,$chemist_id,$salesman_id,$user_type)
	{		
		$items = "";
		//error_reporting(0);
		$date_time = date('d-M h:i A');
		/*$where = array('i_code'=>$i_code);
		$row = $this->Scheme_Model->select_row("tbl_medicine",$where);*/
		
		$this->db->select("m.*");
		$where = array('i_code'=>$i_code);
		$this->db->where($where);
		$row = $this->db->get("tbl_medicine as m")->row();
		if(!empty($row->id))
		{
			$i_code				=	$row->i_code;
			$item_code			=	$row->item_code;
			$title				=	$row->title;
			$item_name			=	ucwords(strtolower($row->item_name));
			$company_name		=	ucwords(strtolower($row->company_name));
			$company_full_name 	=  	ucwords(strtolower($row->company_full_name));
			$batchqty			=	$row->batchqty;
			$batch_no			=	$row->batch_no;
			$packing			=	$row->packing;
			$sale_rate			=	sprintf('%0.2f',round($row->sale_rate,2));
			$mrp				=	sprintf('%0.2f',round($row->mrp,2));
			$final_price		=	sprintf('%0.2f',round($row->final_price,2));
			$scheme				=	$row->salescm1."+".$row->salescm2;
			$expiry				=	$row->expiry;				
			$compcode 			=   $row->compcode;				
			$item_date 			=   $row->item_date;
			$margin 			=   round($row->margin);				
			$misc_settings		=   $row->misc_settings;
			$gstper				=	$row->gstper;
			$itemjoinid			=	$row->itemjoinid;
			$featured 			= 	$row->featured;
			$discount 			= 	$row->discount;
			
			if(empty($discount))
			{
				$discount = "4.5";
			}
			
			$description1 = $this->new_clean(trim($row->title2));
			$description2 = $this->new_clean(trim($row->description));
			$image1 = constant('img_url_site')."uploads/default_img.jpg";
			$image2 = constant('img_url_site')."uploads/default_img.jpg";
			$image3 = constant('img_url_site')."uploads/default_img.jpg";
			$image4 = constant('img_url_site')."uploads/default_img.jpg";
			if(!empty($row->image1))
			{
				$image1 = constant('img_url_site').$row->image1;
			}
			if(!empty($row->image2))
			{
				$image2 = constant('img_url_site').$row->image2;
			}
			if(!empty($row->image3))
			{
				$image3 = constant('img_url_site').$row->image3;
			}
			if(!empty($row->image4))
			{
				$image4 = constant('img_url_site').$row->image4;
			}			

			/********************************************************/
			$itemjoinid = "";
			$items1 = "";
			if($itemjoinid!="")
			{
				$itemjoinid1 = explode (",", $itemjoinid);
				foreach($itemjoinid1 as $item_code_n)
				{
					$items1.= $this->get_itemjoinid($item_code_n);
				}
				if ($items1 != '') {
					$items1 = substr($items1, 0, -1);
				}
				$items1 = ',"items1":['.$items1.']';
			}
			else
			{
				$items1 = ',"items1":""';
			}
			/****************************************/
			$hotdeals 			=   $row->hotdeals;
			$hotdeals_short 	=   $row->hotdeals_short;
			/************************************************/
			
$items .= <<<EOD
{"i_code":"{$i_code}","item_code":"{$item_code}","date_time":"{$date_time}","title":"{$title}","item_name":"{$item_name}","company_name":"{$company_name}","company_full_name":"{$company_full_name}","image1":"{$image1}","image2":"{$image2}","image3":"{$image3}","image4":"{$image4}","description1":"{$description1}","description2":"{$description2}","batchqty":"{$batchqty}","sale_rate":"{$sale_rate}","mrp":"{$mrp}","final_price":"{$final_price}","batch_no":"{$batch_no}","packing":"{$packing}","expiry":"{$expiry}","scheme":"{$scheme}","margin":"{$margin}","featured":"{$featured}","gstper":"{$gstper}","discount":"{$discount}","misc_settings":"{$misc_settings}","itemjoinid":"{$itemjoinid}","hotdeals":"{$hotdeals}","hotdeals_short":"{$hotdeals_short}"$items1},
EOD;
	}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}

	public function insert_top_search($user_type,$user_altercode,$salesman_id,$item_code)
	{
		$result = $this->db->query("SELECT id FROM `tbl_top_search` WHERE `user_altercode`='$user_altercode' and user_type='$user_type' and salesman_id='$salesman_id' order by id desc LIMIT 25,10")->result();
		foreach($result as $row)
		{
			$this->db->query("delete from tbl_top_search where id='$row->id'");
		}

		$where = array('user_altercode'=>$user_altercode,'salesman_id'=>$salesman_id,'user_type'=>$user_type,'item_code'=>$item_code);
		$row = $this->Scheme_Model->select_row("tbl_top_search",$where);
		if(empty($row))
		{
			$date = date('Y-m-d');
			$time = date("H:i",time());
			$datetime = time();

			$dt = array(
				'user_altercode'=>$user_altercode,
				'salesman_id'=>$salesman_id,
				'user_type'=>$user_type,
				'item_code'=>$item_code,
				'date'=>$date,
				'time'=>$time,
				'datetime'=>$datetime,
			);
			$this->Scheme_Model->insert_fun("tbl_top_search",$dt);
		}
	}

	public function medicine_details_api($user_type,$user_altercode,$salesman_id,$item_code)
	{		
		$this->insert_top_search($user_type,$user_altercode,$salesman_id,$item_code);
		$items = "";
		$item_date_time = date('d-M h:i A');
		
		$this->db->select("m.*");
		$where = array('i_code'=>$item_code);
		$this->db->where($where);
		$row = $this->db->get("tbl_medicine as m")->row();
		if(!empty($row->id))
		{
			$item_code			=	$row->i_code;
			$item_name			=	htmlentities(ucwords(strtolower($row->item_name)));
			$item_packing		=	htmlentities($row->packing);
			$item_expiry		=	htmlentities($row->expiry);
			$item_batch_no		=	htmlentities($row->batch_no);
			$item_company 		=  	ucwords(strtolower($row->company_full_name));
			$item_quantity		=	$row->batchqty;
			$item_ptr			=	sprintf('%0.2f',round($row->sale_rate,2));
			$item_mrp			=	sprintf('%0.2f',round($row->mrp,2));
			$item_price			=	sprintf('%0.2f',round($row->final_price,2));
			$item_scheme		=	$row->salescm1."+".$row->salescm2;
			
			$item_margin 		=   round($row->margin);				
			$misc_settings		=   $row->misc_settings;
			$item_gst			=	$row->gstper;
			$item_featured 		= 	$row->featured;
			$item_discount 		= 	$row->discount;

			if($item_quantity==0)
			{
				$this->add_low_stock_alert($item_code);
			}
			
			if(empty($item_discount))
			{
				$item_discount = "4.5";
			}
			
			$item_description1 = htmlentities(trim($row->title2));
			$item_description2 = htmlentities(trim($row->description));
			$item_description1  =   $this->new_clean($item_description1);
			$item_description2  =   $this->new_clean($item_description2);
			$item_image  = constant('img_url_site')."uploads/default_img.jpg";
			$item_image2 = constant('img_url_site')."uploads/default_img.jpg";
			$item_image3 = constant('img_url_site')."uploads/default_img.jpg";
			$item_image4 = constant('img_url_site')."uploads/default_img.jpg";
			if(!empty($row->image1))
			{
				$item_image = constant('img_url_site').$row->image1;
			}
			if(!empty($row->image2))
			{
				$item_image2 = constant('img_url_site').$row->image2;
			}
			if(!empty($row->image3))
			{
				$item_image3 = constant('img_url_site').$row->image3;
			}
			if(!empty($row->image4))
			{
				$item_image4 = constant('img_url_site').$row->image4;
			}

			/*******************************************************
			$itemjoinid			=	$row->itemjoinid;
			/********************************************************/
			$itemjoinid = "";
			$items1 = "";
			if($itemjoinid!="")
			{
				$itemjoinid1 = explode (",", $itemjoinid);
				foreach($itemjoinid1 as $item_code_n)
				{
					$items1.= $this->get_itemjoinid($item_code_n);
				}
				if ($items1 != '') {
					$items1 = substr($items1, 0, -1);
				}
				$items1 = ',"items1":['.$items1.']';
			}
			else
			{
				$items1 = ',"items1":""';
			}

			$item_stock = "";
			if($misc_settings=="#NRX")
			{
				if($item_quantity>=10){
					$item_stock = "Available";
				}
			}
			
			$item_order_quantity = "";
			$where1 = array('chemist_id'=>$user_altercode,'selesman_id'=>$salesman_id,'user_type'=>$user_type,'i_code'=>$item_code,'status'=>'0');
			$row1 = $this->Scheme_Model->select_row("drd_temp_rec",$where1);
			if(!empty($row1->id))
			{
				$item_order_quantity = $row1->quantity;
			}
			
$items.= <<<EOD
{"item_date_time":"{$item_date_time}","item_code":"{$item_code}","item_image":"{$item_image}","item_image2":"{$item_image2}","item_image3":"{$item_image3}","item_image4":"{$item_image4}","item_name":"{$item_name}","item_packing":"{$item_packing}","item_expiry":"{$item_expiry}","item_batch_no":"{$item_batch_no}","item_company":"{$item_company}","item_quantity":"{$item_quantity}","item_stock":"{$item_stock}","item_ptr":"{$item_ptr}","item_mrp":"{$item_mrp}","item_price":"{$item_price}","item_scheme":"{$item_scheme}","item_margin":"{$item_margin}","item_gst":"{$item_gst}","item_featured":"{$item_featured}","item_discount":"{$item_discount}","item_description1":"{$item_description1}","item_description2":"{$item_description2}","item_order_quantity":"{$item_order_quantity}"},
EOD;
	}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function search_chemist($keyword)
	{
		$items = "";
		$this->db->where("(name like '".$keyword."%' or altercode='$keyword' or altercode like '%".$keyword."' or altercode like '".$keyword."%' or altercode like '%".$keyword."%') and slcd='CL'");
		$this->db->limit(100);
		$query= $this->db->get("tbl_acm")->result();		
		foreach ($query as $row)
		{
			if(substr($row->name,0,1)==".")
			{
			}
			else
			{
				$id			=	$row->id;
				$user_name	=	$row->name;
				$chemist_id	=	$row->altercode;
				$code		=	$row->code;
				
				$where1 = array('code'=>$row->code);
				$row1   = $this->Scheme_Model->select_row("tbl_acm_other",$where1);
				
				$user_image = constant('img_url_site')."img_v".constant('site_v')."/logo.png";
				if(!empty($row1->image))
				{
					$user_image = constant('img_url_site')."user_profile/".$row1->image;
				}					

$items .= <<<EOD
{"id":"{$id}","user_name":"{$user_name}","chemist_id":"{$chemist_id}","user_image":"{$user_image}","code":"{$code}"},
EOD;
			}
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}

	public function chemist_search_api($user_type="",$user_altercode="",$keyword="")
	{
		$items = "";
		$salesman_id 	= $user_altercode;
		$count = 0;

		//"select tbl_acm.name,tbl_acm.altercode,tbl_acm_other.image,(select count(id) as user_cart from drd_temp_rec where user_type='sales' and selesman_id='$salesman_id' and chemist_id=tbl_acm.altercode and status=0) as user_cart,(select sum(quantity*sale_rate) as user_cart_total from drd_temp_rec where user_type='sales' and selesman_id='$salesman_id' and chemist_id=tbl_acm.altercode and status=0) as user_cart_total from tbl_acm left JOIN tbl_acm_other on tbl_acm.code=tbl_acm_other.code where (name like '".$keyword."%' or altercode='$keyword' or altercode like '%".$keyword."' or altercode like '".$keyword."%' or altercode like '%".$keyword."%') and slcd='CL' limit 50"

		$result = $this->db->query("select tbl_acm.name,tbl_acm.altercode,tbl_acm_other.image from tbl_acm left JOIN tbl_acm_other on tbl_acm.code=tbl_acm_other.code where (name like '".$keyword."%' or altercode='$keyword' or altercode like '%".$keyword."' or altercode like '".$keyword."%' or altercode like '%".$keyword."%') and slcd='CL' limit 50")->result();		
		$user_cart = $user_cart_total = 0;
		foreach ($result as $row)
		{
			if(substr($row->name,0,1)==".")
			{
			}
			else
			{
				$chemist_name		=	ucwords(strtolower($row->name));
				$chemist_altercode	=	$row->altercode;

				/*$user_cart 		 = $row->user_cart;
				$user_cart_total = $row->user_cart_total;*/
				$user_cart_total = sprintf('%0.2f',round($user_cart_total,2));
				
				$chemist_image = constant('main_site')."img_v".constant('site_v')."/logo.png";
				if(!empty($row->image))
				{
					$chemist_image = constant('main_site')."user_profile/".$row->image;
				}
				$count++;				

$items .= <<<EOD
{"chemist_altercode":"{$chemist_altercode}","chemist_name":"{$chemist_name}","chemist_image":"{$chemist_image}","user_cart":"{$user_cart}","user_cart_total":"{$user_cart_total}","count":"{$count}"},
EOD;
			}
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function hot_deals()
	{
		$where = array('hotdeals'=>1,'item_code!='=>'',);
		$this->db->where($where);
		$this->db->limit(50);
		$query = $this->db->get("tbl_medicine")->result();		
		foreach ($query as $row)
		{
			$i_code				=	$row->i_code;
			$item_code			=	$row->item_code;
			$title				=	$row->title;
			$item_name			=	ucwords(strtolower($row->item_name));
			$company_name		=	ucwords(strtolower($row->company_name));
			$company_full_name 	=  	ucwords(strtolower($row->company_full_name));
			$batchqty			=	$row->batchqty;
			$batch_no			=	$row->batch_no;
			$packing			=	$row->packing;
			$sale_rate			=	$row->sale_rate;
			$mrp				=	$row->mrp;
			$scheme				=	$row->salescm1."+".$row->salescm2;
			$expiry				=	$row->expiry;				
			$compcode 			=   $row->compcode;				
			$item_date 			=   $row->item_date;
			$margin 			=   round($row->margin);				
			$misc_settings		=   $row->misc_settings;
			$gstper				=	$row->gstper;
			$present			=	$row->present;
			$itemjoinid			=	$row->itemjoinid;
			
			$i_code		=	$row->i_code;
			$image 		= 	$this->Scheme_Model->get_medicine_image($i_code);
			$featured 	= 	$this->Scheme_Model->get_medicine_featured($i_code);
			$discount 	= 	$this->Scheme_Model->get_company_discount($compcode);
			
			/*********************yha decount karta h**************/
			$final_price0=  $sale_rate * $discount / 100;
			$final_price0=	$sale_rate - $final_price0;
			
			/*********************yha gst add karta h**************/
			$final_price=   $final_price0 * $gstper / 100;
			$final_price=	$final_price0 + $final_price;
			
			$final_price= 	round($final_price,2);
			
			/***************************************/
			$mrp_xx = $mrp;
			if($mrp==0)
			{
				$mrp_xx = 1;
			}
			$margin = $mrp - $final_price;
			$margin = $margin / $mrp_xx;
			$margin = $margin * 100;
			$margin = round($margin);
			/***************************************/

			/*****************************************
			if($itemjoinid!="")
			{
				$itemjoinid1 = explode (",", $itemjoinid);
				foreach($itemjoinid1 as $item_code_n)
				{
					$items1.= $this->get_itemjoinid($item_code_n);
				}
				if ($items1 != '') {
					$items1 = substr($items1, 0, -1);
				}
				$items1 = ',"items1":['.$items1.']';
			}
			else
			{
				$items1 = ',"items1":""';
			}
			/****************************************/				
			
			$hotdeals 			=   $row->hotdeals;
			$hotdeals_short 	=   $row->hotdeals_short;
			/************************************************/
			
			$i++;
			if($i%2==0) {
				$css = "search_page_gray"; 
			} else { 
				$css = "search_page_gray1";
			}
$items .= <<<EOD
{"i_code":"{$i_code}","item_code":"{$item_code}","date_time":"{$date_time}","title":"{$title}","item_name":"{$item_name}","company_name":"{$company_name}","company_full_name":"{$company_full_name}","image":"{$image}","batchqty":"{$batchqty}","sale_rate":"{$sale_rate}","mrp":"{$mrp}","final_price":"{$final_price}","batch_no":"{$batch_no}","packing":"{$packing}","expiry":"{$expiry}","scheme":"{$scheme}","margin":"{$margin}","featured":"{$featured}","gstper":"{$gstper}","discount":"{$discount}","present":"{$present}","misc_settings":"{$misc_settings}","itemjoinid":"{$itemjoinid}","hotdeals":"{$hotdeals}","css":"{$css}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}

	public function my_order_api($user_type="",$user_altercode="",$salesman_id="",$get_record="")
	{
		$items = "";
		if($user_type=="sales")
		{
			$this->db->distinct();
			$this->db->group_by('order_id');
			$this->db->where('selesman_id',$salesman_id);
			$this->db->where('chemist_id',$user_altercode);
			$this->db->order_by('id','desc');
			$this->db->limit(12,$get_record);
			$query = $this->db->get("tbl_order")->result();
		}
		else
		{
			$this->db->distinct();
			$this->db->group_by('order_id');
			$this->db->where('chemist_id',$user_altercode);
			$this->db->order_by('id','desc');
			$this->db->limit(12,$get_record);
			$query = $this->db->get("tbl_order")->result();
		}
		foreach($query as $row)
		{
			$get_record++;
			$order_id = $row->order_id;
			
			$row1 = $this->db->query("SELECT sum(`sale_rate` * `quantity`) as total FROM `tbl_order` as t2 where t2.order_id='$order_id'")->row();			
			$item_total = round($row1->total,2);
			if($row->gstvno=="")
			{
				$item_title = "Pending / Order no. ".$order_id;
			}
			else
			{
				$item_title = "Generated / Order no. ".$row->gstvno;
			}
			$item_date_time	= $row->date." ".$row->time;			
			$item_id = $order_id;

			$row1 = $this->db->query("SELECT tbl_acm.name,tbl_acm.altercode,tbl_acm_other.image from tbl_acm,tbl_acm_other where tbl_acm.altercode='$row->chemist_id' and tbl_acm.code = tbl_acm_other.code")->row();
			$user_image = constant('main_site')."user_profile/$row1->image";
			if(empty($row1->image))
			{
				$user_image = constant('main_site')."img_v".constant('site_v')."/logo.png";
			}
			$item_message   	= $item_total;
			$item_image 		= $user_image;

			$item_image 		= htmlentities($item_image);

$items.= <<<EOD
{"item_id":"{$item_id}","item_title":"{$item_title}","item_message":"{$item_message}","item_date_time":"{$item_date_time}","item_image":"{$item_image}","get_record":"{$get_record}"},
EOD;
		}
if ($items != ''){
	$items = substr($items, 0, -1);
}
	return $items;
	}

	public function my_order_details_api($user_type="",$user_altercode="",$salesman_id="",$order_id="")
	{
		$items = "";
		if($user_type=="sales")
		{
			$this->db->select("o.*,m.packing,m.expiry,m.company_full_name,m.packing,m.salescm1,m.salescm2,m.image1");
			$this->db->where('o.selesman_id',$salesman_id);
			$this->db->where('o.chemist_id',$user_altercode);
			$this->db->where('o.order_id',$order_id);
			$this->db->order_by('o.id','desc');
			$this->db->from('tbl_order as o');
			$this->db->join('tbl_medicine as m', 'm.i_code = o.i_code', 'left');
			$query = $this->db->get()->result();
		}
		else
		{
			$this->db->select("o.*,m.packing,m.expiry,m.company_full_name,m.packing,m.salescm1,m.salescm2,m.image1");
			$this->db->where('o.chemist_id',$user_altercode);
			$this->db->where('o.order_id',$order_id);
			$this->db->order_by('o.id','desc');
			$this->db->from('tbl_order as o');
			$this->db->join('tbl_medicine as m', 'm.i_code = o.i_code', 'left');
			$query = $this->db->get()->result();
		}
		foreach($query as $row)
		{
			$item_code 			= $row->i_code;
			$item_price 		= sprintf('%0.2f',round($row->sale_rate,2));
			$item_quantity 		= $row->quantity;
			$item_quantity_price= sprintf('%0.2f',round($row->quantity * $row->sale_rate,2));
			$item_date_time 	= $row->date." ".$row->time;
			$item_modalnumber 	= "Pc / Laptop"; //$row->modalnumber;
			
			$item_name 		= htmlentities(ucwords(strtolower($row->item_name)));
			$item_packing 	= htmlentities($row->packing);
			$item_expiry 	= htmlentities($row->expiry);
			$item_company 	= htmlentities(ucwords(strtolower($row->company_full_name)));
			$item_scheme 	= $row->salescm1."+".$row->salescm2;

			$item_image = constant('img_url_site')."uploads/default_img.jpg";
			if(!empty($row->image1))
			{
				$item_image = constant('img_url_site').$row->image1;
			}

$items.= <<<EOD
{"item_code":"{$item_code}","item_image":"{$item_image}","item_name":"{$item_name}","item_packing":"{$item_packing}","item_expiry":"{$item_expiry}","item_company":"{$item_company}","item_scheme":"{$item_scheme}","item_price":"{$item_price}","item_quantity":"{$item_quantity}","item_quantity_price":"{$item_quantity_price}","item_date_time":"{$item_date_time}","item_modalnumber":"{$item_modalnumber}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function check_notification($user_type,$chemist_id)
	{
		/*****************notification message*******************
		/*$row = $this->db->query("select * from tbl_new_notification where chemist_id='$chemist_id' and status='0' order by id desc")->row();
		if($row->id!="")
		{
			$count=1;
			$notiid 	= $row->id;
			$notititle 	= $row->title;
			$notibody 	= $row->message;
			 $this->db->query("update tbl_new_notification set status='1' where id='$notiid'");
		}
		/*****************broadcast message*******************
		$row = $this->db->query("select * from tbl_broadcast where chemist_id='$chemist_id' and user_type='$user_type' and status='0' order by id desc")->row();
		if($row->id!="")
		{
			$broadcastid 		= $row->id;
			$broadcasttitle 	= $row->title;
			$broadcastmessage 	= $row->broadcast;
			$this->db->query("update tbl_broadcast set status='1' where id='$broadcastid'");
		}
		/*****************check block or not*******************
		$query = $this->db->query("select tbl_acm.id,tbl_acm_other.block,tbl_acm_other.status from tbl_acm,tbl_acm_other where altercode='$chemist_id' and tbl_acm.code = tbl_acm_other.code")->row();
		if ($query->id!="")
		{
			$status = "1";
			if($query->block=="1")
			{
				$status = "2";
			}
			if($query->status=="0")
			{
				$status = "0";
			}
		}
$items.= <<<EOD
{"count":"{$count}","status":"{$status}","notiid":"{$notiid}","notititle":"{$notititle}","notibody":"{$notibody}","notitime":"{$notitime}","broadcastid":"{$broadcastid}","broadcasttitle":"{$broadcasttitle}","broadcastmessage":"{$broadcastmessage}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}
		<?php*/
	}

	public function my_notification_api($user_type="",$user_altercode="",$salesman_id="",$get_record="")
	{
		$items = "";		
		//$this->db->where('user_type',$user_type);
		$this->db->where('chemist_id',$user_altercode);
		$this->db->where('device_id','default');
		$this->db->order_by('id','desc');
		$this->db->limit(12,$get_record);
		$query = $this->db->get("tbl_android_notification")->result();
		foreach($query as $row)
		{
			$get_record++;
			$item_id		=	$row->id;
			$item_title		=	($row->title);
			$item_message	=	($row->message);
			$item_message	=   str_replace("<br>"," ",$item_message);
			$item_date_time = 	$row->date." ".$row->time;

			$item_message	= 	substr($item_message, 0, 50)."....";

			$row1 = $this->db->query("SELECT tbl_acm.name,tbl_acm.altercode,tbl_acm_other.image from tbl_acm,tbl_acm_other where tbl_acm.altercode='$row->chemist_id' and tbl_acm.code = tbl_acm_other.code")->row();
			$user_image = constant('main_site')."user_profile/$row1->image";
			if(empty($row1->image))
			{
				$user_image = constant('main_site')."img_v".constant('site_v')."/logo.png";
			}
			$item_image 	= 	$user_image;
			
$items.= <<<EOD
{"item_id":"{$item_id}","item_title":"{$item_title}","item_message":"{$item_message}","item_date_time":"{$item_date_time}","item_image":"{$item_image}","get_record":"{$get_record}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function my_notification_details_api($user_type="",$user_altercode="",$salesman_id="",$item_id="")
	{
		$items = "";
		/*$this->db->query("update tbl_android_notification set status='1' where id='$notification_id'");*/

		//$this->db->where('user_type',$user_type);
		$this->db->where('chemist_id',$user_altercode);
		$this->db->where('device_id','default');
		$this->db->where('id',$item_id);
		$this->db->order_by('id','desc');
		$this->db->limit(8);
		$query = $this->db->get("tbl_android_notification")->result();
		foreach($query as $row)
		{
			$item_id		=	$row->id;
			$item_title		=	($row->title);
			$item_message	=	($row->message);
			$item_date_time = 	$row->date." ".$row->time;
			
			$item_fun_type	= 	($row->funtype);
			$itemid			= 	($row->itemid);
			$compid			= 	($row->compid);
			$division		= 	($row->division);
			$item_image2	= 	$row->image;
			
			$item_fun_id = $item_fun_id2 = "";
			if(!empty($item_image2))
			{
				$item_image2 =   constant('img_url_site')."uploads/manage_notification/photo/resize/".$item_image2;
			}

			if($item_fun_type=="1")
			{
				$item_fun_name = "get_single_medicine_info";
				$item_fun_id   = $itemid;
			}

			if($item_fun_type=="2")
			{
				$item_fun_name = "featured_brand";
				$item_fun_id   = $compid;
				$item_fun_id2  = $division;
			}

			if($item_fun_type=="3")
			{
				$item_fun_name = "map";
			}

			if($item_fun_type=="4")
			{
				$item_fun_name = "my_order";
			}

			if($item_fun_type=="5")
			{
				$item_fun_name = "my_invoice";
			}

			$row1 = $this->db->query("SELECT tbl_acm.name,tbl_acm.altercode,tbl_acm_other.image from tbl_acm,tbl_acm_other where tbl_acm.altercode='$row->chemist_id' and tbl_acm.code = tbl_acm_other.code")->row();
			$user_image = constant('main_site')."user_profile/$row1->image";
			if(empty($row1->image))
			{
				$user_image = constant('main_site')."img_v".constant('site_v')."/logo.png";
			}
			$item_image 	= 	$user_image;

$items.= <<<EOD
{"item_id":"{$item_id}","item_title":"{$item_title}","item_message":"{$item_message}","item_date_time":"{$item_date_time}","item_image":"{$item_image}","item_image2":"{$item_image2}","item_fun_type":"{$item_fun_type}","item_fun_name":"{$item_fun_name}","item_fun_id":"{$item_fun_id}","item_fun_id2":"{$item_fun_id2}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	// yha off karna ha base64encode laga ha iss ke bina use kar rahay ha 
	public function website_menu()
	{
		//error_reporting(0);
		$items = "";
		$i = 1;
		$image = "";
		$where = array('status'=>1,);
		$query = $this->Scheme_Model->select_all_result("tbl_medicine_category",$where,"short_order","asc");
		foreach ($query as $row)
		{
			$code		=	$row->code;
			$name		=	base64_encode(ucwords(strtolower($row->menu)));
			$image		=  constant('img_url_site')."uploads/manage_medicine_category/photo/resize/".$row->image;
			if (empty($row->image)){
				$image 			= constant('img_url_site')."uploads/default_img.jpg";
			}
			
$items.= <<<EOD
{"code":"{$code}","name":"{$name}","image":"{$image}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}

	public function website_menu_json_new()
	{
		//error_reporting(0);
		$items = "";
		$where = array('status'=>1,);
		$query = $this->Scheme_Model->select_all_result("tbl_medicine_category",$where,"short_order","asc");
		foreach ($query as $row)
		{
			$item_code		=	$row->code;
			$item_company	=	ucwords(strtolower($row->menu));
			$item_image		=  constant('img_url_site')."uploads/manage_medicine_category/photo/resize/".$row->image;
			if (empty($row->image)){
				$item_image 	= constant('img_url_site')."uploads/default_img.jpg";
			}
			
$items.= <<<EOD
{"item_code":"{$item_code}","item_company":"{$item_company}","item_image":"{$item_image}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	// yha off karna ha base64encode laga ha iss ke bina use kar rahay ha 
	public function featured_brand_json()
	{
		//error_reporting(0);
		$items = "";
		$image = "";
		$where = array('status'=>1,);
		$query = $this->Scheme_Model->select_all_result("tbl_featured_brand",$where,"id","RANDOM");
		foreach ($query as $row)
		{
			$id					=	$row->id;
			$compcode			=	($row->compcode);
			$company_full_name	=	base64_encode(ucwords(strtolower($row->company_full_name)));
			$division 			= "";
			$image				=   constant('img_url_site')."uploads/manage_featured_brand/photo/resize/".$row->image;
			if (empty($row->image)){
				$image 			= constant('img_url_site')."uploads/default_img.jpg";
			}
			
$items.= <<<EOD
{"id":"{$id}","compcode":"{$compcode}","company_full_name":"{$company_full_name}","division":"{$division}","image":"{$image}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}

	public function featured_brand_json_new()
	{
		//error_reporting(0);
		$items = "";
		$image = "";
		/*$where = array('status'=>1,);
		$query = $this->Scheme_Model->select_all_result("tbl_featured_brand",$where,"id","RANDOM");*/

		$this->db->select("compcode,company_full_name,image");
		$this->db->where('status',1);
		$this->db->order_by('id','RANDOM');
		$this->db->limit('15');
		$query = $this->db->get("tbl_featured_brand")->result();
		foreach ($query as $row)
		{
			$item_code			=	($row->compcode);
			$item_company		=	ucwords(strtolower($row->company_full_name));
			$item_division 		= 	"";
			$item_image			=   constant('img_url_site')."uploads/manage_featured_brand/photo/resize/".$row->image;
			if (empty($row->image)){
				$item_image 	= constant('img_url_site')."uploads/default_img.jpg";
			}

			$item_image 	= htmlentities($item_image);
			
$items.= <<<EOD
{"item_code":"{$item_code}","item_company":"{$item_company}","item_division":"{$item_division}","item_image":"{$item_image}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}

	

	public function new_medicine_this_month()
	{
		//error_reporting(0);
		$items = "";
		$time  = time();
		$vdt60 = date("Y-m-d", strtotime("-60 days", $time));
		
		$this->db->select("m.*");
		$this->db->where('item_date>=',$vdt60);
		$this->db->order_by("RAND()");
		$this->db->limit('25');
		$query = $this->db->get("tbl_medicine as m")->result();
		foreach ($query as $row)
		{			
			$i_code				=	$row->i_code;
			$item_code			=	$row->item_code;
			$item_name			=	ucwords(strtolower($row->item_name));
			$company_full_name 	=  	ucwords(strtolower($row->company_full_name));
			$batchqty			=	$row->batchqty;
			$batch_no			=	$row->batch_no;
			$packing			=	$row->packing;
			$sale_rate			=	sprintf('%0.2f',round($row->sale_rate,2));
			$mrp				=	sprintf('%0.2f',round($row->mrp,2));
			$final_price		=	sprintf('%0.2f',round($row->final_price,2));
			$scheme				=	$row->salescm1."+".$row->salescm2;
			$expiry				=	$row->expiry;
			$margin 			=   round($row->margin);
			$featured 			= 	$row->featured;
			
			
			$image1 = constant('img_url_site')."uploads/default_img.jpg";
			if(!empty($row->image1))
			{
				$image1 = constant('img_url_site').$row->image1;
			}
			
$items.= <<<EOD
{"i_code":"{$i_code}","item_code":"{$item_code}","item_name":"{$item_name}","company_full_name":"{$company_full_name}","image":"{$image1}","featured":"{$featured}","packing":"{$packing}","mrp":"{$mrp}","sale_rate":"{$sale_rate}","final_price":"{$final_price}","batchqty":"{$batchqty}","scheme":"{$scheme}","batch_no":"{$batch_no}","expiry":"{$expiry}","margin":"{$margin}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}

	public function new_medicine_this_month_json_new()
	{
		$items = "";
		$time  = time();
		$vdt60 = date("Y-m-d", strtotime("-60 days", $time));
		
		$this->db->select("i_code,item_name,packing,company_name,batchqty,mrp,sale_rate,final_price,margin,featured,image1");
		$this->db->where('item_date>=',$vdt60);
		$this->db->order_by("RAND()");
		$this->db->limit('15');
		$query = $this->db->get("tbl_medicine")->result();
		foreach ($query as $row)
		{			

			$item_code			=	$row->i_code;
			$item_name			=	ucwords(strtolower($row->item_name));
			$item_packing		=	$row->packing;
			$item_company		=  	ucwords(strtolower($row->company_name));
			$item_quantity		=	$row->batchqty;
			$item_mrp			=	sprintf('%0.2f',round($row->mrp,2));
			$item_ptr			=	sprintf('%0.2f',round($row->sale_rate,2));
			$item_price			=	sprintf('%0.2f',round($row->final_price,2));
			$item_margin 		=   round($row->margin);
			$item_featured 		= 	$row->featured;
			
			$item_image = constant('img_url_site')."uploads/default_img.jpg";
			if(!empty($row->image1))
			{
				$item_image = constant('img_url_site').$row->image1;
			}
			$item_image 		= htmlentities($item_image);

			$item_header_title = "New arrivals";
			$get_record = "";
			
$items.= <<<EOD
{"item_code":"{$item_code}","item_image":"{$item_image}","item_name":"{$item_name}","item_packing":"{$item_packing}","item_company":"{$item_company}","item_quantity":"{$item_quantity}","item_mrp":"{$item_mrp}","item_ptr":"{$item_ptr}","item_price":"{$item_price}","item_margin":"{$item_margin}","item_featured":"{$item_featured}","item_header_title":"{$item_header_title}","get_record":"{$get_record}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function hot_selling_today_json()
	{
		//error_reporting(0);
		$items = "";
		$query = $this->db->query("select m.* from tbl_hot_selling INNER JOIN tbl_medicine as m on tbl_hot_selling.item_code=m.i_code order by tbl_hot_selling.id desc,RAND() limit 25")->result();
		foreach ($query as $row)
		{
			$i_code				=	$row->i_code;
			$item_code			=	$row->item_code;
			$item_name			=	ucwords(strtolower($row->item_name));
			$company_full_name 	=  	ucwords(strtolower($row->company_full_name));
			$batchqty			=	$row->batchqty;
			$batch_no			=	$row->batch_no;
			$packing			=	$row->packing;
			$sale_rate			=	sprintf('%0.2f',round($row->sale_rate,2));
			$mrp				=	sprintf('%0.2f',round($row->mrp,2));
			$final_price		=	sprintf('%0.2f',round($row->final_price,2));
			$scheme				=	$row->salescm1."+".$row->salescm2;
			$expiry				=	$row->expiry;
			$margin 			=   round($row->margin);
			$featured 			= 	$row->featured;
			$discount 			= 	$row->discount;
			
			if(empty($discount))
			{
				$discount = "4.5";
			}
			
			$image1 = constant('img_url_site')."uploads/default_img.jpg";
			if(!empty($row->image1))
			{
				$image1 = constant('img_url_site').$row->image1;
			}
			
$items.= <<<EOD
{"i_code":"{$i_code}","item_code":"{$item_code}","item_name":"{$item_name}","company_full_name":"{$company_full_name}","image":"{$image1}","featured":"{$featured}","packing":"{$packing}","mrp":"{$mrp}","sale_rate":"{$sale_rate}","final_price":"{$final_price}","batchqty":"{$batchqty}","scheme":"{$scheme}","batch_no":"{$batch_no}","expiry":"{$expiry}","margin":"{$margin}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}

	public function hot_selling_today_json_new()
	{
		$items = "";
		/*$query = $this->db->query("select m.* from tbl_hot_selling INNER JOIN tbl_medicine as m on tbl_hot_selling.item_code=m.i_code order by tbl_hot_selling.id desc,RAND() limit 25")->result();*/

		$this->db->select("m.i_code,m.item_name,m.packing,m.company_name,m.batchqty,m.mrp,m.sale_rate,m.final_price,m.margin,m.featured,m.image1");
		$this->db->order_by("RAND()");
		$this->db->limit('15');
		$this->db->from('tbl_medicine as m');
		$this->db->join('tbl_hot_selling', 'tbl_hot_selling.item_code=m.i_code', 'right outer');
		$query = $this->db->get()->result();
		foreach ($query as $row)
		{
			$item_code			=	$row->i_code;
			$item_name			=	ucwords(strtolower($row->item_name));
			$item_packing		=	$row->packing;
			$item_company		=  	ucwords(strtolower($row->company_name));
			$item_quantity		=	$row->batchqty;
			$item_mrp			=	sprintf('%0.2f',round($row->mrp,2));
			$item_ptr			=	sprintf('%0.2f',round($row->sale_rate,2));
			$item_price			=	sprintf('%0.2f',round($row->final_price,2));
			$item_margin 		=   round($row->margin);
			$item_featured 		= 	$row->featured;
			
			$item_image = constant('img_url_site')."uploads/default_img.jpg";
			if(!empty($row->image1))
			{
				$item_image = constant('img_url_site').$row->image1;
			}

			$item_image 		= htmlentities($item_image);

			$item_header_title  = "Hot selling";
			$get_record = "";
			
$items.= <<<EOD
{"item_code":"{$item_code}","item_image":"{$item_image}","item_name":"{$item_name}","item_packing":"{$item_packing}","item_company":"{$item_company}","item_quantity":"{$item_quantity}","item_mrp":"{$item_mrp}","item_ptr":"{$item_ptr}","item_price":"{$item_price}","item_margin":"{$item_margin}","item_featured":"{$item_featured}","item_header_title":"{$item_header_title}","get_record":"{$get_record}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function must_buy_medicines_json()
	{
		//error_reporting(0);
		$items = "";
		$date = date("Y-m-d");
		
		$sameid = "";
		$query = $this->db->query("select DISTINCT i_code, COUNT(*) as `quantity` FROM tbl_order where date='$date' GROUP BY i_code,item_name HAVING COUNT(*) > 1 order by quantity desc,RAND() limit 25")->result();
		foreach ($query as $row)
		{
			$sameid.=$row->i_code.",";
		}
		$sameid = substr($sameid,0,-1);
		if(!empty($sameid))
		{
			$sameid = "m.i_code in(".$sameid.")";
		}
		
		if(!empty($sameid))
		{
			$this->db->select("m.*");
			$this->db->where($sameid);
			$this->db->order_by("RAND()");
			$this->db->limit('25');
			$query = $this->db->get("tbl_medicine as m")->result();
			foreach ($query as $row)
			{				
				$i_code				=	$row->i_code;
				$item_code			=	$row->item_code;
				$item_name			=	ucwords(strtolower($row->item_name));
				$company_full_name 	=  	ucwords(strtolower($row->company_full_name));
				$batchqty			=	$row->batchqty;
				$batch_no			=	$row->batch_no;
				$packing			=	$row->packing;
				$sale_rate			=	sprintf('%0.2f',round($row->sale_rate,2));
				$mrp				=	sprintf('%0.2f',round($row->mrp,2));
				$final_price		=	sprintf('%0.2f',round($row->final_price,2));
				$scheme				=	$row->salescm1."+".$row->salescm2;
				$expiry				=	$row->expiry;
				$margin 			=   round($row->margin);
				$featured 			= 	$row->featured;
				$discount 			= 	$row->discount;
				
				if(empty($discount))
				{
					$discount = "4.5";
				}
				
				$image1 = constant('img_url_site')."uploads/default_img.jpg";
				if(!empty($row->image1))
				{
					$image1 = constant('img_url_site').$row->image1;
				}
			
$items.= <<<EOD
{"i_code":"{$i_code}","item_code":"{$item_code}","item_name":"{$item_name}","company_full_name":"{$company_full_name}","image":"{$image1}","featured":"{$featured}","packing":"{$packing}","mrp":"{$mrp}","sale_rate":"{$sale_rate}","final_price":"{$final_price}","batchqty":"{$batchqty}","scheme":"{$scheme}","batch_no":"{$batch_no}","expiry":"{$expiry}","margin":"{$margin}"},
EOD;
			}
if ($items != '') {
	$items = substr($items, 0, -1);
}
		}
	return $items;
	}

	public function must_buy_medicines_json_new()
	{
		$items = "";
		$date = date("Y-m-d");
		
		$sameid = "";
		$query = $this->db->query("select DISTINCT i_code, COUNT(*) as `quantity` FROM tbl_order where date='$date' GROUP BY i_code,item_name HAVING COUNT(*) > 1 order by quantity desc,RAND() limit 15")->result();
		foreach ($query as $row)
		{
			$sameid.=$row->i_code.",";
		}
		$sameid = substr($sameid,0,-1);
		if(!empty($sameid))
		{
			$sameid = "m.i_code in(".$sameid.")";
		}
		
		if(!empty($sameid))
		{
			$this->db->select("m.*");
			$this->db->where($sameid);
			$this->db->order_by("RAND()");
			$this->db->limit('25');
			$query = $this->db->get("tbl_medicine as m")->result();
			foreach ($query as $row)
			{				
				$item_code			=	$row->i_code;
				$item_name			=	ucwords(strtolower($row->item_name));
				$item_packing		=	$row->packing;
				$item_company		=  	ucwords(strtolower($row->company_name));
				$item_quantity		=	$row->batchqty;
				$item_mrp			=	sprintf('%0.2f',round($row->mrp,2));
				$item_ptr			=	sprintf('%0.2f',round($row->sale_rate,2));
				$item_price			=	sprintf('%0.2f',round($row->final_price,2));
				$item_margin 		=   round($row->margin);
				$item_featured 		= 	$row->featured;
				
				$item_image = constant('img_url_site')."uploads/default_img.jpg";
				if(!empty($row->image1))
				{
					$item_image = constant('img_url_site').$row->image1;
				}

				$item_image 		= htmlentities($item_image);

				$item_header_title  = "Must buy";
				$get_record = "";
			
$items.= <<<EOD
{"item_code":"{$item_code}","item_image":"{$item_image}","item_name":"{$item_name}","item_packing":"{$item_packing}","item_company":"{$item_company}","item_quantity":"{$item_quantity}","item_mrp":"{$item_mrp}","item_ptr":"{$item_ptr}","item_price":"{$item_price}","item_margin":"{$item_margin}","item_featured":"{$item_featured}","item_header_title":"{$item_header_title}","get_record":"{$get_record}"},
EOD;
			}
if ($items != '') {
	$items = substr($items, 0, -1);
}
		}
	return $items;
	}

	public function frequently_use_medicines_json()
	{
		//error_reporting(0);
		$items = "";
		
		$sameid = "";
		$query = $this->db->query("select * from tbl_must_buy_medicines where status='1'")->result();
		foreach ($query as $row)
		{
			$sameid.=$row->itemid.",";
		}
		$sameid = substr($sameid,0,-1);
		if(!empty($sameid))
		{
			$sameid = "m.i_code in(".$sameid.")";
		}
		
		if(!empty($sameid))
		{
			$this->db->select("m.*");
			$this->db->where($sameid);
			$this->db->order_by("RAND()");
			$this->db->limit('25');
			$query = $this->db->get("tbl_medicine as m")->result();
			foreach ($query as $row)
			{				
				$i_code				=	$row->i_code;
				$item_code			=	$row->item_code;
				$item_name			=	ucwords(strtolower($row->item_name));
				$company_full_name 	=  	ucwords(strtolower($row->company_full_name));
				$batchqty			=	$row->batchqty;
				$batch_no			=	$row->batch_no;
				$packing			=	$row->packing;
				$sale_rate			=	sprintf('%0.2f',round($row->sale_rate,2));
				$mrp				=	sprintf('%0.2f',round($row->mrp,2));
				$final_price		=	sprintf('%0.2f',round($row->final_price,2));
				$scheme				=	$row->salescm1."+".$row->salescm2;
				$expiry				=	$row->expiry;
				$margin 			=   round($row->margin);
				$featured 			= 	$row->featured;
				$discount 			= 	$row->discount;
				
				if(empty($discount))
				{
					$discount = "4.5";
				}

				$image1 = constant('img_url_site')."uploads/default_img.jpg";
				if(!empty($row->image1))
				{
					$image1 = constant('img_url_site').$row->image1;
				}
			
$items.= <<<EOD
{"i_code":"{$i_code}","item_code":"{$item_code}","item_name":"{$item_name}","company_full_name":"{$company_full_name}","image":"{$image1}","featured":"{$featured}","packing":"{$packing}","mrp":"{$mrp}","sale_rate":"{$sale_rate}","final_price":"{$final_price}","batchqty":"{$batchqty}","scheme":"{$scheme}","batch_no":"{$batch_no}","expiry":"{$expiry}","margin":"{$margin}"},
EOD;
			}
if ($items != '') {
	$items = substr($items, 0, -1);
}
		}
	return $items;
	}

	public function frequently_use_medicines_json_new()
	{
		$items = "";
		
		$sameid = "";
		$query = $this->db->query("select * from tbl_must_buy_medicines where status='1'")->result();
		foreach ($query as $row)
		{
			$sameid.=$row->itemid.",";
		}
		$sameid = substr($sameid,0,-1);
		if(!empty($sameid))
		{
			$sameid = "m.i_code in(".$sameid.")";
		}
		
		if(!empty($sameid))
		{
			$this->db->select("m.*");
			$this->db->where($sameid);
			$this->db->order_by("RAND()");
			$this->db->limit('15');
			$query = $this->db->get("tbl_medicine as m")->result();
			foreach ($query as $row)
			{				
				$item_code			=	$row->i_code;
				$item_name			=	ucwords(strtolower($row->item_name));
				$item_packing		=	$row->packing;
				$item_company		=  	ucwords(strtolower($row->company_name));
				$item_quantity		=	$row->batchqty;
				$item_mrp			=	sprintf('%0.2f',round($row->mrp,2));
				$item_ptr			=	sprintf('%0.2f',round($row->sale_rate,2));
				$item_price			=	sprintf('%0.2f',round($row->final_price,2));
				$item_margin 		=   round($row->margin);
				$item_featured 		= 	$row->featured;
				
				$item_image = constant('img_url_site')."uploads/default_img.jpg";
				if(!empty($row->image1))
				{
					$item_image = constant('img_url_site').$row->image1;
				}

				$item_image 		= htmlentities($item_image);

				$item_header_title  = "Frequently use";
				$get_record = "";
			
$items.= <<<EOD
{"item_code":"{$item_code}","item_image":"{$item_image}","item_name":"{$item_name}","item_packing":"{$item_packing}","item_company":"{$item_company}","item_quantity":"{$item_quantity}","item_mrp":"{$item_mrp}","item_ptr":"{$item_ptr}","item_price":"{$item_price}","item_margin":"{$item_margin}","item_featured":"{$item_featured}","item_header_title":"{$item_header_title}","get_record":"{$get_record}"},
EOD;
			}
if ($items != '') {
	$items = substr($items, 0, -1);
}
		}
	return $items;
	}


	public function stock_now_available()
	{
		$items = "";
		
		$sameid = "";
		$query = $this->db->query("SELECT tbl_medicine.i_code FROM `tbl_low_stock_alert` inner join tbl_medicine on tbl_medicine.i_code=tbl_low_stock_alert.i_code where tbl_medicine.batchqty!='0' order by RAND() LIMIT 15")->result();
		foreach ($query as $row)
		{
			$sameid.=$row->i_code.",";
		}
		$sameid = substr($sameid,0,-1);
		if(!empty($sameid))
		{
			$sameid = "m.i_code in(".$sameid.")";
		}
		
		if(!empty($sameid))
		{
			$this->db->select("m.*");
			$this->db->where($sameid);
			//$this->db->order_by("RAND()");
			$this->db->limit('25');
			$query = $this->db->get("tbl_medicine as m")->result();
			foreach ($query as $row)
			{				
				$item_code			=	$row->i_code;
				$item_name			=	ucwords(strtolower($row->item_name));
				$item_packing		=	$row->packing;
				$item_company		=  	ucwords(strtolower($row->company_name));
				$item_quantity		=	$row->batchqty;
				$item_mrp			=	sprintf('%0.2f',round($row->mrp,2));
				$item_ptr			=	sprintf('%0.2f',round($row->sale_rate,2));
				$item_price			=	sprintf('%0.2f',round($row->final_price,2));
				$item_margin 		=   round($row->margin);
				$item_featured 		= 	$row->featured;
				
				$item_image = constant('img_url_site')."uploads/default_img.jpg";
				if(!empty($row->image1))
				{
					$item_image = constant('img_url_site').$row->image1;
				}

				$item_image 		= htmlentities($item_image);

				$item_header_title  = "Stock available now";
				$get_record = "";
			
$items.= <<<EOD
{"item_code":"{$item_code}","item_image":"{$item_image}","item_name":"{$item_name}","item_packing":"{$item_packing}","item_company":"{$item_company}","item_quantity":"{$item_quantity}","item_mrp":"{$item_mrp}","item_ptr":"{$item_ptr}","item_price":"{$item_price}","item_margin":"{$item_margin}","item_featured":"{$item_featured}","item_header_title":"{$item_header_title}","get_record":"{$get_record}"},
EOD;
			}
if ($items != '') {
	$items = substr($items, 0, -1);
}
		}
	return $items;
	}

	public function user_top_search_items($user_type,$user_altercode,$salesman_id)
	{
		$items = "";
		
		$sameid = "";
		$query = $this->db->query("select item_code from tbl_top_search where user_type='$user_type' and user_altercode='$user_altercode' and salesman_id='$salesman_id' limit 15")->result();
		foreach ($query as $row)
		{
			if(!empty($row->item_code))
			{
				$sameid.=$row->item_code.",";
			}
		}
		
		$sameid = substr($sameid,0,-1);
		if(!empty($sameid))
		{
			$sameid = "m.i_code in(".$sameid.")";
		}
		
		if(!empty($sameid))
		{
			$this->db->select("m.*");
			$this->db->where($sameid);
			//$this->db->order_by("RAND()");
			$this->db->limit('25');
			$query = $this->db->get("tbl_medicine as m")->result();
			foreach ($query as $row)
			{				
				$item_code			=	$row->i_code;
				$item_name			=	ucwords(strtolower($row->item_name));
				$item_packing		=	$row->packing;
				$item_company		=  	ucwords(strtolower($row->company_name));
				$item_quantity		=	$row->batchqty;
				$item_mrp			=	sprintf('%0.2f',round($row->mrp,2));
				$item_ptr			=	sprintf('%0.2f',round($row->sale_rate,2));
				$item_price			=	sprintf('%0.2f',round($row->final_price,2));
				$item_margin 		=   round($row->margin);
				$item_featured 		= 	$row->featured;
				
				$item_image = constant('img_url_site')."uploads/default_img.jpg";
				if(!empty($row->image1))
				{
					$item_image = constant('img_url_site').$row->image1;
				}

				$item_image 		= htmlentities($item_image);

				$item_header_title  = "Top Search";
				$get_record = "";
			
$items.= <<<EOD
{"item_code":"{$item_code}","item_image":"{$item_image}","item_name":"{$item_name}","item_packing":"{$item_packing}","item_company":"{$item_company}","item_quantity":"{$item_quantity}","item_mrp":"{$item_mrp}","item_ptr":"{$item_ptr}","item_price":"{$item_price}","item_margin":"{$item_margin}","item_featured":"{$item_featured}","item_header_title":"{$item_header_title}","get_record":"{$get_record}"},
EOD;
			}
if ($items != '') {
	$items = substr($items, 0, -1);
}
		}
	return $items;
	}
	
	public function featured_brand($compcode,$division,$orderby)
	{
		//error_reporting(0);
		if($orderby=="not")
		{			
			if($division=="")
			{
				$this->db->order_by('batchqty','desc');
				$this->db->order_by('item_name','asc');
				$this->db->where('compcode',$compcode);
				//$this->db->where('division',$division);
			}
			else
			{
				$this->db->order_by('item_name','asc');
				$this->db->where('compcode',$compcode);
				$this->db->where('division',$division);
			}
		}
		if($orderby=="sort_price")
		{
			if($division=="")
			{
				$this->db->order_by('mrp','asc');
				$this->db->where('compcode',$compcode);
				//$this->db->where('division',$division);
			}
			else
			{
				$this->db->order_by('mrp','asc');
				$this->db->where('compcode',$compcode);
				$this->db->where('division',$division);
			}
		}
		if($orderby=="sort_price1")
		{
			if($division=="")
			{
				$this->db->order_by('mrp','desc');
				$this->db->where('compcode',$compcode);
				//$this->db->where('division',$division);
			}
			else
			{
				$this->db->order_by('mrp','desc');
				$this->db->where('compcode',$compcode);
				$this->db->where('division',$division);
			}
		}
		if($orderby=="sort_margin")
		{
			if($division=="")
			{
				$this->db->order_by('margin','asc');
				$this->db->where('compcode',$compcode);
				//$this->db->where('division',$division);
			}
			else
			{
				$this->db->order_by('margin','asc');
				$this->db->where('compcode',$compcode);
				$this->db->where('division',$division);
			}
		}
		if($orderby=="sort_margin1")
		{
			if($division=="")
			{
				$this->db->order_by('margin','desc');
				$this->db->where('compcode',$compcode);
				//$this->db->where('division',$division);
			}
			else
			{
				$this->db->order_by('margin','desc');
				$this->db->where('compcode',$compcode);
				$this->db->where('division',$division);
			}
		}
		if($orderby=="sort_atoz")
		{
			if($division=="")
			{
				$this->db->order_by('item_name','asc');
				$this->db->where('compcode',$compcode);
				//$this->db->where('division',$division);
			}
			else
			{
				$this->db->order_by('item_name','asc');
				$this->db->where('compcode',$compcode);
				$this->db->where('division',$division);
			}
		}
		if($orderby=="sort_ztoa")
		{
			if($division=="")
			{
				$this->db->order_by('item_name','desc');
				$this->db->where('compcode',$compcode);
				//$this->db->where('division',$division);
			}
			else
			{				
				$this->db->order_by('item_name','desc');
				$this->db->where('compcode',$compcode);
				$this->db->where('division',$division);
			}
		}
		$this->db->where('status','1');
		$query = $this->db->get("tbl_medicine")->result();
		$i = 0;
		$items = "";
		foreach ($query as $row)
		{
			if(substr($row->item_name,0,1)==".")
			{
			}
			else
			{
				if($row->misc_settings=="#ITNOTE" && $row->batchqty=="0.000")
				{					

				}
				else
				{
					if($row->sale_rate=="0" || $row->sale_rate=="0.0")
					{
					}
					else
					{						
						$id					=	$row->id;
						$compcode			=	$row->compcode;
						$i_code				=	$row->i_code;
						$featured 			= 	$row->featured;
						
						$image1 = constant('img_url_site')."uploads/default_img.jpg";
						if(!empty($row->image1))
						{
							$image1 = constant('img_url_site').$row->image1;
						}
						if($featured=="1")
						{
							$i++;
							if($i<4)
							{								
								$sameid[$id]    =	$id;
								$name		=	ucwords(strtolower($row->item_name));
								$company 	= ucwords(strtolower($row->company_full_name));
								$qty		=	$row->batchqty;
								$packing	=	$row->packing;
								$expiry		=	$row->expiry;
								$scheme		=	$row->salescm1."+".$row->salescm2;
								$misc_settings=	$row->misc_settings;
								$margin		=	$row->margin;
								
								$mrp		=	sprintf('%0.2f',round($row->mrp,2));
								$ptr		=	sprintf('%0.2f',round($row->sale_rate,2));
								$price		=	sprintf('%0.2f',round($row->final_price,2));

$items .= <<<EOD
{"i_code":"{$i_code}","name":"{$name}","company":"{$company}","qty":"{$qty}","packing":"{$packing}","expiry":"{$expiry}","image":"{$image1}","mrp":"{$mrp}","ptr":"{$ptr}","price":"{$price}","margin":"{$margin}","scheme":"{$scheme}","featured":"{$featured}","misc_settings":"{$misc_settings}"},
EOD;
							}
						}
					}
				}
			}
		}
		foreach ($query as $row)
		{
			if(substr($row->item_name,0,1)==".")
			{
			}
			else
			{
				if($row->misc_settings=="#ITNOTE" && $row->batchqty=="0.000")
				{					

				}
				else
				{
					if($row->sale_rate=="0" || $row->sale_rate=="0.0")
					{
					}
					else
					{						
						$id			=	$row->id;						
						$name		=	ucwords(strtolower($row->item_name));
						$company 	= ucwords(strtolower($row->company_full_name));
						$qty		=	$row->batchqty;
						$packing	=	$row->packing;
						$expiry		=	$row->expiry;
						$scheme		=	$row->salescm1."+".$row->salescm2;
						$misc_settings=	$row->misc_settings;
						$margin		=	$row->margin;
						
						$mrp		=	sprintf('%0.2f',round($row->mrp,2));
						$ptr		=	sprintf('%0.2f',round($row->sale_rate,2));
						$price		=	sprintf('%0.2f',round($row->final_price,2));
						
						$image1 = constant('img_url_site')."uploads/default_img.jpg";
						if(!empty($row->image1))
						{
							$image1 = constant('img_url_site').$row->image1;
						}
						if(empty($sameid[$id]))
						{
$items .= <<<EOD
{"i_code":"{$i_code}","name":"{$name}","company":"{$company}","qty":"{$qty}","packing":"{$packing}","expiry":"{$expiry}","image":"{$image1}","mrp":"{$mrp}","ptr":"{$ptr}","price":"{$price}","margin":"{$margin}","scheme":"{$scheme}","featured":"{$featured}","misc_settings":"{$misc_settings}"},
EOD;
						}
					}
				}
			}
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}

	public function featured_brand_api($compcode="",$division="",$get_record="")
	{
		$this->db->where('compcode',$compcode);
		if($division!="")
		{
			$this->db->where('division',$division);
		}
		$this->db->where('status','1');
		$this->db->order_by('featured','desc');
		$this->db->order_by('batchqty','desc');
		$this->db->order_by('item_name','asc');
		$this->db->limit(12,$get_record);
		$query = $this->db->get("tbl_medicine")->result();
		$i = 0;
		$items = "";
		foreach ($query as $row)
		{
			if((substr($row->item_name,0,1)==".") && ($row->misc_settings=="#ITNOTE" && $row->batchqty=="0.000") && ($row->sale_rate=="0" || $row->sale_rate=="0.0"))
			{
			}
			else
			{						
				$item_featured 		= 	$row->featured;
				if($item_featured=="1")
				{			
					$id					=	$row->id;	
					$i++;
					if($i<4)
					{		
						$get_record++;						
						$sameid[$id]    =	$id;

						$item_code		=	$row->i_code;
						$item_name		=	ucwords(strtolower($row->item_name));		
						$item_packing	=	$row->packing;				
						$item_company 	= 	ucwords(strtolower($row->company_full_name));
						$item_margin	=	$row->margin;
						$item_quantity	=	$row->batchqty;
						$item_featured 	= 	$row->featured;				
						
						$item_mrp		=	sprintf('%0.2f',round($row->mrp,2));
						$item_ptr		=	sprintf('%0.2f',round($row->sale_rate,2));
						$item_price		=	sprintf('%0.2f',round($row->final_price,2));
						
						$item_image = constant('img_url_site')."uploads/default_img.jpg";
						if(!empty($row->image1))
						{
							$item_image = constant('img_url_site').$row->image1;
						}

						$item_header_title = ucwords(strtolower($row->company_full_name)); 

$items.= <<<EOD
{"item_code":"{$item_code}","item_image":"{$item_image}","item_name":"{$item_name}","item_packing":"{$item_packing}","item_company":"{$item_company}","item_quantity":"{$item_quantity}","item_mrp":"{$item_mrp}","item_ptr":"{$item_ptr}","item_price":"{$item_price}","item_margin":"{$item_margin}","item_featured":"{$item_featured}","item_header_title":"{$item_header_title}","get_record":"{$get_record}"},
EOD;
					}
				}
			}
		}
		foreach ($query as $row)
		{
			if((substr($row->item_name,0,1)==".") && ($row->misc_settings=="#ITNOTE" && $row->batchqty=="0.000") && ($row->sale_rate=="0" || $row->sale_rate=="0.0"))
			{
			}
			else
			{						
				$id		=	$row->id;
				if(empty($sameid[$id]))
				{
					$get_record++;
					$item_code		=	$row->i_code;
					$item_name		=	ucwords(strtolower($row->item_name));		
					$item_packing	=	$row->packing;				
					$item_company 	= 	ucwords(strtolower($row->company_full_name));
					$item_margin	=	$row->margin;
					$item_quantity	=	$row->batchqty;
					$item_featured 	= 	$row->featured;
					
					$item_mrp		=	sprintf('%0.2f',round($row->mrp,2));
					$item_ptr		=	sprintf('%0.2f',round($row->sale_rate,2));
					$item_price		=	sprintf('%0.2f',round($row->final_price,2));
					
					$item_image = constant('img_url_site')."uploads/default_img.jpg";
					if(!empty($row->image1))
					{
						$item_image = constant('img_url_site').$row->image1;
					}

					$item_header_title = ucwords(strtolower($row->company_full_name)); 
				
$items.= <<<EOD
{"item_code":"{$item_code}","item_image":"{$item_image}","item_name":"{$item_name}","item_packing":"{$item_packing}","item_company":"{$item_company}","item_quantity":"{$item_quantity}","item_mrp":"{$item_mrp}","item_ptr":"{$item_ptr}","item_price":"{$item_price}","item_margin":"{$item_margin}","item_featured":"{$item_featured}","item_header_title":"{$item_header_title}","get_record":"{$get_record}"},
EOD;
				}
			}
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function medicine_category($itemcat='',$orderby='')
	{
		//error_reporting(0);
		//$this->db->order_by('batchqty','desc');
		if($orderby=="not")
		{
			$this->db->order_by('item_name','asc');
			$this->db->order_by('batchqty','desc');
		}
		if($orderby=="sort_price")
		{
			$this->db->order_by('mrp','asc');
		}
		if($orderby=="sort_price1")
		{
			$this->db->order_by('mrp','desc');
		}
		if($orderby=="sort_margin")
		{
			$this->db->order_by('margin','asc');
		}
		if($orderby=="sort_margin1")
		{
			$this->db->order_by('margin','desc');
		}
		if($orderby=="sort_atoz")
		{
			$this->db->order_by('item_name','asc');
		}
		if($orderby=="sort_ztoa")
		{
			$this->db->order_by('item_name','desc');
		}
		$this->db->where('itemcat',$itemcat);
		$this->db->where('status','1');
		$query = $this->db->get("tbl_medicine")->result();
		$i = 0;
		$items = "";
		foreach ($query as $row)
		{
			if(substr($row->item_name,0,1)==".")
			{
			}
			else
			{
				if($row->misc_settings=="#ITNOTE" && $row->batchqty=="0.000")
				{					

				}
				else
				{
					if($row->sale_rate=="0" || $row->sale_rate=="0.0")
					{
					}
					else
					{						
						$id					=	$row->id;
						$i_code				=	$row->i_code;
						$featured 			= 	$row->featured;
						
						$image1 = constant('img_url_site')."uploads/default_img.jpg";
						if(!empty($row->image1))
						{
							$image1 = constant('img_url_site').$row->image1;
						}
						if($featured=="1")
						{
							$i++;
							if($i<4)
							{								
								$sameid[$id]    =	$id;
								$name			=	ucwords(strtolower($row->item_name));						
								$company 		= ucwords(strtolower($row->company_full_name));
								$qty			=	$row->batchqty;
								$packing		=	$row->packing;
								$expiry			=	$row->expiry;
								$scheme			=	$row->salescm1."+".$row->salescm2;
								$misc_settings	=	$row->misc_settings;
								$margin			=	$row->margin;
								
								$mrp				=	sprintf('%0.2f',round($row->mrp,2));
								$ptr			=	sprintf('%0.2f',round($row->sale_rate,2));
								$price		=	sprintf('%0.2f',round($row->final_price,2));

$items .= <<<EOD
{"i_code":"{$i_code}","name":"{$name}","company":"{$company}","qty":"{$qty}","packing":"{$packing}","expiry":"{$expiry}","image":"{$image1}","mrp":"{$mrp}","ptr":"{$ptr}","price":"{$price}","margin":"{$margin}","scheme":"{$scheme}","featured":"{$featured}","misc_settings":"{$misc_settings}"},
EOD;
							}
						}
					}
				}
			}
		}
		foreach ($query as $row)
		{
			if(substr($row->item_name,0,1)==".")
			{
			}
			else
			{
				if($row->misc_settings=="#ITNOTE" && $row->batchqty=="0.000")
				{					

				}
				else
				{
					if($row->sale_rate=="0" || $row->sale_rate=="0.0")
					{
					}
					else
					{						
						$id				=	$row->id;
						$name			=	ucwords(strtolower($row->item_name));						
						$company 		= ucwords(strtolower($row->company_full_name));
						$qty			=	$row->batchqty;
						$packing		=	$row->packing;
						$expiry			=	$row->expiry;
						$scheme			=	$row->salescm1."+".$row->salescm2;
						$misc_settings	=	$row->misc_settings;
						$margin			=	$row->margin;
						
						$mrp			=	sprintf('%0.2f',round($row->mrp,2));
						$ptr			=	sprintf('%0.2f',round($row->sale_rate,2));
						$price			=	sprintf('%0.2f',round($row->final_price,2));
						
						$image1 = constant('img_url_site')."uploads/default_img.jpg";
						if(!empty($row->image1))
						{
							$image1 = constant('img_url_site').$row->image1;
						}
						if(empty($sameid[$id]))
						{
$items .= <<<EOD
{"i_code":"{$i_code}","name":"{$name}","company":"{$company}","qty":"{$qty}","packing":"{$packing}","expiry":"{$expiry}","image":"{$image1}","mrp":"{$mrp}","ptr":"{$ptr}","price":"{$price}","margin":"{$margin}","scheme":"{$scheme}","featured":"{$featured}","misc_settings":"{$misc_settings}"},
EOD;
						}
					}
				}
			}
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}

	public function medicine_category_api($itemcat="",$get_record="")
	{
		$this->db->where('itemcat',$itemcat);
		$this->db->where('status','1');
		$this->db->order_by('featured','desc');
		$this->db->order_by('batchqty','desc');
		$this->db->order_by('item_name','asc');
		$this->db->limit(12,$get_record);
		$query = $this->db->get("tbl_medicine")->result();

		$row1 = $this->db->query("select * from tbl_medicine_category where code='$itemcat'")->row();
		$i = 0;
		$items = "";
		foreach ($query as $row)
		{
			if((substr($row->item_name,0,1)==".") && ($row->misc_settings=="#ITNOTE" && $row->batchqty=="0.000") && ($row->sale_rate=="0" || $row->sale_rate=="0.0"))
			{
			}
			else
			{
				$item_featured 		= 	$row->featured;
				if($item_featured=="1")
				{			
					$id					=	$row->id;	
					$i++;
					if($i<4)
					{		
						$get_record++;						
						$sameid[$id]    =	$id;

						$item_code		=	$row->i_code;
						$item_name		=	ucwords(strtolower($row->item_name));		
						$item_packing	=	$row->packing;				
						$item_company 	= 	ucwords(strtolower($row->company_full_name));
						$item_margin	=	$row->margin;
						$item_quantity	=	$row->batchqty;
						$item_featured 	= 	$row->featured;						
						
						$item_mrp		=	sprintf('%0.2f',round($row->mrp,2));
						$item_ptr		=	sprintf('%0.2f',round($row->sale_rate,2));
						$item_price		=	sprintf('%0.2f',round($row->final_price,2));
						
						$item_image = constant('img_url_site')."uploads/default_img.jpg";
						if(!empty($row->image1))
						{
							$item_image = constant('img_url_site').$row->image1;
						}

						$item_header_title	=	ucwords(strtolower($row1->menu));

$items.= <<<EOD
{"item_code":"{$item_code}","item_image":"{$item_image}","item_name":"{$item_name}","item_packing":"{$item_packing}","item_company":"{$item_company}","item_quantity":"{$item_quantity}","item_mrp":"{$item_mrp}","item_ptr":"{$item_ptr}","item_price":"{$item_price}","item_margin":"{$item_margin}","item_featured":"{$item_featured}","item_header_title":"{$item_header_title}","get_record":"{$get_record}"},
EOD;
					}
				}
			}
		}
		foreach ($query as $row)
		{
			if((substr($row->item_name,0,1)==".") && ($row->misc_settings=="#ITNOTE" && $row->batchqty=="0.000") && ($row->sale_rate=="0" || $row->sale_rate=="0.0"))
			{
			}
			else
			{						
				$id		=	$row->id;
				if(empty($sameid[$id]))
				{
					$get_record++;
					$item_code		=	$row->i_code;
					$item_name		=	ucwords(strtolower($row->item_name));		
					$item_packing	=	$row->packing;				
					$item_company 	= 	ucwords(strtolower($row->company_full_name));
					$item_margin	=	$row->margin;
					$item_quantity	=	$row->batchqty;
					$item_featured 	= 	$row->featured;					
					
					$item_mrp		=	sprintf('%0.2f',round($row->mrp,2));
					$item_ptr		=	sprintf('%0.2f',round($row->sale_rate,2));
					$item_price		=	sprintf('%0.2f',round($row->final_price,2));
					
					$item_image = constant('img_url_site')."uploads/default_img.jpg";
					if(!empty($row->image1))
					{
						$item_image = constant('img_url_site').$row->image1;
					}

					$item_header_title	=	ucwords(strtolower($row1->menu));
				
$items.= <<<EOD
{"item_code":"{$item_code}","item_image":"{$item_image}","item_name":"{$item_name}","item_packing":"{$item_packing}","item_company":"{$item_company}","item_quantity":"{$item_quantity}","item_mrp":"{$item_mrp}","item_ptr":"{$item_ptr}","item_price":"{$item_price}","item_margin":"{$item_margin}","item_featured":"{$item_featured}","item_header_title":"{$item_header_title}","get_record":"{$get_record}"},
EOD;
				}
			}
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}

	public function my_invoice_api($user_type="",$user_altercode="",$salesman_id="",$get_record="")
	{
		$items = "";
		if($user_type=="sales")
		{
			$this->db->where('altercode',$user_altercode);
			$this->db->order_by('id','desc');
			$this->db->limit(12,$get_record);
			$query = $this->db->get("tbl_invoice")->result();
		}
		else
		{
			$this->db->where('altercode',$user_altercode);
			$this->db->order_by('id','desc');
			$this->db->limit(12,$get_record);
			$query = $this->db->get("tbl_invoice")->result();
		}
		foreach($query as $row)
		{
			$get_record++;
			$item_id			= $row->id;
			$item_title 		= $row->gstvno;
			$item_total 		= number_format($row->amt,2);
			$item_date_time 	= date("d-M-y",strtotime($row->date));
			$out_for_delivery 	= $row->out_for_delivery;
			$delete_status		= $row->delete_status;

			$row1 = $this->db->query("SELECT tbl_acm.name,tbl_acm.altercode,tbl_acm_other.image from tbl_acm,tbl_acm_other where tbl_acm.altercode='$row->altercode' and tbl_acm.code = tbl_acm_other.code")->row();
			$user_image = constant('main_site')."user_profile/$row1->image";
			if(empty($row1->image))
			{
				$user_image = constant('main_site')."img_v".constant('site_v')."/logo.png";
			}
			$item_message   = $item_total;
			$item_image 	= $user_image;

			$gstvno = $row->gstvno;
			$download_url = constant('main_site')."user/download_invoice1/".$user_altercode."/".$gstvno;

$items.= <<<EOD
{"item_id":"{$item_id}","item_title":"{$item_title}","item_message":"{$item_message}","item_date_time":"{$item_date_time}","item_image":"{$item_image}","out_for_delivery":"{$out_for_delivery}","delete_status":"{$delete_status}","download_url":"{$download_url}","get_record":"{$get_record}"},
EOD;
		}
if ($items != ''){
	$items = substr($items, 0, -1);
}
	return $items;
	}

	public function my_invoice_details_api($user_type="",$user_altercode="",$salesman_id="",$item_id="")
	{
		$header_title = "";
		$download_url = "";
		$items = "";
		$delete_items = "";
		$this->db->where('id',$item_id);
		$this->db->where('altercode',$user_altercode);
		$row = $this->db->get("tbl_invoice")->row();
		if($row->id!="")
		{
			$inv_type 	= "insert";
			$id			= $row->id;
			$gstvno 	= $row->gstvno;
			$header_title = $gstvno;
			$date_time 	= date("d-M-y",strtotime($row->date));
			$total 		= number_format($row->amt,2);
			$excelFile 	= "./upload_invoice/".$gstvno.".xls";
			$download_url = constant('main_site')."user/download_invoice/".$user_altercode."/".$gstvno;
			
			$excelFile_delete 	= "./upload_invoice/delete_".$gstvno.".xls";
			
			$name = substr($row->name,0,19);
			$file_name = "_D.R.DISTRIBUTORS PVT_".$name.".xls";
			
			$status = "Generated";
				
			$item_code_r 	= "E";
			$qty_r 			= "K";
			
			$i = 1;
			$headername = 2;
			$this->load->library('excel');
			$objPHPExcel = PHPExcel_IOFactory::load($excelFile);
			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow();
				for ($row=$headername; $row<=$highestRow; $row++)
				{	
					$item_code 	= $worksheet->getCell($item_code_r.$row)->getValue();
					$item_quantity = $worksheet->getCell($qty_r.$row)->getValue();
					
					$row1 = $this->db->query("select * from tbl_medicine where i_code='$item_code'")->row();

					$item_price 		= sprintf('%0.2f',round($row1->sale_rate,2));
					$item_quantity_price= sprintf('%0.2f',round($item_quantity * $row1->sale_rate,2));
					$item_date_time 	= date("d-M-y",strtotime($date_time));
					$item_modalnumber 	= "Pc / Laptop"; //$row->modalnumber;
					
					$item_name 		= htmlentities(ucwords(strtolower($row1->item_name)));
					$item_packing 	= htmlentities($row1->packing);
					$item_expiry 	= htmlentities($row1->expiry);
					$item_company 	= htmlentities(ucwords(strtolower($row1->company_full_name)));
					$item_scheme 	= $row1->salescm1."+".$row1->salescm2;
					$item_featured 	= $row1->featured;

					$item_image		= constant('img_url_site').$row1->image1;
					if(empty($row1->image1))
					{
						$item_image = constant('main_site')."uploads/default_img.jpg";
					}
					
$items.= <<<EOD
{"item_code":"{$item_code}","item_image":"{$item_image}","item_name":"{$item_name}","item_packing":"{$item_packing}","item_expiry":"{$item_expiry}","item_company":"{$item_company}","item_scheme":"{$item_scheme}","item_featured":"{$item_featured}","item_price":"{$item_price}","item_quantity":"{$item_quantity}","item_quantity_price":"{$item_quantity_price}","item_date_time":"{$item_date_time}","item_modalnumber":"{$item_modalnumber}"},
EOD;
				}
			}
			
			if(file_exists($excelFile_delete)=="1")
			{
				$item_code_r 	= "A";
				$qty_r 			= "F";
				$remarks_r		= "H";

				$i = 1;
				$headername = 2;
				$objPHPExcel = PHPExcel_IOFactory::load($excelFile_delete);
				foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
				{
					$highestRow = $worksheet->getHighestRow();
					for ($row=$headername; $row<=$highestRow; $row++)
					{
						$item_code 	= $worksheet->getCell($item_code_r.$row)->getValue();
						$item_quantity = $worksheet->getCell($qty_r.$row)->getValue();
						$item_remarks = $worksheet->getCell($remarks_r.$row)->getValue();
					
						$row1 = $row1 = $this->db->query("select * from tbl_medicine where i_code='$item_code'")->row();

						$item_price 		= sprintf('%0.2f',round($row1->sale_rate,2));
						$item_quantity_price=  $item_price;
						$item_date_time 	= date("d-M-y",strtotime($date_time));
						$item_modalnumber 	= "Pc / Laptop"; //$row->modalnumber;
						
						$item_name 		= htmlentities(ucwords(strtolower($row1->item_name)));
						$item_packing 	= htmlentities($row1->packing);
						$item_expiry 	= htmlentities($row1->expiry);
						$item_company 	= htmlentities(ucwords(strtolower($row1->company_full_name)));
						$item_scheme 	= $row1->salescm1."+".$row1->salescm2;
						$item_featured 	= $row1->featured;

						$item_image		= constant('img_url_site').$row1->image1;
						if(empty($row1->image1))
						{
							$item_image = constant('main_site')."uploads/default_img.jpg";
						}

						$item_description1 = $item_remarks;
						$item_description1  =  $this->new_clean($item_description1);
					
$delete_items.= <<<EOD
{"item_code":"{$item_code}","item_image":"{$item_image}","item_name":"{$item_name}","item_packing":"{$item_packing}","item_expiry":"{$item_expiry}","item_company":"{$item_company}","item_scheme":"{$item_scheme}","item_featured":"{$item_featured}","item_price":"{$item_price}","item_quantity":"{$item_quantity}","item_quantity_price":"{$item_quantity_price}","item_date_time":"{$item_date_time}","item_modalnumber":"{$item_modalnumber}","item_description1":"{$item_description1}"},
EOD;
					}
				}
			}
		}
if ($items != ''){
	$items = substr($items, 0, -1);
}

if ($delete_items != ''){
	$delete_items = substr($delete_items, 0, -1);
}

$header_title= <<<EOD
{"header_title":"{$header_title}"}
EOD;

$download_url= <<<EOD
{"download_url":"{$download_url}"}
EOD;

	$val[0] = $items;
	$val[1] = $delete_items;
	$val[2] = $download_url;
	$val[3] = $header_title;
	return $val;
	}
	
	public function check_download_invoice($user_type,$chemist_id,$lastid1,$gstvno)
	{
		$download = "no";
		$this->db->where('altercode',$chemist_id);
		$this->db->where('gstvno',$gstvno);
		$row = $this->db->get("tbl_invoice")->row();	
		if($row->id!="")
		{
			$download = "yes";
		}
$items.= <<<EOD
{"download":"{$download}"},
EOD;
if ($items != ''){
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function medicine_add_to_cart_api($user_type,$user_altercode,$salesman_id,$order_type,$item_code,$item_order_quantity,$mobilenumber,$modalnumber,$device_id,$excel_number="0")
	{
		$where = array('chemist_id'=>$user_altercode,'selesman_id'=>$salesman_id,'user_type'=>$user_type,'i_code'=>$item_code,'status'=>'0');
		$this->db->delete("drd_temp_rec", $where);
		
		$time = time();
		$date = date("Y-m-d",$time);
		$datetime = date("d-M-y H:i",$time);
		
		if($user_type=="sales")
		{
			$temp_rec = $user_type."_".$salesman_id."_".$user_altercode;			
		}
		else
		{
			$temp_rec = $user_type."_".$user_altercode;
		}

		if($excel_number==0){
			$row2 = $this->db->query("select excel_number from drd_temp_rec where chemist_id='$user_altercode' and selesman_id='$salesman_id' and user_type='$user_type' and status=0 order by id desc")->row();
			if(!empty($row2->excel_number)){
				$excel_number = $row2->excel_number + 1;
			}
		}
			
		$where1 = array('i_code'=>$item_code);
		$row1 = $this->Scheme_Model->select_row("tbl_medicine",$where1);
		if(!empty($row1->item_name))
		{
			$image1 = constant('img_url_site')."uploads/default_img.jpg";
			if(!empty($row1->image1))
			{
				$image1 = constant('img_url_site').$row1->image1;
			}
			
			$dt = array(
				'i_code'=>$item_code,
				'item_code'=>$row1->item_code,
				'quantity'=>$item_order_quantity,				
				'item_name'=>$row1->item_name,
				'packing'=>$row1->packing,
				'expiry'=>$row1->expiry,
				'margin'=>$row1->margin,
				'featured'=>$row1->featured,
				'company_full_name'=>$row1->company_full_name,
				'sale_rate'=>$row1->final_price,
				'scheme'=>$row1->salescm1."+".$row1->salescm2,
				'image'=>$image1,
				'chemist_id'=>$user_altercode,
				'selesman_id'=>$salesman_id,
				'user_type'=>$user_type,
				'date'=>$date,
				'time'=>$time,
				'datetime'=>$datetime,
				'temp_rec'=>$temp_rec,
				'order_type'=>$order_type,
				'mobilenumber'=>$mobilenumber,
				'modalnumber'=>$modalnumber,
				'device_id'=>$device_id,
				'excel_number'=>$excel_number,
				);
			$this->Scheme_Model->insert_fun("drd_temp_rec",$dt);
			
			$status = "1";
		}else{
			$status = "0";
		}
		return $status;
	}

	public function delete_medicine_api($user_type="",$user_altercode="",$salesman_id="",$item_code="")
	{
		$response = $this->db->query("delete from drd_temp_rec where user_type='$user_type' and chemist_id='$user_altercode' and selesman_id='$salesman_id' and status='0' and i_code='$item_code'");
		
		return $response;
	}

	public function delete_all_medicine_api($user_type="",$user_altercode="",$salesman_id="")
	{
		$response = $this->db->query("delete from drd_temp_rec where user_type='$user_type' and chemist_id='$user_altercode' and selesman_id='$salesman_id' and status='0'");
		
		return $response;
	}
	
	public function count_temp_rec($user_type="",$user_altercode="",$salesman_id="")
	{		
		$count = 0;
		if($user_type=="sales")
		{			
			if(empty($user_altercode))
			{
				$row = $this->db->query("select count(distinct temp_rec) as total from drd_temp_rec where selesman_id='$salesman_id' and status='0' order by chemist_id asc")->row();
				if(!empty($row->total))
				{
					$count = $row->total;
				}
			} else {
				$row = $this->db->query("select count(chemist_id) as total from drd_temp_rec where chemist_id='$user_altercode' and selesman_id='$salesman_id' and status='0' order by chemist_id asc")->row();
				if(!empty($row->total))
				{
					$count = $row->total;
				}
			}
		}
		else
		{			
			$row = $this->db->query("select count(chemist_id) as total from drd_temp_rec where chemist_id='$user_altercode' and selesman_id='' and status='0' order by chemist_id asc")->row();
			if(!empty($row->total))
			{
				$count = $row->total;
			}
		}
		return $count;
	}

	public function medicine_similar_api($item_code="",$get_record="")
	{
		$items = "";
		$row = $this->db->query("select itemjoinid FROM tbl_medicine WHERE i_code='$item_code'")->row();
		$itemjoinid = $row->itemjoinid;

		if($itemjoinid!=""){
			$itemjoinid = explode (",", $itemjoinid);
			foreach($itemjoinid as $item_code_n)
			{
				$items.= $this->get_itemjoinid($item_code_n);
			}
			if ($items != '') {
				$items = substr($items, 0, -1);
			}
		}
		return $items;
	}

	public function add_low_stock_alert($i_code)
	{	
		$user_type 		= $_COOKIE['user_type'];
		$user_altercode	= $_COOKIE['user_altercode'];
		$chemist_id 	= $_COOKIE['chemist_id'];
		
		$salesman_id = "";
		if($user_type=="sales")
		{
			$salesman_id 	= $user_altercode;
			$user_altercode = $chemist_id;
		}

		$date = date('Y-m-d');
		$time = date("H:i",time());
		
		if($user_type=="sales")
		{
			$where = array('altercode'=>$user_altercode,);
			$qr = $this->Scheme_Model->select_row("tbl_acm",$where);

			$title 			= ucwords(strtolower($qr->name));
			$chemist_name 	= "$title - ($user_altercode)";	

			$where = array('customer_code'=>$salesman_id,);
			$qr = $this->Scheme_Model->select_row("tbl_users",$where);
			
			$name 			= ucwords(strtolower($qr->firstname." ".$qr->lastname));
			$salesman_name 	= "$name - ($qr->customer_code)";
		}
		if($user_type=="chemist")
		{			
			$where = array('altercode'=>$user_altercode,);
			$qr = $this->Scheme_Model->select_row("tbl_acm",$where);

			$title 			= ucwords(strtolower($qr->name));
			$chemist_name 	= "$title - ($qr->altercode)";
		}
		
		$where = array('i_code'=>$i_code);
		$row = $this->Scheme_Model->select_row("tbl_medicine",$where);
		if(!empty($row->item_name))
		{
			$item_name = $row->item_name;
			$item_code = $row->item_code;
			
			$where1 = array('i_code'=>$i_code,'date'=>$date,);
			$row1 = $this->Scheme_Model->select_row("tbl_low_stock_alert",$where1);
			if(empty($row1->i_code))
			{
				$dt = array(
				'user_type'=>$user_type,
				'chemist_id'=>$user_altercode,
				'salesman_id'=>$salesman_id,
				'i_code'=>$i_code,
				'item_name'=>$item_name,
				'item_code'=>$item_code,
				'date'=>$date,
				'time'=>$time,
				'download_status'=>0,
				);
				$query = $this->Scheme_Model->insert_fun("tbl_low_stock_alert",$dt);
			}
		}
		
		$subject  = "DRD Low Stock || $title";
		$message  = "Hi $title,<br><br> One of the customer tried to order a Medicine which is currently out of stock <br><br>";
		$message .= "Item Name : ".$item_name."<br>";
		$message .= "Item Code : ".$item_code."<br>";
		$message .= "Chemist Name : ".$chemist_name."<br>";
		if($salesman_name)
		{
			$message .= "Salesman Name : ".$salesman_name."<br>";
		}
		$message .= "<br>Please arrange a callback for the customer to place this order.";
		$message .="<br><br>Thanks<br>D R Distributors Private Limited<br><br>";
		
		/**********************************************************/
		
		if(!empty($query))
		{
			$subject = ($subject);
			$message = ($message);
			$email_function = "low_stock_alert";
			$mail_server = "";
			
			$row = $this->db->query("select * from tbl_email where email_function='$email_function'")->row();
			$user_email_id = $row->email;

			$date = date('Y-m-d');
			$time = date("H:i",time());

			$dt = array(
			'user_email_id'=>$user_email_id,
			'subject'=>$subject,
			'message'=>$message,
			'email_function'=>$email_function,
			'mail_server'=>$mail_server,
			'date'=>$date,
			'time'=>$time,
			);
			$this->Scheme_Model->insert_fun("tbl_email_send",$dt);
		}
	}
}