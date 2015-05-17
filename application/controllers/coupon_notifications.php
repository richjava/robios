<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Coupon_notifications extends Dashboard_Controller {

    private $item_name = 'coupon';

    /**
     * Initiate the controller.
     */
    public function init() {
        $this->output->set_template('blank');
        $this->load->css('assets/themes/default/css/bootstrap.css');
        $this->load->css('assets/themes/default/css/notifications.css');
        $this->load->model('Coupon');
    }

    public function coupons_list($user_id) {
        $data = $this->list_items(base_url() . 'coupon_notifications/coupons_list/'.$user_id, 5, 4);
        $this->load->view('pages/coupon_notification_list', $data);
    }

    public function get_items(&$config) {
        $this->init();
        $config['total_rows'] = $this->Coupon->count_all();
        $offset = $this->uri->segment($config['uri_segment']);
        $this->Coupon->limit($config['per_page'], $offset);
        $this->Coupon->order_by("expiry_date", "desc");
        return $this->Coupon->get_many_by('user_id', $this->uri->segment(3));
    }
    
    public function list_items($base_url, $per_page, $uri_segment = 3) {
	$this->load->helper('url');
	//$this->load->library('table');
	//$data = array();$this->get_list_data();

	//pagination (including styling for bootstrap)
	$this->load->library('pagination');
	$config['base_url'] = $base_url;
	$config['per_page'] = $per_page;
	$config['uri_segment'] = $uri_segment;
	$config['full_tag_open'] = '<ul class="pagination">';
	$config['full_tag_close'] = '</ul>';
	$config['prev_link'] = '&laquo;';
	$config['prev_tag_open'] = '<li>';
	$config['prev_tag_close'] = '</li>';
	$config['next_link'] = '&raquo;';
	$config['next_tag_open'] = '<li>';
	$config['next_tag_close'] = '</li>';
	$config['cur_tag_open'] = '<li class="active"><a href="#">';
	$config['cur_tag_close'] = '</a></li>';
	$config['num_tag_open'] = '<li>';
	$config['num_tag_close'] = '</li>';

	//config variable passed by reference
	$rows = $this->get_items($config);
	$config["num_links"] = round($config["total_rows"] / $config["per_page"]);

	$this->pagination->initialize($config);

//	$items = array();
//	foreach ($rows as $row) {
//	    $items = $this->process_items($items, $row);
//	}
//	$data['items'] = $items;
//	return $data;
        $data['items'] = $rows;
        return $data;
    }

//    public function process_items($items, $row) {
//        $items[] = array(
//            $row->title,
//            date('d/m/Y', strtotime($row->expiry_date)),
//            date('d/m/Y', strtotime($row->expiry_date)),
//        );
//        return $items;
//    }

//    public function get_list_data() {
//        $tbl_heading = array(
//            '0' => array('data' => 'Title', 'class' => 'col-sm-8'),
//            '1' => array('data' => 'Start Date', 'class' => 'col-sm-2'),
//            '2' => array('data' => 'End Date', 'class' => 'col-sm-2'));
//        return array(
//            'tbl_heading' => $tbl_heading);
//    }

    public function get_item_name() {
        return $this->item_name;
    }

}
