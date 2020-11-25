<?php

class Authmodel extends CI_Model {

    private $table = 'petugas';

    // check login
    public function check_login_petugas($email = '', $password = '', $kode = '') {
        $pass = md5($password);
        $sql = $this->db->query("SELECT
                                    p.id_petugas,
                                    p.id_admin,
                                    u.nama_admin,
                                    p.nama_petugas,
                                    p.nomor_ktp,
                                    p.email_petugas,
                                    p.nomor_hp,
                                    p.alamat_petugas,
                                    p.kode_petugas,
                                    p.img,
                                    p.img_thumb,
                                    p.tanggal_post,
                                    p.status_data,
                                    COALESCE(wp.nama,'') AS provinsi,
                                    COALESCE(wkb.nama,'') AS kabupaten,
                                    u.license,
                                    u.license_exp,    
                                    u.path
                                FROM
                                    petugas p
                                LEFT JOIN user u ON
                                    p.id_admin = u.id_ref
                                LEFT JOIN wilayah_kabupaten wkb ON
                                    SUBSTRING(p.id_admin, 3, 2) = wkb.id AND SUBSTRING(p.id_admin, 1, 2) = wkb.id_dati1
                                LEFT JOIN wilayah_provinsi wp ON
                                    SUBSTRING(p.id_admin, 1, 2) = wp.id
                                WHERE
                                    p.email_petugas = '$email' OR p.nomor_hp='$email' AND p.password='$pass' AND p.kode_petugas='$kode'
                                GROUP BY
                                    p.id_petugas");
        return $sql->result();
    }

    public function check_login_admin($email = '', $password = '') {
        $pass = md5($password);
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
                                    u.tanggal_post
                                FROM
                                    user u
                                LEFT JOIN wilayah_kabupaten wkb ON
                                    SUBSTRING(u.id_ref, 3, 2) = wkb.id AND SUBSTRING(u.id_ref, 1, 2) = wkb.id_dati1
                                LEFT JOIN wilayah_provinsi wp ON
                                    SUBSTRING(u.id_ref, 1, 2) = wp.id
                                WHERE
                                    u.email = '$email' AND password='$pass'");
        return $sql->result();
    }

    public function check_login_saksi($email = '', $password = '') {
        $pass = md5($password);
        $sql = $this->db->query("SELECT
                                        s.id_saksi,
                                        s.id_admin,
                                        s.id_pemilihan,
                                        s.id_wilayah_pemilihan,
                                        s.id_tps,
                                        s.id_asal_saksi,
                                        s.nomor_ktp_saksi,
                                        s.email_saksi,
                                        s.nama_saksi,
                                        s.nomor_hp_saksi,
                                        s.img_pas,
                                        s.barcode,
                                        s.tanggal_post,
                                        u.license,
                                        u.license_exp
                                    FROM
                                        saksi s
                                    LEFT JOIN user u ON
                                        u.id_ref = s.id_admin
                                    WHERE 
                                        s.email_saksi='$email' OR s.nomor_hp_saksi='$email' AND s.password_saksi='$pass' 
                                    GROUP BY
                                        s.id_saksi");
        return $sql->result();
    }

    public function get_license($id_admin = '') {

        $sql = $this->db->query("SELECT                                       
                                        u.license,
                                        u.license_exp
                                    FROM
                                        user u                                 
                                    WHERE 
                                        u.id_ref='$id_admin'");
        return $sql->result();
    }

}
