<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller{

    public function __construct(){
        parent::__construct();
        //Codeigniter : Write Less Do More
      }

    function index(){
        //echo "Hai.. ini aplikasi simple gis";
//         $this->load->view('homepage');
		$data = array('content' => 'admin/formhome');
        $this->load->view('templates/template-admin', $data);


    }

}
