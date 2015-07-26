<?php

class User extends MY_Model {

  private static $table = 'users';
  private $user;

  public function __construct() {
    $this->load->library('session');
    parent::__construct();
  }

  public function login($username, $password) {
    $q = $this->db->where('email', $username)->get(self::$table);
    $user = current($q->result());
    if($user && password_verify($password, $user->password)) {
      $this->setUserData($user);
      return true;
    }
  }

  public function update($data) {
    $id = $data['id'];
    unset($data['id']);

    if(empty($data['password'])) {
      unset($data['password']);
    } else {
      $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    }
    unset($data['confirmation']);

    $this->db->where('id', $id)->update(self::$table, $data);
    if($this->db->affected_rows() == 1) {
      $this->setUserData(current($this->db->where('id', $id)->get(self::$table)->result()));
      return true;
    }
  }

  public function logout() {
    $this->session->sess_destroy();
  }

  public function isLoggedIn() {
    return !!$this->session->userdata('logged_in');
  }

  public function getId() {
    return $this->get('id');
  }

  public function getFirstName() {
    return $this->get('firstName');
  }

  public function getLastName() {
    return $this->get('lastName');
  }

  public function getPhone() {
    return $this->get('phone');
  }

  public function getType() {
    return $this->get('type');
  }

  public function getAddress() {
    return $this->get('address');
  }

  public function getSuburb() {
    return $this->get('suburb');
  }

  public function getPostcode() {
    return $this->get('postcode');
  }

  public function getEmail() {
    return $this->get('email');
  }

  private function get($name) {
    if($this->session) {
      $user = $this->session->userdata('user');
      if(property_exists($user, $name)) return $user->$name;
    }
  }

  private function setUserData($user = NULL) {
    $this->session->set_userdata('logged_in', !!$user);
    if($user) {
      unset($user->password);
      $this->session->set_userdata('user', $user);
    } else {
      $this->session->unset_userdata('user');
    }
  }

}
