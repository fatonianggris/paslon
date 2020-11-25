<?php

class Keloladatamodel extends CI_Model {

    private $table_ktp = 'ktp';
    private $table_user = 'user';
    private $table_petugas = 'petugas';

    //---------------------------------------COUNT ANGGOTA KTP---------------------------------------//
    public function get_count_ktp($id_admin = '', $role = '') {

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

    //---------------------------------------GET ANGGOTA--------------------------------------------------//
    public function get_ktp($id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            p.id_ktp,
                                            p.nik_kta_baru,
                                            p.id_asal,
                                            p.id_admin,                                            
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
                                        LEFT JOIN petugas pt ON
                                            p.id_petugas = pt.id_petugas AND p.id_admin = p.id_admin AND p.status_data = 1 AND pt.status_data = 1 AND pt.id_admin = p.id_admin
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTR(p.id_admin, 3, 2) = wkb.id AND SUBSTR(p.id_admin, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTR(p.id_admin, 1, 2) = wp.id
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
                                            p.nik_kta_baru,
                                            p.id_asal,
                                            p.id_admin,                                           
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
                                        LEFT JOIN petugas pt ON
                                            p.id_petugas = pt.id_petugas AND p.id_admin = p.id_admin AND p.status_data = 1 AND pt.status_data = 1 AND pt.id_admin = p.id_admin
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTR(p.id_admin, 3, 2) = wkb.id AND SUBSTR(p.id_admin, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTR(p.id_admin, 1, 2) = wp.id
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
                                            p.nik_kta_baru,
                                            p.id_asal,
                                            p.id_admin,                                         
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
                                        LEFT JOIN petugas pt ON
                                            p.id_petugas = pt.id_petugas AND p.id_admin = p.id_admin AND pt.id_admin = p.id_admin
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTR(p.id_admin, 3, 2) = wkb.id AND SUBSTR(p.id_admin, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTR(p.id_admin, 1, 2) = wp.id
                                    ) t                                   
                                    ORDER BY
                                        t.tanggal_post
                                    DESC");
        }
        return $sql->result();
    }

    //---------------------------------------UBAH STATUS ANGGOTA--------------------------------------------------//
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

    public function get_img_by_id_ktp($id = '', $id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $this->db->select('img, id_admin');
            $this->db->where('id_ktp', $id);
            $this->db->where('id_admin', $id_admin);
        } elseif (!empty($id_admin) && ($role == 1)) {

            $this->db->select('img, id_admin');
            $this->db->where('id_ktp', $id);
            $this->db->like('id_admin', $id_admin);
        } elseif ($role == 0) {

            $this->db->select('img, id_admin');
            $this->db->where('id_ktp', $id);
        }

        $sql = $this->db->get($this->table_ktp);
        return $sql->result();
    }

    //---------------------------------------DELETE ANGGOTA--------------------------------------------------//
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

    public function get_path_by_id_reg($id = '', $id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $this->db->select('path');
            $this->db->where('id_admin', $id);
        } elseif (!empty($id_admin) && ($role == 1)) {

            $this->db->select('path');
            $this->db->like('id_admin', $id);
        } elseif ($role == 0) {

            $this->db->select('path');
            $this->db->where('id_admin', $id);
        }

        $sql = $this->db->get($this->table_user);
        return $sql->result();
    }

    public function get_petugas_ktp($id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        id_petugas,
                                        nama_petugas
                                    FROM
                                        petugas
                                    WHERE
                                        id_admin = '$id_admin' AND status_data = 1");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT
                                        id_petugas,
                                        nama_petugas
                                    FROM
                                        petugas
                                    WHERE
                                        id_admin LIKE '$id_admin%' AND status_data = 1");
        } elseif ($role == 0) {

            $sql = $this->db->query("SELECT
                                        id_petugas,
                                        nama_petugas
                                    FROM
                                        petugas
                                        ");
        }

        return $sql->result();
    }

    //-------------------------------------------------------------------------------//

    public function get_count_reg($id_admin = '', $role = '') {

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

    //------------------------------------GET PETUGAS------------------------------------------------//

    public function get_count_pet($id_admin = '', $role = '') {

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

    public function get_petugas_pet($id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT DISTINCT
                                            p.id_petugas,
                                            p.id_admin,
                                            p.nama_petugas,
                                            p.nomor_hp,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
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
                                                k.id_petugas = p.id_petugas AND k.status_data = 1 AND k.id_admin = p.id_admin
                                        ) AS jml_ktp,
                                        p.status_data,
                                        p.tanggal_post
                                    FROM
                                        petugas p
                                    LEFT JOIN wilayah_kabupaten wkb ON
                                        SUBSTR(p.id_admin, 3, 2) = wkb.id AND SUBSTR(p.id_admin, 1, 2) = wkb.id_dati1
                                    LEFT JOIN wilayah_provinsi wp ON
                                        SUBSTR(p.id_admin, 1, 2) = wp.id
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
                                        SELECT DISTINCT
                                            p.id_petugas,
                                            p.id_admin,
                                            p.nama_petugas,
                                            p.nomor_hp,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
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
                                                k.id_petugas = p.id_petugas AND k.status_data = 1 AND k.id_admin = p.id_admin
                                        ) AS jml_ktp,
                                        p.status_data,
                                        p.tanggal_post
                                    FROM
                                        petugas p
                                    LEFT JOIN wilayah_kabupaten wkb ON
                                        SUBSTR(p.id_admin, 3, 2) = wkb.id AND SUBSTR(p.id_admin, 1, 2) = wkb.id_dati1
                                    LEFT JOIN wilayah_provinsi wp ON
                                        SUBSTR(p.id_admin, 1, 2) = wp.id
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
                                        SELECT DISTINCT
                                            p.id_petugas,
                                            p.id_admin,
                                            p.nama_petugas,
                                            p.nomor_hp,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
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
                                                k.id_petugas = p.id_petugas AND k.status_data = 1 AND k.id_admin = p.id_admin
                                        ) AS jml_ktp,
                                        p.status_data,
                                        p.tanggal_post
                                    FROM
                                        petugas p
                                    LEFT JOIN wilayah_kabupaten wkb ON
                                        SUBSTR(p.id_admin, 3, 2) = wkb.id AND SUBSTR(p.id_admin, 1, 2) = wkb.id_dati1
                                    LEFT JOIN wilayah_provinsi wp ON
                                        SUBSTR(p.id_admin, 1, 2) = wp.id
                                    ) t                                   
                                    ORDER BY
                                        t.tanggal_post
                                    DESC");
        }

        return $sql->result();
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

    public function ubah_status_ktp_pet($id = '') {
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

    //--------------------------------------------------------------------------------------//

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

}

?>