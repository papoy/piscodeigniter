<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Restserver extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        // $this->methods['index_get']['limit'] = 500; // 500 requests per hour per user/key
        // $this->methods['armada_get']['limit'] = 500; // 500 requests per hour per user/key
        // $this->methods['armada_post']['limit'] = 100; // 100 requests per hour per user/key
        // $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
    }


    function halte_get() {
        $halte = $this->get('id_halte');
        // $halte1 = $this->get('halte_id');
        if ($halte == '') {
            $z = $this->db->get('tbl_halte')->result_array();
        } else {
            $this->db->where('id_halte' , $halte);
            $z = $this->db->get('tbl_halte')->result();
        }
        $this->response($z, 200);
    }

    function koordinathalte_get() {
        $halte = $this->get('halte_id');
        if ($halte == '') {
            $z = $this->db->get('tbl_koordinathalte')->result_array();
        } else {
            $this->db->where('halte_id' , $halte);
            $z = $this->db->get('tbl_koordinathalte')->result();
        }
        $this->response($z, 200);
    }

    public function armada_get()
    {
        // Users from a data store e.g. database
        $armada = $this->get('id_armada');
        if ($armada == '') {
            $z = $this->db->get('tbl_armada')->result_array();
        } else {
            $this->db->where('id_armada', $armada);
            $z = $this->db->get('tbl_armada')->result();
        }
        $this->response($z, 200);
    }

    function koordinatarmada_get() {
        $armada = $this->get('armada_id');
        if ($armada == '') {
            $z = $this->db->get('tbl_koordinatarmada')->result_array();
        } else {
            $this->db->where('armada_id' , $armada);
            $z = $this->db->get('tbl_koordinatarmada')->result();
        }
        $this->response($z, 200);
    }

    public function rute_get()
    {
        $rute = $this->get('id_jalan');
        if ($rute == '') {
            $z = $this->db->get('tbl_jalan')->result_array();
        } else {
            $this->db->where('id_jalan', $rute);
            $z = $this->db->get('tbl_jalan')->result();
        }
        $this->response($z, 200);
    }

    function koordinatrute_get() {
        $rute = $this->get('jalan_id');
        if ($rute == '') {
            $z = $this->db->get('tbl_koordinatjalan')->result_array();
        } else {
            $this->db->where('jalan_id' , $rute);
            $z = $this->db->get('tbl_koordinatjalan')->result();
        }
        $this->response($z, 200);
    }

    public function relasi_get()
    {
        // Users from a data store e.g. database
        $relasi = $this->get('id_relasi');
        if ($relasi == '') {
            $z = $this->db->get('tbl_relasi')->result_array();
        } else {
            $this->db->where('id_relasi', $relasi);
            $z = $this->db->get('tbl_relasi')->result();
        }
        $this->response($z, 200);
    }
}
