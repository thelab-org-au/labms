<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Assign_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function getWaitlistStudents($location,$previous)
    {
        $this->db->select('student.*');
        $this->db->join('waitlist', 'waitlist.student = student.id');
        $this->db->where('waitlist.location',$location);
        $this->db->where_not_in('student.id', $previous);
        $this->db->order_by("name", "asc");
        return $this->db->get('student')->result_array();

    }

    public function getTermSessionIds($session,$location)
    {
        $this->db->where('session',$session);
        $this->db->where('location',$location);
        $this->db->select('id');
        return $this->db->get('term_session')->result_array();
    }
    
    public function getPerviousStudents($ids)
    {
        $this->db->distinct('student');
        $this->db->where_in('session', $ids);
        return $this->db->get('studentsession')->result_array(); 
    }
    
    public function getStudentsIn($ids)
    {
        $this->db->where_in('id', $ids);
        $this->db->order_by("name", "asc");
        return $this->db->get('student')->result_array();
    }
    
    public function getOther($ids)
    {
        $this->db->where_not_in('student.id', $ids);
        $this->db->order_by("name", "asc");
        return $this->db->get('student')->result_array(); 
    }
    
    public function searchStudents($name)
    {
        $this->db->like('name', $name);
        $this->db->order_by("name", "asc");
        return $this->db->get('student')->result_array(); 
    }
    
    public function checkStudent($session,$id)
    {
        $this->db->where('session',$session);
        $this->db->where('student',$id);
        return $this->db->get('studentsession')->result_array();
    }
    
    public function addStudent($data)
    {
        $this->db->insert('studentsession', $data);         
    }

}