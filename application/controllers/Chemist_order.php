<?php
header('Content-Type: application/json');
defined('BASEPATH') OR exit('No direct script access allowed');
class Chemist_order extends CI_Controller
{
	public function get_temp_rec($chemist_id)
	{
		$user_type 		= $_COOKIE['user_type'];
		$user_altercode = $_COOKIE['user_altercode'];
		if($user_type=="sales")
		{
			$temp_rec = $user_type."_".$user_altercode."_".$chemist_id;
		}
		else
		{
			$temp_rec = $user_type."_".$user_altercode;
		}
		return $temp_rec;
	}
	
	public function add_medicine_to_cart(){
		//error_reporting(0);
		$items = "";
		$user_type 		= $_COOKIE['user_type'];
		$user_altercode	= $_COOKIE['user_altercode'];
		$i_code 		= $_POST['i_code'];
		$quantity 		= $_POST['quantity'];
		$chemist_id		= $_POST['chemist_id']; //only for sales man time
		
		$item_name = base64_decode($_POST["item_name"]);
		$sale_rate = ($_POST["final_price"]);
		$scheme    = base64_decode($_POST["scheme"]);
		$image     = ($_POST["image"]);
		/**********************************************/
		
		$time = time();
		$date = date("Y-m-d",$time);
		$datetime = date("d-M-y H:i",$time);
				
		$temp_rec = $this->get_temp_rec($chemist_id);
		$row = $this->db->query("select * from drd_temp_rec where temp_rec='$temp_rec' and status='0' order by excel_number desc")->row();
		if(!empty($row->excel_temp_id))
		{
			$excel_temp_id = $row->excel_temp_id;
		}
		else
		{
			$mytime = time();
			$excel_temp_id	= $temp_rec."_pc_mobile_".$mytime;
		}
		$excel_number_x = 0;
		if(!empty($row->excel_number))
		{
			$excel_number_x = $row->excel_number;
		}
		$excel_number = intval($excel_number_x) + 1;
		$salesman_id = "";
		if($user_type=="sales")
		{
			$salesman_id = $user_altercode;
		}
		else
		{
			$chemist_id  = $user_altercode;
		}
		if(!empty($i_code) && !empty($quantity))
		{
			$mobilenumber = "";
			$modalnumber = "PC / Laptop";

			/********************old cart m medicine ko delete karta h yha**/
			$where = array('chemist_id'=>$chemist_id,'salesman_id'=>$salesman_id,'user_type'=>$user_type,'i_code'=>$i_code,'status'=>'0');
			$row = $this->Scheme_Model->select_row("drd_temp_rec",$where);
			if(!empty($row->id))
			{
				$this->db->query("update drd_temp_rec set quantity='$quantity' where id='$row->id'");
				$response = 1;
			}
			else
			{
				$where = array('i_code'=>$i_code);
				$row = $this->Scheme_Model->select_row("tbl_medicine",$where);
				
				$order_type = "pc_mobile";
				$dt = array(
					'i_code'=>$i_code,
					'quantity'=>$quantity,

					'item_name'=>$item_name,
					'company_full_name'=>$row->company_full_name,
					'packing'=>$row->packing,
					'expiry'=>$row->expiry,
					'image'=>$image,
					'sale_rate'=>$sale_rate,
					'scheme'=>$scheme,
					
					'chemist_id'=>$chemist_id,
					'salesman_id'=>$salesman_id,
					'user_type'=>$user_type,
					'date'=>$date,
					'time'=>$time,
					'datetime'=>$datetime,
					'temp_rec'=>$temp_rec,
					'order_type'=>$order_type,
					'mobilenumber'=>$mobilenumber,
					'modalnumber'=>$modalnumber,
					'excel_temp_id'=>$excel_temp_id,
					
					'excel_number'=>$excel_number,
				);
				
				if(!empty($row->id))
				{
					$response = $this->Scheme_Model->insert_fun("drd_temp_rec",$dt);
					if($response!=0 || !empty($response))
					{
						$response = 1;
					}
				}
			}
			
$items.= <<<EOD
{"response":"{$response}"},
EOD;
        }
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}<?php
	}
	
	public function get_order_quantity_of_medicine(){
		//error_reporting(0);
		$items = "";
		$user_type 		= $_COOKIE['user_type'];
		$user_altercode	= $_COOKIE['user_altercode'];
		
		$chemist_id	= $_REQUEST["chemist_id"];
		$i_code		= $_REQUEST["i_code"];
		
		$salesman_id = "";
		if($user_type=="sales")
		{
			$salesman_id = $user_altercode;
		}
		else
		{
			$chemist_id  = $user_altercode;
		}
		
		$quantity = "";
		$where = array('chemist_id'=>$chemist_id,'salesman_id'=>$salesman_id,'user_type'=>$user_type,'i_code'=>$i_code,'status'=>'0');
		$row = $this->Scheme_Model->select_row("drd_temp_rec",$where);
		if(!empty($row->id))
		{
			$quantity = $row->quantity;
		}
		
$items .= <<<EOD
{"quantity":"{$quantity}"},
EOD;

if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}<?php
    }
	

	public function save_order_to_server()
	{		
		error_reporting(0);
		$items = "";
		$slice_type		= $_REQUEST["slice_type"];
		$slice_item		= $_REQUEST["slice_item"];
		$chemist_id		= $_REQUEST["chemist_id"];
		$remarks 		= $_REQUEST["remarks"];

		$user_type 		= $_COOKIE['user_type'];
		$user_altercode = $_COOKIE['user_altercode'];
		$user_password	= $_COOKIE['user_password'];
		
		$chemist_id 	= $_COOKIE['chemist_id'];

		$salesman_id = "";
		if($user_type=="sales")
		{
			$salesman_id 	= $user_altercode;
			$user_altercode = $chemist_id;
		}	

		$val = $this->Order_Model->save_order_to_server("pc_mobile",$slice_type,$slice_item,$remarks,$salesman_id,$user_altercode,$user_type,$user_password);
		$status = $val[0];
		$place_order_message = ($val[1]);
		if($status=="1"){
			$user_cart_total = 0;
			setcookie("user_cart_total", $user_cart_total, time() + (86400 * 30), "/");
		}
		
$items .= <<<EOD
{"status":"{$status}","place_order_message":"{$place_order_message}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}<?php
	}
}
?>