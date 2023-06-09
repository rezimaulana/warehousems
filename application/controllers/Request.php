<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Request extends MY_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("Goods");
        $this->load->model("Request_types");
        $this->load->model("Request_trx");
        $this->load->model("Request_hdr");
        $this->load->model("Request_dtl");
    }

    function index(){
        if($this->session->userdata('userdata')['code']===CODE_ROLE_ADMIN) {
                $data['title']="Manage Request";
                $data['result'] = $this->Request_hdr->getAll();
                $this->load->view('fragment/headerTable', $data);
                $this->load->view('fragment/navAdmin');
                $this->load->view('request/admin/index', $data);
                $this->load->view('fragment/footerTableFilterStatus');
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

    function detail($id){
        if($this->session->userdata('userdata')['code']===CODE_ROLE_ADMIN){
            $data['title']="Request Detail";
            $data['result']= $this->Request_hdr->getById($id);
            if($data['result']){
                $data['items'] = $this->Request_dtl->getByHeaderId($id);
                $this->load->view('fragment/headerTable', $data);
                $this->load->view('fragment/navAdmin');
                $this->load->view('request/admin/detail', $data);
                $this->load->view('fragment/footerTable1');
            } else {
                show_404();
            }
        } else {
            redirect(base_url());
        }
    }

    function approve(){
        $id = $this->input->post("id");
        $ver = $this->input->post("ver");
        $type = $this->input->post("types");
        $arrNewQty = json_decode($this->input->post("arrNewQty"), true);
        $notValid = true;
        foreach ($arrNewQty as $qty) {
            if ($qty < 0) {
                $notValid = false;
                break;
            }
        }
        if($notValid){
            $this->Request_trx->accept($id, $ver, $type);
            redirect(base_url('request/detail/'.$id));
        } else {
            $this->session->set_flashdata('error', 'Your transaction will result minus in stock(<0)! Please reject this request.');
            redirect(base_url('request/detail/'.$id));
        }
    }

    function reject(){
        $id = $this->input->post("id");
        $ver = $this->input->post("ver");
        $this->Request_trx->reject($id, $ver);
        redirect(base_url('request/detail/'.$id));
    }

}