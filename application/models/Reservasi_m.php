<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Reservasi_m extends CI_Model 
{
    public function getReservasi($id = null)
    {
        if($id === null){
            $result = $this->db->get("reservasi")->result();
        }else{
            $this->db->where("id_reservasi",$id);
            $result = $this->db->get("reservasi")->row();
        }

        return $result;
    }

    public function getReservasibytanggal($tglAwal,$tglAkhir)
    {
        $this->db->select('transaksi_reservasi.*, reservasi.*, users.nama, users.email, users.no_telp');
        $this->db->join('users', 'transaksi_reservasi.id_user = users.id_user');
        $this->db->join('reservasi', 'transaksi_reservasi.id_reservasi = reservasi.id_reservasi');
        $this->db->order_by("id", "DESC");
        $this->db->where('status', 'Selesai');

        $this->db->where('DATE(tgl_transaksi) >=', $tglAwal);
        $this->db->where('DATE(tgl_transaksi) <=', $tglAkhir);

        $result = $this->db->get("transaksi_reservasi")->result();
        return $result;
    }

    public function addTransaksiReservasi($data)
    {
        if ($this->_cekTanggalReservasi($data['tgl_reservasi']) || $data['tgl_reservasi'] <= date('Y-m-d')) {
            return 0;
        }else{
            $this->db->insert('transaksi_reservasi',$data);
            return $this->db->affected_rows();
        }
    }

    private function _cekTanggalReservasi($tgl_reservasi)
    {
        $this->db->where('tgl_reservasi', $tgl_reservasi);
        return $this->db->get('transaksi_reservasi')->result();
    }

    public function getPesananReservasi($id_user)
    {
        $this->db->where('id_user', $id_user);
        $this->db->join('reservasi', 'transaksi_reservasi.id_reservasi = reservasi.id_reservasi');
        $this->db->where('NOT (status="Selesai" OR status="Dibatalkan")');
        return $this->db->get('transaksi_reservasi')->result();
    }

    public function getRiwayatReservasi($id_user)
    {
        $this->db->where('id_user', $id_user);
        $this->db->join('reservasi', 'transaksi_reservasi.id_reservasi = reservasi.id_reservasi');
        $this->db->where('(status="Selesai" OR status="Dibatalkan")');
        return $this->db->get('transaksi_reservasi')->result();
    }

    public function getDetailPesananReservasi($id)
    {
        $this->db->select('transaksi_reservasi.*, reservasi.*, users.nama, users.email, users.no_telp');
        $this->db->where('id', $id);
        $this->db->join('users', 'users.id_user = transaksi_reservasi.id_user');
        $this->db->join('reservasi', 'transaksi_reservasi.id_reservasi = reservasi.id_reservasi');
        return $this->db->get('transaksi_reservasi')->row();
    }

    public function getListPesananReservasi($id=null)
    {
        $this->db->select('transaksi_reservasi.*, reservasi.*, users.nama');
        if ($id != null) {
            $this->db->where('transaksi_reservasi.id_reservasi', $id);
        }
        $this->db->where('(status="Belum Lunas" OR status="Lunas")');
        $this->db->join('users', 'users.id_user = transaksi_reservasi.id_user');
        $this->db->join('reservasi', 'transaksi_reservasi.id_reservasi = reservasi.id_reservasi');
        return $this->db->get('transaksi_reservasi')->result();
    }

    public function tambahReservasi($data)
    {
        $this->db->insert('reservasi',$data);
        return $this->db->affected_rows();
    }

    public function updateReservasi($data, $id)
    {
        // jika ada gambar baru run hapus file
        if (isset($data["foto"])) $this->_unlinkMenu($id);
        
        $this->db->update('reservasi',$data,['id_reservasi' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteReservasi($id)
    {
        $this->_unlinkReservasi($id);
        
        $this->db->delete('reservasi', ['id_reservasi' => $id]);
        return $this->db->affected_rows();
    }

    public function getPesananReservasiBayarOrder($nama = null)
    {
        if ($nama != null) {
            $this->db->like('users.nama',$nama);
        }
        $this->db->select('transaksi_reservasi.*, reservasi.*, users.nama, users.email, users.no_telp');
        $this->db->join('users', 'transaksi_reservasi.id_user = users.id_user');
        $this->db->join('reservasi', 'transaksi_reservasi.id_reservasi = reservasi.id_reservasi');
        $this->db->order_by("id", "DESC");
        $this->db->where('status', 'Belum Bayar');
        return $this->db->get("transaksi_reservasi")->result();
    }

    public function getPetugas($id)
    {
        $this->db->select('nama, email, no_telp, foto');
        $this->db->where('id_user', $id);
        return $this->db->get("users")->row();
    }

    public function getBelumLunasReservasiOrder($nama = null)
    {
        if ($nama != null) {
            $this->db->like('users.nama',$nama);
        }
        $this->db->select('transaksi_reservasi.*, reservasi.*, users.nama, users.email, users.no_telp');
        $this->db->join('users', 'transaksi_reservasi.id_user = users.id_user');
        $this->db->join('reservasi', 'transaksi_reservasi.id_reservasi = reservasi.id_reservasi');
        $this->db->order_by("id", "ASC");
        $this->db->where('status', 'Belum Lunas');
        return $this->db->get("transaksi_reservasi")->result();
    }

    public function getLunasOrder($nama = null)
    {
        if ($nama != null) {
            $this->db->like('users.nama',$nama);
        }
        $this->db->select('transaksi_reservasi.*, reservasi.*, users.nama, users.email, users.no_telp');
        $this->db->join('users', 'transaksi_reservasi.id_user = users.id_user');
        $this->db->join('reservasi', 'transaksi_reservasi.id_reservasi = reservasi.id_reservasi');
        $this->db->order_by("id", "ASC");
        $this->db->where('status', 'Lunas');
        return $this->db->get("transaksi_reservasi")->result();
    }

    public function getSelesaiOrder($nama = null)
    {
        if ($nama != null) {
            $this->db->like('users.nama',$nama);
        }
        $this->db->select('transaksi_reservasi.*, reservasi.*, users.nama, users.email, users.no_telp');
        $this->db->join('users', 'transaksi_reservasi.id_user = users.id_user');
        $this->db->join('reservasi', 'transaksi_reservasi.id_reservasi = reservasi.id_reservasi');
        $this->db->order_by("id", "DESC");
        $this->db->where('status', 'Selesai');
        return $this->db->get("transaksi_reservasi")->result();
    }

    public function bayarReservasi($data, $id)
    {
        $this->db->update('transaksi_reservasi',$data,['id' => $id]);
        return $this->db->affected_rows();
    }

    // hapus file
    private function _unlinkReservasi($id)
    {
        $image = $this->db->get_where("reservasi",["id_reservasi" => $id])->row();
        
        if ($image != null) {
            if ($image->foto != "") {
                $target_file = './images/reservasi/' . $image->foto;
                unlink($target_file);
            }
        }

    }

}