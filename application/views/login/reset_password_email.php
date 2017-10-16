<!DOCTYPE html>
<html>
<head>
	<title><?php echo lang('login_reset_password'); ?></title>
	<!-- Google Khmer web font -->
	<link href='http://fonts.googleapis.com/css?family=Hanuman:400,700' rel='stylesheet' type='text/css'>
</head>
<body>
<?php echo lang('login_reset_password_message'); ?><br /><br />
<?php echo anchor('login/reset_password_enter_password/'.$reset_key, lang('login_reset_password')); ?>
</body>
</html>