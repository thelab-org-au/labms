<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once APPPATH.'controllers/signup/basesignup.php';

class Cost extends MY_Controller 
{
    public $termModel;
    function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model','model');
        $this->mainContent = 'admin/sessions/cost';
        $this->title = 'Admin';
        $this->baseSeg = 3; 
        
        $this->load->model('term_model','termModel');
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
        $this->init();
        $this->loginRequired = true;
        $this->CheckLogin();
    	$this->render();
    }
    
    private function init()
    {
        $locationIds = $terms = $sessions = array();

        if($this->getUserLevel() >= 4)
        {
            $this->data['locations'] = $this->model->getLocations();

            foreach($this->data['locations'] as $location)
                $locationIds[] = $location['id'];
        }
        else
        {
            $id = $this->getUserId();
            foreach($this->model->getUserLocations($id) as $d)
                $locationIds[] = $d['location'];

            $this->data['locations'] = $this->model->getLocationsData($locationIds);
        }



        foreach($this->model->getLocationSessions($locationIds) as $data)
        {
            $term[] = $data['term'];
            $sessions[] = $data['session'];
        }

        foreach($this->model->getTerms($term) as $term)
        {
            if($this->datediff($term['startDate'],date('d/m/Y')) || true)
            {
                $data['id'] = $term['id'];
                $data['desc'] = $term['startDate'] . ' - ' .$term['endDate'];

                $this->data['terms'][] = $data;
            }
        }

        if(isset($this->data['terms']))
        {
            foreach($this->model->getSessions($sessions) as $session)
            {
                $data['id'] = $session['id'];
                $data['desc'] = $session['day'] . ' ' .$session['startTime'] . ' - ' .$session['endTime'];

                $this->data['sessions'][] = $data;
            }
        }


       
    }
    
    public function getLocationData()
    {
        $data['location'] = (int)$this->input->get('location');
        $data['termSession'] = $this->model->getTermSessionData($data['location']);   
        
        echo $this->load->view('admin/sessions/costTable', $data, true);  
    }
    
    public function setCost()
    {
        $id = $this->input->post('termSession',true);
        
        $data = array
        (
            'termSessionId' => $id,
            'full' => $this->input->post('full',true),
            'con' => $this->input->post('con',true)
        );  
        
        $costId = $this->model->getSessionCost($id);
        if(count($costId) == 0)
        {
            $this->model->addSessionCost($data);
        }
        else
        {
            $costId = $costId[0]['id'];
            $this->model->updateCost($costId,$data);
        }     
        
        $this->session->set_userdata('ok', 'Session cost added');
        $this->preRender();
        //redirect('admin/cost');
    }
    
    public function addCost()
    {
        if($this->validateCost())
        {
            $where = array
            (
                'term' => $this->input->post('term',true),
                'session' => $this->input->post('session',true),
                'location' => $this->input->post('location',true)
            );

            $id = $this->model->getTermSessionId($where);
            if($id)
            {


                $costId = $this->model->getSessionCost($id);
                if(count($costId) == 0)
                {
                    $this->model->addSessionCost($data);
                }
                else
                {
                    $costId = $costId[0]['id'];
                    $this->model->updateCost($costId,$data);
                }

                $this->session->set_userdata('ok', 'Session cost has been added' );
            }
        }

        $this->preRender();
       /* echo $this->getUserLevel();
        return;
        $data = date('d/m/Y');
        
        echo $this->datediff($data,'03/07/2014');*/
        
        //var_dump($_POST);
    }
    
    public function datediff($date1, $date2)
    {
        $first = date_create_from_format('d/m/Y', $date1);
        $second = date_create_from_format('d/m/Y', $date2);
        return ($first > $second);
    }

    protected function validateCost()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('location', 'Location', 'trim|required|xss_clean|callback_val');
        $this->form_validation->set_rules('term', 'Term', 'trim|required|xss_clean|callback_val');
        $this->form_validation->set_rules('session', 'Session', 'trim|required|xss_clean');
        $this->form_validation->set_rules('full', 'Full price', 'trim|numeric|xss_clean');
        $this->form_validation->set_rules('con', 'Concession price', 'trim|numeric|xss_clean');

        return $this->form_validation->run();
    }

    public function val($val)
    {
        $this->form_validation->set_message('val', '%s id required ');
        return $val != '-1';
    }
}