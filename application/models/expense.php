<?php
class Expense extends CI_Model
{
	
	/*
	Determines if a given item_id is an item kit
	*/
	function exists($expense_id)
	{
		$this->db->from('expense');
		$this->db->where('id',$expense_id);
		$query = $this->db->get();

		return ($query->num_rows()==1);
	}

	/*
	Returns all the item kits
	*/
	function get_all($limit=10000, $offset=0,$col='id',$ord='DESC')
	{
		//delete = 0 not delete
		$this->db->from('expense');
		$this->db->where('deleted',0);
		$this->db->order_by($col, $ord);
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();
	}
	
	function count_all()
	{
		$this->db->from('expense');
		$this->db->where('deleted',0);
		return $this->db->count_all_results();
	}


	public function get_payment_id()
	{	
		$this->db->select_max('id');
	 	$query = $this->db->get('expense')->row()->id;
		return $query+1;
	}

	/*
	Gets information about a particular item kit
	*/
	function get_info($expense_id)
	{
		$this->db->from('expense');
		$this->db->where('id',$expense_id);
		
		$query = $this->db->get();

		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $item_kit_id is NOT an item kit
			$item_obj=new stdClass();

			//Get all the fields from items table
			$fields = $this->db->list_fields('expense');

			foreach ($fields as $field)
			{
				$item_obj->$field='';
			}

			return $item_obj;
		}
	}
	

	/*

	/*
	Inserts or updates an item kit
	*/
	function save(&$data, $expense_id=false)
	{
		if (!$expense_id or !$this->exists($expense_id))
		{
			if($this->db->insert('expense',$data))
			{
				$data['id']=$this->db->insert_id();
				return true;
			}
			return false;
		}

		$this->db->where('id', $expense_id);
		return $this->db->update('expense',$data);
	}

	/*
	Deletes one item kit
	*/
	function delete($expense_id)
	{
		$this->db->where('id', $expense_id);
		return $this->db->update('expense', array('deleted' => 1));
	}

	/*
	Deletes a list of item kits
	*/
	function delete_list($expense_id)
	{
		$this->db->where_in('id',$expense_id);
		return $this->db->update('expense', array('deleted' => 1));
 	}

 	/*
	Get search suggestions to find kits
	*/
	function get_search_suggestions($search,$limit=25)
	{
		$suggestions = array();

		$this->db->from('expense');
		$this->db->like('payment_id', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->where('deleted',0);
		$this->db->order_by("id", "DESC");
		$by_reil = $this->db->get();
		foreach($by_reil->result() as $row)
		{
			$suggestions[]=array('label' => $row->payment_id);
		}
		
		$this->db->from('expense');
		$this->db->like('expense_date', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->where('deleted',0);
		$this->db->order_by("id", "DESC");
		$by_date = $this->db->get();
		foreach($by_date->result() as $row)
		{
			$suggestions[]=array('label' => $row->expense_date);
		}

		$this->db->from('expense');
		$this->db->like('expense_type', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->where('deleted',0);
		$this->db->order_by("id", "DESC");
		$by_date = $this->db->get();
		foreach($by_date->result() as $row)
		{
			$suggestions[]=array('label' => $row->expense_type);
		}

		$this->db->from('expense');
		$this->db->like('expense_title', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->where('deleted',0);
		$this->db->order_by("id", "DESC");
		$by_date = $this->db->get();
		foreach($by_date->result() as $row)
		{
			$suggestions[]=array('label' => $row->expense_title);
		}

		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;

	}
		
	/*
	Preform a search on items kits
	*/
	function search($search, $limit=16,$offset=0,$column='id',$orderby='DESC')
	{
		$this->db->from('expense');
		
		if ($this->config->item('speed_up_search_queries'))
		{
			$this->db->where("payment_id LIKE '".$this->db->escape_like_str($search)."%' or 
			expense_date LIKE '".$this->db->escape_like_str($search)."%'");
		}
		else
		{
			$this->db->where("(
			payment_id LIKE '%".$this->db->escape_like_str($search)."%' or 
			expense_date LIKE '%".$this->db->escape_like_str($search)."%' or
			expense_type LIKE '%".$this->db->escape_like_str($search)."%' or
			expense_title LIKE '%".$this->db->escape_like_str($search)."%'
			) and deleted=0");	
		}
		$this->db->order_by($column, $orderby);
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();	
	}
	
	function search_count_all($search)
	{
		$this->db->from('expense');
		
		if ($this->config->item('speed_up_search_queries'))
		{
			$this->db->where("payment_id LIKE '".$this->db->escape_like_str($search)."%' or 
			expense_date LIKE '".$this->db->escape_like_str($search)."%'");
		}
		else
		{
			$this->db->where("(
			payment_id LIKE '%".$this->db->escape_like_str($search)."%' or 
			expense_date LIKE '%".$this->db->escape_like_str($search)."%' or
			expense_type LIKE '%".$this->db->escape_like_str($search)."%' or
			expense_title LIKE '%".$this->db->escape_like_str($search)."%'
			) and deleted=0");	
		}
		$this->db->order_by("id", "DESC");
		$result=$this->db->get();				
		return $result->num_rows();	
	}

	//We create a temp table that allows us to do easy report/receiving queries
	public function create_expense_temp_table($params)
	{
		$where = '';
		
		if (isset($params['start_date']) && isset($params['end_date']))
		{
			$where = 'WHERE expense_date BETWEEN "'.$params['start_date'].'" and "'.$params['end_date'].'"';
		}
		else
		{
			//If we don't pass in a date range, we don't need data from the temp table
			$where = 'WHERE 1=2';
		}
		
		$this->db->query("CREATE TEMPORARY TABLE ".$this->db->dbprefix('expense_temp')."
		(SELECT deleted, date(expense_date) as expense_date, expense_title, check_paper, type_money, payment_id, total_expense, note FROM ".$this->db->dbprefix('expense')."
		$where
		)");
	}

}
?>