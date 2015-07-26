<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * MY_Controller
 *
 * @package
 * @author Lab admin
 * @copyright craig poole
 * @version 2013
 * @access public
 */
abstract class MY_Controller extends CI_Controller {
    public $model = null;
    protected $data = array();
    protected $title = '';
    protected $mainContent = '';
    protected $template = 'template';
    protected $topNav = array();
    protected $baseSeg = 2;
    protected $emailError = '';

    /**
     * MY_Controller::__construct()
     *
     * @param mixed $modelName
     * @param mixed $t
     * @param mixed $mc
     * @return
     */
    function __construct($modelName = null, $t = null, $mc = null) {
        parent::__construct();
        $this->data['error'] = null;
        $this->data['ok'] = null;
        if($modelName != null) $this->Setup($modelName);
        $this->load->model('user');
    }

    /**
     * MY_Controller::ConfigEmail()
     *
     * @TODO: move this into uh config section?????
     */
    protected function ConfigEmail() {
        $this->config->set_item('protocol', 'smtp');
        $this->config->set_item('smtp_host', 'ssl://box1030.bluehost.com');
        $this->config->set_item('smtp_port', 465);
        $this->config->set_item('smtp_user', 'no-reply@thelab.org.au');
        $this->config->set_item('smtp_pass', '@1Admin1@');
        $this->config->set_item('default_from', 'no-reply@thelab.org.au');
    }

    protected function render() {
      $this->data['userName'] = $this->user->getFirstName();
      $this->mainNav($this->user->getType());
      $this->data['title'] = $this->title;
      $this->data['mainContent'] = $this->mainContent;
      $this->data['topNav'] = $this->topNav;
      $this->load->view($this->template, $this->data);
    }

    /**
     * MY_Controller::setInfo()
     *
     * @param mixed $data
     * @return
     */
    protected function setInfo($data) {
        $this->title = $data['title'];
        $this->mainContent = $data['mainContent'];
    }

    /**
     * MY_Controller::setNavItem()
     *
     * @param mixed $item
     * @return
     */
    protected function setNavItem($item)
    {
        $this->topNav[$item['title']] = $item;
    }

    /**
     * MY_Controller::addNavItem()
     *
     * @param mixed $title
     * @param mixed $element
     * @param mixed $item
     * @return
     */
    protected function addNavItem($title,$element,$item)
    {
        $this->topNav[$title]['items'][$element] = $item;
    }

    protected function redirectIfNotLoggedIn($dest = '/user/login') {
      if(!$this->user->isLoggedIn()) redirect($dest, 'refresh');
    }

    public function Log($data) {
      $this->model->logData($data,get_class($this));
    }

    protected function Setup($modelName) {
      $this->load->model($modelName, 'model');
    }

    /**
     * MY_Controller::SendEmail()
     *
     * @param mixed $subject
     * @param mixed $message
     * @param mixed $to
     * @param string $from
     * @param mixed $attach
     * @param mixed $cc
     * @return
     */
    public function SendEmail($subject, $message, $to,$from = 'admin@thelab.org.au', $replyto = null, $attach = null,$cc = null)
    {
        /*
        $config = Array(

            'protocol' => 'sendmail',
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1',

        );
        */

        $config = Array(

            'protocol' => 'smtp',
            'smtp_host' => 'ssl://box1030.bluehost.com',
            'smtp_port' => 465,
            'smtp_user' => 'no-reply@thelab.org.au',
            'smtp_pass' => '@1Admin1@',
            'smtp_timeout' => 10,
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1',

        );



        if($from == '')
            $from = $this->config->item('default_from');

        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->set_mailtype("html");

        if($replyto != null)
            $this->email->reply_to($replyto);

        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);

        if($cc != null)
        {
            if(is_array($cc))
            {
                foreach($cc as $c)
                    $this->email->cc($c);
            }
            else
                $this->email->cc($cc);
        }

        if($attach != null)
        {
            if(file_exists($attach) || $this->IsFile($attach))
                $this->email->attach($attach);
        }

        //return (!$this->email->send()) ?  $this->email->print_debugger() : true;
        if($this->email->send())
            return true;
        else
        {
            $this->emailError = $this->email->print_debugger();
            return false;
        }
    }

    /**
     * MY_Controller::IsFile()
     *
     * @param mixed $attach
     * @return
     */
    private function IsFile($attach)
    {
        return (get_resource_type($attach) == 'file' || get_resource_type($attach) == 'stream');
    }

    private function mainNav($userType) {
        if($this->user->isLoggedin()) {
            $this->profileNav($userType);
            $this->mentorNav($userType);
            $this->adminNav($userType);
        }
    }

    private function mentorNav($userType) {
        if($userType == 1 || $userType == 3) return;
        $temp = array();
        $temp['link'] = site_url().'/user/profile';
        $temp['title'] = 'Mentor';
        $temp['home'] = true;
        $temp['items'] = array();
        $temp['items'][] = array('title' => 'Attendance','link' => site_url().'/attendance', 'class' => 'users');
        $temp['items'][] = array('title' => 'Training','link' => site_url().'/training', 'class' => 'page');
        $this->setNavItem($temp);
    }

    private function adminNav($userType) {
        if($userType < 4) return;
        $temp = array();
        $temp['link'] = site_url('/admin/admin');
        $temp['title'] = 'Admin';
        $temp['home'] = true;
        $temp['items'] = array();
        $temp['items'][] = array('title' => 'Locations','link' => site_url().'/admin/alocations', 'class' => 'report');
        $temp['items'][] = array('title' => 'Sessions','link' => site_url().'/admin/asessions', 'class' => 'report');
        $temp['items'][] = array('title' => 'Students','link' => site_url().'/admin/astudents', 'class' => 'report');
        $temp['items'][] = array('title' => 'Mentors','link' => site_url().'/admin/amentors', 'class' => 'report');
        $temp['items'][] = array('title' => 'Users','link' => site_url().'/admin/ausers', 'class' => 'report');
        $temp['items'][] = array('title' => 'Training','link' => site_url().'/training/maintenance', 'class' => 'report');
        $temp['items'][] = array('title' => 'Mailout','link' => site_url().'/mailout', 'class' => 'report');
        $temp['items'][] = array('title' => 'Session cost','link' => site_url().'/admin/cost', 'class' => 'report');
        $temp['items'][] = array('title' => 'Attendance','link' => site_url().'/admin/aAttendance', 'class' => 'report');
        $this->setNavItem($temp);
    }

    private function profileNav($userType) {
       $this->setNavItem(array(
          'link' => site_url('user/profile'),
          'title' => 'My details',
          'home' => true,
          'items' => array(
              array('title' => 'My information', 'link' => site_url('user/profile'), 'class' => 'report'),
              array('title' => 'Child information', 'link' => site_url('user/profile/child'), 'class' => 'report'),
              array('title' => 'Waiting lists', 'link' => site_url('user/profile/waiting'), 'class' => 'report'),
              array('title' => 'Mailing lists', 'link' => site_url('user/profile/mail'), 'class' => 'report'),
              array('title' => 'Payment', 'link' => site_url('user/profile/payment'), 'class' => 'report'),
              array('title' => 'Mentor', 'link' => site_url('user/profile/mentor'), 'class' => 'report'),
          ),
       ));
    }

    protected function do_upload($fileName)
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'pdf|doc|docx|txt|odt';
        $config['file_name'] = $fileName;
        $config['max_size']  = '2048';
        $config['max_filename']  = '30';
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
    }

}
