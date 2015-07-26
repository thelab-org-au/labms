<?php

class Login extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user');
        $this->template = 'login/login';
        $this->modelmainContent = 'login/login';
        $this->title = 'Login';
        $this->baseSeg = 3;
    }

  	public function index() {
        if ($this->uri->segment($this->baseSeg) === FALSE) {
      		  $this->preRender();
        } else {
            $func = $this->uri->segment($this->baseSeg);
            $this->$func();
        }
  	}

    private function preRender() {
      $this->data['page'] = $this->input->get('page', true);
      $this->render();
    }

    public function login() {
        $username = $this->input->post('login');
        $password = $this->input->post('pass');
        if($this->user->login($username, $password)) {
            $page = $this->input->get('page', true);
            $dests = array(
                'mail' => 'signup/mailinglist',
                'wait' => 'signup/waitlist',
                'mentor' => 'signup/mentor',
            );
            $dest = isset($dests[$page]) ? $dests[$page] : 'user/profile';
            redirect(site_url($dest), 'refresh');
        } else {
            $this->data['error'] = 'Could not log in. Please cehck your details.';
            $this->session->set_userdata('user', null);
            $this->preRender();
        }
    }

    public function logout() {
        $this->user->logout();
        redirect('/user/login', 'refresh');
    }
}
