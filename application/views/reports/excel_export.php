<?php $this->load->view("partial/header"); ?>

<div class="container" style=" padding-right: 0px; padding-left: 0px;">
		<div class="row" style=" margin-right: 0px; margin-left: 0px;">
			
			<div class="col-xs-5 col-xs-offset-4"  style="padding-right: 5px; padding-left: 5px; margin-left: 30%">

				<div class="panel panel-default">
					<div class="panel-heading clearfix">
						<?php echo lang('reports_report_input'); ?>
					</div>
					<div class="panel-body" style="padding: 15px;">
					
			<?php
			if(isset($error))
			{
				echo "<div class='error_message'>".$error."</div>";
			}
			?>
			
				<div>
					<?php echo lang('reports_export_to_excel'); ?>: <input type="radio" name="export_excel" id="export_excel_yes" value='1' /> <?php echo lang('common_yes'); ?>
					<input type="radio" name="export_excel" id="export_excel_no" value='0' checked='checked' /> <?php echo lang('common_no'); ?>
				</div>

     <button type="submit" class="submit_button pull-right btn btn-primary" name="generate_report" id="generate_report"><i class="fa fa-search" aria-hidden="true"></i> <?= lang('common_search') ?> </button>

			<?php /* 
			echo form_button(array(
				'name'=>'generate_report',
				'id'=>'generate_report',
				'content'=>lang('common_submit'),
				'class'=>'submit_button')
			);  */
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
		var export_excel = 0;
		if ($("#export_excel_yes").attr('checked'))
		{
			export_excel = 1;
		}
		
		window.location = window.location+'/' + export_excel;
	});	
});
</script>
		