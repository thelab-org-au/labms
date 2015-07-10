<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_mailout extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE IF NOT EXISTS `mailout` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `date` varchar(15) NOT NULL,
      `desc` varchar(255) NOT NULL,
      `content` text NOT NULL,
      PRIMARY KEY (`id`)
    )');
  }

  public function down() {
    $this->dbforge->drop_table('mailout');
  }

}
