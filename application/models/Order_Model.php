<?php
ini_set('memory_limit','-1');
ini_set('post_max_size','100M');
ini_set('upload_max_filesize','100M');
ini_set('max_execution_time',36000);
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."/third_party/PHPExcel.php";
class Order_Model extends CI_Model  
{
	/******* order part hear**********************/
	public function get_temp_rec($user_type='',$user_altercode='',$salesman_id='')
	{
		if($user_type=="sales")
		{
			$temp_rec = $user_type."_".$salesman_id."_".$user_altercode;
		}
		else
		{
			$temp_rec = $user_type."_".$user_altercode;
		}
		return $temp_rec;
	}

	public function my_cart_api($user_type="",$user_altercode="",$user_password="",$selesman_id="",$order_type="",$device_type="website")
	{
		$items = "";
		$other_items = "";

		$items_total = $items_price = 0;
		if($user_type=="sales")
		{
			if($order_type=="all"){
				$temp_rec = $this->get_temp_rec($user_type,$user_altercode,$selesman_id);
				$where = array('temp_rec'=>$temp_rec,'selesman_id'=>$selesman_id,'chemist_id'=>$user_altercode,'status'=>'0');
				$query = $this->Scheme_Model->select_all_result("drd_temp_rec",$where,'excel_number','asc');
			}else{
				$temp_rec = $this->get_temp_rec($user_type,$user_altercode,$selesman_id);
				$where = array('temp_rec'=>$temp_rec,'selesman_id'=>$selesman_id,'chemist_id'=>$user_altercode,'status'=>'0','order_type'=>$order_type);
				$query = $this->Scheme_Model->select_all_result("drd_temp_rec",$where,'excel_number','asc');
			}
		}
		else
		{
			$selesman_id 	= "";
			if($order_type=="all"){
				$temp_rec = $this->get_temp_rec($user_type,$user_altercode,$selesman_id);
				$where = array('temp_rec'=>$temp_rec,'chemist_id'=>$user_altercode,'status'=>'0');
				$query = $this->Scheme_Model->select_all_result("drd_temp_rec",$where,'excel_number','asc');
			}else {
				$temp_rec = $this->get_temp_rec($user_type,$user_altercode,$selesman_id);
				$where = array('temp_rec'=>$temp_rec,'chemist_id'=>$user_altercode,'status'=>'0','order_type'=>$order_type);
				$query = $this->Scheme_Model->select_all_result("drd_temp_rec",$where,'excel_number','asc');
			}
		}		
        foreach($query as $row)
		{
			$item_id			= $row->id;
			$item_code 			= $row->i_code;
			$item_quantity		= $row->quantity;
			$item_image			= $row->image;
			$item_name			= htmlentities(ucwords(strtolower($row->item_name)));
			$item_packing		= htmlentities($row->packing);
			$item_expiry		= htmlentities($row->expiry);
			$item_company		= htmlentities(ucwords(strtolower($row->company_full_name)));
			$item_scheme		= $row->scheme;
			
			$item_margin 		= round($row->margin);
			$item_featured 		= $row->featured;

			$item_price			= sprintf('%0.2f',round($row->sale_rate,2));
			$item_quantity_price= sprintf('%0.2f',round($item_price*$item_quantity,2));
			$item_datetime		= $row->datetime;
			$item_modalnumber	= htmlentities($row->modalnumber);
			
			$items_total++;
			$items_price 		= $items_price + $item_quantity_price;

$items.= <<<EOD
{"item_id":"{$item_id}","item_code":"{$item_code}","item_quantity":"{$item_quantity}","item_image":"{$item_image}","item_name":"{$item_name}","item_packing":"{$item_packing}","item_expiry":"{$item_expiry}","item_company":"{$item_company}","item_scheme":"{$item_scheme}","item_margin":"{$item_margin}","item_featured":"{$item_featured}","item_price":"{$item_price}","item_quantity_price":"{$item_quantity_price}","item_datetime":"{$item_datetime}","item_modalnumber":"{$item_modalnumber}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	//iss query say button visble or disble hota ha plceorder ka
	$place_order_btn = $this->Order_Model->get_total_price_of_order($selesman_id,$user_altercode,$user_type,$user_password,$device_type);
	$place_order_button  = $place_order_btn[0];
	$place_order_message = "<center>".$place_order_btn[1]."</center>";

	$items_price = sprintf('%0.2f',round($items_price,2));
$other_items=<<<EOD
{"user_altercode":"{$user_altercode}","items_total":"{$items_total}","items_price":"{$items_price}","place_order_button":"{$place_order_button}","place_order_message":"{$place_order_message}"}
EOD;
		$val[0] = $items;
		$val[1] = $other_items;
		$val[2] = $items_total;
		return $val;
	}

	public function salesman_my_cart_api($user_type="",$user_altercode="")
	{
		$items = "";
		$salesman_id 	= $user_altercode;
		$query = $this->db->query("select distinct chemist_id from drd_temp_rec where selesman_id='$salesman_id' and user_type='$user_type' and status='0' order by chemist_id asc")->result();
		foreach($query as $row)
		{	
			$chemist_id = $row->chemist_id;
			$row1 = $this->db->query("select count(id) as user_cart,sum(quantity*sale_rate) as user_cart_total from drd_temp_rec where user_type='$user_type' and selesman_id='$salesman_id' and chemist_id='$chemist_id' and status=0")->row();
			$user_cart = $user_cart_total = 0;
			if($row1->user_cart!=0)
			{
				$user_cart = $row1->user_cart;
				$user_cart_total = $row1->user_cart_total;
			}
			$user_cart_total = sprintf('%0.2f',round($user_cart_total,2));
			
			$row1 = $this->db->query("select tbl_acm.name,tbl_acm.altercode,tbl_acm_other.image from tbl_acm left JOIN tbl_acm_other on tbl_acm.code=tbl_acm_other.code where tbl_acm.altercode='$chemist_id'")->row();
			$chemist_name  		= htmlentities(ucwords(strtolower($row1->name)));		
			$chemist_altercode 	= $row1->altercode;

			$chemist_image = base_url()."img_v".constant('site_v')."/logo.png";
			if(!empty($row1->image))
			{
				$chemist_image = base_url()."user_profile/".$row1->image;
			}
			
$items.= <<<EOD
{"chemist_altercode":"{$chemist_altercode}","chemist_name":"{$chemist_name}","chemist_image":"{$chemist_image}","user_cart":"{$user_cart}","user_cart_total":"{$user_cart_total}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}        
		return $items;
	}
	
	public function tbl_order_id()
	{
		$q = $this->db->query("select order_id from tbl_order_id where id='1'")->row();
		$order_id = $q->order_id + 1;
		$this->db->query("update tbl_order_id set order_id='$order_id' where id='1'");
		return $order_id;
	}
	
	public function get_total_price_of_order($selesman_id='',$chemist_id='',$user_type='',$user_password='',$device_type="website")
	{
		$temp_rec = $this->get_temp_rec($user_type,$chemist_id,$selesman_id);
		if($user_type=="sales")
		{
			$this->db->where('selesman_id',$selesman_id);
		}
		$this->db->where('temp_rec',$temp_rec);
		$this->db->where('chemist_id',$chemist_id);
		$this->db->where('status','0');
		$this->db->order_by('id','desc');	
		$query = $this->db->get("drd_temp_rec")->result();
		$order_price = 0;
		foreach($query as $row)
		{
			$order_price = $order_price + ($row->quantity * $row->sale_rate);
		}

		$row = $this->db->query("select tbl_acm_other.password,tbl_acm_other.block,tbl_acm_other.status,tbl_acm_other.order_limit,tbl_acm_other.website_limit,tbl_acm_other.android_limit from tbl_acm left join tbl_acm_other on tbl_acm.code = tbl_acm_other.code where tbl_acm.altercode='$chemist_id' and tbl_acm.code=tbl_acm_other.code limit 1")->row();
		
		$user_order_limit = "5000";
		if($device_type=="website")
		{
			$user_order_limit = $row->website_limit;
		}
		if($device_type=="android")
		{
			$user_order_limit = $row->android_limit;
		}
			
		$order_limit[0] = 1; // ek honay par he place hoga order
		$order_limit[1] = "";
		if($user_type=="chemist")
		{
			$order_limit[1] = "<font color='red'>Minimum value to place order is of <i class='fa fa-inr'></i> ". number_format($user_order_limit)."/-</font>";
			$order_price      = round($order_price);
			$user_order_limit = round($user_order_limit);
			if($order_price<=$user_order_limit)
			{
				$order_limit[0] = 0;
			}
			/**jab user block yha inactive ho to */
			if($row->block=="1" || $row->status=="0")
			{
				$order_limit[0] = 0;
				$order_limit[1] = "<font color='red'>Can't Place Order due to technical issues.</font>";
			}		
			/**jab user ka password match na kray to */
			if($row->password!=$user_password)
			{
				$order_limit[0] = 0;
				$order_limit[1] = "<font color='red'>Can't Place Order, Please Re-Login with your New Password.</font>";
			}
		}
		
		return $order_limit;
	}
	
	public function save_order_to_server($order_type='',$slice_type='',$slice_item='',$remarks='',$selesman_id='',$chemist_id='',$user_type='',$user_password='',$latitude='',$longitude='',$mobilenumber='',$modalnumber='',$device_id='')
	{
		$status[0] = "0";
		$status[1] = "<font color='red'>Sorry your order has been failed please try again.</font>";
		$under_construction = $this->Scheme_Model->get_website_data("under_construction");
		if($under_construction=="1")
		{
			return $status;
		}
		
		$date = date('Y-m-d');
		$time = date("H:i",time());
		
		$place_order_btn[0] = 1;
		$temp_rec = $this->get_temp_rec($user_type,$chemist_id,$selesman_id);
		if($user_type=="chemist")
		{
			$place_order_btn = $this->get_total_price_of_order($user_type,$chemist_id,$user_password,$selesman_id);
		}
		if($place_order_btn[0]=="0")
		{
			return $status;
		}
		else
		{
			$order_id 	= $this->tbl_order_id();
			if($slice_type=="0")
			{
				$slice_type = "";
			}
			
			if($user_type=="sales")
			{
				$this->db->where('selesman_id',$selesman_id);
			}
			$this->db->where('temp_rec',$temp_rec);
			$this->db->where('chemist_id',$chemist_id);
			$this->db->where('status','0');
			$this->db->order_by('id','desc');	
			$query = $this->db->get("drd_temp_rec")->result();
			
			$remarks  = ($remarks);
			$join_temp = time()."_".$user_type."_".$chemist_id."_".$selesman_id;
			$i_code = $item_qty ="";
			foreach($query as $row)
			{
				$i_code		= $row->i_code;
				$item_qty	= $row->quantity;
				$quantity 	= $item_qty;
				$item_name 	=  $row->item_name;
				$sale_rate 	=  $row->sale_rate;
				$item_code 	=  $row->item_code; // its real id
				$item_image	=  $row->image;
				
				if(empty($item_code)){
					// yha delete kaarna ha code 22-04-12
					$where = array('i_code'=>$i_code);
					$tbl_medicine = $this->Scheme_Model->select_row("tbl_medicine",$where);
					$item_code = $tbl_medicine->item_code;
					/*************************************/
				}

				$total = $total + ($sale_rate * $quantity);
				
				$temp_rec_new = $order_id."_".$temp_rec;
				
				if($item_name!=""){
					$dt = array(
					'order_id'=>$order_id,
					'chemist_id'=>$chemist_id,
					'selesman_id'=>$selesman_id,
					'user_type'=>$user_type,
					'order_type'=>$order_type,
					'remarks'=>$remarks,
					'i_code'=>$i_code,
					'item_code'=>$item_code,
					'item_name'=>$item_name,
					'quantity'=>$quantity,
					'sale_rate'=>$sale_rate,
					'date'=>$date,
					'time'=>$time,
					'join_temp'=>$join_temp,
					'temp_rec'=>$temp_rec_new,
					'status'=>'1',
					'gstvno'=>'',
					'odt'=>'',
					'ordno_new'=>'',
					'latitude'=>$latitude,
					'longitude'=>$longitude,
					'mobilenumber'=>$mobilenumber,
					'modalnumber'=>$modalnumber,
					'device_id'=>$device_id,
					'image'=>$item_image,
					);
					$query = $this->Scheme_Model->insert_fun("tbl_order",$dt);	
				}
			}
			if($query)
			{
				$this->save_order_to_server_again($temp_rec_new,$order_id,$order_type);
				$this->db->query("update drd_temp_rec set status='1',order_id='$order_id' where temp_rec='$temp_rec' and status='0' and chemist_id='$chemist_id' and selesman_id='$selesman_id'");
				
				$status[1] = "<font color='#28a745'>Thanks for placing you order, your order has been placed successfully.<br>Your Order No. : ".$order_id."</font>".$this->Scheme_Model->get_website_data("place_order_message");
				$status[0] = "1";

				return $status;
			}
			else{
				return $status; // jab mobile say order kar diya or website par be place order karay to
			}
		}
	}
	
	public function save_order_to_server_again($temp_rec,$order_id,$order_type)
	{
		//error_reporting(0);
		$where = array('temp_rec'=>$temp_rec,'order_id'=>$order_id);
		$this->db->where($where);
		$query = $this->db->get("tbl_order")->result();
		$total_rs = $count_line = 0;
		foreach($query as $row)
		{
			$remarks 	= $row->remarks;
			$user_type 	= $row->user_type;
			$chemist_id = $row->chemist_id;
			$selesman_id= $row->selesman_id;
			$total_rs 	= ($row->sale_rate * $row->quantity) + $total_rs;
			$count_line++;
		}
		$total_rs = round($total_rs);
		if($user_type=="chemist")
		{			
			$where 			= array('altercode'=>$chemist_id);
			$users 			= $this->Scheme_Model->select_row("tbl_acm",$where);
			$acm_altercode 	= $users->altercode;
			$acm_name		= ucwords(strtolower($users->name));
			$acm_email 		= $users->email;
			$acm_mobile 	= $users->mobile;			
			
			$chemist_excle 	= "$acm_name ($acm_altercode)";
			$file_name 		= $acm_altercode;
		}
		if($user_type=="sales")
		{
			//jab sale man say login hota ha to
			$where 			= array('altercode'=>$chemist_id);
			$users 			= $this->Scheme_Model->select_row("tbl_acm",$where);
			$user_session	= $users->id;
			$acm_altercode 	= $users->altercode;
			$acm_name 		= ucwords(strtolower($users->name));
			$acm_email 		= $users->email;
			$acm_mobile 	= $users->mobile;
			
			$where = array('customer_code'=>$selesman_id);
			$users = $this->Scheme_Model->select_row("tbl_users",$where);
			$salesman_name 		= $users->firstname." ".$users->lastname;
			$salesman_mobile	= $users->cust_mobile;
			$salesman_altercode	= $users->customer_code;
			
			$chemist_excle 	= $acm_name." ($acm_altercode)";
			$file_name 		= $acm_altercode;
		}

		/*****************Excel file ke liya*****************************
		// yha code band kiya ha ku ki url diya ha file nahi bj rhay no need file ko download ka url bj rahy ha osi say sara kam ho raha ha	
		$file_name_1 = $this->Order_Model->excel_save_order_to_server($query,$chemist_excle,"cronjob_download");
		/****************************************************************/	
		
		/*****************whtsapp message*****************************/	
		if($user_type == "sales")
		{
			if($salesman_mobile!="")
			{
				$w_number 		= "+91".$salesman_mobile;//$c_cust_mobile;
				$w_altercode 	= $acm_altercode;
				$w_message 		= "New Order Placed - $order_id for $acm_name for amount $total_rs";
				$this->Message_Model->insert_whatsapp_message($w_number,$w_message,$w_altercode);
			}
		}
		
		$txt_msg = "";
		if($order_type=="Android")
		{
			$txt_msg = "Hello $acm_name ($acm_altercode)<br><br>Thank you for placing a new order using our DRD App. <br><br>Order No. : $order_id<br>Total Rs. : $total_rs/- <br>Remarks : $remarks<br><br>Download excel file <br><br>https://www.drdistributor.com/user/download_order/".$order_id."/".$acm_altercode."<br><br>You can also place orders from our website using normal desktops at your shop by going to www.drdistributor.com on your chrome browser.<br><br><b>D.R. Distributors Pvt. Ltd.</b>";
		}
		else
		{
			$txt_msg = "Hello $acm_name ($acm_altercode)<br><br>Thank you for placing a new order using our DRD website. <br><br>Order No. : $order_id<br>Total Rs. : $total_rs/- <br>Remarks : $remarks<br><br>Download excel file <br><br>https://www.drdistributor.com/user/download_order/".$order_id."/".$acm_altercode."<br><br>You can also place orders from our new mobile app. Download app from Google play store by clicking on link.<br>https://rb.gy/xo2qlk<br><br><b>D.R. Distributors Pvt. Ltd.</b>";
		}
		
			
		/*************27-11-19***********************/
		$q_altercode 	= $acm_altercode;
		$q_title 		= "New Order - $order_id";
		$q_message		= $txt_msg;
		$this->Message_Model->insert_android_notification("4",$q_title,$q_message,$q_altercode,"chemist");
		/************************************************/
		if(!empty($acm_mobile))
		{
			$w_number 		= "+91".$acm_mobile;
			$w_altercode 	= $acm_altercode;
			$w_message 		= $txt_msg;
			$this->Message_Model->insert_whatsapp_message($w_number,$w_message,$w_altercode);
		}
		else
		{
			$err = "Number not Available";
			$mobile = "";
			$this->Message_Model->tbl_whatsapp_email_fail($mobile,$err,$acm_altercode);
		}

		/***************only for group message***********************/
		$txt_msg1  = str_replace("Hello","",$txt_msg);
		$group2_message 	= "New order recieved from ".$txt_msg1;
		$whatsapp_group2 = $this->Scheme_Model->get_website_data("whatsapp_group2");
		$this->Message_Model->insert_whatsapp_group_message($whatsapp_group2,$group2_message);
		/*************************************************************/

		/******************group message******************************/
		$group1_message 	= "New Order Recieved from ".$txt_msg1."Please check in Easy Sol";
		$whatsapp_group1 = $this->Scheme_Model->get_website_data("whatsapp_group1");
		$this->Message_Model->insert_whatsapp_group_message($whatsapp_group1,$group1_message);
		/**********************************************************/
		
		$subject = "DRD Order || ($order_id) || $acm_name ($acm_altercode)";
		
		$message = "";
		if($user_type == "sales"){
			$message ="Salesman : ".$salesman_name." (".$salesman_altercode.")<br>";
		}		
		$message.=$txt_msg;
		
		$user_email_id = $acm_email;
		if (filter_var($user_email_id, FILTER_VALIDATE_EMAIL)) {
			//$user_email_id = "drdwebmail1@gmail.com";	
		}
		else{			
			$err = $user_email_id." is Wrong Email";
			$mobile = "";
			$this->Message_Model->tbl_whatsapp_email_fail($mobile,$err,$acm_altercode);
			$user_email_id = "drdwebmail1@gmail.com";			
		}
		if(!empty($user_email_id))
		{
			//$file_name1 = $order_id;
			$file_name_1 = $file_name1 = "";
			
			$subject = ($subject);
			$message = ($message);
			$email_function = "new_order";
			$mail_server = "";

			/************************************************/
			$row1 = $this->db->query("select * from tbl_email where email_function='$email_function'")->row();
			/***********************************************/
			$email_other_bcc = $row1->email;

			$date = date('Y-m-d');
			$time = date("H:i",time());

			$dt = array(
			'user_email_id'=>$user_email_id,
			'subject'=>$subject,
			'message'=>$message,
			'email_function'=>$email_function,
			'file_name1'=>$file_name1,
			'file_name_1'=>$file_name_1,
			'mail_server'=>$mail_server,
			'email_other_bcc'=>$email_other_bcc,
			'date'=>$date,
			'time'=>$time,
			);
			$this->Scheme_Model->insert_fun("tbl_email_send",$dt);				
		}
		
		return "1";
	}
	
	public function excel_save_order_to_server($query,$chemist_excle,$download_type)
	{
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		//error_reporting(0);
		ob_clean();		

		date_default_timezone_set('Asia/Calcutta');
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1','Code')
		->setCellValue('B1','Name')
		->setCellValue('C1','Quantity')
		->setCellValue('D1','PTR')
		->setCellValue('E1','Total')
		->setCellValue('F1','Chemist');		

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);	
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray(array('font' => array('size' => 10,'bold' => false,'color' => array('rgb' => '000000'),'name'  => 'Arial')));

		$i = 0;
		$rowCount = 2;
		foreach($query as $row)
		{
			$i++;
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,$row->item_code);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,$row->item_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,$row->quantity);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,$row->sale_rate);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,$row->sale_rate * $row->quantity);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,$chemist_excle);
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':F'.$rowCount)->applyFromArray(array('font' => array('size' => 8,'bold' => false,'color' => array('rgb' => '000000'),'name'  => 'Arial')));
			
			$file_name = $row->order_id;
			
			$rowCount++;
		}
		if($download_type=="direct_download")
		{
			$file_name = $file_name.".xls";
			
			//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
			/*$objWriter->save('uploads_sales/kapilkifile.xls');*/
			
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename='.$file_name);
			header('Cache-Control: max-age=0');
			ob_start();
			$objWriter->save('php://output');
			$data = ob_get_contents();
		}

		if($download_type=="cronjob_download")
		{
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
			$file_name = "temp_files/save_order_".time().".xls";
			$objWriter->save($file_name);

			return $file_name;
		}
	}
}