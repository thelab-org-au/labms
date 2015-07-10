<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

abstract class Basesignup extends MY_Controller 
{

    function __construct()
    {
        parent::__construct();
    }
    protected function createBaseUser($student = true,$location = true)
    {
        $email = $this->input->post('email',TRUE);
        $user = $this->model->getUser($email);
        
        $id;
        if($this->baseFormValidation() && !$this->isLoggedin())
        {

            if(sizeof($user) != 0)
            {
                $id = $user[0]['id'];
                $this->setUserData($user);
                
            }
            else
            {
                $id = $this->AddBaseData();
            }
            
            

            $this->userId = $id;
            
            return $this->addData($id,$email,$student,$location);
        }
        else if($this->isLoggedin())
        {
            $id = $this->getUserId();

            $this->userId = $id;
            
            return $this->addData($id,$email,$student,$location);           
        }
        else
            return false;
    }
    
    private function addData($id,$email,$student,$location)
    {
        $returnData = array();
        //if($student)
           // $returnData['studentId'] = $this->addChildData($id);
        if($location && (int)$this->input->post('lab') != -2 && !$this->isLoggedin()) 
            $locationId = $this->addUserLocation($id);
        else if((int)$this->input->post('lab') != -2)
            $locationId = $this->input->post('lab');
        else
            $locationId = null;
            
        $returnData['email'] = $email;
        $returnData['id'] = $id;
        $returnData['location'] = $locationId;
        return $returnData;         
    }
    
    protected function baseFormValidation()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'valid_email|trim|required|xss_clean');
        $this->form_validation->set_rules('fname', 'First name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('lname', 'Surname', 'trim|required|xss_clean');
        $this->form_validation->set_rules('postcode', 'Postcode', 'trim|max_length[4]|numeric|xss_clean');      
        $this->form_validation->set_rules('pass', 'Password', 'matches[passCon]|trim|required|min_length[8]|xss_clean');
        $this->form_validation->set_rules('passCon', 'Password confirmation', 'trim|required|xss_clean');
        
        return $this->form_validation->run();        
    }
    
    protected function confirmSignup($returnData,$link,$view)
    {
        if(!$this->isLoggedin())
        {
            $this->sendConfirmation($link,$view,$returnData);
            $this->session->set_userdata('ok', 'Sign up completed.<br/>An email has been sent to ' .$returnData['email'] . '.<br/>Please click the link in the email to confirm your details' );
        }
        else
            $this->session->set_userdata('ok', 'Sign up completed.' );             
                  
    }

    protected function AddBaseData()
    {
        return $this->model->addUser();
    }

    protected function confirmUser($data)
    {
        $user = $this->model->getuserConfirmation($data);
        if(sizeof($user) === 1)
        {
            $this->model->confirmUser($user[0]['user'],$user[0]['id']);
            $userData = $this->model->getUserId($user[0]['user']);
            $this->setUserData($userData);
            redirect(site_url().'/user/profile');
        }         
    }
    
    protected function sendConfirmation($link,$view,$returnData)
    {
        $id = $returnData['id'];
        $email = $returnData['email'];
        
        $sendId = md5($id);
        $sendEmail = md5($email);
        
        
        $emailData['link'] = site_url().$link.'?a='.$sendId.'&b='.$sendEmail;
        
        $body = $this->load->view($view,$emailData,true);
        $subject = 'thelab.org.au email confirmation';
        
        $this->ConfigEmail();
        $this->SendEmail($subject,$body,$email);
        
        $conData['user'] = $id;
        $conData['a'] = $sendId;
        $conData['b'] = $sendEmail;
        $this->model->insertData('emailconfirmation',$conData);        
    }
    
    protected function getChildData($name,$dob,$id)
    {
        $data = array();
        if($this->input->post($name) != '' && $this->input->post($dob) != '')
        {
            $data['name'] = $this->input->post($name);
            $data['dob'] = $this->input->post($dob);
            $data['user'] = $id;
            
            return $this->model->addChildData($data);
        }
        else
            return false;
                
    }
    

    protected function addContact($id)
    {
        $data['user'] = $id;
        return $this->model->addContact($data);
    }
    
    protected function addStudentContact($studentId,$contactId)
    {
        $data['contact'] = $contactId;
        $data['student'] = $studentId;
        $this->model->addStudentContact($data);
    }

    protected function addUserLocation($id)
    {
        $data['user'] = $id;
        $data['location'] = ((int)$this->input->post('lab') == -2 ? null : (int)$this->input->post('lab'));
        
        if(!$this->model->checkUserLocation($id,$data['location']))
            $this->model->addUserLocation($data);
            
        return (int)$this->input->post('lab');
    } 
}