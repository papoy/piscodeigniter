<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relasi extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('model_relasi','model_halte','model_armada','model_jalan'));
    $this->load->helper('url');
    $this->load->library('form_validation'); //untuk menyimpan titik relasi
    $this->load->library('pagination');
  }
  function Index(){
    if (isset($_POST['q'])) {
    $data1['ringkasan'] = $this->input->post('cari');
    // se session userdata untuk pencarian, untuk paging pencarian
    $this->session->set_userdata('sess_ringkasan', $data1['ringkasan']);
    }
    else {
      $data1['ringkasan'] = $this->session->userdata('sess_ringkasan');
    }
    $data = array('content' => 'admin/formrelasi',
    // 'itemrelasi'=>$this->model_relasi->getAll(),
    'itemhalte'=>$this->model_halte->getAll(),
    'itemarmada'=>$this->model_armada->getAll(),
    'itemjalan'=>$this->model_jalan->getAll());
    $this->load->model('model_relasi','model_halte','model_armada','model_jalan');
    $this->db->like('namahalte','namaarmada','namajalan', $data1['ringkasan']);
    $this->db->from('tbl_relasi');
    $this->db->join('tbl_halte', 'tbl_halte.id_halte = tbl_relasi.halte_id');
    $this->db->join('tbl_armada', 'tbl_armada.id_armada = tbl_relasi.armada_id1');
    $this->db->join('tbl_jalan', 'tbl_jalan.id_jalan = tbl_relasi.jalan_id');

    // $this->db->like('namahalte', $data['keterangan']);
    //     $this->db->from('tbl_halte');

    // pagination limit
    $pagination['base_url'] = base_url().'index.php/admin/relasi/page';
    $pagination['total_rows'] = $this->db->count_all_results();
    $pagination['full_tag_open'] = "<span class=\"pagination\" style='letter-spacing:2px;'>";
    $pagination['full_tag_close'] = "</div></p>";
    $pagination['cur_tag_open'] = "<span class=\"current\">";
    $pagination['cur_tag_close'] = "</span>";
    $pagination['num_tag_open'] = "<span class=\"disabled\">";
    $pagination['num_tag_close'] = "</span>";
    $pagination['per_page'] = "100";
    $pagination['uri_segment'] = 3;
    $pagination['num_links'] = 5;

    $this->pagination->initialize($pagination);

    $data2['ListRelasi'] = $this->model_relasi->ambildata($pagination['per_page'],$this->uri->segment(3,0),$data1['ringkasan']);
    $data3['ListHalte']  = $this->model_halte->ambildata($pagination['per_page'],$this->uri->segment(3,0),$data1['ringkasan']);
    $data4['ListArmada']  = $this->model_armada->ambildata($pagination['per_page'],$this->uri->segment(3,0),$data1['ringkasan']);
    $data5['ListRute']  = $this->model_jalan->ambildata($pagination['per_page'],$this->uri->segment(3,0),$data1['ringkasan']);

    $this->load->vars($data2, $data3, $data4, $data5);
    $this->load->view('templates/template-admin', $data);
  }
  function create(){
    if (!$this->input->is_ajax_request()) {
        show_404();
    }else{
        //kita validasi inputnya dulu
        $this->form_validation->set_rules('id_halte', 'Nama Halte', 'trim|required');
        $this->form_validation->set_rules('id_armada', 'Nama armada', 'trim|required');
        $this->form_validation->set_rules('id_jalan', 'Nama Jalan', 'trim|required');

        if ($this->form_validation->run()==false) {
            $status = 'error';
            $msg = validation_errors();
        }else{
          $id_halte = $this->input->post('id_halte');
          $id_armada = $this->input->post('id_armada');
          $id_jalan = $this->input->post('id_jalan');

            if ($this->model_relasi->create($id_halte,$id_armada,$id_jalan)) {
                $status = 'success';
                $msg = "Data  relasi berhasil disimpan";
            }else{
                $status = 'error';
                $msg = "terjadi kesalahan saat menyimpan data  relasi";
            }


        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
    }
  }
  function edit(){
      if (!$this->input->is_ajax_request()) {
          show_404();
      }else{
          //kita validasi inputnya dulu
          $this->form_validation->set_rules('id_relasi', 'ID Relasi', 'trim|required');
          if ($this->form_validation->run()==false) {
              $status = 'error';
              $msg = validation_errors();
          }else{
              $id = $this->input->post('id_relasi');
              if ($this->model_relasi->read($id)->num_rows()!=null) {
                  $status = 'success';
                  $msg = $this->model_relasi->read($id)->result();
              }else{
                  $status = 'error';
                  $msg = "Data halte tidak ditemukan";
              }
          }
          $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
      }
  }
  function update(){
      if (!$this->input->is_ajax_request()) {
          show_404();
      }else{
          //kita validasi inputnya dulu
          $this->form_validation->set_rules('id_halte', 'Nama Halte', 'trim|required');
          $this->form_validation->set_rules('id_armada', 'Nama Armada', 'trim|required');
          $this->form_validation->set_rules('id_jalan', 'Nama Jalan', 'trim|required');
          // $this->form_validation->set_rules('id_relasi', 'ID Relasi', 'trim|required');
          if ($this->form_validation->run()==false) {
              $status = 'error';
              $msg = validation_errors();
          }else{
              $id = $this->input->post('id_relasi');
              if ($this->model_relasi->update($id)) {
                  $status = 'success';
                  $msg = "Data jalan berhasil diupdate";
              }else{
                  $status = 'error';
                  $msg = "terjadi kesalahan saat mengupdate data relasi";
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
        $this->form_validation->set_rules('id_relasi', 'Id  relasi', 'trim|required');
        if ($this->form_validation->run()==false) {
            $status = 'error';
            $msg = validation_errors();
        }else{
            $id = $this->input->post('id_relasi');
            if ($this->model_relasi->delete($id)) {
                $status = 'success';
                $msg = "Data  relasi berhasil dihapus";
            }else{
                $status = 'error';
                $msg = "terjadi kesalahan saat menghapus data  relasi";
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
        $this->form_validation->set_rules('id_relasi', 'Id  relasi', 'trim|required');
        if ($this->form_validation->run()==false) {
            $status = 'error';
            $msg = validation_errors();
        }else{
            $id = $this->input->post('id_relasi');
            if ($this->model_relasi->read($id)->num_rows()!=null) {
                $status = 'success';
                $msg = $this->model_relasi->read($id)->result();
            }else{
                $status = 'error';
                $msg = "data  relasi tidak ditemukan";
            }
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
    }
  }
}
