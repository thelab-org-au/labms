<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/signup/basesignup.php';

class Mentor extends Basesignup
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('signup/mentormodel','model');
        $this->data['labs'] = $this->model->GetAllLabs();
        $this->data['techs'] = $this->model->GetTable('techs');
        $this->data['mentorForm'] = true;
        $this->mainContent = 'forms/mentorform';
        $this->title = 'Mentor signup';
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

    public function signup()
    {
        $this->load->model('signup/mentormodel','model');
        if($this->validateMentor())
        {
            $returnData = $this->createBaseUser(false);

            if($returnData !== false)
            {
                $returnData['mentorId'] = $this->addMentorDetails($returnData);
                $this->addApplication($returnData);

                $succsess = true;

                if (!empty($_FILES['userfile']['name']))
                {
                    $path = $_FILES['userfile']['name'];
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $name = $this->input->post('fname').'_'.$this->input->post('lname').'_'.$returnData['id'];
                    $succsess = $this->do_upload($name);

                    $fileData = $this->upload->data();
                    $updateData['origFileName'] = $fileData['client_name'];
                    $updateData['fileName'] = $fileData['orig_name'];

                    $this->model->updateMentor($returnData['mentorId'],$updateData);
                }


                if($succsess === true)
                {
                    //$this->confirmSignup($returnData,'/signup/waitlist/confirm','emailTemplate/mentor');
                    if(!$this->isLoggedin())
                        $this->sendConfirmation('/signup/waitlist/confirm','emailtemplate/mentor',$returnData);

                    $this->data['hTitle'] = 'Mentor job application';

                    if(!$this->isLoggedin())
                        $this->session->set_userdata('ok', 'Sign up completed.<br/>An email has been sent to ' .$returnData['email'] . '.<br/>Please click the link in the email to confirm your details' );
                    else
                        $this->session->set_userdata('ok', 'Sign up completed.' );


                   if(!$this->isLoggedin())
                   {
                        $this->mainContent = 'confirmations/confirmation';
                         $this->preRender();
                   }
                   else
                        redirect(site_url().'/user/profile', 'refresh');
                }
                else
                {
                    $this->data['error'] = $succsess;
                    $this->preRender();
                }
            }
        }
        else
        {
            $this->preRender();
        }
    }

    private function validateMentor()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('state', '<b>State</b>', 'trim|required|xss_clean');
        $this->form_validation->set_rules('education', '<b>Educational History</b>', 'trim|required|xss_clean');
        $this->form_validation->set_rules('crime', '<b>Criminal convictions</b>', 'required');
        $this->form_validation->set_rules('crimeDetails', '<b>Conviction details</b>', 'trim|xss_clean');
        $this->form_validation->set_rules('workChild', '<b>Working with Children Check</b>', 'required');

        foreach($this->data['techs'] as $tech)
            $this->form_validation->set_rules('expTech'.$tech['name'], '<b>'.$tech['desc'].'</b>', 'required|xss_clean');

        $this->form_validation->set_rules('otherSkills', '<b>Other skills</b>', 'trim|xss_clean');
        $this->form_validation->set_rules('references', '<b>References </b>', 'trim|required|xss_clean');
        $this->form_validation->set_rules('workExperience', '<b>Work Experience </b>', 'trim|required|xss_clean');
        $this->form_validation->set_rules('contactEmployer', '<b>Contact employer</b>', 'required');
        $this->form_validation->set_rules('addInfo', '<b>Additional Information</b>', 'trim|xss_clean');

        return $this->form_validation->run();
    }

    private function addMentorDetails($returnData)
    {
         $data['user'] = $returnData['id'];
         $data['dob'] = $this->input->post('age1');
         $data['state'] = $this->input->post('state',true);
         $data['education'] = $this->input->post('education');
         $data['conviction'] = $this->input->post('crime',true);
         $data['convictionDetails'] = $this->input->post('crimeDetails');
         $data['childrenCheck'] = $this->input->post('workChild');
         $data['workingWithChild'] = $this->input->post('childExperience',true);
         $data['otherSkills'] = $this->input->post('otherSkills',true);
         $data['references'] = $this->input->post('references',true);
         $data['workExp'] = $this->input->post('workExperience',true);
         $data['contactEmployer'] = $this->input->post('contactEmployer');
         $data['addInfo'] = $this->input->post('addInfo',true);

        $mentorId = $this->model->addMentor($data);
        $this->addExperience($mentorId);

        return $mentorId;
    }

    private function addExperience($mentorId)
    {
        foreach($this->data['techs'] as $tech)
        {
            $data['mentor'] = $mentorId;
            $data['tech'] = $tech['id'];
            $data['level'] = $this->input->post('expTech'.$tech['name']);
            $this->model->addMentorExp($data);
        }
    }

    private function addApplication($returnData)
    {
        $data['mentor'] = $returnData['mentorId'];
        $data['location'] = $this->input->post('lab');
        $this->model->addApplication($data);
    }

	/*private function do_upload($fileName)
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'pdf|doc|docx|txt|odt';
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
            return true;
		}
	} */
}
