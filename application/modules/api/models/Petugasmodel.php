<?php

class Petugasmodel extends CI_Model {

    private $petugas = 'petugas';

    /**
     * METHOD/FUNCTION user CRUD
     */
    public function get_petugas_by_id($id = '') {

        $sql = $this->db->query("SELECT `id_petugas`, `nomor_ktp`, `nama_petugas`, `status_data`,  DATE_FORMAT(cast(tanggal_post as date), '%d/%m/%Y') as tanggal_post, `kode_petugas`, `email_petugas`, `nomor_hp`, `alamat_petugas`,`img` ,`img_thumb` FROM `petugas` WHERE id_petugas=$id");
        return $sql->result_array();
    }

    public function count_pet_admin($id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        t.id_admin,
                                        COUNT(t.id_petugas) AS jml_pet
                                    FROM
                                        (
                                        SELECT       
                                            p.id_petugas,
                                            p.id_admin,
                                            p.status_data
                                        FROM
                                            petugas p
                                    ) t
                                    WHERE
                                        t.status_data = 1 AND t.id_admin = $id_admin");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT
                                        t.id_admin,
                                        COUNT(t.id_petugas) AS jml_pet
                                    FROM
                                        (
                                        SELECT       
                                            p.id_petugas,
                                            p.id_admin,
                                            p.status_data
                                        FROM
                                            petugas p
                                    ) t
                                    WHERE
                                        t.status_data = 1 AND t.id_admin LIKE $id_admin%");
        } elseif ($role == 0) {
            $sql = $this->db->query("SELECT
                                        t.id_admin,
                                        COUNT(t.id_petugas) AS jml_pet
                                    FROM
                                        (
                                        SELECT       
                                            p.id_petugas,
                                            p.id_admin,
                                            p.status_data
                                        FROM
                                            petugas p
                                    ) t ");
        }
        return $sql->result_array();
    }

    public function get_petugas_admin($id_admin = '', $role = '', $limit = '') {

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
                                            p.alamat_petugas,
                                            p.email_petugas,
                                            p.nomor_ktp,
                                            p.kode_petugas,
                                            wp.nama AS provinsi,
                                            wk.nama AS kabupaten,
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
                                    LEFT JOIN wilayah_provinsi wp ON
                                       wp.id = SUBSTRING(p.id_admin, 1, 2)
                                    LEFT JOIN wilayah_kabupaten wk ON
                                       wk.id = SUBSTRING(p.id_admin, 3, 2) AND wk.id_dati1 = SUBSTRING(p.id_admin, 1, 2)
                                    ) t
                                    WHERE
                                        t.id_admin = '$id_admin' AND status_data = 1
                                    ORDER BY
                                        t.tanggal_post
                                    DESC LIMIT $limit");
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
                                            p.alamat_petugas,
                                            p.email_petugas,
                                            p.nomor_ktp,
                                            p.kode_petugas,
                                            wp.nama AS provinsi,
                                            wk.nama AS kabupaten,
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
                                    LEFT JOIN wilayah_provinsi wp ON
                                       wp.id = SUBSTRING(p.id_admin, 1, 2)
                                    LEFT JOIN wilayah_kabupaten wk ON
                                       wk.id = SUBSTRING(p.id_admin, 3, 2) AND wk.id_dati1 = SUBSTRING(p.id_admin, 1, 2)
                                    ) t
                                    WHERE
                                        t.id_admin LIKE '$id_admin%' AND status_data = 1
                                    ORDER BY
                                        t.tanggal_post
                                    DESC LIMIT $limit");
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
                                            p.alamat_petugas,
                                            p.email_petugas,
                                            p.nomor_ktp,
                                            p.kode_petugas,
                                            wp.nama AS provinsi,
                                            wk.nama AS kabupaten,
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
                                    LEFT JOIN wilayah_provinsi wp ON
                                       wp.id = SUBSTRING(p.id_admin, 1, 2)
                                    LEFT JOIN wilayah_kabupaten wk ON
                                       wk.id = SUBSTRING(p.id_admin, 3, 2) AND wk.id_dati1 = SUBSTRING(p.id_admin, 1, 2)
                                    ) t
                                    ORDER BY
                                        t.tanggal_post
                                    DESC LIMIT $limit");
        }
        return $sql->result();
    }

    public function update_petugas($id = '', $value = '') {
        $this->db->trans_begin();
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
        $this->db->update($this->petugas, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function update_pass($id = '', $value = '') {
        $passwd = md5($value['pass']);
        $this->db->trans_begin();
        $data = array(
            'password' => $passwd
        );
        $this->db->where('id_petugas', $id);
        $this->db->update($this->petugas, $data);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

}
