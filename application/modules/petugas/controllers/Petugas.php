<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Petugas extends MX_Controller {

    public function __construct() {
        parent::__construct();
        //Do your magic here 
        $this->load->model('Petugasmodel');
        if ($this->session->userdata('ktpapps') == FALSE) {
            redirect('auth');
        }
        $this->user = $this->session->userdata("ktpapps");
    }

    //---------------------------------------INDEX PETUGAS---------------------------------------//
    public function index() {

        $data['petugas'] = $this->Petugasmodel->get_petugas($this->user['id_ref'], $this->user['role_admin']);
        $data['count'] = $this->Petugasmodel->get_count($this->user['id_ref'], $this->user['role_admin']);

        $this->template->load('template_admin/template_admin', 'daftar_petugas', $data);
    }

    //---------------------------------------TAMBAH PETUGAS---------------------------------------//

    public function tambah_petugas() {

        $data['count'] = $this->Petugasmodel->get_count($this->user['id_ref'], $this->user['role_admin']);
        $data['admin_regional'] = $this->Petugasmodel->get_admin_regional($this->user['id_ref'], $this->user['role_admin']);
        $data['admin'] = $this->Petugasmodel->get_admin(); //?
        $this->template->load('template_admin/template_admin', 'tambah_petugas', $data);
    }

    public function tambah_petugas_anggota($id = '') {

        $data['anggota_petugas'] = $this->Petugasmodel->get_anggota_petugas($id);
        $data['count'] = $this->Petugasmodel->get_count($this->user['id_ref'], $this->user['role_admin']);
        $data['admin_regional'] = $this->Petugasmodel->get_admin_regional($this->user['id_ref'], $this->user['role_admin']);
        $data['admin'] = $this->Petugasmodel->get_admin(); //?
        $this->template->load('template_admin/template_admin', 'tambah_petugas_anggota', $data);
    }

//---------------------------------------GET PETUGAS---------------------------------------//
    public function get_petugas($id = '') {

        $data['petugas'] = $this->Petugasmodel->get_by_id_petugas($id, $this->user['id_ref'], $this->user['role_admin']); //?
        $data['admin_regional'] = $this->Petugasmodel->get_admin_regional($this->user['id_ref'], $this->user['role_admin']);
        $cek = $this->Petugasmodel->get_by_id_petugas($id, $this->user['id_ref'], $this->user['role_admin']);
        if ($cek == FALSE or empty($id)) {
            $data = array();
            $this->load->view('error_404', $data);
        } else {
            //edit data with id
            $this->template->load('template_admin/template_admin', 'edit_petugas', $data);
        }
    }

//---------------------------------------KIRIM PETUGAS---------------------------------------//

    public function kirim_petugas_anggota() {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('nama_petugas', 'Nama Lengkap Petugas', 'required');
        $this->form_validation->set_rules('email_petugas', 'Email Petugas', 'required');
        $this->form_validation->set_rules('nomor_hp', 'Nomor Handphone', 'required');
        $this->form_validation->set_rules('region_petugas', 'Regional Petugas', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]|matches[cf_passwd]');
        $this->form_validation->set_rules('cf_passwd', 'Password Konfirmasi', 'required|min_length[4]');

        if ($data['image'] != "" && $data['image_thumb'] != "") {
            $content_img = file_get_contents(base_url() . $data['image']);
            $content_img_thumb = file_get_contents(base_url() . $data['image_thumb']);

            $path = 'uploads/petugas/';
            $path_thumb = 'uploads/petugas/thumbs/';

            $data_img = explode('/', $data['image']);
            $img_name = $data_img[2];

            $data_img_thumb = explode('/', $data['image_thumb']);
            $img_name_thumb = $data_img_thumb[2];

            file_put_contents($path . $img_name, $content_img);
            file_put_contents($path_thumb . $img_name_thumb, $content_img_thumb);

            $data['pic'] = $path . $img_name;
            $data['pic_thumb'] = $path_thumb . $img_name_thumb;
        }

        if ($data['password'] == $data['cf_passwd']) {
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                redirect('petugas/'); //folder, controller, method
            } else {
                $this->load->library('upload'); //load library upload file
                $this->load->library('image_lib'); //load library image

                if (!empty($_FILES['img']['tmp_name'])) {

                    $path = 'uploads/petugas/';
                    $path_thumb = 'uploads/petugas/thumbs/';
                    //config upload file
                    $config['upload_path'] = $path;
                    $config['allowed_types'] = 'jpg|png|jpeg';
                    $config['max_size'] = 2048; //set limit
                    $config['overwrite'] = FALSE; //if have same name, add number
                    $config['remove_spaces'] = TRUE; //change space into _
                    $config['encrypt_name'] = TRUE;
                    //initialize config upload
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('img')) {//if success upload data
                        $result['upload'] = $this->upload->data();
                        $name = $result['upload']['file_name'];
                        $data['pic'] = $path . $name;

                        $img['image_library'] = 'gd2';
                        $img['source_image'] = $path . $name;
                        $img['new_image'] = $path_thumb . $name;
                        $img['maintain_ratio'] = true;
                        $img['width'] = 100;
                        $img['weight'] = 100;

                        $this->image_lib->initialize($img);
                        if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                            $data['pic_thumb'] = $path_thumb . $name;
                        } else {
                            $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                            redirect('petugas/');
                        }
                    } else {
                        $this->session->set_flashdata('flash_message', warn_msg($this->upload->display_errors()));
                        redirect('petugas/');
                    }
                }

                $input = $this->Petugasmodel->insert_petugas($data, $this->user['id_ref'], $this->user['role_admin']);
                if ($input == true) {
                    $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data telah tersimpan..'));
                    redirect('petugas/');
                } else {
                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                    redirect('petugas/');
                }
            }
        } else {
            $this->session->set_flashdata('flash_message', err_msg('Maaf, Password yang anda inputkan tidak sama...'));
            redirect('petugas/');
        }
    }

    public function kirim_petugas() {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('nama_petugas', 'Nama Lengkap Petugas', 'required');
        $this->form_validation->set_rules('email_petugas', 'Email Petugas', 'required');
        $this->form_validation->set_rules('nomor_hp', 'Nomor Handphone', 'required');
        $this->form_validation->set_rules('region_petugas', 'Regional Petugas', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]|matches[cf_passwd]');
        $this->form_validation->set_rules('cf_passwd', 'Password Konfirmasi', 'required|min_length[4]');

        if ($data['password'] == $data['cf_passwd']) {
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                redirect('petugas/tambah_petugas'); //folder, controller, method
            } else {
                $this->load->library('upload'); //load library upload file
                $this->load->library('image_lib'); //load library image

                if (!empty($_FILES['img'])) {

                    $path = 'uploads/petugas/';
                    $path_thumb = 'uploads/petugas/thumbs/';
                    //config upload file
                    $config['upload_path'] = $path;
                    $config['allowed_types'] = 'jpg|png|jpeg';
                    $config['max_size'] = 2048; //set limit
                    $config['overwrite'] = FALSE; //if have same name, add number
                    $config['remove_spaces'] = TRUE; //change space into _
                    $config['encrypt_name'] = TRUE;
                    //initialize config upload
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('img')) {//if success upload data
                        $result['upload'] = $this->upload->data();
                        $name = $result['upload']['file_name'];
                        $data['pic'] = $path . $name;

                        $img['image_library'] = 'gd2';
                        $img['source_image'] = $path . $name;
                        $img['new_image'] = $path_thumb . $name;
                        $img['maintain_ratio'] = true;
                        $img['width'] = 100;
                        $img['weight'] = 100;

                        $this->image_lib->initialize($img);
                        if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                            $data['pic_thumb'] = $path_thumb . $name;
                        } else {
                            $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                            redirect('petugas/tambah_petugas');
                        }
                    } else {
                        $this->session->set_flashdata('flash_message', warn_msg($this->upload->display_errors()));
                        redirect('petugas/tambah_petugas');
                    }
                }

                $input = $this->Petugasmodel->insert_petugas($data, $this->user['id_ref'], $this->user['role_admin']);
                if ($input == true) {
                    $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data telah tersimpan..'));
                    redirect('petugas/tambah_petugas');
                } else {
                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                    redirect('petugas/tambah_petugas');
                }
            }
        } else {
            $this->session->set_flashdata('flash_message', err_msg('Maaf, Password yang anda inputkan tidak sama...'));
            redirect('petugas/tambah_petugas');
        }
    }

