<?php
class Crud_m extends CI_Model {

    public function get($id=null,$table)
    {
      if($id==null){
        $this->db->get($table);
      }else {
        $this->db->where('id',$id);
        $this->db->get($table);
      }
    }
}