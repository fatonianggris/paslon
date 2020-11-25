<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Ktp extends MX_Controller {

    public function __construct() {
        parent::__construct();
        //Do your magic here
        if ($this->session->userdata('ktpapps') == FALSE) {
            redirect('auth');
        }
        $this->load->model('Ktpmodel');
        $this->load->library('datatables');
        $this->user = $this->session->userdata("ktpapps");
    }

    //---------------------------------------DAFTAR LIST ANGGOTA/KTP---------------------------------------//
    public function index() {

        $data['count'] = $this->Ktpmodel->get_count($this->user['id_ref'], $this->user['role_admin']);
        $data['admin_regional'] = $this->Ktpmodel->get_admin_regional($this->user['id_ref'], $this->user['role_admin']);
        $data['admin_mutasi'] = $this->Ktpmodel->get_admin_mutasi($this->user['id_ref'], $this->user['role_admin']);
        $data['petugas'] = $this->Ktpmodel->get_petugas($this->user['id_ref'], $this->user['role_admin']);
        $data['kec'] = $this->Ktpmodel->get_kecamatan(); //?
        $data['kel'] = $this->Ktpmodel->get_kelurahan(); //?
        $data['prov'] = $this->Ktpmodel->get_provinsi(); //?
        $data['kab'] = $this->Ktpmodel->get_kabupaten(); //?
        $this->template->load('template_admin/template_admin', 'daftar_ktp', $data);
    }

    public function lihat_ktp_admin($id = '') {

        $data['admin'] = $this->Ktpmodel->get_admin_by_id($id);
        $data['count'] = $this->Ktpmodel->get_admin_count($id);
        $data['prov'] = $this->Ktpmodel->get_provinsi(); //?
        $data['kab'] = $this->Ktpmodel->get_kabupaten(); //?
        $data['kec'] = $this->Ktpmodel->get_kecamatan(); //?
        $data['kel'] = $this->Ktpmodel->get_kelurahan(); //?
        $data['admin_regional'] = $this->Ktpmodel->get_admin_regional($this->user['id_ref'], $this->user['role_admin']);
        $data['admin_mutasi'] = $this->Ktpmodel->get_admin_mutasi($this->user['id_ref'], $this->user['role_admin']);
        $data['petugas'] = $this->Ktpmodel->get_petugas($this->user['id_ref'], $this->user['role_admin']);
        $this->template->load('template_admin/template_admin', 'lihat_ktp_admin', $data);
    }

    public function lihat_ktp_pet($id = '') {

        $data['pet'] = $this->Ktpmodel->get_by_id_pet($id, $this->user['id_ref'], $this->user['role_admin']);
        $data['count'] = $this->Ktpmodel->get_count_pet($id, $this->user['id_ref'], $this->user['role_admin']);
        $data['petugas'] = $this->Ktpmodel->get_petugas($this->user['id_ref'], $this->user['role_admin']);
        $data['admin_regional'] = $this->Ktpmodel->get_admin_regional($this->user['id_ref'], $this->user['role_admin']);
        $data['admin_mutasi'] = $this->Ktpmodel->get_admin_mutasi($this->user['id_ref'], $this->user['role_admin']);
        $data['kec'] = $this->Ktpmodel->get_kecamatan(); //?
        $data['kel'] = $this->Ktpmodel->get_kelurahan(); //?
        $data['prov'] = $this->Ktpmodel->get_provinsi(); //?
        $data['kab'] = $this->Ktpmodel->get_kabupaten(); //?
        $cek = $this->Ktpmodel->get_by_id_pet($id, $this->user['id_ref'], $this->user['role_admin']);

        if ($cek == FALSE or empty($id)) {
            $data = array();
            $this->load->view('error_404', $data);
        } else {
            //edit data with id
            $this->template->load('template_admin/template_admin', 'lihat_ktp_pet', $data);
        }
    }

    //---------------------------------------DETAIL ANGGOTA KTP---------------------------------------//
    public function detail_ktp($id) {

        $data['detail'] = $this->Ktpmodel->get_detail_ktp($id, $this->user['id_ref'], $this->user['role_admin']);
        $data['kec'] = $this->Ktpmodel->get_kecamatan(); //?
        $data['kel'] = $this->Ktpmodel->get_kelurahan(); //?
        $data['prov'] = $this->Ktpmodel->get_provinsi(); //?
        $data['kab'] = $this->Ktpmodel->get_kabupaten(); //?
        $data['pekerjaan'] = $this->Ktpmodel->get_pekerjaan();

        $cek = $this->Ktpmodel->get_by_id_ktp($id, $this->user['id_ref'], $this->user['role_admin']);
        if ($cek == FALSE or empty($id)) {
            $data = array();
            $this->load->view('error_404', $data);
        } else {

            $this->template->load('template_admin/template_admin', 'detail_ktp', $data);
        }
    }

    //---------------------------------------TAMBAH ANGGOTA KTP---------------------------------------//

    public function tambah_ktp() {

        $data['provinsi'] = $this->Ktpmodel->get_provinsi(); //?
        $data['pekerjaan'] = $this->Ktpmodel->get_pekerjaan();
        $data['kab'] = $this->Ktpmodel->get_kabupaten(); //?
        $data['admin_regional'] = $this->Ktpmodel->get_admin_regional($this->user['id_ref'], $this->user['role_admin']);
        $data['petugas'] = $this->Ktpmodel->get_petugas($this->user['id_ref'], $this->user['role_admin']);
        $this->template->load('template_admin/template_admin', 'tambah_ktp', $data);
    }

    public function tambah_ktp_pet($id = '') {

        $data['provinsi'] = $this->Ktpmodel->get_provinsi(); //?
        $data['kab'] = $this->Ktpmodel->get_kabupaten(); //?
        $data['pekerjaan'] = $this->Ktpmodel->get_pekerjaan();
        $data['pet'] = $this->Ktpmodel->get_by_id_pet($id, $this->user['id_ref'], $this->user['role_admin']);
        $data['petugas'] = $this->Ktpmodel->get_petugas($this->user['id_ref'], $this->user['role_admin']);
        $data['admin_regional'] = $this->Ktpmodel->get_admin_regional($this->user['id_ref'], $this->user['role_admin']);
        $this->template->load('template_admin/template_admin', 'tambah_ktp_pet', $data);
    }

    public function tambah_ktp_admin($id = '') {

        $data['provinsi'] = $this->Ktpmodel->get_provinsi(); //?
        $data['kab'] = $this->Ktpmodel->get_kabupaten(); //?
        $data['pekerjaan'] = $this->Ktpmodel->get_pekerjaan();
        $data['admin'] = $this->Ktpmodel->get_by_id_admin($id);
        $this->template->load('template_admin/template_admin', 'tambah_ktp_admin', $data);
    }

    function add_ajax_petugas($id_regional = '') {
        $data = "";
        if ($id_regional == 34) {
            $data .= "<option value=''>Pilih nama petugas</option>";
        }
        $query = $this->Ktpmodel->get_petugas_reg($id_regional, $this->user['id_ref'], $this->user['role_admin']);

        foreach ($query as $value) {
            $data .= "<option value='" . $value->id_petugas . "'>" . ucwords($value->nama_petugas) . "</option>";
        }
        echo $data;
    }

    //---------------------------------------IMPORT DATA ANGGOTA KTP---------------------------------------//

    public function upload_csv() {
        $this->load->library('form_validation');
        // Load form validation library
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);
        $this->form_validation->set_rules('region_anggota', 'Region e-KTP', 'required');
        $this->form_validation->set_rules('nama_petugas', 'Nama Petugas Pemungutan', 'required');
        $kerja = $this->Ktpmodel->get_pekerjaan();

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('ktp/'); //folder, controller, method
        } else {
            // If file uploaded
            $file_mimes = array('text/x-comma-separated-values',
                'text/comma-separated-values',
                'application/octet-stream',
                'application/vnd.ms-excel',
                'application/x-csv',
                'text/x-csv',
                'text/csv',
                'application/csv',
                'application/excel',
                'application/vnd.msexcel',
                'text/plain',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            );
            if (isset($_FILES['csv']['name'])) {
                $arr_file = explode('.', $_FILES['csv']['name']);
                $extension = end($arr_file);
                if (($extension == 'xlsx' || $extension == 'xls' || $extension == 'csv') && in_array($_FILES['csv']['type'], $file_mimes)) {
                    if (!empty($_FILES['csv']['name'])) {
                        // get file extension
                        $extension = pathinfo($_FILES['csv']['name'], PATHINFO_EXTENSION);

                        if ($extension == 'csv') {
                            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                        } elseif ($extension == 'xlsx') {
                            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                        } else {
                            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                        }
                        // file path
                        $spreadsheet = $reader->load($_FILES['csv']['tmp_name']);
                        $allDataInSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

                        // array Count
                        $arrayCount = count($allDataInSheet);

                        $flag = 0;
                        $createArray = array('nik_ktp', 'nama_ktp', 'tempat_lahir', 'tanggal_lahir',
                            'jenis_kelamin', 'gol_darah', 'alamat_ktp', 'rt', 'rw', 'agama', 'status_nikah',
                            'pekerjaan', 'nomor_hp');
                        $makeArray = array('nik_ktp' => 'nik_ktp',
                            'nama_ktp' => 'nama_ktp', 'tempat_lahir' => 'tempat_lahir', 'tanggal_lahir' => 'tanggal_lahir',
                            'jenis_kelamin' => 'jenis_kelamin', 'gol_darah' => 'gol_darah', 'alamat_ktp' => 'alamat_ktp',
                            'agama' => 'agama', 'rt' => 'rt', 'rw' => 'rw', 'status_nikah' => 'status_nikah', 'pekerjaan' => 'pekerjaan',
                            'nomor_hp' => 'nomor_hp');
                        $SheetDataKey = array();

                        foreach ($allDataInSheet as $dataInSheet) {
                            foreach ($dataInSheet as $key => $value) {
                                if (in_array(trim($value), $createArray)) {
                                    $value = preg_replace('/\s+/', '', $value);
                                    $SheetDataKey[trim($value)] = $key;
                                }
                            }
                        }

                        $dataDiff = array_diff_key($makeArray, $SheetDataKey);

                        if (empty($dataDiff)) {
                            $flag = 1;
                        }
                        // match excel sheet column
                        if ($flag == 1) {
                            for ($i = 2; $i <= $arrayCount; $i++) {
                                $id_admin = $this->user['id_ref'];
                                $id_regional = $data['region_anggota'];
                                $id_petugas = $data['nama_petugas'];
                                $nik_ktp = $SheetDataKey['nik_ktp'];
                                $nama_ktp = $SheetDataKey['nama_ktp'];
                                $tempat_lahir = $SheetDataKey['tempat_lahir'];
                                $tanggal_lahir = $SheetDataKey['tanggal_lahir'];
                                $jenis_kelamin = $SheetDataKey['jenis_kelamin'];
                                $gol_darah = $SheetDataKey['gol_darah'];
                                $alamat_ktp = $SheetDataKey['alamat_ktp'];
                                $rt = $SheetDataKey['rt'];
                                $rw = $SheetDataKey['rw'];
                                $agama = $SheetDataKey['agama'];
                                $status_nikah = $SheetDataKey['status_nikah'];
                                $pekerjaan = $SheetDataKey['pekerjaan'];
                                $nomor_hp = $SheetDataKey['nomor_hp'];

//                        $id_admin = filter_var(trim($allDataInSheet[$i][$id_admin]), FILTER_SANITIZE_STRING);
//                        $id_regional = filter_var(trim($allDataInSheet[$i][$id_regional]), FILTER_SANITIZE_STRING);
                                $nik_ktp = strtolower(filter_var(trim($allDataInSheet[$i][$nik_ktp]), FILTER_SANITIZE_STRING));
                                $nama_ktp = strtolower(filter_var(trim($allDataInSheet[$i][$nama_ktp]), FILTER_SANITIZE_STRING));
                                $tempat_lahir = strtolower(filter_var(trim($allDataInSheet[$i][$tempat_lahir]), FILTER_SANITIZE_STRING));
                                $tanggal_lahir = strtolower(filter_var(trim($allDataInSheet[$i][$tanggal_lahir]), FILTER_SANITIZE_STRING));
                                $jenis_kelamin = strtolower(filter_var(trim($allDataInSheet[$i][$jenis_kelamin]), FILTER_SANITIZE_STRING));
                                $gol_darah = strtolower(filter_var(trim($allDataInSheet[$i][$gol_darah]), FILTER_SANITIZE_STRING));
                                $alamat_ktp = strtolower(filter_var(trim($allDataInSheet[$i][$alamat_ktp]), FILTER_SANITIZE_STRING));
                                $rt = strtolower(filter_var(trim($allDataInSheet[$i][$rt]), FILTER_SANITIZE_STRING));
                                $rw = strtolower(filter_var(trim($allDataInSheet[$i][$rw]), FILTER_SANITIZE_STRING));
                                $agama = strtolower(filter_var(trim($allDataInSheet[$i][$agama]), FILTER_SANITIZE_STRING));
                                $status_nikah = strtolower(filter_var(trim($allDataInSheet[$i][$status_nikah]), FILTER_SANITIZE_STRING));
                                $pekerjaan = strtolower(filter_var(trim($allDataInSheet[$i][$pekerjaan]), FILTER_SANITIZE_STRING));
                                $nomor_hp = strtolower(filter_var(trim($allDataInSheet[$i][$nomor_hp]), FILTER_SANITIZE_STRING));

                                $id_jenis_kelamin = '';
                                $id_gol_darah = '';
                                $id_agama = '';
                                $id_status_nikah = '';

                                if ($jenis_kelamin == 'laki-laki') {
                                    $id_jenis_kelamin = 1;
                                } elseif ($jenis_kelamin == 'perempuan') {
                                    $id_jenis_kelamin = 0;
                                }

                                if ($gol_darah == 'a') {
                                    $id_gol_darah = 1;
                                } elseif ($gol_darah == 'b') {
                                    $id_gol_darah = 2;
                                } elseif ($gol_darah == 'ab') {
                                    $id_gol_darah = 3;
                                } elseif ($gol_darah == 'o') {
                                    $id_gol_darah = 4;
                                } else {
                                    $id_gol_darah = 5;
                                }

                                if ($agama == 'islam') {
                                    $id_agama = 1;
                                } elseif ($agama == 'kristen') {
                                    $id_agama = 2;
                                } elseif ($agama == 'hindu') {
                                    $id_agama = 3;
                                } elseif ($agama == 'budha') {
                                    $id_agama = 4;
                                } else {
                                    $id_agama = 5;
                                }

                                if ($status_nikah == 'belum menikah') {
                                    $id_status_nikah = 0;
                                } elseif ($status_nikah == 'menikah') {
                                    $id_status_nikah = 1;
                                } elseif ($status_nikah == 'cerai hidup') {
                                    $id_status_nikah = 2;
                                } elseif ($status_nikah == 'cerai mati') {
                                    $id_status_nikah = 3;
                                }

                                if (!empty($pekerjaan)) {
                                    foreach ($kerja as $key => $value) {
                                        if (strtolower($pekerjaan) == strtolower($value->job)) {
                                            $pekerjaan = $value->id;
                                        } else {
                                            $pekerjaan = 13;
                                        }
                                    }
                                }

                                $fetchData[] = array('id_admin' => $id_admin, 'id_regional' => $id_regional, 'id_petugas' => $id_petugas,
                                    'nik_ktp' => $nik_ktp,
                                    'nama_ktp' => $nama_ktp, 'tempat_lahir' => $tempat_lahir, 'tanggal_lahir' => $tanggal_lahir,
                                    'jenis_kelamin' => $id_jenis_kelamin, 'gol_darah' => $id_gol_darah, 'alamat_ktp' => $alamat_ktp,
                                    'rt' => $rt, 'rw' => $rw, 'agama' => $id_agama, 'status_nikah' => $id_status_nikah, 'pekerjaan' => $pekerjaan,
                                    'nomor_hp_ktp' => $nomor_hp);
                            }
                            $data['dataInfo'] = $fetchData;
                            $this->Ktpmodel->setBatchImport($fetchData);
                            $this->Ktpmodel->importData();
                        } else {
                            $this->session->set_flashdata('flash_message', err_msg('Maaf, Silahkan Import file dengan benar, kolom csv anda belum sesuai'));
                            redirect('ktp/');
                        }
                        $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Import Data Telah Tersimpan..'));
                        redirect('ktp/');
                    }
                } else {

                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Silahkan Import file berformat .csv'));
                    redirect('ktp/');
                }
            } else {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Silahkan pilih file .csv terlebih dahulu'));
                redirect('ktp/');
                return false;
            }
        }
    }

    public function upload_csv_pet($id = '') {
// Load form validation library
        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);
        $this->form_validation->set_rules('region_anggota', 'Nama Alias Regional', 'required');
        $id_admin = $this->Ktpmodel->get_by_id_admin_reg($data['region_anggota']);
        $kerja = $this->Ktpmodel->get_pekerjaan();

        if (empty($id)) {
            $this->session->set_flashdata('flash_message', warn_msg('ID regional tidak ditemukan'));
            redirect('ktp/lihat_ktp_pet/' . $id); //folder, controller, method
        } else {
// If file uploaded

            $file_mimes = array('text/x-comma-separated-values',
                'text/comma-separated-values',
                'application/octet-stream',
                'application/vnd.ms-excel',
                'application/x-csv',
                'text/x-csv',
                'text/csv',
                'application/csv',
                'application/excel',
                'application/vnd.msexcel',
                'text/plain',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            );
            if (isset($_FILES['csv']['name'])) {
                $arr_file = explode('.', $_FILES['csv']['name']);
                $extension = end($arr_file);
                if (($extension == 'xlsx' || $extension == 'xls' || $extension == 'csv') && in_array($_FILES['csv']['type'], $file_mimes)) {
                    if (!empty($_FILES['csv']['name'])) {
// get file extension
                        $extension = pathinfo($_FILES['csv']['name'], PATHINFO_EXTENSION);

                        if ($extension == 'csv') {
                            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                        } elseif ($extension == 'xlsx') {
                            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                        } else {
                            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                        }
// file path
                        $spreadsheet = $reader->load($_FILES['csv']['tmp_name']);
                        $allDataInSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

// array Count
                        $arrayCount = count($allDataInSheet);

                        $flag = 0;
                        $createArray = array('nik_ktp', 'nama_ktp', 'tempat_lahir', 'tanggal_lahir',
                            'jenis_kelamin', 'gol_darah', 'alamat_ktp', 'rt', 'rw', 'agama', 'status_nikah',
                            'pekerjaan', 'nomor_hp');
                        $makeArray = array('nik_ktp' => 'nik_ktp', 'nama_ktp' => 'nama_ktp', 'tempat_lahir' => 'tempat_lahir', 'tanggal_lahir' => 'tanggal_lahir',
                            'jenis_kelamin' => 'jenis_kelamin', 'gol_darah' => 'gol_darah', 'alamat_ktp' => 'alamat_ktp',
                            'agama' => 'agama', 'rt' => 'rt', 'rw' => 'rw', 'status_nikah' => 'status_nikah', 'pekerjaan' => 'pekerjaan',
                            'nomor_hp' => 'nomor_hp');
                        $SheetDataKey = array();

                        foreach ($allDataInSheet as $dataInSheet) {
                            foreach ($dataInSheet as $key => $value) {
                                if (in_array(trim($value), $createArray)) {
                                    $value = preg_replace('/\s+/', '', $value);
                                    $SheetDataKey[trim($value)] = $key;
                                }
                            }
                        }

                        $dataDiff = array_diff_key($makeArray, $SheetDataKey);

                        if (empty($dataDiff)) {
                            $flag = 1;
                        }
// match excel sheet column
                        if ($flag == 1) {
                            for ($i = 2; $i <= $arrayCount; $i++) {
                                $id_admin = $this->user['id_ref'];
                                $id_regional = $data['region_anggota'];
                                $id_petugas = $id;
                                $nik_ktp = $SheetDataKey['nik_ktp'];
                                $nama_ktp = $SheetDataKey['nama_ktp'];
                                $tempat_lahir = $SheetDataKey['tempat_lahir'];
                                $tanggal_lahir = $SheetDataKey['tanggal_lahir'];
                                $jenis_kelamin = $SheetDataKey['jenis_kelamin'];
                                $gol_darah = $SheetDataKey['gol_darah'];
                                $alamat_ktp = $SheetDataKey['alamat_ktp'];
                                $rt = $SheetDataKey['rt'];
                                $rw = $SheetDataKey['rw'];
                                $agama = $SheetDataKey['agama'];
                                $status_nikah = $SheetDataKey['status_nikah'];
                                $pekerjaan = $SheetDataKey['pekerjaan'];
                                $nomor_hp = $SheetDataKey['nomor_hp'];

//                        $id_admin = filter_var(trim($allDataInSheet[$i][$id_admin]), FILTER_SANITIZE_STRING);
//                        $id_regional = filter_var(trim($allDataInSheet[$i][$id_regional]), FILTER_SANITIZE_STRING);
                                $nik_ktp = strtolower(filter_var(trim($allDataInSheet[$i][$nik_ktp]), FILTER_SANITIZE_STRING));
                                $nama_ktp = strtolower(filter_var(trim($allDataInSheet[$i][$nama_ktp]), FILTER_SANITIZE_STRING));
                                $tempat_lahir = strtolower(filter_var(trim($allDataInSheet[$i][$tempat_lahir]), FILTER_SANITIZE_STRING));
                                $tanggal_lahir = strtolower(filter_var(trim($allDataInSheet[$i][$tanggal_lahir]), FILTER_SANITIZE_STRING));
                                $jenis_kelamin = strtolower(filter_var(trim($allDataInSheet[$i][$jenis_kelamin]), FILTER_SANITIZE_STRING));
                                $gol_darah = strtolower(filter_var(trim($allDataInSheet[$i][$gol_darah]), FILTER_SANITIZE_STRING));
                                $alamat_ktp = strtolower(filter_var(trim($allDataInSheet[$i][$alamat_ktp]), FILTER_SANITIZE_STRING));
                                $rt = strtolower(filter_var(trim($allDataInSheet[$i][$rt]), FILTER_SANITIZE_STRING));
                                $rw = strtolower(filter_var(trim($allDataInSheet[$i][$rw]), FILTER_SANITIZE_STRING));
                                $agama = strtolower(filter_var(trim($allDataInSheet[$i][$agama]), FILTER_SANITIZE_STRING));
                                $status_nikah = strtolower(filter_var(trim($allDataInSheet[$i][$status_nikah]), FILTER_SANITIZE_STRING));
                                $pekerjaan = strtolower(filter_var(trim($allDataInSheet[$i][$pekerjaan]), FILTER_SANITIZE_STRING));
                                $nomor_hp = strtolower(filter_var(trim($allDataInSheet[$i][$nomor_hp]), FILTER_SANITIZE_STRING));

                                $id_jenis_kelamin = '';
                                $id_gol_darah = '';
                                $id_agama = '';
                                $id_status_nikah = '';

                                if ($jenis_kelamin == 'laki-laki') {
                                    $id_jenis_kelamin = 1;
                                } elseif ($jenis_kelamin == 'perempuan') {
                                    $id_jenis_kelamin = 0;
                                }

                                if ($gol_darah == 'a') {
                                    $id_gol_darah = 1;
                                } elseif ($gol_darah == 'b') {
                                    $id_gol_darah = 2;
                                } elseif ($gol_darah == 'ab') {
                                    $id_gol_darah = 3;
                                } elseif ($gol_darah == 'O') {
                                    $id_gol_darah = 4;
                                } else {
                                    $id_gol_darah = 5;
                                }

                                if ($agama == 'islam') {
                                    $id_agama = 1;
                                } elseif ($agama == 'kristen') {
                                    $id_agama = 2;
                                } elseif ($agama == 'hindu') {
                                    $id_agama = 3;
                                } elseif ($agama == 'budha') {
                                    $id_agama = 4;
                                } else {
                                    $id_agama = 5;
                                }

                                if ($status_nikah == 'belum menikah') {
                                    $id_status_nikah = 0;
                                } elseif ($status_nikah == 'menikah') {
                                    $id_status_nikah = 1;
                                } elseif ($status_nikah == 'cerai hidup') {
                                    $id_status_nikah = 2;
                                } elseif ($status_nikah == 'cerai mati') {
                                    $id_status_nikah = 3;
                                }


                                if (!empty($pekerjaan)) {
                                    foreach ($kerja as $key => $value) {
                                        if (strtolower($pekerjaan) == strtolower($value->job)) {
                                            $pekerjaan = $value->id;
                                        } else {
                                            $pekerjaan = 13;
                                        }
                                    }
                                }

                                $fetchData[] = array('id_admin' => $id_admin, 'id_regional' => $id_regional, 'id_petugas' => $id_petugas,
                                    'nik_ktp' => $nik_ktp, 'nama_ktp' => $nama_ktp, 'tempat_lahir' => $tempat_lahir, 'tanggal_lahir' => $tanggal_lahir,
                                    'jenis_kelamin' => $id_jenis_kelamin, 'gol_darah' => $id_gol_darah, 'alamat_ktp' => $alamat_ktp,
                                    'rt' => $rt, 'rw' => $rw, 'agama' => $id_agama, 'status_nikah' => $id_status_nikah, 'pekerjaan' => $pekerjaan,
                                    'nomor_hp_ktp' => $nomor_hp);
                            }
                            $data['dataInfo'] = $fetchData;
                            $this->Ktpmodel->setBatchImport($fetchData);
                            $this->Ktpmodel->importData();
                        } else {
                            $this->session->set_flashdata('flash_message', err_msg('Maaf, Silahkan Import file dengan benar, kolom csv anda belum sesuai'));
                            redirect('ktp/lihat_ktp_pet/' . $id);
                        }
                        $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Import Data Telah Tersimpan..'));
                        redirect('ktp/lihat_ktp_pet/' . $id);
                    }
                } else {

                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Silahkan Import file berformat .csv'));
                    redirect('ktp/lihat_ktp_pet/' . $id);
                }
            } else {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Silahkan pilih file .csv terlebih dahulu'));
                redirect('ktp/lihat_ktp_pet/' . $id);
            }
        }
    }

    public function upload_csv_admin($id = '') {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $id_admin = $this->Ktpmodel->get_by_id_admin_reg($id);
        $kerja = $this->Ktpmodel->get_pekerjaan();
        $this->form_validation->set_rules('nama_petugas', 'Nama Petugas Pemungutan', 'required');

        if (empty($id)) {
            $this->session->set_flashdata('flash_message', warn_msg('ID regional tidak ditemukan'));
            redirect('ktp/lihat_ktp_admin/' . $id); //folder, controller, method
        } else {

            $file_mimes = array('text/x-comma-separated-values',
                'text/comma-separated-values',
                'application/octet-stream',
                'application/vnd.ms-excel',
                'application/x-csv',
                'text/x-csv',
                'text/csv',
                'application/csv',
                'application/excel',
                'application/vnd.msexcel',
                'text/plain',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            );
            if (isset($_FILES['csv']['name'])) {
                $arr_file = explode('.', $_FILES['csv']['name']);
                $extension = end($arr_file);
                if (($extension == 'xlsx' || $extension == 'xls' || $extension == 'csv') && in_array($_FILES['csv']['type'], $file_mimes)) {
                    if (!empty($_FILES['csv']['name'])) {

                        $extension = pathinfo($_FILES['csv']['name'], PATHINFO_EXTENSION);

                        if ($extension == 'csv') {
                            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                        } elseif ($extension == 'xlsx') {
                            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                        } else {
                            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                        }

                        $spreadsheet = $reader->load($_FILES['csv']['tmp_name']);
                        $allDataInSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

                        $arrayCount = count($allDataInSheet);

                        $flag = 0;
                        $createArray = array('nik_ktp', 'nama_ktp', 'tempat_lahir', 'tanggal_lahir',
                            'jenis_kelamin', 'gol_darah', 'alamat_ktp', 'rt', 'rw', 'agama', 'status_nikah',
                            'pekerjaan', 'nomor_hp');
                        $makeArray = array('nik_ktp' => 'nik_ktp',
                            'nama_ktp' => 'nama_ktp', 'tempat_lahir' => 'tempat_lahir', 'tanggal_lahir' => 'tanggal_lahir',
                            'jenis_kelamin' => 'jenis_kelamin', 'gol_darah' => 'gol_darah', 'alamat_ktp' => 'alamat_ktp',
                            'agama' => 'agama', 'rt' => 'rt', 'rw' => 'rw', 'status_nikah' => 'status_nikah', 'pekerjaan' => 'pekerjaan',
                            'nomor_hp' => 'nomor_hp');
                        $SheetDataKey = array();

                        foreach ($allDataInSheet as $dataInSheet) {
                            foreach ($dataInSheet as $key => $value) {
                                if (in_array(trim($value), $createArray)) {
                                    $value = preg_replace('/\s+/', '', $value);
                                    $SheetDataKey[trim($value)] = $key;
                                }
                            }
                        }

                        $dataDiff = array_diff_key($makeArray, $SheetDataKey);

                        if (empty($dataDiff)) {
                            $flag = 1;
                        }

                        if ($flag == 1) {
                            for ($i = 2; $i <= $arrayCount; $i++) {
                                $id_admin = $id_admin[0]->id_admin;
                                $id_regional = $id;
                                $id_petugas = $data['nama_petugas'];
                                $nik_ktp = $SheetDataKey['nik_ktp'];
                                $nama_ktp = $SheetDataKey['nama_ktp'];
                                $tempat_lahir = $SheetDataKey['tempat_lahir'];
                                $tanggal_lahir = $SheetDataKey['tanggal_lahir'];
                                $jenis_kelamin = $SheetDataKey['jenis_kelamin'];
                                $gol_darah = $SheetDataKey['gol_darah'];
                                $alamat_ktp = $SheetDataKey['alamat_ktp'];
                                $rt = $SheetDataKey['rt'];
                                $rw = $SheetDataKey['rw'];
                                $agama = $SheetDataKey['agama'];
                                $status_nikah = $SheetDataKey['status_nikah'];
                                $pekerjaan = $SheetDataKey['pekerjaan'];
                                $nomor_hp = $SheetDataKey['nomor_hp'];

//                        $id_admin = filter_var(trim($allDataInSheet[$i][$id_admin]), FILTER_SANITIZE_STRING);
//                        $id_regional = filter_var(trim($allDataInSheet[$i][$id_regional]), FILTER_SANITIZE_STRING);
                                $nik_ktp = strtolower(filter_var(trim($allDataInSheet[$i][$nik_ktp]), FILTER_SANITIZE_STRING));
                                $nama_ktp = strtolower(filter_var(trim($allDataInSheet[$i][$nama_ktp]), FILTER_SANITIZE_STRING));
                                $tempat_lahir = strtolower(filter_var(trim($allDataInSheet[$i][$tempat_lahir]), FILTER_SANITIZE_STRING));
                                $tanggal_lahir = strtolower(filter_var(trim($allDataInSheet[$i][$tanggal_lahir]), FILTER_SANITIZE_STRING));
                                $jenis_kelamin = strtolower(filter_var(trim($allDataInSheet[$i][$jenis_kelamin]), FILTER_SANITIZE_STRING));
                                $gol_darah = strtolower(filter_var(trim($allDataInSheet[$i][$gol_darah]), FILTER_SANITIZE_STRING));
                                $alamat_ktp = strtolower(filter_var(trim($allDataInSheet[$i][$alamat_ktp]), FILTER_SANITIZE_STRING));
                                $rt = strtolower(filter_var(trim($allDataInSheet[$i][$rt]), FILTER_SANITIZE_STRING));
                                $rw = strtolower(filter_var(trim($allDataInSheet[$i][$rw]), FILTER_SANITIZE_STRING));
                                $agama = strtolower(filter_var(trim($allDataInSheet[$i][$agama]), FILTER_SANITIZE_STRING));
                                $status_nikah = strtolower(filter_var(trim($allDataInSheet[$i][$status_nikah]), FILTER_SANITIZE_STRING));
                                $pekerjaan = strtolower(filter_var(trim($allDataInSheet[$i][$pekerjaan]), FILTER_SANITIZE_STRING));
                                $nomor_hp = strtolower(filter_var(trim($allDataInSheet[$i][$nomor_hp]), FILTER_SANITIZE_STRING));

                                $id_jenis_kelamin = '';
                                $id_gol_darah = '';
                                $id_agama = '';
                                $id_status_nikah = '';

                                if ($jenis_kelamin == 'laki-laki') {
                                    $id_jenis_kelamin = 1;
                                } elseif ($jenis_kelamin == 'perempuan') {
                                    $id_jenis_kelamin = 0;
                                }

                                if ($gol_darah == 'a') {
                                    $id_gol_darah = 1;
                                } elseif ($gol_darah == 'b') {
                                    $id_gol_darah = 2;
                                } elseif ($gol_darah == 'ab') {
                                    $id_gol_darah = 3;
                                } elseif ($gol_darah == 'O') {
                                    $id_gol_darah = 4;
                                } else {
                                    $id_gol_darah = 5;
                                }

                                if ($agama == 'islam') {
                                    $id_agama = 1;
                                } elseif ($agama == 'kristen') {
                                    $id_agama = 2;
                                } elseif ($agama == 'hindu') {
                                    $id_agama = 3;
                                } elseif ($agama == 'budha') {
                                    $id_agama = 4;
                                } else {
                                    $id_agama = 5;
                                }

                                if ($status_nikah == 'belum menikah') {
                                    $id_status_nikah = 0;
                                } elseif ($status_nikah == 'menikah') {
                                    $id_status_nikah = 1;
                                } elseif ($status_nikah == 'cerai hidup') {
                                    $id_status_nikah = 2;
                                } elseif ($status_nikah == 'cerai mati') {
                                    $id_status_nikah = 3;
                                }

                                if (!empty($pekerjaan)) {
                                    foreach ($kerja as $key => $value) {
                                        if (strtolower($pekerjaan) == strtolower($value->job)) {
                                            $pekerjaan = $value->id;
                                        } else {
                                            $pekerjaan = 13;
                                        }
                                    }
                                }

                                $fetchData[] = array('id_admin' => $id_admin, 'id_regional' => $id_regional, 'id_petugas' => $id_petugas,
                                    'nik_ktp' => $nik_ktp,
                                    'nama_ktp' => $nama_ktp, 'tempat_lahir' => $tempat_lahir, 'tanggal_lahir' => $tanggal_lahir,
                                    'jenis_kelamin' => $id_jenis_kelamin, 'gol_darah' => $id_gol_darah, 'alamat_ktp' => $alamat_ktp,
                                    'rt' => $rt, 'rw' => $rw, 'agama' => $id_agama, 'status_nikah' => $id_status_nikah, 'pekerjaan' => $pekerjaan,
                                    'nomor_hp_ktp' => $nomor_hp);
                            }
                            $data['dataInfo'] = $fetchData;
                            $this->Ktpmodel->setBatchImport($fetchData);
                            $this->Ktpmodel->importData();
                        } else {
                            $this->session->set_flashdata('flash_message', err_msg('Maaf, Silahkan Import file dengan benar, kolom csv anda belum sesuai'));
                            redirect('ktp/lihat_ktp_admin/' . $id);
                        }
                        $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Import Data Telah Tersimpan..'));
                        redirect('ktp/lihat_ktp_admin/' . $id);
                    }
                } else {

                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Silahkan Import file berformat .csv'));
                    redirect('ktp/lihat_ktp_admin/' . $id);
                }
            } else {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Silahkan pilih file .csv terlebih dahulu'));
                redirect('ktp/lihat_ktp_admin/' . $id);
            }
        }
    }

    //---------------------------------------ZIP DATA ANGGOTA KTP---------------------------------------//

    public function zip_all_ktp() {
        $this->load->library('zip');
        date_default_timezone_set("Asia/Jakarta");
        $date = date('Y-m-d H-i-s', time());

        if ($this->user['role_admin'] == 1 or $this->user['role_admin'] == 2) {

            $admin_path = $this->Ktpmodel->get_path_by_id_admin($this->user['id_ref'], $this->user['role_admin']); //?

            if (!empty($admin_path)) {

                foreach ($admin_path as $key => $value) {
                    $archive_file_name = 'LAPORAN_' . $value->nama_admin . '_' . $date . '.zip';
                    $rootPath = realpath(FCPATH . $value->path);

                    $this->zip->read_dir($rootPath, FALSE);
                    $this->zip->download($archive_file_name);
                }
            }
        } else {
            $archive_file_name = 'all_foto_ktp_' . $date . '.zip';
            $rootPath = realpath(FCPATH . '/uploads/ktp');

            $this->zip->read_dir($rootPath, FALSE);
            $status = $this->zip->download($archive_file_name);

            if ($status == TRUE) {
                exit("Zip file downloaded");
            } else {
                exit("Could not find Zip file to download");
            }
        }
    }

    public function zip_reg_ktp($id = '') {

        date_default_timezone_set("Asia/Jakarta");
        $date = date('Y-m-d H-i-s', time());

        if (!empty($id)) {
            $reg_path = $this->Ktpmodel->get_path_by_id_reg($id); //?
            //var_dump($reg_path);exit;
            $archive_file_name = $reg_path[0]->nama_admin . '_' . $date . '.zip';
            $rootPath = realpath($reg_path[0]->path);
        } else {
            $data = 'error';
            $this->load->view('error_404', $data);
        }

        $this->zip->read_dir($rootPath, FALSE);
        $status = $this->zip->download($archive_file_name);

        if ($status == TRUE) {
            exit("Zip file downloaded");
        } else {
            exit("Could not find Zip file to download");
        }
    }

    //---------------------------------------GET DATA ANGGOTA KTP---------------------------------------//

    public function get_ktp($id = '') {

        $data['ktp'] = $this->Ktpmodel->get_by_id_ktp($id, $this->user['id_ref'], $this->user['role_admin']); //?      
        $data['pet'] = $this->Ktpmodel->get_petugas($this->user['id_ref'], $this->user['role_admin']);
        $data['admin_regional'] = $this->Ktpmodel->get_admin_regional($this->user['id_ref'], $this->user['role_admin']);
        $data['provinsi'] = $this->Ktpmodel->get_provinsi(); //?
        $data['pekerjaan'] = $this->Ktpmodel->get_pekerjaan();
        $data['prov'] = $this->Ktpmodel->get_provinsi(); //?
        $data['kab'] = $this->Ktpmodel->get_kabupaten(); //?
        $data['kec'] = $this->Ktpmodel->get_kecamatan(); //?
        $data['kel'] = $this->Ktpmodel->get_kelurahan(); //?

        $cek = $this->Ktpmodel->get_by_id_ktp($id, $this->user['id_ref'], $this->user['role_admin']);
        if ($cek == FALSE or empty($id)) {
            $data = array();
            $this->load->view('error_404', $data);
        } else {
            //edit data with id
            $this->template->load('template_admin/template_admin', 'edit_ktp', $data);
        }
    }

    public function get_ktp_admin($id = '') {

        $data['ktp'] = $this->Ktpmodel->get_by_id_ktp($id, $this->user['id_ref'], $this->user['role_admin']); //?
        $data['admin_regional'] = $this->Ktpmodel->get_admin_regional($this->user['id_ref'], $this->user['role_admin']);
        $data['petugas'] = $this->Ktpmodel->get_petugas_admin($data['ktp'][0]->id_admin);
        $data['provinsi'] = $this->Ktpmodel->get_provinsi(); //?
        $data['pekerjaan'] = $this->Ktpmodel->get_pekerjaan();
        $data['prov'] = $this->Ktpmodel->get_provinsi(); //?
        $data['kab'] = $this->Ktpmodel->get_kabupaten(); //?
        $data['kec'] = $this->Ktpmodel->get_kecamatan(); //?
        $data['kel'] = $this->Ktpmodel->get_kelurahan(); //?
        $cek = $this->Ktpmodel->get_by_id_ktp($id, $this->user['id_ref'], $this->user['role_admin']);
        if ($cek == FALSE or empty($id)) {
            $data = array();
            $this->load->view('error_404', $data);
        } else {
            //edit data with id
            $this->template->load('template_admin/template_admin', 'edit_ktp_admin', $data);
        }
    }

    public function get_ktp_pet($id = '') {

        $data['ktp'] = $this->Ktpmodel->get_by_id_ktp($id, $this->user['id_ref'], $this->user['role_admin']); //?
        $data['pet'] = $this->Ktpmodel->get_by_id_pet($data['ktp'][0]->id_petugas, $this->user['id_ref'], $this->user['role_admin']);
        $data['petugas'] = $this->Ktpmodel->get_petugas($this->user['id_ref'], $this->user['role_admin']);
        $data['admin_regional'] = $this->Ktpmodel->get_admin_regional($this->user['id_ref'], $this->user['role_admin']);
        $data['provinsi'] = $this->Ktpmodel->get_provinsi(); //?
        $data['pekerjaan'] = $this->Ktpmodel->get_pekerjaan();
        $data['prov'] = $this->Ktpmodel->get_provinsi(); //?
        $data['kab'] = $this->Ktpmodel->get_kabupaten(); //?
        $data['kec'] = $this->Ktpmodel->get_kecamatan(); //?
        $data['kel'] = $this->Ktpmodel->get_kelurahan(); //?
        $cek = $this->Ktpmodel->get_by_id_ktp($id, $this->user['id_ref'], $this->user['role_admin']);
        if ($cek == FALSE or empty($id)) {
            $data = array();
            $this->load->view('error_404', $data);
        } else {
            //edit data with id
            $this->template->load('template_admin/template_admin', 'edit_ktp_pet', $data);
        }
    }

    public function cek_nik_ktp() {

        $nik = $this->input->post('nik');
        $cek = $this->Ktpmodel->get_nik($nik);

        if ($cek == FALSE) {
            echo '1';
        } else {
            echo '0';
        }
    }

    //---------------------------------------GET DATA ANGGOTA KTP---------------------------------------//

    public function kirim_ktp() {

        $this->load->library('form_validation');
        $this->load->library('zend');
        $this->zend->load('Zend/Barcode');

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        date_default_timezone_set("Asia/Jakarta");
        $date = date('Y-m-d H-i-s', time());

        $this->form_validation->set_rules('nama_petugas', 'Nama Petugas Pemungutan', 'required');
        $this->form_validation->set_rules('region_anggota', 'Region Anggota', 'required');
        $this->form_validation->set_rules('nik_ktp', 'Nomor ID', 'required');
        $this->form_validation->set_rules('nama_ktp', 'Nama ID', 'required');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'required');
        $this->form_validation->set_rules('kabupaten', 'Kabupaten', 'required');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
        $this->form_validation->set_rules('kelurahan', 'Kelurahan', 'required');
        $this->form_validation->set_rules('alamat_ktp', 'Alamat ID', 'required');
        $this->form_validation->set_rules('rt', 'RT', 'required');
        $this->form_validation->set_rules('rw', 'RW', 'required');
        $this->form_validation->set_rules('kodepos', 'Kode Pos', 'required');
        $this->form_validation->set_rules('agama', 'Agama', 'required');
        $this->form_validation->set_rules('pend_terakhir', 'Pendidikan Terakhir', 'required');
        $this->form_validation->set_rules('status_nikah', 'Status Perkawinan', 'required');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan e-KTP', 'required');
        $this->form_validation->set_rules('tanggal_daftar', 'Tanggal Daftar', 'required');
        $this->form_validation->set_rules('pengurus', 'Pengurus', 'required');

        $id_admin = $this->Ktpmodel->get_by_id_admin_reg($data['region_anggota']);
        $name_file = strtolower(str_replace(' ', '_', $data['nik_ktp'] . '_' . $data['nama_ktp'] . '_' . $date));

        $get_code_wilayah = $this->Ktpmodel->get_code_wil($id_admin[0]->id_ref, $id_admin[0]->role_admin);

        $no_urut = '';
        $get_no_urutan = $this->Ktpmodel->get_no_urut($data['region_anggota']);

        $tgl_lahir = explode("/", $data['tanggal_lahir']);
        $no_tgl_lahir = substr($tgl_lahir['2'], 2, 2);
        $tgl_lahir_gab = $tgl_lahir['0'] . $tgl_lahir['1'] . $no_tgl_lahir;

        if (empty($get_no_urutan)) {
            $no_urut = '000001';
        } else {
            $no_urut = str_pad($get_no_urutan[0]->no_urut + 1, 6, "0", STR_PAD_LEFT);
        }

        $no_kta_baru = $get_code_wilayah[0]->code . $data['provinsi'] . $data['kabupaten'] . $data['kecamatan'] . $data['kelurahan'] . $tgl_lahir_gab . $no_urut;

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('ktp/tambah_ktp'); //folder, controller, method
        } else {
            $this->load->library('upload'); //load library upload file
            $this->load->library('image_lib'); //load library image
            //ktp
            if (!empty($_FILES['img'])) {

                $path = $id_admin[0]->path . '/';
                $path_thumb = $id_admin[0]->path . '/thumbs/';

                //config upload file
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 2048; //set limit
                $config['overwrite'] = FALSE; //if have same name, add number
                $config['remove_spaces'] = TRUE; //change space into _
                $config['encrypt_name'] = FALSE;
                $config['file_name'] = $name_file . "_ktp";
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
                    $img['width'] = 600;
                    $img['height'] = 300;

                    $this->image_lib->initialize($img);
                    if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                        $data['pic_thumb'] = $path_thumb . $name;
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                        redirect('ktp/tambah_ktp');
                    }
                } else {
                    $this->session->set_flashdata('flash_message', err_msg("Maaf, Silahkan upload Foto ID terlebih dahulu."));
                    redirect('ktp/tambah_ktp');
                }
            }
            // pas foto ktp
            if (!empty($_FILES['img_pas'])) {

                $path = $id_admin[0]->path . '/';
                $path_thumb = $id_admin[0]->path . '/pasfoto_thumbs/';
                //config upload file
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 2048; //set limit
                $config['overwrite'] = FALSE; //if have same name, add number
                $config['remove_spaces'] = TRUE; //change space into _
                $config['encrypt_name'] = FALSE;
                $config['file_name'] = $name_file . "_pas_foto";
                //initialize config upload
                $this->upload->initialize($config);

                if ($this->upload->do_upload('img_pas')) {//if success upload data
                    $result['upload'] = $this->upload->data();
                    $name = $result['upload']['file_name'];
                    $data['pic_pas'] = $path . $name;

                    $img['image_library'] = 'gd2';
                    $img['source_image'] = $path . $name;
                    $img['new_image'] = $path_thumb . $name;
                    $img['maintain_ratio'] = true;
                    $img['width'] = 300;
                    $img['height'] = 300;

                    $this->image_lib->initialize($img);
                    if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                        $data['pic_pas_thumb'] = $path_thumb . $name;
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                        redirect('ktp/tambah_ktp');
                    }
                } else {
                    $this->session->set_flashdata('flash_message', err_msg("Maaf, Silahkan upload pas foto terlebih dahulu."));
                    redirect('ktp/tambah_ktp');
                }
            }

            if (!empty($no_kta_baru)) {

                $image_resource = Zend_Barcode::factory('code128', 'image', array('text' => $no_kta_baru, 'barHeight' => 20, 'factor' => 1,), array())->draw();
                $barcode_name = $name_file . '.jpg';
                $image_dir = $id_admin[0]->path . '/barcode/'; // penyimpanan file barcode
                $data['nik_kta_baru'] = $no_kta_baru;
                $data['barcode'] = $image_dir . $barcode_name;
                imagejpeg($image_resource, $image_dir . $barcode_name);
            } else {

                $this->session->set_flashdata('flash_message', err_msg('Maaf, Generate Barcode terjadi kesalahan...'));
                redirect('ktp/tambah_ktp');
            }

            $input = $this->Ktpmodel->insert_ktp($data, $id_admin[0]->id_ref);
            if ($input == true) {
                $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data telah tersimpan..'));
                redirect('ktp/tambah_ktp');
            } else {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                redirect('ktp/tambah_ktp');
            }
        }
    }

    public function kirim_ktp_admin($id = '') {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        date_default_timezone_set("Asia/Jakarta");
        $date = date('Y-m-d H-i-s', time());

        $this->form_validation->set_rules('nama_petugas', 'Nama Petugas Pemungutan', 'required');
        $this->form_validation->set_rules('region_anggota', 'Region Anggota', 'required');
        $this->form_validation->set_rules('nik_ktp', 'Nomor ID', 'required');
        $this->form_validation->set_rules('nama_ktp', 'Nama ID', 'required');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'required');
        $this->form_validation->set_rules('kabupaten', 'Kabupaten', 'required');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
        $this->form_validation->set_rules('kelurahan', 'Kelurahan', 'required');
        $this->form_validation->set_rules('alamat_ktp', 'Alamat ID', 'required');
        $this->form_validation->set_rules('rt', 'RT', 'required');
        $this->form_validation->set_rules('rw', 'RW', 'required');
        $this->form_validation->set_rules('kodepos', 'Kode Pos', 'required');
        $this->form_validation->set_rules('agama', 'Agama', 'required');
        $this->form_validation->set_rules('pend_terakhir', 'Pendidikan Terakhir', 'required');
        $this->form_validation->set_rules('status_nikah', 'Status Perkawinan', 'required');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan e-KTP', 'required');
        $this->form_validation->set_rules('tanggal_daftar', 'Tanggal Daftar', 'required');
        $this->form_validation->set_rules('pengurus', 'Pengurus', 'required');

        $id_admin = $this->Ktpmodel->get_by_id_admin_reg($data['region_anggota']);
        $name_file = strtolower(str_replace(' ', '_', $data['nik_ktp'] . '_' . $data['nama_ktp'] . '_' . $date));

        $get_code_wilayah = $this->Ktpmodel->get_code_wil($id_admin[0]->id_ref, $id_admin[0]->role_admin);

        $no_urut = '';
        $get_no_urutan = $this->Ktpmodel->get_no_urut($data['region_anggota']);

        $tgl_lahir = explode("/", $data['tanggal_lahir']);
        $no_tgl_lahir = substr($tgl_lahir['2'], 2, 2);
        $tgl_lahir_gab = $tgl_lahir['0'] . $tgl_lahir['1'] . $no_tgl_lahir;

        if (empty($get_no_urutan)) {
            $no_urut = '000001';
        } else {
            $no_urut = str_pad($get_no_urutan[0]->no_urut + 1, 6, "0", STR_PAD_LEFT);
        }

        $no_kta_baru = $get_code_wilayah[0]->code . $data['provinsi'] . $data['kabupaten'] . $data['kecamatan'] . $data['kelurahan'] . $tgl_lahir_gab . $no_urut;


