<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trainingmodel extends MY_Model
{   

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function addTraningContent($data)
    {
        $this->insertData('training',$data);
    }
    
    public function getTrainingInfo()
    {
        $this->db->select('id,desc');
        return $this->db->get('training')->result_array();
    }
    
    public function getTrainingContent($id)
    {
        $this->db->select('content');
        $this->db->where('id',$id);
        return $this->db->get('training')->result_array();        
    }
}