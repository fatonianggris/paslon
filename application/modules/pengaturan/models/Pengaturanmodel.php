<?php

class Pengaturanmodel extends CI_Model {

    private $table_user = 'user';
    private $table_template = 'template';

    //---------------------------------------GET user---------------------------------------//

    public function get_by_id_user($id = '') {
        $this->db->where('id_user', $id);
        $sql = $this->db->get($this->table_user);
        return $sql->result();
    }

    //---------------------------------------UPDATE user---------------------------------------//

    public function update_user($id = '', $value = '') {
        $this->db->trans_begin();

        $data = array(
            'nama_admin' => $value['nama_admin'],
            'email' => $value['email'],
            'nomor_hp' => $value['nomor_hp'],
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

    public function get_img_by_id_user($id = '') {
        $this->db->select('img');
        $this->db->where('id_user', $id);
        $sql = $this->db->get($this->table_user);
        return $sql->result();
    }

    //--------------------------------GET TEMPLATE-----------------------------------------//

    public function get_by_id_template($id = '') {
        $this->db->where('id_template', $id);
        $sql = $this->db->get($this->table_template);
        return $sql->result();
    }

    //---------------------------------------UPDATE TEMPLATE---------------------------------------//
    public function update_template($id = '', $value = '') {
        $this->db->trans_begin();

        $data = array(
            'judul_website' => $value['judul_website'],
            'nama_website' => $value['nama_website'],
            'warna_website' => $value['warna_website'],
            'logo_website' => $value['pic1'],
            'logo_nama_website' => $value['pic2'],
            'logo_favicon' => $value['pic3']
        );

        $this->db->where('id_template', $id);
        $this->db->update($this->table_template, $data);

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