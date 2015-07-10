<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_term extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE IF NOT EXISTS `term` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `startDate` varchar(15) NOT NULL,
      `endDate` varchar(15) NOT NULL,
      `numWeeks` int(3) NOT NULL,
      PRIMARY KEY (`id`)
    )');
  }

  public function down() {
    $this->dbforge->drop_table('term');
  }

}
