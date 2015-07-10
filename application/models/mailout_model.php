<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailout_model extends MY_Model
{   

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function storeMailout($data)
    {
        return $this->insertData('mailout',$data);
    }
    
    
    public function getLocations($id = null)
    {
        $this->db->where('active','1');
        
        if($id != null)
            $this->db->where('id',$id);
        
        if($id == null)
            return $this->db->get('locations')->result_array();
        else
        {
            $result = $this->db->get('locations')->result_array();
            return $result[0];
        }
    }
    
    public function getUserLocations()
    {
        $temp = $this->session->userdata('user');
        
        $this->db->where('user',$temp['id']);
        return $this->db->get('userlocation')->result_array();
    }
    
    public function getUserLocationsById($id)
    {
        $this->db->where('user',$id);
        return $this->db->get('userlocation')->result_array();
    }
    
    public function getUserLocationsByEmail($email)
    {
        $this->db->select('id');
        $this->db->where('email',$email);
        $query = $this->db->get('users')->result_array();
        return $query[0]['id'];
    }
    
    public function getAllUsers($superAdmin = null)
    {
        $this->db->where('active','1');
        
        if($superAdmin != '5')
            $this->db->where('userType !=','5');
        
        return $this->db->get('users')->result_array();
    }
    
    public function removeUser($id)
    {
        $this->db->where('user',$id);
        $this->db->delete('maillist'); 
        return $this->db->affected_rows();
    }
    
    public function getUsersByLocation($data,$superAdmin = null)
    {
        //$this->db->where('active','1');
        $this->db->distinct();
        $this->db->select('user');
        $this->db->where_in('location', $data);
        
        $query = $this->db->get('userlocation')->result_array();
        
        $this->db->flush_cache();
        
        $users = array();
        
        foreach($query as $row)
           $users[] = $row['user'];
           
        if(count($users) == 0)
            return null;

        $this->db->where('active','1');
        
        if($superAdmin == '5')
            $this->db->or_where('userType =','5');
        $this->db->where_in('id', $users);
        return $this->db->get('users')->result_array();
    }
    
    public function getMaillistUsers($labs)
    {
        $this->db->distinct();
        $this->db->select('user');
        $this->db->where_in('location', $labs);
        return $this->db->get('maillist')->result_array();
    }
    
    public function getUserEmail($id)
    {
        $this->db->select('email');
        $this->db->where('id',$id);
        $data = $this->db->get('users')->result_array();
        return $data[0]['email'];
    }
    
    public function getUserEmails($users = null, $locations = null,$userType = null)
    {
        $this->db->distinct();
        $this->db->select('id,email');
        $this->db->from('users');
        
        
        $where = true;
        if($users != null)
        {
            for($cnt = 0; $cnt < sizeof($users); $cnt++)
            {
                if($cnt == 0)
                {
                    $this->db->where('users.id',$users[$cnt]);
                    $where = false; 
                }
                else
                    $this->db->or_where('users.id',$users[$cnt]);       
            }
        }
          
        if($locations != null)
        {
            $this->db->join('userlocation','userlocation.user = users.id');
            
            for($cnt = 0; $cnt < sizeof($locations); $cnt++)
            {
                if($cnt == 0 && $where)
                    $this->db->where('userlocation.location',$locations[$cnt]);
                else
                    $this->db->or_where('userlocation.location',$locations[$cnt]);    
            }
        }
        

        if($userType != null)
        {
            for($cnt = 0; $cnt < sizeof($userType); $cnt++)
            {
                if($cnt == 0 && $where)
                    $this->db->where('users.userType',$userType[$cnt]);
                else
                    $this->db->or_where('users.userType',$userType[$cnt]);    
            }
        }
        
        return $this->db->get()->result_array();
    }
}