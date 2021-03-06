<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class News_item_notifications extends Dashboard_Controller {

    private $item_name = 'news_item';

    /**
     * Initiate the controller.
     */
    public function init() {

        $this->output->set_template('blank');

        $this->load->css('assets/themes/default/css/bootstrap.css');
        $this->load->css('assets/themes/default/css/notifications.css');
        $this->load->model('News_item');
    }

    public function index() {
        $data = $this->list_items(base_url() . 'news_item_notifications/', 50, 3);
        $this->load->view('pages/news_item_notification_list', $data);
    }

    public function get_items(&$config) {
        $config['total_rows'] = $this->News_item->count_all();
        $offset = $this->uri->segment($config['uri_segment']);
        $this->News_item->limit($config['per_page'], $offset);
        $this->News_item->order_by("expiry_date", "desc");
        return $this->News_item->get_many_by('user_id', 1);
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
            '0' => array('data' => 'Title', 'class' => 'col-sm-10'),
            '1' => array('data' => 'Date', 'class' => 'col-sm-2'));
        return array(
            'tbl_heading' => $tbl_heading);
    }

    public function get_item_name() {
        return $this->item_name;
    }

}
