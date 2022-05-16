<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Menu extends RestController 
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Menu_m", "menu");
        $this->load->model('Kadaluarsa_m', "kadaluarsa");
        $this->kadaluarsa->getTransaksiKadaluarsa();
    }


    public function index_get($id = null)
    {
        if($id !== null)
        {
            $menu = $this->menu->getMenu($id);
        }
        else
        {
            $menu = $this->menu->getMenu();
        }
        
        if($menu){
            $this->response([
                'success' => true,
                'message' => 'Berhasil ambil data',
                'data' => $menu
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Gagal ambil data',
                'data' => []
            ],self::HTTP_NOT_FOUND);
        }
    }

    public function kategori_get($id)
    {
        $menu = $this->menu->getMenuByIdKategori($id);
        
        if($menu){
            $this->response([
                'success' => true,
                'message' => 'Berhasil ambil data',
                'data' => $menu
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Gagal ambil data',
                'data' => []
            ],self::HTTP_NOT_FOUND);
        }
    }

    public function terlaris_get()
    {
        $limit = 10;
        
        $menu = $this->menu->getMenuTerlaris($limit);
        
        if($menu){
            $this->response([
                'success' => true,
                'message' => 'Berhasil ambil data',
                'data' => $menu
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Gagal ambil data',
                'data' => []
            ],self::HTTP_NOT_FOUND);
        }
    }

    public function search_get($search)
    {
        $menu = $this->menu->getMenuByName($search);
        
        if($menu){
            $this->response([
                'success' => true,
                'message' => 'Berhasil ambil data',
                'data' => $menu
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Gagal ambil data',
                'data' => []
            ],self::HTTP_NOT_FOUND);
        }
    }

    public function hapus_get($id = null)
    {
        
        if ($id === null) {
            $this->response([
                'success' => false,
                'message' => 'provide an id'
            ],self::HTTP_BAD_REQUEST);
        }else {
            if ($this->menu->deleteMenu($id) > 0) {
                $this->response([
                    'success' => true,
                    'id' => $id,
                    'message' => 'Berhasil dihapus.'
                ],self::HTTP_CREATED);
            }else {
                $this->response([
                    'success' => false,
                    'message' => 'Id tidak ditemukan!'
                ],self::HTTP_BAD_REQUEST);
            }
        }
    }

    public function update_post()
    {
        $id = $this->post('id_menu');
        $data =[
            'id_kategori' => $this->post('id_kategori'),
            'menu' => $this->post('menu'),
            'deskripsi' => $this->post('deskripsi'),
            'stok' => $this->post('stok'),
            'harga' => $this->post('harga')
        ];

        // cek upload image photo
        if (!empty($_FILES["photo"])) {
            if($_FILES["photo"]["error"] == 0){
                $data["photo"] = $this->_uploadFile($_FILES["photo"]);
            }
        } 

        if ($this->menu->updateMenu($data, $id) > 0) {
            $this->response([
                'success' => true,
                'message' => 'Berhasil ubah menu'
            ],self::HTTP_CREATED);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Gagal ubah menu'
            ],self::HTTP_BAD_REQUEST);
        }
    }

    public function tambah_post()
    {
        $data =[
            'id_kategori' => $this->post('id_kategori'),
            'menu' => $this->post('menu'),
            'deskripsi' => $this->post('deskripsi'),
            'stok' => $this->post('stok'),
            'harga' => $this->post('harga')
        ];

        // cek upload image photo
        if (!empty($_FILES["photo"])) {
            if($_FILES["photo"]["error"] == 0){
                $data["photo"] = $this->_uploadFile($_FILES["photo"]);
            }
        } 

        if ($this->menu->tambahMenu($data) > 0) {
            $this->response([
                'success' => true,
                'message' => 'Berhasil tambah menu'
            ],self::HTTP_CREATED);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Gagal tambah menu'
            ],self::HTTP_BAD_REQUEST);
        }
    }

    // upload image
    private function _uploadFile($file)
    {
        $config['upload_path'] = './images/menu/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size']     = 4092;
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