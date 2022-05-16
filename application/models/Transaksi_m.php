<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Transaksi_m extends CI_Model 
{
    public function getPendapatanPenjualan($tgl)
    {
        if ($tgl == 'hari') {
            $this->db->where('DATE(tgl_transaksi)', date('Y-m-d'));
        }else{
            $this->db->where('MONTH(tgl_transaksi)', date('m'));
            $this->db->where('YEAR(tgl_transaksi)', date('Y'));
        }
        $this->db->where('status', 'Selesai');
        $this->db->select('SUM(total) as total');
        return $this->db->get('transaksi')->row();
    }

    public function getTotalPenjualan($tgl)
    {
        if ($tgl == 'hari') {
            $this->db->where('DATE(tgl_transaksi)', date('Y-m-d'));
        }else{
            $this->db->where('MONTH(tgl_transaksi)', date('m'));
            $this->db->where('YEAR(tgl_transaksi)', date('Y'));
        }
        $this->db->where('status', 'Selesai');
        $this->db->join('pesanan_detail', 'transaksi.id = pesanan_detail.id_transaksi');
        $this->db->select('SUM(qty) as total_penjualan');
        return $this->db->get('transaksi')->row();
    }

    public function getTransaksiPenjualan($status)
    {
        $this->db->where('status', $status);
        $this->db->select('COUNT(total) as total');
        return $this->db->get('transaksi')->row();
    }

    public function getPendapatanBooking($tgl)
    {
        if ($tgl == 'hari') {
            $this->db->where('DATE(tgl_transaksi)', date('Y-m-d'));
        }else{
            $this->db->where('MONTH(tgl_transaksi)', date('m'));
            $this->db->where('YEAR(tgl_transaksi)', date('Y'));
        }
        $this->db->where('status', 'Selesai');
        $this->db->select('SUM(bayar) as total');
        return $this->db->get('transaksi_reservasi')->row();
    }

    public function getTransaksiBooking($status)
    {
        $this->db->where('status', $status);
        $this->db->select('COUNT(total) as total');
        return $this->db->get('transaksi_reservasi')->row();
    }

    public function getTerjualHari()
    {
        $this->db->select('menu.*, SUM(qty) as terjual');
        $this->db->join('pesanan_detail', 'menu.id_menu = pesanan_detail.id_menu');
        $this->db->join('transaksi', 'pesanan_detail.id_transaksi = transaksi.id');
        $this->db->where('transaksi.status', 'selesai');
        $this->db->where('date(tgl_transaksi)', date('Y-m-d'));
        $this->db->group_by('menu.id_menu');
        $this->db->order_by('menu.id_menu', 'ASC');
        $trxSelesai = $this->db->get('menu')->result();
    
        return $trxSelesai;
    }

    public function getTerjualBulan()
    {
        $this->db->select('menu.*, SUM(qty) as terjual');
        $this->db->join('pesanan_detail', 'menu.id_menu = pesanan_detail.id_menu');
        $this->db->join('transaksi', 'pesanan_detail.id_transaksi = transaksi.id');
        $this->db->where('transaksi.status', 'selesai');
        $this->db->where('MONTH(tgl_transaksi)', date('m'));
        $this->db->where('YEAR(tgl_transaksi)', date('Y'));
        $this->db->group_by('menu.id_menu');
        $this->db->order_by('menu.id_menu', 'ASC');
        $trxSelesai = $this->db->get('menu')->result();
    
        return $trxSelesai;
    }

}