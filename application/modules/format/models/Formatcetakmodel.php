<?php

class Formatcetakmodel extends CI_Model {

    private $table_ktp = 'ktp';
    private $table_user = 'user';
    private $table_format = 'format_cetak';

    //---------------------------------------COUNT ANGGOTA KTP---------------------------------------//
    public function get_count_anggota($id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        (
                                        SELECT
                                            COUNT(id_ktp)
                                        FROM
                                            ktp
                                        WHERE
                                            id_admin = '$id_admin' AND status_data = 1
                                    ) AS ktp,
                                    (
                                        SELECT
                                            COUNT(nik_ktp) - COUNT(DISTINCT nik_ktp)
                                        FROM
                                            ktp
                                        WHERE
                                            id_admin = '$id_admin' AND status_data = 1
                                    ) AS ktp_duplicate,
                                    (
                                        SELECT
                                            COUNT(id_user)
                                        FROM
                                            user
                                        WHERE
                                            id_ref = '$id_admin'
                                    ) AS regional,
                                    (
                                        SELECT
                                            COUNT(id_petugas)
                                        FROM
                                            petugas
                                        WHERE
                                            id_admin = '$id_admin' AND status_data = 1
                                    ) AS petugas");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT
                                        (
                                        SELECT
                                            COUNT(id_ktp)
                                        FROM
                                            ktp
                                        WHERE
                                            id_admin LIKE '$id_admin%' AND status_data = 1
                                    ) AS ktp,
                                    (
                                        SELECT
                                            COUNT(nik_ktp) - COUNT(DISTINCT nik_ktp)
                                        FROM
                                            ktp
                                        WHERE
                                            id_admin LIKE '$id_admin%' AND status_data = 1
                                    ) AS ktp_duplicate,
                                    (
                                        SELECT
                                            COUNT(id_user)
                                        FROM
                                            user
                                        WHERE
                                            id_ref LIKE '$id_admin%'
                                    ) AS regional,
                                    (
                                        SELECT
                                            COUNT(id_petugas)
                                        FROM
                                            petugas
                                        WHERE
                                            id_admin LIKE '$id_admin%' AND status_data = 1
                                    ) AS petugas");
        } elseif ($role == 0) {

            $sql = $this->db->query("SELECT
                                        (
                                        SELECT
                                            COUNT(id_ktp)
                                        FROM
                                            ktp
                                       
                                    ) AS ktp,
                                    (
                                        SELECT
                                            COUNT(nik_ktp) - COUNT(DISTINCT nik_ktp)
                                        FROM
                                            ktp
                                        
                                    ) AS ktp_duplicate,
                                    (
                                        SELECT
                                            COUNT(id_user)
                                        FROM
                                            user
                                        
                                    ) AS regional,
                                    (
                                        SELECT
                                            COUNT(id_petugas)
                                        FROM
                                            petugas
                                       
                                    ) AS petugas");
        }
        return $sql->result();
    }

    //----------------------------------------GET PROV KAB KEC DESA----------------------------------------------//

    public function get_provinsi($id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT 
                                        * 
                                     FROM 
                                        wilayah_provinsi
                                     WHERE
                                        id=" . substr($id_admin, 0, 2) . "");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT 
                                        * 
                                     FROM 
                                        wilayah_provinsi
                                     WHERE
                                        id='$id_admin'");
        } elseif ($role == 0) {
            $sql = $this->db->query("SELECT 
                                        * 
                                     FROM 
                                        wilayah_provinsi");
        }
        return $sql->result();
    }

    public function get_kabupaten($id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT 
                                        * 
                                     FROM 
                                        wilayah_kabupaten
                                     WHERE
                                        id=" . substr($id_admin, 2, 2) . " AND id_dati1=" . substr($id_admin, 0, 2) . "");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT 
                                        * 
                                     FROM 
                                        wilayah_kabupaten
                                     WHERE
                                        id_dati1='$id_admin'");
        } elseif ($role == 0) {
            $sql = $this->db->query("SELECT 
                                        * 
                                     FROM 
                                        wilayah_kabupaten
                                     WHERE
                                        id_dati1='$id_admin'");
        }
        return $sql->result();
    }

