<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '-1');
ini_set('post_max_size', '100M');
ini_set('upload_max_filesize', '100M');
ini_set('max_execution_time', 36000);class Manage_pending_order extends CI_Controller {
	var $Page_title = "Manage Pending Order";
	var $Page_name  = "manage_pending_order";
	var $Page_view  = "manage_pending_order";
	var $Page_menu  = "manage_pending_order";
	var $page_controllers = "manage_pending_order";
	var $Page_tbl   = "tbl_pending_order";
	public function index()
	{
		$page_controllers = $this->page_controllers;
		redirect("admin/$page_controllers/view");
	}
	public function add()
	{
		error_reporting(0);
		/******************session***********************/
		$user_id = $this->session->userdata("user_id");
		$user_type = $this->session->userdata("user_type");
		/******************session***********************/		

		$Page_title = $this->Page_title;
		$Page_name 	= $this->Page_name;
		$Page_view 	= $this->Page_view;
		$Page_menu 	= $this->Page_menu;
		$Page_tbl 	= $this->Page_tbl;
		$page_controllers 	= $this->page_controllers;	

		$this->Admin_Model->permissions_check_or_set($Page_title,$Page_name,$user_type);		

		$data['title1'] = $Page_title." || Add";
		$data['title2'] = "Add";
		$data['Page_name'] = $Page_name;
		$data['Page_menu'] = $Page_menu;
		$this->breadcrumbs->push("Admin","admin/");
		$this->breadcrumbs->push("$Page_title","admin/$page_controllers/");
		$this->breadcrumbs->push("Add","admin/$page_controllers/add");
		$tbl = $Page_tbl;
		
		$current_quantity = 0;
		extract($_POST);
		if(isset($Submit))
		{
			$message_db = "";
			if (!empty($_FILES["file_name"]["name"]))
			{
				$upload_path = "./upload_pending_order/";
				$x = $_FILES["file_name"]['name'];
				$y = $_FILES["file_name"]['tmp_name'];
				
				$excelFile =time().$x;
				move_uploaded_file($y,$upload_path.$excelFile);
			}
			
			if (!empty($_FILES["file_name"]["name"]))
			{
				$excelFile1 = "upload_pending_order/".$excelFile;
				$excelFile 	= "./upload_pending_order/".$excelFile;
				
				$time = time();
				$date = date("Y-m-d",$time);
				
				$company1 	= "A";
				$item_code1 = "B";
				$item_name1 = "C";
				$pack1 		= "D";
				$qty1 		= "E";
				$f_qty1 	= "F";
				$division1 	= "G";
				$headername = 8;
				$this->load->library('excel');
				$objPHPExcel = PHPExcel_IOFactory::load($excelFile);
				foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
				{
					$date_range	= $worksheet->getCell("A5")->getValue();
					$highestRow = $worksheet->getHighestRow();
					for ($row=$headername; $row<=$highestRow; $row++)
					{
						$company 	= $worksheet->getCell($company1.$row)->getValue();
						$item_code 	= $worksheet->getCell($item_code1.$row)->getValue();
						$item_name 	= $worksheet->getCell($item_name1.$row)->getValue();
						$pack 		= $worksheet->getCell($pack1.$row)->getValue();
						$qty 		= $worksheet->getCell($qty1.$row)->getValue();
						$f_qty 		= $worksheet->getCell($f_qty1.$row)->getValue();
						$division 	= $worksheet->getCell($division1.$row)->getValue();
												
						if($qty>=10)
						{
							$qty = round($qty/10) * 10;
						}
						else
						{
							$qty = 10;
						}						
						
						/*
						if($current_quantity==0)
						{
							/***************18-01-2020*****************
							$qty = $this->check_last_qty($item_code,$qty);
							/******************************************
						}*/
						if($date_range=="")
						{
							$date_range = date("d-M-Y");
						}
						if($company=="")
						{
							$company = "";
						}
						if($item_code=="")
						{
							$item_code = "";
						}
						if($item_name=="")
						{
							$item_name = "";
						}
						if($pack=="")
						{
							$pack = "";
						}
						if($qty=="")
						{
							$qty = "";
						}
						if($f_qty=="")
						{
							$f_qty = "";
						}
						if($division=="")
						{
							$division = "";
						}
						
						$row1 = $this->db->query("select item_name,company_name,division,packing from tbl_medicine where item_code='$item_code'")->row();
						
						$item_name 	= $row1->item_name;
						$company	= $row1->company_name;
						$pack 		= $row1->packing;
						$division	= $row1->division;
						if($item_name!="")
						{
							$row2 = $this->db->query("select item_code from tbl_pending_order where item_code='$item_code'")->row();
							if($row2->item_code=="")
							{
								$dt = array(
								'company'=>$company,
								'item_code'=>$item_code,
								'item_name'=>$item_name,
								'pack'=>$pack,
								'qty'=>$qty,
								'f_qty'=>$f_qty,
								'division'=>$division,
								'date_range'=>$date_range,
								'date'=>$date,
								'time'=>$time,
								);
								$result = $this->Scheme_Model->insert_fun("tbl_pending_order",$dt);
							}
						}
						$dtr = $date_range;
					}
				}
			}
			unlink($excelFile1);
			//$this->low_stock_alert_add_on_pending_order($dtr,$current_quantity);
			//$this->sales_deleted_add_on_pending_order($dtr,$current_quantity);
			$name = base64_decode($name);
			if($result)
			{
				$message_db = "($property_title) -  Add Successfully.";
				$message = "Add Successfully.";
				$this->session->set_flashdata("message_type","success");
			}
			else
			{
				$message_db = "($property_title) - Not Add.";
				$message = "Not Add.";
				$this->session->set_flashdata("message_type","error");
			}
		}
		if($message_db!="")
		{
			$message = $Page_title." - ".$message;
			$message_db = $Page_title." - ".$message_db;
			$this->session->set_flashdata("message_footer","yes");
			$this->session->set_flashdata("full_message",$message);
			$this->Admin_Model->Add_Activity_log($message_db);
			if($result)
			{
				redirect(base_url()."admin/$page_controllers/view");
			}
		}

		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/add",$data);
		$this->load->view("admin/header_footer/footer",$data);

	}
	
	
	public function add2()
	{
		error_reporting(0);
		/******************session***********************/
		$user_id = $this->session->userdata("user_id");
		$user_type = $this->session->userdata("user_type");
		/******************session***********************/		

		$Page_title = $this->Page_title;
		$Page_name 	= $this->Page_name;
		$Page_view 	= $this->Page_view;
		$Page_menu 	= $this->Page_menu;
		$Page_tbl 	= $this->Page_tbl;
		$page_controllers 	= $this->page_controllers;	

		$this->Admin_Model->permissions_check_or_set($Page_title,$Page_name,$user_type);		

		$data['title1'] = $Page_title." || Add";
		$data['title2'] = "Add";
		$data['Page_name'] = $Page_name;
		$data['Page_menu'] = $Page_menu;
		$this->breadcrumbs->push("Admin","admin/");
		$this->breadcrumbs->push("$Page_title","admin/$page_controllers/");
		$this->breadcrumbs->push("Add","admin/$page_controllers/add");
		$tbl = $Page_tbl;
		
		$current_quantity = 0;
		extract($_POST);
		if(isset($Submit))
		{
			$message_db = "";
			if (!empty($_FILES["file_name"]["name"]))
			{
				$upload_path = "./upload_pending_order/";
				$x = $_FILES["file_name"]['name'];
				$y = $_FILES["file_name"]['tmp_name'];
				
				$excelFile =time().$x;
				move_uploaded_file($y,$upload_path.$excelFile);
			}
			
			if (!empty($_FILES["file_name"]["name"]))
			{
				$excelFile1 = "upload_pending_order/".$excelFile;
				$excelFile 	= "./upload_pending_order/".$excelFile;
				
				$time = time();
				$date = date("Y-m-d",$time);
				
				$item_code1 = "A";
				$qty1 		= "C";
				$headername = 7;
				$this->load->library('excel');
				$objPHPExcel = PHPExcel_IOFactory::load($excelFile);
				foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
				{
					$date_range	= $worksheet->getCell("A4")->getValue();
					$highestRow = $worksheet->getHighestRow();
					for ($row=$headername; $row<=$highestRow; $row++)
					{
						$item_code 	= $worksheet->getCell($item_code1.$row)->getValue();
						$qty 		= $worksheet->getCell($qty1.$row)->getValue();
						
						if($item_code!="")
						{
							if($qty>=10)
							{
								$qty = round($qty/10) * 10;
							}
							else
							{
								$qty = 10;
							}						
							
							/*
							if($current_quantity==0)
							{
								/***************18-01-2020*****************
								$qty = $this->check_last_qty($item_code,$qty);
								/******************************************
							}*/
							if($date_range=="")
							{
								$date_range = date("d-M-Y");
							}
							if($item_code=="")
							{
								$item_code = "";
							}
							if($pack=="")
							{
								$pack = "";
							}
							if($qty=="")
							{
								$qty = "";
							}
							$f_qty = "";
							if($division=="")
							{
								$division = "";
							}
							
							$row1 = $this->db->query("select item_name,company_name,division,packing from tbl_medicine where item_code='$item_code'")->row();
							
							$item_name 	= $row1->item_name;
							$company	= $row1->company_name;
							$pack 		= $row1->packing;
							$division	= $row1->division;
							if($item_name!="")
							{
								$row2 = $this->db->query("select item_code from tbl_pending_order where item_code='$item_code'")->row();
								if($row2->item_code=="")
								{
									$dt = array(
									'company'=>$company,
									'item_code'=>$item_code,
									'item_name'=>$item_name,
									'pack'=>$pack,
									'qty'=>$qty,
									'f_qty'=>$f_qty,
									'division'=>$division,
									'date_range'=>$date_range,
									'date'=>$date,
									'time'=>$time,
									);
									$result = $this->Scheme_Model->insert_fun("tbl_pending_order",$dt);
								}
							}
							$dtr = $date_range;
						}
					}
				}
			}
			unlink($excelFile1);
			//$this->low_stock_alert_add_on_pending_order($dtr,$current_quantity);
			//$this->sales_deleted_add_on_pending_order($dtr,$current_quantity);
			$name = base64_decode($name);
			if($result)
			{
				$message_db = "($property_title) -  Add Successfully.";
				$message = "Add Successfully.";
				$this->session->set_flashdata("message_type","success");
			}
			else
			{
				$message_db = "($property_title) - Not Add.";
				$message = "Not Add.";
				$this->session->set_flashdata("message_type","error");
			}
		}
		if($message_db!="")
		{
			$message = $Page_title." - ".$message;
			$message_db = $Page_title." - ".$message_db;
			$this->session->set_flashdata("message_footer","yes");
			$this->session->set_flashdata("full_message",$message);
			$this->Admin_Model->Add_Activity_log($message_db);
			if($result)
			{
				redirect(base_url()."admin/$page_controllers/view");
			}
		}

		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/add2",$data);
		$this->load->view("admin/header_footer/footer",$data);

	}
	
	public function add3()
	{
		error_reporting(0);
		/******************session***********************/
		$user_id = $this->session->userdata("user_id");
		$user_type = $this->session->userdata("user_type");
		/******************session***********************/		

		$Page_title = $this->Page_title;
		$Page_name 	= $this->Page_name;
		$Page_view 	= $this->Page_view;
		$Page_menu 	= $this->Page_menu;
		$Page_tbl 	= $this->Page_tbl;
		$page_controllers 	= $this->page_controllers;	

		$this->Admin_Model->permissions_check_or_set($Page_title,$Page_name,$user_type);		

		$data['title1'] = $Page_title." || Add";
		$data['title2'] = "Add";
		$data['Page_name'] = $Page_name;
		$data['Page_menu'] = $Page_menu;
		$this->breadcrumbs->push("Admin","admin/");
		$this->breadcrumbs->push("$Page_title","admin/$page_controllers/");
		$this->breadcrumbs->push("Add","admin/$page_controllers/add");
		$tbl = $Page_tbl;
		
		$current_quantity = 0;
		extract($_POST);
		if(isset($Submit))
		{
			$message_db = "";
			if (!empty($_FILES["file_name"]["name"]))
			{
				$upload_path = "./upload_pending_order/";
				$x = $_FILES["file_name"]['name'];
				$y = $_FILES["file_name"]['tmp_name'];
				
				$excelFile =time().$x;
				move_uploaded_file($y,$upload_path.$excelFile);
			}
			
			if (!empty($_FILES["file_name"]["name"]))
			{
				$excelFile1 = "upload_pending_order/".$excelFile;
				$excelFile 	= "./upload_pending_order/".$excelFile;
				
				$time = time();
				$date = date("Y-m-d",$time);
				
				$company1 	= "A";
				$item_code1 = "B";
				$item_name1 = "C";
				$pack1 		= "D";
				$qty1 		= "E";
				$f_qty1 	= "F";
				$division1 	= "G";
				$headername = 8;
				$this->load->library('excel');
				$objPHPExcel = PHPExcel_IOFactory::load($excelFile);
				foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
				{
					$date_range	= $worksheet->getCell("A5")->getValue();
					$highestRow = $worksheet->getHighestRow();
					for ($row=$headername; $row<=$highestRow; $row++)
					{
						$company 	= $worksheet->getCell($company1.$row)->getValue();
						$item_code 	= $worksheet->getCell($item_code1.$row)->getValue();
						$item_name 	= $worksheet->getCell($item_name1.$row)->getValue();
						$pack 		= $worksheet->getCell($pack1.$row)->getValue();
						$qty 		= $worksheet->getCell($qty1.$row)->getValue();
						$f_qty 		= $worksheet->getCell($f_qty1.$row)->getValue();
						$division 	= $worksheet->getCell($division1.$row)->getValue();
												
						if($qty>=10)
						{
							$qty = round($qty/10) * 10;
						}
						else
						{
							$qty = 10;
						}						
						
						/*
						if($current_quantity==0)
						{
							/***************18-01-2020*****************
							$qty = $this->check_last_qty($item_code,$qty);
							/******************************************
						}*/
						if($date_range=="")
						{
							$date_range = date("d-M-Y");
						}
						if($company=="")
						{
							$company = "";
						}
						if($item_code=="")
						{
							$item_code = "";
						}
						if($item_name=="")
						{
							$item_name = "";
						}
						if($pack=="")
						{
							$pack = "";
						}
						if($qty=="")
						{
							$qty = "";
						}
						if($f_qty=="")
						{
							$f_qty = "";
						}
						if($division=="")
						{
							$division = "";
						}
						
						$row1 = $this->db->query("select item_name,company_name,division,packing from tbl_medicine where item_code='$item_code'")->row();
						
						$item_name 	= $row1->item_name;
						$company	= $row1->company_name;
						$pack 		= $row1->packing;
						$division	= $row1->division;
						if($item_name!="")
						{
							$row2 = $this->db->query("select item_code from tbl_pending_order where item_code='$item_code'")->row();
							if($row2->item_code=="")
							{
								$dt = array(
								'company'=>$company,
								'item_code'=>$item_code,
								'item_name'=>$item_name,
								'pack'=>$pack,
								'qty'=>$qty,
								'f_qty'=>$f_qty,
								'division'=>$division,
								'date_range'=>$date_range,
								'date'=>$date,
								'time'=>$time,
								);
								$result = $this->Scheme_Model->insert_fun("tbl_pending_order",$dt);
							}
						}
						$dtr = $date_range;
					}
				}
			}
			unlink($excelFile1);
			//$this->low_stock_alert_add_on_pending_order($dtr,$current_quantity);
			//$this->sales_deleted_add_on_pending_order($dtr,$current_quantity);
			$name = base64_decode($name);
			if($result)
			{
				$message_db = "($property_title) -  Add Successfully.";
				$message = "Add Successfully.";
				$this->session->set_flashdata("message_type","success");
			}
			else
			{
				$message_db = "($property_title) - Not Add.";
				$message = "Not Add.";
				$this->session->set_flashdata("message_type","error");
			}
		}
		if($message_db!="")
		{
			$message = $Page_title." - ".$message;
			$message_db = $Page_title." - ".$message_db;
			$this->session->set_flashdata("message_footer","yes");
			$this->session->set_flashdata("full_message",$message);
			$this->Admin_Model->Add_Activity_log($message_db);
			if($result)
			{
				redirect(base_url()."admin/$page_controllers/view");
			}
		}

		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/add3",$data);
		$this->load->view("admin/header_footer/footer",$data);

	}
	public function view()
	{		error_reporting(0);
		/******************session***********************/
		$user_id = $this->session->userdata("user_id");
		$user_type = $this->session->userdata("user_type");
		/******************session***********************/		
		$_SESSION["latitude"] = 
		$_SESSION["longitude"] = "";
		$Page_title = $this->Page_title;
		$Page_name 	= $this->Page_name;
		$Page_view 	= $this->Page_view;
		$Page_menu 	= $this->Page_menu;
		$Page_tbl 	= $this->Page_tbl;
		$page_controllers 	= $this->page_controllers;	
		$this->Admin_Model->permissions_check_or_set($Page_title,$Page_name,$user_type);	
		$data['title1'] = $Page_title." || View";
		$data['title2'] = "View";		$data['Page_name'] = $Page_name;
		$data['Page_menu'] = $Page_menu;
		$this->breadcrumbs->push("Admin","admin/");			$this->breadcrumbs->push("$Page_title","admin/$page_controllers/");
		$this->breadcrumbs->push("View","admin/$page_controllers/view");		
		$tbl = $Page_tbl;	
		
		extract($_POST);
		if(isset($Submit))
		{
			$dt = array(
			'email'=>$email,
			'password'=>$password,
			);
			$result = $this->Scheme_Model->insert_fun("tbl_gmail_username_password",$dt);
			
			if($result)
			{
				redirect(base_url()."admin/$page_controllers/view");
			}
		}
		
		$row1 = $this->db->query("select * from tbl_gmail_username_password where id='1' order by id desc")->row();
		$data["row1"] = $row1;
		
		if(isset($Submit1))
		{
			$this->load->library('phpmailer_lib');
			$mail = $this->phpmailer_lib->load();
        
			$subject 	= 'Test Mail';
            $body 		= 'Hi there, <strong>Carl</strong> here.<br/> This is our email body.';
            $email 		= 'kapil707sharma@gmail.com';
			//$email 	= $row1->email;


            $mail->CharSet = 'UTF-8';
            $mail->SetFrom($row1->email,'Carl');

            //You could either add recepient name or just the email address.
            /*$mail->AddAddress($email,"Recepient Name");*/
            $mail->AddAddress($email);

            /*//Address to which recipient will reply
            $mail->addReplyTo("reply@yourdomain.com","Reply");
            $mail->addCC("cc@example.com");
            $mail->addBCC("bcc@example.com");

            //Add a file attachment
            $mail->addAttachment("file.txt", "File.txt");        
            $mail->addAttachment("images/profile.png"); //Filename is optional*/

            //You could send the body as an HTML or a plain text
            $mail->IsHTML(true);

            $mail->Subject = $subject;
            $mail->Body = $body;

            //Send email via SMTP
            $mail->IsSMTP();
            $mail->SMTPAuth   = true; 
            $mail->SMTPSecure = "ssl";  //tls
            $mail->Host       = "smtp.googlemail.com";
            $mail->Port       = 465; //you could use port 25, 587, 465 for googlemail
            $mail->Username   = $row1->email;
            $mail->Password   = $row1->password;

            if($mail->send()){
                $result = '1';
            }
            else{
                $result = "";
            }
			
			if($result)
			{
				$message = "Email Send.";
				$this->session->set_flashdata("message_type","success");
			}
			else
			{
				$message = "Email Not Send.";
				$this->session->set_flashdata("message_type","error");
			}
			if($result)
			{
				redirect(base_url()."admin/$page_controllers/view");
			}
		}
		
		if(isset($Submit2))
		{
			$this->db->query("update $tbl set status='1' where status='0'");
			if($result)
			{
				$message = "Email Start.";
				$this->session->set_flashdata("message_type","success");
			}
			else
			{
				$message = "Email Not Start.";
				$this->session->set_flashdata("message_type","error");
			}
			if($result)
			{
				redirect(base_url()."admin/$page_controllers/view");
			}
		}
		
		if(isset($Submit3))
		{
			$this->db->query("update $tbl set status='0' where status='1'");
			if($result)
			{
				$message = "Email Stop.";
				$this->session->set_flashdata("message_type","success");
			}
			else
			{
				$message = "Email Not Stop.";
				$this->session->set_flashdata("message_type","error");
			}
			if($result)
			{
				redirect(base_url()."admin/$page_controllers/view");
			}
		}
		
		if(isset($Submit4))
		{
			$this->db->query("delete from $tbl");
			if($result)
			{
				$message = "Data Delete.";
				$this->session->set_flashdata("message_type","success");
			}
			else
			{
				$message = "Data Not Delete.";
				$this->session->set_flashdata("message_type","error");
			}
			if($result)
			{
				redirect(base_url()."admin/$page_controllers/view");
			}
		}
		$query = $this->db->query("select * from $tbl order by id asc");
  		$data["result"] = $query->result();
		$this->load->view("admin/header_footer/header",$data);		$this->load->view("admin/$Page_view/view",$data);
		$this->load->view("admin/header_footer/footer",$data);
	}
	
	/*****************02-01-20***********************************/
	/*****************07-12-19***********************/
	public function low_stock_alert_add_on_pending_order($date_range,$current_quantity)
	{
		error_reporting(0);
		$qty 	= 15;
		$f_qty 	= "";
		$time = time();
		$date = date("Y-m-d",$time);
		/*$date_range = date("d-M-Y",$time);
		$date_range = "FROM : $date_range  TO : $date_range";*/
		//$vdt = date("Y-m-d", strtotime("-1 days", $time)); // yha ek din old low stock alert lay kar ata ha
				
		$query = $this->db->query("select id,item_code from tbl_low_stock_alert where status='0'")->result();
		foreach($query as $row)
		{
			$id 		= $row->id;
			$item_code 	= $row->item_code;
			$row1 = $this->db->query("select item_name,company_name,division,packing from tbl_medicine where item_code='$item_code'")->row();
			if($row1->item_name!="")
			{
				$row2 = $this->db->query("select item_code from tbl_pending_order where item_code='$item_code'")->row();
				if($row2->item_code=="")
				{
					$item_name 	= $row1->item_name;
					$company	= $row1->company_name;
					$pack 		= $row1->packing;
					$division	= $row1->division;
					$qty 		= 10;
					
					/*if($current_quantity==0)
					{
						/***************18-01-2020*****************
						$qty = $this->check_last_qty($item_code,$qty);
						/******************************************
					}*/
					
					$dt = array(
					'company'=>$company,
					'item_code'=>$item_code,
					'item_name'=>$item_name,
					'pack'=>$pack,
					'qty'=>$qty,
					'f_qty'=>$f_qty,
					'division'=>$division,
					'date_range'=>$date_range,
					'date'=>$date,
					'time'=>$time,
					);
					$this->Scheme_Model->insert_fun("tbl_pending_order",$dt);
				}
				
				$this->db->query("update tbl_low_stock_alert set status='1' where id='$id'");
			}
		}
	}
	/*****************02-01-20***********************************/
	public function sales_deleted_add_on_pending_order($date_range,$current_quantity)
	{
		error_reporting(0);
		$qty 	= 15;
		$f_qty 	= "";
		$time = time();
		$date = date("Y-m-d",$time);
				
		$query = $this->db->query("select id,item_code from tbl_sales_deleted where status='0'")->result();
		foreach($query as $row)
		{
			$id 		= $row->id;
			$item_code 	= $row->item_code;
			$row1 = $this->db->query("select item_name,company_name,division,packing from tbl_medicine where item_code='$item_code'")->row();
			if($row1->item_name!="")
			{
				$row2 = $this->db->query("select item_code from tbl_pending_order where item_code='$item_code'")->row();
				if($row2->item_code=="")
				{
					$item_name 	= $row1->item_name;
					$company	= $row1->company_name;
					$pack 		= $row1->packing;
					$division	= $row1->division;
					$qty 		= 10;
					
					/*
					if($current_quantity==0)
					{
						/***************18-01-2020*****************
						$qty = $this->check_last_qty($item_code,$qty);
						/******************************************
					}*/
					
					$dt = array(
					'company'=>$company,
					'item_code'=>$item_code,
					'item_name'=>$item_name,
					'pack'=>$pack,
					'qty'=>$qty,
					'f_qty'=>$f_qty,
					'division'=>$division,
					'date_range'=>$date_range,
					'date'=>$date,
					'time'=>$time,
					);
					$this->Scheme_Model->insert_fun("tbl_pending_order",$dt);
				}
				
				$this->db->query("update tbl_sales_deleted set status='1' where id='$id'");
			}
		}
	}
	
	//04-01-20
	
	public function delete_rec()
	{
		$id = $_POST["id"];
		$Page_title = $this->Page_title;
		$Page_tbl = $this->Page_tbl;
		$result = $this->db->query("delete from $Page_tbl where id='$id'");
		if($result)
		{
			$message = "Delete Successfully.";
		}
		else
		{
			$message = "Not Delete.";
		}
		$message = $Page_title." - ".$message;
		$this->Admin_Model->Add_Activity_log($message);
		echo "ok";
	}
	
	public function change_qty()
	{
		$id 	= $_POST["id"];
		$qty 	= $_POST["qty"];
		$Page_title = $this->Page_title;
		$Page_tbl = $this->Page_tbl;
		$result = $this->db->query("update $Page_tbl set qty='$qty' where id='$id'");
		
		/***************18-01-2020*********************/
		$row = $this->db->query("select * from $Page_tbl where id='$id'")->row();		
		$this->db->query("update tbl_pending_order_medicine set qty='$qty' where item_code='$row->item_code'");
		/*********************************************/
		if($result)
		{
			$message = "Update Successfully.";
		}
		else
		{
			$message = "Not Update.";
		}
		$message = $Page_title." - ".$message;
		$this->Admin_Model->Add_Activity_log($message);
		echo "ok";
	}
	/***************18-01-2020*****************/
	public function check_last_qty($item_code,$qty)
	{
		$row = $this->db->query("select * from tbl_pending_order_medicine where item_code='$item_code'")->row();
		if($row->id=="")
		{
			$qty = "10";
		}
		else			
		{
			if($qty<=$row->qty)
			{
				// jab last qty badhi ha to jo crunt qty oss ko update kar day gay ku ki new qty badhi ha
				$this->db->query("update tbl_pending_order_medicine set qty='$qty' where item_code='$item_code'");
				$qty = $row->qty;
			}
		}
		return $qty;
	}
	public function download_pending_order_medicine()
	{
		$page_controllers 	= $this->page_controllers;	
		$this->Excel_Model->download_pending_order_medicine();
		//redirect(base_url()."admin/$page_controllers/view");
	}
}