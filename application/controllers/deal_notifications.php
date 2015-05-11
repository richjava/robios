<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Deal_notifications extends Dashboard_Controller {

    private $item_name = 'coupon';

    /**
     * Initiate the controller.
     */
    public function init() {

        $this->output->set_template('blank');

        $this->load->css('assets/themes/default/css/bootstrap.css');
        $this->load->css('assets/themes/default/css/notifications.css');
        $this->load->model('Deal');
    }

    public function index() {
        $data = $this->list_items(base_url() . 'deal_notifications/', 50, 3);
        $this->load->view('pages/deal_notification_list', $data);
    }

    public function get_items(&$config) {
        $config['total_rows'] = $this->Deal->count_all();
        $offset = $this->uri->segment($config['uri_segment']);
        $this->Deal->limit($config['per_page'], $offset);
        $this->Deal->order_by("expiry_date", "desc");
        return $this->Deal->get_many_by('user_id', 1);
    }

    public function process_items($items, $row) {
        $items[] = array(
            $row->title,
            date('d/m/Y', strtotime($row->expiry_date)),
            date('d/m/Y', strtotime($row->expiry_date)),
        );
        return $items;
    }

    public function get_list_data() {
        $tbl_heading = array(
            '0' => array('data' => 'Title', 'class' => 'col-sm-8'),
            '1' => array('data' => 'Start Date', 'class' => 'col-sm-2'),
            '2' => array('data' => 'End Date', 'class' => 'col-sm-2'));
        return array(
            'tbl_heading' => $tbl_heading);
    }
    
    public function detail($id) {
        echo "detail";
    }

    public function get_item_name() {
        return $this->item_name;
    }

}
