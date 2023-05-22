<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Goods_categories extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }

    function getAll(){
        $this->db->select('*');
        $this->db->from('goods_categories gc');
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