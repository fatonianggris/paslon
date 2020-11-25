<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pemilihan extends MX_Controller {

    public function __construct() {
        parent::__construct();
//Do your magic here 
        $this->load->model('Pemilihanmodel');
        if ($this->session->userdata('ktpapps') == FALSE) {
            redirect('auth');
        }
        $this->user = $this->session->userdata("ktpapps");
    }

//---------------------------------------DAFTAR DATA PEMILIHAN-------------------------------------------------//

    public function daftar_pemilihan() {
        $data['provinsi'] = $this->Pemilihanmodel->get_provinsi($this->user['id_ref'], $this->user['role_admin']); //?
        $data['count'] = $this->Pemilihanmodel->get_count_pemilihan($this->user['id_ref'], $this->user['role_admin']);
        $data['pemilihan'] = $this->Pemilihanmodel->get_data_pemilihan($this->user['id_ref'], $this->user['role_admin']); //?

        $this->template->load('template_admin/template_admin', 'daftar_pemilihan', $data);
    }

    //---------------------------------------DAFTAR DATA PEMILIHAN-------------------------------------------------//

    public function dashboard_pemilihan($id_pemilihan = "") {
        $data['count'] = $this->Pemilihanmodel->get_count_dashboard($id_pemilihan);
        $data['pemilihan'] = $this->Pemilihanmodel->get_data_id_pemilihan($id_pemilihan, $this->user['id_ref'], $this->user['role_admin']); //?
        $data['calon_pemilihan'] = $this->Pemilihanmodel->get_data_id_calon_pemilihan($id_pemilihan); //?
        $data['tps'] = $this->Pemilihanmodel->get_all_tps($id_pemilihan);
        $data['provinsi_suara'] = $this->Pemilihanmodel->get_suara_provinsi($id_pemilihan, $data['pemilihan'][0]->id_kategori_pemilihan, $data['pemilihan'][0]->id_regional_pemilihan);
        $data['kabupaten_suara'] = $this->Pemilihanmodel->get_suara_kabupaten($id_pemilihan, $data['pemilihan'][0]->id_kategori_pemilihan, $data['pemilihan'][0]->id_regional_pemilihan);
        $data['kecamatan_suara'] = $this->Pemilihanmodel->get_suara_kecamatan($id_pemilihan, $data['pemilihan'][0]->id_kategori_pemilihan, $data['pemilihan'][0]->id_regional_pemilihan);
        $this->template->load('template_admin/template_admin', 'dashboard_pemilihan', $data);
    }

//---------------------------------------DAFTAR DATA TPS DAN PETUGAS--------------------------------------------------//

    public function daftar_tps_petugas($id_wilayah_pemilihan = '', $id_pemilihan = "") {

        $data['count'] = $this->Pemilihanmodel->get_count_tps_petugas($id_wilayah_pemilihan, $id_pemilihan, $this->user['id_ref'], $this->user['role_admin']);
        $data['pemilihan'] = $this->Pemilihanmodel->get_data_id_pemilihan($id_pemilihan, $this->user['id_ref'], $this->user['role_admin']);
        $data['nama_wilayah'] = $this->Pemilihanmodel->get_nama_wilayah($id_wilayah_pemilihan);
        $data['petugas_saksi'] = $this->Pemilihanmodel->get_data_petugas_saksi($id_pemilihan, $id_wilayah_pemilihan, $this->user['id_ref'], $this->user['role_admin']); //?
        $data['petugas_saksi_terpakai'] = $this->Pemilihanmodel->get_data_petugas_saksi_terpakai($id_pemilihan, $this->user['id_ref'], $this->user['role_admin']); //?

        $this->template->load('template_admin/template_admin', 'daftar_tps_petugas', $data);
    }

    //---------------------------------------DAFTAR DATA PETUGAS SAKSI-------------------------------------------------//

    public function daftar_petugas_saksi($id_pemilihan = "") {

        $data['count'] = $this->Pemilihanmodel->get_count_tps_petugas($id_pemilihan, $this->user['id_ref'], $this->user['role_admin']);
        $data['pemilihan'] = $this->Pemilihanmodel->get_data_id_pemilihan($id_pemilihan, $this->user['id_ref'], $this->user['role_admin']); //?

        $this->template->load('template_admin/template_admin', 'daftar_petugas_saksi', $data);
    }

//---------------------------------------DAFTAR DATA TPS DAN PETUGAS--------------------------------------------------//

    public function daftar_region_pemilihan($id_pemilihan = "") {

        $data['count'] = $this->Pemilihanmodel->get_count_tps_petugas($id_pemilihan, $this->user['id_ref'], $this->user['role_admin']);
        $data['pemilihan'] = $this->Pemilihanmodel->get_data_id_pemilihan($id_pemilihan, $this->user['id_ref'], $this->user['role_admin']); //?

        $this->template->load('template_admin/template_admin', 'daftar_region_pemilihan', $data);
    }

    //---------------------------------------DAFTAR DATA CALON SAINGAN-------------------------------------------------//

    public function daftar_calon_pemilihan($id_pemilihan = "") {

        $data['count'] = $this->Pemilihanmodel->get_count_tps_petugas($id_pemilihan, $this->user['id_ref'], $this->user['role_admin']);
        $data['pemilihan'] = $this->Pemilihanmodel->get_data_id_pemilihan($id_pemilihan, $this->user['id_ref'], $this->user['role_admin']); //?
        $data['calon_pemilihan'] = $this->Pemilihanmodel->get_data_id_calon_pemilihan($id_pemilihan); //?

        $this->template->load('template_admin/template_admin', 'daftar_calon_pemilihan', $data);
    }

//---------------------------------------DAFTAR DATA HASIL SUARA--------------------------------------------------//

    public function hasil_pemilihan_suara($id_tps = "", $id_pemilihan = "", $id_wilayah_pemilihan = '') {

        $data['pemilihan'] = $this->Pemilihanmodel->get_data_id_pemilihan($id_pemilihan, $this->user['id_ref'], $this->user['role_admin']); //?
        $data['nama_wilayah'] = $this->Pemilihanmodel->get_nama_wilayah($id_wilayah_pemilihan);
        $data['petugas_saksi'] = $this->Pemilihanmodel->get_data_petugas_saksi($id_pemilihan, $id_wilayah_pemilihan, $this->user['id_ref'], $this->user['role_admin']); //?
        $data['petugas_saksi_terpakai'] = $this->Pemilihanmodel->get_data_petugas_saksi_terpakai($id_pemilihan, $this->user['id_ref'], $this->user['role_admin']); //?
        $data['tps'] = $this->Pemilihanmodel->get_hasil_tps($id_tps);
        $data['calon_pemilihan'] = $this->Pemilihanmodel->get_data_id_calon_pemilihan($id_pemilihan);

        $cek_hasil_pemilihan = $this->Pemilihanmodel->get_hasil_pemilihan($id_tps, $id_pemilihan, $id_wilayah_pemilihan);

        if ($cek_hasil_pemilihan == TRUE) {
            $data['get_hasil_pemilihan'] = $this->Pemilihanmodel->get_hasil_pemilihan($id_tps, $id_pemilihan, $id_wilayah_pemilihan);
            $data['suara_calon'] = $this->Pemilihanmodel->get_hasil_suara_calon_view($id_tps, $id_pemilihan, $id_wilayah_pemilihan);
            $this->template->load('template_admin/template_admin', 'view_hasil_tps', $data);
        } else {
            $data['suara_calon'] = $this->Pemilihanmodel->get_hasil_suara_calon($id_pemilihan);
            $this->template->load('template_admin/template_admin', 'input_hasil_tps', $data);
        }
    }

//---------------------------------------TAMBAH PEMILIHAN --------------------------------------------------// 
    public function tambah_pemilihan() {

        $data['provinsi'] = $this->Pemilihanmodel->get_provinsi($this->user['id_ref'], $this->user['role_admin']); //?

        $this->template->load('template_admin/template_admin', 'tambah_pemilihan', $data);
    }

    //---------------------------------------TAMBAH PEMILIHAN --------------------------------------------------// 
    public function tambah_calon_pemilihan($id_pemilihan = "") {

        $data['count'] = $this->Pemilihanmodel->get_count_tps_petugas($id_pemilihan, $this->user['id_ref'], $this->user['role_admin']);
        $data['pemilihan'] = $this->Pemilihanmodel->get_data_id_pemilihan($id_pemilihan, $this->user['id_ref'], $this->user['role_admin']); //?

        $this->template->load('template_admin/template_admin', 'tambah_calon_pemilihan', $data);
    }

//---------------------------------------TAMBAH TPS --------------------------------------------------// 
    public function tambah_tps($id_pemilihan = "", $id_wilayah_pemilihan = '') {

        $data['nama_wilayah'] = $this->Pemilihanmodel->get_nama_wilayah($id_wilayah_pemilihan);
        $data['pemilihan'] = $this->Pemilihanmodel->get_data_id_pemilihan($id_pemilihan, $this->user['id_ref'], $this->user['role_admin']); //?
        $data['petugas_saksi'] = $this->Pemilihanmodel->get_data_petugas_saksi($id_pemilihan, $id_wilayah_pemilihan, $this->user['id_ref'], $this->user['role_admin']); //?
        $data['petugas_saksi_terpakai'] = $this->Pemilihanmodel->get_data_petugas_saksi_terpakai($id_pemilihan, $this->user['id_ref'], $this->user['role_admin']); //?
        $this->template->load('template_admin/template_admin', 'tambah_tps', $data);
    }

//---------------------------------------TAMBAH PETUGAS SAKSI --------------------------------------------------// 
    public function tambah_petugas_saksi($id_pemilihan = "") {

        $data['count'] = $this->Pemilihanmodel->get_count_tps_petugas($id_pemilihan, $this->user['id_ref'], $this->user['role_admin']);
        $data['pemilihan'] = $this->Pemilihanmodel->get_data_id_pemilihan($id_pemilihan, $this->user['id_ref'], $this->user['role_admin']); //?

        $this->template->load('template_admin/template_admin', 'tambah_petugas_saksi', $data);
    }

//---------------------------------------TAMBAH PETUGAS SAKSI --------------------------------------------------// 
    public function tambah_hasil_pemilihan_suara($id = "") {

        $data['provinsi'] = $this->Pemilihanmodel->get_provinsi($this->user['id_ref'], $this->user['role_admin']); //?
        $data['kabupaten'] = $this->Pemilihanmodel->get_kabupaten($this->user['id_ref'], $this->user['role_admin']); //?

        $this->template->load('template_admin/template_admin', 'tambah_pemilihan', $data);
    }

    //---------------------------------------GET PEMILIHAN SUARA--------------------------------------------------// 

    public function get_hasil_pemilihan_suara($id_tps = "", $id_pemilihan = "", $id_wilayah_pemilihan = '') {

        $data['pemilihan'] = $this->Pemilihanmodel->get_data_id_pemilihan($id_pemilihan, $this->user['id_ref'], $this->user['role_admin']); //?
        $data['nama_wilayah'] = $this->Pemilihanmodel->get_nama_wilayah($id_wilayah_pemilihan);
        $data['petugas_saksi'] = $this->Pemilihanmodel->get_data_petugas_saksi($id_pemilihan, $id_wilayah_pemilihan, $this->user['id_ref'], $this->user['role_admin']); //?
        $data['petugas_saksi_terpakai'] = $this->Pemilihanmodel->get_data_petugas_saksi_terpakai($id_pemilihan, $this->user['id_ref'], $this->user['role_admin']); //?
        $data['tps'] = $this->Pemilihanmodel->get_hasil_tps($id_tps);
        $data['calon_pemilihan'] = $this->Pemilihanmodel->get_data_id_calon_pemilihan($id_pemilihan);
        $data['suara_calon'] = $this->Pemilihanmodel->get_hasil_suara_calon_edit($id_tps, $id_pemilihan, $id_wilayah_pemilihan);
        $data['get_hasil_pemilihan'] = $this->Pemilihanmodel->get_hasil_pemilihan($id_tps, $id_pemilihan, $id_wilayah_pemilihan);

        $this->template->load('template_admin/template_admin', 'edit_hasil_tps', $data);
    }

    //---------------------------------------GET CALON PEMILIHAN --------------------------------------------------// 

    public function get_calon_pemilihan($id = '', $id_pemilihan = '') {

        $data['count'] = $this->Pemilihanmodel->get_count_tps_petugas($id_pemilihan, $this->user['id_ref'], $this->user['role_admin']);
        $data['pemilihan'] = $this->Pemilihanmodel->get_data_id_pemilihan($id_pemilihan, $this->user['id_ref'], $this->user['role_admin']); //?
        $data['get_calon_pemilihan'] = $this->Pemilihanmodel->get_data_id_calon($id); //?

        $this->template->load('template_admin/template_admin', 'edit_calon_pemilihan', $data);
    }

    //---------------------------------------KIRIM CALON PEMILIHAN---------------------------------------//
    public function kirim_calon_pemilihan($id_pemilihan = "") {
        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('nomor_urut_awal', 'Nomor Urut', 'required');
        $this->form_validation->set_rules('nama_calon_awal', 'Nama Calon', 'required');

        $cek_no_urut = $this->Pemilihanmodel->cek_nomor_urut_calon($id_pemilihan, $data['nomor_urut']);

        if ($cek_no_urut == TRUE or ! empty($cek_no_urut)) {

            $this->session->set_flashdata('flash_message', succ_msg("Maaf, Nomor Urut .$data[nomor_urut]. sudah dibuat.."));
            redirect('pemilihan/tambah_calon_pemilihan/' . $id_pemilihan);
        } else {
            if ($this->form_validation->run() == FALSE) {

                $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                redirect('pemilihan/tambah_calon_pemilihan/' . $id_pemilihan);
            } else {

                $input = $this->Pemilihanmodel->insert_calon_pemilihan($data, $id_pemilihan);

                if ($input == true) {
                    $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data Telah Tersimpan..'));
                    redirect('pemilihan/tambah_calon_pemilihan/' . $id_pemilihan);
                } else {
                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                    redirect('pemilihan/tambah_calon_pemilihan/' . $id_pemilihan);
                }
            }
        }
    }

    //---------------------------------------KIRIM HASIL PEMILIHANS---------------------------------------//
    public function kirim_hasil_pemilihan($id_tps = "", $id_pemilihan = "", $id_wilayah_pemilihan = '') {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('dp_dpt_laki_laki', 'Data Pemilih Pemilih Tetap Laki-laki', 'required');
        $this->form_validation->set_rules('dp_dpt_perempuan', 'Data Pemilih Pemilih Tetap Perempuan', 'required');
        $this->form_validation->set_rules('dp_dpph_laki_laki', 'Data Pemilih Pemilih Pindahan Laki-laki', 'required');
        $this->form_validation->set_rules('dp_dpph_perempuan', 'Data Pemilih Pemilih Pindahan Perempuan', 'required');
        $this->form_validation->set_rules('dp_dptb_laki_laki', 'Data Pemilih Pemilih Tambahan Laki-laki', 'required');
        $this->form_validation->set_rules('dp_dptb_perempuan', 'Data Pemilih Pemilih Tambahan Perempuan', 'required');
        $this->form_validation->set_rules('dp_total', 'Total Data Pemilih', 'required');

        $this->form_validation->set_rules('php_dpt_laki_laki', 'Pengguna Hak Pilih Pemilih Tetap Laki-laki', 'required');
        $this->form_validation->set_rules('php_dpt_perempuan', 'Pengguna Hak Pilih Pemilih Tetap Perempuan', 'required');
        $this->form_validation->set_rules('php_dpph_laki_laki', 'Pengguna Hak Pilih Pemilih Pindahan Laki-laki', 'required');
        $this->form_validation->set_rules('php_dpph_perempuan', 'Pengguna Hak Pilih Pemilih Pindahan Perempuan', 'required');
        $this->form_validation->set_rules('php_dptb_laki_laki', 'Pengguna Hak Pilih Pemilih Tambahan Laki-laki', 'required');
        $this->form_validation->set_rules('php_dptb_perempuan', 'Pengguna Hak Pilih Pemilih Tambahan Perempuan', 'required');
        $this->form_validation->set_rules('php_total', 'Total Pengguna Hak Pilih', 'required');

        $this->form_validation->set_rules('total_suara_sah', 'Perolehan Suara Sah', 'required');
        $this->form_validation->set_rules('total_suara_tidak_sah', 'Perolehan Suara Tidak Sah', 'required');

        $this->form_validation->set_rules('suara_sah[]', 'Perolehan Suara Sah Tiap Calon', 'required');

        if (!isset($data['id_petugas_saksi'])) {
            $data['id_petugas_saksi'] = '';
        } else {
            $data['id_petugas_saksi'] = implode(',', $data['id_petugas_saksi']);
        }

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('pemilihan/hasil_pemilihan_suara/' . $id_tps . '/' . $id_pemilihan . '/' . $id_wilayah_pemilihan);
        } else {

            $this->load->library('upload'); //load library upload file
            $this->load->library('image_lib'); //load library image
            $illegalChar = array(".", ",", "?", "!", ":", ";", "-", "+", "<", ">", "%", "~", "€", "$", "[", "]", "{", "}", "@", "&", "#", "*", "„", "/", "\\", "|", "'", '"', " ");

            $nama_tps = $this->Pemilihanmodel->get_tps($id_tps);
            $nama_file = strtolower(str_replace($illegalChar, '_', $nama_tps[0]->nama_tps));
            $nama_file_done = preg_replace('/\s+/', '', $nama_file);

            if (!empty($_FILES['fotoc1_pertama'])) {

                $path = $nama_tps[0]->path_tps . '/foto/';
                $path_thumb = $nama_tps[0]->path_tps . '/foto/thumbs/';

                //config upload file
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 2048; //set limit
                $config['overwrite'] = FALSE; //if have same name, add number
                $config['remove_spaces'] = TRUE; //change space into _
                $config['encrypt_name'] = FALSE;
                $config['file_name'] = $nama_file_done . '_fotoc1_pertama';
                //initialize config upload
                $this->upload->initialize($config);

                if ($this->upload->do_upload('fotoc1_pertama')) {//if success upload data
                    $result['upload'] = $this->upload->data();
                    $name = $result['upload']['file_name'];
                    $data['fotoc1_pertama'] = $path . $name;

                    $img['image_library'] = 'gd2';
                    $img['source_image'] = $path . $name;
                    $img['new_image'] = $path_thumb . $name;
                    $img['maintain_ratio'] = true;
                    $img['width'] = 600;
                    $img['height'] = 800;
//                    var_dump($img['new_image']);
//                    exit;
                    $this->image_lib->initialize($img);
                    if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                        $data['fotoc1_pertama_thumb'] = $path_thumb . $name;
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                        redirect('pemilihan/hasil_pemilihan_suara/' . $id_tps . '/' . $id_pemilihan . '/' . $id_wilayah_pemilihan);
                    }
                }
            }

            if (!empty($_FILES['fotoc1_kedua'])) {

                $path = $nama_tps[0]->path_tps . '/foto/';
                $path_thumb = $nama_tps[0]->path_tps . '/foto/thumbs/';

                //config upload file
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 2048; //set limit
                $config['overwrite'] = FALSE; //if have same name, add number
                $config['remove_spaces'] = TRUE; //change space into _
                $config['encrypt_name'] = FALSE;
                $config['file_name'] = $nama_file_done . '_fotoc1_kedua';
                //initialize config upload
                $this->upload->initialize($config);

                if ($this->upload->do_upload('fotoc1_kedua')) {//if success upload data
                    $result['upload'] = $this->upload->data();
                    $name = $result['upload']['file_name'];
                    $data['fotoc1_kedua'] = $path . $name;

                    $img['image_library'] = 'gd2';
                    $img['source_image'] = $path . $name;
                    $img['new_image'] = $path_thumb . $name;
                    $img['maintain_ratio'] = true;
                    $img['width'] = 600;
                    $img['height'] = 800;
//                    var_dump($img['new_image']);
//                    exit;
                    $this->image_lib->initialize($img);
                    if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                        $data['fotoc1_kedua_thumb'] = $path_thumb . $name;
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                        redirect('pemilihan/hasil_pemilihan_suara/' . $id_tps . '/' . $id_pemilihan . '/' . $id_wilayah_pemilihan);
                    }
                }
            }

            $input_hasil = $this->Pemilihanmodel->insert_hasil_pemilihan($data, $id_tps, $id_pemilihan, $id_wilayah_pemilihan);

            if ($input_hasil == true) {

                $hasil_array = array();
                for ($i = 0; $i < count($data['suara_sah']); $i++) {

                    $hasil_array[$i] = array(
                        'id_calon_pemilihan' => $data['id_calon_pemilihan'][$i],
                        'id_pemilihan' => $id_pemilihan,
                        'id_wilayah_pemilihan' => $id_wilayah_pemilihan,
                        'id_tps' => $id_tps,
                        'suara_sah' => $data['suara_sah'][$i]
                    );
                }

                $input_suara = $this->db->insert_batch('suara_calon', $hasil_array);
                $update_status_tps = $this->Pemilihanmodel->update_status_hasil_pemilihan($id_tps, $id_pemilihan, $id_wilayah_pemilihan);

                if ($input_suara == TRUE && $update_status_tps == TRUE) {
                    $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data telah tersimpan..'));
                    redirect('pemilihan/hasil_pemilihan_suara/' . $id_tps . '/' . $id_pemilihan . '/' . $id_wilayah_pemilihan);
                } else {
                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                    redirect('pemilihan/hasil_pemilihan_suara/' . $id_tps . '/' . $id_pemilihan . '/' . $id_wilayah_pemilihan);
                }
            } else {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                redirect('pemilihan/hasil_pemilihan_suara/' . $id_tps . '/' . $id_pemilihan . '/' . $id_wilayah_pemilihan);
            }
        }
    }

