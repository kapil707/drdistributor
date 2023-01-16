<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit','-1');
ini_set('post_max_size','500M');
ini_set('upload_max_filesize','500M');
ini_set('max_execution_time',36000);
class Exe01 extends CI_Controller {
	function new_clean($string) {
		$k= str_replace('\n', '<br>', $string);
		$k= preg_replace('/[^A-Za-z0-9\#]/', ' ', $k);
		return $k;
		//return preg_replace('/[^A-Za-z0-9\#]/', '', $string); // Removes special chars.
	}	

	function download_order()
	{
		//error_reporting(0);
		$items = "";
		$q = $this->db->query("select temp_rec from tbl_order where download_status='0' order by id asc limit 1")->row();			
		if(!empty($q->temp_rec))
		{
			$total_line_row = $this->db->query("select count(temp_rec) as total from tbl_order where temp_rec='$q->temp_rec'")->row();
			$total_line = $total_line_row->total;
			$new_temp_rec = time(); // yha temp rec nichay drd database ne temp rec banta ha
			$where = array('temp_rec'=>$q->temp_rec,'download_status'=>'0',);
			$result = $this->Scheme_Model->select_all_result("tbl_order",$where);
			foreach($result as $row)
			{
				$where1 = array('i_code'=>$row->i_code);
				$tbl_medicine = $this->Scheme_Model->select_row("tbl_medicine",$where1);
				$item_code = $tbl_medicine->item_code;

				$order_status = 0;
				//$time = date("h:i a", ($row->time));

				$remarks = $this->new_clean(htmlentities($row->remarks));
				$gstvno = "";
				$time = $row->time;

$items .= "('$row->id','$row->order_id','$item_code','$row->quantity','$row->chemist_id','$row->user_type','$row->chemist_id','$row->temp_rec','$remarks','$row->sale_rate','$order_status','$row->date','$time','$gstvno',$new_temp_rec,$total_line),";
			}
if ($items != '') {
$items = substr($items, 0, -1);
}
			}
		if($items!="")
		{
?>
INSERT INTO tbl_order (online_id,order_id,item_code,quantity,chemist_id,user_type,salesman_id,temp_rec,remarks,sale_rate,order_status,date,time,gstvno,new_temp_rec,total_line) VALUES <?= $items;?>;<?= $row->order_id ?>
		<?php
		}		
	}
	public function upload_order_status_in_server($order_id='')
	{
		//error_reporting(0);
		if($order_id!='')
		{
			$this->db->query("update tbl_order set download_status='1' where order_id='$order_id'");
			echo "$order_id";

			/***************only for group message***********************
			$group2_message 	= "This Order No. *$order_id* downloaded properly.";
			$whatsapp_group2 = $this->Scheme_Model->get_website_data("whatsapp_group2");
			$this->Message_Model->insert_whatsapp_group_message($whatsapp_group2,$group2_message);
			/*************************************************************/
		}
	}

	public function upload_order_gstvno($order_id='',$gstvno='')
	{
		$this->db->query("update tbl_order set gstvno='$gstvno' where order_id='$order_id'");
	}

	public function download_order_reset($order_id='')
	{
		//error_reporting(0);
		if($order_id!="")
		{		
			/***************only for group message***********************/
			$group2_message 	= "This Order No. *$order_id* was not downloaded properly. After few seconds order redownload automatically.";
			$whatsapp_group2 = $this->Scheme_Model->get_website_data("whatsapp_group2");
			$this->Message_Model->insert_whatsapp_group_message($whatsapp_group2,$group2_message);
			/*************************************************************/
			
			$x = $this->db->query("update tbl_order set download_status='0' where order_id='$order_id'");
			if($x)
			{
				echo "ok";
			}
		}
	}

