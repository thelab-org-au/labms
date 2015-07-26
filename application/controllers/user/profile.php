<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once APPPATH.'controllers/signup/basesignup.php';

class Profile extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('profile_model', 'model');
        $this->mainContent = 'profile/profile';
        $this->title = 'Profile';
        $this->baseSeg = 3;
    }

  	public function index()
  	{

        if ($this->uri->segment($this->baseSeg) === FALSE)
        {
            $this->data['page'] = 'profile/userInfo';
    		$this->preRender();
        }
        else
        {
            $func = $this->uri->segment($this->baseSeg);
            $this->$func();
        }
  	}

    private function init()
    {
        $id = $this->getUserId();

        if($this->data['page'] == 'profile/userInfo')
        {
            $userData = $this->model->getUserData($id);
            $this->data['userType'] = $userData[0]['userType'];
            $this->data['userData'] = $userData[0];
        }
        else if($this->data['page'] == 'profile/childInfo')
        {
            $this->getStudentData($id);
        }
        else if($this->data['page'] == 'profile/waitinglist')
        {
            $this->data['studentData'] = $this->model->getWaitlistData($id);
        }
        else if($this->data['page'] == 'profile/mailout')
        {
            $this->data['studentData'] = $this->model->getMaillistData($id);
        }
        else if($this->data['page'] == 'profile/mentorInfo')
        {
            $this->data['mentorData'] = $this->model->getMentorData($id);
            $this->data['techs'] = $this->model->GetTable('techs');
            if(count($this->data['mentorData']) > 0)
            {
                $this->data['mentorData'] = $this->data['mentorData'][0];


                foreach($this->model->getMentorExp($this->data['mentorData']['id']) as $exp)
                    $this->data['mentorData']['exp'][$exp['tech']] = $exp['level'];


            }
        }
        else if($this->data['page'] == 'profile/paymentInfo')
        {

        }


        $this->data['mentor'] = false;
        $this->data['parent'] = true;

    }

    private function getStudentData($id)
    {
        $this->data['studentData'] = $this->model->getStudentData($id);

        $this->data['parent'] = false;
        for($cnt = 0; $cnt < count ($this->data['studentData']); $cnt++)
        {
            $temp = array();
            $temp = $this->model->getStudentSchool($this->data['studentData'][$cnt]['studentData']);

            foreach($temp as $t)
                $this->data['studentData'][$cnt]['schoolData'][] = $t['schoolLevel'];


            $temp = $this->model->getStudentCondition($this->data['studentData'][$cnt]['studentData']);
            foreach($temp as $t)
                $this->data['studentData'][$cnt]['conditionData'][] = $t['condition'];


            $temp = $this->model->getStudentExperience($this->data['studentData'][$cnt]['studentData']);

            foreach($temp as $t)
                $this->data['studentData'][$cnt]['studentExp'][$t['tech']] = $t['level'];

            $temp = $this->model->getStudentInterest($this->data['studentData'][$cnt]['studentData']);

            foreach($temp as $t)
                $this->data['studentData'][$cnt]['studentInterest'][$t['tech']] = $t['level'];

            $this->data['parent'] = true;
        }


    }

    private function preRender()
    {
  	    $this->loginRequired = true;
        $this->CheckLogin();
        $this->init();
    		$this->render();
    }

    public function loadPage($page = null)
    {
        if($page == null) $page = $this->input->get('page',true);
        switch($page)
        {
            case 'child':
                $this->data['page'] = 'profile/childInfo';
                $this->data['schools'] = $this->model->GetTable('schoollevel');
                $this->data['conditions'] = $this->model->GetTable('conditions');
                $this->data['techs'] = $this->model->GetTable('techs');
                break;
            case 'waiting':
                $this->data['page'] = 'profile/waitinglist';
                break;
            case 'mail':
                $this->data['page'] = 'profile/mailout';
                break;
            case 'payment':
                $this->data['page'] = 'profile/paymentInfo';
                break;
            case 'mentor':
                $this->data['page'] = 'profile/mentorInfo';
                break;
            default:
                $this->data['page'] = 'profile/userInfo';
                break;
        }

        $this->preRender();
    }

    public function updateUser()
    {
        $id = (int)$this->input->post('userId');
        $data['email'] = $this->input->post('email',true);
        $data['firstName'] = $this->input->post('fname',true);
        $data['lastName'] = $this->input->post('lname',true);
        $data['phone'] = $this->input->post('phone',true);
        $data['address'] = $this->input->post('address',true);
        $data['suburb'] = $this->input->post('suburb',true);
        $data['postcode'] = $this->input->post('postcode',true);

        $pass = $this->input->post('pass',true);
        $passCon = $this->input->post('passCon',true);

        if($pass != '' && $pass == $passCon)
        {
            $this->load->library('encrypt');
            $data['password'] =  $this->encrypt->encode($pass);
        }

        if($this->model->updateUser($id,$data) == 1)
        {
            $this->session->set_userdata('ok', 'Your information has been updated' );
        }
        else
            $this->data['error'] = 'An error has occured your information has not been updated';

        $this->data['page'] = 'profile/userInfo';
        $this->preRender();
    }

    public function studentUpdate()
    {
        return;
        $id = (int)$this->input->post('id',true);
        $studentDataId = (int)$this->input->post('studentData',true);

        $data = array(
            'name' => $this->input->post('name',true),
            'dob' => $this->input->post('age',true)
        );

        $this->model->updateTable($id,$data,'student');

        $data = array(
            'daysAtSchool' => $this->input->post('days',true),
            'schoolOther' => $this->input->post('otherText',true),
            'conditionOther' => $this->input->post('otherConditionText',true),
            'lapTop' => $this->input->post('pc',true),
            'sessionType' => $this->input->post('socialInterest',true),
            'otherInfo' => $this->input->post('text',true),
            'sessionOther' => $this->input->post('otherintrestText',true)
        );

        $this->model->updateTable($studentDataId,$data,'studentdata');

        $this->model->deleteTable('studentschool',$studentDataId);
        foreach($this->input->post('school') as $school)
            $this->model->addStudentSchool(array('studentData' => $studentDataId, 'schoolLevel' => $school));


        $this->model->deleteTable('studentconditions',$studentDataId);
        foreach($this->input->post('conditions') as $condition)
            $this->model->addStudentCondition(array('studentData' => $studentDataId, 'condition' => $condition));

        $this->model->deleteTable('studentintrest',$studentDataId);
        $this->model->deleteTable('studentexperience',$studentDataId);

        foreach($this->input->post() as $key => $value)
        {
            if(strpos($key, 'intrest') === 0)
            {
                $this->model->addStudentInterest(array
                                                (
                                                    'studentData' => $studentDataId,
                                                    'tech' => substr($key,7),
                                                    'level' => $value)
                                                );
            }
            else if(strpos($key, 'exp') === 0)
            {
                $this->model->addStudentExperience(array
                                                (
                                                    'studentData' => $studentDataId,
                                                    'tech' => substr($key,3),
                                                    'level' => $value)
                                                );
            }
        }

        $this->loadPage('child');
    }

    public function mailRemove()
    {
        $id = (int)$this->input->get('id',true);
        $this->model->removeMail($id);
        $this->data['page'] = 'profile/mailout';
        $this->preRender();
    }

    public function mentorUpdate()
    {
        $id = (int)$this->input->post('id',true);

        $data = array
        (
            'education' => $this->input->post('education',true),
            'conviction' => $this->input->post('crime',true),
            'convictionDetails' => $this->input->post('crimeDetails',true),
            'childrenCheck' => $this->input->post('workChild',true),
            'workingWithChild' => $this->input->post('childExperience',true),
            'otherSkills' => $this->input->post('otherSkills',true),
            'references' => $this->input->post('references',true),
            'workExp' => $this->input->post('workExperience',true),
            'contactEmployer' => $this->input->post('contactEmployer',true),
            'addInfo' => $this->input->post('addInfo',true),
        );

        if (!empty($_FILES['userfile']['name']))
        {
            $currentFile = $this->input->post('currentFile',true);

            if(file_exists('uploads/'.$currentFile))
                unlink('uploads/'.$currentFile);

            $path = $_FILES['userfile']['name'];
            $succsess = $this->do_upload($id);

            $fileData = $this->upload->data();
            $data['origFileName'] = $fileData['client_name'];
            $data['fileName'] = $fileData['orig_name'];
        }

        $this->model->updateTable($id,$data,'mentor');

        $this->model->deleteMentorTable('mentorexperience',$id);

        foreach($this->input->post() as $key => $value)
        {
            if(strpos($key, 'Tech') === 0)
            {
                $this->model->addMentorExperience(array
                                                (
                                                    'mentor' => $id,
                                                    'tech' => substr($key,4),
                                                    'level' => $value)
                                                );
            }
        }

        $this->data['page'] = 'profile/mentorInfo';
        $this->preRender();
    }
}
