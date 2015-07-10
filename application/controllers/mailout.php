<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/admin/admin.php';

class Mailout extends MY_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('mailout_model','model');
        $this->mainContent = 'mailout/mailoutCreate';
        $this->title = 'Mailout';
        $this->baseSeg = 2;
    }
    
	public function index()
	{
        /* if ($this->uri->segment($this->baseSeg) === FALSE)

        {

            $this->preRender();

        }

        else

        {

            $func = $this->uri->segment($this->baseSeg);

            $this->$func();

        } 

        */
        $this->preRender();
	}


    private function init()
    {
        $temp = $this->session->userdata('user');
        $userLocations = $this->model->getUserLocations();
        if((int)$temp['type'] > 4)
        {
        $this->data['locations'] = $this->model->getLocations();
        }
        else
        {
            foreach($this->model->getUserLocations() as $location)
                $temp2[] = $this->model->getLocations($location['location']);
        
            $this->data['locations'] = $temp2;
        }  
           
        foreach($temp['locations'] as $loc)
            $this->data['userLocations'][] = $loc['location'];

        $this->data['users'] = $this->model->getAllUsers($temp['type']);
        
        for($cnt = 0; $cnt < count($this->data['users']); $cnt++)
        {
            $temp = $this->model->getUserLocationsById($this->data['users'][$cnt]['id']);
            $t = '';
            for($cnt2 = 0; $cnt2 < count($temp); $cnt2++)

                $t .= $temp[$cnt2]['location'] . ',';

            $t = substr($t, 0, -1);
           $this->data['users'][$cnt]['locations'] = $t;
        }
    }

    private function preRender()
    {
        $this->init();
        $this->loginRequired = true;
        $this->CheckLogin();
    	$this->render();         
    }

    public function sendMailout()
    {
        
        if(!$this->validate())
        {
            echo validation_errors(); 
            return;    
        }
        
        $data['date'] = date("d-m-Y");
        $data['desc'] = $this->input->post('mailoutDesc',true);
        $data['content'] = $this->input->post('mailoutContent');
        $this->model->storeMailout($data);
      
        $users = array();
        
        $ids = explode(',',$this->input->post('ids'));
        
        foreach($ids as $user)
        {
            if($user != '')
                $users[] = $this->model->getUserEmail($user); 
        }

        $labs = explode(',',$this->input->post('labs'));
        $maillist = $this->input->post('maillist');

        if($maillist == 'true')
        {

            $temp = $this->model->getMaillistUsers($labs);

            $temp2 = array();
            foreach($temp as $t)
            {
                if(!in_array($t['user'], $ids))
                    $temp2[] = $t['user'];
            }
            if(count($temp2) > 0)
            {
                foreach($temp2 as $user)
                    $users[] = $this->model->getUserEmail($user); 
            }
        }
        
        foreach($this->input->post() as $key => $value)
        {
            if (strpos($key,'user') !== false)
                $users[] = $this->model->getUserEmail($value);
        }
        
        if(count($users) == 0)
        {
           echo 'No recipients selected';
           return; 
        }
            
        $data['email'] = 'craig@oztron.com';
        $view = $this->load->view('mailout/mailoutTemplate.php',$data,true);
        
        $errors = array();
        foreach($users as $email)
        {
            $data['email'] = $email;
            $view = $this->load->view('mailout/mailoutTemplate.php',$data,true);
            if(!$this->SendEmail($data['desc'],$view,$email))
            {
                $errors[] = $email;
            }
        }
        
        //$this->SendEmail($data['desc'],$view,'craig@oztron.com');
    }
    
    protected function validate()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('mailoutDesc', 'Description', 'trim|required|xss_clean');
        $this->form_validation->set_rules('mailoutContent', 'Mailout content', 'trim|required|xss_clean');
        
        return $this->form_validation->run();        
    }
    
    public function getUsers()
    {
        //echo $this->input->get('ids');
        $ids = explode(",", $this->input->get('ids'));
        
        $all = $this->input->get('all');
        
        if(count($ids) == 0 && $all == null)
        {
            echo '';
            return;
        }
        
        if($all != null)
        {
            $this->init();
            $view = $this->load->view('mailout/users',$this->data,true);
            echo $view;
            return;
        }
            
        $temp = $this->session->userdata('user');
        
        $data['users'] = $this->model->getUsersByLocation($ids,$temp['type']);
        

        if( $data['users'] == null)
        {
            echo '';
            return;
        }
            
        //var_dump($ids);
        //return;
         for($cnt = 0; $cnt < count($data['users']); $cnt++)
        {
            $temp = $this->model->getUserLocationsById($data['users'][$cnt]['id']);
            $t = '';
            for($cnt2 = 0; $cnt2 < count($temp); $cnt2++)

                $t .= $temp[$cnt2]['location'] . ',';

            $t = substr($t, 0, -1);
           $data['users'][$cnt]['locations'] = $t;
        }  
        
        //var_dump($data);     
        $view = $this->load->view('mailout/users',$data,true);
        echo $view;
    }
    
    public function preview()
    {
        $data['desc'] = $this->input->post('mailoutDesc',true);
        $data['content'] = $this->input->post('mailoutContent'); 
        echo $this->load->view('mailout/mailoutTemplate.php',$data,true);       
    }
    
    public function unsubscribe()
    {
        $id = $this->model->getUserLocationsByEmail($this->input->get('id'));
        
        $data['output'] = '<form action="'.site_url().'/mailout/confirm" method="post">
                            <input type="hidden" name="id" value="'.$id.'" />
                    <table>
                    <tr>
                        <td>
                            <div>
                                <p>Are you sure you want to unsubscribe from the lab mailing list?</p>
                            </div>
                        </td>
                    </tr>
                    <tr><td><br /></td></tr>
                    <tr>
                        <td>
                            <button>Unsubscribe</button>
                        </td>
                    </tr>
                    </table>
				</form>';
        
        $this->load->view('mailout/unsubscribe',$data);
    }
    
    public function confirm()
    {
        $data['output'] = '<table style="width:100%; text-align: center;"><tr><td>You have been unsubscribed <br/>Thank you.</td></tr></table>';
        echo $this->model->removeUser((int)$this->input->post('id'));
        $this->load->view('mailout/unsubscribe',$data);
    }

}