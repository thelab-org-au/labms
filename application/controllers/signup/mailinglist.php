<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/signup/basesignup.php';

class Mailinglist extends Basesignup
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('signup/mailinglistmodel','model');
        $this->data['labs'] = $this->model->GetAllLabs();
        $this->mainContent = 'forms/maillist';
        $this->title = 'Mailing list';
        $this->baseSeg = 3;
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
    	$this->render();
    }

    public function confirm()
    {
        $data['a'] = $this->input->get('a');
        $data['b'] = $this->input->get('b');
        $this->confirmUser($data);
    }

    public function signup()
    {
        $returnData = $this->createBaseUser();

        if($returnData !== false)
        {

            $locationId = $returnData['location'];
            $this->addToMaillist($returnData['id'],$locationId);

            $this->confirmSignup($returnData,'/signup/mailinglist/confirm','emailTemplate/maillistconfirmation');
            /*
            if(!$this->isLoggedin())
                $this->sendConfirmation('/signup/mailinglist/confirm','emailTemplate/maillistconfirmation',$returnData);



            if(!$this->isLoggedin())
                $this->session->set_userdata('ok', 'Sign up completed.<br/>An email has been sent to ' .$returnData['email'] . '.<br/>Please click the link in the email to confirm your details' );
            else
                $this->session->set_userdata('ok', 'Sign up completed.' );
           */
           if(!$this->isLoggedin())
           {
                $this->mainContent = 'confirmations/maillist';
                $this->preRender();
           }
           else
                redirect(site_url().'/user/profile', 'refresh');

        }
        else
            $this->preRender();
    }

    private function addToMaillist($user,$location)
    {
        $data['user'] = $user;
        $data['location'] = $location;
        $this->model->addToMaillist($data);
    }
}
