<?php

class Laporanmodel extends CI_Model {

    private $table_petugas = 'petugas';
    private $table_ktp = 'ktp';
    private $table_user = 'user';
    private $table_laporan = 'laporan';

    public function get_pekerjaan() {
        $sql = $this->db->query("SELECT * FROM pekerjaan");
        return $sql->result();
    }

    //---------------------------------------COUNT ANGGOTA KTP---------------------------------------//
    public function get_count($id_admin = '', $role = '') {

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

    //---------------------------------------CETAK LAPORAN ALL---------------------------------------//

    public function get_laporan($id_admin = '') {

        $sql = $this->db->query("SELECT * FROM laporan where id_admin='$id_admin'");

        return $sql->result();
    }

    public function get_name_file($id_ref = '', $role = '') {

        if (!empty($id_ref) && ($role == 2)) {

            $sql = $this->db->query("SELECT 
                                        code,
                                        nama
                                    FROM
                                        wilayah_kabupaten
                                    WHERE
                                        id = " . substr($id_ref, 2, 2) . " AND id_dati1 = " . substr($id_ref, 0, 2) . "");
        } elseif (!empty($id_ref) && ($role == 1)) {

            $sql = $this->db->query("SELECT 
                                        code,
                                        nama
                                    FROM
                                        wilayah_provinsi
                                    WHERE
                                        id = '$id_ref'");
        } elseif ($role == 0) {

            $sql = $this->db->query("SELECT 
                                        code,
                                        nama
                                    FROM
                                        wilayah_provinsi
                                    WHERE
                                        id = '$id_ref'");
        }
        return $sql->result();
    }

    public function get_ktp_id_by_distinct($id_admin = '', $role = '', $data_check = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT DISTINCT
                                            (p.id_asal),
                                            p.id_ktp,
                                            p.id_admin,
                                            p.status_data,
                                            wp.nama AS provinsi,
                                            wk.nama AS kabupaten,
                                            wkc.nama AS kecamatan,
                                            wd.nama AS kelurahan,
                                            p.tanggal_post
                                        FROM
                                            ktp p
                                        LEFT JOIN wilayah_provinsi wp ON
                                            wp.id = SUBSTRING(p.id_asal, 1, 2)
                                        LEFT JOIN wilayah_kabupaten wk ON
                                            wk.id = SUBSTRING(p.id_asal, 3, 2) AND wk.id_dati1 = SUBSTRING(p.id_asal, 1, 2)
                                        LEFT JOIN wilayah_kecamatan wkc ON
                                            wkc.id = SUBSTRING(p.id_asal, 5, 2) AND wkc.id_dati1 = SUBSTRING(p.id_asal, 1, 2) AND wkc.id_dati2 = SUBSTRING(p.id_asal, 3, 2)
                                        LEFT JOIN wilayah_desa wd ON
                                            wd.id = SUBSTRING(p.id_asal, 7, 2) AND wd.id_dati1 = SUBSTRING(p.id_asal, 1, 2) AND wd.id_dati2 = SUBSTRING(p.id_asal, 3, 2) AND wd.id_dati3 = SUBSTRING(p.id_asal, 5, 2)
                                        WHERE
                                            p.id_ktp IN($data_check) AND p.status_data = 1
                                        GROUP BY
                                            p.id_asal
                                        ORDER BY
                                            p.tanggal_post
                                        DESC");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT DISTINCT
                                            (p.id_asal),
                                            p.id_ktp,
                                            p.id_admin,
                                            p.status_data,
                                            wp.nama AS provinsi,
                                            wk.nama AS kabupaten,
                                            wkc.nama AS kecamatan,
                                            wd.nama AS kelurahan,
                                            p.tanggal_post
                                        FROM
                                            ktp p
                                        LEFT JOIN wilayah_provinsi wp ON
                                            wp.id = SUBSTRING(p.id_asal, 1, 2)
                                        LEFT JOIN wilayah_kabupaten wk ON
                                            wk.id = SUBSTRING(p.id_asal, 3, 2) AND wk.id_dati1 = SUBSTRING(p.id_asal, 1, 2)
                                        LEFT JOIN wilayah_kecamatan wkc ON
                                            wkc.id = SUBSTRING(p.id_asal, 5, 2) AND wkc.id_dati1 = SUBSTRING(p.id_asal, 1, 2) AND wkc.id_dati2 = SUBSTRING(p.id_asal, 3, 2)
                                        LEFT JOIN wilayah_desa wd ON
                                            wd.id = SUBSTRING(p.id_asal, 7, 2) AND wd.id_dati1 = SUBSTRING(p.id_asal, 1, 2) AND wd.id_dati2 = SUBSTRING(p.id_asal, 3, 2) AND wd.id_dati3 = SUBSTRING(p.id_asal, 5, 2)
                                        WHERE
                                            p.id_ktp IN($data_check) AND p.status_data = 1
                                        GROUP BY
                                            p.id_asal
                                        ORDER BY
                                            p.tanggal_post
                                        DESC");
        } elseif ($role == 0) {

            $sql = $this->db->query("SELECT DISTINCT
                                            (p.id_asal),
                                            p.id_ktp,
                                            p.id_admin,
                                            p.status_data,
                                            wp.nama AS provinsi,
                                            wk.nama AS kabupaten,
                                            wkc.nama AS kecamatan,
                                            wd.nama AS kelurahan,
                                            p.tanggal_post
                                        FROM
                                            ktp p
                                        LEFT JOIN wilayah_provinsi wp ON
                                            wp.id = SUBSTRING(p.id_asal, 1, 2)
                                        LEFT JOIN wilayah_kabupaten wk ON
                                            wk.id = SUBSTRING(p.id_asal, 3, 2) AND wk.id_dati1 = SUBSTRING(p.id_asal, 1, 2)
                                        LEFT JOIN wilayah_kecamatan wkc ON
                                            wkc.id = SUBSTRING(p.id_asal, 5, 2) AND wkc.id_dati1 = SUBSTRING(p.id_asal, 1, 2) AND wkc.id_dati2 = SUBSTRING(p.id_asal, 3, 2)
                                        LEFT JOIN wilayah_desa wd ON
                                            wd.id = SUBSTRING(p.id_asal, 7, 2) AND wd.id_dati1 = SUBSTRING(p.id_asal, 1, 2) AND wd.id_dati2 = SUBSTRING(p.id_asal, 3, 2) AND wd.id_dati3 = SUBSTRING(p.id_asal, 5, 2)
                                        WHERE
                                            p.id_ktp IN($data_check)
                                        GROUP BY
                                            p.id_asal
                                        ORDER BY
                                            p.tanggal_post
                                        DESC");
        }
        return $sql->result();
    }

    public function get_ktp_by_id_asal($id_asal = '', $id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            p.id_ktp,
                                            p.id_asal,
                                            p.id_admin,
                                            p.nik_kta_baru,
                                            wp.nama AS provinsi,
                                            wk.nama AS kabupaten,
                                            wkc.nama AS kecamatan,
                                            wd.nama AS kelurahan,
                                            p.id_petugas,
                                            pt.nama_petugas,
                                            p.nik_ktp,
                                            p.nama_ktp,
                                            p.tempat_lahir,
                                            p.tanggal_lahir,
                                            p.jenis_kelamin,
                                            p.gol_darah,
                                            p.alamat_ktp,
                                            p.agama,
                                            p.status_nikah,
                                            p.pekerjaan,
                                            p.rt,
                                            p.rw,
                                            p.nomor_hp_ktp,
                                            p.img,
                                            p.img_thumb,
                                            p.status_data,
                                            p.tanggal_post
                                        FROM
                                            ktp p
                                        LEFT JOIN petugas pt ON
                                            p.id_petugas = pt.id_petugas AND p.status_data = 1 AND pt.status_data = 1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            wp.id = SUBSTRING(p.id_asal, 1, 2)
                                        LEFT JOIN wilayah_kabupaten wk ON
                                            wk.id = SUBSTRING(p.id_asal, 3, 2) AND wk.id_dati1 = SUBSTRING(p.id_asal, 1, 2)
                                        LEFT JOIN wilayah_kecamatan wkc ON
                                            wkc.id = SUBSTRING(p.id_asal, 5, 2) AND wkc.id_dati1 = SUBSTRING(p.id_asal, 1, 2) AND wkc.id_dati2 = SUBSTRING(p.id_asal, 3, 2)
                                        LEFT JOIN wilayah_desa wd ON
                                            wd.id = SUBSTRING(p.id_asal, 7, 2) AND wd.id_dati1 = SUBSTRING(p.id_asal, 1, 2) AND wd.id_dati2 = SUBSTRING(p.id_asal, 3, 2) AND wd.id_dati3 = SUBSTRING(p.id_asal, 5, 2)
                                    ) t
                                    WHERE
                                        t.id_asal = '$id_asal' AND t.id_admin = '$id_admin' AND t.status_data = 1
                                    ORDER BY
                                        t.tanggal_post
                                    DESC");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            p.id_ktp,
                                            p.id_asal,
                                            p.id_admin,
                                            p.nik_kta_baru,
                                            wp.nama AS provinsi,
                                            wk.nama AS kabupaten,
                                            wkc.nama AS kecamatan,
                                            wd.nama AS kelurahan,
                                            p.id_petugas,
                                            pt.nama_petugas,
                                            p.nik_ktp,
                                            p.nama_ktp,
                                            p.tempat_lahir,
                                            p.tanggal_lahir,
                                            p.jenis_kelamin,
                                            p.gol_darah,
                                            p.alamat_ktp,
                                            p.agama,
                                            p.status_nikah,
                                            p.pekerjaan,
                                            p.rt,
                                            p.rw,
                                            p.nomor_hp_ktp,
                                            p.img,
                                            p.img_thumb,
                                            p.status_data,
                                            p.tanggal_post
                                        FROM
                                            ktp p
                                        LEFT JOIN petugas pt ON
                                            p.id_petugas = pt.id_petugas AND p.status_data = 1 AND pt.status_data = 1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            wp.id = SUBSTRING(p.id_asal, 1, 2)
                                        LEFT JOIN wilayah_kabupaten wk ON
                                            wk.id = SUBSTRING(p.id_asal, 3, 2) AND wk.id_dati1 = SUBSTRING(p.id_asal, 1, 2)
                                        LEFT JOIN wilayah_kecamatan wkc ON
                                            wkc.id = SUBSTRING(p.id_asal, 5, 2) AND wkc.id_dati1 = SUBSTRING(p.id_asal, 1, 2) AND wkc.id_dati2 = SUBSTRING(p.id_asal, 3, 2)
                                        LEFT JOIN wilayah_desa wd ON
                                            wd.id = SUBSTRING(p.id_asal, 7, 2) AND wd.id_dati1 = SUBSTRING(p.id_asal, 1, 2) AND wd.id_dati2 = SUBSTRING(p.id_asal, 3, 2) AND wd.id_dati3 = SUBSTRING(p.id_asal, 5, 2)
                                    ) t
                                    WHERE
                                        t.id_asal = '$id_asal' AND t.id_admin LIKE '$id_admin%' AND t.status_data = 1
                                    ORDER BY
                                        t.tanggal_post
                                    DESC");
        } elseif ($role == 0) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            p.id_ktp,
                                            p.id_asal,
                                            p.id_admin,
                                            p.nik_kta_baru,
                                            wp.nama AS provinsi,
                                            wk.nama AS kabupaten,
                                            wkc.nama AS kecamatan,
                                            wd.nama AS kelurahan,
                                            p.id_petugas,
                                            pt.nama_petugas,
                                            p.nik_ktp,
                                            p.nama_ktp,
                                            p.tempat_lahir,
                                            p.tanggal_lahir,
                                            p.jenis_kelamin,
                                            p.gol_darah,
                                            p.alamat_ktp,
                                            p.agama,
                                            p.status_nikah,
                                            p.pekerjaan,
                                            p.rt,
                                            p.rw,
                                            p.nomor_hp_ktp,
                                            p.img,
                                            p.img_thumb,
                                            p.status_data,
                                            p.tanggal_post
                                        FROM
                                            ktp p
                                        LEFT JOIN petugas pt ON
                                            p.id_petugas = pt.id_petugas AND p.status_data = 1 AND pt.status_data = 1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            wp.id = SUBSTRING(p.id_asal, 1, 2)
                                        LEFT JOIN wilayah_kabupaten wk ON
                                            wk.id = SUBSTRING(p.id_asal, 3, 2) AND wk.id_dati1 = SUBSTRING(p.id_asal, 1, 2)
                                        LEFT JOIN wilayah_kecamatan wkc ON
                                            wkc.id = SUBSTRING(p.id_asal, 5, 2) AND wkc.id_dati1 = SUBSTRING(p.id_asal, 1, 2) AND wkc.id_dati2 = SUBSTRING(p.id_asal, 3, 2)
                                        LEFT JOIN wilayah_desa wd ON
                                            wd.id = SUBSTRING(p.id_asal, 7, 2) AND wd.id_dati1 = SUBSTRING(p.id_asal, 1, 2) AND wd.id_dati2 = SUBSTRING(p.id_asal, 3, 2) AND wd.id_dati3 = SUBSTRING(p.id_asal, 5, 2)
                                    ) t
                                    WHERE
                                        t.id_asal = '$id_asal'
                                    ORDER BY
                                        t.tanggal_post
                                    DESC");
        }
        return $sql->result();
    }

    //---------------------------------------CETAK FOTO ALL---------------------------------------//

    public function cetak_all_ktp($id_admin = '', $role = '', $data_check = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            k.id_ktp,
                                            k.id_petugas,                                          
                                            k.status_data,
                                            k.id_admin,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            wk.nama AS kecamatan,
                                            wd.nama AS kelurahan,
                                            k.nik_ktp,
                                            k.nama_ktp,
                                            k.tempat_lahir,
                                            k.tanggal_lahir,
                                            k.rt,
                                            k.rw,
                                            k.jenis_kelamin,
                                            k.alamat_ktp,
                                            k.pekerjaan,
                                            k.img_thumb
                                        FROM
                                            ktp k
                                        LEFT JOIN petugas p ON
                                            k.id_petugas = p.id_petugas
                                        LEFT JOIN wilayah_desa wd ON
                                            SUBSTRING(k.id_asal, 7, 2) = wd.id AND SUBSTRING(k.id_asal, 1, 2) = wd.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wd.id_dati2 AND SUBSTRING(k.id_asal, 5, 2) = wd.id_dati3
                                        LEFT JOIN wilayah_kecamatan wk ON
                                            SUBSTRING(k.id_asal, 5, 2) = wk.id AND SUBSTRING(k.id_asal, 1, 2) = wk.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wk.id_dati2
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTRING(k.id_asal, 3, 2) = wkb.id AND SUBSTRING(k.id_asal, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTRING(k.id_asal, 1, 2) = wp.id
                                    ) t
                                    WHERE
                                        t.id_admin = '$id_admin' AND t.status_data = 1 AND t.id_ktp IN($data_check)
                                    ORDER BY
                                        t.id_ktp ASC");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            k.id_ktp,
                                            k.id_petugas,                                           
                                            k.status_data,
                                            k.id_admin,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            wk.nama AS kecamatan,
                                            wd.nama AS kelurahan,
                                            k.nik_ktp,
                                            k.nama_ktp,
                                            k.tempat_lahir,
                                            k.tanggal_lahir,
                                            k.rt,
                                            k.rw,
                                            k.jenis_kelamin,
                                            k.alamat_ktp,
                                            k.pekerjaan,
                                            k.img_thumb
                                        FROM
                                            ktp k
                                        LEFT JOIN petugas p ON
                                            k.id_petugas = p.id_petugas
                                        LEFT JOIN wilayah_desa wd ON
                                            SUBSTRING(k.id_asal, 7, 2) = wd.id AND SUBSTRING(k.id_asal, 1, 2) = wd.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wd.id_dati2 AND SUBSTRING(k.id_asal, 5, 2) = wd.id_dati3
                                        LEFT JOIN wilayah_kecamatan wk ON
                                            SUBSTRING(k.id_asal, 5, 2) = wk.id AND SUBSTRING(k.id_asal, 1, 2) = wk.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wk.id_dati2
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTRING(k.id_asal, 3, 2) = wkb.id AND SUBSTRING(k.id_asal, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTRING(k.id_asal, 1, 2) = wp.id
                                    ) t
                                    WHERE
                                        t.id_admin LIKE '$id_admin%' AND t.status_data = 1 AND t.id_ktp IN($data_check)
                                    ORDER BY
                                        t.id_ktp ASC");
        } elseif ($role == 0) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            k.id_ktp,
                                            k.id_petugas,                                         
                                            k.status_data,
                                            k.id_admin,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            wk.nama AS kecamatan,
                                            wd.nama AS kelurahan,
                                            k.nik_ktp,
                                            k.nama_ktp,
                                            k.tempat_lahir,
                                            k.tanggal_lahir,
                                            k.rt,
                                            k.rw,
                                            k.jenis_kelamin,
                                            k.alamat_ktp,
                                            k.pekerjaan,
                                            k.img_thumb
                                        FROM
                                            ktp k
                                        LEFT JOIN petugas p ON
                                            k.id_petugas = p.id_petugas
                                        LEFT JOIN wilayah_desa wd ON
                                            SUBSTRING(k.id_asal, 7, 2) = wd.id AND SUBSTRING(k.id_asal, 1, 2) = wd.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wd.id_dati2 AND SUBSTRING(k.id_asal, 5, 2) = wd.id_dati3
                                        LEFT JOIN wilayah_kecamatan wk ON
                                            SUBSTRING(k.id_asal, 5, 2) = wk.id AND SUBSTRING(k.id_asal, 1, 2) = wk.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wk.id_dati2
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTRING(k.id_asal, 3, 2) = wkb.id AND SUBSTRING(k.id_asal, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTRING(k.id_asal, 1, 2) = wp.id
                                    ) t            
                                    WHERE
                                        t.status_data = 1 AND t.id_ktp IN($data_check)
                                    ORDER BY
                                        t.id_ktp ASC");
        }
        return $sql->result();
    }

    //---------------------------------------CETAK KTA ID---------------------------------------//

    public function cetak_kta_id($id = '', $id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            k.id_ktp,
                                            k.id_petugas,                                            
                                            k.img_pas,
                                            k.img_pas_thumb,
                                            k.jenis_kelamin,
                                            k.barcode,
                                            k.nik_kta_baru,
                                            k.id_asal,
                                            k.status_data,
                                            k.id_admin,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            wk.nama AS kecamatan,
                                            wd.nama AS kelurahan,
                                            k.nik_ktp,
                                            k.nama_ktp,
                                            k.tempat_lahir,
                                            k.tanggal_lahir,
                                            k.rt,
                                            k.rw,
                                            k.alamat_ktp,
                                            k.pekerjaan,
                                            k.img_thumb
                                        FROM
                                            ktp k
                                        LEFT JOIN petugas p ON
                                            k.id_petugas = p.id_petugas
                                        LEFT JOIN wilayah_desa wd ON
                                            SUBSTRING(k.id_asal, 7, 2) = wd.id AND SUBSTRING(k.id_asal, 1, 2) = wd.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wd.id_dati2 AND SUBSTRING(k.id_asal, 5, 2) = wd.id_dati3
                                        LEFT JOIN wilayah_kecamatan wk ON
                                            SUBSTRING(k.id_asal, 5, 2) = wk.id AND SUBSTRING(k.id_asal, 1, 2) = wk.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wk.id_dati2
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTRING(k.id_asal, 3, 2) = wkb.id AND SUBSTRING(k.id_asal, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTRING(k.id_asal, 1, 2) = wp.id
                                    ) t
                                    WHERE
                                        t.id_ktp='$id' AND t.id_admin='$id_admin' AND t.status_data = 1
                                    ORDER BY
                                        t.id_ktp ASC");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            k.id_ktp,
                                            k.id_petugas,                                            
                                            k.img_pas,
                                            k.img_pas_thumb,
                                            k.jenis_kelamin,
                                            k.barcode,
                                            k.nik_kta_baru,
                                            k.id_asal,
                                            k.status_data,
                                            k.id_admin,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            wk.nama AS kecamatan,
                                            wd.nama AS kelurahan,
                                            k.nik_ktp,
                                            k.nama_ktp,
                                            k.tempat_lahir,
                                            k.tanggal_lahir,
                                            k.rt,
                                            k.rw,
                                            k.alamat_ktp,
                                            k.pekerjaan,
                                            k.img_thumb
                                        FROM
                                            ktp k
                                        LEFT JOIN petugas p ON
                                            k.id_petugas = p.id_petugas
                                        LEFT JOIN wilayah_desa wd ON
                                            SUBSTRING(k.id_asal, 7, 2) = wd.id AND SUBSTRING(k.id_asal, 1, 2) = wd.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wd.id_dati2 AND SUBSTRING(k.id_asal, 5, 2) = wd.id_dati3
                                        LEFT JOIN wilayah_kecamatan wk ON
                                            SUBSTRING(k.id_asal, 5, 2) = wk.id AND SUBSTRING(k.id_asal, 1, 2) = wk.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wk.id_dati2
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTRING(k.id_asal, 3, 2) = wkb.id AND SUBSTRING(k.id_asal, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTRING(k.id_asal, 1, 2) = wp.id
                                    ) t
                                    WHERE
                                        t.id_ktp='$id' AND t.id_admin LIKE '$id_admin%' AND t.status_data = 1
                                    ORDER BY
                                        t.id_ktp ASC");
        } elseif ($role == 0) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            k.id_ktp,
                                            k.id_petugas,                                            
                                            k.img_pas,
                                            k.img_pas_thumb,
                                            k.jenis_kelamin,
                                            k.barcode,
                                            k.nik_kta_baru,
                                            k.id_asal,
                                            k.status_data,
                                            k.id_admin,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            wk.nama AS kecamatan,
                                            wd.nama AS kelurahan,
                                            k.nik_ktp,
                                            k.nama_ktp,
                                            k.tempat_lahir,
                                            k.tanggal_lahir,
                                            k.rt,
                                            k.rw,
                                            k.alamat_ktp,
                                            k.pekerjaan,
                                            k.img_thumb
                                        FROM
                                            ktp k
                                        LEFT JOIN petugas p ON
                                            k.id_petugas = p.id_petugas
                                        LEFT JOIN wilayah_desa wd ON
                                            SUBSTRING(k.id_asal, 7, 2) = wd.id AND SUBSTRING(k.id_asal, 1, 2) = wd.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wd.id_dati2 AND SUBSTRING(k.id_asal, 5, 2) = wd.id_dati3
                                        LEFT JOIN wilayah_kecamatan wk ON
                                            SUBSTRING(k.id_asal, 5, 2) = wk.id AND SUBSTRING(k.id_asal, 1, 2) = wk.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wk.id_dati2
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTRING(k.id_asal, 3, 2) = wkb.id AND SUBSTRING(k.id_asal, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTRING(k.id_asal, 1, 2) = wp.id
                                    ) t
                                    WHERE
                                        t.id_ktp='$id'
                                    ORDER BY
                                        t.id_ktp ASC");
        }

        return $sql->result();
    }

    //---------------------------------------CETAK KARTU MANDAT ID---------------------------------------//

    public function cetak_kartu_mandat_id($id_saksi = '', $id_pemilihan = '') {

        $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            s.id_saksi,
                                            s.id_anggota,
                                            s.id_pemilihan,
                                            s.id_admin,
                                            s.id_tps,
                                            s.id_asal_saksi,
                                            s.nomor_ktp_saksi,
                                            s.email_saksi,
                                            s.password_saksi,
                                            s.nama_saksi,
                                            s.nomor_hp_saksi,
                                            s.tempat_lahir,
                                            s.tanggal_lahir,
                                            s.alamat_saksi,
                                            s.rt,
                                            s.rw,
                                            s.kodepos,
                                            s.jenis_kelamin,
                                            s.img_pas,
                                            s.barcode,
                                            s.status_data,
                                            p.nama_pemilihan,
                                            p.tahun_pemilihan,
                                            p.nama_calon,
                                            p.nama_wakil_calon,
                                            p.id_kategori_pemilihan,
                                            tp.nama_tps,
                                            tp.nomor_tps,
                                            tp.id_wilayah_pemilihan,
                                            wd.nama AS nama_kelurahan
                                        FROM
                                            saksi s
                                        LEFT JOIN pemilihan p ON
                                            s.id_pemilihan = p.id_pemilihan
                                        LEFT JOIN tps tp ON
                                            tp.id_tps = s.id_tps
                                        LEFT JOIN wilayah_desa wd ON
                                            SUBSTRING(tp.id_wilayah_pemilihan, 7, 2) = wd.id AND SUBSTRING(tp.id_wilayah_pemilihan, 1, 2) = wd.id_dati1 AND SUBSTRING(tp.id_wilayah_pemilihan, 3, 2) = wd.id_dati2 AND SUBSTRING(tp.id_wilayah_pemilihan, 5, 2) = wd.id_dati3
                                    ) t
                                    WHERE
                                        t.id_saksi = '$id_saksi' AND t.id_pemilihan = '$id_pemilihan' AND t.status_data=1");
        return $sql->result();
    }

    //---------------------------------------CETAK KTA ALL---------------------------------------//

    public function cetak_kta_all($id_admin = '', $role = '', $data_check = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            k.id_ktp,
                                            k.id_asal,
                                            k.img_pas,
                                            k.barcode,
                                            k.id_petugas,                                            
                                            k.status_data,
                                            k.id_admin,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            wk.nama AS kecamatan,
                                            wd.nama AS kelurahan,
                                            k.nik_ktp,
                                            k.nama_ktp,
                                            k.tempat_lahir,
                                            k.tanggal_lahir,
                                            k.rt,
                                            k.rw,
                                            k.jenis_kelamin,
                                            k.alamat_ktp,
                                            k.pekerjaan,
                                            k.img_thumb
                                        FROM
                                            ktp k
                                        LEFT JOIN petugas p ON
                                            k.id_petugas = p.id_petugas
                                        LEFT JOIN wilayah_desa wd ON
                                            SUBSTRING(k.id_asal, 7, 2) = wd.id AND SUBSTRING(k.id_asal, 1, 2) = wd.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wd.id_dati2 AND SUBSTRING(k.id_asal, 5, 2) = wd.id_dati3
                                        LEFT JOIN wilayah_kecamatan wk ON
                                            SUBSTRING(k.id_asal, 5, 2) = wk.id AND SUBSTRING(k.id_asal, 1, 2) = wk.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wk.id_dati2
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTRING(k.id_asal, 3, 2) = wkb.id AND SUBSTRING(k.id_asal, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTRING(k.id_asal, 1, 2) = wp.id
                                    ) t
                                    WHERE
                                        t.id_admin = '$id_admin' AND t.id_ktp IN($data_check) AND t.status_data = 1 
                                    ORDER BY
                                        t.id_ktp ASC");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            k.id_ktp,
                                            k.id_petugas,
                                            k.id_asal,
                                            k.img_pas,
                                            k.barcode,                                           
                                            k.status_data,
                                            k.id_admin,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            wk.nama AS kecamatan,
                                            wd.nama AS kelurahan,
                                            k.nik_ktp,
                                            k.nama_ktp,
                                            k.tempat_lahir,
                                            k.tanggal_lahir,
                                            k.rt,
                                            k.rw,
                                            k.jenis_kelamin,
                                            k.alamat_ktp,
                                            k.pekerjaan,
                                            k.img_thumb
                                        FROM
                                            ktp k
                                        LEFT JOIN petugas p ON
                                            k.id_petugas = p.id_petugas
                                        LEFT JOIN wilayah_desa wd ON
                                            SUBSTRING(k.id_asal, 7, 2) = wd.id AND SUBSTRING(k.id_asal, 1, 2) = wd.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wd.id_dati2 AND SUBSTRING(k.id_asal, 5, 2) = wd.id_dati3
                                        LEFT JOIN wilayah_kecamatan wk ON
                                            SUBSTRING(k.id_asal, 5, 2) = wk.id AND SUBSTRING(k.id_asal, 1, 2) = wk.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wk.id_dati2
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTRING(k.id_asal, 3, 2) = wkb.id AND SUBSTRING(k.id_asal, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTRING(k.id_asal, 1, 2) = wp.id
                                    ) t
                                    WHERE
                                        t.id_admin LIKE '$id_admin%' AND t.id_ktp IN($data_check) AND t.status_data = 1
                                    ORDER BY
                                        t.id_ktp ASC");
        } elseif ($role == 0) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            k.id_ktp,
                                            k.id_petugas,
                                            k.id_asal,
                                            k.img_pas,
                                            k.barcode,                                           
                                            k.status_data,
                                            k.id_admin,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            wk.nama AS kecamatan,
                                            wd.nama AS kelurahan,
                                            k.nik_ktp,
                                            k.nama_ktp,
                                            k.tempat_lahir,
                                            k.tanggal_lahir,
                                            k.rt,
                                            k.rw,
                                            k.jenis_kelamin,
                                            k.alamat_ktp,
                                            k.pekerjaan,
                                            k.img_thumb
                                        FROM
                                            ktp k
                                        LEFT JOIN petugas p ON
                                            k.id_petugas = p.id_petugas
                                        LEFT JOIN wilayah_desa wd ON
                                            SUBSTRING(k.id_asal, 7, 2) = wd.id AND SUBSTRING(k.id_asal, 1, 2) = wd.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wd.id_dati2 AND SUBSTRING(k.id_asal, 5, 2) = wd.id_dati3
                                        LEFT JOIN wilayah_kecamatan wk ON
                                            SUBSTRING(k.id_asal, 5, 2) = wk.id AND SUBSTRING(k.id_asal, 1, 2) = wk.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wk.id_dati2
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTRING(k.id_asal, 3, 2) = wkb.id AND SUBSTRING(k.id_asal, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTRING(k.id_asal, 1, 2) = wp.id
                                    ) t      
                                    WHERE
                                        t.id_ktp IN($data_check) AND t.status_data = 1
                                    ORDER BY
                                        t.id_ktp ASC");
        }

        return $sql->result();
    }

    //---------------------------------------CETAK KTA REG ADMIN---------------------------------------//

    public function cetak_kta_admin($id = '', $id_admin = '', $role = '', $data_check = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            k.id_ktp,
                                            k.id_asal,
                                            k.img_pas,
                                            k.barcode,
                                            k.id_petugas,                                           
                                            k.status_data,
                                            k.id_admin,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            wk.nama AS kecamatan,
                                            wd.nama AS kelurahan,
                                            k.nik_ktp,
                                            k.nama_ktp,
                                            k.tempat_lahir,
                                            k.tanggal_lahir,
                                            k.rt,
                                            k.rw,
                                            k.jenis_kelamin,
                                            k.alamat_ktp,
                                            k.pekerjaan,
                                            k.img_thumb
                                        FROM
                                            ktp k
                                        LEFT JOIN petugas p ON
                                            k.id_petugas = p.id_petugas
                                        LEFT JOIN wilayah_desa wd ON
                                            SUBSTRING(k.id_asal, 7, 2) = wd.id AND SUBSTRING(k.id_asal, 1, 2) = wd.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wd.id_dati2 AND SUBSTRING(k.id_asal, 5, 2) = wd.id_dati3
                                        LEFT JOIN wilayah_kecamatan wk ON
                                            SUBSTRING(k.id_asal, 5, 2) = wk.id AND SUBSTRING(k.id_asal, 1, 2) = wk.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wk.id_dati2
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTRING(k.id_asal, 3, 2) = wkb.id AND SUBSTRING(k.id_asal, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTRING(k.id_asal, 1, 2) = wp.id
                                    ) t
                                    WHERE
                                        t.id_admin = '$id' AND t.id_ktp IN($data_check) AND t.status_data = 1
                                    ORDER BY
                                        t.id_ktp ASC");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            k.id_ktp,
                                            k.id_petugas,
                                            k.id_asal,
                                            k.img_pas,
                                            k.barcode,                                           
                                            k.status_data,
                                            k.id_admin,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            wk.nama AS kecamatan,
                                            wd.nama AS kelurahan,
                                            k.nik_ktp,
                                            k.nama_ktp,
                                            k.tempat_lahir,
                                            k.tanggal_lahir,
                                            k.rt,
                                            k.rw,
                                            k.jenis_kelamin,
                                            k.alamat_ktp,
                                            k.pekerjaan,
                                            k.img_thumb
                                        FROM
                                            ktp k
                                        LEFT JOIN petugas p ON
                                            k.id_petugas = p.id_petugas
                                        LEFT JOIN wilayah_desa wd ON
                                            SUBSTRING(k.id_asal, 7, 2) = wd.id AND SUBSTRING(k.id_asal, 1, 2) = wd.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wd.id_dati2 AND SUBSTRING(k.id_asal, 5, 2) = wd.id_dati3
                                        LEFT JOIN wilayah_kecamatan wk ON
                                            SUBSTRING(k.id_asal, 5, 2) = wk.id AND SUBSTRING(k.id_asal, 1, 2) = wk.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wk.id_dati2
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTRING(k.id_asal, 3, 2) = wkb.id AND SUBSTRING(k.id_asal, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTRING(k.id_asal, 1, 2) = wp.id
                                    ) t
                                    WHERE
                                        t.id_admin = '$id' AND t.id_ktp IN($data_check) AND t.status_data = 1
                                    ORDER BY
                                        t.id_ktp ASC");
        } elseif ($role == 0) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            k.id_ktp,
                                            k.id_petugas,
                                            k.id_asal,
                                            k.img_pas,
                                            k.barcode,                                            
                                            k.status_data,
                                            k.id_admin,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            wk.nama AS kecamatan,
                                            wd.nama AS kelurahan,
                                            k.nik_ktp,
                                            k.nama_ktp,
                                            k.tempat_lahir,
                                            k.tanggal_lahir,
                                            k.rt,
                                            k.rw,
                                            k.jenis_kelamin,
                                            k.alamat_ktp,
                                            k.pekerjaan,
                                            k.img_thumb
                                        FROM
                                            ktp k
                                        LEFT JOIN petugas p ON
                                            k.id_petugas = p.id_petugas
                                        LEFT JOIN wilayah_desa wd ON
                                            SUBSTRING(k.id_asal, 7, 2) = wd.id AND SUBSTRING(k.id_asal, 1, 2) = wd.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wd.id_dati2 AND SUBSTRING(k.id_asal, 5, 2) = wd.id_dati3
                                        LEFT JOIN wilayah_kecamatan wk ON
                                            SUBSTRING(k.id_asal, 5, 2) = wk.id AND SUBSTRING(k.id_asal, 1, 2) = wk.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wk.id_dati2
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTRING(k.id_asal, 3, 2) = wkb.id AND SUBSTRING(k.id_asal, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTRING(k.id_asal, 1, 2) = wp.id
                                    ) t           
                                    WHERE
                                        t.id_admin = '$id' AND t.id_ktp IN($data_check) AND t.status_data = 1
                                    ORDER BY
                                        t.id_ktp ASC");
        }

        return $sql->result();
    }

    //---------------------------------------CETAK KTA PET---------------------------------------//

    public function cetak_kta_pet($id = '', $id_admin = '', $role = '', $data_check = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            k.id_ktp,
                                            k.id_asal,
                                            k.img_pas,
                                            k.barcode,
                                            k.id_petugas,                                           
                                            k.status_data,
                                            k.id_admin,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            wk.nama AS kecamatan,
                                            wd.nama AS kelurahan,
                                            k.nik_ktp,
                                            k.nama_ktp,
                                            k.tempat_lahir,
                                            k.tanggal_lahir,
                                            k.rt,
                                            k.rw,
                                            k.jenis_kelamin,
                                            k.alamat_ktp,
                                            k.pekerjaan,
                                            k.img_thumb
                                        FROM
                                            ktp k
                                        LEFT JOIN petugas p ON
                                            k.id_petugas = p.id_petugas
                                        LEFT JOIN wilayah_desa wd ON
                                            SUBSTRING(k.id_asal, 7, 2) = wd.id AND SUBSTRING(k.id_asal, 1, 2) = wd.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wd.id_dati2 AND SUBSTRING(k.id_asal, 5, 2) = wd.id_dati3
                                        LEFT JOIN wilayah_kecamatan wk ON
                                            SUBSTRING(k.id_asal, 5, 2) = wk.id AND SUBSTRING(k.id_asal, 1, 2) = wk.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wk.id_dati2
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTRING(k.id_asal, 3, 2) = wkb.id AND SUBSTRING(k.id_asal, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTRING(k.id_asal, 1, 2) = wp.id
                                    ) t
                                    WHERE
                                        t.id_petugas = '$id' AND t.status_data = 1  AND t.id_ktp IN($data_check)
                                    ORDER BY
                                        t.id_ktp ASC");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            k.id_ktp,
                                            k.id_petugas,
                                            k.id_asal,
                                            k.img_pas,
                                            k.barcode,                                           
                                            k.status_data,
                                            k.id_admin,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            wk.nama AS kecamatan,
                                            wd.nama AS kelurahan,
                                            k.nik_ktp,
                                            k.nama_ktp,
                                            k.tempat_lahir,
                                            k.tanggal_lahir,
                                            k.rt,
                                            k.rw,
                                            k.jenis_kelamin,
                                            k.alamat_ktp,
                                            k.pekerjaan,
                                            k.img_thumb
                                        FROM
                                            ktp k
                                        LEFT JOIN petugas p ON
                                            k.id_petugas = p.id_petugas
                                        LEFT JOIN wilayah_desa wd ON
                                            SUBSTRING(k.id_asal, 7, 2) = wd.id AND SUBSTRING(k.id_asal, 1, 2) = wd.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wd.id_dati2 AND SUBSTRING(k.id_asal, 5, 2) = wd.id_dati3
                                        LEFT JOIN wilayah_kecamatan wk ON
                                            SUBSTRING(k.id_asal, 5, 2) = wk.id AND SUBSTRING(k.id_asal, 1, 2) = wk.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wk.id_dati2
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTRING(k.id_asal, 3, 2) = wkb.id AND SUBSTRING(k.id_asal, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTRING(k.id_asal, 1, 2) = wp.id
                                    ) t
                                    WHERE
                                        t.id_petugas = '$id' AND t.status_data = 1 AND t.id_ktp IN($data_check)
                                    ORDER BY
                                        t.id_ktp ASC");
        } elseif ($role == 0) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            k.id_ktp,
                                            k.id_petugas,
                                            k.id_asal,
                                            k.img_pas,
                                            k.barcode,                                           
                                            k.status_data,
                                            k.id_admin,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            wk.nama AS kecamatan,
                                            wd.nama AS kelurahan,
                                            k.nik_ktp,
                                            k.nama_ktp,
                                            k.tempat_lahir,
                                            k.tanggal_lahir,
                                            k.rt,
                                            k.rw,
                                            k.jenis_kelamin,
                                            k.alamat_ktp,
                                            k.pekerjaan,
                                            k.img_thumb
                                        FROM
                                            ktp k
                                        LEFT JOIN petugas p ON
                                            k.id_petugas = p.id_petugas
                                        LEFT JOIN wilayah_desa wd ON
                                            SUBSTRING(k.id_asal, 7, 2) = wd.id AND SUBSTRING(k.id_asal, 1, 2) = wd.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wd.id_dati2 AND SUBSTRING(k.id_asal, 5, 2) = wd.id_dati3
                                        LEFT JOIN wilayah_kecamatan wk ON
                                            SUBSTRING(k.id_asal, 5, 2) = wk.id AND SUBSTRING(k.id_asal, 1, 2) = wk.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wk.id_dati2
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTRING(k.id_asal, 3, 2) = wkb.id AND SUBSTRING(k.id_asal, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTRING(k.id_asal, 1, 2) = wp.id
                                    ) t           
                                    WHERE
                                        t.id_petugas = '$id' AND t.id_ktp IN($data_check) AND t.status_data = 1
                                    ORDER BY
                                        t.id_ktp ASC");
        }

        return $sql->result();
    }

    //---------------------------------------CETAK FOTO PETUGAS ALL---------------------------------------//

    public function get_by_id_admin_pet($id_petugas = '') {

        $sql = $this->db->query("SELECT
                                    p.id_admin,
                                    u.id_ref,
                                    u.role_admin
                                FROM
                                    petugas p
                                JOIN user u ON
                                    p.id_admin = u.id_ref AND p.id_petugas = '$id_petugas'");
        return $sql->result();
    }

    public function cetak_pet_ktp($id = '', $id_admin = '', $role = '', $data_check = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                             k.id_ktp,
                                            k.id_asal,
                                            k.img_pas,
                                            k.barcode,
                                            k.id_petugas,                                            
                                            k.status_data,
                                            k.id_admin,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            wk.nama AS kecamatan,
                                            wd.nama AS kelurahan,
                                            k.nik_ktp,
                                            k.nama_ktp,
                                            k.tempat_lahir,
                                            k.tanggal_lahir,
                                            k.rt,
                                            k.rw,
                                            k.jenis_kelamin,
                                            k.alamat_ktp,
                                            k.pekerjaan,
                                            k.img_thumb
                                        FROM
                                            ktp k                                        
                                        LEFT JOIN petugas p ON
                                            k.id_petugas = p.id_petugas
                                        LEFT JOIN wilayah_desa wd ON
                                            SUBSTRING(k.id_admin, 7, 2) = wd.id AND SUBSTRING(k.id_admin, 1, 2) = wd.id_dati1 AND SUBSTRING(k.id_admin, 3, 2) = wd.id_dati2 AND SUBSTRING(k.id_admin, 5, 2) = wd.id_dati3
                                        LEFT JOIN wilayah_kecamatan wk ON
                                            SUBSTRING(k.id_admin, 5, 2) = wk.id AND SUBSTRING(k.id_admin, 1, 2) = wk.id_dati1 AND SUBSTRING(k.id_admin, 3, 2) = wk.id_dati2
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTRING(k.id_admin, 3, 2) = wkb.id AND SUBSTRING(k.id_admin, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTRING(k.id_admin, 1, 2) = wp.id
                                    ) t
                                    WHERE
                                        t.id_petugas = '$id' AND t.id_admin = '$id_admin' AND t.id_ktp IN($data_check) AND t.status_data = 1
                                    ORDER BY
                                        t.nama_ktp ASC");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                              k.id_ktp,
                                            k.id_asal,
                                            k.img_pas,
                                            k.barcode,
                                            k.id_petugas,                                            
                                            k.status_data,
                                            k.id_admin,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            wk.nama AS kecamatan,
                                            wd.nama AS kelurahan,
                                            k.nik_ktp,
                                            k.nama_ktp,
                                            k.tempat_lahir,
                                            k.tanggal_lahir,
                                            k.rt,
                                            k.rw,
                                            k.jenis_kelamin,
                                            k.alamat_ktp,
                                            k.pekerjaan,
                                            k.img_thumb
                                        FROM
                                            ktp k                                        
                                        LEFT JOIN petugas p ON
                                            k.id_petugas = p.id_petugas
                                        LEFT JOIN wilayah_desa wd ON
                                            SUBSTRING(k.id_admin, 7, 2) = wd.id AND SUBSTRING(k.id_admin, 1, 2) = wd.id_dati1 AND SUBSTRING(k.id_admin, 3, 2) = wd.id_dati2 AND SUBSTRING(k.id_admin, 5, 2) = wd.id_dati3
                                        LEFT JOIN wilayah_kecamatan wk ON
                                            SUBSTRING(k.id_admin, 5, 2) = wk.id AND SUBSTRING(k.id_admin, 1, 2) = wk.id_dati1 AND SUBSTRING(k.id_admin, 3, 2) = wk.id_dati2
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTRING(k.id_admin, 3, 2) = wkb.id AND SUBSTRING(k.id_admin, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTRING(k.id_admin, 1, 2) = wp.id
                                    ) t
                                    WHERE
                                        t.id_petugas = '$id' AND t.id_admin LIKE '$id_admin%' AND t.id_ktp IN($data_check) AND t.status_data = 1
                                    ORDER BY
                                        t.nama_ktp ASC");
        } elseif ($role == 0) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                             k.id_ktp,
                                            k.id_asal,
                                            k.img_pas,
                                            k.barcode,
                                            k.id_petugas,                                            
                                            k.status_data,
                                            k.id_admin,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            wk.nama AS kecamatan,
                                            wd.nama AS kelurahan,
                                            k.nik_ktp,
                                            k.nama_ktp,
                                            k.tempat_lahir,
                                            k.tanggal_lahir,
                                            k.rt,
                                            k.rw,
                                            k.jenis_kelamin,
                                            k.alamat_ktp,
                                            k.pekerjaan,
                                            k.img_thumb
                                        FROM
                                            ktp k                                        
                                        LEFT JOIN petugas p ON
                                            k.id_petugas = p.id_petugas
                                        LEFT JOIN wilayah_desa wd ON
                                            SUBSTRING(k.id_admin, 7, 2) = wd.id AND SUBSTRING(k.id_admin, 1, 2) = wd.id_dati1 AND SUBSTRING(k.id_admin, 3, 2) = wd.id_dati2 AND SUBSTRING(k.id_admin, 5, 2) = wd.id_dati3
                                        LEFT JOIN wilayah_kecamatan wk ON
                                            SUBSTRING(k.id_admin, 5, 2) = wk.id AND SUBSTRING(k.id_admin, 1, 2) = wk.id_dati1 AND SUBSTRING(k.id_admin, 3, 2) = wk.id_dati2
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTRING(k.id_admin, 3, 2) = wkb.id AND SUBSTRING(k.id_admin, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTRING(k.id_admin, 1, 2) = wp.id
                                    ) t
                                    WHERE
                                        t.id_petugas = '$id' AND t.id_ktp IN($data_check) AND t.status_data = 1
                                    ORDER BY
                                        t.nama_ktp ASC");
        }
        return $sql->result();
    }

    public function get_petugas($id = '', $id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        *
                                    FROM
                                        petugas
                                    WHERE
                                        id_petugas = '$id' AND id_admin = '$id_admin' AND status_data = 1");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT
                                        *
                                    FROM
                                        petugas
                                    WHERE
                                        id_petugas = '$id' AND id_admin LIKE '$id_admin%' AND status_data = 1");
        } elseif ($role == 0) {

            $sql = $this->db->query("SELECT
                                        *
                                    FROM
                                        petugas
                                    WHERE
                                        id_petugas = '$id'");
        }

        return $sql->result();
    }

    //---------------------------------------CETAK FOTO PETUGAS REG---------------------------------------//

    public function cetak_reg_ktp($id = '', $id_admin = '', $role = '', $data_check = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            k.id_ktp,
                                            k.id_asal,
                                            k.img_pas,
                                            k.barcode,
                                            k.id_petugas,                                            
                                            k.status_data,
                                            k.id_admin,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            wk.nama AS kecamatan,
                                            wd.nama AS kelurahan,
                                            k.nik_ktp,
                                            k.nama_ktp,
                                            k.tempat_lahir,
                                            k.tanggal_lahir,
                                            k.rt,
                                            k.rw,
                                            k.jenis_kelamin,
                                            k.alamat_ktp,
                                            k.pekerjaan,
                                            k.img_thumb
                                        FROM
                                            ktp k
                                        LEFT JOIN petugas p ON
                                            k.id_petugas = p.id_petugas
                                        LEFT JOIN wilayah_desa wd ON
                                            SUBSTRING(k.id_admin, 7, 2) = wd.id AND SUBSTRING(k.id_admin, 1, 2) = wd.id_dati1 AND SUBSTRING(k.id_admin, 3, 2) = wd.id_dati2 AND SUBSTRING(k.id_admin, 5, 2) = wd.id_dati3
                                        LEFT JOIN wilayah_kecamatan wk ON
                                            SUBSTRING(k.id_admin, 5, 2) = wk.id AND SUBSTRING(k.id_admin, 1, 2) = wk.id_dati1 AND SUBSTRING(k.id_admin, 3, 2) = wk.id_dati2
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTRING(k.id_admin, 3, 2) = wkb.id AND SUBSTRING(k.id_admin, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTRING(k.id_admin, 1, 2) = wp.id
                                    ) t
                                    WHERE
                                        t.id_admin = '$id' AND t.id_admin = '$id_admin' AND t.id_ktp IN($data_check) AND t.status_data = 1
                                    ORDER BY
                                        t.nama_ktp ASC");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            k.id_ktp,
                                            k.id_asal,
                                            k.img_pas,
                                            k.barcode,
                                            k.id_petugas,                                            
                                            k.status_data,
                                            k.id_admin,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            wk.nama AS kecamatan,
                                            wd.nama AS kelurahan,
                                            k.nik_ktp,
                                            k.nama_ktp,
                                            k.tempat_lahir,
                                            k.tanggal_lahir,
                                            k.rt,
                                            k.rw,
                                            k.jenis_kelamin,
                                            k.alamat_ktp,
                                            k.pekerjaan,
                                            k.img_thumb
                                        FROM
                                            ktp k
                                        LEFT JOIN petugas p ON
                                            k.id_petugas = p.id_petugas
                                        LEFT JOIN wilayah_desa wd ON
                                            SUBSTRING(k.id_admin, 7, 2) = wd.id AND SUBSTRING(k.id_admin, 1, 2) = wd.id_dati1 AND SUBSTRING(k.id_admin, 3, 2) = wd.id_dati2 AND SUBSTRING(k.id_admin, 5, 2) = wd.id_dati3
                                        LEFT JOIN wilayah_kecamatan wk ON
                                            SUBSTRING(k.id_admin, 5, 2) = wk.id AND SUBSTRING(k.id_admin, 1, 2) = wk.id_dati1 AND SUBSTRING(k.id_admin, 3, 2) = wk.id_dati2
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTRING(k.id_admin, 3, 2) = wkb.id AND SUBSTRING(k.id_admin, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTRING(k.id_admin, 1, 2) = wp.id
                                    ) t
                                    WHERE
                                        t.id_admin = '$id' AND t.id_admin LIKE '$id_admin%' AND t.id_ktp IN($data_check) AND t.status_data = 1
                                    ORDER BY
                                        t.nama_ktp ASC");
        } elseif ($role == 0) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            k.id_ktp,
                                            k.id_asal,
                                            k.img_pas,
                                            k.barcode,
                                            k.id_petugas,                                            
                                            k.status_data,
                                            k.id_admin,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            wk.nama AS kecamatan,
                                            wd.nama AS kelurahan,
                                            k.nik_ktp,
                                            k.nama_ktp,
                                            k.tempat_lahir,
                                            k.tanggal_lahir,
                                            k.rt,
                                            k.rw,
                                            k.jenis_kelamin,
                                            k.alamat_ktp,
                                            k.pekerjaan,
                                            k.img_thumb
                                        FROM
                                            ktp k
                                        LEFT JOIN petugas p ON
                                            k.id_petugas = p.id_petugas
                                        LEFT JOIN wilayah_desa wd ON
                                            SUBSTRING(k.id_admin, 7, 2) = wd.id AND SUBSTRING(k.id_admin, 1, 2) = wd.id_dati1 AND SUBSTRING(k.id_admin, 3, 2) = wd.id_dati2 AND SUBSTRING(k.id_admin, 5, 2) = wd.id_dati3
                                        LEFT JOIN wilayah_kecamatan wk ON
                                            SUBSTRING(k.id_admin, 5, 2) = wk.id AND SUBSTRING(k.id_admin, 1, 2) = wk.id_dati1 AND SUBSTRING(k.id_admin, 3, 2) = wk.id_dati2
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTRING(k.id_admin, 3, 2) = wkb.id AND SUBSTRING(k.id_admin, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTRING(k.id_admin, 1, 2) = wp.id
                                    ) t
                                    WHERE
                                        t.id_admin = '$id' AND t.id_ktp IN($data_check) AND t.status_data = 1
                                    ORDER BY
                                        t.nama_ktp ASC");
        }
        return $sql->result();
    }

    public function get_regional_admin($id = '', $id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        u.nama_admin,
                                        u.id_ref,
                                        wd.nama AS kelurahan,
                                        wp.nama AS provinsi,
                                        wkb.nama AS kabupaten,
                                        wk.nama AS kecamatan
                                    FROM
                                        user u
                                    LEFT JOIN wilayah_desa wd ON
                                        SUBSTRING(u.id_ref, 7, 2) = wd.id AND SUBSTRING(u.id_ref, 1, 2) = wd.id_dati1 AND SUBSTRING(u.id_ref, 3, 2) = wd.id_dati2 AND SUBSTRING(u.id_ref, 5, 2) = wd.id_dati3
                                    LEFT JOIN wilayah_kecamatan wk ON
                                        SUBSTRING(u.id_ref, 5, 2) = wk.id AND SUBSTRING(u.id_ref, 1, 2) = wk.id_dati1 AND SUBSTRING(u.id_ref, 3, 2) = wk.id_dati2
                                    LEFT JOIN wilayah_kabupaten wkb ON
                                        SUBSTRING(u.id_ref, 3, 2) = wkb.id AND SUBSTRING(u.id_ref, 1, 2) = wkb.id_dati1
                                    LEFT JOIN wilayah_provinsi wp ON
                                        SUBSTRING(u.id_ref, 1, 2) = wp.id
                                    WHERE
                                        u.id_ref = '$id'");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT
                                        u.nama_admin,
                                        u.id_ref,
                                        wd.nama AS kelurahan,
                                        wp.nama AS provinsi,
                                        wkb.nama AS kabupaten,
                                        wk.nama AS kecamatan
                                    FROM
                                        user u
                                    LEFT JOIN wilayah_desa wd ON
                                        SUBSTRING(u.id_ref, 7, 2) = wd.id AND SUBSTRING(u.id_ref, 1, 2) = wd.id_dati1 AND SUBSTRING(u.id_ref, 3, 2) = wd.id_dati2 AND SUBSTRING(u.id_ref, 5, 2) = wd.id_dati3
                                    LEFT JOIN wilayah_kecamatan wk ON
                                        SUBSTRING(u.id_ref, 5, 2) = wk.id AND SUBSTRING(u.id_ref, 1, 2) = wk.id_dati1 AND SUBSTRING(u.id_ref, 3, 2) = wk.id_dati2
                                    LEFT JOIN wilayah_kabupaten wkb ON
                                        SUBSTRING(u.id_ref, 3, 2) = wkb.id AND SUBSTRING(u.id_ref, 1, 2) = wkb.id_dati1
                                    LEFT JOIN wilayah_provinsi wp ON
                                        SUBSTRING(u.id_ref, 1, 2) = wp.id
                                    WHERE
                                        u.id_ref = '$id'");
        } elseif ($role == 0) {

            $sql = $this->db->query("SELECT
                                        u.nama_admin,
                                        u.id_ref,
                                        wd.nama AS kelurahan,
                                        wp.nama AS provinsi,
                                        wkb.nama AS kabupaten,
                                        wk.nama AS kecamatan
                                    FROM
                                        user u
                                    LEFT JOIN wilayah_desa wd ON
                                        SUBSTRING(u.id_ref, 7, 2) = wd.id AND SUBSTRING(u.id_ref, 1, 2) = wd.id_dati1 AND SUBSTRING(u.id_ref, 3, 2) = wd.id_dati2 AND SUBSTRING(u.id_ref, 5, 2) = wd.id_dati3
                                    LEFT JOIN wilayah_kecamatan wk ON
                                        SUBSTRING(u.id_ref, 5, 2) = wk.id AND SUBSTRING(u.id_ref, 1, 2) = wk.id_dati1 AND SUBSTRING(u.id_ref, 3, 2) = wk.id_dati2
                                    LEFT JOIN wilayah_kabupaten wkb ON
                                        SUBSTRING(u.id_ref, 3, 2) = wkb.id AND SUBSTRING(u.id_ref, 1, 2) = wkb.id_dati1
                                    LEFT JOIN wilayah_provinsi wp ON
                                        SUBSTRING(u.id_ref, 1, 2) = wp.id
                                    WHERE
                                        u.id_ref = '$id'");
        }

        return $sql->result();
    }

    //---------------------------------------UPDATE INSERT LAPORAN---------------------------------------//

    public function get_id_by_laporan($id_admin = '') {

        $this->db->where('id_admin', $id_admin);

        $sql = $this->db->get($this->table_laporan);
        return $sql->result();
    }

    public function update_laporan($value = '', $id_admin = '', $role = '') {
        $this->db->trans_begin();

        $data = array(
            'jenis_laporan' => $value['jenis_laporan'],
            'header_laporan' => $value['header_laporan'],
            'img' => $value['pic'],
            'img_thumb' => $value['pic_thumb']
        );


        $this->db->where('id_admin', $id_admin);
        $this->db->update($this->table_laporan, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function insert_laporan($value = '', $id_admin = '', $role = '') {
        $this->db->trans_begin();

        $data = array(
            'jenis_laporan' => $value['jenis_laporan'],
            'id_admin' => $id_admin,
            'header_laporan' => $value['header_laporan'],
            'img' => $value['pic'],
            'img_thumb' => $value['pic_thumb']
        );

        $this->db->insert($this->table_laporan, $data);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //---------------------------------------GET WILAYAH LAPORAN---------------------------------------//

    public function get_provinsi() {
        $sql = $this->db->query('SELECT * FROM wilayah_provinsi');
        return $sql->result();
    }

    public function get_kabupaten() {
        $sql = $this->db->query('SELECT * FROM wilayah_kabupaten');
        return $sql->result();
    }

    public function get_kecamatan() {
        $sql = $this->db->query('SELECT * FROM wilayah_kecamatan');
        return $sql->result();
    }

    public function get_kelurahan() {
        $sql = $this->db->query('SELECT * FROM wilayah_desa');
        return $sql->result();
    }

    public function get_by_id_admin_reg($id_ref = '') {

        $this->db->select('id_ref, role_admin');
        $this->db->where('id_ref', $id_ref);

        $sql = $this->db->get($this->table_user);
        return $sql->result();
    }

}

?>