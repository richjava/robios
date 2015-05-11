<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Motelapp extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper('url');
    }

    /**
     * Initiate the controller.
     */
    private function _init() {
        $this->output->set_template('default');
        $this->load->js('assets/themes/default/js/greensock.js');
        $this->load->js('assets/themes/default/js/layerslider.kreaturamedia.jquery.js');
        $this->load->js('assets/themes/default/js/layerslider.transitions.js');
        $this->load->js('assets/themes/default/js/TweenMax.min.js');
        $this->load->js('assets/themes/default/js/jquery.scrollmagic.min.js');
        $this->load->js('assets/themes/default/js/jquery.scrollmagic.debug.js');

        $this->load->css('assets/themes/default/css/motelapp.css');

        //custom
        //$this->load->js('assets/themes/default/js/scripts.js');
    }

    /**
     * Display MotelApp home page
     */
    public function index() {
        $this->_init();
        $this->output->set_title("Motel App | Robios | Android mobile app for motels in New Zealand");
        $this->load->view('pages/motelapp');
    }

    /**
     * Display list of coupons for mobile app.
     */
    public function coupon_list($user_id) {
        $this->load->helper('url');
        $this->load->library('table');
        $data = $this->get_list_data();

        //pagination (including styling for bootstrap)
        $this->load->library('pagination');
        $config['base_url'] = base_url().'motelapp/dashboard/'.$this->get_item_name();
        $config['per_page'] = 5;
        $config['uri_segment'] = 4;
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
        
        $items = array();
        foreach ($rows as $row) {
            $items = $this->process_items($items, $row);
        }
        $data['items'] = $items;
        $this->load->view('pages/motelapp_dashboard', $data);
    }

}
