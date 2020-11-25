<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends MX_Controller {

    public function __construct() {
        parent::__construct();
        //Do your magic here 
        $this->load->model('Laporanmodel');
        if ($this->session->userdata('ktpapps') == FALSE) {
            redirect('auth');
        }
        $this->load->library("Pdf");
        $this->load->library('user_agent');
        $this->load->library('pdfgenerator');
        $this->user = $this->session->userdata("ktpapps");
    }

    //---------------------------------------CETAK LAPORAN ALL---------------------------------------//

    public function cetak_laporan_all() {
        $this->load->library('zip');
        $this->load->helper('file');

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $path = './uploads/laporan/pdf/';
        delete_files($path);

        $nama_file_zip = $this->Laporanmodel->get_name_file($this->user['id_ref'], $this->user['role_admin']);

        //var_dump($laporan);exit;
        $laporan = $this->Laporanmodel->get_laporan($this->user['id_ref'], $this->user['role_admin']); //?

        if ($data['data_check'] == '' or $data['data_check'] == NULL) {
            $this->session->set_flashdata('flash_message', warn_msg('Pilih data terlebih dahulu'));
            redirect('ktp/');
        } else {
            if (empty($laporan)) {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Data Laporan Anggota masih kosong...'));
                redirect('ktp/ktp');
            } else {
                if (empty($data)) {            //add new data
                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Data Anggota masih kosong...'));
                    redirect('ktp/ktp');
                } else {

                    $get_distinct_data = $this->Laporanmodel->get_ktp_id_by_distinct($this->user['id_ref'], $this->user['role_admin'], $data['data_check']);
                    $kerja = $this->Laporanmodel->get_pekerjaan();
//                    var_dump($get_distinct_data);
//                    exit;
                    foreach ($get_distinct_data as $value) {

                        $data = $this->Laporanmodel->get_ktp_by_id_asal($value->id_asal, $this->user['id_ref'], $this->user['role_admin']);
//                        var_dump($data);
//                        exit;
                        $fileName = $value->provinsi . '_' . $value->kabupaten . '-' . $value->kecamatan . '-' . $value->kelurahan . '-' . date('d-m-Y');

                        $pdfArray = array();
                        // create new PDF document
                        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                        // set document information
                        $pdf->SetCreator(PDF_CREATOR);
                        $pdf->SetAuthor(PDF_HEADER_TITLE);
                        $pdf->SetTitle('Daftar Laporan E-KTP');
                        $pdf->SetSubject('Laporan E-KTP');
                        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
                        // set margins
                        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_BOTTOM, PDF_MARGIN_RIGHT);
                        // Call before the addPage() method
                        $pdf->SetPrintHeader(false);
                        $pdf->SetPrintFooter(false);
                        // set auto page breaks
                        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                        // set image scale factor
                        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
                        // set some language-dependent strings (optional)
                        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
                            require_once(dirname(__FILE__) . '/lang/eng.php');
                            $pdf->setLanguageArray($l);
                        }
                        // set font
                        $pdf->SetFont('helvetica', 'B', 12);
                        // add a page
                        $pdf->AddPage('L', 'A4');
                        //$pdf->Cell(0, 0, 'Proyek Jalan Malang', 1, 1, 'C');
                        $pdf->SetFont('times', '', 10);
                        // Table with rowspans and THEAD
                        $theader = '
               
            <div align="center">
             <img width="110px" height="110px" src="' . base_url() . $laporan[0]->img . '">
                 </br>
            </div>
            <table border style="width:100%;" >
                <tr>
                    <td width="4%"></td> 
                    <td width="8%"></td>             
                    <td width="56%"></td>
                    <td width="8%"></td>
                    <td align="center" border="3" width="23%" height="27">                        
                        <b style="margin-top:10px;" >' . strtoupper($laporan[0]->jenis_laporan) . '</b>                      
                     </td>
                </tr>
            </table>
            </br>
            <h2 align="center">' . strtoupper($laporan[0]->header_laporan) . '<br/><br/></h2>
            
            <table border style="width:100%;" >
            <thead>                  
               <tr>
                    <td width="4%"></td> 
                    <td width="8%">Kelurahan :</td>             
                    <td width="61%">' . $value->kelurahan . '</td>
                    <td width="8%" >Kabupaten :</td>
                    <td width="20%">' . $value->kabupaten . '</td>
               </tr>
               <tr> 
                    <td width="4%"></td> 
                    <td width="8%">Kecamatan :</td>             
                    <td width="61%">' . $value->kecamatan . '</td>
                    <td width="8%">Provinsi :</td>
                    <td width="20%">' . $value->provinsi . '</td>
               </tr>
            </thead>
            </table>
             <br></br>
             <br></br>
            <table border="0.2" style="width:100%;" >
            <thead>                  
             <tr align="center">
              <td width="4%"><b>NO</b></td>             
              <td width="17%"><b>NAMA</b></td>
              <td width="16%"><b>NIK</b></td>
              <td width="13%"><b>TGL/BLN/THN/LAHIR</b></td>
              <td width="10%"><b>JENIS KELAMIN (L/P)</b></td>
              <td width="14%"><b>PEKERJAAN</b></td>
              <td width="14%"><b>ALAMAT LENGKAP</b></td>
              <td width="12%"><b>TANDA TANGAN/CAP JEMPOL</b></td>             
             </tr>
             
             <tr align="center" style="background-color:#E0E0E0;">
              <td width="4%">1</td>             
              <td width="17%">2</td>
              <td width="16%">3</td>
              <td width="13%">4</td>
              <td width="10%">5</td>
              <td width="14%">6</td>
              <td width="14%">7</td>
              <td width="12%">8</td>            
             </tr>
            </thead>';

                        array_push($pdfArray, $theader);
                        $i = 1;
                        foreach ($data as $key => $val) {
                            $jk = '';
                            $pekerjaan = '';
                            if ($val->jenis_kelamin == 0) {
                                $jk = 'P';
                            } else if ($val->jenis_kelamin == 1) {
                                $jk = 'L';
                            }
                            if (!empty($val->pekerjaan)) {
                                foreach ($kerja as $key => $values) {
                                    if ($val->pekerjaan == $values->id) {
                                        $pekerjaan = $values->job;
                                        //var_dump($value->job);
                                        //exit;
                                    }
                                }
                            } else {
                                $pekerjaan = '';
                            }
                            $tcontent = '<tbody><tr>
                        <td width="4%" align="center">' . $i . '</td>                       
                        <td width="17%">' . strtoupper($val->nama_ktp) . '</td>
                        <td width="16%">' . strtoupper($val->nik_ktp) . '</td>
                        <td width="13%">' . strtoupper($val->tempat_lahir) . ", " . strtoupper($val->tanggal_lahir) . '</td>
                        <td width="10%" align="center">' . strtoupper($jk) . '</td>
                        <td width="14%">' . strtoupper($pekerjaan) . '</td>
                        <td width="14%">' . strtoupper($val->alamat_ktp) . ', RT.' . $val->rt . ', RW.' . $val->rw . '</td>
                        <td width="12%"></td>
                       </tr></tbody>';
                            $i++;
                            array_push($pdfArray, $tcontent);
                        }
                        $tbot = '</table>
                            <br></br>
                            <br></br>
                            <br></br>
                            <table border style="width:100%;" >
                                <tr>
                                    <td width="4%"></td> 
                                    <td width="8%"></td>             
                                    <td width="56%"></td>
                                    <td width="8%"></td>
                                    <td align="center"width="23%">                        
                                       …………………………………………… 2018                     
                                     </td>
                                </tr>
                                <tr>
                                    <td width="4%"></td> 
                                    <td width="8%"></td>             
                                    <td width="56%"></td>
                                    <td width="4%"></td>
                                    <td align="center"width="30%">                                         
                                    </td>
                                 </tr>                
                                 <tr>
                                    <td width="4%"></td> 
                                    <td width="8%"></td>             
                                    <td width="56%"></td>
                                    <td width="4%"></td>
                                    <td align="center"width="30%">                        
                                      <b>BAKAL CALON YANG BERSANGKUTAN</b>                 
                                    </td>
                                </tr>
                                <tr>
                                <td width="4%"></td> 
                                    <td width="8%"></td>             
                                    <td width="56%"></td>
                                    <td width="4%"></td>
                                    <td align="center"width="30%">                                        
                                    </td>
                                 </tr>
                                  <tr>
                                <td width="4%"></td> 
                                    <td width="8%"></td>             
                                    <td width="56%"></td>
                                    <td width="4%"></td>
                                    <td align="center"width="30%">                                        
                                    </td>
                                 </tr>
                                <tr>
                                    <td width="4%"></td> 
                                    <td width="8%"></td>             
                                    <td width="56%"></td>
                                    <td width="6%"></td>
                                    <td align="center" border="1" width="12%" height="55">                        
                                      Materai 6000                 
                                    </td>
                                </tr>
                                 <tr>
                                 <td width="4%"></td> 
                                    <td width="8%"></td>             
                                    <td width="56%"></td>
                                    <td width="4%"></td>
                                    <td align="center"width="30%">                                         
                                    </td>
                                 </tr>
                                  <tr>
                                <td width="4%"></td> 
                                    <td width="8%"></td>             
                                    <td width="56%"></td>
                                    <td width="4%"></td>
                                    <td align="center"width="30%">                                        
                                    </td>
                                 </tr>
                                <tr>
                                    <td width="4%"></td> 
                                    <td width="8%"></td>             
                                    <td width="56%"></td>
                                    <td width="4%"></td>
                                    <td align="center"width="30%">                        
                                      (………………………...…………….)                
                                    </td>
                                </tr>
                            </table>
                             <br></br>
                             <br></br>
                             <br></br>
                            <table border style="width:100%;" >                
                             <tr>
                              <td width="100%"><font size="11"><b>Keterangan: </b>                  
                                  <br/> 1. *) Coret yang tidak diperlukan. 
                                  <br/> 2. Pada kolom 7 ditulis lengkap RT dan RW atau Dusun.
                                  <br/> 3. Formulir ini dapat diperbanyak oleh calon Anggotan DPD, apabila tidak mencukupi.
                                  </font>
                              </td>
                             </tr>    
                            </table>';
                        array_push($pdfArray, $tbot);
                        $table = implode(" ", $pdfArray);

                        $tbl = <<<EOD
                {$table}
EOD;
                        $pdf->writeHTML($tbl, true, false, false, false, '');

// ---------------------------------------------------------
//Close and output PDF document
                        if ($this->agent->is_browser('Safari')) {
                            $pdf->Output(FCPATH . '/' . $path . '/' . $fileName . '.pdf', 'F');
                        } else {
                            $pdf->Output(FCPATH . '/' . $path . '/' . $fileName . '.pdf', 'F');
                        }
                    }
                    $this->zip->read_dir($path, FALSE);
                    $this->zip->download('Laporan_' . $nama_file_zip[0]->nama . '_' . $nama_file_zip[0]->code . '_' . date('d-m-Y') . '_(pdf)' . '.zip');
                }
            }
        }
    }

