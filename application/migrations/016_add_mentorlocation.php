<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_mentorlocation extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE IF NOT EXISTS `mentorlocation` (
      `mentor` int(11) NOT NULL,
      `location` int(11) NOT NULL,
      `active` tinyint(4) NOT NULL DEFAULT "1",
      KEY `mentor` (`mentor`,`location`),
      KEY `location` (`location`),
      CONSTRAINT `mentorlocation_ibfk_1` FOREIGN KEY (`mentor`) REFERENCES `mentor` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');
  }

  public function down() {
    $this->dbforge->drop_table('mentorlocation');
  }

}
