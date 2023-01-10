<?php
header('Content-Type: application/json');
defined('BASEPATH') OR exit('No direct script access allowed');
class Chemist_order extends CI_Controller
{
	public function get_temp_rec($chemist_id)
	{
		$user_altercode = $this->session->userdata('user_altercode');
		$user_type 		= $this->session->userdata('user_type');
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
		$user_type 		= $this->session->userdata('user_type');
		$user_altercode	= $this->session->userdata('user_altercode');
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
		$selesman_id = "";
		if($user_type=="sales")
		{
			$selesman_id = $user_altercode;
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
			$where = array('chemist_id'=>$chemist_id,'selesman_id'=>$selesman_id,'user_type'=>$user_type,'i_code'=>$i_code,'status'=>'0');
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
					'selesman_id'=>$selesman_id,
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
	
	public function add_low_stock_alert()
	{	
		$user_type 		= $this->session->userdata('user_type');
		$user_altercode	= $this->session->userdata('user_altercode');
		$i_code 		= $_POST['i_code'];
		
		$selesman_id = "";
		if($user_type=="sales")
		{
			$selesman_id = $user_altercode;
		}
		else
		{
			$chemist_id  = $user_altercode;
		}

		$date 			= date('Y-m-d');
		$time 			= time();
		if($user_type=="sales")
		{
			$where = array('altercode'=>$chemist_id,);
			$qr = $this->Scheme_Model->select_row("tbl_acm",$where);

			$title 			= ucwords(strtolower($qr->name));
			$chemist_name 	= "$title - ($chemist_id)";	
			$acm_email 		= $qr->email;

			$where = array('customer_code'=>$selesman_id,);
			$qr = $this->Scheme_Model->select_row("tbl_users",$where);
			
			$name 			= ucwords(strtolower($qr->firstname." ".$qr->lastname));
			$salesman_name 	= "$name - ($qr->customer_code)";
		}
		if($user_type=="chemist")
		{			
			$where = array('altercode'=>$chemist_id,);
			$qr = $this->Scheme_Model->select_row("tbl_acm",$where);

			$title 			= ucwords(strtolower($qr->name));
			$chemist_name 	= "$title - ($qr->altercode)";
			$acm_email 		= $qr->email;
		}
		
		$where = array('i_code'=>$i_code);
		$row = $this->Scheme_Model->select_row("tbl_medicine",$where);
		if(!empty($row->item_name))
		{
			$item_name = $row->item_name;
			$item_code = $row->item_code;
			
			$where1 = array('i_code'=>$i_code,'date'=>$date,);
			$row1 = $this->Scheme_Model->select_row("tbl_low_stock_alert",$where1);
			if(empty($row1->i_code))
			{
				$dt = array(
				'user_type'=>$user_type,
				'chemist_id'=>$chemist_id,
				'selesman_id'=>$selesman_id,
				'i_code'=>$i_code,
				'item_name'=>$item_name,
				'item_code'=>$item_code,
				'date'=>$date,
				'time'=>$time,
				);
				$query = $this->Scheme_Model->insert_fun("tbl_low_stock_alert",$dt);
			}
		}
		
		$subject  = "DRD Low Stock || $title";
		$message  = "Hi $title,<br><br> One of the customer tried to order a Medicine which is currently out of stock <br><br>";
		$message .= "Item Name : ".$item_name."<br>";
		$message .= "Item Code : ".$item_code."<br>";
		$message .= "Chemist Name : ".$chemist_name."<br>";
		if($salesman_name)
		{
			$message .= "Salesman Name : ".$salesman_name."<br>";
		}
		$message .= "<br>Please arrange a callback for the customer to place this order.";
		$message .="<br><br>Thanks<br>D R Distributors Private Limited<br><br>";
		
		/**********************************************************/
		
		if(!empty($query))
		{
			$subject = base64_encode($subject);
			$message = base64_encode($message);
			$email_function = "low_stock_alert";
			$mail_server = "";
			
			$row = $this->db->query("select * from tbl_email where email_function='$email_function'")->row();
			$user_email_id = $row->email;

			$dt = array(
			'user_email_id'=>$user_email_id,
			'subject'=>$subject,
			'message'=>$message,
			'email_function'=>$email_function,
			'mail_server'=>$mail_server,
			);
			$this->Scheme_Model->insert_fun("tbl_email_send",$dt);
		}
	}
	
	public function count_temp_rec()
	{
		//error_reporting(0);
		
		$user_type	 	= $this->session->userdata('user_type');
		$user_altercode	= $this->session->userdata('user_altercode');
		$chemist_id		= $_POST["chemist_id"];
		
		$count = 0;
		if($user_type=="sales")
		{
			$selesman_id 	= $user_altercode;
			
			if(empty($chemist_id))
			{
				$row = $this->db->query("select count(distinct temp_rec) as total from drd_temp_rec where selesman_id='$selesman_id' and status='0' order by chemist_id asc")->row();
				if(!empty($row->total))
				{
					$count = $row->total;
				}
			} else {
				$row = $this->db->query("select count(chemist_id) as total from drd_temp_rec where chemist_id='$chemist_id' and selesman_id='$selesman_id' and status='0' order by chemist_id asc")->row();
				if(!empty($row->total))
				{
					$count = $row->total;
				}
			}
		}
		else
		{
			$selesman_id 	= "0";
			$chemist_id 	= $user_altercode;
			
			$row = $this->db->query("select count(chemist_id) as total from drd_temp_rec where chemist_id='$chemist_id' and selesman_id='' and status='0' order by chemist_id asc")->row();
			if(!empty($row->total))
			{
				$count = $row->total;
			}
		}
		echo $count;
	}
	
	public function medicine_cart_list_api()
    {
        //error_reporting(0);
		$items = "";
		$i = 1;
		$chemist_id 	= $_REQUEST['chemist_id'];		
		$user_type 		= $this->session->userdata('user_type');
		$user_altercode	= $this->session->userdata('user_altercode');
		
		$temp_rec = $this->get_temp_rec($chemist_id);
		if($user_type=="sales")
		{
			$selesman_id 	= $user_altercode;
			$where = array('temp_rec'=>$temp_rec,'selesman_id'=>$selesman_id,'status'=>'0');
			$query = $this->Scheme_Model->select_all_result("drd_temp_rec",$where,'excel_number','asc');
		}
		else
		{
			$selesman_id 	= "";
			$chemist_id 	= $user_altercode;
			$where = array('temp_rec'=>$temp_rec,'chemist_id'=>$chemist_id,'status'=>'0');
			$query = $this->Scheme_Model->select_all_result("drd_temp_rec",$where,'excel_number','asc');
		}		
        foreach($query as $row)
        {
			$i++;
			$id 			= ($row->id);
			$i_code 		= ($row->i_code);
			
			$item_name 		= ucwords(strtolower($row->item_name));
			$company_full_name= ucwords(strtolower($row->company_full_name));
			$packing 		= ($row->packing);
			$packing 		= str_replace('"',"'",$packing);
			$expiry 		= ($row->expiry);
			$image 			= ($row->image);
			$quantity 		= ($row->quantity);
			$sale_rate 		= ($row->sale_rate);
			$scheme 		= ($row->scheme);
			$modalnumber 	= ($row->modalnumber);
			$datetime 		= ($row->datetime);
			$finalpay 		= base64_encode(number_format($row->quantity * $row->sale_rate,2));
			
$items.= <<<EOD
{"id":"{$id}","i_code":"{$i_code}","item_name":"{$item_name}","company_full_name":"{$company_full_name}","packing":"{$packing}","expiry":"{$expiry}","image":"{$image}","quantity":"{$quantity}","sale_rate":"{$sale_rate}","scheme":"{$scheme}","finalpay":"{$finalpay}","modalnumber":"{$modalnumber}","datetime":"{$datetime}"},
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
		$user_type 		= $this->session->userdata('user_type');
		$user_altercode	= $this->session->userdata('user_altercode');
		
		$chemist_id	= $_REQUEST["chemist_id"];
		$i_code		= $_REQUEST["i_code"];
		
		$selesman_id = "";
		if($user_type=="sales")
		{
			$selesman_id = $user_altercode;
		}
		else
		{
			$chemist_id  = $user_altercode;
		}
		
		$quantity = "";
		$where = array('chemist_id'=>$chemist_id,'selesman_id'=>$selesman_id,'user_type'=>$user_type,'i_code'=>$i_code,'status'=>'0');
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
	
	public function user_top_order(){
		//error_reporting(0);
		$items = "";
		$user_type 		= $this->session->userdata('user_type');
		$user_altercode	= $this->session->userdata('user_altercode');
		
		$result = $this->db->query("select DISTINCT item_name,id,i_code,quantity, COUNT(*) as ct FROM tbl_order where chemist_id='$user_altercode' and user_type='$user_type' GROUP BY item_name HAVING COUNT(*) > 0 order by ct asc limit 10")->result();
		foreach($result as $row)
		{
			$id 			= ($row->id);
			$i_code 		= ($row->i_code);
			$item_name 		= ucwords(strtolower($row->item_name));
			$quantity 		= ($row->quantity);
			
$items.= <<<EOD
{"id":"{$id}","i_code":"{$i_code}","item_name":"{$item_name}","quantity":"{$quantity}"},
EOD;
        }
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}<?php
    }
	
	public function view_cart_or_empty_cart_btn()
	{
		//error_reporting(0);
		$items = 0;
		$rs = 0;
		
		$chemist_id		= $chemist_id1 = $_REQUEST['chemist_id'];		
		$user_altercode	= $this->session->userdata('user_altercode');
		$user_type 		= $this->session->userdata('user_type');
		
		$temp_rec = $this->get_temp_rec($chemist_id);
		if($user_type=="sales")
		{
			$selesman_id 	= $user_altercode;
			$query = $this->db->query("select * from drd_temp_rec where temp_rec='$temp_rec' and status='0' and selesman_id='$selesman_id' order by id desc")->result();
		}
		else
		{
			$selesman_id 	= "";
			$chemist_id 	= $user_altercode;
			$query = $this->db->query("select * from drd_temp_rec where temp_rec='$temp_rec' and status='0' and chemist_id='$chemist_id' order by id desc")->result();
		}
        foreach($query as $y)
        {
            $rs = $rs + $y->quantity * $y->sale_rate;
            $items++;
        }
		if($items==0)
		{
			?>
			<div class="container">
				<div class="row">
					<div class="col-5 text-center">				
						<div class="SearchMedicine_items"><?= $items ?> items</div>
						<div class="SearchMedicine_rs"><i class="fa fa-inr"></i><?= number_format($rs,2) ?></div>
					</div>
					<div class="col-7 text-center">
						<i class="fa fa-circle-o-notch fa-spin" style="font-size:24px;display:none" id="order_loading"></i><button class="btn btn-primary btn-block site_main_btn31" onclick="cart_empty_btn()" tabindex="-3" title="Cart Is Empty">Cart is empty</button>
					</div>
				</div>
			</div>
			<?php
		}
		else
		{
			?>
			<div class="container">
				<div class="row">
					<div class="col-5 text-center">				
						<div class="SearchMedicine_items"><?= $items ?> items</div>
						<div class="SearchMedicine_rs"><i class="fa fa-inr"></i> <?= number_format($rs,2) ?>/-</div>
					</div>
					<div class="col-7 text-center">
						<i class="fa fa-circle-o-notch fa-spin" style="font-size:24px;display:none" id="order_loading"></i><button class="btn btn-primary btn-block site_main_btn31" onclick="view_cart_btn()" tabindex="-3" title="View cart">View cart</button>
					</div>
				</div>
			</div>
			<?php
		}
	}
	
	public function place_order_or_empty_cart_btn()
	{
		//error_reporting(0);
		$items = 0;
		$rs = 0;
		
		$chemist_id		= $_REQUEST['chemist_id'];		
		$user_altercode	= $this->session->userdata('user_altercode');
		$user_type 		= $this->session->userdata('user_type');
		
		$temp_rec = $this->get_temp_rec($chemist_id);
		if($user_type=="sales")
		{
			$selesman_id 	= $user_altercode;			
			$where = array('temp_rec'=>$temp_rec,'selesman_id'=>$selesman_id,'status'=>'0');
			$query = $this->Scheme_Model->select_all_result("drd_temp_rec",$where);
		}
		else
		{
			$selesman_id 	= "";
			$chemist_id 	= $user_altercode;
			$where = array('temp_rec'=>$temp_rec,'chemist_id'=>$chemist_id,'status'=>'0');
			$query = $this->Scheme_Model->select_all_result("drd_temp_rec",$where);
		}
        foreach($query as $y)
        {
            $rs = $rs + $y->quantity * $y->sale_rate;
            $items++;
        }
		?>
		<script>
		$(".mycartwalidiv_price").html('<i class="fa fa-inr"></i><?= number_format($rs,2) ?>/-');
		</script>
		<?php
		if($items==0)
		{
			?>
			<div class="container">
				<div class="row">
					<div class="col-5 text-center">				
						<div class="SearchMedicine_items"><?= $items ?> items</div>
						<div class="SearchMedicine_rs"><i class="fa fa-inr"></i><?= number_format($rs,2) ?>/-</div>
					</div>
					<div class="col-7 text-center">
						<i class="fa fa-circle-o-notch fa-spin" style="font-size:24px;display:none" id="order_loading"></i><button class="btn btn-primary btn-block site_main_btn31" onclick="cart_empty_btn()" tabindex="-3">Cart is empty</button>
					</div>
				</div>
			</div>
			<?php
		}
		else
		{
			//iss query say button visble or disble hota ha plceorder ka
			$place_order_btn = $this->Order_Model->get_total_price_of_order($selesman_id,$chemist_id,$user_type,$_SESSION['user_password']);
			?>
			<div class="container">
				<div class="row">
					<?php
		                if($place_order_btn[0]==0)
		                {
			                ?>
							<div class="col-12 text-center">	
								<strong style="color:red">
								<?= $place_order_btn[1] ?>
								</strong>
							</div>
							<?php
						}
					?>
					<div class="col-5 text-center">				
						<div class="SearchMedicine_items"><?= $items ?> items</div>
						<div class="SearchMedicine_rs"><em class="fa fa-inr"></em><?= number_format($rs,2) ?>/-</div>
					</div>
					<div class="col-7 text-center">
						<?php
		                if($place_order_btn[0]==0)
		                {
			                ?>
							<em class="fa fa-circle-o-notch fa-spin" style="font-size:24px;display:none" id="order_loading"></em><button class="btn btn-block site_main_btn31_disabled" tabindex="-3" title="Can't place order">Can't place order</button>
							<?php
		                } 
						if($place_order_btn[0]!=0)
		                {
						?>
						<em class="fa fa-circle-o-notch fa-spin" style="font-size:24px;display:none" id="order_loading"></em><button class="btn btn-primary btn-block site_main_btn31" onclick="place_order_model()" tabindex="-3" title="Place order">Place order</button>
						<?php } ?>
					</div>
				</div>
			</div>
			<?php
		}
	}

	public function save_order_to_server()
	{		
		error_reporting(0);
		$items = "";
		$slice_type		= $_REQUEST["slice_type"];
		$slice_item		= $_REQUEST["slice_item"];
		$chemist_id		= $_REQUEST["chemist_id"];
		$remarks 		= $_REQUEST["remarks"];
		$user_altercode = $this->session->userdata('user_altercode');
		$user_type 		= $this->session->userdata('user_type');
		
		$selesman_id = "";
		if($user_type=="sales")
		{
			$selesman_id = $user_altercode;
		}
		else
		{
			$chemist_id  = $user_altercode;
		}		

		$status = $this->Order_Model->save_order_to_server("pc_mobile",$slice_type,$slice_item,$remarks,$selesman_id,$chemist_id,$user_type,$_SESSION["user_password"]);
		$order_success = $status[0];
		$place_order_message = base64_encode($status[1]);
		$device_id = "";
		
$items .= <<<EOD
{"order_success":"{$order_success}","device_id":"{$device_id}","chemist_id":"{$chemist_id}","selesman_id":"{$selesman_id}","user_type":"{$user_type}","place_order_message":"{$place_order_message}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}<?php
	}

	public function delete_medicine()
	{
		//error_reporting(0);
		$items = "";
		$id = $_REQUEST["id"];
		$response = $this->db->query("delete from drd_temp_rec where id='$id'");

$items.= <<<EOD
{"response":"{$response}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}<?php
	}
	
	public function delete_all_medicine()
	{
		//error_reporting(0);
		$items = "";
		$chemist_id = $_POST["chemist_id"];
		$temp_rec = $this->get_temp_rec($chemist_id);
		$response = $this->db->query("delete from drd_temp_rec where temp_rec='$temp_rec' and status='0'");

$items.= <<<EOD
{"response":"{$response}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}<?php
	}
}
?>