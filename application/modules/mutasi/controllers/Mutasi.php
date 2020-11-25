<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mutasi extends MX_Controller {

    public function __construct() {
        parent::__construct();
        //Do your magic here 

        if ($this->session->userdata('ktpapps') == FALSE) {
            redirect('auth');
        }
        $this->load->model('Mutasimodel');
        $this->user = $this->session->userdata("ktpapps");
    }

    public function daftar_mutasi_keluar() {
        $data['mutasi_anggota_keluar'] = $this->Mutasimodel->get_mutasi_keluar($this->user['id_ref'], $this->user['role_admin']);
        $data['admin_mutasi'] = $this->Mutasimodel->get_admin_mutasi($this->user['id_ref'], $this->user['role_admin']);
        $data['count'] = $this->Mutasimodel->get_count();
        $this->template->load('template_admin/template_admin', 'daftar_mutasi_keluar', $data);
    }

    public function daftar_mutasi_masuk() {
        $data['mutasi_anggota_masuk'] = $this->Mutasimodel->get_mutasi_masuk($this->user['id_ref'], $this->user['role_admin']);
        $data['count'] = $this->Mutasimodel->get_count();
        $this->template->load('template_admin/template_admin', 'daftar_mutasi_masuk', $data);
    }

    public function mutasi_anggota() {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('id_region_tujuan', 'Region Tujuan Mutasi', 'required');

        $id = $data['id_ktp'];

        date_default_timezone_set("Asia/Jakarta");
        $date = date('Y-m-d H-i-s', time());

        $cek = $this->Mutasimodel->get_by_id_ktp($id);

        if ($cek == FALSE or empty($id)) {

            $this->load->view('error_404', $data);
        } else {
            if ($this->form_validation->run() == FALSE) {

                $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                redirect('ktp/ktp'); //folder, controller, method
            } else {
                $ktp = $this->Mutasimodel->get_ktp_mutasi($id);
                $data['id_anggota'] = $ktp[0]->id_ktp;
                $data['id_admin'] = $ktp[0]->id_admin;
                $data['id_region_asal'] = $ktp[0]->id_admin;
                $data['nama_anggota'] = $ktp[0]->nama_ktp;
                $data['nik_ktp'] = $ktp[0]->nik_ktp;
                $data['nomor_hp'] = $ktp[0]->nomor_hp_ktp;
                $data['status_pengurus'] = $ktp[0]->pengurus;
                $data['status_mutasi'] = 1;
                $data['no_kta_lama'] = $ktp[0]->nik_kta_baru;
                $data['tgl_pengajuan_mutasi'] = $date;

                $input = $this->Mutasimodel->insert_mutasi($data);
                $update = $this->Mutasimodel->update_status_mutasi_true($ktp[0]->id_ktp);

                if ($input == true && $update == true) {
                    $this->session->set_flashdata('flash_message', succ_msg("Berhasil, Mutasi Anggota '" . strtoupper($data['nama_anggota']) . "' telah tersimpan.."));
                    redirect('ktp/ktp');
                } else {
                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                    redirect('ktp/ktp');
                }
            }
        }
    }

    public function mutasi_anggota_pet() {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('id_region_tujuan', 'Region Tujuan Mutasi', 'required');

        $id = $data['id_ktp'];
        $id_url = $data['id_url'];

        date_default_timezone_set("Asia/Jakarta");
        $date = date('Y-m-d H-i-s', time());

        $cek = $this->Mutasimodel->get_by_id_ktp($id);

        if ($cek == FALSE or empty($id)) {

            $this->load->view('error_404', $data);
        } else {
            if ($this->form_validation->run() == FALSE) {

                $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                redirect('ktp/lihat_ktp_pet/' . $id_url); //folder, controller, method
            } else {
                $ktp = $this->Mutasimodel->get_ktp_mutasi($id);
                $data['id_anggota'] = $ktp[0]->id_ktp;
                $data['id_admin'] = $ktp[0]->id_admin;
                $data['id_region_asal'] = $ktp[0]->id_admin;
                $data['nama_anggota'] = $ktp[0]->nama_ktp;
                $data['nik_ktp'] = $ktp[0]->nik_ktp;
                $data['nomor_hp'] = $ktp[0]->nomor_hp_ktp;
                $data['status_pengurus'] = $ktp[0]->pengurus;
                $data['status_mutasi'] = 1;
                $data['no_kta_lama'] = $ktp[0]->nik_kta_baru;
                $data['tgl_pengajuan_mutasi'] = $date;

                $input = $this->Mutasimodel->insert_mutasi($data);
                $update = $this->Mutasimodel->update_status_mutasi_true($ktp[0]->id_ktp);

                if ($input == true && $update == true) {
                    $this->session->set_flashdata('flash_message', succ_msg("Berhasil, Mutasi Anggota '" . strtoupper($data['nama_anggota']) . "' telah tersimpan.."));
                    redirect('ktp/lihat_ktp_pet/' . $id_url);
                } else {
                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                    redirect('ktp/lihat_ktp_pet/' . $id_url);
                }
            }
        }
    }

    public function mutasi_anggota_admin() {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('id_region_tujuan', 'Region Tujuan Mutasi', 'required');

        $id = $data['id_ktp'];
        $id_url = $data['id_url'];

        date_default_timezone_set("Asia/Jakarta");
        $date = date('Y-m-d H-i-s', time());

        $cek = $this->Mutasimodel->get_by_id_ktp($id);

        if ($cek == FALSE or empty($id)) {

            $this->load->view('error_404', $data);
        } else {
            if ($this->form_validation->run() == FALSE) {

                $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                redirect('ktp/lihat_ktp_admin/' . $id_url); //folder, controller, method
            } else {
                $ktp = $this->Mutasimodel->get_ktp_mutasi($id);
                $data['id_anggota'] = $ktp[0]->id_ktp;
                $data['id_admin'] = $ktp[0]->id_admin;
                $data['id_region_asal'] = $ktp[0]->id_admin;
                $data['nama_anggota'] = $ktp[0]->nama_ktp;
                $data['nik_ktp'] = $ktp[0]->nik_ktp;
                $data['nomor_hp'] = $ktp[0]->nomor_hp_ktp;
                $data['status_pengurus'] = $ktp[0]->pengurus;
                $data['status_mutasi'] = 1;
                $data['no_kta_lama'] = $ktp[0]->nik_kta_baru;
                $data['tgl_pengajuan_mutasi'] = $date;

                $input = $this->Mutasimodel->insert_mutasi($data);
                $update = $this->Mutasimodel->update_status_mutasi_true($ktp[0]->id_ktp);

                if ($input == true && $update == true) {
                    $this->session->set_flashdata('flash_message', succ_msg("Berhasil, Mutasi Anggota '" . strtoupper($data['nama_anggota']) . "' telah tersimpan.."));
                    redirect('ktp/lihat_ktp_admin/' . $id_url);
                } else {
                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                    redirect('ktp/lihat_ktp_admin/' . $id_url);
                }
            }
        }
    }

    public function edit_mutasi_anggota($id = '') {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('id_region_tujuan', 'Region Tujuan Mutasi', 'required');

        $cek = $this->Mutasimodel->get_by_id_ktp($id);

        if ($cek == FALSE or empty($id)) {

            $this->load->view('error_404', $data);
        } else {
            if ($this->form_validation->run() == FALSE) {

                $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                redirect('mutasi/daftar_mutasi_keluar'); //folder, controller, method
            } else {

                $update = $this->Mutasimodel->update_mutasi($id, $data);

                if ($update == true) {
                    $this->session->set_flashdata('flash_message', succ_msg("Berhasil, Update Mutasi Anggota '" . strtoupper($data['nama_anggota']) . "' telah tersimpan.."));
                    redirect('mutasi/daftar_mutasi_keluar');
                } else {
                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                    redirect('mutasi/daftar_mutasi_keluar');
                }
            }
        }
    }

    public function delete_mutasi() {

        $id = $this->input->post('id');

        $id_admin = $this->Mutasimodel->get_id_mutasi($id);
        $update = $this->Mutasimodel->update_status_mutasi_false($id_admin[0]->id_anggota);
        $delete = $this->Mutasimodel->delete_mutasi_keluar($id);

        if ($delete == true && $update == true) {
            echo '1|' . succ_msg('Berhasil, Data Telah Terhapus..');
        } else {
            echo '0|' . err_msg('Maaf, Terjadi kesalahan, Coba lagi....');
        }
    }

    public function konfirmasi_anggota_mutasi() {

        $no_urut = '';
        $id = $this->input->post('id');
        $id_admin = $this->Mutasimodel->get_id_mutasi($id);
        $ktp = $this->Mutasimodel->get_ktp_mutasi($id_admin[0]->id_anggota);

        $id_admin_ktp = $this->Mutasimodel->get_by_id_admin_reg($id_admin[0]->id_region_tujuan);

        $get_code_wilayah = $this->Mutasimodel->get_code_wil($id_admin_ktp[0]->id_ref, $id_admin_ktp[0]->role_admin);

        $get_no_urutan = $this->Mutasimodel->get_no_urut($id_admin[0]->id_region_tujuan);

        $tgl_lahir = explode("/", $ktp[0]->tanggal_lahir);
        $no_tgl_lahir = substr($tgl_lahir['2'], 2, 2);
        $tgl_lahir_gab = $tgl_lahir['0'] . $tgl_lahir['1'] . $no_tgl_lahir;

        if (empty($get_no_urutan)) {
            $no_urut = '000001';
        } else {
            $no_urut = str_pad($get_no_urutan[0]->no_urut + 1, 6, "0", STR_PAD_LEFT);
        }

        $no_kta_baru = $get_code_wilayah[0]->code . $ktp[0]->id_asal . $tgl_lahir_gab . $no_urut;

        $data['nik_kta_lama'] = $ktp[0]->nik_kta_baru;
        $data['nik_kta_baru'] = $no_kta_baru;
        $data['id_regional_tujuan'] = $id_admin[0]->id_region_tujuan;
        $data['pengurus'] = 2;
        $data['id_petugas'] = 0;

        $update_anggota = $this->Mutasimodel->update_status_mutasi_false($id_admin[0]->id_anggota);
        $update_anggota_masuk = $this->Mutasimodel->update_status_ktp($id_admin[0]->id_anggota, $data);
        $update_mutasi = $this->Mutasimodel->update_status_mutasi_masuk($id, $data);

        if ($update_mutasi == true && $update_anggota == true && $update_anggota_masuk == true) {
            echo '1|' . succ_msg('Berhasil, Data Telah Dikonfirmasi..');
        } else {
            echo '0|' . err_msg('Maaf, Terjadi kesalahan, Coba lagi....');
        }
    }

    ///------------------------------------------------------------------------------------------//
}