    public function get_kecamatan($id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT 
                                        * 
                                     FROM 
                                        wilayah_kecamatan
                                     WHERE
                                        id_dati2=" . substr($id_admin, 2, 2) . " AND id_dati1=" . substr($id_admin, 0, 2) . "");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT 
                                        * 
                                     FROM 
                                        wilayah_kecamatan
                                     WHERE
                                        id_dati1='$id_admin'");
        } elseif ($role == 0) {
            $sql = $this->db->query("SELECT 
                                        * 
                                     FROM 
                                        wilayah_kecamatan");
        }
        return $sql->result();
    }

    public function get_kelurahan() {
        $sql = $this->db->query('SELECT * FROM wilayah_desa');
        return $sql->result();
    }

    //---------------------------------------GET KAT FORMAT-----------------------------------------------//

    public function get_format_by_kat($id) {

        $this->db->select('*');
        $this->db->where('kategori_dapil', $id);

        $sql = $this->db->get($this->table_format);
        return $sql->result();
    }

    public function get_format_by_kat_edit($id = '', $id_dapil = '') {

        $this->db->select('*');
        $this->db->where('kategori_dapil', $id_dapil);
        $this->db->where_not_in('id_format', $id);

        $sql = $this->db->get($this->table_format);
        return $sql->result();
    }

    //---------------------------------------GET AJAX KEC KAB-----------------------------------------------//

