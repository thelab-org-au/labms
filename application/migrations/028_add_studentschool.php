<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_studentschool extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE IF NOT EXISTS `studentschool` (
      `studentData` int(11) NOT NULL,
      `schoolLevel` int(11) NOT NULL,
      KEY `student` (`studentData`),
      KEY `schoolLevel` (`schoolLevel`),
      CONSTRAINT `studentschool_ibfk_2` FOREIGN KEY (`schoolLevel`) REFERENCES `schoollevel` (`id`),
      CONSTRAINT `studentschool_ibfk_3` FOREIGN KEY (`studentData`) REFERENCES `studentdata` (`id`)
    )');
  }

  public function down() {
    $this->dbforge->drop_table('studentschool');
  }

}
