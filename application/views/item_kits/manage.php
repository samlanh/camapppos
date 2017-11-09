<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
$(document).ready(function()
{
	var table_columns = ["","item_kit_number","name",'description','unit_price','',''];
	enable_sorting("<?php echo site_url("$controller_name/sorting"); ?>",table_columns, <?php echo $per_page; ?>);
	enable_select_all();
    enable_checkboxes();
    enable_row_selection();
    enable_search('<?php echo site_url("$controller_name/suggest");?>',<?php echo json_encode(lang("common_confirm_search"));?>);
    enable_delete(<?php echo json_encode(lang($controller_name."_confirm_delete"));?>,<?php echo json_encode(lang($controller_name."_none_selected"));?>);
    
    $('#generate_barcodes').click(function()
    {
    	var selected = get_selected_values();
    	if (selected.length == 0)
    	{
    		alert(<?php echo json_encode(lang('items_must_select_item_for_barcode')); ?>);
    		return false;
    	}

    	$(this).attr('href','<?php echo site_url("item_kits/generate_barcodes");?>/'+selected.join('~'));
    });

    $('#generate_barcode_labels').click(function()
    {
    	var selected = get_selected_values();
    	if (selected.length == 0)
    	{
    		alert(<?php echo json_encode(lang('items_must_select_item_for_barcode')); ?>);
    		return false;
    	}

    	$(this).attr('href','<?php echo site_url("item_kits/generate_barcode_labels");?>/'+selected.join('~'));
    });
});


function getb(coun,term,per_page)
{	
	$('#sortable_table tr th').unbind();
	var sort="<?php echo site_url("$controller_name/searching/"); ?>/";
	head = ['',"item_kit_number","name",'description','unit_price','',''];
	var paginate="#pagination tr td";
	enable_sorting(sort,head,paginate,coun,per_page,term);
   
	
}

function init_table_sorting()
{
	//Only init if there is more than one row
	if($('.tablesorter tbody tr').length >1)
	{
		$("#sortable_table").tablesorter(
		{
			sortList: [[1,0]],
			headers:
			{
				0: { sorter: false},
				5: { sorter: false}
			}

		});
	}
}

function post_item_kit_form_submit(response)
{
	if(!response.success)
	{
		set_feedback(response.message,'error_message',true);
	}
	else
	{
		//This is an update, just update one row
		if(jQuery.inArray(response.item_id,get_visible_checkbox_ids()) != -1)
		{
			update_row(response.item_id,'<?php echo site_url("$controller_name/get_row")?>');
			set_feedback(response.message,'success_message',false);

		}
		else //refresh entire table
		{
			do_search(true,function()
			{
				//highlight new row
				highlight_row(response.item_kit_id);
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
				
				<?php if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>	
				<li>			
				<?php echo 
					anchor("$controller_name/view/-1/width~$form_width",'<i class="fa fa-plus" aria-hidden="true"></i> '.
					lang($controller_name.'_new'),
					array('class'=>'thickbox none new', 
						'title'=>lang($controller_name.'_new')));
				?>
				</li>
				<?php } ?>
				<li>
				<?php echo 
					anchor("$controller_name/generate_barcode_labels",'<i class="fa fa-barcode" aria-hidden="true"></i> '.
					lang("common_barcode_labels"),
					array('id'=>'generate_barcode_labels', 
						'class' => 'generate_barcodes_inactive',
						'target' =>'_blank',
						'title'=>lang('common_barcode_labels'))); 
				?>
				</li>
				<li>
				<?php echo 
					anchor("$controller_name/generate_barcodes",'<i class="fa fa-barcode" aria-hidden="true"></i> '.
					lang("common_barcode_sheet"),
					array('id'=>'generate_barcodes',
					 	'class' => 'generate_barcodes_inactive',
						'target' =>'_blank',
						'title'=>lang('common_barcode_sheet'))); 
				?>
				</li>
					
				<?php if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) {?>	
				<li>	
				<?php echo 
					anchor("$controller_name/delete",'<i class="fa fa-trash-o" aria-hidden="true"></i> '.
					lang("common_delete"),
					array('id'=>'delete', 
						'class'=>'delete_inactive')); 
				?>
				</li>
				<?php } ?>
				<li>
				<?php echo anchor("$controller_name/excel_export",'<i class="fa fa-download" aria-hidden="true"></i> '.
					lang('common_excel_export'),
					array('class'=>'none import'));
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
			<h5> Totals : <b class="text-primary"><?= $total_rows ?></b> </h5>
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
<?php $this->load->view("partial/footer"); ?>
