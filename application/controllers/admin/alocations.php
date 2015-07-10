<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/admin/admin.php';

class Alocations extends Admin 
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model','model');
        $this->mainContent = 'admin/locations';
        $this->title = 'Admin locations';
        $this->baseSeg = 3;
        $this->Init(); 
    }
    
	public function index()
	{
	   
        if ($this->uri->segment($this->baseSeg) === FALSE)
        {
            $this->preRender();
        }
        else
        {
            $func = $this->uri->segment($this->baseSeg);
            $this->$func();
        } 
	}
    
    private function preRender()
    {
        $this->loginRequired = true;
        $this->CheckLogin();
    	$this->render();         
    }
    
    private function Init()
    {
        $this->data['locations'] = $this->model->getLocations();
    }
    
    public function getData()
    {
        $id = (int)$this->input->get('id');
        $data['info'] = $this->model->getLocationData($id);
        
        echo $this->load->view('admin/locationsEdit',$data,true);
    }
    
    public function add()
    {
        $data['name'] = $this->input->post('name',true);
        $data['address'] = $this->input->post('address',true);
        $result = $this->model->addLocation($data);
        if($result != false)
            $this->session->set_userdata('ok',$data['name'] .' has been added'  );
        else
            $this->session->set_userdata('error','An error has occurred ' .$data['name'] .' has not been added'  );
            
        redirect('admin/alocations','refresh');
    }
    
    public function edit()
    {
        $id = (int)$this->input->post('id');
        $data['name'] = $this->input->post('name',true);
        $data['address'] = $this->input->post('address');
        $result = $this->model->updateLocation($id,$data);
        
        if($result != false)
            $this->session->set_userdata('ok',$data['name'] .' has been updated'  );
        else
            $this->session->set_userdata('error','An error has occurred ' .$data['name'] .' has not been updated'  );
        
        redirect('admin/alocations','refresh');
    }
    
    public function delete()
    {
        $id = (int)$this->input->get('id');
        $data['active'] = '0';
        $result = $this->model->updateLocation($id,$data);
        
        if($result != false)
            $this->session->set_userdata('ok',$this->input->get('name') .' has been removed'  );
        else
            $this->session->set_userdata('error','An error has occurred ' .$this->input->get('name') .' has not been removed'  );
        
        redirect('admin/alocations','refresh');
    }
}