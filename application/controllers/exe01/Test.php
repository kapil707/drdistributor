<?php
header("Content-type: application/json; charset=utf-8");
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit','-1');
ini_set('post_max_size','500M');
ini_set('upload_max_filesize','500M');
ini_set('max_execution_time',36000);
class Test extends CI_Controller
{
	function new_clean($string)
	{
		$k = str_replace('\n', '<br>', $string);
		$k = preg_replace('/[^A-Za-z0-9\#]/', ' ', $k);
		return $k;
		//return preg_replace('/[^A-Za-z0-9\#]/', '', $string); // Removes special chars.
	}
	public function download_order_in_localhost()
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
				$chemist_id = $row->chemist_id;
			}
			
			$row2 = $this->db->query("SELECT code,slcd FROM `tbl_acm` WHERE `altercode`='" . $chemist_id . "'")->row();
			if (!empty($row2->code)) {
				$acno = $row2->code;
				$slcd = $row2->slcd;
			}
			
			foreach ($result as $row) {
				$new_temp_rec = time(); // yha temp rec nichay drd database ne temp rec banta ha
				$remarks = $this->new_clean(htmlentities($row->remarks));
				$remarks = base64_encode($remarks);
				
				$items .= '{"online_id":"' . $row->id . '","order_id": "' . $row->order_id . '","i_code": "' . $row->i_code . '","item_code": "' . $row->item_code . '","quantity": "' . $row->quantity . '","sale_rate": "' . $row->sale_rate . '","user_type": "' . $row->user_type . '","chemist_id": "' . $row->chemist_id . '","salesman_id": "' . $row->selesman_id . '","acno": "' . $acno . '","slcd": "' . $slcd . '","remarks": "' . $remarks . '","date": "' . $row->date . '","time": "' . $row->time . '","total_line": "' . $total_line . '","temp_rec": "' . $row->temp_rec . '","new_temp_rec": "' . $new_temp_rec . '","order_status": "0"},';
			}
			if (!empty($items)) {
				if ($items != '') {
					$items = substr($items, 0, -1);
				}
				echo $parmiter = '{"items": [' . $items . ']}';
			}
		}
	}
}