<?php

class User extends MY_Model {

    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $organisation_id;
    /**
     * Based on wordpress roles. Super Admin, Administrator, Editor, Contributor, Subscriber
     * @link https://codex.wordpress.org/Roles_and_Capabilities
     * @var String 
     */
    public $role;

    function validate() {
	$user = $this->get_by(array('username' => $this->input->post('username'), 'password' => md5($this->input->post('password'))));
	if ($user) {
	    return true;
	}
    }

}
