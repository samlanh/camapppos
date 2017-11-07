<?php
echo form_open('employees/save/'.$person_info->person_id,array('id'=>'employee_form'));
?>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="employee_basic_info">
<legend><?php echo lang("employees_basic_information"); ?></legend>

<?php $this->load->view("people/form_basic_info"); ?>

</fieldset>

<fieldset id="employee_login_info">
<legend><?php echo lang("employees_login_info"); ?></legend>
<div class="field_row clearfix">	
<?php echo form_label(lang('employees_username').':', 'username',array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'username',
		'class'=>'form-control',
		'id'=>'username',
		'value'=>$person_info->username));?>
	</div>
</div>

<?php
$password_label_attributes = $person_info->person_id == "" ? array('class'=>'required'):array();
?>

<div class="field_row clearfix">	
<?php echo form_label(lang('employees_password').':', 'password',$password_label_attributes); ?>
	<div class='form_field'>
	<?php echo form_password(array(
		'name'=>'password',
		'class'=>'form-control',
		'id'=>'password'
	));?>
	</div>
</div>


<div class="field_row clearfix">	
<?php echo form_label(lang('employees_repeat_password').':', 'repeat_password',$password_label_attributes); ?>
	<div class='form_field'>
	<?php echo form_password(array(
		'name'=>'repeat_password',
		'class'=>'form-control',
		'id'=>'repeat_password'
	));?>
	</div>
</div>
</fieldset>

<fieldset id="employee_permission_info">
<legend><?php echo lang("employees_permission_info"); ?></legend>
<p><?php echo lang("employees_permission_desc"); ?></p>

<ul id="permission_list">
<?php
foreach($all_modules->result() as $module)
{
?>
<li>	
<?php echo form_checkbox("permissions[]",$module->module_id,$this->Employee->has_module_permission($module->module_id,$person_info->person_id),  "class='module_checkboxes'"); ?>
<span class="medium"><?php echo $this->lang->line('module_'.$module->module_id);?>:</span>
<span class="small"><?php echo $this->lang->line('module_'.$module->module_id.'_desc');?></span>
	
<br/>
<ul style="display: -webkit-inline-box;">
	<?php
	foreach($this->Module_action->get_module_actions($module->module_id)->result() as $module_action)
	{
		?>
		<li>
		<?php echo form_checkbox("permissions_actions[]",$module_action->module_id."|".$module_action->action_id,$this->Employee->has_module_action_permission($module->module_id, $module_action->action_id, $person_info->person_id)); ?>
		<span class="medium"><?php echo $this->lang->line($module_action->action_name_key);?></span>
		</li>
	<?php
	}
	?>
	</ul>
</li>
<?php
}
?>
</ul>

<button type="submit" class="submit_button pull-right btn btn-primary" name="submit" id="submit"><i class="fa fa-save" aria-hidden="true"></i> <?= lang('common_submit') ?> </button>

<?php /*
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
	$(".module_checkboxes").change(function()
	{
		if ($(this).attr('checked'))
		{
			$(this).parent().find('input[type=checkbox]').attr('checked', 'checked');
		}
		else
		{
			$(this).parent().find('input[type=checkbox]').attr('checked', '');			
		}
	});
	
	var submitting = false;

	$('#employee_form').validate({
		submitHandler:function(form) {
			if (submitting) return;
			submitting = true;
			$(form).mask(<?php echo json_encode(lang('common_wait')); ?>);	

			$(form).ajaxSubmit({
			success:function(response)
			{
				tb_remove();
				post_person_form_submit(response);
				submitting = false;
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules: 
		{
			first_name: "required",
			last_name: "required",
			username:
			{
				required:true,
				minlength: 4
			},
			
			password:
			{
				<?php
				if($person_info->person_id == "")
				{
				?>
				required:true,
				<?php
				}
				?>
				minlength: 6
			},	
			repeat_password:
			{
 				equalTo: "#password"
			},
    		email: "email"
   		},
		messages: 
		{
     		first_name: <?php echo json_encode(lang('common_first_name_required')); ?>,
     		last_name: <?php echo json_encode(lang('common_last_name_required')); ?>,
     		username:
     		{
     			required: <?php echo json_encode(lang('employees_username_required')); ?>,
     			minlength: <?php echo json_encode(lang('employees_username_minlength')); ?>
     		},
     		
			password:
			{
				<?php
				if($person_info->person_id == "")
				{
				?>
				required:<?php echo json_encode(lang('employees_password_required')); ?>,
				<?php
				}
				?>
				minlength: <?php echo json_encode(lang('employees_password_minlength')); ?>
			},
			repeat_password:
			{
				equalTo: <?php echo json_encode(lang('employees_password_must_match')); ?>
     		},
     		email: <?php echo json_encode(lang('common_email_invalid_format')); ?>
		}
	});
});
</script>