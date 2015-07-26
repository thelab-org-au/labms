<?php

class Profile extends MY_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('profile_model', 'model');
    $this->mainContent = 'profile/profile';
    $this->title = 'Profile';
    $this->baseSeg = 3;
  }

  private function formFieldInfo($label, $type = 'text') {
    $label = ucfirst($label);
    $name = str_replace(' ', '', ucwords($label));
    $cb = 'get' . $name;
    return array(
      'type' => $type,
      'label' => $label,
      'name' => lcfirst($name),
      'default' => $this->user->$cb(),
    );
  }

	public function index() {
    if ($this->uri->segment($this->baseSeg) === FALSE) {
      $this->updateUser();
    } else {
      $func = $this->uri->segment($this->baseSeg);
      $this->$func();
    }
	}

  private function init() {
      if($this->data['page'] == 'profile/childInfo')
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

  private function preRender() {
    $this->redirectIfNotLoggedIn();
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

  public function updateUser() {

    $this->load->library('form_validation');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'min_length[8]|matches[confirmation]');
    if($this->form_validation->run()) {
      if($this->user->update($this->input->post(null, true))) {
        $this->session->set_userdata('ok', 'Your information has been updated' );
      } else {
        $this->data['error'] = 'An error has occured your information has not been updated';
      }
    } else {
      $data['error'] = validation_errors();
    }

    $this->data['user_id'] = $this->user->getId();
    $this->data['field_groups'] = array(
      array(
        $this->formFieldInfo('First name'),
        $this->formFieldInfo('Last name'),
      ),
      array(
        $this->formFieldInfo('Phone'),
        $this->formFieldInfo('Address'),
        $this->formFieldInfo('Suburb'),
        $this->formFieldInfo('Postcode'),
      ),
      array(
        $this->formFieldInfo('Email'),
        array('name' => 'password', 'type' => 'password', 'default' => '', 'label' => 'Update password (Min length 8)'),
        array('name' => 'confirmation', 'type' => 'password', 'default' => '', 'label' => 'Password confirmation'),
      ),
    );
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
