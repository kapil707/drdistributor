<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller {
	var $Page_title = "Dashboard";
	var $Page_name  = "dashboard";
	var $Page_view  = "dashboard";
	var $Page_menu  = "dashboard";
	var $Page_tbl   = "";
	var $page_controllers = "dashboard";
	public function index()
	{
		error_reporting(0);
		/******************session***********************/
		$user_id = $this->session->userdata("user_id");
		/******************session***********************/	

		$Page_title = $this->Page_title;
		$Page_name 	= $this->Page_name;
		$Page_view 	= $this->Page_view;
		$Page_menu 	= $this->Page_menu;
		$Page_tbl 	= $this->Page_tbl;
		$page_controllers 	= $this->page_controllers;	

		$data['title1'] = $Page_title." || Dashboard";
		$data['title2'] = "Dashboard";
		$data['Page_name'] = $Page_name;
		$data['Page_menu'] = $Page_menu;
		$this->breadcrumbs->push("Admin","admin/");
		$this->breadcrumbs->push("$Page_title","admin/$page_controllers/");
		//$this->breadcrumbs->push("Add","admin/$page_controllers/add");	

		$tbl = $Page_tbl;

		$user_type = $this->session->userdata("user_type");
		if($user_type=="")
		{
			$this->session->set_flashdata("message","<p class='font-bold  alert alert-warning m-b-sm'>Your Account Not Approved</p>");	

			$this->session->set_flashdata("message_footer","yes");
			$this->session->set_flashdata("message_type","warning");
			$this->session->set_flashdata("full_message","Your Account Not Approved.");
		}
		/***********************************************/	

		$total_medicine = $total_acm = $total_staffdetail = $total_salesman = $today_total_sales = $today_master = 0;
		
		$result = $this->db->query("select id from tbl_master where slcd='SM' and altercode!=''")->result();
		foreach($result as $row)
		{
			$today_master++;
		}

		$result = $this->db->query("select id from tbl_medicine")->result();
		foreach($result as $row)
		{
			$total_medicine++;
		}	

		$result = $this->db->query("select id from tbl_acm where slcd='CL'")->result();
		foreach($result as $row)
		{
			$total_acm++;
		}	

		$result = $this->db->query("select id from tbl_staffdetail")->result();
		foreach($result as $row)
		{
			$total_staffdetail++;
		}		

		$result = $this->db->query("select id from tbl_users")->result();
		foreach($result as $row)
		{
			$total_salesman++;
		}
		
		
		$vdt = date("Y-m-d");
		$result = $this->db->query("select amt from tbl_invoice where date='$vdt'")->result();
		foreach($result as $row)
		{
			$today_total_sales = $today_total_sales + round($row->amt);
		}
		
		$top_10_medicine = "";
		/*$result = $this->db->query("select DISTINCT item_name, COUNT(*) as ct FROM tbl_sales where vdt='$vdt' GROUP BY item_name HAVING COUNT(*) > 1 order by ct desc limit 10")->result();
		foreach($result as $row)
		{
			$top_10_medicine.= "{ y: '$row->item_name', a: $row->ct},";
		}
		if ($top_10_medicine != '') {
			$top_10_medicine = substr($top_10_medicine, 0, -1);
		}*/
		
		$today_orders1 = $today_orders2 = $today_orders3 = $today_website_orders_items = $today_android_orders_items = $today_excel_orders_items = 0;
		$date = date("Y-m-d");
		$result = $this->db->query("select DISTINCT order_id from tbl_order where date='$date'")->result();
		foreach($result as $row)
		{
			$today_orders1++;
		}
		
		$result = $this->db->query("select DISTINCT order_id from tbl_order where date='$date' and download_status='0'")->result();
		foreach($result as $row)
		{
			$today_orders2++;
		}
		
		$result = $this->db->query("select DISTINCT chemist_id from tbl_order where date='$date'")->result();
		foreach($result as $row)
		{
			$today_orders3++;
		}
		
		$result = $this->db->query("select DISTINCT order_id from tbl_order where date='$date' and order_type='pc_mobile'")->result();
		foreach($result as $row)
		{
			$today_website_orders_items++;
		}
		
		$result = $this->db->query("select DISTINCT order_id from tbl_order where date='$date' and order_type='excelFile'")->result();
		foreach($result as $row)
		{
			$today_excel_orders_items++;
		}
		
		$result = $this->db->query("select DISTINCT order_id from tbl_order where date='$date' and order_type='android'")->result();
		foreach($result as $row)
		{
			$today_android_orders_items++;
		}
		
		$date = date("Y-m-d");
		
		$result = $this->db->query("select gstvno from tbl_invoice where date='$date'")->result();
		foreach($result as $row)
		{
			$today_invoice++;
		}
		
		$today_orders_price = $today_orders_items = 0;
		$date = date("Y-m-d");
		$result = $this->db->query("select * from tbl_order where date='$date'")->result();
		foreach($result as $row)
		{
			$today_orders_price = $today_orders_price + ($row->quantity * $row->sale_rate);
			$today_orders_items++;
		}
		
		$data["total_medicine"] 	= $total_medicine;
		$data["total_acm"] 			= $total_acm;
		$data["total_staffdetail"] 	= $total_staffdetail;
		$data["total_salesman"] 	= $total_salesman;
		$data["today_master"] 		= $today_master;
		$data["today_total_sales"] 	= utf8_encode(money_format('%!.0n',$today_total_sales));
		$data["top_10_medicine"] 	= $top_10_medicine;
		$data["today_orders"]		= $today_orders1."/".$today_orders2;
		$data["today_orders3"]		= $today_orders3;
		$data["today_pending_invoice_email"]	= $today_pending_invoice_email;
		$data["today_invoice"]		= $today_invoice;
		
		$data["today_orders_price"]	= utf8_encode(money_format('%!.0n',$today_orders_price));
		$data["today_orders_items"]	= $today_orders_items;
		$data["today_website_orders_items"]	= $today_website_orders_items;
		$data["today_android_orders_items"]	= $today_android_orders_items;
		$data["today_excel_orders_items"]	= $today_excel_orders_items;

		$this->load->view('admin/header_footer/header',$data);
		$this->load->view("admin/$Page_view/index",$data);
		$this->load->view('admin/header_footer/footer',$data);
		$this->load->view("admin/$Page_view/".$Page_view."_footer",$data);
	}	

	public function edit_profile()
	{
		/******************session***********************/
		$user_id = $this->session->userdata("user_id");
		/******************session***********************/		

		$Page_title = $this->Page_title;
		$Page_name 	= $this->Page_name;
		$Page_view 	= $this->Page_view;
		$Page_menu 	= $this->Page_menu;
		$Page_tbl 	= $this->Page_tbl;
		$page_controllers 	= $this->page_controllers;		

		$data['title1'] = $Page_title." || Edit Profile";
		$data['title2'] = "Edit Profile";
		$data['Page_name'] = $Page_name;
		$data['Page_menu'] = $Page_menu;
		$this->breadcrumbs->push("Admin","admin/");
		$this->breadcrumbs->push("$Page_title","admin/$page_controllers/");
		$this->breadcrumbs->push("Edit Profile","admin/$page_controllers/add");	

		$tbl = $Page_tbl;
		$data['url_path'] = base_url()."uploads/manage_users/photo/";
		$upload_path = "./uploads/manage_users/photo/";
		$upload_thumbs_path = "./uploads/manage_users/photo/thumbs/";		

		extract($_POST);
		if(isset($Submit))
		{
			$result = "";
			$this->form_validation->set_rules('name','Name',"required");
			if($password!="")
			{
				$this->form_validation->set_rules('password','Password','trim|required|min_length[6]|alpha_numeric',
				array(
				"min_length"=>"<p class='font-bold  alert alert-danger m-b-sm'>Min 6 charter length.</p>"
				));
				$this->form_validation->set_rules('password1','Password Confirmation','trim|required|matches[password]');				

				$password = md5($password);
				$password = sha1($password);
				$password = md5($password);
			}
			else
			{
				$password = $old_password;
			}			

			if ($this->form_validation->run() == FALSE)
			{
				$message = "Check Validation.";
				$this->session->set_flashdata("message_type","warning");
			}
			else
			{
				$image = "";
				if (!empty($_FILES["photo"]["name"]))
				{
					$name1 = "photo";
					$x = $_FILES["photo"]['name'];
					$y = $_FILES["photo"]['tmp_name'];
					$image = $this->Scheme_Model->photo_up($name1,$x,$y,$upload_path,$upload_thumbs_path,"60");
				}
				else
				{
					$image = $old_photo;
				}			

				$where = array('id'=>$user_id);
				$dt = array('name'=>$name,'image'=>$image,'password'=>$password,);
				$result = $this->Scheme_Model->edit_fun("tbl_user",$dt,$where);
				if($result)
				{
					$this->Admin_Model->admin_login($old_email,$password);
					$message = "Edit Successfully.";
					$this->session->set_flashdata("message_type","success");
				}
				else
				{
					$message = "Not Add.";
					$this->session->set_flashdata("message_type","error");
				}
			}
			$message = "Edit Profile"." - ".$message;
			$this->session->set_flashdata("message_footer","yes");
			$this->session->set_flashdata("full_message",$message);
			$this->Admin_Model->Add_Activity_log($message);
			if($result)
			{
				redirect(base_url()."admin/$page_controllers/edit_profile");
			}
		}		

		$query = $this->db->query("select * from tbl_user where id='$user_id'");
  		$data["result"] = $query->result();						

		$this->load->view('admin/header_footer/header',$data);
		$this->load->view("admin/$Page_view/edit_profile",$data);
		$this->load->view('admin/header_footer/footer',$data);
	}	

	public function delete_photo()
	{
		$id = $this->session->userdata("user_id");
		$result = $this->db->query("update tbl_user set photo='default.jpg' where id='$id'");
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

	public function check_login()
	{
		$user_id = $this->session->userdata('user_id');
		$user_password = $this->session->userdata('user_password');
		if(!empty($user_id) && $user_id !='')
		{
			$query = $this->db->query("select * from tbl_user where id='$user_id' and password='$user_password'");
  			$row = $query->row();
			if($row)
			{
				if($row->updateme==1)
				{
					$id = $row->id;
					$this->db->query("update tbl_user set updateme='0' where id='$user_id' and password='$user_password'");				

					$user_password = $row->password;
					$user_type = $row->user_type;				

					$session_arr = array('user_id'=>$row->id,'name'=>$row->name,'user_email'=>$row->email,'username'=>$row->username,'user_type'=>$user_type,'user_password'=>$user_password);
					$this->session->set_userdata($session_arr);
					echo "update";
				}
				else
				{
					$make_interest_count = $contact_form_count = $feedback_count = 0;
					$query = $this->db->query("select * from tbl_make_interest where status='0'");
					$result = $query->result();
					foreach($result as $row)
					{
						$make_interest_count++;
					}
					$query = $this->db->query("select * from tbl_feedback where status='0'");
					$result = $query->result();
					foreach($result as $row)
					{
						$feedback_count++;
					}
					$query = $this->db->query("select * from tbl_contact_form where status='0'");
					$result = $query->result();
					foreach($result as $row)
					{
						$contact_form_count++;
					}
					if($make_interest_count==0)
					{
						$make_interest_count="";
					}
					if($feedback_count==0)
					{
						$feedback_count="";
					}
					if($contact_form_count==0)
					{
						$contact_form_count="";
					}
					?>
                    <script>
					$("#make_interest_count").html("<?= $make_interest_count ?>");
					$("#feedback_count").html("<?= $feedback_count ?>");
					$("#contact_form_count").html("<?= $contact_form_count ?>");
					</script>
                    <?php
				}
			}
			else
			{
				echo "notok";
				$this->session->sess_destroy();
			}
		}
		else
		{
			echo "notok";
			$this->session->sess_destroy();
		}
		//$this->Auto_Time_Table_Model->Process();
	}

	public function notify()
	{
		$pgtype = $_POST["pgtype"];
		if($pgtype!="")
		{
			if($pgtype=="make_interest")
			{
				$query = $this->db->query("select * from tbl_make_interest where status='0' order by id desc limit 4");
				$result = $query->result();
				foreach($result as $row)
				{
					?>
				<li>
					<div class="dropdown-messages-box">
						<a href="<?= base_url(); ?>admin/manage_make_interest/edit/<?php echo $row->id; ?>">
							<div class="media-body">
                            	<?php
								$type = $row->type;
								$property_id = $row->property_id;
								if($type=="property")
								{
									$query = $this->db->query("select * from tbl_property where id='$property_id'");
								}
								if($type=="vehicles")
								{
									$query = $this->db->query("select * from tbl_vehicles where id='$property_id'");
								}
								$row1 = $query->row();
								?>
								<strong><?php echo base64_decode($row->name); ?>
                                </strong> 
                                interested on your 
                                <?php if($type=="property") { ?>
								<?= base64_decode($row1->property_title); ?> property.
                                <?php } ?>                                

                                <?php if($type=="vehicles") { ?>
								<?= base64_decode($row1->title); ?> vehicles.
                                <?php } ?>
                                <br>
								<small class="text-muted">
								<?php
								$display_time_H = date("H",$row->time);
								$display_time_i = date("i",$row->time);
								echo $time= date("d-M-Y",$row->time)." at ".$this->Scheme_Model->time_conveter($display_time_H,$display_time_i);
								?>
								</small>
							</div>
						</a>
					</div>
				</li>			

				<li class="divider"></li>
				<?php } ?>
				<li>
					<div class="text-center link-block">
						<a href="<?= base_url(); ?>admin/manage_make_interest">
							<i class="fa fa-envelope"></i> <strong>
                            See All People Interest
                            </strong>
						</a>
					</div>
				</li>
				<?php
			}			

			if($pgtype=="feedback")
			{
				$query = $this->db->query("select * from tbl_feedback where status='0' order by id desc limit 4");
				$result = $query->result();
				foreach($result as $row)
				{
					?>
				<li>
					<div class="dropdown-messages-box">
						<a href="<?= base_url(); ?>admin/manage_feedback/edit/<?= $row->id ?>">
							<div class="media-body">
								<strong><?php echo base64_decode($row->name); ?></strong> send feadback. <br>
								<small class="text-muted">
								<?php
								$display_time_H = date("H",$row->time);
								$display_time_i = date("i",$row->time);
								echo $time= date("d-M-Y",$row->time)." at ".$this->Scheme_Model->time_conveter($display_time_H,$display_time_i);
								?>
								</small>
							</div>
						</a>
					</div>
				</li>			

				<li class="divider"></li>
				<?php } ?>
				<li>
					<div class="text-center link-block">
						<a href="<?= base_url(); ?>admin/manage_feedback">
							<i class="fa fa-envelope"></i> <strong>
                            	See All Submited Feedbacks
                            </strong>
						</a>
					</div>
				</li>
				<?php
			}		

			if($pgtype=="contact_form")
			{
				$query = $this->db->query("select * from tbl_contact_form where status='0' order by id desc limit 4");
				$result = $query->result();
				foreach($result as $row)
				{
					?>
				<li>

					<div class="dropdown-messages-box">
						<a href="<?= base_url(); ?>admin/manage_contact_form/edit/<?= $row->id ?>">
							<div class="media-body">
								<strong><?php echo base64_decode($row->email); ?></strong> send contact from. <br>
								<small class="text-muted">
								<?php
								$display_time_H = date("H",$row->time);
								$display_time_i = date("i",$row->time);
								echo $time= date("d-M-Y",$row->time)." at ".$this->Scheme_Model->time_conveter($display_time_H,$display_time_i);
								?>
								</small>
							</div>
						</a>
					</div>
				</li>				

				<li class="divider"></li>
				<?php } ?>
				<li>
					<div class="text-center link-block">
						<a href="<?= base_url(); ?>admin/manage_contact_form">
							<i class="fa fa-envelope"></i> <strong>
                            	See All Submited Contacts
                            </strong>
						</a>
					</div>
				</li>
				<?php
			}		

			$this->db->query("update tbl_$pgtype set status='1' where status='0'");
		}
	}

	public function set_theme()
	{
		$id = $_POST["selected_theme"];
		$this->db->query("update tbl_theme set selected_theme='0' where selected_theme='1'");
		$this->db->query("update tbl_theme set selected_theme='1' where id='$id'");
		echo "ok";
	}

	public function set_website_type()
	{
		$id = $_POST["website_type"];
		$this->db->query("update tbl_website_type set selected_theme='0' where selected_theme='1'");
		$this->db->query("update tbl_website_type set selected_theme='1' where id='$id'");
		echo "ok";
	}

	public function set_website_type1()
	{
		$id = $_POST["website_type"];
		$this->db->query("update tbl_website_type1 set selected_theme='0' where selected_theme='1'");
		$this->db->query("update tbl_website_type1 set selected_theme='1' where id='$id'");
		echo "ok";
	}
}