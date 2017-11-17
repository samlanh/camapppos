<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<?php
echo form_open('exchanges/save/'.$exchange_info->id, array('id'=>'exchange_form'));
?>
<fieldset id="item_basic_info">

<legend><?php echo lang("exchage_basic_information"); ?></legend>

<div class="field_row clearfix">
<?php echo form_label(lang('exchange_dollar').':', 'exchange_dollar',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'dollar',
		'class'=>'form-control',
		'id'=>'dollar',
		'readonly'=>true,
		'value'=>1)
	);?>
	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label(lang('exchange_reil').':', 'exchange_reil',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'reil',
		'class'=>'form-control',
		'id'=>'reil',
		'value'=>$exchange_info->reil)
	);?>
	</div>
</div>


<div class="field_row clearfix">
<?php echo form_label(lang('exchange_date').':', 'exchange_date',array('class'=>'required wide')); ?>

<div class='form_field col-12'>            
            <?php echo form_dropdown('day',$days, $selected_day, 'id="day"'); ?>
            <?php echo form_dropdown('month',$months, $selected_month, 'id="month"'); ?>
            <?php echo form_dropdown('year',$years, $selected_year, 'id="year"'); ?>
            
            <input type="hidden" id="date" name="date" value="<?php echo $exchange_info->date;?>" />
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
    $('#year,#month,#day').change(function()
    {
        $("#date").val($("#year").val()+'-'+$("#month").val()+'-'+$('#day').val());
     
    });


	var submitting = false;

	$('#exchange_form').validate({
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
				post_exchange_form_submit(response);
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules:
		{
			date : "required",
			reil:
			{
				required:true,
				number:true
			},

			dollar:
			{
				required:true,
				number:true
			}

   		},
		messages:
		{	
			date : <?php echo json_encode(lang('exchange_date_required')); ?>,
		
			reil:
			{
				required:<?php echo json_encode(lang('exchange_reil_required')); ?>,
				number:<?php echo json_encode(lang('exchange_reil_number')); ?>
			},
			dollar:
			{
				required:<?php echo json_encode(lang('exchange_dollar_required')); ?>,
				number:<?php echo json_encode(lang('exchange_dollar_number')); ?>
			}
		}
	});
});
</script>