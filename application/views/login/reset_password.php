<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/login.css?<?php echo APPLICATION_VERSION; ?>" />

<!-- Google Khmer web font -->
<link href='http://fonts.googleapis.com/css?family=Hanuman:400,700' rel='stylesheet' type='text/css'>

<title>PHP Point Of Sale <?php echo lang('login_reset_password'); ?></title>
<script src="<?php echo base_url();?>js/jquery-1.3.2.min.js?<?php echo APPLICATION_VERSION; ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
<script type="text/javascript">
$(document).ready(function()
{
	$("#login_form input:first").focus();
});
</script>
</head>
<body>

<div id="welcome_message" class="top_message">
		<?php echo lang('login_welcome_message'); ?>
		<h2><?php //echo lang('login_reset_password');?></h2>
</div>
	<div style="height:60px;"></div>
	<?php if (validation_errors()) {?>
		<div id="welcome_message" class="top_message_error">
			<?php echo validation_errors(); ?>
		</div>
	<?php } ?>
<?php echo form_open('login/do_reset_password_notify') ?>
<div id="container">
	<div id="top">
		<h4 style="font-family:arial; font-weight: bold;color:#fff;">Reset New Password</h4>
		<?php //echo img(array('src' => $this->Appconfig->get_logo_image()));?>
	</div>
	<table id="login_form">
	
		<tr id="form_field_username">	
			<td class="form_field_label" style="font-size: 10px;"><?php echo lang('login_username'); ?>/<br /><?php echo lang('common_email'); ?>: </td>
			<td class="form_field">
			<?php echo form_input(array(
			'name'=>'username_or_email', 
			'data-dojo-type'=>'dijit/form/ValidationTextBox',
			'missingMessage'=>'សូមបំពេញឈ្មោះអ្នកប្រើប្រាស់!',
			'required'=>'true',
			'placeholder'=>'េខសំងាត់',
			'size'=>'20')); ?>
			</td>
		</tr>		
		<tr id="form_field_submit">	
			<td id="submit_button" colspan="2">
				<?php echo form_submit('login_button',lang('login_reset_password')); ?>
			</td>
		</tr>
	</table>
	<table id="bottom">
		<tr>
			<td id="right">
				<?php echo date("Y")?> <?php echo lang('login_version'); ?> <?php echo APPLICATION_VERSION; ?>
			</td>
		</tr>
	</table>
</div>
<div id="footer">
	<table id="main">
		<tbody><tr>
			<td>
				<label class="textgreen footertitle f_style">អាសយដ្ឋាន​ ៖</label>
				<dl>
				   <lable class="f_style"><b>ផ្ទះលេខ ១៦២ ផ្លូវលេខ ១៥០ សង្កាត់ ទឹកល្អក់១ ទូលគោក ភ្នំពេញ</b></lable><br>
				  	<span class="t_shadow" style="font-weight:bold;font-size:20px;">TEL :(855) 10 78 55 44<span><br>	
					<lable class="t_shadow" style="font-weight:bold; font-size:21px;">www.vssservice.com</lable><br>
					<lable class="t_shadow" style="font-weight:bold; font-size:20px;">E-mail : Borachhay@yahoo.com</lable><br>		   
				</span></span></dl>
				<label class="textgreen footertitle f_style">ប្រើប្រាស់ដោយ៖</label>
				<a style="font-weight:bold;" href="http://www.vssservice.com/" target="_blank"><label class="textyellow footertitle">
					<b>VSS SERVICE</b>
				</label>				
			</a></td>
			<td class="textgreenlight" valign="top">
				<label class="textgreen footertitle f_style">អាសយដ្ឋាន​ ៖</label>
				<dl>
				   <lable class="f_style"><b>ផ្ទះលេខ ១៦២ ផ្លូវលេខ ១៥០ សង្កាត់ ទឹកល្អក់១ ទូលគោក ភ្នំពេញ</b></lable><br>
				  	<span class="t_shadow" style="font-weight:bold;font-size:20px;">TEL :(855) 10 78 55 44<span><br>	
					<lable class="t_shadow" style="font-weight:bold; font-size:21px;">www.vssservice.com</lable><br>
					<lable class="t_shadow" style="font-weight:bold; font-size:20px;">E-mail : Borachhay@yahoo.com</lable><br>		   
				</span></span></dl>
				<label class="textgreen footertitle f_style">© រក្សាសិទ្ធិដោយ</label>
				<a style="font-weight:bold;" href="http://www.vssservice.com/" target="_blank"><label class="textyellow footertitle">
					<b>VSS SERVICE</b>
				</label>	
				<br><br>
			</a></td>
		</tr>
	</tbody></table>
</div>
<?php echo form_close(); ?>
</body>
</html>