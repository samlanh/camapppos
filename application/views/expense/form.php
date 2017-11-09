<style type="text/css">
fieldset div.field_row{
border: 0; margin: 0;padding: 0;
}	

</style>

<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<?php
echo form_open('expenses/save/'.$expense_info->id, array('id'=>'expense_form'));
?>
<fieldset id="item_basic_info">

<legend><?php echo lang("expense_basic_information"); ?></legend>

<div class="row">

<div class="col-xs-6">
		<div class="field_row clearfix">
<?php echo form_label(lang('expense_type').' :', 'expense_type',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'expense_type',
		'class'=>'form-control',
		'id'=>'expense_type',
		'value'=>$expense_info->expense_type)
	);?>
	</div>
  </div>
</div>

<div class="col-xs-6">
	 <div class="field_row clearfix">
<?php echo form_label(lang('expense_payment_id').' :', 'payment_id',array('class'=>'required wide')); ?>
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
<?php echo form_label(lang('expense_title').' :', 'expense_title',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'expense_title',
		'class'=>'form-control',
		'id'=>'expense_title',
		'value'=>$expense_info->expense_title)
	);?>
	</div>
  </div>
</div>

<div class="col-xs-6">
   <div class="field_row clearfix">
<?php echo form_label(lang('expense_type_money').' :', 'type_money',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_dropdown('type_money',['Cash'=>lang('expense_cash'),'Check'=>lang('expense_check'),'Bank'=>lang('expense_bank')],$expense_info->type_money,'class="form-control" id="type_money"');?>
	</div>
  </div>
</div>


</div>
<div class="row">


 <div class="col-xs-6">
  	<div class="field_row clearfix">
<?php echo form_label(lang('expense_date').':', 'expense_date',array('class'=>'required wide')); ?>

<div class='form_field' style="clear: both;">            
            <?php echo form_dropdown('day',$days, $selected_day, 'id="day"'); ?>
            <?php echo form_dropdown('month',$months, $selected_month, 'id="month"'); ?>
            <?php echo form_dropdown('year',$years, $selected_year, 'id="year"'); ?>

            <input type="hidden" id="expense_date" name="expense_date" value="<?= $expense_info->expense_date ?>" />
  </div>       
 </div>
</div>

<div class="col-xs-6">
   <div class="field_row clearfix">
<?php echo form_label(lang('expense_check_paper').' :', 'check_paper',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'check_paper',
		'class'=>'form-control',
		'id'=>'check_paper',
		'value'=>$expense_info->check_paper)
	);?>
	</div>
  </div>
</div>


<div class="col-xs-6">
   <div class="field_row clearfix">
<?php echo form_label(lang('expense_total').' $ : ', 'total_expense',array('class'=>'required wide')); ?>

	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'total_expense',
		'class'=>'form-control',
		'id'=>'total_expense',
		'value'=>$expense_info->total_expense)
	);?>
	</div>
  </div>
</div>

<div class="col-xs-12">
   <div class="field_row clearfix">
<?php echo form_label(lang('expense_note').' :', 'note',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_textarea(array(
		'name'=>'note',
		'rows' => 3,   'cols' => 40,
		'class'=>'form-control',
		'id'=>'note',
		'value'=>$expense_info->note)
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
        $("#expense_date").val($("#year").val()+'-'+$("#month").val()+'-'+$('#day').val());
     
    });

	var submitting = false;

	$('#expense_form').validate({
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
				post_expense_form_submit(response);
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules:
		{
			expense_type : "required",
			expense_date : "required",
			expense_title : "required",
			payment_id : "required",
			
			total_expense:
			{
				required:true,
				number:true
			}

   		},
		messages:
		{	
			expense_type : <?php echo json_encode(lang('expense_type_required')); ?>,
			expense_date : <?php echo json_encode(lang('expense_date_required')); ?>,
			expense_title : <?php echo json_encode(lang('expense_payment_title_required')); ?>,
			payment_id : <?php echo json_encode(lang('expense_payment_id_required')); ?>,

			total_expense :
			{
				required:<?php echo json_encode(lang('expense_total_expense_required')); ?>,
				number:<?php echo json_encode(lang('expense_total_expense_number')); ?>
			}
		}
	});



	$("#expense_type").autocomplete({
		source: '<?php echo site_url("expenses/select_expense_type"); ?>',
		delay: 10,
		autoFocus: false,
		minLength: 0,
		select: function(event, ui)
		{	
			$("#expense_type").val(ui.item.label);			
			
		}
	});

	$("#customer_search").mouseleave(function () {
		customer_search = $("#customer_search").val();		
		if(customer_search==''){
			$("#customer_id").val('');
			$("#customer_selected").html('');
		}else{

        $.get( "expenses/get_customer_fullname",{customer_id:customer_search}, function( data ) {  
 		 $("#customer_selected").html(data);
        });
			
		}
	});



});
</script>