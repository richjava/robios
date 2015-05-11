<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_Controller extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->init();
    }

    /**
     * Initiate the controller.
     */
    public function init() {
        $this->output->set_template('dashboard');
        $this->output->set_title("Admin | Robios Web and Mobile Solutions");
        $this->load->css('assets/themes/default/css/motelapp.css');
    }

    public function index() {
        $data = $this->list_items(base_url() . 'admin/' . $this->get_item_name() . 's', 5);
        $this->load->view('pages/admin', $data);
	
	
    
    
    }

    public function list_items($base_url, $per_page, $uri_segment = 3) {
        $this->load->helper('url');
        $this->load->library('table');
        $data = $this->get_list_data();

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

        $items = array();
        foreach ($rows as $row) {
            $items = $this->process_items($items, $row);
        }
        $data['items'] = $items;
        return $data;
    }

    public function add_edit($id = null) {
        $this->load->helper('form');
        //is add/edit
        if (!$this->input->post()) {
            $data = $this->get_add_edit_data($id);
            $data["item"] = $this->get_item($id);
            $data["is_edit"] = ($id == null);
            $this->load->view('pages/admin', $data);
        } else {//if is insert/update
            $this->insert_update($id);
        }
    }

    private function insert_update($id) {
        $this->load->library('form_validation');

        // validation
        $this->set_validation_rules();

        //if doesn't validate
        if (!$this->form_validation->run()) {
            $this->load->view('pages/admin', $this->get_add_edit_data($id));
        } else {//if validates
            $this->process_insert_update($id);

            //add flash and redirect
            $action = "";
            if ($id == null) {
                $action = "added";
            } else {
                $action = "updated";
            }
            $this->session->set_flashdata('success', 'Item successfully ' . $action);
            redirect('/admin/' . $this->get_item_name() . 's');
        }
    }

    public function process_insert_update($id) {
        $item_data = $this->populate_from_post();
        if ($id != null) {
            $item_data['id'] = (int) $id;
        }
        return $this->get_item_instance()->save($item_data,$id);
    }

}
