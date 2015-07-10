<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * MY_Model
 * 
 * @package   
 * @author Lab admin
 * @copyright craig poole
 * @version 2013
 * @access public
 */
class MY_Model extends CI_Model
{
    private $errorLog = 'errorLogs';
    private $userLog = 'userLogs';
    
    /**
     * MY_Model::__construct()
     * 
     * @return
     */
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }
    
    public function getLocationId()
    {
       $this->db->select('id');
       $data = $this->db->get('locations')->result_array();
       return $data; 
    }
    public function getLocationIds()
    {
       $this->db->select('id');
       $data = $this->db->get('locations')->result_array();
       $returnData = array();
       
       foreach($data as $d)
        $returnData[] = $d['id'];
        
       return $returnData; 
    }
    
    /**
     * MY_Model::countResults()
     * 
     * @param mixed $table
     * @param mixed $where
     * @param mixed $or
     * @return
     */
    public function countResults($table,$where = null, $or = null)
    {
        $this->buildWhere($where,$or);
        $this->db->from($table);
        return $this->db->count_all_results();        
    }
    
    /**
     * MY_Model::GetTable()
     * 
     * @param mixed $table
     * @param mixed $where
     * @param mixed $or
     * @return
     */
    public function GetTable($table,$where = null,$or = null)
    {
        $this->buildWhere($where,$or);
            
        return $this->RunQuery($table);
    }
    
    /**
     * MY_Model::GetTableLimit()
     * 
     * @param mixed $table
     * @param mixed $limit
     * @param mixed $where
     * @param mixed $or
     * @return
     */
    public function GetTableLimit($table,$limit,$where = null,$or = null)
    {
        $this->buildWhere($where,$or);
        
        if(is_array($limit))
        {
           $this->db->limit($limit[0], $limit[1]); 
        }
        else
            $this->db->limit($limit);
       
       return $this->RunQuery($table); 
    }
    
    /**
     * MY_Model::RunQuery()
     * 
     * @param mixed $table
     * @return
     */
    private function RunQuery($table)
    {
         $query = $this->db->get($table);
        
        //$this->PrintQuery();
        return $query->result_array();       
    }
    
    /**
     * MY_Model::PrintQuery()
     * 
     * @return
     */
    public function PrintQuery()
    {
        echo $this->db->last_query();
    }
    
    /**
     * MY_Model::buildWhere()
     * 
     * @param mixed $where
     * @param mixed $or
     * @return
     */
    private function buildWhere($where,$or = null)
    {
        if($where != null && is_array($where))
        {
            foreach($where as $key => $value)
                $this->db->where($key,$value);
        }
        
        if($or != null)
        {
            foreach($or as $key => $value)
                $this->db->or_where($key,$value);
        }       
    }
    
    /**
     * MY_Model::GetId()
     * 
     * @return
     */
    protected function GetId()
    {
        if($this->db->affected_rows() == 1)
        {
            return $this->db->insert_id();
        }
        else
            return false;      
    }
    
    /**
     * MY_Model::logData()
     * 
     * @param mixed $data
     * @param mixed $error
     * @return
     */
    public function logData($data,$class)
    {
        if(is_array($data))
            $data = json_encode($data);
            
        $insertData['data'] = $data;
        $insertData['class'] = $class;
        $this->db->insert('logs',$insertData);
    }
    
        
    /**
     * MY_Model::insertData()
     * 
     * @param mixed $table
     * @param mixed $data
     * @return
     */
    public function insertData($table,$data)
    {
        $this->db->insert($table, $data);
        return $this->GetId();  
    }
    
    /**
     * MY_Model::getuserConfirmation()
     * 
     * @param mixed $where
     * @return
     */
    public function getuserConfirmation($where)
    {
        return $this->GetTable('emailconfirmation',$where);
    }
    
    public function record_count($table) 
    {
        return $this->db->count_all($table);
    }
    
    public function get_enum_values( $table, $field )
    {
        $type = $this->db->query( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" )->row( 0 )->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        foreach( explode(',', $matches[1]) as $value )
        {
             $enum[] = trim( $value, "'" );
        }
        return $enum;
    }
}