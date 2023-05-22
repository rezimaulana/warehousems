<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Items extends MY_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("Goods");
        $this->load->model("Goods_categories");
    }

    function index(){
        if($this->session->userdata('userdata')['code']===CODE_ROLE_ADMIN ||
            $this->session->userdata('userdata')['code']===CODE_ROLE_USER) {
                $data['title']="Items";
                $data['result'] = $this->Goods->getAll();
                $data['categories'] = $this->Goods_categories->getAll();
                $this->load->view('fragment/headerTable', $data);
                if($this->session->userdata('userdata')['code']===CODE_ROLE_ADMIN){
                    $this->load->view('fragment/navAdmin');
                    $this->load->view('items/admin/index', $data);
                }
                if($this->session->userdata('userdata')['code']===CODE_ROLE_USER){
                    $this->load->view('fragment/navUser');
                    $this->load->view('items/user/index', $data);
                }
                $this->load->view('fragment/footerTableFilterCategory');
        }
        else{
            redirect(base_url()); 
        }
    }

}