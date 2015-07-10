<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Add_student_model extends MY_Model

{   



    function __construct()

    {

        // Call the Model constructor

        parent::__construct();

    }
    
    public function addStudent($data)
    {
        $this->db->insert('student',$data);
        return $this->GetId(); 
    }
    
    public function addToSession($data)
    {
        $this->db->insert('studentsession',$data);
        return $this->GetId();        
    }
    
    public function validate($name,$contact)
    {
        $this->db->where('name',$name);
        $this->db->where('contact_email',$contact);
        $data = $this->db->get('student')->result_array();
        return (count($data) == 0);
    }

}