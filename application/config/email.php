<?php defined('BASEPATH') OR exit('No direct script access allowed');
$config = array(
    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => 'mail.parcelbhej.com', 
    'smtp_port' => 587,
    'smtp_user' => 'info@parcelbhej.com',
    'smtp_pass' => 'Snehal@123',
    //'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
    'mailtype' => 'html', //plaintext 'text' mails or 'html'
    //'smtp_timeout' => '4', //in seconds
    'charset' => 'UTF-8',
    'wordwrap' => TRUE
);