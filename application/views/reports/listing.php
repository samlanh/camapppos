<?php $this->load->view("partial/header"); ?>

<div class="container" style=" padding-right: 0px; padding-left: 0px;">
		<div class="row" style=" margin-right: 0px; margin-left: 0px;">
			<div class="col-xs-12"  style="padding-right: 5px; padding-left: 5px;">
				<div class="panel panel-default">
					<div class="panel-heading clearfix">
					<img src='<?php echo base_url()?>images/menubar/reports.png' alt='<?php echo lang('reports_reports'); ?> - <?php echo lang('reports_welcome_message'); ?>' />
		        
		           <?php echo lang('reports_reports'); ?>

					</div>
					<div class="panel-body" style="padding: 15px;">

<ul id="report_list" style="text-align: center;">
	<li class="full"> 
		<h3><?php echo lang('reports_customers'); ?></h3>
		<ul>	
			<li class="graphical"><a href="<?php echo site_url('reports/graphical_summary_customers');?>"><?php echo lang('reports_graphical_reports'); ?></a></li>
			<li class="summary"><a href="<?php echo site_url('reports/summary_customers');?>"><?php echo lang('reports_summary_reports'); ?></a></li>
			<li class="detailed"><a href="<?php echo site_url('reports/specific_customer');?>"><?php echo lang('reports_detailed_reports'); ?></a></li>		
		</ul>
	</li>
	<li class="full">
		<h3><?php echo lang('reports_employees'); ?></h3>
		<ul>
			<li class="graphical"><a href="<?php echo site_url('reports/graphical_summary_employees');?>"><?php echo lang('reports_graphical_reports'); ?></a></li>
			<li class="summary"><a href="<?php echo site_url('reports/summary_employees');?>"><?php echo lang('reports_summary_reports'); ?></a></li>
			<li class="detailed"><a href="<?php echo site_url('reports/specific_employee');?>"><?php echo lang('reports_detailed_reports'); ?></a></li>
		</ul>
	</li>
	<li class="full">
		<h3><?php echo lang('reports_sales'); ?></h3>
		<ul>
			<li class="graphical"><a href="<?php echo site_url('reports/graphical_summary_sales');?>"><?php echo lang('reports_graphical_reports'); ?></a></li>
			<li class="summary"><a href="<?php echo site_url('reports/summary_sales');?>"><?php echo lang('reports_summary_reports'); ?></a></li>
			<li class="detailed"><a href="<?php echo site_url('reports/detailed_sales');?>"><?php echo lang('reports_detailed_reports'); ?></a></li>			
		</ul>
	</li>
	<?php if ($this->config->item('track_cash')) { ?>
	<li class="third">
		<h3><?php echo lang('reports_register_log_title'); ?></h3>
		<ul>
			<li>&nbsp;</li>
			<li>&nbsp;</li>
			<li class="detailed"><a href="<?php echo site_url('reports/detailed_register_log');?>"><?php echo lang('reports_detailed_reports'); ?></a></li>			
		</ul>
	</li>
	<?php } ?>
	<li class="second">
		<h3><?php echo lang('reports_categories'); ?></h3>
		<ul>
			<li class="graphical"><a href="<?php echo site_url('reports/graphical_summary_categories');?>"><?php echo lang('reports_graphical_reports'); ?></a></li>
			<li class="summary"><a href="<?php echo site_url('reports/summary_categories');?>"><?php echo lang('reports_summary_reports'); ?></a></li>		
		</ul>
	</li>
	<li class="second">
		<h3><?php echo lang('reports_discounts'); ?></h3>
		<ul>
			<li class="graphical"><a href="<?php echo site_url('reports/graphical_summary_discounts');?>"><?php echo lang('reports_graphical_reports'); ?></a></li>
			<li class="summary"><a href="<?php echo site_url('reports/summary_discounts');?>"><?php echo lang('reports_summary_reports'); ?></a></li>			
		</ul>
	</li>
	<li class="second">
		<h3><?php echo lang('reports_items'); ?></h3>
		<ul>
			<li class="graphical"><a href="<?php echo site_url('reports/graphical_summary_items');?>"><?php echo lang('reports_graphical_reports'); ?></a></li>
			<li class="summary"><a href="<?php echo site_url('reports/summary_items');?>"><?php echo lang('reports_summary_reports'); ?></a></li>			
		</ul>
	</li>
	<li class="second">
		<h3><?php echo lang('module_item_kits'); ?></h3>
		<ul>
			<li class="graphical"><a href="<?php echo site_url('reports/graphical_summary_item_kits');?>"><?php echo lang('reports_graphical_reports'); ?></a></li>
			<li class="summary"><a href="<?php echo site_url('reports/summary_item_kits');?>"><?php echo lang('reports_summary_reports'); ?></a></li>			
		</ul>
	</li>
	<li class="second">
		<h3><?php echo lang('reports_payments'); ?></h3>
		<ul>
			<li class="graphical"><a href="<?php echo site_url('reports/graphical_summary_payments');?>"><?php echo lang('reports_graphical_reports'); ?></a></li>
			<li class="summary"><a href="<?php echo site_url('reports/summary_payments');?>"><?php echo lang('reports_summary_reports'); ?></a></li>	
		</ul>
	</li>
	<li class="second">
		<h3><?php echo lang('reports_suppliers'); ?></h3>
		<ul>
			<li class="graphical"><a href="<?php echo site_url('reports/graphical_summary_suppliers');?>"><?php echo lang('reports_graphical_reports'); ?></a></li>
			<li class="summary"><a href="<?php echo site_url('reports/summary_suppliers');?>"><?php echo lang('reports_summary_reports'); ?></a></li>
			<li class="detailed"><a href="<?php echo site_url('reports/specific_supplier');?>"><?php echo lang('reports_detailed_reports'); ?></a></li>					
		</ul>
	</li>
	<li class="second">
		<h3><?php echo lang('reports_taxes'); ?></h3>
		<ul>
			<li class="graphical"><a href="<?php echo site_url('reports/graphical_summary_taxes');?>"><?php echo lang('reports_graphical_reports'); ?></a></li>
			<li class="summary"><a href="<?php echo site_url('reports/summary_taxes');?>"><?php echo lang('reports_summary_reports'); ?></a></li>			
		</ul>
	</li>
	<li class="third">
		<h3><?php echo lang('reports_receivings'); ?></h3>
		<ul>
			<li>&nbsp;</li>
			<li>&nbsp;</li>
			<li class="detailed"><a href="<?php echo site_url('reports/detailed_receivings');?>"><?php echo lang('reports_detailed_reports'); ?></a></li>			
		</ul>
	</li>
	<li class="second">
		<h3><?php echo lang('reports_inventory_reports'); ?></h3>
		<ul>
			<li class="graphical"><a href="<?php echo site_url('reports/inventory_low');?>"><?php echo lang('reports_low_inventory'); ?></a></li>
			<li class="summary"><a href="<?php echo site_url('reports/inventory_summary');?>"><?php echo lang('reports_inventory_summary'); ?></a></li>	
		</ul>
	</li>
	<li class="third">
		<h3><?php echo lang('reports_deleted_sales'); ?></h3>
		<ul>
			<li>&nbsp;</li>
			<li>&nbsp;</li>
			<li class="detailed"><a href="<?php echo site_url('reports/deleted_sales');?>"><?php echo lang('reports_detailed_reports'); ?></a></li>
		</ul>
	</li>	
	<li class="full">
		<h3><?php echo lang('reports_giftcards'); ?></h3>
		<ul>
			<li>&nbsp;</li>
			<li class="summary"><a href="<?php echo site_url('reports/summary_giftcards');?>"><?php echo lang('reports_summary_reports'); ?></a></li>			
			<li class="detailed"><a href="<?php echo site_url('reports/detailed_giftcards');?>"><?php echo lang('reports_detailed_reports'); ?></a></li>			
		</ul>
	</li>
	<li class="third">
		<h3><?php echo lang('reports_store_accounts'); ?></h3>
		<ul>
			<li>&nbsp;</li>
			<li>&nbsp;</li>			
			<li class="detailed"><a href="<?php echo site_url('reports/specific_supplier_store_accounts');?>"><?php echo lang('reports_detailed_reports'); ?></a></li>			
		</ul>
	</li>

	<li class="third">
		<h3><?php echo lang('module_incomes'); ?></h3>
		<ul>
			<li>&nbsp;</li>
			<li>&nbsp;</li>			
			<li class="detailed"><a href="<?php echo site_url('reports/detailed_income');?>"><?php echo lang('reports_detailed_reports'); ?></a></li>			
		</ul>
	</li>

	<li class="third">
		<h3><?php echo lang('module_expenses'); ?></h3>
		<ul>
			<li>&nbsp;</li>
			<li>&nbsp;</li>			
			<li class="detailed"><a href="<?php echo site_url('reports/detailed_expense');?>"><?php echo lang('reports_detailed_reports'); ?></a></li>			
		</ul>
	</li>

	<li class="second">
		<h3><?php echo lang('common_income_expense'); ?></h3>
		<ul>
			<li style="background: #f2f2f2;">&nbsp;</li>					
			<li class="detailed"><a href="<?php echo site_url('reports/summary_income_expense');?>">
				<?php echo lang('reports_summary_reports'); ?>
			</a></li>	
				
		</ul>
	</li>

	<li class="third">
		<h3><?php echo lang('module_payoweds'); ?></h3>
		<ul>
			<li>&nbsp;</li>

			<li class="summary"><a href="<?php echo site_url('reports/payowed_summary');?>"><?php echo lang('reports_summary_reports'); ?></a></li>	
			<li class="detailed"><a href="<?php echo site_url('reports/detailed_payoweds');?>"><?php echo lang('reports_detailed_reports'); ?></a></li>			
		</ul>
	</li>
	</ul>
					</div>
					<div class="panel-footer ">
					
					</div>
                </div>
			</div>

		</div>
	</div>

<?php $this->load->view("partial/footer"); ?>