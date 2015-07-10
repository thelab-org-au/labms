<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_attendance extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE IF NOT EXISTS `attendance` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `studentSession` int(11) NOT NULL,
      `date` varchar(11) NOT NULL,
      `present` tinyint(4) NOT NULL,
      PRIMARY KEY (`id`),
      KEY `student_idx` (`studentSession`),
      CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`studentSession`) REFERENCES `studentsession` (`id`)
    )');
  }

  public function down() {
    $this->dbforge->drop_table('attendance');
  }

}
