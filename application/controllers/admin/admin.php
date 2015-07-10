<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once APPPATH.'controllers/signup/basesignup.php';

class Admin extends MY_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model','model');
        $this->mainContent = 'admin/admin';
        $this->title = 'Admin';
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
        $this->loginRequired = true;
        $this->CheckLogin();
    	$this->render();         
    }
}