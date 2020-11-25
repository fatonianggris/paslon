<?php

class Saksimodel extends CI_Model {

    private $petugas = 'petugas';
    private $table_pemilihan = 'pemilihan';
    private $table_tps = 'tps';
    private $table_saksi = 'saksi';
    private $table_calon_pemilihan = 'calon_pemilihan';
    private $table_hasil_pemilihan = 'hasil_pemilihan';
    private $table_suara_calon = 'suara_calon';

    /**
     * METHOD/FUNCTION user CRUD
     */
    public function count_tps_saksi($id_saksi = '') {

        $this->db->where('id_petugas_saksi', $id_saksi);
        $sql = $this->db->get($this->table_tps);

        return $sql->num_rows();
    }

    public function count_pemilihan_saksi($id_pet = '') {

        $this->db->where('id_pemilihan', $id_pet);
        $sql = $this->db->get($this->table_pemilihan);

        return $sql->num_rows();
    }

    public function get_saksi_by_id($id = '') {

        $sql = $this->db->query("SELECT
                                    id_saksi,
                                    id_pemilihan,
                                    id_admin,
                                    id_wilayah_pemilihan,
                                    id_tps,
                                    nomor_ktp_saksi,
                                    email_saksi,
                                    nama_saksi,
                                    nomor_hp_saksi,
                                    tanggal_post
                                FROM
                                    saksi
                                WHERE 
                                    id_saksi=$id");
        return $sql->result_array();
    }

    public function get_tps_saksi($id_saksi = '', $limit = '') {

        $sql = $this->db->query("SELECT
                                    t.id_tps,
                                    t.id_pemilihan,
                                    t.id_admin,
                                    t.id_wilayah_pemilihan,
                                    t.id_petugas_saksi,
                                    t.nomor_tps,
                                    t.nama_tps,
                                    t.path_tps,
                                    t.status_formulir_c1,
                                    (
                                    SELECT
                                        COUNT(cp.id_calon_pemilihan)
                                    FROM
                                        calon_pemilihan cp
                                    WHERE
                                        cp.id_pemilihan = t.id_pemilihan AND cp.status_data = 1
                                    ) AS jumlah_calon_pemilihan,
                                    DATE_FORMAT(
                                            CAST(t.tanggal_post AS DATE),
                                            '%d/%m/%Y'
                                        ) AS tanggal_post,
                                    CONCAT(UCASE(p.nama_pemilihan),' ',p.tahun_pemilihan) AS nama_pemilihan,
                                    wpasl.nama AS provinsi,
                                    wkbasl.nama AS kabupaten,
                                    wkcasl.nama AS kecamatan,
                                    wdasl.nama AS kelurahan
                                FROM
                                    tps t
                                LEFT JOIN wilayah_provinsi wpasl ON
                                    wpasl.id = SUBSTRING(t.id_wilayah_pemilihan, 1, 2)
                                LEFT JOIN pemilihan p ON
                                    p.id_pemilihan = t.id_pemilihan
                                LEFT JOIN wilayah_kabupaten wkbasl ON
                                    wkbasl.id = SUBSTRING(t.id_wilayah_pemilihan, 3, 2) AND wkbasl.id_dati1 = SUBSTRING(t.id_wilayah_pemilihan, 1, 2)
                                LEFT JOIN wilayah_kecamatan wkcasl ON
                                    wkcasl.id = SUBSTRING(t.id_wilayah_pemilihan, 5, 2) AND wkcasl.id_dati1 = SUBSTRING(t.id_wilayah_pemilihan, 1, 2) AND wkcasl.id_dati2 = SUBSTRING(t.id_wilayah_pemilihan, 3, 2)
                                LEFT JOIN wilayah_desa wdasl ON
                                    wdasl.id = SUBSTRING(t.id_wilayah_pemilihan, 7, 2) AND wdasl.id_dati1 = SUBSTRING(t.id_wilayah_pemilihan, 1, 2) AND wdasl.id_dati2 = SUBSTRING(t.id_wilayah_pemilihan, 3, 2) AND wdasl.id_dati3 = SUBSTRING(t.id_wilayah_pemilihan, 5, 2)
                                WHERE
                                    t.id_petugas_saksi IN($id_saksi) AND t.status_data = 1 ORDER BY t.tanggal_post ASC LIMIT $limit");
        return $sql->result_array();
    }

    public function get_pemilihan_saksi($id_pemilihan = '', $limit = '') {

        $sql = $this->db->query("SELECT
                                    p.id_pemilihan,
                                    p.id_regional_pemilihan,
                                    p.nama_pemilihan,
                                    p.id_kategori_pemilihan,                                  
                                    p.tahun_pemilihan,
                                    p.nomor_urut,
                                    p.nama_calon,
                                    p.nama_wakil_calon,
                                    DATE_FORMAT(
                                            CAST(p.tanggal_post AS DATE),
                                            '%d/%m/%Y'
                                        ) AS tanggal_post,
                                    COALESCE(wp.nama, '') AS provinsi,
                                    COALESCE(wkb.nama, '') AS kabupaten
                                FROM
                                  pemilihan p
                                LEFT JOIN wilayah_kabupaten wkb ON
                                    SUBSTRING(p.id_regional_pemilihan, 3, 2) = wkb.id AND SUBSTRING(p.id_regional_pemilihan, 1, 2) = wkb.id_dati1
                                LEFT JOIN wilayah_provinsi wp ON
                                    SUBSTRING(p.id_regional_pemilihan, 1, 2) = wp.id
                                WHERE
                                    p.id_pemilihan = '$id_pemilihan' AND p.status_data = 1 ORDER BY p.tanggal_post ASC LIMIT $limit");
        return $sql->result_array();
    }

    //----------------------------------GET TPS-------------------------------------//
    public function get_tps($id = '') {

        $sql = $this->db->query("SELECT 
                                      * 
                                  FROM 
                                      tps
                                  WHERE
                                      id_tps='$id'");
        return $sql->result();
    }

    public function insert_hasil_pemilihan($value = '', $id_tps = "", $id_pemilihan = "", $id_wilayah_pemilihan = '') {

        $this->db->trans_begin();

        $data = array(
            'id_pemilihan' => $id_pemilihan,
            'id_wilayah_pemilihan' => $id_wilayah_pemilihan,
            'id_tps' => $id_tps,
            'id_petugas_saksi' => $value['id_petugas_saksi'],
            'dp_dpt_laki_laki' => $value['dp_dpt_laki_laki'],
            'dp_dpt_perempuan' => $value['dp_dpt_perempuan'],
            'dp_dpph_laki_laki' => $value['dp_dpph_laki_laki'],
            'dp_dpph_perempuan' => $value['dp_dpph_perempuan'],
            'dp_dptb_laki_laki' => $value['dp_dptb_laki_laki'],
            'dp_dptb_perempuan' => $value['dp_dptb_perempuan'],
            'dp_total' => $value['dp_total'],
            'php_dpt_laki_laki' => $value['php_dpt_laki_laki'],
            'php_dpt_perempuan' => $value['php_dpt_perempuan'],
            'php_dpph_laki_laki' => $value['php_dpph_laki_laki'],
            'php_dpph_perempuan' => $value['php_dpph_perempuan'],
            'php_dptb_laki_laki' => $value['php_dptb_laki_laki'],
            'php_dptb_perempuan' => $value['php_dptb_perempuan'],
            'php_total' => $value['php_total'],
            'total_suara_sah' => $value['total_suara_sah'],
            'total_suara_tidak_sah' => $value['total_suara_tidak_sah'],
            'fotoc1_pertama' => $value['fotoc1_pertama'],
            'fotoc1_pertama_thumb' => $value['fotoc1_pertama_thumb'],
            'fotoc1_kedua' => $value['fotoc1_kedua'],
            'fotoc1_kedua_thumb' => $value['fotoc1_kedua_thumb']
        );

        $this->db->insert($this->table_hasil_pemilihan, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //--------------------------------UPDATE STATUS HASIL PEMILIHAN-----------------------------------------//

    public function update_status_hasil_pemilihan($id_tps = '', $id_pemilihan = '', $id_wilayah_pemilihan = '') {

        $this->db->trans_begin();

        $data = array(
            'status_formulir_c1' => 1
        );

        $this->db->where('id_tps', $id_tps);
        $this->db->where('id_pemilihan', $id_pemilihan);
        $this->db->where('id_wilayah_pemilihan', $id_wilayah_pemilihan);
        $this->db->update($this->table_tps, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //--------------------------------GET HASIL PEMILIHAN--------------------------------------//
    public function get_hasil_pemilihan($id_tps = '', $id_pemilihan = '', $id_wilayah_pemilihan = '') {

        $sql = $this->db->query("SELECT
                                    hp.id_hasil_pemilihan,
                                    hp.id_pemilihan,
                                    hp.id_wilayah_pemilihan,
                                    hp.id_tps,
                                    hp.id_petugas_saksi,
                                    hp.dp_dpt_laki_laki,
                                    hp.dp_dpt_perempuan,
                                    hp.dp_dpph_laki_laki,
                                    hp.dp_dpph_perempuan,
                                    hp.dp_dptb_laki_laki,
                                    hp.dp_dptb_perempuan,
                                    hp.dp_total,
                                    hp.php_dpt_laki_laki,
                                    hp.php_dpt_perempuan,
                                    hp.php_dpph_laki_laki,
                                    hp.php_dpph_perempuan,
                                    hp.php_dptb_laki_laki,
                                    hp.php_dptb_perempuan,
                                    hp.php_total,
                                    hp.total_suara_sah,
                                    hp.total_suara_tidak_sah,
                                    hp.fotoc1_pertama,
                                    hp.fotoc1_pertama_thumb,
                                    hp.fotoc1_kedua,
                                    hp.fotoc1_kedua_thumb,
                                    hp.tanggal_post,
                                    hp.status_data,
                                    t.nama_tps,
                                    t.nomor_tps,
                                    p.nama_pemilihan,
                                    p.tahun_pemilihan
                                FROM
                                    hasil_pemilihan hp
                                LEFT JOIN tps t ON
                                    t.id_tps = hp.id_tps
                                LEFT JOIN pemilihan p ON
                                    p.id_pemilihan = hp.id_pemilihan
                                WHERE
                                    hp.id_tps = '$id_tps' AND hp.id_pemilihan = '$id_pemilihan' AND hp.id_wilayah_pemilihan = '$id_wilayah_pemilihan' AND hp.status_data = 1");

        return $sql->result();
    }

    //--------------------------------CEK HASIL SUARA--------------------------------------//
    public function get_hasil_suara($id_tps = '', $id_pemilihan = '', $id_wilayah_pemilihan = '') {

        $sql = $this->db->query("SELECT
                                        *
                                    FROM
                                        suara_calon
                                    WHERE
                                        id_tps = '$id_tps' AND id_pemilihan = '$id_pemilihan' AND id_wilayah_pemilihan='$id_wilayah_pemilihan' AND status_data = 1");

        return $sql->result();
    }

    //--------------------------------GET SUARA CALON PEMILIHAN--------------------------------------//
    public function get_hasil_suara_calon($id_pemilihan = '') {

        $sql = $this->db->query("SELECT
                                    cp.nama_calon,
                                    cp.nama_wakil_calon,
                                    cp.nomor_urut,
                                    cp.id_calon_pemilihan,
                                    cp.id_pemilihan,
                                    sc.id_suara_calon,                                                   
                                    sc.id_wilayah_pemilihan,
                                    sc.id_tps,
                                    sc.suara_sah,
                                    DATE_FORMAT(
                                            CAST(sc.tanggal_post AS DATE),
                                            '%d/%m/%Y'
                                        ) AS tanggal_post,
                                    cp.status_data
                                FROM
                                    calon_pemilihan cp
                                LEFT JOIN suara_calon sc ON
                                    cp.id_calon_pemilihan = sc.id_calon_pemilihan AND cp.id_pemilihan = sc.id_pemilihan
                                WHERE
                                    cp.id_pemilihan='$id_pemilihan' AND cp.status_data = 1");
        return $sql->result();
    }

    public function get_data_calon_pemilihan($id_pemilihan = "") {

        $sql = $this->db->query("SELECT
                                        *
                                FROM
                                    calon_pemilihan
                                WHERE
                                    id_pemilihan = '$id_pemilihan' AND status_data = 1");

        return $sql->result();
    }

    //--------------------------------GET SUARA CALON PEMILIHAN EDIT--------------------------------------//
    public function get_hasil_suara_calon_edit($id_tps = '', $id_pemilihan = '', $id_wilayah_pemilihan = '') {

        $sql = $this->db->query("SELECT
                                    cp.nama_calon,
                                    cp.nama_wakil_calon,
                                    cp.nomor_urut,
                                    cp.id_calon_pemilihan,
                                    cp.id_pemilihan,
                                    sc.id_suara_calon,                                                   
                                    sc.id_wilayah_pemilihan,
                                    sc.id_tps,
                                    sc.suara_sah,
                                    DATE_FORMAT(
                                            CAST(sc.tanggal_post AS DATE),
                                            '%d/%m/%Y'
                                        ) AS tanggal_post,
                                    sc.status_data
                                FROM
                                    calon_pemilihan cp
                                LEFT JOIN suara_calon sc ON
                                    cp.id_pemilihan = sc.id_pemilihan AND cp.id_calon_pemilihan = sc.id_calon_pemilihan AND sc.id_wilayah_pemilihan='$id_wilayah_pemilihan' AND sc.id_tps='$id_tps' 
                                WHERE
                                    cp.id_pemilihan = '$id_pemilihan' AND cp.status_data = 1");
        return $sql->result();
    }

    //--------------------------------UPDATE HASIL PEMILIHAN-----------------------------------------//

    public function update_hasil_pemilihan($value = '', $id_tps = "", $id_pemilihan = "", $id_wilayah_pemilihan = '') {

        $this->db->trans_begin();

        $data = array(
            'id_petugas_saksi' => $value['id_petugas_saksi'],
            'dp_dpt_laki_laki' => $value['dp_dpt_laki_laki'],
            'dp_dpt_perempuan' => $value['dp_dpt_perempuan'],
            'dp_dpph_laki_laki' => $value['dp_dpph_laki_laki'],
            'dp_dpph_perempuan' => $value['dp_dpph_perempuan'],
            'dp_dptb_laki_laki' => $value['dp_dptb_laki_laki'],
            'dp_dptb_perempuan' => $value['dp_dptb_perempuan'],
            'dp_total' => $value['dp_total'],
            'php_dpt_laki_laki' => $value['php_dpt_laki_laki'],
            'php_dpt_perempuan' => $value['php_dpt_perempuan'],
            'php_dpph_laki_laki' => $value['php_dpph_laki_laki'],
            'php_dpph_perempuan' => $value['php_dpph_perempuan'],
            'php_dptb_laki_laki' => $value['php_dptb_laki_laki'],
            'php_dptb_perempuan' => $value['php_dptb_perempuan'],
            'php_total' => $value['php_total'],
            'total_suara_sah' => $value['total_suara_sah'],
            'total_suara_tidak_sah' => $value['total_suara_tidak_sah'],
            'fotoc1_pertama' => $value['fotoc1_pertama'],
            'fotoc1_pertama_thumb' => $value['fotoc1_pertama_thumb'],
            'fotoc1_kedua' => $value['fotoc1_kedua'],
            'fotoc1_kedua_thumb' => $value['fotoc1_kedua_thumb']
        );

        $this->db->where('id_tps', $id_tps);
        $this->db->where('id_pemilihan', $id_pemilihan);
        $this->db->where('id_wilayah_pemilihan', $id_wilayah_pemilihan);
        $this->db->update($this->table_hasil_pemilihan, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
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
