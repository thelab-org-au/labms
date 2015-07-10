<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/admin/admin.php';

class Ausers extends Admin 
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model','model');
        $this->mainContent = 'admin/users';
        $this->title = 'Admin users';
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
        $user = $this->session->userdata('user');
        $temp = $this->model->getUserLocations($user['id']);
        
        $userlocations = array();
        foreach($temp as $t)
            $userlocations[] = $t['location'];
            
        if((int)$user['type'] <= 4) 
        {   
            $temp = $this->model->getLocations();
            $this->data['users'] = $this->model->getUsers(null,$userlocations);

            foreach($this->model->getUserLocations($user['id']) as $t)
                $userlocations[] = $t['location'];
             
             foreach($temp as $t)
             {
                if(in_array($t['id'],$userlocations))
                    $this->data['locations'][] = $t;
             }  
        }
        else
        {
            $this->data['users'] = $this->model->getUsers();
            $this->data['locations'] = $this->model->getLocations();
        }
        $this->data['userTypes'] = $this->model->getUserType();
    }
    
    private function preRender()
    {
        $this->init();
        $this->loginRequired = true;
        $this->CheckLogin();
    	$this->render();         
    }
    
    public function add()
    {
        $this->load->library('encrypt');
        $data['userType'] = $this->input->post('lab');
        $data['email'] = $this->input->post('email',true);
        $data['firstName'] = $this->input->post('fname',true);
        $data['lastName'] = $this->input->post('lname',true);
        
        $data['phone'] = null;
        $data['address'] = null;
        $data['suburb'] = null;
        $data['postcode'] = null;
        
        $data['password'] = $this->encrypt->encode($this->input->post('pass',true));
        $data['active'] = '1';
        
        $id = $this->model->addUser($data);
        
        if($data['userType'] == '2')
            $this->addMentorUser($id);
        
        foreach($this->input->post('location') as $location)
            $this->model->addUserLocation($id,$location);
            
        $this->preRender();
    }
    
    private function addMentorUser($id)
    {
        $data = array();
        $data['user'] = $id;
        $data['dob'] = 'Needs to be added';
        $data['state'] = 'Needs to be added';
        $data['education'] = 'Needs to be added';
        $data['conviction'] = 0;
        $data['convictionDetails'] = null;
        $data['childrenCheck'] = 0;
        $data['workingWithChild'] = null;
        $data['otherSkills'] = null;
        $data['references'] = 'Needs to be added';
        $data['workExp'] = 'Needs to be added';
        $data['contactEmployer'] = 0;
        $data['addInfo'] = null;
        $data['fileName'] = null;
        $data['origFileName'] = null;
        $this->model->addMentorUser($data);        
    }
    
    public function delete()
    {
        $this->model->removeUser((int)$this->input->get('id'));
        $this->preRender();
    }
    
    public function editUser()
    {
        $id = $this->input->post('editId');
        
        if($this->baseFormValidation())
        {
            $data['userType'] = $this->input->post('labEdit');
            $data['email'] = $this->input->post('emailEdit',true);
            $data['firstName'] = $this->input->post('fnameEdit',true);
            $data['lastName'] = $this->input->post('lnameEdit',true);
            
            $data['phone'] = $this->input->post('phoneEdit',true);
            $data['address'] = $this->input->post('addressEdit',true);
            $data['suburb'] = $this->input->post('suburbEdit',true);
            $data['postcode'] = $this->input->post('postcodeEdit',true);
            
           $this->model->updateUser($id,$data);
            
            
            if(array_key_exists('location',$_POST))
            {
				$this->model->removeUserLocation($id);
                foreach($this->input->post('location') as $location)
                    $this->model->addUserLocation($id,$location);
            }

        }
        $this->preRender();
    }
    
    protected function baseFormValidation()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('emailEdit', 'Email', 'valid_email|trim|required|xss_clean');
        $this->form_validation->set_rules('fnameEdit', 'First name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('lnameEdit', 'Surname', 'trim|required|xss_clean');
        
        return $this->form_validation->run();        
    }
    
    private function addLocations()
    {
        
    }
    
    public function getData()
    {
        $data['user'] = $this->model->getUsers($this->input->get('id'));
        foreach($this->model->getUserLocations($this->input->get('id')) as $t)
        {
            $data['user']['locations'][] = $t['location'];
        }
        
        $data['userTypes'] = $this->model->getUserType();
        
        $user = $this->session->userdata('user');
        
        $temp = $this->model->getLocations();
        
        if((int)$user['type'] == 4)
        {
            $userlocations = array();
            foreach($this->model->getUserLocations($user['id']) as $t)
                $userlocations[] = $t['location'];
             
             foreach($temp as $t)
             {
                if(in_array($t['id'],$userlocations))
                    $data['locations'][] = $t;
             }           
        }
        else
        {
            $data['locations'] = $temp;
        }
       
        
        $view = $this->load->view('admin/userEdit',$data,true);
        echo  $view;
    }
}