//---------------------------------------CETAK KTA dan KTP ALL---------------------------------------//

    public function cetak_kta_all() {

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        if ($data['data_check'] == '' or $data['data_check'] == NULL) {

            $this->session->set_flashdata('flash_message', warn_msg('Pilih data terlebih dahulu'));
            redirect('ktp/ktp');
        } else {

            $data['kta'] = $this->Laporanmodel->cetak_kta_all($this->user['id_ref'], $this->user['role_admin'], $data['data_check']);

            if (empty($data['kta'])) {            //add new data
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Data ID masih kosong...'));
                redirect('ktp/ktp');
            } else {
                $html = $this->load->view('cetak_kta_all', $data, true);
                $this->pdfgenerator->generate($html, 'laporan_kartu_tanda_anggota');
            }
        }
    }

    //---------------------------------------CETAK KTA REG ADMIN---------------------------------------//

    public function cetak_kta_admin($id = '') {

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        if ($data['data_check'] == '' or $data['data_check'] == NULL) {

            $this->session->set_flashdata('flash_message', warn_msg('Pilih data terlebih dahulu'));
            redirect('ktp/lihat_ktp_admin/' . $id);
        } else {

            $id_admin = $this->Laporanmodel->get_by_id_admin_reg($id);
            $data['kta'] = $this->Laporanmodel->cetak_kta_admin($id, $id_admin[0]->id_ref, $id_admin[0]->role_admin, $data['data_check']);

            if (empty($data['kta'])) {            //add new data
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Data ID masih kosong...'));
                redirect('ktp/lihat_ktp_admin/' . $id);
            } else {
                $html = $this->load->view('cetak_kta_all', $data, true);
                $this->pdfgenerator->generate($html, 'laporan_kartu_tanda_anggota');
            }
        }
    }

    //---------------------------------------CETAK KTA PET---------------------------------------//

    public function cetak_kta_pet($id = '') {
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        if ($data['data_check'] == '' or $data['data_check'] == NULL) {

            $this->session->set_flashdata('flash_message', warn_msg('Pilih data terlebih dahulu'));
            redirect('ktp/lihat_ktp_pet/' . $id);
        } else {

            $id_admin = $this->Laporanmodel->get_by_id_admin_pet($id);
            $data['kta'] = $this->Laporanmodel->cetak_kta_pet($id, $id_admin[0]->id_ref, $id_admin[0]->role_admin, $data['data_check']);

            if (empty($data['kta'])) {            //add new data
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Data ID masih kosong...'));
                redirect('ktp/lihat_ktp_pet/' . $id);
            } else {
                $html = $this->load->view('cetak_kta_all', $data, true);
                $this->pdfgenerator->generate($html, 'laporan_kartu_tanda_anggota');
            }
        }
    }

    //---------------------------------------CETAK KTA ID---------------------------------------//

    public function cetak_kta($id = '') {

        $data['prov'] = $this->Laporanmodel->get_provinsi(); //?
        $data['kab'] = $this->Laporanmodel->get_kabupaten(); //?
        $data['kec'] = $this->Laporanmodel->get_kecamatan(); //?
        $data['kel'] = $this->Laporanmodel->get_kelurahan(); //?
        $data['kta'] = $this->Laporanmodel->cetak_kta_id($id, $this->user['id_ref'], $this->user['role_admin']);
        if (empty($data['kta'])) {            //add new data
            $this->session->set_flashdata('flash_message', err_msg('Maaf, Data ID masih kosong...'));
            redirect('ktp/ktp');
        } else {
            //$this->load->view('cetak_kta_all', $data);
            $html = $this->load->view('cetak_kta', $data, true);
            $this->pdfgenerator->generate($html, 'kartu_tanda_anggota');
        }
    }

