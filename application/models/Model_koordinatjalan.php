<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_koordinatjalan extends CI_Model{

    public function create($jalan,$latitude,$longitude){
        $data = array('jalan_id' => $jalan,
        'latitude'=>$latitude,
        'longitude'=>$longitude);
        $query = $this->db->insert('tbl_koordinatjalan', $data);
        return $query;
    }
    public function getAll(){
        $this->db->select('*');//kita akan mengambil semua data
        $this->db->from('tbl_koordinatjalan');
        $this->db->join('tbl_jalan', 'tbl_jalan.id_jalan = tbl_koordinatjalan.jalan_id');//kita join tbl jalan dengan foreign key jalan_id
        $query = $this->db->get();
        return $query;
    }
    public function read($id){
        $this->db->select('*');//kita akan mengambil semua data
        $this->db->from('tbl_koordinatjalan');
        $this->db->join('tbl_jalan', 'tbl_jalan.id_jalan = tbl_koordinatjalan.jalan_id');//kita join tbl jalan dengan foreign key jalan_id
        $this->db->where('id_jalan', $id);
        $query = $this->db->get();
        return $query;
    }
    public function update($jalan,$latitude,$longitude,$id){
        $data = array('jalan_id' => $jalan,
        'latitude'=>$latitude,
        'longitude'=>$longitude);
        $this->db->where('id_koordinatjalan', $id);
        $query = $this->db->update('tbl_koordinatjalan',$data);
        return $query;
    }
    public function delete($id){
        $this->db->where('jalan_id', $id);
        $query = $this->db->delete('tbl_koordinatjalan');
        return $query;
    }
    public function validasi($id){
      $this->db->where('jalan_id', $id);
      $query = $this->db->get('tbl_koordinatjalan');
      return $query;
    }
    public function getJalan(){
      $this->db->select('id_jalan,namajalan,keterangan');//kita akan mengambil semua data
      $this->db->from('tbl_koordinatjalan');
      $this->db->join('tbl_jalan', 'tbl_jalan.id_jalan = tbl_koordinatjalan.jalan_id');
      $this->db->distinct('id_jalan');
      $query = $this->db->get();
      return $query;
    }
}
