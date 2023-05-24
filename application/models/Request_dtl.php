<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Request_dtl extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }

    function getByHeaderId($id){
        $this->db->select('rd.id, rd.qty as req_qty, rd.goods_id, g.item, g.qty, g.goods_category_id, g.is_active, gs.code, gs.name, rd.ver', false);
        $this->db->from('request_dtl rd');
        $this->db->join('goods g', 'g.id = rd.goods_id', 'inner');
        $this->db->join('goods_categories gs', 'gs.id = g.goods_category_id', 'inner');
        $this->db->where('rd.request_hdr_id', $id);
        $this->db->where('rd.is_active', true);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        else {
            return false;
        }
    }

    function getByGoodsId($id){
        $this->db->select('rh.trx_code, rd.qty, rt.name, rd.updated_at', false);
        $this->db->from('request_dtl rd');
        $this->db->join('request_hdr rh', 'rh.id = rd.request_hdr_id', 'inner');
        $this->db->join('request_types rt', 'rt.id = rh.request_type_id', 'inner');
        $this->db->where('rd.goods_id', $id);
        $this->db->where('rh.approval', true);
        $this->db->where('rd.is_active', true);
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