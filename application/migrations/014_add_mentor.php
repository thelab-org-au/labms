<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_mentor extends CI_Migration {

  public function __construct()
  {
    $this->load->dbforge();
    $this->load->database();
  }

  public function up() {
    $this->db->query('CREATE TABLE IF NOT EXISTS `mentor` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `user` int(11) NOT NULL,
      `dob` varchar(45) NOT NULL,
      `state` varchar(45) NOT NULL,
      `education` text NOT NULL,
      `conviction` smallint(6) NOT NULL,
      `convictionDetails` text,
      `childrenCheck` tinyint(4) NOT NULL,
      `workingWithChild` text,
      `otherSkills` text,
      `references` text NOT NULL,
      `workExp` text NOT NULL,
      `contactEmployer` tinyint(4) NOT NULL,
      `addInfo` text,
      `fileName` varchar(256) DEFAULT NULL,
      `origFileName` varchar(50) DEFAULT NULL,
      PRIMARY KEY (`id`),
      KEY `mentorUser_idx` (`user`),
      CONSTRAINT `mentorUser` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    )');
  }

  public function down() {
    $this->dbforge->drop_table('mentor');
  }

}
