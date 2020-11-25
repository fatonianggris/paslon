<?php

class Berandamodel extends CI_Model {

    /**
     * GET DATA BERANDA
     */
    public function get_beranda_petugas($id = '') {

        $sql = $this->db->query("SELECT
                                    p.id_petugas,
                                    p.nama_petugas,
                                    p.id_admin,
                                    p.status_data,
                                    p.nomor_ktp,
                                    p.email_petugas,
                                    p.nomor_hp,
                                    p.alamat_petugas,
                                    p.kode_petugas,
                                    p.img,
                                    p.img_thumb,
                                    p.tanggal_post,
                                    (
                                    SELECT
                                        COUNT(k.id_ktp)
                                    FROM
                                        ktp k
                                    WHERE
                                        k.id_petugas = p.id_petugas AND k.status_data = 1
                                ) AS jml_ktp
                                FROM
                                    petugas p
                                WHERE
                                    p.id_petugas = '$id' AND p.status_data = 1");
        return $sql->result_array();
    }

    public function get_beranda_saksi($id = '') {

        $sql = $this->db->query("SELECT
                                        s.id_saksi,
                                        s.id_pemilihan,
                                        s.id_wilayah_pemilihan,
                                        s.id_tps,
                                        s.id_asal_saksi,
                                        s.nomor_ktp_saksi,
                                        s.email_saksi,
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
                                        t.nama_tps,
                                        t.nomor_tps,
                                        t.id_wilayah_pemilihan,
                                        p.id_regional_pemilihan,
                                        p.nama_pemilihan,
                                        p.id_kategori_pemilihan,
                                        p.tahun_pemilihan,
                                        p.nomor_urut,
                                        p.nama_calon,
                                        p.nama_wakil_calon,
                                        COALESCE(wp.nama, '') AS provinsi_pemilihan,
                                        COALESCE(wkb.nama, '') AS kabupaten_pemilihan,
                                        wpasl.nama AS provinsi_tps,
                                        wkbasl.nama AS kabupaten_tps,
                                        wkcasl.nama AS kecamatan_tps,
                                        wdasl.nama AS kelurahan_tps,
                                        wppeng.nama AS provinsi_petugas,   
                                        wkbpeng.nama AS kabupaten_petugas,
                                        wkcpeng.nama AS kecamatan_petugas,   
                                        wdpeng.nama AS kelurahan_petugas
                                    FROM
                                        saksi s
                                    LEFT JOIN pemilihan p ON
                                        s.id_pemilihan = p.id_pemilihan
                                    LEFT JOIN tps t ON
                                        s.id_tps = t.id_tps
                                    LEFT JOIN wilayah_kabupaten wkb ON
                                        SUBSTRING(p.id_regional_pemilihan, 3, 2) = wkb.id AND SUBSTRING(p.id_regional_pemilihan, 1, 2) = wkb.id_dati1
                                    LEFT JOIN wilayah_provinsi wp ON
                                        SUBSTRING(p.id_regional_pemilihan, 1, 2) = wp.id
                                    LEFT JOIN wilayah_provinsi wpasl ON
                                        wpasl.id = SUBSTRING(s.id_wilayah_pemilihan, 1, 2)
                                    LEFT JOIN wilayah_kabupaten wkbasl ON
                                        wkbasl.id = SUBSTRING(s.id_wilayah_pemilihan, 3, 2) AND wkbasl.id_dati1 = SUBSTRING(s.id_wilayah_pemilihan, 1, 2)
                                    LEFT JOIN wilayah_kecamatan wkcasl ON
                                        wkcasl.id = SUBSTRING(s.id_wilayah_pemilihan, 5, 2) AND wkcasl.id_dati1 = SUBSTRING(s.id_wilayah_pemilihan, 1, 2) AND wkcasl.id_dati2 = SUBSTRING(s.id_wilayah_pemilihan, 3, 2)
                                    LEFT JOIN wilayah_desa wdasl ON
                                        wdasl.id = SUBSTRING(s.id_wilayah_pemilihan, 7, 2) AND wdasl.id_dati1 = SUBSTRING(s.id_wilayah_pemilihan, 1, 2) AND wdasl.id_dati2 = SUBSTRING(s.id_wilayah_pemilihan, 3, 2) AND wdasl.id_dati3 = SUBSTRING(s.id_wilayah_pemilihan, 5, 2)
                                    LEFT JOIN wilayah_provinsi wppeng ON
                                        SUBSTR(s.id_asal_saksi, 1, 2) = wppeng.id
                                    LEFT JOIN wilayah_kabupaten wkbpeng ON
                                        SUBSTR(s.id_asal_saksi, 3, 2) = wkbpeng.id AND SUBSTR(s.id_asal_saksi, 1, 2) = wkbpeng.id_dati1
                                    LEFT JOIN wilayah_kecamatan wkcpeng ON
                                        wkcpeng.id = SUBSTRING(s.id_asal_saksi, 5, 2) AND wkcpeng.id_dati1 = SUBSTRING(s.id_asal_saksi, 1, 2) AND wkcpeng.id_dati2 = SUBSTRING(s.id_asal_saksi, 3, 2)
                                    LEFT JOIN wilayah_desa wdpeng ON
                                        wdpeng.id = SUBSTRING(s.id_asal_saksi, 7, 2) AND wdpeng.id_dati1 = SUBSTRING(s.id_asal_saksi, 1, 2) AND wdpeng.id_dati2 = SUBSTRING(s.id_asal_saksi, 3, 2) AND wdpeng.id_dati3 = SUBSTRING(s.id_asal_saksi, 5, 2)                                                                                                                                                      
                                    WHERE
                                        s.id_saksi = '$id'");
        return $sql->result_array();
    }

    public function get_beranda_admin($id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        u.id_user,
                                        u.role_admin,
                                        u.id_ref,
                                        u.nama_admin,
                                        u.email,
                                        u.nomor_hp,
                                        u.img,
                                        u.img_thumb,
                                        u.license,
                                        u.license_exp,
                                        u.create_prev,
                                        u.read_prev,
                                        u.update_prev,
                                        u.delete_prev,
                                        COALESCE(wp.nama,'') AS provinsi,
                                        COALESCE(wkb.nama,'') AS kabupaten,
                                        (
                                        SELECT
                                            COUNT(k.id_ktp)
                                        FROM
                                            ktp k
                                        WHERE
                                            k.status_data = 1 AND k.id_admin = '$id_admin'
                                        ) AS jml_ktp,
                                        (
                                            SELECT
                                                COUNT(p.id_petugas)
                                            FROM
                                                petugas p
                                            WHERE
                                                p.status_data = 1 AND p.id_admin = '$id_admin'
                                        ) AS jml_pet,
                                        u.tanggal_post
                                    FROM
                                        user u
                                    LEFT JOIN wilayah_kabupaten wkb ON
                                        SUBSTRING(u.id_ref, 3, 2) = wkb.id AND SUBSTRING(u.id_ref, 1, 2) = wkb.id_dati1
                                    LEFT JOIN wilayah_provinsi wp ON
                                        SUBSTRING(u.id_ref, 1, 2) = wp.id
                                    WHERE u.id_ref='$id_admin'");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT
                                        u.id_user,
                                        u.role_admin,
                                        u.id_ref,
                                        u.nama_admin,
                                        u.email,
                                        u.nomor_hp,
                                        u.img,
                                        u.img_thumb,
                                        u.license,
                                        u.license_exp,
                                        u.create_prev,
                                        u.read_prev,
                                        u.update_prev,
                                        u.delete_prev,
                                        COALESCE(wp.nama,'') AS provinsi,
                                        COALESCE(wkb.nama,'') AS kabupaten,
                                        (
                                        SELECT
                                            COUNT(k.id_ktp)
                                        FROM
                                            ktp k
                                        WHERE
                                            k.status_data = 1 AND k.id_admin LIKE '$id_admin%'
                                        ) AS jml_ktp,
                                        (
                                            SELECT
                                                COUNT(p.id_petugas)
                                            FROM
                                                petugas p
                                            WHERE
                                                p.status_data = 1 AND p.id_admin LIKE '$id_admin%'
                                        ) AS jml_pet,
                                        u.tanggal_post
                                    FROM
                                        user u
                                    LEFT JOIN wilayah_kabupaten wkb ON
                                        SUBSTRING(u.id_ref, 3, 2) = wkb.id AND SUBSTRING(u.id_ref, 1, 2) = wkb.id_dati1
                                    LEFT JOIN wilayah_provinsi wp ON
                                        SUBSTRING(u.id_ref, 1, 2) = wp.id
                                    WHERE u.id_ref='$id_admin'");
        } elseif ($role == 0) {

            $sql = $this->db->query("SELECT
                                        u.id_user,
                                        u.role_admin,
                                        u.id_ref,
                                        u.nama_admin,
                                        u.email,
                                        u.nomor_hp,
                                        u.img,
                                        u.img_thumb,
                                        u.license,
                                        u.license_exp,
                                        u.create_prev,
                                        u.read_prev,
                                        u.update_prev,
                                        u.delete_prev,
                                        COALESCE(wp.nama,'') AS provinsi,
                                        COALESCE(wkb.nama,'') AS kabupaten,
                                        (
                                        SELECT
                                            COUNT(k.id_ktp)
                                        FROM
                                            ktp k
                                        WHERE
                                            k.status_data = 1
                                        ) AS jml_ktp,
                                        (
                                            SELECT
                                                COUNT(p.id_petugas)
                                            FROM
                                                petugas p
                                            WHERE
                                                p.status_data = 1 
                                        ) AS jml_pet,
                                        u.tanggal_post
                                    FROM
                                        user u
                                    LEFT JOIN wilayah_kabupaten wkb ON
                                        SUBSTRING(u.id_ref, 3, 2) = wkb.id AND SUBSTRING(u.id_ref, 1, 2) = wkb.id_dati1
                                    LEFT JOIN wilayah_provinsi wp ON
                                        SUBSTRING(u.id_ref, 1, 2) = wp.id
                                    WHERE u.id_ref='$id_admin'");
        }
        return $sql->result();
    }

}
