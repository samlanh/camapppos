<?php
require_once("report.php");
class Detailed_expenses extends Report
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function getDataColumns()
	{
		return  array(
			array('data'=>lang('expense_payment_id'), 'align'=>'left'),
			array('data'=>lang('expense_date'), 'align'=>'left'),
			array('data'=>lang('expense_title'), 'align'=>'left'),
			array('data'=>lang('expense_type_money'), 'align'=>'left'), 
			array('data'=>lang('expense_check'), 'align'=>'left'), 
			array('data'=>lang('expense_total'), 'align'=>'right')
		    );		
	}
	
	public function getData()
	{
		$this->db->select('expense_date, expense_title,check_paper,type_money,payment_id,total_expense, note');
		$this->db->from('expense_temp');

		$this->db->where('deleted', 0);		
		$this->db->order_by('expense_date');

		$data = array();
		$data['details'] = $this->db->get()->result_array();
		return $data;
	}
	
	public function getSummaryData()
	{
		$this->db->select('sum(total_expense) as total');
		$this->db->from('expense_temp');		
		$this->db->where('deleted', 0);
		return $this->db->get()->row_array();
	}
}
?>