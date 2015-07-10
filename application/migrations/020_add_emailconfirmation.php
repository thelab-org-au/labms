<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_emailconfirmation extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE IF NOT EXISTS `emailconfirmation` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `user` int(11) NOT NULL,
      `a` varchar(32) NOT NULL,
      `b` varchar(32) NOT NULL,
      PRIMARY KEY (`id`),
      KEY `user` (`user`),
      CONSTRAINT `emailconfirmation_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`)
    )');
  }

  public function down() {
    $this->dbforge->drop_table('emailconfirmation');
  }

}
