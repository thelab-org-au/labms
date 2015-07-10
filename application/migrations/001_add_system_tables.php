<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_system_tables extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE IF NOT EXISTS `ci_sessions` (
      `session_id` varchar(40) NOT NULL DEFAULT "0",
      `ip_address` varchar(45) NOT NULL DEFAULT "0",
      `user_agent` varchar(120) NOT NULL,
      `last_activity` int(10) unsigned NOT NULL DEFAULT "0",
      `user_data` text NOT NULL,
      PRIMARY KEY (`session_id`),
      KEY `last_activity_idx` (`last_activity`)
    )');
    $this->db->query('CREATE TABLE IF NOT EXISTS `errorlogs` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `data` text,
      PRIMARY KEY (`id`)
    )');
    $this->db->query('CREATE TABLE IF NOT EXISTS `logs` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `data` varchar(2048) DEFAULT NULL,
      `class` varchar(255) NOT NULL,
      PRIMARY KEY (`id`)
    )');
  }

  public function down() {

  }

}

/* End of file add_system_tables.php */
/* Location: ./application/migrations/add_system_tables.php */