//---------------------------------------EDIT PETUGAS---------------------------------------//
    public function edit_petugas($id = '') {

        $this->load->library('form_validation');
        $param = $this->input->post();

        $data = $this->security->xss_clean($param);
        $data['pic'] = $data['image'];
        $data['pic_thumb'] = $data['image_thumb'];

        $data_img_1 = explode('/', $data['image']);
        $img_name_1 = $data_img_1[2];

        $this->form_validation->set_rules('nama_petugas', 'Nama Lengkap Petugas', 'required');
        $this->form_validation->set_rules('email_petugas', 'Email Petugas', 'required');
        $this->form_validation->set_rules('nomor_hp', 'Nomor Handphone', 'required');

        if ($this->form_validation->run() == FALSE) {
            //
            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('petugas/get_petugas/' . $id);
        } else {
            $this->load->library('upload'); //load library upload file
            $this->load->library('image_lib'); //load library image

            if (!empty($_FILES['img']['tmp_name'])) {

                $this->delete_file_pet($img_name_1); //delete existing file

                $path = 'uploads/petugas/';
                $path_thumb = 'uploads/petugas/thumbs/';
                //config upload file
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 2048; //set without limit
                $config['overwrite'] = FALSE; //if have same name, add number
                $config['remove_spaces'] = TRUE; //change space into _
                $config['encrypt_name'] = TRUE;
                //initialize config upload
                $this->upload->initialize($config);

                if ($this->upload->do_upload('img')) {//if success upload data
                    $result['upload'] = $this->upload->data();
                    $name = $result['upload']['file_name'];
                    $data['pic'] = $path . $name;

                    $img['image_library'] = 'gd2';
                    $img['source_image'] = $path . $name;
                    $img['new_image'] = $path_thumb . $name;
                    $img['maintain_ratio'] = true;
                    $img['width'] = 100;
                    $img['weight'] = 100;

                    $this->image_lib->initialize($img);
                    if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                        $data['pic_thumb'] = $path_thumb . $name;
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                        redirect('petugas/get_petugas/' . $id);
                    }
                } else {
                    $this->session->set_flashdata('flash_message', warn_msg($this->upload->display_errors()));
                    redirect('petugas/get_petugas/' . $id);
                }
            }

            if ($data['password_lama'] != '') {
                $this->form_validation->set_rules('password_baru', 'Password Baru', 'required|min_length[4]|matches[conf_password_lama]');
                $this->form_validation->set_rules('conf_password_lama', 'Password Konfirmasi Baru', 'required|min_length[4]');

                if ($this->form_validation->run() == FALSE) {
                    $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                    redirect('petugas/get_petugas/' . $id);
                } else {
                    $cek_pass = $this->Petugasmodel->cek_password_petugas($id, $data['password_lama']);
                    if ($cek_pass) {
                        $this->Petugasmodel->update_password_petugas($id, $data['password_baru']);
                    } else {
                        $this->session->set_flashdata('flash_message', warn_msg("Maaf, Password Lama Anda salah/tidak sesuai."));
                        redirect('petugas/get_petugas/' . $id);
                    }
                }
            }

            // print_r($data);exit;    
            $edit = $this->Petugasmodel->update_petugas($id, $data, $this->user['id_ref'], $this->user['role_admin']);
            if ($edit == true) {
                $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data Telah Tersimpan..'));
                redirect('petugas/get_petugas/' . $id);
            } else {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                redirect('petugas/get_petugas/' . $id);
            }
        }
    }

