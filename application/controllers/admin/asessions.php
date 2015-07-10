<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/admin/admin.php';

class Asessions extends Admin 
{
    public $termModel;
    function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model','model');
        $this->mainContent = 'admin/sessions/sessions';
        $this->title = 'Admin sessions';
        $this->baseSeg = 3;
        
        $this->load->model('term_model','termModel');
        
        //$this->init(); 
    }
    
	public function index()
	{
	   
        $this->preRender(); 
        
	}
    
    private function init()
    {
        $user = $this->session->userdata('user');
        $temp = $this->model->getUserLocations($user['id']);
        
        $userlocations = array();
        foreach($temp as $t)
            $userlocations[] = $t['location'];

        
        if((int)$user['type'] < 5)
            $this->data['termSessions'] = $this->termModel->getTermSessions($userlocations);
        else
            $this->data['termSessions'] = $this->termModel->getTermSessions();
            
       $this->data['days'] = $this->termModel->getSessionDays();
       
       $temp = $this->model->getLocations();
       
       foreach($temp as $location)
       {
            $data['id'] = $location['id'];
            $data['desc'] = $location['name'];
            
            $this->data['locations'][] = $data;       
       }
       
       $temp = $this->data['sessionData'] = $this->termModel->getAllSessions();
       
       foreach($temp as $session)
       {
            $data['id'] = $session['id'];
            $data['desc'] = $session['day'] . ' ' .$session['startTime'] . ' - ' .$session['endTime'];
            
            $this->data['sessions'][] = $data;
       }
       
       $temp = $this->data['termData'] = $this->termModel->getAllTerms(); 
       
        foreach($temp as $term)
       {
            $data['id'] = $term['id'];
            $data['desc'] = $term['startDate'] . ' - ' .$term['endDate'];
            
            $this->data['terms'][] = $data;
       }
       
       /*
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
        */
       
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
        //var_dump($_POST);
        
        if(!$this->validateTerm())
        {
            
            $this->data['error'] = validation_errors();
        }
        else
        {
            $data['startDate'] = $this->input->post('startDate',true);
            $data['endDate'] = $this->input->post('endDate',true);
            $data['numWeeks'] = $this->datediffInWeeks($data['startDate'], $data['endDate']) + 1;

            if(count($this->termModel->getTerm($data['startDate'],$data['endDate'])) != 0)
            {
                $this->data['error'] = 'Term dates already created';
                $this->preRender();
                return;                
            }
            
            if($this->termModel->addTerm($data))
            {
                $this->session->set_userdata('ok', 'Term has been added' );
            }
            else
                $this->data['error'] = 'An error has occured term was not added' ; 
        }
        $this->preRender();
    }
    
    protected function validateTerm()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '<br/>');
        $this->form_validation->set_rules('startDate', 'Start date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('endDate', 'End date', 'trim|required|xss_clean|callback_date_check');
        return $this->form_validation->run();        
    }
    
	public function date_check($str)
	{
        if($this->input->post('startDate',true) == $this->input->post('endDate',true))
        {
            $this->form_validation->set_message('date_check', 'Start and end date must not match'); 
            return false;
        }
        return true;
	}
    

    
    public function addSession()
    {
        $this->data['error'] = null;
        
        if(!$this->validateSession())
        {
            $this->data['error'] = validation_errors();
        }
        else if($this->input->post('day',true) == '-1')
        {
            $this->data['error'] = 'Please select day';
        }
        else
        {
            $data['day'] = $this->input->post('day',true);
            $data['startTime'] = $this->input->post('start',true);
            $data['endTime'] = $this->input->post('end',true);
            
            if(count($this->termModel->getSession($data['day'],$data['startTime'],$data['endTime'])) != 0)
            {
                $this->data['error'] = 'Session already created';
                $this->preRender();
                return;
            }
            
            if($this->termModel->addSession($data))
            {
                $this->session->set_userdata('ok', 'Session has been added' );
            }
            else
                $this->data['error'] = 'An error has occured session was not added' ; 
        }

        $this->preRender();
    }
    
    protected function validateSession()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '<br/>');
        $this->form_validation->set_rules('day', 'Day', 'trim|required|xss_clean');
        $this->form_validation->set_rules('start', 'Start time', 'trim|required|xss_clean|callback_time_check');
        $this->form_validation->set_rules('end', 'End time', 'trim|required|xss_clean');
        return $this->form_validation->run();        
    }
    
	public function time_check($str)
	{
        if($this->input->post('start',true) == $this->input->post('end',true))
        {
            $this->form_validation->set_message('time_check', 'Start and end time must not match'); 
            return false;
        }
        return true;
	}
    
    public function create()
    {
        //var_dump($_POST);
        
        $data['term'] = $this->input->post('term',true);
        $data['session'] = $this->input->post('session',true);
        $data['location'] = $this->input->post('location',true);
        
        if(!$this->valCreate('location'))
            return;
            
         if(!$this->valCreate('term'))
            return;
            
        if(!$this->valCreate('session'))
            return;
            
        if(count($this->termModel->getTermSession($data['term'],$data['session'],$data['location'])) != 0)
        {
            $this->data['error'] = 'Location session already exists' ;           
        }
        else
        {
            if($this->termModel->addTermSesison($data))
            {
                $this->session->set_userdata('ok', 'Location session added' );
            }
            else
                $this->data['error'] = 'An error has occured location session was not added' ; 
        }
        
        $this->preRender();
    }

    private function valCreate($field)
    {
        if($this->input->post($field) == '-1')
        {
            $this->data['error'] = "Please select $field" ; 
            $this->preRender();
            return false;
        }        
        return true;
    }
    
    /*
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
    */
}