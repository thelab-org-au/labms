<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_studentcontact extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE IF NOT EXISTS `studentcontact` (
      `student` int(11) NOT NULL,
      `contact` int(11) NOT NULL,
      KEY `student_idx` (`student`),
      KEY `contact_idx` (`contact`),
      CONSTRAINT `contactCon` FOREIGN KEY (`contact`) REFERENCES `contact` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
      CONSTRAINT `studentCon` FOREIGN KEY (`student`) REFERENCES `student` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    )');
  }

  public function down() {
    $this->dbforge->drop_table('studentcontact');
  }

}
