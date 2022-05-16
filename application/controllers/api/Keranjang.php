<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Keranjang extends RestController 
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Keranjang_m", "keranjang");

    }

    public function index_post()
    {
        date_default_timezone_set('Asia/Jakarta');

        $id_user = $this->post('id_user');

        $keranjang = $this->keranjang->getKeranjangByidUser($id_user);

        if ($keranjang) {
            $this->response([
                'success' => true,
                'message' => 'Berhasil Ambil data!.',
                'id_user' => $id_user,
                'data' => $keranjang
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Gagal Ambil data!.',
                'id_user' => $id_user,
                'data' => []
            ],self::HTTP_BAD_REQUEST);
        }
    }

    public function add_post()
    {
        date_default_timezone_set('Asia/Jakarta');

        $data = [
            'id_user' => $this->post('id_user'),
            'id_menu' => $this->post('id_menu'),
            'qty' => $this->post('qty')
        ];
        
        if ($this->keranjang->cekKeranjang($data['id_menu'], $data['id_user'])) {
            $this->response([
                'success' => false,
                'message' => 'Telah ada di Keranjang.'
            ],self::HTTP_BAD_REQUEST);
        } else {
            $keranjang = $this->keranjang->addKeranjang($data);
            if ($keranjang > 0) {
                $this->response([
                    'success' => true,
                    'message' => 'Berhasil dimasukkan Keranjang!.'
                ],self::HTTP_CREATED);
            }else {
                $this->response([
                    'success' => false,
                    'message' => 'Gagal Masukkan Keranjang!.'
                ],self::HTTP_BAD_REQUEST);
            }

        }
    }

    public function jumlah_post()
    {   
        $id_user = $this->post('id_user');
        $keranjang = $this->keranjang->getJumlahKeranjang($id_user);
        if ($keranjang ) {
            $this->response([
                'success' => true,
                'message' => 'Berhasil Ambil data!.',
                'id_user' => $id_user,
                'data' => $keranjang
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => true,
                'message' => 'Berhasil Ambil data!.',
                'id_user' => $id_user,
                'data' => []
            ],self::HTTP_BAD_REQUEST);
        }
        
    }

    public function delete_post()
    {
        $id_user = $this->post('id_user');
        $id_menu = $this->post('id_menu');

        if ($this->uri->segment(4) === 'user') {
            if ($this->keranjang->deleteKeranjangByIdUser($id_user) > 0) {
                $this->response([
                    'success' => true,
                    'message' => 'Berhasil Hapus Keranjang.'
                ],self::HTTP_CREATED);
            }else {
                $this->response([
                    'success' => false,
                    'message' => 'Gagal Hapus Keranjang!'
                ],self::HTTP_BAD_REQUEST);
            }
        }else{
            if ($this->keranjang->deleteKeranjang($id_user, $id_menu) > 0) {
                $this->response([
                    'success' => true,
                    'message' => 'Berhasil Hapus Keranjang.'
                ],self::HTTP_CREATED);
            }else {
                $this->response([
                    'success' => false,
                    'message' => 'Gagal Hapus Keranjang!'
                ],self::HTTP_BAD_REQUEST);
            }
        } 
    }

    public function update_qty_post()
    {
        date_default_timezone_set('Asia/Jakarta');

        $data = [
            'id_user' => $this->post('id_user'),
            'id_menu' => $this->post('id_menu'),
            'qty' => $this->post('qty')
        ];

        $keranjang = $this->keranjang->updateQty($data);
        if ($keranjang > 0) {
            $this->response([
                'success' => true,
                'message' => 'Berhasil diupdate Keranjang!.'
            ],self::HTTP_CREATED);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Gagal diupdate Keranjang!.'
            ],self::HTTP_BAD_REQUEST);
        }
    }

}