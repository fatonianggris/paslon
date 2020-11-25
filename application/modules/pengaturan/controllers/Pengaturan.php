<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends MX_Controller {

    public function __construct() {
        parent::__construct();
        //Do your magic here 

        if ($this->session->userdata('ktpapps') == FALSE) {
            redirect('auth');
        }
        $this->load->model('Pengaturanmodel');
        $this->user = $this->session->userdata("ktpapps");
    }

    //---------------------------------------GET USER---------------------------------------//

    public function get_user($id = '') {
        if ($this->user['id_user'] != $id) {
            redirect('dashboard');
        }

        $data['user'] = $this->Pengaturanmodel->get_by_id_user($id); //?
        $cek = $this->Pengaturanmodel->get_by_id_user($id);
        if ($cek == FALSE or empty($id)) {
            $data = array();
            $this->load->view('error_404', $data);
        } else {
            //edit data with id
            $this->template->load('template_admin/template_admin', 'pengaturan_akun', $data);
        }
    }

    //---------------------------------------EDIT USER---------------------------------------//
    public function edit_user($id = '') {

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

        if ($this->form_validation->run() == FALSE) {
            //
            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('pengaturan/get_user/' . $id);
        } else {
            $this->load->library('upload'); //load library upload file
            $this->load->library('image_lib'); //load library image

            if (!empty($_FILES['img']['tmp_name'])) {

                $this->delete_file_user($img_name_1); //delete existing file

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
                        redirect('pengaturan/get_user/' . $id);
                    }
                } else {
                    $this->session->set_flashdata('flash_message', warn_msg($this->upload->display_errors()));
                    redirect('pengaturan/get_user/' . $id);
                }
            }

            // print_r($data);exit;    
            $edit = $this->Pengaturanmodel->update_user($id, $data);
            if ($edit == true) {
                $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data Telah Tersimpan..'));
                redirect('pengaturan/get_user/' . $id);
            } else {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                redirect('pengaturan/get_user/' . $id);
            }
        }
    }

    public function delete_file_user($name = '') {
        $path = './uploads/user/';
        $path_thumb = './uploads/user/thumbs/';
        @unlink($path . $name);
        @unlink($path_thumb . $name);
    }

    //----------------------------------------GET TEMPLATE---------------------------------------------------//

    public function get_template($id = '') {
        $data['template'] = $this->Pengaturanmodel->get_by_id_template($id); //?
        $cek = $this->Pengaturanmodel->get_by_id_template($id);
        if ($cek == FALSE or empty($id)) {
            $data = array();
            $this->load->view('error_404', $data);
        } else {
            //edit data with id
            $this->template->load('template_admin/template_admin', 'pengaturan_template', $data);
        }
    }

    //---------------------------------------EDIT TEMPLATE---------------------------------------//
    public function edit_template($id = '') {

        $this->load->library('form_validation');
        $param = $this->input->post();

        $data = $this->security->xss_clean($param);

        $data['pic1'] = $data['logo_website'];
        $data['pic2'] = $data['logo_nama_website'];
        $data['pic3'] = $data['logo_favicon'];

        $data_img_1 = explode('/', $data['logo_website']);
        $img_name_1 = $data_img_1[2];

        $data_img_2 = explode('/', $data['logo_nama_website']);
        $img_name_2 = $data_img_2[2];

        $data_img_3 = explode('/', $data['logo_favicon']);
        $img_name_3 = $data_img_3[2];

        $this->form_validation->set_rules('nama_website', 'Nama Website', 'required');
        $this->form_validation->set_rules('judul_website', 'Judul Website', 'required');
        $this->form_validation->set_rules('warna_website', 'Judul Website', 'required');

        if ($this->form_validation->run() == FALSE) {
            //
            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('pengaturan/get_template/' . $id);
        } else {
            $this->load->library('upload'); //load library upload file
            $this->load->library('image_lib'); //load library image

            if (!empty($_FILES['img_logo_website']['tmp_name'])) {

                $this->delete_file_template($img_name_1); //delete existing file

                $path = 'uploads/data/';

                //config upload file
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 1048; //set without limit
                $config['overwrite'] = FALSE; //if have same name, add number
                $config['remove_spaces'] = TRUE; //change space into _
                $config['encrypt_name'] = TRUE;
                //initialize config upload
                $this->upload->initialize($config);

                if ($this->upload->do_upload('img_logo_website')) {//if success upload data
                    $result['upload'] = $this->upload->data();
                    $name = $result['upload']['file_name'];
                    $data['pic1'] = $path . $name;

                    $img['image_library'] = 'gd2';
                    $img['source_image'] = $path . $name;
                    $img['maintain_ratio'] = true;
                    $img['width'] = 100;
                    $img['weight'] = 100;

                    $this->image_lib->initialize($img);
                } else {
                    $this->session->set_flashdata('flash_message', warn_msg($this->upload->display_errors()));
                    redirect('pengaturan/get_template/' . $id);
                }
            }

            if (!empty($_FILES['img_logo_nama_website']['tmp_name'])) {

                $this->delete_file_template($img_name_2); //delete existing file

                $path = 'uploads/data/';

                //config upload file
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 1048; //set without limit
                $config['overwrite'] = FALSE; //if have same name, add number
                $config['remove_spaces'] = TRUE; //change space into _
                $config['encrypt_name'] = TRUE;
                //initialize config upload
                $this->upload->initialize($config);

                if ($this->upload->do_upload('img_logo_nama_website')) {//if success upload data
                    $result['upload'] = $this->upload->data();
                    $name = $result['upload']['file_name'];
                    $data['pic2'] = $path . $name;

                    $img['image_library'] = 'gd2';
                    $img['source_image'] = $path . $name;
                    $img['maintain_ratio'] = true;
                    $img['width'] = 100;
                    $img['weight'] = 100;

                    $this->image_lib->initialize($img);
                } else {
                    $this->session->set_flashdata('flash_message', warn_msg($this->upload->display_errors()));
                    redirect('pengaturan/get_template/' . $id);
                }
            }

            if (!empty($_FILES['img_logo_favicon']['tmp_name'])) {

                $this->delete_file_template($img_name_3); //delete existing file

                $path = 'uploads/data/';

                //config upload file
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 1048; //set without limit
                $config['overwrite'] = FALSE; //if have same name, add number
                $config['remove_spaces'] = TRUE; //change space into _
                $config['encrypt_name'] = TRUE;
                //initialize config upload
                $this->upload->initialize($config);

                if ($this->upload->do_upload('img_logo_favicon')) {//if success upload data
                    $result['upload'] = $this->upload->data();
                    $name = $result['upload']['file_name'];
                    $data['pic3'] = $path . $name;

                    $img['image_library'] = 'gd2';
                    $img['source_image'] = $path . $name;
                    $img['maintain_ratio'] = true;
                    $img['width'] = 100;
                    $img['weight'] = 100;

                    $this->image_lib->initialize($img);
                } else {
                    $this->session->set_flashdata('flash_message', warn_msg($this->upload->display_errors()));
                    redirect('pengaturan/get_template/' . $id);
                }
            }

            // print_r($data);exit;    
            $edit = $this->Pengaturanmodel->update_template($id, $data);
            if ($edit == true) {
                $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data Telah Tersimpan..'));
                redirect('pengaturan/get_template/' . $id);
            } else {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                redirect('pengaturan/get_template/' . $id);
            }
        }
    }

    public function delete_file_template($name = '') {
        $path = './uploads/data/';
        @unlink($path . $name);
    }

}
