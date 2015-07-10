<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends MY_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('test_model','model');

    }
    
    public function index()
    {

        $this->load->view('test',$this->data);
    }
    
    function upload()
    {
        if (!empty($_FILES['userfile']['name'])) 
        {
            $this->do_upload('test.pdf');
        }
    }
    
	private function do_upload($fileName)
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'pdf|doc|docx|txt';
        $config['file_name'] = $fileName;
		$config['max_size']	= '2048';
        $config['max_filename']	= '30';
        $config['remove_spaces'] = true;


		$this->load->library('upload', $config);

		if (!$this->upload->do_upload())
		{
            return $this->upload->display_errors();
		}
		else
		{
		  var_dump($this->upload->data());
            return true;
		}
	}
}