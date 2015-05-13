<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard_Controller extends MY_Controller {

    function __construct() {
	parent::__construct();
	$this->load->helper('url');
	
    }

    /**
     * Initiate the controller.
     */
    public function init() {
	$this->output->set_template('dashboard');
        $this->output->set_title("Dashboard | Robios Web and Mobile Solutions");
	//custom css
	$this->load->css('assets/themes/default/css/motelapp.css');
    }

    public function index() {
        $this->init();
	if ($this->check_login()) {
	    $data = $this->list_items(base_url() . 'motelapp/dashboard/' . $this->get_item_name(), 5, 4);
	    $this->load->view('pages/dashboard', $data);
	}
    }

    public function get_image_thumbnail($item) {
        $url = base_url().'dashboard/'.$this->get_item_name().'s/detail/'.$item->id;
	if ($item->image_url) {
	    $this->load->helper('html');
	    $s3_base_url = 'https://s3-ap-southeast-2.amazonaws.com/robios.com-dev/';
	    $thumb_suffix = '_thumb';
	    $image_properties = array(
		'src' => $s3_base_url . $item->image_url . $thumb_suffix,
		'alt' => $item->title,
		'class' => 'img-thumbnail list-thumbnail', //bootstrap styling
		'title' => $item->title
	    );
	    return '<a href="'.$url.'">'.img($image_properties).'</a>';
	} else {
	    return '<a href="'.$url.'"><h1 class="no-thumb"><i class="fa fa-picture-o"></i></h1></a>';
	}
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
    
    public function get_post_description($content){
        $desc_length = 200;
	$desc = strip_tags($content);
        $desc = str_replace("&nbsp;","",$desc);
	if (strlen($desc) > $desc_length) {
	    $desc = substr($desc, 0, $desc_length) . '[...]';
	}
	return $desc;
    }

    public function add_edit($id = null) {
        $this->init();
	if ($this->check_login()) {
	    $this->load->helper('form');

	    //is add/edit
	    if (!$this->input->post()) {
		$data = $this->get_add_edit_data($id);

		$data["is_edit"] = ($id == null);
		$this->load->view('pages/dashboard', $data);
	    } else {//if is insert/update
		$this->insert_update($id);
	    }
	}
    }

    private function insert_update($id) {
	$this->load->library('form_validation');

	// validation
	$this->set_validation_rules();
	//if doesn't validate
	if (!$this->form_validation->run()) {
	    $this->load->view('pages/dashboard', $this->get_add_edit_data($id));
	} else {//if validates
	    $item_data = $this->populate_from_post();
	    if ($id == null) {
		$item_data['date_created'] = date('Y-m-d H:i:s', time());
	    }
//            if($id == null){
//                $item->date_created = date('Y-m-d H:i:s', time());
//            }
	    $file = $_FILES['featured_image'];
	    if ($file['name']) {
		if ($this->process_upload($id, $item_data)) {
		    $newitem_id = $this->process_insert_update($item_data, $id);
		    if ($newitem_id != null) {
			$id = $newitem_id;
		    }
		    $image_url = $this->save_image($id, $this->upload->data());
		    if ($image_url) {
			//get item back (after original insert) and update it with image url
			$this->save_item_image_url($id, $image_url);
		    }
		}
	    } else {
		$newitem_id = $this->process_insert_update($item_data, $id);
		if ($newitem_id != null) {
		    $id = $newitem_id;
		}
	    }

	    $this->check_send_notification($id, $item_data);

	    //add flash and redirect
	    $action = "";
	    if ($id == null) {
		$action = "added";
	    } else {
		$action = "updated";
	    }
	    $this->session->set_flashdata('success', 'Item successfully ' . $action);
	    redirect('/motelapp/dashboard/' . $this->get_item_name());
	}
    }

    private function process_upload($id, $item_data) {
	$config['upload_path'] = './uploads/';
	$config['allowed_types'] = 'gif|jpg|png';
	$config['max_size'] = 2000;
	$config['max_width'] = 2024;
	$config['max_height'] = 2768;

	$this->load->library('upload', $config);

	if (!$this->upload->do_upload('featured_image')) {
	    $error = array('error' => $this->upload->display_errors('<p>', '</p>'));
	    $data = $this->get_add_edit_data($id);
	    $data['error'] = $error;
	    $data["is_edit"] = ($id == null);
	    $this->load->view('pages/dashboard', $data);
	    return false;
	} else {
	    //$data = array('upload_data' => $this->upload->data());



	    return true;
//                    $this->load->view('upload_success', $data);
	}
    }

    private function check_send_notification($id, $item_data) {
	//if send notification       
	if ($this->input->post('send_notification')=='send_notification') {
	    //send notification
	    //$this->load->config('pushbots');
	    $this->load->helper('notifications');
	    $url = base_url() . "dashboard/coupons/detail/$id/mobile";
	    if (!send_notification($url, $item_data['title'], ucfirst($this->get_simple_item_name()))) {
		//TODO handle send notification error
	    }
	}
    }

    public function process_insert_update($item_data, $id) {
	//save item
	//$item->id = (int) $id;
	if ($id != null) {
	    $item_data['id'] = (int) $id;
	}

	return $this->get_item_instance()->save($item_data, $id);
	//return $item->save($id);
    }

    public function set_default_expiry_date($item) {
	$item->expiry_date = date('Y-m-d H:i:s', time() + (3600 * 24 * 7)); //two weeks ahead of now
    }

    private function save_image($id, $data) {
	$tmp_file_path = $data['full_path'];
	$file_ext = $data['file_ext'];
	$large_width = 600;
	$large_height = 1500; //max height (width x 2.5)
	$thumb_width = 120;
	$thumb_height = 300; //max height (width x 2.5)

	$this->load->library('image_lib');
	//resize and create scaled large image
	$lrg_image_name = $this->resize_image($tmp_file_path, $file_ext, $large_width, $large_height);
	//resize and create thumbnail
	$thumb_image_name = $this->resize_image($tmp_file_path, $file_ext, $thumb_width, $thumb_height);
	$this->load->helper('file');

	$this->load->library('s3');

	$is_uploaded = false;
	$uri = 'image/' . $this->session->userdata("user_id") . '/' . $this->get_item_name() . '/' . $id . '/img';
//        // Simple PUT:
	if ($this->save_to_s3($data, $data['file_path'] . $lrg_image_name, $uri . '_lrg')) {
//            //upload thumb
	    if ($this->save_to_s3($data, $data['file_path'] . $thumb_image_name, $uri . '_thumb')) {
		$is_uploaded = true;
	    } else {
		//TODO error checking
	    }
	} else {
	    //TODO error checking
	}
	if ($is_uploaded) {
	    //clean up
	    delete_files($data['file_path']);
	    return $uri;
	} else {
	    return null;
	}
    }

    private function resize_image($file_path, $file_ext, $width, $height = null) {
	$image_name = '';
	$config['image_library'] = 'gd2';
	$config['source_image'] = $file_path;
	//$config['maintain_ratio'] = TRUE;//will 
	$config['width'] = $width;
	if ($height) {
	    $config['height'] = $height;
	    $image_name = $width . 'x' . $height . '-image' . $file_ext;
	    $width . 'x' . $height . '-image' . $file_ext;
	} else {
	    $image_name = $width . '-width-image' . $file_ext;
	}
	$config['new_image'] = $image_name;

	$this->image_lib->initialize($config);
	$this->image_lib->resize();
	$this->image_lib->clear();

	return $image_name;
    }

    private function save_to_s3($file_data, $file_path, $uri) {
	$bucket = 'robios.com-dev';
	//need to specify content type, otherwise it will be considered application/octet-stream
	$image_type = $file_data['file_type'];

	// Simple PUT:
	if ($this->s3->putObject(S3::inputFile($file_path), $bucket, $uri, S3::ACL_PUBLIC_READ, array(), array('Content-Type' => $image_type), S3::STORAGE_CLASS_RRS)) {
	    //echo "File uploaded.";
	    return $uri;
	} else {
	    //echo "Failed to upload file.";
	    return null;
	}
    }

    private function check_login() {
	if ($this->session->userdata("is_logged_in")) {
	    return true;
	} else {
	    $this->load->view('pages/login');
	    return false;
	}
    }

//     
}
