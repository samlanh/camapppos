<?php

echo form_open('mail/send',array('id'=>'mail_form'));
?>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="supplier_basic_info">
<legend>Send Information</legend>

<div class="field_row clearfix">	
<?php echo form_label('Email * : ', 'email',array('style' => 'color:red' )); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'email',
		'class'=>'form-control',
		'id'=>'email',
		'value'=>$mail)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label('Subject * :', 'subject',  array('style' => 'color:red')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'subject',
		'class'=>'form-control',
		'id'=>'subject',
		'value'=>'')
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label('Comment :', 'comment'); ?>
	<div class='form_field'>
	<?php echo form_textarea(array(
		'name'=>'comment',
		'class'=>'form-control',		
		'id'=>'comment',
		'rows'=>'6',
		'value'=>'')
	);?>
	</div>
</div>

<button type="submit" class="submit_button pull-right btn btn-primary" name="submit" id="submit"><i class="fa fa-save" aria-hidden="true"></i> <?= lang('common_submit') ?> </button>

<?php /**
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'value'=>lang('common_submit'),
	'class'=>'submit_button float_right')
); */
?>
</fieldset>
<?php 
echo form_close();
?>
<script type='text/javascript'>

//validation and submit handling
$(document).ready(function()
{
	var submitting = false;
	
	$('#mail_form').validate({
		submitHandler:function(form)
		{
			if (submitting) return;
			submitting = true;
			$(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
			$(form).ajaxSubmit({
			success:function(response)
			{	
				console.log(response);
				
				tb_remove();
				submitting = false;	
		
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules: 
		{
			email: "required",
			subject: "required"		
   		},
		messages: 
		{
     		subject: 'Subject is required',
     		email: <?php echo json_encode(lang('common_email_invalid_format')); ?>
		}
	});
});
</script>