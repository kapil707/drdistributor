<?php
ini_set('memory_limit','-1');
ini_set('post_max_size','100M');
ini_set('upload_max_filesize','100M');
ini_set('max_execution_time',36000);
defined('BASEPATH') OR exit('No direct script access allowed');
class Import_order extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//error_reporting(0);
		if($_COOKIE['user_session']==""){
			redirect(base_url()."user/login");			
		}
		$under_construction = $this->Scheme_Model->get_website_data("under_construction");
		if($under_construction=="1")
		{
			redirect(base_url()."under_construction");
		}
	}
	
	public function index()
	{
		////error_reporting(0);
		
		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		//$data["chemist_id"] = $_COOKIE['user_altercode'];
		
		$data["main_page_title"] = "Upload order";
		$user_altercode	= $_COOKIE['user_altercode'];
		$user_type		= $_COOKIE['user_type'];
		$chemist_id		= $_COOKIE['chemist_id'];

		$data["chemist_id"] = $chemist_id;

		if(!empty($user_type))
		{
			if($user_type=="sales")
			{
				$data["session_user_fname"]  = "Code : ".$chemist_id." | <a href='".base_url()."home/select_chemist'> <img src='".base_url()."/img_v".constant('site_v')."/edit_icon_w.png' width='12px;' style='margin-top: 2px;margin-bottom: 2px;'></a>";
			}

			$salesman_id = "";
			if($user_type=="sales")
			{
				$salesman_id 	= $user_altercode;
				$user_altercode = $chemist_id;
			}
		}
		
		$where = array('user_altercode'=>$user_altercode);
		$row = $this->Scheme_Model->select_row("drd_excel_file",$where);
		$data["headername"] = $data["itemname"] = $data["itemqty"] = $data["itemmrp"] 	= "";
		if(!empty($row->headername))
		{
			$data["headername"] = $row->headername;
			$data["itemname"] 	= $row->itemname;
			$data["itemqty"] 	= $row->itemqty;
			$data["itemmrp"] 	= $row->itemmrp;
		}
		$data["chemist_id"] = $chemist_id;
		
		$this->load->view('home/header', $data);
		$this->load->view('import_order/index', $data);
	}
	
	public function select_chemist(){
		$chemist_id		= $_COOKIE['chemist_id'];
		if(empty($chemist_id))
		{
			redirect(base_url()."home/select_chemist");
		}
		else{
			redirect(base_url()."import_order");
		}
	}
	
	public function medicine_suggest(){
		////error_reporting(0);
		
		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		$data["main_page_title"] = "Suggest medicine";

		$user_altercode	= $_COOKIE['user_altercode'];
		$user_type		= $_COOKIE['user_type'];
		$chemist_id		= $_COOKIE['chemist_id'];

		$data["chemist_id"] = $chemist_id;

		if(!empty($user_type))
		{
			if($user_type=="sales")
			{
				$data["session_user_fname"]  = "Code : ".$chemist_id." | <a href='".base_url()."home/select_chemist'> <img src='".base_url()."/img_v".constant('site_v')."/edit_icon_w.png' width='12px;' style='margin-top: 2px;margin-bottom: 2px;'></a>";
			}

			$salesman_id = "";
			if($user_type=="sales")
			{
				$salesman_id 	= $user_altercode;
				$user_altercode = $chemist_id;
			}
		}

		$this->load->view('home/header',$data);
		$this->load->view('import_order/medicine_suggest', $data);
		$this->load->view('home/footer', $data);
	}
	
	public function medicine_search($order_id='')
	{
		////error_reporting(0);
		
		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		//$data["chemist_id"] = $_COOKIE['user_altercode'];
		
		$data["main_page_title"] = "Upload order";
		
		$user_altercode	= $_COOKIE['user_altercode'];
		$user_type		= $_COOKIE['user_type'];
		$chemist_id		= $_COOKIE['chemist_id'];

		$data["chemist_id"] = $chemist_id;

		if(!empty($user_type))
		{
			if($user_type=="sales")
			{
				$data["session_user_fname"]  = "Code : ".$chemist_id." | <a href='".base_url()."home/select_chemist'> <img src='".base_url()."/img_v".constant('site_v')."/edit_icon_w.png' width='12px;' style='margin-top: 2px;margin-bottom: 2px;'></a>";
			}

			$salesman_id = "";
			if($user_type=="sales")
			{
				$salesman_id 	= $user_altercode;
				$user_altercode = $chemist_id;
			}
		}
		$data["order_id"]	= $order_id = base64_decode($order_id);
		$data["myname"] 	= $user_altercode;

		$where = array('order_id'=>$order_id,'status'=>'0');
		$result = $this->Scheme_Model->select_all_result("drd_import_file",$where,"id","asc");
		$data["result"] 	= $result;
		if(empty($result))
		{
			redirect(base_url()."import_order");
		}

		$data["import_order_page"] = "yes";
		$this->load->view('home/header', $data);
		$this->load->view('import_order/medicine_search', $data);
		$this->load->view('home/footer', $data);
	}
	
	public function medicine_deleted_items($order_id='')
	{
		////error_reporting(0);
		
		$data["session_user_image"] 	= $_COOKIE['user_image'];
		$data["session_user_fname"]     = $_COOKIE['user_fname'];
		$data["session_user_altercode"] = $_COOKIE['user_altercode'];
		
		$data["main_page_title"] = "Deleted items";
		
		$user_altercode	= $_COOKIE['user_altercode'];
		$user_type		= $_COOKIE['user_type'];
		$chemist_id		= $_COOKIE['chemist_id'];

		$data["chemist_id"] = $chemist_id;

		if(!empty($user_type))
		{
			if($user_type=="sales")
			{
				$data["session_user_fname"]  = "Code : ".$chemist_id." | <a href='".base_url()."home/select_chemist'> <img src='".base_url()."/img_v".constant('site_v')."/edit_icon_w.png' width='12px;' style='margin-top: 2px;margin-bottom: 2px;'></a>";
			}

			$salesman_id = "";
			if($user_type=="sales")
			{
				$salesman_id 	= $user_altercode;
				$user_altercode = $chemist_id;
			}
		}
		$data["order_id"]	= $order_id = base64_decode($order_id);
		
		/*****************************************/
		if($user_type=="chemist")
		{
			$users = $this->db->query("select * from tbl_acm where altercode='$chemist_id' ")->row();
			$acm_altercode 	= $users->altercode;
			$acm_name		= $users->name;
			$acm_email 		= $users->email;
			$acm_mobile 	= $users->mobile;			
			
			$chemist_excle 	= "$acm_name ($acm_altercode)";
			$file_name 		= $acm_altercode;
		}
		if($user_type=="sales")
		{
			//jab sale man say login hota ha to
			$users = $this->db->query("select * from tbl_acm where altercode='$user_altercode' ")->row();
			$user_session	= $users->id;
			$acm_altercode 	= $users->altercode;
			$acm_name 		= $users->name;
			$acm_email 		= $users->email;
			$acm_mobile 	= $users->mobile;

			$users = $this->db->query("select * from tbl_users where customer_code='$salesman_id' ")->row();
			$salesman_name 		= $users->firstname." ".$users->lastname;
			$salesman_mobile	= $users->cust_mobile;
			$salesman_altercode	= $users->customer_code;
			
			$chemist_excle 	= $acm_name." ($acm_altercode)";
			$file_name 		= $acm_altercode;
		}
		/***********************************************/
		$result = $this->db->query("select * from drd_import_file where order_id='$order_id' and status=0")->result();
		$data["result"]	= $result;
		if(empty($result))
		{
			redirect(base_url()."home/my_cart");
		}
		
		$i = 0;
		foreach($result as $row)
		{
			$i++;
			$item_name = $row->item_name;
			$mrp = $row->mrp;
			$quantity = $row->quantity;
			
			$dt1 = "<br><table border='1' width='100%'><tr><td>Sno</td><td>Deleted Item Name</td><td>Deleted Item Mrp.</td><td>Deleted Item Quantity</td></tr>";

			$dt.= "<tr><td>".$i."</td><td>".$item_name."</td><td>".$mrp."</td><td>".$quantity."</td></tr>";
			$dt2.= "</table>";
		}
		
		$message = $dt1.$dt.$dt2;
		$subject   = "Import order delete items from D.R. Distributors Pvt. Ltd.";
		
		$user_email_id = $acm_email;
		if (filter_var($user_email_id, FILTER_VALIDATE_EMAIL)) {
		
		}
		else{
			$err = $user_email_id." is Wrong Email";
			$mobile = "";
			$this->Message_Model->tbl_whatsapp_email_fail($mobile,$err,$acm_altercode);
			
			$user_email_id="";
		}
		
		if($user_email_id!="")
		{
			$file_name_1 = "Import-Order-Deleted-Items-Report.xls";
			$file_name1  = $this->import_orders_delete_items($result);
			
			$subject = ($subject);
			$message = ($message);
			$email_function = "import_orders_delete_items";
			$mail_server = "";

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
			'date'=>$date,
			'time'=>$time,
			);
			$this->Scheme_Model->insert_fun("tbl_email_send",$dt);				
		}
		
		$this->load->view('home/header', $data);
		$this->load->view('import_order/medicine_deleted_items', $data);
		$this->load->view('home/footer', $data);
	}
	
	public function import_orders_delete_items($query)
	{
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		//error_reporting(0);
		ob_clean();		

		date_default_timezone_set('Asia/Calcutta');
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', 'Sno')
		->setCellValue('B1', 'Item Name')
		->setCellValue('C1', 'Item Mrp.')
		->setCellValue('D1', 'Item Quantity');		

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);	

		$i = 0;
		$rowCount = 2;
		foreach($query as $row)
		{
			$i++;			
			$item_name = $row->item_name;
			$mrp = $row->mrp;
			$quantity = $row->quantity;
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,$i);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,$item_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,$mrp);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,$quantity);
			$rowCount++;
		}
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
		$file_name = "temp_files/import_orders_delete_items_".time().".xls";
		$objWriter->save($file_name);
		return $file_name;
	}
	
	public function downloadfile($order_id='')
	{	
		$order_id = base64_decode($order_id);
		$result = $this->db->query("select * from drd_import_file where order_id='$order_id' and status=0")->result();
		
		$delimiter = ",";
		$filename = "download.csv";
		$i = 0;
		$f = fopen('php://memory', 'w');
		$fields = array('ID', 'Name','Mrp', 'Qty');
		fputcsv($f, $fields, $delimiter);
		foreach($result as $row)
		{
			$i++;
			$lineData = array($i, $row->item_name,$row->mrp,$row->quantity);
			fputcsv($f, $lineData, $delimiter);
		}
		fseek($f, 0);
		
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="' . $filename . '";');
		
		fpassthru($f);
		exit;
	}
	
	public function import_order_downloadall($order_id='')
	{	
		
		$result = $this->db->query("select * from drd_import_file where order_id='$order_id' and status='0'")->result();
		
		$delimiter = ",";
		$filename = "download.csv";
		$i = 0;
		$f = fopen('php://memory', 'w');
		$fields = array('ID', 'Name', 'Qty');
		fputcsv($f, $fields, $delimiter);
		foreach($result as $row)
		{
			$i++;
			$lineData = array($i, $row->item_name, $row->quantity);
			fputcsv($f, $lineData, $delimiter);
		}
		fseek($f, 0);
		
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="' . $filename . '";');
		
		fpassthru($f);
		exit;
	}
	
	
	/**********************************************/

	
	
	public function upload_import_file(){
		
		header('Content-Type: application/json');
		$items = "";
		$headername	= strtoupper($_GET['headername']);
		$itemname 	= strtoupper($_GET['itemname']);
		
		$itemqty 	= strtoupper($_GET['itemqty']);
		$itemqty    = str_replace(",","",$itemqty);
		$itemqty    = str_replace(".","",$itemqty);

		$itemmrp 	= strtoupper($_GET['itemmrp']);
		$itemmrp    = str_replace(",","",$itemmrp);
		$itemmrp    = str_replace(".","",$itemmrp);

		$user_type		= $_COOKIE['user_type'];
		$user_altercode	= $_COOKIE['user_altercode'];
		$user_password	= $_COOKIE['user_password'];
		$chemist_id		= $_COOKIE['chemist_id'];

		$salesman_id = "";
		if($user_type=="sales")
		{
			$salesman_id 	= $user_altercode;
			$user_altercode = $chemist_id;
		}
		
		$where = array('user_altercode'=>$user_altercode);
		$row = $this->Scheme_Model->select_row("drd_excel_file",$where);
		if(empty($row->id))
		{
			$this->db->query("insert into drd_excel_file set headername='$headername',itemname='$itemname',itemqty='$itemqty',itemmrp='$itemmrp',user_altercode='$user_altercode'");
		}
		else
		{
			$this->db->query("update drd_excel_file set headername='$headername',itemname='$itemname',itemqty='$itemqty',itemmrp='$itemmrp' where user_altercode='$user_altercode'");
		}
		
		$filename = time().$_FILES['file']['name'];
		$uploadedfile = $_FILES['file']['tmp_name'];
		$upload_path = "./temp_files/";
		if(move_uploaded_file($uploadedfile, $upload_path.$filename))
		{
			/*****************************/
			$row = $this->db->query("select order_id from drd_import_file order by id desc limit 1")->row();
			$order_id = 1;
			if(!empty($row->order_id))
			{
				$order_id = $row->order_id + 1;
			}
			/*****************************/
			
			$excelFile = $upload_path.$filename;
			if(file_exists($excelFile))
			{
				$this->load->library('excel');
				$objPHPExcel = PHPExcel_IOFactory::load($excelFile);
				foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
				{
					$highestRow = $worksheet->getHighestRow();
					for ($row=$headername; $row<=$highestRow; $row++)
					{
						$item_name 	= $worksheet->getCell($itemname.$row)->getValue();
						if($item_name!="")
						{
							$quantity 	= $worksheet->getCell($itemqty.$row)->getValue();
							$mrp 		= $worksheet->getCell($itemmrp.$row)->getValue();
							
							if($quantity=="")
                            {
                              	$quantity = 1;
                            }

							if($quantity==0)
                            {
                              	$quantity = 1;
                            }

							$quantity = intval($quantity);
							if($quantity>=1000)
							{
								$quantity = 1000;
							}
                          
                          	if($mrp=="")
                            {
                              	$mrp = "";
                            }
							
							$dt = array(
							'item_name'=>$item_name,
							'quantity'=>$quantity,
							'mrp'=>$mrp,
							'order_id'=>$order_id,
							);
							$this->Scheme_Model->insert_fun("drd_import_file",$dt);
						}
					}
				}
				unlink($excelFile);
			}
			$order_id  = base64_encode($order_id);
			$url = base_url()."import_order/medicine_search/$order_id";
		}
		else{
			$url = base_url()."import_order";
		}
$items.= <<<EOD
{"url":"{$url}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}<?php
	}
	
	function clean($string) {
		$string = str_replace('(', '', $string);
		$string = str_replace(')', '', $string);
		$string = str_replace('*', '', $string);
		$string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.
		$string = str_replace('-', '', $string); // Replaces all spaces with hyphens.
		return preg_replace('/[^A-Za-z0-9\#]/', '', $string); // Removes special chars.
	}
	
	function clean1($string) {
		$string = str_replace('"', "'", $string);
		$string = str_replace('\'', '', $string);
		return $string;
	}
	
	function clean2($string) {
		// remove 29-11-19 check kiya ha no need for search panel
		/*$string = str_replace('-', ' ', $string);
		$string = str_replace('(', ' ', $string);
		$string = str_replace(')', ' ', $string);
		$string = str_replace('*', ' ', $string);// Replaces all spaces with hyphens.*/
		return $string; // Removes 
		return preg_replace('/[^A-Za-z0-9\#]/', ' ', $string); // Removes special chars.
	}
	
	function clean3($string) {
		$string = str_replace('-', ' ', $string);
		$string = str_replace('(', ' ', $string);
		$string = str_replace(')', ' ', $string);
		$string = str_replace('*', ' ', $string);
		return preg_replace('/[^A-Za-z0-9\#]/', ' ', $string);
	}
	
	public function get_temp_rec($chemist_id)
	{
		$user_altercode = $_COOKIE['user_altercode'];
		$user_type 		= $_COOKIE['user_type'];
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
	
	
	
	function highlightWords($string, $search){
		$string = strtoupper($this->clean2($string));
		$search = strtoupper($search);
		$myArray = explode(' ', $search);
		foreach($myArray as $raman)
		{
			if (strpos($string, $raman) !== false) 
			{
				$string = str_replace($raman,"<b>".$raman."</b>",$string);
			}
		}
		return $string;
	}
	
	
	public function insert_main_row_data()
	{		
		$excel_number	= $_POST["row_id"];
		
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

		$row = $this->db->query("select * from drd_import_file where id='$excel_number'")->row();

		$order_id			= $row->order_id;
		$order_quantity		= $row->quantity;
		$item_mrp 			= $row->mrp;
		$order_item_name	= $this->clean1($row->item_name);
		
		/******************************************/
		$suggest_i_code = "";
		$suggest = 0;

		$row_s = $this->db->query("select * from drd_import_orders_suggest where your_item_name='$order_item_name' order by id desc")->row();
		if(!empty($row_s->id))
		{
			$suggest = 1;
			$order_item_name	= $row_s->item_name;
			$suggest_i_code 	= $row_s->i_code;
			$suggest_altercode 	= $row_s->user_altercode;
		}
		$type_ = 1;
		if(!empty($suggest_i_code))
		{
			$type_ = "1";
			$i_code = $suggest_i_code;
			$where = array('i_code'=>$i_code);
		}
		else{			
			/******************************************/
			$items=$this->Chemist_Model->import_order_dropdownbox($order_item_name,$item_mrp);
			/*****************************************/		
			$type_ = $items["type"];
			$i_code = $items["i_code"];
			$where = array('i_code'=>$i_code);
		}
		
		$this->db->select("*");
		$this->db->where($where);
		$this->db->limit(1);
		$this->db->order_by('item_name','asc');
		$row = $this->db->get("tbl_medicine")->row();
		$image1 = constant('img_url_site')."uploads/default_img.jpg";
		
		$selected_item_name = $selected_packing = $selected_batchqty = $selected_scheme = $selected_company_full_name = $selected_batch_no = $selected_expiry = "";
		$selected_batchqty = $selected_mrp = $selected_ptr = $selected_price = 0;
		$item_code = "";
		$return_status = 0;
		if(!empty($row)) {
			if(!empty($row->image1))
			{
				$image1 = constant('img_url_site').$row->image1;
			}
			$selected_mrp	=	$row->mrp;
			$selected_ptr	=	$row->sale_rate;
			$selected_price	=	$row->final_price;
			
			$selected_item_name = ucwords(strtolower($row->item_name));
			$selected_packing = $row->packing;
			$selected_expiry = $row->expiry;
			$selected_company_full_name = ucwords(strtolower($row->company_full_name));
			$selected_batch_no = $row->batch_no;
			$selected_batchqty = $row->batchqty;
			$selected_scheme = $row->salescm1."+".$row->salescm2;
			
			$selected_mrp = number_format($selected_mrp,2);
			$selected_ptr = number_format($selected_ptr,2);
			$selected_price = number_format($selected_price,2);
			
			/******************************************/
			if($row->batchqty!=0  && is_numeric($order_quantity)){

				$item_code = $row->i_code;
				$return_status = $this->add_excelFile_temp_tbl($item_code,$order_quantity,$excel_number,$order_id,$user_type,$user_altercode,$salesman_id);				
			}
			/******************************************/
		}
		?>
		<script>
		$('.selected_SearchAnotherMedicine_<?= $excel_number ?>').show();
		$('.select_product_<?= $excel_number ?>').show();
		</script>
		<?php 
		$selected_msg = "";
		if($type_==1)
		{
			$selected_msg = "Find medicine (By DRD server) |";
			?>
			<style>
			.remove_css_<?= $excel_number ?>{
				background:#13ffb33b !important;
			}
			</style>
			<?php
		}
		if($type_==0)
		{
			$selected_msg = "Find medicine but difference name or mrp. (By DRD server) | ";
			?>
			<style>
			.remove_css_<?= $excel_number ?>{
				background:#1713ff2e !important;
			}
			</style>
			<?php
		}
		
		if($selected_item_name=="")
		{
			$selected_msg = "<span style=color:red>(Not found any medicine)</span> | ";
			?>
			<script>
			$('.select_product_<?= $excel_number ?>').hide();
			//$('.selected_SearchAnotherMedicine_<?= $excel_number ?>').show();
			</script>
			<style>
			.remove_css_<?= $excel_number ?>{
				background:#ffe494 !important;
			}
			</style>
			<?php
		}		
		
		if($selected_batchqty==0)
		{
			$selected_msg.= "<span style=color:red>Out of stock</span> | ";
			?>
			<style>
			.remove_css_<?= $excel_number ?>{
				background:#ffe494 !important;
			}
			</style>
			<?php
		}
		
		if($suggest==1)
		{
			$selected_msg = "Related results found (Suggest set by $suggest_altercode) | ";
			?>
			<style>
			.remove_css_<?= $excel_number ?>{
				background:#97dcd6 !important;
			}
			</style>
			<script>
				$('.selected_suggest_<?= $excel_number ?>').show();
			</script>
			<?php
			
			if($selected_batchqty==0)
			{
				$selected_msg.= " <span style=color:red>Out of stock</span> | ";
				?>
				<style>
				.remove_css_<?= $excel_number ?>{
					background:#ffe494 !important;
				}
				</style>
				<?php
			}
		}
		if($selected_scheme=="0+0")
		{
			?>
			<script>
			$('.selected_scheme_span_<?= $excel_number ?>').hide();
			</script>
			<?php
		}
		?>
		<script> 
		$('.item_qty_<?= $excel_number ?>').focus();		
		$('.chosen-select_<?= $excel_number ?>').chosen({width: "100%"});
		
		$('.selected_msg_<?= $excel_number ?>').html('<?php echo $selected_msg; ?>');
		$('.selected_item_name_<?= $excel_number ?>').html('<?php echo $selected_item_name; ?>');
		$('.image_css_<?= $excel_number ?>').attr("src","<?php echo $image1 ?>");
		$('.selected_packing_<?= $excel_number ?>').html('<?php echo $selected_packing ?>');
		$('.selected_mrp_<?= $excel_number ?>').html('<?php echo $selected_mrp; ?>');
		$('.selected_scheme_<?= $excel_number ?>').html('Scheme : <?php echo $selected_scheme; ?>');
		$('.selected_expiry_<?= $excel_number ?>').html('<b><?php echo $selected_expiry ?></b>');
		$('.selected_sale_rate_<?= $excel_number ?>').html('<?php echo $selected_ptr ?>');
		$('.selected_batchqty_<?= $excel_number ?>').html('<?php echo $selected_batchqty ?>');
		$('.selected_batch_no_<?= $excel_number ?>').html('<?php echo $selected_batch_no ?>');
		$('.selected_final_price_<?= $excel_number ?>').html('<?php echo $selected_price; ?>');
		$('.selected_company_full_name_<?= $excel_number ?>').html('<?php echo $selected_company_full_name; ?>');
		</script>
		<?php
	}
	
	public function expiry_check($expiry)
	{
		$dt = date("y.m.d");
		$time = strtotime($dt);
		$y = date("ym", strtotime("+6 month", $time));
		$expiry1 = substr($expiry,0,2);
		$expiry2 = substr($expiry,3,5);
		$x = $expiry2.$expiry1;
		if($y<=$x)
		{
			$r = 0;
		}
		else
		{
			$r = 1;
		}
		return $r;
	}
	
	public function add_excelFile_temp_tbl($item_code,$item_order_quantity,$excel_number,$order_id,$user_type,$user_altercode,$salesman_id)
	{		
		$return_status = 0;

		$order_type 	= "excelFile";
		$mobilenumber 	= "";
		$modalnumber 	= "PC - Import Order";
		$device_id    	= "";

		if($item_code!="")
		{
			$return_status = $this->Chemist_Model->medicine_add_to_cart_api($user_type,$user_altercode,$salesman_id,$order_type,$item_code,$item_order_quantity,$mobilenumber,$modalnumber,$device_id,$excel_number);

			$this->db->query("update drd_import_file set status='1' where id='$excel_number' and order_id='$order_id'");
		}
		return $return_status;
	}
	
	public function change_order_quantity()
	{
		header('Content-Type: application/json');
		$items = "";
		$row_id 		= $_POST["row_id"];
		$quantity		= $_POST["quantity"];
		
		$response = $this->db->query("update drd_import_file set quantity='$quantity' where id='$row_id'");

$items.= <<<EOD
{"response":"{$response}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}<?php
	}
	
	public function delete_row_medicine()
	{
		//error_reporting(0);
		header('Content-Type: application/json');
		$items = "";
		$row_id	= $_POST["row_id"];
		if($row_id!="")
		{
			$this->db->query("update drd_import_file set status=0 where id='$row_id'");
			$this->db->query("delete from drd_temp_rec where excel_number='$row_id'");
		}
		$response = "1";
$items.= <<<EOD
{"response":"{$response}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}<?php
	}
	
	/*21-01-2020*/
	public function change_medicine_2()
	{
		//error_reporting(0);
		header('Content-Type: application/json');
		$items = "";

		$item_code		= ($_POST["item_code"]);	
		$row_id			= ($_POST["row_id"]);	
		
		$row = $this->db->query("select item_name from tbl_medicine where i_code='$item_code'")->row();
		$item_name = $row->item_name;

		$row1 = $this->db->query("select item_name from drd_import_file where id='$row_id'")->row();
		$your_item_name = $row1->item_name;

		$this->db->query("delete from drd_temp_rec where excel_number='$row_id'");
		
		$this->db->query("delete from drd_import_orders_suggest where your_item_name='$your_item_name'");

		$user_altercode	= $_COOKIE["user_altercode"];
		$date = date('Y-m-d');
		$time = time();
		$datetime = date("d-M-y H:i",$time);
		
		$response = $this->db->query("insert into drd_import_orders_suggest set your_item_name='$your_item_name',item_name='$item_name',i_code='$item_code',user_altercode='$user_altercode',date='$date',time='$time',datetime='$datetime'");

$items.= <<<EOD
{"response":"{$response}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}<?php
	}
	
	public function delete_suggested_medicine()
	{
		//error_reporting(0);
		header('Content-Type: application/json');
		$items = "";

		$user_type 		= $_COOKIE['user_type'];
		$user_altercode	= $_REQUEST["user_altercode"];

		$row_id 		= ($_REQUEST["row_id"]);
		$response 		= 0;

		$row = $this->db->query("select item_name from drd_import_file where id='$row_id'")->row();
		if(!empty($row->item_name))
		{
			$row1 = $this->db->query("select i_code from drd_import_orders_suggest where your_item_name='$row->item_name'")->row();

			$response = $this->db->query("delete from drd_import_orders_suggest where your_item_name='$row->item_name'");

			$salesman_id = "";
			if($user_type=="sales")
			{
				$salesman_id 	= $_COOKIE['user_altercode'];
			}else{
				$user_altercode	= $_COOKIE["user_altercode"];
			}

			$item_code = $row1->i_code;

			$this->db->query("delete from drd_temp_rec where i_code='$item_code' and user_type='$user_type' and salesman_id='$salesman_id' and chemist_id='$user_altercode' and status=0");
		}

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