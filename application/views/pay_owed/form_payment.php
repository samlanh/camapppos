<?php
echo form_open('payoweds/save/'.$owed_info->id,array('id'=>'payowed_form'));
?>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="customer_basic_info">
<legend><?php echo lang("payment_owed_customers_basic_information"); ?></legend>

<div class="row" style="margin: 0px;">

<div class="col-xs-6">
<?php echo form_label(lang('common_first_name').':', 'first_name',array('class'=>'wide')); ?>
	<div class='form-group'>
	<?php echo form_input(array(
		'name'=>'first_name',
		'class'=>'form-control',
		'id'=>'first_name',
		'readonly'=>true,
		'value'=>$person_info->first_name));?>		
	</div>	
</div>

<div class="col-xs-6">	
	<?php echo form_label(lang('common_last_name').':', 'last_name'); ?>
	<div class='form-group'>
	<?php echo form_input(array(
		'name'=>'last_name',
		'class'=>'form-control',
		'readonly'=>true,
		'id'=>'last_name',
		'value'=>$person_info->last_name));?>
	</div>
</div>

<div class="col-xs-6">
<?php echo form_label(lang('common_email').':', 'email',array('class'=>'wide')); ?>
	<div class='form-group'>
	<?php echo form_input(array(
		'name'=>'email',
		'readonly'=>true,
		'class'=>'form-control',
		'id'=>'email',
		'value'=>$person_info->email));?>		
	</div>	
</div>

<div class="col-xs-6">	
	<?php echo form_label(lang('common_phone_number').':', 'phone_number'); ?>
	<div class='form-group'>
	<?php echo form_input(array(
		'name'=>'phone_number',
		'class'=>'form-control',
		'readonly'=>true,
		'id'=>'phone_number',
		'value'=>$person_info->phone_number));?>
	</div>
</div>
</div>

<hr>

<div class="row" style="margin: 0px;">

<div class="col-xs-6">

<?php echo form_label(lang('payoweds_exchange_rate').' :', 'exchange_rate',array('class'=>'wide')); ?>

	<div class='form-group'>
	<?php echo form_input(array(
		'name'=>'exchange_rate',
		'class'=>'form-control',
		'id'=>'exchange_rate',
		'readonly'=>true,
		'value'=>to_number_money_reil($this->Exchange->select_last_exchange_rate_to_reil())
		));?>		
	</div>	

</div>

<input type="hidden" name="exchange_rate_reil" value="<?= $this->Exchange->select_last_exchange_rate_to_reil() ?>" id="exchange_rate_reil">

<div class="col-xs-6">
<?php echo form_label(lang('payoweds_total_remain_before').' :', 'common_total',array('class'=>'wide')); ?>
	<div class='form-group'>
	<?php echo form_input(array(
		'name'=>'total_amount',
		'class'=>'form-control',
		'id'=>'total_amount',
		'readonly'=>true,
		'value'=>to_currency($owed_info->remain_balance)));?>		
	</div>	
</div>

<input type="hidden" name="payowed_before_hidden" id="payowed_before_hidden" value="<?= $owed_info->payment_amount ?>" >

<input type="hidden" name="remain_balance_before_hidden" id="remain_balance_before_hidden" value="<?= $owed_info->remain_balance ?>" >

<input type="hidden" name="total_amount_hidden" id="total_amount_hidden" value="<?= $owed_info->total_amount ?>" >

<input type="hidden" value="<?= $person_info->person_id; ?>" name="customer_id">

<input type="hidden" value="<?= $owed_info->sale_id; ?>" name="sale_id">

<div class="col-xs-6 col-xs-offset-6" style="padding-left: 0; padding-right: 2px;">	

<div class="col-xs-6">
	<?php echo form_label(lang('payoweds_payment_dollar').' :', 'payment_amount_dollar'); ?>
	<div class='form-group'>
	<?php echo form_input(array(
		'name'=>'payment_amount_dollar',
		'class'=>'form-control',
		'id'=>'payment_amount_dollar',
		'value'=>0));?>
	</div>
</div>

