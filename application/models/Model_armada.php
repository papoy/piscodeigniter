<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_armada extends CI_Model{

    public function create(){
        $data = array('namaarmada' => $this->input->post('namaarmada'),
        'rute'=>$this->input->post('rute'));
        $query = $this->db->insert('tbl_armada', $data);
        return $query;
    }
    public function ambildata($perPage, $uri, $ringkasan) {
    		$this->db->select('*');
    		$this->db->from('tbl_armada');
    		if (!empty($ringkasan)) {
    			$this->db->like('namaarmada', $ringkasan);
    		}
    		$this->db->order_by('namaarmada','asc');
    		$getData = $this->db->get('', $perPage, $uri);

    		if ($getData->num_rows() > 0)
    			return $getData->result_array();
    		else
    			return null;
  	}
    public function getAll(){
        $query = $this->db->get('tbl_armada');
        return $query;
    }
    public function read($id){
        $this->db->where('id_armada', $id);
        $query = $this->db->get('tbl_armada');
        return $query;
    }
    public function delete($id){
        $this->db->where('id_armada', $id);
        $query = $this->db->delete('tbl_armada');
        return $query;
    }
    public function update($id){
        $data = array('namaarmada' => $this->input->post('namaarmada'),
        'rute'=>$this->input->post('rute'));
        $this->db->where('id_armada', $id);
        $query = $this->db->update('tbl_armada', $data);
        return $query;
    }

}
