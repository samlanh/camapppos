<?php
class Payowed extends CI_Model
{

	public function get_info($customer_id)
	{		
		$this->db->from('payment_owed_tbl');
		$this->db->where(['customer_id'=>$customer_id,'deleted'=>0,'remain_balance >'=>0]);	
		return $this->db->get();
	}

	public function get_info_by_id($id)
	{
		$this->db->from('payment_owed_tbl');
		$this->db->where(['id'=>$id]);	
		return $this->db->get()->row();
	}

	public function get_owed_by_sale($sale_id)
	{		
		$this->db->from('payment_owed_tbl');
		$this->db->where(['sale_id'=>$sale_id,'deleted'=>0]);	
		$query = $this->db->get();
		return $query->row();
	}
		
	public function save($data)
	{
	 $this->db->insert('payment_owed_tbl',$data);
	 return $this->db->insert_id();
	}

	function get_all($limit=10000, $offset=0,$col='sale_id',$order='DESC')
	{
		$this->db->from('payment_owed_tbl');
		$this->db->where(['deleted' => 0 , 'remain_balance > ' => 0]);
		$this->db->order_by($col,$order);
		$this->db->limit($limit,$offset);
		$data = $this->db->get();					
		return $data;
	}
	
	function count_all()
	{
		$this->db->from('payment_owed_tbl');
		$this->db->where(['deleted' => 0 , 'remain_balance > ' => 0]);
		return $this->db->count_all_results();
	}
	
	public function update_old_owed($id)
	{	
		$this->db->where('id',$id);
		$this->db->update('payment_owed_tbl',['deleted'=>1]);
		return true;
	}

	
	function get_search_suggestions($search, $limit=25)
	{
		$suggestions = array();
		
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');
		
		if ($this->config->item('speed_up_search_queries'))
		{
			$this->db->where("(first_name LIKE '".$this->db->escape_like_str($search)."%' or 
			last_name LIKE '".$this->db->escape_like_str($search)."%' or 
			CONCAT(`first_name`,' ',`last_name`) LIKE '".$this->db->escape_like_str($search)."%') and deleted=0");
		}
		else
		{
			$this->db->where("(first_name LIKE '%".$this->db->escape_like_str($search)."%' or 
			last_name LIKE '%".$this->db->escape_like_str($search)."%' or 
			CONCAT(`first_name`,' ',`last_name`) LIKE '%".$this->db->escape_like_str($search)."%') and deleted=0");
		}
		
		$this->db->order_by("last_name", "asc");		
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=array('label'=> $row->first_name.' '.$row->last_name);		
		}
		
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');	
		$this->db->where('deleted',0);		
		$this->db->like("email",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->order_by("email", "asc");		
		$by_email = $this->db->get();
		foreach($by_email->result() as $row)
		{
			$suggestions[]=array('label'=> $row->email);		
		}
		
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');	
		$this->db->where('deleted',0);		
		$this->db->like("company_name",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->order_by("company_name", "asc");		
		$by_company_name = $this->db->get();
		foreach($by_company_name->result() as $row)
		{
			$suggestions[]=array('label'=> $row->company_name);		
		}
		
		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;	
	}

	function search($search, $limit=20,$offset=0,$column='phppos_people.person_id',$orderby='DESC')
	{			
			$this->db->from('payment_owed_tbl');
			$this->db->join('people','payment_owed_tbl.customer_id=people.person_id');		
			$this->db->where("(first_name LIKE '%".$this->db->escape_like_str($search)."%' or 
			last_name LIKE '%".$this->db->escape_like_str($search)."%' or 
			email LIKE '%".$this->db->escape_like_str($search)."%' or 
			phone_number LIKE '%".$this->db->escape_like_str($search)."%' or 			
			CONCAT(`first_name`,' ',`last_name`) LIKE '%".$this->db->escape_like_str($search)."%') and deleted=0");		
			$this->db->where(['payment_owed_tbl.deleted'=>0,'payment_owed_tbl.remain_balance >'=>0]);
			$this->db->order_by($column,$orderby);
			$this->db->limit($limit);
			$this->db->offset($offset);
			return $this->db->get();		
		
	}

	function search_count_all($search, $limit=10000)
	{
			$this->db->from('payment_owed_tbl');
			$this->db->join('people','payment_owed_tbl.customer_id=people.person_id');		
			$this->db->where("(first_name LIKE '%".$this->db->escape_like_str($search)."%' or 
			last_name LIKE '%".$this->db->escape_like_str($search)."%' or 
			email LIKE '%".$this->db->escape_like_str($search)."%' or 
			phone_number LIKE '%".$this->db->escape_like_str($search)."%' or 			
			CONCAT(`first_name`,' ',`last_name`) LIKE '%".$this->db->escape_like_str($search)."%') and deleted=0");	

			$this->db->where('deleted',0);			
			$this->db->limit($limit);
			$result=$this->db->get();				
			return $result->num_rows();	

		}


public function create_payowed_temp_table($params)
	{
		$where = '';		
		if (isset($params['start_date']) && isset($params['end_date']) && $params['customer_id'] == -1)
		{
			$where = 'WHERE date(payment_date) BETWEEN "'.$params['start_date'].'" and "'.$params['end_date'].'"';
		}else{
			$where = 'WHERE date(payment_date) BETWEEN "'.$params['start_date'].'" and "'.$params['end_date'].'" AND customer_id = "'.$params['customer_id'].'"';
		}		

	    $this->_create_payowed_temp_table_query($where);
	}

function _create_payowed_temp_table_query($where)
		{
		$this->db->query("CREATE TEMPORARY TABLE ".$this->db->dbprefix('payment_owed_tbl_temp')." (SELECT ".$this->db->dbprefix('payment_owed_tbl').".sale_id,customer_id, owed_date, payment_date,total_amount,payment_amount,remain_balance,deleted, ".$this->db->dbprefix('people').".person_id,first_name, last_name, email, phone_number FROM ".$this->db->dbprefix('payment_owed_tbl')." 
			INNER JOIN ".$this->db->dbprefix('people')." ON  ".$this->db->dbprefix('payment_owed_tbl').'.customer_id ='.$this->db->dbprefix('people').'.person_id'."
			$where			
			)");
	}
	



}
?>