//---------------------------------------KIRIM TPS---------------------------------------//
    public function kirim_tps($id_pemilihan = "", $id_wilayah_pemilihan = '') {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('jumlah_tps', 'Jumlah TPS', 'required');
        $this->form_validation->set_rules('nama_tps', 'Nama TPS', 'required');

        if (!isset($data['id_petugas_saksi'])) {
            $data['id_petugas_saksi'] = '';
        } else {
            $data['id_petugas_saksi'] = implode(',', $data['id_petugas_saksi']);
        }

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('pemilihan/tambah_tps/' . $id_pemilihan . '/' . $id_wilayah_pemilihan);
        } else {
            $illegalChar = array(".", ",", "?", "!", ":", ";", "-", "+", "<", ">", "%", "~", "€", "$", "[", "]", "{", "}", "@", "&", "#", "*", "„", "/", "\\", "|", "'", '"', " ");

            $wilayah = $this->Pemilihanmodel->get_nama_wilayah($id_wilayah_pemilihan);
            $get_max_nomor_tps = $this->Pemilihanmodel->get_max_nomor_tps($id_pemilihan, $id_wilayah_pemilihan);
            $pemilihan = $this->Pemilihanmodel->get_data_id_pemilihan($id_pemilihan, $this->user['id_ref'], $this->user['role_admin']); //?

            $name_dir_region_prov = strtolower(str_replace($illegalChar, '_', $wilayah[0]->provinsi . '_' . $wilayah[0]->id_dati1));
            $name_dir_region_kab = strtolower(str_replace($illegalChar, '_', $wilayah[0]->kabupaten . '_' . $wilayah[0]->id_dati2));
            $name_dir_region_kec = strtolower(str_replace($illegalChar, '_', $wilayah[0]->kecamatan . '_' . $wilayah[0]->id_dati3));
            $name_dir_region_kel = strtolower(str_replace($illegalChar, '_', $wilayah[0]->kelurahan . '_' . $wilayah[0]->id));
            $path_wilayah = $pemilihan[0]->path_pemilihan . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec . '/' . $name_dir_region_kel;
            $path_wilayah_done = preg_replace('/\s+/', '', $path_wilayah);

            $tps_array = array();

            for ($i = 1; $i <= $data['jumlah_tps']; $i++) {
                $nomor_tps = str_pad($get_max_nomor_tps[0]->nomor_tps + $i, 3, "0", STR_PAD_LEFT);
                $nama_tps = $data['nama_tps'];
                $tps_path = strtolower(str_replace($illegalChar, '_', $nama_tps . '_' . $nomor_tps));
                $tps_path_done = preg_replace('/\s+/', '', $tps_path);

                $tps_array[] = array(
                    'id_pemilihan' => $id_pemilihan,
                    'id_wilayah_pemilihan' => $id_wilayah_pemilihan,
                    'id_admin' => $this->user['id_ref'],
                    'id_petugas_saksi' => $data['id_petugas_saksi'],
                    'nomor_tps' => $nomor_tps,
                    'nama_tps' => $nama_tps,
                    'path_tps' => $path_wilayah_done . '/' . $tps_path_done
                );

                file_put_contents("README_JANGAN_DIHAPUS.txt", $current);
                mkdir($path_wilayah_done . '/' . $tps_path_done, 0777, true);
                mkdir($path_wilayah_done . '/' . $tps_path_done . '/foto/', 0777, true);
                mkdir($path_wilayah_done . '/' . $tps_path_done . '/foto/thumbs', 0777, true);

                $content = "JANGAN DIHAPUS!!, INI MERUPAKAN FILE TPS " . $data['nama_tps'] . '-' . $nomor_tps;
                $fp_foto = fopen($path_wilayah_done . '/' . $tps_path_done . '/foto/' . 'README_JANGAN_DIHAPUS.txt', "wb");
                fwrite($fp_foto, $content);
                fclose($fp_foto);

                $content = "JANGAN DIHAPUS!!, INI MERUPAKAN FILE TPS " . $data['nama_tps'] . '-' . $nomor_tps;
                $fp_foto_thumb = fopen($path_wilayah_done . '/' . $tps_path_done . '/foto/thumbs/' . 'README_JANGAN_DIHAPUS.txt', "wb");
                fwrite($fp_foto_thumb, $content);
                fclose($fp_foto_thumb);
            }

            $input = $this->db->insert_batch('tps', $tps_array);

            if ($input == true) {

                $id_tps = $this->Pemilihanmodel->get_max_id_tps();
                $id_pemilihan_array = explode(',', $data['id_petugas_saksi']);

                $saksi_array = array();

                if ($data['jumlah_tps'] == 1) {
                    for ($i = 0; $i < count($id_pemilihan_array); $i++) {

                        $saksi_array[$i] = array(
                            'id_saksi' => $id_pemilihan_array[$i],
                            'id_wilayah_pemilihan' => $id_wilayah_pemilihan,
                            'id_tps' => $id_tps[0]->id_tps
                        );
                    }

                    $update_saksi = $this->db->update_batch('saksi', $saksi_array, 'id_saksi');
                }

                $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data telah tersimpan..'));
                redirect('pemilihan/tambah_tps/' . $id_pemilihan . '/' . $id_wilayah_pemilihan);
            } else {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                redirect('pemilihan/tambah_tps/' . $id_pemilihan . '/' . $id_wilayah_pemilihan);
            }
        }
    }

    //---------------------------------------KIRIM PETUGAS SAKSI---------------------------------------//
    public function kirim_petugas_saksi($id_pemilihan = "") {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('kategori_petugas', 'Kategori Saksi', 'required');
        $this->form_validation->set_rules('password', 'Paswoord', 'required');

        if ($data['kategori_petugas'] == 1) {
            $this->form_validation->set_rules('nomor_ktp_saksi', 'Nomor KTP', 'required');
            $this->form_validation->set_rules('nama_saksi', 'Nama Saksi', 'required');
            $this->form_validation->set_rules('email_saksi', 'Email Saksi', 'required');
            $this->form_validation->set_rules('nomor_hp_saksi', 'Nomor HP', 'required');
        } else {
            $this->form_validation->set_rules('anggota_saksi[]', 'Anggota Sebagai Saksi', 'required');
        }

        $cek_email = $this->Pemilihanmodel->cek_email_saksi($data['email_saksi']);

        if ($cek_email == TRUE or ! empty($cek_email)) {

            $this->session->set_flashdata('flash_message', succ_msg("Maaf, Email .$data[email_saksi]. sudah digunakan.."));
            redirect('pemilihan/tambah_petugas_saksi/' . $id_pemilihan);
        } else {

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                redirect('pemilihan/tambah_petugas_saksi/' . $id_pemilihan);
            } else {

                if ($data['kategori_petugas'] == 1) {

                    $input = $this->Pemilihanmodel->insert_petugas_saksi($data, $this->user['id_ref'], $id_pemilihan);
                } else {

                    $data_anggota = implode(',', $data['anggota_saksi']);
                    $anggota = $this->Pemilihanmodel->anggota_saksi($data_anggota);

                    $petugas_array = array();
//                    var_dump($anggota);
//                    exit;
                    for ($i = 0; $i <= count($anggota) - 1; $i++) {
                        $petugas_array[] = array(
                            'id_pemilihan' => $id_pemilihan,
                            'id_admin' => $anggota[$i]->id_admin,
                            'id_anggota' => $anggota[$i]->id_ktp,
                            'id_asal_saksi' => $anggota[$i]->id_asal,
                            'nama_saksi' => $anggota[$i]->nama_ktp,
                            'nomor_ktp_saksi' => $anggota[$i]->nik_ktp,
                            'email_saksi' => $anggota[$i]->email,
                            'nomor_hp_saksi' => $anggota[$i]->nomor_hp_ktp,
                            'tempat_lahir' => $anggota[$i]->tempat_lahir,
                            'tanggal_lahir' => $anggota[$i]->tanggal_lahir,
                            'alamat_saksi' => $anggota[$i]->alamat_ktp,
                            'rt' => $anggota[$i]->rt,
                            'rw' => $anggota[$i]->rw,
                            'kodepos' => $anggota[$i]->kodepos,
                            'jenis_kelamin' => $anggota[$i]->jenis_kelamin,
                            'img_pas' => $anggota[$i]->img_pas,
                            'barcode' => $anggota[$i]->barcode,
                            'password_saksi' => md5($data['password'])
                        );
                    }
                    $input = $this->db->insert_batch('saksi', $petugas_array);
                }

                if ($input == true) {
                    $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data telah tersimpan..'));
                    redirect('pemilihan/tambah_petugas_saksi/' . $id_pemilihan);
                } else {
                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                    redirect('pemilihan/tambah_petugas_saksi/' . $id_pemilihan);
                }
            }
        }
    }

    public function get_petugas_saksi($id = '', $id_pemilihan = '') {

        $data['pemilihan'] = $this->Pemilihanmodel->get_data_id_pemilihan($id_pemilihan, $this->user['id_ref'], $this->user['role_admin']); //?
        $data['petugas_saksi'] = $this->Pemilihanmodel->get_by_id_petugas_saksi($id, $id_pemilihan);

        $this->template->load('template_admin/template_admin', 'edit_petugas_saksi', $data);
    }

    public function edit_petugas_saksi($id_petugas = '', $id_pemilihan = "") {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('nomor_ktp_saksi', 'Nomor KTP', 'required');
        $this->form_validation->set_rules('nama_saksi', 'Nama Saksi', 'required');
        $this->form_validation->set_rules('email_saksi', 'Email Saksi', 'required');
        $this->form_validation->set_rules('nomor_hp_saksi', 'Nomor HP', 'required');

        $cek_email = $this->Pemilihanmodel->cek_email_saksi($id_petugas);
        $cek = $this->Pemilihanmodel->get_by_id_petugas_saksi($id_petugas);

        if ($cek_email == TRUE && $cek[0]->email_saksi != $data['email_saksi']) {

            $this->session->set_flashdata('flash_message', warn_msg("Maaf, Email .$data[email_saksi]. sudah digunakan.."));
            redirect('pemilihan/get_petugas_saksi/' . $id_petugas . '/' . $id_pemilihan);
        } else {

            if ($cek == FALSE or empty($id_petugas)) {
                $data = array();
                $this->load->view('error_404', $data);
            } else {

                if ($this->form_validation->run() == FALSE) {

                    $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                    redirect('pemilihan/get_petugas_saksi/' . $id_petugas . '/' . $id_pemilihan);
                } else {

                    if ($data['password_lama'] != '') {
                        $this->form_validation->set_rules('password_baru', 'Password Baru', 'required|min_length[4]|matches[conf_password_lama]');
                        $this->form_validation->set_rules('conf_password_lama', 'Password Konfirmasi Baru', 'required|min_length[4]');

                        if ($this->form_validation->run() == FALSE) {

                            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                            redirect('pemilihan/get_petugas_saksi/' . $id_petugas . '/' . $id_pemilihan);
                        } else {
                            $cek_pass = $this->Pemilihanmodel->cek_password_saksi($id_petugas, $data['password_lama']);
                            if ($cek_pass) {
                                $this->Pemilihanmodel->update_password_saksi($id_petugas, $data['password_baru']);
                            } else {
                                $this->session->set_flashdata('flash_message', warn_msg("Maaf, Password Lama Anda salah/tidak sesuai.."));
                                redirect('pemilihan/get_petugas_saksi/' . $id_petugas . '/' . $id_pemilihan);
                            }
                        }
                    }

                    $edit = $this->Pemilihanmodel->update_petugas_saksi($id_petugas, $data);
                    if ($edit == true) {

                        $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data Telah Tersimpan..'));
                        redirect('pemilihan/get_petugas_saksi/' . $id_petugas . '/' . $id_pemilihan);
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                        redirect('pemilihan/get_petugas_saksi/' . $id_petugas . '/' . $id_pemilihan);
                    }
                }
            }
        }
    }

    //---------------------------------------EDIT CALON PEMILIHAN---------------------------------------//
    public function edit_calon_pemilihan($id_calon = "", $id_pemilihan = "") {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('nomor_urut', 'Nomor Urut', 'required');
        $this->form_validation->set_rules('nama_calon', 'Nama Calon', 'required');

        $cek_no_urut = $this->Pemilihanmodel->cek_nomor_urut_calon($id_pemilihan, $data['nomor_urut']);

        if ($cek_no_urut == TRUE && $cek_no_urut[0]->nomor_urut != $data['nomor_urut']) {

            $this->session->set_flashdata('flash_message', succ_msg("Maaf, Nomor Urut .$data[nomor_urut]. sudah dibuat.."));
            redirect('pemilihan/get_calon_pemilihan/' . $id_calon . '/' . $id_pemilihan);
        } else {
            if ($this->form_validation->run() == FALSE) {

                $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                redirect('pemilihan/get_calon_pemilihan/' . $id_calon . '/' . $id_pemilihan);
            } else {

                $update = $this->Pemilihanmodel->update_calon_pemilihan($id_calon, $data);

                if ($update == true) {
                    $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data Telah Tersimpan..'));
                    redirect('pemilihan/get_calon_pemilihan/' . $id_calon . '/' . $id_pemilihan);
                } else {
                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                    redirect('pemilihan/get_calon_pemilihan/' . $id_calon . '/' . $id_pemilihan);
                }
            }
        }
    }

