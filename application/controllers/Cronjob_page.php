<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '-1');
ini_set('post_max_size', '100M');
ini_set('upload_max_filesize', '100M');
ini_set('max_execution_time', 36000);
require_once APPPATH."/third_party/PHPExcel.php";
class Cronjob_page extends CI_Controller 
{
	public function test_email()
	{
		// Load PHPMailer library
		$this->load->library('phpmailer_lib');

		// PHPMailer object
		$mail = $this->phpmailer_lib->load();

		// SMTP configuration
		$mail->isSMTP();
		$mail->Host     = 'smtp.rediffmailpro.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'vipul@drdistributors.co.in';
		$mail->Password = 'DRD#123';
		$mail->SMTPSecure = 'ssl';
		$mail->Port     = 110;

		$mail->setFrom('vipul@drdistributors.co.in', 'CodexWorld');
		$mail->addReplyTo('vipul@drdistributors.co.in', 'CodexWorld');

		// Add a recipient
		$mail->addAddress('kapil707sharma@gmail.com');

		// Add cc or bcc 
		$mail->addCC('kapil707sharma@gmail.com');
		$mail->addBCC('kapil707sharma@gmail.com');

		// Email subject
		$mail->Subject = 'Send Email via SMTP using PHPMailer in CodeIgniter';

		// Set email format to HTML
		$mail->isHTML(true);

		// Email body content
		$mailContent = "<h1>Send HTML Email using SMTP in CodeIgniter</h1>
			<p>This is a test email sending using SMTP mail server with PHPMailer.</p>";
		$mail->Body = $mailContent;

		// Send email
		if(!$mail->send()){
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		}else{
			echo 'Message has been sent';
		}

		 /*
		$this->load->library('phpmailer_lib');
		$email = $this->phpmailer_lib->load();
		
		$subject = "drd local test";
		$message = "drd local test";
		
		$addreplyto 		= "vipul@drdistributors.co.in";
		$addreplyto_name 	= "Vipul DRD";
		$server_email 		= "vipul@drdistributors.co.in";
		$server_email_name 	= "vipul@drdistributors.co.in";
		$email1 			= "kapil707sharma@gmail.com";
		
		$email->AddReplyTo($addreplyto,$addreplyto_name);
		$email->SetFrom($server_email,$server_email_name);
		$email->AddAddress($email1);
		
		$email->Subject   	= $subject;
		$email->Body 		= $message;		
		
		$email->IsHTML(true);	
		
		$email->IsSMTP();
		$email->SMTPAuth   = true; 
		//$email->SMTPSecure = "tls";  //tls
		$email->Host       = "smtp.rediffmailpro.com";
		$email->Port       = 587;
		$email->Username   = "vipul@drdistributors.co.in";
		$email->Password   = "DRD#123";

		/*$email->IsSMTP();
		$email->SMTPAuth   = true; 
		$email->SMTPSecure = "tls";  //tls
		$email->Host       = "smtpcorp.com";
		$email->Port       = 2525;
		$email->Username   = "send@drdindia.com";
		$email->Password   = "DRD#123"; */
		
		/*
		if($email->send()){
            echo 'Message has been sent';
        }else{
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $email->ErrorInfo;
        }*/
	}

	public function Myexcle_export_for3_party()
	{
		//error_reporting(0);
		$delimiter = ",";
		$fp = fopen('chemist/uploads_sales/item_list.csv', 'w');
		$fields = array('Company_Name','DIVISION','Item_Code','Item_Name','Packing','Expiry','BatchNo','SaleRate','MRP','SaleScm1','SaleScm2','BATCHQTY','GSTPER','Item_Date','Date','Time');
		fputcsv($fp, $fields, $delimiter);
		$query = $this->db->get("tbl_medicine")->result();
		foreach($query as $row)
		{
			$dt = date("d-M-Y");
			$tt = date("H:i:s");
			$item_date = date("d-M-Y", strtotime($row->item_date));
			$lineData = array("$row->company_name","$row->division","$row->item_code","$row->item_name","$row->packing","$row->expiry","$row->batch_no","$row->sale_rate","$row->mrp","$row->salescm1","$row->salescm2","$row->batchqty","$row->gstper","$item_date","$dt","$tt");
			fputcsv($fp, $lineData, $delimiter);
		}
		fclose($fp);
		echo "ok";
	}
	
