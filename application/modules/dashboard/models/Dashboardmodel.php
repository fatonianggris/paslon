<?php

class Dashboardmodel extends CI_Model {

    private $table_ktp = 'ktp';

    //---------------------------------------COUNT REGIONAL ADMIN---------------------------------------//
    public function get_count_by_reg($id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            u.nama_admin,
                                            u.role_admin,
                                            u.id_ref,      
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            (
                                            SELECT
                                                COUNT(id_ktp)
                                            FROM
                                                ktp
                                            WHERE
                                                status_data = 1 AND id_admin = u.id_ref AND id_admin = u.id_ref
                                        ) AS jml_ktp,
                                        u.tanggal_post
                                    FROM
                                        user u
                                    LEFT JOIN wilayah_kabupaten wkb ON
                                        SUBSTR(u.id_ref, 3, 2) = wkb.id AND SUBSTR(u.id_ref, 1, 2) = wkb.id_dati1
                                    LEFT JOIN wilayah_provinsi wp ON
                                        SUBSTR(u.id_ref, 1, 2) = wp.id
                                    WHERE
                                        u.id_ref = '$id_admin'
                                    ) t
                                    WHERE
                                        t.id_ref = '$id_admin' ORDER BY t.tanggal_post");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            u.nama_admin,
                                            u.role_admin,
                                            u.id_ref,      
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            (
                                            SELECT
                                                COUNT(id_ktp)
                                            FROM
                                                ktp
                                            WHERE
                                                status_data = 1 AND id_admin = u.id_ref AND id_admin = u.id_ref
                                        ) AS jml_ktp,
                                        u.tanggal_post
                                    FROM
                                        user u
                                    LEFT JOIN wilayah_kabupaten wkb ON
                                        SUBSTR(u.id_ref, 3, 2) = wkb.id AND SUBSTR(u.id_ref, 1, 2) = wkb.id_dati1
                                    LEFT JOIN wilayah_provinsi wp ON
                                        SUBSTR(u.id_ref, 1, 2) = wp.id
                                    WHERE
                                        u.id_ref LIKE '$id_admin%'
                                    ) t
                                    WHERE
                                        t.id_ref LIKE '$id_admin%' ORDER BY t.tanggal_post");
        } elseif ($role == 0) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            u.nama_admin,
                                            u.role_admin,
                                            u.id_ref,      
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            (
                                            SELECT
                                                COUNT(id_ktp)
                                            FROM
                                                ktp
                                            WHERE
                                                id_admin = u.id_ref
                                        ) AS jml_ktp,
                                        u.tanggal_post
                                    FROM
                                        user u
                                    LEFT JOIN wilayah_kabupaten wkb ON
                                        SUBSTR(u.id_ref, 3, 2) = wkb.id AND SUBSTR(u.id_ref, 1, 2) = wkb.id_dati1
                                    LEFT JOIN wilayah_provinsi wp ON
                                        SUBSTR(u.id_ref, 1, 2) = wp.id                                  
                                    ) t");
        }
        return $sql->result();
    }

    //---------------------------------------//COUNT KTP PETUGAS---------------------------------------//
    public function get_count_by_ktp($id_admin = '', $role = '') {

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
                                            p.email_petugas,
                                            p.nomor_ktp,
                                            p.kode_petugas,
                                            wp.nama as provinsi,
                                            wkb.nama as kabupaten,
                                            (
                                            SELECT
                                                COUNT(k.id_ktp)
                                            FROM
                                                ktp k
                                            WHERE
                                                k.id_petugas = p.id_petugas AND k.status_data = 1 AND k.id_admin = p.id_admin
                                        ) AS jml_ktp,
                                        p.status_data
                                    FROM
                                        petugas p
                                    LEFT JOIN wilayah_kabupaten wkb ON
                                        SUBSTR(p.id_admin, 3, 2) = wkb.id AND SUBSTR(p.id_admin, 1, 2) = wkb.id_dati1
                                    LEFT JOIN wilayah_provinsi wp ON
                                        SUBSTR(p.id_admin, 1, 2) = wp.id
                                    ORDER BY
                                        p.tanggal_post
                                    DESC
                                    ) t
                                    WHERE
                                        t.id_admin = '$id_admin' AND status_data = 1");
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
                                            p.email_petugas,
                                            p.nomor_ktp,
                                            p.kode_petugas,
                                            wp.nama as provinsi,
                                            wkb.nama as kabupaten,
                                            (
                                            SELECT
                                                COUNT(k.id_ktp)
                                            FROM
                                                ktp k
                                            WHERE
                                                k.id_petugas = p.id_petugas AND k.status_data = 1 AND k.id_admin = p.id_admin
                                        ) AS jml_ktp,
                                        p.status_data
                                    FROM
                                        petugas p
                                    LEFT JOIN wilayah_kabupaten wkb ON
                                        SUBSTR(p.id_admin, 3, 2) = wkb.id AND SUBSTR(p.id_admin, 1, 2) = wkb.id_dati1
                                    LEFT JOIN wilayah_provinsi wp ON
                                        SUBSTR(p.id_admin, 1, 2) = wp.id
                                    ORDER BY
                                        p.tanggal_post
                                    DESC
                                    ) t
                                    WHERE
                                        t.id_admin LIKE '$id_admin%' AND status_data = 1");
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
                                            p.email_petugas,
                                            p.nomor_ktp,
                                            p.kode_petugas,
                                            wp.nama as provinsi,
                                            wkb.nama as kabupaten,
                                            (
                                            SELECT
                                                COUNT(k.id_ktp)
                                            FROM
                                                ktp k
                                            WHERE
                                                k.id_petugas = p.id_petugas
                                        ) AS jml_ktp,
                                        p.status_data
                                    FROM
                                        petugas p
                                    LEFT JOIN wilayah_kabupaten wkb ON
                                        SUBSTR(p.id_admin, 3, 2) = wkb.id AND SUBSTR(p.id_admin, 1, 2) = wkb.id_dati1
                                    LEFT JOIN wilayah_provinsi wp ON
                                        SUBSTR(p.id_admin, 1, 2) = wp.id
                                    ORDER BY
                                        p.tanggal_post
                                    DESC
                                    ) t");
        }

        return $sql->result();
    }

    //---------------------------------------//SET TEMPLATE---------------------------------------//

    public function get_template() {
        $sql = $this->db->query('SELECT * FROM template WHERE id_template=1');
        return $sql->result();
    }

    //---------------------------------------//COUNT KTP PETUGAS---------------------------------------//
    public function get_count_laporan($id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        (
                                        SELECT
                                            COUNT(id_ktp)
                                        FROM
                                            ktp
                                        WHERE
                                            id_admin = '$id_admin' AND status_data = 1
                                    ) AS jml_ktp,
                                    (
                                        SELECT
                                            COUNT(id_petugas)
                                        FROM
                                            petugas
                                        WHERE
                                            id_admin = '$id_admin' AND status_data = 1
                                    ) AS jml_petugas,
                                    (
                                        SELECT
                                            COUNT(nik_ktp)
                                        FROM
                                            ktp
                                        WHERE
                                            id_admin = '$id_admin' AND status_data = 1
                                    ) AS total_ktp,
                                    (
                                        SELECT
                                            COUNT(nik_ktp) - COUNT(DISTINCT nik_ktp)
                                        FROM
                                            ktp
                                        WHERE
                                            id_admin = '$id_admin' AND status_data = 1
                                    ) AS total_duplikat");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT
                                        (
                                        SELECT
                                            COUNT(id_ktp)
                                        FROM
                                            ktp
                                        WHERE
                                            id_admin LIKE '$id_admin%' AND status_data = 1
                                    ) AS jml_ktp,
                                    (
                                        SELECT
                                            COUNT(id_petugas)
                                        FROM
                                            petugas
                                        WHERE
                                            id_admin LIKE '$id_admin%' AND status_data = 1
                                    ) AS jml_petugas,
                                    (
                                        SELECT
                                            COUNT(nik_ktp)
                                        FROM
                                            ktp
                                        WHERE
                                            id_admin LIKE '$id_admin%' AND status_data = 1
                                    ) AS total_ktp,
                                    (
                                        SELECT
                                            COUNT(nik_ktp) - COUNT(DISTINCT nik_ktp)
                                        FROM
                                            ktp
                                        WHERE
                                            id_admin LIKE '$id_admin%' AND status_data = 1
                                    ) AS total_duplikat");
        } elseif ($role == 0) {

            $sql = $this->db->query("SELECT
                                        (
                                        SELECT
                                            COUNT(id_ktp)
                                        FROM
                                            ktp
                                       
                                    ) AS jml_ktp,
                                    (
                                        SELECT
                                            COUNT(id_petugas)
                                        FROM
                                            petugas
                                       
                                    ) AS jml_petugas,
                                    (
                                        SELECT
                                            COUNT(nik_ktp)
                                        FROM
                                            ktp
                                       
                                    ) AS total_ktp,
                                    (
                                        SELECT
                                            COUNT(nik_ktp) - COUNT(DISTINCT nik_ktp)
                                        FROM
                                            ktp
                                       
                                    ) AS total_duplikat");
        }
        return $sql->result();
    }

    //---------------------------------------//ID DUPLIKAT---------------------------------------//
    public function get_duplikat_ktp($id_admin = '', $role = '') {

        if (!empty($id_admin) && ($role == 2)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            k.id_ktp,
                                            k.nik_ktp,
                                            k.id_admin,
                                            k.nama_ktp,
                                            wp.nama as provinsi,
                                            wkb.nama as kabupaten,
                                            p.id_petugas,
                                            k.tempat_lahir,
                                            k.tanggal_lahir,
                                            k.status_data,
                                            k.tanggal_post
                                        FROM
                                            ktp k
                                        LEFT JOIN petugas p ON
                                            k.id_petugas = p.id_petugas
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTR(k.id_admin, 3, 2) = wkb.id AND SUBSTR(k.id_admin, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTR(k.id_admin, 1, 2) = wp.id
                                        WHERE
                                            k.status_data = 1 AND k.id_admin = '$id_admin' AND k.nik_ktp IN(
                                            SELECT
                                                k.nik_ktp
                                            FROM
                                                ktp k
                                            GROUP BY
                                                k.nik_ktp
                                            HAVING
                                                COUNT(*) > 1
                                        ) AND k.nama_ktp IN(
                                        SELECT
                                            k.nama_ktp
                                        FROM
                                            ktp k
                                        GROUP BY
                                            k.nama_ktp
                                        HAVING
                                            COUNT(*) > 1
                                    )
                                    ORDER BY
                                        k.nama_ktp ASC
                                    ) t
                                    WHERE
                                        t.id_admin = '$id_admin' AND t.status_data = 1
                                    ORDER BY
                                        t.nama_ktp ASC");
        } elseif (!empty($id_admin) && ($role == 1)) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            k.id_ktp,
                                            k.nik_ktp,
                                            k.id_admin,
                                            k.nama_ktp,
                                            wp.nama as provinsi,
                                            wkb.nama as kabupaten,
                                            p.id_petugas,
                                            k.tempat_lahir,
                                            k.tanggal_lahir,
                                            k.status_data,
                                            k.tanggal_post
                                        FROM
                                            ktp k
                                        LEFT JOIN petugas p ON
                                            k.id_petugas = p.id_petugas
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTR(k.id_admin, 3, 2) = wkb.id AND SUBSTR(k.id_admin, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTR(k.id_admin, 1, 2) = wp.id
                                        WHERE
                                            k.status_data = 1 AND k.id_admin LIKE '$id_admin%' AND k.nik_ktp IN(
                                            SELECT
                                                k.nik_ktp
                                            FROM
                                                ktp k
                                            GROUP BY
                                                k.nik_ktp
                                            HAVING
                                                COUNT(*) > 1
                                        ) AND k.nama_ktp IN(
                                        SELECT
                                            k.nama_ktp
                                        FROM
                                            ktp k
                                        GROUP BY
                                            k.nama_ktp
                                        HAVING
                                            COUNT(*) > 1
                                    )
                                    ORDER BY
                                        k.nama_ktp ASC
                                    ) t
                                    WHERE
                                        t.id_admin LIKE '$id_admin%' AND t.status_data = 1
                                    ORDER BY
                                        t.nama_ktp ASC");
        } elseif ($role == 0) {

            $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            k.id_ktp,
                                            k.nik_ktp,
                                            k.id_admin,
                                            k.nama_ktp,
                                            wp.nama as provinsi,
                                            wkb.nama as kabupaten,
                                            p.id_petugas,
                                            k.tempat_lahir,
                                            k.tanggal_lahir,
                                            k.status_data,
                                            k.tanggal_post
                                        FROM
                                            ktp k
                                        LEFT JOIN petugas p ON
                                            k.id_petugas = p.id_petugas
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTR(k.id_admin, 3, 2) = wkb.id AND SUBSTR(k.id_admin, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTR(k.id_admin, 1, 2) = wp.id
                                        WHERE
                                            k.nik_ktp IN(
                                            SELECT
                                                k.nik_ktp
                                            FROM
                                                ktp k
                                            GROUP BY
                                                k.nik_ktp
                                            HAVING
                                                COUNT(*) > 1
                                        ) AND k.nama_ktp IN(
                                        SELECT
                                            k.nama_ktp
                                        FROM
                                            ktp k
                                        GROUP BY
                                            k.nama_ktp
                                        HAVING
                                            COUNT(*) > 1
                                    )
                                    ORDER BY
                                        k.nama_ktp ASC
                                    ) t                                
                                    ORDER BY
                                        t.nama_ktp ASC");
        }
        return $sql->result();
    }

    //---------------------------------------//GET PETUGAS---------------------------------------//
    public function get_petugas($id_admin = '', $role = '') {

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

    //---------------------------------------//GET PROVINSI---------------------------------------//
    public function get_provinsi() {
        $sql = $this->db->query('SELECT * FROM wilayah_provinsi');
        return $sql->result();
    }

    //---------------------------------------//-----GET KABUPATEN----------------------------------//
    public function get_kabupaten() {
        $sql = $this->db->query('SELECT * FROM wilayah_kabupaten');
        return $sql->result();
    }

}

?>