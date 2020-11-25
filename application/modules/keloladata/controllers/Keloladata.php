<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Keloladata extends MX_Controller {

    public function __construct() {
        parent::__construct();
        //Do your magic here 
        $this->load->model('Keloladatamodel');
        if ($this->session->userdata('ktpapps') == FALSE) {
            redirect('auth');
        }
        $this->user = $this->session->userdata("ktpapps");
    }

    //---------------------------------------ANGGOTA--------------------------------------------------//

    public function data_ktp() {

        $data['ktp'] = $this->Keloladatamodel->get_ktp($this->user['id_ref'], $this->user['role_admin']);
        $data['count'] = $this->Keloladatamodel->get_count_ktp($this->user['id_ref'], $this->user['role_admin']);
        $data['petugas'] = $this->Keloladatamodel->get_petugas_ktp($this->user['id_ref'], $this->user['role_admin']);
        $data['kec'] = $this->Keloladatamodel->get_kecamatan(); //?
        $data['kel'] = $this->Keloladatamodel->get_kelurahan(); //?
        $data['prov'] = $this->Keloladatamodel->get_provinsi(); //?
        $data['kab'] = $this->Keloladatamodel->get_kabupaten(); //?
        $this->template->load('template_admin/template_admin', 'daftar_ktp', $data);
    }

    public function ubah_status_ktp() {

        $id = $this->input->post('id');
        $status = $this->input->post('status');

        if (isset($id) && isset($status)) {
            $this->Keloladatamodel->ubah_status_ktp($id, $status);
            echo '1|' . succ_msg('Berhasil, Data Telah Terupdate..');
        } else {
            echo '0|' . err_msg('Maaf, Terjadi kesalahan, Coba lagi....');
        }
    }

    public function delete_ktp() {

        $id = $this->input->post('id');
        $data = $this->Keloladatamodel->get_img_by_id_ktp($id, $this->user['id_ref'], $this->user['role_admin']);
        $data_img = explode('/', $data[0]->img);
        $name_img = $data_img[4];
        $delete = $this->Keloladatamodel->delete_ktp($id, $this->user['id_ref'], $this->user['role_admin']);
        if ($delete == true) {
            if ($this->user['role_admin'] == 0) {
                $this->delete_file_ktp($name_img, $data[0]->id_admin);
            }
            echo '1|' . succ_msg('Berhasil, Data Telah Terhapus..');
        } else {
            echo '0|' . err_msg('Maaf, Terjadi kesalahan, Coba lagi....');
        }
    }

    public function delete_file_ktp($name = '', $id = '') {

        $path_reg = $this->Keloladatamodel->get_path_by_id_reg($id, $this->user['id_ref'], $this->user['role_admin']);

        $path = $path_reg[0]->path . '/';
        $path_thumb = $path_reg[0]->path . '/thumbs/';
        @unlink($path . $name);
        @unlink($path_thumb . $name);
    }

//-------------------------------------------PETUGAS------------------------------------------//

    public function data_petugas() {

        $data['petugas'] = $this->Keloladatamodel->get_petugas_pet($this->user['id_ref'], $this->user['role_admin']);
        $data['count'] = $this->Keloladatamodel->get_count_pet($this->user['id_ref'], $this->user['role_admin']);
        $this->template->load('template_admin/template_admin', 'daftar_petugas', $data);
    }

    public function ubah_status_pet() {

        $id = $this->input->post('id');
        $status = $this->input->post('status');

        if (isset($id) && isset($status)) {
            $this->Keloladatamodel->ubah_status_petugas($id, $status);
            $this->Keloladatamodel->ubah_status_ktp_pet($id);
            echo '1|' . succ_msg('Berhasil, Data Telah Terupdate..');
        } else {
            echo '0|' . err_msg('Maaf, Terjadi kesalahan, Coba lagi....');
        }
    }

    public function delete_petugas() {

        $id = $this->input->post('id');
        $data = $this->Keloladatamodel->get_img_by_id_petugas($id, $this->user['id_ref'], $this->user['role_admin']);
        $data_img = explode('/', $data[0]->img);
        $name_img = $data_img[2];
        $delete = $this->Keloladatamodel->delete_petugas($id, $this->user['id_ref'], $this->user['role_admin']);
        $update_status_ktp = $this->Keloladatamodel->update_status_ktp_pet($id, $this->user['id_ref'], $this->user['role_admin']);
        if ($delete == TRUE && $update_status_ktp == TRUE) {
            if ($this->user['role_admin'] == 0) {
                $this->delete_file_pet($name_img);
            }
            echo '1|' . succ_msg('Berhasil, Data Telah Terhapus..');
        } else {
            echo '0|' . err_msg('Maaf, Terjadi kesalahan, Coba lagi....');
        }
    }

    public function delete_file_pet($name = '') {
        $path = './uploads/petugas/';
        $path_thumb = './uploads/petugas/thumbs/';
        @unlink($path . $name);
        @unlink($path_thumb . $name);
    }

}
