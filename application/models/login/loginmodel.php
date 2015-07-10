<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LoginModel extends MY_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }
    
    public function getUser($name)
    {
        $where['email'] = $name;
        $where['active'] = '1';
        $this->db->limit(1);
        return $this->GetTable('users',$where);
    }
}