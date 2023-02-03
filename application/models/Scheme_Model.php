<?php
ini_set('memory_limit','-1');
ini_set('post_max_size','100M');
ini_set('upload_max_filesize','100M');
ini_set('max_execution_time',36000);
defined('BASEPATH') OR exit('No direct script access allowed');
class Scheme_Model extends CI_Model  
{	
	function select_all_result($tbl,$where,$orderby='',$asc_desc='')
	{
		if($where!="")
		{
			$this->db->where($where);
		}
		if($orderby!="")
		{
			$this->db->order_by($orderby,$asc_desc);
		}
		return $this->db->get($tbl)->result();	
	}
	
	function select_row($tbl,$where)
	{
		if($where!="")
		{
			$this->db->where($where);
		}
		return $this->db->get($tbl)->row();	
	}
	function insert_fun($tbl,$dt)
	{
		if($this->db->insert($tbl,$dt))		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}
	}
	function select_all_fun($tbl,$where)
	{
		if($where!="")
		{
			$this->db->where($where);
		}
		return $this->db->get($tbl)->result_array();	
	}
	function select_all_fun_order_by($tbl,$where,$orderby)
	{		if($where!="")
		{
			$this->db->where($where);
		}
		if($orderby!="")
		{
			$this->db->order_by($orderby);
		}
		return $this->db->get($tbl)->result_array();
	}	function edit_fun($tbl,$dt,$where)
	{
		if($this->db->update($tbl,$dt,$where))
		{
			return true;		}
		else
		{
			return false;
		}
	}	function delete_fun($tbl,$where)
	{
		if($this->db->delete($tbl,$where))
		{
			return true;		}
		else
		{
			return false;
		}
	}
	public function get_website_data($page_type)
	{
		$query = $this->db->query("select * from tbl_website where page_type='$page_type'")->row();
		if($query->mydata=="")
		{
			$query->mydata = base64_encode("");
		}
		return base64_decode($query->mydata);
	}}  