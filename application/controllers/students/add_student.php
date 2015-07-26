<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Add_student extends MY_Controller

{

    function __construct()
    {

        parent::__construct();

        $this->load->model('students/add_student_model','model');

        $this->mainContent = 'student/add';

        $this->title = 'Add student';

    }



	public function index()
	{

       // var_dump($this->input->post(null,true));
       $valError;
        if($this->validate())
        {

            $data['name'] = $this->input->post('name',true);
            $data['contact_email'] = $this->input->post('contactEmail',true);

            if(!$this->model->validate(trim($data['name']),trim($data['contact_email'])))
            {
                echo 'Student and contact already exists';
                return;
            }

            $data['contact_phone'] = $this->input->post('phone',true);

            $sessionData['session'] = (int)$this->input->post('addToSession',true);
            $sessionData['student'] = $this->model->addStudent($data);
            $sessionData['active'] = 1;
            //var_dump($sessionData);
            if($sessionData['student'] != null)
            {
                if($this->model->addToSession($sessionData) != null)
                {
                    echo 'true';
                    return;
                }

            }

        }
        else
            echo validation_errors();
	}


    protected function validate()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('contactEmail', 'Email', 'trim|valid_email|required|xss_clean');
        $this->form_validation->set_rules('phone', 'Contact phone', 'trim|required|xss_clean');
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');

        return $this->form_validation->run();
    }


 }
