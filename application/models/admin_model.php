<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends MY_Model
{   

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function getLocations()
    {
        $this->db->where('active','1');
            
        return $this->GetTable('locations');
    }
    
    public function getAllSessions()
    {
        return $this->GetTable('session');
    }
    
    public function getLocationData($id)
    {
        $this->db->where('id',$id);
         return $this->GetTable('locations');
    }
    
    public function getLocationsData($id)
    {
        $this->db->where_in('id',$id);
         return $this->GetTable('locations');
    }

    public function getLocationSessions($id)
    {
        $this->db->where_in('location',$id);
        return $this->GetTable('term_session');
    }

    public function getTerms($id)
    {
        $this->db->where_in('id',$id);
        return $this->GetTable('term');
    }

    public function getSessions($id)
    {
        $this->db->where_in('id',$id);
        return $this->GetTable('session_time');
    }
    
    public function updateLocation($id,$data)
    {
        $this->db->where('id',$id);
        $this->db->update('locations',$data);
        return ($this->db->affected_rows() == 1);
    }
    
    public function addLocation($data)
    {
        $this->db->insert('locations',$data);
        return $this->GetId();
    }
    
    public function getUserLocations($user)
    {
        $this->db->where('user',$user);
        return $this->db->get('userlocation')->result_array();
    }
    
    public function getStudents($active = '1',$start = '0',$where = null,$like = null,$limit = false)
    {
        $this->db->select('student.*');
        $this->db->select('studentsession.session');
        //$this->db->select('session.desc');
        $this->db->select('locations.name as locname');
        $this->db->from('student');
        $this->db->join('studentsession', 'student.id = studentsession.student');
        $this->db->join('term_session', 'term_session.id = studentsession.session');
        $this->db->join('locations', ' term_session.location = locations.id' );
        $this->db->where('student.active',$active);
        
        if($where != null && !is_array($where))
        {
            $this->db->where('term_session.location',$where);
        }
        
        if($like != null)
            $this->db->like('student.name', $like);
            
        if($limit)
            $this->db->limit(PAG_LIMIT, $start);
        $this->db->group_by('student.id');
        $this->db->order_by('student.name');
        //$data = %this
        return $this->db->get()->result_array();        
    }
    
    
    public function getUsers($id = null,$locations = null)
    {
        $this->db->select('users.*,usertypes.type, usertypes.id as typeId');
        $this->db->from('users');
        $this->db->join('usertypes', 'usertypes.id = users.userType','left');
        $this->db->join('userlocation', 'userlocation.user = users.id','left');
        $this->db->where('users.active','1');
        
        if($id != null)
           $this->db->where('users.id',$id); 
           
        if($locations != null)
            $this->db->where_in('userlocation.location', $locations);           
        
        return $this->db->get()->result_array();       
    }
    
    public function getUserType()
    {
        return $this->getTable('usertypes');
    }
    
    public function addUser($data)
    {
        return $this->insertData('users',$data);
    }
    
    public function addMentorUser($data)
    {
        return $this->insertData('mentor',$data);
    }

    public function addSessionCost($data)
    {
        return $this->insertData('session_cost',$data);
    }

    public function updateCost($id,$data)
    {
        $this->db->where('id',$id);
        $this->db->update('session_cost',$data);
    }

    public function clearCost()
    {
        $this->db->where('id != ', '1');
        $this->db->delete('session_cost');
    }

    public function getSessionCost($id)
    {
        $this->db->where('termSessionId',$id);
        return $this->db->get('session_cost')->result_array();
    }
    public function getTermSessionId($where)
    {
        $this->db->where($where);
        $data = $this->db->get('term_session')->result_array();
        if(count($data) == 1)
            return $data[0]['id'];
        else
            return false;
    }
    
    public function deactivateStudent($id)
    {
        $this->db->where('id',$id);
        $this->db->update('student',array('active' => '0'));
        
        $this->db->flush_cache();
        
        $this->db->where('student',$id);
        $this->db->update('studentsession',array('active' => '0'));
    }
    
    public function removeUser($id)
    {
        $this->db->where('id',$id);
        $data['active'] = '0';
        $this->db->update('users',$data);
    }
    
    public function updateUser($id,$data)
    {
        $this->db->where('id',$id);
        $this->db->update('users',$data);       
    }
    
    public function getMentorsApplications($location = null,$mentor = null,$like = null,$start = null)
    {
        $this->db->distinct();
        $this->db->select('applications.mentor,applications.location');
        $this->db->select('mentor.*');
        $this->db->select('users.email,users.firstName,users.lastName,users.email,users.phone,users.address,users.suburb,users.postcode');
        $this->db->from('mentor');
        $this->db->join('users','users.id = mentor.user');
        $this->db->join('applications','applications.mentor = mentor.id');
        $this->db->where('applications.active','1');
        
        if($location != null)
            $this->db->where('applications.location',$location);
            
        if($mentor != null)
            $this->db->where('mentor.id',$mentor);
            
        if($like != null)
        {
            $this->db->like('users.firstName', $like);
            $this->db->or_like('users.lastName',$like);
        }
        
        if($start != null)
            $this->db->limit(PAG_LIMIT, $start);
        
        return $this->db->get()->result_array(); 
    }
    
    public function getMentors($location = null,$mentor = null,$like = null,$start = null,$active = '1')
    {
        //$this->db->select('applications.mentor,applications.location');
        $this->db->distinct();
        $this->db->select('mentor.*');
        $this->db->select('users.email,users.firstName,users.lastName,users.email,users.phone,users.address,users.suburb,users.postcode');
        $this->db->from('mentor');
        $this->db->join('users','users.id = mentor.user');
        $this->db->join('mentorlocation','mentorlocation.mentor = mentor.id');
        $this->db->where('mentorlocation.active',$active);
        
        if($location != null)
            $this->db->where('mentorlocation.location',$location);
            
        if($mentor != null)
            $this->db->where('mentor.id',$mentor);
            
        if($like != null)
        {
            $this->db->like('users.firstName', $like);
            $this->db->or_like('users.lastName',$like);
        }
        
        if($start != null)
            $this->db->limit(PAG_LIMIT, $start);
        
        return $this->db->get()->result_array(); 
    }
    
    public function getMentorLocations($mentor,$active = '1')
    {
        $this->db->where('mentor',$mentor);
        $this->db->where('active',$active);
        return $this->db->get('mentorlocation')->result_array();
    }
    
    public function getMentorExp($mentor)
    {
        $this->db->select('mentorexperience.*,techs.desc');
        $this->db->from('mentorexperience');
        $this->db->join('techs','mentorexperience.tech = techs.id');
        $this->db->where('mentorexperience.mentor',$mentor);
        return $this->db->get()->result_array(); 
    }
    
    public function getFileName($mentor)
    {
        $this->db->where('id',$mentor);
        return $this->db->get('mentor')->result_array(); 
    }
    
    public function createMentor($data,$active = '1')
    {
        $info = $this->checkMentor($data);
        $this->db->flush_cache();
        
        if(sizeof($info) == 0)
        {
           return $this->insertData('mentorlocation',$data); 
        }
        else
        {
            $this->db->where('mentor',$data['mentor']);
            $this->db->where('location',$data['location']);
            $this->db->update('mentorlocation', array('active' => $active));
            return ($this->db->affected_rows() == 1);            
        }      
    }
    
    private function checkMentor($data)
    {
        $this->db->where('mentor',$data['mentor']);
        $this->db->where('location',$data['location']);
        return $this->db->get('mentorlocation')->result_array();
    }
    
    public function removeApplication($mentor)
    {
        $this->db->where('mentor',$mentor);
        $this->db->update('applications',array('active' => '0'));
    }   
    
    public function addSession($data)
    {
        return $this->insertData('session',$data);
    }
    
    public function checkSessionInfo($location,$desc)
    {
        $this->db->where('location',$location);
        $this->db->where('desc',$desc);
        $data = $this->db->get('session')->result_array();
        return sizeof($data) == 0;
    }
    
    public function addTerm($data)
    {
        return $this->insertData('session_term',$data);
    }
    
    public function checkTerm($data)
    {
        $this->db->where('session',$data['session']);
        $this->db->where('startDate',$data['startDate']);
        $this->db->where('endDate',$data['endDate']); 
        $data = $this->db->get('session_term')->result_array();
        return sizeof($data) == 0;               
    }
    
    public function getSessionList($location = null)
    {
        $this->db->select('session.*');
        $this->db->select('session_term.startDate,session_term.endDate');
        $this->db->select('locations.name');
        $this->db->from('session');
        $this->db->join('session_term','session.id = session_term.session','left');
        $this->db->join('locations','locations.id = session.location' );
        
        $this->db->order_by('session_term.id','desc');
        
        if($location != null)
            $this->db->where('locations.id ',$location);
        
        return $this->db->get()->result_array();
    }
    
    public function updateSession($id,$data)
    {
        $this->db->where('id',$id);
        $this->db->update('session', $data); 
        return ($this->db->affected_rows() == 1); 
    }
    
    public function removeUserLocation($user)
    {
        $this->db->where('user', $user);
        $this->db->delete('userlocation');
    }
    
    public function addUserLocation($user,$location)
    {
        $data = array(
           'user' => $user ,
           'location' => $location 
        );
        
        $this->db->insert('userlocation', $data);         
    }
    
    public function getTermSessionData($location)
    {
        $this->db->select('session_time.day,session_time.startTime,session_time.endTime, session_time.id as sessionId');
        $this->db->select('term.startDate,term.endDate,term.id as termId');
        $this->db->select('session_cost.full,session_cost.con');
        $this->db->select('term_session.id as termSessionId');
        $this->db->from('term');
        $this->db->from('session_time');
        $this->db->join('term_session','term_session.session = session_time.id and term_session.term = term.id');
        $this->db->join('session_cost', 'session_cost.termSessionId = term_session.id','left');
        $this->db->where('term_session.location',$location);
        $this->db->order_by('term_session.id','desc');
        $this->db->limit(20);
        
        return $this->db->get()->result_array();
    }
    
    public function getStudentDetails($id)
    {
        $this->db->where('id',$id);
        $data = $this->db->get('student')->result_array();
        return $data[0];
    }
    
    public function getStudentData($id)
    {
         $this->db->where('id',$id);
        $data = $this->db->get('studentdata')->result_array();
        return $data[0];       
    }
    
    public function getStudentSchoolLevel($studentData)
    {
        $this->db->where('studentData',$studentData);
        $data = $this->db->get('studentschool')->result_array();
        if(count($data) > 0)return $data[0]; else return null;
    }
    
    public function getStudentIntrest($studentData)
    {
        $this->db->where('studentData',$studentData);
        return $this->db->get('studentintrest')->result_array();
    }
    
    public function getStudentConditions($studentData)
    {
        $this->db->where('studentData',$studentData);
        return $this->db->get('studentconditions')->result_array();
    }
    
    public function getStudentExperience($studentData)
    {
        $this->db->where('studentData',$studentData);
        return $this->db->get('studentexperience')->result_array();
    }
    
    public function createUser($data)
    {
        $this->db->insert('users', $data); 
        return $this->GetId();
    }
    
    public function studentData($data)
    {
        $this->db->insert('studentdata', $data); 
        return $this->GetId();
    }
    
    public function updateStudentData($id,$data)
    {
        $this->db->where('id', $id);
        $this->db->update('studentdata', $data);        
    }
    
    public function updateStudent($id,$data)
    {
        $this->db->where('id', $id);
        $this->db->update('student', $data);        
    }
    
    public function deleteTableData($table,$id)
    {
        $this->db->where('studentData',$id);
        $this->db->delete($table);
    }
    public function addTableData($table,$data)
    {
        $this->db->insert($table,$data);
    }
    
    public function getStudentLocations($id)
    {
        $this->db->select('term_session.location');
        $this->db->join('studentsession' , 'studentsession.session = term_session.session');
        $this->db->where('studentsession.student',$id);
        return $this->db->get('term_session')->result_array();
    }
    
    public function checkUserLocation($user,$location)
    {
        $this->db->where('user',$user);
        $this->db->where('location',$location);
        $data = $this->db->get('userlocation')->result_array();
        return (count($data) == 0);
    }

    
}