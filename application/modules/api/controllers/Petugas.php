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
class Petugas extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('Petugasmodel');
        //$this->db->cache_on();
    }

    public function petugasktp_get() {
        $id = $this->get('id_petugas');
        if (!$id) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID salah'], REST_Controller::HTTP_OK);
        } else {
            $data = $this->Petugasmodel->get_petugas_by_id($id);
            $result = array();
            if ($data) {
                // Set the response and exit
                // data is found              
                foreach ($data as $key => $value) {
                    $result['status'] = TRUE;
                    $result['petugas'] = $value;
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

    public function petugasadmin_get() {
        $id_admin = $this->get('id_admin');
        $id_role = $this->get('id_role');
        $limit = $this->get('limit');

        if (!$id_admin) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID salah'], REST_Controller::HTTP_OK);
        } else {
            $count = $this->Petugasmodel->count_pet_admin($id_admin, $id_role);
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($count) {
                if ($limit >= $count) {
                    $data['status'] = FALSE;
                    $data['message'] = "Data terakhir telah diupdate";
                    $limit = $count;
                } else {
                    $data['status'] = TRUE;
                }
                $data['result'] = $this->Petugasmodel->get_petugas_admin($id_admin, $id_role, $limit);
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

    // UPDATE USER
    public function updatepetugas_post() {

        $id_petugas = $this->post('id_petugas');
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

                $path = 'uploads/petugas/' . $nama_image . '.png';
                $path_thumb = 'uploads/petugas/thumbs/' . $nama_image . '.png';

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
                $this->Petugasmodel->update_pass($id_petugas, $dt);
            }

            $input = $this->Petugasmodel->update_petugas($id_petugas, $data);
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

    public function delete_file_petugas($name = '') {
        $path = './uploads/petugas/';
        $path_thumb = './uploads/petugas/thumbs/';
        @unlink($path . $name);
        @unlink($path_thumb . $name);
    }

}
