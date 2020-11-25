<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Formatcetak extends MX_Controller {

    public function __construct() {
        parent::__construct();
        //Do your magic here 
        $this->load->model('Formatcetakmodel');
        if ($this->session->userdata('ktpapps') == FALSE) {
            redirect('auth');
        }
        $this->user = $this->session->userdata("ktpapps");
    }

    //---------------------------------------DAFTAR DATA--------------------------------------------------//

    public function daftar_data_anggota() {

        $data['count'] = $this->Formatcetakmodel->get_count_anggota($this->user['id_ref'], $this->user['role_admin']);
        $data['label'] = $this->Formatcetakmodel->get_label_pencarian($this->user['id_ref'], $this->user['role_admin']); //?
        $data['kec'] = $this->Formatcetakmodel->get_kecamatan(); //?
        $data['kel'] = $this->Formatcetakmodel->get_kelurahan(); //?
        $data['prov'] = $this->Formatcetakmodel->get_provinsi(); //?
        $data['kab'] = $this->Formatcetakmodel->get_kabupaten(); //?
        $this->template->load('template_admin/template_admin', 'daftar_anggota', $data);
    }

    //---------------------------------------DAFTAR FORMAT CETAK--------------------------------------------------//

    public function daftar_format_pencarian() {

        $data['count'] = $this->Formatcetakmodel->get_count_anggota($this->user['id_ref'], $this->user['role_admin']);
        $data['kec'] = $this->Formatcetakmodel->get_kecamatan($this->user['id_ref'], $this->user['role_admin']); //?
        $data['prov'] = $this->Formatcetakmodel->get_provinsi($this->user['id_ref'], $this->user['role_admin']); //?
        $data['kab'] = $this->Formatcetakmodel->get_kabupaten($this->user['id_ref'], $this->user['role_admin']); //?

        $this->template->load('template_admin/template_admin', 'daftar_format_pencarian', $data);
    }

//---------------------------------------GET PETUGAS---------------------------------------//
    public function get_format($id = '') {

        $data['label'] = $this->Formatcetakmodel->get_by_id_format($id, $this->user['id_ref'], $this->user['role_admin']); //?
        $data['kec'] = $this->Formatcetakmodel->get_kecamatan($this->user['id_ref'], $this->user['role_admin']); //?
        $data['prov'] = $this->Formatcetakmodel->get_provinsi($this->user['id_ref'], $this->user['role_admin']); //?
        $data['kab'] = $this->Formatcetakmodel->get_kabupaten($this->user['id_ref'], $this->user['role_admin']); //?

        $arr_dati = explode(",", $data['label'][0]->kecamatan);

        $dati2 = [];
        foreach ($arr_dati as $value) {
            $dati2[] = substr($value, 2, 2);
        }
        $string_dati2 = implode(',', $dati2);

        if ($string_dati2 != "" or $string_dati2 != null) {
            $data['get_kec'] = $this->Formatcetakmodel->get_kecamatan_concat($data['label'][0]->provinsi, $string_dati2); //?
        } else {
            $data['get_kec'] = $this->Formatcetakmodel->get_kecamatan_concat($data['label'][0]->provinsi, 0); //
        }

        $get_except_reg = $this->Formatcetakmodel->get_format_by_kat_edit($id, $data['label'][0]->kategori_dapil);
        if ($get_except_reg) {
            $kab_id = [];
            foreach ($get_except_reg as $value) {
                $kab_id [] = $value->kabupaten;
                $string_id_kab = implode(',', $kab_id);
            }
        } else {
            $string_id_kab = 0;
        }

        $data['get_kab'] = $this->Formatcetakmodel->get_ajax_kabupaten_edit($data['label'][0]->provinsi, $string_id_kab, $this->user['id_ref'], $this->user['role_admin']);

        $cek = $this->Formatcetakmodel->get_by_id_format($id);
        if ($cek == FALSE or empty($id)) {
            $data = array();
            $this->load->view('error_404', $data);
        } else {
            //edit data with id
            $this->template->load('template_admin/template_admin', 'edit_format_pencarian', $data);
        }
    }

    public function get_ajax_kab() {
        $data = $this->Formatcetakmodel->get_kab_ajax_concat(); //?
        echo json_encode($data);
    }

    public function get_ajax_kec() {
        $data = $this->Formatcetakmodel->get_kec_ajax_concat(); //?
        echo json_encode($data);
    }

    public function kirim_format() {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('kategori_dapil', 'Tingkat Kategori', 'required');
        $this->form_validation->set_rules('nama_alias', 'Nama Label', 'required');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'required');
        $this->form_validation->set_rules('kabupaten[]', 'Kabupaten', 'required');

        if (!isset($data['kecamatan'])) {
            $data['kecamatan'] = '';
        } else {
            $data['kecamatan'] = implode(',', $data['kecamatan']);
        }

        $data['kabupaten'] = implode(',', $data['kabupaten']);

        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('format/formatcetak/daftar_format_pencarian'); //folder, controller, method
        } else {

            $input = $this->Formatcetakmodel->insert_format($data, $this->user['id_ref']);
            if ($input == true) {

                $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data telah tersimpan..'));
                redirect('format/formatcetak/daftar_format_pencarian');
            } else {

                $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                redirect('format/formatcetak/daftar_format_pencarian');
            }
        }
    }

    public function edit_format($id = '') {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('kategori_dapil', 'Tingkat Kategori', 'required');
        $this->form_validation->set_rules('nama_alias', 'Nama Label', 'required');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'required');

        $data['kabupaten'] = implode(',', $data['kabupaten']);
        $data['kecamatan'] = implode(',', $data['kecamatan']);

        $cek = $this->Formatcetakmodel->get_by_id_format($id);

        if ($cek == FALSE or empty($id)) {

            $this->load->view('error_404', $data);
        } else {
            if ($this->form_validation->run() == FALSE) {

                $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
                redirect('format/formatcetak/get_format/' . $id); //folder, controller, method
            } else {

                $update = $this->Formatcetakmodel->update_format($id, $data);

                if ($update == true) {
                    $this->session->set_flashdata('flash_message', succ_msg("Berhasil, Update Format Pencarian '" . strtoupper($data[nama_alias]) . "' telah tersimpan.."));
                    redirect('format/formatcetak/get_format/' . $id);
                } else {
                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                    redirect('format/formatcetak/get_format/' . $id);
                }
            }
        }
    }

    public function delete_format() {

        $id = $this->input->post('id');
        $delete = $this->Formatcetakmodel->delete_format($id);

        if ($delete == true) {

            echo '1|' . succ_msg('Berhasil, Data Telah Terhapus..');
        } else {
            echo '0|' . err_msg('Maaf, Terjadi kesalahan, Coba lagi....');
        }
    }

