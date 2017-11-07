<?php
class Exchange extends CI_Model
{
	
	/*
	Determines if a given item_id is an item kit
	*/
	function exists($exchange_id)
	{
		$this->db->from('exchange_rate');
		$this->db->where('id',$exchange_id);
		$query = $this->db->get();

		return ($query->num_rows()==1);
	}

	function select_last_exchange_rate_to_reil()
	{
		return $this->db->from('exchange_rate')->limit(1)->where('deleted',0)->order_by('id','DESC')->get()->row()->reil;
	}

	function select_last_exchange_rate_to_dollar()
	{
		return $this->db->from('exchange_rate')->limit(1)->where('deleted',0)->order_by('id','DESC')->get()->row()->dollar;
	}

	/*
	Returns all the item kits
	*/
	function get_all($limit=10000, $offset=0,$col='id',$ord='DESC')
	{
		//delete = 0 not delete
		$this->db->from('exchange_rate');
		$this->db->where('deleted',0);
		$this->db->order_by($col, $ord);
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();
	}
	
	function count_all()
	{
		$this->db->from('exchange_rate');
		$this->db->where('deleted',0);
		return $this->db->count_all_results();
	}

	/*
	Gets information about a particular item kit
	*/
	function get_info($exchange_id)
	{
		$this->db->from('exchange_rate');
		$this->db->where('id',$exchange_id);
		
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
			$fields = $this->db->list_fields('exchange_rate');

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
	function save(&$data, $exchange_id=false)
	{
		if (!$exchange_id or !$this->exists($exchange_id))
		{
			if($this->db->insert('exchange_rate',$data))
			{
				$data['id']=$this->db->insert_id();
				return true;
			}
			return false;
		}

		$this->db->where('id', $exchange_id);
		return $this->db->update('exchange_rate',$data);
	}

	/*
	Deletes one item kit
	*/
	function delete($exchange_id)
	{
		$this->db->where('id', $exchange_id);
		return $this->db->update('exchange_rate', array('deleted' => 1));
	}

	/*
	Deletes a list of item kits
	*/
	function delete_list($exchange_id)
	{
		$this->db->where_in('id',$exchange_id);
		return $this->db->update('exchange_rate', array('deleted' => 1));
 	}

 	/*
	Get search suggestions to find kits
	*/
	function get_search_suggestions($search,$limit=25)
	{
		$suggestions = array();

		$this->db->from('exchange_rate');
		$this->db->like('reil', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->where('deleted',0);
		$this->db->order_by("id", "DESC");
		$by_reil = $this->db->get();
		foreach($by_reil->result() as $row)
		{
			$suggestions[]=array('label' => $row->reil);
		}
		
		$this->db->from('exchange_rate');
		$this->db->like('date', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->where('deleted',0);
		$this->db->order_by("id", "DESC");
		$by_date = $this->db->get();
		foreach($by_date->result() as $row)
		{
			$suggestions[]=array('label' => $row->date);
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
		$this->db->from('exchange_rate');
		
		if ($this->config->item('speed_up_search_queries'))
		{
			$this->db->where("reil LIKE '".$this->db->escape_like_str($search)."%' or 
			dollar LIKE '".$this->db->escape_like_str($search)."%'");
		}
		else
		{
			$this->db->where("(reil LIKE '%".$this->db->escape_like_str($search).
			"%' or dollar LIKE '%".$this->db->escape_like_str($search)."%' or
			date LIKE '%".$this->db->escape_like_str($search)."%') and deleted=0");	
		}
		$this->db->order_by($column, $orderby);
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();	
	}
	
	function search_count_all($search)
	{
		$this->db->from('exchange_rate');
		
		if ($this->config->item('speed_up_search_queries'))
		{
			$this->db->where("reil LIKE '".$this->db->escape_like_str($search)."%' or 
			dollar LIKE '".$this->db->escape_like_str($search)."%'");
		}
		else
		{
			$this->db->where("(reil LIKE '%".$this->db->escape_like_str($search).
			"%' or dollar LIKE '%".$this->db->escape_like_str($search)."%' or
			date LIKE '%".$this->db->escape_like_str($search)."%') and deleted=0");	
		}
		$this->db->order_by("id", "DESC");
		$result=$this->db->get();				
		return $result->num_rows();	
	}
}
?>