<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pekerjaan extends MX_Controller {

    public function __construct() {
        parent::__construct();
        //Do your magic here 

        if ($this->session->userdata('ktpapps') == FALSE) {
            redirect('auth');
        }
        $this->load->model('Pekerjaanmodel');
        $this->user = $this->session->userdata("ktpapps");
    }

    //---------------------------------------DAFTAR PEKERJAAN---------------------------------------//

    public function daftar_pekerjaan() {

        $data['pekerjaan'] = $this->Pekerjaanmodel->get_pekerjaan(); //?
        $data['count'] = $this->Pekerjaanmodel->get_count();
        $this->template->load('template_admin/template_admin', 'daftar_pekerjaan', $data);
    }

    //---------------------------------------EDIT PEKERJAAN---------------------------------------//

    public function edit_pekerjaan($id = '') {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('job', 'Jenis Pekerjaan', 'required');

        if ($this->form_validation->run() == FALSE) {
            //
            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('pekerjaan/daftar_pekerjaan');
        } else {

            $edit = $this->Pekerjaanmodel->update_pekerjaan($id, $data);
            if ($edit == true) {

                $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data Telah Tersimpan..'));
                redirect('pekerjaan/daftar_pekerjaan');
            } else {

                $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                redirect('pekerjaan/daftar_pekerjaan');
            }
        }
    }

    //---------------------------------------KIRIM PEKERJAAN---------------------------------------//

    public function kirim_pekerjaan() {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('job', 'Jenis Pekerjaan', 'required');

        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('pekerjaan/daftar_pekerjaan'); //folder, controller, method
        } else {

            $input = $this->Pekerjaanmodel->insert_pekerjaan($data);
            if ($input == true) {

                $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data telah tersimpan..'));
                redirect('pekerjaan/daftar_pekerjaan');
            } else {

                $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                redirect('pekerjaan/daftar_pekerjaan');
            }
        }
    }

    //---------------------------------------DELETE PEKERJAAN---------------------------------------//

    public function delete_pekerjaan() {

        $id = $this->input->post('id');
        $delete = $this->Pekerjaanmodel->delete_pekerjaan($id);

        if ($delete == true) {

            echo '1|' . succ_msg('Berhasil, Data Telah Terhapus..');
        } else {
            echo '0|' . err_msg('Maaf, Terjadi kesalahan, Coba lagi....');
        }
    }

}