//---------------------------------------GET AJAX ANGGOTA KTP---------------------------------------//


    public function get_ajax_label($id_label) {

        $get_label = $this->Formatcetakmodel->get_by_id_format($id_label);
        $get_prov = $this->Formatcetakmodel->get_nama_prov($get_label[0]->provinsi);
        $get_kab = $this->Formatcetakmodel->get_nama_kab($get_label[0]->kabupaten);

        $data = "";

        foreach ($get_prov as $value) {
            $data .= "<span class='label label-success m-l-5'><b>" . strtoupper($value->nama) . "</b></span>";
        }

        foreach ($get_kab as $value) {
            $data .= "<span class='label label-info m-l-5'><b>" . strtoupper($value->nama) . ' ' . strtoupper($value->administratif) . "</b></span>";
        }

        if ($get_label[0]->kecamatan != NULL or $get_label[0]->kecamatan != "") {

            $get_kec = $this->Formatcetakmodel->get_nama_kec($get_label[0]->kecamatan);
            foreach ($get_kec as $value) {
                $data .= "<span class='label label-warning m-l-5'><b>" . strtoupper($value->nama) . "</b></span>";
            }
        }

        echo $data;
    }

    public function add_ajax_kab_edit($id_prov, $id_admin = '') {

        if (!empty($this->user['id_ref']) && ($this->user['role_admin'] == 2)) {

            $query = $this->db->get_where('wilayah_kabupaten', array('id_dati1' => $id_prov, 'id' => substr($this->user['id_ref'], 2, 2)));
        } elseif (!empty($this->user['id_ref']) && ($this->user['role_admin'] == 1)) {

            if (!empty(substr($id_admin, 2, 2)) or substr($id_admin, 2, 2) != NULL) {

                $query = $this->db->get_where('wilayah_kabupaten', array('id_dati1' => $id_prov, 'id' => substr($id_admin, 2, 2)));
            } else {
                $query = $this->db->get_where('wilayah_kabupaten', array('id_dati1' => $id_prov));
            }
        } elseif ($this->user['role_admin'] == 0) {

            $query = $this->db->get_where('wilayah_kabupaten', array('id_dati1' => $id_prov));
        }
        $data = "<option></option>";
        foreach ($query->result() as $value) {
            $data .= "<option value='" . $value->id_dati1 . "" . $value->id . "'>" . $value->nama . " [" . strtoupper($value->administratif) . "]" . "</option>";
        }
        echo $data;
    }

    public function add_ajax_kab() {
        $id_prov = $this->input->post('id_prov');
        $id_kat = $this->input->post('id_kat');

        $get_except_reg = $this->Formatcetakmodel->get_format_by_kat($id_kat);

        if ($get_except_reg) {

            $kab_id = [];
            foreach ($get_except_reg as $value) {
                $kab_id [] = $value->kabupaten;
            }
            $string_id_kab = implode(',', $kab_id);
        } else {
            $string_id_kab = 0;
        }

        $query = $this->Formatcetakmodel->get_ajax_kabupaten($id_prov, $string_id_kab, $this->user['id_ref'], $this->user['role_admin']);

        $data = "";
        foreach ($query as $value) {
            $data .= "<option value='" . $value->id_dati1 . "" . $value->id . "'>" . $value->nama . " [" . strtoupper($value->administratif) . "]" . "</option>";
        }
        echo $data;
    }

    public function add_ajax_kec() {
        $id_prov = $this->input->post('id_prov');
        $id_kab = $this->input->post('id_kab');
        $id_kat = $this->input->post('id_kat');

        $get_except_reg = $this->Formatcetakmodel->get_format_by_kat($id_kat);

        $id = [];
        foreach ($id_kab as $value) {
            $id[] = substr($value, 2, 2);
        }
        $string_kab = implode(',', $id);

        if ($get_except_reg) {
            $kec_id = [];
            foreach ($get_except_reg as $value) {
                $kec_id [] = $value->kecamatan;
            }
            $string_id_kec = implode(',', $kec_id);
        } else {
            $string_id_kec = 0;
        }

        $query = $this->Formatcetakmodel->get_ajax_kecamatan($id_prov, $string_kab, $string_id_kec);

        $data = "";
        foreach ($query as $value) {
            $data .= "<option value='" . $value->id_dati1 . "" . $value->id_dati2 . "" . $value->id . "'>" . $value->nama . "</option>";
        }
        echo $data;
    }

}
