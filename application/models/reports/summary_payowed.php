<?php
require_once("report.php");
class Summary_payowed extends Report
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function getDataColumns()
	{
		return array(array('data'=>lang('payoweds_customer'), 'align' => 'left'), array('data'=>lang('payoweds_total_amount'), 'align' => 'left'), array('data'=>lang('payoweds_payment_amount'), 'align' => 'left'), array('data' => lang('payoweds_remain_balance'), 'align' => 'right'));
	}
	
	public function getData()
	{
		$this->db->select('person_id, first_name, last_name, sum(total_amount) as total_amount, sum(payment_amount) as payment_amount,sum(remain_balance) as remain_balance');
		$this->db->from('payment_owed_tbl_temp');			
		$this->db->where(['deleted' => 0]);
		$this->db->group_by('customer_id');
		$this->db->order_by('sale_id', 'desc');

		return $this->db->get()->result_array();
	}
	
	public function getSummaryData()
	{
			$this->db->select('sum(total_amount) as total_amount, sum(payment_amount) as payment_amount, sum(remain_balance) as remain_balance');
			$this->db->from('payment_owed_tbl_temp');
			$this->db->where('deleted', 0);
		    return $this->db->get()->row_array();
	}
}
?>