<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Kategori extends RestController 
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Kategori_m", "kategori");

    }

    public function index_get($id = null)
    {   
        if($id !== null)
        {
            $kategori = $this->kategori->getKategori($id);
        }
        else
        {
            $kategori = $this->kategori->getKategori();
        }

        if($kategori){
            $this->response([
                'success' => true,
                'message' => 'Berhasil ambil data',
                'data' => $kategori
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Gagal ambil data',
                'data' => []
            ],self::HTTP_NOT_FOUND);
        }
    }

}