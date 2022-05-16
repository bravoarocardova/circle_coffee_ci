<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Order extends RestController 
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Order_m", "order");

    }

    public function tanggal_post()
    {
        $tglAwal = $this->post('tgl_awal');
        $tglAkhir = $this->post('tgl_akhir');
        $order = $this->order->getOrderbytanggal($tglAwal,$tglAkhir);

        if($order){
            $data = [];
            foreach($order as $item){
                $item->petugas = $this->order->getPetugas($item->petugas);
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

    public function selesai_get()
    {
        $nama = $this->uri->segment(4);

        if ($nama != null) {
            $order = $this->order->getSelesaiOrder($nama);
        }else{
            $order = $this->order->getSelesaiOrder();
        }
        $data = [];
        foreach($order as $item){
            $item->petugas = $this->order->getPetugas($item->petugas);
            $data[] = $item;
        }
        if($order){
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

    public function proses_get()
    {
        $nama = $this->uri->segment(4);

        if ($nama != null) {
            $order = $this->order->getProsesOrder($nama);
        }else{
            $order = $this->order->getProsesOrder();
        }
        $data = [];
        foreach($order as $item){
            $item->petugas = $this->order->getPetugas($item->petugas);
            $data[] = $item;
        }

        if($order){
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

    public function siap_get()
    {
        $nama = $this->uri->segment(4);

        if ($nama != null) {
            $order = $this->order->getSiapOrder($nama);
        }else{
            $order = $this->order->getSiapOrder();
        }
        $data = [];
        foreach($order as $item){
            $item->petugas = $this->order->getPetugas($item->petugas);
            $data[] = $item;
        }
        if($order){
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

    public function pesanan_get()
    {
        $nama = $this->uri->segment(4);

        if ($nama != null) {
            $order = $this->order->getPesananBayarOrder($nama);
        }else{
            $order = $this->order->getPesananBayarOrder();
        }
        
        $data = [];
        foreach($order as $row){
            $row->kadaluwarsa = date('Y-m-d H:i:s',strtotime($row->tgl_transaksi) + 60 * 30);
            $data[] = $row;
        }
        if($order){
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

    public function index_post()
    {
        date_default_timezone_set('Asia/Jakarta');

        $id_user = $this->post('id_user');

        $order = $this->order->getOrder($id_user);
        if ($order) {
            $this->response([
                'success' => true,
                'message' => 'Berhasil Ambil data.',
                'data' => $order
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Gagal Ambil data',
                'data' => [],
            ],self::HTTP_BAD_REQUEST);
        }
    }

    public function update_status_post()
    {
        $id_transaksi = $this->post('id_transaksi');
        $data['status'] = $this->post('status');
        $petugas = $this->post('petugas');
        if ($petugas != null) {
            $data['petugas'] = $petugas;
        }

        if ($this->order->updateStatusOrder($data, $id_transaksi) > 0) {
            $this->response([
                'success' => true,
                'message' => 'Update Status Pesanan Berhasil'
            ],self::HTTP_CREATED);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Update Status Pesanan Gagal'
            ],self::HTTP_BAD_REQUEST);
        }
    }

    public function add_post()
    {
        if ($this->uri->segment(4) === 'detail') {
            $data = [
                'id_transaksi' => $this->post('id_transaksi'),
                'id_menu' => $this->post('id_menu'),
                'harga' => $this->post('harga'),
                'qty'=> $this->post('qty')
            ];

            $order = $this->order->addDetailOrder($data);

            if ($order) {
                $this->order->updateStok($data['qty'], $data['id_menu']);

                $this->response([
                    'success' => true,
                    'message' => 'Pesanan Berhasil',
                ],self::HTTP_CREATED);
            }else {
                $this->response([
                    'success' => false,
                    'message' => 'Pesanan Gagal',
                ],self::HTTP_BAD_REQUEST);
            }
        }else {
            $data = [
            'id_user' => $this->post('id_user'),
            'total' =>  $this->post('total'),
            'status' => 'Belum Bayar',
            'tgl_transaksi'=> date('Y-m-d H:i:s')
            ];

            $order = $this->order->addOrder($data);

            if ($order) {
                $this->response([
                    'success' => true,
                    'message' => 'Pesanan Berhasil',
                    'last_id' => $order
                ],self::HTTP_CREATED);
            }else {
                $this->response([
                    'success' => false,
                    'message' => 'Pesanan Gagal',
                    'last_id' => null
                ],self::HTTP_BAD_REQUEST);
            }
        }
        
    }

    public function riwayat_post()
    {
        $id_user = $this->post('id_user');

        $order = $this->order->getRiwayatOrder($id_user);
        if ($order) {
            $this->response([
                'success' => true,
                'message' => 'Berhasil Ambil data.',
                'data' => $order
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
                'data' => [],
            ],self::HTTP_BAD_REQUEST);
        }
    }

    public function pesanan_post()
    {
        $id_user = $this->post('id_user');

        $order = $this->order->getPesananOrder($id_user);
        if ($order) {
            $data = [];
            foreach($order as $row){
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
                'message' => 'Data tidak ditemukan!',
                'data' => [],
            ],self::HTTP_BAD_REQUEST);
        }
    }

    public function detail_post()
    {
        $id_transaksi = $this->post('id_transaksi');

        $order = $this->order->getDetailTransaksiOrder($id_transaksi);
        if ($order) {
            $this->response([
                'success' => true,
                'message' => 'Berhasil Ambil data.',
                'transaksi' => $order,
                'data' => $this->order->getDetailOrder($id_transaksi)
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
                'transaksi' => [],
                'data' => [],
            ],self::HTTP_BAD_REQUEST);
        }
    }
    
}