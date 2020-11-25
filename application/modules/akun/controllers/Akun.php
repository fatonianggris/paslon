<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Akun extends MX_Controller {

    public function __construct() {
        parent::__construct();
        //Do your magic here 

        if ($this->session->userdata('ktpapps') == FALSE) {
            redirect('auth');
        }
        $this->load->model('Akunmodel');
        $this->user = $this->session->userdata("ktpapps");
    }

//---------------------------------------DAFTAR KAB PROV NAS---------------------------------------//
    public function daftar_admin_kabupaten() {
        if ($this->user['role_admin'] == 2) {
            redirect('dashboard');
        }
        $data['admin_kab'] = $this->Akunmodel->get_admin_kabupaten(substr($this->user['id_ref'], 0, 2), $this->user['role_admin']);
        $data['count'] = $this->Akunmodel->get_count();
        $data['prov'] = $this->Akunmodel->get_provinsi(); //?
        $data['kab'] = $this->Akunmodel->get_kabupaten(); //?
        $this->template->load('template_admin/template_admin', 'daftar_akun_kabupaten', $data);
    }

    public function daftar_admin_provinsi() {
        if ($this->user['role_admin'] == 2 or $this->user['role_admin'] == 1) {
            redirect('dashboard');
        }
        $data['admin_prov'] = $this->Akunmodel->get_admin_provinsi();
        $data['count'] = $this->Akunmodel->get_count();
        $data['prov'] = $this->Akunmodel->get_provinsi(); //?
        $this->template->load('template_admin/template_admin', 'daftar_akun_provinsi', $data);
    }

    public function daftar_admin_nasional() {
        if ($this->user['role_admin'] == 2 or $this->user['role_admin'] == 1) {
            redirect('dashboard');
        }
        $data['admin_nas'] = $this->Akunmodel->get_admin_nasional();
        $data['count'] = $this->Akunmodel->get_count();
        $this->template->load('template_admin/template_admin', 'daftar_akun_nasional', $data);
    }

//---------------------------------------TAMBAH KAB PROV NAS---------------------------------------//
    public function tambah_admin_kabupaten() {

        $data['admin_regional'] = $this->Akunmodel->get_admin_regional($this->user['id_ref'], $this->user['role_admin']);
        $data['admin'] = $this->Akunmodel->get_admin(); //?
        $get_prov = $this->db->select('*')->from('wilayah_provinsi')->get();
        $data['provinsi'] = $get_prov->result();
        $this->template->load('template_admin/template_admin', 'tambah_akun_kabupaten', $data);
    }

    public function tambah_admin_provinsi() {
        if ($this->user['role_admin'] == 2) {
            redirect('dashboard');
        }

        $get_prov = $this->db->select('*')->from('wilayah_provinsi')->get();
        $data['provinsi'] = $get_prov->result();
        $this->template->load('template_admin/template_admin', 'tambah_akun_provinsi', $data);
    }

    public function tambah_admin_nasional() {
        if ($this->user['role_admin'] == 2 or $this->user['role_admin'] == 1) {
            redirect('dashboard');
        }
        $data['petugas'] = $this->Akunmodel->get_petugas_nasional($this->user['id_ref']); //?
        $this->template->load('template_admin/template_admin', 'tambah_akun_nasional', $data);
    }

//---------------------------------------GET KAB PROV NAS---------------------------------------//
    public function get_admin_kabupaten($id = '') {

        $data['admin_kabupaten'] = $this->Akunmodel->get_by_id_admin($id); //?
        $get_prov = $this->db->select('*')->from('wilayah_provinsi')->get();
        $data['provinsi'] = $get_prov->result();
        $data['prov'] = $this->Akunmodel->get_provinsi(); //?
        $data['kab'] = $this->Akunmodel->get_kabupaten(); //?
        $cek = $this->Akunmodel->get_by_id_admin($id);
        if ($cek == FALSE or empty($id)) {
            $data = array();
            $this->load->view('error_404', $data);
        } else {
            //edit data with id
            $this->template->load('template_admin/template_admin', 'edit_akun_kabupaten', $data);
        }
    }

    public function get_admin_provinsi($id = '') {

        $data['admin_provinsi'] = $this->Akunmodel->get_by_id_admin($id); //?
        $data['admin_kabupaten'] = $this->Akunmodel->get_by_id_admin($id); //?

        $get_prov = $this->db->select('*')->from('wilayah_provinsi')->get();
        $data['provinsi'] = $get_prov->result();
        $data['prov'] = $this->Akunmodel->get_provinsi(); //?
        $cek = $this->Akunmodel->get_by_id_admin($id);
        if ($cek == FALSE or empty($id)) {
            $data = array();
            $this->load->view('error_404', $data);
        } else {
            //edit data with id
            $this->template->load('template_admin/template_admin', 'edit_akun_provinsi', $data);
        }
    }

    public function get_admin_nasional($id = '') {

        $data['admin_nasional'] = $this->Akunmodel->get_by_id_superadmin($id); //?

        $cek = $this->Akunmodel->get_by_id_superadmin($id);
        if ($cek == FALSE or empty($id)) {
            $data = array();
            $this->load->view('error_404', $data);
        } else {
            //edit data with id
            $this->template->load('template_admin/template_admin', 'edit_akun_nasional', $data);
        }
    }

//---------------------------------------KIRIM KAB PROV NAS---------------------------------------//
    public function kirim_admin_kabupaten() {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('nama_admin', 'Nama Lengkap Admin', 'required');
        $this->form_validation->set_rules('email', 'Nama Email', 'required');
        $this->form_validation->set_rules('nomor_hp', 'Nomor Handphone', 'required');
        $this->form_validation->set_rules('status', 'Status Admin', 'required');
        $this->form_validation->set_rules('provinsi', 'Pilih Provinsi', 'required');
        $this->form_validation->set_rules('kabupaten', 'Pilih Kabupaten', 'required');
        $this->form_validation->set_rules('password_adm', 'Password Admin', 'required|min_length[4]|matches[cf_passwd_adm]');
        $this->form_validation->set_rules('cf_passwd_adm', 'Password Konfirmasi Admin', 'required|min_length[4]');

        $this->form_validation->set_rules('nama_petugas', 'Nama Lengkap Petugas', 'required');
        $this->form_validation->set_rules('email_petugas', 'Email Petugas', 'required');
        $this->form_validation->set_rules('nomor_hp_pet', 'Nomor Handphone Petugas', 'required');
        $this->form_validation->set_rules('region_petugas', 'Regional Petugas', 'required');
        $this->form_validation->set_rules('password_pet', 'Password Petugas', 'required|min_length[4]|matches[cf_passwd_pet]');
        $this->form_validation->set_rules('cf_passwd_pet', 'Password Konfirmasi Petugas', 'required|min_length[4]');

        $get_name_prov_kab = $this->Akunmodel->get_prov_kab($data['provinsi'], $data['kabupaten']);
        $id_ref = $data['provinsi'] . $data['kabupaten'];
        $cek = $this->Akunmodel->cek_id_admin_kab($id_ref);

        if (!isset($data['update'])) {
            $data['update'] = '0';
        }
        if (!isset($data['create'])) {
            $data['create'] = '0';
        }
        if (!isset($data['delete'])) {
            $data['delete'] = '0';
        }

        date_default_timezone_set("Asia/Jakarta");
        $date = date('Y-m-d H-i-s', time());
        $name_dir = strtolower(str_replace(' ', '_', $data['nama_admin'] . '_' . $date));
        $name_dir_prov_kab = strtolower(str_replace(' ', '_', $get_name_prov_kab[0]->nama_provinsi . '_' . $get_name_prov_kab[0]->nama_kabupaten . '_' . $date));

        if ($cek == TRUE or empty($id_ref)) {

            $this->session->set_flashdata('flash_message', err_msg('Maaf, Akun telah dibuat...'));
            redirect('akun/tambah_admin_kabupaten');
        } else {

            if ($data['password_adm'] == $data['cf_passwd_adm']) {

                if (!file_exists('uploads/ktp/' . $name_dir)) {

                    mkdir('uploads/ktp/' . $name_dir, 0777, true);
                    $admin_path = 'uploads/ktp/' . $name_dir;

                    if (!file_exists($admin_path . '/' . $name_dir_prov_kab)) {
                        mkdir($admin_path . '/' . $name_dir_prov_kab, 0777, true);
                        mkdir($admin_path . '/' . $name_dir_prov_kab . '/thumbs/', 0777, true);
                        mkdir($admin_path . '/' . $name_dir_prov_kab . '/barcode/', 0777, true);
                        mkdir($admin_path . '/' . $name_dir_prov_kab . '/pasfoto_thumbs/', 0777, true);

                        $data['path'] = $admin_path . '/' . $name_dir_prov_kab;
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori upload foto sudah dibuat...'));
                        redirect('akun/tambah_admin_kabupaten');
                    }

                    if ($this->form_validation->run() == FALSE) {
                        $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                        redirect('akun/tambah_admin_kabupaten'); //folder, controller, method
                    } else {
                        $this->load->library('upload'); //load library upload file
                        $this->load->library('image_lib'); //load library image

                        if (!empty($_FILES['img_adm'])) {

                            $path = 'uploads/user/';
                            $path_thumb = 'uploads/user/thumbs/';
                            //config upload file
                            $config['upload_path'] = $path;
                            $config['allowed_types'] = 'jpg|png|jpeg';
                            $config['max_size'] = 1048; //set limit
                            $config['overwrite'] = FALSE; //if have same name, add number
                            $config['remove_spaces'] = TRUE; //change space into _
                            $config['encrypt_name'] = TRUE;
                            //initialize config upload
                            $this->upload->initialize($config);

                            if ($this->upload->do_upload('img_adm')) {//if success upload data
                                $result['upload'] = $this->upload->data();
                                $name = $result['upload']['file_name'];
                                $data['pic_adm'] = $path . $name;

                                $img['image_library'] = 'gd2';
                                $img['source_image'] = $path . $name;
                                $img['new_image'] = $path_thumb . $name;
                                $img['maintain_ratio'] = true;
                                $img['width'] = 100;
                                $img['weight'] = 100;

                                $this->image_lib->initialize($img);
                                if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                                    $data['pic_thumb_adm'] = $path_thumb . $name;
                                } else {
                                    $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                                    redirect('akun/tambah_admin_kabupaten');
                                }
                            } else {
                                $this->session->set_flashdata('flash_message', warn_msg($this->upload->display_errors()));
                                redirect('akun/tambah_admin_kabupaten');
                            }
                        }

                        if ($data['password_pet'] == $data['cf_passwd_pet']) {

                            if (!empty($_FILES['img_pet'])) {

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

                                if ($this->upload->do_upload('img_pet')) {//if success upload data
                                    $result['upload'] = $this->upload->data();
                                    $name = $result['upload']['file_name'];
                                    $data['pic_pet'] = $path . $name;

                                    $img['image_library'] = 'gd2';
                                    $img['source_image'] = $path . $name;
                                    $img['new_image'] = $path_thumb . $name;
                                    $img['maintain_ratio'] = true;
                                    $img['width'] = 100;
                                    $img['weight'] = 100;

                                    $this->image_lib->initialize($img);
                                    if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                                        $data['pic_thumb_pet'] = $path_thumb . $name;
                                    } else {
                                        $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                                        redirect('akun/tambah_admin_kabupaten');
                                    }
                                } else {
                                    $this->session->set_flashdata('flash_message', warn_msg($this->upload->display_errors()));
                                    redirect('akun/tambah_admin_kabupaten');
                                }
                            }
                        } else {
                            $this->session->set_flashdata('flash_message', err_msg('Maaf, Password Petugas yang anda inputkan tidak sama...'));
                            redirect('akun/tambah_admin_kabupaten');
                        }

                        $input_petugas = $this->Akunmodel->insert_petugas($data, $this->user['id_ref'], $this->user['role_admin']);
                        $input_admin = $this->Akunmodel->insert_admin_kabupaten($data);

                        if ($input_petugas == true && $input_admin == true) {
                            $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data telah tersimpan..'));
                            redirect('akun/tambah_admin_kabupaten');
                        } else {
                            $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                            redirect('akun/tambah_admin_kabupaten');
                        }
                    }
                } else {
                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori upload foto sudah dibuat...'));
                    redirect('akun/tambah_admin_kabupaten');
                }
            } else {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Password Admin yang anda inputkan tidak sama...'));
                redirect('akun/tambah_admin_kabupaten');
            }
        }
    }

    public function kirim_admin_provinsi() {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('nama_admin', 'Nama Lengkap Admin', 'required');
        $this->form_validation->set_rules('email', 'Nama Email', 'required');
        $this->form_validation->set_rules('nomor_hp', 'Nomor Handphone', 'required');
        $this->form_validation->set_rules('provinsi', 'Pilih Provinsi', 'required');
        $this->form_validation->set_rules('status', 'Status Admin', 'required');
        $this->form_validation->set_rules('password_adm', 'Password', 'required|min_length[4]|matches[cf_passwd_adm]');
        $this->form_validation->set_rules('cf_passwd_adm', 'Password Konfirmasi', 'required|min_length[4]');

        $this->form_validation->set_rules('nama_petugas', 'Nama Lengkap Petugas', 'required');
        $this->form_validation->set_rules('email_petugas', 'Email Petugas', 'required');
        $this->form_validation->set_rules('nomor_hp_pet', 'Nomor Handphone Petugas', 'required');
        $this->form_validation->set_rules('region_petugas', 'Regional Petugas', 'required');
        $this->form_validation->set_rules('password_pet', 'Password Petugas', 'required|min_length[4]|matches[cf_passwd_pet]');
        $this->form_validation->set_rules('cf_passwd_pet', 'Password Konfirmasi Petugas', 'required|min_length[4]');

        $get_name_prov = $this->Akunmodel->get_prov($data['provinsi']);
        $id_ref = $data['provinsi'];
        $cek = $this->Akunmodel->cek_id_admin_prov($id_ref);

        if (!isset($data['update'])) {
            $data['update'] = '0';
        }
        if (!isset($data['create'])) {
            $data['create'] = '0';
        }
        if (!isset($data['delete'])) {
            $data['delete'] = '0';
        }

        date_default_timezone_set("Asia/Jakarta");
        $date = date('Y-m-d H-i-s', time());
        $name_dir = strtolower(str_replace(' ', '_', $data['nama_admin'] . '_' . $date));
        $name_dir_prov = strtolower(str_replace(' ', '_', $get_name_prov[0]->nama_provinsi . '_' . $date));

        if ($cek == TRUE or empty($id_ref)) {
            $this->session->set_flashdata('flash_message', err_msg('Maaf, Akun telah dibuat...'));
            redirect('akun/tambah_admin_provinsi');
        } else {

            if ($data['password_adm'] == $data['cf_passwd_adm']) {

                if (!file_exists('uploads/ktp/' . $name_dir)) {

                    mkdir('uploads/ktp/' . $name_dir, 0777, true);
                    $admin_path = 'uploads/ktp/' . $name_dir;

                    if (!file_exists($admin_path . '/' . $name_dir_prov)) {
                        mkdir($admin_path . '/' . $name_dir_prov, 0777, true);
                        mkdir($admin_path . '/' . $name_dir_prov . '/thumbs/', 0777, true);
                        mkdir($admin_path . '/' . $name_dir_prov . '/barcode/', 0777, true);
                        mkdir($admin_path . '/' . $name_dir_prov . '/pasfoto_thumbs/', 0777, true);

                        $data['path'] = $admin_path . '/' . $name_dir_prov;
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori upload foto sudah dibuat...'));
                        redirect('akun/tambah_admin_provinsi');
                    }

                    if ($this->form_validation->run() == FALSE) {
                        $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                        redirect('akun/tambah_admin_provinsi'); //folder, controller, method
                    } else {
                        $this->load->library('upload'); //load library upload file
                        $this->load->library('image_lib'); //load library image

                        if (!empty($_FILES['img_adm'])) {

                            $path = 'uploads/user/';
                            $path_thumb = 'uploads/user/thumbs/';
                            //config upload file
                            $config['upload_path'] = $path;
                            $config['allowed_types'] = 'jpg|png|jpeg';
                            $config['max_size'] = 1048; //set limit
                            $config['overwrite'] = FALSE; //if have same name, add number
                            $config['remove_spaces'] = TRUE; //change space into _
                            $config['encrypt_name'] = TRUE;
                            //initialize config upload
                            $this->upload->initialize($config);

                            if ($this->upload->do_upload('img_adm')) {//if success upload data
                                $result['upload'] = $this->upload->data();
                                $name = $result['upload']['file_name'];
                                $data['pic_adm'] = $path . $name;

                                $img['image_library'] = 'gd2';
                                $img['source_image'] = $path . $name;
                                $img['new_image'] = $path_thumb . $name;
                                $img['maintain_ratio'] = true;
                                $img['width'] = 100;
                                $img['weight'] = 100;

                                $this->image_lib->initialize($img);
                                if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                                    $data['pic_thumb_adm'] = $path_thumb . $name;
                                } else {
                                    $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                                    redirect('akun/tambah_admin_provinsi');
                                }
                            } else {
                                $this->session->set_flashdata('flash_message', warn_msg($this->upload->display_errors()));
                                redirect('akun/tambah_admin_provinsi');
                            }
                        }

                        if ($data['password_pet'] == $data['cf_passwd_pet']) {

                            if (!empty($_FILES['img_pet'])) {

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

                                if ($this->upload->do_upload('img_pet')) {//if success upload data
                                    $result['upload'] = $this->upload->data();
                                    $name = $result['upload']['file_name'];
                                    $data['pic_pet'] = $path . $name;

                                    $img['image_library'] = 'gd2';
                                    $img['source_image'] = $path . $name;
                                    $img['new_image'] = $path_thumb . $name;
                                    $img['maintain_ratio'] = true;
                                    $img['width'] = 100;
                                    $img['weight'] = 100;

                                    $this->image_lib->initialize($img);
                                    if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                                        $data['pic_thumb_pet'] = $path_thumb . $name;
                                    } else {
                                        $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                                        redirect('akun/tambah_admin_provinsi');
                                    }
                                } else {
                                    $this->session->set_flashdata('flash_message', warn_msg($this->upload->display_errors()));
                                    redirect('akun/tambah_admin_provinsi');
                                }
                            }
                        } else {
                            $this->session->set_flashdata('flash_message', err_msg('Maaf, Password Petugas yang anda inputkan tidak sama...'));
                            redirect('akun/tambah_admin_provinsi');
                        }

                        $input_petugas = $this->Akunmodel->insert_petugas($data, $this->user['id_ref'], $this->user['role_admin']);
                        $input_admin = $this->Akunmodel->insert_admin_provinsi($data);

                        if ($input_admin == true && $input_petugas == true) {
                            $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data telah tersimpan..'));
                            redirect('akun/tambah_admin_provinsi');
                        } else {
                            $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                            redirect('akun/tambah_admin_provinsi');
                        }
                    }
                } else {
                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori upload foto sudah dibuat...'));
                    redirect('akun/tambah_admin_provinsi');
                }
            } else {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Password yang anda inputkan tidak sama...'));
                redirect('akun/tambah_admin_provinsi');
            }
        }
    }

    public function kirim_admin_nasional() {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('nama_admin', 'Nama Lengkap Admin', 'required');
        $this->form_validation->set_rules('email', 'Nama Email', 'required');
        $this->form_validation->set_rules('nomor_hp', 'Nomor Handphone', 'required');
        $this->form_validation->set_rules('status', 'Status Admin', 'required');
        $this->form_validation->set_rules('password_adm', 'Password', 'required|min_length[4]|matches[cf_passwd_adm]');
        $this->form_validation->set_rules('cf_passwd_adm', 'Password Konfirmasi', 'required|min_length[4]');

        $this->form_validation->set_rules('nama_petugas', 'Nama Lengkap Petugas', 'required');
        $this->form_validation->set_rules('email_petugas', 'Email Petugas', 'required');
        $this->form_validation->set_rules('nomor_hp_pet', 'Nomor Handphone Petugas', 'required');
        $this->form_validation->set_rules('region_petugas', 'Regional Petugas', 'required');
        $this->form_validation->set_rules('password_pet', 'Password Petugas', 'required|min_length[4]|matches[cf_passwd_pet]');
        $this->form_validation->set_rules('cf_passwd_pet', 'Password Konfirmasi Petugas', 'required|min_length[4]');

        $get_name_admin = $this->Akunmodel->get_admin_prov();
        $cek = $this->Akunmodel->cek_nama_admin($data['nama_admin']);

        date_default_timezone_set("Asia/Jakarta");
        $date = date('Y-m-d H-i-s', time());
        $name_dir = strtolower(str_replace(' ', '_', $data['nama_admin'] . '_' . $date));
        $name_dir_admin = strtolower(str_replace(' ', '_', $get_name_admin[0]->nama_provinsi_admin . '_' . $date));

        if ($cek == TRUE) {

            $this->session->set_flashdata('flash_message', err_msg('Maaf, Nama Akun telah dibuat...'));
            redirect('akun/tambah_admin_nasional');
        } else {

            if ($this->form_validation->run() == FALSE) {

                $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                redirect('akun/tambah_admin_nasional'); //folder, controller, method
            } else {

                if ($data['password_adm'] == $data['cf_passwd_adm']) {
                    $this->load->library('upload'); //load library upload file
                    $this->load->library('image_lib'); //load library image

                    if (!file_exists('uploads/ktp/' . $name_dir)) {

                        mkdir('uploads/ktp/' . $name_dir, 0777, true);
                        $admin_path = 'uploads/ktp/' . $name_dir;

                        if (!file_exists($admin_path . '/' . $name_dir_admin)) {
                            mkdir($admin_path . '/' . $name_dir_admin, 0777, true);
                            mkdir($admin_path . '/' . $name_dir_admin . '/thumbs/', 0777, true);
                            mkdir($admin_path . '/' . $name_dir_admin . '/barcode/', 0777, true);
                            mkdir($admin_path . '/' . $name_dir_admin . '/pasfoto_thumbs/', 0777, true);

                            $data['path'] = $admin_path . '/' . $name_dir_admin;
                        } else {
                            $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori upload foto sudah dibuat...'));
                            redirect('akun/tambah_admin_nasional');
                        }

                        if (!empty($_FILES['img_adm'])) {

                            $path = 'uploads/user/';
                            $path_thumb = 'uploads/user/thumbs/';
                            //config upload file
                            $config['upload_path'] = $path;
                            $config['allowed_types'] = 'jpg|png|jpeg';
                            $config['max_size'] = 1048; //set limit
                            $config['overwrite'] = FALSE; //if have same name, add number
                            $config['remove_spaces'] = TRUE; //change space into _
                            $config['encrypt_name'] = TRUE;
                            //initialize config upload
                            $this->upload->initialize($config);

                            if ($this->upload->do_upload('img_adm')) {//if success upload data
                                $result['upload'] = $this->upload->data();
                                $name = $result['upload']['file_name'];
                                $data['pic_adm'] = $path . $name;

                                $img['image_library'] = 'gd2';
                                $img['source_image'] = $path . $name;
                                $img['new_image'] = $path_thumb . $name;
                                $img['maintain_ratio'] = true;
                                $img['width'] = 100;
                                $img['weight'] = 100;

                                $this->image_lib->initialize($img);
                                if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                                    $data['pic_thumb_adm'] = $path_thumb . $name;
                                } else {
                                    $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                                    redirect('akun/tambah_admin_nasional');
                                }
                            } else {
                                $this->session->set_flashdata('flash_message', warn_msg($this->upload->display_errors()));
                                redirect('akun/tambah_admin_nasional');
                            }
                        }

                        if ($data['password_pet'] == $data['cf_passwd_pet']) {

                            if (!empty($_FILES['img_pet'])) {

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

                                if ($this->upload->do_upload('img_pet')) {//if success upload data
                                    $result['upload'] = $this->upload->data();
                                    $name = $result['upload']['file_name'];
                                    $data['pic_pet'] = $path . $name;

                                    $img['image_library'] = 'gd2';
                                    $img['source_image'] = $path . $name;
                                    $img['new_image'] = $path_thumb . $name;
                                    $img['maintain_ratio'] = true;
                                    $img['width'] = 100;
                                    $img['weight'] = 100;

                                    $this->image_lib->initialize($img);
                                    if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                                        $data['pic_thumb_pet'] = $path_thumb . $name;
                                    } else {
                                        $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                                        redirect('akun/tambah_admin_nasional');
                                    }
                                } else {
                                    $this->session->set_flashdata('flash_message', warn_msg($this->upload->display_errors()));
                                    redirect('akun/tambah_admin_nasional');
                                }
                            }
                        } else {
                            $this->session->set_flashdata('flash_message', err_msg('Maaf, Password Petugas yang anda inputkan tidak sama...'));
                            redirect('akun/tambah_admin_nasional');
                        }

                        $input_petugas = $this->Akunmodel->insert_petugas($data, $this->user['id_ref'], $this->user['role_admin']);
                        $input_admin = $this->Akunmodel->insert_admin_nasional($data);

                        if ($input_admin == true && $input_petugas == true) {
                            $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data telah tersimpan..'));
                            redirect('akun/tambah_admin_nasional');
                        } else {
                            $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                            redirect('akun/tambah_admin_nasional');
                        }
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori upload foto sudah dibuat...'));
                        redirect('akun/tambah_admin_nasional');
                    }
                } else {
                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Password yang anda inputkan tidak sama...'));
                    redirect('akun/tambah_admin_nasional');
                }
            }
        }
    }

