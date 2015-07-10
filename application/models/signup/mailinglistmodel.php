<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'models/signup/base.php';
/**
 * Mailinglistmodel
 * 
 * @package   
 * @author Lab admin
 * @copyright craig poole
 * @version 2013
 * @access public
 */
class Mailinglistmodel extends Base
{   
    /**
     * Mailinglistmodel::__construct()
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
     * Mailinglistmodel::GetAllLabs()
     * 
     * @return
     */
    public function GetAllLabs()
    {
        return $this->getLabs();
    }
    
    //add user data to users table
    /**
     * Mailinglistmodel::addUser()
     * 
     * @return
     */
    public function addUser()
    {
        return $this->addBaseData();
    }
    
    /**
     * Mailinglistmodel::addChildData()
     * 
     * @param mixed $data
     * @return
     */
    public function addChildData($data)
    {
        return $this->insertData('student', $data);    
    }
    
    /**
     * Mailinglistmodel::addContact()
     * 
     * @param mixed $data
     * @return
     */
    public function addContact($data)
    {
        return $this->insertData('contact', $data);        
    }
    
    /**
     * Mailinglistmodel::addStudentContact()
     * 
     * @param mixed $data
     * @return
     */
    public function addStudentContact($data)
    {
        return $this->insertData('studentcontact', $data);           
    }
    
    /**
     * Mailinglistmodel::addUserLocation()
     * 
     * @param mixed $data
     * @return
     */
    public function addUserLocation($data)
    {
        return $this->insertData('userlocation', $data);        
    }
    
    /**
     * Mailinglistmodel::addToMaillist()
     * 
     * @param mixed $data
     * @return
     */
    public function addToMaillist($data)
    {       
        return $this->insertData('maillist', $data);        
    }
}