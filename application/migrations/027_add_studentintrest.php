<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_studentintrest extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE IF NOT EXISTS `studentintrest` (
      `studentData` int(11) NOT NULL,
      `tech` int(11) NOT NULL,
      `level` int(11) NOT NULL,
      KEY `student` (`studentData`,`tech`),
      KEY `tech` (`tech`),
      CONSTRAINT `studentintrest_ibfk_2` FOREIGN KEY (`tech`) REFERENCES `techs` (`id`),
      CONSTRAINT `studentintrest_ibfk_3` FOREIGN KEY (`studentData`) REFERENCES `studentdata` (`id`)
    )');
  }

  public function down() {
    $this->dbforge->drop_table('studentintrest');
  }

}
