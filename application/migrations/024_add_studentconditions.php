<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_studentconditions extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE IF NOT EXISTS `studentconditions` (
      `studentData` int(11) NOT NULL,
      `condition` int(11) NOT NULL,
      KEY `student` (`studentData`,`condition`),
      KEY `condition` (`condition`),
      CONSTRAINT `studentconditions_ibfk_2` FOREIGN KEY (`condition`) REFERENCES `conditions` (`id`),
      CONSTRAINT `studentconditions_ibfk_3` FOREIGN KEY (`studentData`) REFERENCES `studentdata` (`id`)
    )');
  }

  public function down() {
    $this->dbforge->drop_table('studentconditions');
  }

}
