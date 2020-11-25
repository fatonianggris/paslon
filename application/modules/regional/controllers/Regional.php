<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Regional extends MX_Controller {

    public function __construct() {
        parent::__construct();
//Do your magic here 
        $this->load->model('Regionalmodel');
        if ($this->session->userdata('ktpapps') == FALSE) {
            redirect('auth');
        }
        $this->user = $this->session->userdata("ktpapps");
    }

//---------------------------------------DAFTAR REGIONAL---------------------------------------//

    public function daftar_provinsi() {

        $data['daftar_provinsi'] = $this->Regionalmodel->get_daftar_provinsi();

        $data['count'] = $this->Regionalmodel->get_count();
        $this->template->load('template_admin/template_admin', 'daftar_provinsi', $data);
    }

    public function daftar_kabupaten($id_dati1 = '') {

        $data['daftar_kabupaten'] = $this->Regionalmodel->get_daftar_kabupaten($id_dati1);
        $data['get_nama_prov'] = $this->Regionalmodel->get_nama_provinsi($id_dati1);
        $data['count'] = $this->Regionalmodel->get_count();
        $this->template->load('template_admin/template_admin', 'daftar_kabupaten', $data);
    }

    public function daftar_kecamatan($id_dati1 = '', $id_dati2 = '') {

        $data['daftar_kecamatan'] = $this->Regionalmodel->get_daftar_kecamatan($id_dati1, $id_dati2);
        $data['get_nama_prov'] = $this->Regionalmodel->get_nama_provinsi($id_dati1);
        $data['get_nama_kab'] = $this->Regionalmodel->get_nama_kabupaten($id_dati1, $id_dati2);
        $data['count'] = $this->Regionalmodel->get_count();
        $this->template->load('template_admin/template_admin', 'daftar_kecamatan', $data);
    }

    public function daftar_kelurahan_desa($id_dati1 = '', $id_dati2 = '', $id_dati3 = '') {

        $data['daftar_kelurahan_desa'] = $this->Regionalmodel->get_daftar_kelurahan_desa($id_dati1, $id_dati2, $id_dati3);
        $data['get_nama_prov'] = $this->Regionalmodel->get_nama_provinsi($id_dati1);
        $data['get_nama_kab'] = $this->Regionalmodel->get_nama_kabupaten($id_dati1, $id_dati2);
        $data['get_nama_kec'] = $this->Regionalmodel->get_nama_kecamatan($id_dati1, $id_dati2, $id_dati3);
        $data['count'] = $this->Regionalmodel->get_count();
        $this->template->load('template_admin/template_admin', 'daftar_kelurahan_desa', $data);
    }

//---------------------------------------TAMBAH REGIONAL---------------------------------------//

    public function tambah_provinsi() {

        $data['prov'] = $this->Regionalmodel->get_provinsi(); //?
        $data['kab'] = $this->Regionalmodel->get_kabupaten(); //?
        $data['kec'] = $this->Regionalmodel->get_kecamatan(); //?
        $data['kel'] = $this->Regionalmodel->get_kelurahan(); //?

        $this->template->load('template_admin/template_admin', 'tambah_provinsi', $data);
    }

    public function tambah_kabupaten() {

        $data['prov'] = $this->Regionalmodel->get_provinsi(); //?
        $data['kab'] = $this->Regionalmodel->get_kabupaten(); //?
        $data['kec'] = $this->Regionalmodel->get_kecamatan(); //?
        $data['kel'] = $this->Regionalmodel->get_kelurahan(); //?

        $this->template->load('template_admin/template_admin', 'tambah_kabupaten', $data);
    }

    public function tambah_kecamatan() {

        $data['prov'] = $this->Regionalmodel->get_provinsi(); //?
        $data['kab'] = $this->Regionalmodel->get_kabupaten(); //?
        $data['kec'] = $this->Regionalmodel->get_kecamatan(); //?
        $data['kel'] = $this->Regionalmodel->get_kelurahan(); //?

        $this->template->load('template_admin/template_admin', 'tambah_kecamatan', $data);
    }

    public function tambah_kelurahan_desa() {

        $data['prov'] = $this->Regionalmodel->get_provinsi(); //?
        $data['kab'] = $this->Regionalmodel->get_kabupaten(); //?
        $data['kec'] = $this->Regionalmodel->get_kecamatan(); //?
        $data['kel'] = $this->Regionalmodel->get_kelurahan(); //?

        $this->template->load('template_admin/template_admin', 'tambah_kelurahan_desa', $data);
    }

//---------------------------------------GET REGIONAL---------------------------------------//

    public function get_provinsi_form($id = '') {

        $data['prov'] = $this->Regionalmodel->get_provinsi(); //?
        $data['kab'] = $this->Regionalmodel->get_kabupaten(); //?
        $data['kec'] = $this->Regionalmodel->get_kecamatan(); //?
        $data['kel'] = $this->Regionalmodel->get_kelurahan(); //?

        $cek = $this->Regionalmodel->get_by_id_provinsi($id);
        if ($cek == FALSE or empty($id)) {
            $data = array();
            $this->load->view('error_404', $data);
        } else {
            $data['provinsi'] = $this->Regionalmodel->get_by_id_provinsi($id);
            $this->template->load('template_admin/template_admin', 'edit_provinsi', $data);
        }
    }

    public function get_kabupaten_form($id = '', $id_dati1 = '') {

        $data['prov'] = $this->Regionalmodel->get_provinsi(); //?
        $data['kab'] = $this->Regionalmodel->get_kabupaten(); //?
        $data['kec'] = $this->Regionalmodel->get_kecamatan(); //?
        $data['kel'] = $this->Regionalmodel->get_kelurahan(); //?

        $cek = $this->Regionalmodel->get_by_id_kabupaten($id, $id_dati1);
        if ($cek == FALSE or empty($id) or empty($id_dati1)) {
            $data = array();
            $this->load->view('error_404', $data);
        } else {
            $data['kabupaten'] = $this->Regionalmodel->get_by_id_kabupaten($id, $id_dati1);
            $this->template->load('template_admin/template_admin', 'edit_kabupaten', $data);
        }
    }

    public function get_kecamatan_form($id = '', $id_dati1 = '', $id_dati2 = '') {

        $data['prov'] = $this->Regionalmodel->get_provinsi(); //?
        $data['kab'] = $this->Regionalmodel->get_kabupaten(); //?
        $data['kec'] = $this->Regionalmodel->get_kecamatan(); //?
        $data['kel'] = $this->Regionalmodel->get_kelurahan(); //?

        $cek = $this->Regionalmodel->get_by_id_kecamatan($id, $id_dati1, $id_dati2);
        if ($cek == FALSE or empty($id) or empty($id_dati1) or empty($id_dati2)) {
            $data = array();
            $this->load->view('error_404', $data);
        } else {
            $data['kecamatan'] = $this->Regionalmodel->get_by_id_kecamatan($id, $id_dati1, $id_dati2);
            $this->template->load('template_admin/template_admin', 'edit_kecamatan', $data);
        }
    }

    public function get_kelurahan_desa_form($id = '', $id_dati1 = '', $id_dati2 = '', $id_dati3 = '') {

        $data['prov'] = $this->Regionalmodel->get_provinsi(); //?
        $data['kab'] = $this->Regionalmodel->get_kabupaten(); //?
        $data['kec'] = $this->Regionalmodel->get_kecamatan(); //?
        $data['kel'] = $this->Regionalmodel->get_kelurahan(); //?

        $cek = $this->Regionalmodel->get_by_id_kelurahan_desa($id, $id_dati1, $id_dati2, $id_dati3);
        if ($cek == FALSE or empty($id) or empty($id_dati1) or empty($id_dati2) or empty($id_dati3)) {
            $data = array();
            $this->load->view('error_404', $data);
        } else {
            $data['kelurahan_desa'] = $this->Regionalmodel->get_by_id_kelurahan_desa($id, $id_dati1, $id_dati2, $id_dati3);
            $this->template->load('template_admin/template_admin', 'edit_kelurahan_desa', $data);
        }
    }

    //---------------------------------------KIRIM REGIONAL---------------------------------------//

    public function kirim_provinsi() {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('nama', 'Nama Provinsi', 'required');

        $id_max = $this->Regionalmodel->get_max_id_provinsi();

        $cek_nama = $this->Regionalmodel->cek_nama_provinsi($data['nama']);

        if ($cek_nama == TRUE or ! empty($cek_nama)) {

            $this->session->set_flashdata('flash_message', succ_msg("Maaf, Nama Provinsi .$data[nama]. sudah dibuat.."));
            redirect('regional/tambah_provinsi');
        } else {

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                redirect('regional/tambah_provinsi'); //folder, controller, method
            } else {

                $data['code'] = $id_max[0]->max_code + 1;

                $input = $this->Regionalmodel->insert_provinsi($data);
                if ($input == true) {
                    $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data telah tersimpan..'));
                    redirect('regional/tambah_provinsi');
                } else {
                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                    redirect('regional/tambah_provinsi');
                }
            }
        }
    }

    public function kirim_kabupaten() {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('id_dati1', 'Regional Provinsi', 'required');
        $this->form_validation->set_rules('administratif', 'Administratif Kabupaten', 'required');
        $this->form_validation->set_rules('nama', 'Nama Kabupaten', 'required');

        $id_max = $this->Regionalmodel->get_max_id_kabupaten($data['id_dati1']);

        $cek_nama = $this->Regionalmodel->cek_nama_kabupaten($data['nama']);

        if ($cek_nama == TRUE or ! empty($cek_nama)) {

            $this->session->set_flashdata('flash_message', succ_msg("Maaf, Nama Kabupaten .$data[nama]. sudah dibuat.."));
            redirect('regional/tambah_kabupaten');
        } else {
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                redirect('regional/tambah_kabupaten'); //folder, controller, method
            } else {

                $data['id'] = $id_max[0]->max_id + 1;
                $data['code'] = $id_max[0]->max_code + 1;

                $input = $this->Regionalmodel->insert_kabupaten($data);
                if ($input == true) {
                    $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data telah tersimpan..'));
                    redirect('regional/tambah_kabupaten');
                } else {
                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                    redirect('regional/tambah_kabupaten');
                }
            }
        }
    }

    public function kirim_kecamatan() {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('id_dati1', 'Regional Provinsi', 'required');
        $this->form_validation->set_rules('id_dati2', 'Regional Kabupaten', 'required');
        $this->form_validation->set_rules('nama', 'Nama Kecamatan', 'required');

        $id_max = $this->Regionalmodel->get_max_id_kecamatan($data['id_dati1'], $data['id_dati2']);

        $cek_nama = $this->Regionalmodel->cek_nama_kecamatan($data['nama']);

        if ($cek_nama == TRUE or ! empty($cek_nama)) {

            $this->session->set_flashdata('flash_message', succ_msg("Maaf, Nama Kecamatan .$data[nama]. sudah dibuat.."));
            redirect('regional/tambah_kecamatan');
        } else {
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                redirect('regional/tambah_kecamatan'); //folder, controller, method
            } else {

                $data['id'] = $id_max[0]->max_id + 1;

                $input = $this->Regionalmodel->insert_kecamatan($data);
                if ($input == true) {
                    $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data telah tersimpan..'));
                    redirect('regional/tambah_kecamatan');
                } else {
                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                    redirect('regional/tambah_kecamatan');
                }
            }
        }
    }

    public function kirim_kelurahan_desa() {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('id_dati1', 'Regional Provinsi', 'required');
        $this->form_validation->set_rules('id_dati2', 'Regional Kabupaten', 'required');
        $this->form_validation->set_rules('id_dati3', 'Regional Kecamatan', 'required');
        $this->form_validation->set_rules('administratif', 'Administratif Kelurahan/Desa', 'required');
        $this->form_validation->set_rules('nama', 'Nama Kelurahan/Desa', 'required');

        $id_max = $this->Regionalmodel->get_max_id_kelurahan_desa($data['id_dati1'], $data['id_dati2'], $data['id_dati3']);

        $cek_nama = $this->Regionalmodel->cek_nama_kelurahan($data['nama']);

        if ($cek_nama == TRUE or ! empty($cek_nama)) {

            $this->session->set_flashdata('flash_message', succ_msg("Maaf, Nama Kelurahan .$data[nama]. sudah dibuat.."));
            redirect('regional/tambah_kelurahan_desa');
        } else {
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                redirect('regional/tambah_kelurahan_desa'); //folder, controller, method
            } else {

                $data['id'] = $id_max[0]->max_id + 1;

                $input = $this->Regionalmodel->insert_kelurahan_desa($data);
                if ($input == true) {
                    $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data telah tersimpan..'));
                    redirect('regional/tambah_kelurahan_desa');
                } else {
                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                    redirect('regional/tambah_kelurahan_desa');
                }
            }
        }
    }

    //---------------------------------------EDIT REGIONAL---------------------------------------//

    public function edit_provinsi($id = '') {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('nama', 'Nama Provinsi', 'required');

        $cek = $this->Regionalmodel->get_by_id_provinsi($id);

        $cek_nama = $this->Regionalmodel->cek_nama_provinsi($data['nama']);

        if ($cek_nama == TRUE && $cek[0]->nama != $data['nama']) {

            $this->session->set_flashdata('flash_message', warn_msg("Maaf, Nama Provinsi .$data[nama]. sudah dibuat.."));
            redirect('regional/get_provinsi_form/' . $id);
            
        } else {
            if ($cek == FALSE or empty($id)) {

                $data = array();
                $this->load->view('error_404', $data);
            } else {

                if ($this->form_validation->run() == FALSE) {

                    $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                    redirect('regional/get_provinsi_form/' . $id);
                } else {

                    $edit = $this->Regionalmodel->update_provinsi($id, $data);
                    if ($edit == true) {
                        $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data Telah Tersimpan..'));
                        redirect('regional/get_provinsi_form/' . $id);
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                        redirect('regional/get_provinsi_form/' . $id);
                    }
                }
            }
        }
    }

    public function edit_kabupaten($id = '', $id_dati1 = '') {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('id_dati1', 'Regional Provinsi', 'required');
        $this->form_validation->set_rules('administratif', 'Administratif Kabupaten', 'required');
        $this->form_validation->set_rules('nama', 'Nama Kabupaten', 'required');

        $cek = $this->Regionalmodel->get_by_id_kabupaten($id, $id_dati1);
        $id_max = $this->Regionalmodel->get_max_id_kabupaten($data['id_dati1']);

        $cek_nama = $this->Regionalmodel->cek_nama_provinsi($data['nama']);

        if ($cek_nama == TRUE && $cek[0]->nama != $data['nama']) {

            $this->session->set_flashdata('flash_message', warn_msg("Maaf, Nama Kabupaten .$data[nama]. sudah dibuat.."));
            redirect('regional/get_kabupaten_form/' . $id . '/' . $id_dati1);
        } else {
            if ($cek == FALSE or empty($id)) {
                $data = array();
                $this->load->view('error_404', $data);
            } else {

                if ($this->form_validation->run() == FALSE) {

                    $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                    redirect('regional/get_kabupaten_form/' . $id . '/' . $id_dati1);
                } else {
                    $data['id'] = $id_max[0]->max_id + 1;
                    $data['code'] = $id_max[0]->max_code + 1;

                    $edit = $this->Regionalmodel->update_kabupaten($id, $id_dati1, $data);
                    if ($edit == true) {
                        $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data Telah Tersimpan..'));
                        redirect('regional/daftar_kabupaten/' . $id_dati1);
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                        redirect('regional/get_kabupaten_form/' . $id . '/' . $id_dati1);
                    }
                }
            }
        }
    }

    public function edit_kecamatan($id = '', $id_dati1 = '', $id_dati2 = '') {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('id_dati1', 'Regional Provinsi', 'required');
        $this->form_validation->set_rules('id_dati2', 'Regional Kabupaten', 'required');
        $this->form_validation->set_rules('nama', 'Nama Kecamatan', 'required');

        $cek = $this->Regionalmodel->get_by_id_kecamatan($id, $id_dati1, $id_dati2);
        $id_max = $this->Regionalmodel->get_max_id_kecamatan($data['id_dati1'], $data['id_dati2']);


        $cek_nama = $this->Regionalmodel->cek_nama_kecamatan($data['nama']);

        if ($cek_nama == TRUE && $cek[0]->nama != $data['nama']) {

            $this->session->set_flashdata('flash_message', warn_msg("Maaf, Nama Kecamatan .$data[nama]. sudah dibuat.."));
            redirect('regional/get_kecamatan_form/' . $id . '/' . $id_dati1 . '/' . $id_dati2);
        } else {
            if ($cek == FALSE or empty($id)) {
                $data = array();
                $this->load->view('error_404', $data);
            } else {

                if ($this->form_validation->run() == FALSE) {

                    $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                    redirect('regional/get_kecamatan_form/' . $id . '/' . $id_dati1 . '/' . $id_dati2);
                } else {
                    $data['id'] = $id_max[0]->max_id + 1;

                    $edit = $this->Regionalmodel->update_kecamatan($id, $id_dati1, $id_dati2, $data);
                    if ($edit == true) {
                        $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data Telah Tersimpan..'));
                        redirect('regional/daftar_kecamatan/' . $id_dati1 . '/' . $id_dati2);
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                        redirect('regional/get_kecamatan_form/' . $id . '/' . $id_dati1 . '/' . $id_dati2);
                    }
                }
            }
        }
    }

    public function edit_kelurahan_desa($id = '', $id_dati1 = '', $id_dati2 = '', $id_dati3 = '') {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('id_dati1', 'Regional Provinsi', 'required');
        $this->form_validation->set_rules('id_dati2', 'Regional Kabupaten', 'required');
        $this->form_validation->set_rules('id_dati3', 'Regional Kecamatan', 'required');
        $this->form_validation->set_rules('nama', 'Nama Kelurahan/Desa', 'required');
        $this->form_validation->set_rules('administratif', 'Administratif Kelurahan/Desa', 'required');

        $cek = $this->Regionalmodel->get_by_id_kelurahan_desa($id, $id_dati1, $id_dati2, $id_dati3);
        $id_max = $this->Regionalmodel->get_max_id_kelurahan_desa($data['id_dati1'], $data['id_dati2'], $data['id_dati3']);

        $cek_nama = $this->Regionalmodel->cek_nama_kelurahan($data['nama']);

        if ($cek_nama == TRUE && $cek[0]->nama != $data['nama']) {

            $this->session->set_flashdata('flash_message', warn_msg("Maaf, Nama Kelurahan .$data[nama]. sudah dibuat.."));
            redirect('regional/get_kelurahan_desa_form/' . $id . '/' . $id_dati1 . '/' . $id_dati2 . '/' . $id_dati3);
        } else {

            if ($cek == FALSE or empty($id)) {
                $data = array();
                $this->load->view('error_404', $data);
            } else {

                if ($this->form_validation->run() == FALSE) {

                    $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                    redirect('regional/get_kelurahan_desa_form/' . $id . '/' . $id_dati1 . '/' . $id_dati2 . '/' . $id_dati3);
                } else {
                    $data['id'] = $id_max[0]->max_id + 1;

                    $edit = $this->Regionalmodel->update_kelurahan_desa($id, $id_dati1, $id_dati2, $id_dati3, $data);
                    if ($edit == true) {
                        $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data Telah Tersimpan..'));
                        redirect('regional/daftar_kelurahan_desa/' . $id_dati1 . '/' . $id_dati2 . '/' . $id_dati3);
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                        redirect('regional/get_kelurahan_desa_form/' . $id . '/' . $id_dati1 . '/' . $id_dati2 . '/' . $id_dati3);
                    }
                }
            }
        }
    }

    //---------------------------------------DELETE REGIONAL---------------------------------------//

    public function delete_provinsi() {

        $id = $this->input->post('id');

        $delete = $this->Regionalmodel->delete_provinsi($id);

        if ($delete == TRUE) {
            echo '1|' . succ_msg('Berhasil, Data Telah Terhapus..');
        } else {
            echo '0|' . err_msg('Maaf, Terjadi kesalahan, Coba lagi....');
        }
    }

    public function delete_kabupaten() {

        $id = $this->input->post('id');
        $id_dati1 = $this->input->post('id_dati1');

        $delete = $this->Regionalmodel->delete_kabupaten($id, $id_dati1);

        if ($delete == TRUE) {
            echo '1|' . succ_msg('Berhasil, Data Telah Terhapus..');
        } else {
            echo '0|' . err_msg('Maaf, Terjadi kesalahan, Coba lagi....');
        }
    }

    public function delete_kecamatan() {

        $id = $this->input->post('id');
        $id_dati1 = $this->input->post('id_dati1');
        $id_dati2 = $this->input->post('id_dati2');

        $delete = $this->Regionalmodel->delete_kecamatan($id, $id_dati1, $id_dati2);

        if ($delete == TRUE) {
            echo '1|' . succ_msg('Berhasil, Data Telah Terhapus..');
        } else {
            echo '0|' . err_msg('Maaf, Terjadi kesalahan, Coba lagi....');
        }
    }

    public function delete_kelurahan_desa() {

        $id = $this->input->post('id');
        $id_dati1 = $this->input->post('id_dati1');
        $id_dati2 = $this->input->post('id_dati2');
        $id_dati3 = $this->input->post('id_dati3');

        $delete = $this->Regionalmodel->delete_kelurahan_desa($id, $id_dati1, $id_dati2, $id_dati3);

        if ($delete == TRUE) {
            echo '1|' . succ_msg('Berhasil, Data Telah Terhapus..');
        } else {
            echo '0|' . err_msg('Maaf, Terjadi kesalahan, Coba lagi....');
        }
    }

    //---------------------------------------GET AJAX ANGGOTA KTP---------------------------------------//

    function add_ajax_kab($id_prov) {
        $query = $this->db->get_where('wilayah_kabupaten', array('id_dati1' => $id_prov));
        $data = "<option></option>";
        foreach ($query->result() as $value) {
            $data .= "<option value='" . $value->id . "'>" . $value->nama . " [" . strtoupper($value->administratif) . "]" . "</option>";
        }
        echo $data;
    }

    function add_ajax_kec($id_prov, $id_kab) {
        $query = $this->db->get_where('wilayah_kecamatan', array('id_dati1' => $id_prov, 'id_dati2' => $id_kab));
        $data = "<option></option>";
        foreach ($query->result() as $value) {
            $data .= "<option value='" . $value->id . "'>" . $value->nama . "</option>";
        }
        echo $data;
    }

    function add_ajax_des($id_prov, $id_kab, $id_kec) {
        $query = $this->db->get_where('wilayah_desa', array('id_dati1' => $id_prov, 'id_dati2' => $id_kab, 'id_dati3' => $id_kec));
        $data = "<option></option>";
        foreach ($query->result() as $value) {
            $data .= "<option value='" . $value->id . "'>" . $value->nama . " [" . strtoupper($value->administratif) . "]" . "</option>";
        }
        echo $data;
    }

}
