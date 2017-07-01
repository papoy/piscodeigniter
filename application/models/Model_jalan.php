<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_jalan extends CI_Model{

    public function create(){
        $data = array('namajalan' => $this->input->post('namajalan'),
        'keterangan'=>$this->input->post('keterangan'));
        $query = $this->db->insert('tbl_jalan', $data);
        return $query;
    }
    public function ambildata($perPage, $uri, $ringkasan) {
    		$this->db->select('*');
    		$this->db->from('tbl_jalan');
    		if (!empty($ringkasan)) {
    			$this->db->like('namajalan', $ringkasan);
    		}
    		$this->db->order_by('namajalan','asc');
    		$getData = $this->db->get('', $perPage, $uri);

    		if ($getData->num_rows() > 0)
    			return $getData->result_array();
    		else
    			return null;
  	}
    public function getAll(){
        $query = $this->db->get('tbl_jalan');
        return $query;
    }
    public function read($id){
        $this->db->where('id_jalan', $id);
        $query = $this->db->get('tbl_jalan');
        return $query;
    }
    public function delete($id){
        $this->db->where('id_jalan', $id);
        $query = $this->db->delete('tbl_jalan');
        return $query;
    }
    public function update($id){
        $data = array('namajalan' => $this->input->post('namajalan'),
        'keterangan'=>$this->input->post('keterangan'));
        $this->db->where('id_jalan', $id);
        $query = $this->db->update('tbl_jalan', $data);
        return $query;
    }

}
