<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_student extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE IF NOT EXISTS `student` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(45) NOT NULL,
      `dob` varchar(32) NOT NULL,
      `studentData` int(11) DEFAULT NULL,
      `user` int(11) DEFAULT NULL,
      `contact_phone` varchar(14) DEFAULT NULL,
      `contact_email` varchar(125) DEFAULT NULL,
      `active` tinyint(4) NOT NULL DEFAULT "1",
      PRIMARY KEY (`id`),
      KEY `studentData` (`studentData`),
      KEY `user` (`user`),
      CONSTRAINT `student_ibfk_2` FOREIGN KEY (`studentData`) REFERENCES `studentdata` (`id`),
      CONSTRAINT `student_ibfk_3` FOREIGN KEY (`user`) REFERENCES `users` (`id`)
    )');
  }

  public function down() {
    $this->dbforge->drop_table('student');
  }

}
