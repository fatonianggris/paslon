<?php

class Ktpmodel extends CI_Model {

    private $ktp = 'ktp';
    private $user = 'user';

    /**
     * METHOD/FUNCTION KTP CRUD
     */
    //-------------------------------------------------- GET KTP----------------------------------------------------//
    public function get_img_by_id_ktp($id = '') {

        $this->db->select('img, id_admin');
        $this->db->where('id_ktp', $id);

        $sql = $this->db->get($this->ktp);
        return $sql->result();
    }

    public function get_by_id_admin_reg($id_admin = '') {

        $this->db->select('id_ref, role_admin, path');
        $this->db->where('id_ref', $id_admin);

        $sql = $this->db->get($this->user);
        return $sql->result();
    }

    public function get_path_by_id_reg($id = '') {

        $this->db->select('path, nama_admin');
        $this->db->where('id_ref', $id);

        $sql = $this->db->get($this->table_user);
        return $sql->result();
    }

    public function count_ktp_petugas_all($id_pet = '') {

        $this->db->where('id_petugas', $id_pet);
        $sql = $this->db->get($this->ktp);
        return $sql->num_rows();
    }

    public function count_ktp_admin_all($id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $this->db->select('*');
            $this->db->where('id_admin', $id_admin);
        } elseif (!empty($id_admin) && ($role == 1)) {

            $this->db->select('*');
            $this->db->like('id_admin', $id_admin, 'after');
        } elseif ($role == 0) {
            $this->db->select('*');
        }

