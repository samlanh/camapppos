<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="icon" href="<?php echo base_url();?>favicon.ico" type="image/x-icon"/>
<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/login.css?<?php echo APPLICATION_VERSION; ?>" />

<!-- Google Khmer web font -->
<link href='http://fonts.googleapis.com/css?family=Hanuman:400,700' rel='stylesheet' type='text/css'>

<title>PHP Point Of Sale <?php echo lang('login_login'); ?></title>

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


		<?php if (isset($subscription_cancelled_within_30_days) && $subscription_cancelled_within_30_days === true) { ?>
			<div class="top_message_error"><?php echo lang('login_subscription_cancelled_within_30_days'); ?></div>
		<?php } ?>
		<?php
		if ($_SERVER['HTTP_HOST'] == 'demo.phppointofsale.com' || $_SERVER['HTTP_HOST'] == 'demo.phppointofsalestaging.com')
		{
		?>
			<h2>Press login to continue</h2>
		<?php
		}
		?>
	</div>
		<div style="height:60px;"></div>
		<div id="marquee" style="clear:both;">
			<marquee behavior="scroll" direction="left" onmouseout="this.start()" onmouseover="this.stop()" scrollamount="5">VSS Consultancy : ផ្ដល់សេវាកម្ម ផ្នែកបច្ចេកទេសព័ត៏មានវទ្យា​ ​ជាមួយតំលែទាបបំផុត</marquee>
		</div>	
	<?php if (validation_errors()) {?>
		<div id="welcome_message" class="top_message_error">
			<?php echo lang('login_welcome_message'); ?>
		</div>
	<?php } ?>
<?php echo form_open('login') ?>
<div id="container">
	<div id="top">
		<?php //echo img(array('src' => $this->Appconfig->get_logo_image()));?>
		<?php echo validation_errors(); ?>
	</div>
	<table id="login_form">
	
		<tr id="form_field_username">	
			<td class="form_field_label"><?php echo lang('login_username'); ?>: </td>
			<td class="form_field"   >
			<?php echo form_input(array(
			'name'=>'username', 
			'value'=> $_SERVER['HTTP_HOST'] == 'demo.phppointofsale.com' || $_SERVER['HTTP_HOST'] == 'demo.phppointofsalestaging.com' ? 'admin' : '',
			'size'=>'20',
			'required'=>'true',
			'missingMessage'=>'ឈ្មោះអ្នកប្រើប្រាស់!',
			'placeholder'=>'ឈ្មោះអ្នកប្រើប្រាស់',
			'data-dojo-type'=>'dijit/form/ValidationTextBox'
			)); ?>
			</td>
		</tr>
	
		<tr id="form_field_password">	
			<td class="form_field_label"><?php echo lang('login_password'); ?>: </td>
			<td class="form_field">
			<?php echo form_password(array(
			'name'=>'password', 
			'value'=>$_SERVER['HTTP_HOST'] == 'demo.phppointofsale.com' || $_SERVER['HTTP_HOST'] == 'demo.phppointofsalestaging.com' ? 'pointofsale' : '',
			'size'=>'20',
			'required'=>'true',
			'missingMessage'=>'សូមបំពេញលេខសំងាត់!',
			'placeholder'=>'លេខសំងាត់!',
			'data-dojo-type'=>'dijit/form/ValidationTextBox'
			)); ?>

			</td>
		</tr>
		
		<tr id="form_field_submit">	
			<td id="submit_button" colspan="2">
				<?php echo form_submit('login_button',lang('login_login')); ?>
			</td>
		</tr>
	</table>
	<table id="bottom">
		<tr>
			<td id="left">
				<?php echo anchor('login/reset_password', lang('login_reset_password')); ?> 
			</td>
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