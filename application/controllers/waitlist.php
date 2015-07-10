<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once APPPATH.'controllers/signup/basesignup.php';

class Waitlist extends MY_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('profile_model','model');
        $this->mainContent = 'profile/profile';
        $this->title = 'Waitlist';
        
        $this->baseSeg = 3; 
    }
    
	public function index()
	{

        if ($this->uri->segment($this->baseSeg) === FALSE)
        {
            $this->data['page'] = 'profile/userInfo';
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
	    $this->loginRequired = true;
        $this->CheckLogin();
        $this->init(); 
	//	$this->render();         
    }
    
    private function init()
    {
        
    }
}