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
class Wilayahktpscan extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('Wilayahktpscanmodel');
//        $this->load->library("firebase/Firebase");
//        $this->load->library("firebase/Push");
//        $this->load->library("firebase/config");
        //$this->db->cache_on();
    }

    /**
     * METHOD/FUNCTION JOBS CRUD
     */
    // GET WILAYAH PROV
    public function getnamaprovinsi_get() {
        $nama_provinsi = $this->get('nama_provinsi');

        if (!$nama_provinsi) {

            $this->set_response([
                'status' => FALSE,
                'message' => 'ID/Kode salah'], REST_Controller::HTTP_OK);
        } else {

            $data_list = $this->Wilayahktpscanmodel->get_provinsi();
            $data = $this->Wilayahktpscanmodel->get_nama_provinsi($nama_provinsi);
            $result = array();
            if ($data) {

                foreach ($data as $key => $value) {
                    $result['status'] = TRUE;
                    $result['get_provinsi'] = $value;
                }
                $result['provinsi'] = $data_list;
                // Set the response and exit             
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
                    'message' => 'Data provinsi tidak ditemukan'
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    // GET WILAYAH KAB
    public function getnamakabupaten_get() {
        $id_provinsi = $this->get('id_provinsi');
        $nama_kabupaten = $this->get('nama_kabupaten');

        if (!$id_provinsi) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID/Kode salah'], REST_Controller::HTTP_OK);
        } else {

            $data_list = $this->Wilayahktpscanmodel->get_kabupaten($id_provinsi);
            $data = $this->Wilayahktpscanmodel->get_nama_kabupaten($id_provinsi, $nama_kabupaten);
            $result = array();

            if ($data) {
                foreach ($data as $key => $value) {
                    $result['status'] = TRUE;
                    $result['get_kabupaten'] = $value;
                }
                $result['kabupaten'] = $data_list;

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
                    'message' => 'Data kabupaten tidak ditemukan'
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    // GET WILAYAH KEC
    public function getnamakecamatan_get() {
        $id_provinsi = $this->get('id_provinsi');
        $id_kabupaten = $this->get('id_kabupaten');
        $nama_kecamatan = $this->get('nama_kecamatan');

        if (!$id_provinsi) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID/Kode salah'], REST_Controller::HTTP_OK);
        } else {
            
            $data_list = $this->Wilayahktpscanmodel->get_kecamatan($id_provinsi, $id_kabupaten);
            $data = $this->Wilayahktpscanmodel->get_nama_kecamatan($id_provinsi, $id_kabupaten, $nama_kecamatan);
            
            if ($data) {
                
                foreach ($data as $key => $value) {
                    $result['status'] = TRUE;
                    $result['get_kecamatan'] = $value;
                }
                $result['kecamatan'] = $data_list;   
                
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
                    'message' => 'Data kecamatan tidak ditemukan'
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    // GET WILAYAH KEL
    public function getnamakelurahan_get() {
        $id_provinsi = $this->get('id_provinsi');
        $id_kabupaten = $this->get('id_kabupaten');
        $id_kecamatan = $this->get('id_kecamatan');
        $nama_kelurahan = $this->get('nama_kelurahan');

        if (!$id_provinsi) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID/Kode salah'], REST_Controller::HTTP_OK);
        } else {
            
            $data_list = $this->Wilayahktpscanmodel->get_kelurahan($id_provinsi, $id_kabupaten, $id_kecamatan);
            $data = $this->Wilayahktpscanmodel->get_nama_kelurahan($id_provinsi, $id_kabupaten, $id_kecamatan, $nama_kelurahan);
            
            if ($data) {
                
                 foreach ($data as $key => $value) {
                    $result['status'] = TRUE;
                    $result['get_kelurahan'] = $value;
                }
                $result['kelurahan'] = $data_list;   
                
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
                    'message' => 'Data kelurahan tidak ditemukan'
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

}
