<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_usertypes extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE IF NOT EXISTS `usertypes` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `type` varchar(45) NOT NULL,
      PRIMARY KEY (`id`)
    )');
  }

  public function down() {
    $this->dbforge->drop_table('usertypes');
  }

}
