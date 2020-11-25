<?php

class Datatablemodel extends CI_Model {

    private $table_format = 'format_cetak';

    public function get_label($id = '') {

        $this->db->select('*');
        $this->db->where('id_format', $id);

        $sql = $this->db->get($this->table_format);
        return $sql->result();
    }

}

?>