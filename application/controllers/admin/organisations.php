<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Organisations extends Admin_Controller {

    private $item_name = 'organisation';

    /**
     * Initiate the controller.
     */
    public function init() {
        parent::init();
        $this->load->model('Organisation');
    }

    public function get_items(&$config) {
        $config['total_rows'] = $this->Organisation->count_all();
        $offset = $this->uri->segment($config['uri_segment']);
        $this->Organisation->limit($config['per_page'], $offset);
        $this->Organisation->order_by("name", "desc");
        return $this->Organisation->get_all();
    }

    public function process_items($items, $row) {
        //$anchor = anchor('admin/organisations/detail/' . $row->id, 'View');
        //if is still valid, edit otherwise relist
        //if (strtotime($row->expiry_date) > time()) {
        $anchor = anchor('admin/organisations/add_edit/' . $row->id, 'Edit');
//        } else {
//            $anchor .= '  | ' . anchor('admin/user/add_edit/' . $row->id, 'Relist');
//        }
        $anchor .= '  | ' . anchor('admin/organisations/delete/' . $row->id, 'Delete');

        $items[] = array(
            $row->name,
            $row->status,
            $anchor
        );
        return $items;
    }

    public function get_list_data() {
        $tbl_heading = array(
            '0' => array('data' => 'Name', 'class' => 'col-sm-7'),
            '1' => array('data' => 'Status', 'class' => 'col-sm-3'),
            '2' => array('data' => 'Action', 'class' => 'col-sm-2'));
        return array(
            'tbl_heading' => $tbl_heading,
            'content' => 'partials/admin/organisation/organisation_list',
            'organisations_main_nav_class' => 'active',
            'users_main_nav_class' => '',
            'list_nav_class' => 'active',
            'add_nav_class' => '');
    }

    public function add_edit($id = null) {
        $this->load->js('assets/themes/default/js/bootstrap-datepicker.js');
        $this->load->css('assets/themes/default/css/datepicker.css');
        parent::add_edit($id);
    }

    public function get_item($id) {
        $organisation = new Organisation();
        //if is add
        if ($id == null) {
            //populate with defaults
            $organisation->name = '';
            $organisation->status = 'Pending';
            //$this->set_default_expiry_date($coupon);
            //$coupon->expiry_date = date('Y-m-d H:i:s',time() + (3600 * 24 * 7)); //two weeks ahead of now
        } else {//if is edit
            //get item from db by id
            $this->load->model('Organisation');
            $organisation = $this->Organisation->get($id);
        }
        return $organisation;
    }

    public function populate_from_post() {
        $organisation_data = array();
        $organisation_data['name'] = $this->input->post('organisation_name');
        $status = $this->input->post('status') ? 'Active' : 'Pending';
        $organisation_data['status'] = $status;
        $organisation_data['date_created'] = date('Y-m-d H:i:s', time());
//        $organisation = new Organisation();
//        $organisation->name = $this->input->post('organisation_name');
//        $status = $this->input->post('status') ? 'Active' : 'Pending';
//        $organisation->status = $status;
//        $organisation->date_created = date('Y-m-d H:i:s', time());
        return $organisation_data;
    }

    public function set_validation_rules() {
        $this->form_validation->set_rules(array(
            array(
                'field' => 'organisation_name',
                'label' => 'Organisation Name',
                'rules' => 'required',
            )
        ));
        $this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
    }

    public function get_add_edit_data($id) {
        //if edit, don't set add link as selected
        $add_nav_class = ($id == null) ? 'active' : '';
        return array(
            'edit' => $id != null,
            'content' => 'partials/admin/organisation/organisation_add',
            'users_main_nav_class' => '',
            'organisations_main_nav_class' => 'active',
            'list_nav_class' => '',
            'add_nav_class' => $add_nav_class
        );
    }

    public function get_item_name() {
        return $this->item_name;
    }

    public function delete($id) {

        if ($this->Organisation->delete($id)) {
            $this->session->set_flashdata('success', 'Organisation successfully deleted.');
        } else {
            $this->session->set_flashdata('error', 'There was a problem deleting the Organisation. Please try again.');
        }
        //take back to list
        redirect('admin/' . $this->get_item_name() . 's', 'refresh');
    }

    public function process_insert_update($id) {
        //insert or update organisation first, update returns null 
        if ($id) {
            parent::process_insert_update($id);
        } else {
            $id = parent::process_insert_update($id);
        }

        //if send email is checked
        if ($this->input->post('status')) {

            $organisation = $this->populate_from_post();

            //create auth token
            $this->load->model('Auth_token');
            $token_data = array();
            $token_data['business_name'] = $organisation['name'];
            if ($id) {
                $token_data['business_id'] = $id;
            }

            $this->load->helper('string');
            $token_data['token'] = random_string('alnum', 16);
            $token = new Auth_token();
            $token->save($token_data);

            //send email
//	    $this->load->config('email');
//	    $this->load->helper('email');
//	    //if ($this->_send_email()) {
//	    $subject = 'Robios account authorisation for '.$organisation->name;
//	    $email = $this->config->item('smtp_user');
//	    $message = get_authorisation_email_body($token);
//	    if ($this->email->send_email($subject, $email, $message)) {
//		$this->session->set_flashdata('success', 'Thank you for contacting us. We will be in touch shortly.');
//		redirect("/site", 'refresh');
//	    } else {
//		//TODO show error
//		//show_error($this->email->print_debugger());
//	    }
        }
        return null;
    }

    public function get_authorisation_email_body($token) {
        $body = '<h1>This is the body heading</h1>'
                . '<p>Please click the following link to take you to the registration page:</p>'
                . '<p><a href="http://localhost/robios/auth/signup/abc123">http://localhost/robios/auth/signup/abc123</a></p>';
        return $body;
    }
    
    public function get_item_instance() {
         return new Organisation();
    }

//    public function detail($id,$device_type = null) {
//	$this->load->helper('url');
//	$item = $this->get_item($id);
//	//no device type is for desktop
//	if ($device_type == null) {
//	    $this->output->set_template('default');
//	    $this->output->set_title($item->title." | Coupon | Robios | Mobile and Web Development in Christchurch, New Zealand");
//	    $this->load->css('assets/themes/default/css/detail.css');
//
//	}else if ($device_type === 'mobile'){
//	    $this->output->set_template('blank');
//	}
//	
//	$this->load->view('pages/coupon_detail',array("item"=>$item));
//    }
}
