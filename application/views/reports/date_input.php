<?php $this->load->view("partial/header"); ?>

<div class="container" style=" padding-right: 0px; padding-left: 0px;">
		<div class="row" style=" margin-right: 0px; margin-left: 0px;">
			<div class="col-xs-5 col-xs-offset-4"  style="padding-right: 5px; padding-left: 5px; margin-left: 30%">
	<div class="panel panel-default">
					<div class="panel-heading clearfix">
						<strong><?php echo lang('reports_report_input'); ?></strong>
					</div>
		<div class="panel-body" style="padding: 15px;">
					
<?php
if(isset($error))
{
	echo "<div class='error_message'>".$error."</div>";
}
?>

<?php echo form_label(lang('reports_date_range'), 'report_date_range_label', array('class'=>'required')); ?>
	<div id='report_date_range_simple'>
		<input type="radio" name="report_type" id="simple_radio" value='simple' checked='checked'/>
		<?php echo form_dropdown('report_date_range_simple',$report_date_range_simple, '', 'id="report_date_range_simple"'); ?>
	</div>
	
	<div id='report_date_range_complex'>
		<input type="radio" name="report_type" id="complex_radio" value='complex' />
		<?php echo form_dropdown('start_month',$months, $selected_month, 'id="start_month"'); ?>
		<?php echo form_dropdown('start_day',$days, $selected_day, 'id="start_day"'); ?>
		<?php echo form_dropdown('start_year',$years, $selected_year, 'id="start_year"'); ?>
		-
		<?php echo form_dropdown('end_month',$months, $selected_month, 'id="end_month"'); ?>
		<?php echo form_dropdown('end_day',$days, $selected_day, 'id="end_day"'); ?>
		<?php echo form_dropdown('end_year',$years, $selected_year, 'id="end_year"'); ?>
	</div>
	
	<?php echo form_label(lang('reports_sale_type'), 'reports_sale_type_label', array('class'=>'required')); ?>
	<div id='report_sale_type'>
		<?php echo form_dropdown('sale_type',array('all' => lang('reports_all'), 'sales' => lang('reports_sales'), 'returns' => lang('reports_returns')), 'all', 'id="sale_type"'); ?>
	</div>


<button type="submit" class="submit_button pull-right btn btn-primary" name="generate_report" id="generate_report"><i class="fa fa-search" aria-hidden="true"></i> <?= lang('common_search') ?> </button>

<?php /*
echo form_button(array(
	'name'=>'generate_report',
	'id'=>'generate_report',
	'content'=>lang('common_submit'),
	'class'=>'submit_button')
); */
?>
	</div>
					<div class="panel-footer ">
						
					</div>
                </div>
			</div>
	
		</div>
	</div>

<?php $this->load->view("partial/footer"); ?>


<script type="text/javascript" language="javascript">
$(document).ready(function()
{
	$("#generate_report").click(function()
	{		
		var sale_type = $("#sale_type").val();
		
		if ($("#simple_radio").attr('checked'))
		{
			window.location = window.location+'/'+$("#report_date_range_simple option:selected").val() + '/' + sale_type;
		}
		else
		{
			var start_date = $("#start_year").val()+'-'+$("#start_month").val()+'-'+$('#start_day').val();
			var end_date = $("#end_year").val()+'-'+$("#end_month").val()+'-'+$('#end_day').val();
	
			window.location = window.location+'/'+start_date + '/'+ end_date+ '/' + sale_type;
		}
	});
	
	$("#start_month, #start_day, #start_year, #end_month, #end_day, #end_year").click(function()
	{
		$("#complex_radio").attr('checked', 'checked');
	});
	
	$("#report_date_range_simple").click(function()
	{
		$("#simple_radio").attr('checked', 'checked');
	});
	
});
</script>