<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/admin/admin.php';

class Asessions extends Admin 
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model','model');
        $this->mainContent = 'admin/sessions/sessions';
        $this->title = 'Admin sessions';
        $this->baseSeg = 3;
        $this->init(); 
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
    
    private function init()
    {
       // $this->data['users'] = $this->model->getUsers();
       // $this->data['userTypes'] = $this->model->getUserType();
       
       $this->data['locations'] = $this->model->getLocations();
       
        $temp = array();
        foreach($this->getSessionData() as $lab)
        {
            //if(in_array($lab['id'],$loc))
                $temp[] = $lab;
        }
        $this->data['labInfo'] = $temp;
        
        $tempSess = array();
        foreach($temp as $location)
        {
            $tempSess[$location['name']][] = $this->model->getSessionList($location['id']);
            $tempSess[$location['name']]['id'] = $location['id'];
        }
        
        $this->data['sessionList'] = $tempSess;
        
       
    }
    
    private function preRender()
    {
        $this->init();
        $this->loginRequired = true;
        $this->CheckLogin();
    	$this->render();         
    }
    
    private function getSessionData()
    {
       $labs =  $this->model->getLocations();
       $sessions = $this->model->getAllSessions();
       for($cnt = 0; $cnt < sizeof($labs); $cnt++)
       {
            foreach($sessions as $session)
            {
                if($session['location'] == $labs[$cnt]['id'])
                    $labs[$cnt]['sessions'][] = $session;
            }                
       }
       
       return $labs;
    } 
    
    public function addTerm()
    {
        $location = (int)$this->input->post('lab');
        $data['session'] = (int)$this->input->post('lab'.$location);
        $data['startDate'] = $this->input->post('startDate',true); 
        $data['endDate'] = $this->input->post('endDate',true);
        
        if($this->model->checkTerm($data))
        {
            if($this->model->addTerm($data))
                $this->session->set_userdata('ok', 'Term has been added' );
            else
               $this->data['error'] = 'Session has not been added' ; 
        }
        else
            $this->data['error'] = 'Term already exists' ; 
            
        $this->preRender();
    }
    public function addSession()
    {
        $this->data['error'] = null;
        $data['location'] = (int)$this->input->post('labLoc');
        $data['desc'] = $this->input->post('sessionDesc',true);
        
        if($this->model->checkSessionInfo($data['location'],$data['desc']))
        {
            if($this->model->addSession($data))
                $this->session->set_userdata('ok', 'Session has been added' );
            else
               $this->data['error'] = 'Session has not been added' ;             
        }
        else
            $this->data['error'] = 'Session already exists' ; 

        $this->preRender();
    }
    
    public function editSession()
    {
        
        $sessionId = '';
        foreach($this->input->post() as $key => $value)
        {
            if (strpos($key,'lab') !== false && (int)$value != -1) 
            {
                $sessionId = $value;
                break;
            }
        }
        $data['desc'] = $this->input->post('editDesc',true);
        if($this->model->updateSession($sessionId,$data))
        {
            $this->session->set_userdata('ok', 'Session has been updated' );
        }
        else
        {
            $this->data['error'] = 'Session not updated'; 
        }
        $this->preRender();
    }
}