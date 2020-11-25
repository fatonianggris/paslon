<?php

class Pekerjaanmodel extends CI_Model {

    private $pekerjaan = 'pekerjaan';

    /**
     * METHOD/FUNCTION JOBS CRUD
     */
    public function get_pekerjaan() {

        $this->db->select('*');

        $sql = $this->db->get($this->pekerjaan);
        return $sql->result();
    }

    public function get_nama_pekerjaan($nama_pekerjaan = '') {
        $sql = $this->db->query("SELECT
                                    *
                                FROM
                                    pekerjaan
                                WHERE
                                    REPLACE(job,' ','') = '$nama_pekerjaan'");
        return $sql->result();
    }

}