<div class="col-xs-6">
	<?php echo form_label(lang('payoweds_payment_reil').' :', 'payment_amount_reil'); ?>
	<div class='form-group'>
	<?php echo form_input(array(
		'name'=>'payment_amount_reil',
		'class'=>'form-control',
		'id'=>'payment_amount_reil',
		'value'=>0));?>
	</div>
 </div>
</div>

<div class="col-xs-6 col-xs-offset-6">	
	<?php echo form_label(lang('payoweds_payment_amount').' :', 'payment_amount'); ?>
	<div class='form-group'>
	<?php echo form_input(array(
		'name'=>'payment_amount',
		'class'=>'form-control',
		'id'=>'payment_amount',
		'readonly'=>true,
		'value'=>0));?>
	</div>
</div>

<input type="hidden" name="total_amount_hidden" id="total_amount_hidden" value="<?= $owed_info->total_amount ?>" >

<div class="col-xs-6 col-xs-offset-6">	
	<?php echo form_label(lang('payoweds_remain_balance').' :', 'remain_balance'); ?>
	<div class='form-group'>
	<?php echo form_input(array(
		'name'=>'remain_balance',
		'class'=>'form-control',
		'id'=>'remain_balance',
		'readonly'=>true,
		'value'=>$owed_info->remain_balance));?>
	</div>
   </div>
 </div>
</div>

<button type="submit" class="submit_button pull-right btn btn-primary" name="submit" id="submit"><i class="fa fa-save" aria-hidden="true"></i> <?= lang('common_submit') ?> </button>

</fieldset>
<?php 
echo form_close();
?>
<script type='text/javascript'>

//validation and submit handling
$(document).ready(function()
{

$('#payment_amount_reil').keydown(function () {			
	
		 payment_amount_reil = $('#payment_amount_reil').val();	
		 payment_amount_dollar = $('#payment_amount_dollar').val();	
		 exchange_reil = $('#exchange_rate_reil').val();
		 exchange_to_reil = payment_amount_reil / exchange_reil;
			total_to_dollar = Number(payment_amount_dollar) + Number(exchange_to_reil);
		$('#payment_amount').val(parseFloat(total_to_dollar).toFixed(2));
		remain_balance_before_hidden = $('#remain_balance_before_hidden').val();
		remain_balance = Number(remain_balance_before_hidden) - Number(total_to_dollar);
		$('#remain_balance').val(parseFloat(remain_balance).toFixed(2));
		console.log(remain_balance);

	});

	$('#payment_amount_dollar').keydown(function () {

		payment_amount_reil = $('#payment_amount_reil').val();	
		 payment_amount_dollar = $('#payment_amount_dollar').val();	
		 exchange_reil = $('#exchange_rate_reil').val();
		 exchange_to_reil = payment_amount_reil / exchange_reil;
			total_to_dollar = Number(payment_amount_dollar) + Number(exchange_to_reil);
		$('#payment_amount').val(parseFloat(total_to_dollar).toFixed(2));
		remain_balance_before_hidden = $('#remain_balance_before_hidden').val();
		remain_balance = Number(remain_balance_before_hidden) - Number(total_to_dollar);
		$('#remain_balance').val(parseFloat(remain_balance).toFixed(2));
		console.log(remain_balance);

	});

	var submitting = false;
	$('#payowed_form').validate({
		submitHandler:function(form)
		{
			if (submitting) return;
			submitting = true;
			$(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
			$(form).ajaxSubmit({
			success:function(response)
			{
				tb_remove();
			    post_pay_owed_form_submit(response);				
				submitting = false;
				window.location = window.location+'/receipt/'+ response.id;
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules: 
		{
		payment_amount_dollar: {
      	required: true,
     	 number: true
   		 },
   		 payment_amount_reil: {
      	 required: true,
     	 number: true
   		 }
				
   		},
		messages: 
		{
     	payment_amount_dollar : <?php echo json_encode(lang('common_required_money')); ?>,
     	payment_amount_reil: <?php echo json_encode(lang('common_required_money')); ?>,     		
		}
	});
});
</script>