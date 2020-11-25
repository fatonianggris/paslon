<?php

class Laporanpemilihanmodel extends CI_Model {

    private $table_petugas = 'petugas';
    private $table_ktp = 'ktp';
    private $table_user = 'user';
    private $table_laporan = 'laporan';

    //---------------------------------------CETAK KARTU MANDAT ID---------------------------------------//

    public function cetak_kartu_mandat_id($id_saksi = '', $id_pemilihan = '') {

        $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            s.id_saksi,
                                            s.id_anggota,
                                            s.id_pemilihan,
                                            s.id_admin,
                                            s.id_tps,
                                            s.id_asal_saksi,
                                            s.nomor_ktp_saksi,
                                            s.email_saksi,
                                            s.password_saksi,
                                            s.nama_saksi,
                                            s.nomor_hp_saksi,
                                            s.tempat_lahir,
                                            s.tanggal_lahir,
                                            s.alamat_saksi,
                                            s.rt,
                                            s.rw,
                                            s.kodepos,
                                            s.jenis_kelamin,
                                            s.img_pas,
                                            s.barcode,
                                            s.status_data,
                                            p.nama_pemilihan,
                                            p.tahun_pemilihan,
                                            p.nama_calon,
                                            p.nama_wakil_calon,
                                            p.id_kategori_pemilihan,
                                            tp.nama_tps,
                                            tp.nomor_tps,
                                            tp.id_wilayah_pemilihan,
                                            wd.nama AS nama_kelurahan
                                        FROM
                                            saksi s
                                        LEFT JOIN pemilihan p ON
                                            s.id_pemilihan = p.id_pemilihan
                                        LEFT JOIN tps tp ON
                                            tp.id_tps = s.id_tps
                                        LEFT JOIN wilayah_desa wd ON
                                            SUBSTRING(tp.id_wilayah_pemilihan, 7, 2) = wd.id AND SUBSTRING(tp.id_wilayah_pemilihan, 1, 2) = wd.id_dati1 AND SUBSTRING(tp.id_wilayah_pemilihan, 3, 2) = wd.id_dati2 AND SUBSTRING(tp.id_wilayah_pemilihan, 5, 2) = wd.id_dati3
                                    ) t
                                    WHERE
                                        t.id_saksi = '$id_saksi' AND t.id_pemilihan = '$id_pemilihan' AND t.status_data=1");
        return $sql->result();
    }

    //---------------------------------------CETAK FOTO ALL---------------------------------------//

    public function cetak_all_kartu_mandat($id_pemilihan = '', $data_check = '') {

        $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            s.id_saksi,
                                            s.id_anggota,
                                            s.id_pemilihan,
                                            s.id_admin,
                                            s.id_tps,
                                            s.id_asal_saksi,
                                            s.nomor_ktp_saksi,
                                            s.email_saksi,
                                            s.password_saksi,
                                            s.nama_saksi,
                                            s.nomor_hp_saksi,
                                            s.tempat_lahir,
                                            s.tanggal_lahir,
                                            s.alamat_saksi,
                                            s.rt,
                                            s.rw,
                                            s.kodepos,
                                            s.jenis_kelamin,
                                            s.img_pas,
                                            s.barcode,
                                            s.status_data,
                                            p.nama_pemilihan,
                                            p.tahun_pemilihan,
                                            p.nama_calon,
                                            p.nama_wakil_calon,
                                            p.id_kategori_pemilihan,
                                            tp.nama_tps,
                                            tp.nomor_tps,
                                            tp.id_wilayah_pemilihan,
                                            wdt.nama AS nama_kelurahan,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            wk.nama AS kecamatan,
                                            wd.nama AS kelurahan
                                        FROM
                                            saksi s
                                        LEFT JOIN pemilihan p ON
                                            s.id_pemilihan = p.id_pemilihan
                                        LEFT JOIN tps tp ON
                                            tp.id_tps = s.id_tps
                                        LEFT JOIN wilayah_desa wdt ON
                                            SUBSTRING(tp.id_wilayah_pemilihan, 7, 2) = wdt.id AND SUBSTRING(tp.id_wilayah_pemilihan, 1, 2) = wdt.id_dati1 AND SUBSTRING(tp.id_wilayah_pemilihan, 3, 2) = wdt.id_dati2 AND SUBSTRING(tp.id_wilayah_pemilihan, 5, 2) = wdt.id_dati3
                                        LEFT JOIN wilayah_desa wd ON
                                            SUBSTRING(s.id_asal_saksi, 7, 2) = wd.id AND SUBSTRING(s.id_asal_saksi, 1, 2) = wd.id_dati1 AND SUBSTRING(s.id_asal_saksi, 3, 2) = wd.id_dati2 AND SUBSTRING(s.id_asal_saksi, 5, 2) = wd.id_dati3
                                        LEFT JOIN wilayah_kecamatan wk ON
                                            SUBSTRING(s.id_asal_saksi, 5, 2) = wk.id AND SUBSTRING(s.id_asal_saksi, 1, 2) = wk.id_dati1 AND SUBSTRING(s.id_asal_saksi, 3, 2) = wk.id_dati2
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTRING(s.id_asal_saksi, 3, 2) = wkb.id AND SUBSTRING(s.id_asal_saksi, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTRING(s.id_asal_saksi, 1, 2) = wp.id
                                    ) t
                                    WHERE
                                        t.id_saksi IN($data_check) AND t.id_pemilihan = '$id_pemilihan' AND t.status_data=1
                                    ORDER BY
                                        t.id_saksi ASC");

        return $sql->result();
    }

    //---------------------------------------CETAK FOTO ALL---------------------------------------//

    public function get_all_saksi($id_pemilihan = '', $data_check = '') {

        $sql = $this->db->query("SELECT
                                        t.*
                                    FROM
                                        (
                                        SELECT
                                            s.id_saksi,
                                            s.id_anggota,
                                            s.id_pemilihan,
                                            s.id_admin,
                                            s.id_tps,
                                            s.id_asal_saksi,
                                            s.nomor_ktp_saksi,
                                            s.email_saksi,
                                            s.password_saksi,
                                            s.nama_saksi,
                                            s.nomor_hp_saksi,
                                            s.tempat_lahir,
                                            s.tanggal_lahir,
                                            s.alamat_saksi,
                                            s.rt,
                                            s.rw,
                                            s.kodepos,
                                            s.jenis_kelamin,
                                            s.img_pas,
                                            s.barcode,
                                            s.status_data,
                                            p.nama_pemilihan,
                                            p.tahun_pemilihan,
                                            p.nama_calon,
                                            p.nama_wakil_calon,
                                            p.id_kategori_pemilihan,
                                            tp.nama_tps,
                                            tp.nomor_tps,
                                            tp.id_wilayah_pemilihan,
                                            wdt.nama AS nama_kelurahan,
                                            wp.nama AS provinsi,
                                            wkb.nama AS kabupaten,
                                            wk.nama AS kecamatan,
                                            wd.nama AS kelurahan
                                        FROM
                                            saksi s
                                        LEFT JOIN pemilihan p ON
                                            s.id_pemilihan = p.id_pemilihan
                                        LEFT JOIN tps tp ON
                                            tp.id_tps = s.id_tps
                                        LEFT JOIN wilayah_desa wdt ON
                                            SUBSTRING(tp.id_wilayah_pemilihan, 7, 2) = wdt.id AND SUBSTRING(tp.id_wilayah_pemilihan, 1, 2) = wdt.id_dati1 AND SUBSTRING(tp.id_wilayah_pemilihan, 3, 2) = wdt.id_dati2 AND SUBSTRING(tp.id_wilayah_pemilihan, 5, 2) = wdt.id_dati3
                                        LEFT JOIN wilayah_desa wd ON
                                            SUBSTRING(s.id_asal_saksi, 7, 2) = wd.id AND SUBSTRING(s.id_asal_saksi, 1, 2) = wd.id_dati1 AND SUBSTRING(s.id_asal_saksi, 3, 2) = wd.id_dati2 AND SUBSTRING(s.id_asal_saksi, 5, 2) = wd.id_dati3
                                        LEFT JOIN wilayah_kecamatan wk ON
                                            SUBSTRING(s.id_asal_saksi, 5, 2) = wk.id AND SUBSTRING(s.id_asal_saksi, 1, 2) = wk.id_dati1 AND SUBSTRING(s.id_asal_saksi, 3, 2) = wk.id_dati2
                                        LEFT JOIN wilayah_kabupaten wkb ON
                                            SUBSTRING(s.id_asal_saksi, 3, 2) = wkb.id AND SUBSTRING(s.id_asal_saksi, 1, 2) = wkb.id_dati1
                                        LEFT JOIN wilayah_provinsi wp ON
                                            SUBSTRING(s.id_asal_saksi, 1, 2) = wp.id
                                    ) t
                                    WHERE
                                        t.id_saksi IN($data_check) AND t.id_pemilihan = '$id_pemilihan' AND t.status_data=1
                                    ORDER BY
                                        t.nama_saksi ASC");

        return $sql->result_array();
    }

    //---------------------------------------GET NAMA PEMILIHAN ---------------------------------------//
    public function get_regional_pemilihan($id_wilayah_pemilihan = '') {
        $sql = $this->db->query("SELECT
                                        wd.nama,
                                        CONCAT(
                                            wd.id_dati1,
                                            wd.id_dati2,
                                            wd.id_dati3,
                                            wd.id
                                        ) AS id_wilayah_pemilihan,
                                        wp.id AS id_provinsi,
                                        wp.nama AS provinsi,
                                        wk.id AS id_kabupaten,
                                        wk.nama AS kabupaten,
                                        wk.administratif AS administratif_kab,
                                        wkc.id AS id_kecamatan,
                                        wkc.nama AS kecamatan,
                                        wd.id AS id_kelurahan,
                                        wd.nama AS kelurahan,
                                        wd.administratif AS administratif_kel
                                    FROM
                                        wilayah_desa wd
                                    LEFT JOIN wilayah_provinsi wp ON
                                        wp.id = wd.id_dati1
                                    LEFT JOIN wilayah_kabupaten wk ON
                                        wk.id = wd.id_dati2 AND wk.id_dati1 = wd.id_dati1
                                    LEFT JOIN wilayah_kecamatan wkc ON
                                        wkc.id = wd.id_dati3 AND wkc.id_dati1 = wd.id_dati1 AND wkc.id_dati2 = wd.id_dati2
                                    WHERE
                                        CONCAT(
                                            wd.id_dati1,
                                            wd.id_dati2,
                                            wd.id_dati3,
                                            wd.id
                                        ) IN($id_wilayah_pemilihan)
                                    GROUP BY
                                        wd.nama
                                    ORDER BY
                                        wd.nama ASC");
        return $sql->result();
    }

    //---------------------------------------GET NAMA WILAYAH ---------------------------------------//
    public function get_nama_wilayah($id_wilayah_pemilihan = '') {
        $sql = $this->db->query("SELECT                                                                          
                                        wp.nama AS provinsi,                                       
                                        wk.nama AS kabupaten,
                                        wk.administratif AS administratif_kab,                                       
                                        wkc.nama AS kecamatan,                                      
                                        wd.nama AS kelurahan,
                                        wd.administratif AS administratif_kel
                                    FROM
                                        wilayah_desa wd
                                    LEFT JOIN wilayah_provinsi wp ON
                                        wp.id = wd.id_dati1
                                    LEFT JOIN wilayah_kabupaten wk ON
                                        wk.id = wd.id_dati2 AND wk.id_dati1 = wd.id_dati1
                                    LEFT JOIN wilayah_kecamatan wkc ON
                                        wkc.id = wd.id_dati3 AND wkc.id_dati1 = wd.id_dati1 AND wkc.id_dati2 = wd.id_dati2
                                    WHERE
                                        CONCAT(
                                            wd.id_dati1,
                                            wd.id_dati2,
                                            wd.id_dati3,
                                            wd.id
                                        ) = '$id_wilayah_pemilihan'");
        return $sql->result();
    }

    //---------------------------------------GET DATA TPS PEMILIHAN ---------------------------------------//
    public function get_data_tps($id_pemilihan = '', $id_wilayah_pemilihan = '') {

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
                                    t.id_pemilihan,
                                    t.id_petugas_saksi,
                                    t.id_wilayah_pemilihan,
                                    t.nama_tps,
                                    t.nomor_tps,
                                    t.status_data,
                                    s.nama_saksi,
                                    s.nomor_ktp_saksi
                                FROM
                                    tps t
                                LEFT JOIN hasil_pemilihan hp ON
                                    hp.id_tps = t.id_tps AND hp.id_wilayah_pemilihan= t.id_wilayah_pemilihan
                                LEFT JOIN saksi s ON
                                    s.id_saksi = t.id_petugas_saksi
                                WHERE
                                    t.id_pemilihan = '$id_pemilihan' AND t.id_wilayah_pemilihan = '$id_wilayah_pemilihan' AND t.status_data = 1
                                ORDER BY 
                                    t.nama_tps");


        return $sql->result_array();
    }

    //--------------------------------GET HASIL PEMILIHAN--------------------------------------//
    public function get_hasil_pemilihan($id_pemilihan = '', $id_wilayah_pemilihan = '') {

        $sql = $this->db->query("SELECT
                                    t.id_tps,
                                    t.id_pemilihan,
                                    t.id_admin,
                                    t.id_wilayah_pemilihan,
                                    t.id_petugas_saksi,
                                    t.nama_tps,
                                    t.nomor_tps,
                                    t.status_data,
                                    hp.id_tps,
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
                                    hp.total_suara_tidak_sah
                                FROM
                                    tps t
                                LEFT JOIN hasil_pemilihan hp ON
                                    hp.id_tps = t.id_tps AND hp.id_wilayah_pemilihan = t.id_wilayah_pemilihan
                                WHERE
                                    t.id_pemilihan = '$id_pemilihan' AND t.id_wilayah_pemilihan = '$id_wilayah_pemilihan' AND t.status_data = 1
                                ORDER BY 
                                    t.nama_tps");

        return $sql->result();
    }

    //--------------------------------GET HASIL PEMILIHAN--------------------------------------//
    public function get_sum_hasil_pemilihan($id_pemilihan = '', $id_wilayah_pemilihan = '') {

        $sql = $this->db->query("SELECT
                                    SUM(hp.dp_total) AS jumlah_dp,
                                    SUM(hp.php_total) AS jumlah_php,
                                    SUM(hp.dp_total)+SUM(hp.php_total) AS tambah_jumlah_php_dp,
                                    SUM(hp.total_suara_sah) AS jumlah_suara_sah,
                                    SUM(hp.total_suara_tidak_sah) AS jumlah_suara_tidak_sah
                                FROM
                                    hasil_pemilihan hp
                                WHERE
                                    hp.id_pemilihan = '$id_pemilihan' AND hp.id_wilayah_pemilihan = '$id_wilayah_pemilihan'");

        return $sql->result();
    }

//--------------------------------GET HASIL SUARA CALON--------------------------------------//
    public function get_hasil_suara_calon($id_pemilihan = '', $id_wilayah_pemilihan = '') {

        $sql = $this->db->query("SELECT
                                    sc.id_pemilihan,      
                                    sc.id_suara_calon,       
                                    sc.id_calon_pemilihan,
                                    sc.id_wilayah_pemilihan,
                                    sc.id_tps,
                                    sc.suara_sah,
                                    sc.tanggal_post,
                                    sc.status_data
                                FROM 
                                    suara_calon sc 
                                WHERE
                                    sc.id_pemilihan = '$id_pemilihan' AND sc.id_wilayah_pemilihan = '$id_wilayah_pemilihan' AND sc.status_data = 1");
        return $sql->result();
    }

    //---------------------------------------GET NAMA PEMILIHAN ---------------------------------------//
    public function get_nama_pemilihan($id_pemilihan = '') {

        $sql = $this->db->query("SELECT * FROM pemilihan where id_pemilihan='$id_pemilihan'");

        return $sql->result();
    }

    //---------------------------------------GET NAMA CALON ---------------------------------------//
    public function get_calon($id_pemilihan = '') {

        $sql = $this->db->query("SELECT * FROM calon_pemilihan where id_pemilihan='$id_pemilihan'");

        return $sql->result();
    }

    //---------------------------------------GET WILAYAH LAPORAN---------------------------------------//

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

    public function get_by_id_admin_reg($id_ref = '') {

        $this->db->select('id_ref, role_admin');
        $this->db->where('id_ref', $id_ref);

        $sql = $this->db->get($this->table_user);
        return $sql->result();
    }

}

?>