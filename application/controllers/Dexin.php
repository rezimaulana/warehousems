<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dexin extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('Dashboard');
    }
	public function index()
	{	
		$data['title']="Dashboard";
		$judul = $this->input->post('judul');
		$data['result'] = $this->Dashboard->getJudul($judul);
		// var_dump($data['result']);
		$this->load->view('fragment/header',$data);
		$this->load->view('fragment/nav');
		$this->load->view('dashboard/dashboard',$data);
		$this->load->view('fragment/footer');
	}
}