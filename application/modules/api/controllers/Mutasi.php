<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Mutasi extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('Mutasimodel');
        //$this->db->cache_on();
    }

    public function detailmutasi_get() {
        $id = $this->get('id_mutasi');

        if (!$id) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID salah'], REST_Controller::HTTP_OK);
        } else {
            $data = $this->Mutasimodel->get_detail_mutasi($id);
            $result = array();
            if ($data) {
                // Set the response and exit
                // data is found              
                foreach ($data as $key => $value) {
                    $result['status'] = TRUE;
                    $result['detail_mutasi'] = $value;
                }
                $this->output
                        ->set_status_header(REST_Controller::HTTP_OK)
                        ->set_header('Cache-Control: no-store, no-cache, must-revalidate')
                        ->set_header('Cache-Control: post-check=0, pre-check=0')
                        ->set_header('Pragma: no-cache')
                        ->set_content_type('application/json', 'utf-8')
                        ->set_output(json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            } else {
                // Set the response and exit
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Mutasi tidak ditemukan'
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function getmutasimasuk_get() {
        $id_tujuan = $this->get('id_region_tujuan');
        $limit = $this->get('limit');

        if (!$id_tujuan) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID salah'], REST_Controller::HTTP_OK);
        } else {
            $count = $this->Mutasimodel->count_mutasi_masuk_all($id_tujuan);
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($count) {
                if ($limit >= $count) {
                    $data['status'] = FALSE;
                    $data['message'] = "Data terakhir telah diupdate";
                    $limit = $count;
                } else {
                    $data['status'] = TRUE;
                }
                $data['result'] = $this->Mutasimodel->get_all_mutasi_masuk($id_tujuan, $limit);
                if ($data) {
                    $this->output
                            ->set_status_header(REST_Controller::HTTP_OK)
                            ->set_header('Cache-Control: no-store, no-cache, must-revalidate')
                            ->set_header('Cache-Control: post-check=0, pre-check=0')
                            ->set_header('Pragma: no-cache')
                            ->set_content_type('application/json', 'utf-8')
                            ->set_output(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
                } else {
                    // Set the response and exit
                    $this->set_response([
                        'status' => FALSE,
                        'message' => 'Data tidak ditemukan'
                            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
                }
            }
        }
    }

    public function getmutasikeluar_get() {
        $id_asal = $this->get('id_region_asal');
        $limit = $this->get('limit');

        if (!$id_asal) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID salah'], REST_Controller::HTTP_OK);
        } else {
            $count = $this->Mutasimodel->count_mutasi_keluar_all($id_asal);
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($count) {
                if ($limit >= $count) {
                    $data['status'] = FALSE;
                    $data['message'] = "Data terakhir telah diupdate";
                    $limit = $count;
                } else {
                    $data['status'] = TRUE;
                }
                $data['result'] = $this->Mutasimodel->get_all_mutasi_keluar($id_asal, $limit);
                if ($data) {
                    $this->output
                            ->set_status_header(REST_Controller::HTTP_OK)
                            ->set_header('Cache-Control: no-store, no-cache, must-revalidate')
                            ->set_header('Cache-Control: post-check=0, pre-check=0')
                            ->set_header('Pragma: no-cache')
                            ->set_content_type('application/json', 'utf-8')
                            ->set_output(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
                } else {
                    // Set the response and exit
                    $this->set_response([
                        'status' => FALSE,
                        'message' => 'Data tidak ditemukan'
                            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
                }
            }
        }
    }

    public function konfirmasimutasi_post() {

        $id_mutasi = $this->input->post('id_mutasi');

        if (!$id_mutasi) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID salah'], REST_Controller::HTTP_OK);
        } else {

            $no_urut = '';
            $id_admin = $this->Mutasimodel->get_id_mutasi($id_mutasi);
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
            $update_mutasi = $this->Mutasimodel->update_status_mutasi_masuk($id_mutasi, $data);

            if ($update_mutasi == true && $update_anggota == true && $update_anggota_masuk == true) {

                $this->set_response([
                    'status' => TRUE,
                    'message' => "Status mutasi telah diupdate"], REST_Controller::HTTP_OK);
            } else {
                // Set the response and exit
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Status mutasi gagal'
                        ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function deletemutasi_post() {

        $id = $this->input->post('id_mutasi');

        $id_admin = $this->Mutasimodel->get_id_mutasi($id);
        $update = $this->Mutasimodel->update_status_mutasi_false($id_admin[0]->id_anggota);
        $delete = $this->Mutasimodel->delete_mutasi_keluar($id);

        if ($update == true && $delete == true) {

            $this->set_response([
                'status' => TRUE,
                'message' => "Mutasi telah dihapus"], REST_Controller::HTTP_OK);
        } else {
            // Set the response and exit
            $this->set_response([
                'status' => FALSE,
                'message' => 'Hapus mutasi gagal'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

}
