<?php

class Migrate extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('migration');
        $this->input->is_cli_request() or exit;
    }

    public function index() {
        $this->migrate();
    }

    public function version($version) {
        $this->migrate($version);
    }

    private function migrate($version = NULL) {
        $migration = $version ?
            $this->migration->version($version) :
            $this->migration->latest();
        if(!$migration) {
            echo $this->migration->error_string();
        } else {
            echo 'Migration(s) done'.PHP_EOL;
        }
     }
 }
