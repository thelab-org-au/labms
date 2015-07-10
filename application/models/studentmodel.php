<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Studentmodel extends MY_Model
{   

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    
    public function findStudentData($search)
    {
        $this->db->like('name', $search);
        $query = $this->db->get('student');
        return $query->result_array();
    }
    
    public function checkStudent($data)
    {
        return $this->GetTable('studentsession',$data);
    }
    
    public function addToSession($data)
    {
        return $this->insertData('studentsession',$data);
    }
    
    public function updateSession($session,$student)
    {
        $this->db->where('student',$student);
        $this->db->where('session',$session);
        $data['active'] = '1';
        $this->db->update('studentsession', $data);
        return ($this->db->affected_rows() == 1); 
    }
    
    public function findSessionByLab($lab)
    {
        $this->db->where('location',$lab);
        return $this->db->get('term_session')->result_array();      
    }
    
    public function getSessionInfo($session)
    {
        $where['session'] = $session;
        return $this->GetTable('studentsession',$where);
    }

    public function getStudentById($id)
    {
        
        $this->db->where('id',$id);
        $data = $this->db->get('student');
        return $data->result_array();
    }
    
    public function removeFromSession($session,$student)
    {
        $this->db->where('student',$student);
        $this->db->where('session',$session);
        $data['active'] = '0';
        $this->db->update('studentsession',$data);
        return ($this->db->affected_rows() == 1);
    }
    
    public function getStudentDetails($id)
    {
        $this->db->select('*');
        $this->db->from('student');
        $this->db->join('studentdata', 'studentdata.id = student.studentData','left');
        $this->db->where('student.id',$id);
        return $this->db->get()->result_array();
    }
    
    public function getStudentConditions($studentData)
    {
        $this->db->select('*');
        $this->db->from('conditions');
        $this->db->join('studentconditions', 'conditions.id = studentconditions.condition','right');
        $this->db->where('studentconditions.studentData',$studentData);
        return $this->db->get()->result_array();
    }
    public function getStudentSchool($studentData)
    {
        $this->db->select('*');
        $this->db->from('schoollevel');
        $this->db->join('studentschool', 'schoollevel.id = studentschool.schoolLevel','right');
        $this->db->where('studentschool.studentData',$studentData);
        return $this->db->get()->result_array();
    }
    
    public function getStudentIntrests($studentData,$type)
    {
        $this->db->select('*');
        $this->db->from('techs');
        $this->db->join($type, 'techs.id = '.$type.'.tech','right');
        $this->db->where($type.'.studentData',$studentData);
        return $this->db->get()->result_array();
    }
    
    public function primaryContact($id)
    {
        $where['id'] = $id;
        return $this->GetTable('users',$where);
    } 
    
    public function getStudentContacts($id)
    {
         $this->db->select('*');
         $this->db->select('contact.name,contact.phone');
        $this->db->from('contact');
        $this->db->join('studentcontact', 'contact.id = studentcontact.contact','right');
        $this->db->where('studentcontact.student',$id);
        return $this->db->get()->result_array();       
    }
    
    
    public function setStudentActive($id)
    {
        $this->db->where('id',$id);
        $this->db->update('student',array('active' => '1'));
    }
}