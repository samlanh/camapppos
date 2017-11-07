<?php
require_once("report.php");
class Specific_supplier_store_accounts extends Report
{
	function __construct()
	{		
		parent::__construct();
	}
	
	public function getDataColumns()
	{

		return array(
						array('data'=>lang('reports_id'), 'align'=>'left'), 
						array('data'=>lang('reports_date'), 'align'=>'left'), 
						array('data'=>lang('reports_receiving_id'), 'align'=>'left'), 
						array('data'=>lang('reports_debit'), 'align'=>'left'), 
						array('data'=>lang('reports_credit'), 'align'=>'left'), 
						array('data'=>lang('reports_balance'), 'align'=>'left'), 
						array('data'=>lang('reports_comments'), 'align'=>'left')
					);
				
	}
	
	public function getData()
	{
		$this->db->select('date, receiving_id, transaction_amount, balance,comment');
		$this->db->from('store_accounts');		
		$this->db->where('date BETWEEN "'. $this->params['start_date']. ' 00:00:00" and "'. $this->params['end_date'].' 23:59:59" and supplier_id='.$this->params['supplier_id']);
		$this->db->where('deleted', 0);			
		$this->db->order_by('date');
		return $this->db->get()->result_array();
		
	}
	
	public function getSummaryData()
	{
		return  $this->getData();
	}
}
?>