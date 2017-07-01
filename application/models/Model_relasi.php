<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_relasi extends CI_Model{

    public function create($id_halte,$id_armada,$id_jalan){
        $data = array('halte_id' => $id_halte,
        'armada_id1'=>$id_armada,
        'jalan_id'=>$id_jalan);
        $query = $this->db->insert('tbl_relasi', $data);
        return $query;
    }
    public function ambildata($perPage, $uri, $ringkasan) {
    		$this->db->select('*');
    		$this->db->from('tbl_relasi');
        $this->db->join('tbl_halte', 'tbl_halte.id_halte = tbl_relasi.halte_id');
        $this->db->join('tbl_armada', 'tbl_armada.id_armada = tbl_relasi.armada_id1');
        $this->db->join('tbl_jalan', 'tbl_jalan.id_jalan = tbl_relasi.jalan_id');
    		if (!empty($ringkasan)) {
    			$this->db->like('namahalte','namaarmada','namajalan', $ringkasan);
    		}
    		$this->db->order_by('namahalte','namaarmada','namajalan','asc');
    		$getData = $this->db->get('', $perPage, $uri);

    		if ($getData->num_rows() > 0)
    			return $getData->result_array();
    		else
    			return null;
  	}
    public function getAll(){
        $this->db->select('*');//kita akan mengambil semua data
        $this->db->from('tbl_relasi');
        $this->db->join('tbl_halte', 'tbl_halte.id_halte = tbl_relasi.halte_id');
        $this->db->join('tbl_armada', 'tbl_armada.id_armada = tbl_relasi.armada_id1');
        $this->db->join('tbl_jalan', 'tbl_jalan.id_jalan = tbl_relasi.jalan_id');
        $query = $this->db->get();
        return $query;
    }
    public function read($id){
        $this->db->select('*');//kita akan mengambil semua data
        $this->db->from('tbl_relasi');
        $this->db->join('tbl_halte', 'tbl_halte.id_halte = tbl_relasi.halte_id');
        $this->db->join('tbl_armada', 'tbl_armada.id_armada = tbl_relasi.armada_id1');
        $this->db->join('tbl_jalan', 'tbl_jalan.id_jalan = tbl_relasi.jalan_id');//kita join tbl relasi dengan foreign key relasi_id
        $this->db->where('id_relasi', $id);
        $query = $this->db->get();
        return $query;
    }
    public function update($id){
      $data = array('halte_id' => $this->input->post('id_halte'),
        'armada_id1'=>$this->input->post('id_armada'),
        'jalan_id'=>$this->input->post('id_jalan'));
        $this->db->where('id_relasi', $id);
        $query = $this->db->update('tbl_relasi',$data);
        return $query;
    }
    public function delete($id){
        $this->db->where('id_relasi', $id);
        $query = $this->db->delete('tbl_relasi');
        return $query;
    }
    public function validasi($id){
      $this->db->where('relasi_id', $id);
      $query = $this->db->get('tbl_relasi');
      return $query;
    }

}
