<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_mailoutlocation extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE IF NOT EXISTS `mailoutlocation` (
      `location` int(11) NOT NULL,
      `mailout` int(11) NOT NULL,
      KEY `location` (`location`),
      KEY `mailout` (`mailout`),
      CONSTRAINT `mailoutlocation_ibfk_1` FOREIGN KEY (`location`) REFERENCES `locations` (`id`),
      CONSTRAINT `mailoutlocation_ibfk_2` FOREIGN KEY (`mailout`) REFERENCES `mailout` (`id`)
    )');
  }

  public function down() {
    $this->dbforge->drop_table('mailoutlocation');
  }

}
