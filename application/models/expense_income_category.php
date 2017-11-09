<?php
class Expense_income_category extends CI_Model
{
	
	/*
	Determines if a given item_id is an item kit
	*/
	function exists($id)
	{
		$this->db->from('expense_income_category');
		$this->db->where('id',$id);
		$query = $this->db->get();

		return ($query->num_rows()==1);
	}

	

	/*
	Returns all the item kits
	*/
	function get_all($limit=10000, $offset=0,$col='id',$ord='DESC')
	{
		//delete = 0 not delete
		$this->db->from('expense_income_category');
		$this->db->where('deleted',0);
		$this->db->order_by($col, $ord);
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();
	}
	
	function count_all()
	{
		$this->db->from('expense_income_category');
		$this->db->where('deleted',0);
		return $this->db->count_all_results();
	}

	/*
	Gets information about a particular item kit
	*/
	function get_info($id)
	{
		$this->db->from('expense_income_category');
		$this->db->where('id',$id);
		
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
			$fields = $this->db->list_fields('expense_income_category');

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
	function save(&$data, $id=false)
	{
		if (!$id or !$this->exists($id))
		{
			if($this->db->insert('expense_income_category',$data))
			{
				$data['id']=$this->db->insert_id();
				return true;
			}
			return false;
		}

		$this->db->where('id', $id);
		return $this->db->update('expense_income_category',$data);
	}

	/*
	Deletes one item kit
	*/
	function delete($id)
	{
		$this->db->where('id', $id);
		return $this->db->update('expense_income_category', array('deleted' => 1));
	}

	/*
	Deletes a list of item kits
	*/
	function delete_list($id)
	{
		$this->db->where_in('id',$id);
		return $this->db->update('expense_income_category', array('deleted' => 1));
 	}

 	/*
	Get search suggestions to find kits
	*/
	function get_search_suggestions($search,$limit=25)
	{
		$suggestions = array();

		$this->db->from('expense_income_category');
		$this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->where('deleted',0);
		$this->db->order_by("id", "DESC");
		$by_name = $this->db->get();

		foreach($by_name->result() as $row)
		{
			$suggestions[]=array('label' => $row->name);
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
		$this->db->from('expense_income_category');		
		$this->db->where("name LIKE '".$this->db->escape_like_str($search)."%'");
		$this->db->order_by($column, $orderby);
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();	
	}
	
	function search_count_all($search)
	{
		$this->db->from('expense_income_category');
		$this->db->where("name LIKE '".$this->db->escape_like_str($search)."%'");
		$this->db->order_by("id", "DESC");
		$result=$this->db->get();				
		return $result->num_rows();	
	}
}
?>