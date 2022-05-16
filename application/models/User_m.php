<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class User_m extends CI_Model 
{
    public function getUser($id = null)
    {
        $this->db->order_by("role_id", "ASC");
        if ($id === null) {
            $this->db->order_by("nama", "ASC");
            $result = $this->db->get("users")->result();
        }else{
            $this->db->order_by("nama", "ASC");
            $this->db->where("id_user", $id);
            $result = $this->db->get("users")->row();
        }

        return $result;
    }

    public function getUserNama($nama)
    {
        
        $this->db->order_by("nama", "ASC");
        $this->db->like("nama", $nama);
        $result = $this->db->get("users")->result();
        return $result;
    }

    public function getUserRole()
    {
        $result = $this->db->get("role")->result();
        return $result;
    }

    public function addUser($data)
    {
        $this->db->insert('users',$data);
        return $this->db->affected_rows();
    }

    public function deleteUser($id)
    {
        $this->_unlinkUser($id);

        $this->db->delete('users', ['id_users' => $id]);
        return $this->db->affected_rows();
    }

    public function updateUser($data, $id)
    {
        if (isset($data["foto"])) $this->_unlinkUser($id);

        $this->db->update('users',$data,['id_user' => $id]);
        return $this->db->affected_rows();
    }

    // has file
    private function _unlinkUser($id)
    {
        $image = $this->db->get_where("users",["id_users" => $id])->row();
        
        if ($image != null) {
            if ($image->foto != "") {
                $target_file = './imageUpload/' . $image->foto;
                unlink($target_file);
            }
        }

    }

}