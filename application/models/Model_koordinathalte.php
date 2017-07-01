<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_koordinathalte extends CI_Model{

    public function create($halte,$latitude,$longitude){
        $data = array('halte_id' => $halte,
        'latitude'=>$latitude,
        'longitude'=>$longitude);
        $query = $this->db->insert('tbl_koordinathalte', $data);
        return $query;
    }
    public function getAll(){
        $this->db->select('*');//kita akan mengambil semua data
        $this->db->from('tbl_koordinathalte');
        $this->db->join('tbl_halte', 'tbl_halte.id_halte = tbl_koordinathalte.halte_id');//kita join tbl halte dengan foreign key halte_id
        $query = $this->db->get();
        return $query;
    }
    public function read($id){
        $this->db->select('*');//kita akan mengambil semua data
        $this->db->from('tbl_koordinathalte');
        $this->db->join('tbl_halte', 'tbl_halte.id_halte = tbl_koordinathalte.halte_id');//kita join tbl halte dengan foreign key halte_id
        $this->db->where('id_koordinathalte', $id);
        $query = $this->db->get();
        return $query;
    }
    public function update($halte,$latitude,$longitude,$id){
        $data = array('halte_id' => $halte,
        'latitude'=>$latitude,
        'longitude'=>$longitude);
        $this->db->where('id_koordinathalte', $id);
        $query = $this->db->update('tbl_koordinathalte',$data);
        return $query;
    }
    public function delete($id){
        $this->db->where('id_koordinathalte', $id);
        $query = $this->db->delete('tbl_koordinathalte');
        return $query;
    }
    public function validasi($id){
      $this->db->where('halte_id', $id);
      $query = $this->db->get('tbl_koordinathalte');
      return $query;
    }

}
