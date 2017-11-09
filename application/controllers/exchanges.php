<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once ("secure_area.php");

class Exchanges extends Secure_area {

	function __construct()
	{
		// add exchanges module permission
		parent::__construct('exchanges');
		
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
		
		$config['base_url'] = site_url('exchanges/sorting');
		$config['total_rows'] = $this->Exchange->count_all();
		$config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20; 
		$data['total_rows'] = $this->Exchange->count_all();
		$this->pagination->initialize($this->configPagination($config['base_url'],$config['total_rows'],$config['per_page']));
		$data['pagination'] = $this->pagination->create_links();
		$data['controller_name']=strtolower(get_class());
		$data['form_width']=$this->get_form_width();
		$data['per_page'] = $config['per_page'];
		$data['manage_table']=get_exchange_rate_manage_table($this->Exchange->get_all($data['per_page']),$this);
		$this->load->view('exchange/manage',$data);

	}


	function sorting()
	{

		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		if ($search)
		{
			$config['total_rows'] = $this->Exchange->search_count_all($search);
			$table_data = $this->Exchange->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		else
		{
			$config['total_rows'] = $this->Exchange->count_all();
			$table_data = $this->Exchange->get_all($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		$config['base_url'] = site_url('item_kits/sorting');
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($this->configPagination($config['base_url'],$config['total_rows'],$config['per_page']));
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_exchange_rate_manage_table_data_rows($table_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));	
	}
	
	/* added for excel expert */
	function excel_export() {
		$data = $this->Exchange->get_all()->result_object();
		$this->load->helper('report');
		$rows = array();
		$row = array("Dollar", "Reil", "Date");
		$rows[] = $row;
		
		foreach ($data as $r) {
			
			$row = array(
				$r->dollar,
				$r->reil,
				Date('d-M-Y',strtotime($r->date)),
				
			);
			
			$rows[] = $row;		
		}
		
		$content = array_to_csv($rows);
		force_download('exchange_rate_export' . '.csv', $content);
		exit;
	}

	function search()
	{
	
		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		$search_data=$this->Exchange->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'DESC');
		$config['base_url'] = site_url('exchange/search');
		$config['total_rows'] = $this->Exchange->search_count_all($search);
		$config['per_page'] = $per_page ;
		$this->pagination->initialize($this->configPagination($config['base_url'],$config['total_rows'],$config['per_page']));				
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_exchange_rate_manage_table_data_rows($search_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
	}

	/*
	Gives search suggestions based on what is being searched for
	*/
	function suggest()
	{
		$suggestions = $this->Exchange->get_search_suggestions($this->input->get('term'),100);
		echo json_encode($suggestions);
	}

	function get_row()
	{
		$exchange_id = $this->input->post('row_id');
		$data_row=get_exchange_rate_data_row($this->Exchange->get_info($exchange_id),$this);
		echo $data_row;
	}

	function view($exchange_id=-1)
	{

		$this->check_action_permission('add_update');	

		$this->load->helper('report');

        $data = array();
        $data['months'] = get_months();
        $data['days'] = get_days();
        $data['years'] = get_years();

		$data['exchange_info']=$this->Exchange->get_info($exchange_id);

		 if($exchange_id==-1)
        {
        	$data['selected_year']=0;
        	$data['selected_month']=0;
        	$data['selected_day']=0;
     
        }
        else
        {
        	list($data['selected_year'],$data['selected_month'],$data['selected_day'])=explode('-',$data['exchange_info']->date);        
 		}

		$this->load->view("exchange/form",$data);
	}
	
	function save($exchange_id=-1)
	{
		$this->check_action_permission('add_update');		
		$data = array(
		'reil'=>$this->input->post('reil'),
		'dollar'=>$this->input->post('dollar'),		
		'date'=>$this->input->post('date')
		);
		
		if($this->Exchange->save($data, $exchange_id))
		{
			//New Exchange
			if($exchange_id==-1)
			{
				echo json_encode(array('success'=>true,'message'=>lang('exchange_successful_adding').' '.
				$data['reil'],'id'=>$exchange_id));
				$exchange_id = $exchange_id;
			}
			else //previous item
			{
				echo json_encode(array('success'=>true,'message'=>lang('exchange_successful_updating').' '.
				$data['reil'], 'id' => $exchange_id));
			}
		
		}
		else//failure
		{
			echo json_encode(array('success'=>false,'message'=>lang('exchange_error_adding_updating').' '.
			$data['reil'],'id'=>-1));
		}

	}
	

	function delete()
	{
		$this->check_action_permission('delete');	

		$exchange_to_delete=$this->input->post('ids');

		if($this->Exchange->delete_list($exchange_to_delete))
		{
			echo json_encode(array('success'=>true,'message'=>lang('exchange_rate_successful_deleted').' '.
			count($exchange_to_delete).' '.lang('exchange_rate_one_or_multiple')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>lang('exchange_rate_cannot_be_deleted')));
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