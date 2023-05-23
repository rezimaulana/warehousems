<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Request_hdr extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }

    function getAll(){
        $this->db->select(
            'rh.id, rh.trx_code, rh.request_type_id, rh.requested_by, rh.approved_by, rh.approval,
            rh.created_at, rh.ver, 
            adm.fullname as adm_fullname, 
            usr.fullname as user_fullname, 
            rt.code, rt.name, 
            COUNT(rd.id) as item_count, 
            SUM(rd.qty) as item_sum', 
            false
        );
        $this->db->from('request_hdr rh');
        $this->db->join('users adm', 'adm.id = rh.approved_by', 'left');
        $this->db->join('users usr', 'usr.id = rh.requested_by', 'inner');
        $this->db->join('request_types rt', 'rt.id = rh.request_type_id', 'inner');
        $this->db->join('request_dtl rd', 'rd.request_hdr_id = rh.id', 'right');
        $this->db->where('rh.is_active', true);
        $this->db->group_by('rh.id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        else {
            return false;
        }
    }
    
    
}