<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once APPPATH.'controllers/signup/basesignup.php';

class Attendance extends MY_Controller 
{
    public $termModel;
    function __construct()
    {
        parent::__construct();
        $this->load->model('attendancemodel','model');
        $this->mainContent = 'attendance/attendance';
        $this->title = 'Attendance';
        $this->load->model('term_model','termModel');
        $this->setLabs();
        
        
        //$this->data['labInfo'] = $this->getSessionData();
        $this->baseSeg = 2;    
    }
    
    private function setLabs()
    {
        $this->loginRequired = true;
        $this->CheckLogin();
        
        $user = $this->session->userdata('user'); 
        $loc = array();
        
        
        foreach($user['locations'] as $location)
            $loc[] = $location['location'];
            
        
        if($user['type'] == '2')
        {  
            foreach($this->model->getMentorLocations($user['id']) as $location)
            {
                if(!in_array($location['location'],$loc))
                    $loc[] = $location['location'];
            }
        }
       if ($user['type'] == '5' )
           $loc = $this->model->getLocationIds();
       
        $temp = array();
        $labIds = array();
        foreach($this->getSessionData() as $lab)
        {
            if(in_array($lab['id'],$loc))
            {
                $temp[] = $lab;
                $labIds[] = $lab['id'];
            }
                
        }
        $this->data['labInfo'] = $temp;
        $this->data['labIDs'] = $labIds;
    }
    
