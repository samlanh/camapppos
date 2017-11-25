<?php
require_once("report.php");
class Sale_detail_list extends Report
{
	function __construct()
	{
		parent::__construct();
	}

	public function getDataColumns()
	{
		return array(		
							array('data'=>lang('reports_sale_id'), 'align'=>'left'),
							array('data'=>lang('reports_date'), 'align'=>'left'), 
							array('data'=>lang('reports_name'), 'align'=>'left'),
							array('data'=>lang('reports_category'), 'align'=> 'left'),							
							array('data'=>lang('sales_price'), 'align'=>'right'),
							array('data'=>lang('reports_quantity_purchased'), 'align'=> 'left'), 
							array('data'=>lang('reports_discount'), 'align'=>'right'),
							array('data'=>lang('reports_subtotal'), 'align'=>'right'), 
							array('data'=>lang('reports_tax'), 'align'=>'right'),
							array('data'=>lang('reports_total'), 'align'=>'right'),
							array('data'=>lang('reports_sold_by'), 'align'=>'left'), 
							array('data'=>lang('reports_sold_to'), 'align'=>'left'), 

							);
	}
	
	public function getData()
	{		

	
	
		$this->db->select('sale_id,quantity_purchased,discount_percent,items.name as item_name, item_kits.name as item_kit_name,sales_items_temp.category, item_unit_price, sale_date, subtotal, total, tax, employee.first_name as emp_fname,employee.last_name as emp_lname, customer.first_name as cus_fname, customer.last_name as cus_lname');
		$this->db->from('sales_items_temp');
		$this->db->join('items', 'sales_items_temp.item_id = items.item_id', 'left');
		$this->db->join('item_kits', 'sales_items_temp.item_kit_id = item_kits.item_kit_id', 'left');
		$this->db->join('people as employee', 'sales_items_temp.employee_id = employee.person_id');
		$this->db->join('people as customer', 'sales_items_temp.customer_id = customer.person_id', 'left');
		
		if ($this->params['sale_type'] == 'sales')
		{
			$this->db->where('quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('quantity_purchased < 0');
		}
		
		$this->db->where('sales_items_temp.deleted', 0);	
		$this->db->order_by('sale_date','desc');
		return $this->db->get()->result_array();
	}
	
	public function getSummaryData()
	{
		$this->db->select('sum(subtotal) as subtotal, sum(total) as total, sum(tax) as tax,sum(profit) as profit');
		$this->db->from('sales_items_temp');
		if ($this->params['sale_type'] == 'sales')
		{
			$this->db->where('quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('quantity_purchased < 0');
		}
		
		$this->db->where('deleted', 0);
		return $this->db->get()->row_array();		
	}

}
?>