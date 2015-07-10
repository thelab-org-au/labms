<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_maillist extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE IF NOT EXISTS `maillist` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `user` int(11) NOT NULL,
      `location` int(11) DEFAULT NULL,
      PRIMARY KEY (`id`),
      KEY `user_idx` (`user`),
      KEY `location` (`location`),
      CONSTRAINT `maillist_ibfk_1` FOREIGN KEY (`location`) REFERENCES `locations` (`id`),
      CONSTRAINT `userMail` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    )');
  }

  public function down() {
    $this->dbforge->drop_table('maillist');
  }

}
