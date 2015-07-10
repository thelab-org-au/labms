<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_add_schoollevel extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE IF NOT EXISTS `schoollevel` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `desc` varchar(255) NOT NULL,
      `name` varchar(32) NOT NULL,
      PRIMARY KEY (`id`)
    )');
  }

  public function down() {
    $this->dbforge->drop_table('schoollevel');
  }

}
