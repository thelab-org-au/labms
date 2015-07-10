<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ResetModel extends MY_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    
    }
    
    public function addPassword($pass,$email)
    {
        $data['password'] = $this->encrypt->encode($pass);
        $this->db->where('email', $email);
        $this->db->update('users',$data);
        return ($this->db->affected_rows() == 1); 
    }
    
    public function getUserId($where)
    {
        $data = $this->GetTable('users',$where);
        return $data[0]['id'];
    }
    
    public function updatePassword($id,$pass)
    {
        $this->db->where('id',$id);
        $this->db->update('users',$pass);
        return ($this->db->affected_rows() == 1); 
    }
    
    public function deleteConfirmation($conf)
    {   
        $this->db->flush_cache();
        $this->db->where('id', $conf);
        $this->db->delete('emailconfirmation'); 
    }
}