//---------------------------------------CETAK KTA KTP ID---------------------------------------//

    public function cetak_kta_ktp($id = '') {

        $data['prov'] = $this->Laporanmodel->get_provinsi(); //?
        $data['kab'] = $this->Laporanmodel->get_kabupaten(); //?
        $data['kec'] = $this->Laporanmodel->get_kecamatan(); //?
        $data['kel'] = $this->Laporanmodel->get_kelurahan(); //?
        $data['kta'] = $this->Laporanmodel->cetak_kta_id($id, $this->user['id_ref'], $this->user['role_admin']);
        if (empty($data['kta'])) {            //add new data
            $this->session->set_flashdata('flash_message', err_msg('Maaf, Data ID masih kosong...'));
            redirect('ktp/ktp');
        } else {
            //$this->load->view('cetak_kta_all', $data);
            $html = $this->load->view('cetak_kta_ktp', $data, true);
            $this->pdfgenerator->generate($html, 'kartu_tanda_anggota');
        }
    }

    //---------------------------------------CETAK KTP ALL---------------------------------------//

    public function cetak_ktp_all() {

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        if ($data['data_check'] == '' or $data['data_check'] == NULL) {

            $this->session->set_flashdata('flash_message', warn_msg('Pilih data terlebih dahulu'));
            redirect('ktp/ktp');
        } else {
            $data['laporan'] = $this->Laporanmodel->get_laporan($this->user['id_ref'], $this->user['role_admin']); //?
            $data['ktp'] = $this->Laporanmodel->cetak_all_ktp($this->user['id_ref'], $this->user['role_admin'], $data['data_check']);

            if (empty($data['laporan'])) {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Data Laporan Anggota masih kosong...'));
                redirect('ktp/ktp');
            } else {
                if (empty($data['ktp'])) {            //add new data
                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Data Anggota masih kosong...'));
                    redirect('ktp/ktp');
                } else {
                    $html = $this->load->view('cetak_laporan_foto', $data, true);
                    $this->pdfgenerator->generate($html, 'laporan_foto_semua');
                }
            }
        }
    }

    //---------------------------------------CETAK KTA ALL---------------------------------------//

    public function cetak_kta_only_all() {

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        if ($data['data_check'] == '' or $data['data_check'] == NULL) {

            $this->session->set_flashdata('flash_message', warn_msg('Pilih data terlebih dahulu'));
            redirect('ktp/ktp');
        } else {

            $data['kta'] = $this->Laporanmodel->cetak_kta_all($this->user['id_ref'], $this->user['role_admin'], $data['data_check']);

            if (empty($data['kta'])) {            //add new data
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Data ID masih kosong...'));
                redirect('ktp/ktp');
            } else {
                $html = $this->load->view('cetak_laporan_kta', $data, true);
                $this->pdfgenerator->generate($html, 'laporan_kartu_tanda_anggota');
            }
        }
    }

    //---------------------------------------CETAK KTP REG---------------------------------------//

    public function cetak_kta_only_admin($id = '') {

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        if ($data['data_check'] == '' or $data['data_check'] == NULL) {

            $this->session->set_flashdata('flash_message', warn_msg('Pilih data terlebih dahulu'));
            redirect('ktp/lihat_ktp_admin/' . $id);
        } else {

            $id_admin = $this->Laporanmodel->get_by_id_admin_reg($id);
            $regional = $this->Laporanmodel->get_regional_admin($id, $id_admin[0]->id_ref, $id_admin[0]->role_admin); //?
            $data['kta'] = $this->Laporanmodel->cetak_reg_ktp($id, $this->user['id_ref'], $this->user['role_admin'], $data['data_check']);

            if (empty($data['kta'])) {            //add new data
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Data masih kosong...'));
                redirect('ktp/lihat_ktp_admin/' . $id);
            } else {
                $html = $this->load->view('cetak_laporan_kta', $data, true);
                $this->pdfgenerator->generate($html, 'laporan_kartu_tanda_anggota_' . $regional[0]->nama_admin);
            }
        }
    }

    //---------------------------------------CETAK KTP PET---------------------------------------//

    public function cetak_kta_only_pet($id = '') {

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        if ($data['data_check'] == '' or $data['data_check'] == NULL) {

            $this->session->set_flashdata('flash_message', warn_msg('Pilih data terlebih dahulu'));
            redirect('ktp/lihat_ktp_pet/' . $id);
        } else {

            $id_admin = $this->Laporanmodel->get_by_id_admin_pet($id);
            $petugas = $this->Laporanmodel->get_petugas($id, $this->user['id_ref'], $this->user['role_admin']); //?
            $data['kta'] = $this->Laporanmodel->cetak_pet_ktp($id, $id_admin[0]->id_ref, $id_admin[0]->role_admin, $data['data_check']);

            if (empty($data['kta'])) {            //add new data
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Data Laporan Anggota masih kosong...'));
                redirect('ktp/lihat_ktp_pet/' . $id);
            } else {
                $html = $this->load->view('cetak_laporan_kta', $data, true);
                $this->pdfgenerator->generate($html, 'laporan_kartu_tanda_anggota_' . $petugas[0]->nama_petugas);
            }
        }
    }

    //---------------------------------------CETAK LAPORAN REG---------------------------------------//

    public function cetak_laporan_admin($id = '') {

        $laporan = $this->Laporanmodel->get_laporan($id); //?
        $regional = $this->Laporanmodel->get_regional_admin($id, $this->user['id_ref'], $this->user['role_admin']); //?
        $data = $this->Laporanmodel->cetak_reg_ktp($id, $this->user['id_ref'], $this->user['role_admin']);

        if (empty($laporan)) {
            $this->session->set_flashdata('flash_message', err_msg('Maaf, Data Laporan  masih kosong...'));
            redirect('ktp/lihat_ktp_admin/' . $id);
        } else {
            if (empty($data)) {            //add new data
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Data Anggota masih kosong...'));
                redirect('ktp/lihat_ktp_admin/' . $id);
            } else {
                $pdfArray = array();
                // create new PDF document
                $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

                // set document information
                $pdf->SetCreator(PDF_CREATOR);
                $pdf->SetAuthor(PDF_HEADER_TITLE);
                $pdf->SetTitle('Daftar Laporan E-KTP');
                $pdf->SetSubject('Laporan E-KTP');

                $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

                // set margins
                $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_BOTTOM, PDF_MARGIN_RIGHT);

                // Call before the addPage() method
                $pdf->SetPrintHeader(false);
                $pdf->SetPrintFooter(false);
                // set auto page breaks
                $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

                // set image scale factor
                $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

                // set some language-dependent strings (optional)
                if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
                    require_once(dirname(__FILE__) . '/lang/eng.php');
                    $pdf->setLanguageArray($l);
                }
                // set font
                $pdf->SetFont('helvetica', 'B', 12);

                // add a page
                $pdf->AddPage('L', 'A4');
                //$pdf->Cell(0, 0, 'Proyek Jalan Malang', 1, 1, 'C');

                $pdf->SetFont('times', '', 10);
                // Table with rowspans and THEAD
                $theader = '
            <div align="center">
             <img width="110px" height="110px" src="' . base_url() . $laporan[0]->img . '">
                 </br>
            </div>
            <table border style="width:100%;" >
                <tr>
                    <td width="4%"></td> 
                    <td width="8%"></td>             
                    <td width="56%"></td>
                    <td width="8%"></td>
                    <td align="center" border="3" width="23%" height="27">                        
                        <b style="margin-top:10px;" >' . strtoupper($laporan[0]->jenis_laporan) . '</b>                      
                     </td>
                </tr>
            </table>
            </br>
            <h2 align="center">' . strtoupper($laporan[0]->header_laporan) . '<br/><br/></h2>            
            <table border style="width:100%;" >
            <thead>                  
               <tr>
                    <td width="1% "></td> 
                    <td width="16%">KELURAHAN/DESA*) :</td>             
                    <td width="44%">' . strtoupper($regional[0]->kelurahan) . '</td>
                    <td width="16%">KABUPATEN/KOTA*) :</td>
                    <td width="20%">' . strtoupper($regional[0]->kabupaten) . '</td>
               </tr>
               <tr> 
                    <td width="1%"></td> 
                    <td width="16%">KECAMATAN :</td>             
                    <td width="44%">' . strtoupper($regional[0]->kecamatan) . '</td>
                    <td width="16%">PROVINSI :</td>
                    <td width="20%">' . strtoupper($regional[0]->provinsi) . ' </td>
               </tr>
            </thead>
            </table>
             <br></br>
             <br></br>
            <table border="0.2" style="width:100%;" >
            <thead>                  
             <tr align="center">
              <td width="4%"><b>NO</b></td>             
              <td width="17%"><b>NAMA</b></td>
              <td width="16%"><b>NIK</b></td>
              <td width="13%"><b>TGL/BLN/THN/LAHIR</b></td>
              <td width="10%"><b>JENIS KELAMIN (L/P)</b></td>
              <td width="14%"><b>PEKERJAAN</b></td>
              <td width="14%"><b>ALAMAT LENGKAP</b></td>
              <td width="12%"><b>TANDA TANGAN/CAP JEMPOL</b></td>             
             </tr>
             
             <tr align="center" style="background-color:#E0E0E0;">
                        <td width = "4%">1</td>
                        <td width = "17%">2</td>
                        <td width = "16%">3</td>
                        <td width = "13%">4</td>
                        <td width = "10%">5</td>
                        <td width = "14%">6</td>
                        <td width = "14%">7</td>
                        <td width = "12%">8</td>
              </tr>
              </thead>';
                array_push($pdfArray, $theader);
                $i = 1;
                foreach ($data as $key => $value) {
                    $jk = ' ';
                    if ($value->jenis_kelamin == 0) {
                        $jk = 'P';
                    } else if ($value->jenis_kelamin == 1) {
                        $jk = 'L';
                    }
                    $tcontent = '<tbody>
                    <tr>
                        <td width = "4%" align = "center">' . $i . ' </td>
                        <td width = "17%">' . strtoupper($value->nama_ktp) . ' </td>
                        <td width = "16%">' . strtoupper($value->nik_ktp) . ' </td>
                        <td width = "13%">' . strtoupper($value->tempat_lahir) . ", " . strtoupper($value->tanggal_lahir) . ' </td>
                        <td width = "10%" align = "center">' . strtoupper($jk) . ' </td>
                        <td width = "14%">' . strtoupper($value->pekerjaan) . ' </td>
                        <td width = "14%">' . strtoupper($value->alamat_ktp) . ', RT.' . $value->rt . ', RW.' . $value->rw . ' </td>
                        <td width = "12%"></td>
                    </tr>
                    </tbody>';
                    $i++;
                    array_push($pdfArray, $tcontent);
                }
                $tbot = '</table>
            <br></br>
            <br></br>
            <br></br>
            <table border style="width:100%;" >
                <tr>
                    <td width="4%"></td> 
                    <td width="8%"></td>             
                    <td width="56%"></td>
                    <td width="8%"></td>
                    <td align="center"width="23%">                        
                       …………………………………………… 2018                     
                     </td>
                </tr>
                <tr>
                    <td width="4%"></td> 
                    <td width="8%"></td>             
                    <td width="56%"></td>
                    <td width="4%"></td>
                    <td align="center"width="30%">                                         
                    </td>
                 </tr>                
                 <tr>
                    <td width="4%"></td> 
                    <td width="8%"></td>             
                    <td width="56%"></td>
                    <td width="4%"></td>
                    <td align="center"width="30%">                        
                      <b>BAKAL CALON YANG BERSANGKUTAN</b>                 
                    </td>
                </tr>
                 <tr>
                <td width="4%"></td> 
                    <td width="8%"></td>             
                    <td width="56%"></td>
                    <td width="4%"></td>
                    <td align="center"width="30%">                                        
                    </td>
                 </tr>
                <tr>
                <td width="4%"></td> 
                    <td width="8%"></td>             
                    <td width="56%"></td>
                    <td width="4%"></td>
                    <td align="center"width="30%">                                        
                    </td>
                 </tr>
                <tr>
                    <td width="4%"></td> 
                    <td width="8%"></td>             
                    <td width="56%"></td>
                    <td width="6%"></td>
                    <td align="center" border="1" width="12%" height="55">                        
                      Materai 6000                 
                    </td>
                </tr>
                 <tr>
                 <td width="4%"></td> 
                    <td width="8%"></td>             
                    <td width="56%"></td>
                    <td width="4%"></td>
                    <td align="center"width="30%">                                         
                    </td>
                 </tr>
                  <tr>
                <td width="4%"></td> 
                    <td width="8%"></td>             
                    <td width="56%"></td>
                    <td width="4%"></td>
                    <td align="center"width="30%">                                        
                    </td>
                 </tr>
                <tr>
                    <td width="4%"></td> 
                    <td width="8%"></td>             
                    <td width="56%"></td>
                    <td width="4%"></td>
                    <td align="center"width="30%">                        
                      (………………………...…………….)                
                    </td>
                </tr>
            </table>
             <br></br>
             <br></br>
             <br></br>
            <table border style="width:100%;" >                
             <tr>
              <td width="100%"><font size="11"><b>Keterangan: </b>                  
                  <br/> 1. *) Coret yang tidak diperlukan. 
                  <br/> 2. Pada kolom 7 ditulis lengkap RT dan RW atau Dusun.
                  <br/> 3. Formulir ini dapat diperbanyak oleh calon Anggotan DPD, apabila tidak mencukupi.
                  </font>
              </td>
             </tr>    
            </table>';
                array_push($pdfArray, $tbot);
                $table = implode(" ", $pdfArray);

                $tbl = <<<EOD
                {$table}