	public function all_message_send_by()
	{
		$this->Message_Model->send_whatsapp_message();
		$this->Message_Model->send_whatsapp_group_message();
		$this->Message_Model->send_email_message();		
		$this->Message_Model->send_android_notification();
	}

	public function chkinvdel()
	{
		$time  = time();
		$vdt15 = date("Y-m-d", strtotime("-15 days", $time));

		$q = $this->db->query("SELECT * FROM `tbl_invoice2` WHERE `date`<'$vdt15'")->result();
		foreach($q as $row)
		{
			$id 		= $row->id;
			$gstvno 	= $row->gstvno;
			echo $files = base_url()."/upload_invoice/".$gstvno.".xls";
			echo "<br>";
			$files 		= $_SERVER['DOCUMENT_ROOT']."/upload_invoice/".$gstvno.".xls";
			$files1 	= $_SERVER['DOCUMENT_ROOT']."/upload_invoice/delete_".$gstvno.".xls";
			unlink($files);

			$files2 	= "./upload_invoice/delete_".$gstvno.".xls";
			if(file_exists($files2)=="1")
			{
				unlink($files1);
			}
		}
	}
	
	/********delete one month old sales************************/
	public function delete_one_old_rec()
	{
		$time  = time();
		$vdt   = date("Y-m-d",$time);
		$day1  = date("Y-m-d", strtotime("-1 days", $time));
		$day7  = date("Y-m-d", strtotime("-7 days", $time));
		$vdt30 = date("Y-m-d", strtotime("-30 days", $time));
		$vdt45 = date("Y-m-d", strtotime("-45 days", $time));
		$vdt60 = date("Y-m-d", strtotime("-60 days", $time));

		$this->db->query("update tbl_staffdetail_other set daily_date='$vdt',download_status='1' where daily_date='$day1'"); 

		//$this->db->query("DELETE FROM `tbl_email_send` WHERE date<='$day7'");
		$this->db->query("DELETE FROM `tbl_whatsapp_message` WHERE date<='$day7'");
		$this->db->query("DELETE FROM `tbl_whatsapp_group_message` WHERE date<='$day7'");
		
		$this->db->query("DELETE FROM `tbl_order` WHERE date<='$vdt45'");
		$this->db->query("DELETE FROM `drd_temp_rec` WHERE date<='$vdt60' and status='1'");
		$this->db->query("DELETE FROM `tbl_android_notification` WHERE date<='$vdt60'");		
		$this->db->query("DELETE FROM `tbl_deliverby` WHERE vdt<='$vdt'");		
		$this->db->query("DELETE FROM `tbl_low_stock_alert` WHERE date<='$vdt30'");
		$this->db->query("DELETE FROM `tbl_delete_import` WHERE date<='$vdt60'");
		$this->db->query("DELETE FROM `tbl_android_device_id` WHERE date<='$vdt60'");
		$result = $this->db->query("SELECT * FROM `tbl_invoice` WHERE `date`<'$vdt60'")->result();
		foreach($result as $row)
		{
			$id 		= $row->id;
			$gstvno 	= $row->gstvno;
			$files 		= $_SERVER['DOCUMENT_ROOT']."/upload_invoice/".$gstvno.".xls";
			$files1 	= $_SERVER['DOCUMENT_ROOT']."/upload_invoice/delete_".$gstvno.".xls";
			unlink($files);

			$files2 	= "./upload_invoice/delete_".$gstvno.".xls";
			if(file_exists($files2)=="1")
			{
				unlink($files1);
			}
			$this->db->query("DELETE FROM `tbl_invoice` WHERE id='$id'");
		}

		$result = $this->db->query("select * from tbl_staffdetail_other")->result();
		foreach($result as $row)
		{
			$row1 = $this->db->query("select * from tbl_staffdetail where code='$row->code'")->row();
			if(empty($row1->id))
			{
				$code = $row->code;
				$this->db->query("delete from tbl_staffdetail_other where code='$code'");
			}
		}

		$result = $this->db->query("SELECT * FROM `tbl_email_send`  WHERE `date`<'$day7'")->result();
		foreach($result as $row)
		{
			$id = $row->id;
			$file_name1 = $row->file_name1;
			if($file_name1)
			{
				unlink($file_name1);
			}
			$file_name2 = $row->file_name2;
			if($file_name2)
			{
				unlink($file_name2);
			}
			$file_name3 = $row->file_name3;
			if($file_name3)
			{
				unlink($file_name3);
			}
			$this->db->query("DELETE FROM `tbl_email_send` WHERE id='$id'");
		}
	}

