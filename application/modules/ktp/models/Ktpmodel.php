<?php

class Ktpmodel extends CI_Model {

    private $table_ktp = 'ktp';
    private $table_user = 'user';
    private $table_petugas = 'petugas';
    private $_batchImport;

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

    //---------------------------------------SET INDEX ANGGOTA---------------------------------------//

    public function get_petugas($id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        id_petugas,
                                        id_admin,
                                        nama_petugas
                                    FROM
                                        petugas
                                    WHERE
                                        id_admin = '$id_admin' AND status_data = 1");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT
                                        id_petugas,
                                        id_admin,
                                        nama_petugas
                                    FROM
                                        petugas
                                    WHERE
                                        id_admin LIKE '$id_admin%' AND status_data = 1");
        } elseif ($role == 0) {

            $sql = $this->db->query("SELECT
                                        id_petugas,
                                        id_admin,
                                        nama_petugas
                                    FROM
                                        petugas");
        }

        return $sql->result();
    }

    public function get_petugas_admin($id_admin = '') {


        $sql = $this->db->query("SELECT
                                        id_petugas,
                                        id_admin,
                                        nama_petugas
                                    FROM
                                        petugas
                                    WHERE
                                        id_admin = '$id_admin' AND status_data = 1");
        return $sql->result();
    }

    public function get_admin_mutasi($id_admin = '', $role = '') {

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
                                WHERE NOT
                                    t.id_ref = '$id_admin'
                                ORDER BY
                                    t.tanggal_post ASC");

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
                                            u.status_data,
                                            u.tanggal_post
                                        FROM
                                            user u
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTR(u.id_ref, 3, 2) = wkb.id AND SUBSTR(u.id_ref, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTR(u.id_ref, 1, 2) = wp.id
                                    ) t
                                    WHERE
                                        t.id_ref = '$id_admin' AND t.status_data='1'
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
                                             u.status_data,
                                            u.tanggal_post
                                        FROM
                                            user u
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTR(u.id_ref, 3, 2) = wkb.id AND SUBSTR(u.id_ref, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTR(u.id_ref, 1, 2) = wp.id
                                    ) t
                                    WHERE
                                        t.id_ref LIKE '$id_admin%' AND t.status_data='1'
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
                                            u.status_data,
                                            u.tanggal_post
                                        FROM
                                            user u
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTR(u.id_ref, 3, 2) = wkb.id AND SUBSTR(u.id_ref, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTR(u.id_ref, 1, 2) = wp.id
                                    ) t     
                                    WHERE
                                        t.status_data='1'
                                    ORDER BY
                                        t.tanggal_post");
        }

        return $sql->result();
    }

    public function get_petugas_reg($id_regional = '', $id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        p.id_petugas,
                                        p.nama_petugas,
                                        p.id_admin,
                                        p.tanggal_post
                                    FROM
                                        petugas p
                                    WHERE
                                        p.id_admin = '$id_regional' AND p.status_data = 1
                                    ORDER BY
                                        p.tanggal_post");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT
                                        p.id_petugas,
                                        p.nama_petugas,
                                        p.id_admin,
                                        p.tanggal_post
                                    FROM
                                        petugas p
                                    WHERE
                                        p.id_admin LIKE '$id_regional%' AND p.status_data = 1
                                    ORDER BY
                                        p.tanggal_post");
        } elseif ($role == 0) {

            $sql = $this->db->query("SELECT
                                        p.id_petugas,
                                        p.nama_petugas,
                                        p.id_admin,
                                        p.tanggal_post
                                    FROM
                                        petugas p  
                                    WHERE
                                        p.id_admin LIKE '$id_regional%'
                                    ORDER BY
                                        p.tanggal_post");
        }

        return $sql->result();
    }

