<?php $this->load->view("partial/header"); ?>
<script type="text/javascript" src="<?= base_url('js/excelexportjs.js') ?>"></script>

<table id="title_bar">
	<tr>
		<td id="title_icon">
			<img src='<?php echo base_url()?>images/menubar/reports.png' alt='<?php echo lang('reports_reports'); ?> - <?php echo lang('reports_welcome_message'); ?>' />
		</td>
		<td id="title"><?php echo lang('reports_reports'); ?> - <?php echo $title ?>  

		<button class="btn btn-xs btn-primary pull-right" id="export"><i class="fa fa-download"></i> Export To CSV</button>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><small><?php echo $subtitle ?></small></td>
	</tr>
</table>
<br />


<table id="contents">
	<tr>
		<td id="item_table">

			<hr>
			<h5> Income </h5>

			<div id="table_holder" style="width:100%;">
				<table class="tablesorter report" id="sortable_table">
					<thead>
						<tr>
							<?php foreach ($headers_income as $header) { ?>
							<th align="<?php echo $header['align'];?>"><?php echo $header['data']; ?></th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($data_income as $row) { ?>
						<tr>
						<?php foreach ($row as $cell) { ?>
						<td align="<?php echo $cell['align'];?>"><?php echo $cell['data']; ?></td>
							<?php } ?>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>	


			<hr>
			<h5> Expense </h5>
			<div id="table_holder" style="width:100%;">
				<table class="tablesorter report" id="sortable_table">
					<thead>
						<tr>
							<?php foreach ($headers_expense as $header) { ?>
							<th align="<?php echo $header['align'];?>"><?php echo $header['data']; ?></th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($data_expense as $row) { ?>
						<tr>
						<?php foreach ($row as $cell) { ?>
						<td align="<?php echo $cell['align'];?>"><?php echo $cell['data']; ?></td>
							<?php } ?>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>	

			<div id="report_summary" class="tablesorter report" style="margin-right: 10px; padding: 6px;">
			<?php foreach($summary_data as $name => $value) { ?>
				<div class="summary_row"><?php echo "<strong>".lang('reports_'.$name). '</strong>: '.to_currency($value); ?></div>
			<?php }?>
			</div>
		</td>
	</tr>
</table>




<div id="feedback_bar"></div>

<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">

$('#export').click(function(e) {
	 $("#contents").excelexportjs({
            containerid: "contents"
            , datatype: 'table'
        });
});

function init_table_sorting()
{
	//Only init if there is more than one row
	if($('.tablesorter tbody tr').length >1)
	{
		$("#sortable_table").tablesorter(); 
	}
}
$(document).ready(function()
{
	init_table_sorting();
});
</script>