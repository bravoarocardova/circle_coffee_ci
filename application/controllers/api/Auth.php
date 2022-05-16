<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Auth extends RestController 
{

    function __construct()
    {
        parent::__construct();
        // header('Access-Control-Allow-Origin: *');
        // header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        // header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        $this->load->model("Auth_m", "auth");

    }

    public function index_post()
    {
        date_default_timezone_set('Asia/Jakarta');
 
        $data =[
            'email' => $this->post('email'),
            'password' => $this->post('password')
        ];
        
        $data = $this->auth->login($data);

        if ($data) {
            $this->response([
                'success' => true,
                'message' => 'Login Berhasil.',
                'data' => $data
            ],self::HTTP_CREATED);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Email/Kata Sandi salah!',
            ],self::HTTP_BAD_REQUEST);
        }
    }

    public function register_post()
    {
        date_default_timezone_set('Asia/Jakarta');

        $data =[
            'nama' => $this->post('nama'),
            'email' => $this->post('email'),
            'no_telp' => $this->post('no_telp'),
            'password' => $this->post('password'),
            'role_id' => $this->post('role_id'),
            'is_active' => $this->post('is_active'),
        ];

        // cek upload image file
        // if (!empty($_FILES["foto"])) {
        //     $data["foto"] = $this->_uploadFile($_FILES["foto"]);
        // } else {
        //     $data["foto"] = "";
        // }
        
        if($this->auth->checkEmailExits($data['email'])){
            $this->response([
                'success' => false,
                'message' => 'Register Gagal Email telah digunakan!'
            ],self::HTTP_BAD_REQUEST);
        }else {
            if ($this->auth->register($data) > 0) {
                $this->response([
                    'success' => true,
                    'message' => 'Register Berhasil.'
                ],self::HTTP_CREATED);
            }else {
                $this->response([
                    'success' => false,
                    'message' => 'Register Gagal'
                ],self::HTTP_BAD_REQUEST);
            }
        }
    }


    // upload image
    // private function _uploadFile($file)
    // {
    //     $config['upload_path'] = './imageUpload/';
    //     $config['allowed_types'] = 'gif|jpg|png|jpeg';
    //     $config['max_size']     = 2048;
    //     // $config['file_name'] = $this->post('id') . '-' . date('dmYHis') . '-' . basename($_FILES['abstrak']['name']);
    //     $this->load->library('upload', $config);

    //     $_FILES['file']['name'] = date('dmYHis')."_".str_replace("", "", basename($file['name']));
    //     $_FILES['file']['type'] = $file['type'];
    //     $_FILES['file']['tmp_name'] = $file['tmp_name'];
    //     $_FILES['file']['error'] = $file['error'];
    //     $_FILES['file']['size'] = $file['size'];

    //     if($this->upload->do_upload('file')){
    //         $file_name = $this->upload->data('file_name');
    //     }else{
    //         $file_name = "";
    //     }

    //     return $file_name;

    // }

}