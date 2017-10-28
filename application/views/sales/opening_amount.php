<?php $this->load->view('partial/header.php'); ?>
<style type="text/css">
	.error { float: none !important; }
</style>

<div id="register_container" class="sales">

<div class="container" style=" padding-right: 0px; padding-left: 0px;">
		<div class="row" style=" margin-right: 0px; margin-left: 0px;">
			<div class="col-xs-6 col-xs-offset-3"  style="padding-right: 5px; padding-left: 5px;">
				<div class="panel panel-default">
					<div class="panel-heading clearfix">
						<?php echo lang("sales_opening_amount_desc"); ?>
					</div>
		
		<div class="panel-body" style="padding : 15px;">

     <?php  echo form_open('sales', array('id'=>'opening_amount_form'));  ?>

      <div class="field_row clearfix">
     <?php echo form_label(lang('sales_opening_amount').':', 'opening_amount',array('class'=>'wide required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'opening_amount',
		'id'=>'opening_amount',
		'class'=>'form-control',
		'value'=>'')
	);?>
	</div>
 </div>
<br>
<button type="submit" class="submit_button pull-right btn btn-primary" name="submit" id="submit"><i class="fa fa-save" aria-hidden="true"></i> <?= lang('common_submit') ?> </button>

<?php /**
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'value'=>lang('common_submit'),
	'class'=>'submit_button float_right')
); */
?>

<?php
echo form_close();
?>
	</div>
		<div class="panel-footer ">
						
		</div>
       </div>
    </div>

	   </div>
	</div>
   </div>
 </div>

<?php $this->load->view('partial/footer.php'); ?>

<script type='text/javascript'>

//validation and submit handling
$(document).ready(function()
{
	var submitting = false;

	$('#opening_amount_form').validate({
		rules:
		{
			opening_amount: {
				required: true,
				number: true
			}
   		},
   		messages: {
	   		closing_amount: {
				required: <?php echo json_encode(lang('sales_amount_required')); ?>,
				number: <?php echo json_encode(lang('sales_amount_number')); ?>
			}
   		}
	});
});
</script>