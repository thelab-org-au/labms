<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


require_once APPPATH.'models/signup/base.php';


class SignupModel extends Base
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    /*
    public function userExists($user)
    {
        $data = $this->GetTable('users', array('email' => $user));
        return sizeof($data) != 0;
    }
    
    public function CreateUser($data)
    {
        unset($data['password2']);
        $this->db->insert('users', $data);
        
        return ($this->db->affected_rows() == 1); 
    }
    */
    public function addUser()
    {
        return $this->addBaseData();
    }      
    
    public function addUserLocation($data)
    {
        return $this->insertData('userLocation', $data);        
    }
}