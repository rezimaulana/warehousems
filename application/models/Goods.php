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

    function getById($id){
        $this->db->select('g.id, g.item, g.qty, g.goods_category_id, g.ver, g.is_active, gc.code, gc.name', false);
        $this->db->from('goods g');
        $this->db->join('goods_categories gc', 'gc.id = g.goods_category_id', 'inner');
        $this->db->where('g.id', $id);
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

    function insert() {
        $uuid = $this->db->query('SELECT UUID() AS uuid')->row()->uuid;
        $now = date('Y-m-d H:i:s');
        $data = array(
            'id' => $uuid,
            'item' => $this->input->post('item'),
            'goods_category_id' => $this->input->post('category'),
            'created_by' => $this->session->userdata('userdata')['id'],
            'created_at' => $now,
        );
        $query = $this->db->insert('goods', $data);
        if ($this->db->affected_rows() === 1) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    function deleteById($id, $ver) {
        $currentVer = $this->db->select('ver')->where('id', $id)->where('ver', $ver)->get('goods')->row()->ver;
        if ($currentVer == $ver) {
            $now = date('Y-m-d H:i:s');
            $data = array(
                'updated_by' => $this->session->userdata('userdata')['id'],
                'updated_at' => $now,
                'ver' => $currentVer + 1,
                'is_active' => 0,
            );
            $query = $this->db->where('id', $id)->update('goods', $data);
            if ($this->db->affected_rows() === 1) {
                $this->session->set_flashdata('error', RES_DELETED);
                return TRUE;
            }
            else {
                $this->session->set_flashdata('error', RES_FAILED);
                return FALSE;
            }
        } else {
            $this->session->set_flashdata('error', RES_VERSION_MISMATCH);
            return FALSE;
        }
    }
    
    function update(){
        $id = $this->input->post("id");
        $ver = $this->input->post("ver");
        $currentVer = $this->db->select('ver')->where('id', $id)->where('ver', $ver)->get('goods')->row()->ver;
        if ($currentVer == $ver) {
            $now = date('Y-m-d H:i:s');
            $data = array(
                'item' => $this->input->post("item"),
                'goods_category_id' => $this->input->post("category"),
                'updated_by' => $this->session->userdata('userdata')['id'],
                'updated_at' => $now,
                'ver' => $currentVer + 1,
            );
            $query = $this->db->where('id', $id)->update('goods', $data);
            if ($this->db->affected_rows() === 1) {
                $this->session->set_flashdata('error', RES_UPDATED);
                return TRUE;
            }
            else {
                $this->session->set_flashdata('error', RES_FAILED);
                return FALSE;
            }
        } else {
            $this->session->set_flashdata('error', RES_VERSION_MISMATCH);
            return FALSE;
        }
    }

}