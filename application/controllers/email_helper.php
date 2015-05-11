<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('send_email'))
{
    function send_email($subject, $email, $message)
    {
        $ci = get_instance();
        $ci->config->load('email');
        $admin_email = $ci->config->item('smtp_user');
        $config = Array(
            'protocol' => 'sendmail',
            'smtp_host' => 'relay-hosting.secureserver.net',
            'smtp_port' => 25,
            'smtp_user' => $admin_email,
            'smtp_pass' => $ci->config->item('smtp_pass'),
            'mailtype' => 'html',
            'charset' => 'utf-8'
        );
        $ci->load->library('email', $config);
        $ci->email->set_newline("\r\n");
        $ci->email->from($admin_email); //$this->input->post('email'), $this->input->post('name'));
        $ci->email->to($email);
        $ci->email->subject($subject); //"Inquiry ".date('Y-m-d H:i:s'));
        $ci->email->message($message); //$this->input->post('comment'));
        //send email
        if ($ci->email->send()) {
            return true;
        } else {
            //development only, change if used in production
            //show_error($this->email->print_debugger());
            $errors = $ci->email->get_debugger_messages();
            echo $errors;
        }
    }   
}