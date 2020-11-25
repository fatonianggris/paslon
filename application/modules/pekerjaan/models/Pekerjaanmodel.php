<?php

class Pekerjaanmodel extends CI_Model {

    private $table_pekerjaan = 'pekerjaan';

    public function get_count() {

        $sql = $this->db->query("SELECT
                                    (
                                    SELECT
                                        COUNT(id)
                                    FROM
                                        pekerjaan
                                ) AS pekerjaan,
                                (
                                    SELECT
                                        COUNT(id_ktp)
                                    FROM
                                        ktp
                                ) AS anggota,
                                (
                                    SELECT
                                        COUNT(id_user)
                                    FROM
                                        user
                                ) AS regional_admin");

        return $sql->result();
    }

    //---------------------------------------GET user---------------------------------------//

    public function get_pekerjaan() {

        $this->db->select('*');

        $sql = $this->db->get($this->table_pekerjaan);
        return $sql->result();
    }

    //---------------------------------------UPDATE user---------------------------------------//

    public function update_pekerjaan($id = '', $value = '') {

        $this->db->trans_begin();

        $data = array(
            'job' => $value['job']
        );

        $this->db->where('id', $id);
        $this->db->update($this->table_pekerjaan, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //--------------------------------INSERT PEKERJAAN-----------------------------------------//

    public function insert_pekerjaan($value = '') {

        $this->db->trans_begin();

        $data = array(
            'job' => $value['job'],
        );
        $this->db->insert($this->table_pekerjaan, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //--------------------------------DELETE PEKERJAAN-----------------------------------------//


    public function delete_pekerjaan($value) {
        $this->db->trans_begin();

        $this->db->where('id', $value);
        $this->db->delete($this->table_pekerjaan);

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