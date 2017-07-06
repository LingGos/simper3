<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class KlasifikasiModel extends CI_Model {

    private $tabel;
    private $tabelID;

    public function __construct() {
        $this->tabel = 'klasifikasi';
        $this->tabelID = 'klaID';
    }

    public function tambah($data) {
        $this->db->insert($this->tabel, $data);
        return $this->db->affected_rows();
    }

    public function getall() {
        $query = $this->db->query("SELECT * FROM klasifikasi WHERE klaParentID IS NULL");
        return $query->result();
    }

    public function getbyid($id) {
        $this->db->from($this->tabel);
        $this->db->where($this->tabelID, $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function getbyidparent($id) {
        $query = $this->db->query("SELECT * FROM klasifikasi WHERE klaParentID=?", array($id));
        return $query->result();
    }

    public function ubahbyid($where, $data) {
        $this->db->update($this->tabel, $data, $where);
        return $this->db->affected_rows();
    }

    public function hapusbyid($id) {
        $this->db->where($this->tabelID, $id);
        $this->db->delete($this->tabel);
        return $this->db->affected_rows();
    }

}

?>
