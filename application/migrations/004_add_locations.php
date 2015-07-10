<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_add_locations extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE IF NOT EXISTS `locations` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(128) NOT NULL,
      `address` varchar(512) NOT NULL,
      `active` tinyint(4) NOT NULL DEFAULT "1",
      PRIMARY KEY (`id`)
    )');
  }

  public function down() {
    $this->dbforge->drop_table('locations');
  }

}
