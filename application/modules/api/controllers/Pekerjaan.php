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
class Pekerjaan extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('Pekerjaanmodel');
//        $this->load->library("firebase/Firebase");
//        $this->load->library("firebase/Push");
//        $this->load->library("firebase/config");
        //$this->db->cache_on();
    }

    /**
     * METHOD/FUNCTION JOBS CRUD
     */
    // GET PEKERJAAN

    public function getpekerjaan_get() {

        $data['result'] = $this->Pekerjaanmodel->get_pekerjaan();

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

    public function getnamapekerjaan_get() {
        $nama_pekerjaan = $this->get('nama_pekerjaan');

        if (!$nama_pekerjaan) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID/Kode salah'], REST_Controller::HTTP_OK);
        } else {

            $data_list = $this->Pekerjaanmodel->get_pekerjaan();
            $data = $this->Pekerjaanmodel->get_nama_pekerjaan($nama_pekerjaan);
            $result = array();

            if ($data) {

                foreach ($data as $key => $value) {
                    $result['status'] = TRUE;
                    $result['get_pekerjaan'] = $value;
                }
                $result['pekerjaan'] = $data_list;

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
                    'message' => 'Data pekerjaan tidak ditemukan'
                        ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

}
