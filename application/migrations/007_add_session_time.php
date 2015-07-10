<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_session_time extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE IF NOT EXISTS `session_time` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `day` enum("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday") NOT NULL,
      `startTime` varchar(10) NOT NULL,
      `endTime` varchar(10) NOT NULL,
      PRIMARY KEY (`id`)
    )');
  }

  public function down() {
    $this->dbforge->drop_table('session_time');
  }

}
