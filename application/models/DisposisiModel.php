<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DisposisiModel extends CI_Model {

    private $tabel;
    private $tabelID;
    private $db2;

    public function __construct() {
        $this->tabel = 'disposisi';
        $this->tabelID = 'disID';
        $this->db2 = $this->load->database('db_gateway_papbr', TRUE);
    }

    public function tambah($data) {
        $this->db->insert($this->tabel, $data);
        return $this->db->affected_rows();
    }

    public function ubahbyid($where, $data) {
        $this->db->update($this->tabel, $data, $where);
        return $this->db->affected_rows();
    }

    public function getbyid($id) {
        $this->db->from($this->tabel);
        $this->db->where($this->tabelID, $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function hapusbyid($id) {
        $this->db->where($this->tabelID, $id);
        $this->db->delete($this->tabel);
        return $this->db->affected_rows();
    }

    //oke
    public function get_disposisi($id) {
        $query = $this->db->query('
            SELECT * 
            FROM 
            disposisi 
            WHERE
            disSumSukID=? ORDER BY disTgl ASC'
                , array($id));
        return $query->result();
    }

    //oke
    public function get_disposisi_getPegawai($penID) {
        $query = $this->db->query('
            SELECT pegawai.* 
            FROM 
            pengguna,pegawai 
            WHERE
            pengguna.penPegID=pegawai.pegID AND pengguna.penID=?'
                , array($penID));
        return $query->row();
    }

    public function getall_byiduser($penID) {
        $query = $this->db->query('
            SELECT * 
            FROM 
            disposisi 
            WHERE
            disDariPenID=? OR disKepadaPenID=? ORDER BY disTgl DESC'
                , array($penID, $penID));
        return $query->result();
    }

    public function getall_byiduser_masuk($penID) {
        $query = $this->db->query('
            SELECT * 
            FROM 
            disposisi 
            WHERE
            disKepadaPenID=? ORDER BY disTgl DESC'
                , array($penID));
        return $query->result();
    }

    public function getall_byiduser_terkirim($penID) {
        $query = $this->db->query('
            SELECT * 
            FROM 
            disposisi 
            WHERE
            disDariPenID=? ORDER BY disTgl DESC'
                , array($penID));
        return $query->result();
    }

    public function get_countnotif($penID) {
        $query = $this->db->query('
                SELECT * 
                FROM
                disposisi
                WHERE
                disKepadaPenID=? AND disBuka=?
                ORDER BY disTgl DESC'
                , array($penID, 'N')
        );
        return $query->result();
    }

    public function getall_tujuan_disposisi($penID) {
        $query = $this->db->query('
                SELECT * 
                FROM
                pengguna,pegawai,unit
                WHERE
                penPegID=pegID AND pegUniID=uniID AND penStatus=? AND penLevel!=? AND penID !=?'
                , array('Y', 'ROOT', $penID)
        );
        return $query->result();
    }
    public function getall_koorjs_disposisi() {
        $query = $this->db->query('
                SELECT * 
                FROM
                pengguna,pegawai,unit
                WHERE
                penPegID=pegID AND pegUniID=uniID AND penStatus=? AND penLevel=?'
                , array('Y', 'KOORJS')
        );
        return $query->result();
    }
    public function getall_js_disposisi() {
        $query = $this->db->query('
                SELECT * 
                FROM
                pegawai,unit
                WHERE
                pegUniID=uniID AND pegUniID=?'
                ,array(config_item('ID_JABJS/JSP_AKTIF'))
        );
        return $query->result();
    }

    public function kirim_pesan_sms($data = array()) {
        $nohp = $data['nohp'];
        $pesan = $data['pesan'];
        $jmlSMS = ceil(strlen($pesan) / 153);
        $pecah = str_split($pesan, 153);
        $query = $this->db2->query('SHOW TABLE STATUS LIKE ? ', array('outbox'));
        $newID = $query->row()->Auto_increment;
        for ($i = 1; $i <= $jmlSMS; $i++) {
            $udh = "050003A7" . sprintf("%02s", $jmlSMS) . sprintf("%02s", $i);
            $msg = $pecah[$i - 1];
            if ($i == 1) {
                $data = array(
                    'DestinationNumber' => $nohp,
                    'UDH' => $udh,
                    'TextDecoded' => $msg,
                    'ID' => $newID,
                    'Multipart' => 'true',
                    'CreatorID' => 'Gammu'
                );
                $this->db2->insert('outbox', $data);
            } else {
                $data = array(
                    'UDH' => $udh,
                    'TextDecoded' => $msg,
                    'ID' => $newID,
                    'SequencePosition' => $i
                );
                $this->db2->insert('outbox_multipart', $data);
            }
        }
    }

}

?>
