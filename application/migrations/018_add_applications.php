<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_applications extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE IF NOT EXISTS `applications` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `mentor` int(11) NOT NULL,
      `location` int(11) DEFAULT NULL,
      `active` tinyint(4) NOT NULL DEFAULT "1",
      PRIMARY KEY (`id`),
      KEY `user_idx` (`mentor`),
      KEY `location` (`location`),
      CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`mentor`) REFERENCES `mentor` (`id`),
      CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`location`) REFERENCES `locations` (`id`)
    )');
  }

  public function down() {
    $this->dbforge->drop_table('applications');
  }

}
