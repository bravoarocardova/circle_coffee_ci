<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Kategori_m extends CI_Model 
{
    public function getKategori($id = null)
    {
        if($id === null){
            $result = $this->db->get("kategori")->result();
        }else{
            $this->db->where('id_kategori', $id);
            $result = $this->db->get("kategori")->row();
        }

        return $result;
    }

}