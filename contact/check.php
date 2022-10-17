<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/contact/contact.class.php");
$_SESSION['contact-name'] = $_POST['contact-name'];
$_SESSION['contact-email'] = $_POST['contact-email'];
$_SESSION['contact-message'] = $_POST['contact-message'];
$_SESSION['check-box'] = $_POST['rule'];

$arr_err_msg = Contact::check_input($_SESSION['contact-name'],$_SESSION['contact-email'],$_SESSION['contact-message']);
$_SESSION['contact-name-error'] = $arr_err_msg['name'];
$_SESSION['contact-email-error'] = $arr_err_msg['email'];
$_SESSION['contact-message-error'] = $arr_err_msg['message'];

if(empty($arr_err_msg['name']) && empty($arr_err_msg['email']) && empty($arr_err_msg['message'])) {
    header('Location: /contact/confirm.php');
}else{
    header('Location: /contact/index.php');
}