<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contact extends CI_Controller {

    function __construct() {
	parent::__construct();

	$this->load->helper('url');
    }

    /**
     * Initiate the controller.
     */
    private function _init() {
	$this->output->set_template('default');
	$this->output->set_title("Robios | Mobile and Web Development in Christchurch, New Zealand");
	$this->load->js('assets/themes/default/js/greensock.js');
	$this->load->js('assets/themes/default/js/layerslider.kreaturamedia.jquery.js');
	$this->load->js('assets/themes/default/js/layerslider.transitions.js');
	$this->load->js('assets/themes/default/js/TweenMax.min.js');
	$this->load->js('assets/themes/default/js/jquery.scrollmagic.min.js');
	$this->load->js('assets/themes/default/js/jquery.scrollmagic.debug.js');
	$this->load->css('assets/themes/default/css/home.css');
    }

    /**
     * Display Contact page.
     */
    public function index() {
	$this->load->helper('form');

	// validation
	$this->load->library('form_validation');
	$this->form_validation->set_rules(array(
	    array(
		'field' => 'name',
		'label' => 'Name',
		'rules' => 'required',
	    ),
	    array(
		'field' => 'comment',
		'label' => 'Comment',
		'rules' => 'required',
	    ),
	    array(
		'field' => 'email',
		'label' => 'Email',
		'rules' => 'required',
	    ),
	));

	$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
	//if doesn't validate
	if (!$this->form_validation->run()) {
	    $this->_init();
	    $this->load->view('pages/home');
	} else {//if validates
	    $this->load->config('email');
	    $this->load->helper('email');
	    //if ($this->_send_email()) {
	    $subject = 'Enquiry ' . date('Y-m-d H:i:s');
	    $email = $this->config->item('smtp_user');
	    $message = $this->input->post('comment');
	    if ($this->email->send_email($subject, $email, $message)) {
		$this->session->set_flashdata('success', 'Thank you for contacting us. We will be in touch shortly.');
		redirect("/site", 'refresh');
	    } else {
		//TODO show error
		//show_error($this->email->print_debugger());
	    }
	    }
	}

	/*
	 * Send the email.
	 */
//    private function _send_email() {
//	$admin_email = "richjavalabs@gmail.com";
//	$config = Array(
//	    'protocol' => 'smtp',
//	    'smtp_host' => 'ssl://smtp.googlemail.com',
//	    'smtp_port' => 465,
//	    'smtp_auth' => true,
//	    'smtp_user' => $admin_email,
//	    'smtp_pass' => 'xxxx',
//	    'mailtype' => 'html',
//	    'charset' => 'iso-8859-1'
//	);
//	$this->load->library('email', $config);
//	$this->email->set_newline("\r\n");
//	$this->email->from($this->input->post('email'), $this->input->post('name'));
//	$this->email->to($admin_email);
//	$this->email->subject("Inquiry ".date('Y-m-d H:i:s'));
//	$this->email->message($this->input->post('comment'));
//	
//	//send email 
//	if ($this->email->send()) {
//	    return true;
//	} else {
//	    //development only, change if used in production
//	    show_error($this->email->print_debugger());
//	}
 //   }

}
