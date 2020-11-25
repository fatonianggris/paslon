<?php

class Petugasmodel extends CI_Model {

    private $table_petugas = 'petugas';
    private $table_ktp = 'ktp';

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

    //---------------------------------------TMABAH PETUGAS---------------------------------------//

    public function get_admin() {
        $sql = $this->db->query('SELECT * FROM user WHERE role_admin IN (1,2) ORDER BY tanggal_post DESC');
        return $sql->result();
    }

    public function get_anggota_petugas($id = '') {


        $sql = $this->db->query("SELECT
                                    t.*
                                FROM
                                    (
                                    SELECT
                                        p.id_ktp,
                                        p.id_admin,
                                        p.id_petugas,
                                        p.id_asal,
                                        p.kodepos,
                                        p.pend_terakhir,
                                        p.nik_ktp,
                                        p.email,
                                        p.nama_ktp,
                                        p.nomor_kk,
                                        p.tempat_lahir,
                                        p.tanggal_lahir,
                                        p.jenis_kelamin,
                                        p.gol_darah,
                                        p.alamat_ktp,
                                        p.rt,
                                        p.rw,                                     
                                        p.agama,
                                        p.status_nikah,
                                        p.pekerjaan,
                                        p.nomor_hp_ktp,
                                        p.nomor_rumah_ktp,
                                        p.nomor_kantor_ktp,
                                        p.nomor_faksimili_ktp,
                                        p.tanggal_daftar,
                                        p.nik_kta_lama,
                                        p.nik_kta_baru,
                                        p.pengurus,
                                        COALESCE(p.kategori,'') as kategori,                                        
                                        COALESCE(p.jabatan,'') as jabatan,
                                        p.wilayah_pengurus,
                                        p.facebook,
                                        p.twitter,
                                        p.instagram,
                                        p.whatsapp,
                                        p.img,
                                        p.img_thumb,
                                        p.img_pas,
                                        p.img_pas_thumb,
                                        p.barcode,
                                        p.status_data,                                        
                                        COALESCE(p.status_mutasi,'') as status_mutasi,
                                        pt.nama_petugas,
                                        u.nama_admin,   
                                        pk.job AS nama_pekerjaan,
                                        wpasl.nama AS provinsi_asal,
                                        wkbasl.nama AS kabupaten_asal,
                                        wkcasl.nama AS kecamatan_asal,
                                        wdasl.nama AS kelurahan_asal,
                                        COALESCE(wppeng.nama,'') as provinsi_pengurus,   
                                        COALESCE(wkbpeng.nama,'') as kabupaten_pengurus,
                                        COALESCE(wkcpeng.nama,'') as kecamatan_pengurus,   
                                        COALESCE(wdpeng.nama,'') as kelurahan_pengurus,  
                                        COALESCE(wp.nama,'') as provinsi,   
                                        COALESCE(wkb.nama,'') as kabupaten,  
                                        DATE_FORMAT(
                                            CAST(p.tanggal_post AS DATE),
                                            '%d/%m/%Y'
                                        ) AS tanggal_post
                                    FROM
                                        ktp p                                   
                                    LEFT JOIN petugas pt ON
                                        p.id_petugas = pt.id_petugas AND p.status_data = 1 AND pt.status_data = 1    
                                    LEFT JOIN pekerjaan pk ON
                                        p.pekerjaan = pk.id
                                    LEFT JOIN wilayah_provinsi wp ON
                                       wp.id = SUBSTRING(p.id_admin, 1, 2)
                                    LEFT JOIN wilayah_kabupaten wkb ON
                                       wkb.id = SUBSTRING(p.id_admin, 3, 2) AND wkb.id_dati1 = SUBSTRING(p.id_admin, 1, 2)
                                    LEFT JOIN wilayah_provinsi wpasl ON
                                       wpasl.id = SUBSTRING(p.id_asal, 1, 2)
                                    LEFT JOIN wilayah_kabupaten wkbasl ON
                                       wkbasl.id = SUBSTRING(p.id_asal, 3, 2) AND wkbasl.id_dati1 = SUBSTRING(p.id_asal, 1, 2)
                                    LEFT JOIN wilayah_kecamatan wkcasl ON
                                       wkcasl.id = SUBSTRING(p.id_asal, 5, 2) AND wkcasl.id_dati1 = SUBSTRING(p.id_asal, 1, 2) AND wkcasl.id_dati2 = SUBSTRING(p.id_asal, 3, 2)
                                    LEFT JOIN wilayah_desa wdasl ON
                                       wdasl.id = SUBSTRING(p.id_asal, 7, 2) AND wdasl.id_dati1 = SUBSTRING(p.id_asal, 1, 2) AND wdasl.id_dati2 = SUBSTRING(p.id_asal, 3, 2) AND wdasl.id_dati3 = SUBSTRING(p.id_asal, 5, 2)                                                                        
                                    LEFT JOIN wilayah_provinsi wppeng ON
                                        SUBSTR(p.wilayah_pengurus, 1, 2) = wppeng.id
                                    LEFT JOIN wilayah_kabupaten wkbpeng ON
                                        SUBSTR(p.wilayah_pengurus, 3, 2) = wkbpeng.id AND SUBSTR(p.wilayah_pengurus, 1, 2) = wkbpeng.id_dati1
                                    LEFT JOIN wilayah_kecamatan wkcpeng ON
                                        wkcpeng.id = SUBSTRING(p.wilayah_pengurus, 5, 2) AND wkcpeng.id_dati1 = SUBSTRING(p.wilayah_pengurus, 1, 2) AND wkcpeng.id_dati2 = SUBSTRING(p.wilayah_pengurus, 3, 2)
                                    LEFT JOIN wilayah_desa wdpeng ON
                                        wdpeng.id = SUBSTRING(p.wilayah_pengurus, 7, 2) AND wdpeng.id_dati1 = SUBSTRING(p.wilayah_pengurus, 1, 2) AND wdpeng.id_dati2 = SUBSTRING(p.wilayah_pengurus, 3, 2) AND wdpeng.id_dati3 = SUBSTRING(p.wilayah_pengurus, 5, 2)                                                                              
                                    LEFT JOIN user u ON
                                        p.id_admin = u.id_ref
                                ) t
                                WHERE
                                  t.id_ktp='$id'");
        return $sql->result();
    }

    public function get_admin_regional($id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            u.id_ref,
                                            u.nama_admin,
                                            u.role_admin,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            u.tanggal_post
                                        FROM
                                            user u
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTR(u.id_ref, 3, 2) = wkb.id AND SUBSTR(u.id_ref, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTR(u.id_ref, 1, 2) = wp.id
                                    ) t
                                    WHERE
                                        t.id_ref = '$id_admin'
                                    ORDER BY
                                        t.tanggal_post");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            u.id_ref,
                                            u.nama_admin,
                                            u.role_admin,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            u.tanggal_post
                                        FROM
                                            user u
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTR(u.id_ref, 3, 2) = wkb.id AND SUBSTR(u.id_ref, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTR(u.id_ref, 1, 2) = wp.id
                                    ) t
                                    WHERE
                                        t.id_ref LIKE '$id_admin%'
                                    ORDER BY
                                        t.tanggal_post");
        } else if (($role == 0)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            u.id_ref,
                                            u.nama_admin,
                                            u.role_admin,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            u.tanggal_post
                                        FROM
                                            user u
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTR(u.id_ref, 3, 2) = wkb.id AND SUBSTR(u.id_ref, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTR(u.id_ref, 1, 2) = wp.id
                                    ) t                                   
                                    ORDER BY
                                        t.tanggal_post");
        }

        return $sql->result();
    }

