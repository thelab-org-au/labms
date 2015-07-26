<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once APPPATH.'controllers/signup/basesignup.php';

class Training extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('trainingmodel','model');
        $this->mainContent = 'training/training';
        $this->title = 'Training';
        $this->baseSeg = 2;
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

    private function preRender() {
      $this->redirectIfNotLoggedIn();
    	$this->render();
    }

    private function init()
    {
        $this->data['info'] = $this->model->getTrainingInfo();
    }

    public function maintenance()
    {
        $this->mainContent = 'training/maintenance';
        $this->title = 'Training maintenance';
        $this->preRender();
    }

    public function addNew()
    {
        $data['desc'] = $this->input->post('trainingDesc',true);
        $data['content'] = $this->input->post('trainingContent');
        $this->model->addTraningContent($data);
    }

    public function view()
    {
        $content = $this->model->getTrainingContent($this->input->get('id'));
        echo $content[0]['content'];
    }

    public function test()
    {
        echo '';
        //$this->log($_POST['test']);
        //echo $this->SendEmail('Email test new with data',$_POST['test'],'craig@oztron.com');
    }
}
