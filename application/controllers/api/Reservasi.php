<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Reservasi extends RestController 
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Reservasi_m", "reservasi");
        $this->load->model('Kadaluarsa_m', "kadaluarsa");
        $this->kadaluarsa->getTransaksiReservasiKadaluarsa();
        $this->kadaluarsa->getTransaksiSelesaiReservasiKadaluarsa();
    }

    public function index_get($id = null)
    {
        if($id !== null)
        {
            $reservasi = $this->reservasi->getReservasi($id);
        }else
        {
            $reservasi = $this->reservasi->getReservasi();
        }

        if($reservasi){
            $this->response([
                'success' => true,
                'message' => 'Berhasil ambil data.',
                'data' => $reservasi
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => false,
                'message' => 'not found',
                'data' => []
            ],self::HTTP_NOT_FOUND);
        }
    }

    public function tanggal_post()
    {
        $tglAwal = $this->post('tgl_awal');
        $tglAkhir = $this->post('tgl_akhir');
        $reservasi = $this->reservasi->getReservasibytanggal($tglAwal,$tglAkhir);

        if($reservasi){
            $data = [];
            foreach($reservasi as $item){
                $item->petugas = $this->reservasi->getPetugas($item->petugas);
                $data[] = $item;
            }
            $this->response([
                'success' => true,
                'message' => 'Berhasil ambil data.',
                'data' => $data
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => false,
                'message' => 'not found',
                'data' => []
            ],self::HTTP_NOT_FOUND);
        }
    }

    public function pesanan_get()
    {
        $nama = $this->uri->segment(4);

        if ($nama != null) {
            $reservasi = $this->reservasi->getPesananReservasiBayarOrder($nama);
        }else{
            $reservasi = $this->reservasi->getPesananReservasiBayarOrder();
        }
        
        $data = [];
        if($reservasi){
            foreach($reservasi as $row){
                $row->kadaluwarsa = date('Y-m-d H:i:s',strtotime($row->tgl_transaksi) + 60 * 30);
                $data[] = $row;
            }
            $this->response([
                'success' => true,
                'message' => 'Berhasil Ambil data',
                'data' => $data
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
                'data' => []
            ],self::HTTP_NOT_FOUND);
        }
    }

    public function belum_lunas_get()
    {
        $nama = $this->uri->segment(4);

        if ($nama != null) {
            $reservasi = $this->reservasi->getBelumLunasReservasiOrder($nama);
        }else{
            $reservasi = $this->reservasi->getBelumLunasReservasiOrder();
        }
        $data = [];
        
        if($reservasi){
            foreach($reservasi as $item){
                $item->petugas = $this->reservasi->getPetugas($item->petugas);
                $data[] = $item;
            }
            $this->response([
                'success' => true,
                'message' => 'Berhasil Ambil data',
                'data' => $data
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
                'data' => []
            ],self::HTTP_NOT_FOUND);
        }
    }

    public function lunas_get()
    {
        $nama = $this->uri->segment(4);

        if ($nama != null) {
            $reservasi = $this->reservasi->getLunasOrder($nama);
        }else{
            $reservasi = $this->reservasi->getLunasOrder();
        }
        $data = [];
        foreach($reservasi as $item){
            $item->petugas = $this->reservasi->getPetugas($item->petugas);
            $data[] = $item;
        }
        if($reservasi){
            $this->response([
                'success' => true,
                'message' => 'Berhasil Ambil data',
                'data' => $data
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
                'data' => []
            ],self::HTTP_NOT_FOUND);
        }
    }

    public function selesai_get()
    {
        $nama = $this->uri->segment(4);

        if ($nama != null) {
            $reservasi = $this->reservasi->getSelesaiOrder($nama);
        }else{
            $reservasi = $this->reservasi->getSelesaiOrder();
        }
        $data = [];
        foreach($reservasi as $item){
            $item->petugas = $this->reservasi->getPetugas($item->petugas);
            $data[] = $item;
        }
        if($reservasi){
            $this->response([
                'success' => true,
                'message' => 'Berhasil Ambil data',
                'data' => $data
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
                'data' => []
            ],self::HTTP_NOT_FOUND);
        }
    }

    public function list_pesanan_get($id=null)
    {
        if($id !== null)
        {
            $reservasi = $this->reservasi->getListPesananReservasi($id);
        }else
        {
            $reservasi = $this->reservasi->getListPesananReservasi();
        }
        
        if($reservasi){
            $this->response([
                'success' => true,
                'message' => 'Berhasil ambil data.',
                'data' => $reservasi
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => false,
                'message' => 'not found',
                'data' => []
            ],self::HTTP_NOT_FOUND);
        }
    }

    public function transaksi_post()
    {
        $data =[
            'id_reservasi' => $this->post('id_reservasi'),
            'id_user' => $this->post('id_user'),
            'total' => $this->post('total'),
            'status' => 'Belum Bayar',
            'tgl_reservasi' => $this->post('tgl_reservasi'),
            'tgl_transaksi' => date('Y-m-d H:i:s'),
        ];

        if ($this->reservasi->addTransaksiReservasi($data) > 0) {
            $this->response([
                'success' => true,
                'message' => 'Berhasil ditambah, Silahkan melakukan pembayaran.'
            ],self::HTTP_CREATED);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Tanggal yang dipesan tidak tersedia'
            ],self::HTTP_BAD_REQUEST);
        }

    }

    public function pesanan_post()
    {
        $id_user = $this->post('id_user');

        $reservasi = $this->reservasi->getPesananReservasi($id_user);
        
        if ($reservasi) {
            $data = [];
            foreach($reservasi as $row){
                $row->kadaluwarsa = date('Y-m-d H:i:s',strtotime($row->tgl_transaksi) + 60 * 30);
                $data[] = $row;
            }
            $this->response([
                'success' => true,
                'message' => 'Berhasil Ambil data.',
                'data' => $data
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Tidak Ada data',
                'data' => [],
            ],self::HTTP_BAD_REQUEST);
        }
    }

    public function riwayat_post()
    {
        $id_user = $this->post('id_user');

        $reservasi = $this->reservasi->getRiwayatReservasi($id_user);
        
        if ($reservasi) {
            $this->response([
                'success' => true,
                'message' => 'Berhasil Ambil data.',
                'data' => $reservasi
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Tidak Ada data',
                'data' => [],
            ],self::HTTP_BAD_REQUEST);
        }
    }

    public function detail_post()
    {
        $id = $this->post('id');

        $reservasi = $this->reservasi->getDetailPesananReservasi($id);
        
        if ($reservasi) {
            $this->response([
                'success' => true,
                'message' => 'Berhasil Ambil data.',
                'data' => $reservasi
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Tidak Ada data',
                'data' => [],
            ],self::HTTP_BAD_REQUEST);
        }
    }

    public function tambah_post()
    {
        $data =[
            'reservasi' => $this->post('reservasi'),
            'deskripsi' => $this->post('deskripsi'),
            'harga' => $this->post('harga')
        ];

        // cek upload image photo
        if (!empty($_FILES["foto"])) {
            if($_FILES["foto"]["error"] == 0){
                $data["foto"] = $this->_uploadFile($_FILES["foto"]);
            }
        } 

        if ($this->reservasi->tambahReservasi($data) > 0) {
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

    public function update_post()
    {
        $id = $this->post('id_reservasi');
        $data =[
            'reservasi' => $this->post('reservasi'),
            'deskripsi' => $this->post('deskripsi'),
            'harga' => $this->post('harga')
        ];
        // echo json_encode($this->post());die;
        // cek upload image photo
        if (!empty($_FILES["foto"])) {
            if($_FILES["foto"]["error"] == 0){
                $data["foto"] = $this->_uploadFile($_FILES["foto"]);
            }
        } 

        if ($this->reservasi->updateReservasi($data, $id) > 0) {
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

    public function hapus_get($id = null)
    {
        
        if ($id === null) {
            $this->response([
                'success' => false,
                'message' => 'provide an id'
            ],self::HTTP_BAD_REQUEST);
        }else {
            if ($this->reservasi->deleteReservasi($id) > 0) {
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

    public function bayar_post()
    {
        $id = $this->post('id');
        $total = $this->post('total');
        $data =[
            'bayar' => $this->post('bayar'),
            'status' => ($this->post('bayar') < $total) ? 'Belum Lunas' : 'Lunas',
            'petugas' => $this->post('petugas'),
        ];
        if ($this->post('bayar') > $total) {
            $this->response([
                'success' => false,
                'message' => 'Gagal dibayar nominal lebih besar dari total'
            ],self::HTTP_BAD_REQUEST);
        }else{
            if ($this->reservasi->bayarReservasi($data,$id) > 0) {
                $this->response([
                    'success' => true,
                    'message' => 'Berhasil dibayar'
                ],self::HTTP_CREATED);
            }else {
                $this->response([
                    'success' => false,
                    'message' => 'Gagal dibayar'
                ],self::HTTP_BAD_REQUEST);
            }
        }
    }

    public function update_pesanan_post()
    {
        $id = $this->post('id');
        $total = $this->post('total');
        $data =[
            'bayar' => $total,
            'status' => $this->post('status'),
        ];
        if ($this->reservasi->bayarReservasi($data,$id) > 0) {
            $this->response([
                'success' => true,
                'message' => 'Berhasil dibayar'
            ],self::HTTP_CREATED);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Gagal dibayar'
            ],self::HTTP_BAD_REQUEST);
        }
    }

    // upload image
    private function _uploadFile($file)
    {
        $config['upload_path'] = './images/reservasi/';
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