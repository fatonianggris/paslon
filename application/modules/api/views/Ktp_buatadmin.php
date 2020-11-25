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
class Ktp extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('Ktpmodel');
//        $this->load->library("firebase/Firebase");
//        $this->load->library("firebase/Push");
//        $this->load->library("firebase/config");
        //$this->db->cache_on();
    }

    /**
     * METHOD/FUNCTION JOBS CRUD
     */

//GET ALL KTP PETUGAS
    public function ktpallpetugas_get() {
        $id_pet = $this->get('id_petugas');

        $limit = $this->get('limit');
        if (!$id_pet) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID salah'], REST_Controller::HTTP_OK);
        } else {
            $count = $this->Ktpmodel->count_ktp_all($id_pet);
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($count) {
                if ($limit >= $count) {
                    $data['status'] = FALSE;
                    $data['message'] = "Data terakhir telah diupdate";
                    $limit = $count;
                } else {
                    $data['status'] = TRUE;
                }
                $data['result'] = $this->Ktpmodel->get_all_ktp_petugas($id_pet, $limit);
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

    //get ktp by id
    public function detailktp_get() {
        $id = $this->get('id_ktp');
        if (!$id) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID salah'], REST_Controller::HTTP_OK);
        } else {
            $data = $this->Ktpmodel->get_detail_ktp($id);
            $result = array();
            if ($data) {
                // Set the response and exit
                // data is found              
                foreach ($data as $key => $value) {
                    $result['status'] = TRUE;
                    $result['detail_ktp'] = $value;
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
                    'message' => 'KTP tidak ditemukan'
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    // ADD PROJECT
    public function addktp_post() {

        $image = $this->post('img');
        $image_thumb = $this->post('img_thumb');
        $nama_image = $this->post('nama_img');
        $region_anggota = $this->post('region_anggota');

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $id_admin = $this->Ktpmodel->get_by_id_admin_reg($region_anggota);
        $path_reg = $this->Ktpmodel->get_path_by_id_reg($region_anggota);

        if ($data) {

            if ($nama_image != '') {
                $path = $path_reg[0]->path . '/' . $nama_image . '.png';
                $path_thumb = $path_reg[0]->path . '/thumbs/' . $nama_image . '.png';

                file_put_contents($path, base64_decode($image));
                file_put_contents($path_thumb, base64_decode($image_thumb));
                $data['pic'] = $path;
                $data['pic_thumb'] = $path_thumb;
            } else {
                $data['pic'] = $image;
                $data['pic_thumb'] = $image_thumb;
            }

            $input = $this->Ktpmodel->insert_ktp($data, $id_admin[0]->id_admin);
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

    // UPDATE JOB
    public function updatektp_post() {
        $id_ktp = $this->post('id_ktp');

        $image = $this->post('img');
        $image_thumb = $this->post('img_thumb');
        $nama_image = $this->post('nama_img');
        $region_ktp = $this->post('region_ktp');

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $path_reg = $this->Ktpmodel->get_path_by_id_reg($region_ktp);

        if ($data) {
            if ($nama_image != '') {
                $path = $path_reg[0]->path . '/' . $nama_image . '.png';
                $path_thumb = $path_reg[0]->path . '/thumbs/' . $nama_image . '.png';

                file_put_contents($path, base64_decode($image));
                file_put_contents($path_thumb, base64_decode($image_thumb));
                $data['pic'] = $path;
                $data['pic_thumb'] = $path_thumb;
            } else {
                $data['pic'] = $image;
                $data['pic_thumb'] = $image_thumb;
            }

            $input = $this->Ktpmodel->update_ktp($id_ktp, $data);
            if ($input == true) {
                $this->set_response([
                    'status' => TRUE,
                    'message' => 'Data telah tersimpan'], REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => TRUE,
                    'message' => 'Mohon maaf, terjadi kesalahan.'], REST_Controller::HTTP_OK);
            }
        } else {
            // user is not found with the credentials
            $this->set_response([
                'status' => TRUE,
                'message' => 'Mohon maaf, server sedang sibuk'], REST_Controller::HTTP_OK);
        }
    }

    // DELETE KTP
    public function deletektp_post() {

        $id_ktp = $this->input->post('id_ktp');
        $data = $this->Ktpmodel->get_img_by_id_ktp($id_ktp);
        $data_img = explode('/', $data[0]->img);
        $name_img = $data_img[4];

        if ($id_ktp) {
            // get the data by id
            $delete = $this->Ktpmodel->delete_ktp($id_ktp);
            //print_r($user);exit();
            if ($delete) {
                // data is found    
                $this->delete_file($name_img, $data[0]->id_regional);
                $this->set_response([
                    'status' => TRUE,
                    'message' => 'Data berhasil dihapus!'], REST_Controller::HTTP_OK);
            } else {
                // required post params is missing
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'ID tidak ditemukan!'], REST_Controller::HTTP_OK);
            }
        } else {
            // required post params is missing
            $this->set_response([
                'status' => FALSE,
                'message' => 'Mohon maaf, server sedang sibuk!'], REST_Controller::HTTP_OK);
        }
    }

    public function delete_file($name = '', $id = '') {

        $path_reg = $this->Ktpmodel->get_path_by_id_reg($id);

        $path = $path_reg[0]->path . '/';
        $path_thumb = $path_reg[0]->path . '/thumbs/';
        @unlink($path . $name);
        @unlink($path_thumb . $name);
    }

    public function ktpregadmin_get() {
        $id_admin = $this->get('id_admin');
        $id_reg = $this->get('id_regional');
        $id_role = $this->get('id_role');

        $limit = $this->get('limit');

        if (!$id_admin) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID salah'], REST_Controller::HTTP_OK);
        } else {
            $count = $this->Ktpmodel->count_ktp_reg_admin($id_admin, $id_reg, $id_role);
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($count) {
                if ($limit >= $count) {
                    $data['status'] = FALSE;
                    $data['message'] = "Data terakhir telah diupdate";
                    $limit = $count;
                } else {
                    $data['status'] = TRUE;
                }
                $data['result'] = $this->Ktpmodel->get_ktp_reg_petugas($id_admin, $id_reg, $id_role, $limit);
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

    //GET ALL KTP PETUGAS
    public function ktpalladmin_get() {
        $id_admin = $this->get('id_admin');
        $id_role = $this->get('id_role');

        $limit = $this->get('limit');

        if (!$id_admin) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID salah'], REST_Controller::HTTP_OK);
        } else {
            $count = $this->Ktpmodel->count_ktp_all_admin($id_admin, $id_role);
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($count) {
                if ($limit >= $count) {
                    $data['status'] = FALSE;
                    $data['message'] = "Data terakhir telah diupdate";
                    $limit = $count;
                } else {
                    $data['status'] = TRUE;
                }
                $data['result'] = $this->Ktpmodel->get_all_ktp_admin($id_admin, $id_role, $limit);
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

}
