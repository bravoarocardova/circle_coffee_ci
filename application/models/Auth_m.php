<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Auth_m extends CI_Model 
{
    public function login($data)
    {
        $this->db->select('id_user, nama, email, no_telp, foto, role_id');
        $this->db->where($data);
        $result = $this->db->get("users")->row();

        return $result;
    }


    public function register($data)
    {
        $this->db->insert('users',$data);
        return $this->db->affected_rows();
    }

    public function checkEmailExits($email)
    {
        $this->db->where('email',$email);
        return $this->db->get("users")->result();
    }

}