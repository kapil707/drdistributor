<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit','-1');
ini_set('post_max_size','500M');
ini_set('upload_max_filesize','500M');
ini_set('max_execution_time',36000);
class Exe02 extends CI_Controller
{
	function new_clean($string)
	{
		$k = str_replace('\n', '<br>', $string);
		$k = preg_replace('/[^A-Za-z0-9\#]/', ' ', $k);
		return $k;
		//return preg_replace('/[^A-Za-z0-9\#]/', '', $string); // Removes special chars.
	}
	public function insert_message_on_server()
	{
		/********************** */
		$isdone = "";
		$data = json_decode(file_get_contents('php://input'), true);
		$items = $data["items"];
		foreach ($items as $row) {
			if (!empty($row["mobile"]) && !empty($row["message"]) && $row["type_of_message"] == "whatsapp_message") {
				$mobile = $row["mobile"];
				$message = (base64_decode($row["message"]));
				$altercode = $row["altercode"];

				$this->Message_Model->insert_whatsapp_message($mobile, $message, $altercode);
				$isdone = "yes";
			}

			if (!empty($row["mobile"]) && !empty($row["message"]) && $row["type_of_message"] == "whatsapp_group") {
				$mobile = $row["mobile"];
				$message = (base64_decode($row["message"]));
				$altercode = "";

				$this->Message_Model->insert_whatsapp_group_message($mobile, $message);
				$isdone = "yes";
			}

			if (!empty($row["title"]) && !empty($row["message"]) && !empty($row["altercode"]) && !empty($row["funtype"]) && $row["type_of_message"] == "notification_message") {
				$title = $row["title"];
				$message = (base64_decode($row["message"]));
				$altercode = $row["altercode"];
				$funtype = $row["funtype"];

				$this->Message_Model->insert_android_notification($funtype, $title, $message, $altercode, "chemist");
				$isdone = "yes";
			}
		}
		if ($isdone == "yes") {
			echo "done";
		}
	}

	public function download_order_in_folder()
	{
		$items = "";
		$total_line = 0;
		$q = $this->db->query("select temp_rec from tbl_order where download_status='0' order by id asc limit 1")->row();

		$q = $this->db->query("select temp_rec from tbl_order where temp_rec='282880_chemist_V153' order by id asc limit 1")->row();
		if (!empty($q->temp_rec)) {
			$temp_rec = $q->temp_rec;

			$result = $this->db->query("select id,order_id,i_code,item_code,quantity,user_type,chemist_id,selesman_id,temp_rec,sale_rate,remarks,date,time from tbl_order where temp_rec='" . $temp_rec . "'")->result();
			foreach ($result as $row) {
				$total_line++;
			}
			foreach ($result as $row) {
				$new_temp_rec = time(); // yha temp rec nichay drd database ne temp rec banta ha
				$remarks = $this->new_clean(htmlentities($row->remarks));
				$items .= '{"online_id":"' . $row->id . '","order_id": "' . $row->order_id . '","code": "' . $row->i_code . '","item_code": "' . $row->item_code . '","quantity": "' . $row->quantity . '","user_type": "' . $row->user_type . '","chemist_id": "' . $row->chemist_id . '","salesman_id": "' . $row->selesman_id . '","sale_rate": "' . $row->sale_rate . '","remarks": "' . $remarks . '","date": "' . $row->date . '","time": "' . $row->time . '","total_line": "' . $total_line . '","temp_rec": "' . $row->temp_rec . '","new_temp_rec": "' . $new_temp_rec . '","order_status": "0"},';
			}
			if (!empty($items)) {
				if ($items != '') {
					$items = substr($items, 0, -1);
				}
				echo $parmiter = '{"items": [' . $items . ']}';
				file_put_contents("json_order_download/" . $temp_rec . ".json", $parmiter);
			}
		}
	}

