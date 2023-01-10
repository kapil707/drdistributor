<?php header("Content-type: application/json; charset=utf-8");
defined('BASEPATH') OR exit('No direct script access allowed');
class Api_track extends CI_Controller {
	public function login($page_type)
	{
		error_reporting(0);
		$defaultpassword= $this->Scheme_Model->get_website_data("defaultpassword");
		$items = "";
		$user_return 	= 	"0";
		$user_alert 	= 	"Logic error.";
		if($page_type=="get")
		{
			$submit		= $_GET['submit'];
			$user_name1 = $_GET['user_name1'];
			$password1 	= $_GET['password1'];
		}
		if($page_type=="post")
		{
			$submit		= $_POST['submit'];
			$user_name1 = $_POST['user_name1'];
			$password1 	= $_POST['password1'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
			$user_return 	= 	"0";
			$user_alert 	= 	"Wrong Anything Else";
			if($user_name1!="" && $password1!="")
			{
				$user_password = md5($password1);
				$alert = "Enter true User name or Password";			
				$query = $this->db->query("select tbl_master.id,tbl_master.code,tbl_master.altercode,tbl_master.name,tbl_master.mobile,tbl_master.email,tbl_master.status as status1,tbl_master_other.status,tbl_master_other.password as password,tbl_master_other.exp_date from tbl_master left join tbl_master_other on tbl_master.code = tbl_master_other.code where tbl_master.altercode='$user_name1' and tbl_master.code=tbl_master_other.code and tbl_master.slcd='SM' limit 1")->row();
				if ($query->id!="")
				{
					if ($query->password == $user_password || $user_password==md5($defaultpassword))
					{
						$user_session 	= 	$query->id;
						$user_fname		= 	$query->name;
						$user_code	 	= 	$query->code;
						$user_altercode	= 	$query->altercode;
						$user_return 	= 	"1";
						$user_alert 	= 	"Logged in successfully";
					}
					else
					{
						$user_alert = "Incorrect password";
					}
				}
				else
				{
						$user_alert = "You are not registered";
				}
			}
$items .= <<<EOD
{"user_session":"{$user_session}","user_fname":"{$user_fname}","user_code":"{$user_code}","user_altercode":"{$user_altercode}","user_password":"{$user_password}","user_alert":"{$user_alert}","user_return":"{$user_return}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
[<?= $items;?>]
<?php
		}
	}
	public function update_live_track_user($page_type)
	{
		error_reporting(0);
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$user_session 	= $_GET['user_session'];
			$latitude		= $_GET['latitude'];
			$longitude		= $_GET['longitude'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$user_session 	= $_POST['user_session'];
			$latitude		= $_POST['latitude'];
			$longitude		= $_POST['longitude'];
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
			$datetime = time();
			$timei = date("i",$time);
			$time = date("H:i",$time);
			$row = $this->db->query("select code from tbl_master where id='$user_session' and slcd='SM'")->row();
			$code = $row->code;
			
			$this->db->query("update tbl_master_other set latitude='$latitude',longitude='$longitude',date='$date',time='$time',datetime='$datetime' where code='$code'");
			$treak_time = $this->Scheme_Model->get_website_data("treak_time");
			/*if($timei%$treak_time==0){*/
				$row = $this->db->query("select id from tbl_deliver_info where time='$time' and date='$date' and user_id='$user_session' order by id desc")->row();
				if($row->id=="")
				{
					$this->db->query("insert into tbl_deliver_info set latitude='$latitude',longitude='$longitude',user_id='$user_session',date='$date',time='$time',datetime='$datetime'");
				}
			//}
			$toast_msg = "Update Your Info :- ".$time;
$items .= <<<EOD
{"toast_msg":"{$toast_msg}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
[<?= $items;?>]
<?php
		}
	}
	public function chemist_info_for_delivery_boy($page_type)
	{
		error_reporting(0);
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$user_session 	= $_GET['user_session'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$user_session 	= $_POST['user_session'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
			$row2 = $this->db->query("select altercode from tbl_master where id='$user_session' and slcd='SM'")->row();
			$altercode 	= $row2->altercode;
			$result = $this->db->query("SELECT DISTINCT `chemist_id` FROM `tbl_deliverby` WHERE deliverby_altercode='$altercode'")->result();
			foreach($result as $row)
			{
				$chemist_id 	= $row->chemist_id;
				$row1 = $this->db->query("SELECT * FROM `tbl_acm` WHERE altercode='$chemist_id' and slcd='CL'")->row();
				$id			=	$row1->id;
				$name		=	$row1->name;
				$code		=	$row1->code;
				$altercode	=	$row1->altercode;			
$items .= <<<EOD
{"id":"{$id}","name":"{$name}","code":"{$code}","altercode":"{$altercode}"},
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
	public function order_completed($page_type)
	{
		error_reporting(0);
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$user_session 	= $_GET['user_session'];
			$chemist_id		= $_GET['chemist_id'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$user_session 	= $_POST['user_session'];
			$chemist_id		= $_POST['chemist_id'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
			$row2 = $this->db->query("select altercode from tbl_master where id='$user_session' and slcd='SM'")->row();
			$altercode 	= $row2->altercode;
			$x = $this->db->query("delete from tbl_deliverby where chemist_id='$chemist_id' and deliverby_altercode='$altercode'");
			$toast_msg = "";
			if($x)
			{
				$toast_msg = "Your Order Has Been Completed Successfully!";
			}
$items .= <<<EOD
{"toast_msg":"{$toast_msg}"},
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