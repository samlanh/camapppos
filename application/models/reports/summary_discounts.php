<?php
require_once("report.php");
class Summary_discounts extends Report
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function getDataColumns()
	{
		return array(array('data'=>lang('reports_discount_percent'), 'align'=> 'left'),array('data'=>lang('reports_count'), 'align'=> 'left'));
	}
	
	public function getData()
	{
		$this->db->select('CONCAT(discount_percent, "%") as discount_percent, count(*) as count', false);
		$this->db->from('sales_items_temp');
		$this->db->where('discount_percent > 0');
		if ($this->params['sale_type'] == 'sales')
		{
			$this->db->where('quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('quantity_purchased < 0');
		}
		$this->db->where($this->db->dbprefix('sales_items_temp').'.deleted', 0);
		$this->db->group_by('sales_items_temp.discount_percent');
		$this->db->order_by('discount_percent');
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
		$this->db->where($this->db->dbprefix('sales_items_temp').'.deleted', 0);
		return $this->db->get()->row_array();		
	}
}
?>