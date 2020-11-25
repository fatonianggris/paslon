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
class Saksi extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('Saksimodel');
        //$this->db->cache_on();
    }

    public function saksi_get() {
        $id = $this->get('id_saksi');
        if (!$id) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID salah'], REST_Controller::HTTP_OK);
        } else {
            $data = $this->Saksimodel->get_saksi_by_id($id);
            $result = array();
            if ($data) {
                // Set the response and exit
                // data is found              
                foreach ($data as $key => $value) {
                    $result['status'] = TRUE;
                    $result['saksi'] = $value;
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
                    'message' => 'User tidak ditemukan'
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function tpssaksi_get() {

        $id_saksi = $this->get('id_saksi');
        $limit = $this->get('limit');

        if (!$id_saksi) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID salah'], REST_Controller::HTTP_OK);
        } else {
            $count = $this->Saksimodel->count_tps_saksi($id_saksi);
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($count) {
                if ($limit >= $count) {
                    $data['status'] = TRUE;
                    $data['message'] = "Data terakhir telah diupdate";
                    $limit = $count;
                } else {
                    $data['status'] = TRUE;
                }
                $data['tps_saksi'] = $this->Saksimodel->get_tps_saksi($id_saksi, $limit);
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
                        'message' => 'User tidak ditemukan'
                            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
                }
            }
        }
    }

    public function pemilihansaksi_get() {

        $id_pemilihan = $this->get('id_pemilihan');
        $limit = $this->get('limit');

        if (!$id_pemilihan) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID salah'], REST_Controller::HTTP_OK);
        } else {

            $count = $this->Saksimodel->count_pemilihan_saksi($id_pemilihan);

            if ($count) {
                if ($limit >= $count) {
                    $data['status'] = TRUE;
                    $data['message'] = "Data terakhir telah diupdate";
                    $limit = $count;
                } else {
                    $data['status'] = TRUE;
                }

                $data['pemilihan'] = $this->Saksimodel->get_pemilihan_saksi($id_pemilihan, $limit);
                if ($data) {
                    // Set the response and exit               
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
                        'message' => 'User tidak ditemukan'
                            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
                }
            }
        }
    }

    public function detailpaslon_get() {
        $id_pemilihan = $this->get('id_pemilihan');

        if (!$id_pemilihan) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID salah'], REST_Controller::HTTP_OK);
        } else {
            $data['status'] = TRUE;
            $data['message'] = "Data terakhir telah diupdate";
            $data['paslon'] = $this->Saksimodel->get_data_calon_pemilihan($id_pemilihan);

            if ($data) {
                // Set the response and exit              
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
                    'message' => 'User tidak ditemukan'
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function detailhasilsuarapaslon_get() {
        $id_tps = $this->get('id_tps');
        $id_pemilihan = $this->get('id_pemilihan');
        $id_wilayah_pemilihan = $this->get('id_wilayah_pemilihan');

        if (!$id_tps) {

            $this->set_response([
                'status' => FALSE,
                'message' => 'ID salah'], REST_Controller::HTTP_OK);
        } else {
            $data['status'] = TRUE;
            $data['message'] = "Data terakhir telah diupdate";
            $data['suara_edit'] = $this->Saksimodel->get_hasil_suara_calon_edit($id_tps, $id_pemilihan, $id_wilayah_pemilihan);
            if ($data) {
                // Set the response and exit
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
                    'message' => 'User tidak ditemukan'
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function detailhasiltps_get() {
        $id_tps = $this->get('id_tps');
        $id_pemilihan = $this->get('id_pemilihan');
        $id_wilayah_pemilihan = $this->get('id_wilayah_pemilihan');

        if (!$id_pemilihan) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID salah'], REST_Controller::HTTP_OK);
        } else {

            $data_pemilihan = $this->Saksimodel->get_hasil_pemilihan($id_tps, $id_pemilihan, $id_wilayah_pemilihan);

            $result = array();

            if ($data_pemilihan) {
                // Set the response and exit
                // data is found         
                $result['status'] = TRUE;
                foreach ($data_pemilihan as $key => $value) {
                    $result['pemilihan'] = $value;
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
                    'message' => 'User tidak ditemukan'
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    //---------------------------------------KIRIM HASIL PEMILIHANS---------------------------------------//
    public function kirimhasiltps_post() {

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $id_tps = $this->post('id_tps');
        $id_pemilihan = $this->post('id_pemilihan');
        $id_wilayah_pemilihan = $this->post('id_wilayah_pemilihan');

        $fotoc1_pertama = $this->post('fotoc1_pertama');
        $fotoc1_pertama_thumb = $this->post('fotoc1_pertama_thumb');

        $fotoc1_kedua = $this->post('fotoc1_kedua');
        $fotoc1_kedua_thumb = $this->post('fotoc1_kedua_thumb');

        $name_image_fotoc1_pertama = $this->post('nama_fotoc1_pertama');
        $name_image_fotoc1_kedua = $this->post('nama_fotoc1_kedua');

        $id_calon_pemilihan = $this->post('id_calon_pemilihan');
        $jumlah_suara = $this->post('jumlah_suara');

        $id_calon_pemilihan_array = explode(',', $id_calon_pemilihan);
        $jumlah_suara_array = explode(',', $jumlah_suara);

        $nama_tps = $this->Saksimodel->get_tps($id_tps);

        if (!empty($fotoc1_pertama)) {

            $path = $nama_tps[0]->path_tps . '/foto/' . $name_image_fotoc1_pertama . '.png';
            $path_thumb = $nama_tps[0]->path_tps . '/foto/thumbs/' . $name_image_fotoc1_pertama . '.png';

            file_put_contents($path, base64_decode($fotoc1_pertama));
            file_put_contents($path_thumb, base64_decode($fotoc1_pertama_thumb));

            $data['fotoc1_pertama'] = $path;
            $data['fotoc1_pertama_thumb'] = $path_thumb;
        } else {
            // user is not found with the credentials
            $this->set_response([
                'status' => FALSE,
                'message' => 'Mohon maaf, Upload Foto hasil C1 dahulu'], REST_Controller::HTTP_OK);
        }

        if (!empty($fotoc1_kedua)) {

            $path = $nama_tps[0]->path_tps . '/foto/' . $name_image_fotoc1_kedua . '.png';
            $path_thumb = $nama_tps[0]->path_tps . '/foto/thumbs/' . $name_image_fotoc1_kedua . '.png';

            file_put_contents($path, base64_decode($fotoc1_kedua));
            file_put_contents($path_thumb, base64_decode($fotoc1_kedua_thumb));

            $data['fotoc1_kedua'] = $path;
            $data['fotoc1_kedua_thumb'] = $path_thumb;
        } else {
            // user is not found with the credentials
            $this->set_response([
                'status' => FALSE,
                'message' => 'Mohon maaf, Upload Foto hasil C1 dahulu'], REST_Controller::HTTP_OK);
        }

        $input_hasil = $this->Saksimodel->insert_hasil_pemilihan($data, $id_tps, $id_pemilihan, $id_wilayah_pemilihan);

        if ($input_hasil == true) {

            $hasil_array = array();
            for ($i = 0; $i < count($id_calon_pemilihan_array); $i++) {

                $hasil_array[$i] = array(
                    'id_calon_pemilihan' => $id_calon_pemilihan_array[$i],
                    'id_pemilihan' => $id_pemilihan,
                    'id_wilayah_pemilihan' => $id_wilayah_pemilihan,
                    'id_tps' => $id_tps,
                    'suara_sah' => $jumlah_suara_array[$i]
                );
            }

            $input_suara = $this->db->insert_batch('suara_calon', $hasil_array);

            $update_status_tps = $this->Saksimodel->update_status_hasil_pemilihan($id_tps, $id_pemilihan, $id_wilayah_pemilihan);

            if ($input_suara == TRUE && $update_status_tps == TRUE) {
                $this->set_response([
                    'status' => TRUE,
                    'message' => 'Data telah tersimpan'], REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Mohon maaf, terjadi kesalahan.'], REST_Controller::HTTP_OK);
            }
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Mohon maaf, server sedang sibuk'], REST_Controller::HTTP_OK);
        }
    }

    //---------------------------------------UPDATE HASIL PEMILIHANS---------------------------------------//
    public function updatehasiltps_post() {

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $id_tps = $this->post('id_tps');
        $id_pemilihan = $this->post('id_pemilihan');
        $id_wilayah_pemilihan = $this->post('id_wilayah_pemilihan');

        $fotoc1_pertama = $this->post('fotoc1_pertama');
        $fotoc1_pertama_thumb = $this->post('fotoc1_pertama_thumb');

        $name_image_fotoc1_pertama = $this->post('nama_fotoc1_pertama');
        $name_image_fotoc1_kedua = $this->post('name_fotoc1_kedua');

        $fotoc1_kedua = $this->post('fotoc1_kedua');
        $fotoc1_kedua_thumb = $this->post('fotoc1_kedua_thumb');

        $id_calon_pemilihan = $this->post('id_calon_pemilihan');
        $id_suara_calon = $this->post('id_suara_calon');
        $jumlah_suara = $this->post('jumlah_suara');

        $id_calon_pemilihan_array = explode(',', $id_calon_pemilihan);
        $id_suara_calon_array = explode(',', $id_suara_calon);
        $jumlah_suara_array = explode(',', $jumlah_suara);

        $nama_tps = $this->Saksimodel->get_tps($id_tps);

        if ($name_image_fotoc1_pertama != "") {

            $this->delete_file_foto_c1_pertama($id_tps, $id_pemilihan, $id_wilayah_pemilihan);

            $nama_image = $name_image_fotoc1_pertama . '_fotoc1_pertama';

            $path = $nama_tps[0]->path_tps . '/foto/' . $nama_image . '.png';
            $path_thumb = $nama_tps[0]->path_tps . '/foto/thumbs/' . $nama_image . '.png';

            file_put_contents($path, base64_decode($fotoc1_pertama));
            file_put_contents($path_thumb, base64_decode($fotoc1_pertama_thumb));

            $data['fotoc1_pertama'] = $path;
            $data['fotoc1_pertama_thumb'] = $path_thumb;
        } else {
            $data['fotoc1_pertama'] = $fotoc1_pertama;
            $data['fotoc1_pertama_thumb'] = $fotoc1_pertama_thumb;
        }

        if ($name_image_fotoc1_kedua != "") {

            $this->delete_file_foto_c1_kedua($id_tps, $id_pemilihan, $id_wilayah_pemilihan);

            $nama_image = $name_image_fotoc1_kedua . '_fotoc1_kedua';

            $path = $nama_tps[0]->path_tps . '/foto/' . $nama_image . '.png';
            $path_thumb = $nama_tps[0]->path_tps . '/foto/thumbs/' . $nama_image . '.png';

            file_put_contents($path, base64_decode($fotoc1_kedua));
            file_put_contents($path_thumb, base64_decode($fotoc1_kedua_thumb));

            $data['fotoc1_kedua'] = $path;
            $data['fotoc1_kedua_thumb'] = $path_thumb;
        } else {
            // user is not found with the credentials
            $data['fotoc1_kedua'] = $fotoc1_kedua;
            $data['fotoc1_kedua_thumb'] = $fotoc1_kedua_thumb;
        }

        $update_hasil = $this->Saksimodel->update_hasil_pemilihan($data, $id_tps, $id_pemilihan, $id_wilayah_pemilihan);

        if ($update_hasil == true) {

            $get_hasil_suara = $this->Saksimodel->get_hasil_suara($id_tps, $id_pemilihan, $id_wilayah_pemilihan);

            $array_suara = array();
            foreach ($get_hasil_suara as $key => $value) {
                $array_suara[] = $value->id_calon_pemilihan;
            }

            $hasil_array_update = array();
            $hasil_array_input = array();

            $input_bool = FALSE;
            $edit_bool = FALSE;

            for ($i = 0; $i < count($jumlah_suara_array); $i++) {
                if (in_array($id_calon_pemilihan_array[$i], $array_suara)) {

                    $hasil_array_update[$i] = array(
                        'id_suara_calon' => $id_suara_calon_array[$i],
                        'suara_sah' => $jumlah_suara_array[$i]
                    );
                    $edit_bool = TRUE;
                } else {
                    $hasil_array_input[$i] = array(
                        'id_calon_pemilihan' => $id_calon_pemilihan_array[$i],
                        'id_pemilihan' => $id_pemilihan,
                        'id_wilayah_pemilihan' => $id_wilayah_pemilihan,
                        'id_tps' => $id_tps,
                        'suara_sah' => $jumlah_suara_array[$i]
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
            if ($input_bool || $edit_bool) {
                $this->set_response([
                    'status' => TRUE,
                    'message' => 'Data telah tersimpan'], REST_Controller::HTTP_OK);
            }
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Mohon maaf, terjadi kesalahan.'], REST_Controller::HTTP_OK);
        }
    }

    // UPDATE USER
    public function updatesaksi_post() {

        $id_petugas = $this->post('id_saksi');

        $image = $this->post('img');
        $image_thumb = $this->post('img_thumb');

        $nama_image = $this->post('nama_foto');
        $path_image = $this->post('path_foto');

        $pass = $this->post('password');

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $data_img = explode('/', $path_image);
        $name_img = $data_img[2];

        if ($data) {

            if ($nama_image != '') {

                $this->delete_file_petugas($name_img); //delete existing file

                $path = 'uploads/saksi/' . $nama_image . '.png';
                $path_thumb = 'uploads/saksi/thumbs/' . $nama_image . '.png';

                file_put_contents($path, base64_decode($image));
                file_put_contents($path_thumb, base64_decode($image_thumb));

                $data['pic'] = $path;
                $data['pic_thumb'] = $path_thumb;
            } else {
                $data['pic'] = $image;
                $data['pic_thumb'] = $image_thumb;
            }
            if ($pass != "") {
                $dt['pass'] = $pass;
                $this->Saksimodel->update_pass($id_petugas, $dt);
            }

            $input = $this->Saksimodel->update_petugas($id_petugas, $data);
            if ($input == true) {
                $this->set_response([
                    'status' => TRUE,
                    'message' => 'Data telah tersimpan'], REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Mohon maaf, terjadi kesalahan.'], REST_Controller::HTTP_OK);
            }
        } else {
            // user is not found with the credentials
            $this->set_response([
                'status' => FALSE,
                'message' => 'Mohon maaf, server sedang sibuk'], REST_Controller::HTTP_OK);
        }
    }

    public function delete_file_foto_c1_pertama($id_tps = '', $id_pemilihan = '', $id_wilayah_pemilihan = '') {

        $data = $this->Saksimodel->get_hasil_pemilihan($id_tps, $id_pemilihan, $id_wilayah_pemilihan);

        $path = $data[0]->fotoc1_pertama;
        $path_thumb = $data[0]->fotoc1_pertama_thumb;

        @unlink($path);
        @unlink($path_thumb);
    }

    public function delete_file_foto_c1_kedua($id_tps = '', $id_pemilihan = '', $id_wilayah_pemilihan = '') {
        $data = $this->Saksimodel->get_hasil_pemilihan($id_tps, $id_pemilihan, $id_wilayah_pemilihan);

        $path = $data[0]->fotoc1_kedua;
        $path_thumb = $data[0]->fotoc1_kedua_thumb;

        @unlink($path);
        @unlink($path_thumb);
    }

    public function delete_file_petugas($name = '') {
        $path = './uploads/saksi/';
        $path_thumb = './uploads/saksi/thumbs/';
        @unlink($path . $name);
        @unlink($path_thumb . $name);
    }

}
