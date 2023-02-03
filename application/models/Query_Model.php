<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Query_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function get_Manage_android_info1()
    {
        $this->db->select('t1.id,t1.user_type,t1.time,t1.logout,t1.clear_database,t1.broadcast,t1.versioncode,t1.chemist_id,t2.name');
        $this->db->from('tbl_android_device_id as t1');
        $this->db->join('tbl_acm as t2', 't1.chemist_id = t2.altercode', 'left');
        $this->db->order_by("t1.time", "desc");
        $query = $this->db->get();
        return $query->result();
    } 

    public function get_Manage_master1()
    {
        $this->db->select('t1.id,t1.altercode,t1.name,t1.email,t1.mobile,t1.altercode,t2.status');
        $this->db->from('tbl_master as t1');
        $this->db->join('tbl_master_other as t2', 't1.code = t2.code', 'left');
        $this->db->order_by("t1.code", "asc");
        $query = $this->db->get();
        return $query->result();
    } 
}