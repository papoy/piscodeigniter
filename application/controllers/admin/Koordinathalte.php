<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Koordinathalte extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('model_koordinathalte','model_halte'));
    $this->load->helper('url');
    $this->load->library('form_validation'); //untuk menyimpan titik Koordinathalte
  }
  function Index(){
    $data = array('content' => 'admin/formkoordinathalte',
    'itemhalte'=>$this->model_halte->getAll(),
    'itemkoordinat'=>$this->model_koordinathalte->getAll());
    $this->load->view('templates/template-admin', $data);
  }
  function create(){
    if (!$this->input->is_ajax_request()) {
        show_404();
    }else{
        //kita validasi inputnya dulu
        $this->form_validation->set_rules('id_halte', 'Nama halte', 'trim|required');
        $this->form_validation->set_rules('latitude', 'Latitude', 'trim|required');
        $this->form_validation->set_rules('longitude', 'Longitude', 'trim|required');

        if ($this->form_validation->run()==false) {
            $status = 'error';
            $msg = validation_errors();
        }else{
          $halte = $this->input->post('id_halte');
          $latitude = $this->input->post('latitude');
          $longitude = $this->input->post('longitude');
          if ($this->model_koordinathalte->validasi($halte)->num_rows()==null) {
            if ($this->model_koordinathalte->create($halte,$latitude,$longitude)) {
                $status = 'success';
                $msg = "Data koordinat halte berhasil disimpan";
            }else{
                $status = 'error';
                $msg = "terjadi kesalahan saat menyimpan data koordinat halte";
            }
          }else {
            $status = 'error';
            $msg = "koordinat marker untuk halte tersebut sudah ada";
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
        $this->form_validation->set_rules('id_koordinathalte', 'Id Koordinat halte', 'trim|required');
        if ($this->form_validation->run()==false) {
            $status = 'error';
            $msg = validation_errors();
        }else{
            $id = $this->input->post('id_koordinathalte');
            if ($this->model_koordinathalte->delete($id)) {
                $status = 'success';
                $msg = "Data koordinat halte berhasil dihapus";
            }else{
                $status = 'error';
                $msg = "terjadi kesalahan saat menghapus data koordinat halte";
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
        $this->form_validation->set_rules('id_koordinathalte', 'Id Koordinat halte', 'trim|required');
        if ($this->form_validation->run()==false) {
            $status = 'error';
            $msg = validation_errors();
        }else{
            $id = $this->input->post('id_koordinathalte');
            if ($this->model_koordinathalte->read($id)->num_rows()!=null) {
                $status = 'success';
                $msg = $this->model_koordinathalte->read($id)->result();
            }else{
                $status = 'error';
                $msg = "data koordinat halte tidak ditemukan";
            }
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
    }
  }
}
