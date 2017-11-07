<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


$CI =& get_instance();


$config['smtp_host'] = $CI->Appconfig->get('email_host');
$config['smtp_port'] = $CI->Appconfig->get('email_port');
$config['smtp_user'] = $CI->Appconfig->get('email_send');
$config['smtp_pass'] = $CI->Appconfig->get('password_send');
$config['protocol']  = 'smtp';
$config['validate']  = true;
$config['mailtype']  = 'html';
$config['charset']   = 'utf-8';
$config['newline']   = "\r\n";