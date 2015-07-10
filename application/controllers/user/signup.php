<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/signup/basesignup.php';

class Signup extends Basesignup
 {
    private $userData = array();
    function __construct()
    {
        $this->loginRequired = false;
        parent::__construct('login/signupModel');
        $this->load->model('login/signupModel','model');
        $this->baseSeg = 3;           
    } 
	public function index()
	{   
        if ($this->uri->segment($this->baseSeg) === FALSE)
        {
            $this->preRender();
        }
        else
        {
            $func = $this->uri->segment($this->baseSeg);
            $this->$func();
        }  
	}
    
    private function preRender()
    {
	       $this->data['userData'] = $this->userData;
            $this->load->view('login/signup',$this->data);        
    }
    
    public function process()
    {
        $returnData = $this->createBaseUser(false,false); 
        
        if($returnData !== false)
        {
            $this->sendConfirmation('/signup/waitlist/confirm','emailtemplate/generalSignup',$returnData);

            $this->session->set_userdata('ok', 'Sign up completed.<br/>An email has been sent to ' .$returnData['email'] . '.<br/>Please click the link in the email to confirm your details');
            
            $this->data['userData'] = $this->userData;
            $this->load->view('login/signupConfirmation',$this->data);
        }
        else
            $this->preRender();       
    }
    
    private function ValidateData($data)
    {
        $valid = !($data['email'] == '' && $data['password'] == '' &&
                    $data['firstName'] == '' && $data['lastName'] == '' &&
                    $data['password2'] == '');
                    
        if(!$valid)
        {
           $this->data['error'] = 'Username/Email<br/>Password<br/>Password confirm<br/>First name<br/>Last name<br/> required!'; 
        }
        else
        {
            if(!($valid = ($this->userData['password'] == $this->userData['password2']))) 
                $this->data['error'] = 'Passwords do not match';            
        }  
        
        return $valid;
    }
}