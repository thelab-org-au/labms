<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_mentorexperience extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE `mentorexperience` (
      `mentor` int(11) NOT NULL,
      `tech` int(11) NOT NULL,
      `level` int(3) NOT NULL,
      KEY `mentor` (`mentor`),
      KEY `tech` (`tech`),
      CONSTRAINT `mentorexperience_ibfk_1` FOREIGN KEY (`mentor`) REFERENCES `mentor` (`id`),
      CONSTRAINT `mentorexperience_ibfk_2` FOREIGN KEY (`tech`) REFERENCES `techs` (`id`)
    )');
  }

  public function down() {
    $this->dbforge->drop_table('mentorexperience');
  }

}