	public function report_send_by_admin()
	{
		$massage = "Report:-".date('d-M h:i A');
		
		$massage1 = "\\n";		
		$massage1.= "\\n **************Main part**************";
		
		$result = $this->db->query("select count(id) as total from tbl_medicine")->row();
		$massage1.= "\\nTotal medicine :- ".$result->total;
		
		$result = $this->db->query("select count(id) as total from tbl_acm where slcd='CL'")->row();
		$massage1.= "\\nTotal chemist :- ".$result->total;
		
		$result = $this->db->query("select count(id) as total from tbl_users")->row();
		$massage1.= "\\nTotal salesman :- ".$result->total;
		
		$result = $this->db->query("select count(id) as total from tbl_staffdetail")->row();
		$massage1.= "\\nTotal  corporate :- ".$result->total;
		
		$result = $this->db->query("select count(id) as total from tbl_master where slcd='SM' and altercode!=''")->row();
		$massage1.= "\\nTotal master :- ".$result->total;
		
		/************************************************/
		
		$date = date("Y-m-d");
		
		$this->db->select('amt');
		$this->db->where('date',$date);
		$query = $this->db->get("tbl_invoice")->result();
		$today_invoice = 0;
		foreach($query as $row)
		{
			$today_invoice++;
			$today_total_sales = $today_total_sales + round($row->amt);
			$today_total_taxamt = $today_total_taxamt + round($row->taxamt);
		}
		
		setlocale(LC_MONETARY, 'en_IN');
		$today_total_sales = money_format('%!i', $today_total_sales - $today_total_taxamt);
		
		$today_total_sales = substr($today_total_sales, 0, -3);
		
		$massage2 = "\\n";
		$massage2.= "\\n **************Sales part**************";
		$massage2.= "\\nTotal invoice :- ".$today_invoice;
		$massage2.= "\\nTotal sale :- ".$today_total_sales;
		
		/***************************************************/
		
		$result = $this->db->query("select count(DISTINCT order_id) as total from tbl_order where date='$date'")->row();
		$today_orders1 = $result->total;
		
		$result = $this->db->query("select count(DISTINCT order_id) as total from tbl_order where download_status='0'")->row();
		$today_orders2 = $result->total;

		$result = $this->db->query("select sum(quantity*sale_rate) as total from tbl_order where download_status='0'")->row();
		$today_orders2_val = $result->total;

		setlocale(LC_MONETARY, 'en_IN');
		$today_orders2_val = money_format('%!i', $today_orders2_val);
		$today_orders2_val = substr($today_orders2_val, 0, -3);
		
		$massage3 = "\\n";
		$massage3.= "\\n **************Order part**************";
		$massage3.= "\\nPending order :- ".$today_orders2;	
		$massage3.= "\\nPending order value :- ".$today_orders2_val;
		$massage3.= "\\n";	
		$massage3.= "\\nToday total order :- ".$today_orders1;
		
		$result = $this->db->query("select count(DISTINCT chemist_id) as total from tbl_order where date='$date' ")->row();
		$massage3.= "\\nUnique orders :- ".$result->total;
		
		$result = $this->db->query("select count(DISTINCT order_id) as total from tbl_order where date='$date' and order_type='pc_mobile'")->row();
		$massage3.= "\\nTotal website orders :- ".$result->total;
		
		$result = $this->db->query("select count(DISTINCT order_id) as total from tbl_order where date='$date' and order_type='android'")->row();
		$massage3.= "\\nTotal android orders :- ".$result->total;
		
		$this->db->select('quantity,sale_rate');
		$this->db->where('date',$date);
		$query = $this->db->get("tbl_order")->result();
		$today_orders_items = 0;
		foreach($query as $row)
		{
			$today_orders_price = $today_orders_price + ($row->quantity * $row->sale_rate);
			$today_orders_items++;
		}
		setlocale(LC_MONETARY, 'en_IN');
		$today_orders_price = money_format('%!i', $today_orders_price);
		$today_orders_price = substr($today_orders_price, 0, -3);
		
		$massage3.= "\\nTotal order value :- ".$today_orders_price;
		$massage3.= "\\nTotal order item :- ".$today_orders_items;

		/***************only for group message***********************/
		$group2_message 	= $massage.$massage1.$massage2.$massage3;
		$whatsapp_group2 = $this->Scheme_Model->get_website_data("whatsapp_group2");
		$this->Message_Model->insert_whatsapp_group_message($whatsapp_group2,$group2_message);
		/*************************************************************/
	}

