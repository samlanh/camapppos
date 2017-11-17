<?php $this->load->view("partial/header"); ?>
<?php
if (isset($error_message))
{
	echo '<h1 style="text-align: center;">'.$error_message.'</h1>';
	exit;
}
?>
<input type="button" onclick="preView();" label="Printview " value="Print View" />
<input type="button" onclick="printReciept();" label="Printview " value="Print" />
<div id="receipt_wrapper">
	<div id="receipt_header">
		<div id="company_name"><?php echo $this->config->item('company'); ?></div>
		<?php if($this->config->item('company_logo')) {?>
		<div id="company_logo"><?php echo img(array('src' => $this->Appconfig->get_logo_image())); ?></div>
		<?php } ?>
		<div id="company_address"><?php echo nl2br($this->config->item('address')); ?></div>
		<div id="company_phone"><?php echo $this->config->item('phone'); ?></div>
		<div id="sale_receipt"><?php echo $receipt_title; ?></div>
		<div id="sale_time"><?php echo $transaction_time ?></div>
	</div>
	<div id="receipt_general_info">
		<?php if(isset($customer))
		{
		?>
		<div id="customer"><?php echo lang('customers_customer').": ".$customer; ?></div>
		<?php
		}
		?>
		<div id="sale_id"><?php echo lang('sales_id').": POS ".$owed_info->sale_id; ?></div>
		<div id="employee"><?php echo lang('employees_employee').": ".$employee; ?></div>
	</div>

	<table id="receipt_items">
	
	<td colspan="3" style='text-align:right;border-top:1px solid #000000;font-size:10px !important;'>Total Amount : </td>
	<td colspan="3" style='text-align:right;border-top:1px solid #000000;font-size:10px !important;'><?= to_currency($owed_info->total_amount); ?></td>
	</tr>

	<tr>
	<td colspan="3" style='text-align:right;font-size:10px !important;'>Paid Amount : </td>
	<td colspan="3" style='text-align:right;font-size:10px !important;'><?= to_currency($owed_info->payment_amount); ?></td>
	</tr>

	<tr>
	<td colspan="3" style='text-align:right;font-size:10px !important;'>Remain Balance : </td>
	<td colspan="3" style='text-align:right;font-size:10px !important;'><?= to_currency($owed_info->remain_balance); ?></td>
	</tr>

	
    <tr>
    <td colspan="6">&nbsp;</td>
    </tr>

	<tr>
		<td colspan="2" style='text-align:right;font-size:10px !important;'>Exchange Rate</td>
		<td colspan="4" style='text-align:right;font-size:10px !important;'>
	 <?php echo to_currency($this->Exchange->select_last_exchange_rate_to_dollar()).' = '.to_number_money_reil($this->Exchange->select_last_exchange_rate_to_reil()); ?>
		</td>
	</tr>
	
	
	</table>

	<div id="sale_return_policy">
	<?php echo nl2br($this->config->item('return_policy')); ?>
	</div>
	<div id='barcode'>
	<?php echo "<img src='".site_url('barcode')."?barcode=POS$owed_info->sale_id&text=POS$owed_info->sale_id' />"; ?>
	</div>
	<div id="signature">
	----------------------------------------------
	</div>
</div>
<?php $this->load->view("partial/footer"); ?>

<?php if ($this->Appconfig->get('print_after_sale'))
{
?>
<script type="text/javascript">
$(window).load(function()
{
	window.print();
});
function preView(){

	//window.print('');
	 var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,"; 
     disp_setting+="scrollbars=yes,width=400, height=500, left=100, top=25"; 
 var content_vlue = document.getElementById("receipt_wrapper").innerHTML; 
 
 var docprint=window.open("","",disp_setting); 
  docprint.document.open(); 
  docprint.document.write('<html><head><title>Stock inventory System</title>'); 
  docprint.document.write('</head><body style=" margin:0px; font-family :Verdana, Khmer Os Battambang; font-size:13px;"><center>');          
  docprint.document.write(content_vlue);          
  docprint.document.write('</center></body></html>'); 
  docprint.document.close(); 
  docprint.focus(); 
}
function printReciept(){
	//window.print('');
var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,"; 
   disp_setting+="scrollbars=yes,width=400, height=500, left=100, top=25"; 
var content_vlue = document.getElementById("receipt_wrapper").innerHTML; 

var docprint=window.open("","",disp_setting); 
docprint.document.open(); 
docprint.document.write('<html><head><title>Stock inventory System</title>'); 
docprint.document.write('</head><body onLoad="self.print()" style=" margin:0px; font-family:Verdana,Khmer Os Battambang; font-size:13px;"><center>');          
window.print();
docprint.document.write(content_vlue);          
docprint.document.write('</center></body></html>'); 
docprint.document.close(); 
docprint.focus(); 
}
</script>
<?php
}
?>