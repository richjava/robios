<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Coupons extends Dashboard_Controller {

    private $item_name = 'coupon';

    /**
     * Initiate the controller.
     */
    public function init() {
	parent::init();
	$this->load->model('Coupon');
    }

    public function get_items(&$config) {
	$user_id = $this->session->userdata('user_id');
	$config['total_rows'] = $this->Coupon->count_by(array("user_id" => $user_id));
	$offset = $this->uri->segment($config['uri_segment']);
	$this->Coupon->limit($config['per_page'], $offset);
	$this->Coupon->order_by("date_created", "desc");
	return $this->Coupon->get_many_by('user_id', $user_id);
    }

    public function process_items($items, $row) {
	$anchor = anchor('motelapp/dashboard/coupon/detail/' . $row->id, 'View');
	//if is still valid, edit otherwise relist
	if (strtotime($row->expiry_date) > time()) {
	    $anchor .= '  | ' . anchor('dashboard/coupons/add_edit/' . $row->id, 'Edit');
	} else {
	    $anchor .= '  | ' . anchor('dashboard/coupons/add_edit/' . $row->id, 'Relist');
	}
	$anchor .= '  | ' . anchor('dashboard/coupons/delete/' . $row->id, 'Delete');

	$items[] = array(
	    $this->get_image_thumbnail($row),
	    $row->title,
	    $row->description,
	    date('d/m/Y', strtotime($row->expiry_date)),
	    $anchor
	);
	return $items;
    }

    public function get_list_data() {
	$tbl_heading = array(
	    '0' => array('data' => 'Image', 'class' => 'col-sm-2'),
	    '1' => array('data' => 'Title', 'class' => 'col-sm-3'),
	    '2' => array('data' => 'Description', 'class' => 'col-sm-3'),
	    '3' => array('data' => 'Expiry Date', 'class' => 'col-sm-2'),
	    '4' => array('data' => 'Action', 'class' => 'col-sm-2'));
	return array(
	    'tbl_heading' => $tbl_heading,
	    'content' => 'partials/coupon/coupon_list',
	    'coupons_main_nav_class' => 'active',
	    'deals_main_nav_class' => '',
	    'news_main_nav_class' => '',
	    'list_nav_class' => 'active',
	    'add_nav_class' => '');
    }

    public function add_edit($id = null) {
	$this->load->js('assets/themes/default/js/bootstrap-datepicker.js');
	$this->load->css('assets/themes/default/css/datepicker.css');
	parent::add_edit($id);
    }

    public function get_item($id) {
	$coupon = new Coupon();
	//if is add
	if ($id == null) {
	    //populate with defaults
            $coupon->title = '';
            $coupon->content = '';
            $coupon->conditions = '';
            $coupon->status = 'Pending';
            $this->set_default_expiry_date($coupon);
	    
	} else {//if is edit
	    //get item from db by id
	    $this->load->model('Coupon');
	    $coupon = $this->Coupon->get($id);
	}
	return $coupon;
    }

    public function populate_from_post() {
	$coupon_data = array();
	$coupon_data['title'] = $this->input->post('title');
	$coupon_data['content'] = $this->input->post('content');
	$coupon_data['status'] = $this->input->post('status');
	$time = strtotime(str_replace('/', '-', $this->input->post('expiry_date')));
	$coupon_data['expiry_date'] = date('Y-m-d H:i:s', $time);
	$coupon_data['user_id'] = $this->session->userdata('user_id');
	$coupon_data['description'] = $this->get_post_description($coupon_data['content']);
	return $coupon_data;
    }

    public function set_validation_rules() {
	$this->form_validation->set_rules(array(
	    array(
		'field' => 'title',
		'label' => 'Title',
		'rules' => 'required',
	    ),
	    array(
		'field' => 'content',
		'label' => 'Content',
		'rules' => 'required',
	    ),
	    array(
		'field' => 'expiry_date',
		'label' => 'Expiry date',
		'rules' => 'required',
	    ),
	));
	$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
    }

    public function get_add_edit_data($id) {
	//if edit, don't set add link as selected
	$add_nav_class = ($id == null) ? 'active' : '';

	$item = $this->get_item($id);
	return array(
	    'is_edit' => $id != null,
	    'item' => $item,
	    'content' => 'partials/coupon/coupon_add',
	    'coupons_main_nav_class' => 'active',
	    'deals_main_nav_class' => '',
	    'news_main_nav_class' => '',
	    'list_nav_class' => '',
	    'add_nav_class' => $add_nav_class
	);
    }

    public function get_item_name() {
	return $this->item_name;
    }
    
    public function get_simple_item_name() {
        return $this->get_item_name();
    }

    public function delete($id) {
	$this->load->model('Coupon');
	if ($this->Coupon->delete($id)) {
	    $this->session->set_flashdata('success', 'Coupon successfully deleted.');
	} else {
	    $this->session->set_flashdata('error', 'There was a problem deleting the Coupon. Please try again.');
	}
	//take back to list
	redirect('motelapp/dashboard/' . $this->get_item_name(), 'refresh');
    }

    public function detail($id, $device_type = null) {
        $this->init();
	$this->load->helper('url');
	$item = $this->get_item($id);
	//no device type is for desktop
	if ($device_type == null) {
	    $this->output->set_template('default');
	    $this->output->set_title($item->title . " | Coupon | Robios | Mobile and Web Development in Christchurch, New Zealand");
	    $this->load->css('assets/themes/default/css/detail.css');
	} else if ($device_type === 'mobile') {
	    $this->output->set_template('detail');
	}

	$this->load->view('pages/coupon_detail', array("item" => $item));
    }

    public function get_item_instance() {
	return new Coupon();
    }

    public function save_item_image_url($id, $image_url) {
	$this->load->model('Coupon');
	$item = $this->Coupon->get($id);
	$item_data = (array) $item;
	$item_data['image_url'] = $image_url;

	$coupon = new Coupon();
	$coupon->update($id, $item_data);
    }

}
