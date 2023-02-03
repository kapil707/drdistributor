<?php header("Content-type: application/json; charset=utf-8");
defined('BASEPATH') OR exit('No direct script access allowed');
class Api_mobile30 extends CI_Controller {
	public function insert_temp_order($page_type)
	{
		error_reporting(0);
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$device_id		= $_GET['device_id'];
			$i_code 		= $_GET['i_code'];
			$quantity 		= $_GET['quantity'];
			$item_name 		= $_GET['item_name'];
			$sale_rate 		= $_GET['sale_rate'];
			$scheme 		= $_GET['scheme'];
			$chemist_id 	= $_GET['chemist_id'];
			$selesman_id 	= $_GET['selesman_id'];
			$user_type 		= $_GET['user_type'];
			$mobilenumber 	= $_GET['mobilenumber'];
			$modalnumber 	= $_GET['modalnumber'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$device_id		= $_POST['device_id'];
			$i_code 		= $_POST['i_code'];
			$quantity 		= $_POST['quantity'];
			$item_name 		= $_POST['item_name'];
			$sale_rate 		= $_POST['sale_rate'];
			$scheme 		= $_POST['scheme'];
			$chemist_id 	= $_POST['chemist_id'];
			$selesman_id 	= $_POST['selesman_id'];
			$user_type 		= $_POST['user_type'];
			$mobilenumber 	= $_POST['mobilenumber'];
			$modalnumber 	= $_POST['modalnumber'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
			$time = time();
			$date = date("Y-m-d",$time);
			$datetime = date("d-M-y H:i",$time);
			
			if($user_type=="sales")
			{
				$temp_rec = $user_type."_".$selesman_id."_".$chemist_id;				
			}
			else
			{
				$temp_rec = $user_type."_".$chemist_id;
			}
			
			$where = array('chemist_id'=>$chemist_id,'selesman_id'=>$selesman_id,'user_type'=>$user_type,'i_code'=>$i_code,'status'=>'0');
			$row = $this->Scheme_Model->select_row("drd_temp_rec",$where);
			
			$scheme = base64_encode($scheme);
			$order_type = "Android";
			
			$dt = array(
				'device_id'=>$device_id,
				'i_code'=>$i_code,
				'quantity'=>$quantity,
				'item_name'=>$item_name,
				'sale_rate'=>$sale_rate,
				'scheme'=>$scheme,
				'chemist_id'=>$chemist_id,
				'selesman_id'=>$selesman_id,
				'user_type'=>$user_type,
				'date'=>$date,
				'time'=>$time,
				'datetime'=>$datetime,
				'temp_rec'=>$temp_rec,
				'order_type'=>$order_type,
				'mobilenumber'=>$mobilenumber,
				'modalnumber'=>$modalnumber,
				);
			
			if($row->id=="")
			{
				$query = $this->Scheme_Model->insert_fun("drd_temp_rec",$dt);
			}
			else
			{
				$where1 = array('chemist_id'=>$chemist_id,'selesman_id'=>$selesman_id,'user_type'=>$user_type,'i_code'=>$i_code,'status'=>'0');
				$query = $this->Scheme_Model->edit_fun("drd_temp_rec",$dt,$where1);
			}
$items .= <<<EOD
{"i_code":"{$i_code}","datetime":"{$datetime}","modalnumber":"{$modalnumber}","chemist_id":"{$chemist_id}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
[<?= $items;?>]
<?php
		}
	}
	
	public function get_online_cart($page_type)
	{
		error_reporting(0);
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$device_id		= $_GET['device_id'];
			$chemist_id 	= $_GET['chemist_id'];
			$selesman_id 	= $_GET['selesman_id'];
			$user_type 		= $_GET['user_type'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$device_id		= $_POST['device_id'];
			$chemist_id 	= $_POST['chemist_id'];
			$selesman_id 	= $_POST['selesman_id'];
			$user_type 		= $_POST['user_type'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
			$where = array('chemist_id'=>$chemist_id,'selesman_id'=>$selesman_id,'user_type'=>$user_type,'status'=>'0');
			$query = $this->Scheme_Model->select_all_result("drd_temp_rec",$where);
			foreach($query as $row)
			{
				$i_code 		= $row->i_code;
				$quantity		= $row->quantity;
				$datetime		= $row->datetime;
				$modalnumber	= $row->modalnumber;
				$chemist_id	    = $row->chemist_id;
			
$items .= <<<EOD
{"i_code":"{$i_code}","quantity":"{$quantity}","datetime":"{$datetime}","modalnumber":"{$modalnumber}","chemist_id":"{$chemist_id}"},
EOD;
			}
			if($i_code=="")
			{
				// jab cart empty ha to
				$i_code = 0;
				$quantity = 0;
$items .= <<<EOD
{"i_code":"{$i_code}","quantity":"{$quantity}","datetime":"{$datetime}","modalnumber":"{$modalnumber}","chemist_id":"{$chemist_id}"},
EOD;
			}
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
[<?= $items;?>]
<?php
		}
	}
	
	public function get_online_cart2($page_type) // yha sirf home page ke liya ha jab sales man say login ho to chimist id uper say he aya ge
	{
		error_reporting(0);
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$device_id		= $_GET['device_id'];
			$chemist_id 	= $_GET['chemist_id'];
			$user_type 		= $_GET['user_type'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$device_id		= $_POST['device_id'];
			$chemist_id 	= $_POST['chemist_id'];
			$user_type 		= $_POST['user_type'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
			if($user_type=="sales")
			{
				$where = array('selesman_id'=>$chemist_id,'user_type'=>$user_type,'status'=>'0');
			}
			else{
				$where = array('chemist_id'=>$chemist_id,'user_type'=>$user_type,'status'=>'0');
			}
			$query = $this->Scheme_Model->select_all_result("drd_temp_rec",$where);
			foreach($query as $row)
			{
				$i_code 		= $row->i_code;
				$quantity		= $row->quantity;
				$datetime		= $row->datetime;
				$modalnumber	= $row->modalnumber;
				$chemist_id	    = $row->chemist_id;
			
$items .= <<<EOD
{"i_code":"{$i_code}","quantity":"{$quantity}","datetime":"{$datetime}","modalnumber":"{$modalnumber}","chemist_id":"{$chemist_id}"},
EOD;
			}
			if($i_code=="")
			{
				// jab cart empty ha to
				$i_code = 0;
				$quantity = 0;
$items .= <<<EOD
{"i_code":"{$i_code}","quantity":"{$quantity}","datetime":"{$datetime}","modalnumber":"{$modalnumber}","chemist_id":"{$chemist_id}"},
EOD;
			}
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
[<?= $items;?>]
<?php
		}
	}
	
	public function delete_temp_order($page_type)
	{
		error_reporting(0);
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$i_code 		= $_GET['i_code'];
			$device_id		= $_GET['device_id'];
			$chemist_id 	= $_GET['chemist_id'];
			$selesman_id 	= $_GET['selesman_id'];
			$user_type 		= $_GET['user_type'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$i_code 		= $_POST['i_code'];
			$device_id		= $_POST['device_id'];
			$chemist_id 	= $_POST['chemist_id'];
			$selesman_id 	= $_POST['selesman_id'];
			$user_type 		= $_POST['user_type'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
			$where = array('chemist_id'=>$chemist_id,'selesman_id'=>$selesman_id,'user_type'=>$user_type,'i_code'=>$i_code,'status'=>'0');
			$query = $this->Scheme_Model->delete_fun("drd_temp_rec",$where);
			
			$result = "0";
			if($query)
			{
				$result = "1";
			}
			
$items .= <<<EOD
{"result":"{$result}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
[<?= $items;?>]
<?php
		}
	}
	
	public function deleteall_temp_order($page_type)
	{
		error_reporting(0);
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$i_code 		= $_GET['i_code'];
			$device_id		= $_GET['device_id'];
			$chemist_id 	= $_GET['chemist_id'];
			$selesman_id 	= $_GET['selesman_id'];
			$user_type 		= $_GET['user_type'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$i_code 		= $_POST['i_code'];
			$device_id		= $_POST['device_id'];
			$chemist_id 	= $_POST['chemist_id'];
			$selesman_id 	= $_POST['selesman_id'];
			$user_type 		= $_POST['user_type'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
			$where = array('chemist_id'=>$chemist_id,'selesman_id'=>$selesman_id,'user_type'=>$user_type,'status'=>'0');
			$query = $this->Scheme_Model->delete_fun("drd_temp_rec",$where);
			
			$result = "0";
			if($query)
			{
				$result = "1";
			}
			
$items .= <<<EOD
{"result":"{$result}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
[<?= $items;?>]
<?php
		}
	}
	
	public function save_order_to_server($page_type)
	{
		error_reporting(0);
		if($page_type=="get")
		{			
			$submit			= $_GET['submit'];
			$device_id		= $_GET['device_id'];
			$chemist_id 	= $_GET['chemist_id'];
			$selesman_id 	= $_GET['selesman_id'];
			$user_type 		= $_GET['user_type'];			
			$remarks 		= $_GET["remarks"];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$device_id		= $_POST['device_id'];
			$chemist_id 	= $_POST['chemist_id'];
			$selesman_id 	= $_POST['selesman_id'];
			$user_type 		= $_POST['user_type'];
			$remarks 		= $_POST["remarks"];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{			
			$slice_type		= "";
			$slice_item		= "";
			
			$where= array('altercode'=>$chemist_id,'slcd'=>'CL');
			$row = $this->Scheme_Model->select_row("tbl_acm",$where);
			$where= array('code'=>$row->code);
			$row1 = $this->Scheme_Model->select_row("tbl_acm_other",$where);

			$this->Order_Model->save_order_to_server("Android",$slice_type,$slice_item,$remarks,$selesman_id,$chemist_id,$user_type,$row1->password);
			$order_success = 1;
			
$items .= <<<EOD
{"order_success":"{$order_success}","device_id":"{$device_id}","chemist_id":"{$chemist_id}","selesman_id":"{$selesman_id}","user_type":"{$user_type}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
[<?= $items;?>]
<?php
		}
	}
}