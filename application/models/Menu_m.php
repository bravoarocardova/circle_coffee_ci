<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Menu_m extends CI_Model 
{
    public function getMenu($id = null)
    {
        if($id === null){
            $this->db->order_by('menu', 'ASC');
            $result = $this->db->get("menu")->result();
        }else{
            $this->db->where("id_menu",$id);
            $result = $this->db->get("menu")->row();
        }

        return $result;
    }

    public function getMenuByIdKategori($id)
    {
        $this->db->where("id_kategori",$id);
        return $this->db->get("menu")->result();
    }

    public function getMenuTerlaris($limit)
    {
        $this->db->select('menu.*, SUM(qty) as terjual');
        $this->db->join('pesanan_detail', 'pesanan_detail.id_menu = menu.id_menu');
        $this->db->group_by('pesanan_detail.id_menu');
        $this->db->order_by('terjual', 'DESC');
        $this->db->limit($limit);
        return $this->db->get("menu")->result();
    }

    public function getMenuByName($search)
    {
        $this->db->like('menu', $search, 'both');
        return $this->db->get("menu")->result();
    }

    public function deleteMenu($id)
    {
        $this->_unlinkMenu($id);
        
        $this->db->delete('menu', ['id_menu' => $id]);
        return $this->db->affected_rows();
    }

    public function tambahMenu($data)
    {
        $this->db->insert('menu',$data);
        return $this->db->affected_rows();
    }

    public function updateMenu($data, $id)
    {
        // jika ada gambar baru run hapus file
        if (isset($data["photo"])) $this->_unlinkMenu($id);
        
        $this->db->update('menu',$data,['id_menu' => $id]);
        return $this->db->affected_rows();
    }

    // // hapus file
    private function _unlinkMenu($id)
    {
        $image = $this->db->get_where("menu",["id_menu" => $id])->row();
        
        if ($image != null) {
            if ($image->photo!= "") {
                $target_photo = './images/menu/' . $image->photo;
                unlink($target_photo);
            }
        }

    }

}