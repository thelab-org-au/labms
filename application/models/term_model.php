<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Term_model extends MY_Model
{   

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function getSessionDays()
    {
        return $this->get_enum_values('session_time','day');
    }
    
    public function addSession($data)
    {
        return $this->insertData('session_time',$data);
    }
    
    public function getAllSessions()
    {
        return $this->GetTable('session_time');
    }
    
    public function getSessionById($id)
    {
        $this->db->where('id',$id);
        return $this->GetTable('session_time');
    }
    
    public function getSession($day,$start,$end)
    {
        $this->db->where('day',$day);
        $this->db->where('startTime',$start);
        $this->db->where('endTime',$end);
        return $this->db->get('session_time')->result_array();
    }
    
    public function addTerm($data)
    {
        return $this->insertData('term',$data);
    }
    
    public function getAllTerms()
    {
        return $this->GetTable('term');
    }
    
    public function getTerm($start,$end)
    {
        $this->db->where('startDate',$start);
        $this->db->where('endDate',$end);
        return $this->db->get('term')->result_array();        
    }
    
    public function getTermBySession($session)
    {
        $this->db->select('*');
        $this->db->from('term');
        $this->db->join('term_session','term_session.term = term.id');
        $this->db->where('term_session.id',$session);
        return $this->db->get()->result_array();
    }
    
    public function addTermSesison($data)
    {
        return $this->insertData('term_session',$data);
    }
    
    public function getTermSession($term,$session,$location)
    {
        $this->db->where('term',$term);
        $this->db->where('session',$session);
        $this->db->where('location',$location);
        return $this->db->get('term_session')->result_array(); 
    }

    
    public function getSessions($location)
    {
        $this->db->select('*');
        $this->db->select('term_session.id as termSessionId');
        $this->db->from('session_time');
        $this->db->join('term_session','term_session.session = session_time.id','left');
        $this->db->where('term_session.location',$location);
        return $this->db->get()->result_array();
    }
    
    public function getTerms($location)
    {
        $this->db->select('*');
        $this->db->select('term_session.id as termSessionId');
        $this->db->from('term');
        $this->db->join('term_session','term_session.term = term.id','left');
        $this->db->where('term_session.location',$location);
        return $this->db->get()->result_array();     
    }
    
    public function getTermSessions($locations = null)
    {
        $this->db->select('term.startDate, term.endDate,term.numWeeks');
        $this->db->select('locations.name, locations.id as locationId');
        $this->db->select('session_time.day,session_time.startTime,session_time.endTime, session_time.id as sessionTimeId');
        $this->db->select('term_session.id as termSessionId');
        $this->db->from('term');
        $this->db->join('term_session','term_session.term = term.id');
        $this->db->join('locations','term_session.location = locations.id');
        $this->db->join('session_time','term_session.session = session_time.id');

        $this->db->order_by("term_session.id", "desc");
        $this->db->order_by("locations.name", "desc");
        
        if($locations != null)
            $this->db->where_in('locations.id', $locations);
            
        $this->db->limit(20);
            
        return $this->db->get()->result_array(); 
    }
}