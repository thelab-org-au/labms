<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once APPPATH.'controllers/signup/basesignup.php';

class Login extends MY_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('login/loginmodel','model');
       // $this->data['labs'] = $this->model->GetAllLabs();
        $this->template = 'login/login';   
        $this->mainContent = 'login/login';
        $this->title = 'Login';
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
	       $this->data['page'] = $this->input->get('page',true);
	       $this->loginRequired = false; 
		  $this->render();        
    }
    
     public function login()
    {
        $this->load->library('encrypt');
        $userData = $this->model->getUser(trim($this->input->post('login')));
        if(sizeof($userData) == 1)
        {
            $pass = $this->encrypt->decode($userData[0]['password']);

            if($pass == trim($this->input->post('pass')))
            {
                $userData['loggedin'] = true;
                $this->setUserData($userData);
                $page = $this->input->get('page',true);
            
				
				                    //redirect(site_url().'/user/profile', 'refresh');
                    //return; 
                if($page == null)
                {
                    redirect(site_url().'/user/profile', 'refresh');
                    return; 
                }
                else
                {
                    switch($page)
                    {
                        case 'mail':
                            redirect(site_url().'/signup/mailinglist', 'refresh');
                            break;
                        case 'wait':
                            redirect(site_url().'/signup/waitlist', 'refresh');
                            break;
                        case 'mentor':
                            redirect(site_url().'/signup/mentor', 'refresh');
                            break;
                    }
                    return;
                }             
            } 
        }
        
        $this->data['error'] = 'Error incorrect details.';
        $this->session->set_userdata('user', null);
        $this->preRender();
    }
    
    public function logout()
    {
        $this->session->unset_userdata('ok');
       $this->session->set_userdata('user', null);
       redirect('/user/login', 'refresh');
    }
}