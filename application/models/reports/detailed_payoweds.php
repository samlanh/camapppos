<?php
require_once("report.php");
class Detailed_payoweds extends Report
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function getDataColumns()
	{
		return array(
						'summary' => array(
										array('data'=>lang('payoweds_customer'), 'align'=> 'left'), 
										array('data'=>lang('payoweds_email'), 'align'=> 'left'), 
										array('data'=>lang('payoweds_phone'), 'align'=> 'left'), 
										array('data'=>lang('payoweds_total_amount'), 'align'=> 'left'), 
										array('data'=>lang('payoweds_payment_amount'), 'align'=> 'left'), 
										array('data'=>lang('payoweds_remain_balance'), 'align'=> 'right')),
					    'details' => array(
										array('data'=>lang('payoweds_sale_id'), 'align'=> 'left'), 
										array('data'=>lang('payoweds_payment_date'), 'align'=> 'left'), 
										array('data'=>lang('payoweds_total_amount'), 'align'=> 'left'), 
										array('data'=>lang('payoweds_payment_amount'), 'align'=> 'left'), 
										array('data'=>lang('payoweds_remain_balance'), 'align'=> 'left'))
									);		
	}
	
	public function getData()
	{
		$this->db->select('person_id, first_name, last_name, sum(total_amount) as total_amount, sum(payment_amount) as payment_amount,sum(remain_balance) as remain_balance, email, phone_number');
		$this->db->from('payment_owed_tbl_temp');
			
		$this->db->where(['deleted' => 0]);
		$this->db->group_by('customer_id');
		$this->db->order_by('sale_id', 'desc');

		$data = array();
		$data['summary'] = $this->db->get()->result_array();
		$data['details'] = array();
		foreach($data['summary'] as $key=>$value)
		{
			$this->db->select('sale_id, payment_date,total_amount ,payment_amount,remain_balance');
			$this->db->from('payment_owed_tbl_temp');
			$this->db->where(['deleted' => 0, 'customer_id'=>$value['person_id']]);
			$this->db->order_by('sale_id', 'desc');
			$data['details'][$key] = $this->db->get()->result_array();
		}
		
		return $data;
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