<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_model extends MY_Model
{   

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function getUserData($id)
    {
        $this->db->where('id',$id);
        return $this->db->get('users')->result_array();
    }
    
    public function updateUser($id,$data)
    {
        $this->db->where('id',$id);
        $this->db->update('users',$data);
        return $this->db->affected_rows() == 1;
    }
    
    public function getStudentData($id)
    {
        $this->db->select('student.*');
        $this->db->select('studentdata.daysAtSchool,studentdata.schoolOther,studentdata.conditionOther,
        studentdata.lapTop,studentdata.sessionType,studentdata.otherInfo,studentdata.sessionOther');
        $this->db->join('studentdata','studentdata.id = student.studentData','left');
        $this->db->from('student');
        $this->db->where('student.user',$id);
        return $this->db->get()->result_array();
    }
    
    public function getWaitlistData($id)
    {
        $this->db->select('student.*');
        $this->db->select('locations.name as location');
        $this->db->select('waitlist.id as waitlistId');
        $this->db->join('waitlist','waitlist.student = student.id');
        $this->db->join('locations','locations.id = waitlist.location');
        $this->db->where('student.user',$id);
        return $this->db->get('student')->result_array();
    }
    
    public function getMaillistData($id)
    {
        $this->db->select('locations.name');
        $this->db->select('maillist.id');
        $this->db->join('locations','maillist.location = locations.id');
        $this->db->where('maillist.user',$id);
        return $this->db->get('maillist')->result_array();
    }
    
    public function getMentorData($id)
    {
        $this->db->where('user',$id);
        return $this->db->get('mentor')->result_array();
        
    }
    
    public function getMentorExp($id)
    {
        $this->db->where('mentor',$id);
        return $this->db->get('mentorexperience')->result_array();
    }
    
    public function getStudentSchool($studentData)
    {
        $this->db->select('schoolLevel');
        $this->db->where('studentData',$studentData);
        return $this->db->get('studentschool')->result_array();
    }
    
    public function getStudentCondition($studentData)
    {
        $this->db->select('condition');
        $this->db->where('studentData',$studentData);
        return $this->db->get('studentconditions')->result_array();
    }
    
    public function getStudentExperience($studentData)
    {
        $this->db->select('tech,level');
        $this->db->where('studentData',$studentData);
        return $this->db->get('studentexperience')->result_array();
    }   
    
    public function getStudentInterest($studentData)
    {
        $this->db->select('tech,level');
        $this->db->where('studentData',$studentData);
        return $this->db->get('studentintrest')->result_array();
    } 
    
    public function updateTable($id,$data,$table)
    {
        $this->db->where('id', $id);
        $this->db->update($table, $data);    
        return $this->db->affected_rows() == 1;     
    } 
    
  /*  public function deleteStudentSchool($id)
    {
        $this->db->where('studentData', $id);
        $this->db->delete('studentschool'); 
    }*/
    
    public function deleteTable($table,$id)
    {
        $this->db->where('studentData', $id);
        $this->db->delete($table); 
    }
    
    public function deleteMentorTable($table,$id)
    {
        $this->db->where('mentor', $id);
        $this->db->delete($table); 
    }
    
    public function addStudentSchool($data)
    {
        return $this->insertData('studentschool',$data); 
    }
    
    public function addStudentCondition($data)
    {
        return $this->insertData('studentconditions',$data); 
    }
    
    public function addStudentInterest($data)
    {
        return $this->insertData('studentintrest',$data); 
    }
    
    public function addStudentExperience($data)
    {
        return $this->insertData('studentexperience',$data); 
    }
    
    public function addMentorExperience($data)
    {
        return $this->insertData('mentorexperience',$data); 
    }
    
    public function removeMail($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('maillist');         
    }
}