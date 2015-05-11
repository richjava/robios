<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Class for handling authorization and authentication.
 */
class Auth extends CI_Controller {

    function __construct() {
	parent::__construct();
	$this->load->helper('url');
    }

    /**
     * Set up.
     */
    private function _init() {
	$this->output->set_template('default');
    }

    /**
     * Display Sign Up page.
     */
    public function signup($auth_token = null) {
	$this->_init();
	$this->load->css('assets/themes/default/css/signup.css');
	$this->load->model('Auth_token');
	$token = $this->Auth_token->get_by(array('token' => $auth_token));
	if ($token) {
	    $this->load->helper('form');
	}
	$this->load->view('pages/signup', array("token" => $token));
    }

    /**
     * Sign the user out and load home page.
     */
    public function logout() {
	$this->_init();
	$this->session->sess_destroy();
	redirect('/', 'refresh');
    }

    /**
     * Validate that the user is a member. Used as part of login 
     * (and AJAX login) functionality.
     */
    public function validate() {
	$user = $this->process_validate();
	if ($user) {
	    $this->_do_login($user);
	    echo 'success';
	} else { // incorrect username or password
	    echo 'fail';
	    //$this->session->set_flashdata('loginerror', 'Incorrect username and/or password. Please try again.');
	    //redirect('/auth/login', 'refresh');
	}
    }

    function process_validate() {
	$this->load->model('User');
	$password = md5($this->input->post('password'));
	return $this->User->get_by(array('email' => $this->input->post('email'), 'password' => $password));
    }

    /**
     * Log the user in and redirect to home page.
     */
    private function _do_login($user) {
	$data = array(
	    'is_logged_in' => true,
	    'user_id' => $user->id,
	    'user_role' => $user->role
	);
	$this->session->set_userdata($data);
    }

//    public function activate_account($token) {
//        $this->load->model('Activation_token');
//        $activation_token = $this->Activation_token->get_by(array('token' => $token));
//        if ($activation_token) {
//            //set email to user, save it and redirect to home page
//            $this->load->model('User');
//            $user = $this->User->get_by(array('email' => $activation_token->email));
//            $user->status = "active";
//            $user->save();
//            redirect('site');
//        } else {
//            //set flashes and redirect to signup page
//        }
//    }

    /**
     * Create a new user and store in db. Used as part of Signup functionality.
     */
    public function create_user($auth_token = null) {
	if ($auth_token == null) {
	    redirect('auth/signup/', 'refresh');
	} else {
	    $this->load->model('Auth_token');
	    $token = $this->Auth_token->get_by(array('token' => $auth_token));
	    if ($token) {
		$this->load->library('form_validation');
		//validate 
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
		$this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');

		if (!$this->form_validation->run()) {
		    $this->_init();
		    $this->load->view('pages/signup', array('token' => $token));
		} else {
		    $this->load->model('User');

		    //check that user doesn't already exist
		    $email = $this->input->post('email');
		    $user = $this->User->get_by(array('email' => $email));
		    if (!$user) {
			$this->process_create_user($token);
		    } else {
			//$this->session->set_flashdata('error', 'A user with this email address already exists.');
			$this->session->set_flashdata('error', 'A user with this email address already exists.');
		    }
		    redirect('auth/signup/' . $auth_token, 'refresh');
		}
	    } else {
		redirect('auth/signup/', 'refresh');
	    }
	}
    }

    private function process_create_user($token) {
	
	$org_id = $this->input->post('organisation_id');
	//Create new user	   
	$user_data = array();
	$user_data['first_name'] = $this->input->post('first_name');
	$user_data['last_name'] = $this->input->post('last_name');
	$user_data['email'] = $this->input->post('email');
	$user_data['password'] = md5($this->input->post('password'));
	$user_data['organisation_id'] = $org_id;

	//check to see if is first time or if business account has already been created
	
	$admin_user = $this->User->get_many_by(array('organisation_id'=>$this->input->post('organisation_id')));
	if (!$admin_user) {
	    //user is first to create account
	    $user_data['role'] = "Administrator";
	    
	    //set Organisation's status from "Pending" to "Active"
	    
	    $this->load->model('Organisation');
	    $organisation = new Organisation();
	    $organisation->update($org_id,array('status'=>'Active'));
	} else {
	    //user is not first to create account
	    $this->User->role = "Editor";
	}
	   
	//save user
	$user = new User();
	$user_id = $user->save($user_data);
	
	if ($user_id != null) {
	    //delete token
	    $this->load->model('Auth_token');
	    $this->Auth_token->delete($token->id);

	    //Sign user in (user id and role stored in session)
	    $user->id = $user_id;
	    $user->role = $user_data['role'];
	    $this->_do_login($user);

	    $this->session->set_flashdata('success', 'Account successfully created.');
	} else {
	    $this->session->set_flashdata('error', 'An error occurred and the account was not created.');
	}
    }

    /*
     * For AJAX call to check if current user is logged in. 
     */

    public function is_logged_in() {
	echo $this->session->userdata('email') != null ? 'true' : 'false';
    }

}
