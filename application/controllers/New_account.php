<?php
ini_set('memory_limit','-1');
ini_set('post_max_size','100M');
ini_set('upload_max_filesize','100M');
ini_set('max_execution_time',36000);
defined('BASEPATH') OR exit('No direct script access allowed');
class New_account extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//error_reporting(0);
		if($this->session->userdata('user_session')==""){
			redirect(base_url()."user/login");			
		}
		$under_construction = $this->Scheme_Model->get_website_data("under_construction");
		if($under_construction=="1")
		{
			redirect(base_url()."under_construction");
		}
	}
	
	public function file1()
	{
		////error_reporting(0);
		
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		//$data["chemist_id"] = $this->session->userdata('user_altercode');
		
		$data["main_page_title"] = "Stock file";		
		
		$this->load->view('home/header', $data);
		$this->load->view('new_account/file1', $data);
	}
	public function upload_file1(){
		//error_reporting(0);

		$this->db->query("TRUNCATE TABLE drd_temp_file1");

		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		ob_clean();		

		date_default_timezone_set('Asia/Calcutta');
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A5', 'Company Name')
		->setCellValue('B5', 'Gst 0%')
		->setCellValue('C5', 'Value')
		->setCellValue('D5', 'Gst 5%')
		->setCellValue('E5', 'Value')
		->setCellValue('F5', 'Gst 12%')
		->setCellValue('G5', 'Value')
		->setCellValue('H5', 'Gst 18%')
		->setCellValue('I5', 'Value')
		->setCellValue('J5', 'Gst 28%')
		->setCellValue('K5', 'Value')
		->setCellValue('L5', 'Total Value')
		->setCellValue('M5', 'Inclusive Tax Total');		

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);

		$items = "";
		$headername	= strtoupper($_GET['headername']);
		$companyname = strtoupper($_GET['companyname']);
		
		$gst0 		= strtoupper($_GET['gst0']);
		$gst5 		= strtoupper($_GET['gst5']);
		$gst12 		= strtoupper($_GET['gst12']);
		$gst18 		= strtoupper($_GET['gst18']);
		$gst28 		= strtoupper($_GET['gst28']);
		$totalvalue = strtoupper($_GET['totalvalue']);
		$add_gst 	= strtoupper($_GET['add_gst']);

		$filename = time().$_FILES['file']['name'];
		$uploadedfile = $_FILES['file']['tmp_name'];
		$upload_path = "./temp_new_account/";
		if(move_uploaded_file($uploadedfile, $upload_path.$filename))
		{			
			$excelFile = $upload_path.$filename;
			if(file_exists($excelFile))
			{
				$this->load->library('excel');
				$objPHPExcel1 = PHPExcel_IOFactory::load($excelFile);
				foreach ($objPHPExcel1->getWorksheetIterator() as $worksheet)
				{
					$rowCount = 5;
					$highestRow = $worksheet->getHighestRow();
					for ($row=$headername; $row<=$highestRow; $row++)
					{
						$companyname_ = $worksheet->getCell($companyname.$row)->getValue();
						$companyname_ = str_replace("."," ",$companyname_);
						if($companyname_!="")
						{
							$gst0_ 		 = $worksheet->getCell($gst0.$row)->getValue();
							$gst5_ 		 = $worksheet->getCell($gst5.$row)->getValue();
							$gst12_ 	 = $worksheet->getCell($gst12.$row)->getValue();
							$gst18_ 	 = $worksheet->getCell($gst18.$row)->getValue();
							$gst28_ 	 = $worksheet->getCell($gst28.$row)->getValue();
							$totalvalue_ = $worksheet->getCell($totalvalue.$row)->getValue();

							$gst0_total  = round($gst0_ * 0 , 2);
							$gst5_total  = round($gst5_ * 1.05 , 2);
							$gst12_total = round($gst12_ * 1.12 , 2);
							$gst18_total = round($gst18_ * 1.18 , 2);
							$gst28_total = round($gst28_ * 1.28 , 2);

							$inclusive_tax_total_ = $gst0_total + $gst5_total + $gst12_total + $gst18_total + $gst28_total;
							if($add_gst==0)
							{
								$inclusive_tax_total_ = $totalvalue_;
							}

							$this->db->query("insert into drd_temp_file1 (companyname,gst0,gst0_total,gst5,gst5_total,gst12,gst12_total,gst18,gst18_total,gst28,gst28_total,totalvalue,inclusive_tax_total) values ('$companyname_','$gst0_','$gst0_total','$gst5_','$gst5_total','$gst12_','$gst12_total','$gst18_','$gst18_total','$gst28_','$gst28_total','$totalvalue_','$inclusive_tax_total_')");

							/*$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,$companyname_);
							$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,$gst0_);
							$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,$gst0_ * 0);
							$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,$gst5_);
							$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,round($gst5_ * 1.05,2));
							$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,$gst12_);
							$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,round($gst12_ * 1.12,2));
							$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,$gst18_);
							$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,round($gst18_ * 1.18,2));
							$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount,$gst28_);
							$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount,round($gst28_ * 1.28,2));
							$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount,$totalvalue_);
							$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount,round($gst0_ * 0,2) + round($gst5_ * 1.05,2) + round($gst12_ * 1.12,2) + round($gst18_ * 1.18,2) + round($gst28_ * 1.28,2));
							$rowCount++;*/
						}
					}
				}
				unlink($excelFile);
			}
		}
		
		/*$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
		$file_name = "temp_new_account/new_items_".time().".xls";
		$objWriter->save($file_name);
		$url = base_url().$file_name;*/



		$url = base_url()."new_account/file2";

		header('Content-Type: application/json');
