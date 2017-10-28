<?php $this->load->view("partial/header"); ?>

<div class="container" style=" padding-right: 0px; padding-left: 0px;">
		<div class="row" style=" margin-right: 0px; margin-left: 0px;">
	
			<div class="col-xs-6 col-xs-offset-3" style="padding-right: 5px; padding-left: 5px;">
				<div class="panel panel-default">
					<div class="panel-heading clearfix">
			
	    <img height="30px" src='<?php echo base_url()?>images/menubar/receivings.png' alt='title icon' />
		
		<?php echo lang('receivings_register')." - ".lang('receivings_edit_receiving'); ?> RECV <?php echo $receiving_info['receiving_id']; ?>

					</div>
					<div class="panel-body" style="padding:15px;">
					
					<fieldset>
	<?php echo form_open("receivings/save/".$receiving_info['receiving_id'],array('id'=>'receivings_edit_form')); ?>
	<ul id="error_message_box"></ul>
	
	<div class="field_row clearfix">
	<?php echo form_label(lang('receivings_receipt').':', 'receipt'); ?>
		<div class='form_field'>
			<?php echo anchor('receivings/receipt/'.$receiving_info['receiving_id'], 'RECV '.$receiving_info['receiving_id'], array('target' => '_blank'));?>
		</div>
	</div>
	
	<div class="field_row clearfix">
	<?php echo form_label(lang('sales_date').':', 'date'); ?>
		<div class='form_field'>
			<?php echo form_input(array('name'=>'date','value'=>date(get_date_format(), strtotime($receiving_info['receiving_time'])), 'id'=>'date'));?>
		</div>
	</div>
	
	<div class="field_row clearfix">
	<?php echo form_label(lang('receivings_supplier').':', 'supplier'); ?>
		<div class='form_field'>
			<?php echo form_dropdown('supplier_id', $suppliers, $receiving_info['supplier_id'], 'id="supplier_id" class="form-control" style="width:70%;"');?>
		</div>
	</div>
	
	<div class="field_row clearfix">
	<?php echo form_label(lang('sales_employee').':', 'employee'); ?>
		<div class='form_field'>
			<?php echo form_dropdown('employee_id', $employees, $receiving_info['employee_id'], 'id="employee_id" class="form-control" style="width:70%;"');?>
		</div>
	</div>
	
	<div class="field_row clearfix">
	<?php echo form_label(lang('sales_comment').':', 'comment'); ?>
		<div class='form_field'>
			<?php echo form_textarea(array('name'=>'comment','value'=>$receiving_info['comment'],'rows'=>'4','style'=>'width:70%;', 'class'=>'form-control','id'=>'comment'));?>
		</div>
	</div>

	<button type="submit" class="submit_button pull-right btn btn-primary" name="submit" id="submit" style="margin-left: 5px;"><i class="fa fa-save" aria-hidden="true"></i> <?= lang('common_submit') ?> </button>
	
	<?php /*
	echo form_submit(array(
		'name'=>'submit',
		'id'=>'submit',
		'value'=>lang('common_submit'),
		'class'=>'submit_button float_left')
	); */
	?>
	</form>

	<?php if ($receiving_info['deleted'])
	{
	?>
	<?php echo form_open("receivings/undelete/".$receiving_info['receiving_id'],array('id'=>'receivings_undelete_form')); ?>
		
	<button type="submit" class="submit_button pull-right btn btn-warning" name="submit" id="submit" style="margin-left: 5px;"><i class="fa fa-undo" aria-hidden="true"></i> <?= lang('receivings_undelete_entire_sale') ?> </button>

		<?php /*
		echo form_submit(array(
			'name'=>'submit',
			'id'=>'submit',
			'value'=>lang('receivings_undelete_entire_sale'),
			'class'=>'submit_button float_right')
		); */
		?>
	</form>
	<?php
	}
	else
	{
	?>
	<?php echo form_open("receivings/delete/".$receiving_info['receiving_id'],array('id'=>'receivings_delete_form')); ?>

	<button type="submit" class="submit_button pull-right btn btn-danger" name="submit" id="submit"><i class="fa fa-remove" aria-hidden="true"></i> <?= lang('receivings_delete_entire_receiving') ?> </button>

		<?php /*
		echo form_submit(array(
			'name'=>'submit',
			'id'=>'submit',
			'value'=>lang('receivings_delete_entire_receiving'),
			'class'=>'delete_button float_right')
		); */
		?>
	</form>
	<?php
	}
	?>
</fieldset>

					</div>
					<div class="panel-footer ">
						
					</div>
                </div>
			</div>
		</div>
	</div>




<div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">
$(document).ready(function()
{	
	$('#date').datePicker({startDate: '<?php echo get_js_start_of_time_date(); ?>'});
	$("#receivings_delete_form").submit(function()
	{
		if (!confirm(<?php echo json_encode(lang("sales_delete_confirmation")); ?>))
		{
			return false;
		}
	});
	
	$("#receivings_undelete_form").submit(function()
	{
		if (!confirm(<?php echo json_encode(lang("receivings_undelete_confirmation")); ?>))
		{
			return false;
		}
	});
	var submitting = false;
	$('#receivings_edit_form').validate({
		submitHandler:function(form)
		{
			if (submitting) return;
			submitting = true;
			$(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
			
			$(form).ajaxSubmit({
			success:function(response)
			{
				submitting = false;
				$(form).unmask();
				if(response.success)
				{
					set_feedback(response.message,'success_message',false);
				}
				else
				{
					set_feedback(response.message,'error_message',true);	
					
				}
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules: 
		{
   		},
		messages: 
		{
		}
	});
});
</script>