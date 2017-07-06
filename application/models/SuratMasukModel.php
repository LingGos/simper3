<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class SuratMasukModel extends CI_Model {
    private $tabel;
    private $tabelID;
    public function __construct() {
        $this->tabel='surat';
        $this->tabelID='surID';
    }
    //oke
    public function tambah($data) {
        $this->db->insert($this->tabel, $data);
        return $this->db->affected_rows();
    }
    //oke
    public function tambah_telaah_staff($data) {
        $this->db->insert('telaah_staff', $data);
        return $this->db->affected_rows();
    }
    //oke
    public function tambah_perkara($data) {
        $this->db->insert('perkara', $data);
        return $this->db->affected_rows();
    }
    public function getall($penID) {
        if($this->session->userdata('masuk_level')=='KASUBAGUMUM' || $this->session->userdata('masuk_level')=='PIMPINAN'){
            $query = $this->db->query('SELECT * FROM surat WHERE surKategori=? ORDER BY surTglTerimaKeluar DESC',array('M'));
            return $query->result();
        }else{    
            $query = $this->db->query('SELECT * FROM surat WHERE surKategori=? AND surID IN (SELECT disSumSukID FROM disposisi WHERE (disDariPenID=? OR disKepadaPenID=?)) ORDER BY surTglTerimaKeluar DESC',array('M',$penID,$penID));
            return $query->result();
        }
    }
    //oke,oke
    public function getbyid($id) {
        $this->db->from($this->tabel);
        $this->db->where($this->tabelID, $id);
        $query = $this->db->get();
        return $query->row();
    }
    //oke
    public function getall_tabayun($penID) {
        if($this->session->userdata('masuk_level')=='KASUBAGUMUM' || $this->session->userdata('masuk_level')=='PIMPINAN'){
            $query = $this->db->query('SELECT * FROM surat s,perkara p WHERE s.surID=p.perSurID AND s.surKategori=? AND s.surJenis=? AND s.surTabayun=? ORDER BY s.surTglTerimaKeluar DESC',array('M','PENTING','Y'));
            return $query->result();
        }else{
            $query = $this->db->query('SELECT * FROM surat s,perkara p WHERE s.surID=p.perSurID AND s.surKategori=? AND s.surJenis=? AND s.surTabayun=?  AND s.surID IN (SELECT disSumSukID FROM disposisi WHERE (disDariPenID=? OR disKepadaPenID=?))  ORDER BY s.surTglTerimaKeluar DESC',array('M','PENTING','Y',$penID,$penID));
            return $query->result();
        }
    }
    //oke
    public function getall_penting($penID) {
        if($this->session->userdata('masuk_level')=='KASUBAGUMUM' || $this->session->userdata('masuk_level')=='PIMPINAN'){
            $query = $this->db->query('SELECT * FROM surat s,telaah_staff t WHERE s.surID=t.telSumID AND s.surKategori=? AND s.surJenis=? AND s.surTabayun=? ORDER BY s.surTglTerimaKeluar DESC',array('M','PENTING','N'));
            return $query->result();
        }  else {
            $query = $this->db->query('SELECT * FROM surat s,telaah_staff t WHERE s.surID=t.telSumID AND s.surKategori=? AND s.surJenis=? AND s.surTabayun=? AND s.surID IN (SELECT disSumSukID FROM disposisi WHERE (disDariPenID=? OR disKepadaPenID=?)) ORDER BY s.surTglTerimaKeluar DESC',array('M','PENTING','N',$penID,$penID));
            return $query->result();
        }
    }
    //oke
    public function getall_rabi($penID,$surJenis) {
        if($this->session->userdata('masuk_level')=='KASUBAGUMUM' || $this->session->userdata('masuk_level')=='PIMPINAN'){
            $query = $this->db->query('SELECT * FROM surat WHERE surKategori=? AND surJenis=? AND surTabayun=? ORDER BY surTglTerimaKeluar DESC',array('M',$surJenis,'N'));
            return $query->result();
        }
    }
    //oke
    public function getbyid_telaah_staff($id) {
        $this->db->from('telaah_staff');
        $this->db->where('telSumID', $id);
        $query = $this->db->get();
        return $query->row();
    }
    public function getbyid_perkara($id) {
        $this->db->from('perkara');
        $this->db->where('perSurID', $id);
        $query = $this->db->get();
        return $query->row();
    }
    //oke
    public function ubahbyid($where, $data) {
        $this->db->update($this->tabel, $data, $where);
        return $this->db->affected_rows();
    }
    //oke
    public function ubahbyid_telaah_staff($where, $data) {
        $this->db->update('telaah_staff', $data, $where);
        return $this->db->affected_rows();
    }
    //oke
    public function ubahbyid_perkara($where,$data) {
        $this->db->update('perkara', $data, $where);
        return $this->db->affected_rows();
    }
    //oke
    public function hapusbyid($id) {
        $this->db->where($this->tabelID, $id);
        $this->db->delete($this->tabel);
        return $this->db->affected_rows();
    }
    //oke
    public function hapusbyid_telaah_staff($id) {
        $this->db->where('telSumID', $id);
        $this->db->delete('telaah_staff');
        return $this->db->affected_rows();
    }
     //oke
    public function hapusbyid_perkara($id) {
        $this->db->where('perSurID', $id);
        $this->db->delete('perkara');
        return $this->db->affected_rows();
    }


    public function getbyid_infodisposisimasuk() {
        $query = $this->db->query('
            SELECT s.*,i.*,k.*,d.*,u.uniNama,p.pegNama 
            FROM 
            indek i,klasifikasi k, surat_masuk s,disposisi d,unit u,pegawai p,pengguna pp 
            WHERE
            s.sumIndID=i.indID AND s.sumKlaID=k.klaID AND d.disJenis=? AND d.disKepadaPenID=? AND d.disKepadaPenID=pp.penID AND pp.penPegID=p.pegID AND p.pegUniID=u.uniID ORDER BY disTgl DESC'
            ,array('M',$this->session->userdata('masuk_id')));
        return $query->result();
    }
    
    public function getbyid_infodisposisikeluar() {
        $query = $this->db->query('
            SELECT s.*,i.*,k.*,d.*,u.uniNama,p.pegNama 
            FROM 
            indek i,klasifikasi k, surat_masuk s,disposisi d,unit u,pegawai p,pengguna pp 
            WHERE
            s.sumIndID=i.indID AND s.sumKlaID=k.klaID AND d.disJenis=? AND d.disDariPenID=? AND d.disDariPenID=pp.penID AND pp.penPegID=p.pegID AND p.pegUniID=u.uniID ORDER BY disTgl DESC'
            ,array('K',$this->session->userdata('masuk_id')));
        return $query->result();
    }
    //oke
    public function getall_suratkeluar() {
        $query=  $this->db->query('SELECT * FROM surat WHERE surKategori=?',array('K'));
         return $query->result();
    }
    //oke
    public function getall_indek() {
        $query=  $this->db->query('SELECT * FROM indek');
         return $query->result();
    }
    //oke
    public function get_NoUrut() {
        $query = $this->db->query('SELECT surNoUrut FROM surat ORDER BY surTglInput DESC LIMIT 1');
        $surNoUrut = 1;
        if (count($query->row()) > 0) {
            $surNoUrut = intval($query->row()->surNoUrut) + 1;
        }
        return $surNoUrut;
    }
   
}
?>
