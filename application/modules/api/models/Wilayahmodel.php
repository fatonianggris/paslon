<?php

class Wilayahmodel extends CI_Model {

    private $wilayah_prov = 'wilayah_provinsi';
    private $wilayah_kab = 'wilayah_kabupaten';
    private $wilayah_kec = 'wilayah_kecamatan';
    private $wilayah_kel = 'wilayah_kelurahan';

    /**
     * METHOD/FUNCTION JOBS CRUD
     */
    public function get_provinsi() {
        $sql = $this->db->query('SELECT * FROM wilayah_provinsi');
        return $sql->result();
    }

    public function get_kabupaten($id_provinsi = '') {
        $sql = $this->db->query("SELECT
                                    *
                                FROM
                                    wilayah_kabupaten
                                WHERE
                                    id_dati1 = '$id_provinsi'");
        return $sql->result();
    }

    public function get_kecamatan($id_provinsi = '', $id_kabupaten = '') {
        $sql = $this->db->query("SELECT
                                    *
                                FROM
                                    wilayah_kecamatan
                                WHERE
                                    id_dati1 = '$id_provinsi' AND id_dati2 = '$id_kabupaten'");
        return $sql->result();
    }

    public function get_kelurahan($id_provinsi = '', $id_kabupaten = '', $id_kecamatan = '') {
        $sql = $this->db->query("SELECT
                                    *
                                FROM
                                    wilayah_desa
                                WHERE
                                    id_dati1 = '$id_provinsi' AND id_dati2 = '$id_kabupaten' AND id_dati3 = '$id_kecamatan'");
        return $sql->result();
    }

}