    //---------------------------------------LIHAT ANGGOTA KTP---------------------------------------//
    public function get_by_id_pet($id = '', $id_admin = '', $role = '') {

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

    public function get_by_id_admin($id = '') {

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
                                        t.id_ref = '$id'
                                    ORDER BY
                                        t.tanggal_post");
        return $sql->result();
    }

    public function get_count_pet($id = '', $id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        (
                                        SELECT
                                            COUNT(id_ktp)
                                        FROM
                                            ktp
                                        WHERE
                                            id_admin = '$id_admin' AND id_petugas = '$id' AND status_data = 1
                                    ) AS ktp,
                                    (
                                        SELECT
                                            COUNT(nik_ktp) - COUNT(DISTINCT nik_ktp)
                                        FROM
                                            ktp
                                        WHERE
                                            id_admin = '$id_admin' AND status_data = 1 AND id_petugas = '$id'
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
                                            id_admin LIKE '$id_admin%' AND id_petugas = '$id' AND status_data = 1
                                    ) AS ktp,
                                    (
                                        SELECT
                                            COUNT(nik_ktp) - COUNT(DISTINCT nik_ktp)
                                        FROM
                                            ktp
                                        WHERE
                                            id_admin LIKE '$id_admin%' AND status_data = 1 AND id_petugas = '$id'
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
                                        WHERE
                                           id_petugas = '$id'
                                    ) AS ktp,
                                    (
                                        SELECT
                                            COUNT(nik_ktp) - COUNT(DISTINCT nik_ktp)
                                        FROM
                                            ktp
                                        WHERE
                                            id_petugas = '$id'
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

    public function get_count_reg($id = '', $id_admin = '', $role = '') {

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
                                            COUNT(id_ref)
                                        FROM
                                            user
                                        WHERE
                                            id_ref = '$id_admin'
                                    ) AS user,
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
                                            COUNT(id_ref)
                                        FROM
                                            user
                                        WHERE
                                            id_ref LIKE '$id_admin%'
                                    ) AS user,
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
                                            COUNT(id_ref)
                                        FROM
                                            user
                                        
                                    ) AS user,
                                    (
                                        SELECT
                                            COUNT(id_petugas)
                                        FROM
                                            petugas
                                        
                                    ) AS petugas");
        }
        return $sql->result();
    }

    //---------------------------------------DETAIL ANGGOTA KTP---------------------------------------//

    public function get_detail_ktp($id = '', $id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            k.*,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            p.nama_petugas
                                        FROM
                                            ktp k
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTR(k.id_admin, 3, 2) = wkb.id AND SUBSTR(k.id_admin, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTR(k.id_admin, 1, 2) = wp.id
                                        LEFT JOIN petugas p ON
                                            p.id_petugas = p.id_petugas
                                    ) t
                                    WHERE
                                        t.id_admin = '$id_admin' AND t.id_ktp = '$id'");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            k.*,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            p.nama_petugas
                                        FROM
                                            ktp k
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTR(k.id_admin, 3, 2) = wkb.id AND SUBSTR(k.id_admin, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTR(k.id_admin, 1, 2) = wp.id
                                        LEFT JOIN petugas p ON
                                            p.id_petugas = p.id_petugas
                                    ) t
                                    WHERE
                                        t.id_admin LIKE '$id_admin%' AND t.id_ktp = '$id'");
        } elseif ($role == 0) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            k.*,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            p.nama_petugas
                                        FROM
                                            ktp k
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTR(k.id_admin, 3, 2) = wkb.id AND SUBSTR(k.id_admin, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTR(k.id_admin, 1, 2) = wp.id
                                        LEFT JOIN petugas p ON
                                            p.id_petugas = p.id_petugas
                                    ) t
                                    WHERE
                                        t.id_ktp = '$id'");
        }
        return $sql->result();
    }

    //---------------------------------------EDIT DATA ANGGOTA---------------------------------------//

    public function update_ktp($id = '', $value = '', $id_admin = '', $role = '') {
        $this->db->trans_begin();

        $data = array(
            'id_admin' => $value['region_anggota'],
            'id_petugas' => $value['nama_petugas'],
            'id_asal' => $value['provinsi'] . $value['kabupaten'] . $value['kecamatan'] . $value['kelurahan'],
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
            'tanggal_daftar' => $value['tanggal_daftar'],
            'nik_kta_lama' => $value['nik_kta_lama'],
            'pengurus' => $value['pengurus'],
            'kategori' => @$value['kategori'],
            'jabatan' => @$value['jabatan'],
            'wilayah_pengurus' => @$value['provinsi_peng'] . @$value['kabupaten_peng'] . @$value['kecamatan_peng'] . @$value['kelurahan_peng'],
            'facebook' => $value['facebook'],
            'twitter' => $value['twitter'],
            'instagram' => $value['instagram'],
            'whatsapp' => $value['whatsapp']
        );

        $this->db->where('id_ktp', $id);
        $this->db->update($this->table_ktp, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //---------------------------------------ZIP DATA ANGGOTA---------------------------------------//

    public function get_path_by_id_reg($id = '') {

        $this->db->select('path, nama_admin');
        $this->db->where('id_ref', $id);

        $sql = $this->db->get($this->table_user);
        return $sql->result();
    }

    public function get_path_by_id_admin($id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                    *
                                FROM
                                    user
                                WHERE
                                    id_ref = '$id_admin'");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT
                                    *
                                FROM
                                    user
                                WHERE
                                    id_ref LIKE '$id_admin%'");
        } elseif ($role == 0) {

            $sql = $this->db->query("SELECT
                                    *
                                FROM
                                    user
                                WHERE
                                    id_ref = '$id_admin'");
        }
        return $sql->result();
    }

//---------------------------------------GET ANGGOTA KTP---------------------------------------//
    public function get_by_id_ktp($id = '', $id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $this->db->where('id_ktp', $id);
            $this->db->where('id_admin', $id_admin);
        } elseif (!empty($id_admin) && ($role == 1)) {

            $this->db->where('id_ktp', $id);
            $this->db->like('id_admin', $id_admin);
        } elseif ($role == 0) {

            $this->db->where('id_ktp', $id);
        }

        $sql = $this->db->get($this->table_ktp);
        return $sql->result();
    }

    //---------------------------------------SET KIRIM DATA ANGGOTA---------------------------------------//

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

    public function get_by_id_admin_reg($id_admin = '') {

        $this->db->select('id_ref, role_admin, path');
        $this->db->where('id_ref', $id_admin);
        $this->db->where('status_data', 1);

        $sql = $this->db->get($this->table_user);
        return $sql->result();
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

    public function insert_ktp($value = '', $id_admin = '') {
        $this->db->trans_begin();

        $data = array(
            'id_admin' => $id_admin,
            'id_petugas' => $value['nama_petugas'],
            'id_asal' => $value['provinsi'] . $value['kabupaten'] . $value['kecamatan'] . $value['kelurahan'],
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
            'kategori' => @$value['kategori'],
            'jabatan' => @$value['jabatan'],
            'wilayah_pengurus' => @$value['provinsi_peng'] . @$value['kabupaten_peng'] . @$value['kecamatan_peng'] . @$value['kelurahan_peng'],
            'facebook' => $value['facebook'],
            'twitter' => $value['twitter'],
            'instagram' => $value['instagram'],
            'whatsapp' => $value['whatsapp']
        );

        $this->db->insert($this->table_ktp, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //---------------------------------------EXPORT DATA LAPORAN---------------------------------------//

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
                                            p.id_petugas,
                                            wp.nama AS provinsi,
                                            wk.nama AS kabupaten,
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
                                            wp.id = SUBSTRING(p.id_admin, 1, 2)
                                        LEFT JOIN wilayah_kabupaten wk ON
                                            wk.id = SUBSTRING(p.id_admin, 3, 2) AND wk.id_dati1 = SUBSTRING(p.id_admin, 1, 2)
                                    ) t
                                    WHERE
                                        t.id_asal = '$id_asal' AND t.status_data = 1
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
                                            p.id_petugas,
                                            wp.nama AS provinsi,
                                            wk.nama AS kabupaten,
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
                                            wp.id = SUBSTRING(p.id_admin, 1, 2)
                                        LEFT JOIN wilayah_kabupaten wk ON
                                            wk.id = SUBSTRING(p.id_admin, 3, 2) AND wk.id_dati1 = SUBSTRING(p.id_admin, 1, 2)
                                    ) t
                                    WHERE
                                        t.id_asal = '$id_asal' AND t.status_data = 1
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
                                            p.id_petugas,
                                            wp.nama AS provinsi,
                                            wk.nama AS kabupaten,
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
                                            wp.id = SUBSTRING(p.id_admin, 1, 2)
                                        LEFT JOIN wilayah_kabupaten wk ON
                                            wk.id = SUBSTRING(p.id_admin, 3, 2) AND wk.id_dati1 = SUBSTRING(p.id_admin, 1, 2)
                                    ) t
                                    WHERE
                                        t.id_asal = '$id_asal'
                                    ORDER BY
                                        t.tanggal_post
                                    DESC");
        }
        return $sql->result_array();
    }

    public function get_penerbit_prov($id_ref = '') {

        $sql = $this->db->query("SELECT 
                                    code,
                                    nama
                                FROM
                                    wilayah_provinsi
                                WHERE
                                    id = '$id_ref'");
        return $sql->result();
    }

    public function get_penerbit_kab($id_ref = '') {

        $sql = $this->db->query("SELECT 
                                        code,
                                        nama
                                FROM
                                    wilayah_kabupaten
                                WHERE
                                    id = SUBSTRING('$id_ref', 3, 2) AND id_dati1 = SUBSTRING('$id_ref', 1, 2)");
        return $sql->result();
    }

    //---------------------------------------EXPORT ALL EXCEL---------------------------------------//

    public function get_all_ktp($id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            p.id_ktp,
                                            p.id_admin,                                            
                                            p.nik_kta_baru,
                                            p.id_petugas,       
                                            pt.nama_petugas,
                                            wp.nama as provinsi,
                                            wkb.nama as kabupaten,
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
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTR(p.id_admin, 3, 2) = wkb.id AND SUBSTR(p.id_admin, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTR(p.id_admin, 1, 2) = wp.id
                                        LEFT JOIN petugas pt ON
                                            p.id_petugas = pt.id_petugas AND p.id_admin = p.id_admin AND p.status_data = 1 AND pt.status_data = 1 AND pt.id_admin = p.id_admin
                                    ) t
                                    WHERE
                                        t.id_admin = '$id_admin' AND t.status_data = 1
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
                                            p.id_admin,                                            
                                            p.nik_kta_baru,
                                            p.id_petugas,       
                                            pt.nama_petugas,
                                            wp.nama as provinsi,
                                            wkb.nama as kabupaten,
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
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTR(p.id_admin, 3, 2) = wkb.id AND SUBSTR(p.id_admin, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTR(p.id_admin, 1, 2) = wp.id
                                        LEFT JOIN petugas pt ON
                                            p.id_petugas = pt.id_petugas AND p.id_admin = p.id_admin AND p.status_data = 1 AND pt.status_data = 1 AND pt.id_admin = p.id_admin
                                    ) t
                                    WHERE
                                        t.id_admin LIKE '$id_admin%' AND t.status_data = 1
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
                                            p.id_admin,                                           
                                            p.nik_kta_baru,
                                            p.id_petugas,       
                                            pt.nama_petugas,
                                            wp.nama as provinsi,
                                            wkb.nama as kabupaten,
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
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTR(p.id_admin, 3, 2) = wkb.id AND SUBSTR(p.id_admin, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTR(p.id_admin, 1, 2) = wp.id
                                        LEFT JOIN petugas pt ON
                                            p.id_petugas = pt.id_petugas AND p.id_admin = p.id_admin AND p.status_data = 1 AND pt.status_data = 1 AND pt.id_admin = p.id_admin
                                    ) t
                                    WHERE
                                        t.status_data = 1
                                    ORDER BY
                                        t.tanggal_post
                                    DESC");
        }
        return $sql->result_array();
    }

    public function get_all_ktp_pet($id = '', $id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            p.id_ktp,
                                            p.id_admin,
                                            p.nik_kta_baru,
                                            p.id_asal,
                                            p.id_petugas,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            pt.nama_petugas,
                                            p.nik_ktp,
                                            p.nama_ktp,
                                            p.tempat_lahir,
                                            p.tanggal_lahir,
                                            p.jenis_kelamin,
                                            p.gol_darah,
                                            p.rt,
                                            p.rw,
                                            p.alamat_ktp,
                                            p.agama,
                                            p.status_nikah,
                                            p.pekerjaan,
                                            p.nomor_hp_ktp,
                                            p.img,
                                            p.img_thumb,
                                            p.status_data,
                                            p.tanggal_post
                                        FROM
                                            ktp p
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTR(p.id_admin, 3, 2) = wkb.id AND SUBSTR(p.id_admin, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTR(p.id_admin, 1, 2) = wp.id
                                        LEFT JOIN petugas pt ON
                                            p.id_petugas = pt.id_petugas AND p.id_admin = p.id_admin AND p.status_data = 1 AND pt.status_data = 1 AND pt.id_admin = p.id_admin
                                    ) t
                                    WHERE
                                        t.status_data = 1 AND t.id_admin = '$id_admin' AND t.id_petugas = '$id'
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
                                            p.id_admin,
                                            p.nik_kta_baru,
                                            p.id_asal,
                                            p.id_petugas,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            pt.nama_petugas,
                                            p.nik_ktp,
                                            p.nama_ktp,
                                            p.tempat_lahir,
                                            p.tanggal_lahir,
                                            p.jenis_kelamin,
                                            p.gol_darah,
                                            p.rt,
                                            p.rw,
                                            p.alamat_ktp,
                                            p.agama,
                                            p.status_nikah,
                                            p.pekerjaan,
                                            p.nomor_hp_ktp,
                                            p.img,
                                            p.img_thumb,
                                            p.status_data,
                                            p.tanggal_post
                                        FROM
                                            ktp p
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTR(p.id_admin, 3, 2) = wkb.id AND SUBSTR(p.id_admin, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTR(p.id_admin, 1, 2) = wp.id
                                        LEFT JOIN petugas pt ON
                                            p.id_petugas = pt.id_petugas AND p.id_admin = p.id_admin AND p.status_data = 1 AND pt.status_data = 1 AND pt.id_admin = p.id_admin
                                    ) t
                                    WHERE
                                        t.status_data = 1 AND t.id_admin LIKE '$id_admin%' AND t.id_petugas = '$id'
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
                                            p.id_admin,
                                            p.nik_kta_baru,
                                            p.id_asal,
                                            p.id_petugas,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            pt.nama_petugas,
                                            p.nik_ktp,
                                            p.nama_ktp,
                                            p.tempat_lahir,
                                            p.tanggal_lahir,
                                            p.jenis_kelamin,
                                            p.gol_darah,
                                            p.rt,
                                            p.rw,
                                            p.alamat_ktp,
                                            p.agama,
                                            p.status_nikah,
                                            p.pekerjaan,
                                            p.nomor_hp_ktp,
                                            p.img,
                                            p.img_thumb,
                                            p.status_data,
                                            p.tanggal_post
                                        FROM
                                            ktp p
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTR(p.id_admin, 3, 2) = wkb.id AND SUBSTR(p.id_admin, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTR(p.id_admin, 1, 2) = wp.id
                                        LEFT JOIN petugas pt ON
                                            p.id_petugas = pt.id_petugas AND p.id_admin = p.id_admin AND p.status_data = 1 AND pt.status_data = 1 AND pt.id_admin = p.id_admin
                                    ) t
                                    WHERE
                                        t.status_data = 1 AND t.id_petugas = '$id'
                                    ORDER BY
                                        t.tanggal_post
                                    DESC");
        }
        return $sql->result_array();
    }

    public function get_all_ktp_admin($id = '', $id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            p.id_ktp,
                                            p.id_admin,
                                            p.nik_kta_baru,
                                            p.id_asal,                                         
                                            p.id_petugas,
                                            pt.nama_petugas,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
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
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTR(p.id_admin, 3, 2) = wkb.id AND SUBSTR(p.id_admin, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTR(p.id_admin, 1, 2) = wp.id
                                        LEFT JOIN petugas pt ON
                                            p.id_petugas = pt.id_petugas AND p.id_admin = p.id_admin AND p.status_data = 1 AND pt.status_data = 1 AND pt.id_admin = p.id_admin
                                    ) t
                                    WHERE
                                        t.status_data = 1 AND t.id_admin = '$id'
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
                                            p.id_admin,
                                            p.nik_kta_baru,
                                            p.id_asal,                                            
                                            p.id_petugas,
                                            pt.nama_petugas,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
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
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTR(p.id_admin, 3, 2) = wkb.id AND SUBSTR(p.id_admin, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTR(p.id_admin, 1, 2) = wp.id
                                        LEFT JOIN petugas pt ON
                                            p.id_petugas = pt.id_petugas AND p.id_admin = p.id_admin AND p.status_data = 1 AND pt.status_data = 1 AND pt.id_admin = p.id_admin
                                    ) t
                                    WHERE
                                        t.status_data = 1 AND t.id_admin LIKE '$id%'
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
                                            p.id_admin,
                                            p.nik_kta_baru,
                                            p.id_asal,                                           
                                            p.id_petugas,
                                            pt.nama_petugas,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
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
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTR(p.id_admin, 3, 2) = wkb.id AND SUBSTR(p.id_admin, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTR(p.id_admin, 1, 2) = wp.id
                                        LEFT JOIN petugas pt ON
                                            p.id_petugas = pt.id_petugas AND p.id_admin = p.id_admin AND p.status_data = 1 AND pt.status_data = 1 AND pt.id_admin = p.id_admin
                                    ) t
                                    WHERE
                                        t.status_data = 1 AND t.id_admin LIKE '$id%'
                                    ORDER BY
                                        t.tanggal_post
                                    DESC");
        }
        return $sql->result_array();
    }

    public function get_pekerjaan() {
        $sql = $this->db->query("SELECT * FROM pekerjaan");
        return $sql->result();
    }

    //---------------------------------------GET ANGGOTA ADMIN---------------------------------------//

    public function get_admin_by_id($id = '') {
        $sql = $this->db->query("SELECT
                                    *
                                FROM
                                    user
                                WHERE
                                    id_ref = '$id'
                                ORDER BY
                                    tanggal_post
                                DESC
                                    ");
        return $sql->result();
    }

    public function get_admin_count($id = '') {
        $sql = $this->db->query("SELECT
                                    (
                                    SELECT
                                        COUNT(r.id_ref)
                                    FROM
                                        user r
                                    WHERE
                                        r.id_ref LIKE '$id%'
                                ) AS jml_reg,
                                (
                                    SELECT
                                        COUNT(k.id_ktp)
                                    FROM
                                        ktp k
                                    WHERE
                                        k.id_admin LIKE '$id%'
                                ) AS jml_ktp");
        return $sql->result();
    }

    //---------------------------------------DELETE ANGGOTA---------------------------------------//

    public function get_img_by_id_ktp($id = '', $id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $this->db->select('img, id_admin, img_pas, barcode');
            $this->db->where('id_ktp', $id);
            $this->db->where('id_admin', $id_admin);
        } elseif (!empty($id_admin) && ($role == 1)) {

            $this->db->select('img, id_admin, img_pas, barcode');
            $this->db->where('id_ktp', $id);
            $this->db->like('id_admin', $id_admin);
        } elseif ($role == 0) {

            $this->db->select('img, id_admin, img_pas, barcode');
            $this->db->where('id_ktp', $id);
        }

        $sql = $this->db->get($this->table_ktp);
        return $sql->result();
    }

    public function delete_ktp($value = '', $id_admin = '', $role = '') {
        $this->db->trans_begin();

        $data = array(
            'status_data' => 0
        );

        if (!empty($id_admin) && ($role == 2)) {

            $this->db->where('id_ktp', $value);
            $this->db->where('id_admin', $id_admin);
            $this->db->update($this->table_ktp, $data);
        } elseif (!empty($id_admin) && ($role == 1)) {

            $this->db->where('id_ktp', $value);
            $this->db->like('id_admin', $id_admin);
            $this->db->update($this->table_ktp, $data);
        } elseif ($role == 0) {

            $this->db->where('id_ktp', $value);
            $this->db->delete($this->table_ktp);
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //---------------------------------------UBAH STATUS ANGGOTA---------------------------------------// 

    public function ubah_status_ktp($id = '', $status = '') {
        $this->db->trans_begin();

        $data = array(
            'status_data' => $status
        );

        $this->db->where('id_ktp', $id);
        $this->db->update($this->table_ktp, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //---------------------------------------GET AJAX ANGGOTA---------------------------------------// 

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

    //---------------------------------------METHOD UMUM---------------------------------------// 

    public function setBatchImport($batchImport) {
        $this->_batchImport = $batchImport;
    }

    public function importData() {
        $data = $this->_batchImport;
        $this->db->insert_batch($this->table_ktp, $data);
    }

    public function get_nik($nik = '') {

        $this->db->where('nik_ktp', $nik);

        $sql = $this->db->get($this->table_ktp);
        return $sql->result();
    }

}

?>