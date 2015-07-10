<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'models/signup/base.php';

class Mentormodel extends Base
{ 
    public function GetAllLabs()
    {
        return $this->getLabs();
    }
    
    public function addMentorExp($data)
    {
        $this->db->insert('mentorexperience',$data);
        return $this->GetId();        
    }
    
    public function addMentor($data)
    {
        $this->db->insert('mentor',$data);
        return $this->GetId();        
    }
    
    public function addUser()
    {
        return $this->addBaseData();
    }      
    
    public function addUserLocation($data)
    {
        return $this->insertData('userlocation', $data);        
    }
    
    public function addApplication($data)
    {
        return $this->insertData('applications', $data);        
    }
    
    public function updateMentor($id,$data)
    {
        $this->db->where('id',$id);
        $this->db->update('mentor',$data);
    }
}