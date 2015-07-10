<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'models/signup/base.php';

class Waitlistmodel extends Base
{   

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function GetAllLabs()
    {
        return $this->getLabs();
    }
    
    public function createStudentData($data)
    {
        $this->db->insert('studentdata',$data);
        return $this->GetId();
    }
    
    public function addSchoolLevel($data)
    {
        $this->db->insert('studentschool',$data);
        return $this->GetId();        
    }
    
    public function addStudentCondition($data)
    {
        $this->db->insert('studentconditions',$data);
        return $this->GetId();        
    }
    
    public function addDataStudent($data,$table)
    {
        $this->db->insert($table,$data);
        return $this->GetId();        
    }
    
    public function updateStudent($studentId,$data)
    {
        $this->db->where('id',$studentId);
        $this->db->update('student', $data);
        return ($this->db->affected_rows() == 1);
    }
    
    public function addContactData($data)
    {
        $this->db->insert('contact',$data);
        return $this->GetId();         
    }
    
    public function addStudentContact($data)
    {
        $this->db->insert('studentcontact',$data);
        return $this->GetId();        
    }
    

    public function addUser()
    {
        return $this->addBaseData();
    }
    
    public function addChildData($data)
    {
        return $this->insertData('student', $data);    
    }
    public function addUserLocation($data)
    {
        return $this->insertData('userlocation', $data);        
    }
    
    public function addToWaitList($data)
    {
        return $this->insertData('waitlist', $data); 
    }
}