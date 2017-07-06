<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class LaporanModel extends CI_Model {

    public function getDataQuery($sql, $where = "") {
        $query = $this->db->query($sql, $where);
        return $query->result();
    }
    public function getDataQueryRow($sql, $where = "") {
            $query = $this->db->query($sql, $where);
            return $query->row();
    }
}

?>
