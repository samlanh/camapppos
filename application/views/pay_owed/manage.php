<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
$(document).ready(function() 
{ 
	var table_columns = ['sale_id','customer_id','payment_date','total_amount','payment_amount','remain_balance',''];
	enable_sorting("<?php echo site_url("$controller_name/sorting"); ?>",table_columns, <?php echo $per_page; ?>);
    enable_select_all();
    enable_checkboxes();
    enable_row_selection();
    enable_search('<?php echo site_url("$controller_name/suggest");?>',<?php echo json_encode(lang("common_confirm_search"));?>);   
    enable_delete(<?php echo json_encode(lang($controller_name."_confirm_delete"));?>,<?php echo json_encode(lang($controller_name."_none_selected"));?>);
	enable_cleanup(<?php echo json_encode(lang("customers_confirm_cleanup"));?>);
}); 


function post_pay_owed_form_submit(response)
{
	if(!response.success)
	{
		set_feedback(response.message,'error_message',true);	
	}
	else
	{
		//This is an update, just update one row
		if(jQuery.inArray(response.id,get_visible_checkbox_ids()) != -1)
		{
			update_row(response.id,'<?php echo site_url("$controller_name/get_row")?>');
			set_feedback(response.message,'success_message',false);	
			
		}
		else //refresh entire table
		{
			do_search(true,function()
			{
				//highlight new row
				highlight_row(response.id);
				set_feedback(response.message,'success_message',false);		
			});
		}
	}
}
</script>

<div class="container" style=" padding-right: 0px; padding-left: 0px;">
		 <div class="row" style=" margin-right: 0px; margin-left: 0px;">

		 <div class="col-xs-2"  style="padding-right: 5px; padding-left: 5px;">
				<div class="panel panel-default">
					<div class="panel-heading clearfix">
						<img style="max-height: 30px;" src='<?php echo base_url()?>images/menubar/<?php echo $controller_name; ?>.png' alt='title icon' /> <strong><?php echo lang('common_list_of').' '.lang('module_'.$controller_name); ?></strong>
					</div>
					<div class="panel-body">
				 <ul class="nav nav-pills nav-stacked">
    
				<li> 
				<?php
				if ($controller_name == 'payoweds') {	
					echo anchor("$controller_name/excel_export",'<i class="fa fa-download" aria-hidden="true"></i> '.
					lang('common_excel_export'),
					array('class'=>'none import'));
				}
				?>
				</li>
				
				
			 </ul>

			</div>
			<div class="panel-footer ">
						
					</div>
            </div>
			</div>

	<div class="col-xs-10" style="padding-right: 5px; padding-left: 5px;">
				<div class="panel panel-default">
			<div class="panel-heading clearfix">
			<div class="col-xs-9">
			<h5> <?= lang('common_total') ?> : <b class="text-primary"><?= $total_rows ?></b> </h5>
			</div>

			<div class="col-xs-3">
			<?php echo form_open("$controller_name/search",array('id'=>'search_form','class'=>'form-horizontal pull-right')); ?>

			   <div id="custom-search-input">
                <div class="input-group">
                    <input type="text" name='search' id='search' class="form-control" placeholder="Search" />
                    <span class="input-group-btn">
                        <button class="btn btn-info" type="button">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                </div>
            </div>
				
			   <?php echo form_close() ?>
			</div>
			</div>
			
			<div class="panel-body">
           <?php echo $manage_table; ?>

			<div id="pagination" class="clearfix pull-right">
				<?php echo $pagination;?>
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
<?php $this->load->view("partial/footer"); ?>