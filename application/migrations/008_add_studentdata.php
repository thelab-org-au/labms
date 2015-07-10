<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_studentdata extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE IF NOT EXISTS `studentdata` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `daysAtSchool` int(11) NOT NULL,
      `schoolOther` varchar(255) NOT NULL,
      `conditionOther` varchar(255) NOT NULL,
      `lapTop` tinyint(4) NOT NULL,
      `sessionType` varchar(255) NOT NULL,
      `otherInfo` text NOT NULL,
      `sessionOther` varchar(255) NOT NULL,
      PRIMARY KEY (`id`)
    )');
  }

  public function down() {
    $this->dbforge->drop_table('studentdata');
  }

}
