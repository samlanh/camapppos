<?php $this->load->view("partial/header"); ?>
<table id="contents" >
	<tr>
		<td>
			<table id="title_section">
				<tr>
					<td id="title_icon">
						<img src='<?php echo base_url()?>images/menubar/sales.png' alt='title icon' />
					</td>
					<td id="title">
						<?php echo lang('sales_suspended_sales'); ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<div id="reg_item_search_suspended">
				<?php echo form_open("sales/suspended",array('id'=>'search_customer_form')); ?>
					<?php echo form_input(array('name'=>'search','id'=>'search','size'=>'40', 'accesskey' => 'i'));?>																									
				</form>
			</div>
		</td>
	</tr>
	<tr>
		<td id="item_table">
			<div id="table_holder" style="width: 100%;">
				<table class="tablesorter report" id="sortable_table">
					<thead>
						<tr>
							<th>+</th>
							<th><?php echo lang('sales_suspended_sale_id'); ?></th>
							<th><?php echo lang('sales_date'); ?></th>
							<th><?php echo lang('sales_customer'); ?></th>
							<th><?php echo lang('sales_total'); ?></th>
							<th><?php echo lang('sales_payments_total'); ?></th>
							<th><?php echo lang('sales_amount_due'); ?></th>
							<th><?php echo lang('sales_comments'); ?></th>
							<th><?php echo lang('sales_unsuspend'); ?></th>
							<th><?php echo lang('sales_receipt'); ?></th>
							<th><?php echo lang('common_delete'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php				
						foreach ($suspended_sales as $suspended_sale)
						{
						?>
							<tr>
								<td><a href="#" class="expand" style="font-weight: bold;">+</a></td>
								<td><?php echo $suspended_sale['sale_id'];?></td>
								<td><?php echo date(get_date_format(),strtotime($suspended_sale['sale_time']));?></td>
								<td>
									<?php
									if (isset($suspended_sale['customer_id']))
									{
										$customer = $this->Customer->get_info($suspended_sale['customer_id']);
										echo $customer->first_name. ' '. $customer->last_name;
									}
									else
									{
									?>
										&nbsp;
									<?php
									}
									?>
								</td>
								<td align="right"><?php echo to_currency($suspended_sale['total']);?></td>
								<td align="right"><?php echo to_currency($suspended_sale['pay']);?></td>
								<td align="right"><?php echo to_currency($suspended_sale['total'] - $suspended_sale['pay']);?></td>
								<td><?php echo $suspended_sale['comment'];?></td>
								<td>
									<?php 
									echo form_open('sales/unsuspend');
									echo form_hidden('suspended_sale_id', $suspended_sale['sale_id']);
									?>
									<input type="submit" name="submit" value="<?php echo lang('sales_unsuspend'); ?>" id="submit_unsuspend" class="submit_button float_right">
									</form>
								</td>
								<td>
									<?php 
									echo form_open('sales/receipt/'.$suspended_sale['sale_id'], array('method'=>'get', 'id' => 'form_receipt_suspended_sale'));
									?>
									<input type="submit" name="submit" value="<?php echo lang('sales_recp'); ?>" id="submit_receipt" class="submit_button float_right">
									</form>
								</td>
								<td>
									<?php 
									echo form_open('sales/delete_suspended_sale', array('id' => 'form_delete_suspended_sale'));
									echo form_hidden('suspended_sale_id', $suspended_sale['sale_id']);
									?>
									<input type="submit" name="submit" value="<?php echo lang('common_delete'); ?>" id="submit_delete" class="submit_button float_right">
									</form>
								</td>
							</tr>
							<tr>
								<td colspan="12" class="innertable">
									<table class="innertable">
										<thead>
											<tr>
												<th><?php echo lang('sales_date'); ?></th>
												<th><?php echo lang('sales_payment'); ?></th>
												<th><?php echo lang('sales_amount'); ?></th>
											</tr>
										</thead>
									
										<tbody>
											<?php foreach ($sales_payments AS $i => $row2) { ?>
												<?php if($row2['sale_id'] == $suspended_sale['sale_id']) :?>																				
												<tr>													
													<td><?php echo date(get_date_format(),strtotime($row2['payment_date'])) ." ". date(get_time_format(),strtotime($row2['payment_date'])); ?></td>
													<td><?php echo $row2['payment_type']; ?></td>
													<td  align="right"><?php echo to_currency($row2['payment_amount']); ?></td>
												</tr>
												<?php endif;?>												
											<?php } ?>
										</tbody>
									</table>
								</td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</td>
	</tr>
</table>
<?php $this->load->view("partial/footer"); ?>
<script type="text/javascript">
$(document).ready(function()
{
	$("#form_delete_suspended_sale").submit(function()
	{
		if (!confirm(<?php echo json_encode(lang("sales_delete_confirmation")); ?>))
		{
			return false;
		}
	});

	$(".tablesorter a.expand").click(function(event)
	{
		$(event.target).parent().parent().next().find('td.innertable').toggle();
		
		if ($(event.target).text() == '+')
		{
			$(event.target).text('-');
		}
		else
		{
			$(event.target).text('+');
		}
		return false;
	});
});
</script>
