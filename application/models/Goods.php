<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Goods extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }

    function getAll(){
        $this->db->select('g.id, g.item, g.qty, g.goods_category_id, g.ver, g.is_active, gc.code, gc.name', false);
        $this->db->from('goods g');
        $this->db->join('goods_categories gc', 'gc.id = g.goods_category_id', 'inner');
        $this->db->where('g.is_active', true);
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