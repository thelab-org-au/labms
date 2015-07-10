<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_userlocation extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE IF NOT EXISTS `userlocation` (
      `user` int(11) NOT NULL,
      `location` int(11) NOT NULL,
      KEY `user_idx` (`user`),
      KEY `location_idx` (`location`),
      CONSTRAINT `locationLoc` FOREIGN KEY (`location`) REFERENCES `locations` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
      CONSTRAINT `userLoc` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
    )');
  }

  public function down() {
    $this->dbforge->drop_table('userlocation');
  }

}
