<?php

class Aattendance extends MY_Controller {
  public $termModel;

  public function __construct() {
    parent::__construct();
    $this->load->model('attendancemodel', 'model');
    $this->mainContent = 'admin/attendance/attendance';
    $this->title = 'Attendance';
    $this->load->model('term_model', 'termModel');
    $this->setLabs();
    $this->baseSeg = 3;
  }

  private function setLabs() {
    $this->redirectIfNotLoggedIn();
    $loc = array();
    $type = $this->user->getType();
    if ($type == '4') {
      foreach ($user['locations'] as $location) {
        $loc[]['id'] = $location['location'];
      }
    }
    if ($type == '5') {
      $loc = $this->model->getLocationId();
    }
    for ($cnt = 0; $cnt < count($loc); ++$cnt) {
      $loc[$cnt]['terms'] = $this->model->getTerms($loc[$cnt]['id']);
      for ($cnt2 = 0; $cnt2 < count($loc[$cnt]['terms']); ++$cnt2) {
        $loc[$cnt]['terms'][$cnt2]['sessions'] = $this->model->getSession($loc[$cnt]['id'],
        $loc[$cnt]['terms'][$cnt2]['term']);
      }
    }
    $this->data['labData'] = $loc;
    $names = array();
    foreach ($loc as $l) {
      $names[$l['id']] = $this->model->getLocationName($l['id']);
    }
    $this->data['labNames'] = $names;
    $labTerms = array();
    $temp = $this->model->getTermData();
    for ($cnt = 0; $cnt < count($temp); ++$cnt) {
      $labTerms[$cnt]['desc'] = $temp[$cnt]['startDate'].' - '.$temp[$cnt]['endDate'];
      $labTerms[$cnt]['id'] = $temp[$cnt]['id'];
    }
    $this->data['labTerms'] = $labTerms;
    $labSessions = array();
    $temp = $this->model->getSessionInformation();
    for ($cnt = 0; $cnt < count($temp); ++$cnt) {
      $labSessions[$cnt]['desc'] = $temp[$cnt]['day'].' - '.$temp[$cnt]['startTime'].
      ' - '.$temp[$cnt]['endTime'];
      $labSessions[$cnt]['id'] = $temp[$cnt]['id'];
    }
    $this->data['labSessions'] = $labSessions;
  }

  public function index() {
    $this->redirectIfNotLoggedIn();
    $this->render();
  }

  public function getLocationData() {
    $data['location'] = (int) $this->input->get('location');
    $data['termSession'] = $this->model->getTermSessionData($data['location']);
    echo $this->load->view('admin/attendance/displayTable', $data, true);
  }

  public function process() {
    $location = (int) $this->input->get('location');
    $term = (int) $this->input->get('term');
    $session = (int) $this->input->get('session');
    $id = $this->model->getTermSessionId($location, $term, $session);
    $data = array();
    if (count($id) > 0) {
      $studentData = $this->model->getSessionStudentData($id[0]['id']);
      $cnt = 0;
      foreach ($studentData as $sd) {
        $data[$cnt]['info'] = $this->model->getStudentInfo($sd['student']);
        $data[$cnt]['attendance'] = $this->model->getAttendanceData($sd['id']);
        ++$cnt;
      }
      $output = $this->load->view('admin/attendance/display', array('data' => $data), true);
      echo $output;
    } else {
      echo '<table><tr><td>No records found</td></tr></table>';
    }
  }
}
