<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Manage_notification extends CI_Controller {
	var $Page_title = "Manage Notification";	
	var $Page_name  = "manage_notification";
	var $Page_view  = "manage_notification";
	var $Page_menu  = "manage_notification";
	var $page_controllers = "manage_notification";
	var $Page_tbl   = "tbl_android_notification";
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
		$data['url_path'] 	= base_url()."uploads/$page_controllers/photo/resize/";
		$upload_path 		= "./uploads/$page_controllers/photo/main/";
		$upload_resize 		= "./uploads/$page_controllers/photo/resize/";

		$system_ip = $this->input->ip_address();
		$med_item_id = "";
		extract($_POST);
		if(isset($Submit))
		{
			$title 			= base64_encode($title);
			$subject 		= base64_encode($subject);
			$message		= nl2br($message);
			//$message		= str_replace("<br />","\\n",$message);			
			$message 		= base64_encode($message);
			
			
			$message_db = "";
			$time = time();
			$date = date("Y-m-d",$time);

			if (!empty($_FILES["image"]["name"]))
			{
				$this->Image_Model->uploadTo = $upload_path;
				$image = $this->Image_Model->upload($_FILES['image']);
				$image = str_replace($upload_path,"",$image);

				$this->Image_Model->newPath = $upload_resize;
				$this->Image_Model->newWidth = 550;
				$this->Image_Model->newHeight = 550;
				$this->Image_Model->resize();
			}		
			else
			{
				$image = "";
			}			

			$result = "";
			if($altercode=="0" || $altercode=="")
			{
				$query1 = $this->db->query("select * from tbl_acm where slcd='CL' order by name asc")->result();
			}
			else
			{
				$query1 = $this->db->query("select * from tbl_acm where slcd='CL' and altercode='$altercode' order by name asc")->result();
			}
			foreach($query1 as $row1)
			{	
				if($row1->altercode!="")
				{
					$altercode = $row1->altercode;
					$result = $this->send_android_notification($title,$message,$altercode,"chemist",$funtype,$itemid,$compid,$division,$image);
				}
			}
			if($result)
			{
				$message_db = "($property_title) - Add Successfully.";
				$message = "Add Successfully.";
				$this->session->set_flashdata("message_type","success");
			}
			else
			{
				$message_db = "($property_title) - Not Add.";
				$message = "Not Add.";
				$this->session->set_flashdata("message_type","error");
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
		}		

		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/add",$data);
		$this->load->view("admin/header_footer/footer",$data);
	}
	public function view()
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

		$data['title1'] = $Page_title." || View";
		$data['title2'] = "View";
		$data['Page_name'] = $Page_name;
		$data['Page_menu'] = $Page_menu;

		$this->breadcrumbs->push("Admin","admin/");
		$this->breadcrumbs->push("$Page_title","admin/$page_controllers/");
		$this->breadcrumbs->push("View","admin/$page_controllers/view");	

		$tbl = $Page_tbl;	

		$data['url_path'] = base_url()."uploads/$page_controllers/photo/";
		$upload_path = "./uploads/$page_controllers/photo/";			

		$this->load->library('pagination');

		$result = $this->db->query("select * from $tbl where firebase_status=0 order by id desc")->result();
		
		$config['total_rows'] = count($result);
		$data["count_records"] = count($result);
        $config['per_page'] = 100;

        if($num!=""){
           $config['per_page'] = $num;
        }
        $config['full_tag_open']="<ul class='pagination'>";
        $config['full_tag_close']="</ul>";
        $config['first_tag_open']='<li>';
        $config['first_tag_close']='</li>';
        $config['last_tag_open']='<li>';
        $config['last_tag_close']='</li>';
        $config['next_tag_open']='<li>';
        $config['next_tag_close']='</li>';
        $config['prev_tag_open']='<li>';
        $config['prev_tag_close']='</li>';
        $config['num_tag_open']='<li>';
        $config['num_tag_close']='</li>';
        $config['cur_tag_open']="<li class='active'><a>";
        $config['cur_tag_close']='</a></li>';
        $config['num_links'] = 100;    
        $config['page_query_string'] = TRUE;
		$per_page=$_GET["pg"];
		if($per_page=="")
		{
			$per_page = 0;
		}


		$data['per_page']=$per_page;
		
		$data['user_id'] = $user_id;

		$query = $this->db->query("select * from $tbl where firebase_status=0 order by id desc LIMIT $per_page,100");
  		$data["result"] = $query->result();

		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/view",$data);
		$this->load->view("admin/header_footer/footer",$data);
	}
	
	public function send_android_notification($title,$message,$chemist_id,$user_type,$funtype,$itemid,$compid,$division,$image)
	{
		$time = time();
		$date = date("Y-m-d",$time);
		
		/*$result = $this->db->query("select * from tbl_android_device_id where chemist_id='$chemist_id'")->result();
		foreach($result as $row)
		{
			$device_id =  $row->device_id;
			
			$dt = array(
			'chemist_id'=>$chemist_id,
			'user_type'=>$user_type,
			'title'=>$title,
			'message'=>$message,
			'time'=>$time,
			'date'=>$date,
			'device_id'=>$device_id,
			'funtype'=>$funtype,
			'itemid'=>$itemid,
			'compid'=>$compid,
			'division'=>$division,);
			
			$this->Scheme_Model->insert_fun("tbl_android_notification",$dt);
		}*/
		
		$device_id =  "default"; // yha sirf website or android me show ke liya use hota ha web page par show ki liya sirf
			
		$dt = array(
		'chemist_id'=>$chemist_id,
		'user_type'=>$user_type,
		'title'=>$title,
		'message'=>$message,
		'time'=>$time,
		'date'=>$date,
		'device_id'=>$device_id,
		'funtype'=>$funtype,
		'itemid'=>$itemid,
		'compid'=>$compid,
		'division'=>$division,
		'image'=>$image,);
		
		$this->Scheme_Model->insert_fun("tbl_android_notification",$dt);
		return 1;
	}
	
	public function call_search_acm()
	{		
		error_reporting(0);
		?><ul style="margin: 0px;padding: 0px;"><?php
		$acm_name = $this->input->post('acm_name');
		$result =  $this->db->query ("select * from tbl_acm where name Like '$acm_name%' or name Like '%$acm_name' or altercode='$acm_name' limit 50")->result();
		foreach($result as $row)
		{
			$id = $row->altercode;
			$name = ($row->name);
			$name1 = base64_encode($row->name);
			$altercode = ($row->altercode);
			?>
			<li style="list-style: none;margin: 5px;"><a href="javascript:addacm('<?= $id ?>','<?= $name1 ?>')"><?= $name ?> (<?= $altercode ?>)</a></li>
			<?php
		}
		?></ul><?php
	}
	
	public function call_search_item()
	{		
		error_reporting(0);
		?><ul style="margin: 0px;padding: 0px;"><?php
		$item_name = $this->input->post('item_name');
		$result =  $this->db->query ("select id,i_code,item_name,item_code from tbl_medicine where item_name Like '$item_name%' or item_name Like '%$item_name' limit 50")->result();
		foreach($result as $row)
		{
			$id = $row->i_code;
			$item_name = ($row->item_name);
			$item_name1 = base64_encode($row->item_name);
			$item_code = ($row->item_code);
			?>
			<li style="list-style: none;margin: 5px;"><a href="javascript:additem(<?= $id ?>,'<?= $item_name1 ?>')"><?= $item_name ?> (<?= $item_code ?>)</a></li>
			<?php
		}
		?></ul><?php
	}
	
	public function call_search_company()
	{		
		error_reporting(0);
		?><ul style="margin: 0px;padding: 0px;"><?php
		$company_full_name = $this->input->post('company_name');
		$result =  $this->db->query ("select DISTINCT company_full_name,compcode from tbl_medicine where company_full_name Like '$company_full_name%' or company_name Like '%$company_full_name' limit 50")->result();
		foreach($result as $row)
		{
			$id = $row->compcode;
			$company_full_name = ($row->company_full_name);
			$company_full_name1 = base64_encode($row->company_full_name);
			$compcode = ($row->compcode);
			?>
			<li style="list-style: none;margin: 5px;"><a href="javascript:addcompany(<?= $id ?>,'<?= $company_full_name1 ?>')"><?= $company_full_name ?> (<?= $compcode ?>)</a></li>
			<?php
		}
		?></ul><?php
	}
	
	public function get_company_division()
	{		
		error_reporting(0);
		$compid = $this->input->post('compid');
		?><select name="division" id="division" class="form-control">
			<option value="">
				Select Company Division
			</option>
			<?php
			$result =  $this->db->query ("select DISTINCT division from tbl_medicine where compcode='$compid' order by division asc")->result();
			foreach($result as $row)
			{
				$division = $row->division;
				?>
				<option value="<?= $division ?>">
					<?= $division ?>
				</option>
				<?php
			}
		?></select><?php
	}
}