	public function send_member_notification(){
		
		//error_reporting(0);
		define('API_ACCESS_KEY', 'AAAAdZCD4YU:APA91bFjmo0O-bWCz2ESy0EuG9lz0gjqhAatkakhxJmxK1XdNGEusI5s_vy7v7wT5TeDsjcQH0ZVooDiDEtOU64oTLZpfXqA8EOmGoPBpOCgsZnIZkoOLVgErCQ68i5mGL9T6jnzF7lO');
		
		//$this->db->select('firebase_token');
		$query = $this->db->query("SELECT firebase_token FROM `tbl_master_other` WHERE `firebase_token`!=''")->result();
		foreach($query as $row)
		{
			$firebase_token = $row->firebase_token;

			$id = "1";
			$title = "Hello";
			$message = "Hello";
			$funtype = "100";
			$division = "";
			$company_full_name = "";
			$image = "";
			$itemid = "";
			
			$token = $firebase_token;
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

	public function check_duplicate_records()
	{
		$massage = "Report:-".date('d-M h:i A');

		$massage.= "\\n*Medicine duplicate records*";

		$i = 0;
		$result = $this->db->query("SELECT item_name,item_code,i_code FROM tbl_medicine group by item_code having count(*)>=2")->result();
		foreach($result as $row)
		{
			$i++;
			$massage.= "\\n$i :- ".$row->item_name." code(".$row->item_code.") -- id(".$row->i_code.")";
		}


		$massage1 = "\\n\\n*Medicine not added item code*";

		$i = 0;
		$result = $this->db->query("SELECT item_name,item_code,i_code FROM tbl_medicine where item_code=''")->result();
		foreach($result as $row)
		{
			$i++;
			$massage1.= "\\n$i :- ".$row->item_name." code(".$row->item_code.") -- id(".$row->i_code.")";
		}

		/***************only for group message***********************/
		$group2_message 	= $massage.$massage1;
		$whatsapp_group2 = $this->Scheme_Model->get_website_data("whatsapp_group2");
		$this->Message_Model->insert_whatsapp_group_message($whatsapp_group2,$group2_message);
		/*************************************************************/
	}

	public function cronjob_featured_brand_json_new()
	{
		$result0 = $this->Chemist_Model->featured_brand_json_new();
		file_put_contents("json_api/featured_brand_json_new.json", $result0);
	}

	public function cronjob_new_medicine_this_month_json_new()
	{
		$result0 = $this->Chemist_Model->new_medicine_this_month_json_new();
		file_put_contents("json_api/new_medicine_this_month_json_new.json", $result0);
	}

	public function cronjob_hot_selling_today_json_new()
	{
		$result0 = $this->Chemist_Model->hot_selling_today_json_new();
		file_put_contents("json_api/hot_selling_today_json_new.json", $result0);
	}

	public function cronjob_must_buy_medicines_json_new()
	{
		$result0 = $this->Chemist_Model->must_buy_medicines_json_new();
		file_put_contents("json_api/must_buy_medicines_json_new.json", $result0);
	}

	public function cronjob_frequently_use_medicines_json_new()
	{
		$result0 = $this->Chemist_Model->frequently_use_medicines_json_new();
		file_put_contents("json_api/frequently_use_medicines_json_new.json", $result0);
	}

	public function cronjob_stock_now_available()
	{
		$result0 = $this->Chemist_Model->stock_now_available();
		file_put_contents("json_api/stock_now_available.json", $result0);
	}
}