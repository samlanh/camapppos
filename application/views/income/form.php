<style type="text/css">
fieldset div.field_row{
border: 0; margin: 0;padding: 0;
}	

</style>

<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<?php
echo form_open('incomes/save/'.$income_info->id, array('id'=>'income_form'));
?>
<fieldset id="item_basic_info">

<legend><?php echo lang("income_basic_information"); ?></legend>

<div class="row">

 <div class="col-xs-6">
		<div class="field_row clearfix">
<?php echo form_label(lang('income_type').' :', 'income_type',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'income_type',
		'class'=>'form-control',
		'id'=>'income_type',
		'value'=>$income_info->income_type)
	);?>
	</div>
  </div>
</div>

<div class="col-xs-6">
	 <div class="field_row clearfix">
<?php echo form_label(lang('income_payment_id').' :', 'payment_id',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'payment_id',
		'class'=>'form-control',
		'id'=>'payment_id',
		'value'=>$payment_id)
	);?>
	</div>
  </div>
</div>

 <div class="col-xs-6">
		<div class="field_row clearfix">
<?php echo form_label(lang('income_title').' :', 'income_title',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'income_title',
		'class'=>'form-control',
		'id'=>'income_title',
		'value'=>$income_info->income_title)
	);?>
	</div>
  </div>
</div>

<div class="col-xs-6">
   <div class="field_row clearfix">
<?php echo form_label(lang('income_type_money').' :', 'type_money',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_dropdown('type_money',['Cash'=>lang('income_cash'),'Check'=>lang('income_check'),'Bank'=>lang('income_bank')],$income_info->type_money,'class="form-control" id="type_money"');?>
	</div>
  </div>
</div>

</div>
<div class="row">

 <div class="col-xs-6">
  	<div class="field_row clearfix">
<?php echo form_label(lang('income_date').':', 'income_date',array('class'=>'required wide')); ?>

<div class='form_field' style="clear: both;">            
            <?php echo form_dropdown('day',$days, $selected_day, 'id="day"'); ?>
            <?php echo form_dropdown('month',$months, $selected_month, 'id="month"'); ?>
            <?php echo form_dropdown('year',$years, $selected_year, 'id="year"'); ?>

            <input type="hidden" id="income_date" name="income_date" value="<?= $income_info->income_date ?>" />
  </div>       
 </div>
</div>

<div class="col-xs-6">
   <div class="field_row clearfix">
<?php echo form_label(lang('income_check_paper').' :', 'check_paper',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'check_paper',
		'class'=>'form-control',
		'id'=>'check_paper',
		'value'=>$income_info->check_paper)
	);?>
	</div>
  </div>
</div>


<div class="col-xs-6">
   <div class="field_row clearfix">
<?php echo form_label(lang('income_total').' $ : ', 'total_income',array('class'=>'required wide')); ?>

	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'total_income',
		'class'=>'form-control',
		'id'=>'total_income',
		'value'=>$income_info->total_income)
	);?>
	</div>
  </div>
</div>

<div class="col-xs-12">
   <div class="field_row clearfix">
<?php echo form_label(lang('income_note').' :', 'note',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_textarea(array(
		'name'=>'note',
		'rows' => 3,   'cols' => 40,
		'class'=>'form-control',
		'id'=>'note',
		'value'=>$income_info->note)
	);?>
	</div>
  </div>
</div>

</div>

<hr>

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
        $("#income_date").val($("#year").val()+'-'+$("#month").val()+'-'+$('#day').val());
     
    });


	var submitting = false;

	$('#income_form').validate({
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
				post_income_form_submit(response);
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules:
		{
		
			income_date : "required",
			income_title : "required",
			payment_id : "required",
			
			total_income:
			{
				required:true,
				number:true
			}

   		},
		messages:
		{	
			income_date : <?php echo json_encode(lang('income_date_required')); ?>,
			income_title : <?php echo json_encode(lang('income_payment_title_required')); ?>,
			payment_id : <?php echo json_encode(lang('income_payment_id_required')); ?>,

			total_income :
			{
				required:<?php echo json_encode(lang('income_total_income_required')); ?>,
				number:<?php echo json_encode(lang('income_total_income_number')); ?>
			}
		}
	});


	$("#income_type").autocomplete({
		source: '<?php echo site_url("incomes/select_income_type"); ?>',
		delay: 10,
		autoFocus: false,
		minLength: 0,
		select: function(event, ui)
		{	
			$("#income_type").val(ui.item.label);			
		}
	});

	$("#customer_search").mouseleave(function () {
		customer_search = $("#customer_search").val();		
		if(customer_search==''){
			$("#customer_id").val('');
			$("#customer_selected").html('');
		}else{

        $.get( "incomes/get_customer_fullname",{customer_id:customer_search}, function( data ) {  
 		 $("#customer_selected").html(data);
        });
			
		}
	});



});
</script>