	public function download_query_for_local_server()
	{
		$qry = "";
		$items = "";
		$result = $this->db->query("select * from tbl_medicine_image where download_status=0 limit 100")->result();
		foreach ($result as $row) {
			$description = htmlentities($row->description);
			$description = str_replace("'", "&prime;", $description);
			$description = base64_encode($description);
			$title = base64_encode($row->title);

			$items .= '{"query_type":"medicine_image","itemid":"' . $row->itemid . '","featured":"' . $row->featured . '","image":"' . $row->image . '","image2":"' . $row->image2 . '","image3":"' . $row->image3 . '","image4":"' . $row->image4 . '","title":"' . $title . '","description":"' . $description . '","status":"' . $row->status . '","date":"' . $row->date . '","time":"' . $row->time . '"},';

			$qry .= "update tbl_medicine_image set download_status=1 where id='$row->id';";
		}
		if (empty($items)) {
			$result = $this->db->query("select * from tbl_acm_other where download_status=0 limit 100")->result();
			foreach ($result as $row) {

				$code 			= $row->code;
				$status 		= $row->status;
				$exp_date 		= $row->exp_date;
				$password 		= $row->password;
				$broadcast 		= $row->broadcast;
				$block 			= $row->block;
				$image 			= $row->image;
				$user_phone 	= $row->user_phone;
				$user_email 	= $row->user_email;
				$user_address 	= $row->user_address;
				$user_update 	= $row->user_update;
				$order_limit 	= $row->order_limit;
				$new_request 	= $row->new_request;
				$website_limit 	= $row->website_limit;
				$android_limit 	= $row->android_limit;
	
				$items .= '{"query_type":"acm_other","code":"'.$code.'","status":"'.$status.'","exp_date":"'.$exp_date.'","password":"'.$password.'","broadcast":"'.$broadcast.'","block":"'.$block.'","image":"'.$image.'","user_phone":"'.$user_phone.'","user_email":"'.$user_email.'","user_address":"'.$user_address.'","user_update":"'.$user_update.'","order_limit":"'.$order_limit.'","new_request":"'.$new_request.'","website_limit":"'.$website_limit.'","android_limit":"'.$android_limit.'"},';
	
				$qry.= "update tbl_acm_other set download_status=1 where id='$row->id'";
			}
		}
		if (empty($items)) {
			$result = $this->db->query("SELECT tbl_low_stock_alert.id,tbl_low_stock_alert.date,tbl_low_stock_alert.time,tbl_acm.code,tbl_low_stock_alert.i_code FROM tbl_low_stock_alert,tbl_acm where tbl_acm.altercode=tbl_low_stock_alert.chemist_id and tbl_low_stock_alert.user_type='chemist' and tbl_low_stock_alert.download_status=0 limit 100")->result();
			foreach ($result as $row) {

				$slcd  	= "CL";
				$uid   	= "DRD";
	
				$vdt 	= date("Y-m-d H:i:s",$row->time);
				$acno 	= $row->code;
				$itemc 	= $row->i_code;
	
				$items .= '{"query_type":"low_stock_alert","vdt":"'.$vdt.'","acno":"'.$acno.'","slcd":"'.$slcd.'","itemc":"'.$itemc.'","uid":"'.$uid.'"},';
	
				$qry.= "update tbl_low_stock_alert set download_status=1 where id='$row->id'";
			}
		}
		if (!empty($items)) {
			if ($items != '') {
				$items = substr($items, 0, -1);
			}
			echo $parmiter = '{"items": [' . $items . ']}';

			$curl = curl_init();

			curl_setopt_array(
				$curl,
				array(
					CURLOPT_URL => 'http://122.160.139.36:7272/drd_local_server/exe01/download_query_for_local_server',
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 0,
					CURLOPT_TIMEOUT => 10,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS => $parmiter,
					CURLOPT_HTTPHEADER => array(
						'Content-Type: application/json',
					),
				)
			);

			$response = curl_exec($curl);
			curl_close($curl);
			echo $response;
			if ($response == "done") {
				$arr = explode(";", $qry);
				foreach ($arr as $row_q) {
					if ($row_q != "") {
						$this->db->query("$row_q");
					}
				}
			}
		}
	}
}