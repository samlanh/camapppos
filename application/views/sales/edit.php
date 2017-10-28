<?php $this->load->view("partial/header"); ?>

<div class="container" style=" padding-right: 0px; padding-left: 0px;">
		<div class="row" style=" margin-right: 0px; margin-left: 0px;">			

			<div class="col-xs-6 col-xs-offset-3" style="padding-right: 5px; padding-left: 5px;">
				<div class="panel panel-default">
					<div class="panel-heading clearfix">
				<img height="30px" src='<?php echo base_url()?>images/menubar/sales.png' alt='title icon' />
		      <?php echo lang('sales_register')." - ".lang('sales_edit_sale'); ?> POS <?php echo $sale_info['sale_id']; ?>
					</div>
					<div class="panel-body" style="padding: 15px;">
	<fieldset>
	<?php echo form_open("sales/save/".$sale_info['sale_id'],array('id'=>'sales_edit_form')); ?>
	<ul id="error_message_box"></ul>
	
	<div class="field_row clearfix">
	<?php echo form_label(lang('sales_receipt').':', 'sales_receipt'); ?>
		<div class='form_field'>
			<?php echo anchor('sales/receipt/'.$sale_info['sale_id'], 'POS '.$sale_info['sale_id'], array('target' => '_blank'));?>
		</div>
	</div>
	
	<div class="field_row clearfix">
	<?php echo form_label(lang('sales_date').':', 'date'); ?>
		<div class='form_field'>
			<?php echo form_input(array('name'=>'date','value'=>date(get_date_format(), strtotime($sale_info['sale_time'])), 'id'=>'date','class'=>'form-control'));?>
		</div>
	</div>
	
	<div class="field_row clearfix">
	<?php echo form_label(lang('sales_customer').':', 'customer'); ?>
		<div class='form_field'>
			<?php echo form_dropdown('customer_id', $customers, $sale_info['customer_id'], 'id="customer_id" class="form-control" style="width: 56%;float: left;margin-right: 4px;"');?>
			<?php if ($sale_info['customer_id']) { ?>
				<?php echo anchor('sales/email_receipt/'.$sale_info['sale_id'], lang('sales_email_receipt'), array('id' => 'email_receipt'));?>
			<?php }?>
		</div>
	</div>
	
	<div class="field_row clearfix">
	<?php echo form_label(lang('sales_employee').':', 'employee'); ?>
		<div class='form_field'>
			<?php echo form_dropdown('employee_id', $employees, $sale_info['employee_id'], 'id="employee_id" class="form-control" style="width: 70%;"');?>
		</div>
	</div>
	
	<div class="field_row clearfix">
	<?php echo form_label(lang('sales_comment').':', 'comment'); ?>
		<div class='form_field'>
			<?php echo form_textarea(array('name'=>'comment','value'=>$sale_info['comment'],'rows'=>'4','class'=>'form-control', 'id'=>'comment','style'=>'width: 70%;'));?>
		</div>
	</div>

	<button type="submit" class="submit_button pull-right btn btn-primary" name="submit" id="submit" style="margin-left: 5px;"><i class="fa fa-save" aria-hidden="true"></i> <?= lang('common_submit') ?> </button>
	
	<?php /**
	echo form_submit(array(
		'name'=>'submit',
		'id'=>'submit',
		'value'=>lang('common_submit'),
		'class'=>'submit_button float_left')
	); */
	?>
	</form>

	<?php if ($sale_info['deleted'])
	{
	?>
	<?php echo form_open("sales/undelete/".$sale_info['sale_id'],array('id'=>'sales_undelete_form')); ?>
		
	<button type="submit" class="submit_button pull-right btn btn-warning" name="submit" id="submit" style="margin-left: 5px;"><i class="fa fa-undo" aria-hidden="true"></i> <?= lang('sales_undelete_entire_sale') ?> </button>

		<?php /*
		echo form_submit(array(
			'name'=>'submit',
			'id'=>'submit',
			'value'=>lang('sales_undelete_entire_sale'),
			'class'=>'submit_button float_right')
		); */
		?>
	</form>
	<?php
	}
	else
	{
	?>
	<?php echo form_open("sales/delete/".$sale_info['sale_id'],array('id'=>'sales_delete_form')); ?>
		
	<button type="submit" class="submit_button pull-right btn btn-danger" name="submit" id="submit"><i class="fa fa-remove" aria-hidden="true"></i> <?= lang('sales_delete_entire_sale') ?> </button>

		<?php /*
		echo form_submit(array(
			'name'=>'submit',
			'id'=>'submit',
			'value'=>lang('sales_delete_entire_sale'),
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
	$("#email_receipt").click(function()
	{
		$.get($(this).attr('href'), function()
		{
			alert("<?php echo lang('sales_receipt_sent'); ?>")
		});
		
		return false;
	});
	$('#date').datePicker({startDate: '<?php echo get_js_start_of_time_date(); ?>'});
	$("#sales_delete_form").submit(function()
	{
		if (!confirm('<?php echo lang("sales_delete_confirmation"); ?>'))
		{
			return false;
		}
	});
	
	$("#sales_undelete_form").submit(function()
	{
		if (!confirm('<?php echo lang("sales_undelete_confirmation"); ?>'))
		{
			return false;
		}
	});
	
	$('#sales_edit_form').validate({
		submitHandler:function(form)
		{
			$(form).ajaxSubmit({
			success:function(response)
			{
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