<?php

function send_notification($url, $message, $platform = "1") {
    $ci =& get_instance();
    $ci->load->library('Pushbots');
    $ci->config->load('pushbots');
    $pb = new PushBots();
// Application ID
    $appID = $ci->config->item('app_id');
// Application Secret
    $appSecret = $ci->config->item('app_secret');
    $pb->App($appID, $appSecret);

// Notification Settings
    $pb->Alert($message);
    $pb->Platform($platform); //"1" = android
    //$pb->Badge("1");
// Custom fields - payload data
    $customfields = array("nextActivity" => "nz.co.richjavalabs.motelapp.WebActivity", "url" => $url);
    $pb->Payload($customfields);

// Update Alias 
    /**
     * set Alias Data
     * @param	integer	$platform 0=> iOS or 1=> Android.
     * @param	String	$token Device Registration ID.
     * @param	String	$alias New Alias.
     */
//$pb->AliasData(1, "APA91bFpQyCCczXC6hz4RTxxxxx", "test");
// set Alias on the server
//$pb->setAlias();
// Push it !
    $pb->Push();

// Push to Single Device
// Notification Settings
//$pb->AlertOne("test Mesage");
//$pb->PlatformOne("0");
//$pb->TokenOne("3dfc8119fedeb90d1b8a9xxxxxx");
//
////Push to Single Device
//$pb->PushOne();
}
