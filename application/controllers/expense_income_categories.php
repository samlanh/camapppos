<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once ("secure_area.php");

class Expense_income_categories extends Secure_area {

	function __construct()
	{
		// add exchanges module permission
		parent::__construct('expense_income_categories');		
	}

	public function configPagination($base_url,$total_rows,$per_page)
       {		
	    $config['base_url']=$base_url;
		$config['total_rows']=$total_rows;
		$config['per_page']=$per_page;
	    $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tagl_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tagl_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item disabled">';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tagl_close'] = '</a></li>';
        $config['attributes'] = array('class' => 'page-link');

        return $config;
   }

	function index()
	{
		
		$config['base_url'] = site_url('expense_income_categories/sorting');
		$config['total_rows'] = $this->Expense_income_category->count_all();
		$config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20; 
		$data['total_rows'] = $this->Expense_income_category->count_all();
		$this->pagination->initialize($this->configPagination($config['base_url'],$config['total_rows'],$config['per_page']));
		$data['pagination'] = $this->pagination->create_links();
		$data['controller_name']=strtolower(get_class());
		$data['form_width']=$this->get_form_width();
		$data['per_page'] = $config['per_page'];
		$data['manage_table']=get_expense_income_categories_manage_table($this->Expense_income_category->get_all($data['per_page']),$this);
		$this->load->view('expense_income_category/manage',$data);

	}


	function sorting()
	{

		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		if ($search)
		{
			$config['total_rows'] = $this->Expense_income_category->search_count_all($search);
			$table_data = $this->Expense_income_category->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		else
		{
			$config['total_rows'] = $this->Expense_income_category->count_all();
			$table_data = $this->Expense_income_category->get_all($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		$config['base_url'] = site_url('item_kits/sorting');
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($this->configPagination($config['base_url'],$config['total_rows'],$config['per_page']));
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_expense_income_categories_manage_table_data_rows($table_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));	
	}
	
	/* added for excel expert */
	function excel_export() {
		$data = $this->Expense_income_category->get_all()->result_object();
		$this->load->helper('report');
		$rows = array();
		$row = array("Name");
		$rows[] = $row;
		
		foreach ($data as $r) {
			
			$row = array(
				$r->name,					
			);
			
			$rows[] = $row;		
		}
		
		$content = chr(239).chr(187).chr(191).array_to_csv($rows);
		force_download('expense_income_export' . '.csv', $content);
		exit;
	}

	function search()
	{
	
		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		$search_data=$this->Expense_income_category->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'DESC');
		$config['base_url'] = site_url('expense_income_categories/search');
		$config['total_rows'] = $this->Expense_income_category->search_count_all($search);
		$config['per_page'] = $per_page ;
		$this->pagination->initialize($this->configPagination($config['base_url'],$config['total_rows'],$config['per_page']));				
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_expense_income_categories_manage_table_data_rows($search_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
	}

	/*
	Gives search suggestions based on what is being searched for
	*/
	function suggest()
	{
		$suggestions = $this->Expense_income_category->get_search_suggestions($this->input->get('term'),100);
		echo json_encode($suggestions);
	}

	function get_row()
	{
		$id = $this->input->post('row_id');
		$data_row=get_expense_income_categories_data_row($this->Expense_income_category->get_info($id),$this);
		echo $data_row;
	}

	function view($id=-1)
	{

		$this->check_action_permission('add_update');	

		$this->load->helper('report');

		$data['expense_income_category_info']=$this->Expense_income_category->get_info($id);	

		$this->load->view("expense_income_category/form",$data);
	}
	
	function save($id=-1)
	{
		$this->check_action_permission('add_update');		
		$data = array(
		'name'=>$this->input->post('name'),
		
		);
		
		if($this->Expense_income_category->save($data, $id))
		{
			//New Exchange
			if($id==-1)
			{
				echo json_encode(array('success'=>true,'message'=>lang('exchange_successful_adding').' '.
				$data['name'],'id'=>$id));
				$id = $id;
			}
			else //previous item
			{
				echo json_encode(array('success'=>true,'message'=>lang('exchange_successful_updating').' '.
				$data['name'], 'id' => $id));
			}
		
		}
		else//failure
		{
			echo json_encode(array('success'=>false,'message'=>lang('exchange_error_adding_updating').' '.
			$data['name'],'id'=>-1));
		}

	}	

	function delete()
	{
		$this->check_action_permission('delete');	

		$exchange_to_delete=$this->input->post('ids');

		if($this->Expense_income_category->delete_list($exchange_to_delete))
		{
			echo json_encode(array('success'=>true,'message'=>lang('expense_income_categories_successful_deleted').' '.
			count($exchange_to_delete).' '.lang('expense_income_categories_one_or_multiple')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>lang('expense_income_categories_cannot_be_deleted')));
		}
	}
	
	/*
	get the width for the add/edit form
	*/
	function get_form_width()
	{
		return 550;
	}

}
?>