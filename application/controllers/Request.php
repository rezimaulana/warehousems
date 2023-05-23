<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Request extends MY_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("Goods");
        $this->load->model("Request_types");
        $this->load->model("Request_trx");
    }

    function index(){
        if($this->session->userdata('userdata')['code']===CODE_ROLE_ADMIN ||
            $this->session->userdata('userdata')['code']===CODE_ROLE_USER) {
                $data['title']="Items";
                $data['result'] = $this->Goods->getAll();
                $this->load->view('fragment/headerTable', $data);
                if($this->session->userdata('userdata')['code']===CODE_ROLE_ADMIN){
                    $this->load->view('fragment/navAdmin');
                }
                if($this->session->userdata('userdata')['code']===CODE_ROLE_USER){
                    $this->load->view('fragment/navUser');
                }
                $this->load->view('request/index', $data);
                $this->load->view('fragment/footerTable1');
        }
        else{
            redirect(base_url()); 
        }
    }

    function create(){
        if($this->session->userdata('userdata')['code']===CODE_ROLE_USER){
            $data['title']="Create Request";
            $data['goods']= $this->Goods->getAll();
            $data['request_types'] = $this->Request_types->getAll();
            $this->load->view('fragment/header', $data);
            $this->load->view('fragment/navUser');
            $this->load->view('request/user/create', $data);
            $this->load->view('fragment/footer');
        } else {
            redirect(base_url());
        }
    }

    function insert(){
        $itemsJSON = $this->input->post('items');
        if($itemsJSON == "" || $itemsJSON == "[]") {
            $this->session->set_flashdata('error', 'Minimum 1 Item!'); 
            redirect(base_url('request/create'));
        }
        $trxCode = $this->generateTrxCode();
        $items = json_decode($itemsJSON, true);
        $result = $this->Request_trx->insert($trxCode, $items);
        if($result) {
            redirect(base_url('request/create'));
        } else { 
            redirect(base_url('request/create'));
        }
    }

    function generateTrxCode(){
        $nid = 'TRX-';
        $nunix = now();
        $nsplit = '-';
        $chars = array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $max = count($chars)-1;
        $serial = '';
        for($i=0;$i<10;$i++){
            $serial .= (!($i % 5) && $i ? '-' : '').$chars[rand(0, $max)];
        }
        $trxCode = $nid.$nunix.$nsplit.$serial;
        return $trxCode;
    }

    // function insert(){
    //     $result = $this->Goods->insert(); 
    //     if($result) {
    //         $this->session->set_flashdata('success', RES_CREATED);
    //         redirect(base_url('items'));
    //     } else {
    //         $this->session->set_flashdata('error', RES_FAILED); 
    //         redirect(base_url('items'));
    //     }
    // }

    // function delete($id, $ver){
    //     $this->Goods->deleteById($id, $ver);
    //     redirect(base_url('items'));
    // }

    // function edit($id){
    //     if($this->session->userdata('userdata')['code']===CODE_ROLE_ADMIN){
    //         $data['title']="Edit Item";
    //         $data['result']= $this->Goods->getById($id);
    //         if($data['result']){
    //             $data['categories'] = $this->Goods_categories->getAll();
    //             $this->load->view('fragment/header', $data);
    //             $this->load->view('fragment/navAdmin');
    //             $this->load->view('items/admin/edit', $data);
    //             $this->load->view('fragment/footer');
    //         } else {
    //             show_404();
    //         }
    //     } else {
    //         redirect(base_url());
    //     }
    // }

    // function update(){
    //     $this->Goods->update();
    //     redirect(base_url("items"));
    // }

}