    public function get_ajax_kabupaten_edit($id_prov, $id_kab, $id_admin, $role) {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                      CONCAT(id_dati1,id) as kab_con,
                                      nama,
                                      administratif
                                FROM
                                    wilayah_kabupaten
                                WHERE
                                    id_dati1 = $id_prov AND id = " . substr($id_admin, 2, 2) . " AND CONCAT(id_dati1,id) NOT IN ($id_kab)");
        } elseif (!empty($id_admin) && ($role == 1)) {
            $sql = $this->db->query("SELECT
                                     CONCAT(id_dati1,id) as kab_con,
                                      nama,
                                      administratif
                                FROM
                                    wilayah_kabupaten
                                WHERE
                                    id_dati1 = $id_prov AND CONCAT(id_dati1,id) NOT IN ($id_kab)");
        } elseif ($role == 0) {
            $sql = $this->db->query("SELECT
                                      CONCAT(id_dati1,id) as kab_con,
                                      nama,
                                      administratif
                                FROM
                                    wilayah_kabupaten
                                WHERE
                                    id_dati1 = $id_prov AND CONCAT(id_dati1,id) NOT IN ($id_kab)");
        }
        return $sql->result();
    }

    public function get_ajax_kabupaten($id_prov, $id_kab, $id_admin, $role) {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                    *
                                FROM
                                    wilayah_kabupaten
                                WHERE
                                    id_dati1 = $id_prov AND id = " . substr($id_admin, 2, 2) . " AND CONCAT(id_dati1,id) NOT IN ($id_kab)");
        } elseif (!empty($id_admin) && ($role == 1)) {
            $sql = $this->db->query("SELECT
                                    *
                                FROM
                                    wilayah_kabupaten
                                WHERE
                                    id_dati1 = $id_prov AND CONCAT(id_dati1,id) NOT IN ($id_kab)");
        } elseif ($role == 0) {
            $sql = $this->db->query("SELECT
                                    *
                                FROM
                                    wilayah_kabupaten
                                WHERE
                                    id_dati1 = $id_prov AND CONCAT(id_dati1,id) NOT IN ($id_kab)");
        }
        return $sql->result();
    }

    public function get_ajax_kecamatan($id_prov, $id_kab, $id_kec) {
        $sql = $this->db->query("SELECT
                                    *
                                FROM
                                    wilayah_kecamatan
                                WHERE
                                    id_dati1 = $id_prov AND id_dati2 IN ($id_kab) AND CONCAT(id_dati1,id_dati2,id) NOT IN ($id_kec)");

        return $sql->result();
    }

    public function get_kabupaten_concat($id_dati1 = '') {
        $sql = $this->db->query("SELECT
                                    CONCAT(id_dati1,id) as kab_con,
                                    nama,
                                    administratif
                                FROM
                                    wilayah_kabupaten
                                WHERE
                                    id_dati1 IN ($id_dati1)");
        return $sql->result();
    }

    public function get_kecamatan_concat($id_dati1, $id_dati2) {
        $sql = $this->db->query("SELECT
                                    CONCAT(id_dati1,id_dati2,id) as kec_con, 
                                    nama
                                FROM
                                    wilayah_kecamatan
                                WHERE
                                    id_dati1 IN ($id_dati1) AND id_dati2 IN ($id_dati2)");
        return $sql->result();
    }

    public function get_kab_ajax_concat() {
        $sql = $this->db->query("SELECT
                                    CONCAT(id_dati1,id) as kab_con,
                                    UCASE(nama) AS nama,
                                    UCASE(administratif) AS administratif
                                FROM
                                    wilayah_kabupaten");
        return $sql->result();
    }

    public function get_kec_ajax_concat() {
        $sql = $this->db->query("SELECT
                                    CONCAT(id_dati1, id_dati2, id) as kec_con,
                                    UCASE(nama)AS nama                                  
                                FROM
                                    wilayah_kecamatan");
        return $sql->result();
    }

    public function get_nama_prov($id_prov) {
        $sql = $this->db->query("SELECT                                  
                                    nama                                   
                                FROM
                                    wilayah_provinsi
                                WHERE
                                    id=$id_prov");
        return $sql->result();
    }

    public function get_nama_kab($id_kab) {
        $sql = $this->db->query("SELECT                                   
                                    nama,
                                    administratif
                                FROM
                                    wilayah_kabupaten
                                WHERE
                                    CONCAT(id_dati1,id) IN ($id_kab)");
        return $sql->result();
    }

    public function get_nama_kec($id_kec) {
        $sql = $this->db->query("SELECT                                    
                                    nama                                   
                                FROM
                                    wilayah_kecamatan
                                WHERE
                                    CONCAT(id_dati1, id_dati2, id) IN ($id_kec)");
        return $sql->result();
    }

    //---------------------------------------GET ANGGOTA KTP---------------------------------------//
    public function get_label_pencarian($id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT 
                                        * 
                                     FROM 
                                        format_cetak
                                     WHERE
                                        id_admin='$id_admin'");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT 
                                        * 
                                     FROM 
                                        format_cetak
                                     WHERE
                                        id_admin LIKE '" . substr($id_admin, 0, 2) . "%' OR provinsi='$id_admin'");
        } elseif ($role == 0) {
            $sql = $this->db->query("SELECT 
                                        * 
                                     FROM 
                                        format_cetak");
        }
        return $sql->result();
    }

    public function get_by_id_format($id = '') {

        $this->db->select('*');
        $this->db->where('id_format', $id);

        $sql = $this->db->get($this->table_format);
        return $sql->result();
    }

    //---------------------------------------UPDATE FORMAT---------------------------------------//

    public function update_format($id = '', $value = '

        ') {

        $this->db->trans_begin();

        $data = array(
            'kategori_dapil' => $value['kategori_dapil'],
            'nama_alias' => $value['nama_alias'],
            'provinsi' => $value['provinsi'],
            'kabupaten' => $value['kabupaten'],
            'kecamatan' => $value['kecamatan'],
        );

        $this->db->where('id_format', $id);
        $this->db->update($this->table_format, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //--------------------------------INSERT FORMAT-----------------------------------------//

    public function insert_format($value = '', $id_admin = '') {

        $this->db->trans_begin();

        $data = array(
            'kategori_dapil' => $value['kategori_dapil'],
            'id_admin' => $id_admin,
            'nama_alias' => $value['nama_alias'],
            'provinsi' => $value['provinsi'],
            'kabupaten' => $value['kabupaten'],
            'kecamatan' => $value['kecamatan'],
        );
        $this->db->insert($this->table_format, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //--------------------------------DELETE FORMAT-----------------------------------------//


    public function delete_format($value) {

        $this->db->trans_begin();

        $this->db->where('id_format', $value);
        $this->db->delete($this->table_format);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

}

?>