	public function download_order_reset2($order_id='')
	{
		//error_reporting(0);
		if($order_id!="")
		{		
			/***************only for group message***********************/
			$group2_message 	= "This Order No. *$order_id* some problem.After few seconds order redownload automatically.";
			$whatsapp_group2 = $this->Scheme_Model->get_website_data("whatsapp_group2");
			$this->Message_Model->insert_whatsapp_group_message($whatsapp_group2,$group2_message);
			/*************************************************************/
			
			$x = $this->db->query("update tbl_order set download_status='0',remarks='' where order_id='$order_id'");
			if($x)
			{
				echo "ok";
			}
		}
	}
	/*****************************************************/
	public function medicine_upload()
	{
		//error_reporting(0);
		$data = json_decode(file_get_contents('php://input'),true);
		$items = $data["items"];
		foreach($items as $ks)
		{
			$qry = base64_decode($ks["qry"]);
			$this->db->query("insert into tbl_medicine_essol (i_code,item_code,item_name,title,packing,expiry,batch_no,batchqty,salescm1,salescm2,sale_rate,mrp,final_price,margin,costrate,compcode,comp_altercode,company_name,company_full_name,division,qscm,hscm,misc_settings,item_date,itemcat,gstper,itemjoinid,present,featured,discount,image1,image2,image3,image4,title2,description,status,time) values ".$qry);
			echo $ks["thisid"];
		}
	}
	public function medicine_copy_table($total="")
	{
		$r1 = $this->db->query("SELECT count(id) as total FROM `tbl_medicine_essol`")->row();
		if($r1->total==$total)
		{
			/*$this->db->query("DROP TABLE tbl_medicine");
			$this->db->query("CREATE TABLE tbl_medicine LIKE tbl_medicine_essol");
			$this->db->query("INSERT tbl_medicine SELECT * FROM tbl_medicine_essol");
			$this->db->query("TRUNCATE TABLE tbl_medicine_essol");*/

			$this->db->query("TRUNCATE TABLE tbl_medicine");
			$this->db->query("INSERT tbl_medicine SELECT * FROM tbl_medicine_essol");
			$this->db->query("TRUNCATE TABLE tbl_medicine_essol");
			echo "ok";
		}
		else
		{
			/***************only for group message***********************/
			$group2_message 	= "This team please Check total number of medicines!";
			$whatsapp_group2 = $this->Scheme_Model->get_website_data("whatsapp_group2");
			$this->Message_Model->insert_whatsapp_group_message($whatsapp_group2,$group2_message);
			/*************************************************************/
		}
	}
	public function medicine_reset()
	{
		//error_reporting(0);
		$this->db->query("TRUNCATE TABLE tbl_medicine_essol");
		echo "ok";
	}
	/*****************************************************/
	public function chemist_upload()
	{
		//error_reporting(0);
		$data = json_decode(file_get_contents('php://input'),true);
		$items = $data["items"];
		foreach($items as $ks)
		{
			$qry = base64_decode($ks["qry"]);
			$this->db->query("insert into tbl_acm_essol (code,altercode,groupcode,name,type,trimname,address,address1,address2,address3,telephone,telephone1,mobile,email,gstno,status,statecode,invexport,slcd) values ".$qry);
			echo $ks["thisid"];
		}
	}
	public function chemist_copy_table($total="")
	{
		$r1 = $this->db->query("SELECT count(id) as total FROM `tbl_acm_essol`")->row();
		if($r1->total==$total)
		{
			//error_reporting(0);
			$this->db->query("DROP TABLE tbl_acm");
			$this->db->query("CREATE TABLE tbl_acm LIKE tbl_acm_essol");
			$this->db->query("INSERT tbl_acm SELECT * FROM tbl_acm_essol");
			$this->db->query("TRUNCATE TABLE tbl_acm_essol");
			echo "ok";
			
			$this->db->query("update tbl_acm_other set block='0'");
			$result = $this->db->query("select * from tbl_acm where status='*'")->result();
			foreach($result as $row)
			{
				$code = $row->code;
				$chemist_id = $row->altercode;
				if($row->status=="*")
				{
					$this->db->query("update tbl_acm_other set block='1' where code='$code'");
					$this->db->query("update tbl_android_device_id  set logout='1' where user_type='chemist' and chemist_id='$chemist_id'");
				}
			}
		}
	}
	public function chemist_reset()
	{
		//error_reporting(0);
		$this->db->query("TRUNCATE TABLE tbl_acm_essol");
		echo "ok";
	}
	/*****************************************************/
	public function staff_upload()
	{
		//error_reporting(0);
		$data = json_decode(file_get_contents('php://input'),true);
		$items = $data["items"];
		foreach($items as $ks)
		{
			$qry = base64_decode($ks["qry"]);
			$this->db->query("insert into tbl_staffdetail_essol (code,compcode,staffname,degn,mobilenumber,division,memail,slcd,automail,staffid,staffpwd,withsalerep,salerepdt,withcustsale,custrepdt,branchstatus,maxosamt,maxosinv,snsrepdt,bank,chqno,comp_altercode,company_full_name) values ".$qry);
			echo $ks["thisid"];
		}
	}
	public function staff_copy_table($total="")
	{
		$r1 = $this->db->query("SELECT count(id) as total FROM `tbl_staffdetail_essol`")->row();
		if($r1->total==$total)
		{
			$this->db->query("DROP TABLE tbl_staffdetail");
			$this->db->query("CREATE TABLE tbl_staffdetail LIKE tbl_staffdetail_essol");
			$this->db->query("INSERT tbl_staffdetail SELECT * FROM tbl_staffdetail_essol");
			$this->db->query("TRUNCATE TABLE tbl_staffdetail_essol");
			echo "ok";
			
			$time = time();
			$daily_date = date('Y-m-d');
			$result = $this->db->query("select * from tbl_staffdetail")->result();			
			foreach($result as $row)
			{
				$code = $row->code;
				$row1 = $this->db->query("select * from tbl_staffdetail_other where code='$code'")->row();
				if(empty($row1->id)){
					$this->db->query("INSERT INTO tbl_staffdetail_other (code,daily_date,stock_and_sales_analysis, stock_and_sales_analysis_daily_email,download_status) VALUES ('$code','$daily_date','1', '1','2')");
				}
			}
		}
	}
	public function staff_reset()
	{
		//error_reporting(0);
		$this->db->query("TRUNCATE TABLE tbl_staffdetail_essol");
		echo "ok";
	}
	/*****************************************************/
	public function master_upload()
	{
		//error_reporting(0);
		$data = json_decode(file_get_contents('php://input'),true);
		$items = $data["items"];
		foreach($items as $ks)
		{
			$qry = base64_decode($ks["qry"]);
			$this->db->query("insert into tbl_master_essol (code,altercode,slcd,name,telephone,telephone1,mobile,email,status,transport,trimName) values ".$qry);
			echo $ks["thisid"];
		}
	}
	public function master_copy_table($total="")
	{
		$r1 = $this->db->query("SELECT count(id) as total FROM `tbl_master_essol`")->row();
		if($r1->total==$total)
		{
			$this->db->query("DROP TABLE tbl_master");
			$this->db->query("CREATE TABLE tbl_master LIKE tbl_master_essol");
			$this->db->query("INSERT tbl_master SELECT * FROM tbl_master_essol");
			$this->db->query("TRUNCATE TABLE tbl_master_essol");
			echo "ok";
		}
	}
	public function master_reset()
	{
		//error_reporting(0);
		$this->db->query("TRUNCATE TABLE tbl_master_essol");
		echo "ok";
	}
	/************************invoice upload********************************/
	public function invoice_upload()
	{
		//error_reporting(0);
		$data = json_decode(file_get_contents('php://input'),true);
		$items = $data["items"];
		foreach($items as $ks)
		{
			$qry = base64_decode($ks["qry"]);
			if($qry!="")
			{
				$this->db->query("insert into tbl_invoice (acno,amt,taxamt,gstvno,name,email,altercode,date,delete_status) values ".$qry);
			}
			echo $ks["_id"];
		}
	}