EOD;
                $pdf->writeHTML($tbl, true, false, false, false, ' ');

// ---------------------------------------------------------
//Close and output PDF document
                if ($this->agent->is_browser(' Safari')) {
                    $pdf->Output('cetak_laporan_regional' . strtolower($regional[0]->kelurahan) . '.pdf ', 'D');
                } else {
                    $pdf->Output('cetak_laporan_regional' . strtolower($regional[0]->kelurahan) . '.pdf ', 'I');
                }
            }
        }
    }

    //---------------------------------------CETAK LAPORAN PETUGAS---------------------------------------//

    public function cetak_laporan_pet($id = '') {

        $id_admin = $this->Laporanmodel->get_by_id_admin_pet($id);
        $laporan = $this->Laporanmodel->get_laporan($id_admin[0]->id_admin); //?
        $petugas = $this->Laporanmodel->get_petugas($id, $this->user['id_ref'], $this->user['role_admin']); //?
        $data = $this->Laporanmodel->cetak_pet_ktp($id, $this->user['id_ref'], $this->user['role_admin']);
        //var_dump($laporan);exit;
        if (empty($laporan)) {
            $this->session->set_flashdata('flash_message', err_msg('Maaf, Data Laporan Anggota masih kosong...'));
            redirect('ktp/lihat_ktp_pet/' . $id);
        } else {
            if (empty($data)) {            //add new data
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Data Anggota masih kosong...'));
                redirect('ktp/lihat_ktp_pet/' . $id);
            } else {
                $pdfArray = array();
                // create new PDF document
                $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

                // set document information
                $pdf->SetCreator(PDF_CREATOR);
                $pdf->SetAuthor(PDF_HEADER_TITLE);
                $pdf->SetTitle('Daftar Laporan E-KTP');
                $pdf->SetSubject('Laporan E-KTP');

                $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

                // set margins
                $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_BOTTOM, PDF_MARGIN_RIGHT);

                // Call before the addPage() method
                $pdf->SetPrintHeader(false);
                $pdf->SetPrintFooter(false);
                // set auto page breaks
                $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

                // set image scale factor
                $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

                // set some language-dependent strings (optional)
                if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
                    require_once(dirname(__FILE__) . '/lang/eng.php');
                    $pdf->setLanguageArray($l);
                }
                // set font
                $pdf->SetFont('helvetica', 'B', 12);

                // add a page
                $pdf->AddPage('L', 'A4');
                //$pdf->Cell(0, 0, 'Proyek Jalan Malang', 1, 1, 'C');

                $pdf->SetFont('times', '', 10);
                // Table with rowspans and THEAD
                $theader = '
                        <div align = "center">
                        <img width = "110px" height = "110px" src="' . base_url() . $laporan[0]->img . '">  </br>
                        </div>
                        <table border style ="width:100%;" >
                            <tr>
                                <td width = "4%"></td>
                                <td width = "8%"></td>
                                <td width = "56%"></td>
                                <td width = "8%"></td>
                                <td align = "center" border="3" width="23%" height="27">
                                <b style = "margin-top:10px;" >' . strtoupper($laporan[0]->jenis_laporan) . ' </b>
                                </td>
                            </tr>
                        </table>
                        </br>
                        <h2 align = "center">' . strtoupper($laporan[0]->header_laporan) . ' <br/><br/></h2>
                        <table border style = "width:100%;" >
                            <thead>
                                <tr>
                                    <td width = "4%"></td>
                                    <td width = "8%">Kelurahan :</td>
                                    <td width = "61%">-</td>
                                    <td width = "8%" >Kabupaten :</td>
                                    <td width = "20%">-</td>
                                </tr>
                                <tr>
                                    <td width = "4%"></td>
                                    <td width = "8%">Kecamatan :</td>
                                    <td width = "61%">-</td>
                                    <td width = "8%">Provinsi :</td>
                                    <td width = "20%">-</td>
                                </tr>
                            </thead>
                        </table>
                        <br></br>
                        <br></br>
                        <table border = "0.2" style = "width:100%;" >
                            <thead>
                                <tr align = "center">
                                    <td width = "4%"><b>NO</b></td>
                                    <td width = "17%"><b>NAMA</b></td>
                                    <td width = "16%"><b>NIK</b></td>
                                    <td width = "13%"><b>TGL/BLN/THN/LAHIR</b></td>
                                    <td width = "10%"><b>JENIS KELAMIN (L/P)</b></td>
                                    <td width = "14%"><b>PEKERJAAN</b></td>
                                    <td width = "14%"><b>ALAMAT LENGKAP</b></td>
                                    <td width = "12%"><b>TANDA TANGAN/CAP JEMPOL</b></td>
                                </tr>

                                <tr align = "center" style = "background-color:#E0E0E0;">
                                    <td width = "4%">1</td>
                                    <td width = "17%">2</td>
                                    <td width = "16%">3</td>
                                    <td width = "13%">4</td>
                                    <td width = "10%">5</td>
                                    <td width = "14%">6</td>
                                    <td width = "14%">7</td>
                                    <td width = "12%">8</td>
                                </tr>
                        </thead>';
                array_push($pdfArray, $theader);
                $i = 1;
                foreach ($data as $key => $value) {
                    $jk = ' ';
                    if ($value->jenis_kelamin == 0) {
                        $jk = 'P';
                    } else if ($value->jenis_kelamin == 1) {
                        $jk = 'L';
                    }
                    $tcontent = '<tbody><tr>
                        <td width = "4%" align = "center">' . $i . ' </td>
                        <td width = "17%">' . strtoupper($value->nama_ktp) . ' </td>
                        <td width = "16%">' . strtoupper($value->nik_ktp) . ' </td>
                        <td width = "13%">' . strtoupper($value->tempat_lahir) . ", " . strtoupper($value->tanggal_lahir) . ' </td>
                        <td width = "10%" align = "center">' . strtoupper($jk) . ' </td>
                        <td width = "14%">' . strtoupper($value->pekerjaan) . ' </td>
                        <td width = "14%">' . strtoupper($value->alamat_ktp) . ',  RT.' . $value->rt . ', RW.' . $value->rw . ' </td>
                        <td width = "12%"></td>
                        </tr></tbody>';
                    $i++;
                    array_push($pdfArray, $tcontent);
                }
                $tbot = '</table>
            <br></br>
            <br></br>
            <br></br>
            <table border style="width:100%;" >
                <tr>
                    <td width="4%"></td> 
                    <td width="8%"></td>             
                    <td width="56%"></td>
                    <td width="8%"></td>
                    <td align="center"width="23%">                        
                       …………………………………………… 2018                     
                     </td>
                </tr>
                <tr>
                    <td width="4%"></td> 
                    <td width="8%"></td>             
                    <td width="56%"></td>
                    <td width="4%"></td>
                    <td align="center"width="30%">                                         
                    </td>
                 </tr>                
                 <tr>
                    <td width="4%"></td> 
                    <td width="8%"></td>             
                    <td width="56%"></td>
                    <td width="4%"></td>
                    <td align="center"width="30%">                        
                      <b>BAKAL CALON YANG BERSANGKUTAN</b>                 
                    </td>
                </tr>
                <tr>
                <td width="4%"></td> 
                    <td width="8%"></td>             
                    <td width="56%"></td>
                    <td width="4%"></td>
                    <td align="center"width="30%">                                        
                    </td>
                 </tr>
                  <tr>
                <td width="4%"></td> 
                    <td width="8%"></td>             
                    <td width="56%"></td>
                    <td width="4%"></td>
                    <td align="center"width="30%">                                        
                    </td>
                 </tr>
                <tr>
                    <td width="4%"></td> 
                    <td width="8%"></td>             
                    <td width="56%"></td>
                    <td width="6%"></td>
                    <td align="center" border="1" width="12%" height="55">                        
                      Materai 6000                 
                    </td>
                </tr>
                 <tr>
                 <td width="4%"></td> 
                    <td width="8%"></td>             
                    <td width="56%"></td>
                    <td width="4%"></td>
                    <td align="center"width="30%">                                         
                    </td>
                 </tr>
                  <tr>
                <td width="4%"></td> 
                    <td width="8%"></td>             
                    <td width="56%"></td>
                    <td width="4%"></td>
                    <td align="center"width="30%">                                        
                    </td>
                 </tr>
                <tr>
                    <td width="4%"></td> 
                    <td width="8%"></td>             
                    <td width="56%"></td>
                    <td width="4%"></td>
                    <td align="center"width="30%">                        
                      (………………………...…………….)                
                    </td>
                </tr>
            </table>
             <br></br>
             <br></br>
             <br></br>
            <table border style="width:100%;" >                
             <tr>
              <td width="100%"><font size="11"><b>Keterangan: </b>                  
                  <br/> 1. *) Coret yang tidak diperlukan. 
                  <br/> 2. Pada kolom 7 ditulis lengkap RT dan RW atau Dusun.
                  <br/> 3. Formulir ini dapat diperbanyak oleh calon Anggotan DPD, apabila tidak mencukupi.
                  </font>
              </td>
             </tr>    
            </table>';
                array_push($pdfArray, $tbot);
                $table = implode(" ", $pdfArray);

                $tbl = <<<EOD
                {$table}
