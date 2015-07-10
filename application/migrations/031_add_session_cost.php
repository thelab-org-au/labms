<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_session_cost extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE IF NOT EXISTS `session_cost` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `termSessionId` int(11) NOT NULL,
      `full` decimal(9,2) NOT NULL,
      `con` decimal(9,2) NOT NULL,
      PRIMARY KEY (`id`),
      KEY `termSessionId` (`termSessionId`),
      CONSTRAINT `session_cost_ibfk_1` FOREIGN KEY (`termSessionId`) REFERENCES `term_session` (`id`)
    )');
  }

  public function down() {
    $this->drop_table('session_cost');
  }

}
