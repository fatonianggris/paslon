<?php

class Akunmodel extends CI_Model {

    private $table_user = 'user';
    private $table_petugas = 'petugas';

    public function get_template() {
        $sql = $this->db->query('SELECT * FROM template WHERE id_template=1');
        return $sql->result();
    }

    public function get_admin() {
        $sql = $this->db->query('SELECT * FROM user WHERE role_admin IN (1,2) ORDER BY tanggal_post DESC');
        return $sql->result();
    }

    public function get_petugas_nasional($id) {
        $sql = $this->db->query("SELECT * FROM wilayah_provinsi WHERE id='$id'");
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

    //---------------------------------------COUNT ANGGOTA KTP---------------------------------------//
    public function get_count() {
        $sql = $this->db->query("SELECT
                                    (
                                    SELECT
                                        COUNT(id_user)
                                    FROM
                                        user
                                    WHERE
                                        role_admin = 1
                                ) AS admin_prov,
                                (
                                    SELECT
                                        COUNT(id_user)
                                    FROM
                                        user
                                    WHERE
                                        role_admin = 2
                                ) AS admin_kab,
                                (
                                    SELECT
                                        COUNT(id_user)
                                    FROM
                                        user
                                    WHERE
                                        role_admin = 0
                                ) AS superadmin,
                                (
                                    SELECT
                                        COUNT(id_user)
                                    FROM
                                        user
                                ) AS all_admin,
                                (
                                    SELECT
                                        COUNT(id_petugas)
                                    FROM
                                        petugas
                                    WHERE LENGTH(id_admin)=4
                                ) AS petugas_kab,
                                (
                                    SELECT
                                        COUNT(id_petugas)
                                    FROM
                                        petugas
                                    WHERE LENGTH(id_admin)=2
                                ) AS petugas_prov");
        return $sql->result();
    }

    //---------------------------------------GET ADMIN KAB---------------------------------------//
    public function get_admin_kabupaten($id = '', $role = '') {
        if (!empty($id) && ($role == 1)) {
            $sql = $this->db->query("SELECT
                                        u.*,
                                        (
                                        SELECT
                                            COUNT(p.id_petugas)
                                        FROM
                                            petugas p
                                        WHERE
                                            p.id_admin = u.id_ref
                                    ) AS jml_pet,
                                    (
                                        SELECT
                                            COUNT(k.id_ktp)
                                        FROM
                                            ktp k
                                        WHERE
                                            k.id_admin = u.id_ref
                                    ) AS jml_ktp
                                    FROM
                                        user u
                                    WHERE
                                        u.role_admin = 2 AND SUBSTR(u.id_ref, 1, 2) = '$id'
                                    ORDER BY
                                        u.tanggal_post
                                    DESC");
        } elseif ($role == 0) {
            $sql = $this->db->query("SELECT
                                        u.*,
                                        (
                                        SELECT
                                            COUNT(p.id_petugas)
                                        FROM
                                            petugas p
                                        WHERE
                                            p.id_admin = u.id_ref
                                    ) AS jml_pet,
                                    (
                                        SELECT
                                            COUNT(k.id_ktp)
                                        FROM
                                            ktp k
                                        WHERE
                                            k.id_admin = u.id_ref
                                    ) AS jml_ktp
                                    FROM
                                        user u
                                    WHERE
                                        role_admin = 2
                                    ORDER BY
                                        tanggal_post
                                    DESC");
        }
        return $sql->result();
    }

    //---------------------------------------GET ADMIN PROV---------------------------------------//
    public function get_admin_provinsi() {
        $sql = $this->db->query("SELECT
                                    u.*,
                                    (
                                    SELECT
                                        COUNT(p.id_petugas)
                                    FROM
                                        petugas p
                                    WHERE
                                        p.id_admin = u.id_ref
                                ) AS jml_pet,
                                (
                                    SELECT
                                        COUNT(k.id_ktp)
                                    FROM
                                        ktp k
                                    WHERE
                                        k.id_admin = u.id_ref
                                ) AS jml_ktp
                                FROM
                                    user u
                                WHERE
                                    role_admin = 1
                                ORDER BY
                                    tanggal_post
                                DESC");
        return $sql->result();
    }

    //---------------------------------------GET ADMIN NAS---------------------------------------//
    public function get_admin_nasional() {
        $sql = $this->db->query("SELECT
                                    u.*,
                                    (
                                    SELECT
                                        COUNT(p.id_petugas)
                                    FROM
                                        petugas p
                                    WHERE
                                        p.id_admin = u.id_ref
                                ) AS jml_pet,
                                (
                                    SELECT
                                        COUNT(k.id_ktp)
                                    FROM
                                        ktp k
                                    WHERE
                                        k.id_admin = u.id_ref
                                ) AS jml_ktp
                                FROM
                                    user u
                                WHERE
                                    role_admin = 0
                                ORDER BY
                                    tanggal_post
                                DESC");
        return $sql->result();
    }

    //---------------------------------------GET PROV---------------------------------------//
    public function get_prov_kab($id_prov = '', $id_kab = '') {

        $sql = $this->db->query("SELECT
                                    (
                                    SELECT
                                        wp.nama
                                    FROM
                                        wilayah_provinsi wp
                                    WHERE
                                        wp.id = '$id_prov'
                                ) AS nama_provinsi,
                                (
                                    SELECT
                                        wkb.nama
                                    FROM
                                        wilayah_kabupaten wkb
                                    WHERE
                                        wkb.id = '$id_kab' AND wkb.id_dati1 = '$id_prov'
                                ) AS nama_kabupaten");

        return $sql->result();
    }

    public function get_prov($id_prov = '') {

        $sql = $this->db->query("SELECT
                                    (
                                    SELECT
                                        wp.nama
                                    FROM
                                        wilayah_provinsi wp
                                    WHERE
                                        wp.id = '$id_prov'
                                ) AS nama_provinsi");
        return $sql->result();
    }

    public function get_admin_prov() {

        $sql = $this->db->query("SELECT
                                    (
                                    SELECT
                                        wp.nama
                                    FROM
                                        wilayah_provinsi wp
                                    WHERE
                                        wp.id = '34'
                                ) AS nama_provinsi_admin");
        return $sql->result();
    }

    //--------------------------------CEK PASS ADMIN -----------------------------------------//
    public function cek_password_admin($id_admin = '', $pass = '') {

        $passwd = md5($pass);

        $this->db->where('id_user', $id_admin);
        $this->db->where('password', $passwd);

        $sql = $this->db->get($this->table_user);
        return $sql->result();
    }

    //--------------------------------UPDATE PASS ADMIN-----------------------------------------//
    public function update_password_admin($id_admin = '', $pass = '') {
        $passwd = md5($pass);
        $this->db->trans_begin();

        $data = array(
            'password' => $passwd
        );

        $this->db->where('id_user', $id_admin);
        $this->db->update($this->table_user, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function get_by_id_admin($id = '') {
        $this->db->where('id_user', $id);
        $sql = $this->db->get($this->table_user);
        return $sql->result();
    }

    public function cek_id_admin_prov($id = '') {
        $this->db->where('id_ref', $id);
        $sql = $this->db->get($this->table_user);
        return $sql->result();
    }

    public function cek_id_admin_kab($id = '') {
        $this->db->where('id_ref', $id);
        $sql = $this->db->get($this->table_user);
        return $sql->result();
    }

    public function cek_nama_admin($nama = '') {
        $this->db->where('nama_admin', $nama);
        $sql = $this->db->get($this->table_user);
        return $sql->result();
    }

    public function get_by_id_superadmin($id = '') {
        $this->db->where('id_user', $id);
        $sql = $this->db->get($this->table_user);
        return $sql->result();
    }

    public function get_provinsi() {
        $sql = $this->db->query('SELECT * FROM wilayah_provinsi');
        return $sql->result();
    }

    public function get_kabupaten() {
        $sql = $this->db->query('SELECT * FROM wilayah_kabupaten');
        return $sql->result();
    }

//---------------------------------------INSERT KAB---------------------------------------//
    public function insert_admin_kabupaten($value = '') {
        $passwd = md5($value['password_adm']);
        $this->db->trans_begin();

        $data = array(
            'nama_admin' => $value['nama_admin'],
            'role_admin' => 2,
            'email' => $value['email'],
            'nomor_hp' => $value['nomor_hp'],
            'status' => $value['status'],
            'id_ref' => $value['provinsi'] . $value['kabupaten'],
            'password' => $passwd,
            'img' => $value['pic_adm'],
            'img_thumb' => $value['pic_thumb_adm'],
            'path' => $value['path'],
            'license' => $value['license'],
            'license_exp' => $value['license_exp'],
            'create_prev' => $value['create'],
            'update_prev' => $value['update'],
            'delete_prev' => $value['delete'],
        );
        $this->db->insert($this->table_user, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function insert_petugas($value = '', $id_admin = '', $role = '') {
        $passwd = md5($value['password_pet']);
        $this->db->trans_begin();

        if (!empty($id_admin) && ($role == 2)) {

            $data = array(
                'nama_petugas' => $value['nama_petugas'],
                'id_admin' => $id_admin,
                'nomor_ktp' => $value['nomor_ktp'],
                'email_petugas' => $value['email_petugas'],
                'nomor_hp' => $value['nomor_hp_pet'],
                'alamat_petugas' => $value['alamat_petugas'],
                'kode_petugas' => $value['kode_petugas'],
                'password' => $passwd,
                'img' => $value['pic_pet'],
                'img_thumb' => $value['pic_thumb_pet']
            );
        } elseif (!empty($id_admin) && ($role == 1)) {

            $data = array(
                'nama_petugas' => $value['nama_petugas'],
                'id_admin' => $value['region_petugas'],
                'nomor_ktp' => $value['nomor_ktp'],
                'email_petugas' => $value['email_petugas'],
                'nomor_hp' => $value['nomor_hp_pet'],
                'alamat_petugas' => $value['alamat_petugas'],
                'kode_petugas' => $value['kode_petugas'],
                'password' => $passwd,
                'img' => $value['pic_pet'],
                'img_thumb' => $value['pic_thumb_pet']
            );
        } elseif ($role == 0) {

            $data = array(
                'nama_petugas' => $value['nama_petugas'],
                'id_admin' => $value['region_petugas'],
                'nomor_ktp' => $value['nomor_ktp'],
                'email_petugas' => $value['email_petugas'],
                'nomor_hp' => $value['nomor_hp_pet'],
                'alamat_petugas' => $value['alamat_petugas'],
                'kode_petugas' => $value['kode_petugas'],
                'password' => $passwd,
                'img' => $value['pic_pet'],
                'img_thumb' => $value['pic_thumb_pet']
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

//---------------------------------------INSERT PROV---------------------------------------//
    public function insert_admin_provinsi($value = '') {
        $passwd = md5($value['password_adm']);
        $this->db->trans_begin();

        $data = array(
            'nama_admin' => $value['nama_admin'],
            'role_admin' => 1,
            'email' => $value['email'],
            'nomor_hp' => $value['nomor_hp'],
            'status' => $value['status'],
            'id_ref' => $value['provinsi'],
            'password' => $passwd,
            'img' => $value['pic_adm'],
            'img_thumb' => $value['pic_thumb_adm'],
            'path' => $value['path'],
            'license' => $value['license'],
            'license_exp' => $value['license_exp'],
            'create_prev' => $value['create'],
            'update_prev' => $value['update'],
            'delete_prev' => $value['delete'],
        );
        $this->db->insert($this->table_user, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

//---------------------------------------INSERT NAS---------------------------------------//
    public function insert_admin_nasional($value = '') {
        $passwd = md5($value['password_adm']);
        $this->db->trans_begin();

        $data = array(
            'nama_admin' => $value['nama_admin'],
            'role_admin' => 0,
            'email' => $value['email'],
            'nomor_hp' => $value['nomor_hp'],
            'id_ref' => 34,
            'status' => $value['status'],
            'password' => $passwd,
            'license' => $value['license'],
            'license_exp' => $value['license_exp'],
            'path' => $value['path'],
            'img' => $value['pic_adm'],
            'img_thumb' => $value['pic_thumb_adm']
        );
        $this->db->insert($this->table_user, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

//---------------------------------------UPDATE KAB---------------------------------------//
    public function update_admin_kabupaten($id = '', $value = '') {
        $this->db->trans_begin();

        $data = array(
            'nama_admin' => $value['nama_admin'],
            'email' => $value['email'],
            'nomor_hp' => $value['nomor_hp'],
            'id_ref' => $value['provinsi'] . $value['kabupaten'],
            'status' => $value['status'],
            'img' => $value['pic'],
            'img_thumb' => $value['pic_thumb'],
            'license' => $value['license'],
            'license_exp' => $value['license_exp'],
            'create_prev' => $value['create'],
            'update_prev' => $value['update'],
            'delete_prev' => $value['delete']
        );

        $this->db->where('id_user', $id);
        $this->db->update($this->table_user, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

//---------------------------------------UPDATE PROV---------------------------------------//
    public function update_admin_provinsi($id = '', $value = '') {
        $this->db->trans_begin();

        $data = array(
            'nama_admin' => $value['nama_admin'],
            'email' => $value['email'],
            'nomor_hp' => $value['nomor_hp'],
            'id_ref' => $value['provinsi'],
            'status' => $value['status'],
            'img' => $value['pic'],
            'img_thumb' => $value['pic_thumb'],
            'license' => $value['license'],
            'license_exp' => $value['license_exp'],
            'create_prev' => $value['create'],
            'update_prev' => $value['update'],
            'delete_prev' => $value['delete']
        );

        $this->db->where('id_user', $id);
        $this->db->update($this->table_user, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

//---------------------------------------UPDATE NAS---------------------------------------//
    public function update_admin_nasional($id = '', $value = '') {
        $this->db->trans_begin();

        $data = array(
            'nama_admin' => $value['nama_admin'],
            'email' => $value['email'],
            'nomor_hp' => $value['nomor_hp'],
            'status' => $value['status'],
            'license' => $value['license'],
            'license_exp' => $value['license_exp'],
            'img' => $value['pic'],
            'img_thumb' => $value['pic_thumb']
        );

        $this->db->where('id_user', $id);
        $this->db->update($this->table_user, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function get_img_by_id_admin($id = '') {
        $this->db->select('img');
        $this->db->where('id_user', $id);
        $sql = $this->db->get($this->table_user);
        return $sql->result();
    }

    public function get_img_by_id_superadmin($id = '') {
        $this->db->select('img');
        $this->db->where('id_user', $id);
        $sql = $this->db->get($this->table_user);
        return $sql->result();
    }

    public function delete_admin($value) {
        $this->db->trans_begin();

        $this->db->where('id_user', $value);
        $this->db->delete($this->table_user);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function delete_superadmin($value) {
        $this->db->trans_begin();

        $this->db->where('id_user', $value);
        $this->db->delete($this->table_user);

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