<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Koordinatjalan extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('model_koordinatjalan','model_jalan'));
    $this->load->library(array('cart','form_validation')); //untuk menyimpan titik Koordinatjalan
    $this->load->helper('url');
  }
  function Index(){
    $data = array('content' => 'admin/formkoordinatjalan',
    'itemjalan'=>$this->model_jalan->getAll(),
    'itemkoordinat'=>$this->model_koordinatjalan->getAll(),
    'itemjalanpolyline'=>$this->model_koordinatjalan->getJalan());
    $this->load->view('templates/template-admin', $data);
  }
  function addmarker(){
    if (!$this->input->is_ajax_request()) {
        show_404();
    }else{
        //kita validasi inputnya dulu
        $this->form_validation->set_rules('latitude', 'Latitude', 'trim|required');
        $this->form_validation->set_rules('longitude', 'Longitude', 'trim|required');
        if ($this->form_validation->run()==false) {
            $status = 'error';
            $msg = validation_errors();
        }else{
          $latitude = $this->input->post('latitude');
          $longitude = $this->input->post('longitude');
          $urut = 1;
          if ($this->cart->contents()==null) {
            $data = array(
            'id'      => 1,
            'qty'     => 1,
            'price'   => 1,
            'jenis'     => 'jalan',
            'name'    => 1,
            'latitude'=> $latitude,
            'longitude'=> $longitude
            );
          }else {
            foreach ($this->cart->contents() as $increment) {
              $urut++;
            }
            $data = array(
            'id'      => $urut,
            'qty'     => 1,
            'price'   => 1,
            'jenis'     => 'jalan',
            'name'    => 1,
            'latitude'=> $latitude,
            'longitude'=> $longitude
            );
          }
          $this->cart->insert($data);
          $status = 'success';
          $msg = "Data koordinat jalan berhasil disimpan";
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
    }
  }
  function clearmap(){
    if (!$this->input->is_ajax_request()) {
      show_404();
    }else {
      $this->cart->destroy();
      $status = 'success';
      $msg = "Data koordinat jalan berhasil";
      $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
    }
  }
  function create(){
    if (!$this->input->is_ajax_request()) {
      show_404();
    }else {
      $jalan = $this->input->post('id_jalan');
      $this->form_validation->set_rules('id_jalan', 'Nama Jalan', 'trim|required');
      if ($this->form_validation->run()==false) {
        $msg = validation_errors();
        $status = 'error';
      }else {
        if ($this->cart->contents()==null) {
          $msg = 'Koordinat belum diisi';
          $status = 'error';
        }else {
          if ($this->model_koordinatjalan->validasi($jalan)->num_rows()!=null) {
            $msg = 'Polyline jalan sudah ada, coba jalan yang lain';
            $status = 'error';
          }else {
            foreach ($this->cart->contents() as $koordinat) {
              $this->model_koordinatjalan->create($jalan,$koordinat['latitude'],$koordinat['longitude']);
            }
            $msg = 'Koordinat polyline berhasil disimpan';
            $status = 'success';
          }
        }
      }
      $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
    }
  }
  function delete(){
    if (!$this->input->is_ajax_request()) {
      show_404();
    }else {
      $jalan = $this->input->post('id_jalan');
      $this->form_validation->set_rules('id_jalan', 'Nama Jalan', 'trim|required');
      if ($this->form_validation->run()==false) {
        $msg = validation_errors();
        $status = 'error';
      }else {
          if ($this->model_koordinatjalan->delete($jalan)) {
            $msg = 'Data polyline berhasil dihapus';
            $status = 'success';
          }else {
            $msg = 'Terjadi kesalahan saat menghapus data polyline';
            $status = 'error';
          }
      }
      $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
    }
  }
  function read(){
    if (!$this->input->is_ajax_request()) {
      show_404();
    }else {
      $jalan = $this->input->post('id_jalan');
      $this->form_validation->set_rules('id_jalan', 'Nama Jalan', 'trim|required');
      if ($this->form_validation->run()==false) {
        $msg = validation_errors();
        $status = 'error';
      }else {
          if ($this->model_koordinatjalan->read($jalan)->num_rows()!=null) {
            $msg = $this->model_koordinatjalan->read($jalan)->result();
            $status = 'success';
          }else {
            $msg = 'Data polyline tidak ditemukan';
            $status = 'error';
          }
      }
      $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
    }
  }
}