//---------------------------------------DELETE PETUGAS---------------------------------------//
    public function delete_petugas() {

        $id = $this->input->post('id');
        $data = $this->Petugasmodel->get_img_by_id_petugas($id, $this->user['id_ref'], $this->user['role_admin']);
        $data_img1 = explode('/', $data[0]->img);
        $name_img1 = $data_img1[2];
        $delete = $this->Petugasmodel->delete_petugas($id, $this->user['id_ref'], $this->user['role_admin']);
        $update_status_ktp = $this->Petugasmodel->update_status_ktp_pet($id, $this->user['id_ref'], $this->user['role_admin']);

        if ($delete == TRUE && $update_status_ktp == TRUE) {
            if ($this->user['role_admin'] == 0) {
                $this->delete_file_pet($name_img1);
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

//---------------------------------------UBAH STATUS PETUGAS---------------------------------------//
    public function ubah_status_pet() {

        $id = $this->input->post('id');
        $status = $this->input->post('status');

        if (isset($id) && isset($status)) {
            $this->Petugasmodel->ubah_status_petugas($id, $status);
            //$this->Petugasmodel->ubah_status_ktp($id);
            echo '1|' . succ_msg('Berhasil, Data Telah Terupdate..');
        } else {
            echo '0|' . err_msg('Maaf, Terjadi kesalahan, Coba lagi....');
        }
    }

}
