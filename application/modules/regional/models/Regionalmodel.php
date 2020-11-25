<?php

class Regionalmodel extends CI_Model {

    private $table_provinsi = 'wilayah_provinsi';
    private $table_kabupaten = 'wilayah_kabupaten';
    private $table_kecamatan = 'wilayah_kecamatan';
    private $table_kelurahan_desa = 'wilayah_desa';

    public function get_count() {

        $sql = $this->db->query("SELECT
                                        (
                                        SELECT
                                            COUNT(id)
                                        FROM
                                            wilayah_desa
                                    ) AS kelurahan,
                                    (
                                        SELECT
                                            COUNT(id)
                                        FROM
                                            wilayah_kecamatan
                                    ) AS kecamatan,
                                    (
                                        SELECT
                                            COUNT(id)
                                        FROM
                                            wilayah_kabupaten
                                    ) AS kabupaten,
                                    (
                                        SELECT
                                            COUNT(id)
                                        FROM
                                            wilayah_provinsi
                                    ) AS provinsi");

        return $sql->result();
    }

    public function cek_nama_provinsi($nama = '') {

        $sql = $this->db->query("SELECT
                                    nama
                                FROM
                                    wilayah_provinsi
                                WHERE 
                                    nama='$nama'");
        return $sql->result();
    }

    public function cek_nama_kabupaten($nama = '') {

        $sql = $this->db->query("SELECT
                                    nama
                                FROM
                                    wilayah_kabupaten
                                WHERE 
                                    nama='$nama'");
        return $sql->result();
    }

    public function cek_nama_kecamatan($nama = '') {

        $sql = $this->db->query("SELECT
                                    nama
                                FROM
                                    wilayah_kecamatan
                                WHERE 
                                    nama='$nama'");
        return $sql->result();
    }

    public function cek_nama_kelurahan($nama = '') {

        $sql = $this->db->query("SELECT
                                    nama
                                FROM
                                    wilayah_kelurahan
                                WHERE 
                                    nama='$nama'");
        return $sql->result();
    }

    public function get_nama_provinsi($id = '') {

        $sql = $this->db->query("SELECT
                                    nama
                                FROM
                                    wilayah_provinsi
                                WHERE 
                                    id='$id'");
        return $sql->result();
    }

    public function get_nama_kabupaten($id = '', $id_dati1 = '') {

        $sql = $this->db->query("SELECT
                                    nama
                                FROM
                                    wilayah_kabupaten
                                WHERE 
                                    id='$id' AND id_dati1 = '$id_dati1'");
        return $sql->result();
    }

    public function get_nama_kecamatan($id = '', $id_dati1 = '', $id_dati2 = '') {

        $sql = $this->db->query("SELECT
                                    nama
                                FROM
                                    wilayah_kecamatan
                                WHERE 
                                    id='$id' AND id_dati1 = '$id_dati1' AND id_dati2 = '$id_dati2'");
        return $sql->result();
    }

    public function get_max_id_provinsi() {

        $sql = $this->db->query("SELECT
                                    MAX(id) as max_id,
                                    MAX(code) as max_code
                                FROM
                                    wilayah_provinsi");
        return $sql->result();
    }

    public function get_max_id_kabupaten($id_dati1 = '') {

        $sql = $this->db->query("SELECT
                                    MAX(id) AS max_id,
                                    MAX(code) as max_code
                                FROM
                                    wilayah_kabupaten
                                WHERE
                                    id_dati1 = '$id_dati1'");

        return $sql->result();
    }

    public function get_max_id_kecamatan($id_dati1 = '', $id_dati2 = '') {

        $sql = $this->db->query("SELECT
                                    MAX(id) AS max_id
                                FROM
                                    wilayah_kecamatan
                                WHERE
                                    id_dati1 = '$id_dati1' AND id_dati2 = '$id_dati2'");

        return $sql->result();
    }

    public function get_max_id_kelurahan_desa($id_dati1 = '', $id_dati2 = '', $id_dati3 = '') {

        $sql = $this->db->query("SELECT
                                    MAX(id) AS max_id
                                FROM
                                    wilayah_desa
                                WHERE
                                    id_dati1 = '$id_dati1' AND id_dati2 = '$id_dati2' AND id_dati3 = '$id_dati3'");

        return $sql->result();
    }

    //--------------------------------------GET ID REGIONAL---------------------------------------//

    public function get_by_id_provinsi($id = '') {

        $this->db->select('*');
        $this->db->where('id', $id);

        $sql = $this->db->get($this->table_provinsi);
        return $sql->result();
    }

    public function get_by_id_kabupaten($id = '', $id_dati1 = '') {

        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->where('id_dati1', $id_dati1);


        $sql = $this->db->get($this->table_kabupaten);
        return $sql->result();
    }

    public function get_by_id_kecamatan($id = '', $id_dati1 = '', $id_dati2 = '') {

        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->where('id_dati1', $id_dati1);
        $this->db->where('id_dati2', $id_dati2);


        $sql = $this->db->get($this->table_kecamatan);
        return $sql->result();
    }

    public function get_by_id_kelurahan_desa($id = '', $id_dati1 = '', $id_dati2 = '', $id_dati3 = '') {

        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->where('id_dati1', $id_dati1);
        $this->db->where('id_dati2', $id_dati2);
        $this->db->where('id_dati3', $id_dati3);

        $sql = $this->db->get($this->table_kelurahan_desa);
        return $sql->result();
    }

    //--------------------------------------DAFTAR REGIONAL---------------------------------------//

    public function get_daftar_provinsi() {

        $this->db->select('*');

        $sql = $this->db->get($this->table_provinsi);
        return $sql->result();
    }

    public function get_daftar_kabupaten($id_dati1 = '') {

        $this->db->select('*');
        $this->db->where('id_dati1', $id_dati1);

        $sql = $this->db->get($this->table_kabupaten);
        return $sql->result();
    }

    public function get_daftar_kecamatan($id_dati1 = '', $id_dati2 = '') {

        $this->db->select('*');
        $this->db->where('id_dati1', $id_dati1);
        $this->db->where('id_dati2', $id_dati2);

        $sql = $this->db->get($this->table_kecamatan);
        return $sql->result();
    }

    public function get_daftar_kelurahan_desa($id_dati1 = '', $id_dati2 = '', $id_dati3 = '') {

        $this->db->select('*');
        $this->db->where('id_dati1', $id_dati1);
        $this->db->where('id_dati2', $id_dati2);
        $this->db->where('id_dati3', $id_dati3);

        $sql = $this->db->get($this->table_kelurahan_desa);
        return $sql->result();
    }

    //--------------------------------------INSERT REGIONAL---------------------------------------//

    public function insert_provinsi($value = '') {

        $this->db->trans_begin();

        $data = array(
            'code' => $value['code'],
            'nama' => strtoupper($value['nama']),
            'akronim' => $value['akronim'],
            'jml_penduduk' => $value['jml_penduduk'],
            'luas' => $value['luas']
        );

        $this->db->insert($this->table_provinsi, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function insert_kabupaten($value = '') {

        $this->db->trans_begin();

        $data = array(
            'id' => $value['id'],
            'id_dati1' => $value['id_dati1'],
            'code' => $value['code'],
            'nama' => strtoupper($value['nama']),
            'akronim' => $value['akronim'],
            'administratif' => $value['administratif'],
            'jml_penduduk' => $value['jml_penduduk'],
            'luas' => $value['luas']
        );

        $this->db->insert($this->table_kabupaten, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function insert_kecamatan($value = '') {

        $this->db->trans_begin();

        $data = array(
            'id' => $value['id'],
            'id_dati1' => $value['id_dati1'],
            'id_dati2' => $value['id_dati2'],
            'nama' => strtoupper($value['nama']),
            'akronim' => $value['akronim'],
            'jml_penduduk' => $value['jml_penduduk'],
            'luas' => $value['luas']
        );

        $this->db->insert($this->table_kecamatan, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function insert_kelurahan_desa($value = '') {

        $this->db->trans_begin();

        $data = array(
            'id' => $value['id'],
            'id_dati1' => $value['id_dati1'],
            'id_dati2' => $value['id_dati2'],
            'id_dati3' => $value['id_dati3'],
            'nama' => strtoupper($value['nama']),
            'akronim' => $value['akronim'],
            'administratif' => $value['administratif'],
            'kodepos' => $value['kodepos'],
            'jml_penduduk' => $value['jml_penduduk'],
            'luas' => $value['luas']
        );

        $this->db->insert($this->table_kelurahan_desa, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //--------------------------------------UPDATE REGIONAL---------------------------------------//

    public function update_provinsi($id = '', $value = '') {
        $this->db->trans_begin();

        $data = array(
            'code' => $value['code'],
            'nama' => strtoupper($value['nama']),
            'akronim' => $value['akronim'],
            'jml_penduduk' => $value['jml_penduduk'],
            'luas' => $value['luas']
        );

        $this->db->where('id', $id);
        $this->db->update($this->table_provinsi, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function update_kabupaten($id = '', $id_dati1 = '', $value = '') {
        $this->db->trans_begin();

        $data = array(
            'id' => $value['id'],
            'id_dati1' => $value['id_dati1'],
            'code' => $value['code'],
            'nama' => strtoupper($value['nama']),
            'akronim' => $value['akronim'],
            'administratif' => $value['administratif'],
            'jml_penduduk' => $value['jml_penduduk'],
            'luas' => $value['luas']
        );

        $this->db->where('id', $id);
        $this->db->where('id_dati1', $id_dati1);

        $this->db->update($this->table_kabupaten, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function update_kecamatan($id = '', $id_dati1 = '', $id_dati2 = '', $value = '') {
        $this->db->trans_begin();

        $data = array(
            'id' => $value['id'],
            'id_dati1' => $value['id_dati1'],
            'id_dati2' => $value['id_dati2'],
            'nama' => strtoupper($value['nama']),
            'akronim' => $value['akronim'],
            'jml_penduduk' => $value['jml_penduduk'],
            'luas' => $value['luas']
        );

        $this->db->where('id', $id);
        $this->db->where('id_dati1', $id_dati1);
        $this->db->where('id_dati2', $id_dati2);

        $this->db->update($this->table_kecamatan, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function update_kelurahan_desa($id = '', $id_dati1 = '', $id_dati2 = '', $id_dati3 = '', $value = '') {
        $this->db->trans_begin();

        $data = array(
            'id' => $value['id'],
            'id_dati1' => $value['id_dati1'],
            'id_dati2' => $value['id_dati2'],
            'id_dati3' => $value['id_dati3'],
            'nama' => strtoupper($value['nama']),
            'akronim' => $value['akronim'],
            'administratif' => $value['administratif'],
            'kodepos' => $value['kodepos'],
            'jml_penduduk' => $value['jml_penduduk'],
            'luas' => $value['luas']
        );

        $this->db->where('id', $id);
        $this->db->where('id_dati1', $id_dati1);
        $this->db->where('id_dati2', $id_dati2);
        $this->db->where('id_dati3', $id_dati3);
        $this->db->update($this->table_kelurahan_desa, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //--------------------------------------DELETE REGIONAL---------------------------------------//

    public function delete_provinsi($id = '') {
        $this->db->trans_begin();

        $this->db->where('id', $id);
        $this->db->delete($this->table_provinsi);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function delete_kabupaten($id = '', $id_dati1 = '') {
        $this->db->trans_begin();

        $this->db->where('id', $id);
        $this->db->where('id_dati1', $id_dati1);

        $this->db->delete($this->table_kabupaten);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function delete_kecamatan($id = '', $id_dati1 = '', $id_dati2 = '') {
        $this->db->trans_begin();

        $this->db->where('id', $id);
        $this->db->where('id_dati1', $id_dati1);
        $this->db->where('id_dati2', $id_dati2);

        $this->db->delete($this->table_kecamatan);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function delete_kelurahan_desa($id = '', $id_dati1 = '', $id_dati2 = '', $id_dati3 = '') {
        $this->db->trans_begin();

        $this->db->where('id', $id);
        $this->db->where('id_dati1', $id_dati1);
        $this->db->where('id_dati2', $id_dati2);
        $this->db->where('id_dati3', $id_dati3);

        $this->db->delete($this->table_kelurahan_desa);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //----------------------------------------AJAX REGIONAL-------------------------------------------//

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