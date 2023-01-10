<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Manage_broadcast extends CI_Controller {
	var $Page_title = "Manage Broadcast";	
	var $Page_name  = "manage_broadcast";
	var $Page_view  = "manage_broadcast";
	var $Page_menu  = "manage_broadcast";
	var $page_controllers = "manage_broadcast";
	var $Page_tbl   = "tbl_broadcast";
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
		$data['url_path'] = base_url()."uploads/$page_controllers/photo/";
		$upload_path = "./uploads/$page_controllers/photo/";	

		$system_ip = $this->input->ip_address();
		extract($_POST);
		if(isset($Submit))
		{
			$title		    = base64_encode($title);
			$broadcast 		= base64_encode($broadcast);
			
			$message_db = "";
			$time = time();
			$date = date("Y-m-d",$time);
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
				$user_type = "chemist";
				$chemist_id = $row1->altercode;
				
				$dt = array(
				'chemist_id'=>$chemist_id,
				'user_type'=>$user_type,
				'title'=>$title,
				'broadcast'=>$broadcast,);
				
				$this->Scheme_Model->insert_fun("tbl_broadcast",$dt);
				
				$where = array('chemist_id'=>$chemist_id,'user_type'=>$user_type);
				$dt = array(
				'title'=>$title,
				'broadcast'=>$broadcast,
				);
				$this->Scheme_Model->edit_fun("tbl_android_device_id",$dt,$where);
				
				/*$where = array('id'=>$row1->id);
				$result = "";
				$dt = array(
				'title'=>$title,
				'broadcast'=>$broadcast1,
				);
				$result = $this->Scheme_Model->edit_fun("tbl_android_device_id",$dt,$where);*/
			}
			
			if($chemist_id=="0")
			{
				$query1 = $this->db->query("select * from tbl_acm_other order by id asc")->result();
			}
			else
			{
				$row1 = $this->db->query("select * from tbl_acm where altercode='$chemist_id' and slcd='CL'")->row();
				
				$code = $row1->code;
				$query1 = $this->db->query("select * from tbl_acm_other where code='$code' ")->result();
			}
			foreach($query1 as $row1)
			{				
				$where = array('id'=>$row1->id);
				$result = "";
				$dt = array(
				'broadcast'=>$broadcast2,
				);
				$result = $this->Scheme_Model->edit_fun("tbl_acm_other",$dt,$where);
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

		/*$where = array('status'=>"0");
		$data["result"] = $this->Admin_Model->select_result("tbl_broadcast",$where,"id","asc");*/

		$this->load->library('pagination');

		$result = $this->db->query("select * from $tbl where status='0' order by id desc")->result();
		
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

		$query = $this->db->query("select * from $tbl where status='0' order by id desc LIMIT $per_page,100");
  		$data["result"] = $query->result();

		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/view",$data);
		$this->load->view("admin/header_footer/footer",$data);
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
}