    //---------------------------------------INDEX PETUGAS---------------------------------------//

    public function get_petugas($id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT 
                                            p.id_petugas,
                                            p.id_admin,
                                            p.nama_petugas,
                                            p.nomor_hp,
                                            p.alamat_petugas,
                                            p.email_petugas,
                                            p.nomor_ktp,
                                            p.kode_petugas,
                                            (
                                            SELECT
                                                COUNT(k.id_ktp)
                                            FROM
                                                ktp k
                                            WHERE
                                                k.id_petugas = p.id_petugas AND k.status_data = 1
                                        ) AS jml_ktp,
                                        p.status_data,
                                        p.tanggal_post
                                    FROM
                                        petugas p
                                    ) t
                                    WHERE
                                        t.id_admin = '$id_admin' AND status_data = 1
                                    ORDER BY
                                        t.tanggal_post
                                    DESC");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT 
                                            p.id_petugas,
                                            p.id_admin,
                                            p.nama_petugas,
                                            p.nomor_hp,
                                            p.alamat_petugas,
                                            p.email_petugas,
                                            p.nomor_ktp,
                                            p.kode_petugas,
                                            (
                                            SELECT
                                                COUNT(k.id_ktp)
                                            FROM
                                                ktp k
                                            WHERE
                                                k.id_petugas = p.id_petugas AND k.status_data = 1
                                        ) AS jml_ktp,
                                        p.status_data,
                                        p.tanggal_post
                                    FROM
                                        petugas p
                                    ) t
                                    WHERE
                                        t.id_admin LIKE '$id_admin%' AND status_data = 1
                                    ORDER BY
                                        t.tanggal_post
                                    DESC");
        } elseif ($role == 0) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT 
                                            p.id_petugas,
                                            p.id_admin,
                                            p.nama_petugas,
                                            p.nomor_hp,
                                            p.alamat_petugas,
                                            p.email_petugas,
                                            p.nomor_ktp,
                                            p.kode_petugas,
                                            (
                                            SELECT
                                                COUNT(k.id_ktp)
                                            FROM
                                                ktp k
                                            WHERE
                                                k.id_petugas = p.id_petugas
                                        ) AS jml_ktp,
                                        p.status_data,
                                        p.tanggal_post
                                    FROM
                                        petugas p
                                    ) t                                   
                                    ORDER BY
                                        t.tanggal_post
                                    DESC");
        }

        return $sql->result();
    }

    //--------------------------------CEK PASS PETUGAS -----------------------------------------//
    public function cek_password_petugas($id_petugas = '', $pass = '') {

        $passwd = md5($pass);

        $this->db->where('id_petugas', $id_petugas);
        $this->db->where('password', $passwd);

        $sql = $this->db->get($this->table_petugas);
        return $sql->result();
    }

    //--------------------------------UPDATE PASS PETUGAS-----------------------------------------//
    public function update_password_petugas($id_petugas = '', $pass = '') {
        $passwd = md5($pass);
        $this->db->trans_begin();

        $data = array(
            'password' => $passwd
        );

        $this->db->where('id_petugas', $id_petugas);
        $this->db->update($this->table_petugas, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //---------------------------------------GET PETUGAS---------------------------------------//

    public function get_by_id_petugas($id = '', $id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $this->db->where('id_petugas', $id);
            $this->db->where('id_admin', $id_admin);
        } elseif (!empty($id_admin) && ($role == 1)) {

            $this->db->where('id_petugas', $id);
            $this->db->like('id_admin', $id_admin);
        } elseif ($role == 0) {

            $this->db->where('id_petugas', $id);
        }

        $sql = $this->db->get($this->table_petugas);
        return $sql->result();
    }

//---------------------------------------INSERT PETUGAS---------------------------------------//

    public function insert_petugas($value = '', $id_admin = '', $role = '') {
        $passwd = md5($value['password']);
        $this->db->trans_begin();

        if (!empty($id_admin) && ($role == 2)) {

            $data = array(
                'nama_petugas' => $value['nama_petugas'],
                'id_admin' => $id_admin,
                'nomor_ktp' => $value['nomor_ktp'],
                'email_petugas' => $value['email_petugas'],
                'nomor_hp' => $value['nomor_hp'],
                'alamat_petugas' => $value['alamat_petugas'],
                'kode_petugas' => $value['kode_petugas'],
                'password' => $passwd,
                'img' => $value['pic'],
                'img_thumb' => $value['pic_thumb']
            );
        } elseif (!empty($id_admin) && ($role == 1)) {

            $data = array(
                'nama_petugas' => $value['nama_petugas'],
                'id_admin' => $value['region_petugas'],
                'nomor_ktp' => $value['nomor_ktp'],
                'email_petugas' => $value['email_petugas'],
                'nomor_hp' => $value['nomor_hp'],
                'alamat_petugas' => $value['alamat_petugas'],
                'kode_petugas' => $value['kode_petugas'],
                'password' => $passwd,
                'img' => $value['pic'],
                'img_thumb' => $value['pic_thumb']
            );
        } elseif ($role == 0) {

            $data = array(
                'nama_petugas' => $value['nama_petugas'],
                'id_admin' => $value['region_petugas'],
                'nomor_ktp' => $value['nomor_ktp'],
                'email_petugas' => $value['email_petugas'],
                'nomor_hp' => $value['nomor_hp'],
                'alamat_petugas' => $value['alamat_petugas'],
                'kode_petugas' => $value['kode_petugas'],
                'password' => $passwd,
                'img' => $value['pic'],
                'img_thumb' => $value['pic_thumb']
            );
        }
        $this->db->insert($this->table_petugas, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

//---------------------------------------UPDATE PETUGAS---------------------------------------/
    public function update_petugas($id = '', $value = '', $id_admin = '', $role = '') {
        $this->db->trans_begin();

        if (!empty($id_admin) && ($role == 2)) {

            $data = array(
                'nama_petugas' => $value['nama_petugas'],
                'nomor_ktp' => $value['nomor_ktp'],
                'email_petugas' => $value['email_petugas'],
                'nomor_hp' => $value['nomor_hp'],
                'alamat_petugas' => $value['alamat_petugas'],
                'img' => $value['pic'],
                'img_thumb' => $value['pic_thumb']
            );
            $this->db->where('id_petugas', $id);
            $this->db->where('id_admin', $id_admin);
        } elseif (!empty($id_admin) && ($role == 1)) {

            $data = array(
                'nama_petugas' => $value['nama_petugas'],
                'id_admin' => $value['region_petugas'],
                'nomor_ktp' => $value['nomor_ktp'],
                'email_petugas' => $value['email_petugas'],
                'nomor_hp' => $value['nomor_hp'],
                'alamat_petugas' => $value['alamat_petugas'],
                'img' => $value['pic'],
                'img_thumb' => $value['pic_thumb']
            );
            $this->db->where('id_petugas', $id);
            $this->db->like('id_admin', $id_admin);
        } elseif ($role == 0) {

            $data = array(
                'nama_petugas' => $value['nama_petugas'],
                'id_admin' => $value['region_petugas'],
                'nomor_ktp' => $value['nomor_ktp'],
                'email_petugas' => $value['email_petugas'],
                'nomor_hp' => $value['nomor_hp'],
                'alamat_petugas' => $value['alamat_petugas'],
                'img' => $value['pic'],
                'img_thumb' => $value['pic_thumb']
            );
            $this->db->where('id_petugas', $id);
        }

        $this->db->update($this->table_petugas, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function get_img_by_id_petugas($id = '', $id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $this->db->select('img');
            $this->db->where('id_petugas', $id);
            $this->db->where('id_admin', $id_admin);
        } elseif (!empty($id_admin) && ($role == 1)) {

            $this->db->select('img');
            $this->db->where('id_petugas', $id);
            $this->db->like('id_admin', $id_admin);
        } elseif ($role == 0) {

            $this->db->select('img');
            $this->db->where('id_petugas', $id);
        }

        $sql = $this->db->get($this->table_petugas);
        return $sql->result();
    }

//---------------------------------------DELETE PETUGAS---------------------------------------/

    public function delete_petugas($value = '', $id_admin = '', $role = '') {
        $this->db->trans_begin();

        $data = array(
            'status_data' => 0
        );

        if (!empty($id_admin) && ($role == 2)) {

            $this->db->where('id_admin', $id_admin);
            $this->db->where('id_petugas', $value);
            $this->db->update($this->table_petugas, $data);
        } elseif (!empty($id_admin) && ($role == 1)) {

            $this->db->where('id_admin', $id_admin);
            $this->db->like('id_petugas', $value);
            $this->db->update($this->table_petugas, $data);
        } elseif ($role == 0) {

            $this->db->where('id_petugas', $value);
            $this->db->delete($this->table_petugas);
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

//---------------------------------------UBAH STATUS PETUGAS---------------------------------------/

    public function update_status_ktp_pet($value = '', $id_admin = '', $role = '') {
        $this->db->trans_begin();

        $data = array(
            'id_petugas' => 0
        );

        if (!empty($id_admin) && ($role == 2)) {

            $this->db->where('id_admin', $id_admin);
            $this->db->where('id_petugas', $value);
            $this->db->update($this->table_ktp, $data);
        } elseif (!empty($id_admin) && ($role == 1)) {

            $this->db->where('id_admin', $id_admin);
            $this->db->like('id_petugas', $value);
            $this->db->update($this->table_ktp, $data);
        } elseif ($role == 0) {

            $this->db->where('id_petugas', $value);
            $this->db->update($this->table_ktp, $data);
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function ubah_status_petugas($id = '', $status = '') {
        $this->db->trans_begin();

        $data = array(
            'status_data' => $status
        );

        $this->db->where('id_petugas', $id);
        $this->db->update($this->table_petugas, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function ubah_status_ktp($id = '') {
        $this->db->trans_begin();

        $data = array(
            'id_petugas' => 0
        );

        $this->db->where('id_petugas', $id);
        $this->db->update($this->table_ktp, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //------------------------------------------------------------------------------/
}

?>