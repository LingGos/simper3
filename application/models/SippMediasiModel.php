<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SippMediasiModel extends CI_Model {

    private $db2;

    public function __construct() {
        $this->tabel = 'disposisi';
        $this->tabelID = 'disID';
        $this->db2 = $this->load->database('db_sipp', TRUE);
    }

    //oke
    public function getallmediasi() {
        $query = $this->db2->query('
            SELECT nomor_perkara 
            FROM 
            perkara LIMIT 2 
            ');
        return $query->result();
    }

    
}

?>
