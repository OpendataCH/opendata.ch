<?php

require_once('MCAPI.class.php');

// grab an API Key from http://admin.mailchimp.com/account/api/
$api_key = '';
// grab your List's Unique Id by going to http://admin.mailchimp.com/lists/
// Click the "settings" link for the list - the Unique Id is at the bottom of that page.
$list_id = '';

//deutsch
$message_texts['de']['0'] = 'Bitte eine E-Mail Adresse angeben.';
$message_texts['de']['1'] = 'Dies ist keine gültige E-Mail Adresse.';
$message_texts['de']['2'] = 'Diese E-Mail Adresse wurde bereits eingetragen.';
$message_texts['de']['default'] = 'Die Übertragung ist leider fehlgeschlagen.';
$message_texts['de']['success'] = 'Vielen Dank! Eine Bestätigungsmail würde an die angegebene Adresse verschickt.';

//english
$message_texts['en']['0'] = 'Please enter an email address.';
$message_texts['en']['1'] = 'This is not a valid email address.';
$message_texts['en']['2'] = 'This email address is already subscribed.';
$message_texts['en']['default'] = 'The submission failed. Please try again later.';
$message_texts['en']['success'] = 'Thank you! A verification email was sent to the provided address.';

// Validation
if(!$_POST['email']){
    $result = array('success'=>false, 'code'=>'0', 'msg' => $message_texts[$_POST['lang']]['0']);
    echo json_encode($result);
    return;
}

if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $_POST['email'])) {
    $result = array('success'=>false, 'code'=>'1', 'msg' => $message_texts[$_POST['lang']]['1']);
    echo json_encode($result);
    return;
}

$api = new MCAPI($api_key);

if($api->listSubscribe($list_id, $_POST['email']) === true) {
    // It worked!
    $result = array('success'=>true, 'msg'=> $message_texts[$_POST['lang']]['success']);
    echo json_encode($result);
    return;

}else {
    // An error ocurred, return error message
    /*
        200        List_DoesNotExist
        210        List_InvalidInterestFieldType
        211        List_InvalidOption
        212        List_InvalidUnsubMember
        213        List_InvalidBounceMember
        214        List_AlreadySubscribed
        215        List_NotSubscribed
        230        Email_AlreadySubscribed
        231        Email_AlreadyUnsubscribed
        232        Email_NotExists
        233        Email_NotSubscribed
        270        List_InvalidInterestGroup
        271        List_TooManyInterestGroups */

    switch ($api->errorCode) {

        case 214:
            $result = array('success' => false, 'code' => '2', 'msg' => $message_texts[$_POST['lang']]['2']);
            break;

        default:
            $result = array('success' => false, 'code' => $api->errorCode, 'msg' => $message_texts[$_POST['lang']]['default']);
    }

    echo json_encode($result);
    return;
}
	
?>