//---------------------------------------KIRIM PEMILIHAN---------------------------------------//

    public function kirim_pemilihan() {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('kategori_pemilihan', 'Tingkat Pemilihan', 'required');
        $this->form_validation->set_rules('nama_pemilihan', 'Nama Pemilihan', 'required');
        $this->form_validation->set_rules('tahun_pemilihan', 'Periode Pemilihan', 'required');
        $this->form_validation->set_rules('nama_calon_awal', 'Nama Calon 1', 'required');
        $this->form_validation->set_rules('nomor_urut_awal', 'Nomor Urut', 'required');

        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('pemilihan/daftar_pemilihan'); //folder, controller, method
        } else {

            $illegalChar = array(".", ",", "?", "!", ":", ";", "-", "+", "<", ">", "%", "~", "€", "$", "[", "]", "{", "}", "@", "&", "#", "*", "„", "/", "\\", "|", "'", '"', " ");

            $name_foto_pemilihan = strtolower(str_replace($illegalChar, '_', $data['kategori_pemilihan'] . '_' . $data['nama_pemilihan'] . '_' . $data['tahun_pemilihan']));

            $this->load->library('upload'); //load library upload file
            $this->load->library('image_lib'); //load library image
            //ktp
            if (!empty($_FILES['foto'])) {

                $path = 'uploads/foto_pemilihan/';
                $path_thumb = 'uploads/foto_pemilihan/thumbs/';

                //config upload file
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 2048; //set limit
                $config['overwrite'] = FALSE; //if have same name, add number
                $config['remove_spaces'] = TRUE; //change space into _
                $config['encrypt_name'] = FALSE;
                $config['file_name'] = $name_foto_pemilihan . "_foto_pemilih";
                //initialize config upload
                $this->upload->initialize($config);

                if ($this->upload->do_upload('foto')) {//if success upload data
                    $result['upload'] = $this->upload->data();
                    $name = $result['upload']['file_name'];
                    $data['foto_calon'] = $path . $name;

                    $img['image_library'] = 'gd2';
                    $img['source_image'] = $path . $name;
                    $img['new_image'] = $path_thumb . $name;
                    $img['maintain_ratio'] = true;
                    $img['width'] = 600;
                    $img['height'] = 600;
//                    var_dump($img['new_image']);
//                    exit;
                    $this->image_lib->initialize($img);
                    if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                        $data['foto_calon_thumb'] = $path_thumb . $name;
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                        redirect('pemilihan/daftar_pemilihan');
                    }
                }
            }

            if ($data['kategori_pemilihan'] == 1) {
                $nama_kat = 'PRESIDEN';
            } else if ($data['kategori_pemilihan'] == 2) {
                $nama_kat = 'DPR_RI';
            } else if ($data['kategori_pemilihan'] == 3) {
                $nama_kat = 'GUBERNUR';
            } else if ($data['kategori_pemilihan'] == 4) {
                $nama_kat = 'WALIKOTA';
            } else if ($data['kategori_pemilihan'] == 5) {
                $nama_kat = 'BUPATI';
            } else if ($data['kategori_pemilihan'] == 6) {
                $nama_kat = 'DPRD_PROVINSI';
            } else if ($data['kategori_pemilihan'] == 7) {
                $nama_kat = 'DPRD_KABUPATEN_KOTA';
            }

            $data['random_value'] = rand();
            $get_max_id = $this->Pemilihanmodel->get_max_id_pemilihan();

            if ($data['kategori_pemilihan'] == 1 || $data['kategori_pemilihan'] == 2) {

                $data['id_regional_pemilihan'] = '34';

                $name_pemilihan = strtolower(str_replace($illegalChar, '_', $data['id_regional_pemilihan'] . '_' . $nama_kat . '_' . $data['random_value']));
                $get_dir_pemilihan = $this->Pemilihanmodel->get_direktori_pemilihan_nasional();

                if (!file_exists('uploads/pemilihan/' . $name_pemilihan)) {

                    mkdir('uploads/pemilihan/' . $name_pemilihan, 0777, true);
                    $pemilihan_path = 'uploads/pemilihan/' . $name_pemilihan;
                    $data['path_pemilihan'] = $pemilihan_path;

                    foreach ($get_dir_pemilihan as $value_prov) {

                        $name_dir_region_prov = strtolower(str_replace($illegalChar, '_', $value_prov->nama . '_' . $value_prov->id));

                        if (!file_exists($pemilihan_path . '/' . $name_dir_region_prov)) {

                            $prov_path = $pemilihan_path . '/' . $name_dir_region_prov;
                            $prov_path_done = preg_replace('/\s+/', '', $prov_path);
                            mkdir($prov_path_done, 0777, true);

                            $get_dir_pemilihan_kab = $this->Pemilihanmodel->get_direktori_pemilihan_kab($value_prov->id);

                            foreach ($get_dir_pemilihan_kab as $value_kab) {

                                $name_dir_region_kab = strtolower(str_replace($illegalChar, '_', $value_kab->nama . '_' . $value_kab->id));

                                if (!file_exists($pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab)) {

                                    $kab_path = $pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab;
                                    $kab_path_done = preg_replace('/\s+/', '', $kab_path);
                                    mkdir($kab_path_done, 0777, true);

                                    $get_dir_pemilihan_kec = $this->Pemilihanmodel->get_direktori_pemilihan_kec($value_prov->id, $value_kab->id);

                                    foreach ($get_dir_pemilihan_kec as $value_kec) {

                                        $name_dir_region_kec = strtolower(str_replace($illegalChar, '_', $value_kec->nama . '_' . $value_kec->id));

                                        if (!file_exists($pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec)) {

                                            $kec_path = $pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec;
                                            $kec_path_done = preg_replace('/\s+/', '', $kec_path);
                                            mkdir($kec_path_done, 0777, true);

                                            $get_dir_pemilihan_kel = $this->Pemilihanmodel->get_direktori_pemilihan_kel($value_prov->id, $value_kab->id, $value_kec->id);

                                            foreach ($get_dir_pemilihan_kel as $value_kel) {

                                                $name_dir_region_kel = strtolower(str_replace($illegalChar, '_', $value_kel->nama . '_' . $value_kel->id));

                                                if (!file_exists($pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec . '/' . $name_dir_region_kel)) {

                                                    $kel_path = $pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec . '/' . $name_dir_region_kel;
                                                    $kel_path_done = preg_replace('/\s+/', '', $kel_path);

                                                    $status = mkdir($kel_path_done, 0777, true);

                                                    if ($status == false) {
                                                        var_dump($status . "errr:" . $pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec . '/' . $name_dir_region_kel);
                                                        exit;
                                                    }
                                                } else {
                                                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori kelurahan sudah dibuat...'));
                                                    redirect('pemilihan/daftar_pemilihan');
                                                }
                                            }
                                        } else {
                                            $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori kecamatan sudah dibuat...'));
                                            redirect('pemilihan/daftar_pemilihan');
                                        }
                                    }
                                } else {
                                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori kabupaten sudah dibuat...'));
                                    redirect('pemilihan/daftar_pemilihan');
                                }
                            }
                        } else {
                            $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori provinsi sudah dibuat...'));
                            redirect('pemilihan/daftar_pemilihan');
                        }
                    }
                }
            } else if ($data['kategori_pemilihan'] == 3 || $data['kategori_pemilihan'] == 6) {

                $data['id_regional_pemilihan'] = $data['provinsi'];

                $illegalChar = array(".", ",", "?", "!", ":", ";", "-", "+", "<", ">", "%", "~", "€", "$", "[", "]", "{", "}", "@", "&", "#", "*", "„", "/", "\\", "|", "'", '"', " ");

                $name_provinsi = $this->Pemilihanmodel->get_name_provinsi($data['provinsi']);
                $name_pemilihan = strtolower(str_replace($illegalChar, '_', $data['id_regional_pemilihan'] . '_' . $nama_kat . '_' . $name_provinsi[0]->nama . '_' . $data['random_value']));
                $get_dir_pemilihan = $this->Pemilihanmodel->get_direktori_pemilihan_provinsi($data['provinsi']);

                if (!file_exists('uploads/pemilihan/' . $name_pemilihan)) {

                    mkdir('uploads/pemilihan/' . $name_pemilihan, 0777, true);
                    $pemilihan_path = 'uploads/pemilihan/' . $name_pemilihan;
                    $data['path_pemilihan'] = $pemilihan_path;

                    foreach ($get_dir_pemilihan as $value_prov) {

                        $name_dir_region_prov = strtolower(str_replace($illegalChar, '_', $value_prov->nama . '_' . $value_prov->id));

                        if (!file_exists($pemilihan_path . '/' . $name_dir_region_prov)) {

                            $prov_path = $pemilihan_path . '/' . $name_dir_region_prov;
                            $prov_path_done = preg_replace('/\s+/', '', $prov_path);
                            mkdir($prov_path_done, 0777, true);

                            $get_dir_pemilihan_kab = $this->Pemilihanmodel->get_direktori_pemilihan_kab($value_prov->id);

                            foreach ($get_dir_pemilihan_kab as $value_kab) {

                                $name_dir_region_kab = strtolower(str_replace($illegalChar, '_', $value_kab->nama . '_' . $value_kab->id));

                                if (!file_exists($pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab)) {

                                    $kab_path = $pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab;
                                    $kab_path_done = preg_replace('/\s+/', '', $kab_path);
                                    mkdir($kab_path_done, 0777, true);

                                    $get_dir_pemilihan_kec = $this->Pemilihanmodel->get_direktori_pemilihan_kec($value_prov->id, $value_kab->id);

                                    foreach ($get_dir_pemilihan_kec as $value_kec) {

                                        $name_dir_region_kec = strtolower(str_replace($illegalChar, '_', $value_kec->nama . '_' . $value_kec->id));

                                        if (!file_exists($pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec)) {

                                            $kec_path = $pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec;
                                            $kec_path_done = preg_replace('/\s+/', '', $kec_path);
                                            mkdir($kec_path_done, 0777, true);

                                            $get_dir_pemilihan_kel = $this->Pemilihanmodel->get_direktori_pemilihan_kel($value_prov->id, $value_kab->id, $value_kec->id);

                                            foreach ($get_dir_pemilihan_kel as $value_kel) {

                                                $name_dir_region_kel = strtolower(str_replace($illegalChar, '_', $value_kel->nama . '_' . $value_kel->id));

                                                if (!file_exists($pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec . '/' . $name_dir_region_kel)) {

                                                    $kel_path = $pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec . '/' . $name_dir_region_kel;
                                                    $kel_path_done = preg_replace('/\s+/', '', $kel_path);

                                                    $status = mkdir($kel_path_done, 0777, true);

                                                    if ($status == false) {
                                                        var_dump($status . "errr:" . $pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec . '/' . $name_dir_region_kel);
                                                        exit;
                                                    }
                                                } else {
                                                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori kelurahan sudah dibuat...'));
                                                    redirect('pemilihan/daftar_pemilihan');
                                                }
                                            }
                                        } else {
                                            $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori kecamatan sudah dibuat...'));
                                            redirect('pemilihan/daftar_pemilihan');
                                        }
                                    }
                                } else {
                                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori kabupaten sudah dibuat...'));
                                    redirect('pemilihan/daftar_pemilihan');
                                }
                            }
                        } else {
                            $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori provinsi sudah dibuat...'));
                            redirect('pemilihan/daftar_pemilihan');
                        }
                    }
                }
            } else {

                $data['id_regional_pemilihan'] = $data['provinsi'] . $data['kabupaten'];

                $name_provinsi = $this->Pemilihanmodel->get_name_provinsi($data['provinsi']);
                $name_kabupaten = $this->Pemilihanmodel->get_name_kabupaten($data['provinsi'], $data['kabupaten']);
                $illegalChar = array(".", ",", "?", "!", ":", ";", "-", "+", "<", ">", "%", "~", "€", "$", "[", "]", "{", "}", "@", "&", "#", "*", "„", "/", "\\", "|", "'", '"', " ");

                $name_pemilihan = strtolower(str_replace($illegalChar, '_', $data['id_regional_pemilihan'] . '_' . $nama_kat . '_' . $name_provinsi[0]->nama . '_' . $name_kabupaten[0]->nama . '_' . $data['random_value']));
                $get_dir_pemilihan = $this->Pemilihanmodel->get_direktori_pemilihan_provinsi($data['provinsi']);

                if (!file_exists('uploads/pemilihan/' . $name_pemilihan)) {

                    mkdir('uploads/pemilihan/' . $name_pemilihan, 0777, true);
                    $pemilihan_path = 'uploads/pemilihan/' . $name_pemilihan;
                    $data['path_pemilihan'] = $pemilihan_path;

                    foreach ($get_dir_pemilihan as $value_prov) {

                        $name_dir_region_prov = strtolower(str_replace($illegalChar, '_', $value_prov->nama . '_' . $value_prov->id));

                        if (!file_exists($pemilihan_path . '/' . $name_dir_region_prov)) {

                            $prov_path = $pemilihan_path . '/' . $name_dir_region_prov;
                            $prov_path_done = preg_replace('/\s+/', '', $prov_path);
                            mkdir($prov_path_done, 0777, true);

                            $get_dir_pemilihan_kab = $this->Pemilihanmodel->get_direktori_pemilihan_kabupaten($value_prov->id, $data['kabupaten']);

                            foreach ($get_dir_pemilihan_kab as $value_kab) {

                                $name_dir_region_kab = strtolower(str_replace($illegalChar, '_', $value_kab->nama . '_' . $value_kab->id));

                                if (!file_exists($pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab)) {

                                    $kab_path = $pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab;
                                    $kab_path_done = preg_replace('/\s+/', '', $kab_path);
                                    mkdir($kab_path_done, 0777, true);

                                    $get_dir_pemilihan_kec = $this->Pemilihanmodel->get_direktori_pemilihan_kec($value_prov->id, $value_kab->id);

                                    foreach ($get_dir_pemilihan_kec as $value_kec) {

                                        $name_dir_region_kec = strtolower(str_replace($illegalChar, '_', $value_kec->nama . '_' . $value_kec->id));

                                        if (!file_exists($pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec)) {

                                            $kec_path = $pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec;
                                            $kec_path_done = preg_replace('/\s+/', '', $kec_path);
                                            mkdir($kec_path_done, 0777, true);

                                            $get_dir_pemilihan_kel = $this->Pemilihanmodel->get_direktori_pemilihan_kel($value_prov->id, $value_kab->id, $value_kec->id);

                                            foreach ($get_dir_pemilihan_kel as $value_kel) {

                                                $name_dir_region_kel = strtolower(str_replace($illegalChar, '_', $value_kel->nama . '_' . $value_kel->id));

                                                if (!file_exists($pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec . '/' . $name_dir_region_kel)) {

                                                    $kel_path = $pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec . '/' . $name_dir_region_kel;
                                                    $kel_path_done = preg_replace('/\s+/', '', $kel_path);

                                                    $status = mkdir($kel_path_done, 0777, true);

                                                    if ($status == false) {
                                                        var_dump($status . "errr:" . $pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec . '/' . $name_dir_region_kel);
                                                        exit;
                                                    }
                                                } else {
                                                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori kelurahan sudah dibuat...'));
                                                    redirect('pemilihan/daftar_pemilihan');
                                                }
                                            }
                                        } else {
                                            $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori kecamatan sudah dibuat...'));
                                            redirect('pemilihan/daftar_pemilihan');
                                        }
                                    }
                                } else {
                                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori kabupaten sudah dibuat...'));
                                    redirect('pemilihan/daftar_pemilihan');
                                }
                            }
                        } else {
                            $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori provinsi sudah dibuat...'));
                            redirect('pemilihan/daftar_pemilihan');
                        }
                    }
                }
            }

            $input_pemilihan = $this->Pemilihanmodel->insert_pemilihan($data, $this->user['id_ref']);

            if ($input_pemilihan == true) {

                $get_max_id = $this->Pemilihanmodel->get_max_id_pemilihan();

                $hasil_array = array();
                if (!empty($data['nomor_urut'])) {
                    for ($i = 0; $i < count($data['nomor_urut']); $i++) {
                        if ($data['nomor_urut'][$i] != "") {
                            $hasil_array[$i] = array(
                                'id_pemilihan' => $get_max_id[0]->id_pemilihan,
                                'nomor_urut' => $data['nomor_urut'][$i],
                                'nama_calon' => $data['nama_calon'][$i],
                                'nama_wakil_calon' => $data['nama_wakil_calon'][$i],
                                'status_calon' => 1
                            );
                        }
                    }
                }

                $input_calon = $this->db->insert_batch('calon_pemilihan', $hasil_array);

                if ($input_calon == true) {
                    $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data telah tersimpan..'));
                    redirect('pemilihan/daftar_pemilihan');
                }
            } else {

                $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                redirect('pemilihan/daftar_pemilihan');
            }
        }
    }

    public function get_tps($id_tps = '', $id_pemilihan = "", $id_wilayah_pemilihan = '') {

        $data['tps'] = $this->Pemilihanmodel->get_tps($id_tps);
        $data['nama_wilayah'] = $this->Pemilihanmodel->get_nama_wilayah($id_wilayah_pemilihan);
        $data['pemilihan'] = $this->Pemilihanmodel->get_data_id_pemilihan($id_pemilihan, $this->user['id_ref'], $this->user['role_admin']); //?
        $data['petugas_saksi'] = $this->Pemilihanmodel->get_data_petugas_saksi($id_pemilihan, $id_wilayah_pemilihan, $this->user['id_ref'], $this->user['role_admin']); //?
        $data['petugas_saksi_terpakai'] = $this->Pemilihanmodel->get_data_petugas_saksi_terpakai($id_pemilihan, $this->user['id_ref'], $this->user['role_admin']); //?

        $this->template->load('template_admin/template_admin', 'edit_tps', $data);
    }