//---------------------------------------EDIT KAB PROV NAS---------------------------------------//
    public function edit_admin_kabupaten($id = '') {

        $this->load->library('form_validation');
        $param = $this->input->post();

        $data = $this->security->xss_clean($param);
        $data['pic'] = $data['image'];
        $data['pic_thumb'] = $data['image_thumb'];

        $data_img_1 = explode('/', $data['image']);
        $img_name_1 = $data_img_1[2];

        $this->form_validation->set_rules('nama_admin', 'Nama Lengkap Admin', 'required');
        $this->form_validation->set_rules('email', 'Nama Email', 'required');
        $this->form_validation->set_rules('nomor_hp', 'Nomor Handphone', 'required');
        $this->form_validation->set_rules('status', 'Status Admin', 'required');
        $this->form_validation->set_rules('provinsi', 'Pilih Provinsi', 'required');
        $this->form_validation->set_rules('kabupaten', 'Pilih Kabupaten', 'required');

        if (!isset($data['update'])) {
            $data['update'] = '0';
        }
        if (!isset($data['create'])) {
            $data['create'] = '0';
        }
        if (!isset($data['delete'])) {
            $data['delete'] = '0';
        }

        $id_ref = $data['provinsi'] . $data['kabupaten'];
        $cek = $this->Akunmodel->cek_id_admin_kab($id_ref);

        if ($cek == TRUE && $cek[0]->id_ref != $id_ref) {

            $this->session->set_flashdata('flash_message', err_msg('Maaf, Akun telah dibuat...'));
            redirect('akun/get_admin_kabupaten/' . $id);
        } else {

            if ($this->form_validation->run() == FALSE) {

                $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                redirect('akun/get_admin_kabupaten/' . $id);
            } else {
                $this->load->library('upload'); //load library upload file
                $this->load->library('image_lib'); //load library image

                if (!empty($_FILES['img']['tmp_name'])) {

                    $this->delete_file($img_name_1); //delete existing file

                    $path = 'uploads/user/';
                    $path_thumb = 'uploads/user/thumbs/';
                    //config upload file
                    $config['upload_path'] = $path;
                    $config['allowed_types'] = 'jpg|png|jpeg|gif';
                    $config['max_size'] = 1048; //set without limit
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
                            redirect('akun/get_admin_kabupaten/' . $id);
                        }
                    } else {
                        $this->session->set_flashdata('flash_message', warn_msg($this->upload->display_errors()));
                        redirect('akun/get_admin_kabupaten/' . $id);
                    }
                }

                if ($data['password_lama'] != '') {
                    $this->form_validation->set_rules('password_baru', 'Password Baru', 'required|min_length[4]|matches[conf_password_lama]');
                    $this->form_validation->set_rules('conf_password_lama', 'Password Konfirmasi Baru', 'required|min_length[4]');

                    if ($this->form_validation->run() == FALSE) {
                        $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                        redirect('akun/get_admin_kabupaten/' . $id);
                    } else {
                        $cek_pass = $this->Akunmodel->cek_password_admin($id, $data['password_lama']);
                        if ($cek_pass) {
                            $this->Akunmodel->update_password_admin($id, $data['password_baru']);
                        } else {
                            $this->session->set_flashdata('flash_message', warn_msg("Maaf, Password Lama Anda salah/tidak sesuai."));
                            redirect('akun/get_admin_kabupaten/' . $id);
                        }
                    }
                }

                // print_r($data);exit;    
                $edit = $this->Akunmodel->update_admin_kabupaten($id, $data);
                if ($edit == true) {
                    $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data Telah Tersimpan..'));
                    redirect('akun/get_admin_kabupaten/' . $id);
                } else {
                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                    redirect('akun/get_admin_kabupaten/' . $id);
                }
            }
        }
    }

    public function edit_admin_provinsi($id = '') {

        $this->load->library('form_validation');
        $param = $this->input->post();

        $data = $this->security->xss_clean($param);
        $data['pic'] = $data['image'];
        $data['pic_thumb'] = $data['image_thumb'];

        $data_img_1 = explode('/', $data['image']);
        $img_name_1 = $data_img_1[2];

        $this->form_validation->set_rules('nama_admin', 'Nama Lengkap Admin', 'required');
        $this->form_validation->set_rules('email', 'Nama Email', 'required');
        $this->form_validation->set_rules('nomor_hp', 'Nomor Handphone', 'required');
        $this->form_validation->set_rules('status', 'Status Admin', 'required');
        $this->form_validation->set_rules('provinsi', 'Pilih Provinsi', 'required');


        if (!isset($data['update'])) {
            $data['update'] = '0';
        }
        if (!isset($data['create'])) {
            $data['create'] = '0';
        }
        if (!isset($data['delete'])) {
            $data['delete'] = '0';
        }

        $id_ref = $data['provinsi'];
        $cek = $this->Akunmodel->cek_id_admin_prov($id_ref);

        if ($cek == TRUE && $cek[0]->id_ref != $id_ref) {
            $this->session->set_flashdata('flash_message', err_msg('Maaf, Akun telah dibuat...'));
            redirect('akun/get_admin_provinsi/' . $id);
        } else {
            if ($this->form_validation->run() == FALSE) {
                //
                $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                redirect('akun/get_admin_provinsi/' . $id);
            } else {
                $this->load->library('upload'); //load library upload file
                $this->load->library('image_lib'); //load library image

                if (!empty($_FILES['img_adm']['tmp_name'])) {

                    $this->delete_file($img_name_1); //delete existing file

                    $path = 'uploads/user/';
                    $path_thumb = 'uploads/user/thumbs/';
                    //config upload file
                    $config['upload_path'] = $path;
                    $config['allowed_types'] = 'jpg|png|jpeg|gif';
                    $config['max_size'] = 1048; //set without limit
                    $config['overwrite'] = FALSE; //if have same name, add number
                    $config['remove_spaces'] = TRUE; //change space into _
                    $config['encrypt_name'] = TRUE;
                    //initialize config upload
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('img_adm')) {//if success upload data
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
                            redirect('akun/get_admin_provinsi/' . $id);
                        }
                    } else {
                        $this->session->set_flashdata('flash_message', warn_msg($this->upload->display_errors()));
                        redirect('akun/get_admin_provinsi/' . $id);
                    }
                }
                if ($data['password_lama'] != '') {
                    $this->form_validation->set_rules('password_baru', 'Password Baru', 'required|min_length[4]|matches[conf_password_lama]');
                    $this->form_validation->set_rules('conf_password_lama', 'Password Konfirmasi Baru', 'required|min_length[4]');

                    if ($this->form_validation->run() == FALSE) {
                        $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                        redirect('akun/get_admin_provinsi/' . $id);
                    } else {
                        $cek_pass = $this->Akunmodel->cek_password_admin($id, $data['password_lama']);
                        if ($cek_pass) {
                            $this->Akunmodel->update_password_admin($id, $data['password_baru']);
                        } else {
                            $this->session->set_flashdata('flash_message', warn_msg("Maaf, Password Lama Anda salah/tidak sesuai."));
                            redirect('akun/get_admin_provinsi/' . $id);
                        }
                    }
                }
                // print_r($data);exit;    
                $edit = $this->Akunmodel->update_admin_provinsi($id, $data);
                if ($edit == true) {
                    $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data Telah Tersimpan..'));
                    redirect('akun/get_admin_provinsi/' . $id);
                } else {
                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                    redirect('akun/get_admin_provinsi/' . $id);
                }
            }
        }
    }

    public function edit_admin_nasional($id = '') {

        $this->load->library('form_validation');
        $param = $this->input->post();

        $data = $this->security->xss_clean($param);
        $data['pic'] = $data['image'];
        $data['pic_thumb'] = $data['image_thumb'];

        $data_img_1 = explode('/', $data['image']);
        $img_name_1 = $data_img_1[2];

        $this->form_validation->set_rules('nama_admin', 'Nama Lengkap Super Admin', 'required');
        $this->form_validation->set_rules('email', 'Nama Email', 'required');
        $this->form_validation->set_rules('nomor_hp', 'Nomor Handphone', 'required');
        $this->form_validation->set_rules('status', 'Status Super Admin', 'required');

        if ($this->form_validation->run() == FALSE) {
            //
            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('akun/get_admin_nasional/' . $id);
        } else {
            $this->load->library('upload'); //load library upload file
            $this->load->library('image_lib'); //load library image

            if (!empty($_FILES['img']['tmp_name'])) {

                $this->delete_file($img_name_1); //delete existing file

                $path = 'uploads/user/';
                $path_thumb = 'uploads/user/thumbs/';
                //config upload file
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 1048; //set without limit
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
                        redirect('akun/get_admin_nasional/' . $id);
                    }
                } else {
                    $this->session->set_flashdata('flash_message', warn_msg($this->upload->display_errors()));
                    redirect('akun/get_admin_nasional/' . $id);
                }
            }
            if ($data['password_lama'] != '') {
                $this->form_validation->set_rules('password_baru', 'Password Baru', 'required|min_length[4]|matches[conf_password_lama]');
                $this->form_validation->set_rules('conf_password_lama', 'Password Konfirmasi Baru', 'required|min_length[4]');

                if ($this->form_validation->run() == FALSE) {
                    $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                    redirect('akun/get_admin_nasional/' . $id);
                } else {
                    $cek_pass = $this->Akunmodel->cek_password_admin($id, $data['password_lama']);
                    if ($cek_pass) {
                        $this->Akunmodel->update_password_admin($id, $data['password_baru']);
                    } else {
                        $this->session->set_flashdata('flash_message', warn_msg("Maaf, Password Lama Anda salah/tidak sesuai."));
                        redirect('akun/get_admin_nasional/' . $id);
                    }
                }
            }
            // print_r($data);exit;    
            $edit = $this->Akunmodel->update_admin_nasional($id, $data);
            if ($edit == true) {
                $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data Telah Tersimpan..'));
                redirect('akun/get_admin_nasional/' . $id);
            } else {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                redirect('akun/get_admin_nasional/' . $id);
            }
        }
    }

