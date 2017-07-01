<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Koordinatarmada extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('model_koordinatarmada','model_armada'));
    $this->load->helper('url');
    $this->load->library('form_validation'); //untuk menyimpan titik Koordinatarmada
  }
  function Index(){
    $data = array('content' => 'admin/formkoordinatarmada',
    'itemarmada'=>$this->model_armada->getAll(),
    'itemkoordinat'=>$this->model_koordinatarmada->getAll());
    $this->load->view('templates/template-admin', $data);
  }
  function create(){
    if (!$this->input->is_ajax_request()) {
        show_404();
    }else{
        //kita validasi inputnya dulu
        $this->form_validation->set_rules('id_armada', 'Nama Armada', 'trim|required');
        $this->form_validation->set_rules('latitude', 'Latitude', 'trim|required');
        $this->form_validation->set_rules('longitude', 'Longitude', 'trim|required');

        if ($this->form_validation->run()==false) {
            $status = 'error';
            $msg = validation_errors();
        }else{
          $armada = $this->input->post('id_armada');
          $latitude = $this->input->post('latitude');
          $longitude = $this->input->post('longitude');
          if ($this->model_koordinatarmada->validasi($armada)->num_rows()==null) {
            if ($this->model_koordinatarmada->create($armada,$latitude,$longitude)) {
                $status = 'success';
                $msg = "Data koordinat armada berhasil disimpan";
            }else{
                $status = 'error';
                $msg = "terjadi kesalahan saat menyimpan data koordinat armada";
            }
          }else {
            $status = 'error';
            $msg = "koordinat marker untuk armada tersebut sudah ada";
          }

        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
    }
  }
  function delete(){
    if (!$this->input->is_ajax_request()) {
        show_404();
    }else{
        //kita validasi inputnya dulu
        $this->form_validation->set_rules('id_koordinatarmada', 'Id Koordinat armada', 'trim|required');
        if ($this->form_validation->run()==false) {
            $status = 'error';
            $msg = validation_errors();
        }else{
            $id = $this->input->post('id_koordinatarmada');
            if ($this->model_koordinatarmada->delete($id)) {
                $status = 'success';
                $msg = "Data koordinat armada berhasil dihapus";
            }else{
                $status = 'error';
                $msg = "terjadi kesalahan saat menghapus data koordinat armada";
            }
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
    }
  }
  function read()  {
    if (!$this->input->is_ajax_request()) {
        show_404();
    }else{
        //kita validasi inputnya dulu
        $this->form_validation->set_rules('id_koordinatarmada', 'Id Koordinat armada', 'trim|required');
        if ($this->form_validation->run()==false) {
            $status = 'error';
            $msg = validation_errors();
        }else{
            $id = $this->input->post('id_koordinatarmada');
            if ($this->model_koordinatarmada->read($id)->num_rows()!=null) {
                $status = 'success';
                $msg = $this->model_koordinatarmada->read($id)->result();
            }else{
                $status = 'error';
                $msg = "data koordinat armada tidak ditemukan";
            }
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
    }
  }
}
