<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_waitlist extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE IF NOT EXISTS `waitlist` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `student` int(11) NOT NULL,
      `location` int(11) NOT NULL,
      PRIMARY KEY (`id`),
      KEY `student_idx` (`student`),
      KEY `location` (`location`),
      CONSTRAINT `student` FOREIGN KEY (`student`) REFERENCES `student` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
      CONSTRAINT `waitlist_ibfk_1` FOREIGN KEY (`location`) REFERENCES `locations` (`id`)
    )');
  }

  public function down() {
    $this->dbforge->drop_table('waitlist');
  }

}