//print_r($param);exit;
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('ktp/tambah_ktp_reg/' . $id); //folder, controller, method
        } else {
            $this->load->library('upload'); //load library upload file
            $this->load->library('image_lib'); //load library image

            if (!empty($_FILES['img'])) {

                $path = $id_admin[0]->path . '/';
                $path_thumb = $id_admin[0]->path . '/thumbs/';
                //config upload file
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 2048; //set limit
                $config['overwrite'] = FALSE; //if have same name, add number
                $config['remove_spaces'] = TRUE; //change space into _
                $config['encrypt_name'] = FALSE;
                $config['file_name'] = $name_file . "_ktp";
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
                    $img['width'] = 600;
                    $img['height'] = 300;

                    $this->image_lib->initialize($img);
                    if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                        $data['pic_thumb'] = $path_thumb . $name;
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                        redirect('ktp/tambah_ktp_reg/' . $id);
                    }
                } else {
                    $this->session->set_flashdata('flash_message', err_msg("Maaf, Silahkan upload foto ID terlebih dahulu."));
                    redirect('ktp/tambah_ktp_reg/' . $id);
                }
            }

            // pas foto ktp
            if (!empty($_FILES['img_pas'])) {

                $path = $id_admin[0]->path . '/';
                $path_thumb = $id_admin[0]->path . '/pasfoto_thumbs/';
                //config upload file
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 2048; //set limit
                $config['overwrite'] = FALSE; //if have same name, add number
                $config['remove_spaces'] = TRUE; //change space into _
                $config['encrypt_name'] = FALSE;
                $config['file_name'] = $name_file . "_pas_foto";
                //initialize config upload
                $this->upload->initialize($config);

                if ($this->upload->do_upload('img_pas')) {//if success upload data
                    $result['upload'] = $this->upload->data();
                    $name = $result['upload']['file_name'];
                    $data['pic_pas'] = $path . $name;

                    $img['image_library'] = 'gd2';
                    $img['source_image'] = $path . $name;
                    $img['new_image'] = $path_thumb . $name;
                    $img['maintain_ratio'] = true;
                    $img['width'] = 300;
                    $img['height'] = 300;

                    $this->image_lib->initialize($img);
                    if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                        $data['pic_pas_thumb'] = $path_thumb . $name;
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                        redirect('ktp/tambah_ktp_reg/' . $id);
                    }
                } else {
                    $this->session->set_flashdata('flash_message', err_msg("Maaf, Silahkan upload pas foto terlebih dahulu."));
                    redirect('ktp/tambah_ktp_reg/' . $id);
                }
            }

            if (!empty($no_kta_baru)) {

                $image_resource = Zend_Barcode::factory('code128', 'image', array('text' => $no_kta_baru, 'barHeight' => 20,
                            'factor' => 1,), array())->draw();
                $barcode_name = $name_file . '.jpg';
                $image_dir = $id_admin[0]->path . '/barcode/'; // penyimpanan file barcode
                $data['nik_kta_baru'] = $no_kta_baru;
                $data['barcode'] = $image_dir . $barcode_name;
                imagejpeg($image_resource, $image_dir . $barcode_name);
            } else {

                $this->session->set_flashdata('flash_message', err_msg('Maaf, Generate Barcode terjadi kesalahan...'));
                redirect('ktp/tambah_ktp');
            }

            $input = $this->Ktpmodel->insert_ktp($data, $id_admin[0]->id_admin);
            if ($input == true) {
                $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data telah tersimpan..'));
                redirect('ktp/tambah_ktp_reg/' . $id);
            } else {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                redirect('ktp/tambah_ktp_reg/' . $id);
            }
        }
    }

    public function kirim_ktp_pet($id = '') {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        date_default_timezone_set("Asia/Jakarta");
        $date = date('Y-m-d H-i-s', time());

        $this->form_validation->set_rules('nama_petugas', 'Nama Petugas Pemungutan', 'required');
        $this->form_validation->set_rules('region_anggota', 'Region Anggota', 'required');
        $this->form_validation->set_rules('nik_ktp', 'Nomor ID', 'required');
        $this->form_validation->set_rules('nama_ktp', 'Nama ID', 'required');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'required');
        $this->form_validation->set_rules('kabupaten', 'Kabupaten', 'required');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
        $this->form_validation->set_rules('kelurahan', 'Kelurahan', 'required');
        $this->form_validation->set_rules('alamat_ktp', 'Alamat ID', 'required');
        $this->form_validation->set_rules('rt', 'RT', 'required');
        $this->form_validation->set_rules('rw', 'RW', 'required');
        $this->form_validation->set_rules('kodepos', 'Kode Pos', 'required');
        $this->form_validation->set_rules('agama', 'Agama', 'required');
        $this->form_validation->set_rules('pend_terakhir', 'Pendidikan Terakhir', 'required');
        $this->form_validation->set_rules('status_nikah', 'Status Perkawinan', 'required');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan e-KTP', 'required');
        $this->form_validation->set_rules('tanggal_daftar', 'Tanggal Daftar', 'required');
        $this->form_validation->set_rules('pengurus', 'Pengurus', 'required');

        $id_admin = $this->Ktpmodel->get_by_id_admin_reg($data['region_anggota']);
        $name_file = strtolower(str_replace(' ', '_', $data['nik_ktp'] . '_' . $data['nama_ktp'] . '_' . $date));

        $get_code_wilayah = $this->Ktpmodel->get_code_wil($id_admin[0]->id_ref, $id_admin[0]->role_admin);

        $no_urut = '';
        $get_no_urutan = $this->Ktpmodel->get_no_urut($data['region_anggota']);

        $tgl_lahir = explode("/", $data['tanggal_lahir']);
        $no_tgl_lahir = substr($tgl_lahir['2'], 2, 2);
        $tgl_lahir_gab = $tgl_lahir['0'] . $tgl_lahir['1'] . $no_tgl_lahir;

        if (empty($get_no_urutan)) {
            $no_urut = '000001';
        } else {
            $no_urut = str_pad($get_no_urutan[0]->no_urut + 1, 6, "0", STR_PAD_LEFT);
        }

        $no_kta_baru = $get_code_wilayah[0]->code . $data['provinsi'] . $data['kabupaten'] . $data['kecamatan'] . $data['kelurahan'] . $tgl_lahir_gab . $no_urut;

