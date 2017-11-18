
<div class="container" style=" padding-right: 0px; padding-left: 0px;">

  <div class="row" style=" margin-right: 0px; margin-left: 0px;">

	<div class="col-xs-12" style="padding-right: 0px; padding-left: 0px;">
	
	<div class="panel panel-default">

		<div class="panel-heading clearfix">

			<div class="col-xs-6 text-left">	

	<img style="max-height: 30px;" src='<?php echo base_url()?>images/menubar/sales.png' alt='title icon' />
				<b> <?php echo lang('sales_register'); ?> </b>	
			</div>

			<div class="col-xs-2 text-right">
			</div>

			<div class="col-xs-2 text-right">	
			    <?php echo form_open("sales/change_mode",array('id'=>'mode_form')); ?>
						<span><?php echo lang('sales_mode') ?></span>
						<?php echo form_dropdown('mode',$modes,$mode,'id="mode"'); ?>
				</form>
			  </div>
			  <div class="col-xs-2 text-right">
			
			   	<?php 
							/*echo anchor("sales/suspended/width~750",
							"<div class='small_button'>".lang('sales_suspended_sales')."</div>",
							array('class'=>'thickbox none','title'=>lang('sales_suspended_sales')));*/
					echo anchor("sales/suspended", "<div class='btn btn-info'>".lang('sales_suspended_sales')."</div>");
				?>

			   </div>
			</div>
		
<div class="panel-body">
	<div class="col-xs-10" style="padding-left: 0px; padding-right: 0px;">	

	<?php echo form_open("sales/add",array('id'=>'add_item_form')); ?>
	 <div class="col-xs-9" style="padding-left: 0px; padding-right: 0px;">
   <div id="custom-search-input">
        <div class="input-group"> 
					<?php echo form_input(array('name'=>'item','id'=>'item','size'=>'40','class'=>'form-control', 'accesskey' => 'i','style'=>'border: 1px solid;','placeholder'=>lang('common.scan_barcode')));?>
				 <span class="input-group-btn">
                        <button class="btn btn-info" type="button">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
      </div>
      </div> 

     </div>

      <div class="col-xs-3" style="padding-left: 0px; padding-right: 0px;">
      <?php echo anchor("items/view/width~550",
						"<div class='btn btn-primary pull-right'><i class='fa fa-plus'></i> <span>".lang('sales_new_item')."</span></div>",
						array('class'=>'thickbox none','title'=>lang('sales_new_item')));?>
      </div>
   <?= form_close(); ?>

