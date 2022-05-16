<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class User extends RestController 
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("User_m", "user");

    }

    public function index_get($id = null)
    {

        if($id !== null)
        {
            $user = $this->user->getUser($id);
        }
        else
        {
            $user = $this->user->getUser();
        }

        if($user){
            $this->response([
                'success' => true,
                'data' => $user
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => false,
                'message' => 'not found'
            ],self::HTTP_NOT_FOUND);
        }
    }

    public function search_get($nama)
    {

        $user = $this->user->getUserNama($nama);

        if($user){
            $this->response([
                'success' => true,
                'data' => $user
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => false,
                'message' => 'not found'
            ],self::HTTP_NOT_FOUND);
        }
    }

    public function user_role_get()
    {
        $user = $this->user->getUserRole();

        if($user){
            $this->response([
                'success' => true,
                'data' => $user
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => false,
                'message' => 'not found'
            ],self::HTTP_NOT_FOUND);
        }
    }

    public function update_post()
    {
        $id = $this->post('id_user');
        $data =[
            'nama' => $this->post('nama'),
            'email' => $this->post('email'),
            'no_telp' => $this->post('no_telp'),
            
            // 'is_active' => $this->post('is_active'),
        ];
        $role_id = $this->post('role_id');
        if (!empty($role_id)) {
            $data['role_id'] = $role_id;
        }
        $password = $this->post('password');
        if (!empty($password)) {
            $data['password'] = $password;
        }
        
        // cek upload image user
        if (!empty($_FILES["foto"])) {
            if($_FILES["foto"]["error"] == 0){
                $data["foto"] = $this->_uploadFile($_FILES["foto"]);
            }
        }

        if ($this->user->updateUser($data, $id) > 0) {
            $this->response([
                'success' => true,
                'message' => 'Berhasil update user'
            ],self::HTTP_CREATED);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Gagal update user'
            ],self::HTTP_BAD_REQUEST);
        }
    }

    // upload image
    private function _uploadFile($file)
    {
        $config['upload_path'] = './images/profil/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size']     = 2048;
        // $config['file_name'] = $this->post('id') . '-' . date('dmYHis') . '-' . basename($_FILES['abstrak']['name']);
        $this->load->library('upload', $config);

        $_FILES['file']['name'] = date('dmYHis')."_".str_replace("", "", basename($file['name']));
        $_FILES['file']['type'] = $file['type'];
        $_FILES['file']['tmp_name'] = $file['tmp_name'];
        $_FILES['file']['error'] = $file['error'];
        $_FILES['file']['size'] = $file['size'];

        if($this->upload->do_upload('file')){
            $file_name = $this->upload->data('file_name');
        }else{
            $file_name = "";
        }

        return $file_name;

    }

}