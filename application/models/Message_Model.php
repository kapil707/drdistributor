<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Message_Model extends CI_Model
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
	
	public function insert_whatsapp_message($mobile,$message,$altercode)
	{
		$date = date('Y-m-d');
		$time = date("H:i",time());

		$dt = array(
		'mobile'=>$mobile,
		'message'=>$message,
		'chemist_id'=>$altercode,
		'date'=>$date,
		'time'=>$time,
		);
		$this->Scheme_Model->insert_fun("tbl_whatsapp_message",$dt);
	}
	
	public function send_whatsapp_message()
	{		
		$whatsapp_key = $this->Scheme_Model->get_website_data("whatsapp_key");
		
		$this->db->limit(50);
		$this->db->where(array('status'=>'0'));
		$query = $this->db->get("tbl_whatsapp_message")->result();
		foreach($query as $row)
		{
			$id 			= $row->id;
			$mobile 		= $row->mobile;
			$media 			= $row->media;
			$message 		= ($row->message);
			$message 		= str_replace("<br>","\\n",$message);
			$message 		= str_replace("<b>","*",$message);
			$message 		= str_replace("</b>","*",$message);
			$chemist_id 	= $row->chemist_id;

			//$this->db->query("DELETE FROM `tbl_whatsapp_message` WHERE id='$mid'");
		
			if($media!="")
			{
				$parmiter = '{"phone": "'.$mobile.'","message": "'.$message.'","media": { "file": "'.$media.'" }}';
			}
			if($media=="")
			{
				$parmiter = "{\"phone\":\"$mobile\",\"message\":\"$message\"}";
			}

			$curl = curl_init();
			curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.wassi.chat/v1/messages",
			CURLOPT_RETURNTRANSFER=>true,
			CURLOPT_ENCODING =>"",
			CURLOPT_MAXREDIRS =>10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION =>CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS =>$parmiter,
			CURLOPT_HTTPHEADER =>array("content-type: application/json","token:$whatsapp_key"),));
			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);

			$response = htmlspecialchars($response);
			$response = str_replace("'","&#39;",$response);

			$this->db->query("update `tbl_whatsapp_message` set status=1, respose='$response' WHERE id='$id'");

			/*if ($err) {
				echo "cURL Error #:" . $err;
				$err = "Number stored is : $mobile";
				$this->Message_Model->tbl_whatsapp_email_fail($mobile,$err,$chemist_id);
			} else {
				//echo $response;
				$someArray = json_decode($response,true);
				if($someArray["status"]=="400"||$someArray["status"]=="401"||$someArray["status"]=="409"||$someArray["status"]=="500"||$someArray["status"]=="501"||$someArray["status"]=="503")
				{
					$err = "Number stored is : $mobile";
					$this->Message_Model->tbl_whatsapp_email_fail($mobile,$err,$chemist_id);
				}
			}*/
		}
	}
	
	public function insert_whatsapp_group_message($mobile,$message)
	{
		$date = date('Y-m-d');
		$time = date("H:i",time());

		$dt = array(
		'mobile'=>$mobile,
		'message'=>($message),
		'date'=>$date,
		'time'=>$time,
		);
		$this->Scheme_Model->insert_fun("tbl_whatsapp_group_message",$dt);
	}
	
	public function send_whatsapp_group_message()
	{
		$whatsapp_key = $this->Scheme_Model->get_website_data("whatsapp_key");
		
		$this->db->limit(50);
		$this->db->where(array('status'=>'0'));
		$query = $this->db->get("tbl_whatsapp_group_message")->result();
		foreach($query as $row)
		{
			$id 			= $row->id;
			$mobile 		= $row->mobile;
			$message 		= ($row->message);
			$message 		= str_replace("<br>","\\n",$message);
			$message 		= str_replace("<b>","*",$message);
			$message 		= str_replace("</b>","*",$message);
			
			$curl = curl_init();

			curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.wassi.chat/v1/messages",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{\"group\":\"$mobile\",\"priority\":\"high\",\"message\":\"$message\"}",
			CURLOPT_HTTPHEADER => array(
			"content-type: application/json","token:$whatsapp_key"),));

			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);

			$this->db->query("update `tbl_whatsapp_group_message` set status=1,respose='$response' WHERE id='$id'");

			/*if ($err) {
				echo "cURL Error #:" . $err;
				//$this->Email_Model->tbl_whatsapp_email_fail($number,$err,$altercode);
			} else {
				//echo $response;
				$someArray = json_decode($response,true);
				if($someArray["status"]=="400"||$someArray["status"]=="401"||$someArray["status"]=="409"||$someArray["status"]=="500"||$someArray["status"]=="501"||$someArray["status"]=="503")
				{
				}
			}*/
		}
	}
	
	public function insert_android_notification($funtype,$title,$message,$chemist_id,$user_type)
	{
		$date = date('Y-m-d');
		$time = date("H:i",time());
		
		$title 		= ($title);
		$message 	= ($message);
		
		$device_id =  "default"; // yha sirf website or android me show ke liya use hota ha
			
		$dt = array(
		'chemist_id'=>$chemist_id,
		'user_type'=>$user_type,
		'title'=>$title,
		'funtype'=>$funtype,
		'message'=>$message,
		'date'=>$date,
		'time'=>$time,
		'device_id'=>$device_id,);
		
		$this->Scheme_Model->insert_fun("tbl_android_notification",$dt);
	}
	
	function send_android_notification()
	{
		error_reporting(0);
		define('API_ACCESS_KEY', 'AAAAdZCD4YU:APA91bFjmo0O-bWCz2ESy0EuG9lz0gjqhAatkakhxJmxK1XdNGEusI5s_vy7v7wT5TeDsjcQH0ZVooDiDEtOU64oTLZpfXqA8EOmGoPBpOCgsZnIZkoOLVgErCQ68i5mGL9T6jnzF7lO');
		
		$time = time();
		$date = date("Y-m-d",$time);
		
		$where = array('firebase_status'=>'0','device_id'=>'default','date'=>$date);
		$this->db->where($where);
		$this->db->order_by('id','desc');
		$query = $this->db->get("tbl_android_notification")->result();
		foreach($query as $row)
		{
			$id 		= $row->id;
			$user_type 	= $row->user_type;
			$chemist_id = $row->chemist_id;
			$title 		= ($row->title);
			$message    = ($row->message);
			//$message    = htmlentities(str_replace("\n","<br>",$message));

			$funtype 	= $row->funtype;
			$itemid 	= $row->itemid;
			$division 	= $row->division;
			$image1		= $row->image;
			if($funtype=="2")
			{
				$itemid = $row->compid;
				$row1   =  $this->db->query("select company_full_name from tbl_medicine where compcode='$itemid'")->row();
				$company_full_name = base64_decode($row1->company_full_name);
				
				$row1  =  $this->db->query("select image from tbl_featured_brand where compcode='$itemid'")->row();
				if($row1->image!=""){
					//$image =   base_url()."uploads/manage_featured_brand/photo/resize/".$row1->image;
					
					// jab tak old server on ha to iss code say img aya ge notication m
					$image =   constant('main_site')."uploads/manage_featured_brand/photo/resize/".$row1->image;
				}
				else{
					$image = constant('main_site')."uploads/manage_users/photo/photo_1562659909.png";
				}
			}
			
			if($image1!="")
			{
				$image =   constant('main_site')."uploads/manage_notification/photo/resize/".$image1;
				
				// jab tak old server on ha to iss code say img aya ge notication m
				$image =   constant('main_site')."uploads/manage_notification/photo/resize/".$image1;
			}
			
			if($image=="")
			{
				$image = "not";
			}

			if($company_full_name=="")
			{
				$company_full_name = "not";
			}

			if($itemid=="")
			{
				$itemid = "not";
			}

			if($division=="")
			{
				$division = "not";
			}
						
			$query1 = $this->db->query("select firebase_token from tbl_android_device_id where chemist_id='$chemist_id' and user_type='$user_type'")->result();
			foreach($query1 as $row1)
			{
				$token = $row1->firebase_token;
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
				//print_r($data);
					
				$fields = array
				(
					'to'=>$token,
					'data'=>$data,
					"priority"=>"high",
				);

				$headers = array
				(
					'Authorization: key=' . API_ACCESS_KEY,
					'Content-Type: application/json'
				);
				#Send Reponse To FireBase Server	
				$ch = curl_init();
				curl_setopt($ch,CURLOPT_URL,'https://fcm.googleapis.com/fcm/send');
				curl_setopt($ch,CURLOPT_POST,true);
				curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
				curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
				curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
				curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($fields));
				$respose = curl_exec($ch);
				//echo $respose;
				curl_close($ch);
			
				$this->db->query("update tbl_android_notification set firebase_status='1',respose='$respose' where firebase_status='0' and id='$id'");
			}
		}
	}
	
	public function send_email_message()
	{
		//error_reporting(0);
		$this->db->limit(1);
		$this->db->where(array('status'=>'0'));
		$this->db->order_by('id','desc');
		$query = $this->db->get("tbl_email_send")->result();
		
		$this->load->library('phpmailer_lib');
		$email = $this->phpmailer_lib->load();
			
		foreach($query as $row)
		{
			/************************************************/
			$id 			= $row->id;
			$user_email_id 	= $row->user_email_id;
			$subject 		= ($row->subject);
			$message 		= ($row->message);
			$email_function = $row->email_function;
			$file_name1 	= $row->file_name1;
			$file_name2 	= $row->file_name2;
			$file_name3 	= $row->file_name3;
			$file_name_1 	= $row->file_name_1;
			$file_name_2 	= $row->file_name_2;
			$file_name_3 	= $row->file_name_3;
			$mail_server 	= $row->mail_server;
			$email_other_bcc= $row->email_other_bcc;
			if($row->email_other_bcc=="")
			{
				$email_other_bcc="";
			}
			
			/************************************************/
			
			/************************************************/
			$this->db->where('email_function',$email_function);
			$row1 = $this->db->get("tbl_email")->row();
			
			$addreplyto 		= $row1->addreplyto;
			$addreplyto_name 	= $row1->addreplyto_name;
			$server_email 		= $row1->server_email;
			$server_email_name 	= $row1->server_email_name;
			$email1 			= $row1->email;
			$email_bcc 			= $row1->email_bcc;
			$live_or_demo 		= $row1->live_or_demo;
			
			$email->AddReplyTo($addreplyto,$addreplyto_name);
			$email->SetFrom($server_email,$server_email_name);
			/************************************************/
			
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
					$email->addBcc($email_other_bcc_ok);
				}
			}
			if($file_name1)
			{
				if($file_name_1)
				{
					$email->addAttachment($file_name1,$file_name_1);
				}
				else
				{
					$email->addAttachment($file_name1);
				}
			}
			if($file_name2)
			{
				if($file_name_2)
				{
					$email->addAttachment($file_name2,$file_name_2);
				}
				else
				{
					$email->addAttachment($file_name2);
				}
			}
			if($file_name3)
			{
				if($file_name_3)
				{
					$email->addAttachment($file_name3,$file_name_3);
				}
				else
				{
					$email->addAttachment($file_name3);
				}
			}
			
			/************************************************/
			//$this->db->query("delete from tbl_email_send where id='$id'");
			/************************************************/

			$this->db->query("update tbl_email_send set status='1' where id='$id'");
			
			$email->IsHTML(true);		
			if($email->Send()){
				echo "Mail Sent";
			}
			else{
				echo "Mail Failed";
			}
			/*if($file_name1)
			{
				unlink($file_name1);
			}
			if($file_name2)
			{
				unlink($file_name2);
			}
			if($file_name3)
			{
				unlink($file_name3);
			}*/
		}
	}
}