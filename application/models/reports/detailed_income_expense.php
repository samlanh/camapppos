<?php
require_once("report.php");
class Detailed_income_expense extends Report
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function getDataColumns()
	{

		return  array(
			array('data'=>lang('income_payment_id'), 'align'=>'left'),
			array('data'=>lang('income_date'), 'align'=>'left'),
			array('data'=>lang('income_title'), 'align'=>'left'),
			array('data'=>lang('income_type_money'), 'align'=>'left'), 
			array('data'=>lang('income_check'), 'align'=>'left'), 
			array('data'=>lang('income_total'), 'align'=>'right')
		    );		

	}

	public function getData()
	{
		$data = array();

		$this->db->select('income_date, income_title,check_paper,type_money,payment_id,total_income,note');
		$this->db->from('income_temp');
		$this->db->where('deleted', 0);		
		$this->db->order_by('income_date');		
		$data['details_income'] = $this->db->get()->result_array();

		$this->db->select('expense_date, expense_title,check_paper,type_money,payment_id,total_expense, note');
		$this->db->from('expense_temp');
		$this->db->where('deleted', 0);		
		$this->db->order_by('expense_date');		
		$data['details_expense'] = $this->db->get()->result_array();

		return $data;
	}
	
	public function getSummaryData()
	{
		$data = array();

		$this->db->select('sum(total_income) as total_income');
		$this->db->from('income_temp');		
		$data['total_income'] = $this->db->get()->row()->total_income;

		$this->db->select('sum(total_expense) as total_expense');
		$this->db->from('expense_temp');		
		$data['total_expense'] = $this->db->get()->row()->total_expense;

		$data['profit'] = $data['total_income'] - $data['total_expense'];

		return $data;
	}
}
?>