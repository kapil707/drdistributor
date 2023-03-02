<?php header("Content-type: application/json; charset=utf-8");
defined('BASEPATH') OR exit('No direct script access allowed');
class Api_track2 extends CI_Controller {
	public function login($page_type)
	{
		error_reporting(0);
		$defaultpassword= $this->Scheme_Model->get_website_data("defaultpassword");
		$items = "";
		$user_return 	= 	"0";
		$user_alert 	= 	"Logic error.";
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$user_name1 	= $_GET['user_name1'];
			$password1 		= $_GET['password1'];
			$firebase_token = $_GET['firebase_token'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$user_name1 	= $_POST['user_name1'];
			$password1 		= $_POST['password1'];
			$firebase_token = $_POST['firebase_token'];
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
				$user_alert = "Enter true User name or Password";			
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

						$this->db->query("update tbl_master_other set firebase_token='$firebase_token' where code='$user_code'");
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

	public function get_home_page($page_type)
	{
		$items = "";
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$user_id		= $_GET['user_id'];
			$user_session 	= $_GET['user_session'];
			$user_altercode = $_GET['user_altercode'];
			$firebase_token = $_GET['firebase_token'];
			$qry		    = $_GET['qry'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$user_id		= $_POST['user_id'];
			$user_session 	= $_POST['user_session'];
			$user_altercode = $_POST['user_altercode'];
			$firebase_token = $_POST['firebase_token'];
			$qry		    = $_POST['qry'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
		    if(!empty($qry)){
    		    $row	= str_replace("'",'"',$qry);
    		    if ($row != '') {
    				$row = substr($row, 0, -1);
    				$row = "[$row]";
    			}
    		    $row = json_decode($row);
                foreach($row as $r){
                    $latitude   = $r->latitude;
                    $longitude  = $r->longitude;
                    $loc_id     = $r->loc_id;
                    $gettime    = $r->gettime;
                    $getdate    = $r->getdate;
                    $q = $this->db->query("select id from tbl_rider_loc where loc_id='$loc_id'")->row();
    				if (empty($q->id)) {
                        $this->db->query("insert into tbl_rider_loc set latitude='$latitude',longitude='$longitude',loc_id='$loc_id',user_altercode='$user_altercode',gettime='$gettime',getdate='$getdate'");
    				}
                }
		    } else {
                /*---------------------------------*/
            
    			$time = time();
    			$date = date("Y-m-d",$time);
    			$time = date("H:i",$time);
    			$row = $this->db->query("select id,time from drd_attendance where user_id = '$user_id' and date='$date'")->row();
    			$attendance = "no";
    			$time = "";
    			if(!empty($row->id)){
    				$attendance = "yes";
    				$time = $row->time;
    			}
    			$type = "other";
    			$query = $this->db->query("select tbl_master.id,tbl_master.slcd,tbl_master.code,tbl_master.altercode,tbl_master.name,tbl_master.mobile,tbl_master.email,tbl_master.status as status1,tbl_master_other.status,tbl_master_other.password as password,tbl_master_other.exp_date from tbl_master left join tbl_master_other on tbl_master.code = tbl_master_other.code where tbl_master.id='$user_id' and tbl_master.code=tbl_master_other.code limit 1")->row();
    			if($query->slcd=="SM")
    			{
    				$type = "rider";
    			}
		    }
if(!empty($qry)){
    $done = "yes";
$items .= <<<EOD
{"done":"{$done}"},
EOD;
}else{
    $done = "no";
$items .= <<<EOD
{"attendance":"{$attendance}","time":"{$time}","type":"{$type}","done":"{$done}"},
EOD;
}
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
[<?= $items;?>]
<?php
	}

	public function get_drd_attendance($page_type)
	{
		$items = "";
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$user_id		= $_GET['user_id'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$user_id		= $_POST['user_id'];
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
			$time = date("H:i",$time);
			$row = $this->db->query("select id,time from drd_attendance where user_id = '$user_id' and date='$date'")->row();
			$attendance = "no";
			$time = "";
			if(!empty($row->id)){
				$attendance = "yes";
				$time = $row->time;
			}

$items .= <<<EOD
{"attendance":"{$attendance}","time":"{$time}"},
EOD;
			}
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
[<?= $items;?>]
<?php
	}

	public function insert_drd_attendance($page_type)
	{
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$date			= $_GET['date'];
			$time			= $_GET['time'];
			$user_id		= $_GET['user_id'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$date			= $_POST['date'];
			$time			= $_POST['time'];
			$user_id		= $_POST['user_id'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
			$this->db->query("insert into drd_attendance (date,time,user_id) values ('$date','$time','$user_id')");
		}
	}

	public function get_delivery_chemist($page_type)
	{
		//error_reporting(0);
		$items = "";
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
			$result = $this->db->query("SELECT DISTINCT tbl_deliverby.`chemist_id`,tbl_acm.name,tbl_invoice.amt,tbl_invoice.gstvno FROM tbl_deliverby,tbl_master,tbl_acm,tbl_invoice WHERE tbl_master.id='$user_session' and tbl_deliverby.deliverby_altercode = tbl_master.altercode and tbl_master.slcd='SM' and tbl_deliverby.chemist_id = tbl_acm.altercode and tbl_invoice.gstvno = tbl_deliverby.gstvno and tbl_deliverby.status=0")->result();
			foreach($result as $row)
			{
				$chemist_id = 	$row->chemist_id;
				$name		=	$row->name;
				$amt		=	$row->amt;
				$gstvno		=	$row->gstvno;			
$items .= <<<EOD
{"chemist_id":"{$chemist_id}","name":"{$name}","amt":"{$amt}","gstvno":"{$gstvno}"},
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
	
	public function insert_rider_location($page_type)
	{
		header("Content-type: application/json; charset=utf-8");
		$items = "";
		if($page_type=="get")
		{
			$user_id 		= $_GET["user_session"];
			$firebase_token = $_GET["firebase_token"];
			$device_id 		= $_GET["device_id"];
			$getlatitude 	= $_GET["getlatitude"];
			$getlongitude 	= $_GET["getlongitude"];
			$gettime 		= $_GET["gettime"];
			$getdate 		= $_GET["getdate"];
			$my_id 			= $_GET["my_id"];
			$working 		= $_GET["working"];
		}
		if($page_type=="post")
		{
			$user_id 		= $_POST["user_session"];
			$firebase_token = $_POST["firebase_token"];
			$device_id 		= $_POST["device_id"];
			$getlatitude 	= $_POST["getlatitude"];
			$getlongitude 	= $_POST["getlongitude"];
			$gettime 		= $_POST["gettime"];
			$getdate 		= $_POST["getdate"];
			$my_id 			= $_POST["my_id"];
			$working 		= $_POST["working"];			
		}
		if($device_id!="" && $getlatitude!="0.0" && $getlongitude!="0.0" && $my_id!="")
		{
			$row = $this->db->query("select id from tbl_rider_info where user_id='$user_id'")->row();
			if(!empty($row->id))
			{
				$this->db->query("update tbl_rider_info set gettime='$gettime',getdate='$getdate',getlatitude='$getlatitude',getlongitude='$getlongitude',firebase_token='$firebase_token',device_id='$device_id' where user_id='$user_id'");
			}
			else
			{
				$this->db->query("insert into tbl_rider_info (firebase_token,device_id,user_id) values ('$firebase_token','$device_id','$user_id')");
			}

			$this->db->query("insert into tbl_rider_info_child (user_id,device_id,gettime,getdate,getlatitude,getlongitude,my_id,working) values ('$user_id','$device_id','$gettime','$getdate','$getlatitude','$getlongitude','$my_id','$working')");
		}
$items .= <<<EOD
{"my_id":"{$my_id}"},
EOD;

if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
[<?= $items;?>]
<?php
	}

	public function upload_rider_chemist_photo($page_type)
	{
		header("Content-type: application/json; charset=utf-8");
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$image_path 	= $_POST['image_path'];
			$gstvno 		= $_POST['gstvno'];
			$chemist_id 	= $_POST['chemist_id'];
			$rider_id 		= $_POST['user_altercode'];
			
			$img_name     = time()."_".$gstvno."_".$chemist_id."_".$rider_id.".png";
			$user_profile = "upload_chemist_photo/$img_name";			
			file_put_contents($user_profile,base64_decode($image_path));
			
			$time = time();
			$date = date("Y-m-d",$time);
			$time = date("H:i",$time);

			$this->db->query("insert into tbl_rider_chemist_photo (rider_id,chemist_id,image,gstvno,date,time) values ('$rider_id','$chemist_id','$img_name','$gstvno','$date','$time')");
			
			echo base_url().$user_profile;
		}
		else{
			echo "Not Uploaded";
		}
	}

	public function delete_rider_chemist_photo($page_type)
	{
		$items = "";
		$toast_msg = "Not Delete";
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$id 			= $_GET['id'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$id 			= $_POST['id'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
			$row = $this->db->query("select * from tbl_rider_chemist_photo where id='$id'")->row();
			if($row->id)
			{
				$files 	= "./upload_chemist_photo/".$row->image;
				if(file_exists($files)=="1")
				{
					unlink($files);
					$toast_msg = "Photo Deleted Successfully!";	
					$this->db->query("delete from tbl_rider_chemist_photo where id='$id'");	
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

	public function show_rider_chemist_photo($page_type)
	{
		//error_reporting(0);
		$items = "";
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$gstvno 		= $_GET['gstvno'];
			$chemist_id		= $_GET['chemist_id'];
			$rider_id 		= $_GET['user_altercode'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$gstvno 		= $_POST['gstvno'];
			$chemist_id		= $_POST['chemist_id'];
			$rider_id 		= $_POST['user_altercode'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
			$result = $this->db->query("SELECT * from tbl_rider_chemist_photo where gstvno='$gstvno' and chemist_id='$chemist_id' and rider_id='$rider_id'")->result();
			foreach($result as $row)
			{
				$id  	=	$row->id;
				$image 	= 	base_url()."upload_chemist_photo/".$row->image;
				$date  	=	$row->date;
				$time  	=	$row->time;			
$items .= <<<EOD
{"id":"{$id}","image":"{$image}","date":"{$date}","time":"{$time}"},
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

	
	public function complete_order($page_type)
	{
		//error_reporting(0);
		$items = "";
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$gstvno 		= $_GET['gstvno'];
			$chemist_id 	= $_GET['chemist_id'];
			$user_session 	= $_GET['user_altercode'];
			$message 		= $_GET['message'];
			$getlatitude 	= $_GET['getlatitude'];
			$getlongitude 	= $_GET['getlongitude'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$gstvno 		= $_POST['gstvno'];
			$chemist_id 	= $_POST['chemist_id'];
			$user_session 	= $_POST['user_altercode'];
			$message 		= $_POST['message'];
			$getlatitude 	= $_POST['getlatitude'];
			$getlongitude 	= $_POST['getlongitude'];
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
			$time = date("H:i",$time);

			$row = $this->db->query("select altercode from tbl_master where id='$user_session' and slcd='SM'")->row();
			$altercode 	= $row->altercode;
			$x = $this->db->query("update tbl_deliverby set message='$message',date='$date',time='$time',status=1,getlatitude='$getlatitude',getlongitude='$getlongitude' where chemist_id='$chemist_id' and deliverby_altercode='$altercode' and gstvno='$gstvno'");
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

	/*public function test_dt($typeme='')
	{
		$result = $this->db->query("select * from test_tbl where typeme='$typeme'")->result();
		foreach($result as $row)
		{
			echo "Altercode='$row->cid' or ";
		}
	}*/

	public function update_live_track_user($page_type)
	{
		$items = "";
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$user_session 	= $_GET['user_session'];
			$user_altercode = $_GET['user_altercode'];
			$firebase_token = $_GET['firebase_token'];
			$latitude		= $_GET['latitude'];
			$longitude		= $_GET['longitude'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$user_session 	= $_POST['user_session'];
			$user_altercode = $_POST['user_altercode'];
			$firebase_token = $_POST['firebase_token'];
			$latitude		= $_POST['latitude'];
			$longitude		= $_POST['longitude'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1 && !empty($user_session))
		{
			$time = time();
			$date = date("Y-m-d",$time);
			$datetime = time();
			$timei = date("i",$time);
			if ($timei % 4 == 0) 
			{
				$time = date("H:i", $time);

				$this->db->query("update tbl_master,tbl_master_other set tbl_master_other.latitude='$latitude',tbl_master_other.longitude='$longitude',tbl_master_other.date='$date',tbl_master_other.time='$time',tbl_master_other.datetime='$datetime' where tbl_master.code=tbl_master_other.code and tbl_master.id='$user_session'");

				if (empty($user_altercode)) {
					$q = $this->db->query("select altercode from tbl_master where id='$user_session'")->row();
					$user_altercode = $q->altercode;
				}
				$q = $this->db->query("select id from tbl_deliver_info where user_altercode='$user_altercode' and date='$date' and time='$time'")->row();
				if (empty($q->id)) {
					$this->db->query("insert into tbl_deliver_info set latitude='$latitude',longitude='$longitude',user_session='$user_session',user_altercode='$user_altercode',date='$date',time='$time',datetime='$datetime'");
				}
			}
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
	
	public function insert_user_offline_loc($page_type)
	{
		$items = "";
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$user_session 	= $_GET['user_session'];
			$user_altercode = $_GET['user_altercode'];
			$firebase_token = $_GET['firebase_token'];
			$qry		    = $_GET['qry'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$user_session 	= $_POST['user_session'];
			$user_altercode = $_POST['user_altercode'];
			$firebase_token = $_POST['firebase_token'];
		    $qry		    = $_POST['qry'];
		}
		$row	= str_replace("'",'"',$qry);
		
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1 && !empty($user_session))
		{
		    if ($row != '') {
				$row = substr($row, 0, -1);
				$row = "[$row]";
			}
		    $row = json_decode($row);
            foreach($row as $r){
                $latitude   = $r->latitude;
                $longitude  = $r->longitude;
                $loc_id     = $r->loc_id;
                $gettime    = $r->gettime;
                $getdate    = $r->getdate;
                $q = $this->db->query("select id from tbl_rider_loc where loc_id='$loc_id'")->row();
				if (empty($q->id)) {
                    $this->db->query("insert into tbl_rider_loc set latitude='$latitude',longitude='$longitude',loc_id='$loc_id',user_altercode='$user_altercode',gettime='$gettime',getdate='$getdate'");
				}
            }
            
			$time = time();
			$date = date("Y-m-d",$time);
			$datetime = time();
			$timei = date("i",$time);
			if ($timei % 4 == 0) 
			{
				$time = date("H:i", $time);
			}
			$done = "yes";
$items .= <<<EOD
{"done":"{$done}"},
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