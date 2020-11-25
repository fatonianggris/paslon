<?php

class Pemilihanmodel extends CI_Model {

    private $table_pemilihan = 'pemilihan';
    private $table_tps = 'tps';
    private $table_saksi = 'saksi';
    private $table_calon_pemilihan = 'calon_pemilihan';
    private $table_hasil_pemilihan = 'hasil_pemilihan';
    private $table_suara_calon = 'suara_calon';

    //---------------------------------------COUNT PEMILIHAN---------------------------------------//
    public function get_count_pemilihan($id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                         (
                                        SELECT
                                            COUNT(id_pemilihan)
                                        FROM
                                            pemilihan
                                        WHERE
                                            id_admin = '$id_admin' AND status_data = 1
                                    ) AS pemilihan,
                                    (
                                        SELECT
                                            COUNT(id_tps)
                                        FROM
                                            tps
                                        WHERE
                                            id_admin = '$id_admin' AND status_data = 1
                                    ) AS tps,
                                    (
                                        SELECT
                                            COUNT(id_saksi)
                                        FROM
                                            saksi
                                        WHERE
                                            id_admin = '$id_admin' AND status_data = 1
                                    ) AS saksi");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT
                                         (
                                        SELECT
                                            COUNT(id_pemilihan)
                                        FROM
                                            pemilihan
                                        WHERE
                                            id_admin LIKE '$id_admin%' AND status_data = 1
                                    ) AS pemilihan,
                                    (
                                        SELECT
                                            COUNT(id_tps)
                                        FROM
                                            tps
                                        WHERE
                                            id_admin LIKE '$id_admin%' AND status_data = 1
                                    ) AS tps,
                                    (
                                        SELECT
                                            COUNT(id_saksi)
                                        FROM
                                            saksi
                                        WHERE
                                            id_admin LIKE '$id_admin%' AND status_data = 1
                                    ) AS saksi");
        } elseif ($role == 0) {

            $sql = $this->db->query("SELECT
                                        (
                                        SELECT
                                            COUNT(id_pemilihan)
                                        FROM
                                            pemilihan
                                       
                                    ) AS pemilihan,
                                    (
                                        SELECT
                                            COUNT(id_tps)
                                        FROM
                                            tps
                                        
                                    ) AS tps,
                                    (
                                        SELECT
                                            COUNT(id_Saksi)
                                        FROM
                                            saksi                                      
                                    ) AS saksi");
        }
        return $sql->result();
    }

