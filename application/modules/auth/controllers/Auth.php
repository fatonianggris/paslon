<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MX_Controller {

    public function __construct() {
        parent::__construct();
        //Do your magic here
        $this->load->model('Authmodel');
    }

    public function index() {
        if ($this->session->userdata('ktpapps') == TRUE) {
            redirect('dashboard');
        }
        $data = array();
        $data['template'] = $this->Authmodel->get_template();
        $this->load->view('login', $data);
    }

    public function login() {
        $param = $this->input->post();

        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('auth');
        } else {
            $user = $this->Authmodel->get_user($param);
            if (!empty($user)) {
                $this->session->set_userdata('ktpapps', $user);
//                var_dump($as['role_admin']);
//                exit();
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('flash_message', login_err('Maaf.., User tidak ditemukan  !!'));
                redirect('auth');
            }
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        $this->session->unset_userdata('ktpapps');
        //print_r($this->session->userdata());exit;
        redirect('auth');
    }

}
