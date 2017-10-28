<?php
echo form_open('suppliers/savepayment/'.$person_info->person_id,array('id'=>'supplier_form'));
?>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="supplier_basic_info">
<legend><?php echo lang("suppliers_basic_information"); ?></legend>


<div class="field_row clearfix">	
<?php echo form_label(lang('common_balance_to_pay').':', 'comments'); ?>
	<div class='form_field'>
	<?php echo to_currency($person_info->balance);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label(lang('common_amount').':', 'amount', array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'amount',
		'class'=>'form-control',
		'id'=>'amount',
		'value'=>'')
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label(lang('common_comments').':', 'comments'); ?>
	<div class='form_field'>
	<?php echo form_textarea(array(
		'name'=>'comments',
		'class'=>'form-control',
		'id'=>'comments',
		'value'=>$person_info->comments,
		'rows'=>'5',
		'cols'=>'17')		
	);?>
	</div>
</div>
<button type="submit" class="submit_button pull-right btn btn-primary" name="submit" id="submit"><i class="fa fa-save" aria-hidden="true"></i> <?= lang('common_submit') ?> </button>

<?php /*
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'value'=> lang('common_submit'),
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
	
	$('#supplier_form').validate({
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
				post_person_form_submit(response);
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules: 
		{
			amount:{ required: true, number: true}
   		},
		messages: 
		{
			amount: <?php echo json_encode(lang('common_amount_required')); ?>
		}
	});
});
</script>