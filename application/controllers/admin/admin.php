<?php

class Admin extends MY_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('admin_model','model');
    $this->mainContent = 'admin/admin';
    $this->title = 'Admin';
    $this->baseSeg = 3;
  }

  public function index() {
    $this->redirectIfNotLoggedIn();
    $this->render();
  }

}