	public function hot_selling_upload()
	{
		//error_reporting(0);
		$data = json_decode(file_get_contents('php://input'),true);
		$items = $data["items"];
		foreach($items as $ks)
		{
			$hot_selling_query = ($ks["hot_selling_query"]);
			if($hot_selling_query!="")
			{
				$hot_selling_query = base64_decode($hot_selling_query);
				$this->db->query("TRUNCATE TABLE tbl_hot_selling;");
				$this->db->query("insert into tbl_hot_selling (item_code,total,datetime) values ".$hot_selling_query);
			}
			echo "ok";
		}
	}

	public function upload_deliverby()
	{
		//error_reporting(0);
		$data = json_decode(file_get_contents('php://input'),true);
		$items = $data["items"];
		foreach($items as $ks)
		{
			$qry = base64_decode($ks["qry"]);
			if($qry!="")
			{
				$this->db->query("insert into tbl_deliverby (gstvno,vdt,deliverby,vno,acno,chemist_id,deliverby_altercode,amt) values ".$qry);
			}
			$qry = ($ks["qry2"]);
			if($qry!="")
			{
				$this->db->query($qry);
			}
			echo $ks["_id"];
		}
	}

	public function upload_out_for_delivery($gstvno="")
	{
		$data = json_decode(file_get_contents('php://input'),true);
		$items = $data["items"];
		foreach($items as $ks)
		{
			$out_for_delivery = ($ks["out_for_delivery"]);
			$amt = ($ks["amt"]);
			if($out_for_delivery!="")
			{
				if($gstvno!="" && $out_for_delivery!="")
				{
					$this->db->query("update tbl_invoice set out_for_delivery='$out_for_delivery' where gstvno='$gstvno'");
					echo $gstvno;
				}
			}
		}
	}

