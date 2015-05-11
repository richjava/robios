<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Site extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
    }

    /**
     * Initiate the controller.
     */
    private function _init() {
        $this->load->helper('form');
        $this->output->set_template('default_no_footer');
        $this->output->set_title("Robios | Mobile and Web Solutions in Christchurch, New Zealand");

        $this->output->set_meta("description", "Robios is a boutique web and mobile development agency located in the garden city, Christchurch, New Zealand. We specialise in marrying mobile and web technologies to increase the overall reach of applications. Our products are especially suited to small/medium sized businesses wishing to stay in close touch with their customers.");
        $this->output->set_meta("keywords", "web, website, mobile, application, app, notifications, development, design, agency, garden city, Christchurch, New Zealand, affordable, Android");

        //js libraries
        $this->load->js('assets/themes/default/js/greensock.js');
        $this->load->js('assets/themes/default/js/layerslider.kreaturamedia.jquery.js');
        $this->load->js('assets/themes/default/js/layerslider.transitions.js');
        $this->load->js('assets/themes/default/js/TweenMax.min.js');
        $this->load->js('assets/themes/default/js/jquery.scrollmagic.min.js');
        $this->load->js('assets/themes/default/js/jquery.scrollmagic.debug.js');

        //custom
        $this->load->js('assets/themes/default/js/home.js');
        $this->load->css('assets/themes/default/css/home.css');
        $this->load->css('assets/themes/default/css/pricing.css');
    }

    /**
     * Static home page
     */
    public function index() {
        $this->_init();
        $this->load->view('pages/home', array('is_contact_validation' => false));
    }

    /**
     * Display Contact page.
     */
    public function contact() {
        // validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules(array(
            array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required',
            ),
            array(
                'field' => 'message',
                'label' => 'Message',
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
            $this->load->view('pages/home', array('is_contact_validation' => true));
        } else {//if validates
            $this->load->helper('email');
            $name = $this->input->post('name');
            $subject = 'Robios Enquiry from ' . $name;
            $email = $this->input->post('email');

            $body_prefix = 'Dear%20[Name%20here],%0A%0A';
            $body = "[message goes here]";

            $body_suffix = '%0A%0AKind%20regards,%0ARichard%20Lovell%0ALead%20Developer';

            $message = $this->get_message($this->input->post('message'), $name, $email, $subject, $body_prefix, $body, $body_suffix); //$message_intro.$this->input->post('message');
            if (send_email($subject, $message)) {
                $this->session->set_flashdata('success', 'Thank you for contacting us. We will be in touch shortly.');
                redirect("/site#contact", 'refresh');
            } else {
//		TODO handle error         show_error($this->email->print_debugger());
            }
        }
    }

    /**
     * Validate that the user is a member. Used as part of login 
     * (and AJAX login) functionality.
     */
    public function ajax_send_enquiry() {
        $email = $this->input->post('enquiry-email');
        $name = $this->input->post('enquiry-name');      
        $msg = $this->input->post('enquiry-message');
        $type = $this->input->post('enquiry-type');
        $subject = 'Robios Enquiry: ' . $type;
        $this->load->helper('email');
        $body_prefix = 'Dear%20[Name%20here],%0A%0A';
        $body = "[message goes here]";
        $body_suffix = '%0A%0AKind%20regards,%0ARichard%20Lovell%0ALead%20Developer';
        $message = $this->get_message($msg, $name, $email, $subject, $body_prefix, $body, $body_suffix);
        if (send_email($subject, $message)) {
            echo 'success';
        } else {
            echo 'fail';
        }
    }

    private function get_message($msg, $name, $email, $subject, $body_prefix, $body, $body_suffix) {
        $url_friendly_subject = str_replace(" ", "%20", $subject);
        $url_friendly_body = str_replace(" ", "%20", $body);
        $message_intro = '<p>From ' . $name . ' (<a href="mailto:' . $email . '?subject=' . $url_friendly_subject . '
&body=' . $body_prefix . $url_friendly_body . $body_suffix . '">' . $email . '</a>)</p>';
        return $message_intro . $msg;
    }

}
