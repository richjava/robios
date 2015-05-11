<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends Admin_Controller {

    private $item_name = 'user';

    /**
     * Initiate the controller.
     */
    public function init() {
        parent::init();
        $this->load->model('User');
    }

    public function get_items(&$config) {     
        $config['total_rows'] = $this->User->count_all();      
        $offset = $this->uri->segment($config['uri_segment']);
//        $this->User->limit($config['per_page'], $offset);
//        $this->User->order_by("last_name", "desc");
	return $this->User->join_get('*', 'users', 'organisations', 'organisation_id','id','last_name',$config['per_page'] );
        //return $this->User->get_all();
    }

    public function process_items($items, $row) {
        $items[] = array(
            $row->first_name,
            $row->last_name,
            $row->email,
	    $row->name
        );
        return $items;
    }

    public function get_list_data() {
        $tbl_heading = array(
            '0' => array('data' => 'First Name', 'class' => 'col-sm-3'),
            '1' => array('data' => 'Last Name', 'class' => 'col-sm-3'),
            '2' => array('data' => 'Email', 'class' => 'col-sm-3'),
	'3' => array('data' => 'Organisation', 'class' => 'col-sm-3'));
        return array(
            'tbl_heading' => $tbl_heading,
            'content' => 'partials/admin/user/user_list',
            'users_main_nav_class' => 'active',
            'organisations_main_nav_class' => '',
            'list_nav_class' => 'active',
            'add_nav_class' => '');
    }

    public function add_edit($id = null) {
        $this->load->js('assets/themes/default/js/bootstrap-datepicker.js');
        $this->load->css('assets/themes/default/css/datepicker.css');
        parent::add_edit($id);
    }

    public function get_item($id) {
        $user = new User();
        //if is add
        if ($id == null) {
            //populate with defaults
            $user->first_name = '';
            $user->last_name = '';
            $user->email = '';
	    //$user->organisation_id = null;
            
        } else {//if is edit
            //get item from db by id
            $this->load->model('User');
            $user = $this->User->get($id);
        }
        return $user;
    }

//    public function populate_from_post() {
//        $user = new User();
//        $user->title = $this->input->post('title');
//        $user->content = $this->input->post('content');
//        //workaround because php strtotime doesn't work with slashes
//        $time = strtotime(str_replace('/', '-', $this->input->post('expiry_date')));
//        $user->expiry_date = date('Y-m-d H:i:s', $time);
//        $user->conditions = $this->input->post('conditions');
//        $user->date_created = date('Y-m-d H:i:s', time());
//        $user->user_id = 1;
//        return $user;
//    }

//    public function set_validation_rules() {
//        $this->form_validation->set_rules(array(
//            array(
//                'field' => 'title',
//                'label' => 'Title',
//                'rules' => 'required',
//            ),
//            array(
//                'field' => 'content',
//                'label' => 'Content',
//                'rules' => 'required',
//            ),
//            array(
//                'field' => 'expiry_date',
//                'label' => 'Expiry date',
//                'rules' => 'required',
//            ),
//        ));
//        $this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
//    }

//    public function get_add_edit_data($id) {
//        return array(
//            'edit' => $id != null,
//            'content' => 'partials/coupon/coupon_add',
//            'coupons_main_nav_class' => 'active',
//            'deals_main_nav_class' => '',
//            'news_main_nav_class' => '',
//            'list_nav_class' => '',
//            'add_nav_class' => 'active'
//        );
//    }

    public function get_item_name() {
        return $this->item_name;
    }
    
//    public function delete($id) {
//        $this->load->model('Coupon');
//        if ($this->Coupon->delete($id)) {
//            $this->session->set_flashdata('success', 'Coupon successfully deleted.');
//        } else {
//            $this->session->set_flashdata('error', 'There was a problem deleting the Coupon. Please try again.');
//        }
//        //take back to list
//        redirect('motelapp/dashboard/' . $this->get_item_name(), 'refresh');
//    }
    
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