	/********************************************************/
	public function test_url_for_check()
	{
		//error_reporting(0);
		/***************only for group message***********************/
		$group2_message = "Testing message";
		$whatsapp_group2 = $this->Scheme_Model->get_website_data("whatsapp_group2");
		$this->Message_Model->insert_whatsapp_group_message($whatsapp_group2,$group2_message);
		/*************************************************************/
		echo "ok h";
	}


	public function create_new_staff($code)
	{
		//error_reporting(0);
		$time = time();
		$daily_date = date('Y-m-d');
		$monthly = date('Y-m-01', strtotime("+1 months", $time));
		$row1 = $this->db->query("select * from tbl_staffdetail_other where code='$code'")->row();
		if($row1->id==""){
			$this->db->query("INSERT INTO tbl_staffdetail_other (code,daily_date,monthly,stock_and_sales_analysis, stock_and_sales_analysis_daily_email, download_status) VALUES ('$code','$daily_date','$monthly','1', '1', '2')");
		}
		else{
			$this->db->query("update tbl_staffdetail_other set daily_date='$daily_date',monthly='$monthly',download_status='2' where code='$code'");
		}
	}

	public function download_image_from_server()
	{
		//error_reporting(0);
		$row = $this->db->query("select * from tbl_medicine_image where download_status=1 limit 1")->row();
		if(!empty($row->id)){
			$description = htmlentities($row->description);
			$description = str_replace("'","&prime;",$description);
			echo "INSERT INTO tbl_medicine_image (itemid,featured,image,image2,image3,image4,title,description,status,date,time) VALUES ('$row->itemid','$row->featured','$row->image','$row->image2','$row->image3','$row->image4','$row->title','$description','$row->status','$row->date','$row->time')";

			$this->db->query("update tbl_medicine_image set download_status=0 where id='$row->id'");
		}

		$row = $this->db->query("select * from tbl_medicine_image where download_status=2 limit 1")->row();
		if(!empty($row->id)){
			$description = htmlentities($row->description);
			$description = str_replace("'","&prime;",$description);
			echo "update tbl_medicine_image set itemid='$row->itemid',featured='$row->featured',image='$row->image',image2='$row->image2',image3='$row->image3',image4='$row->image4',title='$row->title',description='$description',status='$row->status',date='$row->date',time='$row->time' where id='$row->id'";

			$this->db->query("update tbl_medicine_image set download_status=0 where id='$row->id'");
		}
	}