//---------------------------------------DELETE KAB PROV NAS---------------------------------------//
    public function delete_admin_kabupaten() {

        $id = $this->input->post('id');
        $data = $this->Akunmodel->get_img_by_id_admin($id);
        $data_img1 = explode('/', $data[0]->img);
        $name_img1 = $data_img1[2];
        $delete = $this->Akunmodel->delete_admin($id);
        if ($delete == true) {
            $this->delete_file($name_img1);
            echo '1|' . succ_msg('Berhasil, Data Telah Terhapus..');
        } else {
            echo '0|' . err_msg('Maaf, Terjadi kesalahan, Coba lagi....');
        }
    }

    public function delete_admin_provinsi() {

        $id = $this->input->post('id');
        $data = $this->Akunmodel->get_img_by_id_admin($id);
        $data_img1 = explode('/', $data[0]->img);
        $name_img1 = $data_img1[2];
        $delete = $this->Akunmodel->delete_admin($id);
        if ($delete == true) {
            $this->delete_file($name_img1);
            echo '1|' . succ_msg('Berhasil, Data Telah Terhapus..');
        } else {
            echo '0|' . err_msg('Maaf, Terjadi kesalahan, Coba lagi....');
        }
    }

    public function delete_admin_nasional() {

        $id = $this->input->post('id');
        $data = $this->Akunmodel->get_img_by_id_superadmin($id);
        $data_img1 = explode('/', $data[0]->img);
        $name_img1 = $data_img1[2];
        $delete = $this->Akunmodel->delete_superadmin($id);
        if ($delete == true) {
            $this->delete_file($name_img1);
            echo '1|' . succ_msg('Berhasil, Data Telah Terhapus..');
        } else {
            echo '0|' . err_msg('Maaf, Terjadi kesalahan, Coba lagi....');
        }
    }

    public function delete_file($name = '') {
        $path = './uploads/user/';
        $path_thumb = './uploads/user/thumbs/';
        @unlink($path . $name);
        @unlink($path_thumb . $name);
    }

//---------------------------------------AJAX KAB---------------------------------------//
    function add_ajax_kab($id_prov) {
        $query = $this->db->get_where('wilayah_kabupaten', array('id_dati1' => $id_prov));

        foreach ($query->result() as $value) {
            $data .= "<option value='" . $value->id . "'>" . $value->nama . " [" . strtoupper($value->administratif) . "]" . "</option>";
        }
        echo $data;
    }

}
