<?php

class Authmodel extends CI_Model {

    private $table_user = 'user';

    public function get_user($value = '') {
        $passwd = md5($value['password']);
        $this->db->where('email', $value['email']);
        $this->db->where('password', $passwd);
        $sql = $this->db->get($this->table_user);
        return $sql->row_array();
    }

    public function get_template() {
        $sql = $this->db->query('SELECT * FROM template WHERE id_template=1');
        return $sql->result();
    }

}

?>