	public function download_acm_rec_from_server()
	{
		//error_reporting(0);
		$row = $this->db->query("select * from tbl_acm_other where download_status='1' order by id asc limit 1")->row();			
		if(!empty($row->id))
		{
			echo "INSERT INTO tbl_acm_other (code,status,exp_date,updated_at,password_change,password,broadcast,block,image,user_phone,user_email,user_address,user_update,order_limit,new_request) VALUES ('$row->code','$row->status','$row->exp_date','$row->updated_at','$row->password_change','$row->password','$row->broadcast','$row->block','$row->image','$row->user_phone','$row->user_email','$row->user_address','$row->user_update','$row->order_limit','$row->new_request')";

			$this->db->query("update tbl_acm_other set download_status='0' where id='$row->id'");
		}

		$row = $this->db->query("select * from tbl_acm_other where download_status='2' order by id asc limit 1")->row();			
		if(!empty($row->id))
		{

			echo "update tbl_acm_other set status='$row->status',exp_date='$row->exp_date',updated_at='$row->updated_at',password_change='$row->password_change',password='$row->password',broadcast='$row->broadcast',block='$row->block',image='$row->image',user_phone='$row->user_phone',user_email='$row->user_email',user_address='$row->user_address',user_update='$row->user_update',order_limit='$row->order_limit',new_request='$row->new_request' where code='$row->code'";

			$this->db->query("update tbl_acm_other set download_status='0' where id='$row->id'");
		}
	}

	public function download_staff_rec_from_server()
	{
		$row = $this->db->query("select * from tbl_staffdetail_other where download_status='1' order by id asc limit 1")->row();			
		if(!empty($row->id))
		{
			echo "INSERT INTO tbl_staffdetail_other (code,status,password,daily_date,monthly,whatsapp_message,item_wise_report,chemist_wise_report,stock_and_sales_analysis,item_wise_report_daily_email,chemist_wise_report_daily_email,stock_and_sales_analysis_daily_email,item_wise_report_monthly_email,chemist_wise_report_monthly_email,status2) VALUES ('$row->code','$row->status','$row->password','$row->daily_date','$row->monthly','$row->whatsapp_message','$row->item_wise_report','$row->chemist_wise_report','$row->stock_and_sales_analysis','$row->item_wise_report_daily_email','$row->chemist_wise_report_daily_email','$row->stock_and_sales_analysis_daily_email','$row->item_wise_report_monthly_email','$row->chemist_wise_report_monthly_email','0')";
			
			$this->db->query("update tbl_staffdetail_other set download_status='0' where id='$row->id'"); 
		}
		
		/*$row = $this->db->query("select * from tbl_staffdetail_other where download_status='2' order by id asc limit 1")->row();			
		if(!empty($row->id))
		{
			echo "update tbl_staffdetail_other set status='$row->status',password='$row->password',daily_date='$row->daily_date',monthly='$row->monthly',whatsapp_message='$row->whatsapp_message',item_wise_report='$row->item_wise_report',chemist_wise_report='$row->chemist_wise_report',stock_and_sales_analysis='$row->stock_and_sales_analysis',item_wise_report_daily_email='$row->item_wise_report_daily_email',chemist_wise_report_daily_email='$row->chemist_wise_report_daily_email',stock_and_sales_analysis_daily_email='$row->stock_and_sales_analysis_daily_email',item_wise_report_monthly_email='$row->item_wise_report_monthly_email',chemist_wise_report_monthly_email='$row->chemist_wise_report_monthly_email' where code='$row->code'";
			
			$this->db->query("update tbl_staffdetail_other set download_status='0' where id='$row->id'"); 
		}*/
	}

