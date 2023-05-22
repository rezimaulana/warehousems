<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }

    function login($email, $password){
        $this->db->select('u.id, u.email, u.username, u.fullname, u.role_id, u.is_active, r.code, r.name', false);
        $this->db->from('users u');
        $this->db->join('roles r', 'r.id = u.role_id', 'inner');
        $this->db->where('u.email', $email);
        $this->db->where('u.password', $password);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $userdata = $query->row_array();
            $this->session->set_userdata('userdata', $userdata);
            return true;
        }
        else {
            return false;
        }
    }
    
}