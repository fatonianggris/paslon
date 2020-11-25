<?php

class Ktpmodel extends CI_Model {

    private $ktp = 'ktp';   
    private $user = 'user';

    /**
     * METHOD/FUNCTION KTP CRUD
     */
    public function get_ktp_reg_petugas($id_pet = '', $id_reg = '', $limit = '') {

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
                                        p.kategori,
                                        p.jabatan,
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
                                        pt.nama_petugas,
                                        wp.nama AS provinsi,
                                        wk.nama AS kabupaten,
                                        u.nama_admin,                                                                    
                                        DATE_FORMAT(
                                            CAST(r.tanggal_post AS DATE),
                                            '%d/%m/%Y'
                                        ) AS tanggal_post
                                    FROM
                                        ktp p                                   
                                    LEFT JOIN petugas pt ON
                                        p.id_petugas = pt.id_petugas AND p.status_data = 1 AND pt.status_data = 1
                                    LEFT JOIN wilayah_provinsi wp ON
                                       wp.id = SUBSTRING(p.id_admin, 1, 2)
                                    LEFT JOIN wilayah_kabupaten wk ON
                                       wk.id = SUBSTRING(p.id_admin, 3, 2) AND wk.id_dati1 = SUBSTRING(p.id_admin, 1, 2)
                                    LEFT JOIN USER u ON
                                        p.id_admin = u.id_user
                                ) t
                                WHERE
                                    t.status_data = 1 AND t.id_petugas='$id_pet' AND t.id_admin='$id_reg' ORDER BY t.tanggal_post DESC LIMIT $limit");

