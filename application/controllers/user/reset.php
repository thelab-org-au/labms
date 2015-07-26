<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reset extends MY_Controller
 {

    function __construct()
    {
        parent::__construct();
        $this->init();
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
        if(!$this->input->get('a'))
            $this->load->view('login/reset');
        else
            $this->load->view('login/newpassword');
    }

    private function init()
    {
        $this->load->model('login/resetModel','model');
    }

    public function process()
    {
        //$newPass =  $this->randomPassword();
        $this->init();
        $email = trim($this->input->post('login'));

        //if($this->model->addPassword($newPass,$email))
        //{

            $id = $this->model->getUserId(array('email' => $email));
            $a = md5(rand());
            $b = md5(rand(5, 15));
            $conData['user'] = $id;
            $conData['a'] = $a;
            $conData['b'] = $b;



            $message = '<p>Please click the following link to reset your password.</p>'. site_url().'/user/reset?a='.$a.'&b='.$b;

            if($this->SendEmail('Password reset',$message,trim($this->input->post('login'))))
            {
                $this->session->set_userdata('ok', 'An email has been sent to ' .trim($this->input->post('login')) . '.<br/>Please click the link in the email to reset your password' );

                $this->model->insertData('emailconfirmation',$conData);

                $this->load->view('login/resetconfirmation');
                return;
            }
        //}

        $this->data['error'] = 'An error has occurred please contact site administrators';
        $this->preRender();
    }

    public function apply()
    {
        $this->init();
        if($this->validatePassword())
        {
            $data['a'] = $this->input->get('a');
            $data['b'] = $this->input->get('b');
            $conData = $this->model->getuserConfirmation($data);
            $id = $conData[0]['user'];
            $conId = $conData[0]['id'];

            $this->load->library('encrypt');
            $newPass['password'] = $this->encrypt->encode(trim($this->input->post('pass')));

            $this->model->updatePassword($id,$newPass);
            $this->model->deleteConfirmation($conId);
            $this->session->set_userdata('ok', 'Your password has been reset.<br/> Please login.' );
            redirect(site_url().'/user/login');
            return;
        }
        else
            $this->load->view('login/newpassword');


    }

    protected function validatePassword()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pass', 'Password', 'matches[passCon]|trim|required|min_length[8]');
        $this->form_validation->set_rules('passCon', 'Password confirmation', 'trim|required');

        return $this->form_validation->run();
    }

    private function randomPassword($length = 8)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars),0,$length);
    }
}
