<?php
$this->load->view("partial/header");
?>

<div class="container" style=" padding-right: 0px; padding-left: 0px;">
		<div class="row" style=" margin-right: 0px; margin-left: 0px;">
		
    <div class="col-xs-6 col-xs-offset-3" style="padding-right: 5px; padding-left: 5px;">
				<div class="panel panel-default">
					<div class="panel-heading clearfix">
		<img src='<?php echo base_url()?>images/menubar/reports.png' alt='<?php echo lang('reports_reports'); ?> - <?php echo lang('reports_welcome_message'); ?>' />
		<strong>
		<?php echo lang('reports_reports'); ?> - <?php echo $title ?>
		</strong>
		<small><?php echo $subtitle ?></small>
					</div>
					<div class="panel-body" style="padding: 15px;">

<div style="text-align: center;">
<!--[if lte IE 8]><script src="<?php echo base_url();?>js/excanvas.min.js?<?php echo APPLICATION_VERSION; ?>" type="text/javascript" language="javascript" charset="UTF-8"></script><![endif]-->
<script src="<?php echo base_url();?>js/jquery.flot.min.js?<?php echo APPLICATION_VERSION; ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
<script src="<?php echo base_url();?>js/jquery.flot.pie.min.js?<?php echo APPLICATION_VERSION; ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>

<script type="text/javascript">
$.getScript('<?php echo $graph_file; ?>');
</script>
</div>

<div id="chart_wrapper">
	<div id="chart"></div>
</div>
<div id="report_summary">
<?php foreach($summary_data as $name=>$value) { ?>
	<div class="summary_row" >
	<?php echo lang('reports_'.$name). ': '.to_currency($value); ?> 		
	</div>
<?php }?>
</div>
			</div>
					<div class="panel-footer ">
					
					</div>
                </div>
			</div>
		</div>
	</div>


<?php
$this->load->view("partial/footer"); 
?>