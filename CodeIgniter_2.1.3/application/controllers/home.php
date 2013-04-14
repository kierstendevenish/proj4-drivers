<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Home extends CI_Controller {

 function __construct()
 {
   parent::__construct();
 }

 function index()
 {
   if($this->session->userdata('logged_in'))
   {
     $session_data = $this->session->userdata('logged_in');
     $data['username'] = $session_data['username'];
     $this->load->model('user');
     $location = $this->user->getLocation($data['username']);
     $data['lat'] = $location['lat'];
     $data['long'] = $location['long'];
     
     if ($data['username'] === "admin")
     {
        $this->load->view('templates/header');
        $this->load->view('admin_home_view', $data);
        $this->load->view('templates/footer');
     }
     else
     {
        $this->load->view('templates/header');
        $this->load->view('home_view', $data);
        $this->load->view('templates/footer');
     }
   }
   else
   {
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }
 }

 function logout()
 {
   $this->session->unset_userdata('logged_in');
   session_destroy();
   redirect('home', 'refresh');
 }
 
 function esl()
 {
     $session_data = $this->session->userdata('logged_in');
     $username = $session_data['username'];
     $this->load->model('user');
     $data['esl'] = $this->user->getEsl($username);
     
     $this->load->view('templates/header');
     $this->load->view('esl', $data);
     $this->load->view('templates/footer');
 }
 
 function setEsl()
 {
     $session_data = $this->session->userdata('logged_in');
     $username = $session_data['username'];
     $this->load->model('user');
     
     $esl = $this->input->post('esl');
     
     $this->user->setEsl($username, $esl);
     
     redirect('home');
 }

 function makeEsl()
 {
    $uid = uniqid();
    $esl = site_url() . "/rfq/index/" . $uid;

    $session_data = $this->session->userdata('logged_in');
    $username = $session_data['username'];

    //insert esl into db
    $this->load->model('user');
    $this->user->saveEsl($username, $esl);

    //redirect to home page (need to load all curr esls on home page)
    redirect('driver/listEsls');
 }

}

?>