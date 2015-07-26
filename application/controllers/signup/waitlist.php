<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/signup/basesignup.php';

/**
 * Waitlist
 *
 * @package
 * @author Lab admin
 * @copyright craig poole
 * @version 2013
 * @access public
 */
class Waitlist extends Basesignup
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('signup/waitlistmodel','model');
        $this->data['labs'] = $this->model->GetAllLabs();
        $this->mainContent = 'forms/waitlist';
        $this->title = 'Waiting list';
        $this->data['techs'] = $this->model->GetTable('techs');
        $this->data['schools'] = $this->model->GetTable('schoollevel');
        $this->data['conditions'] = $this->model->GetTable('conditions');
        $this->baseSeg = 3;
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
    	$this->render();
    }

    public function getChildForm()
    {
        $this->data['count'] = $this->input->get('count');
        echo $this->load->view('forms/waitlistdata',$this->data,true);
    }

    public function signup()
    {
        $this->load->model('signup/waitlistmodel','model');
        if($this->validateStudent())
        {
            $returnData = $this->createBaseUser();

            $studentIds = array();

            if($returnData !== false)
            {
                $count = (int)$this->input->post('totalChildCount');


                for($cnt = 0; $cnt <= $count; $cnt++)
                {
                    $s = $this->createStudent($returnData,$cnt);
                    $this->AddToWaitList($returnData,$s);
                    $studentIds[] = $s;
                }

                foreach($studentIds as $student)
                    $this->addContacts($student);

                $this->confirmSignup($returnData,'/signup/waitlist/confirm','emailTemplate/waitlistConfirmation');

                /*
                if(!$this->isLoggedin())
                    $this->sendConfirmation('/signup/waitlist/confirm','emailTemplate/waitlistConfirmation',$returnData);

                if(!$this->isLoggedin())
                    $this->session->set_userdata('ok', 'Sign up completed.<br/>An email has been sent to ' .$returnData['email'] . '.<br/>Please click the link in the email to confirm your details' );
                else
                    $this->session->set_userdata('ok', 'Sign up completed.' );
                */


                $this->data['hTitle'] = 'Waiting list';

                if(!$this->isLoggedin())
               {
                    $this->mainContent = 'confirmations/confirmation';
                    $this->preRender();
               }
               else
                    redirect(site_url().'/user/profile', 'refresh');
            }
        }
        else
        {
            $this->preRender();
        }
    }

    public function confirm()
    {
        $data['a'] = $this->input->get('a');
        $data['b'] = $this->input->get('b');
        $this->confirmUser($data);
    }

    private function validateStudent()
    {
        $count = (int)$this->input->post('totalChildCount');
        $this->load->library('form_validation');

        for($cnt = 0; $cnt <= $count; $cnt++)
        {
            $this->form_validation->set_rules('name'.$cnt, '<b>Name</b>', 'required|xss_clean');
            $this->form_validation->set_rules('age'.$cnt, '<b>Age</b>', 'required|xss_clean');

             foreach($this->data['techs'] as $tech)
                $this->form_validation->set_rules('exp'.$tech['name'].$cnt, '<b>'.$tech['desc'].'</b>', 'required|xss_clean');

            foreach($this->data['techs'] as $tech)
                $this->form_validation->set_rules('intrest'.$tech['name'].$cnt, '<b>'.$tech['desc'].'</b>', 'required|xss_clean');
        }


        return $this->form_validation->run();
    }


    private function createStudent($returnData,$count)
    {
        $studentDataId = $this->createStudentData($count);
        $studentId = $this->getChildData('name'. $count,'age'.$count,$returnData['id']);

        $this->addDataToStudent($studentId,$studentDataId);

        $this->addData($studentDataId,'schools','schoolLevel'.$count,'studentschool'.$count);
        $this->addData($studentDataId,'conditions','condition'.$count,'studentconditions'.$count);
        $this->addExperience($studentDataId,'exp','studentexperience',$count);
        $this->addExperience($studentDataId,'intrest','studentintrest',$count);

        return $studentId;
    }

   /*private function addStudentData($returnData)
    {
        $techs = $this->model->GetTable('techs');
        $studentDataId = $this->createStudentData();

        $this->addDataToStudent($returnData['studentId'][0],$studentDataId);

        $this->addData($studentDataId,'schools','schoolLevel','studentSchool');
        $this->addData($studentDataId,'conditions','condition','studentConditions');
        $this->addExperience($studentDataId,'exp','studentExperience');
        $this->addExperience($studentDataId,'intrest','studentIntrest');
    }*/

    private function addDataToStudent($student,$dataId)
    {
        $data['studentData'] = $dataId;
        $this->model->updateStudent($student,$data);
    }

    private function addExperience($sdId,$type,$table,$count)
    {
        foreach($this->data['techs'] as $tech)
        {
            $data['studentData'] = $sdId;
            $data['tech'] = $tech['id'];
            $data['level'] = $this->input->post($type.$tech['name'].$count);
            $this->model->addDataStudent($data,$table);
        }
    }

    private function addData($sdId,$type,$value,$table,$other = null,$otherText = null)
    {
        foreach($this->data[$type] as $d)
        {
            if(isset($_POST[$d['name']]))
            {
                $data['studentData'] = $sdId;
                $data[$value] = $d['id'];

                if($other != null && $otherText != null)
                    $data[$otherText] = $other;

                $this->model->addDataStudent($data,$table);
            }
        }
    }

    private function createStudentData($count = 0)
    {
        $data['daysAtSchool'] = $this->input->post('days'.$count);
        $data['schoolOther'] = $this->input->post('otherText'.$count,TRUE);
        $data['conditionOther'] = $this->input->post('otherConditionText'.$count,TRUE);
        $data['lapTop'] = $this->input->post('pc'.$count);
        $data['sessionType'] = $this->input->post('interested'.$count);
        $data['otherInfo'] = $this->input->post('text'.$count,TRUE);
        $data['sessionOther'] = $this->input->post('otherintrestText'.$count,TRUE);

        return $this->model->createStudentData($data);
    }

    private function AddToWaitList($returnData,$sid)
    {
        $data['student'] = $sid;
        $data['location'] = $returnData['location'];
        $this->model->addToWaitList($data);
    }

    private function addContacts($sid)
    {
        $count = (int)$this->input->post('contactCount');

        for($cnt = 0; $cnt < $count; $cnt++)
        {
            $data['name'] = $this->input->post('cName'.($cnt + 1),TRUE);
            $data['phone'] = $this->input->post('cPhone'.($cnt + 1),TRUE);

            $conData['student'] = $sid;
            $conData['contact'] = $this->model->addContactData($data);
            $this->model->addStudentContact($conData);
        }
    }
}
