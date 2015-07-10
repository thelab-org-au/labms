<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/admin/admin.php';

class Astudents extends Admin 
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model','model');
        $this->mainContent = 'admin/student/students';
        $this->title = 'Admin students';
        $this->baseSeg = 3; 
        $this->init();
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
    
    private function init($where = null,$like = null)
    {
        $this->data['locations'] = $this->model->getLocations();
        $this->data['students'] = $this->model->getStudents('1','0',$where,$like,false);
        $this->data['nonstudents'] = $this->model->getStudents('0','0',$where,$like,false);
        
        
        //($active = '1',$start = '0',$where = null,$like = null,$limit = false)
        
        $count = sizeof($this->model->getStudents('1','0',$where,$like,false));
        $start = 1;
        
        $this->data['paginationData']['draw'] = false;// ($count > PAG_LIMIT);
        $this->data['paginationData']['count'] = ($count / PAG_LIMIT);
        $this->data['paginationData']['current'] = $start;
        $this->data['paginationData']['function'] = 'pagination';
        
        $this->data['active'] =  $this->load->view('admin/student/view',$this->data,true);
        
        if($count == 0)
            $this->data['active'] = '';
        
        
        $count = sizeof($this->model->getStudents('0','0',$where,$like,false));
        $start = 1;
        
        $this->data['paginationData']['draw'] = false;// ($count > PAG_LIMIT);
        $this->data['paginationData']['count'] = ($count / PAG_LIMIT);
        $this->data['paginationData']['current'] = $start;
        $this->data['paginationData']['function'] = 'pagination';        
        
        $this->data['deactive'] = $this->load->view('admin/student/previous',$this->data,true);
        
        if($count == 0)
            $this->data['deactive'] = '';
    }
    
    private function preRender()
    {
        
        $this->loginRequired = true;
        $this->CheckLogin();
    	$this->render();         
    }
    
    public function editStudentDisplay()
    {
        $this->data['techs'] = $this->model->GetTable('techs');
        $this->data['schools'] = $this->model->GetTable('schoollevel');
        $this->data['conditions'] = $this->model->GetTable('conditions');
        
        $this->mainContent = 'admin/student/edit';
        
        
        $sid = $this->input->get('sid',true);
        
        $student['info'] = $this->model->getStudentDetails($sid);
        
        $student['data'] = null;
        if($student['info']['studentData'] != null)
        {
            $student['data'] = $this->model->getStudentData($student['info']['studentData']);
            $student['schoolLevel'] = $this->model->getStudentSchoolLevel($student['info']['studentData']);
            
            $t = array();
            foreach($this->model->getStudentIntrest($student['info']['studentData']) as $e)
                $t[$e['tech']] = $e['level'];
                
            $student['intrests'] = $t;

            $t = array();
            foreach($this->model->getStudentConditions($student['info']['studentData']) as $c)
                $t[] = $c['condition'];
            $student['conditions'] = $t;
            
            $t = array();
            foreach($this->model->getStudentExperience($student['info']['studentData']) as $e)
                $t[$e['tech']] = $e['level'];
                
            $student['experience'] = $t;

        }
        
        if($student['info']['user'] != null)
        {
           $student['user'] = $this->model->getUsers($student['info']['user']);
           $student['user'] = $student['user'][0]; 
        }
        
       // var_dump($student['user'] );
        
        $this->data['studentId'] = $sid;
        $this->data['studentData'] = $student;

        $this->preRender();
    }
    
    public function updateStudent()
    {
        $uid = $this->input->post('uid',true);
        $this->load->library('encrypt');
        $userdata = array(
                        'userType' => 3,
                        'email' => $this->input->post('email',true),
                        'firstName' => $this->input->post('fname',true),
                        'lastName' => $this->input->post('lname',true),
                        'phone' => $this->input->post('phone',true),
                        'address' => $this->input->post('address',true),
                        'suburb' => $this->input->post('suburb',true),
                        'postcode' => $this->input->post('postcode',true),
                        'password' => $this->encrypt->encode($this->input->post('pass',true)),
                        'active' => 1
                        );
        
        if(!isset($_POST['uid']) && isset($_POST['create']))
        {
            if($this->userValidation())
            {
                $uid = $this->model->createUser($userdata);          
                $this->data['ok'] = 'User created';                
            }
            else
            {
                $_GET['sid'] = $this->input->post('sid');
                $this->editStudentDisplay();
            }
        }
        else if(isset($_POST['uid']))
        {
            unset($userdata['password']);
            unset($userdata['active']);
            unset($userdata['userType']);
            $this->model->updateUser($uid,$userdata);
        }
        
        $did = $this->input->post('did',true);
        
        $data = array(
            'daysAtSchool' => $this->input->post('days',true),
            'schoolOther' => $this->input->post('otherText',true),
            'conditionOther' => $this->input->post('otherConditionText',true),
            'lapTop' => $this->input->post('pc',true),
            'sessionType' => $this->input->post('interested',true),
            'otherInfo' => $this->input->post('text',true),
            'sessionOther' => $this->input->post('otherintrestText',true)
        );
        
        if(!isset($_POST['did']))
        {
            $did = $this->model->studentData($data);
        }
        else
        {
            $this->model->updateStudentData($did,$data);
        }
        
        $sid = $this->input->post('sid',true);
        
        $student = array(
                'name' => $this->input->post('name',true),
                'dob' => $this->input->post('age',true),
                'studentData' => $did,
                'user' => $uid,
                'contact_phone' => $this->input->post('phone',true),
                'contact_email' => $this->input->post('email',true)
        );
        
        $this->model->updateStudent($sid,$student);
        
        
        if(isset($_POST['school']))
        {
            $this->model->deleteTableData('studentschool',$did);
            foreach($this->input->post('school',true) as $school)
            {
                $temp = array('studentData' => $did, 'schoolLevel' => $school);
                $this->model->addTableData('studentschool',$temp);
            }
        }
        
        if(isset($_POST['condition']))
        {
            $this->model->deleteTableData('studentconditions',$did);
            
            foreach($this->input->post('condition',true) as $school)
            {
                $temp = array('studentData' => $did, 'condition' => $school);
                $this->model->addTableData('studentconditions',$temp);
            }
        }
        
        $techs = $this->model->GetTable('techs');
        
        $this->model->deleteTableData('studentexperience',$did);
        
        
        foreach($techs as $t)
        {
            $temp = array('studentData' => $did,'tech' => $t['id'], 'level' => $this->input->post('exp'.$t['id'],true));
            $this->model->addTableData('studentexperience',$temp);
        }

        
        $this->model->deleteTableData('studentintrest',$did);
        
        foreach($techs as $t)
        {
            $temp = array('studentData' => $did,'tech' => $t['id'], 'level' => $this->input->post('intrest'.$t['id'],true));
            $this->model->addTableData('studentintrest',$temp);            
        }
        
        
        $locations = $this->model->getStudentLocations($sid);
        
        foreach($locations as $l)
        {
            if($this->model->checkUserLocation($uid,$l['location']))
                $this->model->addUserLocation($uid,$l['location']);
        }
        

        $_GET['sid'] = $this->input->post('sid');
        $this->session->set_userdata('ok', 'Student updated');
        $this->editStudentDisplay();
    }

    private function userValidation()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'valid_email|trim|required|xss_clean');
        $this->form_validation->set_rules('fname', 'First name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('lname', 'Surname', 'trim|required|xss_clean');
        $this->form_validation->set_rules('postcode', 'Postcode', 'trim|max_length[4]|numeric|xss_clean');      
        $this->form_validation->set_rules('pass', 'Password', 'matches[passCon]|trim|required|min_length[8]|xss_clean');
        $this->form_validation->set_rules('passCon', 'Password confirmation', 'trim|required|xss_clean');
        
        return $this->form_validation->run();        
    }
    
    public function getByLab()
    {
        $lab = (int)$this->input->get('lab');
        $where['session.location'] = $lab;
        $this->init($lab);
        //$this->preRender();
        
        $data['active'] = $this->data['active'];
        $data['deactive'] = $this->data['deactive'];
        echo json_encode($data);
    }
    
    public function getByName()
    {
        $name = $this->input->get('find',true);
        $this->init(null,$name);
        //$this->preRender();
        
        $data['active'] = $this->data['active'];
        $data['deactive'] = $this->data['deactive'];
        echo json_encode($data);        
    } 
    
    public function deactivate()
    {
        echo 'deactivate';
        $id = (int)$this->input->get('id');
        $this->model->deactivateStudent($id);
    }
}

