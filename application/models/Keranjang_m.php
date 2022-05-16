<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Keranjang_m extends CI_Model 
{
    public function getKeranjangByidUser($id = null)
    {
        $this->db->select('keranjang.id_menu, qty, id_kategori, menu, photo, deskripsi, stok, harga');
        $this->db->where("id_user",$id);
        $this->db->join("menu", "keranjang.id_menu = menu.id_menu");
        return $this->db->get("keranjang")->result();
    }

    public function cekKeranjang($id_menu, $id_user)
    {
        $this->db->where([
            "id_user" => $id_user,
            "id_menu" => $id_menu
        ]);
        return $this->db->get("keranjang")->num_rows();
    }

    public function addKeranjang($data)
    {
        $this->db->insert('keranjang',$data);
        return $this->db->affected_rows();
    }

    public function getJumlahKeranjang($id_user)
    {
        $this->db->select('SUM(qty) as jumlah');
        $this->db->where('id_user',$id_user);
        return $this->db->get('keranjang')->row();
    }

    public function deleteKeranjang($id_user,$id_menu)
    {   
        $this->db->delete('keranjang', [
            'id_user' => $id_user,
            'id_menu' => $id_menu
        ]);
        return $this->db->affected_rows();
    }

    public function deleteKeranjangByIdUser($id_user)
    {   
        $this->db->delete('keranjang', ['id_user' => $id_user]);
        return $this->db->affected_rows();
    }

    public function updateQty($data)
    {
        $this->db->where([
            'id_menu' => $data['id_menu'],
            'id_user' => $data['id_user']
        ]);
        $this->db->update('keranjang',['qty' => $data['qty']]);
        return $this->db->affected_rows();
    }

}