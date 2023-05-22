<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * @property CI_Config $config
 * @property CI_Session $session
 */

class MY_Controller extends CI_Controller {

    /***
     * pages of site in menu
     */

    function __construct() {
        parent::__construct();
        $this->load_lang();
        $this->load->library('user_agent');
        $this->load->helper('date');
    }

    /**
     * return module language file
     */
    protected function load_lang() {

        if ($this->uri->segment(1) == 'en' ||
            $this->uri->segment(1) == 'id'
        ) {
            $this->session->set_userdata("lang", $this->uri->segment(1));
            redirect($this->session->flashdata('redirectToCurrent'));
        }

        if ($this->session->userdata('lang') == "en") {
            $lang = "english";
            $this->config->set_item('language',$lang);
            $this->session->set_userdata("lang",'en');
        } else {
            $lang = "indonesia";
            $this->config->set_item('language',$lang);
            $this->session->set_userdata("lang",'id');
        }

        //  $this->lang->load($moduleName, $lang);
    }

}