    //---------------------------------------COUNT DASHBOARD---------------------------------------//
    public function get_count_dashboard($id_pemilihan = '') {

        $sql = $this->db->query("SELECT
                                         (
                                        SELECT
                                            COUNT(id_calon_pemilihan)
                                        FROM
                                            calon_pemilihan
                                        WHERE
                                            id_pemilihan = '$id_pemilihan' AND status_data = 1
                                    ) AS calon_pemilihan,
                                    (
                                        SELECT
                                            COUNT(id_saksi)
                                        FROM
                                            saksi
                                        WHERE
                                            id_pemilihan = '$id_pemilihan' AND status_data = 1
                                    ) AS saksi,
                                    (
                                        SELECT
                                            COUNT(id_tps)
                                        FROM
                                            tps
                                        WHERE
                                            id_pemilihan = '$id_pemilihan' AND status_data = 1
                                    ) AS tps");

        return $sql->result();
    }

    //---------------------------------------COUNT TPS DAN PETUGAS---------------------------------------//
    public function get_count_tps_petugas($id_wilayah_pemilihan, $id_pemilihan = "", $id_admin = '', $role = '') {


        $sql = $this->db->query("SELECT                                       
                                    (
                                        SELECT
                                            COUNT(id_tps)
                                        FROM
                                            tps
                                        WHERE
                                           id_pemilihan = '$id_pemilihan' AND id_wilayah_pemilihan = '$id_wilayah_pemilihan' AND status_data = 1
                                    ) AS tps,
                                    (
                                        SELECT
                                            COUNT(id_saksi)
                                        FROM
                                            saksi
                                        WHERE
                                            id_pemilihan = '$id_pemilihan' AND id_wilayah_pemilihan = '$id_wilayah_pemilihan' AND status_data = 1
                                    ) AS saksi");

        return $sql->result();
    }

    //---------------------------------------DATA PEMILIHAN---------------------------------------//
    public function get_data_pemilihan($id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        *
                                    FROM
                                        pemilihan
                                    WHERE
                                        id_admin = '$id_admin' AND status_data = 1");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT
                                        *
                                    FROM
                                        pemilihan
                                    WHERE
                                        id_admin LIKE '$id_admin%' AND status_data = 1");
        } elseif ($role == 0) {

            $sql = $this->db->query("SELECT
                                        *
                                    FROM
                                        pemilihan
                                    WHERE
                                        status_data = 1");
        }
        return $sql->result();
    }

    //---------------------------------------DATA PEMILIHAN ID---------------------------------------//
    public function get_data_id_pemilihan($id_pemilihan = '', $id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        *
                                    FROM
                                        pemilihan
                                    WHERE
                                      id_pemilihan = '$id_pemilihan' AND id_admin = '$id_admin' AND status_data = 1");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT
                                        *
                                    FROM
                                        pemilihan
                                    WHERE
                                      id_pemilihan = '$id_pemilihan' AND id_admin LIKE '$id_admin%' AND status_data = 1");
        } elseif ($role == 0) {

            $sql = $this->db->query("SELECT
                                        *
                                    FROM
                                        pemilihan
                                    WHERE
                                      id_pemilihan = '$id_pemilihan' AND  status_data = 1");
        }
        return $sql->result();
    }

    //---------------------------------------DATA CALON PEMILIHAN BY ID PEMILIHAN---------------------------------------//
    public function get_data_id_calon_pemilihan($id_pemilihan = "") {

        $sql = $this->db->query("SELECT
                                    cp.*,
                                    (
                                    SELECT
                                        SUM(hp.suara_sah)
                                    FROM
                                        suara_calon hp
                                    WHERE
                                        hp.id_pemilihan = cp.id_pemilihan AND hp.id_calon_pemilihan=cp.id_calon_pemilihan
                                ) AS total_suara
                                FROM
                                    calon_pemilihan cp
                                WHERE                             
                                    cp.id_pemilihan = '$id_pemilihan' AND cp.status_data = 1");

        return $sql->result();
    }

    //---------------------------------------DATA SUARA PROVINSI---------------------------------------//
    public function get_suara_provinsi($id_pemilihan = '', $id_kategori = '', $id_regional_pemilihan = "") {


        if ($id_kategori == 1 || $id_kategori == 2) {

            $sql = $this->db->query("SELECT
                                        wp.nama AS provinsi,                                    
                                        (
                                        SELECT
                                            COUNT(id_tps)
                                        FROM
                                            tps
                                        WHERE
                                            SUBSTRING(id_wilayah_pemilihan,1,2) = wp.id AND status_data = 1 AND id_pemilihan = '$id_pemilihan'
                                    ) AS jumlah_tps,
                                    COALESCE((
                                        SELECT
                                            SUM(sc.suara_sah)
                                        FROM
                                            suara_calon sc
                                        LEFT JOIN calon_pemilihan cp ON
                                            cp.id_calon_pemilihan = sc.id_calon_pemilihan
                                        WHERE
                                            SUBSTRING(sc.id_wilayah_pemilihan,1,2) = wp.id AND cp.status_calon = 1 AND sc.id_pemilihan = '$id_pemilihan'
                                        GROUP BY
                                            (sc.id_calon_pemilihan)
                                    ), 0) AS total_suara
                                    FROM
                                        wilayah_provinsi wp");
        } else {
            $sql = $this->db->query("SELECT
                                        wp.nama AS provinsi,
                                        (
                                        SELECT
                                            COUNT(id_tps)
                                        FROM
                                            tps
                                        WHERE
                                            SUBSTRING(id_wilayah_pemilihan,1,2) = wp.id AND status_data = 1 AND id_pemilihan = '$id_pemilihan'
                                    ) AS jumlah_tps,
                                    COALESCE((
                                        SELECT
                                            SUM(sc.suara_sah)
                                        FROM
                                            suara_calon sc
                                        LEFT JOIN calon_pemilihan cp ON
                                            cp.id_calon_pemilihan = sc.id_calon_pemilihan
                                        WHERE
                                            SUBSTRING(sc.id_wilayah_pemilihan,1,2) = wp.id AND cp.status_calon = 1 AND sc.id_pemilihan = '$id_pemilihan'
                                        GROUP BY
                                            (sc.id_calon_pemilihan)
                                    ), 0) AS total_suara
                                    FROM
                                        wilayah_provinsi wp
                                    WHERE
                                        wp.id = SUBSTRING($id_regional_pemilihan,1,2)");
        }

        return $sql->result();
    }

    //---------------------------------------DATA SUARA KABUPATEN---------------------------------------//
    public function get_suara_kabupaten($id_pemilihan = '', $id_kategori = '', $id_regional_pemilihan = "") {


        if ($id_kategori == 1 || $id_kategori == 2) {

            $sql = $this->db->query("SELECT
                                            wkb.nama AS kabupaten,
                                            wkb.administratif AS adm,
                                            (
                                            SELECT
                                                COUNT(id_tps)
                                            FROM
                                                tps
                                            WHERE
                                                SUBSTRING(id_wilayah_pemilihan,1,2) = wkb.id_dati1 AND SUBSTRING(id_wilayah_pemilihan,3,2) = wkb.id AND status_data = 1 AND id_pemilihan = '$id_pemilihan'
                                        ) AS jumlah_tps,
                                        COALESCE((
                                            SELECT
                                                SUM(sc.suara_sah)
                                            FROM
                                                suara_calon sc
                                            LEFT JOIN calon_pemilihan cp ON
                                                cp.id_calon_pemilihan = sc.id_calon_pemilihan
                                            WHERE
                                                SUBSTRING(sc.id_wilayah_pemilihan,1,2)  = wkb.id_dati1 AND SUBSTRING(sc.id_wilayah_pemilihan,3,2) = wkb.id AND cp.status_calon = 1 AND cp.id_pemilihan = '$id_pemilihan'
                                            GROUP BY
                                                (sc.id_calon_pemilihan)
                                        ), 0) AS total_suara
                                        FROM
                                                wilayah_kabupaten wkb
                                        ");
        } else if ($id_kategori == 3 || $id_kategori == 6) {
            $sql = $this->db->query("SELECT
                                        wkb.nama AS kabupaten,
                                        wkb.administratif AS adm,
                                        (
                                        SELECT
                                            COUNT(id_tps)
                                        FROM
                                            tps
                                        WHERE
                                            SUBSTRING(id_wilayah_pemilihan,1,2) = wkb.id_dati1 AND SUBSTRING(id_wilayah_pemilihan,3,2) = wkb.id AND status_data = 1 AND id_pemilihan = '$id_pemilihan'
                                    ) AS jumlah_tps,
                                    COALESCE((
                                        SELECT
                                            SUM(sc.suara_sah)
                                        FROM
                                            suara_calon sc
                                        LEFT JOIN calon_pemilihan cp ON
                                            cp.id_calon_pemilihan = sc.id_calon_pemilihan
                                        WHERE
                                            SUBSTRING(sc.id_wilayah_pemilihan,1,2)  = wkb.id_dati1 AND SUBSTRING(sc.id_wilayah_pemilihan,3,2) = wkb.id AND cp.status_calon = 1 AND cp.id_pemilihan = '$id_pemilihan'
                                        GROUP BY
                                            (sc.id_calon_pemilihan)
                                    ), 0) AS total_suara
                                    FROM
                                            wilayah_kabupaten wkb
                                    WHERE
                                        wkb.id_dati1 = SUBSTRING($id_regional_pemilihan,1,2)");
        } else {
            $sql = $this->db->query("SELECT
                                        wkb.nama AS kabupaten,
                                        wkb.administratif AS adm,
                                        (
                                        SELECT
                                            COUNT(id_tps)
                                        FROM
                                            tps
                                        WHERE
                                            SUBSTRING(id_wilayah_pemilihan,1,2) = wkb.id_dati1 AND SUBSTRING(id_wilayah_pemilihan,3,2) = wkb.id AND status_data = 1 AND id_pemilihan = '$id_pemilihan'
                                    ) AS jumlah_tps,
                                    COALESCE((
                                        SELECT
                                            SUM(sc.suara_sah)
                                        FROM
                                            suara_calon sc
                                        LEFT JOIN calon_pemilihan cp ON
                                            cp.id_calon_pemilihan = sc.id_calon_pemilihan
                                        WHERE
                                            SUBSTRING(sc.id_wilayah_pemilihan,1,2)  = wkb.id_dati1 AND SUBSTRING(sc.id_wilayah_pemilihan,3,2) = wkb.id AND cp.status_calon = 1 AND cp.id_pemilihan = '$id_pemilihan'
                                        GROUP BY
                                            (sc.id_calon_pemilihan)
                                    ), 0) AS total_suara
                                    FROM
                                            wilayah_kabupaten wkb
                                    WHERE
                                        wkb.id_dati1 = SUBSTRING($id_regional_pemilihan,1,2) AND wkb.id = SUBSTRING($id_regional_pemilihan,3,2)");
        }

        return $sql->result();
    }

    //---------------------------------------DATA SUARA KABUPATEN---------------------------------------//
    public function get_suara_kecamatan($id_pemilihan = '', $id_kategori = '', $id_regional_pemilihan = "") {


        if ($id_kategori == 1 || $id_kategori == 2) {

            $sql = $this->db->query("SELECT
                                            wkc.nama AS kecamatan,
                                            (
                                            SELECT
                                                COUNT(id_tps)
                                            FROM
                                                tps
                                            WHERE
                                                SUBSTRING(id_wilayah_pemilihan, 1, 2) = wkc.id_dati1 AND SUBSTRING(id_wilayah_pemilihan, 3, 2) = wkc.id_dati2 AND SUBSTRING(id_wilayah_pemilihan, 5, 2) = wkc.id AND status_data = 1 AND id_pemilihan = '$id_pemilihan'
                                        ) AS jumlah_tps,
                                        COALESCE(
                                            (
                                            SELECT
                                                SUM(sc.suara_sah)
                                            FROM
                                                suara_calon sc
                                            LEFT JOIN calon_pemilihan cp ON
                                                cp.id_calon_pemilihan = sc.id_calon_pemilihan
                                            WHERE
                                                SUBSTRING(sc.id_wilayah_pemilihan, 1, 2) = wkc.id_dati1 AND SUBSTRING(sc.id_wilayah_pemilihan, 3, 2) = wkc.id_dati2 AND SUBSTRING(sc.id_wilayah_pemilihan, 5, 2) = wkc.id AND cp.status_calon = 1 AND cp.id_pemilihan = '$id_pemilihan'
                                            GROUP BY
                                                (sc.id_calon_pemilihan)
                                        ),
                                        0
                                        ) AS total_suara
                                        FROM
                                            wilayah_kecamatan wkc");
        } else if ($id_kategori == 3 || $id_kategori == 6) {
            $sql = $this->db->query("SELECT
                                        wkc.nama AS kecamatan,
                                        (
                                        SELECT
                                            COUNT(id_tps)
                                        FROM
                                            tps
                                        WHERE
                                            SUBSTRING(id_wilayah_pemilihan, 1, 2) = wkc.id_dati1 AND SUBSTRING(id_wilayah_pemilihan, 3, 2) = wkc.id_dati2 AND SUBSTRING(id_wilayah_pemilihan, 5, 2) = wkc.id AND status_data = 1 AND id_pemilihan = '$id_pemilihan'
                                    ) AS jumlah_tps,
                                    COALESCE(
                                        (
                                        SELECT
                                            SUM(sc.suara_sah)
                                        FROM
                                            suara_calon sc
                                        LEFT JOIN calon_pemilihan cp ON
                                            cp.id_calon_pemilihan = sc.id_calon_pemilihan
                                        WHERE
                                            SUBSTRING(sc.id_wilayah_pemilihan, 1, 2) = wkc.id_dati1 AND SUBSTRING(sc.id_wilayah_pemilihan, 3, 2) = wkc.id_dati2 AND SUBSTRING(sc.id_wilayah_pemilihan, 5, 2) = wkc.id AND cp.status_calon = 1 AND cp.id_pemilihan = '$id_pemilihan'
                                        GROUP BY
                                            (sc.id_calon_pemilihan)
                                    ),
                                    0
                                    ) AS total_suara
                                    FROM
                                        wilayah_kecamatan wkc  
                                    WHERE
                                        wkc.id_dati1 = SUBSTRING($id_regional_pemilihan,1,2)");
        } else {
            $sql = $this->db->query("SELECT
                                        wkc.nama AS kecamatan,
                                        (
                                        SELECT
                                            COUNT(id_tps)
                                        FROM
                                            tps
                                        WHERE
                                            SUBSTRING(id_wilayah_pemilihan, 1, 2) = wkc.id_dati1 AND SUBSTRING(id_wilayah_pemilihan, 3, 2) = wkc.id_dati2 AND SUBSTRING(id_wilayah_pemilihan, 5, 2) = wkc.id AND status_data = 1 AND id_pemilihan = '$id_pemilihan'
                                    ) AS jumlah_tps,
                                    COALESCE(
                                        (
                                        SELECT
                                            SUM(sc.suara_sah)
                                        FROM
                                            suara_calon sc
                                        LEFT JOIN calon_pemilihan cp ON
                                            cp.id_calon_pemilihan = sc.id_calon_pemilihan
                                        WHERE
                                            SUBSTRING(sc.id_wilayah_pemilihan, 1, 2) = wkc.id_dati1 AND SUBSTRING(sc.id_wilayah_pemilihan, 3, 2) = wkc.id_dati2 AND SUBSTRING(sc.id_wilayah_pemilihan, 5, 2) = wkc.id AND cp.status_calon = 1 AND cp.id_pemilihan = '$id_pemilihan'
                                        GROUP BY
                                            (sc.id_calon_pemilihan)
                                    ),
                                    0
                                    ) AS total_suara
                                    FROM
                                        wilayah_kecamatan wkc 
                                    WHERE
                                        wkc.id_dati1 = SUBSTRING($id_regional_pemilihan,1,2) AND wkc.id_dati2 = SUBSTRING($id_regional_pemilihan,3,2)");
        }

        return $sql->result();
    }

    //---------------------------------------DATA CALON PEMILIAN BY ID---------------------------------------//
    public function get_data_id_calon($id = "") {

        $sql = $this->db->query("SELECT
                                        *
                                FROM
                                    calon_pemilihan
                                WHERE
                                    id_calon_pemilihan = '$id' AND status_data = 1");

        return $sql->result();
    }

    //---------------------------------------DATA PETUGAS SAKSI---------------------------------------//
    public function get_data_petugas_saksi($id_pemilihan = "", $id_wilayah_pemilihan = '', $id_admin = '', $role = '') {

        $sql = $this->db->query("SELECT
                                        *
                                FROM
                                    saksi
                                WHERE
                                    id_pemilihan = '$id_pemilihan' AND id_wilayah_pemilihan = '' AND status_data = 1");

        return $sql->result();
    }

    //---------------------------------------DATA PETUGAS SAKSI---------------------------------------//
    public function get_data_petugas_saksi_terpakai($id_pemilihan = "", $id_admin = '', $role = '') {

        $sql = $this->db->query("SELECT
                                    s.nama_saksi,
                                    s.nomor_ktp_saksi,
                                    s.id_wilayah_pemilihan,
                                    s.id_tps,
                                    s.id_saksi,
                                    t.nama_tps,
                                    t.nomor_tps,
                                    wpasl.nama AS provinsi,
                                    wkbasl.nama AS kabupaten,
                                    wkcasl.nama AS kecamatan,
                                    wdasl.nama AS kelurahan
                                FROM
                                    saksi s
                                LEFT JOIN tps t ON
                                    s.id_tps = t.id_tps
                                LEFT JOIN wilayah_provinsi wpasl ON
                                    wpasl.id = SUBSTRING(s.id_wilayah_pemilihan, 1, 2)
                                LEFT JOIN wilayah_kabupaten wkbasl ON
                                    wkbasl.id = SUBSTRING(s.id_wilayah_pemilihan, 3, 2) AND wkbasl.id_dati1 = SUBSTRING(s.id_wilayah_pemilihan, 1, 2)
                                LEFT JOIN wilayah_kecamatan wkcasl ON
                                    wkcasl.id = SUBSTRING(s.id_wilayah_pemilihan, 5, 2) AND wkcasl.id_dati1 = SUBSTRING(s.id_wilayah_pemilihan, 1, 2) AND wkcasl.id_dati2 = SUBSTRING(s.id_wilayah_pemilihan, 3, 2)
                                LEFT JOIN wilayah_desa wdasl ON
                                    wdasl.id = SUBSTRING(s.id_wilayah_pemilihan, 7, 2) AND wdasl.id_dati1 = SUBSTRING(s.id_wilayah_pemilihan, 1, 2) AND wdasl.id_dati2 = SUBSTRING(s.id_wilayah_pemilihan, 3, 2) AND wdasl.id_dati3 = SUBSTRING(s.id_wilayah_pemilihan, 5, 2)                              
                                WHERE
                                    s.id_pemilihan = '$id_pemilihan' AND s.id_wilayah_pemilihan !='' AND s.status_data = 1");

        return $sql->result();
    }

    //---------------------------------------DATA PETUGAS SAKSI---------------------------------------//
    public function get_data_hasil_pemilihan_suara($id_pemilihan = "", $tps = "", $id_admin = '', $role = '') {

        $sql = $this->db->query("SELECT
                                        *
                                FROM
                                    saksi
                                WHERE
                                    id_pemilihan = '$id_pemilihan' AND id_tps = '$tps' AND id_admin = '$id_admin' AND status_data = 1");

        return $sql->result();
    }

    //-----------------------------------NAMA WILAYAH------------------------------------------------//
    public function get_nama_wilayah($id_wilayah_pemilihan = '') {

        $sql = $this->db->query("SELECT
                                    CONCAT(wkl.id_dati1,'',wkl.id_dati2,'', wkl.id_dati3,'',wkl.id) AS id_wilayah,    
                                    wkl.id_dati1,
                                    wkl.id_dati2,
                                    wkl.id_dati3,
                                    wkl.id,
                                    wp.nama AS provinsi,
                                    wkb.nama AS kabupaten,
                                    wkc.nama AS kecamatan,
                                    wkl.nama AS kelurahan
                                 FROM
                                    wilayah_desa wkl
                                 LEFT JOIN wilayah_provinsi wp ON
                                    wp.id = '" . substr($id_wilayah_pemilihan, 0, 2) . "'
                                 LEFT JOIN wilayah_kabupaten wkb ON
                                    wkb.id ='" . substr($id_wilayah_pemilihan, 2, 2) . "' AND wkb.id_dati1 = '" . substr($id_wilayah_pemilihan, 0, 2) . "'
                                 LEFT JOIN wilayah_kecamatan wkc ON
                                    wkc.id ='" . substr($id_wilayah_pemilihan, 4, 2) . "' AND wkc.id_dati1 = '" . substr($id_wilayah_pemilihan, 0, 2) . "' AND wkc.id_dati2 = '" . substr($id_wilayah_pemilihan, 2, 2) . "'
                                 WHERE
                                    wkl.id ='" . substr($id_wilayah_pemilihan, 6, 2) . "' AND wkl.id_dati1 = '" . substr($id_wilayah_pemilihan, 0, 2) . "' AND wkl.id_dati2 = '" . substr($id_wilayah_pemilihan, 2, 2) . "' AND wkl.id_dati3 = '" . substr($id_wilayah_pemilihan, 4, 2) . "'");

        return $sql->result();
    }

    //--------------------------------INSERT PEMILIHAN-----------------------------------------//

    public function insert_pemilihan($value = '', $id_admin = '') {

        $this->db->trans_begin();

        $data = array(
            'id_admin' => $id_admin,
            'id_kategori_pemilihan' => $value['kategori_pemilihan'],
            'id_regional_pemilihan' => $value['id_regional_pemilihan'],
            'nama_pemilihan' => $value['nama_pemilihan'],
            'tahun_pemilihan' => $value['tahun_pemilihan'],
            'nomor_urut' => $value['nomor_urut_awal'],
            'nama_calon' => $value['nama_calon_awal'],
            'nama_wakil_calon' => $value['nama_wakil_calon_awal'],
            'path_pemilihan' => $value['path_pemilihan'],
            'foto_calon' => @$value['foto_calon'],
            'foto_calon_thumb' => @$value['foto_calon_thumb'],
            'random_value' => $value['random_value']
        );

        $this->db->insert($this->table_pemilihan, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //--------------------------------CEK NOMOR TPS--------------------------------------//
    public function cek_nomor_tps($id_pemilihan = '', $id_wilayah_pemilihan = '', $nomor_tps = '') {

        $sql = $this->db->query("SELECT
                                        nomor_tps
                                    FROM
                                        tps
                                    WHERE
                                     nomor_tps = '$nomor_tps' AND id_pemilihan = '$id_pemilihan' AND id_wilayah_pemilihan = '$id_wilayah_pemilihan' AND status_data = 1");

        return $sql->result();
    }

    //--------------------------------GET HASIL PEMILIHAN--------------------------------------//
    public function get_hasil_pemilihan($id_tps = '', $id_pemilihan = '', $id_wilayah_pemilihan = '') {

        $sql = $this->db->query("SELECT
                                        *
                                    FROM
                                        hasil_pemilihan
                                    WHERE
                                        id_tps='$id_tps' AND id_pemilihan = '$id_pemilihan' AND id_wilayah_pemilihan = '$id_wilayah_pemilihan' AND status_data = 1");

        return $sql->result();
    }

    //--------------------------------GET SUARA CALON PEMILIHAN--------------------------------------//
    public function get_hasil_suara_calon($id_pemilihan = '') {

        $sql = $this->db->query("SELECT
                                    cp.nama_calon,
                                    cp.nama_wakil_calon,
                                    cp.nomor_urut,
                                    sc.id_suara_calon,
                                    sc.id_calon_pemilihan,
                                    sc.id_pemilihan,
                                    sc.id_wilayah_pemilihan,
                                    sc.id_tps,
                                    sc.suara_sah,
                                    sc.tanggal_post,
                                    sc.status_data
                                FROM
                                    calon_pemilihan cp
                                LEFT JOIN suara_calon sc ON
                                    cp.id_calon_pemilihan = sc.id_calon_pemilihan AND cp.id_pemilihan = sc.id_pemilihan
                                WHERE
                                    cp.id_pemilihan='$id_pemilihan' AND cp.status_data = 1");
        return $sql->result();
    }

    public function get_hasil_suara_calon_view($id_tps = '', $id_pemilihan = '', $id_wilayah_pemilihan = '') {

        $sql = $this->db->query("SELECT
                                    cp.nama_calon,
                                    cp.nama_wakil_calon,
                                    cp.nomor_urut,
                                    sc.id_suara_calon,
                                    sc.id_calon_pemilihan,
                                    sc.id_pemilihan,
                                    sc.id_wilayah_pemilihan,
                                    sc.id_tps,
                                    sc.suara_sah,
                                    sc.tanggal_post,
                                    sc.status_data
                                FROM
                                    calon_pemilihan cp
                                LEFT JOIN suara_calon sc ON
                                   cp.id_pemilihan = sc.id_pemilihan AND cp.id_calon_pemilihan = sc.id_calon_pemilihan AND sc.id_wilayah_pemilihan='$id_wilayah_pemilihan' AND sc.id_tps='$id_tps'                             
                                WHERE
                                    cp.id_pemilihan='$id_pemilihan' AND cp.status_data = 1");
        return $sql->result();
    }

    public function get_hasil_suara_calon_edit($id_tps = '', $id_pemilihan = '', $id_wilayah_pemilihan = '') {

        $sql = $this->db->query("SELECT
                                    cp.nama_calon,
                                    cp.nama_wakil_calon,
                                    cp.nomor_urut,
                                    cp.id_calon_pemilihan,
                                    cp.id_pemilihan,
                                    sc.id_suara_calon,                                                   
                                    sc.id_wilayah_pemilihan,
                                    sc.id_tps,
                                    sc.suara_sah,
                                    sc.tanggal_post,
                                    sc.status_data
                                FROM
                                    calon_pemilihan cp
                                LEFT JOIN suara_calon sc ON
                                    cp.id_pemilihan = sc.id_pemilihan AND cp.id_calon_pemilihan = sc.id_calon_pemilihan AND sc.id_wilayah_pemilihan='$id_wilayah_pemilihan' AND sc.id_tps='$id_tps' 
                                WHERE
                                    cp.id_pemilihan = '$id_pemilihan' AND cp.status_data = 1");
        return $sql->result();
    }

    //--------------------------------CEK NOMOR URUT CALON--------------------------------------//
    public function get_hasil_suara($id_tps = '', $id_pemilihan = '', $id_wilayah_pemilihan = '') {

        $sql = $this->db->query("SELECT
                                        *
                                    FROM
                                        suara_calon
                                    WHERE
                                        id_tps = '$id_tps' AND id_pemilihan = '$id_pemilihan' AND id_wilayah_pemilihan='$id_wilayah_pemilihan' AND status_data = 1");

        return $sql->result();
    }

    //--------------------------------CEK NOMOR URUT CALON--------------------------------------//
    public function cek_nomor_urut_calon($id_pemilihan = '', $nama_tps = '') {

        $sql = $this->db->query("SELECT
                                        nomor_urut
                                    FROM
                                        calon_pemilihan
                                    WHERE
                                     nomor_urut = '$nama_tps' AND id_pemilihan = '$id_pemilihan' AND status_data = 1");

        return $sql->result();
    }

    //--------------------------------CEK EMAIL PETUGAS--------------------------------------//
    public function cek_email_saksi($email_saksi = '') {

        $sql = $this->db->query("SELECT
                                        email_saksi
                                    FROM
                                        saksi
                                    WHERE
                                        email_saksi = '$email_saksi' AND  status_data = 1");

        return $sql->result();
    }

    //--------------------------------GET MAX ID PEMILIHAN--------------------------------------//
    public function get_max_id_pemilihan() {

        $sql = $this->db->query("SELECT
                                        MAX(id_pemilihan) AS id_pemilihan
                                    FROM
                                        pemilihan
                                    WHERE
                                        status_data = 1");

        return $sql->result();
    }

    //--------------------------------GET MAX ID TPS--------------------------------------//
    public function get_max_id_tps() {

        $sql = $this->db->query("SELECT
                                        MAX(id_tps) AS id_tps
                                    FROM
                                        tps
                                    WHERE
                                        status_data = 1");

        return $sql->result();
    }

    //--------------------------------GET MAX ID TPS--------------------------------------//
    public function get_max_nomor_tps($id_pemilihan = '', $id_wilayah_pemilihan = '') {

        $sql = $this->db->query("SELECT
                                    MAX(
                                        CAST(
                                           nomor_tps AS INT
                                        )
                                    ) AS nomor_tps                                   
                                FROM
                                    tps
                                WHERE
                                    id_pemilihan='$id_pemilihan' AND id_wilayah_pemilihan='$id_wilayah_pemilihan' AND status_data = 1");

        return $sql->result();
    }

    //--------------------------------GET MAX ID PEMILIHAN--------------------------------------//
    public function get_min_id_calon_pemilihan($id_pemilihan = '') {

        $sql = $this->db->query("SELECT
                                        MIN(id_calon_pemilihan) AS id_calon_pemilihan
                                    FROM
                                        calon_pemilihan
                                    WHERE
                                       id_pemilihan='$id_pemilihan' AND status_data = 1");

        return $sql->result();
    }

    //--------------------------------CEK--------------------------------------//
    public function anggota_saksi($id = '') {

        $sql = $this->db->query("SELECT
                                        *
                                    FROM
                                        ktp
                                    WHERE
                                     id_ktp IN ($id) AND status_data = 1");

        return $sql->result();
    }

    //--------------------------------UPDATE STATUS HASIL PEMILIHAN-----------------------------------------//

    public function update_status_hasil_pemilihan($id_tps = '', $id_pemilihan = '', $id_wilayah_pemilihan = '') {

        $this->db->trans_begin();

        $data = array(
            'status_formulir_c1' => 1
        );

        $this->db->where('id_tps', $id_tps);
        $this->db->where('id_pemilihan', $id_pemilihan);
        $this->db->where('id_wilayah_pemilihan', $id_wilayah_pemilihan);
        $this->db->update($this->table_tps, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //--------------------------------UPDATE PASS PETUGAS SAKSI-----------------------------------------//
    public function update_password_saksi($id_saksi = '', $pass = '') {
        $passwd = md5($pass);
        $this->db->trans_begin();

        $data = array(
            'password_saksi' => $passwd
        );

        $this->db->where('id_saksi', $id_saksi);
        $this->db->update($this->table_saksi, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //--------------------------------CEK PASS PETUGAS SAKSI-----------------------------------------//
    public function cek_password_saksi($id_saksi = '', $pass = '') {

        $passwd = md5($pass);

        $this->db->where('id_saksi', $id_saksi);
        $this->db->where('password_saksi', $passwd);

        $sql = $this->db->get($this->table_saksi);
        return $sql->result();
    }

    //--------------------------------INSERT HASIL PEMILIHAN-----------------------------------------//

    public function insert_hasil_pemilihan($value = '', $id_tps = "", $id_pemilihan = "", $id_wilayah_pemilihan = '') {

        $this->db->trans_begin();

        $data = array(
            'id_pemilihan' => $id_pemilihan,
            'id_wilayah_pemilihan' => $id_wilayah_pemilihan,
            'id_tps' => $id_tps,
            'id_petugas_saksi' => $value['id_petugas_saksi'],
            'dp_dpt_laki_laki' => $value['dp_dpt_laki_laki'],
            'dp_dpt_perempuan' => $value['dp_dpt_perempuan'],
            'dp_dpph_laki_laki' => $value['dp_dpph_laki_laki'],
            'dp_dpph_perempuan' => $value['dp_dpph_perempuan'],
            'dp_dptb_laki_laki' => $value['dp_dptb_laki_laki'],
            'dp_dptb_perempuan' => $value['dp_dptb_perempuan'],
            'dp_total' => $value['dp_total'],
            'php_dpt_laki_laki' => $value['php_dpt_laki_laki'],
            'php_dpt_perempuan' => $value['php_dpt_perempuan'],
            'php_dpph_laki_laki' => $value['php_dpph_laki_laki'],
            'php_dpph_perempuan' => $value['php_dpph_perempuan'],
            'php_dptb_laki_laki' => $value['php_dptb_laki_laki'],
            'php_dptb_perempuan' => $value['php_dptb_perempuan'],
            'php_total' => $value['php_total'],
            'total_suara_sah' => $value['total_suara_sah'],
            'total_suara_tidak_sah' => $value['total_suara_tidak_sah'],
            'fotoc1_pertama' => $value['fotoc1_pertama'],
            'fotoc1_pertama_thumb' => $value['fotoc1_pertama_thumb'],
            'fotoc1_kedua' => $value['fotoc1_kedua'],
            'fotoc1_kedua_thumb' => $value['fotoc1_kedua_thumb']
        );

        $this->db->insert($this->table_hasil_pemilihan, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //--------------------------------INSERT TPS-----------------------------------------//

    public function insert_calon_pemilihan($value = '', $id_pemilihan = '') {

        $this->db->trans_begin();

        $data = array(
            'id_pemilihan' => $id_pemilihan,
            'nomor_urut' => $value['nomor_urut_awal'],
            'nama_calon' => $value['nama_calon_awal'],
            'nama_wakil_calon' => $value['nama_wakil_calon_awal']
        );

        $this->db->insert($this->table_calon_pemilihan, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //--------------------------------UPDATE CALON PEMILIHAN-----------------------------------------//

    public function update_calon_pemilihan($id = '', $value = '') {

        $this->db->trans_begin();

        $data = array(
            'nomor_urut' => $value['nomor_urut'],
            'nama_calon' => $value['nama_calon'],
            'nama_wakil_calon' => $value['nama_wakil_calon']
        );

        $this->db->where('id_calon_pemilihan', $id);
        $this->db->update($this->table_calon_pemilihan, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //--------------------------------UPDATE HASIL PEMILIHAN-----------------------------------------//

    public function update_hasil_pemilihan($value = '', $id_tps = "", $id_pemilihan = "", $id_wilayah_pemilihan = '') {

        $this->db->trans_begin();

        $data = array(
            'id_petugas_saksi' => $value['id_petugas_saksi'],
            'dp_dpt_laki_laki' => $value['dp_dpt_laki_laki'],
            'dp_dpt_perempuan' => $value['dp_dpt_perempuan'],
            'dp_dpph_laki_laki' => $value['dp_dpph_laki_laki'],
            'dp_dpph_perempuan' => $value['dp_dpph_perempuan'],
            'dp_dptb_laki_laki' => $value['dp_dptb_laki_laki'],
            'dp_dptb_perempuan' => $value['dp_dptb_perempuan'],
            'dp_total' => $value['dp_total'],
            'php_dpt_laki_laki' => $value['php_dpt_laki_laki'],
            'php_dpt_perempuan' => $value['php_dpt_perempuan'],
            'php_dpph_laki_laki' => $value['php_dpph_laki_laki'],
            'php_dpph_perempuan' => $value['php_dpph_perempuan'],
            'php_dptb_laki_laki' => $value['php_dptb_laki_laki'],
            'php_dptb_perempuan' => $value['php_dptb_perempuan'],
            'php_total' => $value['php_total'],
            'total_suara_sah' => $value['total_suara_sah'],
            'total_suara_tidak_sah' => $value['total_suara_tidak_sah'],
            'fotoc1_pertama' => $value['fotoc1_pertama'],
            'fotoc1_pertama_thumb' => $value['fotoc1_pertama_thumb'],
            'fotoc1_kedua' => $value['fotoc1_kedua'],
            'fotoc1_kedua_thumb' => $value['fotoc1_kedua_thumb']
        );

        $this->db->where('id_tps', $id_tps);
        $this->db->where('id_pemilihan', $id_pemilihan);
        $this->db->where('id_wilayah_pemilihan', $id_wilayah_pemilihan);
        $this->db->update($this->table_hasil_pemilihan, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //--------------------------------INSERT PETUGAS SAKSI-----------------------------------------//

    public function insert_petugas_saksi($value = '', $id_admin = '', $id_pemilihan = '') {

        $this->db->trans_begin();

        $data = array(
            'id_admin' => $id_admin,
            'id_pemilihan' => $id_pemilihan,
            'nama_saksi' => $value['nama_saksi'],
            'nomor_ktp_saksi' => $value['nomor_ktp_saksi'],
            'email_saksi' => $value['email_saksi'],
            'nomor_hp_saksi' => $value['nomor_hp_saksi'],
            'password_saksi' => md5($value ['password'])
        );

        $this->db->insert($this->table_saksi, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //--------------------------------INSERT PEMILIHAN-----------------------------------------//

    public function update_pemilihan($id = '', $value = '') {

        $this->db->trans_begin();

        $data = array(
            'id_kategori_pemilihan' => $value['kategori_pemilihan'],
            'id_regional_pemilihan' => $value['id_regional_pemilihan'],
            'nama_pemilihan' => $value['nama_pemilihan'],
            'tahun_pemilihan' => $value['tahun_pemilihan'],
            'nomor_urut' => $value['nomor_urut'],
            'nama_calon' => $value['nama_calon'],
            'nama_wakil_calon' => $value['nama_wakil_calon'],
            'path_pemilihan' => $value['path_pemilihan'],
            'foto_calon' => $value['foto_calon'],
            'foto_calon_thumb' => $value['foto_calon_thumb']
        );

        $this->db->where('id_pemilihan', $id);
        $this->db->update($this->table_pemilihan, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //----------------------------------GET TPS-------------------------------------//
    public function get_tps($id = '') {

        $sql = $this->db->query("SELECT 
                                      * 
                                  FROM 
                                      tps
                                  WHERE
                                      id_tps='$id'");
        return $sql->result();
    }

    //--------------------------------GET DIREKTORI-----------------------------------------//

    public function get_direktori_pemilihan_nasional() {

        $sql = $this->db->query("SELECT
                                  *
                                 FROM
                                    wilayah_provinsi
                                 WHERE NOT id = 34");

        return $sql->result();
    }

    public function get_direktori_pemilihan_provinsi($id_provinsi = "") {

        $sql = $this->db->query("SELECT
                                  *
                                 FROM
                                    wilayah_provinsi
                                 WHERE NOT id = 34 AND id='$id_provinsi'");

        return $sql->result();
    }

    public function get_direktori_pemilihan_kabupaten($id_provinsi = "", $id_kabupaten = '') {

        $sql = $this->db->query("SELECT
                                  *
                                 FROM
                                    wilayah_kabupaten
                                 WHERE id_dati1='$id_provinsi' AND id='$id_kabupaten'");

        return $sql->result();
    }

    public function get_direktori_pemilihan_kab($id_prov = '') {

        $sql = $this->db->query("SELECT 
                                        * 
                                     FROM 
                                        wilayah_kabupaten
                                     WHERE
                                        id_dati1='$id_prov'");

        return $sql->result();
    }

    public function get_direktori_pemilihan_kec($id_prov = '', $id_kab = '') {

        $sql = $this->db->query("SELECT 
                                        * 
                                     FROM 
                                        wilayah_kecamatan
                                     WHERE
                                        id_dati1='$id_prov' AND id_dati2='$id_kab'");

        return $sql->result();
    }

    public function get_direktori_pemilihan_kel($id_prov = '', $id_kab = '', $id_kec = '') {

        $sql = $this->db->query("SELECT 
                                        * 
                                     FROM 
                                        wilayah_desa
                                     WHERE
                                        id_dati1='$id_prov' AND id_dati2='$id_kab' AND id_dati3='$id_kec'");

        return $sql->result();
    }

    public function get_name_provinsi($id_provinsi = '') {
        $sql = $this->db->query("SELECT 
                                        * 
                                     FROM 
                                        wilayah_provinsi
                                     WHERE
                                        id='$id_provinsi'");
        return $sql->result();
    }

    public function get_name_kabupaten($id_provinsi = '', $id_kabupaten = '') {
        $sql = $this->db->query("SELECT 
                                        * 
                                     FROM 
                                        wilayah_kabupaten
                                     WHERE
                                        id='$id_kabupaten' AND id_dati1='$id_provinsi'");
        return $sql->result();
    }

    //--------------------------------GET PEMILIHAN BY CEK-----------------------------------------//
    public function get_by_id_pemilihan($id = '', $id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        *
                                    FROM
                                        pemilihan
                                    WHERE
                                        id_pemilihan = '$id' AND id_admin = '$id_admin' AND status_data = 1");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT
                                        *
                                    FROM
                                        pemilihan
                                    WHERE
                                        id_pemilihan = '$id' AND id_admin LIKE '$id_admin%' AND status_data = 1");
        } elseif ($role == 0) {

            $sql = $this->db->query("SELECT
                                        *
                                    FROM
                                        pemilihan
                                    WHERE
                                        id_pemilihan = '$id' AND status_data = 1");
        }

        return $sql->result();
    }

    public function get_petugas_saksi_ajax() {
        $sql = $this->db->query("SELECT
                                    id_saksi,
                                    UCASE(nama_saksi) AS nama_saksi,
                                    nomor_ktp_saksi
                                FROM
                                    saksi");
        return $sql->result();
    }

    //--------------------------------------GET ID TPS---------------------------------------//

    public function get_by_id_tps($id_tps = '') {

        $this->db->select('*');
        $this->db->where('id_tps', $id_tps);

        $sql = $this->db->get($this->table_tps);
        return $sql->result();
    }

    //---------------------------------------GET TPS---------------------------------------//
    public function get_hasil_tps($id_tps = '') {

        $sql = $this->db->query("SELECT
                                        *
                                    FROM
                                        tps 
                                    WHERE
                                       id_tps = '$id_tps' AND status_data = 1");

        return $sql->result();
    }

    //--------------------------------------GET ID TPS---------------------------------------//

    public function get_all_tps($id_pemilihan = '') {

        $sql = $this->db->query("SELECT
                                    t.*,
                                    hp.total_suara_sah,
                                    hp.total_suara_tidak_sah
                                FROM
                                    tps t
                                LEFT JOIN hasil_pemilihan hp ON
                                    hp.id_tps = t.id_tps
                                WHERE
                                    t.status_data = 1 AND t.id_pemilihan='$id_pemilihan'
                                ORDER BY
                                    t.tanggal_post
                                DESC
                                LIMIT 5");
        return $sql->result();
    }

    //--------------------------------------GET ID SAKSI---------------------------------------//

    public function get_by_id_petugas_saksi($id_saksi = '') {

        $this->db->select('*');
        $this->db->where('id_saksi', $id_saksi);

        $sql = $this->db->get($this->table_saksi);
        return $sql->result();
    }

    //--------------------------------GET WILAYAH PEMILIHAN-----------------------------------------//

    public function get_wilayah_pemilihan_nasional() {

        $sql = $this->db->query("SELECT
                                    wkc.id_dati1,
                                    wkc.id_dati2,
                                    wkc.id,
                                    wp.nama AS provinsi,
                                    wkb.nama AS kabupaten,
                                    wkc.nama AS kecamatan
                                 FROM
                                    wilayah_kecamatan wkc
                                 LEFT JOIN wilayah_provinsi wp ON
                                    wp.id = wkc.id_dati1
                                 LEFT JOIN wilayah_kabupaten wkb ON
                                    wkb.id = wkc.id_dati2 AND wkb.id_dati1 = wkc.id_dati1");

        return $sql->result();
    }

    public function get_wilayah_pemilihan_provinsi($id_provinsi = "") {

        $sql = $this->db->query("SELECT
                                    wkc.id_dati1,
                                    wkc.id_dati2,
                                    wkc.id,
                                    wp.nama AS provinsi,
                                    wkb.nama AS kabupaten,
                                    wkc.nama AS kecamatan
                                 FROM
                                    wilayah_kecamatan wkc
                                 LEFT JOIN wilayah_provinsi wp ON
                                    wp.id = wkc.id_dati1
                                 LEFT JOIN wilayah_kabupaten wkb ON
                                    wkb.id = wkc.id_dati2 AND wkb.id_dati1 = wkc.id_dati1
                                 WHERE
                                   wkc.id_dati1='$id_provinsi'");

        return $sql->result();
    }

    public function get_wilayah_pemilihan_kabupaten($id_provinsi = "", $id_kabupaten = '') {

        $sql = $this->db->query("SELECT
                                    wkc.id_dati1,
                                    wkc.id_dati2,
                                    wkc.id,
                                    wp.nama AS provinsi,
                                    wkb.nama AS kabupaten,
                                    wkc.nama AS kecamatan
                                 FROM
                                    wilayah_kecamatan wkc
                                 LEFT JOIN wilayah_provinsi wp ON
                                    wp.id = wkc.id_dati1
                                 LEFT JOIN wilayah_kabupaten wkb ON
                                    wkb.id = wkc.id_dati2 AND wkb.id_dati1 = wkc.id_dati1
                                 WHERE
                                   wkc.id_dati1='$id_provinsi' AND wkc.id_dati2 = '$id_kabupaten'");

        return $sql->result();
    }

    //--------------------------------------UPDATE STATUS PETUGAS---------------------------------------//

    public function ubah_status_petugas($id_petugas_saksi = '') {
        $this->db->trans_begin();

        $data = array(
            'id_tps' => "",
            'id_wilayah_pemilihan' => ""
        );

        $this->db->where('id_saksi', $id_petugas_saksi);
        $this->db->update($this->table_saksi, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //--------------------------------------UPDATE TPS---------------------------------------//

    public function update_tps($id_tps = '', $value = '') {
        $this->db->trans_begin();

        $data = array(
            'nama_tps' => $value['nama_tps'],
            'nomor_tps' => $value['nomor_tps'],
            'path_tps' => $value['path_tps'],
            'id_petugas_saksi' => $value['id_petugas_saksi']
        );

        $this->db->where('id_tps', $id_tps);
        $this->db->update($this->table_tps, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //--------------------------------------UPDATE TPS---------------------------------------//

    public function update_path_pemilihan($id_tps = '', $id_pemilihan = '', $id_wilayah_pemilihan = '', $value = '') {
        $this->db->trans_begin();

        $data2 = array(
            'fotoc1_pertama' => $value['fotoc1_pertama'],
            'fotoc1_pertama_thumb' => $value['fotoc1_pertama_thumb'],
            'fotoc1_kedua' => $value['fotoc1_kedua'],
            'fotoc1_kedua_thumb' => $value['fotoc1_kedua_thumb']
        );

        $this->db->where('id_tps', $id_tps);
        $this->db->where('id_pemilihan', $id_pemilihan);
        $this->db->where('id_wilayah_pemilihan', $id_wilayah_pemilihan);
        $this->db->update($this->table_hasil_pemilihan, $data2);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //--------------------------------------UPDATE PETUGAS SAKSI---------------------------------------//

    public function update_petugas_saksi($id = '', $value = '') {
        $this->db->trans_begin();

        $data = array(
            'nama_saksi' => $value['nama_saksi'],
            'nomor_ktp_saksi' => $value['nomor_ktp_saksi'],
            'email_saksi' => $value['email_saksi'],
            'nomor_hp_saksi' => $value['nomor_hp_saksi']
        );

        $this->db->where('id_saksi', $id);
        $this->db->update($this->table_saksi, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function get_provinsi($id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                    *
                                    FROM
                                    wilayah_provinsi
                                    WHERE
                                    id = " . substr($id_admin, 0, 2) . "");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT
                                    *
                                    FROM
                                    wilayah_provinsi
                                    WHERE
                                    id = '$id_admin'");
        } elseif ($role == 0) {
            $sql = $this->db->query("SELECT
                                    *
                                    FROM
                                    wilayah_provinsi");
        }
        return $sql->result();
    }

    public function get_kabupaten() {
        $sql = $this->db->query('SELECT * FROM wilayah_kabupaten');
        return $sql->result();
    }

    public function get_kabupaten_pemilihan($id = '') {
        $sql = $this->db->query("SELECT * FROM wilayah_kabupaten WHERE id_dati1='$id'");
        return $sql->result();
    }

    //--------------------------------DELETE FORMAT-----------------------------------------//


    public function delete_pemilihan($value) {

        $this->db->trans_begin();

        $this->db->where('id_pemilihan', $value);
        $this->db->delete($this->table_pemilihan);
        $this->db->where('id_pemilihan', $value);
        $this->db->delete($this->table_tps);
        $this->db->where('id_pemilihan', $value);
        $this->db->delete($this->table_saksi);
        $this->db->where('id_pemilihan', $value);
        $this->db->delete($this->table_hasil_pemilihan);
        $this->db->where('id_pemilihan', $value);
        $this->db->delete($this->table_calon_pemilihan);
        $this->db->where('id_pemilihan', $value);
        $this->db->delete($this->table_suara_calon);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function delete_tps($id_tps) {

        $this->db->trans_begin();

        $this->db->where('id_tps', $id_tps);
        $this->db->delete($this->table_tps);
        $this->db->where('id_tps', $id_tps);
        $this->db->delete($this->table_hasil_pemilihan);
        $this->db->where('id_tps', $id_tps);
        $this->db->delete($this->table_suara_calon);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function delete_petugas_saksi($value) {

        $this->db->trans_begin();

        $this->db->where('id_saksi', $value);
        $this->db->delete($this->table_saksi);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function delete_calon_pemilihan($value) {

        $this->db->trans_begin();

        $this->db->where('id_calon_pemilihan', $value);
        $this->db->delete($this->table_calon_pemilihan);

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