<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Kadaluarsa_m extends CI_Model 
{
    public function getTransaksiKadaluarsa()
    {
        $this->db->where('status', 'Belum Bayar');
        $this->db->where('tgl_transaksi < ', date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s')) - 60 * 30));
        $transaksi = $this->db->get('transaksi')->result();

        $details = $this->getDetailTransaksiKadaluarsa($transaksi);

        $data = [];
        foreach($details as $detail){
            foreach($detail as $d){
                $data[] = $this->updateStok($d->qty, $d->id_menu);
            }
        }
        
        foreach($transaksi as $trx){
            $this->updateStatusTransaksi($trx->id);
        }
        return true;
        // return $this->getDetailTransaksiKadaluarsa($this->db->get('transaksi')->result());

    }

    public function getDetailTransaksiKadaluarsa($transaksi)
    {
        $detail=[];
        foreach($transaksi as $trx){
            $this->db->where('id_transaksi', $trx->id);
            $detail[] = $this->db->get('pesanan_detail')->result();
        }
        return $detail;
    }

    public function updateStok($qty, $id_menu)
    {
        // return $qty;
        $this->db->set('stok','stok+'.$qty, FALSE);
        $this->db->where('id_menu', $id_menu);
        return $this->db->update('menu');
    }

    public function updateStatusTransaksi($id)
    {
        $this->db->update('transaksi', ['status' => 'Dibatalkan'], ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getTransaksiReservasiKadaluarsa()
    {
        $this->db->where('status', 'Belum Bayar');
        $this->db->where('tgl_transaksi < ', date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s')) - 60 * 30));
        $transaksi = $this->db->get('transaksi_reservasi')->result();

        foreach($transaksi as $trx){
            $this->db->update('transaksi_reservasi', ['status' => 'Dibatalkan'], ['id' => $trx->id]);
        }
        return $this->db->affected_rows();
    }

    public function getTransaksiSelesaiReservasiKadaluarsa()
    {
        $this->db->where('status', 'Lunas');
        $this->db->where('tgl_reservasi < ', date('Y-m-d'));
        $transaksi = $this->db->get('transaksi_reservasi')->result();

        foreach($transaksi as $trx){
            $this->db->update('transaksi_reservasi', ['status' => 'Selesai'], ['id' => $trx->id]);
        }
        return $this->db->affected_rows();
    }

}