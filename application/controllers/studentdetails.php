<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Studentdetails extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('studentmodel','model');
        $this->title = 'Student details';
        $this->baseSeg = 2;
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

  private function preRender() {
    $this->redirectIfNotLoggedIn();
    $this->render();
  }

    public function student()
    {
        $this->mainContent = 'student/details';

        $id = $this->input->get('id');
        $admin = $this->input->get('admin');

        $details = $this->model->getStudentDetails($id);

        $this->getDetails($details,$id,$admin);



        if(!$admin)
        {
            $this->load->view('student/details',$this->data);
        }
        else
        {
            $this->load->view('admin/student/details',$this->data);
        }

    }

    private function getDetails($details,$id,$contact = null)
    {
        $details[0]['conditions'] = $this->model->getStudentConditions($details[0]['studentData']);
        $details[0]['schools'] = $this->model->getStudentSchool($details[0]['studentData']);
        $details[0]['interests'] = $this->model->getStudentIntrests($details[0]['studentData'],'studentintrest');
        $details[0]['experience'] = $this->model->getStudentIntrests($details[0]['studentData'],'studentexperience');


        if($contact != null)
        {
            $con[0]['primary'] = $this->model->primaryContact($details[0]['user']);
            $con[0]['contacts'] = $this->model->getStudentContacts($id);
            $this->data['contacts'] = $con[0];
        }



        $this->data['studentDetails'] = $details[0];
    }

    public function contact()
    {
        $this->mainContent = 'student/contact';
        $id = $this->input->get('id');

        $details = $this->model->getStudentDetails($id);
        $details[0]['primary'] = $this->model->primaryContact($details[0]['user']);
        $details[0]['contacts'] = $this->model->getStudentContacts($id);

        $this->data['contacts'] = $details[0];


        $this->load->view('student/contact',$this->data);
    }

    public function remove()
    {
        $id = $this->input->get('id');
        $session = $this->input->get('session');
        $removed = $this->model->removeFromSession($session,$id);

        echo $removed;
    }

    public function findStudent()
    {
        $search = $this->input->get('search',true);
        $data['data'] = $this->model->findStudentData($search);
        $data['session'] = (int)$this->input->get('session',true);

        echo $this->load->view('student/searchResults',$data);
    }

    public function findStudentLab()
    {
        $lab = $this->input->get('search',true);
        $sessions = $this->model->findSessionByLab($lab);

        $studentIds = array();

        foreach($sessions as $session)
            $studentIds[] = $this->model->getSessionInfo($session['id']);

        $temp = array();

        foreach($studentIds as $sid)
        {
            for($cnt = 0; $cnt < sizeof($sid); $cnt++)
            {
                $t =  $this->model->getStudentById($sid[$cnt]['student']);
                $temp[] = $t[0];
            }
        }


        $data['data'] = $temp;
        $data['session'] = (int)$this->input->get('session',true);

        echo $this->load->view('student/searchResults',$data);
    }

    public function addToSession()
    {
        $student = $this->input->get('student',true);
        $session = $this->input->get('session',true);

        $data['session'] = $this->input->get('session',true);
        $data['student'] = $this->input->get('student',true);
       // $data['active'] = 1;

        $records = $this->model->checkStudent($data);


        if(sizeof($records) == 0)
        {
            $records = $this->model->addToSession($data);
        }
        else if(sizeof($records) > 0 && $records[0]['active'] == '0')
        {
            $records = $this->model->updateSession($session,$student);
        }
        else
        {
            $records = 'Student already in session';
        }

        $this->model->setStudentActive($student);


        echo $records;
    }
}
