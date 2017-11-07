<?php
require_once("report.php");
class Detailed_incomes extends Report
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
		$this->db->select('income_date, income_title,check_paper,type_money,payment_id,total_income,note');
		$this->db->from('income_temp');

		$this->db->where('deleted', 0);		
		$this->db->order_by('income_date');

		$data = array();
		$data['details'] = $this->db->get()->result_array();
		return $data;
	}
	
	public function getSummaryData()
	{
		$this->db->select('sum(total_income) as total');
		$this->db->from('income_temp');		
		$this->db->where('deleted', 0);
		return $this->db->get()->row_array();
	}
}
?>