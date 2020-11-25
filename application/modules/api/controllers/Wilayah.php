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
class Wilayah extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('Wilayahmodel');
//        $this->load->library("firebase/Firebase");
//        $this->load->library("firebase/Push");
//        $this->load->library("firebase/config");
        //$this->db->cache_on();
    }

    /**
     * METHOD/FUNCTION JOBS CRUD
     */
    // GET WILAYAH PROV
    public function getprovinsi_get() {

        $data ['result'] = $this->Wilayahmodel->get_provinsi();
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
                'message' => 'Data tidak ditemukan'
                    ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
    }

    // GET WILAYAH KAB
    public function getkabupaten_get() {
        $id_provinsi = $this->get('id_provinsi');

        if (!$id_provinsi) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID/Kode salah'], REST_Controller::HTTP_OK);
        } else {
            $data ['result'] = $this->Wilayahmodel->get_kabupaten($id_provinsi);
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
                    'message' => 'Data tidak ditemukan'
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    // GET WILAYAH KEC
    public function getkecamatan_get() {
        $id_provinsi = $this->get('id_provinsi');
        $id_kabupaten = $this->get('id_kabupaten');

        if (!$id_provinsi) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID/Kode salah'], REST_Controller::HTTP_OK);
        } else {
            $data ['result'] = $this->Wilayahmodel->get_kecamatan($id_provinsi, $id_kabupaten);
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
                    'message' => 'Data tidak ditemukan'
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    // GET WILAYAH KEL
    public function getkelurahan_get() {
        $id_provinsi = $this->get('id_provinsi');
        $id_kabupaten = $this->get('id_kabupaten');
        $id_kecamatan = $this->get('id_kecamatan');

        if (!$id_provinsi) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID/Kode salah'], REST_Controller::HTTP_OK);
        } else {
            $data ['result'] = $this->Wilayahmodel->get_kelurahan($id_provinsi, $id_kabupaten, $id_kecamatan);
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
                    'message' => 'Data tidak ditemukan'
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

}