$items.= <<<EOD
{"url":"{$url}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}<?php
	}

	/**************************************** */
	public function file2()
	{		
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		
		$data["main_page_title"] = "Credit/debit file";		
		
		$this->load->view('home/header', $data);
		$this->load->view('new_account/file2', $data);
	}

	public function upload_file2(){

		$this->db->query("TRUNCATE TABLE drd_temp_file2");

		$this->load->library('excel');

		$items = "";
		$headername	= strtoupper($_GET['headername']);
		
		$code 		= strtoupper($_GET['code']);
		$name 		= strtoupper($_GET['name']);
		$flag 		= strtoupper($_GET['flag']);
		$debit 		= strtoupper($_GET['debit']);
		$credit 	= strtoupper($_GET['credit']);

		$filename = time().$_FILES['file']['name'];
		$uploadedfile = $_FILES['file']['tmp_name'];
		$upload_path = "./temp_new_account/";
		if(move_uploaded_file($uploadedfile, $upload_path.$filename))
		{			
			$excelFile = $upload_path.$filename;
			if(file_exists($excelFile))
			{
				$this->load->library('excel');
				$objPHPExcel1 = PHPExcel_IOFactory::load($excelFile);
				foreach ($objPHPExcel1->getWorksheetIterator() as $worksheet)
				{
					$highestRow = $worksheet->getHighestRow();
					for ($row=$headername; $row<=$highestRow; $row++)
					{
						$name_ = $worksheet->getCell($name.$row)->getValue();
						$name_ = str_replace("."," ",$name_);
						if($name_!="")
						{
							$code_ 		 = $worksheet->getCell($code.$row)->getValue();
							$flag_ 		 = $worksheet->getCell($flag.$row)->getValue();
							$debit_ 	 = $worksheet->getCell($debit.$row)->getValue();
							$credit_ 	 = $worksheet->getCell($credit.$row)->getValue();

							$this->db->query("insert into drd_temp_file2 (code,name,flag,debit,credit) values ('$code_','$name_','$flag_','$debit_','$credit_')");
						}
					}
				}
				unlink($excelFile);
			}
		}

		$url = base_url()."new_account/file3";

		header('Content-Type: application/json');
$items.= <<<EOD
{"url":"{$url}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}<?php
	}

	/****************************************** */

	/**************************************** */
	public function file3()
	{		
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		
		$data["main_page_title"] = "Expiry file";		
		
		$this->load->view('home/header', $data);
		$this->load->view('new_account/file3', $data);
	}

	public function upload_file3(){

		$this->db->query("TRUNCATE TABLE drd_temp_file3");

		$this->load->library('excel');

		$items = "";
		$headername	= strtoupper($_GET['headername']);
		
		$name 		= strtoupper($_GET['name']);
		$date 		= strtoupper($_GET['date']);
		$amount 	= strtoupper($_GET['amount']);

		$filename = time().$_FILES['file']['name'];
		$uploadedfile = $_FILES['file']['tmp_name'];
		$upload_path = "./temp_new_account/";
		if(move_uploaded_file($uploadedfile, $upload_path.$filename))
		{			
			$excelFile = $upload_path.$filename;
			if(file_exists($excelFile))
			{
				$this->load->library('excel');
				$objPHPExcel1 = PHPExcel_IOFactory::load($excelFile);
				foreach ($objPHPExcel1->getWorksheetIterator() as $worksheet)
				{
					$highestRow = $worksheet->getHighestRow();
					for ($row=$headername; $row<=$highestRow; $row++)
					{
						$name_ = $worksheet->getCell($name.$row)->getValue();
						$name_ = str_replace("."," ",$name_);
						if($name_!="")
						{
							$date_o 	 = $worksheet->getCell($date.$row)->getValue();
							$date_ 		 = str_replace("'","",$date_o);
							$amount_ 	 = $worksheet->getCell($amount.$row)->getValue();

							$this->db->query("insert into drd_temp_file3 (name,date,amount) values ('$name_','$date_','$amount_')");
						}
					}
				}
				unlink($excelFile);
			}
		}

		$url = base_url()."new_account/file_master1";

		header('Content-Type: application/json');
$items.= <<<EOD
{"url":"{$url}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}<?php
	}

	/****************************************** */

	public function file_master1()
	{		
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		
		$data["main_page_title"] = "Master file";		
		
		$this->load->view('home/header', $data);
		$this->load->view('new_account/file_master1', $data);
	}
	
	public function upload_file_master1(){

		$this->db->query("TRUNCATE TABLE drd_temp_file_master1");

		$this->load->library('excel');

		$items = "";
		$headername	= strtoupper($_GET['headername']);
		
		$name 		= strtoupper($_GET['name']);
		$name2 		= strtoupper($_GET['name2']);

		$filename = time().$_FILES['file']['name'];
		$uploadedfile = $_FILES['file']['tmp_name'];
		$upload_path = "./temp_new_account/";
		if(move_uploaded_file($uploadedfile, $upload_path.$filename))
		{			
			$excelFile = $upload_path.$filename;
			if(file_exists($excelFile))
			{
				$this->load->library('excel');
				$objPHPExcel1 = PHPExcel_IOFactory::load($excelFile);
				foreach ($objPHPExcel1->getWorksheetIterator() as $worksheet)
				{
					$highestRow = $worksheet->getHighestRow();
					for ($row=$headername; $row<=$highestRow; $row++)
					{
						$name_ = $worksheet->getCell($name.$row)->getValue();
						$name_ = str_replace("."," ",$name_);
						if($name_!="")
						{
							$name2_ = $worksheet->getCell($name2.$row)->getValue();
							$name2_ = str_replace("."," ",$name2_);

							$this->db->query("insert into drd_temp_file_master1 (name,name2) values ('$name_','$name2_')");
						}
					}
				}
				unlink($excelFile);
			}
		}

		$url = base_url()."new_account/file_master2";

		header('Content-Type: application/json');
$items.= <<<EOD
{"url":"{$url}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}<?php
	}
	/**********************************************/

	public function file_master2()
	{		
		$data["session_user_image"] 	= $this->session->userdata('user_image');
		$data["session_user_fname"]     = $this->session->userdata('user_fname');
		$data["session_user_altercode"] = $this->session->userdata('user_altercode');
		
		$data["main_page_title"] = "Master file2";		
		
		$this->load->view('home/header', $data);
		$this->load->view('new_account/file_master2', $data);
	}
	
	public function upload_file_master2(){

		$this->db->query("TRUNCATE TABLE drd_temp_file_master2");

		$this->load->library('excel');

		$items = "";
		$headername 		= "2";
		$DebitAccountNumber = "A";
		$ValueDate 			= "B";
		$CustomerReferenceNo= "C";
		$BeneficiaryName	= "D";
		$PaymentType		= "E";
		$BeneAccountNumber	= "F";
		$BankCode			= "G";
		$Accounttype		= "H";
		$Amount_i			= "I";
		$POD1				= "J";
		$POD2				= "K";
		$POD3_RTGSPP		= "L";
		$POD4				= "M";
		$Blank_n			= "N";
		$PayableLocationName= "O";
		$Blank_p			= "P";
		$PrintLocationName	= "Q";
		$BeneficiaryAddress1= "R";
		$BeneficiaryAddress2= "S";
		$BeneficiaryAddress3= "T";
		$BeneficiaryAddress4= "U";
		$DeliveryMethod		= "V";
		$ChequeNumber		= "W";
		$BeneE_mailID		= "X";
		$Blank_x			= "Y";
		$Blank_z			= "Z";
		$PrintDate			= "AA";
		$Amount_ab			= "AB";

		$filename = time().$_FILES['file']['name'];
		$uploadedfile = $_FILES['file']['tmp_name'];
		$upload_path = "./temp_new_account/";
		if(move_uploaded_file($uploadedfile, $upload_path.$filename))
		{			
			$excelFile = $upload_path.$filename;
			if(file_exists($excelFile))
			{
				$this->load->library('excel');
				$objPHPExcel1 = PHPExcel_IOFactory::load($excelFile);
				foreach ($objPHPExcel1->getWorksheetIterator() as $worksheet)
				{
					$highestRow = $worksheet->getHighestRow();
					for ($row=$headername; $row<=$highestRow; $row++)
					{
						$BeneficiaryName_ = $worksheet->getCell($BeneficiaryName.$row)->getValue();
						$BeneficiaryName_ = str_replace("."," ",$BeneficiaryName_);
						if($BeneficiaryName_!="")
						{
							$DebitAccountNumber_ = $worksheet->getCell($DebitAccountNumber.$row)->getValue();
							$ValueDate_ = $worksheet->getCell($ValueDate.$row)->getValue();
							$CustomerReferenceNo_ = $worksheet->getCell($CustomerReferenceNo.$row)->getValue();
							
							
							$PaymentType_ = $worksheet->getCell($PaymentType.$row)->getValue();
							$BeneAccountNumber_ = $worksheet->getCell($BeneAccountNumber.$row)->getValue();
							$BankCode_ = $worksheet->getCell($BankCode.$row)->getValue();
							$Accounttype_ = $worksheet->getCell($Accounttype.$row)->getValue();
							$Amount_i_ = $worksheet->getCell($Amount_i.$row)->getValue();
							$POD1_ = $worksheet->getCell($POD1.$row)->getValue();
							$POD2_ = $worksheet->getCell($POD2.$row)->getValue();
							$POD3_RTGSPP_ = $worksheet->getCell($POD3_RTGSPP.$row)->getValue();
							$POD4_ = $worksheet->getCell($POD4.$row)->getValue();
							$Blank_n_ = $worksheet->getCell($Blank_n.$row)->getValue();
							$PayableLocationName_ = $worksheet->getCell($PayableLocationName.$row)->getValue();
							$Blank_p_ = $worksheet->getCell($Blank_p.$row)->getValue();
							$PrintLocationName_ = $worksheet->getCell($PrintLocationName.$row)->getValue();
							$BeneficiaryAddress1_ = $worksheet->getCell($BeneficiaryAddress1.$row)->getValue();
							$BeneficiaryAddress2_ = $worksheet->getCell($BeneficiaryAddress2.$row)->getValue();
							$BeneficiaryAddress3_ = $worksheet->getCell($BeneficiaryAddress3.$row)->getValue();
							$BeneficiaryAddress4_ = $worksheet->getCell($BeneficiaryAddress4.$row)->getValue();
							$DeliveryMethod_ = $worksheet->getCell($DeliveryMethod.$row)->getValue();
							$ChequeNumber_ = $worksheet->getCell($ChequeNumber.$row)->getValue();
							$BeneE_mailID_ = $worksheet->getCell($BeneE_mailID.$row)->getValue();
							$Blank_x_ = $worksheet->getCell($Blank_x.$row)->getValue();
							$Blank_z_ = $worksheet->getCell($Blank_z.$row)->getValue();
							$PrintDate_ = $worksheet->getCell($PrintDate.$row)->getValue();
							$Amount_ab_ = $worksheet->getCell($Amount_ab.$row)->getValue();

							$this->db->query("insert into drd_temp_file_master2 (`DebitAccountNumber`, `ValueDate`, `CustomerReferenceNo`, `BeneficiaryName`, `PaymentType`, `BeneAccountNumber`, `BankCode`, `Accounttype`, `Amount_i`, `POD1`, `POD2`, `POD3_RTGSPP`, `POD4`, `Blank_n`, `PayableLocationName`, `Blank_p`, `PrintLocationName`, `BeneficiaryAddress1`, `BeneficiaryAddress2`, `BeneficiaryAddress3`, `BeneficiaryAddress4`, `DeliveryMethod`, `ChequeNumber`, `BeneE_mailID`, `Blank_x`, `Blank_z`, `PrintDate`, `Amount_ab`) values ('$DebitAccountNumber_','$ValueDate_','$CustomerReferenceNo_','$BeneficiaryName_','$PaymentType_','$BeneAccountNumber_','$BankCode_','$Accounttype_','$Amount_i_','$POD1_','$POD2_','$POD3_RTGSPP_','$POD4_','$Blank_n_','$PayableLocationName_','$Blank_p_','$PrintLocationName_','$BeneficiaryAddress1_','$BeneficiaryAddress2_','$BeneficiaryAddress3_','$BeneficiaryAddress4_','$DeliveryMethod_','$ChequeNumber_','$BeneE_mailID_','$Blank_x_','$Blank_z_','$PrintDate_','$Amount_ab_')");
						}
					}
				}
				unlink($excelFile);
			}
		}

		$url = base_url()."new_account/download_master_file";

		header('Content-Type: application/json');
$items.= <<<EOD
{"url":"{$url}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}<?php
	}
	/**********************************************/
	public function download_master_file(){
		error_reporting(0);
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		ob_clean();		

		date_default_timezone_set('Asia/Calcutta');
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A3', 'ALI')
		->setCellValue('B3', 'NAME OF COMPANY')
		->setCellValue('C3', 'SALE')
		->setCellValue('D3', 'SALE RETURN')
		->setCellValue('E3', 'NET SALES')
		->setCellValue('F3', 'CL.STOCK')
		->setCellValue('G3', 'SALE+GST')
		->setCellValue('H3', 'LEDGER BALANCE')
		->setCellValue('I3', 'STOCK + GST')
		->setCellValue('J3', 'LEDGER- STOCK')
		->setCellValue('K3', 'EXPIRY AMOUNT DUE & ( MONTH)')
		->setCellValue('L3', 'EXPIRY MORE THAN 3 MONTHS')
		->setCellValue('M3', 'FINAL');		

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(1);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(1);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(1);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(1);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(14);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);

		$d = date();
		$datev =  date('Y-m-d', strtotime( $d . " -90 days"));
		$rowCount = 3;
		$result = $this->db->query("SELECT * from drd_temp_file_master1")->result();
		foreach ($result as $row)
		{
			$rowCount++;
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,"");
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,$row->name);
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount,$row->name2);
			$row_f1 = $this->db->query("SELECT * from drd_temp_file1 where companyname='$row->name'")->row();
			$row_f2 = $this->db->query("SELECT * from drd_temp_file2 where name='$row->name2'")->row();
			$ex_total = 0;
			$result_f3 = $this->db->query("SELECT * from drd_temp_file3 where name='$row->name2'")->result();
			foreach($result_f3 as $row_f3)
			{
				$date = date("Y-m-d", strtotime($row_f3->date));
				if($date<$datev)
				{
					$ex_total = $ex_total + $row_f3->amount;
				}				
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,round($row_f2->debit));
			$jv = $row_f2->debit + $row_f1->inclusive_tax_total;
			if($row_f2->debit=="0")
			{
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,round($row_f2->credit));
				$jv = $row_f2->credit - $row_f1->inclusive_tax_total;
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,round($row_f1->inclusive_tax_total));
			
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount,round($jv));
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount,round($ex_total));
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount,round($jv - $ex_total));
		}
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
		$file_name = "temp_new_account/new_items_".time().".xls";
		$objWriter->save($file_name);
		echo base_url().$file_name;
	}

	public function download_master_file2(){
		error_reporting(0);
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		ob_clean();		

		date_default_timezone_set('Asia/Calcutta');
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', 'Debit Account Number')
		->setCellValue('B1', 'Value Date')
		->setCellValue('C1', 'Customer Reference No')
		->setCellValue('D1', 'Beneficiary Name')
		->setCellValue('E1', 'Payment Type')
		->setCellValue('F1', 'Bene Account Number')
		->setCellValue('G1', 'Bank Code')
		->setCellValue('H1', 'Account type')
		->setCellValue('I1', 'Amount')
		->setCellValue('J1', 'POD 1')
		->setCellValue('K1', 'POD 2')
		->setCellValue('L1', 'POD 3 / RTGS PP')
		->setCellValue('M1', 'POD 4')
		->setCellValue('N1', 'Blank')
		->setCellValue('O1', 'Payable Location Name')
		->setCellValue('P1', 'Blank')
		->setCellValue('Q1', 'Print Location Name')
		->setCellValue('R1', 'Beneficiary Address 1')
		->setCellValue('S1', 'Beneficiary Address 2')
		->setCellValue('T1', 'Beneficiary Address 3')
		->setCellValue('U1', 'Beneficiary Address 4')
		->setCellValue('V1', 'Delivery Method')
		->setCellValue('W1', 'Cheque Number')
		->setCellValue('X1', 'Bene E-mail ID')
		->setCellValue('Y1', 'Blank')
		->setCellValue('Z1', 'Blank')
		->setCellValue('AA1', 'Print Date')
		->setCellValue('AB1', 'Amount');		

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(6);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(20);

		$d = date();
		$datev =  date('Y-m-d', strtotime( $d . " -90 days"));

		$rowCount = 1;
		$result = $this->db->query("SELECT * from drd_temp_file_master2")->result();
		foreach ($result as $row)
		{
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,($row->DebitAccountNumber));
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,($row->ValueDate));
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,($row->CustomerReferenceNo));
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,($row->BeneficiaryName));
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,($row->PaymentType));
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,($row->BeneAccountNumber));
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,($row->BankCode));
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,($row->Accounttype));
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,($row->Amount_i));
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount,($row->POD1));
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount,($row->POD2));
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount,($row->POD3_RTGSPP));
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount,($row->POD4));
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount,($row->Blank_n));
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount,($row->PayableLocationName));
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount,($row->Blank_p));
			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount,($row->PrintLocationName));
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount,($row->BeneficiaryAddress1));
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount,($row->BeneficiaryAddress2));
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount,($row->BeneficiaryAddress3));
			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount,($row->BeneficiaryAddress4));
			$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount,($row->DeliveryMethod));
			$objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount,($row->ChequeNumber));
			$objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount,($row->BeneE_mailID));
			$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount,($row->Blank_x));
			$objPHPExcel->getActiveSheet()->SetCellValue('Z'.$rowCount,($row->Blank_z));
			$objPHPExcel->getActiveSheet()->SetCellValue('AA'.$rowCount,($row->PrintDate));
			$objPHPExcel->getActiveSheet()->SetCellValue('AB'.$rowCount,($row->Amount_ab));

			/********************************* */
			$row0 = $this->db->query("SELECT * from drd_temp_file_master1 where name2='$row->BeneficiaryName'")->row();

			$row_f1 = $this->db->query("SELECT * from drd_temp_file1 where companyname='$row0->name'")->row();
			$row_f2 = $this->db->query("SELECT * from drd_temp_file2 where name='$row0->name2'")->row();
			$ex_total = 0;
			$result_f3 = $this->db->query("SELECT * from drd_temp_file3 where name='$row0->name2'")->result();
			foreach($result_f3 as $row_f3)
			{
				$date = date("Y-m-d", strtotime($row_f3->date));
				if($date<$datev)
				{
					$ex_total = $ex_total + $row_f3->amount;
				}				
			}
			$jv = $row_f2->debit + $row_f1->inclusive_tax_total;
			if($row_f2->debit=="0")
			{
				$jv = $row_f2->credit - $row_f1->inclusive_tax_total;
			}			
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,round($jv));
		}
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
		$file_name = "temp_new_account/new_items_".time().".xls";
		$objWriter->save($file_name);
		echo base_url().$file_name;
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
}
?>