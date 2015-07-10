<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Base
 * 
 * @package   
 * @author Lab admin
 * @copyright craig poole
 * @version 2013
 * @access public
 */
abstract class Base extends MY_Model
{   
    /**
     * Base::__construct()
     * 
     * @return
     */
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    //return a array of all labs
    /**
     * Base::getLabs()
     * 
     * @return
     */
    protected function getLabs()
    {
        return $this->GetTable('locations');
    }
    
    //insert user data to database
    /**
     * Base::addBaseData()
     * 
     * @return
     */
    protected function addBaseData()
    {
        $this->load->library('encrypt');
        $data['userType'] = '1';
        $data['email'] = $this->input->post('email');
        $data['firstName'] = $this->input->post('fname');
        $data['lastName'] = $this->input->post('lname');
        $data['phone'] = $this->input->post('phone');
        $data['address'] = $this->input->post('address');
        $data['suburb'] = $this->input->post('suburb');
        $data['postcode'] = $this->input->post('postcode');
        $data['password'] = $this->encrypt->encode($this->input->post('pass'));
        $this->db->insert('users', $data);
        return $this->GetId();
    }
    
    /**
     * Base::getUser()
     * 
     * @param mixed $email
     * @return
     */
    public function getUser($email)
    {
        $where['email'] = $email;
        return $this->GetTable('users',$where);
    }
    
    /**
     * Base::getUserId()
     * 
     * @param mixed $id
     * @return
     */
    public function getUserId($id)
    {
        $where['id'] = $id;
        return $this->GetTable('users',$where);
    }


    

    
    /**
     * Base::confirmUser()
     * 
     * @param mixed $id
     * @param mixed $conf
     * @return
     */
    public function confirmUser($id,$conf)
    {
        $this->db->where('id', $id);
        $data['active'] = '1';
        $this->db->update('users', $data);
        
        $this->db->flush_cache();
        $this->db->where('id', $conf);
        $this->db->delete('emailconfirmation'); 
    }
    
    public function checkUserLocation($user,$location)
    {
        $this->db->where('user',$user);
        $this->db->where('location',$location);
        $data = $this->db->get('userlocation')->result_array();
        return (sizeof($data) > 0);
    }

}