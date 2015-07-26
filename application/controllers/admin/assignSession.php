<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



require_once APPPATH.'controllers/admin/admin.php';

class AssignSession extends  MY_Controller
{
    public $termModel;
    function __construct()
    {
        parent::__construct();
        $this->load->model('assign_model','model');
        $this->mainContent = 'admin/sessions/assign';
        $this->title = 'Assign students';
        $this->baseSeg = 3;
        $this->load->model('term_model','termModel');
    }

    public function index()
    {
        $this->preRender();
    }

    private function init()
    {
        $this->data['termSessionId'] = $termSession = (int)$this->input->get('ti');
        $this->data['locationId'] = $location = (int)$this->input->get('li');
        $this->data['sessionId'] = $session = (int)$this->input->get('si');

        $temp = $this->model->getTermSessionIds($session,$location);
        $termSessions = array();
        foreach($temp as $t)
            $termSessions[] = $t['id'];

        $temp = $this->model->getPerviousStudents($termSessions);

        $previous = array();
        foreach($temp as $t)
            $previous[] = $t['student'];

        $this->data['previous'] = $this->model->getStudentsIn($previous);

       $this->data['waitlist'] = $this->model->getWaitlistStudents($location,$previous);

       foreach($this->data['waitlist'] as $t)
            $previous[] = $t['id'];

       $this->data['other'] = $this->model->getOther($previous);;

    }

    private function preRender()
    {
        $this->init();
        $this->redirectIfNotLoggedIn();
        $this->render();

    }

    public function addStudents()
    {
        $termSession = $this->input->post('termSession');

        unset($_POST['termSession']);
        unset($_POST['searchField']);

        foreach($this->input->post() as $key => $value)
        {
            if(count($this->model->checkStudent($termSession,$key)) == 0)
            {
                $data['session'] = $termSession;
                $data['student'] = $key;
                $data['active'] = 1;
                $this->model->addStudent($data);
            }
        }

        $this->session->set_userdata('ok', 'Students added');
        redirect('admin/asessions');
    }

    public function search()
    {
        $data = $this->model->searchStudents($this->input->get('name',true));
        echo $this->load->view('admin/sessions/sessionAddSearch',array('data' =>$data),true);
    }

}
