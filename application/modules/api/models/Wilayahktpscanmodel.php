<?php

class Wilayahktpscanmodel extends CI_Model {

    private $wilayah_prov = 'wilayah_provinsi';
    private $wilayah_kab = 'wilayah_kabupaten';
    private $wilayah_kec = 'wilayah_kecamatan';
    private $wilayah_kel = 'wilayah_kelurahan';

    /**
     * METHOD/FUNCTION JOBS CRUD
     */
    public function get_nama_provinsi($nama_provinsi) {
        $sql = $this->db->query("SELECT
                                    *
                                FROM
                                    wilayah_provinsi
                                WHERE
                                    REPLACE(nama,' ','') = '$nama_provinsi'");
        return $sql->result();
    }

    public function get_nama_kabupaten($id_provinsi = '', $nama_kabupaten = '') {
        $sql = $this->db->query("SELECT
                                    *
                                FROM
                                    wilayah_kabupaten
                                WHERE
                                    id_dati1 = '$id_provinsi' AND REPLACE(nama,' ','')='$nama_kabupaten'");
        return $sql->result();
    }

    public function get_nama_kecamatan($id_provinsi = '', $id_kabupaten = '', $nama_kecamatan='') {
        $sql = $this->db->query("SELECT
                                    *
                                FROM
                                    wilayah_kecamatan
                                WHERE
                                    id_dati1 = '$id_provinsi' AND id_dati2 = '$id_kabupaten' AND REPLACE(nama,' ','')='$nama_kecamatan'");
        return $sql->result();
    }

    public function get_nama_kelurahan($id_provinsi = '', $id_kabupaten = '', $id_kecamatan = '', $nama_kelurahan='') {
        $sql = $this->db->query("SELECT
                                    *
                                FROM
                                    wilayah_desa
                                WHERE
                                    id_dati1 = '$id_provinsi' AND id_dati2 = '$id_kabupaten' AND id_dati3 = '$id_kecamatan' AND REPLACE(nama,' ','')='$nama_kelurahan'");
        return $sql->result();
    }
    
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