//print_r($param);exit;
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('ktp/tambah_ktp_pet/' . $id); //folder, controller, method
        } else {
            $this->load->library('upload'); //load library upload file
            $this->load->library('image_lib'); //load library image

            if (!empty($_FILES['img'])) {

                $path = $id_admin[0]->path . '/';
                $path_thumb = $id_admin[0]->path . '/thumbs/';
                //config upload file
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 2048; //set limit
                $config['overwrite'] = FALSE; //if have same name, add number
                $config['remove_spaces'] = TRUE; //change space into _
                $config['encrypt_name'] = FALSE;
                $config['file_name'] = $name_file . "_ktp";
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
                    $img['width'] = 600;
                    $img['height'] = 300;

                    $this->image_lib->initialize($img);
                    if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                        $data['pic_thumb'] = $path_thumb . $name;
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                        redirect('ktp/tambah_ktp_pet/' . $id);
                    }
                } else {
                    $this->session->set_flashdata('flash_message', err_msg("Maaf, Silahkan upload foto ID terlebih dahulu."));
                    redirect('ktp/tambah_ktp_pet/' . $id);
                }
            }

            // pas foto ktp
            if (!empty($_FILES['img_pas'])) {

                $path = $id_admin[0]->path . '/';
                $path_thumb = $id_admin[0]->path . '/pasfoto_thumbs/';
                //config upload file
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 2048; //set limit
                $config['overwrite'] = FALSE; //if have same name, add number
                $config['remove_spaces'] = TRUE; //change space into _
                $config['encrypt_name'] = FALSE;
                $config['file_name'] = $name_file . "_pas_foto";
                //initialize config upload
                $this->upload->initialize($config);

                if ($this->upload->do_upload('img_pas')) {//if success upload data
                    $result['upload'] = $this->upload->data();
                    $name = $result['upload']['file_name'];
                    $data['pic_pas'] = $path . $name;

                    $img['image_library'] = 'gd2';
                    $img['source_image'] = $path . $name;
                    $img['new_image'] = $path_thumb . $name;
                    $img['maintain_ratio'] = true;
                    $img['width'] = 300;
                    $img['height'] = 300;

                    $this->image_lib->initialize($img);
                    if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                        $data['pic_pas_thumb'] = $path_thumb . $name;
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                        redirect('ktp/tambah_ktp_pet/' . $id);
                    }
                } else {
                    $this->session->set_flashdata('flash_message', err_msg("Maaf, Silahkan upload pas foto terlebih dahulu."));
                    redirect('ktp/tambah_ktp_pet/' . $id);
                }
            }

            if (!empty($no_kta_baru)) {

                $image_resource = Zend_Barcode::factory('code128', 'image', array('text' => $no_kta_baru, 'barHeight' => 20,
                            'factor' => 1,), array())->draw();
                $barcode_name = $name_file . '.jpg';
                $image_dir = $id_admin[0]->path . '/barcode/'; // penyimpanan file barcode
                $data['nik_kta_baru'] = $no_kta_baru;
                $data['barcode'] = $image_dir . $barcode_name;
                imagejpeg($image_resource, $image_dir . $barcode_name);
            } else {

                $this->session->set_flashdata('flash_message', err_msg('Maaf, Generate Barcode terjadi kesalahan...'));
                redirect('ktp/tambah_ktp');
            }
            $input = $this->Ktpmodel->insert_ktp($data, $id_admin[0]->id_admin);
            if ($input == true) {
                $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data telah tersimpan..'));
                redirect('ktp/tambah_ktp_pet/' . $id);
            } else {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                redirect('ktp/tambah_ktp_pet/' . $id);
            }
        }
    }

    //---------------------------------------EDIT DATA ANGGOTA KTP---------------------------------------//

    public function edit_ktp($id = '') {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $data['pic'] = $data['image'];
        $data['pic_thumb'] = $data['image_thumb'];

        $data_img_1 = explode('/', $data['image']);
        $img_name_1 = $data_img_1[4];

        $data['pic_pas'] = $data['image_pas'];
        $data['pic_pas_thumb'] = $data['image_pas_thumb'];

        $data_img_pas_1 = explode('/', $data['image_pas']);
        $img_name_pas_1 = $data_img_pas_1[4];

        date_default_timezone_set("Asia/Jakarta");
        $date = date('Y-m-d H-i-s', time());

        $this->form_validation->set_rules('nama_petugas', 'Nama Petugas Pemungutan', 'required');
        $this->form_validation->set_rules('region_anggota', 'Region Anggota', 'required');
        $this->form_validation->set_rules('nik_ktp', 'Nomor ID', 'required');
        $this->form_validation->set_rules('nama_ktp', 'Nama ID', 'required');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'required');
        $this->form_validation->set_rules('kabupaten', 'Kabupaten', 'required');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
        $this->form_validation->set_rules('kelurahan', 'Kelurahan', 'required');
        $this->form_validation->set_rules('alamat_ktp', 'Alamat ID', 'required');
        $this->form_validation->set_rules('rt', 'RT', 'required');
        $this->form_validation->set_rules('rw', 'RW', 'required');
        $this->form_validation->set_rules('kodepos', 'Kode Pos', 'required');
        $this->form_validation->set_rules('agama', 'Agama', 'required');
        $this->form_validation->set_rules('pend_terakhir', 'Pendidikan Terakhir', 'required');
        $this->form_validation->set_rules('status_nikah', 'Status Perkawinan', 'required');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan e-KTP', 'required');
        $this->form_validation->set_rules('tanggal_daftar', 'Tanggal Daftar', 'required');
        $this->form_validation->set_rules('pengurus', 'Pengurus', 'required');

        $path_reg = $this->Ktpmodel->get_path_by_id_reg($data['region_anggota'], $this->user['id_ref'], $this->user['role_admin']);
        $name_file = strtolower(str_replace(' ', '_', $data['nik_ktp'] . '_' . $data['nama_ktp'] . '_' . $date));

        if ($this->form_validation->run() == FALSE) {
            //
            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('ktp/get_ktp/' . $id);
        } else {
            $this->load->library('upload'); //load library upload file
            $this->load->library('image_lib'); //load library image

            if (!empty($_FILES['img']['tmp_name'])) {

                $this->delete_file_ktp($img_name_1, $data['region_anggota']); //delete existing file

                $path = $path_reg[0]->path . '/';
                $path_thumb = $path_reg[0]->path . '/thumbs/';
                //config upload file
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 2048; //set without limit
                $config['overwrite'] = FALSE; //if have same name, add number
                $config['remove_spaces'] = TRUE; //change space into _
                $config['encrypt_name'] = FALSE;
                $config['file_name'] = $name_file . "_ktp";
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
                    $img['width'] = 600;
                    $img['height'] = 300;

                    $this->image_lib->initialize($img);
                    if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                        $data['pic_thumb'] = $path_thumb . $name;
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                        redirect('ktp/get_ktp/' . $id);
                    }
                } else {
                    $this->session->set_flashdata('flash_message', err_msg("Maaf, Silahkan upload foto ID terlebih dahulu."));
                    redirect('ktp/get_ktp/' . $id);
                }
            }

            if (!empty($_FILES['img_pas']['tmp_name'])) {

                $this->delete_file_pasfoto($img_name_pas_1, $data['region_anggota']); //delete existing file

                $path = $path_reg[0]->path . '/';
                $path_thumb = $path_reg[0]->path . '/pasfoto_thumbs/';
                //config upload file
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 2048; //set without limit
                $config['overwrite'] = FALSE; //if have same name, add number
                $config['remove_spaces'] = TRUE; //change space into _
                $config['encrypt_name'] = FALSE;
                $config['file_name'] = $name_file . "_pas_foto";
                //initialize config upload
                $this->upload->initialize($config);

                if ($this->upload->do_upload('img_pas')) {//if success upload data
                    $result['upload'] = $this->upload->data();
                    $name = $result['upload']['file_name'];
                    $data['pic_pas'] = $path . $name;

                    $img['image_library'] = 'gd2';
                    $img['source_image'] = $path . $name;
                    $img['new_image'] = $path_thumb . $name;
                    $img['maintain_ratio'] = true;
                    $img['width'] = 300;
                    $img['height'] = 300;

                    $this->image_lib->initialize($img);
                    if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                        $data['pic_pas_thumb'] = $path_thumb . $name;
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                        redirect('ktp/get_ktp/' . $id);
                    }
                } else {
                    $this->session->set_flashdata('flash_message', err_msg("Maaf, Silahkan upload pas foto terlebih dahulu."));
                    redirect('ktp/get_ktp/' . $id);
                }
            }

            // print_r($data);exit;    
            $edit = $this->Ktpmodel->update_ktp($id, $data, $this->user['id_ref'], $this->user['role_admin']);
            if ($edit == true) {
                $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data Telah Tersimpan..'));
                redirect('ktp/get_ktp/' . $id);
            } else {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                redirect('ktp/get_ktp/' . $id);
            }
        }
    }

    public function edit_ktp_admin($id = '') {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $data['pic'] = $data['image'];
        $data['pic_thumb'] = $data['image_thumb'];

        $data_img_1 = explode('/', $data['image']);
        $img_name_1 = $data_img_1[4];

        $data['pic_pas'] = $data['image_pas'];
        $data['pic_pas_thumb'] = $data['image_pas_thumb'];

        $data_img_pas_1 = explode('/', $data['image_pas']);
        $img_name_pas_1 = $data_img_pas_1[4];
        //print_r($img_name_1);exit;
        date_default_timezone_set("Asia/Jakarta");
        $date = date('Y-m-d H-i-s', time());

        $this->form_validation->set_rules('nama_petugas', 'Nama Petugas Pemungutan', 'required');
        $this->form_validation->set_rules('region_anggota', 'Region Anggota', 'required');
        $this->form_validation->set_rules('nik_ktp', 'Nomor ID', 'required');
        $this->form_validation->set_rules('nama_ktp', 'Nama ID', 'required');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'required');
        $this->form_validation->set_rules('kabupaten', 'Kabupaten', 'required');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
        $this->form_validation->set_rules('kelurahan', 'Kelurahan', 'required');
        $this->form_validation->set_rules('alamat_ktp', 'Alamat ID', 'required');
        $this->form_validation->set_rules('rt', 'RT', 'required');
        $this->form_validation->set_rules('rw', 'RW', 'required');
        $this->form_validation->set_rules('kodepos', 'Kode Pos', 'required');
        $this->form_validation->set_rules('agama', 'Agama', 'required');
        $this->form_validation->set_rules('pend_terakhir', 'Pendidikan Terakhir', 'required');
        $this->form_validation->set_rules('status_nikah', 'Status Perkawinan', 'required');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan e-KTP', 'required');
        $this->form_validation->set_rules('tanggal_daftar', 'Tanggal Daftar', 'required');
        $this->form_validation->set_rules('pengurus', 'Pengurus', 'required');

        $path_reg = $this->Ktpmodel->get_path_by_id_reg($data['region_anggota'], $this->user['id_ref'], $this->user['role_admin']);
        $name_file = strtolower(str_replace(' ', '_', $data['nik_ktp'] . '_' . $data['nama_ktp'] . '_' . $date));

        if ($this->form_validation->run() == FALSE) {
            //
            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('ktp/get_ktp_admin/' . $id);
        } else {
            $this->load->library('upload'); //load library upload file
            $this->load->library('image_lib'); //load library image

            if (!empty($_FILES['img']['tmp_name'])) {

                $this->delete_file_ktp($img_name_1, $data['region_anggota']); //delete existing file

                $path = $path_reg[0]->path . '/';
                $path_thumb = $path_reg[0]->path . '/thumbs/';
                //config upload file
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 2048; //set without limit
                $config['overwrite'] = FALSE; //if have same name, add number
                $config['remove_spaces'] = TRUE; //change space into _
                $config['encrypt_name'] = FALSE;
                $config['file_name'] = $name_file . "_ktp";
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
                    $img['width'] = 600;
                    $img['height'] = 300;

                    $this->image_lib->initialize($img);
                    if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                        $data['pic_thumb'] = $path_thumb . $name;
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                        redirect('ktp/get_ktp_admin/' . $id);
                    }
                } else {
                    $this->session->set_flashdata('flash_message', err_msg("Maaf, Silahkan upload foto ID terlebih dahulu."));
                    redirect('ktp/get_ktp_admin/' . $id);
                }
            }

            if (!empty($_FILES['img_pas']['tmp_name'])) {

                $this->delete_file_pasfoto($img_name_pas_1, $data['region_anggota']); //delete existing file

                $path = $path_reg[0]->path . '/';
                $path_thumb = $path_reg[0]->path . '/pasfoto_thumbs/';
                //config upload file
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 2048; //set without limit
                $config['overwrite'] = FALSE; //if have same name, add number
                $config['remove_spaces'] = TRUE; //change space into _
                $config['encrypt_name'] = FALSE;
                $config['file_name'] = $name_file . "_pas_foto";
                //initialize config upload
                $this->upload->initialize($config);

                if ($this->upload->do_upload('img_pas')) {//if success upload data
                    $result['upload'] = $this->upload->data();
                    $name = $result['upload']['file_name'];
                    $data['pic_pas'] = $path . $name;

                    $img['image_library'] = 'gd2';
                    $img['source_image'] = $path . $name;
                    $img['new_image'] = $path_thumb . $name;
                    $img['maintain_ratio'] = true;
                    $img['width'] = 300;
                    $img['height'] = 300;

                    $this->image_lib->initialize($img);
                    if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                        $data['pic_pas_thumb'] = $path_thumb . $name;
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                        redirect('ktp/get_ktp_admin/' . $id);
                    }
                } else {
                    $this->session->set_flashdata('flash_message', err_msg("Maaf, Silahkan upload pas foto terlebih dahulu."));
                    redirect('ktp/get_ktp_admin/' . $id);
                }
            }

            // print_r($data);exit;    
            $edit = $this->Ktpmodel->update_ktp($id, $data, $this->user['id_ref'], $this->user['role_admin']);
            if ($edit == true) {
                $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data Telah Tersimpan..'));
                redirect('ktp/get_ktp_admin/' . $id);
            } else {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                redirect('ktp/get_ktp_admin/' . $id);
            }
        }
    }

    public function edit_ktp_pet($id = '') {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $data['pic'] = $data['image'];
        $data['pic_thumb'] = $data['image_thumb'];

        $data_img_1 = explode('/', $data['image']);
        $img_name_1 = $data_img_1[4];
        //
        $data['pic_pas'] = $data['image_pas'];
        $data['pic_pas_thumb'] = $data['image_pas_thumb'];

        $data_img_pas_1 = explode('/', $data['image_pas']);
        $img_name_pas_1 = $data_img_pas_1[4];

        date_default_timezone_set("Asia/Jakarta");
        $date = date('Y-m-d H-i-s', time());

        $this->form_validation->set_rules('nama_petugas', 'Nama Petugas Pemungutan', 'required');
        $this->form_validation->set_rules('region_anggota', 'Region Anggota', 'required');
        $this->form_validation->set_rules('nik_ktp', 'Nomor ID', 'required');
        $this->form_validation->set_rules('nama_ktp', 'Nama ID', 'required');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'required');
        $this->form_validation->set_rules('kabupaten', 'Kabupaten', 'required');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
        $this->form_validation->set_rules('kelurahan', 'Kelurahan', 'required');
        $this->form_validation->set_rules('alamat_ktp', 'Alamat ID', 'required');
        $this->form_validation->set_rules('rt', 'RT', 'required');
        $this->form_validation->set_rules('rw', 'RW', 'required');
        $this->form_validation->set_rules('kodepos', 'Kode Pos', 'required');
        $this->form_validation->set_rules('agama', 'Agama', 'required');
        $this->form_validation->set_rules('pend_terakhir', 'Pendidikan Terakhir', 'required');
        $this->form_validation->set_rules('status_nikah', 'Status Perkawinan', 'required');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan e-KTP', 'required');
        $this->form_validation->set_rules('tanggal_daftar', 'Tanggal Daftar', 'required');
        $this->form_validation->set_rules('pengurus', 'Pengurus', 'required');

        $path_reg = $this->Ktpmodel->get_path_by_id_reg($data['region_anggota'], $this->user['id_ref'], $this->user['role_admin']);
        $name_file = strtolower(str_replace(' ', '_', $data['nik_ktp'] . '_' . $data['nama_ktp'] . '_' . $date));

        if ($this->form_validation->run() == FALSE) {
            //
            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('ktp/get_ktp_pet/' . $id);
        } else {
            $this->load->library('upload'); //load library upload file
            $this->load->library('image_lib'); //load library image

            if (!empty($_FILES['img']['tmp_name'])) {

                $this->delete_file_ktp($img_name_1, $data['region_anggota']); //delete existing file

                $path = $path_reg[0]->path . '/';
                $path_thumb = $path_reg[0]->path . '/thumbs/';
                //config upload file
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 2048; //set without limit
                $config['overwrite'] = FALSE; //if have same name, add number
                $config['remove_spaces'] = TRUE; //change space into _
                $config['encrypt_name'] = FALSE;
                $config['file_name'] = $name_file . "_ktp";
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
                    $img['width'] = 600;
                    $img['height'] = 300;

                    $this->image_lib->initialize($img);
                    if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                        $data['pic_thumb'] = $path_thumb . $name;
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                        redirect('ktp/get_ktp_pet/' . $id);
                    }
                } else {
                    $this->session->set_flashdata('flash_message', err_msg("Maaf, Silahkan upload foto ID terlebih dahulu."));
                    redirect('ktp/get_ktp_pet/' . $id);
                }
            }

            if (!empty($_FILES['img_pas']['tmp_name'])) {

                $this->delete_file_pasfoto($img_name_pas_1, $data['region_anggota']); //delete existing file

                $path = $path_reg[0]->path . '/';
                $path_thumb = $path_reg[0]->path . '/pasfoto_thumbs/';
                //config upload file
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 2048; //set without limit
                $config['overwrite'] = FALSE; //if have same name, add number
                $config['remove_spaces'] = TRUE; //change space into _
                $config['encrypt_name'] = FALSE;
                $config['file_name'] = $name_file . "_pas_foto";
                //initialize config upload
                $this->upload->initialize($config);

                if ($this->upload->do_upload('img_pas')) {//if success upload data
                    $result['upload'] = $this->upload->data();
                    $name = $result['upload']['file_name'];
                    $data['pic_pas'] = $path . $name;

                    $img['image_library'] = 'gd2';
                    $img['source_image'] = $path . $name;
                    $img['new_image'] = $path_thumb . $name;
                    $img['maintain_ratio'] = true;
                    $img['width'] = 300;
                    $img['height'] = 300;

                    $this->image_lib->initialize($img);
                    if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                        $data['pic_pas_thumb'] = $path_thumb . $name;
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                        redirect('ktp/get_ktp_pet/' . $id);
                    }
                } else {
                    $this->session->set_flashdata('flash_message', err_msg("Maaf, Silahkan upload pas foto terlebih dahulu."));
                    redirect('ktp/get_ktp_pet/' . $id);
                }
            }

            // print_r($data);exit;    
            $edit = $this->Ktpmodel->update_ktp($id, $data, $this->user['id_ref'], $this->user['role_admin']);
            if ($edit == true) {
                $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data Telah Tersimpan..'));
                redirect('ktp/get_ktp_pet/' . $id);
            } else {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                redirect('ktp/get_ktp_pet/' . $id);
            }
        }
    }

    //---------------------------------------EXPORT DATA ANGGOTA KTP---------------------------------------//

    public function export_laporan() {
        $this->load->helper('download');
        $this->load->library('zip');
        $this->load->helper('file');

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $extension = $data['tipe_cetak'];
        $path = './uploads/laporan/excel/';
        delete_files($path);

        $nama_file_zip = $this->Ktpmodel->get_name_file($this->user['id_ref'], $this->user['role_admin']);

        if (!empty($extension)) {
            $extension = $extension;
        } else {
            $extension = 'xlsx';
        }

        if ($data['data_check'] == '' or $data['data_check'] == NULL) {
            $this->session->set_flashdata('flash_message', warn_msg('Pilih data terlebih dahulu'));
            redirect('ktp/'); //folder, controller, method
        } else {

            $get_distinct_data = $this->Ktpmodel->get_ktp_id_by_distinct($this->user['id_ref'], $this->user['role_admin'], $data['data_check']);
            $kerja = $this->Ktpmodel->get_pekerjaan();

            foreach ($get_distinct_data as $value) {

                $empInfo = $this->Ktpmodel->get_ktp_by_id_asal($value->id_asal, $this->user['id_ref'], $this->user['role_admin']);
                $fileName = $value->provinsi . '_' . $value->kabupaten . '_' . $value->kecamatan . '_' . $value->kelurahan . '_' . date('d-m-Y');

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                if ($data['tipe_laporan'] == 1) {

                    $sheet->setCellValue('A1', 'No');
                    $sheet->setCellValue('B1', 'No. KTA');
                    $sheet->setCellValue('C1', 'Penerbit KTA');
                    $sheet->setCellValue('D1', 'Nama');
                    $sheet->setCellValue('E1', 'NIK');
                    $sheet->setCellValue('F1', 'Jenis Kelamin');
                    $sheet->setCellValue('G1', 'Tempat Lahir');
                    $sheet->setCellValue('H1', 'Tanggal Lahir');
                    $sheet->setCellValue('I1', 'Status Perkawinan');
                    $sheet->setCellValue('J1', 'Status Pekerjaan');
                    $sheet->setCellValue('K1', 'Alamat');
                    $sheet->setCellValue('L1', 'idKelurahan');

                    $no = 1;
                    $rowCount = 2;
                    foreach ($empInfo as $element) {

                        $jenis_kelamin = '';
                        $status_nikah = '';
                        $pekerjaan = '';

                        if (strlen($element['id_admin']) > 2) {
                            $nama_penerbit = $this->Ktpmodel->get_penerbit_kab($element['id_admin']);
                        } else {
                            $nama_penerbit = $this->Ktpmodel->get_penerbit_prov($element['id_admin']);
                        }

                        if ($element['jenis_kelamin'] == '1') {
                            $jenis_kelamin = 'laki-laki';
                        } elseif ($element['jenis_kelamin'] == '0') {
                            $jenis_kelamin = 'perempuan';
                        }

                        if ($element['status_nikah'] == '0') {
                            $status_nikah = 'belum menikah';
                        } elseif ($element['status_nikah'] == '1') {
                            $status_nikah = 'menikah';
                        } elseif ($element['status_nikah'] == '2') {
                            $status_nikah = 'cerai hidup';
                        } elseif ($element['status_nikah'] == '3') {
                            $status_nikah = 'cerai mati';
                        }

                        if (!empty($element['pekerjaan'])) {
                            foreach ($kerja as $key => $values) {
                                if ($element['pekerjaan'] == $values->id) {
                                    $pekerjaan = $values->job;
                                    //var_dump($value->job);
                                    //exit;
                                }
                            }
                        } else {
                            $pekerjaan = '';
                        }

                        $sheet->setCellValue('A' . $rowCount, $no);
                        $sheet->setCellValue('B' . $rowCount, $element['nik_kta_baru']);
                        $sheet->setCellValue('C' . $rowCount, $nama_penerbit[0]->nama);
                        $sheet->setCellValue('D' . $rowCount, $element['nama_ktp']);
                        $sheet->setCellValue('E' . $rowCount, $element['nik_ktp']);
                        $sheet->setCellValue('F' . $rowCount, $jenis_kelamin);
                        $sheet->setCellValue('G' . $rowCount, $element['tempat_lahir']);
                        $sheet->setCellValue('H' . $rowCount, $element['tanggal_lahir']);
                        $sheet->setCellValue('I' . $rowCount, $status_nikah);
                        $sheet->setCellValue('J' . $rowCount, $pekerjaan);
                        $sheet->setCellValue('K' . $rowCount, $element['alamat_ktp']);
                        $sheet->setCellValue('L' . $rowCount, "id_kel");
                        $rowCount++;
                        $no++;
                    }
                    if ($extension == 'csv') {
                        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
                        $fileName = $fileName . '.csv';
                    } elseif ($extension == 'xlsx') {
                        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                        $fileName = $fileName . '.xlsx';
                    } else {
                        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
                        $fileName = $fileName . '.xls';
                    }

                    $this->output->set_header('Content-Type: application/vnd.ms-excel');
                    $this->output->set_header("Content-type: application/csv");
                    $this->output->set_header('Cache-Control: max-age=0');
                    header('Content-Disposition: attachment;filename="' . $fileName . '"');
                    $writer->save($path . $fileName);
                } else {

                    $sheet->setCellValue('C2', 'Kelurahan');
                    $sheet->setCellValue('C3', 'Kecamatan');
                    $sheet->setCellValue('D2', $value->kelurahan);
                    $sheet->setCellValue('D3', $value->kecamatan);

                    $sheet->setCellValue('F2', 'Kabupaten/Kota');
                    $sheet->setCellValue('F3', 'Propinsi');
                    $sheet->setCellValue('G2', $value->kabupaten);
                    $sheet->setCellValue('G3', $value->provinsi);


                    $sheet->setCellValue('A5', 'No');
                    $sheet->setCellValue('B5', 'No. KTA');
                    $sheet->setCellValue('C5', 'Penerbit KTA');
                    $sheet->setCellValue('D5', 'Nama');
                    $sheet->setCellValue('E5', 'NIK');
                    $sheet->setCellValue('F5', 'Jenis Kelamin');
                    $sheet->setCellValue('G5', 'Tempat Lahir');
                    $sheet->setCellValue('H5', 'Tanggal Lahir');
                    $sheet->setCellValue('I5', 'Status Perkawinan');
                    $sheet->setCellValue('J5', 'Status Pekerjaan');
                    $sheet->setCellValue('K5', 'Alamat');
                    $sheet->setCellValue('L5', 'idKelurahan');

                    $no = 1;
                    $rowCount = 6;
                    foreach ($empInfo as $element) {

                        $jenis_kelamin = '';
                        $status_nikah = '';
                        $pekerjaan = '';

                        if (strlen($element['id_admin']) > 2) {
                            $nama_penerbit = $this->Ktpmodel->get_penerbit_kab($element['id_admin']);
                        } else {
                            $nama_penerbit = $this->Ktpmodel->get_penerbit_prov($element['id_admin']);
                        }

                        if ($element['jenis_kelamin'] == '1') {
                            $jenis_kelamin = 'laki-laki';
                        } elseif ($element['jenis_kelamin'] == '0') {
                            $jenis_kelamin = 'perempuan';
                        }

                        if ($element['status_nikah'] == '0') {
                            $status_nikah = 'belum menikah';
                        } elseif ($element['status_nikah'] == '1') {
                            $status_nikah = 'menikah';
                        } elseif ($element['status_nikah'] == '2') {
                            $status_nikah = 'cerai hidup';
                        } elseif ($element['status_nikah'] == '3') {
                            $status_nikah = 'cerai mati';
                        }

                        if (!empty($element['pekerjaan'])) {
                            foreach ($kerja as $key => $values) {
                                if ($element['pekerjaan'] == $values->id) {
                                    $pekerjaan = $values->job;
                                    //var_dump($value->job);
                                    //exit;
                                }
                            }
                        } else {
                            $pekerjaan = '';
                        }

                        $sheet->setCellValue('A' . $rowCount, $no);
                        $sheet->setCellValue('B' . $rowCount, $element['nik_kta_baru']);
                        $sheet->setCellValue('C' . $rowCount, $nama_penerbit[0]->nama);
                        $sheet->setCellValue('D' . $rowCount, $element['nama_ktp']);
                        $sheet->setCellValue('E' . $rowCount, $element['nik_ktp']);
                        $sheet->setCellValue('F' . $rowCount, $jenis_kelamin);
                        $sheet->setCellValue('G' . $rowCount, $element['tempat_lahir']);
                        $sheet->setCellValue('H' . $rowCount, $element['tanggal_lahir']);
                        $sheet->setCellValue('I' . $rowCount, $status_nikah);
                        $sheet->setCellValue('J' . $rowCount, $pekerjaan);
                        $sheet->setCellValue('K' . $rowCount, $element['alamat_ktp']);
                        $sheet->setCellValue('L' . $rowCount, "id_kel");
                        $rowCount++;
                        $no++;
                    }
                    if ($extension == 'csv') {
                        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
                        $fileName = $fileName . '.csv';
                    } elseif ($extension == 'xlsx') {
                        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                        $fileName = $fileName . '.xlsx';
                    } else {
                        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
                        $fileName = $fileName . '.xls';
                    }

                    $this->output->set_header('Content-Type: application/vnd.ms-excel');
                    $this->output->set_header("Content-type: application/csv");
                    $this->output->set_header('Cache-Control: max-age=0');
                    header('Content-Disposition: attachment;filename="' . $fileName . '"');
                    $writer->save($path . $fileName);
                }
            }

            $this->zip->read_dir($path, FALSE);
            $this->zip->download('Laporan_' . $nama_file_zip[0]->nama . '_' . $nama_file_zip[0]->code . '_' . date('d-m-Y') . '_(' . $extension . ')' . '.zip');
        }
    }

    public function export_all_csv() {

        $this->load->helper('download');
        $extension = 'csv';

        $nama_file = $this->Ktpmodel->get_name_file($this->user['id_ref'], $this->user['role_admin']);

        if (!empty($extension)) {
            $extension = $extension;
        } else {
            $extension = 'xlsx';
        }

// get employee list
        $empInfo = $this->Ktpmodel->get_all_ktp($this->user['id_ref'], $this->user['role_admin']);
        $kerja = $this->Ktpmodel->get_pekerjaan();
        $fileName = $nama_file[0]->nama . '_' . $nama_file[0]->code . '_' . date('d-m-Y');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'nik_ktp');
        $sheet->setCellValue('B1', 'nama_ktp');
        $sheet->setCellValue('C1', 'tempat_lahir');
        $sheet->setCellValue('D1', 'tanggal_lahir');
        $sheet->setCellValue('E1', 'jenis_kelamin');
        $sheet->setCellValue('F1', 'gol_darah');
        $sheet->setCellValue('G1', 'alamat_ktp');
        $sheet->setCellValue('H1', 'rt');
        $sheet->setCellValue('I1', 'rw');
        $sheet->setCellValue('J1', 'agama');
        $sheet->setCellValue('K1', 'status_nikah');
        $sheet->setCellValue('L1', 'pekerjaan');
        $sheet->setCellValue('M1', 'nomor_hp');

        $rowCount = 2;
        foreach ($empInfo as $element) {

            $jenis_kelamin = '';
            $gol_darah = '';
            $agama = '';
            $status_nikah = '';
            $pekerjaan = '';

            if ($element['jenis_kelamin'] == '1') {
                $jenis_kelamin = 'laki-laki';
            } elseif ($element['jenis_kelamin'] == '0') {
                $jenis_kelamin = 'perempuan';
            }

            if ($element['gol_darah'] == '1') {
                $gol_darah = 'A';
            } elseif ($element['gol_darah'] == '2') {
                $gol_darah = 'B';
            } elseif ($element['gol_darah'] == '3') {
                $gol_darah = 'AB';
            } elseif ($element['gol_darah'] == '4') {
                $gol_darah = 'O';
            } else {
                $gol_darah = 'lainnya';
            }

            if ($element['agama'] == '1') {
                $agama = 'islam';
            } elseif ($element['agama'] == '2') {
                $agama = 'kristen';
            } elseif ($element['agama'] == '3') {
                $agama = 'hindu';
            } elseif ($element['agama'] == '4') {
                $agama = 'budha';
            } else {
                $agama = 'lainnya';
            }

            if ($element['status_nikah'] == '0') {
                $status_nikah = 'belum menikah';
            } elseif ($element['status_nikah'] == '1') {
                $status_nikah = 'menikah';
            } elseif ($element['status_nikah'] == '2') {
                $status_nikah = 'cerai hidup';
            } elseif ($element['status_nikah'] == '3') {
                $status_nikah = 'cerai mati';
            }

            if (!empty($element['pekerjaan'])) {
                foreach ($kerja as $key => $value) {
                    if ($element['pekerjaan'] == $value->id) {
                        $pekerjaan = $value->job;
                        //var_dump($value->job);
                        //exit;
                    }
                }
            } else {
                $pekerjaan = '';
            }

            $sheet->setCellValue('A' . $rowCount, $element['nik_ktp']);
            $sheet->setCellValue('B' . $rowCount, $element['nama_ktp']);
            $sheet->setCellValue('C' . $rowCount, $element['tempat_lahir']);
            $sheet->setCellValue('D' . $rowCount, $element['tanggal_lahir']);
            $sheet->setCellValue('E' . $rowCount, $jenis_kelamin);
            $sheet->setCellValue('F' . $rowCount, $gol_darah);
            $sheet->setCellValue('G' . $rowCount, $element['alamat_ktp']);
            $sheet->setCellValue('H' . $rowCount, $element['rt']);
            $sheet->setCellValue('I' . $rowCount, $element['rw']);
            $sheet->setCellValue('J' . $rowCount, $agama);
            $sheet->setCellValue('K' . $rowCount, $status_nikah);
            $sheet->setCellValue('L' . $rowCount, $pekerjaan);
            $sheet->setCellValue('M' . $rowCount, $element['nomor_hp_ktp']);
            $rowCount++;
        }

        if ($extension == 'csv') {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
            $fileName = $fileName . '.csv';
        } elseif ($extension == 'xlsx') {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $fileName = $fileName . '.xlsx';
        } else {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
            $fileName = $fileName . '.xls';
        }

        $this->output->set_header('Content-Type: application/vnd.ms-excel');
        $this->output->set_header("Content-type: application/csv");
        $this->output->set_header('Cache-Control: max-age=0');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        $writer->save('php://output');
    }

    public function export_csv_admin($id = '') {

        $this->load->helper('download');
        $extension = 'csv';

        $nama_file = $this->Ktpmodel->get_name_file($this->user['id_ref'], $this->user['role_admin']);

        if (!empty($extension)) {
            $extension = $extension;
        } else {
            $extension = 'xlsx';
        }

// get employee list
        $empInfo = $this->Ktpmodel->get_all_ktp_admin($id, $this->user['id_ref'], $this->user['role_admin']);
        $kerja = $this->Ktpmodel->get_pekerjaan();
        $fileName = $nama_file[0]->nama . '_' . $nama_file[0]->code . '_' . date('d-m-Y');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'nik_ktp');
        $sheet->setCellValue('B1', 'nama_ktp');
        $sheet->setCellValue('C1', 'tempat_lahir');
        $sheet->setCellValue('D1', 'tanggal_lahir');
        $sheet->setCellValue('E1', 'jenis_kelamin');
        $sheet->setCellValue('F1', 'gol_darah');
        $sheet->setCellValue('G1', 'alamat_ktp');
        $sheet->setCellValue('H1', 'rt');
        $sheet->setCellValue('I1', 'rw');
        $sheet->setCellValue('J1', 'agama');
        $sheet->setCellValue('K1', 'status_nikah');
        $sheet->setCellValue('L1', 'pekerjaan');
        $sheet->setCellValue('M1', 'nomor_hp');

        $rowCount = 2;
        foreach ($empInfo as $element) {

            $jenis_kelamin = '';
            $gol_darah = '';
            $agama = '';
            $status_nikah = '';
            $pekerjaan = '';

            if ($element['jenis_kelamin'] == '1') {
                $jenis_kelamin = 'laki-laki';
            } elseif ($element['jenis_kelamin'] == '0') {
                $jenis_kelamin = 'perempuan';
            }

            if ($element['gol_darah'] == '1') {
                $gol_darah = 'A';
            } elseif ($element['gol_darah'] == '2') {
                $gol_darah = 'B';
            } elseif ($element['gol_darah'] == '3') {
                $gol_darah = 'AB';
            } elseif ($element['gol_darah'] == '4') {
                $gol_darah = 'O';
            } else {
                $gol_darah = 'lainnya';
            }

            if ($element['agama'] == '1') {
                $agama = 'islam';
            } elseif ($element['agama'] == '2') {
                $agama = 'kristen';
            } elseif ($element['agama'] == '3') {
                $agama = 'hindu';
            } elseif ($element['agama'] == '4') {
                $agama = 'budha';
            } else {
                $agama = 'lainnya';
            }

            if ($element['status_nikah'] == '0') {
                $status_nikah = 'belum menikah';
            } elseif ($element['status_nikah'] == '1') {
                $status_nikah = 'menikah';
            } elseif ($element['status_nikah'] == '2') {
                $status_nikah = 'cerai hidup';
            } elseif ($element['status_nikah'] == '3') {
                $status_nikah = 'cerai mati';
            }

            if (!empty($element['pekerjaan'])) {
                foreach ($kerja as $key => $value) {
                    if ($element['pekerjaan'] == $value->id) {
                        $pekerjaan = $value->job;
                        //var_dump($value->job);
                        //exit;
                    }
                }
            } else {
                $pekerjaan = '';
            }

            $sheet->setCellValue('A' . $rowCount, $element['nik_ktp']);
            $sheet->setCellValue('B' . $rowCount, $element['nama_ktp']);
            $sheet->setCellValue('C' . $rowCount, $element['tempat_lahir']);
            $sheet->setCellValue('D' . $rowCount, $element['tanggal_lahir']);
            $sheet->setCellValue('E' . $rowCount, $jenis_kelamin);
            $sheet->setCellValue('F' . $rowCount, $gol_darah);
            $sheet->setCellValue('G' . $rowCount, $element['alamat_ktp']);
            $sheet->setCellValue('H' . $rowCount, $element['rt']);
            $sheet->setCellValue('I' . $rowCount, $element['rw']);
            $sheet->setCellValue('J' . $rowCount, $agama);
            $sheet->setCellValue('K' . $rowCount, $status_nikah);
            $sheet->setCellValue('L' . $rowCount, $pekerjaan);
            $sheet->setCellValue('M' . $rowCount, $element['nomor_hp_ktp']);
            $rowCount++;
        }

        if ($extension == 'csv') {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
            $fileName = $fileName . '.csv';
        } elseif ($extension == 'xlsx') {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $fileName = $fileName . '.xlsx';
        } else {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
            $fileName = $fileName . '.xls';
        }

        $this->output->set_header('Content-Type: application/vnd.ms-excel');
        $this->output->set_header("Content-type: application/csv");
        $this->output->set_header('Cache-Control: max-age=0');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        $writer->save('php://output');
    }

    public function export_csv_pet($id = '', $petugas = '') {

        $this->load->helper('download');
        $extension = 'csv';

        $nama_file = $this->Ktpmodel->get_name_file($this->user['id_ref'], $this->user['role_admin']);

        if (!empty($extension)) {
            $extension = $extension;
        } else {
            $extension = 'xlsx';
        }

// get employee list
        $empInfo = $this->Ktpmodel->get_all_ktp_pet($id, $this->user['id_ref'], $this->user['role_admin']);
        $kerja = $this->Ktpmodel->get_pekerjaan();
        $fileName = 'petugas_' . $petugas . '_' . $nama_file[0]->nama . '_' . $nama_file[0]->code . '_' . date('d-m-Y');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'nik_ktp');
        $sheet->setCellValue('B1', 'nama_ktp');
        $sheet->setCellValue('C1', 'tempat_lahir');
        $sheet->setCellValue('D1', 'tanggal_lahir');
        $sheet->setCellValue('E1', 'jenis_kelamin');
        $sheet->setCellValue('F1', 'gol_darah');
        $sheet->setCellValue('G1', 'alamat_ktp');
        $sheet->setCellValue('H1', 'rt');
        $sheet->setCellValue('I1', 'rw');
        $sheet->setCellValue('J1', 'agama');
        $sheet->setCellValue('K1', 'status_nikah');
        $sheet->setCellValue('L1', 'pekerjaan');
        $sheet->setCellValue('M1', 'nomor_hp');

        $rowCount = 2;
        foreach ($empInfo as $element) {

            $jenis_kelamin = '';
            $gol_darah = '';
            $agama = '';
            $status_nikah = '';
            $pekerjaan = '';

            if ($element['jenis_kelamin'] == '1') {
                $jenis_kelamin = 'laki-laki';
            } elseif ($element['jenis_kelamin'] == '0') {
                $jenis_kelamin = 'perempuan';
            }

            if ($element['gol_darah'] == '1') {
                $gol_darah = 'A';
            } elseif ($element['gol_darah'] == '2') {
                $gol_darah = 'B';
            } elseif ($element['gol_darah'] == '3') {
                $gol_darah = 'AB';
            } elseif ($element['gol_darah'] == '4') {
                $gol_darah = 'O';
            } else {
                $gol_darah = 'lainnya';
            }

            if ($element['agama'] == '1') {
                $agama = 'islam';
            } elseif ($element['agama'] == '2') {
                $agama = 'kristen';
            } elseif ($element['agama'] == '3') {
                $agama = 'hindu';
            } elseif ($element['agama'] == '4') {
                $agama = 'budha';
            } else {
                $agama = 'lainnya';
            }

            if ($element['status_nikah'] == '0') {
                $status_nikah = 'belum menikah';
            } elseif ($element['status_nikah'] == '1') {
                $status_nikah = 'menikah';
            } elseif ($element['status_nikah'] == '2') {
                $status_nikah = 'cerai hidup';
            } elseif ($element['status_nikah'] == '3') {
                $status_nikah = 'cerai mati';
            }

            if (!empty($element['pekerjaan'])) {
                foreach ($kerja as $key => $value) {
                    if ($element['pekerjaan'] == $value->id) {
                        $pekerjaan = $value->job;
                        //var_dump($value->job);
                        //exit;
                    }
                }
            } else {
                $pekerjaan = '';
            }

            $sheet->setCellValue('A' . $rowCount, $element['nik_ktp']);
            $sheet->setCellValue('B' . $rowCount, $element['nama_ktp']);
            $sheet->setCellValue('C' . $rowCount, $element['tempat_lahir']);
            $sheet->setCellValue('D' . $rowCount, $element['tanggal_lahir']);
            $sheet->setCellValue('E' . $rowCount, $jenis_kelamin);
            $sheet->setCellValue('F' . $rowCount, $gol_darah);
            $sheet->setCellValue('G' . $rowCount, $element['alamat_ktp']);
            $sheet->setCellValue('H' . $rowCount, $element['rt']);
            $sheet->setCellValue('I' . $rowCount, $element['rw']);
            $sheet->setCellValue('J' . $rowCount, $agama);
            $sheet->setCellValue('K' . $rowCount, $status_nikah);
            $sheet->setCellValue('L' . $rowCount, $pekerjaan);
            $sheet->setCellValue('M' . $rowCount, $element['nomor_hp_ktp']);
            $rowCount++;
        }

        if ($extension == 'csv') {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
            $fileName = $fileName . '.csv';
        } elseif ($extension == 'xlsx') {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $fileName = $fileName . '.xlsx';
        } else {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
            $fileName = $fileName . '.xls';
        }

        $this->output->set_header('Content-Type: application/vnd.ms-excel');
        $this->output->set_header("Content-type: application/csv");
        $this->output->set_header('Cache-Control: max-age=0');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        $writer->save('php://output');
    }

    //---------------------------------------DELETE DATA ANGGOTA KTP---------------------------------------//

    public function delete_ktp() {

        $id = $this->input->post('id');
        $data = $this->Ktpmodel->get_img_by_id_ktp($id, $this->user['id_ref'], $this->user['role_admin']);

        $data_img_ktp = explode('/', $data[0]->img);
        $name_img_ktp = $data_img_ktp[4];
        $data_img_pasfoto = explode('/', $data[0]->img_pas);
        $name_img_pasfoto = $data_img_pasfoto[4];
        $data_img_barcode = explode('/', $data[0]->barcode);
        $name_img_barcode = $data_img_barcode[4];

        $delete = $this->Ktpmodel->delete_ktp($id, $this->user['id_ref'], $this->user['role_admin']);
        if ($delete == true) {
            if ($this->user['role_admin'] == 0) {
                $this->delete_file_ktp($name_img_ktp, $data[0]->id_admin);
                $this->delete_file_pasfoto($name_img_pasfoto, $data[0]->id_admin);
                $this->delete_file_barcode($name_img_barcode, $data[0]->id_admin);
            }
            echo '1|' . succ_msg('Berhasil, Data Telah Terhapus..');
        } else {
            echo '0|' . err_msg('Maaf, Terjadi kesalahan, Coba lagi....');
        }
    }

    public function delete_file_ktp($name = '', $id = '') {

        $path_reg = $this->Ktpmodel->get_path_by_id_reg($id);

        $path = $path_reg[0]->path . '/';
        $path_thumb = $path_reg[0]->path . '/thumbs/';
        @unlink($path . $name);
        @unlink($path_thumb . $name);
    }

    public function delete_file_pasfoto($name = '', $id = '') {

        $path_reg = $this->Ktpmodel->get_path_by_id_reg($id);

        $path = $path_reg[0]->path . '/';
        $path_thumb = $path_reg[0]->path . '/pasfoto_thumbs/';
        @unlink($path . $name);
        @unlink($path_thumb . $name);
    }

    public function delete_file_barcode($name = '', $id = '') {

        $path_reg = $this->Ktpmodel->get_path_by_id_reg($id);

        $path_thumb = $path_reg[0]->path . '/barcode/';
        @unlink($path_thumb . $name);
    }

    //---------------------------------------UBAH STATUS DATA ANGGOTA KTP---------------------------------------//


    public function ubah_status_ktp() {

        $id = $this->input->post('id');
        $status = $this->input->post('status');

        if (isset($id) && isset($status)) {
            $this->Ktpmodel->ubah_status_ktp($id, $status);
            echo '1|' . succ_msg('Berhasil, Data Telah Terupdate..');
        } else {
            echo '0|' . err_msg('Maaf, Terjadi kesalahan, Coba lagi....');
        }
    }

    //---------------------------------------GET AJAX ANGGOTA KTP---------------------------------------//

    function add_ajax_kab($id_prov) {
        $query = $this->db->get_where('wilayah_kabupaten', array('id_dati1' => $id_prov));
        $data = "<option></option>";
        foreach ($query->result() as $value) {
            $data .= "<option value='" . $value->id . "'>" . $value->nama . " [" . strtoupper($value->administratif) . "]" . "</option>";
        }
        echo $data;
    }

    function add_ajax_kec($id_prov, $id_kab) {
        $query = $this->db->get_where('wilayah_kecamatan', array('id_dati1' => $id_prov, 'id_dati2' => $id_kab));
        $data = "<option></option>";
        foreach ($query->result() as $value) {
            $data .= "<option value='" . $value->id . "'>" . $value->nama . "</option>";
        }
        echo $data;
    }

    function add_ajax_des($id_prov, $id_kab, $id_kec) {
        $query = $this->db->get_where('wilayah_desa', array('id_dati1' => $id_prov, 'id_dati2' => $id_kab, 'id_dati3' => $id_kec));
        $data = "<option></option>";
        foreach ($query->result() as $value) {
            $data .= "<option value='" . $value->id . "'>" . $value->nama . " [" . strtoupper($value->administratif) . "]" . "</option>";
        }
        echo $data;
    }

}
