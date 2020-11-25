<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Laporanpemilihan extends MX_Controller {

    public function __construct() {
        parent::__construct();
//Do your magic here 
        $this->load->model('Laporanpemilihanmodel');
        if ($this->session->userdata('ktpapps') == FALSE) {
            redirect('auth');
        }
        $this->load->library("Pdf");
        $this->load->library('user_agent');
        $this->load->library('pdfgenerator');
        $this->user = $this->session->userdata("ktpapps");
    }

//---------------------------------------CETAK KARTU MANDAT---------------------------------------//

    public function cetak_kartu_mandat($id_saksi = '', $id_pemilihan = '') {

        $data['prov'] = $this->Laporanpemilihanmodel->get_provinsi(); //?
        $data['kab'] = $this->Laporanpemilihanmodel->get_kabupaten(); //?
        $data['kec'] = $this->Laporanpemilihanmodel->get_kecamatan(); //?
        $data['kel'] = $this->Laporanpemilihanmodel->get_kelurahan(); //?

        $data['kartu_mandat'] = $this->Laporanpemilihanmodel->cetak_kartu_mandat_id($id_saksi, $id_pemilihan);
        if (empty($data['kartu_mandat'])) {            //add new data
            $this->session->set_flashdata('flash_message', err_msg('Maaf, Data ID masih kosong...'));
            redirect('pemilihan/daftar_petugas_saksi/' . $id_pemilihan);
        } else {
//$this->load->view('cetak_kta_all', $data);
            $html = $this->load->view('cetak_kartu_mandat', $data, true);
            $this->pdfgenerator->generate($html, 'kartu_mandat_saksi');
        }
    }

//---------------------------------------CETAK KARTU MANDAT ALL---------------------------------------//

    public function cetak_kartu_mandat_all($id_pemilihan = '') {

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        if ($data['data_check'] == '' or $data['data_check'] == NULL) {

            $this->session->set_flashdata('flash_message', warn_msg('Pilih data terlebih dahulu'));
            redirect('pemilihan/daftar_petugas_saksi/' . $id_pemilihan);
        } else {
            $data['kartu_mandat'] = $this->Laporanpemilihanmodel->cetak_all_kartu_mandat($id_pemilihan, $data['data_check']);
//            var_dump($data);
//            exit;
            if (empty($data['kartu_mandat'])) {            //add new data
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Data Petugas Saksi masih kosong...'));
                redirect('pemilihan/daftar_petugas_saksi/' . $id_pemilihan);
            } else {
                $html = $this->load->view('cetak_laporan_kartu_mandat', $data, true);
                $this->pdfgenerator->generate($html, 'laporan_kartu_mandat_semua');
            }
        }
    }

//---------------------------------------CETAK SAKSI ALL---------------------------------------//

    public function export_all_saksi_csv($id_pemilihan = '') {
        $this->load->helper('download');

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);
        $extension = 'xls';

        $nama_file = $this->Laporanpemilihanmodel->get_nama_pemilihan($id_pemilihan);

        if (!empty($extension)) {
            $extension = $extension;
        } else {
            $extension = 'xlsx';
        }
        if ($data['data_check'] == '' or $data['data_check'] == NULL) {
            $this->session->set_flashdata('flash_message', warn_msg('Pilih data terlebih dahulu'));
            redirect('pemilihan/daftar_petugas_saksi/' . $id_pemilihan);
        } else {
// get employee list
            $empInfo = $this->Laporanpemilihanmodel->get_all_saksi($id_pemilihan, $data['data_check']);

            $fileName = $nama_file[0]->nama_pemilihan . '_' . $nama_file[0]->tahun_pemilihan . '_' . date('d-m-Y');

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'No.');
            $sheet->setCellValue('B1', 'Nomor KTP');
            $sheet->setCellValue('C1', 'Nama Saksi');
            $sheet->setCellValue('D1', 'Email Saksi');
            $sheet->setCellValue('E1', 'Nama TPS');
            $sheet->setCellValue('F1', 'Nomor HP Saksi');

            $rowCount = 2;
            foreach ($empInfo as $element) {

                $sheet->setCellValue('A' . $rowCount, $rowCount - 1);
                $sheet->setCellValue('B' . $rowCount, $element['nomor_ktp_saksi']);
                $sheet->setCellValue('C' . $rowCount, strtoupper($element['nama_saksi']));
                $sheet->setCellValue('D' . $rowCount, $element['email_saksi']);
                $sheet->setCellValue('E' . $rowCount, strtoupper($element['nama_tps'] . ' ' . $element['nomor_tps']));
                $sheet->setCellValue('F' . $rowCount, $element['nomor_hp_saksi']);

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
    }

//---------------------------------------CETAK SAKSI ALL---------------------------------------//

    public function export_all_tps_csv($id_pemilihan = '') {
        $this->load->helper('download');
        $this->load->library('zip');
        $this->load->helper('file');

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);
        $extension = 'xls';

        $nama_file = $this->Laporanpemilihanmodel->get_nama_pemilihan($id_pemilihan);

        if (!empty($extension)) {
            $extension = $extension;
        } else {
            $extension = 'xlsx';
        }

        $path = './uploads/laporan/excel/';
        delete_files($path);

        if ($data['data_check'] == '' or $data['data_check'] == NULL) {
            $this->session->set_flashdata('flash_message', warn_msg('Pilih data terlebih dahulu'));
            redirect('pemilihan/daftar_region_pemilihan/' . $id_pemilihan);
        } else {

            $get_wilayah = $this->Laporanpemilihanmodel->get_regional_pemilihan($data['data_check']);

            foreach ($get_wilayah as $value) {

                $empInfo = $this->Laporanpemilihanmodel->get_data_tps($id_pemilihan, $value->id_wilayah_pemilihan);
                $fileName = $value->provinsi . '_' . $value->kabupaten . '_' . $value->kecamatan . '_' . $value->kelurahan . '_' . date('d-m-Y');
//                var_dump($empInfo);
//                exit;

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                $sheet->setCellValue('A2', 'Kelurahan');
                $sheet->setCellValue('A3', 'Kecamatan');
                $sheet->setCellValue('B2', $value->kelurahan);
                $sheet->setCellValue('B3', $value->kecamatan);

                $sheet->setCellValue('F2', 'Kabupaten/Kota');
                $sheet->setCellValue('F3', 'Propinsi');
                $sheet->setCellValue('G2', $value->kabupaten);
                $sheet->setCellValue('G3', $value->provinsi);

                $sheet->setCellValue('A5', 'No');
                $sheet->setCellValue('B5', 'Nama TPS');
                $sheet->setCellValue('C5', 'Petugas Saksi');
                $sheet->setCellValue('D5', 'Data Pemilih DPT (Lk)');
                $sheet->setCellValue('E5', 'Data Pemilih DPT (Pr)');
                $sheet->setCellValue('F5', 'TOTAL DP DPT');
                $sheet->setCellValue('G5', 'Data Pemilih DPPH (Lk)');
                $sheet->setCellValue('H5', 'Data Pemilih DPPH (Pr)');
                $sheet->setCellValue('I5', 'TOTAL DP DPPH');
                $sheet->setCellValue('J5', 'Data Pemilih DPTB (Lk)');
                $sheet->setCellValue('K5', 'Data Pemilih DPTB (Pr)');
                $sheet->setCellValue('L5', 'TOTAL DP DPTB');
                $sheet->setCellValue('M5', 'TOTAL DP (DPT,PPH,DPTB)');
                $sheet->setCellValue('N5', 'Pengguna Hak Pilih DPT (Lk)');
                $sheet->setCellValue('O5', 'Pengguna Hak Pilih DPT (Pr)');
                $sheet->setCellValue('P5', 'TOTAL PHP DPT');
                $sheet->setCellValue('Q5', 'Pengguna Hak Pilih DPPH (Lk)');
                $sheet->setCellValue('R5', 'Pengguna Hak Pilih DPPH (Pr)');
                $sheet->setCellValue('S5', 'TOTAL PHP DPPH');
                $sheet->setCellValue('T5', 'Pengguna Hak Pilih DPTB (Lk)');
                $sheet->setCellValue('U5', 'Pengguna Hak Pilih DPTB (Pr)');
                $sheet->setCellValue('V5', 'TOTAL PHP DPTB');
                $sheet->setCellValue('W5', 'TOTAL PHP (DPT,PPH,DPTB)');
                $sheet->setCellValue('X5', 'TOTAL SUARA SAH');
                $sheet->setCellValue('Y5', 'TOTAL SUARA TIDAK SAH');

                $rowCount = 6;
                $no = 1;
                foreach ($empInfo as $element) {

                    $sheet->setCellValue('A' . $rowCount, $no);
                    $sheet->setCellValue('B' . $rowCount, strtoupper($element['nama_tps'] . ' ' . $element['nomor_tps']));
                    $sheet->setCellValue('C' . $rowCount, strtoupper($element['nama_saksi']));
                    $sheet->setCellValue('D' . $rowCount, $element['dp_dpt_laki_laki']);
                    $sheet->setCellValue('E' . $rowCount, $element['dp_dpt_perempuan']);
                    $sheet->setCellValue('F' . $rowCount, intval($element['dp_dpt_laki_laki']) + intval($element['dp_dpt_perempuan']));
                    $sheet->setCellValue('G' . $rowCount, $element['dp_dpph_laki_laki']);
                    $sheet->setCellValue('H' . $rowCount, $element['dp_dpph_perempuan']);
                    $sheet->setCellValue('I' . $rowCount, intval($element['dp_dpph_laki_laki']) + intval($element['dp_dpph_perempuan']));
                    $sheet->setCellValue('J' . $rowCount, $element['dp_dptb_laki_laki']);
                    $sheet->setCellValue('K' . $rowCount, $element['dp_dptb_perempuan']);
                    $sheet->setCellValue('L' . $rowCount, intval($element['dp_dptb_laki_laki']) + intval($element['dp_dptb_perempuan']));
                    $sheet->setCellValue('M' . $rowCount, $element['dp_total']);
                    $sheet->setCellValue('N' . $rowCount, $element['php_dpt_laki_laki']);
                    $sheet->setCellValue('O' . $rowCount, $element['php_dpt_perempuan']);
                    $sheet->setCellValue('P' . $rowCount, intval($element['php_dpt_laki_laki']) + intval($element['php_dpt_perempuan']));
                    $sheet->setCellValue('Q' . $rowCount, $element['php_dpph_laki_laki']);
                    $sheet->setCellValue('R' . $rowCount, $element['php_dpph_perempuan']);
                    $sheet->setCellValue('S' . $rowCount, intval($element['php_dpph_laki_laki']) + intval($element['php_dpph_perempuan']));
                    $sheet->setCellValue('T' . $rowCount, $element['php_dptb_laki_laki']);
                    $sheet->setCellValue('U' . $rowCount, $element['php_dptb_perempuan']);
                    $sheet->setCellValue('V' . $rowCount, intval($element['php_dptb_laki_laki']) + intval($element['php_dptb_perempuan']));
                    $sheet->setCellValue('W' . $rowCount, $element['php_total']);
                    $sheet->setCellValue('X' . $rowCount, $element['total_suara_sah']);
                    $sheet->setCellValue('Y' . $rowCount, $element['total_suara_tidak_sah']);

                    $no++;
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
                header('Content-Disposition: attachment;filename="LAPORAN_TPS' . $fileName . '"');
                $writer->save($path . $fileName);
            }
            $this->zip->read_dir($path, FALSE);
            $this->zip->download('LAPORAN_TPS' . $nama_file[0]->nama_pemilihan . '_' . $nama_file[0]->tahun_pemilihan . '_' . date('d-m-Y') . '_(' . $extension . ')' . '.zip');
        }
    }

    //---------------------------------------ZIP DATA ANGGOTA KTP---------------------------------------//

    public function zip_data_tps($id_pemilihan = '') {
        $this->load->library('zip');

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        date_default_timezone_set("Asia/Jakarta");
        $date = date('Y-m-d H-i-s', time());
        $illegalChar = array(".", ",", "?", "!", ":", ";", "-", "+", "<", ">", "%", "~", "€", "$", "[", "]", "{", "}", "@", "&", "#", "*", "„", "|", "'", '"', " ");

        if ($data['data_check'] == '' or $data['data_check'] == NULL) {
            $this->session->set_flashdata('flash_message', warn_msg('Pilih data terlebih dahulu'));
            redirect('pemilihan/daftar_region_pemilihan/' . $id_pemilihan);
        } else {
            $pemilihan = $this->Laporanpemilihanmodel->get_nama_pemilihan($id_pemilihan);
            $get_wilayah = $this->Laporanpemilihanmodel->get_regional_pemilihan($data['data_check']);
            $name = 'TOLONG_DIBACA.txt';

            if (!empty($get_wilayah)) {
                foreach ($get_wilayah as $key => $value) {

                    $name_reg = $pemilihan[0]->nama_pemilihan . '_' . $pemilihan[0]->tahun_pemilihan . '_' . $value->provinsi . '_' . $value->kabupaten . '_' . $value->kecamatan . '_' . $value->kelurahan . '_' . $date;
                    $name_reg_done = strtoupper(str_replace($illegalChar, '_', $name_reg));
                    $data = "JANGAN DIHAPUS!!, INI MERUPAKAN BACKUP DATA WILAYAH DAN TPS, JIKA ADA WILAYAH/TPS YANG BELUM KEARSIP, MAKA TPS TERSEBUT MASIH KOSONG/BELUM PROSES SUBMIT. TERIMA KASIH";

                    $archive_file_name = 'DATA_' . $name_reg_done . '.zip';

                    $dir_path = $pemilihan[0]->path_pemilihan . '/'
                            . $value->provinsi . '_' . $value->id_provinsi . '/'
                            . $value->kabupaten . '_' . $value->id_kabupaten . '/'
                            . $value->kecamatan . '_' . $value->id_kecamatan . '/'
                            . $value->kelurahan . '_' . $value->id_kelurahan . '/';

                    $dir_path_done = strtoupper(str_replace($illegalChar, '_', $dir_path));
                    //var_dump($pemilihan[0]->path_pemilihan);exit;
                    $rootPath = realpath(FCPATH . $dir_path_done);

                    $this->zip->read_dir($rootPath, FALSE);
                }
                $this->zip->add_data($name, $data);
                $this->zip->download($archive_file_name);
            }
        }
    }

    //---------------------------------------CETAK TPS ALL---------------------------------------//

    public function cetak_tps_all($id_pemilihan = '') {
        $this->load->library('zip');
        $this->load->helper('file');

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        date_default_timezone_set("Asia/Jakarta");
        $date = date('Y-m-d H-i-s', time());
        $illegalChar = array(".", ",", "?", "!", ":", ";", "-", "+", "<", ">", "%", "~", "€", "$", "[", "]", "{", "}", "@", "&", "#", "*", "„", "|", "'", '"', " ");

        $path = './uploads/laporan/pdf/';
        delete_files($path);

        if ($data['data_check'] == '' or $data['data_check'] == NULL) {

            $this->session->set_flashdata('flash_message', warn_msg('Pilih data terlebih dahulu'));
            redirect('pemilihan/daftar_region_pemilihan/' . $id_pemilihan);
        } else {
            $pemilihan = $this->Laporanpemilihanmodel->get_nama_pemilihan($id_pemilihan);
            $get_wilayah = $this->Laporanpemilihanmodel->get_regional_pemilihan($data['data_check']);
            $data['calon'] = $this->Laporanpemilihanmodel->get_calon($id_pemilihan);

            $data['arr_calon'] = [];
            foreach ($data['calon'] as $value) {
                $data['arr_calon'][] = $value->id_calon_pemilihan;
            }

            if (!empty($get_wilayah)) {
                foreach ($get_wilayah as $key => $value) {

                    $data['nama_pemilihan'] = $this->Laporanpemilihanmodel->get_nama_pemilihan($id_pemilihan);
                    $data['get_nama_wilayah'] = $this->Laporanpemilihanmodel->get_nama_wilayah($value->id_wilayah_pemilihan);
                    $data['get_tambah_nama_wilayah'] = $this->Laporanpemilihanmodel->get_sum_hasil_pemilihan($id_pemilihan, $value->id_wilayah_pemilihan);
                    $data['hasil_pemilihan'] = $this->Laporanpemilihanmodel->get_hasil_pemilihan($id_pemilihan, $value->id_wilayah_pemilihan);
                    $data['suara_calon'] = $this->Laporanpemilihanmodel->get_hasil_suara_calon($id_pemilihan, $value->id_wilayah_pemilihan);

                    $name_reg = $pemilihan[0]->nama_pemilihan . '_' . $pemilihan[0]->tahun_pemilihan . '_' . $value->provinsi . '_' . $value->kabupaten . '_' . $value->kecamatan . '_' . $value->kelurahan . '_' . $date;
                    $name_reg_done = strtoupper(str_replace($illegalChar, '_', $name_reg));
                    $archive_file_name = 'DATA_TPS_' . $name_reg_done . '.pdf';

                    $html = $this->load->view('cetak_laporan_tps', $data, true);
                    $this->pdfgenerator->generate($html, 'Laporan_TPS', FALSE, 'A4', "landscape", FCPATH . '/' . $path . '/' . $archive_file_name);
                }
                $this->zip->read_dir($path, FALSE);
                $this->zip->download('LAPORAN_TPS_' . $pemilihan[0]->nama_pemilihan . '_' . $pemilihan[0]->tahun_pemilihan . '_' . date('d-m-Y') . '_(pdf)' . '.zip');
            }
        }
    }

    //------------------------------------------------------------------------------------------//
}
