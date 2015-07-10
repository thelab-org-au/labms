<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_studentsession extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE IF NOT EXISTS `studentsession` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `student` int(11) NOT NULL,
      `session` int(11) NOT NULL,
      `active` tinyint(4) NOT NULL DEFAULT "1",
      PRIMARY KEY (`id`),
      KEY `student` (`student`),
      KEY `session` (`session`),
      CONSTRAINT `studentsession_ibfk_1` FOREIGN KEY (`student`) REFERENCES `student` (`id`),
      CONSTRAINT `studentsession_ibfk_3` FOREIGN KEY (`session`) REFERENCES `term_session` (`id`)
    )');
  }

  public function down() {
    $this->dbforge->drop_table('studentsession');
  }

}
