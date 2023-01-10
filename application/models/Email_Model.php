<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Email_Model extends CI_Model
{
	public function tbl_whatsapp_email_fail($number,$message,$altercode)
	{
		$where = array('altercode'=>$altercode);
		$row = $this->Scheme_Model->select_row("tbl_whatsapp_email_fail",$where,'','');
		if($row->id=="")
		{
			$this->db->query("insert into tbl_whatsapp_email_fail set altercode='$altercode',mobile='$number',message='$message'");
		}
	}
	function send_email_for_password_create($name,$user_email_id,$altercode,$password)
	{
		$android_url = base_url()."android/".$altercode;
		
		$subject   = "Login Detail From D. R. Distributors Private Limited";
		$message = "Hello $name ($altercode),<br><br>Login Details for Your online ordering system and android application are as below.";
		$message .="<br><br>Username : $altercode <br>Password : $password";
		$message .="<br><br>On laptop or pc you can visit following link to start placing orders http://drdistributor.com/ <br><br>Please download our app from Google play store : <br><br><a href='$android_url'><img src='https://www.getmigo.com/coverage/us/tennessee/memphis/static/play-store-1cacd18258fc9c52bc3442564740d218.png' width='150px' height='50px'/></a>";
		
		if (filter_var($user_email_id, FILTER_VALIDATE_EMAIL)) {
		
		}
		else{
			$err = $user_email_id." is Wrong Email";
			$mobile = "";
			$this->Email_Model->tbl_whatsapp_email_fail($mobile,$err,$altercode);
			$user_email_id="";
		}
		if($user_email_id!="")
		{
			$subject = base64_encode($subject);
			$message = base64_encode($message);
			$email_function = "password";
			$mail_server = "";

			$dt = array(
			'user_email_id'=>$user_email_id,
			'subject'=>$subject,
			'message'=>$message,
			'email_function'=>$email_function,
			'mail_server'=>$mail_server,
			);
			$this->Scheme_Model->insert_fun("tbl_email_send",$dt);
		}
	}	

	function import_orders_delete_items($message,$altercode,$user_email_id,$date,$time)
	{	
		$android_url = base_url()."android/".$altercode;		
		$subject   = "Delete Items From D.R. Distributors Pvt. Ltd.";
		
		$message .="<br><br>Please download our new app from Google play store to order medicine <br><br><a href='$android_url'><img src='https://www.getmigo.com/coverage/us/tennessee/memphis/static/play-store-1cacd18258fc9c52bc3442564740d218.png' width='150px' height='50px'/></a>";

		if (filter_var($user_email_id, FILTER_VALIDATE_EMAIL)) {
		
		}
		else{
			$err = $user_email_id." is Wrong Email";
			$mobile = "";
			$this->Email_Model->tbl_whatsapp_email_fail($mobile,$err,$altercode);
			
			$user_email_id="";
		}
		
		if($user_email_id!="")
		{
			$file_name_1 = "Deleted-Items-Report.xls";
			$file_name1  = $this->Excel_Model->import_orders_delete_items($date,$time);
			
			$subject = base64_encode($subject);
			$message = base64_encode($message);
			$email_function = "import_orders_delete_items";
			$mail_server = "gmail";
			
			$dt = array(
			'user_email_id'=>$user_email_id,
			'subject'=>$subject,
			'message'=>$message,
			'email_function'=>$email_function,
			'file_name1'=>$file_name1,
			'file_name_1'=>$file_name_1,
			'mail_server'=>$mail_server,
			);
			$this->Scheme_Model->insert_fun("tbl_email_send",$dt);				
		}
	}

	
	
	
	public function test_email($email_function,$mail_server,$user_email_id)
	{
		//error_reporting(0);
		
		$this->load->library('phpmailer_lib');
		$email = $this->phpmailer_lib->load();
		
        $subject = $message = "test mail";
		if($mail_server=="")
		{
			$row = $this->db->query("select * from tbl_email where email_function='$email_function'")->row();
			
			$addreplyto 		= $row->addreplyto;
			$addreplyto_name 	= $row->addreplyto_name;
			$server_email 		= $row->server_email;
			$server_email_name 	= $row->server_email_name;
			$email1 			= $row->email;
			$email_bcc 			= $row->email_bcc;
			$live_or_demo 		= $row->live_or_demo;
			
			$email->AddReplyTo($addreplyto,$addreplyto_name);
			$email->SetFrom($server_email,$server_email_name);
			
			$email->Subject   	= $subject;
			$email->Body 		= $message;		
			if($live_or_demo=="Demo")
			{
				$email->AddAddress($email1);
				$email_bcc = explode (",", $email_bcc);
				foreach($email_bcc as $bcc)
				{
					$email->addBcc($bcc);
				}
			}
			else
			{
				$email->AddAddress($user_email_id);
				$email->addBcc($email1);
				$email_bcc = explode (",", $email_bcc);
				foreach($email_bcc as $bcc)
				{
					$email->addBcc($bcc);
				}
				$email_other_bcc = explode (",", $email_other_bcc); 				
				foreach($email_other_bcc as $email_other_bcc_ok)
				{
					$email->addBcc($email_other_bcc_ok->memail);
				}
			}
			
			$email->IsHTML(true);		
			if($email->Send()){
				echo "Mail Sent";
			}
			else{
				echo "Mail Failed";
			}
			echo "<br>".$email->ErrorInfo;
		}
		
		if($mail_server!="")
		{
			$row = $this->db->query("select * from tbl_email where email_function='$email_function'")->row();
			print_r($row);
				
			$email->CharSet 	= 'UTF-8';
			
			$addreplyto 		= $row->addreplyto;
			$addreplyto_name 	= $row->addreplyto_name;
			$server_email 		= $row->server_email;
			$server_email_name 	= $row->server_email_name;
			$email1 			= $row->email;
			$email_bcc 			= $row->email_bcc;
			$live_or_demo 		= $row->live_or_demo;
			
			$email->AddReplyTo($addreplyto,$addreplyto_name);
			$email->SetFrom($server_email,$server_email_name);
				
			$email->Subject   	= $subject;
			$email->Body 		= $message;
			
			if($live_or_demo=="Demo")
			{
				$email->AddAddress($email1);
				$count++;
				$email_bcc = explode (",", $email_bcc);
				foreach($email_bcc as $bcc)
				{
					$email->addBcc($bcc);
					$count++;
				}
			}
			else
			{
				$email->AddAddress($user_email_id);
				$count++;
				$email->addBcc($email1);
				$count++;
				if($email_bcc!="")
				{
					$email_bcc = explode (",", $email_bcc);
					foreach($email_bcc as $bcc)
					{
						$email->addBcc($bcc);
						$count++;
					}
				}
				if($email_other_bcc!="")
				{
					$email_other_bcc = explode (",", $email_other_bcc); 				
					foreach($email_other_bcc as $email_other_bcc_ok)
					{
						$email->addBcc($email_other_bcc_ok->memail);
						$count++;
					}
				}
			}
				
			$email->IsHTML(true);
				
			$row1 = $this->db->query("select * from tbl_gmail_username_password where mail_server='$mail_server' order by id desc")->row();
			if($mail_server=="gmail")
			{
				$email->IsSMTP();
				$email->SMTPAuth   = true; 
				$email->SMTPSecure = "ssl";  //tls
				$email->Host       = "smtp.googlemail.com";
				$email->Port       = 465; //you could use port 25, 587, 465 for googlemail
				echo $email->Username   = $row1->email;
				echo $email->Password   = $row1->password;
			}
			
			if($mail_server=="smtpcorp")
			{
				$email->IsSMTP();
				$email->SMTPAuth   = true; 
				$email->SMTPSecure = "tls";  //tls
				$email->Host       = "smtpcorp.com";
				$email->Port       = 2525; //you could use port 25, 587, 465 for googlemail
				echo $email->Username   = $row1->email;
				echo $email->Password   = $row1->password;
			}
			
			if($email->Send()){
				echo "Mail Sent";
			}
			else{
				echo "Mail Failed";
			}
			echo "<br>".$email->ErrorInfo;
		}
	}
	
	/*****************30-01-2020*******************/
	public function low_stock_alert_email($subject,$message)
	{
		//error_reporting(0);
		$subject = base64_encode($subject);
		$message = base64_encode($message);
		$email_function = "low_stock_alert";
		$mail_server = "gmail";
		
		$row = $this->db->query("select * from tbl_email where email_function='$email_function'")->row();
		$user_email_id = $row->email;

		$dt = array(
		'user_email_id'=>$user_email_id,
		'subject'=>$subject,
		'message'=>$message,
		'email_function'=>$email_function,
		'mail_server'=>$mail_server,
		);
		$this->Scheme_Model->insert_fun("tbl_email_send",$dt);
	}
}