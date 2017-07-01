<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_koordinatarmada extends CI_Model{

    public function create($armada,$latitude,$longitude){
        $data = array('armada_id' => $armada,
        'latitude'=>$latitude,
        'longitude'=>$longitude);
        $query = $this->db->insert('tbl_koordinatarmada', $data);
        return $query;
    }
    public function getAll(){
        $this->db->select('*');//kita akan mengambil semua data
        $this->db->from('tbl_koordinatarmada');
        $this->db->join('tbl_armada', 'tbl_armada.id_armada = tbl_koordinatarmada.armada_id');//kita join tbl armada dengan foreign key armada_id
        $query = $this->db->get();
        return $query;
    }
    public function read($id){
        $this->db->select('*');//kita akan mengambil semua data
        $this->db->from('tbl_koordinatarmada');
        $this->db->join('tbl_armada', 'tbl_armada.id_armada = tbl_koordinatarmada.armada_id');//kita join tbl armada dengan foreign key armada_id
        $this->db->where('id_koordinatarmada', $id);
        $query = $this->db->get();
        return $query;
    }
    public function update($armada,$latitude,$longitude,$id){
        $data = array('armada_id' => $armada,
        'latitude'=>$latitude,
        'longitude'=>$longitude);
        $this->db->where('id_koordinatarmada', $id);
        $query = $this->db->update('tbl_koordinatarmada',$data);
        return $query;
    }
    public function delete($id){
        $this->db->where('id_koordinatarmada', $id);
        $query = $this->db->delete('tbl_koordinatarmada');
        return $query;
    }
    public function validasi($id){
      $this->db->where('armada_id', $id);
      $query = $this->db->get('tbl_koordinatarmada');
      return $query;
    }

}
