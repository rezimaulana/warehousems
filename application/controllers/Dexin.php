<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dexin extends MY_Controller {
	function __construct(){
        parent::__construct();
    }
	
	function index() {	
		if($this->session->userdata('userdata')['id']){
			redirect(base_url('dexin/defaultRedirect'));
        }
        else{   
			$data['title']="User Authorization";
			$this->load->view('login/login', $data);
        }
	}

	function defaultRedirect(){
        if($this->session->userdata('userdata')['code']===CODE_ROLE_ADMIN){
            redirect(base_url("dashboard"));
        }
        elseif($this->session->userdata('userdata')['code']===CODE_ROLE_USER){
            redirect(base_url("dashboard"));
        }
        else{
            redirect(base_url("dexin/logout")); 
        }
    }

	function logout(){  
		$this->session->sess_destroy();
		redirect(base_url());
    }

	function loginValidation() {
		$this->load->library('form_validation');  
        $this->form_validation->set_rules('email', 'Email', 'required');  
        $this->form_validation->set_rules('password', 'Password', 'required');
		if($this->form_validation->run()) {
			$email = $this->input->post('email');  
            $password = md5($this->input->post('password'));
			$this->load->model('user');
			if($this->user->login($email, $password)){
				if($this->session->userdata('userdata')['is_active']==1){
					redirect(base_url());
				}
				else if ($this->session->userdata('userdata')['is_active']==0){
					$this->session->set_flashdata('error', 'Account is blocked!');
                    $this->session->unset_userdata('userdata');
                    redirect(base_url());
				} else {
					$this->session->set_flashdata('error', 'Unknown Error!');
                    $this->session->unset_userdata('userdata');
                    redirect(base_url());
				}
			} else {  
                $this->session->set_flashdata('error', 'Invalid Email and Password');  
                redirect(base_url());  
            }    
		} else {
			redirect(base_url());
        }
	}

}