	public function download_lowstock_server()
	{
		$row = $this->db->query("SELECT tbl_low_stock_alert.id,tbl_low_stock_alert.date,tbl_low_stock_alert.time,tbl_acm.code,tbl_low_stock_alert.i_code FROM tbl_low_stock_alert,tbl_acm where tbl_acm.altercode=tbl_low_stock_alert.chemist_id and tbl_low_stock_alert.user_type='chemist' and tbl_low_stock_alert.status=0 limit 1")->row();
		if(!empty($row->id))
		{			
			$slcd  = "CL";
			$Uid   = "DRD";

			$this->db->query("update tbl_low_stock_alert set status='1' where id='$row->id'");

			$vdt 	= date("Y-m-d H:i:s",$row->time);
			$acno 	= $row->code;
			$itemc 	= $row->i_code;

			echo "INSERT INTO Shortage (vdt,acno,slcd,itemc,Uid) VALUES ('$vdt','$acno','$slcd','$itemc','$Uid')";
		}
	}

	public function insert_whatsapp_message()
	{
		/********************** */
		$isdone	= "";
		$data 	= json_decode(file_get_contents('php://input'), true);
        $items 	= $data["items"];
		foreach($items as $row)
		{
			if(!empty($row["mobile"]) && !empty($row["message"]) && !empty($row["altercode"]) && $row["type_of_message"] == "whatsapp_message")
			{
				$mobile 	= $row["mobile"];
				$message 	= (base64_decode($row["message"]));
				$altercode  = $row["altercode"];

				$this->Message_Model->insert_whatsapp_message($mobile,$message,$altercode);
				$isdone="yes";
			}

			if(!empty($row["mobile"]) && !empty($row["message"]) && $row["type_of_message"] == "whatsapp_group")
			{
				$mobile 	= $row["mobile"];
				$message 	= (base64_decode($row["message"]));
				$altercode  = "";

				$this->Message_Model->insert_whatsapp_group_message($mobile,$message);
				$isdone="yes";
			}

			if(!empty($row["title"]) && !empty($row["message"]) && !empty($row["altercode"]) && !empty($row["funtype"]) && $row["type_of_message"] == "notification_message")
			{
				$title 		= $row["title"];
				$message 	= (base64_decode($row["message"]));
				$altercode  = $row["altercode"];
				$funtype 	= $row["funtype"];

				$this->Message_Model->insert_android_notification($funtype,$title,$message,$altercode,"chemist");
				$isdone="yes";
			}
		}
		if($isdone=="yes")
		{
			echo "done";
		}
	}

	public function download_order_in_folder()
	{
		$items = "";
		$result = $this->db->query("select id,order_id,item_code,quantity,user_type,chemist_id,selesman_id,temp_rec,remarks from tbl_order where temp_rec='274428_chemist_R51'")->result();
		foreach($result as $row){
			$new_temp_rec = time(); // yha temp rec nichay drd database ne temp rec banta ha
			$remarks = $this->new_clean(htmlentities($row->remarks));
			$items.='{"online_id":"'.$row->id.'","order_id": "'.$row->order_id.'","item_code": "'.$row->item_code.'","quantity": "'.$row->quantity.'","user_type": "'.$row->user_type.'","chemist_id": "'.$row->chemist_id.'","selesman_id": "'.$row->selesman_id.'","temp_rec": "'.$row->temp_rec.'","order_status": "0","sale_rate": "'.$row->sale_rate.'","new_temp_rec": "'.$new_temp_rec.'","date": "'.$row->date.'","time": "'.$row->time.'","remarks": "'.$remarks.'"},';
		}
		if (!empty($items)) {
			if ($items != '') {
				$items = substr($items, 0, -1);
			}
			echo $parmiter = '{"items": ['.$items.']}';
		}
	}
}