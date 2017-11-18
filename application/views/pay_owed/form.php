<?php
echo form_open('payoweds/save_payowed',array('id'=>'payowed_form'));
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
		'id'=>'company_name',
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

<div class="row">
	<div class="col-xs-12"> 
	<table id="item_kit_items" class="table">
	<tr>
		<th><?= lang('payoweds_sale_id') ?></th>
		<th><?= lang('payoweds_payment_date') ?></th>
		<th><?= lang('payoweds_total_amount') ?></th>
		<th><?= lang('payoweds_payment_amount') ?></th>
		<th><?= lang('payoweds_remain_balance') ?></th>
	</tr>	
	<?php 
	foreach ($payment_owed->result() as $value) {?>
		<tr>
			<td>POS <?= $value->sale_id ?></td>		
			<td><?= date('d-M-Y',strtotime($value->payment_date)) ?></td>
			<td><?= to_currency($value->total_amount) ?></td>
			<td><?= to_currency($value->payment_amount) ?></td>
			<td><?= to_currency($value->remain_balance) ?></td>		
		</tr>
	<?php } ?>
</table>

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
<?php echo form_label(lang('payoweds_total_amount').' :', 'common_total',array('class'=>'wide')); ?>
	<div class='form-group'>
	<?php echo form_input(array(
		'name'=>'total_amount',
		'class'=>'form-control',
		'id'=>'total_amount',
		'readonly'=>true,
		'value'=>to_currency($total)));?>		
	</div>	
</div>

<input type="hidden" name="total_amount_hidden" id="total_amount_hidden" value="<?= $total ?>" >

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

<input type="hidden" name="total_amount_hidden" id="total_amount_hidden" value="<?= $total ?>" >

<div class="col-xs-6 col-xs-offset-6">	
	<?php echo form_label(lang('payoweds_remain_balance').' :', 'remain_balance'); ?>
	<div class='form-group'>
	<?php echo form_input(array(
		'name'=>'remain_balance',
		'class'=>'form-control',
		'id'=>'remain_balance',
		'readonly'=>true,
		'value'=>$total));?>
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
		calc_payment_amount_reil();		
	});
$('#payment_amount_reil').blur(function () {			
		calc_payment_amount_reil();		
	});
$('#payment_amount_reil').change(function () {			
		calc_payment_amount_reil();		
	});

	function calc_payment_amount_reil() {		
		 payment_amount_reil = $('#payment_amount_reil').val();	
		 payment_amount_dollar = $('#payment_amount_dollar').val();	
		 exchange_reil = $('#exchange_rate_reil').val();
		 exchange_to_reil = payment_amount_reil / exchange_reil;
		total_to_dollar = Number(payment_amount_dollar) + Number(exchange_to_reil);
		$('#payment_amount').val(parseFloat(total_to_dollar).toFixed(2));
		total_amount = $('#total_amount_hidden').val();
		remain_balance = Number(total_amount) - Number(total_to_dollar);
		$('#remain_balance').val(parseFloat(remain_balance).toFixed(2));
	}

	$('#payment_amount_dollar').keydown(function () {
		calc_payment_amount_dollar();
	});

	$('#payment_amount_dollar').blur(function () {
		calc_payment_amount_dollar();
	});

	$('#payment_amount_dollar').change(function () {
		calc_payment_amount_dollar();
	});

function calc_payment_amount_dollar() {
		payment_amount_reil = $('#payment_amount_reil').val();	
		 payment_amount_dollar = $('#payment_amount_dollar').val();	
		 exchange_reil = $('#exchange_rate_reil').val();
		 exchange_to_reil = payment_amount_reil / exchange_reil;
			total_to_dollar = Number(payment_amount_dollar) + Number(exchange_to_reil);
		$('#payment_amount').val(parseFloat(total_to_dollar).toFixed(2));
		total_amount = $('#total_amount_hidden').val();
		remain_balance = Number(total_amount) - Number(total_to_dollar);
		$('#remain_balance').val(parseFloat(remain_balance).toFixed(2));
}

if(<?=$this->session->userdata('customer') ?> === -1){
	tb_remove();
}

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
				submitting = false;
				window.location = window.location+'/receipt_owed/'+ response.sale_id;
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