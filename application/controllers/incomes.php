<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once ("secure_area.php");

class Incomes extends Secure_area {

	function __construct()
	{
		// add Incomes module permission
		parent::__construct('incomes');
		
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
		
		$config['base_url'] = site_url('income/sorting');
		$config['total_rows'] = $this->Income->count_all();
		$config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20; 
		$data['total_rows'] = $this->Income->count_all();
		$this->pagination->initialize($this->configPagination($config['base_url'],$config['total_rows'],$config['per_page']));
		$data['pagination'] = $this->pagination->create_links();
		$data['controller_name']=strtolower(get_class());
		$data['form_width']=$this->get_form_width();
		$data['per_page'] = $config['per_page'];
		$data['manage_table']=get_income_manage_table($this->Income->get_all($data['per_page']),$this);
		$this->load->view('income/manage',$data);

	}


	function sorting()
	{

		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		if ($search)
		{
			$config['total_rows'] = $this->Income->search_count_all($search);
			$table_data = $this->Income->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		else
		{
			$config['total_rows'] = $this->Income->count_all();
			$table_data = $this->Income->get_all($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		$config['base_url'] = site_url('item_kits/sorting');
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($this->configPagination($config['base_url'],$config['total_rows'],$config['per_page']));
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_income_manage_table_data_rows($table_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));	
	}
	
	/* added for excel expert */
	function excel_export() {
		$data = $this->Income->get_all()->result_object();
		$this->load->helper('report');
		$rows = array();
		$row = array(lang('income_payment_id'),
		 lang('income_date'),	
		  lang('income_type'),
		 lang('income_title'),
		 lang('income_check_paper'),
		 lang('income_type_money'),
		 lang('income_total'),
		 lang('income_note'));
		$rows[] = $row;
		
		foreach ($data as $r) {
			
			$row = array(
				$r->payment_id,				
				Date('d-M-Y',strtotime($r->income_date)),	
				$r->income_type,		
				$r->income_title,
				$r->check_paper,
				$r->type_money,
				to_currency($r->total_income),
				$r->note			
			);
			
			$rows[] = $row;		
		}
		
		$content = chr(239).chr(187).chr(191).array_to_csv($rows);
		force_download('income_export' . '.csv', $content);
		exit;
	}

	function search()
	{	
		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		$search_data=$this->Income->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'DESC');
		$config['base_url'] = site_url('income/search');
		$config['total_rows'] = $this->Income->search_count_all($search);
		$config['per_page'] = $per_page ;
		$this->pagination->initialize($this->configPagination($config['base_url'],$config['total_rows'],$config['per_page']));				
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_income_manage_table_data_rows($search_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
	}

	/*
	Gives search suggestions based on what is being searched for
	*/
	function suggest()
	{
		$suggestions = $this->Income->get_search_suggestions($this->input->get('term'),100);
		echo json_encode($suggestions);
	}


	public function select_income_type()
	{
		$suggestions = $this->Income->get_income_type($this->input->get('term'),100);
		echo json_encode($suggestions);
	}

	function get_row()
	{
		$income_id = $this->input->post('row_id');
		$data_row=get_income_data_row($this->Income->get_info($income_id),$this);
		echo $data_row;
	}

	function view($income_id=-1)
	{

		$this->check_action_permission('add_update');	

		$this->load->helper('report');

        $data = array();
        $data['months'] = get_months();
        $data['days'] = get_days();
        $data['years'] = get_years();

		$data['income_info']=$this->Income->get_info($income_id);
		$data['payment_id'] = $this->Income->get_info($income_id)->payment_id;

		 if($income_id==-1)
        {	

        	$pid = $this->Income->get_payment_id();  
        	$data['payment_id'] = "inc".str_pad($pid, 9, '0', STR_PAD_LEFT);       
        	$data['selected_year']=0;
        	$data['selected_month']=0;
        	$data['selected_day']=0;
     
        }
        else
        {
        	list($data['selected_year'],$data['selected_month'],$data['selected_day'])=explode('-',$data['income_info']->income_date);        
 		}

		$this->load->view("income/form",$data);
	}
	
	function save($income_id=-1)
	{
		$this->check_action_permission('add_update');		
		$data = array(		
		'income_date'=>$this->input->post('income_date'),
		'income_type'=>$this->input->post('income_type'),	
		'income_title'=>$this->input->post('income_title'),
		'check_paper'=>$this->input->post('check_paper'),		
		'type_money'=>$this->input->post('type_money'),
		'payment_id'=>$this->input->post('payment_id'),
		'total_income'=>$this->input->post('total_income'),		
		'note'=>$this->input->post('note'),
		'employee_id'=>$this->Employee->get_logged_in_employee_info()->person_id
		);
		
		if($this->Income->save($data, $income_id))
		{
			//New income
			if($income_id==-1)
			{
				echo json_encode(array('success'=>true,'message'=>lang('income_successful_adding').' '.
				$data['income_title'],'id'=>$income_id));
				$income_id = $income_id;
			}
			else //previous item
			{
				echo json_encode(array('success'=>true,'message'=>lang('income_successful_updating').' '.
				$data['income_title'], 'id' => $income_id));
			}
		
		}
		else//failure
		{
			echo json_encode(array('success'=>false,'message'=>lang('income_error_adding_updating').' '.
			$data['income_title'],'id'=>-1));
		}

	}
	
	function get_customer_fullname()
	{	
		$customer_id = $this->input->get('customer_id');
		$name = $this->Customer->get_customer_fullname($customer_id);
		echo $name;
	}

	function delete()
	{
		$this->check_action_permission('delete');	

		$income_to_delete=$this->input->post('ids');

		if($this->Income->delete_list($income_to_delete))
		{
			echo json_encode(array('success'=>true,'message'=>lang('income_successful_deleted').' '.
			count($income_to_delete).' '.lang('income_one_or_multiple')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>lang('income_cannot_be_deleted')));
		}
	}
	
	function customer_search()
	{
		$suggestions = $this->Customer->get_customer_search_suggestions($this->input->get('term'),100);
		echo json_encode($suggestions);
	}

	
	/*
	get the width for the add/edit form
	*/
	function get_form_width()
	{
		return 700;
	}

}
?>