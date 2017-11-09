<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<?php
echo form_open('exchanges/save/'.$expense_income_category_info->id, array('id'=>'expense_income_category_form'));
?>
<fieldset id="item_basic_info">

<legend><?php echo lang("expense_income_category_basic_information"); ?></legend>

<div class="field_row clearfix">
<?php echo form_label(lang('expense_income_category_name').':', 'name',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'name',
		'class'=>'form-control',
		'id'=>'name',
		'value'=>$expense_income_category_info->name)
	);?>
	</div>
</div>

<button type="submit" class="submit_button pull-right btn btn-primary" name="submit" id="submit"><i class="fa fa-save" aria-hidden="true"></i> <?= lang('common_submit') ?> </button>
<?php
/*
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

	$('#expense_income_category_form').validate({
		submitHandler:function(form)
		{
			if (submitting) return;
			submitting = true;
			$(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
			$(form).ajaxSubmit({
			success:function(response)
			{
				submitting = false;
				tb_remove();				
				post_expense_income_category_form_submit(response);
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules:
		{
			name : "required"		
   		},
		messages:
		{	
			name : <?php echo json_encode(lang('expense_income_category_name_required')); ?>	
			
		}
	});
});
</script>