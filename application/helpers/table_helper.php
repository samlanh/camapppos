<?php
/*
Gets the html table to manage people.
*/
function get_people_manage_table($people,$controller)
{
	$CI =& get_instance();
	$table='<table class="tablesorter table table-bordered" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />', 	
	lang('common_first_name'),
	lang('common_last_name'),
	lang('common_email'),
	lang('common_phone_number'),
	lang('common_action'));
	$table.='<thead><tr>';

	$count = 0;
	foreach($headers as $header)
	{
		$count++;
		
		if ($count == 1)
		{
			$table.="<th class='leftmost'>$header</th>";
		}
		elseif ($count == count($headers))
		{
			$table.="<th class='rightmost'>$header</th>";
		}
		else
		{
			$table.="<th>$header</th>";		
		}
	}
	$table.='</tr></thead><tbody>';
	$table.=get_people_manage_table_data_rows($people,$controller);
	$table.='</tbody></table>';
	return $table;
}

/*
Gets the html data rows for the people.
*/
function get_people_manage_table_data_rows($people,$controller)
{
	$CI =& get_instance();
	
	$table_data_rows='';
	
	foreach($people->result() as $person)
	{
		$table_data_rows.=get_person_data_row($person,$controller);
	}
	
	if($people->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>".lang('common_no_persons_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_person_data_row($person,$controller)
{
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();

	$start_of_time =  date('Y-m-d', 0);
	$today = date('Y-m-d');	
	$link = site_url('reports/specific_'.($controller_name == 'customers' ? 'customer' : 'employee').'/'.$start_of_time.'/'.$today.'/'.$person->person_id.'/all/0');
	$table_data_row='<tr>';	
	$table_data_row.="<td style='text-align:cener; width:3%;'>
	<input type='checkbox' id='person_$person->person_id' value='".$person->person_id."'/></td>";	
	$table_data_row.='<td width="20%"><a href="'.$link.'">'.$person->first_name.'</a></td>';
	$table_data_row.='<td width="20%"><a href="'.$link.'">'.$person->last_name.'</a></td>';
	$table_data_row.='<td width="30%">'.anchor("mail/form/$person->person_id/width~550", $person->email==''?'no email':$person->email, array('title'=>$person->email,'class'=>'thickbox')).'</td>';
	$table_data_row.='<td width="17%">'.$person->phone_number.'</td>';		
	$table_data_row.='<td width="10%" class="rightmost text-center" style="white-space:nowrap;">'.anchor($controller_name."/view/$person->person_id/width~$width", '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> '.lang('common_edit'),array('class'=>'thickbox btn btn-xs btn-primary text-center','title'=>lang($controller_name.'_update'))).'</td>';
	$table_data_row.='</tr>';
	
	return $table_data_row;
}

/*
Gets the html table to manage suppliers.
*/
function get_supplier_manage_table($suppliers,$controller)
{
	$CI =& get_instance();
	$table='<table class="tablesorter table table-bordered" id="sortable_table">';	
	$headers = array('<input type="checkbox" id="select_all" />',
	lang('suppliers_company_name'),
	lang('common_first_name'),
	lang('common_last_name'),	
	lang('common_email'),
	lang('common_phone_number'),
	lang('common_amount'),
	lang('common_payment'),
	lang('common_action'));
	$table.='<thead><tr>';

	$count = 0;
	foreach($headers as $header)
	{
		$count++;
		
		if ($count == 1)
		{
			$table.="<th class='leftmost'>$header</th>";
		}
		elseif ($count == count($headers))
		{
			$table.="<th class='rightmost'>$header</th>";
		}
		else
		{
			$table.="<th>$header</th>";		
		}
	}
	
	$table.='</tr></thead><tbody>';
	$table.=get_supplier_manage_table_data_rows($suppliers,$controller);
	$table.='</tbody></table>';
	return $table;
}

/*
Gets the html data rows for the supplier.
*/
function get_supplier_manage_table_data_rows($suppliers,$controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($suppliers->result() as $supplier)
	{
		$table_data_rows.=get_supplier_data_row($supplier,$controller);
	}
	
	if($suppliers->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='8'><div class='warning_message' style='padding:7px;'>".lang('common_no_persons_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_supplier_data_row($supplier,$controller)
{
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();
	
	$table_data_row='<tr>';
	$table_data_row.="<td width='5%'><input type='checkbox' id='person_$supplier->person_id' value='".$supplier->person_id."'/></td>";
	$table_data_row.='<td width="17%">'.$supplier->company_name.'</td>';	
	$table_data_row.='<td width="17%">'.$supplier->first_name.'</td>';
	$table_data_row.='<td width="17%">'.$supplier->last_name.'</td>';
	$table_data_row.='<td width="22%">'.anchor("mail/form/$supplier->person_id/width~$width", $supplier->email==''?'no email':$supplier->email, array('title'=>$supplier->email,'class'=>'thickbox')).'</td>';
	$table_data_row.='<td width="17%">'.$supplier->phone_number.'</td>';		
	$table_data_row.='<td width="18%" align="right">'.to_currency($supplier->balance).'</td>';
	$table_data_row.='<td width="5%">'.anchor($controller_name."/payment/$supplier->person_id/width~$width",'<i class="fa fa-dollar" aria-hidden="true"></i> '.lang('common_pay'),array('class'=>'thickbox btn btn-xs btn-success','title'=>lang('common_pay_title'))).'</td>';
	$table_data_row.='<td width="5%" class="rightmost">'.anchor($controller_name."/view/$supplier->person_id/width~$width", '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> '.lang('common_edit'),array('class'=>'thickbox btn btn-xs btn-primary text-center','title'=>lang($controller_name.'_update'))).'</td>';				
	$table_data_row.='</tr>';
	return $table_data_row;
}

/*
Gets the html table to manage items.
*/
function get_items_manage_table($items,$controller)
{
	$CI =& get_instance();
	$has_cost_price_permission = $CI->Employee->has_module_action_permission('items','see_cost_price', $CI->Employee->get_logged_in_employee_info()->person_id);
	$table='<table class="tablesorter table table-bordered" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />', 
	$CI->lang->line('items_item_number'),
	$CI->lang->line('items_name'),
	$CI->lang->line('items_category'),
	);
	
	if($has_cost_price_permission)
	{
		$headers = array_merge($headers, array($CI->lang->line('items_cost_price')));
	}
	
	$headers = array_merge($headers, array(
	$CI->lang->line('items_unit_price'),
	$CI->lang->line('items_tax_percents'),
	$CI->lang->line('items_quantity'),
	$CI->lang->line('items_inventory'),
	lang('common_action')
	));
	
	$table.='<thead><tr>';
	$count = 0;
	foreach($headers as $header)
	{
		$count++;
		
		if ($count == 1)
		{
			$table.="<th class='leftmost'>$header</th>";
		}
		elseif ($count == count($headers))
		{
			$table.="<th class='rightmost'>$header</th>";
		}
		else
		{
			$table.="<th>$header</th>";		
		}
	}
	$table.='</tr></thead><tbody>';
	$table.=get_items_manage_table_data_rows($items,$controller);
	$table.='</tbody></table>';
	return $table;
}

/*
Gets the html data rows for the items.
*/
function get_items_manage_table_data_rows($items,$controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($items->result() as $item)
	{
		$table_data_rows.=get_item_data_row($item,$controller);
	}
	
	if($items->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='11'><div class='warning_message' style='padding:7px;'>".lang('items_no_items_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_item_data_row($item,$controller)
{
	$CI =& get_instance();
	$has_cost_price_permission = $CI->Employee->has_module_action_permission('items','see_cost_price', $CI->Employee->get_logged_in_employee_info()->person_id);
	$item_tax_info=$CI->Item_taxes->get_info($item->item_id);
	$tax_percents = '';
	foreach($item_tax_info as $tax_info)
	{
		$tax_percents.=$tax_info['percent']. '%, ';
	}
	$tax_percents=substr($tax_percents, 0, -2);
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();

	$table_data_row='<tr>';
	$table_data_row.='<td width="3%"><input type="checkbox" id="item_'.$item->item_id.'" value="'.$item->item_id.'"/></td>';
	$table_data_row.='<td width="15%">'.$item->item_number.'</td>';
	$table_data_row.='<td width="15%">'.$item->name.'</td>';
	$table_data_row.='<td width="11%">'.$item->category.'</td>';
	if ($has_cost_price_permission)
	{
		$table_data_row.='<td width="11%" align="right">'.to_currency($item->cost_price).'</td>';
	}
	$table_data_row.='<td width="11%" align="right">'.to_currency($item->unit_price).'</td>';
	$table_data_row.='<td width="11%">'.$tax_percents.'</td>';	
	$table_data_row.='<td width="11%">'.$item->quantity.'</td>';
	$table_data_row.='<td width="8%">'.anchor($controller_name."/inventory/$item->item_id/width~$width", lang('common_inv'),array('class'=>'thickbox','title'=>lang($controller_name.'_count'))).'&nbsp;&nbsp;&nbsp;&nbsp;'.anchor($controller_name."/count_details/$item->item_id/width~$width", lang('common_det'),array('class'=>'thickbox','title'=>lang($controller_name.'_details_count'))).'</td>';//inventory details	
	$table_data_row.='<td width="4%" class="rightmost">'.anchor($controller_name."/view/$item->item_id/width~$width", '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> '.lang('common_edit'),array('class'=>'thickbox btn btn-xs btn-primary text-center','title'=>lang($controller_name.'_update'))).'</td>';		
	
	$table_data_row.='</tr>';
	return $table_data_row;
}

/*
Gets the html table to manage giftcards.
*/
function get_giftcards_manage_table( $giftcards, $controller )
{
	$CI =& get_instance();
	
	$table='<table class="tablesorter table table-bordered" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />', 
	lang('giftcards_giftcard_number'),
	lang('giftcards_card_value'),
	lang('giftcards_customer_name'),
	lang('common_action'), 
	);
	
	$table.='<thead><tr>';
	$count = 0;
	foreach($headers as $header)
	{
		$count++;
		
		if ($count == 1)
		{
			$table.="<th class='leftmost'>$header</th>";
		}
		elseif ($count == count($headers))
		{
			$table.="<th class='rightmost'>$header</th>";
		}
		else
		{
			$table.="<th>$header</th>";		
		}
	}
	$table.='</tr></thead><tbody>';
	$table.=get_giftcards_manage_table_data_rows( $giftcards, $controller );
	$table.='</tbody></table>';
	return $table;
}

/*
Gets the html data rows for the giftcard.
*/
function get_giftcards_manage_table_data_rows( $giftcards, $controller )
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($giftcards->result() as $giftcard)
	{
		$table_data_rows.=get_giftcard_data_row( $giftcard, $controller );
	}
	
	if($giftcards->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='11'><div class='warning_message' style='padding:7px;'>".lang('giftcards_no_giftcards_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_giftcard_data_row($giftcard,$controller)
{
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();
	$link = site_url('reports/detailed_'.$controller_name.'/'.$giftcard->customer_id.'/0');
	$cust_info = $CI->Customer->get_info($giftcard->customer_id);
	
	$table_data_row='<tr>';
	$table_data_row.="<td width='3%'><input type='checkbox' id='giftcard_$giftcard->giftcard_id' value='".$giftcard->giftcard_id."'/></td>";
	$table_data_row.='<td width="15%">'.$giftcard->giftcard_number.'</td>';
	$table_data_row.='<td width="20%">'.to_currency($giftcard->value).'</td>';
	$table_data_row.='<td width="15%"><a class="underline" href="'.$link.'">'.$cust_info->first_name. ' '.$cust_info->last_name.'</a></td>';
	$table_data_row.='<td width="5%" class="rightmost">'.anchor($controller_name."/view/$giftcard->giftcard_id/width~$width", '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> '.lang('common_edit'),array('class'=>'thickbox btn btn-xs btn-primary text-center','title'=>lang($controller_name.'_update'))).'</td>';		
	
	$table_data_row.='</tr>';
	return $table_data_row;
}

/*
Gets the html table to manage item kits.
*/



function get_exchange_rate_manage_table($exchange_rate, $controller )
{
	$CI =& get_instance();
	
	$table='<table class="tablesorter table table-bordered" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />',	
	lang('exchange_dollar'),
	lang('exchange_reil'),
	lang('exchange_date'),
	lang('common_action'), 
	);
	
	$table.='<thead><tr>';
	$count = 0;
	foreach($headers as $header)
	{
		$count++;
		
		if ($count == 1)
		{
			$table.="<th class='leftmost'>$header</th>";
		}
		elseif ($count == count($headers))
		{
			$table.="<th class='rightmost'>$header</th>";
		}
		else
		{
			$table.="<th>$header</th>";		
		}
	}
	$table.='</tr></thead><tbody>';
	$table.=get_exchange_rate_manage_table_data_rows( $exchange_rate, $controller);
	$table.='</tbody></table>';
	return $table;
}

function get_exchange_rate_manage_table_data_rows($exchange_rate, $controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($exchange_rate->result() as $exchange)
	{
		$table_data_rows.=get_exchange_rate_data_row($exchange, $controller);
	}
	
	if($exchange_rate->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='11'><div class='warning_message' style='padding:7px;'>".lang('exchange_rate_no_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}


function get_exchange_rate_data_row($exchange,$controller)
{

	$CI =& get_instance();
	
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();

	$table_data_row='<tr>';
	$table_data_row.="<td width='3%'><input type='checkbox' id='exchange_rate_$exchange->id' value='".$exchange->id."'/></td>";
	$table_data_row.='<td width="15%">'.$exchange->dollar.'</td>';
	$table_data_row.='<td width="15%">'.$exchange->reil.'</td>';
	$table_data_row.='<td width="15%">'.Date('d-M-Y',strtotime($exchange->date)).'</td>';
	$table_data_row.='<td width="5%" class="rightmost">'.anchor($controller_name."/view/$exchange->id/width~$width", '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> '.lang('common_edit'),array('class'=>'thickbox btn btn-xs btn-primary text-center','title'=>lang($controller_name.'_update'))).'</td>';
	$table_data_row.='</tr>';
	return $table_data_row;
}

function get_item_kits_manage_table( $item_kits, $controller )
{
	$CI =& get_instance();
	
	$table='<table class="tablesorter table table-bordered" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />', 
	lang('items_item_number'),
	lang('item_kits_name'),
	lang('item_kits_description'),
	lang('items_unit_price'),
	lang('items_tax_percents'),
	lang('common_action'), 
	);
	
	$table.='<thead><tr>';
	$count = 0;
	foreach($headers as $header)
	{
		$count++;
		
		if ($count == 1)
		{
			$table.="<th class='leftmost'>$header</th>";
		}
		elseif ($count == count($headers))
		{
			$table.="<th class='rightmost'>$header</th>";
		}
		else
		{
			$table.="<th>$header</th>";		
		}
	}
	$table.='</tr></thead><tbody>';
	$table.=get_item_kits_manage_table_data_rows( $item_kits, $controller );
	$table.='</tbody></table>';
	return $table;
}

/*
Gets the html data rows for the item kits.
*/
function get_item_kits_manage_table_data_rows( $item_kits, $controller )
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($item_kits->result() as $item_kit)
	{
		$table_data_rows.=get_item_kit_data_row( $item_kit, $controller );
	}
	
	if($item_kits->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='11'><div class='warning_message' style='padding:7px;'>".lang('item_kits_no_item_kits_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}


function get_item_kit_data_row($item_kit,$controller)
{

	$CI =& get_instance();
	
	$item_kit_tax_info=$CI->Item_kit_taxes->get_info($item_kit->item_kit_id);
	$tax_percents = '';
	foreach($item_kit_tax_info as $tax_info)
	{
		$tax_percents.=$tax_info['percent']. '%, ';
	}
	$tax_percents=substr($tax_percents, 0, -2);

	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();

	$table_data_row='<tr>';
	$table_data_row.="<td width='3%'><input type='checkbox' id='item_kit_$item_kit->item_kit_id' value='".$item_kit->item_kit_id."'/></td>";
	$table_data_row.='<td width="15%">'.$item_kit->item_kit_number.'</td>';
	$table_data_row.='<td width="15%">'.$item_kit->name.'</td>';
	$table_data_row.='<td width="20%">'.$item_kit->description.'</td>';
	$table_data_row.='<td width="20%" align="right">'.(!is_null($item_kit->unit_price) ? to_currency($item_kit->unit_price) : '').'</td>';
	$table_data_row.='<td width="20%">'.$tax_percents.'</td>';
	$table_data_row.='<td width="5%" class="rightmost">'.anchor($controller_name."/view/$item_kit->item_kit_id/width~$width", '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> '.lang('common_edit'),array('class'=>'thickbox btn btn-xs btn-primary text-center','title'=>lang($controller_name.'_update'))).'</td>';
	$table_data_row.='</tr>';
	return $table_data_row;
}


//income table


function get_income_manage_table($income, $controller )
{
	$CI =& get_instance();
	
	$table='<table class="tablesorter table table-bordered" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />',	
	lang('income_payment_id'),
	lang('income_date'),
	lang('income_type'),	
	lang('income_title'),
	lang('income_total'),
	lang('common_action'), 
	);
	
	$table.='<thead><tr>';
	$count = 0;
	foreach($headers as $header)
	{
		$count++;
		
		if ($count == 1)
		{
			$table.="<th class='leftmost'>$header</th>";
		}
		elseif ($count == count($headers))
		{
			$table.="<th class='rightmost'>$header</th>";
		}
		else
		{
			$table.="<th>$header</th>";		
		}
	}
	$table.='</tr></thead><tbody>';
	$table.=get_income_manage_table_data_rows($income, $controller);
	$table.='</tbody></table>';
	return $table;
}

function get_income_manage_table_data_rows($income, $controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($income->result() as $inc)
	{
		$table_data_rows.=get_income_data_row($inc, $controller);
	}
	
	if($income->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='11'><div class='warning_message' style='padding:7px;'>".lang('income_no_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}


function get_income_data_row($income, $controller)
{

	$CI =& get_instance();
	
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();

	$table_data_row='<tr>';
	$table_data_row.="<td width='3%'><input type='checkbox' id='income_$income->id' value='".$income->id."'/></td>";
	$table_data_row.='<td width="10%">'.$income->payment_id.'</td>';	
	$table_data_row.='<td width="10%">'.Date('d-M-Y',strtotime($income->income_date)).'</td>';
	$table_data_row.='<td width="15%">'.$income->income_type.'</td>';
	$table_data_row.='<td width="25%">'.$income->income_title.'</td>';
	$table_data_row.='<td width="10%">'.to_currency($income->total_income).'</td>';
	$table_data_row.='<td width="5%" class="rightmost">'.anchor($controller_name."/view/$income->id/width~$width", '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> '.lang('common_edit'),array('class'=>'thickbox btn btn-xs btn-primary text-center','title'=>lang($controller_name.'_update'))).'</td>';
	$table_data_row.='</tr>';
	return $table_data_row;
}


//expense table


function get_expense_manage_table($expense, $controller )
{
	$CI =& get_instance();
	
	$table='<table class="tablesorter table table-bordered" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />',	
	lang('expense_payment_id'),
	lang('expense_date'),	
	lang('expense_type'),
	lang('expense_title'),
	lang('expense_total'),
	lang('common_action'), 
	);
	
	$table.='<thead><tr>';
	$count = 0;
	foreach($headers as $header)
	{
		$count++;
		
		if ($count == 1)
		{
			$table.="<th class='leftmost'>$header</th>";
		}
		elseif ($count == count($headers))
		{
			$table.="<th class='rightmost'>$header</th>";
		}
		else
		{
			$table.="<th>$header</th>";		
		}
	}
	$table.='</tr></thead><tbody>';
	$table.=get_expense_manage_table_data_rows($expense, $controller);
	$table.='</tbody></table>';
	return $table;
}

function get_expense_manage_table_data_rows($expense, $controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($expense->result() as $inc)
	{
		$table_data_rows.=get_expense_data_row($inc, $controller);
	}
	
	if($expense->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='11'><div class='warning_message' style='padding:7px;'>".lang('expense_no_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}


function get_expense_data_row($expense, $controller)
{

	$CI =& get_instance();
	
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();

	$table_data_row='<tr>';
	$table_data_row.="<td width='3%'><input type='checkbox' id='expense_$expense->id' value='".$expense->id."'/></td>";
	$table_data_row.='<td width="10%">'.$expense->payment_id.'</td>';	
	$table_data_row.='<td width="10%">'.Date('d-M-Y',strtotime($expense->expense_date)).'</td>';
	$table_data_row.='<td width="15%">'.$expense->expense_type.'</td>';
	$table_data_row.='<td width="25%">'.$expense->expense_title.'</td>';
	$table_data_row.='<td width="10%">'.to_currency($expense->total_expense).'</td>';
	$table_data_row.='<td width="5%" class="rightmost">'.anchor($controller_name."/view/$expense->id/width~$width", '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> '.lang('common_edit'),array('class'=>'thickbox btn btn-xs btn-primary text-center','title'=>lang($controller_name.'_update'))).'</td>';
	$table_data_row.='</tr>';
	return $table_data_row;
}




function get_expense_income_categories_manage_table($expense_income_categories, $controller )
{
	$CI =& get_instance();
	
	$table='<table class="tablesorter table table-bordered" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />',	
	'Name',
	lang('common_action'), 
	);
	
	$table.='<thead><tr>';
	$count = 0;
	foreach($headers as $header)
	{
		$count++;
		
		if ($count == 1)
		{
			$table.="<th class='leftmost'>$header</th>";
		}
		elseif ($count == count($headers))
		{
			$table.="<th class='rightmost'>$header</th>";
		}
		else
		{
			$table.="<th>$header</th>";		
		}
	}
	$table.='</tr></thead><tbody>';
	$table.=get_expense_income_categories_manage_table_data_rows($expense_income_categories, $controller);
	$table.='</tbody></table>';
	return $table;
}

function get_expense_income_categories_manage_table_data_rows($expense_income_categories, $controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($expense_income_categories->result() as $dataRow)
	{
		$table_data_rows.=get_expense_income_categories_data_row($dataRow, $controller);
	}
	
	if($expense_income_categories->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='11'><div class='warning_message' style='padding:7px;'>".lang('expense_income_category_no_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}


function get_expense_income_categories_data_row($dataRow,$controller)
{
	$CI =& get_instance();
	
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();

	$table_data_row='<tr>';
	$table_data_row.="<td width='3%'><input type='checkbox' id='categories_$dataRow->id' value='".$dataRow->id."'/></td>";
	$table_data_row.='<td width="15%">'.$dataRow->name.'</td>';
	$table_data_row.='<td width="5%" class="rightmost">'.anchor($controller_name."/view/$dataRow->id/width~$width", '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> '.lang('common_edit'),array('class'=>'thickbox btn btn-xs btn-primary text-center','title'=>lang($controller_name.'_update'))).'</td>';
	$table_data_row.='</tr>';
	return $table_data_row;
}

function get_payowed_manage_table($payowed, $controller )
{
	$CI =& get_instance();
	
	$table='<table class="tablesorter table table-bordered" id="sortable_table">';
	
	$headers = array(
	lang('payoweds_sale_id'),
	lang('payoweds_customer'),
	lang('payoweds_payment_date'),
	lang('payoweds_total_amount'),
	lang('payoweds_payment_amount'),
	lang('payoweds_remain_balance'),
	lang('common_action'), 
	);
	
	$table.='<thead><tr style="height:30px">';
	$count = 0;
	foreach($headers as $header)
	{
		$count++;
		
		if ($count == 1)
		{
			$table.="<th class='leftmost'>$header</th>";
		}
		elseif ($count == count($headers))
		{
			$table.="<th class='rightmost'>$header</th>";
		}
		else
		{
			$table.="<th>$header</th>";		
		}
	}
	$table.='</tr></thead><tbody>';
	$table.=get_payowed_manage_table_data_rows($payowed, $controller);
	$table.='</tbody></table>';
	return $table;
}

function get_payowed_manage_table_data_rows($payowed, $controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($payowed->result() as $dataRow)
	{
		$table_data_rows.=get_payowed_data_row($dataRow, $controller);
	}
	
	if($payowed->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='11'><div class='warning_message' style='padding:7px;'>".lang('expense_income_category_no_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}


function get_payowed_data_row($dataRow,$controller)
{
	$CI =& get_instance();	

	$info=$CI->Customer->get_info($dataRow->customer_id);

	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();

	$table_data_row='<tr>';		
	$table_data_row.='<td width="15%">POS '.$dataRow->sale_id.'</td>';
	$table_data_row.='<td width="15%">'.$info->first_name.' '.$info->last_name.'</td>';
	$table_data_row.='<td width="15%">'.date(get_date_format().'-'.get_time_format(), strtotime($dataRow->payment_date)).'</td>';
	$table_data_row.='<td width="15%">'.to_currency($dataRow->total_amount).'</td>';
	$table_data_row.='<td width="15%">'.to_currency($dataRow->payment_amount).'</td>';
	$table_data_row.='<td width="15%">'.to_currency($dataRow->remain_balance).'</td>';
	$table_data_row.='<td width="5%" class="rightmost">'.anchor($controller_name."/view/$dataRow->id/width~$width", '<i class="fa fa-dollar" aria-hidden="true"></i> '.lang('common_payment'),array('class'=>'thickbox btn btn-xs btn-success text-center','title'=>lang('common_payment'))).'</td>';
	$table_data_row.='</tr>';
	return $table_data_row;
}
?>