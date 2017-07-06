<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MasukModel extends CI_Model {

    public function cek_masuk($penUsername, $penPassword) {
        $query = $this->db->query('SELECT * FROM pengguna WHERE penUsername=? AND penPassword=? AND penStatus=?', array($penUsername, $penPassword, 'Y'));
        return $query->row();
    }

    public function data_pengguna($pegID) {
        $query = $this->db->query('SELECT a.*,b.* FROM pegawai a,unit b WHERE a.pegUniID=b.uniID AND a.pegID = ?', array($pegID));
        return $query->row();
    }
}
