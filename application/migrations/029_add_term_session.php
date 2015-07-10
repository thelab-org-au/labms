<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_term_session extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE IF NOT EXISTS `term_session` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `term` int(11) NOT NULL,
      `session` int(11) NOT NULL,
      `location` int(11) NOT NULL,
      PRIMARY KEY (`id`),
      KEY `term` (`term`),
      KEY `session` (`session`),
      KEY `location` (`location`),
      CONSTRAINT `term_session_ibfk_1` FOREIGN KEY (`term`) REFERENCES `term` (`id`),
      CONSTRAINT `term_session_ibfk_2` FOREIGN KEY (`location`) REFERENCES `locations` (`id`),
      CONSTRAINT `term_session_ibfk_3` FOREIGN KEY (`session`) REFERENCES `session_time` (`id`)
    )');
  }

  public function down() {
    $this->dbforge->drop_table('term_session');
  }

}