        return $sql->result_array();
    }

    public function get_all_ktp_petugas($id_pet = '', $limit = '') {

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
                                        p.kategori,
                                        p.jabatan,
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
                                        pt.nama_petugas,
                                        u.nama_admin,                                       
                                        wp.nama AS provinsi,
                                        wk.nama AS kabupaten,
                                        DATE_FORMAT(
                                            CAST(p.tanggal_post AS DATE),
                                            '%d/%m/%Y'
                                        ) AS tanggal_post
                                    FROM
                                        ktp p                                   
                                    LEFT JOIN petugas pt ON
                                        p.id_petugas = pt.id_petugas AND p.status_data = 1 AND pt.status_data = 1
                                    LEFT JOIN wilayah_provinsi wp ON
                                       wp.id = SUBSTRING(p.id_admin, 1, 2)
                                    LEFT JOIN wilayah_kabupaten wk ON
                                       wk.id = SUBSTRING(p.id_admin, 3, 2) AND wk.id_dati1 = SUBSTRING(p.id_admin, 1, 2)
                                    LEFT JOIN USER u ON
                                        p.id_admin = u.id_user
                                ) t
                                WHERE t.status_data=1 AND t.id_petugas='$id_pet' ORDER BY t.tanggal_post DESC LIMIT $limit");

        return $sql->result_array();
    }

    public function get_ktp_reg_admin($id_admin = '', $id_reg = '', $role = '', $limit = '') {

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
                                        p.kategori,
                                        p.jabatan,
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
                                        pt.nama_petugas,
                                        u.nama_admin,
                                        wp.nama AS provinsi,
                                        wk.nama AS kabupaten,                                      
                                        DATE_FORMAT(
                                            CAST(r.tanggal_post AS DATE),
                                            '%d/%m/%Y'
                                        ) AS tanggal_post
                                    FROM
                                        ktp p                                    
                                    LEFT JOIN petugas pt ON
                                        p.id_petugas = pt.id_petugas AND p.status_data = 1 AND pt.status_data = 1
                                    LEFT JOIN wilayah_provinsi wp ON
                                       wp.id = SUBSTRING(p.id_admin, 1, 2)
                                    LEFT JOIN wilayah_kabupaten wk ON
                                       wk.id = SUBSTRING(p.id_admin, 3, 2) AND wk.id_dati1 = SUBSTRING(p.id_admin, 1, 2)
                                    LEFT JOIN USER u ON
                                        p.id_admin = u.id_user
                                ) t
                                WHERE
                                    t.status_data = 1 AND t.id_admin='$id_admin' AND t.id_admin='$id_reg' ORDER BY t.tanggal_post DESC LIMIT $limit");
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
                                        p.kategori,
                                        p.jabatan,
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
                                        pt.nama_petugas,
                                        u.nama_admin,
                                        wp.nama AS provinsi,
                                        wk.nama AS kabupaten,
                                        DATE_FORMAT(
                                            CAST(r.tanggal_post AS DATE),
                                            '%d/%m/%Y'
                                        ) AS tanggal_post
                                    FROM
                                        ktp p                                   
                                    LEFT JOIN petugas pt ON
                                        p.id_petugas = pt.id_petugas AND p.status_data = 1 AND pt.status_data = 1
                                    LEFT JOIN wilayah_provinsi wp ON
                                       wp.id = SUBSTRING(p.id_admin, 1, 2)
                                    LEFT JOIN wilayah_kabupaten wk ON
                                       wk.id = SUBSTRING(p.id_admin, 3, 2) AND wk.id_dati1 = SUBSTRING(p.id_admin, 1, 2)
                                    LEFT JOIN USER u ON
                                        p.id_admin = u.id_user
                                ) t
                                WHERE
                                    t.status_data = 1 AND t.id_admin='$id_admin' AND t.id_admin='$id_reg' ORDER BY t.tanggal_post DESC LIMIT $limit");
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
                                        p.kategori,
                                        p.jabatan,
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
                                        pt.nama_petugas,
                                        u.nama_admin,
                                        wp.nama AS provinsi,
                                        wk.nama AS kabupaten,
                                        DATE_FORMAT(
                                            CAST(r.tanggal_post AS DATE),
                                            '%d/%m/%Y'
                                        ) AS tanggal_post
                                    FROM
                                        ktp p                                   
                                    LEFT JOIN petugas pt ON
                                        p.id_petugas = pt.id_petugas
                                    LEFT JOIN wilayah_provinsi wp ON
                                       wp.id = SUBSTRING(p.id_admin, 1, 2)
                                    LEFT JOIN wilayah_kabupaten wk ON
                                       wk.id = SUBSTRING(p.id_admin, 3, 2) AND wk.id_dati1 = SUBSTRING(p.id_admin, 1, 2)
                                    LEFT JOIN USER u ON
                                        p.id_admin = u.id_user
                                ) t
                                WHERE
                                  t.id_admin='$id_reg' ORDER BY t.tanggal_post DESC LIMIT $limit");
        }

        return $sql->result_array();
    }

    public function get_all_ktp_admin($id_admin = '', $role = '', $limit = '') {

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
                                        p.kategori,
                                        p.jabatan,
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
                                        pt.nama_petugas,
                                        u.nama_admin,
                                        wp.nama AS provinsi,
                                        wk.nama AS kabupaten,  
                                        DATE_FORMAT(
                                            CAST(r.tanggal_post AS DATE),
                                            '%d/%m/%Y'
                                        ) AS tanggal_post
                                    FROM
                                        ktp p                                   
                                    LEFT JOIN petugas pt ON
                                        p.id_petugas = pt.id_petugas AND p.status_data = 1 AND pt.status_data = 1
                                    LEFT JOIN wilayah_provinsi wp ON
                                       wp.id = SUBSTRING(p.id_admin, 1, 2)
                                    LEFT JOIN wilayah_kabupaten wk ON
                                       wk.id = SUBSTRING(p.id_admin, 3, 2) AND wk.id_dati1 = SUBSTRING(p.id_admin, 1, 2)
                                    LEFT JOIN USER u ON
                                        p.id_admin = u.id_user
                                ) t
                                WHERE t.status_data=1 AND t.id_admin='$id_admin' ORDER BY t.tanggal_post DESC LIMIT $limit");
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
                                        p.kategori,
                                        p.jabatan,
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
                                        pt.nama_petugas,
                                        u.nama_admin,
                                        wp.nama AS provinsi,
                                        wk.nama AS kabupaten, 
                                        DATE_FORMAT(
                                            CAST(r.tanggal_post AS DATE),
                                            '%d/%m/%Y'
                                        ) AS tanggal_post
                                    FROM
                                        ktp p                                   
                                    LEFT JOIN petugas pt ON
                                        p.id_petugas = pt.id_petugas AND p.status_data = 1 AND pt.status_data = 1
                                    LEFT JOIN wilayah_provinsi wp ON
                                       wp.id = SUBSTRING(p.id_admin, 1, 2)
                                    LEFT JOIN wilayah_kabupaten wk ON
                                       wk.id = SUBSTRING(p.id_admin, 3, 2) AND wk.id_dati1 = SUBSTRING(p.id_admin, 1, 2)
                                    LEFT JOIN USER u ON
                                        p.id_admin = u.id_user
                                ) t
                                WHERE t.status_data=1 AND t.id_admin LIKE '$id_admin%' ORDER BY t.tanggal_post DESC LIMIT $limit");
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
                                        p.kategori,
                                        p.jabatan,
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
                                        pt.nama_petugas,
                                        u.nama_admin,
                                        wp.nama AS provinsi,
                                        wk.nama AS kabupaten,   
                                        DATE_FORMAT(
                                            CAST(r.tanggal_post AS DATE),
                                            '%d/%m/%Y'
                                        ) AS tanggal_post
                                    FROM
                                        ktp p                                   
                                    LEFT JOIN petugas pt ON
                                        p.id_petugas = pt.id_petugas
                                    LEFT JOIN wilayah_provinsi wp ON
                                       wp.id = SUBSTRING(p.id_admin, 1, 2)
                                    LEFT JOIN wilayah_kabupaten wk ON
                                       wk.id = SUBSTRING(p.id_admin, 3, 2) AND wk.id_dati1 = SUBSTRING(p.id_admin, 1, 2)
                                    LEFT JOIN USER u ON
                                        p.id_admin = u.id_user
                                ) t
                                ORDER BY t.tanggal_post DESC LIMIT $limit");
        }
        return $sql->result_array();
    }

    public function count_ktp_reg($id_pet = '', $id_reg = '') {
        $this->db->where('id_petugas', $id_pet);
        $this->db->where('id_admin', $id_reg);
        $sql = $this->db->get($this->ktp);
        return $sql->num_rows();
    }

    public function count_ktp_reg_admin($id_admin = '', $id_reg = '', $role = '') {

        if (!empty($id_admin) && ($role == 1)) {

            $this->db->where('id_admin', $id_admin);
            $this->db->where('status_data', 1);
            $this->db->where('id_admin', $id_reg);
        } elseif (!empty($id_admin) && ($role == 2)) {

            $this->db->where('id_admin', $id_admin);
            $this->db->where('status_data', 1);
            $this->db->like('id_admin', $id_reg);
        } elseif ($role == 0) {

            $this->db->where('id_admin', $id_reg);
        }
        $sql = $this->db->get($this->ktp);
        return $sql->num_rows();
    }

    public function insert_ktp($value = '', $id_admin = '') {
        $this->db->trans_begin();

        $data = array(
            'id_admin' => $id_admin,
            'id_petugas' => $value['nama_petugas'],
            'nik_ktp' => $value['nik_ktp'],
            'nomor_kk' => $value['nomor_kk'],
            'nama_ktp' => $value['nama_ktp'],
            'tempat_lahir' => $value['tempat_lahir'],
            'tanggal_lahir' => $value['tanggal_lahir'],
            'jenis_kelamin' => $value['jenis_kelamin'],
            'gol_darah' => $value['gol_darah'],
            'alamat_ktp' => $value['alamat_ktp'],
            'rt' => $value['rt'],
            'rw' => $value['rw'],
            'agama' => $value['agama'],
            'status_nikah' => $value['status_nikah'],
            'pekerjaan' => $value['pekerjaan'],
            'kewarganegaraan' => $value['kewarganegaraan'],
            'nomor_hp_ktp' => $value['nomor_hp_ktp'],
            'img' => $value['pic'],
            'img_thumb' => $value['pic_thumb']
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

    public function update_ktp($id = '', $value = '') {
        $this->db->trans_begin();

        $data = array(
            'id_petugas' => $value['nama_petugas'],
            'nik_ktp' => $value['nik_ktp'],
            'nomor_kk' => $value['nomor_kk'],
            'nama_ktp' => $value['nama_ktp'],
            'tempat_lahir' => $value['tempat_lahir'],
            'tanggal_lahir' => $value['tanggal_lahir'],
            'jenis_kelamin' => $value['jenis_kelamin'],
            'gol_darah' => $value['gol_darah'],
            'alamat_ktp' => $value['alamat_ktp'],
            'rt' => $value['rt'],
            'rw' => $value['rw'],
            'agama' => $value['agama'],
            'status_nikah' => $value['status_nikah'],
            'pekerjaan' => $value['pekerjaan'],
            'kewarganegaraan' => $value['kewarganegaraan'],
            'nomor_hp_ktp' => $value['nomor_hp_ktp'],
            'img' => $value['pic'],
            'img_thumb' => $value['pic_thumb']
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

    public function get_img_by_id_ktp($id = '') {

        $this->db->select('img, id_admin');
        $this->db->where('id_ktp', $id);

        $sql = $this->db->get($this->ktp);
        return $sql->result();
    }

    public function get_by_id_admin_reg($id_ref = '') {

        $this->db->select('id_ref, role_admin, path');
        $this->db->where('id_ref', $id_ref);

        $sql = $this->db->get($this->user);
        return $sql->result();
    }

    public function get_path_by_id_reg($id = '') {

        $this->db->select('path');
        $this->db->where('id_admin', $id);

        $sql = $this->db->get($this->user);
        return $sql->result();
    }

    public function count_ktp_all($id_pet = '') {

        $this->db->where('id_petugas', $id_pet);
        $sql = $this->db->get($this->ktp);
        return $sql->num_rows();
    }

    public function count_ktp_all_admin($id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 1)) {

            $this->db->where('id_admin', $id_admin);
        } elseif (!empty($id_admin) && ($role == 2)) {

            $this->db->where('id_admin', $id_admin);
        } elseif ($role == 0) {
            $this->db->where('id_admin', $id_admin);
        }

        $sql = $this->db->get($this->ktp);
        return $sql->num_rows();
    }

    public function get_detail_ktp($id = '') {

        $sql = $this->db->query("SELECT
                                    t.*
                                FROM
                                    (
                                    SELECT
                                        k.id_ktp,                                       
                                        k.id_admin,
                                        k.id_petugas,
                                        k.id_asal,
                                        k.kodepos,
                                        k.pend_terakhir,
                                        k.nik_ktp,
                                        k.email,
                                        k.nama_ktp,
                                        k.nomor_kk,
                                        k.tempat_lahir,
                                        k.tanggal_lahir,
                                        k.jenis_kelamin,
                                        k.gol_darah,
                                        k.alamat_ktp,
                                        k.rt,
                                        k.rw,
                                        k.agama,
                                        k.status_nikah,
                                        k.pekerjaan,
                                        k.nomor_hp_ktp,
                                        k.nomor_rumah_ktp,
                                        k.nomor_kantor_ktp,
                                        k.nomor_faksimili_ktp,
                                        k.tanggal_daftar,
                                        k.nik_kta_lama,
                                        k.nik_kta_baru,
                                        k.pengurus,
                                        k.kategori,
                                        k.jabatan,
                                        k.wilayah_pengurus,
                                        k.facebook,
                                        k.twitter,
                                        k.instagram,
                                        k.whatsapp,
                                        k.img,
                                        k.img_thumb,
                                        k.img_pas,
                                        k.img_pas_thumb,
                                        k.barcode,    
                                        k.status_data,
                                        p.nama_petugas,                                      
                                        wp.nama AS provinsi,
                                        wkb.nama AS kabupaten,
                                        wk.nama AS kecamatan,
                                        wd.nama AS kelurahan,
                                        DATE_FORMAT(
                                            CAST(k.tanggal_post AS DATE),
                                            '%d/%m/%Y'
                                        ) AS tanggal_post
                                    FROM
                                        ktp k                                   
                                    LEFT JOIN petugas p ON
                                        k.id_petugas = p.id_petugas
                                    LEFT JOIN wilayah_desa wd ON
                                        SUBSTRING(k.id_asal, 7, 2) = wd.id AND SUBSTRING(k.id_asal, 1, 2)  = wd.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wd.id_dati2 AND SUBSTRING(k.id_asal, 5, 2) = wd.id_dati3
                                    LEFT JOIN wilayah_kecamatan wk ON
                                        SUBSTRING(k.id_asal, 5, 2) = wk.id AND SUBSTRING(k.id_asal, 1, 2) = wk.id_dati1 AND SUBSTRING(k.id_asal, 3, 2) = wk.id_dati2
                                    LEFT JOIN wilayah_kabupaten wkb ON
                                        SUBSTRING(k.id_asal, 3, 2) = wkb.id AND SUBSTRING(k.id_asal, 1, 2) = wkb.id_dati1
                                    LEFT JOIN wilayah_provinsi wp ON
                                        SUBSTRING(k.id_asal, 1, 2) = wp.id
                                    ) t
                                WHERE
                                    t.status_data = 1 AND t.id_ktp='$id'");
        return $sql->result();
    }

}
