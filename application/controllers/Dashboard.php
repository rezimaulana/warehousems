<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends MY_Controller{
    function __construct(){
        parent::__construct();
    }

    function index(){
        if($this->session->userdata('userdata')['code']===CODE_ROLE_ADMIN ||
            $this->session->userdata('userdata')['code']===CODE_ROLE_USER) {
                $data['title']="Dashboard";
                $this->load->view('fragment/header', $data);
                if($this->session->userdata('userdata')['code']===CODE_ROLE_ADMIN){
                    $this->load->view('fragment/navAdmin');
                    $this->load->view('dashboard/admin/dashboard', $data);
                }
                if($this->session->userdata('userdata')['code']===CODE_ROLE_USER){
                    $this->load->view('fragment/navUser');
                    $this->load->view('dashboard/user/dashboard', $data);
                }
                $this->load->view('fragment/footer');
        }
        else{
            redirect(base_url()); 
        }
    }

}