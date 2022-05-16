<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Laporan extends RestController 
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Laporan_m", "laporan");

    }

    public function index_get()
    {
        $id = $this->get('id_penelitian');
        $jenis = $this->get('jenis');
        $id_user = $this->get('id_users');

        if($id !== null && $jenis !== null)
        {
            $laporan = $this->laporan->getLaporan($id, $jenis);
        }
        else if($id_user !== null)
        {
            $laporan = $this->laporan->getLaporanUser($id_user);
        }
        else
        {
            $laporan = $this->laporan->getLaporan();
        }

        if($laporan){
            $this->response([
                'status' => true,
                'data' => $laporan
            ],self::HTTP_OK);
        }else {
            $this->response([
                'status' => false,
                'message' => 'not found'
            ],self::HTTP_NOT_FOUND);
        }
    }

    public function index_post()
    {
        date_default_timezone_set('Asia/Jakarta');

        $data =[
            'id_penelitian' => $this->post('id_penelitian'),
            'jenis' => $this->post('jenis'),
            'id_users' => $this->post('id_users')
        ];

        // cek upload image file
        if (!empty($_FILES["file"])) {
            $data["file"] = $this->_uploadFile($_FILES["file"]);
        } else {
            $data["file"] = "";
        }

        if ($this->laporan->addLaporan($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new laporan has been added.'
            ],self::HTTP_CREATED);
        }else {
            $this->response([
                'status' => false,
                'message' => 'failed to add new data'
            ],self::HTTP_BAD_REQUEST);
        }
    }

    public function update_post()
    {
        $id = $this->post('id');
        $data =[
            'id_penelitian' => $this->post('id_penelitian'),
            'jenis' => $this->post('jenis'),
            'id_users' => $this->post('id_users')
        ];

        // cek upload image file
        if (!empty($_FILES["file"])) {
            if($_FILES["file"]["error"] == 0){
                $data["file"] = $this->_uploadFile($_FILES["file"]);
            }
        }

        if ($this->laporan->updateLaporan($data, $id) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new laporan has been modify'
            ],self::HTTP_CREATED);
        }else {
            $this->response([
                'status' => false,
                'message' => 'failed to modify new data'
            ],self::HTTP_BAD_REQUEST);
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id'
            ],self::HTTP_BAD_REQUEST);
        }else {
            if ($this->laporan->deleteLaporan($id) > 0) {
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'deleted.'
                ],self::HTTP_CREATED);
            }else {
                $this->response([
                    'status' => false,
                    'message' => 'id not found!'
                ],self::HTTP_BAD_REQUEST);
            }
        }
    }


    // upload image
    private function _uploadFile($file)
    {
        $config['upload_path'] = './keluaran/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|doc|docx|pdf';
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