        $sql = $this->db->get($this->ktp);
        return $sql->num_rows();
    }

    //-------------------------------------------------- GET DETAIL KTP----------------------------------------------------//
    public function get_detail_ktp($id = '') {

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
                                    t.status_data = 1 AND t.id_ktp='$id'");
        return $sql->result();
    }

    public function get_all_ktp_petugas($id_pet = '', $limit = '') {

        $sql = $this->db->query("SELECT 
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
                                        COALESCE(p.kategori, '') AS kategori,
                                        COALESCE(p.jabatan, '') AS jabatan,
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
                                        u.nama_admin,
                                        u.id_ref,
                                        COALESCE(p.status_mutasi, '') AS status_mutasi,
                                        pt.nama_petugas,
                                        pk.job AS nama_pekerjaan,
                                        wpasl.nama AS provinsi_asal,
                                        wkbasl.nama AS kabupaten_asal,
                                        wkcasl.nama AS kecamatan_asal,
                                        wdasl.nama AS kelurahan_asal,
                                        COALESCE(wppeng.nama, '') AS provinsi_pengurus,
                                        COALESCE(wkbpeng.nama, '') AS kabupaten_pengurus,
                                        COALESCE(wkcpeng.nama, '') AS kecamatan_pengurus,
                                        COALESCE(wdpeng.nama, '') AS kelurahan_pengurus,
                                        DATE_FORMAT(
                                            CAST(p.tanggal_post AS DATE),
                                            '%d/%m/%Y'
                                        ) AS tanggal_post,
                                        p.tanggal_post AS urutan
                                    FROM
                                        ktp p
                                    LEFT JOIN petugas pt ON
                                        p.id_petugas = pt.id_petugas
                                    LEFT JOIN user u ON
                                        u.id_ref = p.id_admin
                                    LEFT JOIN pekerjaan pk ON
                                        p.pekerjaan = pk.id
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
                                    WHERE
                                        p.status_data = 1 AND p.id_petugas = '$id_pet'
                                    GROUP BY
                                    	p.id_ktp
                                    ORDER BY
                                        p.tanggal_post ASC
                                    LIMIT $limit");

        return $sql->result_array();
    }

    public function get_all_ktp_admin($id_admin = '', $role, $limit = '') {

        if (!empty($id_admin) && ($role == 2)) {

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
                                        DATE_FORMAT(
                                            CAST(p.tanggal_post AS DATE),
                                            '%d/%m/%Y'
                                        ) AS tanggal_post,
                                        p.tanggal_post AS urutan
                                    FROM
                                        ktp p                                   
                                    LEFT JOIN petugas pt ON
                                        p.id_petugas = pt.id_petugas AND p.status_data = 1 AND pt.status_data = 1 
                                    LEFT JOIN pekerjaan pk ON
                                        p.pekerjaan = pk.id
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
                                WHERE t.status_data=1 AND t.id_admin='$id_admin' ORDER BY t.urutan ASC LIMIT $limit");
        } elseif (!empty($id_admin) && ($role == 1)) {

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
                                        DATE_FORMAT(
                                            CAST(p.tanggal_post AS DATE),
                                            '%d/%m/%Y'
                                        ) AS tanggal_post,
                                        p.tanggal_post AS urutan
                                    FROM
                                        ktp p                                   
                                    LEFT JOIN petugas pt ON
                                        p.id_petugas = pt.id_petugas AND p.status_data = 1 AND pt.status_data = 1 
                                    LEFT JOIN pekerjaan pk ON
                                        p.pekerjaan = pk.id
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
                                WHERE t.status_data=1 AND t.id_admin LIKE '$id_admin%' ORDER BY t.urutan ASC LIMIT $limit");
        } elseif ($role == 0) {

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
                                        DATE_FORMAT(
                                            CAST(p.tanggal_post AS DATE),
                                            '%d/%m/%Y'
                                        ) AS tanggal_post,
                                        p.tanggal_post AS urutan
                                    FROM
                                        ktp p                                   
                                    LEFT JOIN petugas pt ON
                                        p.id_petugas = pt.id_petugas AND p.status_data = 1 AND pt.status_data = 1 
                                    LEFT JOIN pekerjaan pk ON
                                        p.pekerjaan = pk.id
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
                                WHERE t.status_data=1 ORDER BY t.urutan ASC LIMIT $limit");
        }
        return $sql->result_array();
    }

    //-------------------------------------------------- INSERT KTP----------------------------------------------------//

    public function insert_ktp($value = '', $id_admin = '') {
        $this->db->trans_begin();

        $data = array(
            'id_admin' => $id_admin,
            'id_petugas' => $value['nama_petugas'],
            'id_asal' => $value['id_asal'],
            'nama_ktp' => $value['nama_ktp'],
            'nik_ktp' => $value['nik_ktp'],
            'tempat_lahir' => $value['tempat_lahir'],
            'tanggal_lahir' => $value['tanggal_lahir'],
            'jenis_kelamin' => $value['jenis_kelamin'],
            'gol_darah' => $value['gol_darah'],
            'email' => $value['email'],
            'alamat_ktp' => $value['alamat_ktp'],
            'rt' => $value['rt'],
            'rw' => $value['rw'],
            'kodepos' => $value['kodepos'],
            'agama' => $value['agama'],
            'pend_terakhir' => $value['pend_terakhir'],
            'status_nikah' => $value['status_nikah'],
            'pekerjaan' => $value['pekerjaan'],
            'nomor_rumah_ktp' => $value['nomor_rumah_ktp'],
            'nomor_hp_ktp' => $value['nomor_hp_ktp'],
            'nomor_kantor_ktp' => $value['nomor_kantor_ktp'],
            'nomor_faksimili_ktp' => $value['nomor_faksimili_ktp'],
            'img' => $value['pic'],
            'img_thumb' => $value['pic_thumb'],
            'img_pas' => $value['pic_pas'],
            'img_pas_thumb' => $value['pic_pas_thumb'],
            'barcode' => $value['barcode'],
            'tanggal_daftar' => $value['tanggal_daftar'],
            'nik_kta_lama' => $value['nik_kta_lama'],
            'nik_kta_baru' => $value['nik_kta_baru'],
            'pengurus' => $value['pengurus'],
            'kategori' => $value['kategori'],
            'jabatan' => $value['jabatan'],
            'wilayah_pengurus' => $value['wilayah_pengurus'],
            'facebook' => $value['facebook'],
            'twitter' => $value['twitter'],
            'instagram' => $value['instagram'],
            'whatsapp' => $value['whatsapp']
        );

        $this->db->insert($this->ktp, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function get_code_wil($id_ref = '', $role = '') {

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

    public function get_no_urut($id_ref = '') {

        $sql = $this->db->query("SELECT
                                    t.*
                                FROM
                                    (
                                    SELECT
                                        MAX(CAST(SUBSTR(p.nik_kta_baru, 18) AS INT)) AS no_urut,
                                        p.id_admin,
                                        p.status_data
                                    FROM
                                        ktp p
                                ) t
                                WHERE
                                    t.status_data = 1 AND t.id_admin = '$id_ref'");
        return $sql->result();
    }

    //-------------------------------------------------- UPDATE KTP----------------------------------------------------//

    public function update_ktp($id = '', $value = '') {
        $this->db->trans_begin();

        $data = array(
            'id_admin' => $value['id_admin'],
            'id_petugas' => $value['nama_petugas'],
            'id_asal' => $value['id_asal'],
            'nama_ktp' => $value['nama_ktp'],
            'nik_ktp' => $value['nik_ktp'],
            'tempat_lahir' => $value['tempat_lahir'],
            'tanggal_lahir' => $value['tanggal_lahir'],
            'jenis_kelamin' => $value['jenis_kelamin'],
            'gol_darah' => $value['gol_darah'],
            'email' => $value['email'],
            'alamat_ktp' => $value['alamat_ktp'],
            'rt' => $value['rt'],
            'rw' => $value['rw'],
            'kodepos' => $value['kodepos'],
            'agama' => $value['agama'],
            'pend_terakhir' => $value['pend_terakhir'],
            'status_nikah' => $value['status_nikah'],
            'pekerjaan' => $value['pekerjaan'],
            'nomor_rumah_ktp' => $value['nomor_rumah_ktp'],
            'nomor_hp_ktp' => $value['nomor_hp_ktp'],
            'nomor_kantor_ktp' => $value['nomor_kantor_ktp'],
            'nomor_faksimili_ktp' => $value['nomor_faksimili_ktp'],
            'img' => $value['pic'],
            'img_thumb' => $value['pic_thumb'],
            'img_pas' => $value['pic_pas'],
            'img_pas_thumb' => $value['pic_pas_thumb'],
            'nik_kta_lama' => $value['nik_kta_lama'],
            'pengurus' => $value['pengurus'],
            'kategori' => $value['kategori'],
            'jabatan' => $value['jabatan'],
            'wilayah_pengurus' => $value['wilayah_pengurus'],
            'facebook' => $value['facebook'],
            'twitter' => $value['twitter'],
            'instagram' => $value['instagram'],
            'whatsapp' => $value['whatsapp']
        );

        $this->db->where('id_ktp', $id);
        $this->db->update($this->ktp, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //-------------------------------------------------- DELETE KTP----------------------------------------------------//
    public function delete_ktp($id = '') {
        $this->db->trans_begin();

        $data = array(
            'status_data' => 0
        );

        $this->db->where('id_ktp', $id);
        $this->db->update($this->ktp, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

}
