<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Laporan_m extends CI_Model 
{
    public function getLaporan($id = null , $jenis = null)
    {
        if ($id!==null && $jenis !== null) {
            $this->db->where(["id_penelitian" => $id, "jenis" => $jenis]);
            $result = $this->db->get("laporan")->result();
        }else{
            $result = $this->db->get("laporan")->result();
        }

        return $result;
    }

    public function getLaporanUser($id)
    {
        $this->db->select("l.*,u.nama,u.nidn,u.level,u.fakultas,u.prodi");
        $this->db->where("l.id_users",$id);
        $this->db->join("users u", "l.id_users=u.id_users");
        $result = $this->db->get("laporan l")->result();

        return $result;
    }

    public function addLaporan($data)
    {
        $this->db->insert('laporan',$data);
        return $this->db->affected_rows();
    }

    public function deleteLaporan($id)
    {
        $this->_unlinkLaporan($id);
        
        $this->db->delete('laporan', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function updateLaporan($data, $id)
    {
        // jika ada gambar baru run hapus file
        if (isset($data["file"])) $this->_unlinkLaporan($id);
        
        $this->db->update('laporan',$data,['id' => $id]);
        return $this->db->affected_rows();
    }

    // hapus file
    private function _unlinkLaporan($id)
    {
        $image = $this->db->get_where("laporan",["id" => $id])->row();
        
        if ($image != null) {
            if ($image->file != "") {
                $target_file = './fileKegiatan/' . $image->file;
                unlink($target_file);
            }
        }

    }

}