//---------------------------------------EDIT REGIONAL---------------------------------------//

    public function edit_tps($id_tps = '', $id_pemilihan = "", $id_wilayah_pemilihan = '') {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('nama_tps', 'Nama TPS', 'required');
        $this->form_validation->set_rules('nomor_tps', 'Nomor TPS', 'required');

        if (!isset($data['id_petugas_saksi'])) {
            $data['id_petugas_saksi'] = '';
        } else {
            $data['id_petugas_saksi'] = implode(',', $data['id_petugas_saksi']);
        }

        $cek_nomor = $this->Pemilihanmodel->cek_nomor_tps($id_pemilihan, $id_wilayah_pemilihan, $data['nomor_tps']);
        $cek = $this->Pemilihanmodel->get_by_id_tps($id_tps);

        if ($cek_nomor == TRUE && $cek[0]->nomor_tps != $data['nomor_tps']) {

            $this->session->set_flashdata('flash_message', warn_msg("Maaf, Nomor TPS '$data[nomor_tps]' sudah dibuat.."));
            redirect('pemilihan/get_tps/' . $id_tps . '/' . $id_pemilihan . '/' . $id_wilayah_pemilihan);
        } else {

            if ($cek == FALSE or empty($id_tps)) {
                $data = array();
                $this->load->view('error_404', $data);
            } else {

                if ($this->form_validation->run() == FALSE) {

                    $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                    redirect('pemilihan/get_tps/' . $id_tps . '/' . $id_pemilihan . '/' . $id_wilayah_pemilihan);
                } else {

                    //var_dump($data['id_petugas_saksi']);exit;
                    $get_id_petugas = $this->Pemilihanmodel->get_by_id_tps($id_tps);

                    $id_petugas_old_array = explode(',', $get_id_petugas[0]->id_petugas_saksi);
                    $id_petugas_new_array = explode(',', $data['id_petugas_saksi']);

                    $result_diff_old = array_diff($id_petugas_old_array, $id_petugas_new_array);
                    $result_diff_old = array_values($result_diff_old);

                    $illegalChar = array(".", ",", "?", "!", ":", ";", "-", "+", "<", ">", "%", "~", "€", "$", "[", "]", "{", "}", "@", "&", "#", "*", "„", "/", "\\", "|", "'", '"', " ");

                    $wilayah = $this->Pemilihanmodel->get_nama_wilayah($id_wilayah_pemilihan);
                    $pemilihan = $this->Pemilihanmodel->get_data_id_pemilihan($id_pemilihan, $this->user['id_ref'], $this->user['role_admin']); //?

                    $name_dir_region_prov = strtolower(str_replace($illegalChar, '_', $wilayah[0]->provinsi . '_' . $wilayah[0]->id_dati1));
                    $name_dir_region_kab = strtolower(str_replace($illegalChar, '_', $wilayah[0]->kabupaten . '_' . $wilayah[0]->id_dati2));
                    $name_dir_region_kec = strtolower(str_replace($illegalChar, '_', $wilayah[0]->kecamatan . '_' . $wilayah[0]->id_dati3));
                    $name_dir_region_kel = strtolower(str_replace($illegalChar, '_', $wilayah[0]->kelurahan . '_' . $wilayah[0]->id));
                    $path_wilayah = $pemilihan[0]->path_pemilihan . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec . '/' . $name_dir_region_kel;
                    $path_wilayah_done = preg_replace('/\s+/', '', $path_wilayah);

                    $nama_tps = $data['nama_tps'] . '_' . $data['nomor_tps'];
                    $tps_path = strtolower(str_replace($illegalChar, '_', $nama_tps));
                    $tps_path_done = preg_replace('/\s+/', '', $tps_path);

                    $oldname = $cek[0]->path_tps;
                    $newname = $path_wilayah_done . '/' . $tps_path_done;

                    $status = rename($oldname, $newname);
                    $data['path_tps'] = $newname;

                    $edit_tps = $this->Pemilihanmodel->update_tps($id_tps, $data);

                    if ($edit_tps == TRUE) {

                        $pemilihan_path = $this->Pemilihanmodel->get_hasil_pemilihan($id_tps, $id_pemilihan, $id_wilayah_pemilihan);

                        if ($pemilihan_path == TRUE) {

                            $path_hasil_c1_pertama = explode('/', $pemilihan_path[0]->fotoc1_pertama);
                            $path_hasil_c1_pertama_new = $path_hasil_c1_pertama[9];

                            $path_hasil_c1_kedua = explode('/', $pemilihan_path[0]->fotoc1_kedua);
                            $path_hasil_c1_kedua_new = $path_hasil_c1_kedua[9];

                            $data['fotoc1_pertama'] = $path_wilayah_done . '/' . $tps_path_done . '/foto/' . $path_hasil_c1_pertama_new;
                            $data['fotoc1_pertama_thumb'] = $path_wilayah_done . '/' . $tps_path_done . '/foto/thumbs/' . $path_hasil_c1_pertama_new;
                            $data['fotoc1_kedua'] = $path_wilayah_done . '/' . $tps_path_done . '/foto/' . $path_hasil_c1_kedua_new;
                            $data['fotoc1_kedua_thumb'] = $path_wilayah_done . '/' . $tps_path_done . '/foto/thumbs/' . $path_hasil_c1_kedua_new;

                            $update_path_pemilihan = $this->Pemilihanmodel->update_path_pemilihan($id_tps, $id_pemilihan, $id_wilayah_pemilihan, $data);
                        }

                        $saksi_array_old = array();
                        $saksi_array_new = array();

                        if ($result_diff_old) {

                            for ($i = 0; $i < count($result_diff_old); $i++) {

                                $saksi_array_old[$i] = array(
                                    'id_saksi' => $result_diff_old[$i],
                                    'id_wilayah_pemilihan' => '',
                                    'id_tps' => ''
                                );
                            }
                            $update_saksi = $this->db->update_batch('saksi', $saksi_array_old, 'id_saksi');
                        }

                        if (!empty($id_petugas_new_array)) {

                            for ($i = 0; $i < count($id_petugas_new_array); $i++) {

                                $saksi_array_new[$i] = array(
                                    'id_saksi' => $id_petugas_new_array[$i],
                                    'id_wilayah_pemilihan' => $id_wilayah_pemilihan,
                                    'id_tps' => $id_tps
                                );
                            }
                            $update_saksi = $this->db->update_batch('saksi', $saksi_array_new, 'id_saksi');
                        }


                        $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data Telah Tersimpan..'));
                        redirect('pemilihan/get_tps/' . $id_tps . '/' . $id_pemilihan . '/' . $id_wilayah_pemilihan);
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                        redirect('pemilihan/get_tps/' . $id_tps . '/' . $id_pemilihan . '/' . $id_wilayah_pemilihan);
                    }
                }
            }
        }
    }

    //---------------------------------------EDIT HASIL PEMILIHANS---------------------------------------//
    public function edit_hasil_pemilihan($id_tps = "", $id_pemilihan = "", $id_wilayah_pemilihan = '') {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $data['fotoc1_pertama'] = $data['fotoc1_pertama_temp'];
        $data['fotoc1_pertama_thumb'] = $data['fotoc1_pertama_temp_thumb'];

        $data['fotoc1_kedua'] = $data['fotoc1_kedua_temp'];
        $data['fotoc1_kedua_thumb'] = $data['fotoc1_kedua_temp_thumb'];

        $this->form_validation->set_rules('dp_dpt_laki_laki', 'Data Pemilih Pemilih Tetap Laki-laki', 'required');
        $this->form_validation->set_rules('dp_dpt_perempuan', 'Data Pemilih Pemilih Tetap Perempuan', 'required');
        $this->form_validation->set_rules('dp_dpph_laki_laki', 'Data Pemilih Pemilih Pindahan Laki-laki', 'required');
        $this->form_validation->set_rules('dp_dpph_perempuan', 'Data Pemilih Pemilih Pindahan Perempuan', 'required');
        $this->form_validation->set_rules('dp_dptb_laki_laki', 'Data Pemilih Pemilih Tambahan Laki-laki', 'required');
        $this->form_validation->set_rules('dp_dptb_perempuan', 'Data Pemilih Pemilih Tambahan Perempuan', 'required');
        $this->form_validation->set_rules('dp_total', 'Total Data Pemilih', 'required');

        $this->form_validation->set_rules('php_dpt_laki_laki', 'Pengguna Hak Pilih Pemilih Tetap Laki-laki', 'required');
        $this->form_validation->set_rules('php_dpt_perempuan', 'Pengguna Hak Pilih Pemilih Tetap Perempuan', 'required');
        $this->form_validation->set_rules('php_dpph_laki_laki', 'Pengguna Hak Pilih Pemilih Pindahan Laki-laki', 'required');
        $this->form_validation->set_rules('php_dpph_perempuan', 'Pengguna Hak Pilih Pemilih Pindahan Perempuan', 'required');
        $this->form_validation->set_rules('php_dptb_laki_laki', 'Pengguna Hak Pilih Pemilih Tambahan Laki-laki', 'required');
        $this->form_validation->set_rules('php_dptb_perempuan', 'Pengguna Hak Pilih Pemilih Tambahan Perempuan', 'required');
        $this->form_validation->set_rules('php_total', 'Total Pengguna Hak Pilih', 'required');

        $this->form_validation->set_rules('total_suara_sah', 'Perolehan Suara Sah', 'required');
        $this->form_validation->set_rules('total_suara_tidak_sah', 'Perolehan Suara Tidak Sah', 'required');

        $this->form_validation->set_rules('suara_sah[]', 'Perolehan Suara Sah Tiap Calon', 'required');

        if (!isset($data['id_petugas_saksi'])) {
            $data['id_petugas_saksi'] = '';
        } else {
            $data['id_petugas_saksi'] = implode(',', $data['id_petugas_saksi']);
        }

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('pemilihan/get_hasil_pemilihan_suara/' . $id_tps . '/' . $id_pemilihan . '/' . $id_wilayah_pemilihan);
        } else {

            $this->load->library('upload'); //load library upload file
            $this->load->library('image_lib'); //load library image
            $illegalChar = array(".", ",", "?", "!", ":", ";", "-", "+", "<", ">", "%", "~", "€", "$", "[", "]", "{", "}", "@", "&", "#", "*", "„", "/", "\\", "|", "'", '"', " ");

            $nama_tps = $this->Pemilihanmodel->get_tps($id_tps);
            $nama_file = strtolower(str_replace($illegalChar, '_', $nama_tps[0]->nama_tps));
            $nama_file_done = preg_replace('/\s+/', '', $nama_file);

            if (!empty($_FILES['fotoc1_pertama']['tmp_name'])) {

                $this->delete_file_foto_c1_pertama($id_tps, $id_pemilihan, $id_wilayah_pemilihan);

                $path = $nama_tps[0]->path_tps . '/foto/';
                $path_thumb = $nama_tps[0]->path_tps . '/foto/thumbs/';

                //config upload file
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 2048; //set limit
                $config['overwrite'] = FALSE; //if have same name, add number
                $config['remove_spaces'] = TRUE; //change space into _
                $config['encrypt_name'] = FALSE;
                $config['file_name'] = $nama_file_done . '_fotoc1_pertama';
                //initialize config upload
                $this->upload->initialize($config);

                if ($this->upload->do_upload('fotoc1_pertama')) {//if success upload data
                    $result['upload'] = $this->upload->data();
                    $name = $result['upload']['file_name'];
                    $data['fotoc1_pertama'] = $path . $name;

                    $img['image_library'] = 'gd2';
                    $img['source_image'] = $path . $name;
                    $img['new_image'] = $path_thumb . $name;
                    $img['maintain_ratio'] = true;
                    $img['width'] = 600;
                    $img['height'] = 800;
//                    var_dump($img['new_image']);
//                    exit;
                    $this->image_lib->initialize($img);
                    if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                        $data['fotoc1_pertama_thumb'] = $path_thumb . $name;
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                        redirect('pemilihan/get_hasil_pemilihan_suara/' . $id_tps . '/' . $id_pemilihan . '/' . $id_wilayah_pemilihan);
                    }
                }
            }

            if (!empty($_FILES['fotoc1_kedua']['tmp_name'])) {

                $this->delete_file_foto_c1_kedua($id_tps, $id_pemilihan, $id_wilayah_pemilihan);

                $path = $nama_tps[0]->path_tps . '/foto/';
                $path_thumb = $nama_tps[0]->path_tps . '/foto/thumbs/';

                //config upload file
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 2048; //set limit
                $config['overwrite'] = FALSE; //if have same name, add number
                $config['remove_spaces'] = TRUE; //change space into _
                $config['encrypt_name'] = FALSE;
                $config['file_name'] = $nama_file_done . '_fotoc1_kedua';
                //initialize config upload
                $this->upload->initialize($config);

                if ($this->upload->do_upload('fotoc1_kedua')) {//if success upload data
                    $result['upload'] = $this->upload->data();
                    $name = $result['upload']['file_name'];
                    $data['fotoc1_kedua'] = $path . $name;

                    $img['image_library'] = 'gd2';
                    $img['source_image'] = $path . $name;
                    $img['new_image'] = $path_thumb . $name;
                    $img['maintain_ratio'] = true;
                    $img['width'] = 600;
                    $img['height'] = 800;
//                    var_dump($img['new_image']);
//                    exit;
                    $this->image_lib->initialize($img);
                    if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                        $data['fotoc1_kedua_thumb'] = $path_thumb . $name;
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                        redirect('pemilihan/get_hasil_pemilihan_suara/' . $id_tps . '/' . $id_pemilihan . '/' . $id_wilayah_pemilihan);
                    }
                }
            }

            $update_hasil = $this->Pemilihanmodel->update_hasil_pemilihan($data, $id_tps, $id_pemilihan, $id_wilayah_pemilihan);

            if ($update_hasil == true) {

                $get_hasil_suara = $this->Pemilihanmodel->get_hasil_suara($id_tps, $id_pemilihan, $id_wilayah_pemilihan);

                $array_suara = array();
                foreach ($get_hasil_suara as $key => $value) {
                    $array_suara[] = $value->id_calon_pemilihan;
                }

                $hasil_array_update = array();
                $hasil_array_input = array();

                $input_bool = FALSE;
                $edit_bool = FALSE;

                for ($i = 0; $i < count($data['suara_sah']); $i++) {
                    if (in_array($data['id_calon_pemilihan'][$i], $array_suara)) {

                        $hasil_array_update[$i] = array(
                            'id_suara_calon' => $data['id_suara_calon'][$i],
                            'suara_sah' => $data['suara_sah'][$i]
                        );
                        $edit_bool = TRUE;
                    } else {
                        $hasil_array_input[$i] = array(
                            'id_calon_pemilihan' => $data['id_calon_pemilihan'][$i],
                            'id_pemilihan' => $id_pemilihan,
                            'id_wilayah_pemilihan' => $id_wilayah_pemilihan,
                            'id_tps' => $id_tps,
                            'suara_sah' => $data['suara_sah'][$i]
                        );
                        $input_bool = TRUE;
                    }
                }
                if ($input_bool) {
                    $this->db->insert_batch('suara_calon', $hasil_array_input);
                }
                if ($edit_bool) {
                    $this->db->update_batch('suara_calon', $hasil_array_update, 'id_suara_calon');
                }
//                var_dump($update_suara);
//                exit;
                $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data telah tersimpan..'));
                redirect('pemilihan/get_hasil_pemilihan_suara/' . $id_tps . '/' . $id_pemilihan . '/' . $id_wilayah_pemilihan);
            } else {
                $this->session->set_flashdata('flash_message', err_msg('Maaf,Hasil Pemilihan Terjadi kesalahan...'));
                redirect('pemilihan/get_hasil_pemilihan_suara/' . $id_tps . '/' . $id_pemilihan . '/' . $id_wilayah_pemilihan);
            }
        }
    }

    public function get_pemilihan($id = '') {
        $id_reg = $this->Pemilihanmodel->get_by_id_pemilihan($id);
        $data['provinsi'] = $this->Pemilihanmodel->get_provinsi($this->user['id_ref'], $this->user['role_admin']); //?
        $data['kabupaten'] = $this->Pemilihanmodel->get_kabupaten_pemilihan(substr($id_reg[0]->id_regional_pemilihan, 0, 2), $this->user['id_ref'], $this->user['role_admin']); //?
        $data['pemilihan'] = $this->Pemilihanmodel->get_by_id_pemilihan($id, $this->user['id_ref'], $this->user['role_admin']);

        $this->template->load('template_admin/template_admin', 'edit_pemilihan', $data);
    }

    public function edit_pemilihan($id = '') {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $data['foto_calon'] = $data['foto_temp'];
        $data['foto_calon_thumb'] = $data['foto_temp_thumb'];

        $this->form_validation->set_rules('kategori_pemilihan', 'Tingkat Pemilihan', 'required');
        $this->form_validation->set_rules('nama_pemilihan', 'Nama Pemilihan', 'required');
        $this->form_validation->set_rules('tahun_pemilihan', 'Periode Pemilihan', 'required');
        $this->form_validation->set_rules('nama_calon', 'Nama Calon 1', 'required');

        if ($data['kategori_pemilihan'] == 1 || $data['kategori_pemilihan'] == 2) {
            $data['id_regional_pemilihan'] = '34';
        } else if ($data['kategori_pemilihan'] == 3 || $data['kategori_pemilihan'] == 6) {
            $data['id_regional_pemilihan'] = $data['provinsi'];
        } else {
            $data['id_regional_pemilihan'] = $data['provinsi'] . $data['kabupaten'];
        }

        $cek = $this->Pemilihanmodel->get_by_id_pemilihan($id, $this->user['id_ref'], $this->user['role_admin']);

        if ($cek == FALSE or empty($id)) {

            $this->load->view('error_404', $data);
        } else {
            if ($this->form_validation->run() == FALSE) {

                $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                redirect('pemilihan/get_pemilihan/' . $id); //folder, controller, method
            } else {

                $illegalChar = array(".", ",", "?", "!", ":", ";", "-", "+", "<", ">", "%", "~", "€", "$", "[", "]", "{", "}", "@", "&", "#", "*", "„", "/", "\\", "|", "'", '"', " ");

                $name_foto_pemilihan = strtolower(str_replace($illegalChar, '_', $data['kategori_pemilihan'] . '_' . $data['nama_pemilihan'] . '_' . $data['tahun_pemilihan']));

                $this->load->library('upload'); //load library upload file
                $this->load->library('image_lib'); //load library image
                //ktp
                if (!empty($_FILES['foto']['tmp_name'])) {

                    $data_img_pemilihan = explode('/', $cek[0]->foto_calon);
                    $name_img_pemilihan = $data_img_pemilihan[2];

                    $this->delete_file_foto_pemilihan($name_img_pemilihan);

                    $path = 'uploads/foto_pemilihan/';
                    $path_thumb = 'uploads/foto_pemilihan/thumbs/';

                    //config upload file
                    $config['upload_path'] = $path;
                    $config['allowed_types'] = 'jpg|png|jpeg|gif';
                    $config['max_size'] = 2048; //set limit
                    $config['overwrite'] = FALSE; //if have same name, add number
                    $config['remove_spaces'] = TRUE; //change space into _
                    $config['encrypt_name'] = FALSE;
                    $config['file_name'] = $name_foto_pemilihan . "_foto_pemilih";
                    //initialize config upload
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('foto')) {//if success upload data
                        $result['upload'] = $this->upload->data();
                        $name = $result['upload']['file_name'];
                        $data['foto_calon'] = $path . $name;

                        $img['image_library'] = 'gd2';
                        $img['source_image'] = $path . $name;
                        $img['new_image'] = $path_thumb . $name;
                        $img['maintain_ratio'] = true;
                        $img['width'] = 600;
                        $img['height'] = 600;
//                    var_dump($img['new_image']);
//                    exit;
                        $this->image_lib->initialize($img);
                        if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                            $data['foto_calon_thumb'] = $path_thumb . $name;
                        } else {
                            $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                            redirect('pemilihan/daftar_pemilihan');
                        }
                    }
                }

                if ($data['kategori_pemilihan'] == 1) {
                    $nama_kat = 'PRESIDEN';
                } else if ($data['kategori_pemilihan'] == 2) {
                    $nama_kat = 'DPR_RI';
                } else if ($data['kategori_pemilihan'] == 3) {
                    $nama_kat = 'GUBERNUR';
                } else if ($data['kategori_pemilihan'] == 4) {
                    $nama_kat = 'WALIKOTA';
                } else if ($data['kategori_pemilihan'] == 5) {
                    $nama_kat = 'BUPATI';
                } else if ($data['kategori_pemilihan'] == 6) {
                    $nama_kat = 'DPRD_PROVINSI';
                } else if ($data['kategori_pemilihan'] == 7) {
                    $nama_kat = 'DPRD_KABUPATEN_KOTA';
                }
                if ($data['kategori_pemilihan'] != $cek[0]->id_kategori_pemilihan || $data['id_regional_pemilihan'] != $cek[0]->id_regional_pemilihan) {

                    $path_pemilihan = $this->Pemilihanmodel->get_by_id_pemilihan($id);
                    $path = $path_pemilihan[0]->path_pemilihan;

                    $this->delete_folder_pemilihan($path);

                    if ($data['kategori_pemilihan'] == 1 || $data['kategori_pemilihan'] == 2) {

                        $illegalChar = array(".", ",", "?", "!", ":", ";", "-", "+", "<", ">", "%", "~", "€", "$", "[", "]", "{", "}", "@", "&", "#", "*", "„", "/", "\\", "|", "'", '"', " ");
                        $name_pemilihan = strtolower(str_replace($illegalChar, '_', $data['id_regional_pemilihan'] . '_' . $nama_kat . '_' . $cek[0]->random_value));
                        $get_dir_pemilihan = $this->Pemilihanmodel->get_direktori_pemilihan_nasional();

                        if (!file_exists('uploads/pemilihan/' . $name_pemilihan)) {

                            mkdir('uploads/pemilihan/' . $name_pemilihan, 0777, true);
                            $pemilihan_path = 'uploads/pemilihan/' . $name_pemilihan;
                            $data['path_pemilihan'] = $pemilihan_path;

                            foreach ($get_dir_pemilihan as $value_prov) {

                                $name_dir_region_prov = strtolower(str_replace($illegalChar, '_', $value_prov->nama . '_' . $value_prov->id));

                                if (!file_exists($pemilihan_path . '/' . $name_dir_region_prov)) {

                                    $prov_path = $pemilihan_path . '/' . $name_dir_region_prov;
                                    $prov_path_done = preg_replace('/\s+/', '', $prov_path);
                                    mkdir($prov_path_done, 0777, true);

                                    $get_dir_pemilihan_kab = $this->Pemilihanmodel->get_direktori_pemilihan_kab($value_prov->id);

                                    foreach ($get_dir_pemilihan_kab as $value_kab) {

                                        $name_dir_region_kab = strtolower(str_replace($illegalChar, '_', $value_kab->nama . '_' . $value_kab->id));

                                        if (!file_exists($pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab)) {

                                            $kab_path = $pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab;
                                            $kab_path_done = preg_replace('/\s+/', '', $kab_path);
                                            mkdir($kab_path_done, 0777, true);

                                            $get_dir_pemilihan_kec = $this->Pemilihanmodel->get_direktori_pemilihan_kec($value_prov->id, $value_kab->id);

                                            foreach ($get_dir_pemilihan_kec as $value_kec) {

                                                $name_dir_region_kec = strtolower(str_replace($illegalChar, '_', $value_kec->nama . '_' . $value_kec->id));

                                                if (!file_exists($pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec)) {

                                                    $kec_path = $pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec;
                                                    $kec_path_done = preg_replace('/\s+/', '', $kec_path);
                                                    mkdir($kec_path_done, 0777, true);

                                                    $get_dir_pemilihan_kel = $this->Pemilihanmodel->get_direktori_pemilihan_kel($value_prov->id, $value_kab->id, $value_kec->id);

                                                    foreach ($get_dir_pemilihan_kel as $value_kel) {

                                                        $name_dir_region_kel = strtolower(str_replace($illegalChar, '_', $value_kel->nama . '_' . $value_kel->id));

                                                        if (!file_exists($pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec . '/' . $name_dir_region_kel)) {

                                                            $kel_path = $pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec . '/' . $name_dir_region_kel;
                                                            $kel_path_done = preg_replace('/\s+/', '', $kel_path);

                                                            $status = mkdir($kel_path_done, 0777, true);

                                                            if ($status == false) {
                                                                var_dump($status . "errr:" . $pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec . '/' . $name_dir_region_kel);
                                                                exit;
                                                            }
                                                        } else {
                                                            $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori kelurahan sudah dibuat...'));
                                                            redirect('pemilihan/get_pemilihan/' . $id);
                                                        }
                                                    }
                                                } else {
                                                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori kecamatan sudah dibuat...'));
                                                    redirect('pemilihan/get_pemilihan/' . $id);
                                                }
                                            }
                                        } else {
                                            $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori kabupaten sudah dibuat...'));
                                            redirect('pemilihan/get_pemilihan/' . $id);
                                        }
                                    }
                                } else {
                                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori provinsi sudah dibuat...'));
                                    redirect('pemilihan/get_pemilihan/' . $id);
                                }
                            }
                        }
                    } else if ($data['kategori_pemilihan'] == 3 || $data['kategori_pemilihan'] == 6) {

                        $illegalChar = array(".", ",", "?", "!", ":", ";", "-", "+", "<", ">", "%", "~", "€", "$", "[", "]", "{", "}", "@", "&", "#", "*", "„", "/", "\\", "|", "'", '"', " ");

                        $name_provinsi = $this->Pemilihanmodel->get_name_provinsi($data['provinsi']);
                        $name_pemilihan = strtolower(str_replace($illegalChar, '_', $data['id_regional_pemilihan'] . '_' . $nama_kat . '_' . $name_provinsi[0]->nama . '_' . $cek[0]->random_value));
                        $get_dir_pemilihan = $this->Pemilihanmodel->get_direktori_pemilihan_provinsi($data['provinsi']);

                        if (!file_exists('uploads/pemilihan/' . $name_pemilihan)) {

                            mkdir('uploads/pemilihan/' . $name_pemilihan, 0777, true);
                            $pemilihan_path = 'uploads/pemilihan/' . $name_pemilihan;
                            $data['path_pemilihan'] = $pemilihan_path;

                            foreach ($get_dir_pemilihan as $value_prov) {

                                $name_dir_region_prov = strtolower(str_replace($illegalChar, '_', $value_prov->nama . '_' . $value_prov->id));

                                if (!file_exists($pemilihan_path . '/' . $name_dir_region_prov)) {

                                    $prov_path = $pemilihan_path . '/' . $name_dir_region_prov;
                                    $prov_path_done = preg_replace('/\s+/', '', $prov_path);
                                    mkdir($prov_path_done, 0777, true);

                                    $get_dir_pemilihan_kab = $this->Pemilihanmodel->get_direktori_pemilihan_kab($value_prov->id);

                                    foreach ($get_dir_pemilihan_kab as $value_kab) {

                                        $name_dir_region_kab = strtolower(str_replace($illegalChar, '_', $value_kab->nama . '_' . $value_kab->id));

                                        if (!file_exists($pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab)) {

                                            $kab_path = $pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab;
                                            $kab_path_done = preg_replace('/\s+/', '', $kab_path);
                                            mkdir($kab_path_done, 0777, true);

                                            $get_dir_pemilihan_kec = $this->Pemilihanmodel->get_direktori_pemilihan_kec($value_prov->id, $value_kab->id);

                                            foreach ($get_dir_pemilihan_kec as $value_kec) {

                                                $name_dir_region_kec = strtolower(str_replace($illegalChar, '_', $value_kec->nama . '_' . $value_kec->id));

                                                if (!file_exists($pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec)) {

                                                    $kec_path = $pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec;
                                                    $kec_path_done = preg_replace('/\s+/', '', $kec_path);
                                                    mkdir($kec_path_done, 0777, true);

                                                    $get_dir_pemilihan_kel = $this->Pemilihanmodel->get_direktori_pemilihan_kel($value_prov->id, $value_kab->id, $value_kec->id);

                                                    foreach ($get_dir_pemilihan_kel as $value_kel) {

                                                        $name_dir_region_kel = strtolower(str_replace($illegalChar, '_', $value_kel->nama . '_' . $value_kel->id));

                                                        if (!file_exists($pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec . '/' . $name_dir_region_kel)) {

                                                            $kel_path = $pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec . '/' . $name_dir_region_kel;
                                                            $kel_path_done = preg_replace('/\s+/', '', $kel_path);

                                                            $status = mkdir($kel_path_done, 0777, true);

                                                            if ($status == false) {
                                                                var_dump($status . "errr:" . $pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec . '/' . $name_dir_region_kel);
                                                                exit;
                                                            }
                                                        } else {
                                                            $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori kelurahan sudah dibuat...'));
                                                            redirect('pemilihan/get_pemilihan/' . $id);
                                                        }
                                                    }
                                                } else {
                                                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori kecamatan sudah dibuat...'));
                                                    redirect('pemilihan/get_pemilihan/' . $id);
                                                }
                                            }
                                        } else {
                                            $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori kabupaten sudah dibuat...'));
                                            redirect('pemilihan/get_pemilihan/' . $id);
                                        }
                                    }
                                } else {
                                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori provinsi sudah dibuat...'));
                                    redirect('pemilihan/get_pemilihan/' . $id);
                                }
                            }
                        }
                    } else {

                        $name_provinsi = $this->Pemilihanmodel->get_name_provinsi($data['provinsi']);
                        $name_kabupaten = $this->Pemilihanmodel->get_name_kabupaten($data['provinsi'], $data['kabupaten']);
                        $illegalChar = array(".", ",", "?", "!", ":", ";", "-", "+", "<", ">", "%", "~", "€", "$", "[", "]", "{", "}", "@", "&", "#", "*", "„", "/", "\\", "|", "'", '"', " ");

                        $name_pemilihan = strtolower(str_replace($illegalChar, '_', $data['id_regional_pemilihan'] . '_' . $nama_kat . '_' . $name_provinsi[0]->nama . '_' . $name_kabupaten[0]->nama . '_' . $cek[0]->random_values));
                        $get_dir_pemilihan = $this->Pemilihanmodel->get_direktori_pemilihan_provinsi($data['provinsi']);
                        if (!file_exists('uploads/pemilihan/' . $name_pemilihan)) {

                            mkdir('uploads/pemilihan/' . $name_pemilihan, 0777, true);
                            $pemilihan_path = 'uploads/pemilihan/' . $name_pemilihan;
                            $data['path_pemilihan'] = $pemilihan_path;

                            foreach ($get_dir_pemilihan as $value_prov) {

                                $name_dir_region_prov = strtolower(str_replace($illegalChar, '_', $value_prov->nama . '_' . $value_prov->id));

                                if (!file_exists($pemilihan_path . '/' . $name_dir_region_prov)) {

                                    $prov_path = $pemilihan_path . '/' . $name_dir_region_prov;
                                    $prov_path_done = preg_replace('/\s+/', '', $prov_path);
                                    mkdir($prov_path_done, 0777, true);

                                    $get_dir_pemilihan_kab = $this->Pemilihanmodel->get_direktori_pemilihan_kabupaten($value_prov->id, $data['kabupaten']);

                                    foreach ($get_dir_pemilihan_kab as $value_kab) {

                                        $name_dir_region_kab = strtolower(str_replace($illegalChar, '_', $value_kab->nama . '_' . $value_kab->id));

                                        if (!file_exists($pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab)) {

                                            $kab_path = $pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab;
                                            $kab_path_done = preg_replace('/\s+/', '', $kab_path);
                                            mkdir($kab_path_done, 0777, true);

                                            $get_dir_pemilihan_kec = $this->Pemilihanmodel->get_direktori_pemilihan_kec($value_prov->id, $value_kab->id);

                                            foreach ($get_dir_pemilihan_kec as $value_kec) {

                                                $name_dir_region_kec = strtolower(str_replace($illegalChar, '_', $value_kec->nama . '_' . $value_kec->id));

                                                if (!file_exists($pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec)) {

                                                    $kec_path = $pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec;
                                                    $kec_path_done = preg_replace('/\s+/', '', $kec_path);
                                                    mkdir($kec_path_done, 0777, true);

                                                    $get_dir_pemilihan_kel = $this->Pemilihanmodel->get_direktori_pemilihan_kel($value_prov->id, $value_kab->id, $value_kec->id);

                                                    foreach ($get_dir_pemilihan_kel as $value_kel) {

                                                        $name_dir_region_kel = strtolower(str_replace($illegalChar, '_', $value_kel->nama . '_' . $value_kel->id));

                                                        if (!file_exists($pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec . '/' . $name_dir_region_kel)) {

                                                            $kel_path = $pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec . '/' . $name_dir_region_kel;
                                                            $kel_path_done = preg_replace('/\s+/', '', $kel_path);

                                                            $status = mkdir($kel_path_done, 0777, true);

                                                            if ($status == false) {
                                                                var_dump($status . "errr:" . $pemilihan_path . '/' . $name_dir_region_prov . '/' . $name_dir_region_kab . '/' . $name_dir_region_kec . '/' . $name_dir_region_kel);
                                                                exit;
                                                            }
                                                        } else {
                                                            $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori kelurahan sudah dibuat...'));
                                                            redirect('pemilihan/get_pemilihan/' . $id);
                                                        }
                                                    }
                                                } else {
                                                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori kecamatan sudah dibuat...'));
                                                    redirect('pemilihan/get_pemilihan/' . $id);
                                                }
                                            }
                                        } else {
                                            $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori kabupaten sudah dibuat...'));
                                            redirect('pemilihan/get_pemilihan/' . $id);
                                        }
                                    }
                                } else {
                                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Direktori provinsi sudah dibuat...'));
                                    redirect('pemilihan/get_pemilihan/' . $id);
                                }
                            }
                        }
                    }
                } else {
                    $data['path_pemilihan'] = $cek[0]->path_pemilihan;
                }

                $update_pemilihan = $this->Pemilihanmodel->update_pemilihan($id, $data);

                if ($update_pemilihan == true) {
                    $get_min_id = $this->Pemilihanmodel->get_min_id_calon_pemilihan($id);
                    $update_calon = $this->Pemilihanmodel->update_calon_pemilihan($get_min_id[0]->id_calon_pemilihan, $data);

                    if ($update_calon == true) {
                        $this->session->set_flashdata('flash_message', succ_msg("Berhasil, Update Pemilihan '" . strtoupper($data[nama_pemilihan]) . "' telah tersimpan.."));
                        redirect('pemilihan/get_pemilihan/' . $id);
                    }
                } else {
                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                    redirect('pemilihan/get_pemilihan/' . $id);
                }
            }
        }
    }

    public function get_ajax_petugas_saksi() {
        $data = $this->Pemilihanmodel->get_petugas_saksi_ajax(); //?
        echo json_encode($data);
    }

