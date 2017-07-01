<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        //kita load model yang dibutuhkan, yaitu model armada
        $this->load->model(array('model_armada'));
        $this->load->helper('url');
        $this->load->library('form_validation');
    }

    function index()
    {
        $data = array('content' => 'admin/formhome');
        $this->load->view('templates/template-admin', $data);
    }

}
