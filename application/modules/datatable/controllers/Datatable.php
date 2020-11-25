<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Datatable extends MX_Controller {

    public function __construct() {
        parent::__construct();
        //Do your magic here 
        if ($this->session->userdata('ktpapps') == FALSE) {
            redirect('auth');
        }
        $this->load->model('Datatablemodel');
        $this->load->library('datatables');
        $this->user = $this->session->userdata("ktpapps");
    }

    //-----------------------------------------------KTP--------------------------------------------------//

    public function ktp_json() {

        if (!empty($this->user['id_ref']) && ($this->user['role_admin'] == 2)) {
            $this->datatables->select("p.id_ktp,
                                    p.nik_kta_baru,
                                    p.id_asal,
                                    p.id_admin,
                                    p.id_petugas,
                                    wpasl.nama AS provinsi_asal,                                   
                                    CONCAT(UCASE(wkbasl.nama),' ', UCASE(wkbasl.administratif)) AS kabupaten_asal,
                                    wkasl.nama AS kecamatan_asal,
                                    wdasl.nama AS kelurahan_asal,
                                    wpagt.nama AS provinsi_anggota,                                    
                                    CONCAT(UCASE(wkbagt.nama),' ', UCASE(wkbagt.administratif)) AS kabupaten_anggota,
                                    pt.nama_petugas,
                                    p.nik_ktp,
                                    UCASE(p.nama_ktp) AS nama_ktp,
                                    CONCAT(UCASE(p.tempat_lahir),', ',p.tanggal_lahir) AS tmp_tgl_lahir,                                    
                                    IF(p.jenis_kelamin='1','LAKI-LAKI', 'PEREMPUAN') AS jenis_kelamin,
                                    p.gol_darah,
                                    p.alamat_ktp,
                                    p.agama,
                                    p.status_nikah,
                                    p.pekerjaan,
                                    p.nomor_hp_ktp,
                                    p.img,
                                    p.img_thumb,
                                    p.status_data,
                                    p.status_mutasi,
                                    p.tanggal_post");
            $this->datatables->from('ktp p');
            $this->datatables->join('wilayah_kabupaten wkbagt', 'SUBSTR(p.id_admin, 3, 2) = wkbagt.id AND SUBSTR(p.id_admin, 1, 2) = wkbagt.id_dati1', 'left');
            $this->datatables->join('wilayah_provinsi wpagt', 'SUBSTR(p.id_admin, 1, 2) = wpagt.id', 'left');
            $this->datatables->join('wilayah_desa wdasl', 'SUBSTR(p.id_asal, 7, 2) = wdasl.id AND SUBSTR(p.id_asal, 1, 2) = wdasl.id_dati1 AND SUBSTR(p.id_asal, 3, 2) = wdasl.id_dati2 AND SUBSTR(p.id_asal, 5, 2) = wdasl.id_dati3', 'left');
            $this->datatables->join('wilayah_kecamatan wkasl', 'SUBSTR(p.id_asal, 5, 2) = wkasl.id AND SUBSTR(p.id_asal, 1, 2) = wkasl.id_dati1 AND SUBSTR(p.id_asal, 3, 2) = wkasl.id_dati2', 'left');
            $this->datatables->join('wilayah_kabupaten wkbasl', 'SUBSTR(p.id_asal, 3, 2) = wkbasl.id AND SUBSTR(p.id_asal, 1, 2) = wkbasl.id_dati1', 'left');
            $this->datatables->join('wilayah_provinsi wpasl', 'SUBSTR(p.id_asal, 1, 2) = wpasl.id', 'left');
            $this->datatables->join('petugas pt', "p.id_petugas = pt.id_petugas AND p.id_admin = '" . $this->user['id_ref'] . "' AND p.status_data = 1 AND pt.status_data = 1 AND pt.id_admin = '" . $this->user['id_ref'] . "'", 'left');
            $this->datatables->where('p.id_admin', $this->user['id_ref']);
            $this->datatables->where('p.status_data', '1');
            $this->datatables->order_by('p.tanggal_post DESC');

            $this->datatables->add_column('view_ktp', '<a href="' . site_url('ktp/detail_ktp/') . '$1"data-toggle="tooltip" data-original-title="Lihat Detail KTP"><span class="label label-warning"><b>$2</b></span></a>', 'id_ktp, nik_ktp');
            $this->datatables->add_column('view_kta', '<span class="label label-info"><b>$1</b></span>', 'nik_kta_baru');
            $this->datatables->add_column('view_button', $this->button_ktp($this->user), 'id_ktp, status_mutasi, nama_ktp');
        } elseif (!empty($this->user['id_ref']) && ($this->user['role_admin'] == 1)) {

            $this->datatables->select("p.id_ktp,
                                    p.nik_kta_baru,
                                    p.id_asal,
                                    p.id_admin,
                                    p.id_petugas,
                                    wpasl.nama AS provinsi_asal,                                    
                                    CONCAT(UCASE(wkbasl.nama),' ', UCASE(wkbasl.administratif)) AS kabupaten_asal,
                                    wkasl.nama AS kecamatan_asal,
                                    wdasl.nama AS kelurahan_asal,
                                    wpagt.nama AS provinsi_anggota,
                                   CONCAT(UCASE(wkbagt.nama),' ', UCASE(wkbagt.administratif)) AS kabupaten_anggota,
                                    pt.nama_petugas,
                                    p.nik_ktp,
                                    p.nama_ktp,
                                    UCASE(p.nama_ktp) AS nama_ktp,
                                    CONCAT(UCASE(p.tempat_lahir),', ',p.tanggal_lahir) AS tmp_tgl_lahir,                                
                                    IF(p.jenis_kelamin='1','LAKI-LAKI', 'PEREMPUAN') AS jenis_kelamin,
                                    p.gol_darah,
                                    p.alamat_ktp,
                                    p.agama,
                                    p.status_nikah,
                                    p.pekerjaan,
                                    p.nomor_hp_ktp,
                                    p.img,
                                    p.img_thumb,
                                    p.status_data,
                                    p.status_mutasi,
                                    p.tanggal_post");
            $this->datatables->from('ktp p');
            $this->datatables->join('wilayah_kabupaten wkbagt', 'SUBSTR(p.id_admin, 3, 2) = wkbagt.id AND SUBSTR(p.id_admin, 1, 2) = wkbagt.id_dati1', 'left');
            $this->datatables->join('wilayah_provinsi wpagt', 'SUBSTR(p.id_admin, 1, 2) = wpagt.id', 'left');
            $this->datatables->join('wilayah_desa wdasl', 'SUBSTR(p.id_asal, 7, 2) = wdasl.id AND SUBSTR(p.id_asal, 1, 2) = wdasl.id_dati1 AND SUBSTR(p.id_asal, 3, 2) = wdasl.id_dati2 AND SUBSTR(p.id_asal, 5, 2) = wdasl.id_dati3', 'left');
            $this->datatables->join('wilayah_kecamatan wkasl', 'SUBSTR(p.id_asal, 5, 2) = wkasl.id AND SUBSTR(p.id_asal, 1, 2) = wkasl.id_dati1 AND SUBSTR(p.id_asal, 3, 2) = wkasl.id_dati2', 'left');
            $this->datatables->join('wilayah_kabupaten wkbasl', 'SUBSTR(p.id_asal, 3, 2) = wkbasl.id AND SUBSTR(p.id_asal, 1, 2) = wkbasl.id_dati1', 'left');
            $this->datatables->join('wilayah_provinsi wpasl', 'SUBSTR(p.id_asal, 1, 2) = wpasl.id', 'left');
            $this->datatables->join('petugas pt', "p.id_petugas = pt.id_petugas AND p.id_admin LIKE '" . $this->user['id_ref'] . "%' AND p.status_data = 1 AND pt.status_data = 1 AND pt.id_admin LIKE '" . $this->user['id_ref'] . "%'", 'left');
            $this->datatables->like('p.id_admin', $this->user['id_ref'], 'after');
            $this->datatables->where('p.status_data', '1');
            $this->datatables->order_by('p.tanggal_post DESC');

            $this->datatables->add_column('view_ktp', '<a href="' . site_url('ktp/detail_ktp/') . '$1"data-toggle="tooltip" data-original-title="Lihat Detail KTP"><span class="label label-warning"><b>$2</b></span></a>', 'id_ktp, nik_ktp');
            $this->datatables->add_column('view_kta', '<span class="label label-info"><b>$1</b></span>', 'nik_kta_baru');
            $this->datatables->add_column('view_button', $this->button_ktp($this->user), 'id_ktp, status_mutasi, nama_ktp');
        } elseif ($this->user['role_admin'] == 0) {

            $this->datatables->select("p.id_ktp,
                                    p.nik_kta_baru,
                                    p.id_asal,
                                    p.id_admin,
                                    p.id_petugas,
                                    wpasl.nama AS provinsi_asal,
                                    CONCAT(UCASE(wkbasl.nama),' ', UCASE(wkbasl.administratif)) AS kabupaten_asal,
                                    wkasl.nama AS kecamatan_asal,
                                    wdasl.nama AS kelurahan_asal,
                                    wpagt.nama AS provinsi_anggota,                                   
                                    CONCAT(UCASE(wkbagt.nama),' ', UCASE(wkbagt.administratif)) AS kabupaten_anggota,
                                    pt.nama_petugas,
                                    p.nik_ktp,
                                    p.nama_ktp,
                                    UCASE(p.nama_ktp) AS nama_ktp,
                                    CONCAT(UCASE(p.tempat_lahir),', ',p.tanggal_lahir) AS tmp_tgl_lahir, 
                                    IF(p.jenis_kelamin='1','LAKI-LAKI', 'PEREMPUAN') AS jenis_kelamin,
                                    p.gol_darah,
                                    p.alamat_ktp,
                                    p.agama,
                                    p.status_nikah,
                                    p.pekerjaan,
                                    p.nomor_hp_ktp,
                                    p.img,
                                    p.img_thumb,
                                    p.status_data,
                                    p.status_mutasi,
                                    p.tanggal_post");
            $this->datatables->from('ktp p');
            $this->datatables->join('wilayah_kabupaten wkbagt', 'SUBSTR(p.id_admin, 3, 2) = wkbagt.id AND SUBSTR(p.id_admin, 1, 2) = wkbagt.id_dati1', 'left');
            $this->datatables->join('wilayah_provinsi wpagt', 'SUBSTR(p.id_admin, 1, 2) = wpagt.id', 'left');
            $this->datatables->join('wilayah_desa wdasl', 'SUBSTR(p.id_asal, 7, 2) = wdasl.id AND SUBSTR(p.id_asal, 1, 2) = wdasl.id_dati1 AND SUBSTR(p.id_asal, 3, 2) = wdasl.id_dati2 AND SUBSTR(p.id_asal, 5, 2) = wdasl.id_dati3', 'left');
            $this->datatables->join('wilayah_kecamatan wkasl', 'SUBSTR(p.id_asal, 5, 2) = wkasl.id AND SUBSTR(p.id_asal, 1, 2) = wkasl.id_dati1 AND SUBSTR(p.id_asal, 3, 2) = wkasl.id_dati2', 'left');
            $this->datatables->join('wilayah_kabupaten wkbasl', 'SUBSTR(p.id_asal, 3, 2) = wkbasl.id AND SUBSTR(p.id_asal, 1, 2) = wkbasl.id_dati1', 'left');
            $this->datatables->join('wilayah_provinsi wpasl', 'SUBSTR(p.id_asal, 1, 2) = wpasl.id', 'left');
            $this->datatables->join('petugas pt', "p.id_petugas = pt.id_petugas", 'left');
            $this->datatables->where('p.status_data', '1');
            $this->datatables->order_by('p.tanggal_post DESC');

            $this->datatables->add_column('view_ktp', '<a href="' . site_url('ktp/detail_ktp/') . '$1"data-toggle="tooltip" data-original-title="Lihat Detail KTP"><span class="label label-warning"><b>$2</b></span></a>', 'id_ktp, nik_ktp');
            $this->datatables->add_column('view_kta', '<span class="label label-info"><b>$1</b></span>', 'nik_kta_baru');
            $this->datatables->add_column('view_button', $this->button_ktp($this->user), 'id_ktp, status_mutasi, nama_ktp');
        }
        return print_r($this->datatables->generate());
    }

    public function ktp_reg_json($id_admin = '') {

        $this->datatables->select("p.id_ktp,
                                    p.nik_kta_baru,
                                    p.id_asal,
                                    p.id_admin,
                                    p.id_petugas,
                                    wpasl.nama AS provinsi_asal,                                    
                                    CONCAT(UCASE(wkbasl.nama),' ', UCASE(wkbasl.administratif)) AS kabupaten_asal,
                                    wkasl.nama AS kecamatan_asal,
                                    wdasl.nama AS kelurahan_asal,
                                    wpagt.nama AS provinsi_anggota,
                                    CONCAT(UCASE(wkbagt.nama),' ', UCASE(wkbagt.administratif)) AS kabupaten_anggota,
                                    pt.nama_petugas,
                                    p.nik_ktp,
                                    UCASE(p.nama_ktp) AS nama_ktp,
                                    CONCAT(UCASE(p.tempat_lahir),', ',p.tanggal_lahir) AS tmp_tgl_lahir,                                    
                                    IF(p.jenis_kelamin='1','LAKI-LAKI', 'PEREMPUAN') AS jenis_kelamin,
                                    p.gol_darah,
                                    p.alamat_ktp,
                                    p.agama,
                                    p.status_nikah,
                                    p.pekerjaan,
                                    p.nomor_hp_ktp,
                                    p.img,
                                    p.img_thumb,
                                    p.status_data,
                                    p.status_mutasi,
                                    p.tanggal_post");
        $this->datatables->from('ktp p');
        $this->datatables->join('wilayah_kabupaten wkbagt', 'SUBSTR(p.id_admin, 3, 2) = wkbagt.id AND SUBSTR(p.id_admin, 1, 2) = wkbagt.id_dati1', 'left');
        $this->datatables->join('wilayah_provinsi wpagt', 'SUBSTR(p.id_admin, 1, 2) = wpagt.id', 'left');
        $this->datatables->join('wilayah_desa wdasl', 'SUBSTR(p.id_asal, 7, 2) = wdasl.id AND SUBSTR(p.id_asal, 1, 2) = wdasl.id_dati1 AND SUBSTR(p.id_asal, 3, 2) = wdasl.id_dati2 AND SUBSTR(p.id_asal, 5, 2) = wdasl.id_dati3', 'left');
        $this->datatables->join('wilayah_kecamatan wkasl', 'SUBSTR(p.id_asal, 5, 2) = wkasl.id AND SUBSTR(p.id_asal, 1, 2) = wkasl.id_dati1 AND SUBSTR(p.id_asal, 3, 2) = wkasl.id_dati2', 'left');
        $this->datatables->join('wilayah_kabupaten wkbasl', 'SUBSTR(p.id_asal, 3, 2) = wkbasl.id AND SUBSTR(p.id_asal, 1, 2) = wkbasl.id_dati1', 'left');
        $this->datatables->join('wilayah_provinsi wpasl', 'SUBSTR(p.id_asal, 1, 2) = wpasl.id', 'left');
        $this->datatables->join('petugas pt', "p.id_petugas = pt.id_petugas AND pt.status_data = 1 AND pt.id_admin = '" . $this->user['id_ref'] . "'", 'left');
        $this->datatables->where('p.id_admin', $id_admin);
        $this->datatables->where('p.status_data', '1');
        $this->datatables->order_by('p.tanggal_post DESC');

        $this->datatables->add_column('view_ktp', '<a href="' . site_url('ktp/detail_ktp/') . '$1"data-toggle="tooltip" data-original-title="Lihat Detail KTP"><span class="label label-warning"><b>$2</b></span></a>', 'id_ktp, nik_ktp');
        $this->datatables->add_column('view_kta', '<span class="label label-info"><b>$1</b></span>', 'nik_kta_baru');
        $this->datatables->add_column('view_button', $this->button_reg_ktp($this->user), 'id_ktp, status_mutasi, nama_ktp');

        return print_r($this->datatables->generate());
    }

    public function ktp_pet_json($id_pet = '') {

        $this->datatables->select("p.id_ktp,
                                    p.nik_kta_baru,
                                    p.id_asal,
                                    p.id_admin,
                                    p.id_petugas,
                                    wpasl.nama AS provinsi_asal,
                                    CONCAT(UCASE(wkbasl.nama),' ', UCASE(wkbasl.administratif)) AS kabupaten_asal,
                                    wkasl.nama AS kecamatan_asal,
                                    wdasl.nama AS kelurahan_asal,
                                    wpagt.nama AS provinsi_anggota,                                   
                                    CONCAT(UCASE(wkbagt.nama),' ', UCASE(wkbagt.administratif)) AS kabupaten_anggota,
                                    pt.nama_petugas,
                                    p.nik_ktp,
                                    UCASE(p.nama_ktp) AS nama_ktp,
                                    CONCAT(UCASE(p.tempat_lahir),', ',p.tanggal_lahir) AS tmp_tgl_lahir,                                    
                                    IF(p.jenis_kelamin='1','LAKI-LAKI', 'PEREMPUAN') AS jenis_kelamin,
                                    p.gol_darah,
                                    p.alamat_ktp,
                                    p.agama,
                                    p.status_nikah,
                                    p.pekerjaan,
                                    p.nomor_hp_ktp,
                                    p.img,
                                    p.img_thumb,
                                    p.status_data,
                                    p.status_mutasi,
                                    p.tanggal_post");
        $this->datatables->from('ktp p');
        $this->datatables->join('wilayah_kabupaten wkbagt', 'SUBSTR(p.id_admin, 3, 2) = wkbagt.id AND SUBSTR(p.id_admin, 1, 2) = wkbagt.id_dati1', 'left');
        $this->datatables->join('wilayah_provinsi wpagt', 'SUBSTR(p.id_admin, 1, 2) = wpagt.id', 'left');
        $this->datatables->join('wilayah_desa wdasl', 'SUBSTR(p.id_asal, 7, 2) = wdasl.id AND SUBSTR(p.id_asal, 1, 2) = wdasl.id_dati1 AND SUBSTR(p.id_asal, 3, 2) = wdasl.id_dati2 AND SUBSTR(p.id_asal, 5, 2) = wdasl.id_dati3', 'left');
        $this->datatables->join('wilayah_kecamatan wkasl', 'SUBSTR(p.id_asal, 5, 2) = wkasl.id AND SUBSTR(p.id_asal, 1, 2) = wkasl.id_dati1 AND SUBSTR(p.id_asal, 3, 2) = wkasl.id_dati2', 'left');
        $this->datatables->join('wilayah_kabupaten wkbasl', 'SUBSTR(p.id_asal, 3, 2) = wkbasl.id AND SUBSTR(p.id_asal, 1, 2) = wkbasl.id_dati1', 'left');
        $this->datatables->join('wilayah_provinsi wpasl', 'SUBSTR(p.id_asal, 1, 2) = wpasl.id', 'left');
        $this->datatables->join('petugas pt', "p.id_petugas = pt.id_petugas AND pt.status_data = 1 AND pt.id_petugas = '$id_pet'");
        $this->datatables->where('p.id_petugas', $id_pet);
        $this->datatables->where('p.status_data', '1');
        $this->datatables->order_by('p.tanggal_post DESC');

        $this->datatables->add_column('view_ktp', '<a href="' . site_url('ktp/detail_ktp/') . '$1"data-toggle="tooltip" data-original-title="Lihat Detail KTP"><span class="label label-warning"><b>$2</b></span></a>', 'id_ktp, nik_ktp');
        $this->datatables->add_column('view_kta', '<span class="label label-info"><b>$1</b></span>', 'nik_kta_baru');
        $this->datatables->add_column('view_button', $this->button_pet_ktp($this->user), 'id_ktp, status_mutasi, nama_ktp');

        return print_r($this->datatables->generate());
    }

    public function button_ktp($usr = '') {

        $get_button = "";

        if ($usr['role_admin'] == 0) {
            
        } else {
            if ($usr['delete_prev'] == 1) {
                $get_button .= '<a onclick="act_del_ktp($1)" ><button type="button" value="$3" id="$1" class="btn btn-danger btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" data-toggle="tooltip" data-original-title="Hapus Anggota"><i class="ti-close" aria-hidden="true"></i></button></a>';
            } else {
                $get_button .= '<button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" readonly data-toggle="tooltip " data-original-title="Hapus KTP NonAktif (*hub petugas)"><i class="ti-close" aria-hidden="true"></i></button>';
            }
        }
        if ($usr['update_prev'] == 1) {
            $get_button .= '<a href="' . site_url('ktp/get_ktp/') . '$1"><button type="button" class="btn btn-info btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" data-toggle="tooltip" data-original-title="Edit Anggota"><i class="ti-pencil" aria-hidden="true"></i></button></a>';
        } else {
            $get_button .= '<button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" readonly data-toggle="tooltip" data-original-title="Edit KTP NonAktif (*hub petugas)"><i class="ti-pencil" aria-hidden="true"></i></button>';
        }
        if ($usr['update_prev'] == 1 or $usr['create_prev'] == 1) {
            $get_button .= '<a target="_blank" href="' . site_url('laporan/cetak_kta/') . '$1"><button type="button" class="btn btn-warning btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" data-toggle="tooltip" data-original-title="Cetak KTA Anggota"><i class="ti-printer" aria-hidden="true"></i></button></a>';
        } else {
            $get_button .= '<button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" readonly data-toggle="tooltip" data-original-title="Cetak KTA NonAktif (*hub petugas)"><i class="ti-printer" aria-hidden="true"></i></button>';
        }
        if ($usr['update_prev'] == 1 or $usr['create_prev'] == 1) {

            $get_button .= '<a onclick="mutasi_anggota($1,$2)" ><button type="button" value="$3" id="$1" class="btn btn-primary btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" data-toggle="tooltip" data-original-title="Mutasi Anggota"><i class="ti-shift-right" aria-hidden="true"></i></button></a>';
        } else {
            $get_button .= '<button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" readonly data-toggle="tooltip" data-original-title="Mutasi Anggota NonAktif (*hub petugas)"><i class="ti-printer" aria-hidden="true"></i></button>';
        }

        return $get_button;
    }

    public function button_reg_ktp($usr = '') {

        $get_button = "";

        if ($usr['role_admin'] == 0) {
            
        } else {
            if ($usr['delete_prev'] == 1) {
                $get_button .= '<a onclick="act_del_ktp($1)" ><button type="button" value="$3" id="$1" class="btn btn-danger btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" data-toggle="tooltip" data-original-title="Hapus Anggota"><i class="ti-close" aria-hidden="true"></i></button></a>';
            } else {
                $get_button .= '<button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" readonly data-toggle="tooltip" data-original-title="Hapus KTP NonAktif (*hub petugas)"><i class="ti-close" aria-hidden="true"></i></button>';
            }
        }
        if ($usr['update_prev'] == 1) {
            $get_button .= '<a href="' . site_url('ktp/get_ktp_admin/') . '$1"><button type="button" class="btn btn-info btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" data-toggle="tooltip" data-original-title="Edit Anggota"><i class="ti-pencil" aria-hidden="true"></i></button></a>';
        } else {
            $get_button .= '<button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" readonly data-toggle="tooltip" data-original-title="Edit KTP NonAktif (*hub petugas)"><i class="ti-pencil" aria-hidden="true"></i></button>';
        }
        if ($usr['update_prev'] == 1 or $usr['create_prev'] == 1) {
            $get_button .= '<a target="_blank" href="' . site_url('laporan/cetak_kta/') . '$1"><button type="button" class="btn btn-warning btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" data-toggle="tooltip" data-original-title="Cetak KTA Anggota"><i class="ti-printer" aria-hidden="true"></i></button></a>';
        } else {
            $get_button .= '<button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" readonly data-toggle="tooltip" data-original-title="Cetak KTA NonAktif (*hub petugas)"><i class="ti-printer" aria-hidden="true"></i></button>';
        }
        if ($usr['update_prev'] == 1 or $usr['create_prev'] == 1) {

            $get_button .= '<a onclick="mutasi_anggota($1,$2)" ><button type="button" value="$3" id="$1" class="btn btn-primary btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" data-toggle="tooltip" data-original-title="Mutasi Anggota"><i class="ti-shift-right" aria-hidden="true"></i></button></a>';
        } else {
            $get_button .= '<button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" readonly data-toggle="tooltip" data-original-title="Mutasi Anggota NonAktif (*hub petugas)"><i class="ti-printer" aria-hidden="true"></i></button>';
        }

        return $get_button;
    }

    public function button_pet_ktp($usr = '') {

        $get_button = "";

        if ($usr['role_admin'] == 0) {
            
        } else {
            if ($usr['delete_prev'] == 1) {
                $get_button .= '<a onclick="act_del_ktp($1)" ><button type="button" value="$3" id="$1" class="btn btn-danger btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" data-toggle="tooltip" data-original-title="Hapus Anggota"><i class="ti-close" aria-hidden="true"></i></button></a>';
            } else {
                $get_button .= '<button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" readonly data-toggle="tooltip" data-original-title="Hapus KTP NonAktif (*hub petugas)"><i class="ti-close" aria-hidden="true"></i></button>';
            }
        }
        if ($usr['update_prev'] == 1) {
            $get_button .= '<a href="' . site_url('ktp/get_ktp_pet/') . '$1"><button type="button" class="btn btn-info btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" data-toggle="tooltip" data-original-title="Edit Anggota"><i class="ti-pencil" aria-hidden="true"></i></button></a>';
        } else {
            $get_button .= '<button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" readonly data-toggle="tooltip" data-original-title="Edit KTP NonAktif (*hub petugas)"><i class="ti-pencil" aria-hidden="true"></i></button>';
        }
        if ($usr['update_prev'] == 1 or $usr['create_prev'] == 1) {
            $get_button .= '<a target="_blank" href="' . site_url('laporan/cetak_kta/') . '$1"><button type="button" class="btn btn-warning btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" data-toggle="tooltip" data-original-title="Cetak KTA Anggota"><i class="ti-printer" aria-hidden="true"></i></button></a>';
        } else {
            $get_button .= '<button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" readonly data-toggle="tooltip" data-original-title="Cetak KTA NonAktif (*hub petugas)"><i class="ti-printer" aria-hidden="true"></i></button>';
        }
        if ($usr['update_prev'] == 1 or $usr['create_prev'] == 1) {

            $get_button .= '<a onclick="mutasi_anggota($1,$2)" ><button type="button" value="$3" id="$1" class="btn btn-primary btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" data-toggle="tooltip" data-original-title="Mutasi Anggota"><i class="ti-shift-right" aria-hidden="true"></i></button></a>';
        } else {
            $get_button .= '<button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" readonly data-toggle="tooltip" data-original-title="Mutasi Anggota NonAktif (*hub petugas)"><i class="ti-printer" aria-hidden="true"></i></button>';
        }

        return $get_button;
    }

    //-----------------------------------------------PETUGAS--------------------------------------------------//

    public function petugas_json() {

        if (!empty($this->user['id_ref']) && ($this->user['role_admin'] == 2)) {

            $this->datatables->select("p.id_petugas,
                                    p.id_admin,
                                    UCASE(p.nama_petugas) AS nama_petugas,
                                    p.nomor_hp,
                                    p.alamat_petugas,
                                    p.email_petugas,
                                    p.nomor_ktp,
                                    p.kode_petugas,
                                    wp.nama AS provinsi,                                       
                                    CONCAT(UCASE(wkb.nama),' ', UCASE(wkb.administratif)) AS kabupaten,
                                    IF(wkb.nama IS NULL,UCASE(wp.nama),CONCAT(UCASE(wp.nama),'-', CONCAT(UCASE(wkb.nama),' ', UCASE(wkb.administratif)))) AS regional_petugas,
                                   (
                                    SELECT
                                        COUNT(k.id_ktp)
                                    FROM
                                        ktp k
                                    WHERE
                                        k.id_petugas = p.id_petugas AND k.status_data = 1
                                    ) AS jml_ktp,
                                    p.status_data,
                                    p.tanggal_post");
            $this->datatables->from('petugas p');
            $this->datatables->join('wilayah_kabupaten wkb', 'SUBSTR(p.id_admin, 3, 2) = wkb.id AND SUBSTR(p.id_admin, 1, 2) = wkb.id_dati1', 'left');
            $this->datatables->join('wilayah_provinsi wp', 'SUBSTR(p.id_admin, 1, 2) = wp.id', 'left');
            $this->datatables->where('p.id_admin', $this->user['id_ref']);
            $this->datatables->where('p.status_data', '1');
            $this->datatables->order_by('p.tanggal_post DESC');

            $this->datatables->add_column('view_nama_petugas', '<span class="label label-info"><b>$1</b></span>', 'nama_petugas');
            $this->datatables->add_column('view_kode_petugas', '<span class="label label-danger"><b>$1</b></span>', 'kode_petugas');
            $this->datatables->add_column('view_regional_petugas', '<span class="label label-success"><b>$1</b></span>', 'regional_petugas');
            $this->datatables->add_column('view_button', $this->button_petugas($this->user), 'id_petugas, id_admin, nama_petugas');
        } elseif (!empty($this->user['id_ref']) && ($this->user['role_admin'] == 1)) {

            $this->datatables->select("p.id_petugas,
                                    p.id_admin,
                                    UCASE(p.nama_petugas) AS nama_petugas,
                                    p.nomor_hp,
                                    p.alamat_petugas,
                                    p.email_petugas,
                                    p.nomor_ktp,
                                    p.kode_petugas,
                                    wp.nama AS provinsi,
                                    CONCAT(UCASE(wkb.nama),' ', UCASE(wkb.administratif)) AS kabupaten,                                  
                                    IF(wkb.nama IS NULL,UCASE(wp.nama),CONCAT(UCASE(wp.nama),'-', CONCAT(UCASE(wkb.nama),' ', UCASE(wkb.administratif)))) AS regional_petugas,
                                   (
                                    SELECT
                                        COUNT(k.id_ktp)
                                    FROM
                                        ktp k
                                    WHERE
                                        k.id_petugas = p.id_petugas AND k.status_data = 1
                                    ) AS jml_ktp,
                                    p.status_data,
                                    p.tanggal_post");
            $this->datatables->from('petugas p');
            $this->datatables->join('wilayah_kabupaten wkb', 'SUBSTR(p.id_admin, 3, 2) = wkb.id AND SUBSTR(p.id_admin, 1, 2) = wkb.id_dati1', 'left');
            $this->datatables->join('wilayah_provinsi wp', 'SUBSTR(p.id_admin, 1, 2) = wp.id', 'left');
            $this->datatables->like('p.id_admin', $this->user['id_ref'], 'after');
            $this->datatables->where('p.status_data', '1');
            $this->datatables->order_by('p.tanggal_post DESC');

            $this->datatables->add_column('view_nama_petugas', '<span class="label label-info"><b>$1</b></span>', 'nama_petugas');
            $this->datatables->add_column('view_kode_petugas', '<span class="label label-danger"><b>$1</b></span>', 'kode_petugas');
            $this->datatables->add_column('view_regional_petugas', '<span class="label label-success"><b>$1</b></span>', 'regional_petugas');
            $this->datatables->add_column('view_button', $this->button_petugas($this->user), 'id_petugas, id_admin, nama_petugas');
        } elseif ($this->user['role_admin'] == 0) {

            $this->datatables->select("p.id_petugas,
                                    p.id_admin,
                                    UCASE(p.nama_petugas) AS nama_petugas,
                                    p.nomor_hp,
                                    p.alamat_petugas,
                                    p.email_petugas,
                                    p.nomor_ktp,
                                    p.kode_petugas,
                                    wp.nama AS provinsi,
                                    CONCAT(UCASE(wkb.nama),' ', UCASE(wkb.administratif)) AS kabupaten,                                   
                                    IF(wkb.nama IS NULL,UCASE(wp.nama),CONCAT(UCASE(wp.nama),'-', CONCAT(UCASE(wkb.nama),' ', UCASE(wkb.administratif)))) AS regional_petugas,
                                   (
                                    SELECT
                                        COUNT(k.id_ktp)
                                    FROM
                                        ktp k
                                    WHERE
                                        k.id_petugas = p.id_petugas AND k.status_data = 1
                                    ) AS jml_ktp,
                                    p.status_data,
                                    p.tanggal_post");
            $this->datatables->from('petugas p');
            $this->datatables->join('wilayah_kabupaten wkb', 'SUBSTR(p.id_admin, 3, 2) = wkb.id AND SUBSTR(p.id_admin, 1, 2) = wkb.id_dati1', 'left');
            $this->datatables->join('wilayah_provinsi wp', 'SUBSTR(p.id_admin, 1, 2) = wp.id', 'left');
            $this->datatables->where('p.status_data', '1');
            $this->datatables->order_by('p.tanggal_post DESC');

            $this->datatables->add_column('view_nama_petugas', '<span class="label label-info"><b>$1</b></span>', 'nama_petugas');
            $this->datatables->add_column('view_kode_petugas', '<span class="label label-danger"><b>$1</b></span>', 'kode_petugas');
            $this->datatables->add_column('view_regional_petugas', '<span class="label label-success"><b>$1</b></span>', 'regional_petugas');
            $this->datatables->add_column('view_button', $this->button_petugas($this->user), 'id_petugas, id_admin, nama_petugas');
        }

        return print_r($this->datatables->generate());
    }

    public function button_petugas($usr = '') {

        $get_button = "";

        if ($usr['role_admin'] == 0) {
            
        } else {
            if ($usr['delete_prev'] == 1) {
                $get_button .= '<a onclick="act_del_petugas($1)" ><button type="button" value="$3" id="$1" class="btn btn-danger btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" data-toggle="tooltip" data-original-title="Hapus Petugas"><i class="ti-close" aria-hidden="true"></i></button></a>';
            } else {
                $get_button .= '<button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" readonly data-toggle="tooltip" data-original-title="Hapus Petugas NonAktif (*hub petugas)"><i class="ti-close" aria-hidden="true"></i></button>';
            }
        }

        if ($usr['update_prev'] == 1) {
            $get_button .= '<a href="' . site_url('petugas/get_petugas/') . '$1" ><button type="button" data-toggle="tooltip" class="btn btn-info btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" data-original-title="Edit Petugas"><i class="ti-pencil" aria-hidden="true"></i></button></a>';
        } else {
            $get_button .= '<button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" readonly data-toggle="tooltip" data-original-title="Edit Petugas NonAktif (*hub petugas)"><i class="ti-pencil" aria-hidden="true"></i></button>';
        }

        $get_button .= '<a href="' . site_url('ktp/lihat_ktp_pet/') . '$1"><button type="button" class="btn btn-warning btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" data-toggle="tooltip" data-original-title="Lihat Data KTP Petugas"><i class="ti-eye" aria-hidden="true"></i></button></a>';

        if ($usr['create_prev'] == 1) {
            $get_button .= '<a href="' . site_url('ktp/tambah_ktp_pet/') . '$1"><button type="button" class="btn btn-success btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" data-toggle="tooltip" data-original-title="Tambah KTP per Petugas"><i class="ti-plus" aria-hidden="true"></i></button></a>';
        } else {
            $get_button .= '<button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" readonly data-toggle="tooltip" data-original-title="Tambah KTP per Petugas NonAktif (*hub petugas)"><i class="ti-plus" aria-hidden="true"></i></button>';
        }

        return $get_button;
    }

    //-----------------------------------------------AKUN ADMIN KAB--------------------------------------------------//

    public function akun_kab_json() {

        if (!empty(substr($this->user['id_ref'], 0, 2)) && ($this->user['role_admin'] == 1)) {

            $this->datatables->select("u.id_user,
                                        u.id_ref,
                                        UCASE(u.nama_admin) AS nama_admin,
                                        u.status,
                                        u.email,
                                        u.nomor_hp,                                       
                                        DATE_FORMAT(STR_TO_DATE(u.license_exp, '%d/%m/%Y'), '%Y-%m-%d') as license_exp,                                        
                                        u.status_data,
                                        u.create_prev,
                                        u.read_prev,
                                        u.update_prev,
                                        u.delete_prev,
                                        u.tanggal_post,
                                        UCASE(wp.nama) AS provinsi,
                                        CONCAT(UCASE(wkb.nama),' ', UCASE(wkb.administratif)) AS kabupaten,    
                                        (
                                            SELECT
                                                COUNT(p.id_petugas)
                                            FROM
                                                petugas p
                                            WHERE
                                                p.id_admin = u.id_ref
                                        ) AS jml_pet,
                                        (
                                            SELECT
                                                COUNT(k.id_ktp)
                                            FROM
                                                ktp k
                                            WHERE
                                                k.id_admin = u.id_ref
                                        ) AS jml_ktp");
            $this->datatables->from('user u');
            $this->datatables->join('wilayah_kabupaten wkb', 'SUBSTR(u.id_ref, 3, 2) = wkb.id AND SUBSTR(u.id_ref, 1, 2) = wkb.id_dati1', 'left');
            $this->datatables->join('wilayah_provinsi wp', 'SUBSTR(u.id_ref, 1, 2) = wp.id', 'left');
            $this->datatables->where('u.role_admin', '2');
            $this->datatables->where('u.id_ref', substr($this->user['id_ref'], 0, 2));
            $this->datatables->order_by('u.tanggal_post DESC');

            $this->datatables->add_column('view_button', $this->button_admin_kab($this->user), 'id_user, id_ref, nama_admin');
        } elseif ($this->user['role_admin'] == 0) {

            $this->datatables->select("u.id_user,
                                        u.id_ref,
                                        UCASE(u.nama_admin) AS nama_admin,
                                        u.status,
                                        u.email,
                                        u.nomor_hp,                                       
                                        DATE_FORMAT(STR_TO_DATE(u.license_exp, '%d/%m/%Y'), '%Y-%m-%d') as license_exp,                                        
                                        u.status_data,
                                        u.create_prev,
                                        u.read_prev,
                                        u.update_prev,
                                        u.delete_prev,
                                        u.tanggal_post,
                                        UCASE(wp.nama) AS provinsi,
                                        CONCAT(UCASE(wkb.nama),' ', UCASE(wkb.administratif)) AS kabupaten,
                                        (
                                            SELECT
                                                COUNT(p.id_petugas)
                                            FROM
                                                petugas p
                                            WHERE
                                                p.id_admin = u.id_ref
                                        ) AS jml_pet,
                                        (
                                            SELECT
                                                COUNT(k.id_ktp)
                                            FROM
                                                ktp k
                                            WHERE
                                                k.id_admin = u.id_ref
                                        ) AS jml_ktp");
            $this->datatables->from('user u');
            $this->datatables->join('wilayah_kabupaten wkb', 'SUBSTR(u.id_ref, 3, 2) = wkb.id AND SUBSTR(u.id_ref, 1, 2) = wkb.id_dati1', 'left');
            $this->datatables->join('wilayah_provinsi wp', 'SUBSTR(u.id_ref, 1, 2) = wp.id', 'left');
            $this->datatables->where('u.role_admin', '2');
            $this->datatables->order_by('u.tanggal_post DESC');

            $this->datatables->add_column('view_button', $this->button_admin_kab($this->user), 'id_user, id_ref, nama_admin');
        }

        return print_r($this->datatables->generate());
    }

    public function button_admin_kab($usr = '') {

        $get_button = "";

        $get_button .= '<a onclick="act_del_admin_kab($1)" ><button type="button" value="$3" id="$1" class="btn btn-danger btn-sm btn-icon btn-pure btn-outline delete-row-btn " data-toggle="tooltip" data-original-title="Hapus Admin Kabupaten"><i class="ti-close" aria-hidden="true"></i></button></a>';
        $get_button .= '<a href="' . site_url('akun/get_admin_kabupaten/') . '$1" ><button type="button" data-toggle="tooltip" class="btn btn-info btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" data-original-title="Edit Admin Kabupaten"><i class="ti-pencil" aria-hidden="true"></i></button></a>';
        $get_button .= '<a href="' . site_url('ktp/lihat_ktp_admin/') . '$2" ><button type="button" data-toggle="tooltip" class="btn btn-warning btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" data-original-title="Lihat Anggota Admin Kabupaten"><i class="ti-eye" aria-hidden="true"></i></button></a>';

        if ($usr['create_prev'] == 1) {
            $get_button .= '<a href="' . site_url('ktp/tambah_ktp_admin/') . '$2"><button type="button" class="btn btn-success btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" data-toggle="tooltip" data-original-title="Tambah KTP Admin"><i class="ti-plus" aria-hidden="true"></i></button></a>';
        } else {
            $get_button .= '<button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" readonly data-toggle="tooltip" data-original-title="Tambah KTP Admin NonAktif (*hub petugas)"><i class="ti-plus" aria-hidden="true"></i></button>';
        }

        return $get_button;
    }

    //-----------------------------------------------KELOLA ANGGOTA--------------------------------------------------//

    public function kelola_anggota_json() {

        if (!empty($this->user['id_ref']) && ($this->user['role_admin'] == 2)) {
            $this->datatables->select("p.id_ktp,
                                    p.nik_kta_baru,
                                    p.id_asal,
                                    p.id_admin,
                                    p.id_petugas,
                                    wpasl.nama AS provinsi_asal,                                    
                                    CONCAT(UCASE(wkbasl.nama),' ', UCASE(wkbasl.administratif)) AS kabupaten_asal,
                                    wkasl.nama AS kecamatan_asal,
                                    wdasl.nama AS kelurahan_asal,
                                    wpagt.nama AS provinsi_anggota,                                    
                                    CONCAT(UCASE(wkbagt.nama),' ', UCASE(wkbagt.administratif)) AS kabupaten_anggota,
                                    pt.nama_petugas,
                                    p.nik_ktp,
                                    UCASE(p.nama_ktp) AS nama_ktp,
                                    CONCAT(UCASE(p.tempat_lahir),', ',p.tanggal_lahir) AS tmp_tgl_lahir,                                    
                                    IF(p.jenis_kelamin='1','LAKI-LAKI', 'PEREMPUAN') AS jenis_kelamin,
                                    p.gol_darah,
                                    p.alamat_ktp,
                                    p.agama,
                                    p.status_nikah,
                                    p.pekerjaan,
                                    p.nomor_hp_ktp,
                                    p.img,
                                    p.img_thumb,
                                    p.status_data,
                                    p.status_mutasi,
                                    p.tanggal_post");
            $this->datatables->from('ktp p');
            $this->datatables->join('wilayah_kabupaten wkbagt', 'SUBSTR(p.id_admin, 3, 2) = wkbagt.id AND SUBSTR(p.id_admin, 1, 2) = wkbagt.id_dati1', 'left');
            $this->datatables->join('wilayah_provinsi wpagt', 'SUBSTR(p.id_admin, 1, 2) = wpagt.id', 'left');
            $this->datatables->join('wilayah_desa wdasl', 'SUBSTR(p.id_asal, 7, 2) = wdasl.id AND SUBSTR(p.id_asal, 1, 2) = wdasl.id_dati1 AND SUBSTR(p.id_asal, 3, 2) = wdasl.id_dati2 AND SUBSTR(p.id_asal, 5, 2) = wdasl.id_dati3', 'left');
            $this->datatables->join('wilayah_kecamatan wkasl', 'SUBSTR(p.id_asal, 5, 2) = wkasl.id AND SUBSTR(p.id_asal, 1, 2) = wkasl.id_dati1 AND SUBSTR(p.id_asal, 3, 2) = wkasl.id_dati2', 'left');
            $this->datatables->join('wilayah_kabupaten wkbasl', 'SUBSTR(p.id_asal, 3, 2) = wkbasl.id AND SUBSTR(p.id_asal, 1, 2) = wkbasl.id_dati1', 'left');
            $this->datatables->join('wilayah_provinsi wpasl', 'SUBSTR(p.id_asal, 1, 2) = wpasl.id', 'left');
            $this->datatables->join('petugas pt', "p.id_petugas = pt.id_petugas AND p.id_admin = '" . $this->user['id_ref'] . "' AND p.status_data = 1 AND pt.status_data = 1 AND pt.id_admin = '" . $this->user['id_ref'] . "'", 'left');
            $this->datatables->where('p.id_admin', $this->user['id_ref']);
            $this->datatables->where('p.status_data', '1');
            $this->datatables->add_column('view_ktp', '<a href="' . site_url('ktp/detail_ktp/') . '$1"data-toggle="tooltip" data-original-title="Lihat Detail KTP"><span class="label label-warning"><b>$2</b></span></a>', 'id_ktp, nik_ktp');
            $this->datatables->add_column('view_kta', '<span class="label label-info"><b>$1</b></span>', 'nik_kta_baru');

            $this->datatables->add_column('view_button', $this->button_ktp($this->user), 'id_ktp, status_mutasi, nama_ktp');

            $this->datatables->order_by('p.tanggal_post DESC');
        } elseif (!empty($this->user['id_ref']) && ($this->user['role_admin'] == 1)) {

            $this->datatables->select("p.id_ktp,
                                    p.nik_kta_baru,
                                    p.id_asal,
                                    p.id_admin,
                                    p.id_petugas,
                                    wpasl.nama AS provinsi_asal,                                   
                                    CONCAT(UCASE(wkbasl.nama),' ', UCASE(wkbasl.administratif)) AS kabupaten_asal,
                                    wkasl.nama AS kecamatan_asal,
                                    wdasl.nama AS kelurahan_asal,
                                    wpagt.nama AS provinsi_anggota,                                  
                                    CONCAT(UCASE(wkbagt.nama),' ', UCASE(wkbagt.administratif)) AS kabupaten_anggota,
                                    pt.nama_petugas,
                                    p.nik_ktp,
                                    p.nama_ktp,
                                    UCASE(p.nama_ktp) AS nama_ktp,
                                    CONCAT(UCASE(p.tempat_lahir),', ',p.tanggal_lahir) AS tmp_tgl_lahir,                                
                                    IF(p.jenis_kelamin='1','LAKI-LAKI', 'PEREMPUAN') AS jenis_kelamin,
                                    p.gol_darah,
                                    p.alamat_ktp,
                                    p.agama,
                                    p.status_nikah,
                                    p.pekerjaan,
                                    p.nomor_hp_ktp,
                                    p.img,
                                    p.img_thumb,
                                    p.status_data,
                                    p.status_mutasi,
                                    p.tanggal_post");
            $this->datatables->from('ktp p');
            $this->datatables->join('wilayah_kabupaten wkbagt', 'SUBSTR(p.id_admin, 3, 2) = wkbagt.id AND SUBSTR(p.id_admin, 1, 2) = wkbagt.id_dati1', 'left');
            $this->datatables->join('wilayah_provinsi wpagt', 'SUBSTR(p.id_admin, 1, 2) = wpagt.id', 'left');
            $this->datatables->join('wilayah_desa wdasl', 'SUBSTR(p.id_asal, 7, 2) = wdasl.id AND SUBSTR(p.id_asal, 1, 2) = wdasl.id_dati1 AND SUBSTR(p.id_asal, 3, 2) = wdasl.id_dati2 AND SUBSTR(p.id_asal, 5, 2) = wdasl.id_dati3', 'left');
            $this->datatables->join('wilayah_kecamatan wkasl', 'SUBSTR(p.id_asal, 5, 2) = wkasl.id AND SUBSTR(p.id_asal, 1, 2) = wkasl.id_dati1 AND SUBSTR(p.id_asal, 3, 2) = wkasl.id_dati2', 'left');
            $this->datatables->join('wilayah_kabupaten wkbasl', 'SUBSTR(p.id_asal, 3, 2) = wkbasl.id AND SUBSTR(p.id_asal, 1, 2) = wkbasl.id_dati1', 'left');
            $this->datatables->join('wilayah_provinsi wpasl', 'SUBSTR(p.id_asal, 1, 2) = wpasl.id', 'left');
            $this->datatables->join('petugas pt', "p.id_petugas = pt.id_petugas AND p.id_admin LIKE '" . $this->user['id_ref'] . "%' AND p.status_data = 1 AND pt.status_data = 1 AND pt.id_admin LIKE '" . $this->user['id_ref'] . "%'", 'left');
            $this->datatables->like('p.id_admin', $this->user['id_ref'], 'after');
            $this->datatables->where('p.status_data', '1');
            $this->datatables->add_column('view_ktp', '<a href="' . site_url('ktp/detail_ktp/') . '$1"data-toggle="tooltip" data-original-title="Lihat Detail KTP"><span class="label label-warning"><b>$2</b></span></a>', 'id_ktp, nik_ktp');
            $this->datatables->add_column('view_kta', '<span class="label label-info"><b>$1</b></span>', 'nik_kta_baru');

            $this->datatables->add_column('view_button', $this->button_ktp($this->user), 'id_ktp, status_mutasi, nama_ktp');

            $this->datatables->order_by('p.tanggal_post DESC');
        } elseif ($this->user['role_admin'] == 0) {

            $this->datatables->select("p.id_ktp,
                                    p.nik_kta_baru,
                                    p.id_asal,
                                    p.id_admin,
                                    p.id_petugas,
                                    wpasl.nama AS provinsi_asal,                                   
                                    CONCAT(UCASE(wkbasl.nama),' ', UCASE(wkbasl.administratif)) AS kabupaten_asal,
                                    wkasl.nama AS kecamatan_asal,
                                    wdasl.nama AS kelurahan_asal,
                                    wpagt.nama AS provinsi_anggota,
                                    CONCAT(UCASE(wkbagt.nama),' ', UCASE(wkbagt.administratif)) AS kabupaten_anggota,
                                    pt.nama_petugas,
                                    p.nik_ktp,
                                    p.nama_ktp,
                                    UCASE(p.nama_ktp) AS nama_ktp,
                                    CONCAT(UCASE(p.tempat_lahir),', ',p.tanggal_lahir) AS tmp_tgl_lahir, 
                                    IF(p.jenis_kelamin='1','LAKI-LAKI', 'PEREMPUAN') AS jenis_kelamin,
                                    p.gol_darah,
                                    p.alamat_ktp,
                                    p.agama,
                                    p.status_nikah,
                                    p.pekerjaan,
                                    p.nomor_hp_ktp,
                                    p.img,
                                    p.img_thumb,
                                    p.status_data,
                                    p.status_mutasi,
                                    p.tanggal_post");
            $this->datatables->from('ktp p');
            $this->datatables->join('wilayah_kabupaten wkbagt', 'SUBSTR(p.id_admin, 3, 2) = wkbagt.id AND SUBSTR(p.id_admin, 1, 2) = wkbagt.id_dati1', 'left');
            $this->datatables->join('wilayah_provinsi wpagt', 'SUBSTR(p.id_admin, 1, 2) = wpagt.id', 'left');
            $this->datatables->join('wilayah_desa wdasl', 'SUBSTR(p.id_asal, 7, 2) = wdasl.id AND SUBSTR(p.id_asal, 1, 2) = wdasl.id_dati1 AND SUBSTR(p.id_asal, 3, 2) = wdasl.id_dati2 AND SUBSTR(p.id_asal, 5, 2) = wdasl.id_dati3', 'left');
            $this->datatables->join('wilayah_kecamatan wkasl', 'SUBSTR(p.id_asal, 5, 2) = wkasl.id AND SUBSTR(p.id_asal, 1, 2) = wkasl.id_dati1 AND SUBSTR(p.id_asal, 3, 2) = wkasl.id_dati2', 'left');
            $this->datatables->join('wilayah_kabupaten wkbasl', 'SUBSTR(p.id_asal, 3, 2) = wkbasl.id AND SUBSTR(p.id_asal, 1, 2) = wkbasl.id_dati1', 'left');
            $this->datatables->join('wilayah_provinsi wpasl', 'SUBSTR(p.id_asal, 1, 2) = wpasl.id', 'left');
            $this->datatables->join('petugas pt', "p.id_petugas = pt.id_petugas", 'left');
            $this->datatables->add_column('view_ktp', '<a href="' . site_url('ktp/detail_ktp/') . '$1"data-toggle="tooltip" data-original-title="Lihat Detail KTP"><span class="label label-warning"><b>$2</b></span></a>', 'id_ktp, nik_ktp');
            $this->datatables->add_column('view_kta', '<span class="label label-info"><b>$1</b></span>', 'nik_kta_baru');

            $this->datatables->add_column('view_button', $this->button_delete_kelola_anggota($this->user), 'id_ktp, status_mutasi, nama_ktp');

            $this->datatables->order_by('p.tanggal_post DESC');
        }
        return print_r($this->datatables->generate());
    }

    public function button_delete_kelola_anggota($usr = '') {

        $get_button = "";

        if ($usr['delete_prev'] == 1) {
            $get_button .= '<a onclick="act_del_ktp($1)" ><button type="button" value="$3" id="$1" class="btn btn-danger btn-sm btn-icon btn-pure btn-outline delete-row-btn " data-toggle="tooltip" data-original-title="Hapus Anggota"><i class="ti-close" aria-hidden="true"></i></button></a>';
        } else {
            $get_button .= '<button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn" readonly data-toggle="tooltip" data-original-title="Hapus KTP NonAktif (*hub petugas)"><i class="ti-close" aria-hidden="true"></i></button>';
        }

        return $get_button;
    }

    //-----------------------------------------------KELOLA PETUGAS--------------------------------------------------//

    public function kelola_petugas_json() {

        if (!empty($this->user['id_ref']) && ($this->user['role_admin'] == 2)) {

            $this->datatables->select("p.id_petugas,
                                    p.id_admin,
                                    UCASE(p.nama_petugas) AS nama_petugas,
                                    p.nomor_hp,
                                    p.alamat_petugas,
                                    p.email_petugas,
                                    p.nomor_ktp,
                                    p.kode_petugas,
                                    wp.nama AS provinsi,                                      
                                    CONCAT(UCASE(wkb.nama),' ', UCASE(wkb.administratif)) AS kabupaten,
                                    IF(wkb.nama IS NULL,UCASE(wp.nama),CONCAT(UCASE(wp.nama),'-',CONCAT(UCASE(wkb.nama),' ', UCASE(wkb.administratif)))) AS regional_petugas,
                                   (
                                    SELECT
                                        COUNT(k.id_ktp)
                                    FROM
                                        ktp k
                                    WHERE
                                        k.id_petugas = p.id_petugas AND k.status_data = 1
                                    ) AS jml_ktp,
                                    p.status_data,
                                    p.tanggal_post");
            $this->datatables->from('petugas p');
            $this->datatables->join('wilayah_kabupaten wkb', 'SUBSTR(p.id_admin, 3, 2) = wkb.id AND SUBSTR(p.id_admin, 1, 2) = wkb.id_dati1', 'left');
            $this->datatables->join('wilayah_provinsi wp', 'SUBSTR(p.id_admin, 1, 2) = wp.id', 'left');
            $this->datatables->where('p.id_admin', $this->user['id_ref']);
            $this->datatables->where('p.status_data', '1');
            $this->datatables->order_by('p.tanggal_post DESC');

            $this->datatables->add_column('view_nama_petugas', '<span class="label label-info"><b>$1</b></span>', 'nama_petugas');
            $this->datatables->add_column('view_kode_petugas', '<span class="label label-danger"><b>$1</b></span>', 'kode_petugas');
            $this->datatables->add_column('view_regional_petugas', '<span class="label label-success"><b>$1</b></span>', 'regional_petugas');
            $this->datatables->add_column('view_button', $this->button_petugas($this->user), 'id_petugas, id_admin, nama_petugas');
        } elseif (!empty($this->user['id_ref']) && ($this->user['role_admin'] == 1)) {

            $this->datatables->select("p.id_petugas,
                                    p.id_admin,
                                    UCASE(p.nama_petugas) AS nama_petugas,
                                    p.nomor_hp,
                                    p.alamat_petugas,
                                    p.email_petugas,
                                    p.nomor_ktp,
                                    p.kode_petugas,
                                    wp.nama AS provinsi,
                                    CONCAT(UCASE(wkb.nama),' ', UCASE(wkb.administratif)) AS kabupaten,                               
                                    IF(wkb.nama IS NULL,UCASE(wp.nama),CONCAT(UCASE(wp.nama),'-',CONCAT(UCASE(wkb.nama),' ', UCASE(wkb.administratif)))) AS regional_petugas,
                                   (
                                    SELECT
                                        COUNT(k.id_ktp)
                                    FROM
                                        ktp k
                                    WHERE
                                        k.id_petugas = p.id_petugas AND k.status_data = 1
                                    ) AS jml_ktp,
                                    p.status_data,
                                    p.tanggal_post");
            $this->datatables->from('petugas p');
            $this->datatables->join('wilayah_kabupaten wkb', 'SUBSTR(p.id_admin, 3, 2) = wkb.id AND SUBSTR(p.id_admin, 1, 2) = wkb.id_dati1', 'left');
            $this->datatables->join('wilayah_provinsi wp', 'SUBSTR(p.id_admin, 1, 2) = wp.id', 'left');
            $this->datatables->like('p.id_admin', $this->user['id_ref'], 'after');
            $this->datatables->where('p.status_data', '1');
            $this->datatables->order_by('p.tanggal_post DESC');

            $this->datatables->add_column('view_nama_petugas', '<span class="label label-info"><b>$1</b></span>', 'nama_petugas');
            $this->datatables->add_column('view_kode_petugas', '<span class="label label-danger"><b>$1</b></span>', 'kode_petugas');
            $this->datatables->add_column('view_regional_petugas', '<span class="label label-success"><b>$1</b></span>', 'regional_petugas');
            $this->datatables->add_column('view_button', $this->button_petugas($this->user), 'id_petugas, id_admin, nama_petugas');
        } elseif ($this->user['role_admin'] == 0) {

            $this->datatables->select("p.id_petugas,
                                    p.id_admin,
                                    UCASE(p.nama_petugas) AS nama_petugas,
                                    p.nomor_hp,
                                    p.alamat_petugas,
                                    p.email_petugas,
                                    p.nomor_ktp,
                                    p.kode_petugas,
                                    wp.nama AS provinsi,
                                    CONCAT(UCASE(wkb.nama),' ', UCASE(wkb.administratif)) AS kabupaten,                                   
                                    IF(wkb.nama IS NULL,UCASE(wp.nama),CONCAT(UCASE(wp.nama),'-',CONCAT(UCASE(wkb.nama),' ', UCASE(wkb.administratif)))) AS regional_petugas,
                                   (
                                    SELECT
                                        COUNT(k.id_ktp)
                                    FROM
                                        ktp k
                                    WHERE
                                        k.id_petugas = p.id_petugas AND k.status_data = 1
                                    ) AS jml_ktp,
                                    p.status_data,
                                    p.tanggal_post");
            $this->datatables->from('petugas p');
            $this->datatables->join('wilayah_kabupaten wkb', 'SUBSTR(p.id_admin, 3, 2) = wkb.id AND SUBSTR(p.id_admin, 1, 2) = wkb.id_dati1', 'left');
            $this->datatables->join('wilayah_provinsi wp', 'SUBSTR(p.id_admin, 1, 2) = wp.id', 'left');
            $this->datatables->order_by('p.tanggal_post DESC');

            $this->datatables->add_column('view_nama_petugas', '<span class="label label-info"><b>$1</b></span>', 'nama_petugas');
            $this->datatables->add_column('view_kode_petugas', '<span class="label label-danger"><b>$1</b></span>', 'kode_petugas');
            $this->datatables->add_column('view_regional_petugas', '<span class="label label-success"><b>$1</b></span>', 'regional_petugas');
            $this->datatables->add_column('view_button', $this->button_delete_kelola_petugas($this->user), 'id_petugas, id_admin, nama_petugas');
        }

        return print_r($this->datatables->generate());
    }

    public function button_delete_kelola_petugas($usr = '') {

        $get_button = "";

        if ($usr['delete_prev'] == 1) {
            $get_button .= '<a onclick="act_del_petugas($1)" ><button type="button" value="$3" id="$1" class="btn btn-danger btn-sm btn-icon btn-pure btn-outline delete-row-btn " data-toggle="tooltip" data-original-title="Hapus Anggota"><i class="ti-close" aria-hidden="true"></i></button></a>';
        } else {
            $get_button .= '<button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn" readonly data-toggle="tooltip" data-original-title="Hapus KTP NonAktif (*hub petugas)"><i class="ti-close" aria-hidden="true"></i></button>';
        }

        return $get_button;
    }

    //-----------------------------------------------ANGGOTA--------------------------------------------------//

    public function anggota_json($id = '') {

        $get_label = $this->Datatablemodel->get_label($id);

        if (!empty($get_label)) {
            $string_kab = explode(',', $get_label[0]->kabupaten);
            $string_kec = explode(',', $get_label[0]->kecamatan);
        }


        if (!empty($this->user['id_ref']) && ($this->user['role_admin'] == 2) && !empty($get_label)) {

            $this->datatables->select("p.id_ktp,
                                    p.nik_kta_baru,
                                    p.id_asal,
                                    p.id_admin,
                                    p.id_petugas,
                                    wpasl.nama AS provinsi_asal,                                    
                                    CONCAT(UCASE(wkbasl.nama),' ', UCASE(wkbasl.administratif)) AS kabupaten_asal,
                                    wkasl.nama AS kecamatan_asal,
                                    wdasl.nama AS kelurahan_asal,
                                    wpagt.nama AS provinsi_anggota,                                   
                                    CONCAT(UCASE(wkbagt.nama),' ', UCASE(wkbagt.administratif)) AS kabupaten_anggota,
                                    pt.nama_petugas,
                                    p.nik_ktp,
                                    UCASE(p.nama_ktp) AS nama_ktp,
                                    CONCAT(UCASE(p.tempat_lahir),', ',p.tanggal_lahir) AS tmp_tgl_lahir,                                    
                                    IF(p.jenis_kelamin='1','LAKI-LAKI', 'PEREMPUAN') AS jenis_kelamin,
                                    p.gol_darah,
                                    p.alamat_ktp,
                                    p.agama,
                                    p.status_nikah,
                                    p.pekerjaan,
                                    p.nomor_hp_ktp,
                                    p.img,
                                    p.img_thumb,
                                    p.status_data,
                                    p.status_mutasi,
                                    p.tanggal_post");
            $this->datatables->from('ktp p');
            $this->datatables->join('wilayah_kabupaten wkbagt', 'SUBSTR(p.id_admin, 3, 2) = wkbagt.id AND SUBSTR(p.id_admin, 1, 2) = wkbagt.id_dati1', 'left');
            $this->datatables->join('wilayah_provinsi wpagt', 'SUBSTR(p.id_admin, 1, 2) = wpagt.id', 'left');
            $this->datatables->join('wilayah_desa wdasl', 'SUBSTR(p.id_asal, 7, 2) = wdasl.id AND SUBSTR(p.id_asal, 1, 2) = wdasl.id_dati1 AND SUBSTR(p.id_asal, 3, 2) = wdasl.id_dati2 AND SUBSTR(p.id_asal, 5, 2) = wdasl.id_dati3', 'left');
            $this->datatables->join('wilayah_kecamatan wkasl', 'SUBSTR(p.id_asal, 5, 2) = wkasl.id AND SUBSTR(p.id_asal, 1, 2) = wkasl.id_dati1 AND SUBSTR(p.id_asal, 3, 2) = wkasl.id_dati2', 'left');
            $this->datatables->join('wilayah_kabupaten wkbasl', 'SUBSTR(p.id_asal, 3, 2) = wkbasl.id AND SUBSTR(p.id_asal, 1, 2) = wkbasl.id_dati1', 'left');
            $this->datatables->join('wilayah_provinsi wpasl', 'SUBSTR(p.id_asal, 1, 2) = wpasl.id', 'left');
            $this->datatables->join('petugas pt', "p.id_petugas = pt.id_petugas AND p.id_admin = '" . $this->user['id_ref'] . "' AND p.status_data = 1 AND pt.status_data = 1 AND pt.id_admin = '" . $this->user['id_ref'] . "'", 'left');
            $this->datatables->where('p.id_admin', $this->user['id_ref']);
            $this->datatables->where('SUBSTRING(p.id_asal,1,2)', $get_label[0]->provinsi);
            $this->datatables->where_in('SUBSTRING(p.id_asal,1,4)', $string_kab);
            if ($get_label[0]->kecamatan != null or ! empty($get_label[0]->kecamatan) or $get_label[0]->kecamatan != '') {
                $this->datatables->where_in('SUBSTRING(p.id_asal,1,6)', $string_kec);
            }
            $this->datatables->where('p.status_data', '1');
            $this->datatables->order_by('p.tanggal_post DESC');

            $this->datatables->add_column('view_ktp', '<a href="' . site_url('ktp/detail_ktp/') . '$1"data-toggle="tooltip" data-original-title="Lihat Detail KTP"><span class="label label-warning"><b>$2</b></span></a>', 'id_ktp, nik_ktp');
            $this->datatables->add_column('view_kta', '<span class="label label-info"><b>$1</b></span>', 'nik_kta_baru');
            //$this->datatables->add_column('view_button', $this->button_anggota($this->user), 'id_ktp, status_mutasi');
        } elseif (!empty($this->user['id_ref']) && ($this->user['role_admin'] == 1) && !empty($get_label)) {

            $this->datatables->select("p.id_ktp,
                                    p.nik_kta_baru,
                                    p.id_asal,
                                    p.id_admin,
                                    p.id_petugas,
                                    wpasl.nama AS provinsi_asal,                                  
                                    CONCAT(UCASE(wkbasl.nama),' ', UCASE(wkbasl.administratif)) AS kabupaten_asal,
                                    wkasl.nama AS kecamatan_asal,
                                    wdasl.nama AS kelurahan_asal,
                                    wpagt.nama AS provinsi_anggota,
                                    CONCAT(UCASE(wkbagt.nama),' ', UCASE(wkbagt.administratif)) AS kabupaten_anggota,
                                    pt.nama_petugas,
                                    p.nik_ktp,
                                    p.nama_ktp,
                                    UCASE(p.nama_ktp) AS nama_ktp,
                                    CONCAT(UCASE(p.tempat_lahir),', ',p.tanggal_lahir) AS tmp_tgl_lahir,                                
                                    IF(p.jenis_kelamin='1','LAKI-LAKI', 'PEREMPUAN') AS jenis_kelamin,
                                    p.gol_darah,
                                    p.alamat_ktp,
                                    p.agama,
                                    p.status_nikah,
                                    p.pekerjaan,
                                    p.nomor_hp_ktp,
                                    p.img,
                                    p.img_thumb,
                                    p.status_data,
                                    p.status_mutasi,
                                    p.tanggal_post");
            $this->datatables->from('ktp p');
            $this->datatables->join('wilayah_kabupaten wkbagt', 'SUBSTR(p.id_admin, 3, 2) = wkbagt.id AND SUBSTR(p.id_admin, 1, 2) = wkbagt.id_dati1', 'left');
            $this->datatables->join('wilayah_provinsi wpagt', 'SUBSTR(p.id_admin, 1, 2) = wpagt.id', 'left');
            $this->datatables->join('wilayah_desa wdasl', 'SUBSTR(p.id_asal, 7, 2) = wdasl.id AND SUBSTR(p.id_asal, 1, 2) = wdasl.id_dati1 AND SUBSTR(p.id_asal, 3, 2) = wdasl.id_dati2 AND SUBSTR(p.id_asal, 5, 2) = wdasl.id_dati3', 'left');
            $this->datatables->join('wilayah_kecamatan wkasl', 'SUBSTR(p.id_asal, 5, 2) = wkasl.id AND SUBSTR(p.id_asal, 1, 2) = wkasl.id_dati1 AND SUBSTR(p.id_asal, 3, 2) = wkasl.id_dati2', 'left');
            $this->datatables->join('wilayah_kabupaten wkbasl', 'SUBSTR(p.id_asal, 3, 2) = wkbasl.id AND SUBSTR(p.id_asal, 1, 2) = wkbasl.id_dati1', 'left');
            $this->datatables->join('wilayah_provinsi wpasl', 'SUBSTR(p.id_asal, 1, 2) = wpasl.id', 'left');
            $this->datatables->join('petugas pt', "p.id_petugas = pt.id_petugas AND p.id_admin LIKE '" . $this->user['id_ref'] . "%' AND p.status_data = 1 AND pt.status_data = 1 AND pt.id_admin LIKE '" . $this->user['id_ref'] . "%'", 'left');
            $this->datatables->like('p.id_admin', $this->user['id_ref'], 'after');
            $this->datatables->where('p.status_data', '1');
            $this->datatables->where('SUBSTRING(p.id_asal,1,2)', $get_label[0]->provinsi);
            $this->datatables->where_in('SUBSTRING(p.id_asal,1,4)', $string_kab);
            if ($get_label[0]->kecamatan != null or ! empty($get_label[0]->kecamatan) or $get_label[0]->kecamatan != '') {
                $this->datatables->where_in('SUBSTRING(p.id_asal,1,6)', $string_kec);
            }
            $this->datatables->order_by('p.tanggal_post DESC');

            $this->datatables->add_column('view_ktp', '<a href="' . site_url('ktp/detail_ktp/') . '$1"data-toggle="tooltip" data-original-title="Lihat Detail KTP"><span class="label label-warning"><b>$2</b></span></a>', 'id_ktp, nik_ktp');
            $this->datatables->add_column('view_kta', '<span class="label label-info"><b>$1</b></span>', 'nik_kta_baru');
            //$this->datatables->add_column('view_button', $this->button_anggota($this->user), 'id_ktp, status_mutasi');
        } elseif (empty($get_label)) {

            $this->datatables->select("p.id_ktp,
                                    p.nik_kta_baru,
                                    p.id_asal,
                                    p.id_admin,
                                    p.id_petugas,
                                    wpasl.nama AS provinsi_asal,
                                    CONCAT(UCASE(wkbasl.nama),' ', UCASE(wkbasl.administratif)) AS kabupaten_asal,
                                    wkasl.nama AS kecamatan_asal,
                                    wdasl.nama AS kelurahan_asal,
                                    wpagt.nama AS provinsi_anggota,                                   
                                    CONCAT(UCASE(wkbagt.nama),' ', UCASE(wkbagt.administratif)) AS kabupaten_anggota,
                                    pt.nama_petugas,
                                    p.nik_ktp,
                                    p.nama_ktp,
                                    UCASE(p.nama_ktp) AS nama_ktp,
                                    CONCAT(UCASE(p.tempat_lahir),', ',p.tanggal_lahir) AS tmp_tgl_lahir, 
                                    IF(p.jenis_kelamin='1','LAKI-LAKI', 'PEREMPUAN') AS jenis_kelamin,
                                    p.gol_darah,
                                    p.alamat_ktp,
                                    p.agama,
                                    p.status_nikah,
                                    p.pekerjaan,
                                    p.nomor_hp_ktp,
                                    p.img,
                                    p.img_thumb,
                                    p.status_data,
                                    p.status_mutasi,
                                    p.tanggal_post");
            $this->datatables->from('ktp p');
            $this->datatables->join('wilayah_kabupaten wkbagt', 'SUBSTR(p.id_admin, 3, 2) = wkbagt.id AND SUBSTR(p.id_admin, 1, 2) = wkbagt.id_dati1', 'left');
            $this->datatables->join('wilayah_provinsi wpagt', 'SUBSTR(p.id_admin, 1, 2) = wpagt.id', 'left');
            $this->datatables->join('wilayah_desa wdasl', 'SUBSTR(p.id_asal, 7, 2) = wdasl.id AND SUBSTR(p.id_asal, 1, 2) = wdasl.id_dati1 AND SUBSTR(p.id_asal, 3, 2) = wdasl.id_dati2 AND SUBSTR(p.id_asal, 5, 2) = wdasl.id_dati3', 'left');
            $this->datatables->join('wilayah_kecamatan wkasl', 'SUBSTR(p.id_asal, 5, 2) = wkasl.id AND SUBSTR(p.id_asal, 1, 2) = wkasl.id_dati1 AND SUBSTR(p.id_asal, 3, 2) = wkasl.id_dati2', 'left');
            $this->datatables->join('wilayah_kabupaten wkbasl', 'SUBSTR(p.id_asal, 3, 2) = wkbasl.id AND SUBSTR(p.id_asal, 1, 2) = wkbasl.id_dati1', 'left');
            $this->datatables->join('wilayah_provinsi wpasl', 'SUBSTR(p.id_asal, 1, 2) = wpasl.id', 'left');
            $this->datatables->join('petugas pt', "p.id_petugas = pt.id_petugas", 'left');
            $this->datatables->where('p.status_data', '1');
            $this->datatables->where('p.id_asal', 0);
            $this->datatables->order_by('p.tanggal_post DESC');

            $this->datatables->add_column('view_ktp', '<a href="' . site_url('ktp/detail_ktp/') . '$1"data-toggle="tooltip" data-original-title="Lihat Detail KTP"><span class="label label-warning"><b>$2</b></span></a>', 'id_ktp, nik_ktp');
            $this->datatables->add_column('view_kta', '<span class="label label-info"><b>$1</b></span>', 'nik_kta_baru');
        } elseif (($this->user['role_admin'] == 0) && !empty($get_label)) {

            $this->datatables->select("p.id_ktp,
                                    p.nik_kta_baru,
                                    p.id_asal,
                                    p.id_admin,
                                    p.id_petugas,
                                    wpasl.nama AS provinsi_asal,                                 
                                    CONCAT(UCASE(wkbasl.nama),' ', UCASE(wkbasl.administratif)) AS kabupaten_asal,
                                    wkasl.nama AS kecamatan_asal,
                                    wdasl.nama AS kelurahan_asal,
                                    wpagt.nama AS provinsi_anggota,
                                    CONCAT(UCASE(wkbagt.nama),' ', UCASE(wkbagt.administratif)) AS kabupaten_anggota,
                                    pt.nama_petugas,
                                    p.nik_ktp,
                                    p.nama_ktp,
                                    UCASE(p.nama_ktp) AS nama_ktp,
                                    CONCAT(UCASE(p.tempat_lahir),', ',p.tanggal_lahir) AS tmp_tgl_lahir, 
                                    IF(p.jenis_kelamin='1','LAKI-LAKI', 'PEREMPUAN') AS jenis_kelamin,
                                    p.gol_darah,
                                    p.alamat_ktp,
                                    p.agama,
                                    p.status_nikah,
                                    p.pekerjaan,
                                    p.nomor_hp_ktp,
                                    p.img,
                                    p.img_thumb,
                                    p.status_data,
                                    p.status_mutasi,
                                    p.tanggal_post");
            $this->datatables->from('ktp p');
            $this->datatables->join('wilayah_kabupaten wkbagt', 'SUBSTR(p.id_admin, 3, 2) = wkbagt.id AND SUBSTR(p.id_admin, 1, 2) = wkbagt.id_dati1', 'left');
            $this->datatables->join('wilayah_provinsi wpagt', 'SUBSTR(p.id_admin, 1, 2) = wpagt.id', 'left');
            $this->datatables->join('wilayah_desa wdasl', 'SUBSTR(p.id_asal, 7, 2) = wdasl.id AND SUBSTR(p.id_asal, 1, 2) = wdasl.id_dati1 AND SUBSTR(p.id_asal, 3, 2) = wdasl.id_dati2 AND SUBSTR(p.id_asal, 5, 2) = wdasl.id_dati3', 'left');
            $this->datatables->join('wilayah_kecamatan wkasl', 'SUBSTR(p.id_asal, 5, 2) = wkasl.id AND SUBSTR(p.id_asal, 1, 2) = wkasl.id_dati1 AND SUBSTR(p.id_asal, 3, 2) = wkasl.id_dati2', 'left');
            $this->datatables->join('wilayah_kabupaten wkbasl', 'SUBSTR(p.id_asal, 3, 2) = wkbasl.id AND SUBSTR(p.id_asal, 1, 2) = wkbasl.id_dati1', 'left');
            $this->datatables->join('wilayah_provinsi wpasl', 'SUBSTR(p.id_asal, 1, 2) = wpasl.id', 'left');
            $this->datatables->join('petugas pt', "p.id_petugas = pt.id_petugas", 'left');
            $this->datatables->where('p.status_data', '1');
            $this->datatables->where('SUBSTRING(p.id_asal,1,2)', $get_label[0]->provinsi);
            $this->datatables->where_in('SUBSTRING(p.id_asal,1,4)', $string_kab);
            if ($get_label[0]->kecamatan != null or ! empty($get_label[0]->kecamatan) or $get_label[0]->kecamatan != '') {
                $this->datatables->where_in('SUBSTRING(p.id_asal,1,6)', $string_kec);
            }
            $this->datatables->order_by('p.tanggal_post DESC');

            $this->datatables->add_column('view_ktp', '<a href="' . site_url('ktp/detail_ktp/') . '$1"data-toggle="tooltip" data-original-title="Lihat Detail KTP"><span class="label label-warning"><b>$2</b></span></a>', 'id_ktp, nik_ktp');
            $this->datatables->add_column('view_kta', '<span class="label label-info"><b>$1</b></span>', 'nik_kta_baru');
            // $this->datatables->add_column('view_button', $this->button_anggota($this->user), 'id_ktp, status_mutasi');
        }
        return print_r($this->datatables->generate());
    }

    public function button_anggota($usr = '') {

        $get_button = "";

        if ($usr['update_prev'] == 1 or $usr['create_prev'] == 1) {
            $get_button .= '<a target="_blank" href="' . site_url('laporan/cetak_kta_ktp/') . '$1"><button type="button" class="btn btn-warning btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" data-toggle="tooltip" data-original-title="Cetak KTA Anggota"><i class="ti-printer" aria-hidden="true"></i></button></a>';
        } else {
            $get_button .= '<button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" readonly data-toggle="tooltip" data-original-title="Cetak KTA NonAktif (*hub petugas)"><i class="ti-printer" aria-hidden="true"></i></button>';
        }

        return $get_button;
    }

    //-----------------------------------------------ANGGOTA--------------------------------------------------//

    public function format_json() {

        if (!empty($this->user['id_ref']) && ($this->user['role_admin'] == 2)) {

            $this->datatables->select("f.id_format,
                                    f.id_admin,
                                    UCASE(f.nama_alias) AS nama_alias,
                                    f.kecamatan,
                                    wp.nama AS provinsi_nama,
                                    f.kategori_dapil,
                                    f.provinsi,
                                    f.kabupaten,
                                    f.kecamatan,                                                           
                                    f.tanggal_post");
            $this->datatables->from('format_cetak f');
            $this->datatables->join('wilayah_provinsi wp', 'wp.id=f.provinsi', 'left');
            $this->datatables->where_in('f.kabupaten', $this->user['id_ref']);
            $this->datatables->where_in('f.kategori_dapil', 3);
            $this->datatables->order_by('f.tanggal_post DESC');

            $this->datatables->add_column('view_button', $this->button_format($this->user), 'id_format, id_admin, nama_alias');
        } elseif (!empty($this->user['id_ref']) && ($this->user['role_admin'] == 1)) {

            $this->datatables->select("f.id_format,
                                    f.id_admin,
                                    UCASE(f.nama_alias) AS nama_alias,
                                    f.kecamatan,
                                    wp.nama AS provinsi_nama,
                                    f.kategori_dapil,
                                    f.provinsi,
                                    f.kabupaten,
                                    f.kecamatan,                                                           
                                    f.tanggal_post");
            $this->datatables->from('format_cetak f');
            $this->datatables->where('f.provinsi', $this->user['id_ref']);
            $this->datatables->join('wilayah_provinsi wp', 'wp.id=f.provinsi', 'left');
            $this->datatables->order_by('f.tanggal_post DESC');

            $this->datatables->add_column('view_button', $this->button_format($this->user), 'id_format, id_admin, nama_alias');
        } elseif ($this->user['role_admin'] == 0) {

            $this->datatables->select("f.id_format,
                                    f.id_admin,
                                    UCASE(f.nama_alias) AS nama_alias,
                                    f.kecamatan,
                                    wp.nama AS provinsi_nama,
                                    f.kategori_dapil,
                                    f.provinsi,
                                    f.kabupaten,
                                    f.kecamatan,                                                           
                                    f.tanggal_post");
            $this->datatables->from('format_cetak f');
            $this->datatables->join('wilayah_provinsi wp', 'wp.id=f.provinsi', 'left');
            $this->datatables->order_by('f.tanggal_post DESC');

            $this->datatables->add_column('view_button', $this->button_format($this->user), 'id_format, id_admin, nama_alias');
        }
        return print_r($this->datatables->generate());
    }

    public function button_format($usr = '') {

        $get_button = "";

        if ($usr['update_prev'] == 1 or $usr['create_prev'] == 1) {
            $get_button .= '<a href="' . site_url('format/formatcetak/get_format/') . '$1"><button type="button" class="btn btn-info btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" data-toggle="tooltip" data-original-title="Edit Label Pencarian"><i class="ti-pencil" aria-hidden="true"></i></button></a>';
        } else {
            $get_button .= '<button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" readonly data-toggle="tooltip" data-original-title="Edit Label NonAktif (*hub petugas)"><i class="ti-pencil" aria-hidden="true"></i></button>';
        }
        if ($usr['delete_prev'] == 1) {
            $get_button .= '<a onclick="act_del_format($1)" ><button type="button" value="$3" id="$1" class="btn btn-danger btn-sm btn-icon btn-pure btn-outline delete-row-btn  m-l-5" data-toggle="tooltip" data-original-title="Hapus Anggota"><i class="ti-close" aria-hidden="true"></i></button></a>';
        } else {
            $get_button .= '<button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn  m-l-5" readonly data-toggle="tooltip" data-original-title="Hapus KTP NonAktif (*hub petugas)"><i class="ti-close" aria-hidden="true"></i></button>';
        }

        return $get_button;
    }

    //-----------------------------------------------ANGGOTA--------------------------------------------------//

    public function wilayah_pemilihan($id_pemilihan = '', $id_kategori = '', $id_regional_pemilihan = "") {

        if ($id_kategori == 3 || $id_kategori == 6) {

            $this->datatables->select("CONCAT(wkl.id_dati1,'',wkl.id_dati2,'', wkl.id_dati3,'',wkl.id) AS id_wilayah,    
                                    wkl.id_dati1,
                                    wkl.id_dati2,
                                    wkl.id_dati3,
                                    wkl.id,
                                    wp.nama AS provinsi,                                   
                                    CONCAT(UCASE(wkb.nama),' ', UCASE(wkb.administratif)) AS kabupaten,
                                    wkc.nama AS kecamatan,
                                    wkl.nama AS kelurahan,
                                     (
                                    SELECT
                                        COUNT(id_tps)
                                    FROM
                                        tps
                                    WHERE
                                        id_wilayah_pemilihan = CONCAT(wkl.id_dati1,'',wkl.id_dati2,'', wkl.id_dati3,'',wkl.id) AND status_data = 1  AND id_pemilihan = '$id_pemilihan'
                                    ) AS jumlah_tps,
                                     (
                                    SELECT
                                        COUNT(id_saksi)
                                    FROM
                                        saksi
                                    WHERE
                                        id_wilayah_pemilihan = CONCAT(wkl.id_dati1,'',wkl.id_dati2,'', wkl.id_dati3,'',wkl.id) AND status_data = 1 AND id_pemilihan = '$id_pemilihan'
                                    ) AS jumlah_saksi,
                                    (
                                    SELECT 
                                        SUM(sc.suara_sah) AS total_suara
                                    FROM suara_calon sc
                                    LEFT JOIN calon_pemilihan cp ON
                                        cp.id_calon_pemilihan=sc.id_calon_pemilihan                               
                                    WHERE 
                                        sc.id_wilayah_pemilihan=CONCAT(wkl.id_dati1,'',wkl.id_dati2,'', wkl.id_dati3,'',wkl.id) AND cp.status_calon=1 AND sc.id_pemilihan = '$id_pemilihan'  
                                    GROUP BY (sc.id_calon_pemilihan)
                                    ) AS total_suara");
            $this->datatables->from('wilayah_desa wkl');
            $this->datatables->join('wilayah_provinsi wp', 'wp.id = wkl.id_dati1', 'left');
            $this->datatables->join('wilayah_kabupaten wkb', 'wkb.id = wkl.id_dati2 AND wkb.id_dati1 = wkl.id_dati1', 'left');
            $this->datatables->join('wilayah_kecamatan wkc', 'wkc.id = wkl.id_dati3 AND wkc.id_dati2 = wkl.id_dati2 AND wkc.id_dati1 = wkl.id_dati1', 'left');
            $this->datatables->where('wkc.id_dati1', substr($id_regional_pemilihan, 0, 2));

            $this->datatables->order_by('wp.nama ASC');

            $this->datatables->add_column('view_button', $this->button_wilayah($id_pemilihan), 'id_wilayah');
        } elseif ($id_kategori == 1 || $id_kategori == 2) {

            $this->datatables->select("CONCAT(wkl.id_dati1,'',wkl.id_dati2,'', wkl.id_dati3,'',wkl.id) AS id_wilayah,    
                                    wkl.id_dati1,
                                    wkl.id_dati2,
                                    wkl.id_dati3,
                                    wkl.id,
                                    wp.nama AS provinsi,
                                    CONCAT(UCASE(wkb.nama),' ', UCASE(wkb.administratif)) AS kabupaten,
                                    wkc.nama AS kecamatan,
                                    wkl.nama AS kelurahan,
                                     (
                                    SELECT
                                        COUNT(id_tps)
                                    FROM
                                        tps
                                    WHERE
                                        id_wilayah_pemilihan = CONCAT(wkl.id_dati1,'',wkl.id_dati2,'', wkl.id_dati3,'',wkl.id) AND status_data = 1 AND id_pemilihan = '$id_pemilihan'
                                    ) AS jumlah_tps,
                                     (
                                    SELECT
                                        COUNT(id_saksi)
                                    FROM
                                        saksi
                                    WHERE
                                        id_wilayah_pemilihan = CONCAT(wkl.id_dati1,'',wkl.id_dati2,'', wkl.id_dati3,'',wkl.id) AND status_data = 1 AND id_pemilihan = '$id_pemilihan'
                                    ) AS jumlah_saksi,
                                    (
                                    SELECT 
                                        SUM(sc.suara_sah) AS total_suara
                                    FROM suara_calon sc
                                    LEFT JOIN calon_pemilihan cp ON
                                        cp.id_calon_pemilihan=sc.id_calon_pemilihan                               
                                    WHERE 
                                        sc.id_wilayah_pemilihan=CONCAT(wkl.id_dati1,'',wkl.id_dati2,'', wkl.id_dati3,'',wkl.id) AND cp.status_calon=1  AND sc.id_pemilihan = '$id_pemilihan'
                                    GROUP BY (sc.id_calon_pemilihan)
                                    ) AS total_suara");
            $this->datatables->from('wilayah_desa wkl');
            $this->datatables->join('wilayah_provinsi wp', 'wp.id = wkl.id_dati1', 'left');
            $this->datatables->join('wilayah_kabupaten wkb', 'wkb.id = wkl.id_dati2 AND wkb.id_dati1 = wkl.id_dati1', 'left');
            $this->datatables->join('wilayah_kecamatan wkc', 'wkc.id = wkl.id_dati3 AND wkc.id_dati2 = wkl.id_dati2 AND wkc.id_dati1 = wkl.id_dati1', 'left');

            $this->datatables->order_by('wp.nama ASC');

            $this->datatables->add_column('view_button', $this->button_wilayah($id_pemilihan), 'id_wilayah');
        } else {

            $this->datatables->select("CONCAT(wkl.id_dati1,'',wkl.id_dati2,'', wkl.id_dati3,'',wkl.id) AS id_wilayah,    
                                    wkl.id_dati1,
                                    wkl.id_dati2,
                                    wkl.id_dati3,
                                    wkl.id,
                                    wp.nama AS provinsi,
                                    CONCAT(UCASE(wkb.nama),' ', UCASE(wkb.administratif)) AS kabupaten,
                                    wkc.nama AS kecamatan,
                                    wkl.nama AS kelurahan,
                                     (
                                    SELECT
                                        COUNT(id_tps)
                                    FROM
                                        tps
                                    WHERE
                                        id_wilayah_pemilihan = CONCAT(wkl.id_dati1,'',wkl.id_dati2,'', wkl.id_dati3,'',wkl.id) AND status_data = 1 AND id_pemilihan = '$id_pemilihan'
                                    ) AS jumlah_tps,
                                     (
                                    SELECT
                                        COUNT(id_saksi)
                                    FROM
                                        saksi
                                    WHERE
                                        id_wilayah_pemilihan = CONCAT(wkl.id_dati1,'',wkl.id_dati2,'', wkl.id_dati3,'',wkl.id) AND status_data = 1 AND id_pemilihan = '$id_pemilihan'
                                    ) AS jumlah_saksi,
                                    (
                                    SELECT 
                                        SUM(sc.suara_sah) AS total_suara
                                    FROM suara_calon sc
                                    LEFT JOIN calon_pemilihan cp ON
                                        cp.id_calon_pemilihan=sc.id_calon_pemilihan                               
                                    WHERE 
                                        sc.id_wilayah_pemilihan=CONCAT(wkl.id_dati1,'',wkl.id_dati2,'', wkl.id_dati3,'',wkl.id) AND cp.status_calon = 1 AND sc.id_pemilihan = '$id_pemilihan'
                                    GROUP BY (sc.id_calon_pemilihan)
                                    ) AS total_suara");
            $this->datatables->from('wilayah_desa wkl');
            $this->datatables->join('wilayah_provinsi wp', 'wp.id = wkl.id_dati1', 'left');
            $this->datatables->join('wilayah_kabupaten wkb', 'wkb.id = wkl.id_dati2 AND wkb.id_dati1 = wkl.id_dati1', 'left');
            $this->datatables->join('wilayah_kecamatan wkc', 'wkc.id = wkl.id_dati3 AND wkc.id_dati2 = wkl.id_dati2 AND wkc.id_dati1 = wkl.id_dati1', 'left');
            $this->datatables->where('wkc.id_dati1', substr($id_regional_pemilihan, 0, 2));
            $this->datatables->where('wkc.id_dati2', substr($id_regional_pemilihan, 2, 2));

            $this->datatables->order_by('wp.nama ASC');

            $this->datatables->add_column('view_button', $this->button_wilayah($id_pemilihan), 'id_wilayah');
        }
        return print_r($this->datatables->generate());
    }

    public function button_wilayah($id_pemilihan = '') {
        $get_button = "";

        $get_button .= '<a href="' . site_url('pemilihan/daftar_tps_petugas/') . '$1/' . $id_pemilihan . '"><button type="button" class="btn btn-warning btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" data-toggle="tooltip" data-original-title="Lihat TPS & Petugas"><i class="ti-eye" aria-hidden="true"></i></button></a>';

        return $get_button;
    }

    public function daftar_tps($id_pemilihan = '', $id_wilayah_pemilihan = '') {

        $this->datatables->select("t.id_tps,
                                    t.id_pemilihan,
                                    t.id_admin,
                                    t.id_wilayah_pemilihan,
                                    t.id_petugas_saksi,
                                    t.status_formulir_c1,
                                    t.nomor_tps,
                                    UCASE(t.nama_tps) AS nama_tps,                                   
                                    t.tanggal_post,
                                    t.status_data,
                                    (
                                    SELECT 
                                        sc.suara_sah
                                    FROM suara_calon sc
                                    LEFT JOIN calon_pemilihan cp ON
                                            cp.id_calon_pemilihan=sc.id_calon_pemilihan 
                                    WHERE sc.id_tps=t.id_tps AND cp.status_calon=1
                                    ) AS total_suara");
        $this->datatables->from('tps t');
        $this->datatables->where('id_pemilihan', $id_pemilihan);
        $this->datatables->where('id_wilayah_pemilihan', $id_wilayah_pemilihan);
        $this->datatables->where('status_data', 1);
        $this->datatables->order_by('tanggal_post DESC');

        $this->datatables->add_column('view_button', $this->button_tps($this->user, $id_pemilihan, $id_wilayah_pemilihan), 'id_tps, id_admin, nama_tps, nomor_tps');

        return print_r($this->datatables->generate());
    }

    public function button_tps($usr = '', $id_pemilihan = '', $id_wilayah_pemilihan = '') {

        $get_button = "";

        if ($usr['delete_prev'] == 1) {
            $get_button .= '<a onclick="act_del_tps($1)" ><button type="button" value="$3 $4" id="$1" class="btn btn-danger btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" data-toggle="tooltip" data-original-title="Hapus TPS"><i class="ti-close" aria-hidden="true"></i></button></a>';
        } else {
            $get_button .= '<button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" readonly data-toggle="tooltip" data-original-title="Hapus TPS NonAktif (*hub petugas)"><i class="ti-close" aria-hidden="true"></i></button>';
        }

        if ($usr['update_prev'] == 1) {
            $get_button .= '<a href="' . site_url('pemilihan/get_tps/') . '$1/' . $id_pemilihan . '/' . $id_wilayah_pemilihan . '" ><button type="button" data-toggle="tooltip" class="btn btn-info btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" data-original-title="Edit TPS"><i class="ti-pencil" aria-hidden="true"></i></button></a>';
        } else {
            $get_button .= '<button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" readonly data-toggle="tooltip" data-original-title="Edit TPS NonAktif (*hub petugas)"><i class="ti-pencil" aria-hidden="true"></i></button>';
        }

        $get_button .= '<a href="' . site_url('pemilihan/hasil_pemilihan_suara/') . '$1/' . $id_pemilihan . '/' . $id_wilayah_pemilihan . '"><button type="button" class="btn btn-warning btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" data-toggle="tooltip" data-original-title="Lihat Hasil Pemilihan"><i class="ti-eye" aria-hidden="true"></i></button></a>';

        return $get_button;
    }

    public function daftar_saksi($id_pemilihan = '') {

        $this->datatables->select(" s.id_saksi,
                                    s.id_pemilihan,
                                    s.id_admin,
                                    s.id_wilayah_pemilihan,
                                    s.nomor_ktp_saksi,
                                    s.email_saksi,
                                    s.password_saksi,
                                    UCASE(s.nama_saksi) AS nama_saksi,
                                    s.nomor_hp_saksi,
                                    s.tanggal_post,
                                    s.status_data");
        $this->datatables->from('saksi s');
        $this->datatables->where('id_pemilihan', $id_pemilihan);
        $this->datatables->where('status_data', 1);
        $this->datatables->order_by('tanggal_post DESC');

        $this->datatables->add_column('view_button', $this->button_saksi($this->user, $id_pemilihan), 'id_saksi, id_admin, nama_saksi ');

        return print_r($this->datatables->generate());
    }

    public function button_saksi($usr = '', $id_pemilihan = '') {

        $get_button = "";

        if ($usr['delete_prev'] == 1) {
            $get_button .= '<a onclick="act_del_saksi($1)" ><button type="button" value="$3" id="$1" class="btn btn-danger btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" data-toggle="tooltip" data-original-title="Hapus Petugas Saksi"><i class="ti-close" aria-hidden="true"></i></button></a>';
        } else {
            $get_button .= '<button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" readonly data-toggle="tooltip" data-original-title="Hapus Petugas Saksi NonAktif (*hub petugas)"><i class="ti-close" aria-hidden="true"></i></button>';
        }
        if ($usr['update_prev'] == 1 or $usr['create_prev'] == 1) {
            $get_button .= '<a target="_blank" href="' . site_url('laporan/laporanpemilihan/cetak_kartu_mandat/') . '$1/' . $id_pemilihan . '"><button type="button" class="btn btn-warning btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" data-toggle="tooltip" data-original-title="Cetak Kartu Mandat"><i class="ti-printer" aria-hidden="true"></i></button></a>';
        } else {
            $get_button .= '<button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" readonly data-toggle="tooltip" data-original-title="Cetak Kartu Mandat NonAktif (*hub petugas)"><i class="ti-printer" aria-hidden="true"></i></button>';
        }
        if ($usr['update_prev'] == 1) {
            $get_button .= '<a href="' . site_url('pemilihan/get_petugas_saksi/') . '$1/' . $id_pemilihan . '" ><button type="button" data-toggle="tooltip" class="btn btn-info btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" data-original-title="Edit Petugas Saksi"><i class="ti-pencil" aria-hidden="true"></i></button></a>';
        } else {
            $get_button .= '<button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn m-l-5" readonly data-toggle="tooltip" data-original-title="Edit Petugas Saksi NonAktif (*hub petugas)"><i class="ti-pencil" aria-hidden="true"></i></button>';
        }

        return $get_button;
    }

}