//---------------------------------------GET AJAX ANGGOTA KTP---------------------------------------//

    public function add_ajax_anggota($id_admin = '') {

        if ($id_admin == 34) {

            $query = $this->db->query("SELECT
                                        k.*
                                    FROM
                                        ktp k
                                    JOIN saksi s ON
                                        s.id_anggota != k.id_ktp");
        } elseif (strlen($id_admin) == 2 && $id_admin != 34) {

            $query = $this->db->query("SELECT
                                            k.*
                                        FROM
                                            ktp k
                                        JOIN saksi s ON
                                            s.id_anggota != k.id_ktp
                                        WHERE
                                            k.id_admin LIKE '$id_admin%'");
        } elseif (strlen($id_admin) > 2) {

            $query = $this->db->query("SELECT
                                            k.*
                                        FROM
                                            ktp k
                                        JOIN saksi s ON
                                            s.id_anggota != k.id_ktp
                                        WHERE
                                            k.id_admin = '$id_admin'");
        }

        $data = "<option></option>";
        foreach ($query->result() as $value) {
            $data .= "<option value='" . $value->id_ktp . "'>" . strtoupper($value->nama_ktp) . " [" . $value->nik_ktp . "]" . "</option>";
        }

        echo $data;
    }

    function add_ajax_kab($id_prov) {

        if ($this->user['role_admin'] == 2) {
            $query = $this->db->get_where('wilayah_kabupaten', array('id_dati1' => $id_prov, 'id' => substr($this->user['id_ref'], 2, 2)));
        } else {
            $query = $this->db->get_where('wilayah_kabupaten', array('id_dati1' => $id_prov));
        }

        $data = "<option></option>";
        foreach ($query->result() as $value) {
            $data .= "<option value='" . $value->id . "'>" . $value->nama . " [" . strtoupper($value->administratif) . "]" . "</option>";
        }
        echo $data;
    }

//---------------------------------------DELETE---------------------------------------//

    public function delete_pemilihan() {

        $id = $this->input->post('id');
        $path_pemilihan = $this->Pemilihanmodel->get_by_id_pemilihan($id);
        $path_folder = $path_pemilihan[0]->path_pemilihan;
        $path_foto = $path_pemilihan[0]->foto_calon;

        $data_img_pemilihan = explode('/', $path_foto);
        $name_img_pemilihan = $data_img_pemilihan[2];

        $delete_pemilihan = $this->Pemilihanmodel->delete_pemilihan($id, $this->user['id_ref'], $this->user['role_admin']);

        if ($delete_pemilihan == true) {
            $this->delete_folder_pemilihan($path_folder);
            $this->delete_file_foto_pemilihan($name_img_pemilihan);
            echo '1|' . succ_msg('Berhasil, Data Telah Terhapus..');
        } else {
            echo '0|' . err_msg('Maaf, Terjadi kesalahan, Coba lagi....');
        }
    }

    public function delete_tps() {

        $id = $this->input->post('id');
        $path_tps = $this->Pemilihanmodel->get_by_id_tps($id);
        $path_folder = $path_tps[0]->path_tps;
        $id_petugas_saksi = $path_tps[0]->id_petugas_saksi;

        $delete = $this->Pemilihanmodel->delete_tps($id);
        $ubah_status = $this->Pemilihanmodel->ubah_status_petugas($id_petugas_saksi);

        if ($delete == true && $ubah_status = true) {
            $this->delete_folder_tps($path_folder);

            echo '1|' . succ_msg('Berhasil, Data Telah Terhapus..');
        } else {
            echo '0|' . err_msg('Maaf, Terjadi kesalahan, Coba lagi....');
        }
    }

    public function delete_calon_pemilihan() {

        $id = $this->input->post('id');
        $delete = $this->Pemilihanmodel->delete_calon_pemilihan($id, $this->user['id_ref'], $this->user['role_admin']);

        if ($delete == true) {
            echo '1|' . succ_msg('Berhasil, Data Telah Terhapus..');
        } else {
            echo '0|' . err_msg('Maaf, Terjadi kesalahan, Coba lagi....');
        }
    }

    public function delete_petugas_saksi() {

        $id = $this->input->post('id');
        $delete = $this->Pemilihanmodel->delete_petugas_saksi($id, $this->user['id_ref'], $this->user['role_admin']);

        if ($delete == true) {
            echo '1|' . succ_msg('Berhasil, Data Telah Terhapus..');
        } else {
            echo '0|' . err_msg('Maaf, Terjadi kesalahan, Coba lagi....');
        }
    }

    public function delete_folder_pemilihan($path = '') {
        $this->load->helper("file"); // load the helper    
        delete_files($path, true); // delete all files/folders
        rmdir($path);
    }

    public function delete_folder_tps($path = '') {
        $this->load->helper("file"); // load the helper    
        delete_files($path, true); // delete all files/folders
        rmdir($path);
    }

    public function delete_file_foto_pemilihan($name_img = '') {

        $path = 'uploads/foto_pemilihan/';
        $path_thumb = 'uploads/foto_pemilihan/thumbs/';

        @unlink($path . $name_img);
        @unlink($path_thumb . $name_img);
    }

    public function delete_file_foto_c1_pertama($id_tps = '', $id_pemilihan = '', $id_wilayah_pemilihan = '') {

        $data = $this->Pemilihanmodel->get_hasil_pemilihan($id_tps, $id_pemilihan, $id_wilayah_pemilihan);

        $path = $data[0]->fotoc1_pertama;
        $path_thumb = $data[0]->fotoc1_pertama_thumb;

        @unlink($path);
        @unlink($path_thumb);
    }

    public function delete_file_foto_c1_kedua($id_tps = '', $id_pemilihan = '', $id_wilayah_pemilihan = '') {
        $data = $this->Pemilihanmodel->get_hasil_pemilihan($id_tps, $id_pemilihan, $id_wilayah_pemilihan);

        $path = $data[0]->fotoc1_kedua;
        $path_thumb = $data[0]->fotoc1_kedua_thumb;

        @unlink($path);
        @unlink($path_thumb);
    }

}
