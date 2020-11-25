<?php

class Mutasimodel extends CI_Model {

    private $table_mutasi = 'mutasi';
    private $table_ktp = 'ktp';
    private $table_user = 'user';

    public function get_by_id_ktp($id = '') {
        $this->db->where('id_ktp', $id);
        $sql = $this->db->get($this->table_ktp);
        return $sql->result();
    }

    public function get_ktp_mutasi($id = '') {

        $this->db->select('*');
        $this->db->where('id_ktp', $id);
        $sql = $this->db->get($this->table_ktp);
        return $sql->result();
    }

    public function get_id_mutasi($id = '') {

        $this->db->select('*');
        $this->db->where('id_mutasi', $id);
        $sql = $this->db->get($this->table_mutasi);
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


    public function insert_mutasi($value = '') {

        $this->db->trans_begin();

        $data = array(
            'id_anggota' => $value['id_anggota'],
            'id_admin' => $value['id_admin'],
            'id_region_asal' => $value['id_region_asal'],
            'id_region_tujuan' => $value['id_region_tujuan'],
            'nama_anggota' => $value['nama_anggota'],
            'nik_ktp' => $value['nik_ktp'],
            'nomor_hp' => $value['nomor_hp'],
            'keterangan' => $value['keterangan'],
            'status_pengurus' => $value['status_pengurus'],
            'status_mutasi' => $value['status_mutasi'],
            'no_kta_lama' => $value['no_kta_lama'],
            'tgl_pengajuan_mutasi' => $value['tgl_pengajuan_mutasi'],
            'status_data' => 1
        );

        $this->db->insert($this->table_mutasi, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function update_mutasi($id = '', $value = '') {
        $this->db->trans_begin();

        $data = array(
            'id_region_tujuan' => $value['id_region_tujuan'],
            'keterangan' => $value['keterangan']
        );

        $this->db->where('id_mutasi', $id);
        $this->db->update($this->table_mutasi, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function update_status_ktp($id = '', $value = '') {
        $this->db->trans_begin();

        $data = array(
            'id_admin' => $value['id_regional_tujuan'],
            'nik_kta_lama' => $value['nik_kta_lama'],
            'nik_kta_baru' => $value['nik_kta_baru'],
            'pengurus' => $value['pengurus'],
            'id_petugas' => $value['id_petugas'],
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

    public function update_status_mutasi_masuk($id = '', $value = '') {
        $this->db->trans_begin();

        $data = array(
            'no_kta_baru' => $value['nik_kta_baru'],
            'status_mutasi' => 2
        );

        $this->db->where('id_mutasi', $id);
        $this->db->update($this->table_mutasi, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function update_status_mutasi_true($id = '') {
        $this->db->trans_begin();

        $data = array(
            'status_mutasi' => 1,
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

    public function update_status_mutasi_false($id = '') {
        $this->db->trans_begin();

        $data = array(
            'status_mutasi' => '',
            'kategori' => '',
            'jabatan' => '',
            'wilayah' => '',
            
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

    public function delete_mutasi_keluar($value) {
        $this->db->trans_begin();

        $this->db->where('id_mutasi', $value);
        $this->db->delete($this->table_mutasi);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function get_by_id_admin_reg($id_ref = '') {

        $this->db->select('id_ref, role_admin, path');
        $this->db->where('id_ref', $id_ref);

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

    public function get_admin_regional($id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 1)) {

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
        } elseif (!empty($id_admin) && ($role == 2)) {

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

    public function get_mutasi_keluar($id_admin = '', $role = '') {



        $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            m.*,
                                            wpasl.nama AS provinsi_asal,
                                            wkbasl.nama AS kabupaten_asal,
                                            wptj.nama AS provinsi_tujuan,
                                            wkbtj.nama AS kabupaten_tujuan
                                        FROM
                                            mutasi m
                                        LEFT JOIN wilayah_kabupaten wkbtj ON
                                            SUBSTR(m.id_region_tujuan, 3, 2) = wkbtj.id AND SUBSTR(m.id_region_tujuan, 1, 2) = wkbtj.id_dati1
                                        LEFT JOIN wilayah_provinsi wptj ON
                                            SUBSTR(m.id_region_tujuan, 1, 2) = wptj.id
                                        LEFT JOIN wilayah_kabupaten wkbasl ON
                                            SUBSTR(m.id_region_asal, 3, 2) = wkbasl.id AND SUBSTR(m.id_region_asal, 1, 2) = wkbasl.id_dati1
                                        LEFT JOIN wilayah_provinsi wpasl ON
                                            SUBSTR(m.id_region_asal, 1, 2) = wpasl.id
                                    ) t
                                    WHERE
                                        t.id_region_asal = '$id_admin'
                                    ORDER BY
                                        t.tgl_pengajuan_mutasi
                                    DESC");

        return $sql->result();
    }

    public function get_mutasi_masuk($id_admin = '', $role = '') {


        $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            m.*,
                                            wpasl.nama AS provinsi_asal,
                                            wkbasl.nama AS kabupaten_asal,
                                            wptj.nama AS provinsi_tujuan,
                                            wkbtj.nama AS kabupaten_tujuan
                                        FROM
                                            mutasi m
                                        LEFT JOIN wilayah_kabupaten wkbtj ON
                                            SUBSTR(m.id_region_tujuan, 3, 2) = wkbtj.id AND SUBSTR(m.id_region_tujuan, 1, 2) = wkbtj.id_dati1
                                        LEFT JOIN wilayah_provinsi wptj ON
                                            SUBSTR(m.id_region_tujuan, 1, 2) = wptj.id
                                        LEFT JOIN wilayah_kabupaten wkbasl ON
                                            SUBSTR(m.id_region_asal, 3, 2) = wkbasl.id AND SUBSTR(m.id_region_asal, 1, 2) = wkbasl.id_dati1
                                        LEFT JOIN wilayah_provinsi wpasl ON
                                            SUBSTR(m.id_region_asal, 1, 2) = wpasl.id
                                    ) t
                                    WHERE
                                        t.id_region_tujuan = '$id_admin'
                                    ORDER BY
                                        t.tgl_pengajuan_mutasi
                                    DESC");

        return $sql->result();
    }

///------------------------------------------------------------------------------------------//

    public function get_count() {
        $sql = $this->db->query('select (select count(id_user) from user where role_admin = 1) as admin_prov, (select count(id_user) from user where role_admin = 2 ) as admin_kab, (select count(id_user) from user where role_admin = 0) as superadmin, (select count(id_user) from user) as all_admin, (select count(id_petugas) from petugas) as petugas');
        return $sql->result();
    }

}

?>