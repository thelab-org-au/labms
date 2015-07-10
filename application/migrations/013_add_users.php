<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_users extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE IF NOT EXISTS `users` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `userType` int(11) NOT NULL,
      `email` varchar(55) NOT NULL,
      `firstName` varchar(45) NOT NULL,
      `lastName` varchar(45) NOT NULL,
      `phone` varchar(45) DEFAULT NULL,
      `address` varchar(255) DEFAULT NULL,
      `suburb` varchar(45) DEFAULT NULL,
      `postcode` varchar(5) DEFAULT NULL,
      `password` varchar(255) DEFAULT NULL,
      `active` tinyint(1) NOT NULL DEFAULT "0",
      PRIMARY KEY (`id`),
      KEY `type_idx` (`userType`),
      CONSTRAINT `type` FOREIGN KEY (`userType`) REFERENCES `usertypes` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
    )');
  }

  public function down() {
    $this->dbforge->drop_table('users');
  }

}
