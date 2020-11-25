<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {

    public function __construct() {
        parent::__construct();
        //Do your magic here

        if ($this->session->userdata('ktpapps') == FALSE) {
            redirect('auth');
        }
        $this->load->model('Dashboardmodel');
        $this->user = $this->session->userdata("ktpapps");
    }

    //---------------------------------------SET DASHBOARD ADMIN---------------------------------------//
    public function index() {
        $data['template'] = $this->Dashboardmodel->get_template();
        $data['ktp_reg'] = $this->Dashboardmodel->get_count_by_reg($this->user['id_ref'], $this->user['role_admin']);
        $data['ktp_petugas'] = $this->Dashboardmodel->get_count_by_ktp($this->user['id_ref'], $this->user['role_admin']);
        $data['laporan'] = $this->Dashboardmodel->get_count_laporan($this->user['id_ref'], $this->user['role_admin']);
        $data['duplikat'] = $this->Dashboardmodel->get_duplikat_ktp($this->user['id_ref'], $this->user['role_admin']);
        $data['petugas'] = $this->Dashboardmodel->get_petugas($this->user['id_ref'], $this->user['role_admin']);
        $data['prov'] = $this->Dashboardmodel->get_provinsi(); //?
        $data['kab'] = $this->Dashboardmodel->get_kabupaten(); //?
        $this->template->load('template_admin/template_admin', 'dashboard', $data);
    }

}
