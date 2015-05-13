<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class News_items extends Dashboard_Controller {

    private $item_name = 'news_item';

    /**
     * Initiate the controller.
     */
    public function init() {
        parent::init();
        $this->load->model('News_item');
    }

    public function get_items(&$config) {
	$user_id = $this->session->userdata('user_id');
        $config['total_rows'] = $this->News_item->count_by(array("user_id"=>$user_id));
        $offset = $this->uri->segment($config['uri_segment']);
        $this->News_item->limit($config['per_page'], $offset);
        $this->News_item->order_by("date_created", "desc");
        return $this->News_item->get_many_by('user_id', $user_id);
    }

    public function process_items($items, $row) {
        $anchor = anchor('dashboard/news_items/detail/' . $row->id, 'View');
        $anchor .= ' | ' . anchor('dashboard/news_items/add_edit/' . $row->id, 'Edit') . '  | ' . anchor('motelapp/dashboard/news_item/delete/' . $row->id, 'Delete');
        $items[] = array(
            $this->get_image_thumbnail($row),
            $row->title,
            $row->description,
            date('d/m/Y', strtotime($row->date_created)),
            $anchor
        );
        return $items;
    }

    public function get_list_data() {
        $tbl_heading = array(
            '0' => array('data' => 'Image', 'class' => 'col-sm-2'),
            '1' => array('data' => 'Title', 'class' => 'col-sm-3'),
            '2' => array('data' => 'Description', 'class' => 'col-sm-3'),
            '3' => array('data' => 'Date created', 'class' => 'col-sm-2'),
            '4' => array('data' => 'Action', 'class' => 'col-sm-2'));
        return array(
            'tbl_heading' => $tbl_heading,
            'content' => 'partials/news_item/news_list',
            'coupons_main_nav_class' => '',
            'deals_main_nav_class' => '',
            'news_main_nav_class' => 'active',
            'list_nav_class' => 'active',
            'add_nav_class' => ''
        );
    }

    public function get_item($id) {
        $news_item = new News_item();
        //if is add
        if ($id == null) {
            //populate with defaults
            $news_item->title = '';
            $news_item->content = '';
            $news_item->status = 'Pending';
        } else {//if is edit
            //get news item from db by id
            $this->load->model('News_item');
            $news_item = $this->News_item->get($id);
        }
        return $news_item;
    }

    public function populate_from_post() {       
        $news_item_data = array();
        $news_item_data['title'] = $this->input->post('title');
        $news_item_data['content'] = $this->input->post('content');
        $news_item_data['status'] = $this->input->post('status');
        $news_item_data['user_id'] = $this->session->userdata('user_id');
        $news_item_data['description'] = $this->get_post_description($news_item_data['content']);
        return $news_item_data;
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
            )
        ));
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
    }

    public function get_add_edit_data($id) {
        //if edit, don't set add link as selected
        $add_nav_class = ($id == null) ? 'active' : '';

        $item = $this->get_item($id);
        return array(
            'is_edit' => $id != null,
            'item' => $item,
            'content' => 'partials/news_item/news_add',
            'coupons_main_nav_class' => '',
            'deals_main_nav_class' => '',
            'news_main_nav_class' => 'active',
            'list_nav_class' => '',
            'add_nav_class' => $add_nav_class
        );
    }

    public function get_item_name() {
        return $this->item_name;
    }
    
    public function get_simple_item_name() {
        return "news";
    }

    public function delete($id) {
        $this->load->model('News_item');
        if ($this->News_item->delete($id)) {
            $this->session->set_flashdata('success', 'News item successfully deleted.');
        } else {
            $this->session->set_flashdata('error', 'There was a problem deleting the News item. Please try again.');
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
            $this->output->set_title($item->title . " | News | Robios | Mobile and Web Development in Christchurch, New Zealand");
            $this->load->css('assets/themes/default/css/detail.css');
        } else if ($device_type === 'mobile') {
            $this->output->set_template('blank');
        }

        $this->load->view('pages/news_item_detail', array("item" => $item, "device_type"=>$device_type));
    }
    
    public function get_item_instance(){
        return new News_item();
    }
    
    public function save_item_image_url($id,$image_url) {
        $this->load->model('News_item');
        $item = $this->News_item->get($id);
        $item_data = (array)$item;       
        $item_data['image_url'] = $image_url;
        
        $news_item = new News_item();
        $news_item->update($id,$item_data);
    }

}