EOD;
                $pdf->writeHTML($tbl, true, false, false, false, ' ');

// ---------------------------------------------------------
//Close and output PDF document
                if ($this->agent->is_browser(' Safari')) {
                    $pdf->Output(' cetak_laporan_petugas' . strtolower($petugas[0]->nama_petugas) . '.pdf ', 'D');
                } else {
                    $pdf->Output('cetak_laporan_petugas' . strtolower($petugas[0]->nama_petugas) . '.pdf ', 'I');
                }
            }
        }
    }

    //---------------------------------------EDIT GET DELETE LAPORAN PETUGAS---------------------------------------//

    public function get_laporan() {

        $data['laporan'] = $this->Laporanmodel->get_laporan($this->user['id_ref'], $this->user['role_admin']); //?
        $this->template->load('template_admin/template_admin', 'atur_laporan', $data);
    }

    public function edit_laporan() {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $data['pic'] = $data['image'];
        $data['pic_thumb'] = $data['image_thumb'];

        $data_img_1 = explode('/', $data['image']);
        $img_name_1 = $data_img_1[2];

        $this->form_validation->set_rules('jenis_laporan', 'Jenis Laporan', 'required');
        $this->form_validation->set_rules('header_laporan', 'Header Laporan', 'required');
        $cek = $this->Laporanmodel->get_id_by_laporan($this->user['id_ref']);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('laporan/get_laporan');
        } else {
            $this->load->library('upload'); //load library upload file
            $this->load->library('image_lib'); //load library image

            if (!empty($_FILES['img']['tmp_name'])) {

                $this->delete_file($img_name_1); //delete existing file

                $path = 'uploads/logo/';
                $path_thumb = 'uploads/logo/thumbs/';
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
                        redirect('laporan/get_laporan' . $id);
                    }
                } else {
                    $this->session->set_flashdata('flash_message', warn_msg($this->upload->display_errors()));
                    redirect('laporan/get_laporan' . $id);
                }
            }
            if ($cek == FALSE) {
                $edit = $this->Laporanmodel->insert_laporan($data, $this->user['id_ref'], $this->user['role_admin']);
            } else {
                $edit = $this->Laporanmodel->update_laporan($data, $this->user['id_ref'], $this->user['role_admin']);
            }
            if ($edit == true) {
                $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data Telah Tersimpan..'));
                redirect('laporan/get_laporan');
            } else {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                redirect('laporan/get_laporan');
            }
        }
    }

    public function delete_file($name = '') {
        $path = './uploads/logo/';
        $path_thumb = './uploads/logo/thumbs/';
        @unlink($path . $name);
        @unlink($path_thumb . $name);
    }

    //------------------------------------------------------------------------------//
}
