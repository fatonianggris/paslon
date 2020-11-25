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
            $count = $this->Ktpmodel->count_ktp_petugas_all($id_pet);
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

    public function ktpalladmin_get() {
        $id_admin = $this->get('id_admin');
        $id_role = $this->get('role_admin');
        $limit = $this->get('limit');

        if (!$id_admin) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID salah'], REST_Controller::HTTP_OK);
        } else {
            $count = $this->Ktpmodel->count_ktp_admin_all($id_admin, $id_role);
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
        $this->load->library('zend');
        $this->zend->load('Zend/Barcode');

        $image_id = $this->post('img');
        $image_id_thumb = $this->post('img_thumb');

        $nama_image_ktp = $this->post('nama_img_ktp');
        $nama_image_pas_foto = $this->post('nama_img_pas_foto');

        $image_pas = $this->post('img_pas');
        $image_pas_thumb = $this->post('img_pas_thumb');

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $id_admin = $this->Ktpmodel->get_by_id_admin_reg($data['id_admin']);

        $name_file_ktp = strtolower($nama_image_ktp);
        $name_file_pas_foto = strtolower($nama_image_pas_foto);

        $get_code_wilayah = $this->Ktpmodel->get_code_wil($id_admin[0]->id_ref, $id_admin[0]->role_admin);

        $no_urut = '';
        $get_no_urutan = $this->Ktpmodel->get_no_urut($id_admin[0]->id_ref);

        $tgl_lahir = explode("/", $data['tanggal_lahir']);
        $no_tgl_lahir = substr($tgl_lahir['2'], 2, 2);
        $tgl_lahir_gab = $tgl_lahir['0'] . $tgl_lahir['1'] . $no_tgl_lahir;

        if (empty($get_no_urutan)) {
            $no_urut = '000001';
        } else {
            $no_urut = str_pad($get_no_urutan[0]->no_urut + 1, 6, "0", STR_PAD_LEFT);
        }

        $no_kta_baru = $get_code_wilayah[0]->code . $data['id_asal'] . $tgl_lahir_gab . $no_urut;

        if ($data) {

            if ($nama_image_ktp != '') {
                $path_id = $id_admin[0]->path . '/' . $name_file_ktp . '_ktp.png';
                $path_id_thumb = $id_admin[0]->path . '/thumbs/' . $name_file_ktp . '_ktp.png';

                file_put_contents($path_id, base64_decode($image_id));
                file_put_contents($path_id_thumb, base64_decode($image_id_thumb));

                $data['pic'] = $path_id;
                $data['pic_thumb'] = $path_id_thumb;
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Mohon maaf, foto ID belum diupload.'], REST_Controller::HTTP_OK);
            }

            if ($nama_image_pas_foto != '') {
                $path_pas = $id_admin[0]->path . '/' . $name_file_pas_foto . '_pas_foto.png';
                $path_pas_thumb = $id_admin[0]->path . '/pasfoto_thumbs/' . $name_file_pas_foto . '_pas_foto.png';

                file_put_contents($path_pas, base64_decode($image_pas));
                file_put_contents($path_pas_thumb, base64_decode($image_pas_thumb));

                $data['pic_pas'] = $path_pas;
                $data['pic_pas_thumb'] = $path_pas_thumb;
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Mohon maaf, pas foto belum diupload.'], REST_Controller::HTTP_OK);
            }

            if (!empty($no_kta_baru)) {

                $image_resource = Zend_Barcode::factory('code128', 'image', array('text' => $no_kta_baru, 'barHeight' => 20, 'factor' => 1,), array())->draw();
                $barcode_name = $name_file . '.jpg';
                $image_dir = $id_admin[0]->path . '/barcode/'; // penyimpanan file barcode
                $data['nik_kta_baru'] = $no_kta_baru;
                $data['barcode'] = $image_dir . $barcode_name;
                imagejpeg($image_resource, $image_dir . $barcode_name);
            } else {

                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Maaf, Generate Barcode terjadi kesalahan.'], REST_Controller::HTTP_OK);
            }

            $input = $this->Ktpmodel->insert_ktp($data, $id_admin[0]->id_ref);

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

        $nama_img_id = $this->post('nama_img_id');
        $image_id = $this->post('img');
        $image_id_thumb = $this->post('img_thumb');

        $nama_image_ktp = $this->post('nama_img_ktp');
        $nama_image_pas_foto = $this->post('nama_img_pas_foto');

        $nama_img_pas = $this->post('nama_img_pas');
        $image_pas = $this->post('img_pas');
        $image_pas_thumb = $this->post('img_pas_thumb');

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $id_admin = $this->Ktpmodel->get_by_id_admin_reg($data['id_admin']);

        $name_file_ktp = strtolower($nama_image_ktp);
        $name_file_pas_foto = strtolower($nama_image_pas_foto);
//
//        $data_img_id = explode('/', $nama_img_id);
//        $img_id_name = $data_img_id[4];
//
//        $data_img_pas = explode('/', $nama_img_pas);
//        $img_pas_name = $data_img_pas[4];

        if ($data) {

            if ($nama_image_ktp != '') {
                
                $this->delete_file_ktp($nama_img_id, $data['id_admin']);

                $path_id = $id_admin[0]->path . '/' . $name_file_ktp . '_ktp.png';
                $path_id_thumb = $id_admin[0]->path . '/thumbs/' . $name_file_ktp . '_ktp.png';

                file_put_contents($path_id, base64_decode($image_id));
                file_put_contents($path_id_thumb, base64_decode($image_id_thumb));

                $data['pic'] = $path_id;
                $data['pic_thumb'] = $path_id_thumb;
            } else {
                $data['pic'] = $image_id;
                $data['pic_thumb'] = $image_id_thumb;
            }

            if ($nama_image_pas_foto != '') {
                $this->delete_file_pasfoto($nama_img_pas, $data['id_admin']);

                $path_pas = $id_admin[0]->path . '/' . $name_file_pas_foto . '_pas_foto.png';
                $path_pas_thumb = $id_admin[0]->path . '/pasfoto_thumbs/' . $name_file_pas_foto . '_pas_foto.png';

                file_put_contents($path_pas, base64_decode($image_pas));
                file_put_contents($path_pas_thumb, base64_decode($image_pas_thumb));

                $data['pic_pas'] = $path_pas;
                $data['pic_pas_thumb'] = $path_pas_thumb;
            } else {
                $data['pic_pas'] = $image_pas;
                $data['pic_pas_thumb'] = $image_pas_thumb;
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

        if ($id_ktp) {
            // get the data by id
            $delete = $this->Ktpmodel->delete_ktp($id_ktp);
            //print_r($user);exit();
            if ($delete) {
                // data is found                
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

}
