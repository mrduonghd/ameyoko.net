<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/contact/contact.class.php");
$error_msg = Contact::check_input($_SESSION['contact-name'] ,$_SESSION['contact-email'] ,$_SESSION['contact-message']);
$_SESSION['contact-name-error'] = $error_msg['name'];
$_SESSION['contact-email-error'] = $error_msg['email'];
$_SESSION['contact-message-error'] = $error_msg['message'];

if($error_msg['name'] && $error_msg['email'] && $error_msg['message']) {
    header('Location: /contact/index.php');
} else {
    if(Contact::send_contact_mail()) {
        header('Location: /contact/thanks.php');
        session_destroy();
    }else {
        header('Location: /contact/error.php');
    }
}