<div id="register_holder">
			<table id="register">
				
				<thead>
					<tr>
						<th id="reg_item_del"></th>
						<th id="reg_item_name"><?php echo lang('sales_item_name'); ?></th>
						<th id="reg_item_number"><?php echo lang('sales_item_number'); ?></th>
						<th id="reg_item_stock"><?php echo lang('sales_stock'); ?></th>
						<th id="reg_item_price"><?php echo lang('sales_price'); ?></th>
						<th id="reg_item_qty"><?php echo lang('sales_quantity'); ?></th>
						<th id="reg_item_discount"><?php echo lang('sales_discount'); ?></th>
						<th id="reg_item_total"><?php echo lang('sales_total'); ?></th>
					</tr>
				</thead>
				<tbody id="cart_contents">
					<?php if(count($cart)==0)	{ ?>
					<tr>
						<td colspan='8' style="height:60px;border:none;">
								<div class='warning_message' style='padding:7px;'><?php echo lang('sales_no_items_in_cart'); ?></div>
						</td>
					</tr>
					<?php	}
					else	{
					foreach(array_reverse($cart, true) as $line=>$item)		{
						$cur_item_info = isset($item['item_id']) ? $this->Item->get_info($item['item_id']) : $this->Item_kit->get_info($item['item_kit_id']);
						?>
							<tr>
								<td colspan='8'>
								<?php
									echo form_open("sales/edit_item/$line", array('class' => 'line_item_form')); 	?>
							
									<table>							
											<tr id="reg_item_top">
												<td id="reg_item_del" ><?php echo anchor("sales/delete_item/$line",lang('common_delete'), array('class' => 'delete_item'));?></td>
												<td id="reg_item_name"><?php echo $item['name']; ?></td>
												<td id="reg_item_number"><?php echo isset($item['item_id']) ? $item['item_number'] : $item['item_kit_number']; ?></td>
												<td id="reg_item_stock" ><?php echo property_exists($cur_item_info, 'quantity') ? $cur_item_info->quantity : ''; ?></td>
												
												<?php if ($items_module_allowed && $this->Employee->has_module_action_permission('sales', 'edit_sale_price', $this->Employee->get_logged_in_employee_info()->person_id)){ ?>
												<td id="reg_item_price"><?php echo form_input(array('name'=>'price','value'=>$item['price'],'size'=>'6',  'class'=>'form-control','id' => 'price_'.$line));?></td>
												<?php }else{ ?>
												<td id="reg_item_price"><?php echo $item['price']; ?></td>
												<?php echo form_hidden('price',$item['price']); ?>
												<?php }	?>
												
												<td id="reg_item_qty">
												<?php if(isset($item['is_serialized']) && $item['is_serialized']==1){
													echo $item['quantity'];
													echo form_hidden('quantity',$item['quantity']);
													}else{
													echo form_input(array('name'=>'quantity', 'class'=>'form-control','value'=>$item['quantity'],'size'=>'2', 'id' => 'quantity_'.$line));
													}?>
												</td>
							
												<td id="reg_item_discount"><?php echo form_input(array('name'=>'discount','value'=>$item['discount'],'size'=>'3', 'class'=>'form-control','id' => 'discount_'.$line));?></td>
												<td id="reg_item_total"><?php echo to_currency($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount']/100); ?></td>
											</tr>
						
											<tr id="reg_item_bottom">
												<td id="reg_item_descrip_label"><?php echo lang('sales_description_abbrv').':';?></td>
												<td id="reg_item_descrip" colspan="4">
													<?php if(isset($item['allow_alt_description']) && $item['allow_alt_description']==1){
														echo form_input(array('name'=>'description','value'=>$item['description'],'size'=>'20', 'id' => 'description_'.$line));
													}else{
														if ($item['description']!=''){
															echo $item['description'];
															echo form_hidden('description',$item['description']);
														}else{
															echo 'None';
															echo form_hidden('description','');
														}
													}?>
												</td>
												<td id="reg_item_serial_label">
													<?php if(isset($item['is_serialized']) && $item['is_serialized']==1){
														echo lang('sales_serial').':';
													}?>
												</td>
												<td id="reg_item_serial" colspan="2">
													<?php if(isset($item['is_serialized']) && $item['is_serialized']==1)	{
														echo form_input(array('name'=>'serialnumber','value'=>$item['serialnumber'],'size'=>'20', 'id' => 'serialnumber_'.$line));
													}else{
														echo form_hidden('serialnumber', '');
													}?>
												</td>
											</tr>
									</table>
								</form>
							  </td>
							</tr>
						<?php
						}
					}?>
					</tbody>
				</table>
			</div>

	
		</div>
		
   <div class="col-xs-2" style="padding: 0px;">
       <div id="reg_item_base"></div>
			<?php if ($this->config->item('track_cash')) { ?>
			<div style="text-align: center;">
				<?php echo anchor(site_url('sales/closeregister?continue=home'), lang('sales_close_register'),'class="btn btn-xs btn-danger clearfix"'); ?>
			</div>
		<?php } ?>
			<div id="overall_sale">				
				<div id="suspend_cancel">
					<div id="suspend" <?php if(count($cart) > 0){ echo "style='visibility: visible;'";}?>>				
						<?php
						// Only show this part if there are Items already in the sale.
						if(count($cart) > 0){ ?>
								<div class='btn btn-xs btn-warning pull-left' id='suspend_sale_button'> 
								<?php echo lang('sales_suspend_sale');?>
								</div>
						<?php }	?>
					</div>

					<div id="cancel" <?php if(count($cart) > 0){  echo "style='visibility: visible;'";}?>>											
						<?php
						// Only show this part if there are Items already in the sale.
						if(count($cart) > 0){ ?>
							<?php echo form_open("sales/cancel_sale",array('id'=>'cancel_sale_form')); ?>
								<div class='btn btn-xs btn-danger pull-right' id='cancel_sale_button'>
									<?php echo lang('sales_cancel_sale'); ?>
								</div>
							</form>
						<?php } ?>
					</div>
				</div>

				<div id="customer_info_shell">
					<?php
					if(isset($customer))
					{
						echo "<div id='customer_info_filled'>";							
							echo '<div id="customer_name">'.character_limiter($customer, 25).'</div>';
							echo '<div id="customer_email"></div>';

							echo '<div id="customer_edit" style="float:left;">'.anchor("customers/view/$customer_id/width~550", lang('common_edit'),  array('class'=>'thickbox none btn btn-xs btn-primary','title'=>lang('customers_update'))).'</div>';

							echo '<div id="customer_remove" class="pull-right">'.anchor("sales/delete_customer", lang('sales_detach'),array('id' => 'delete_customer','class'=>'btn btn-xs btn-danger')).'</div>';
						echo "</div>";
					}
					else
					{ ?>
						<div id='customer_info_empty'>
							<?php echo form_open("sales/select_customer",array('id'=>'select_customer_form','autocomplete'=>'false')); ?>
							<label id="customer_label" for="customer">
								<?php echo lang('sales_select_customer'); ?>
							</label>
							<?php echo form_input(array('name'=>'customer','id'=>'customer','size'=>'30','value'=>lang('sales_start_typing_customer_name'),  'accesskey' => 'c'));?>
							</form>
							<div id="add_customer_info">
								<div id="common_or">
									<?php echo lang('common_or'); ?>
								</div>
								<?php 
									echo anchor("customers/view/-1/width~550",
									"<div class='small_button fix-button' style='margin:0 auto;'> <span>".lang('sales_new_customer')."</span> </div>", array('class'=>'thickbox none','title'=>lang('sales_new_customer')));
								?>
							</div>
							<div class="clearfix">&nbsp;</div>
						</div>
					<?php } ?>
				</div>
			
				<div id='sale_details'>
					<table id="sales_items">
						<tr>
							<td class="left"><?php echo lang('sales_items_in_cart'); ?>:</td>
							<td class="right"><?php echo $items_in_cart; ?></td>
						</tr>
						<?php
						$total_giftcard_free = 0;

						 foreach($payments as $payment) {

							?>
							<?php if (strpos($payment['payment_type'], lang('sales_giftcard'))!== FALSE) {?>
						<tr>
							<td class="left"><?php echo $payment['payment_type'].' '.lang('sales_balance') ?>: </td>
							<td class="right" style="white-space: nowrap;">
							<?php echo to_currency($this->Giftcard->get_giftcard_value(end(explode(':', $payment['payment_type']))) - $payment['payment_amount']);	
							?>
							</td>
						</tr>					
							<?php
							$total_giftcard_free +=  $payment['payment_amount'];
							 }?>

						<?php } ?>

						<tr>
						<input type="hidden" name="total_giftcard_free" id="total_giftcard_free" value="<?= $total_giftcard_free < $subtotal? $total_giftcard_free : 0  ?>">

							<td class="left"><?php echo lang('sales_sub_total'); ?>:</td>
							<td class="right" style="display: inline-table;"><?php echo to_currency($subtotal); ?></td>
						</tr>
						<?php foreach($taxes as $name=>$value) { ?>
						<tr>
							<td class="left"><?php echo $name; ?>:</td>
							<td class="right"><?php echo to_currency($value); ?></td>
						</tr>
						<?php }; ?>
					</table>
					<table id="sales_items_total">
						<tr>
							<td class="left"><?php echo lang('sales_total_to_dollar'); ?>:</td>
							<td class="right"><?php echo to_currency($total); ?></td>
						</tr>
					</table>

					<table id="sales_items_total">					
						<tr>
							<td class="left"><?php echo lang('sales_total_to_reil'); ?>:</td>
							<td class="right">
							<?php $exchange_to_reil = $this->Exchange->select_last_exchange_rate_to_reil(); ?>
							<?php echo to_number_money_reil($total * $exchange_to_reil); ?>
							</td>
						</tr>
					</table>

					<table id="sales_exchange_rate" style="border-top: 1px solid #fff; background: #08f2ff;">					
						<tr style="font-size: 12px;">
							<td class="left" style="vertical-align: middle;"><?php echo lang('sales_exchange_rate'); ?>:</td>
							<td class="right">
							<?php 
							
							$exchange_to_dollar = $this->Exchange->select_last_exchange_rate_to_dollar();
							?>
							<?php echo to_currency($exchange_to_dollar).' = '.to_number_money_reil($exchange_to_reil); ?>
							</td>
						</tr>
					</table>					

				</div>
				

				<?php
				// Only show this part if there are Items already in the sale.
				if(count($cart) > 0){ ?>

					<div id="Payment_Types" >
				
						<?php
						// Only show this part if there is at least one payment entered.
						if(count($payments) > 0)
						{
						?>
							<table id="register">
							<thead>
							<tr>
							<th id="pt_delete"></th>
							<th id="pt_type"><?php echo lang('sales_type'); ?></th>
							<th id="pt_amount"><?php echo lang('sales_amount'); ?></th>

							</tr>
							</thead>
							<tbody id="payment_contents">
							<?php
								foreach($payments as $payment_id=>$payment)
								{
								echo form_open("sales/edit_payment/".rawurlencode($payment_id),array('id'=>'edit_payment_form'.$payment_id));
								?>
								<tr>
								<td id="pt_delete"><?php echo anchor("sales/delete_payment/".rawurlencode($payment_id),'['.lang('common_delete').']', array('class' => 'delete_payment'));?></td>
								
								<td id="pt_type"><?php echo  $payment['payment_type']    ?> </td>
								<td id="pt_amount"><?php echo  to_currency($payment['payment_amount']);							
								?>  
								</td>				
				
								</tr>
								</form>

								<?php

								}
								?>
							</tbody>
							</table>
						<?php } ?>

						<table id="amount_due">

						<tr class="<?php if($payments_cover_total){ echo 'covered'; }?>">
							<td>
								<div class="float_left" style="font-size:.9em;"><?php echo lang('sales_amount_due'); ?>:</div>
							</td>
							<td style="text-align:right; ">
								<div class="float_left" style="text-align:right;font-weight:bold;"><?php echo to_currency($amount_due); ?></div>
							</td>
						</tr>
					</table>

						<div id="make_payment">
							<?php echo form_open("sales/add_payment",array('id'=>'add_payment_form')); ?>
							<table id="make_payment_table" >
								<tr id="mpt_top">
									<td id="add_payment_text">
										<?php echo lang('sales_add_payment'); ?>:
									</td>
									<td>
								<?php 
								 if($mode !== 'owed'){
								  echo form_dropdown('payment_type',$payment_options,array(), 'id="payment_types"');	
								 }else{
								
								 echo form_dropdown('payment_type',[lang('sales_owed')=>lang('sales_owed')],array(), 'id="payment_types"');	
								 }
								?>										
									</td>
								</tr>
						
								<tr id="mpt_bottom">
									<td id="tender" colspan="2">
									<label style="float: left;" id="amount_tendered_text">Dollar</label>
										<?php echo form_input(array('name'=>'amount_tendered','id'=>'amount_tendered','value'=>to_currency_no_money($amount_due),'size'=>'10','autocomplete'=>'off', 'accesskey' => 'p','class'=>'form-control'));	?>
										<input type="hidden" id="amount_due_value" value="<?php echo $amount_due;?>">
									</td>
								</tr>
							</table>

						
							<div class='btn btn-xs btn-success' id='add_payment_button'>
								<span><?php echo lang('sales_add_payment'); ?></span>
							</div>
							
							</form>
						</div>
					</div>

					<?php
					if(!empty($customer_email))
					{
						echo '<div id="email_customer">';
						echo form_checkbox(array(
							'name'        => 'email_receipt',
							'id'          => 'email_receipt',
							'value'       => '1',
							'checked'     => (boolean)$email_receipt,
							)).' '.lang('sales_email_receipt').': <br /><b style="font-size:1.1em; padding-left: 17px;">'.character_limiter($customer_email, 25).'</b><br />';
						echo '</div>';
					}

					
// 					print_r($this->Employee->get_logged_in_employee_info()); exit;
					// Only show this part if there is at least one payment entered.
					if(count($payments) > 0 ){

						  if($mode !== 'owed'){ 
						?>

						<!-- start sale finish -->

						<div id="finish_sale">

								<table id="make_payment_table" >
							
								<tr id="mpt_bottom">
									<td id="tender" colspan="2">
									<label style="float: left; font-size: 12px;">Receive Reil</label>
										<?php echo form_input(array('name'=>'amount_tendered_reil_exchange','id'=>'amount_tendered_reil_exchange','value'=>$receive_payment_sale*$exchange_to_reil,'size'=>'10','autocomplete'=>'off', 'accesskey' => 'p','class'=>'form-control'));?>										
									</td>
								</tr>

								<tr id="mpt_bottom">
									<td id="tender" colspan="2">
									<label style="float: left; font-size: 12px;">Receive Dollar </label>
										<?php echo form_input(array('name'=>'amount_tendered_dollar_exchange','id'=>'amount_tendered_dollar_exchange','value'=>$receive_payment_sale,'size'=>'10','autocomplete'=>'off', 'accesskey' => 'p','class'=>'form-control'));?>
										
									</td>
								</tr>

								<tr id="mpt_bottom">
									<td id="tender" colspan="2">
									<label style="float: left;font-size: 12px;">Exchange Reil</label>
										<?php echo form_input(array('name'=>'exchange_sale_to_reil','id'=>'exchange_sale_to_reil','value'=>$receive_payment_sale=="0"? 0 : ($receive_payment_sale - ($total - $total_giftcard_free))*$exchange_to_reil,'size'=>'10','autocomplete'=>'off', 'accesskey' => 'p','class'=>'form-control','readonly'=>true)); ?>
									
									</td>
								</tr>

								<tr id="mpt_bottom">
									<td id="tender" colspan="2">
									<label style="float: left; font-size: 12px;">Exchange Dollar</label>
										<?php echo form_input(array('name'=>'exchange_sale_to_dollar','id'=>'exchange_sale_to_dollar','value'=>$receive_payment_sale=="0"?0 : $receive_payment_sale - ($total-$total_giftcard_free),'size'=>'10','autocomplete'=>'off', 'accesskey' => 'p','class'=>'form-control','readonly'=>true)); ?>
									
									</td>
								</tr>

							</table>

							<?php echo form_open("sales/complete",array('id'=>'finish_sale_form')); ?>
							<?php							 
							if ($payments_cover_total)
							{
							echo '<label id="comment_label" for="comment">';
							echo lang('common_comments');
							echo ':</label><br/>';
							echo form_textarea(array('name'=>'comment', 'id' => 'comment', 'value'=>$comment,'rows'=>'1',  'accesskey' => 'o','style'=>'width: 100%;'));
							
							echo "<div class='btn btn-sm btn-success' id='finish_sale_button' style='width:100%; margin-top:5px;'><span>".lang('sales_complete_sale')."</span></div>";
							}
							?>
						</div>
						<!-- end sale finish -->

							<?php }else{ ?>
							<a href="payoweds/view_payowed/-1/width~850" class="thickbox none" style="margin-top: 2px;">
							<div class='btn btn-xs btn-primary' id='sales_payment_owed' style="width: 100%">
								<span><?php echo lang('sales_payment_owed'); ?></span>
							</div>
							</a>
							<?php } ?>
					</form>
					<?php }	?>
				<?php } ?>
			
			</div><!-- END OVERALL-->	
			
		</div>

		</div>
				<div class="panel-footer ">
			
					</div>
                </div>
			</div>
		</div>
	</div>

<div id="feedback_bar"></div>

<div id='TB_load'><img src='<?php echo base_url()?>images/loading_animation.gif'/></div>

<div id="feedback_bar"></div>

<script type="text/javascript">

<?php
if(isset($error))
{
	echo "set_feedback(".json_encode($error).",'error_message',false);";
}

if (isset($warning))
{
	echo "set_feedback(".json_encode($warning).",'warning_message',false);";
}

if (isset($success))
{
	echo "set_feedback(".json_encode($success).",'success_message',false);";
}
?>
</script>

<script type="text/javascript" language="javascript">
$(document).ready(function()
{

 $("#sales_payment_owed").click(function()
    {    	    	
    if($("#customer").val() === "<?php echo lang('sales_start_typing_customer_name');?>"){
    		alert($("#customer").val());    		
    		$("#customer").focus();
    		$("#customer").val('');

     }
    });

	$('#amount_tendered_reil_exchange').keydown(function () {
	calc_amount_tendered_reil_exchange();
	});
		$('#amount_tendered_reil_exchange').change(function () {
	calc_amount_tendered_reil_exchange();
	});
	$('#amount_tendered_reil_exchange').blur(function () {
	calc_amount_tendered_reil_exchange();

	});

	function calc_amount_tendered_reil_exchange(){
			var amount_tendered_reil_exchange = $('#amount_tendered_reil_exchange').val();			
		var exchange_reil = <?= $exchange_to_reil ?>;
		var total_exchange_to_dollar = (parseFloat(amount_tendered_reil_exchange).toFixed(2) / parseFloat(exchange_reil).toFixed(2));
		$('#amount_tendered_dollar_exchange').val(parseFloat(total_exchange_to_dollar).toFixed(2));	
		exchange_sale_total();
		set_receive_payment_sale();
	}

	$('#amount_tendered_dollar_exchange').keydown(function () {
	  calc_amount_tendered_dollar_exchange();	 
	});
	$('#amount_tendered_dollar_exchange').blur(function () {
	  calc_amount_tendered_dollar_exchange();	 
	});
	$('#amount_tendered_dollar_exchange').change(function () {
	  calc_amount_tendered_dollar_exchange();	  
	});

	function calc_amount_tendered_dollar_exchange(){
		var amount_tendered_dollar_exchange = $('#amount_tendered_dollar_exchange').val();	
		var exchange_reil = <?= $exchange_to_reil ?>;
		var total_exchange_to_riel = amount_tendered_dollar_exchange * exchange_reil;		
		$('#amount_tendered_reil_exchange').val(parseFloat(total_exchange_to_riel).toFixed(2));	
		exchange_sale_total();
		set_receive_payment_sale();		
	}

	function exchange_sale_total(){
		
		var total_giftcard_free = $('#total_giftcard_free').val();
		var total_sale = <?= $total ?> - total_giftcard_free;
		var exchange_reil = <?= $exchange_to_reil ?>;

		var amount_tendered_reil_exchange = $('#amount_tendered_reil_exchange').val();
		var amount_tendered_dollar_exchange = $('#amount_tendered_dollar_exchange').val();

		var exchange_sale_to_reil = amount_tendered_reil_exchange - (total_sale * exchange_reil);
		$('#exchange_sale_to_reil').val(parseFloat(exchange_sale_to_reil).toFixed(2));	
		var exchange_sale_to_dollar = amount_tendered_dollar_exchange - total_sale;
		$('#exchange_sale_to_dollar').val(parseFloat(exchange_sale_to_dollar).toFixed(2));
	}
	
	
	var my_ar = new Array ("reg_item_total","reg_item_discount", "reg_item_qty", "reg_item_price", "reg_item_stock", "reg_item_number", "reg_item_name", "reg_item_del");
	for (i=0; i < my_ar.length; i++ ) 
	{
		my_th = $("th#" + my_ar[i]);
		my_td = $("td#" + my_ar[i]);
		my_td.each(function (i)
		{
			$(this).width(my_th.width());
		}); 
	}

 	$('a.thickbox, area.thickbox, input.thickbox').each(function(i) 
	{
		$(this).unbind('click');
    });

	tb_init('a.thickbox, area.thickbox, input.thickbox');
		
	$('#add_item_form, #mode_form, #select_customer_form, #add_payment_form').ajaxForm({target: "#register_container", beforeSubmit: salesBeforeSubmit, success: salesSuccess});
	
	$("#cart_contents input").change(function()
	{
		var toFocusId = $(":input[type!=hidden]:eq("+($(":input[type!=hidden]").index(this) + 1) +")").attr('id');
		$(this.form).ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit, success: function()
		{
			salesSuccess();
			setTimeout(function(){$('#item').focus();}, 10);
		}
		});
	});
	
	$( "#item" ).autocomplete({
		source: '<?php echo site_url("sales/item_search"); ?>',
		delay: 10,
		autoFocus: false,
		minLength: 0,
		select: function(event, ui)
		{
 			event.preventDefault();
 			$( "#item" ).val(ui.item.value);
			$('#add_item_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit, success: salesSuccess});
		},
		change: function(event, ui)
		{
			if ($(this).attr('value') != '' && $(this).attr('value') != <?php echo json_encode(lang('sales_start_typing_item_name')); ?>)
			{
				$("#add_item_form").ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit, success: salesSuccess});
			}
	
    		$(this).attr('value',<?php echo json_encode(lang('sales_start_typing_item_name')); ?>);
		}
	});
	
	setTimeout(function(){$('#item').focus();}, 10);
	
	$('#item,#customer').click(function()
    {
    	$(this).attr('value','');
    });

	$("#customer" ).autocomplete({
		source: '<?php echo site_url("sales/customer_search"); ?>',
		delay: 10,
		autoFocus: false,
		minLength: 0,
		select: function(event, ui)
		{
			$("#customer").val(ui.item.value);
			$('#select_customer_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit, success: salesSuccess});
		}
	});

	function set_receive_payment_sale() {
		$.post('<?php echo site_url("sales/set_receive_payment_sale");?>', {receive_payment_sale: $('#amount_tendered_dollar_exchange').val()});
	}

    $('#customer').blur(function()
    {
    	$(this).attr('value',<?php echo json_encode(lang('sales_start_typing_customer_name')); ?>);
    });
	
	$('#comment').change(function() 
	{
		$.post('<?php echo site_url("sales/set_comment");?>', {comment: $('#comment').val()});
	});
	
	$('#email_receipt').change(function() 
	{
		$.post('<?php echo site_url("sales/set_email_receipt");?>', {email_receipt: $('#email_receipt').is(':checked') ? '1' : '0'});
	});
	
	
    $("#finish_sale_button").click(function()
    {
    	if (confirm(<?php echo json_encode(lang("sales_confirm_finish_sale")); ?>))
    	{
    		$('#finish_sale_form').submit();
    	}
    });

	$("#suspend_sale_button").click(function()
	{
		if (confirm(<?php echo json_encode(lang("sales_confirm_suspend_sale")); ?>))
    	{
			$("#register_container").load('<?php echo site_url("sales/suspend"); ?>');
    	}
	});

    $("#cancel_sale_button").click(function()
    {
    	if (confirm(<?php echo json_encode(lang("sales_confirm_cancel_sale")); ?>))
    	{
			$('#cancel_sale_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit, success: salesSuccess});
    	}
    });

//modify by bunthoeun start

	$("#add_payment_button").click(function()
	{

		if($("#payment_types").val() == <?php echo json_encode(lang('sales_giftcard')); ?>){
			$('#add_payment_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit, success: salesSuccess});
		}else{

      var mode =  $('#mode').val();

	  if(mode == 'sale'){

		at = parseFloat($("#amount_tendered").val());
		ad = parseFloat($("#amount_due_value").val());

		if(at > 0  && at <= ad){    	
			$('#add_payment_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit, success: salesSuccess});
		 }
		else{
			alert(<?php echo json_encode(lang("sales_payment_over")); ?>);
		 }

		}else  if(mode == 'owed'){

		at = parseFloat($("#amount_tendered").val());
		ad = parseFloat($("#amount_due_value").val());

		if(at > 0  && at <= ad){    	
			$('#add_payment_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit, success: salesSuccess});
		 }
		else{
			alert(<?php echo json_encode(lang("sales_payment_over")); ?>);
		 }

		}else if(mode == 'return'){

		at = parseFloat($("#amount_tendered").val());
		ad = parseFloat($("#amount_due_value").val());

		//condition return 
		if(at < 0  && at >= ad){    	
			$('#add_payment_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit, success: salesSuccess});
		 }
		else{
			alert(<?php echo json_encode(lang("sales_payment_over")); ?>);
		 }

		}else{
			console.log('something went wrong');
		}

		}
			
		
    });

//modify by bunthoeun end


	$("#payment_types").change(checkPaymentTypeGiftcard).ready(checkPaymentTypeGiftcard);
	$('#mode').change(function()
	{
		$('#mode_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit, success: salesSuccess});
	});
	
	$('.delete_item, .delete_payment, #delete_customer').click(function(event)
	{
		event.preventDefault();
		$("#register_container").load($(this).attr('href'));	
	});
});

function post_item_form_submit(response)
{
	if(response.success)
	{
		$("#item").attr("value",response.item_id);
		$('#add_item_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit, success: salesSuccess});
		
	}
}

function post_person_form_submit(response)
{
	if(response.success)
	{
		if ($("#select_customer_form").length == 1)
		{
			$("#customer").attr("value",response.person_id);
			$('#select_customer_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit, success: salesSuccess});
		}
		else
		{
			$("#register_container").load('<?php echo site_url("sales/reload"); ?>');
		}
	}
}

function checkPaymentTypeGiftcard()
{

	if ($("#payment_types").val() == <?php echo json_encode(lang('sales_giftcard')); ?>)
	{
		$("#amount_tendered_label").html(<?php echo json_encode(lang('sales_giftcard_number')); ?>);
		$("#amount_tendered_text").html(<?php echo json_encode(lang('sales_giftcard_number')); ?>);
		$("#amount_tendered").val('');
		$("#amount_tendered").focus();
	}
	else
	{	
		$("#amount_tendered").val($('#amount_due_value').val());
		$("#amount_tendered_label").html(<?php echo json_encode(lang('sales_amount_tendered')); ?>);
		$("#amount_tendered_text").html("Amount USD");		
	}
}

function salesBeforeSubmit(formData, jqForm, options)
{
	$("#add_payment_button").hide();
	$("#finish_sale_button").hide();
	$("#TB_load").show();
}

function salesSuccess(responseText, statusText, xhr, $form){

}


</script>