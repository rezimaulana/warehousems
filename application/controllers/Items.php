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

    function create(){
        if($this->session->userdata('userdata')['code']===CODE_ROLE_ADMIN){
            $data['title']="Create Item";
            $data['categories'] = $this->Goods_categories->getAll();
            $this->load->view('fragment/header', $data);
            $this->load->view('fragment/navAdmin');
            $this->load->view('items/admin/create', $data);
            $this->load->view('fragment/footer');
        } else {
            redirect(base_url());
        }
    }

    function insert(){
        $result = $this->Goods->insert(); 
        if($result) {
            $this->session->set_flashdata('success', RES_CREATED);
            redirect(base_url('items'));
        } else {
            $this->session->set_flashdata('error', RES_FAILED); 
            redirect(base_url('items'));
        }
    }

    function delete($id, $ver){
        $this->Goods->deleteById($id, $ver);
        redirect(base_url('items'));
    }

    function edit($id){
        if($this->session->userdata('userdata')['code']===CODE_ROLE_ADMIN){
            $data['title']="Edit Item";
            $data['result']= $this->Goods->getById($id);
            if($data['result']){
                $data['categories'] = $this->Goods_categories->getAll();
                $this->load->view('fragment/header', $data);
                $this->load->view('fragment/navAdmin');
                $this->load->view('items/admin/edit', $data);
                $this->load->view('fragment/footer');
            } else {
                show_404();
            }
        } else {
            redirect(base_url());
        }
    }

    function update(){
        $this->Goods->update();
        redirect(base_url("items"));
    }

}