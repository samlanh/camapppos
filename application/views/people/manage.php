<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
$(document).ready(function() 
{ 
	var table_columns = ['','last_name','first_name','email','phone_number'];
	enable_sorting("<?php echo site_url("$controller_name/sorting"); ?>",table_columns, <?php echo $per_page; ?>);
    enable_select_all();
    enable_checkboxes();
    enable_row_selection();
    enable_search('<?php echo site_url("$controller_name/suggest");?>',<?php echo json_encode(lang("common_confirm_search"));?>);
    enable_email('<?php echo site_url("$controller_name/mailto")?>');
    enable_delete(<?php echo json_encode(lang($controller_name."_confirm_delete"));?>,<?php echo json_encode(lang($controller_name."_none_selected"));?>);
	enable_cleanup(<?php echo json_encode(lang("customers_confirm_cleanup"));?>);
}); 


function post_person_form_submit(response)
{
	if(!response.success)
	{
		set_feedback(response.message,'error_message',true);	
	}
	else
	{
		//This is an update, just update one row
		if(jQuery.inArray(response.person_id,get_visible_checkbox_ids()) != -1)
		{
			update_row(response.person_id,'<?php echo site_url("$controller_name/get_row")?>');
			set_feedback(response.message,'success_message',false);	
			
		}
		else //refresh entire table
		{
			do_search(true,function()
			{
				//highlight new row
				highlight_row(response.person_id);
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
				 if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
					<?php echo anchor("$controller_name/view/-1/width~$form_width",'<i class="fa fa-plus" aria-hidden="true"></i> '.
					$this->lang->line($controller_name.'_new'),
						array('class'=>'thickbox none new', 'title'=>$this->lang->line($controller_name.'_new')));
				}	
				?>
				</li>
				<!--
				 <li> 
				<a class="email email_inactive" href="<?php echo current_url(). '#'; ?>" id="email"><i class="fa fa-envelope" aria-hidden="true"></i> <?php echo lang("common_email");?></a>		
				</li>
				-->
				<li> 
				<?php if ($controller_name =='customers') {?>
				<?php echo anchor("$controller_name/excel_import/width~$form_width",'<i class="fa fa-upload" aria-hidden="true"></i> '.
				lang('common_excel_import'),
				array('class'=>'thickbox none import','title'=>lang('customers_import_customers_from_excel')));
				} ?>
				</li>

				<li> 
				<?php
				if ($controller_name == 'customers' || $controller_name == 'employees') {	
					echo anchor("$controller_name/excel_export",'<i class="fa fa-download" aria-hidden="true"></i> '.
					lang('common_excel_export'),
					array('class'=>'none import'));
				}
				?>
				</li>
				<li> 
				<?php if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
					<?php echo anchor("$controller_name/delete", '<i class="fa fa-trash-o" aria-hidden="true"></i> '. $this->lang->line("common_delete"),array('id'=>'delete', 'class'=>'delete_inactive')); ?>
				<?php } ?>
				</li>
				<li> 
				<?php if ($controller_name =='customers') {?>
					<?php echo 
						anchor("$controller_name/cleanup", '<i class="fa fa-remove" aria-hidden="true"></i> '.
						lang("customers_cleanup_old_customers"),
						array('id'=>'cleanup', 
							'class'=>'cleanup')); 
					?>
				<?php } ?>
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