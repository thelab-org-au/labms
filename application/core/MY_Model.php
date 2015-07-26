<?php

class MY_Model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getLocationId() {
       $this->db->select('id');
       $data = $this->db->get('locations')->result_array();
       return $data;
    }

    public function getLocationIds() {
       $this->db->select('id');
       $data = $this->db->get('locations')->result_array();
       $returnData = array();
       foreach($data as $d) $returnData[] = $d['id'];
       return $returnData;
    }

    public function GetTable($table,$where = null,$or = null) {
        $this->buildWhere($where, $or);
        return $this->RunQuery($table);
    }

    public function GetTableLimit($table,$limit,$where = null,$or = null) {
        $this->buildWhere($where, $or);
        if(is_array($limit)) {
           $this->db->limit($limit[0], $limit[1]);
        } else {
          $this->db->limit($limit);
        }
        return $this->RunQuery($table);
    }

    private function RunQuery($table) {
        $query = $this->db->get($table);
        return $query->result_array();
    }

    private function buildWhere($where, $or = null) {
        if($where != null && is_array($where)) {
            foreach($where as $key => $value) $this->db->where($key,$value);
        }
        if($or != null) {
            foreach($or as $key => $value) $this->db->or_where($key,$value);
        }
    }

    protected function GetId() {
        return ($this->db->affected_rows() == 1) ? $this->db->insert_id() : false;
    }

    public function logData($data, $class) {
        if(is_array($data)) $data = json_encode($data);
        $insertData['data'] = $data;
        $insertData['class'] = $class;
        $this->db->insert('logs',$insertData);
    }

    public function insertData($table, $data) {
        $this->db->insert($table, $data);
        return $this->GetId();
    }

    public function getuserConfirmation($where) {
        return $this->GetTable('emailconfirmation', $where);
    }

    public function record_count($table) {
        return $this->db->count_all($table);
    }

    public function get_enum_values( $table, $field ) {
        $type = $this->db->query( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" )->row( 0 )->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        foreach(explode(',', $matches[1]) as $value) {
             $enum[] = trim( $value, "'" );
        }
        return $enum;
    }
}
