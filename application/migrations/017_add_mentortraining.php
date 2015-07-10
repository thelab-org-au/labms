<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_add_mentortraining extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE IF NOT EXISTS `mentortraining` (
      `mentor` int(11) NOT NULL,
      `training` int(11) NOT NULL,
      KEY `mentor_idx` (`mentor`),
      KEY `training_idx` (`training`),
      CONSTRAINT `mentor` FOREIGN KEY (`mentor`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
      CONSTRAINT `training` FOREIGN KEY (`training`) REFERENCES `training` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
    )');
  }

  public function down() {
    $this->dbforge->drop_table('mentortraining');
  }

}
