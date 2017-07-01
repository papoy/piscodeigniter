<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Armada extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        //kita load model yang dibutuhkan, yaitu model armada
        $this->load->model(array('model_armada'));
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('pagination');
    }

    function index()
    {
      if (isset($_POST['q'])) {
      $data1['ringkasan'] = $this->input->post('cari');
      // se session userdata untuk pencarian, untuk paging pencarian
      $this->session->set_userdata('sess_ringkasan', $data1['ringkasan']);
      }
      else {
        $data1['ringkasan'] = $this->session->userdata('sess_ringkasan');
      }

        $data = array('content' => 'admin/formarmada');
        $this->load->model('model_armada');
        $this->db->like('namaarmada', $data1['ringkasan']);
        $this->db->from('tbl_armada');

        // pagination limit
        $pagination['base_url'] = base_url().'index.php/admin/armada/page';
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

        $data2['ListArmada'] = $this->model_armada->ambildata($pagination['per_page'],$this->uri->segment(3,0),$data1['ringkasan']);

        $this->load->vars($data2);
        $this->load->view('templates/template-admin', $data);
    }
    function create(){
        if (!$this->input->is_ajax_request()) {
            show_404();
        }else{
            //kita validasi inputnya dulu
            $this->form_validation->set_rules('namaarmada', 'Nama armada', 'trim|required');
            $this->form_validation->set_rules('rute', 'Rute', 'trim|required');
            if ($this->form_validation->run()==false) {
                $status = 'error';
                $msg = validation_errors();
            }else{
                if ($this->model_armada->create()) {
                    $status = 'success';
                    $msg = "Data armada berhasil disimpan";
                }else{
                    $status = 'error';
                    $msg = "terjadi kesalahan saat menyimpan data armada";
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
            $this->form_validation->set_rules('id_armada', 'ID Armada', 'trim|required');
            if ($this->form_validation->run()==false) {
                $status = 'error';
                $msg = validation_errors();
            }else{
                $id = $this->input->post('id_armada');
                if ($this->model_armada->read($id)->num_rows()!=null) {
                    $status = 'success';
                    $msg = $this->model_armada->read($id)->result();
                }else{
                    $status = 'error';
                    $msg = "Data armada tidak ditemukan";
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
            $this->form_validation->set_rules('namaarmada', 'Nama Armada', 'trim|required');
            $this->form_validation->set_rules('rute', 'Rute', 'trim|required');
            $this->form_validation->set_rules('id_armada', 'ID Armada', 'trim|required');
            if ($this->form_validation->run()==false) {
                $status = 'error';
                $msg = validation_errors();
            }else{
                $id = $this->input->post('id_armada');
                if ($this->model_armada->update($id)) {
                    $status = 'success';
                    $msg = "Data armada berhasil diupdate";
                }else{
                    $status = 'error';
                    $msg = "terjadi kesalahan saat mengupdate data armada";
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
            $this->form_validation->set_rules('id_armada', 'ID Armada', 'trim|required');
            if ($this->form_validation->run()==false) {
                $status = 'error';
                $msg = validation_errors();
            }else{
                $id = $this->input->post('id_armada');
                if ($this->model_armada->delete($id)) {
                    $status = 'success';
                    $msg = "Data armada berhasil dihapus";
                }else{
                    $status = 'error';
                    $msg = "terjadi kesalahan saat menghapus data armada";
                }
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
        }
    }

}
