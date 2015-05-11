<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('send_email'))
{
    function send_email($subject, $message, $email = null)
    {
        $ci = get_instance();
        $ci->config->load('email');
        if(!$email){
            $email = $ci->config->item('smtp_user');
        }
 
//        $config = Array(
//            'protocol' => 'sendmail',
//            'smtp_host' => 'relay-hosting.secureserver.net',
//            'smtp_port' => 25,
//            'smtp_user' => "richard@robios.co.nz",//$email,
//            'smtp_pass' => ,//$ci->config->item('smtp_pass'),
//            'mailtype' => 'html',
//            'charset' => 'utf-8'
//        );
        $ci->load->library('email');
        $ci->email->set_newline("\r\n");
        $ci->email->from($email); //$this->input->post('email'), $this->input->post('name'));
        $ci->email->to("richjavalabs@gmail.com");//$email);
        $ci->email->subject($subject); //"Inquiry ".date('Y-m-d H:i:s'));
        $ci->email->message($message);////$this->input->post('comment'));
        //send email
        if ($ci->email->send()) {
            return true;
        } else {
            return false;
        }
    }   
}