<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_halte extends CI_Model{

    public function create(){
        $data = array('namahalte' => $this->input->post('namahalte'),
        'keterangan'=>$this->input->post('keterangan'));
        $query = $this->db->insert('tbl_halte', $data);
        return $query;
    }
    public function ambildata($perPage, $uri, $ringkasan) {
    		$this->db->select('*');
    		$this->db->from('tbl_halte');
    		if (!empty($ringkasan)) {
    			$this->db->like('namahalte', $ringkasan);
    		}
    		$this->db->order_by('namahalte','asc');
    		$getData = $this->db->get('', $perPage, $uri);

    		if ($getData->num_rows() > 0)
    			return $getData->result_array();
    		else
    			return null;
  	}

    public function getAll(){
        $query = $this->db->get('tbl_halte');
        return $query;
    }
    public function read($id){
        $this->db->where('id_halte', $id);
        $query = $this->db->get('tbl_halte');
        return $query;
    }
    public function delete($id){
        $this->db->where('id_halte', $id);
        $query = $this->db->delete('tbl_halte');
        return $query;
    }
    public function update($id){
        $data = array('namahalte' => $this->input->post('namahalte'),
        'keterangan'=>$this->input->post('keterangan'));
        $this->db->where('id_halte', $id);
        $query = $this->db->update('tbl_halte', $data);
        return $query;
    }

}
