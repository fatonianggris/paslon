<?php

class Mutasimodel extends CI_Model {

    private $mutasi = 'mutasi';
    private $ktp = 'ktp';
    private $user = 'user';

    /**
     * METHOD/FUNCTION user CRUD
     */
    public function get_detail_mutasi($id_mutasi = '') {

        $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            m.*,
                                            COALESCE(wpasl.nama,'') as provinsi_asal,   
                                            COALESCE(wkbasl.nama,'') as kabupaten_asal,
                                            COALESCE(wptj.nama,'') as provinsi_tujuan,   
                                            COALESCE(wkbtj.nama,'') as kabupaten_tujuan 
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
                                        t.id_mutasi = '$id_mutasi'");

        return $sql->result();
    }

    public function get_all_mutasi_masuk($id_tujuan = '', $limit = '') {


        $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            m.*,                                        
                                            COALESCE(wpasl.nama,'') as provinsi_asal,   
                                            COALESCE(wkbasl.nama,'') as kabupaten_asal,
                                            COALESCE(wptj.nama,'') as provinsi_tujuan,   
                                            COALESCE(wkbtj.nama,'') as kabupaten_tujuan  
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
                                        t.id_region_tujuan = '$id_tujuan'
                                    ORDER BY
                                        t.tgl_pengajuan_mutasi ASC
                                    LIMIT $limit");

        return $sql->result();
    }

    public function get_all_mutasi_keluar($id_admin = '', $limit = '') {



        $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            m.*,
                                            COALESCE(wpasl.nama,'') as provinsi_asal,   
                                            COALESCE(wkbasl.nama,'') as kabupaten_asal,
                                            COALESCE(wptj.nama,'') as provinsi_tujuan,   
                                            COALESCE(wkbtj.nama,'') as kabupaten_tujuan 
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
                                        t.tgl_pengajuan_mutasi ASC
                                    LIMIT $limit");

        return $sql->result();
    }

    public function count_mutasi_masuk_all($id_tujuan = '') {

        $this->db->where('id_region_tujuan', $id_tujuan);
        $sql = $this->db->get($this->mutasi);
        return $sql->num_rows();
    }

    public function count_mutasi_keluar_all($id_asal = '') {

        $this->db->where('id_region_asal', $id_asal);
        $sql = $this->db->get($this->mutasi);
        return $sql->num_rows();
    }

    public function get_id_mutasi($id = '') {

        $this->db->select('*');
        $this->db->where('id_mutasi', $id);
        $sql = $this->db->get($this->mutasi);
        return $sql->result();
    }

    public function get_ktp_mutasi($id = '') {

        $this->db->select('*');
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

    public function update_status_mutasi_false($id = '') {
        $this->db->trans_begin();

        $data = array(
            'status_mutasi' => '',
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
        $this->db->update($this->ktp, $data);

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
        $this->db->update($this->mutasi, $data);

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
        $this->db->delete($this->mutasi);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

}
