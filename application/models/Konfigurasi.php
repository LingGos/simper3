<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Konfigurasi
 *
 * @author LingGos
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Konfigurasi extends CI_Model {

    public function cekSessionAkses() {
        $result = false;
        if ($this->session->userdata('masuk_valid') == TRUE && $this->session->userdata('masuk_id') != "" && $this->session->userdata('masuk_pengguna') != "" && $this->session->userdata('masuk_password') != "") {
            $result = true;
        }
        return $result;
    }

    public function cekModuleAkses($ACL, $task) {
        $result = true;
        if (isset($ACL)) {
            if (isset($ACL[$this->session->userdata('masuk_level')])) {
                if (is_array($ACL[$this->session->userdata('masuk_level')])) {
                    if ($task != null || $task != '') {
                        if (!in_array($task, $ACL[$this->session->userdata('masuk_level')])) {
                            $result = false;
                        }
                    }
                } else {
                    if ($ACL[$this->session->userdata('masuk_level')] != "*") {
                        $result = false;
                    }
                }
            } else {
                $result = false;
            }
        } else {
            $result = false;
        }

        return $result;
    }

    public function MSQLDateToNormal($tgl, $return = "") {
        $bulan = null;
        switch (intval(substr($tgl, 5, 2))) {
            case '1':$bulan = 'Januari';
                break;
            case '2':$bulan = 'Februari';
                break;
            case '3':$bulan = 'Maret';
                break;
            case '4':$bulan = 'April';
                break;
            case '5':$bulan = 'Mei';
                break;
            case '6':$bulan = 'Juni';
                break;
            case '7':$bulan = 'Juli';
                break;
            case '8':$bulan = 'Agustus';
                break;
            case '9':$bulan = 'September';
                break;
            case '10':$bulan = 'Oktober';
                break;
            case '11':$bulan = 'November';
                break;
            case '12':$bulan = 'Desember';
                break;
        }
        if ($bulan != "" || $bulan != null) {
            return (substr($tgl, 8, 9) . ' ' . $bulan . ' ' . substr($tgl, 0, 4));
        } else {
            return $return;
        }
    }

    public function MSQLDateToNormalInUnix($tgl, $return = "") {
        $bulan = null;
        switch (intval(substr($tgl, 5, 2))) {
            case '1':$bulan = 'Jan';
                break;
            case '2':$bulan = 'Feb';
                break;
            case '3':$bulan = 'Mar';
                break;
            case '4':$bulan = 'Apr';
                break;
            case '5':$bulan = 'Mei';
                break;
            case '6':$bulan = 'Jun';
                break;
            case '7':$bulan = 'Jul';
                break;
            case '8':$bulan = 'Aug';
                break;
            case '9':$bulan = 'Sep';
                break;
            case '10':$bulan = 'Okt';
                break;
            case '11':$bulan = 'Nov';
                break;
            case '12':$bulan = 'Des';
                break;
        }
        if ($bulan != "" || $bulan != null) {
            return (substr($tgl, 8, 9) . ' ' . $bulan . ' ' . substr($tgl, 0, 4));
        } else {
            return $return;
        }
    }

    function mysql_timestamp_to_human($dt) { //mysql timestamp to human readable
        $yr = strval(substr($dt, 0, 4)); //year
        $mo = strval(substr($dt, 4, 2)); //month
        $da = strval(substr($dt, 6, 2)); //day
        $hr = strval(substr($dt, 8, 2)); //hour
        $mi = strval(substr($dt, 10, 2)); //minute
        //$se=strval(substr($dt,12,2)); //sec
        return date("d M Y H:i", mktime($hr, $mi, 0, $mo, $da, $yr)) . ""; //format of displayed date and time
    }

    public function dateToFormHtml($tgl) {
        $data = array();
        $data = explode('-', $tgl);
        $tgl = implode('.', $data);
        return $tgl;
    }

    public function dateToMysql($tgl) {
        $data = array();
        $data = explode('.', $tgl);
        $tgl = implode('-', $data);
        return $tgl;
    }

    public function dateMysqlToLap($tgl) {
        $data = array();
        $data = explode('-', $tgl);
        $tgl = implode('/', $data);
        return $tgl;
    }

    public function selisihTgl($date1, $date2) {
        $datetime1 = new DateTime($date1);
        $datetime2 = new DateTime($date2);
        $difference = $datetime1->diff($datetime2);
        return $difference->days;
//  return ((abs(strtotime ($date1) - strtotime ($date2)))/(60*60*24));
    }

    public function TambahKurangTgl($date, $jml) {
//        $date = "2012-02-16";
        return strtotime('-3 day', strtotime($date)); //mengurangi 3 hari hasilnya 2012-02-13
    }

    public function cek_koneksi_internet() {
        $connected = @fsockopen("www.google.com", 80);
        if ($connected) {
            fclose($connected);
            return true;
        } else {
            return false;
        }
    }

    public function getNamaHari($tgl, $sep) {
        $sepparator = $sep; //separator. contoh: '-', '/'
        $parts = explode($sepparator, $tgl);
        $d = date("l", mktime(0, 0, 0, $parts[1], $parts[2], $parts[0]));

        if ($d == 'Monday') {
            return 'Senin';
        } elseif ($d == 'Tuesday') {
            return 'Selasa';
        } elseif ($d == 'Wednesday') {
            return 'Rabu';
        } elseif ($d == 'Thursday') {
            return 'Kamis';
        } elseif ($d == 'Friday') {
            return 'Jumat';
        } elseif ($d == 'Saturday') {
            return 'Sabtu';
        } elseif ($d == 'Sunday') {
            return 'Minggu';
        } else {
            return 'ERROR!';
        }
    }

    public function getNamaHariInUnix($tgl, $sep) {
        $sepparator = $sep; //separator. contoh: '-', '/'
        $parts = explode($sepparator, $tgl);
        $d = date("l", mktime(0, 0, 0, $parts[1], $parts[2], $parts[0]));

        if ($d == 'Monday') {
            return 'Sen';
        } elseif ($d == 'Tuesday') {
            return 'Sel';
        } elseif ($d == 'Wednesday') {
            return 'Rab';
        } elseif ($d == 'Thursday') {
            return 'Kam';
        } elseif ($d == 'Friday') {
            return 'Jum';
        } elseif ($d == 'Saturday') {
            return 'Sabtu';
        } elseif ($d == 'Sunday') {
            return 'Min';
        } else {
            return 'ERROR!';
        }
    }

    public function getNamaBulan($bulan_angka) {
        $bulan = null;
        switch (intval($bulan_angka)) {
            case 1:$bulan = 'Januari';
                break;
            case 2:$bulan = 'Februari';
                break;
            case 3:$bulan = 'Maret';
                break;
            case 4:$bulan = 'April';
                break;
            case 5:$bulan = 'Mei';
                break;
            case 6:$bulan = 'Juni';
                break;
            case 7:$bulan = 'Juli';
                break;
            case 8:$bulan = 'Agustus';
                break;
            case 9:$bulan = 'September';
                break;
            case 10:$bulan = 'Oktober';
                break;
            case 11:$bulan = 'November';
                break;
            case 12:$bulan = 'Desember';
                break;
        }
        return $bulan;
    }

    public function getNamaBulanInUnix($bulan_angka) {
        $bulan = null;
        switch (intval($bulan_angka)) {
            case 1:$bulan = 'Jan';
                break;
            case 2:$bulan = 'Feb';
                break;
            case 3:$bulan = 'Mar';
                break;
            case 4:$bulan = 'Apr';
                break;
            case 5:$bulan = 'Mei';
                break;
            case 6:$bulan = 'Jun';
                break;
            case 7:$bulan = 'Jul';
                break;
            case 8:$bulan = 'Agu';
                break;
            case 9:$bulan = 'Sep';
                break;
            case 10:$bulan = 'Okt';
                break;
            case 11:$bulan = 'Nov';
                break;
            case 12:$bulan = 'Des';
                break;
        }
        return $bulan;
    }

    public function getJmlHari($bln, $thn) {
        return cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
        ;
    }

    public function getRentangHari($start_date, $end_date) {
        //fungsi echo tgl awal sampai tgl akhir
        $date = array();
        $i = 0;
        while (strtotime($start_date) <= strtotime($end_date)) {
            $date[$i] = $start_date;
            $start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
            $i++;
        }
        return $date;
    }

    public function getRentangBulan($start_date, $end_date) {
        //fungsi echo tgl awal sampai tgl akhir
        $date = array();
        $i = 0;
        while (strtotime($start_date) <= strtotime($end_date)) {
            $date[$i] = date_format(date_create($start_date), "Y-m");
            $start_date = date("Y-m", strtotime("+1 month", strtotime($start_date)));
            $i++;
        }
        return $date;
    }

    public function getRentangTahun($start_thn, $end_thn) {
        $data = array();
        for ($i = intval($start_thn); $i <= intval($end_thn); $i++) {
            array_push($data, $i);
        }
        return $data;
    }

}

?>
