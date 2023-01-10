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
		$this->load->library('phpmailer_lib');
		$email = $this->phpmailer_lib->load();
		
		$subject = "drd local test";
		$message = "drd local test";
		
		$addreplyto 		= "vipul@drdindia.com";
		$addreplyto_name 	= "Vipul DRD";
		$server_email 		= "kapil707sharma@gmail.com";
		$server_email_name 	= "kapil";
		$email1 			= "kapil707sharma@gmail.com";
		$email_bcc 			= "kapil7071@gmail.com";
		
		$email->AddReplyTo($addreplyto,$addreplyto_name);
		$email->SetFrom($server_email,$server_email_name);
		$email->AddAddress($email1);
		
		$email->Subject   	= $subject;
		$email->Body 		= $message;		
		
		$email->IsHTML(true);	

		$email->IsSMTP();
		$email->SMTPAuth   = true; 
		$email->SMTPSecure = "tls";  //tls
		$email->Host       = "smtpcorp.com";
		$email->Port       = 2525;
		$email->Username   = "send@drdindia.com";
		$email->Password   = "DRD#123";
		
		if($email->Send()){
			echo "Mail Sent";
		}
		else{
			echo "error";
		}
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
		$this->Message_Model->send_android_notification();
		$this->Message_Model->send_email_message();
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
			echo $files 		= base_url()."/upload_invoice/".$gstvno.".xls";
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
	
	/****************delete one month old sales************************/
	public function delete_one_month_sales()
	{
		$time  = time();
		$vdt   = date("Y-m-d",$time);
		$day1  = date("Y-m-d", strtotime("-1 days", $time));
		$day15 = date("Y-m-d", strtotime("-15 days", $time));
		$vdt30 = date("Y-m-d", strtotime("-30 days", $time));
		$vdt45 = date("Y-m-d", strtotime("-45 days", $time));
		$vdt60 = date("Y-m-d", strtotime("-60 days", $time));
		
		$this->db->query("DELETE FROM `tbl_order` WHERE date<='$vdt45'");
		$this->db->query("DELETE FROM `tbl_android_notification` WHERE date<='$vdt60'");		
		$this->db->query("DELETE FROM `tbl_deliverby` WHERE vdt<='$vdt'");		
		$this->db->query("DELETE FROM `tbl_low_stock_alert` WHERE date<='$vdt60'");
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
	}
	
	public function report_send_by_admin()
	{
		$massage = "Report:-".date('d-M h:i A');
		
		$massage1 = "\\n";		
		$massage1.= "\\nMain Part";
		
		$result = $this->db->query("select count(id) as total from tbl_medicine")->row();
		$massage1.= "\\nTotal Medicine:->".$result->total;
		
		$result = $this->db->query("select count(id) as total from tbl_acm where slcd='CL'")->row();
		$massage1.= "\\nTotal Chemist:->".$result->total;
		
		$result = $this->db->query("select count(id) as total from tbl_users")->row();
		$massage1.= "\\nTotal Salesman:->".$result->total;
		
		$result = $this->db->query("select count(id) as total from tbl_staffdetail")->row();
		$massage1.= "\\nTotal Corporate:->".$result->total;
		
		$result = $this->db->query("select count(id) as total from tbl_master where slcd='SM' and altercode!=''")->row();
		$massage1.= "\\nTotal Master:->".$result->total;
		
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
		$massage2.= "\\nSales Part";
		$massage2.= "\\nTotal Invoice:->".$today_invoice;
		$massage2.= "\\nTotal Sale:->".$today_total_sales;
		
		/***************************************************/
		
		$result = $this->db->query("select count(DISTINCT order_id) as total from tbl_order where date='$date'")->row();
		$today_orders1 = $result->total;
		
		$result = $this->db->query("select count(DISTINCT order_id) as total from tbl_order where download_status='0'")->row();
		$today_orders2 = $result->total;
		
		$massage3 = "\\n";
		$massage3.= "\\nOrder Part";
		$massage3.= "\\nPending Order:->".$today_orders2;		
		$massage3.= "\\nTotal Order:->".$today_orders1;
		
		$result = $this->db->query("select count(DISTINCT chemist_id) as total from tbl_order where date='$date' ")->row();
		$massage3.= "\\nUnique Orders:->".$result->total;
		
		$result = $this->db->query("select count(DISTINCT order_id) as total from tbl_order where date='$date' and order_type='pc_mobile'")->row();
		$massage3.= "\\nTotal Website Orders:->".$result->total;
		
		$result = $this->db->query("select count(DISTINCT order_id) as total from tbl_order where date='$date' and order_type='android'")->row();
		$massage3.= "\\nTotal Android Orders:->".$result->total;
		
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
		
		$massage3.= "\\nTotal Order Value:->".$today_orders_price;
		$massage3.= "\\nTotal Order Item:->".$today_orders_items;

		/***************only for group message***********************/
		$group2_message 	= $massage.$massage1.$massage2.$massage3;
		$whatsapp_group2 = $this->Scheme_Model->get_website_data("whatsapp_group2");
		$this->Message_Model->insert_whatsapp_group_message($whatsapp_group2,$group2_message);
		/*************************************************************/
	}
}