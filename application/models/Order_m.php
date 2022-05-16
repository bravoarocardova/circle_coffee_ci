<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Order_m extends CI_Model 
{

    public function getOrderbytanggal($tglAwal,$tglAkhir)
    {
        $this->db->select('transaksi.*, users.nama, users.email, users.no_telp');
        $this->db->join('users', 'transaksi.id_user = users.id_user');
        $this->db->order_by("id", "DESC");
        $this->db->where('status', 'Selesai');
        
        $this->db->where('DATE(tgl_transaksi) >=', $tglAwal);
        $this->db->where('DATE(tgl_transaksi) <=', $tglAkhir);
        return $this->db->get("transaksi")->result();
    }

    public function getSelesaiOrder($nama = null)
    {
        if ($nama != null) {
            $this->db->like('users.nama',$nama);
        }
        $this->db->select('transaksi.*, users.nama, users.email, users.no_telp');
        $this->db->join('users', 'transaksi.id_user = users.id_user');
        $this->db->order_by("id", "DESC");
        $this->db->where('status', 'Selesai');
        return $this->db->get("transaksi")->result();
    }

    public function getProsesOrder($nama = null)
    {
        if ($nama != null) {
            $this->db->like('users.nama',$nama);
        }
        $this->db->select('transaksi.*, users.nama, users.email, users.no_telp');
        $this->db->join('users', 'transaksi.id_user = users.id_user');
        $this->db->order_by("id", "ASC");
        $this->db->where('status', 'Diproses');
        return $this->db->get("transaksi")->result();
    }

    public function getPetugas($id)
    {
        $this->db->select('nama, email, no_telp, foto');
        $this->db->where('id_user', $id);
        return $this->db->get("users")->row();
    }

    public function getSiapOrder($nama = null)
    {
        if ($nama != null) {
            $this->db->like('users.nama',$nama);
        }
        $this->db->select('transaksi.*, users.nama, users.email, users.no_telp');
        $this->db->join('users', 'transaksi.id_user = users.id_user');
        $this->db->order_by("id", "ASC");
        $this->db->where('status', 'Pesanan Sudah Siap');
        return $this->db->get("transaksi")->result();
    }

    public function getPesananBayarOrder($nama = null)
    {
        if ($nama != null) {
            $this->db->like('users.nama',$nama);
        }
        $this->db->select('transaksi.*, users.nama, users.email, users.no_telp');
        $this->db->join('users', 'transaksi.id_user = users.id_user');
        $this->db->order_by("id", "DESC");
        $this->db->where('status', 'Belum Bayar');
        return $this->db->get("transaksi")->result();
    }

    public function getOrder($id_user)
    {
        $this->db->order_by("id", "DESC");
        $this->db->where('id_user', $id_user);
        return $this->db->get("transaksi")->result();
    }

    public function updateStatusOrder($data, $id_transaksi)
    {
        $this->db->update('transaksi',$data,['id' => $id_transaksi]);
        return $this->db->affected_rows();
    }

    public function addOrder($data)
    {
        $this->db->insert('transaksi',$data);
        return $this->db->insert_id();
    }

    public function addDetailOrder($data)
    {
        $this->db->insert('pesanan_detail',$data);
        return $this->db->affected_rows();
    }

    public function updateStok($qty, $id_menu)
    {   
        $this->db->set('stok','stok-'.$qty, FALSE);
        $this->db->where('id_menu', $id_menu);
        $this->db->update('menu');
        return $this->db->affected_rows();
    }

    public function getRiwayatOrder($id_user)
    {
        $this->db->order_by("id", "DESC");
        $this->db->where('id_user', $id_user);
        $this->db->where('(status="Selesai" OR status="Dibatalkan")');
        return $this->db->get("transaksi")->result();
    }

    public function getPesananOrder($id_user)
    {
        $this->db->order_by("id", "DESC");
        $this->db->where('id_user', $id_user);
        $this->db->where('NOT (status="Selesai" OR status="Dibatalkan")');
        return $this->db->get("transaksi")->result();
    }

    public function getDetailOrder($id_transaksi)
    {
        $this->db->select('menu.id_menu, menu.harga, qty, id_kategori, menu, photo, deskripsi, stok');
        $this->db->join('menu', 'pesanan_detail.id_menu = menu.id_menu');
        // $this->db->order_by("id", "DESC");
        $this->db->where('id_transaksi', $id_transaksi);
        return $this->db->get("pesanan_detail")->result();
    }

    public function getDetailTransaksiOrder($id_transaksi)
    {
        $this->db->select('id, total, status, tgl_transaksi, nama, no_telp');
        $this->db->join('users', 'transaksi.id_user = users.id_user');
        // $this->db->order_by("id", "DESC");
        $this->db->where('id', $id_transaksi);
        return $this->db->get("transaksi")->row();
    }

}