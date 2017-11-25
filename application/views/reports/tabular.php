<?php
if($export_excel == 1)
{
	$rows = array();
	$row = array();
	foreach ($headers as $header) 
	{
		$row[] = strip_tags($header['data']);
	}
	
	$rows[] = $row;
	
	foreach($data as $datarow)
	{
		$row = array();
		foreach($datarow as $cell)
		{
			$row[] = strip_tags($cell['data']);
		}
		$rows[] = $row;
	}
	
	$content = array_to_csv($rows);
	// chr(239) . chr(187) . chr(191) .  => convert unicode font
	force_download(strip_tags($title) . '.csv', chr(239) . chr(187) . chr(191) .$content);
	exit;
}
?>
<?php $this->load->view("partial/header"); ?>
<div class="col-xs-12">
 <button class="btn btn-primary pull-right" onclick="printReciept()"><i class="fa fa-print"></i> Print</button>
<button class="btn btn-default pull-right" onclick="preView()" style="margin-right:5px"><i class="fa fa-search"></i> Print Preview</button>
</div>


<div id="print_report">

<table id="title_bar">
	<tr>
		<td id="title_icon">
			<img src='<?php echo base_url()?>images/menubar/reports.png' alt='<?php echo lang('reports_reports'); ?> - <?php echo lang('reports_welcome_message'); ?>' />
		</td>
		<td id="title"><?php echo lang('reports_reports'); ?> - <?php echo $title ?></td>
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
			<div id="table_holder" style="width:100%;">
				<table class="tablesorter report" id="sortable_table">
					<thead>
						<tr>
							<?php foreach ($headers as $header) { ?>
							<th align="<?php echo $header['align'];?>"><?php echo $header['data']; ?></th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($data as $row) { ?>
						<tr>
							<?php foreach ($row as $cell) { ?>
							<td align="<?php echo $cell['align'];?>"><?php echo $cell['data']; ?></td>
							<?php } ?>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>	
			<div id="report_summary" class="tablesorter report" style="margin-right: 10px;">
			<?php foreach($summary_data as $name=>$value) { ?>
				<div class="summary_row"><?php echo "<strong>".lang('reports_'.$name). '</strong>: '.to_currency($value); ?></div>
			<?php }?>
			</div>
		</td>
	</tr>
</table>

</div>

<div id="feedback_bar"></div>

<?php $this->load->view("partial/footer"); ?>


<script type="text/javascript">
$(window).load(function()
{
	//window.print();
});
function preView(){

	//window.print('');
	 var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,"; 
     disp_setting+="scrollbars=yes,width=1123, height=794, left=100, top=25"; 
 var content_vlue = document.getElementById("print_report").innerHTML; 
 
 var docprint=window.open("","",disp_setting); 
  docprint.document.open(); 
  docprint.document.write('<html><head><title>Stock inventory System</title>'); 
  docprint.document.write('</head><body style=" margin:0px; font-family :Verdana, Khmer Os Battambang; font-size:13px;"><center>');          
  docprint.document.write('<style type="text/css">#report_summary{text-align:right;font-size:14px;}#contents{width:100%} .report{width:100%;border-collapse:collapse;} .report tr>th, .report tr>td{ white-space:nowrap;font-size:12px; border-collapse:collapse;border:1px solid;padding-left:3px;padding-right:3px;} h5{padding-left: 3px; text-align:center;} h4{padding-left: 3px; text-align:center;}body{ margin:0px;');
  docprint.document.write('font-family:Helvetica Neue",Helvetica,Arial,sans-serif, khmer os battambang; font-size:14px;border-spacing: 0; border-collapse: collapse;padding-left: 3px; padding-right: 3px; }');
  docprint.document.write('a{color:#000;text-decoration:none;} p{display: inline;}</style>');
  docprint.document.write(content_vlue);          
  docprint.document.write('</center></body></html>'); 
  docprint.document.close(); 
  docprint.focus(); 
}
function printReciept(){
	//window.print('');
var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,"; 
   disp_setting+="scrollbars=yes,width=1123, height=794, left=100, top=25"; 
var content_vlue = document.getElementById("print_report").innerHTML; 

var docprint=window.open("","",disp_setting); 
docprint.document.open(); 
docprint.document.write('<html><head><title>Stock inventory System</title>'); 
docprint.document.write('</head><body onLoad="self.print()" style=" margin:0px; font-family:Verdana,Khmer Os Battambang; font-size:13px;"><center>');          
docprint.document.write('<style type="text/css">#report_summary{text-align:right;font-size:15px;} #contents{width:100%} .report{width:100%;border-collapse:collapse;} .report tr>th, .report tr>td{font-size:12px; white-space:nowrap;border-collapse:collapse;border:1px solid;padding-left:3px;padding-right:3px;} h5{padding-left: 3px; text-align:center;} h4{padding-left: 3px; text-align:center;}body{ margin:0px;');
docprint.document.write('font-family:Helvetica Neue",Helvetica,Arial,sans-serif, khmer os battambang; font-size:14px;border-spacing: 0; border-collapse: collapse;padding-left: 3px; padding-right: 3px; }');
docprint.document.write('a{color:#000;text-decoration:none;} p{display: inline;}</style>');
//window.print();
docprint.document.write(content_vlue);          
docprint.document.write('</center></body></html>'); 
docprint.document.close(); 
docprint.focus(); 
}
</script>


<script type="text/javascript" language="javascript">
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