<?php $this->load->view("partial/header"); ?>


<div class="container" style=" padding-right: 0px; padding-left: 0px;">
		<div class="row" style=" margin-right: 0px; margin-left: 0px;">
			
		<div class="col-xs-12" style="padding-right: 0px; padding-left: 0px;">
			<div class="panel panel-default">
					<div class="panel-heading clearfix">
						<img style="width: 30px;" src='<?php echo base_url()?>images/menubar/sales.png' alt='title icon' />					
						<strong><?php echo lang('sales_suspended_sales'); ?></strong>
					</div>
					<div class="panel-body">
				<div class="col-xs-12">
					<?php echo form_open("sales/suspended",array('id'=>'search_customer_form')); ?>
			 <div id="custom-search-input">
                <div class="input-group"> 
					<?php echo form_input(array('name'=>'search','class'=>'form-control','id'=>'search','size'=>'40', 'accesskey' => 'i'));?>
				 <span class="input-group-btn">
                        <button class="btn btn-info" type="button">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
			      </div>
			      </div> 	
				<?php echo form_close(); ?>

				</div>
				<div id="table_holder" style="width: 100%;">
				<table class="tablesorter report table table-striped table-bordered" id="sortable_table">
				<thead>
						<tr>
							<th style="padding-top: 7px; padding-bottom: 7px;">+</th>
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
									<input type="submit" name="submit" value="<?php echo lang('sales_unsuspend'); ?>" id="submit_unsuspend" class="btn btn-xs btn-info">
									</form>
								</td>
								<td>
									<?php 
									echo form_open('sales/receipt/'.$suspended_sale['sale_id'], array('method'=>'get', 'id' => 'form_receipt_suspended_sale'));
									?>
									<input type="submit" name="submit" value="<?php echo lang('sales_recp'); ?>" id="submit_receipt" class="btn btn-xs btn-primary">
									</form>
								</td>
								<td>
									<?php 
									echo form_open('sales/delete_suspended_sale', array('id' => 'form_delete_suspended_sale'));
									echo form_hidden('suspended_sale_id', $suspended_sale['sale_id']);
									?>
									<input type="submit" name="submit" value="<?php echo lang('common_delete'); ?>" id="submit_delete" class="btn btn-xs btn-danger">
									</form>
								</td>
							</tr>
							<tr>
								<td colspan="12" class="innertable">
									<table class="innertable table-striped">
										<thead>
											<tr>
												<th width="52%"><?php echo lang('sales_item_name'); ?></th>
												<th width="10%"><?php echo lang('sales_quantity'); ?></th>
												<th width="10%"><?php echo lang('sales_price'); ?></th>
												<th width="10%"><?php echo lang('sales_discount'); ?></th>
												<th width="15%"><?php echo lang('sales_total'); ?></th>
											</tr>
										</thead>
									
										<tbody>
											<?php 
											$i = 1;
											foreach ($items_suspend AS $i => $row2) { ?>

										<?php  if($row2['sale_id'] == $suspended_sale['sale_id']) :?>

												<tr>
												<td style="padding-bottom: 4px; padding-top: 4px;">
												<?php
													if (isset($row2['item_id']))
													{
														$item = $this->Item->get_info($row2['item_id']);
														echo $item->name;
													}
													else
													{
													?>
														&nbsp;
													<?php
													}
													?>
													</td>
													<td><?php echo $row2['quantity_purchased']; ?></td>
													<td><?php echo $row2['item_unit_price']; ?></td>
													<td> <?php echo $row2['discount_percent']; ?></td>

													<td><?php 
													$total = $row2['item_unit_price']*$row2['quantity_purchased'];
													$discount = ($total  * $row2['discount_percent']) / 100;
													echo $total - $discount; ?> </td>
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

					</div>
					<div class="panel-footer ">
						
					</div>
                </div>
			</div>
		</div>
	</div>

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
