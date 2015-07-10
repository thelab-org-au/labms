<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attendancemodel extends MY_Model
{   

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function getAllLabs()
    {
        return $this->GetTable('locations');
    }
    
    public function getAllSessions()
    {
        return $this->GetTable('term_session');
    }
    
    public function getSessionInfo($session)
    {
        $where['id'] = $session;
        return $this->GetTable('term_session',$where);
    }
    
    public function getSessionData($session)
    {
        $where['session'] = $session;
        return $this->GetTable('student',$where);
    }
    
    public function getLocationName($id)
    {
        $this->db->select('name');
        $this->db->where('id',$id);
        $data = $this->db->get('locations')->result_array();
        return $data[0];
    }
    
    public function getTerms($location)
    {
        $this->db->select('term');
        $this->db->where('location',$location);
        return $this->db->get('term_session')->result_array();
    }
    
    public function getTermData()
    {
        return $this->db->get('term')->result_array();
    }
    
    public function getSessionInformation()
    {
        return $this->db->get('session_time')->result_array();
    }
    
    public function getSessionStudentData($session)
    {
        $this->db->where('session',$session);
        return $this->db->get('studentsession')->result_array();
    }
    
    public function getAttendanceData($studentSession)
    {
        $this->db->where('studentSession',$studentSession);
        return $this->db->get('attendance')->result_array();
    }
    
    public function getSession($location,$term)
    {
        $this->db->select('session');
        $this->db->where('term',$term);
        $this->db->where('location',$location);
        $data = $this->db->get('term_session')->result_array();
        $returnData = array();
        
        foreach($data as $d)
            $returnData[] = $d['session'];
        return $returnData;
    }
    
    public function getTermSessionId($location,$term,$session)
    {
        $this->db->select('id');
        $this->db->where('term',$term);
        $this->db->where('location',$location);
        $this->db->where('session',$session);
        $data = $this->db->get('term_session')->result_array();
        return $data;
    }
    
    public function getSessionStudents($session,$active = 1,$start = null)
    {
        $where['session'] = $session;
        $where['active'] = $active;
        
       /* if($start != null)
        {
            $s;
            if($start == 1)
                $s = ($start - 1);
            else
            {
               $s = ($start - 1) *  PAG_LIMIT;
            }
            $this->db->limit(PAG_LIMIT, $s);
        }*/
            
        
        return $this->GetTable('studentsession',$where);        
    }
    
    public function getStudentInfo($student)
    {
        $where['id'] = $student;
        
        $data = $this->GetTable('student',$where);
        return $data[0];        
    } 
    
    public function getAttendance($id,$date = null)
    {
        $where['studentSession'] = $id;
        
        if($date != null)
            $where['date'] = $date;
            
            
        $this->db->order_by("id", "desc");
        $this->db->limit(7);     
        return $this->GetTable('attendance',$where);
    }
    
    public function getStudentSession($student,$session)
    {
        $where['student'] = $student;
        $where['session'] = $session;
        return $this->GetTable('studentsession',$where);
    }
    
    public function addAttendance($data)
    {
        $this->insertData('attendance',$data);
    }
    
    public function updateAttendance($id,$data)
    {
        $this->db->where('id', $id);
        $this->db->update('attendance', $data);
        return $this->GetId(); 
    }
    
    public function getMentorLocations($mentor)
    {
        $this->db->where('mentor', $this->getMentorId($mentor));
        return $this->db->get('mentorlocation')->result_array();
    }
    
    private function getMentorId($user)
    {
        $this->db->where('user',$user);
        $data = $this->db->get('mentor')->result_array();
        return $data[0]['id'];
    }
    
    public function getTermSessionData($location)
    {
        $this->db->select('session_time.day,session_time.startTime,session_time.endTime, session_time.id as sessionId');
        $this->db->select('term.startDate,term.endDate,term.id as termId');
        $this->db->from('term');
        $this->db->from('session_time');
        $this->db->join('term_session','term_session.session = session_time.id and term_session.term = term.id');
        $this->db->where('term_session.location',$location);
        $this->db->order_by('term_session.id','desc');
        $this->db->limit(40);
        
        return $this->db->get()->result_array();
    }

}