	public function index()
	{
	   /*	   
         if ($this->uri->segment($this->baseSeg) === FALSE)
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
    
    private function preRender()
    {
        //var_dump($this->termModel->getSessions(1));
        $this->loginRequired = true;
        $this->CheckLogin();
    	$this->render();         
    }
    
    public function process()
    {
        $session = (int)$this->input->post('sess');
        $ids = explode('-',$this->input->post('ids'));
        foreach($ids as $id)
        {
            $data['present'] = false;
            if(array_key_exists($id,$_POST))
                $data['present'] = true;
                
            $sessid = $this->model->getStudentSession($id,$session);
            
            $data['studentSession'] = $sessid[0]['id'];
            $data['date'] = date("d-m-Y");
            
            $rowCheck = $this->model->getAttendance($sessid[0]['id'],date("d-m-Y"));
            
            if(sizeof($rowCheck) == 0)
                $this->model->addAttendance($data);
            else
                $this->model->updateAttendance($rowCheck[0]['id'],array('present' =>$data['present']));
            
            $this->session->set_userdata('ok', 'Attendance has been recorded' );
        }
        $this->data['sessionInfo'] = $this->model->getSessionInfo($session);
        
        //var_dump($this->data['sessionInfo'][0]);
        //return;
        
        $this->data['selectedSession'] = $this->getLabSessions($this->data['sessionInfo'][0]['location'],$session);
        //$this->preRender();
        redirect('attendance');
    }
    
    public function GetStudentData()
    {
        
        $start = (int)$this->input->get('start');
        $lab = (int)$this->input->get('session');
        $page = (int)$this->input->get('page');
        
        $data['att'] = $this->getSessionStudentData($lab,1,$start);
        
        $data['sess'] = $lab;
        $data['termLength'] = $this->termModel->getTermBySession($lab);
        if($this->input->get('dpage'))
            $data['dpage'] = (int)$this->input->get('dpage');
        else
            $data['dpage'] = '1';
        
               
        //$data['preStudents'] = $this->getSessionStudentData($lab,0);

        $count = sizeof($this->getSessionStudentData($lab,1,null));
        
        $data['paginationData']['draw'] = ($count > PAG_LIMIT);
        $data['paginationData']['count'] = ($count / PAG_LIMIT);
        $data['paginationData']['current'] = $start;
        $data['paginationData']['function'] = 'pagination';
        
        $active['active'] = $this->load->view('attendance/table',$data,true);
        
        if($page !== 'true')
            $active['deactive'] = $this->getDeactiveStudents(true,true);
            
            
        echo json_encode($active);
    }
    
    public function getDeactiveStudents($return = false, $start = false)
    {
        if(!$start)
            $start = (int)$this->input->get('start');
        else if ($this->input->get('dpage'))
            $start = $this->input->get('dpage');
        else
            $start = 1; 
            
        $lab = (int)$this->input->get('session');
        
        //echo $lab;
 
        
        $data['sess'] = $lab;
        
        $data['preStudents'] = $this->getSessionStudentData($lab,0,$start);

        $count = sizeof($this->getSessionStudentData($lab,0,null));
        
        $data['paginationData']['draw'] = ($count > PAG_LIMIT);
        
        $data['paginationData']['count'] = ($count / PAG_LIMIT);
        $data['paginationData']['current'] = $start;
        $data['paginationData']['function'] = 'paginationDeactive';
        
        $active['deactive'] = $this->load->view('attendance/deactive',$data,true);
        
        if($return)
            return $active['deactive'];
        else
            echo json_encode($active) ;        
    }
    
    private function getSessionStudentData($session,$active = 1,$start = null)
    {
        $students = $this->model->getSessionStudents($session,$active,$start);
        $data = $this->getStudents($students);
        return $data;
    }
    
    private function getStudents($students)
    {
        $data = array();
        
        $cnt = 0;
        foreach($students as $student)
        {

            $temp = $this->model->getStudentInfo($student['student']);
            $temp['attendance'] = $this->model->getAttendance($student['id']);
            $data[$cnt] = $temp;
            
            $cnt++;
        }
        return $data;
    }

    private function getSessionData()
    {
        
       $labs =  $this->model->getAllLabs();
       $sessions = $this->model->getAllSessions();

       for($cnt = 0; $cnt < sizeof($labs); $cnt++)
       {
            $tmp = $this->termModel->getSessions($labs[$cnt]['id']);
            
            //if($cnt == 0)
                //var_dump($tmp);
            
            foreach($sessions as $session)
            {
                if($session['location'] == $labs[$cnt]['id'])
                {
                    $labs[$cnt]['sessions'][] = $session;
                }
                    
            }                
       }
       
       return $labs;
    }
    
    public function getLabSessions($id = null,$pre = null)
    {
        if($id == null)
        $id = (int)$this->input->get('id');
       $terms = $this->termModel->getTerms($id);
       $sessions = $this->termModel->getSessions($id);
       
       $currentDate = date_create_from_format('d/m/Y',date('d/m/Y'));
       
        if(count($terms) == 0)
       {
            echo '&nbsp;&nbsp;No sessions found';  
            return; 
       }
        $output = '&nbsp;<select name="lab'.$id.'" class="err" id="labSession" onchange="getStudentData()">';
        $output .= '<option value="-1">-Select Session-</option>';
       
       $sessionFound = false;     
       foreach($terms as $term)
       {
            $startDate = date_create_from_format('d/m/Y', $term['startDate']);
            $endDate = date_create_from_format('d/m/Y', $term['endDate']);
            
           if($startDate <= $currentDate && $endDate >= $currentDate)
           {
                $sessionFound = true;
                $session = $this->termModel->getSessionById($term['session']);
                $session = $session[0];
                
                $select = '';
                if($pre == $term['id'])
                 $select = 'selected="selected"';
                 
                $output .= '<option value="'.$term['id'].'"' . $select .'>'.$session['day'] . ' '. $session['startTime'] . ' - ' . $session['endTime'] .'</option>';
           }
       }
       
       $output .= '</select>';
       
       
       
       if($pre == null)
       {
         if($sessionFound)
            echo $output;
        else
            echo '&nbsp;&nbsp;No sessions found';       
       }
       else
       {
         if($sessionFound)
            echo $output;
        else
            echo  '&nbsp;&nbsp;No sessions found';         
       }

    }    
}