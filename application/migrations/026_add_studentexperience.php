<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_studentexperience extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE IF NOT EXISTS `studentexperience` (
      `studentData` int(11) NOT NULL,
      `tech` int(11) NOT NULL,
      `level` int(11) NOT NULL,
      KEY `student` (`studentData`,`tech`),
      KEY `tech` (`tech`),
      CONSTRAINT `studentexperience_ibfk_2` FOREIGN KEY (`tech`) REFERENCES `techs` (`id`),
      CONSTRAINT `studentexperience_ibfk_3` FOREIGN KEY (`studentData`) REFERENCES `studentdata` (`id`)
    )');
  }

  public function down() {
    $this->dbforge->drop_table('studentexperience');
  }

}
