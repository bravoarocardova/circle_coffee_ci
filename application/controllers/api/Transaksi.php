<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Transaksi extends RestController 
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Transaksi_m", "transaksi");

    }

    public function pendapatan_penjualan_get()
    {
        $transaksi = [
            'hari' => $this->transaksi->getPendapatanPenjualan('hari')->total,
            'bulan' => $this->transaksi->getPendapatanPenjualan('bulan')->total,
        ];

        if($transaksi['hari'] || $transaksi['bulan']){
            $this->response([
                'success' => true,
                'message' => 'Berhasil ambil data',
                'data' => $transaksi
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Gagal ambil data',
                'data' => null
            ],self::HTTP_NOT_FOUND);
        }
    }

    public function total_penjualan_get()
    {
        $transaksi = [
            'hari' => $this->transaksi->getTotalPenjualan('hari')->total_penjualan,
            'bulan' => $this->transaksi->getTotalPenjualan('bulan')->total_penjualan,
        ];
        
        if($transaksi['hari'] || $transaksi['bulan']){
            $this->response([
                'success' => true,
                'message' => 'Berhasil ambil data',
                'data' => $transaksi
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Gagal ambil data',
                'data' => null
            ],self::HTTP_NOT_FOUND);
        }
    }

    public function transaksi_penjualan_get()
    {
        $transaksi = [
            'belum_bayar' => $this->transaksi->getTransaksiPenjualan('Belum Bayar')->total,
            'diproses' => $this->transaksi->getTransaksiPenjualan('Diproses')->total,
            'siap' => $this->transaksi->getTransaksiPenjualan('Pesanan Sudah Siap')->total,
        ];
        
        if($transaksi['belum_bayar'] || $transaksi['diproses'] || $transaksi['siap']){
            $this->response([
                'success' => true,
                'message' => 'Berhasil ambil data',
                'data' => $transaksi
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Gagal ambil data',
                'data' => null
            ],self::HTTP_NOT_FOUND);
        }
    }

    public function pendapatan_booking_get()
    {
        $transaksi = [
            'hari' => $this->transaksi->getPendapatanBooking('hari')->total,
            'bulan' => $this->transaksi->getPendapatanBooking('bulan')->total,
        ];

        if($transaksi['hari'] || $transaksi['bulan']){
            $this->response([
                'success' => true,
                'message' => 'Berhasil ambil data',
                'data' => $transaksi
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Gagal ambil data',
                'data' => null
            ],self::HTTP_NOT_FOUND);
        }
    }

    public function transaksi_booking_get()
    {
        $transaksi = [
            'belum_bayar' => $this->transaksi->getTransaksiBooking('Belum Bayar')->total,
            'belum_lunas' => $this->transaksi->getTransaksiBooking('Belum Lunas')->total,
            'lunas' => $this->transaksi->getTransaksiBooking('Lunas')->total,
        ];
        
        if($transaksi['belum_bayar'] || $transaksi['belum_lunas'] || $transaksi['lunas']){
            $this->response([
                'success' => true,
                'message' => 'Berhasil ambil data',
                'data' => $transaksi
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Gagal ambil data',
                'data' => null
            ],self::HTTP_NOT_FOUND);
        }
    }

    public function terjual_hari_get()
    {
        $transaksi = $this->transaksi->getTerjualHari();
        
        if($transaksi){
            $this->response([
                'success' => true,
                'message' => 'Berhasil ambil data',
                'data' => $transaksi
            ],self::HTTP_OK);
        }else {
            $this->response([
                'success' => false,
                'message' => 'Gagal ambil data',
                'data' => []
            ],self::HTTP_NOT_FOUND);
        }
    }

    public function terjual_bulan_get()
    {
        $transaksi = $this->transaksi->getTerjualHari();
        
        if($transaksi){
            $this->response([
                'success' => true,
                'message' => 'Berhasil ambil data',
                'data' => $transaksi
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