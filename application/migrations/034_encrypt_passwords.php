<?php

class Migration_Encrypt_passwords extends CI_Migration {

  public function __construct() {
    $this->load->database();
  }

  public function up() {
    $this->load->library('encrypt');
    $q = $this->db->select('id, password')->get('users');
    foreach($q->result() as $row) {
      $raw = $this->encrypt->decode($row->password);
      $new = array('password' => password_hash($raw, PASSWORD_DEFAULT));
      $where = array('id' => $row->id);
      $this->db->update('users', $new, $where);
    }
  }

  public function down() {
    // Not reversible, nor should it be.
  }

}
