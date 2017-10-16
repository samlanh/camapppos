<?php $this->load->view("partial/header"); ?>
<?php
if (isset($error_message))
{
	echo '<h1 style="text-align: center;">'.$error_message.'</h1>';
	exit;
}
?>
<input type="button" onclick="preView();" label="Printview " value="Print" />
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
		<div id="sale_id"><?php echo lang('sales_id').": ".$sale_id; ?></div>
		<div id="employee"><?php echo lang('employees_employee').": ".$employee; ?></div>
	</div>

	<table id="receipt_items">
	<tr>
	<th style="width:33%;text-align:center;font-size:10px !important;"><?php echo lang('items_item'); ?></th>
	<th style="width:20%;text-align:center;font-size:10px !important;"><?php echo lang('common_price'); ?></th>
	<th style="width:15%;text-align:center;font-size:10px !important;"><?php echo lang('sales_quantity'); ?></th>
	<th style="width:16%;text-align:center;font-size:10px !important; white-space: nowrap;"><?php echo lang('sales_discount'); ?></th>
	<th style="width:16%;text-align:right;font-size:10px !important;"><?php echo lang('sales_total'); ?></th>
	</tr>
	<?php
	foreach(array_reverse($cart, true) as $line=>$item)
	{
	?>
		<tr>
		<td style="text-align:center;font-size:10px !important;"><span class='long_name'><?php echo $item['name']; ?></span><span class='short_name'><?php echo character_limiter($item['name'],25); ?></span></td>
		<td style="text-align:center;font-size:10px !important;"><?php echo to_currency($item['price']); ?></td>
		<td style='text-align:center;font-size:10px !important;'><?php echo $item['quantity']; ?></td>
		<td style='text-align:center;font-size:10px !important;'><?php echo $item['discount']; ?></td>
		<td style='text-align:right;font-size:10px !important;'><?php echo to_currency($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount']/100); ?></td>
		</tr>

	    <tr ><!-- show descrition -->
	    <td colspan="2" style="text-align:center;font-size:10px !important;"><?php echo $item['description']; ?></td>
		<td colspan="2" style="font-size:10px !important;"><?php echo isset($item['serialnumber']) ? $item['serialnumber'] : ''; ?></td>
		<td colspan="2" style="font-size:10px !important;"><?php echo '&nbsp;'; ?></td>
	    </tr>

	<?php
	}
	?>
	<tr>
	<td colspan="4" style='text-align:right;border-top:2px solid #000000;font-size:10px !important;'><?php echo lang('sales_sub_total'); ?></td>
	<td colspan="2" style='text-align:right;border-top:2px solid #000000;font-size:10px !important;'><?php echo to_currency($subtotal); ?></td>
	</tr>

	<?php foreach($taxes as $name=>$value) { ?>
		<tr>
			<td colspan="4" style='text-align:right;font-size:10px !important;'><?php echo $name; ?>:</td>
			<td colspan="2" style='text-align:right;font-size:10px !important;'><?php echo to_currency($value); ?></td>
		</tr>
	<?php }; ?>

	<tr>
	<td colspan="4" style='text-align:right;font-size:10px !important;'><?php echo lang('sales_total'); ?></td>
	<td colspan="2" style='text-align:right;font-size:10px !important;'><?php echo to_currency($total); ?></td>
	</tr>

    <tr><td colspan="6">&nbsp;</td></tr>

	<?php
		foreach($payments as $payment_id=>$payment)
	{ ?>
		<tr>
		<td colspan="2" style="text-align:right;font-size:10px !important;"><?php echo lang('sales_payment'); ?></td>
		<td colspan="2" style="text-align:right;font-size:10px !important;"><?php $splitpayment=explode(':',$payment['payment_type']); echo $splitpayment[0]; ?> </td>
		<td colspan="2" style="text-align:right;font-size:10px !important;"><?php echo to_currency( $payment['payment_amount'] ); ?>  </td>
	    </tr>
	<?php
	}
	?>	
    <tr><td colspan="6">&nbsp;</td></tr>

	<?php foreach($payments as $payment) {?>
		<?php if (strpos($payment['payment_type'], lang('sales_giftcard'))!== FALSE) {?>
	<tr>
		<td colspan="2" style="text-align:right;font-size:10px !important;"><?php echo lang('sales_giftcard_balance'); ?></td>
		<td colspan="2" style="text-align:right;font-size:10px !important;"><?php echo $payment['payment_type'];?> </td>
		<td colspan="2" style="text-align:right;font-size:10px !important;"><?php echo to_currency($this->Giftcard->get_giftcard_value(end(explode(':', $payment['payment_type'])))); ?></td>
	</tr>
		<?php }?>
	<?php }?>
	
	<?php if ($amount_change >= 0) {?>
	<tr>
		<td colspan="4" style='text-align:right;font-size:10px !important;'><?php echo lang('sales_change_due'); ?></td>
		<td colspan="2" style='text-align:right;font-size:10px !important;'><?php echo to_currency($amount_change); ?></td>
	</tr>
	<?php
	}
	else
	{
	?>
	<tr>
		<td colspan="4" style='text-align:right;font-size:10px !important;'><?php echo lang('sales_amount_due'); ?></td>
		<td colspan="2" style='text-align:right;font-size:10px !important;'><?php echo to_currency($amount_change * -1); ?></td>
	</tr>	
	<?php
	} 
	?>
	</table>

	<div id="sale_return_policy">
	<?php echo nl2br($this->config->item('return_policy')); ?>
	</div>
	<div id='barcode'>
	<?php echo "<img src='".site_url('barcode')."?barcode=$sale_id&text=$sale_id' />"; ?>
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
  docprint.document.write('</head><body style=" margin:0px; font-family:Verdana; font-size:13px;"><center>');          
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
docprint.document.write('</head><body onLoad="self.print()" style=" margin:0px; font-family:Verdana; font-size:13px;"><center>');          
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