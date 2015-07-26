<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/admin/admin.php';

class Amentors extends Admin
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model','model');
        $this->mainContent = 'admin/mentor/mentors';
        $this->title = 'Mentors';
        $this->baseSeg = 3;
        $this->data['labInfo'] = $this->model->getLocations();
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

    public function getMentorApplications()
    {
        $lab = (int)$this->input->get('lab');

        $data['locations'] = $this->sortLabs();
        $data['applications'] = $this->model->getMentorsApplications($lab);
        $data['applications'] = $this->getAge($data['applications']);

        $start = (int)$this->input->get('start');
        $count = sizeof($this->model->getMentorsApplications($lab));

        $data['paginationData']['draw'] = ($count > PAG_LIMIT);
        $data['paginationData']['count'] = ($count / PAG_LIMIT);
        $data['paginationData']['current'] = $start;
        $data['paginationData']['function'] = 'appPagination';


        echo $this->load->view('/admin/mentor/applications',$data,true);
    }

    public function getMentors()
    {
         $lab = (int)$this->input->get('lab');

        $data['locations'] = $this->sortLabs();
        $data['applications'] = $this->model->getMentors($lab);
        $data['applications'] = $this->getAge($data['applications']);

        $start = (int)$this->input->get('start');
        $count = sizeof($this->model->getMentors($lab));

        $data['paginationData']['draw'] = ($count > PAG_LIMIT);
        $data['paginationData']['count'] = ($count / PAG_LIMIT);
        $data['paginationData']['current'] = $start;
        $data['paginationData']['function'] = 'mentorPagination';

        for($cnt = 0; $cnt < sizeof($data['applications']); $cnt++ )
            $data['applications'][$cnt]['locations'] = $this->model->getMentorLocations($data['applications'][$cnt]['id']);


        echo $this->load->view('/admin/mentor/displayMentors',$data,true);

    }

    public function searchApplications()
    {
        $search = $this->input->get('search',true);
        $data['locations'] = $this->sortLabs();
        $data['applications'] = $this->model->getMentorsApplications(null,null,$search);
        $data['applications'] = $this->getAge($data['applications']);
        echo $this->load->view('/admin/mentor/applications',$data,true);
    }

    public function searchMentors()
    {
        $search = $this->input->get('search',true);
        $data['locations'] = $this->sortLabs();
        $data['applications'] = $this->model->getMentors(null,null,$search);
        $data['applications'] = $this->getAge($data['applications']);

        for($cnt = 0; $cnt < sizeof($data['applications']); $cnt++ )
            $data['applications'][$cnt]['locations'] = $this->model->getMentorLocations($data['applications'][$cnt]['id']);

        echo $this->load->view('/admin/mentor/displayMentors',$data,true);
    }

    private function sortLabs()
    {
        $labs = array();
        foreach($this->data['labInfo'] as $l)
           $labs[$l['id']] =  $l['name'];

        return $labs;
    }

    public function view()
    {
        $mentor = (int)$this->input->get('id');
        $app = $this->input->get('m');

        if($app !== 'true')
            $data['applications'] = $this->model->getMentorsApplications(null,$mentor);
        else
            $data['applications'] = $this->model->getMentors(null,$mentor);

        $data['applications'][0]['experience'] = $this->model->getMentorExp($mentor);
        $view = $this->load->view('admin/mentor/view',$data,true);
        echo $view;
    }

    public function createMentor()
    {
        $mentor = (int)$this->input->post('mentorId');
        unset($_POST['mentorId']);
        //var_dump($this->input->post());

        $data['mentor'] = $mentor;
        foreach($this->input->post() as $post)
        {
            $data['location'] = $post;
            $this->model->createMentor($data);
        }

        $this->model->removeApplication($mentor);
        $this->session->set_userdata('ok', 'Mentor updated' );
        redirect('/admin/amentors');
    }

    public function removeMentor()
    {
       // var_dump($this->input->post());

        $data['mentor'] = $this->input->post('mentorId');

        unset($_POST['mentorId']);

        foreach($this->input->post() as $post)
        {
            $data['location'] = $post;
            $this->model->createMentor($data,'0');
        }

        $this->session->set_userdata('ok', 'Mentor updated' );
        redirect('/admin/amentors');
    }

    public function getMentorLabs()
    {
        $mentor = (int)$this->input->post('id');
        $data['info'] = $this->model->getMentors(null,$mentor);
        $data['locations'] = $this->sortLabs();
        for($cnt = 0; $cnt < sizeof($data['info']); $cnt++ )
            $data['info'][$cnt]['locations'] = $this->model->getMentorLocations($data['info'][$cnt]['id']);

        echo $this->load->view('admin/mentor/locations',$data,true);
    }


    public function getAge($data)
    {
        for($cnt = 0; $cnt < sizeof($data); $cnt++)
            $data[$cnt]['dob'] = $this->calcAge($data[$cnt]['dob']);

        return $data;
    }

    private function calcAge($dob)
    {
        $date = DateTime::createFromFormat("d/m/Y", $dob);
        $today = new DateTime('NOW');
        $diff = $today->diff($date);

        return   $diff->y;
    }


}
