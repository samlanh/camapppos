<?php
require_once ("person_controller.php");
class Suppliers extends Person_controller
{
	function __construct()
	{
		parent::__construct('suppliers');
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

     //   $this->pagination->initialize($this->configPagination($config['base_url'],$config['total_rows'],$config['per_page']));

  }
  
	function index()
	{
		$this->check_action_permission('search');
		$config['base_url'] = site_url('suppliers/sorting');
		$config['total_rows'] = $this->Supplier->count_all();
		$config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20; 
		$this->pagination->initialize($this->configPagination($config['base_url'],$config['total_rows'],$config['per_page']));
		$data['pagination'] = $this->pagination->create_links();
		$data['controller_name']=strtolower(get_class());
		$data['form_width']=$this->get_form_width();
		$data['per_page'] = $config['per_page'];
		$data['manage_table']=get_supplier_manage_table($this->Supplier->get_all($data['per_page']),$this);
		$this->load->view('suppliers/manage',$data);
	}
	
	function sorting()
	{
		$this->check_action_permission('search');
		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		if ($search)
		{
			$config['total_rows'] = $this->Supplier->search_count_all($search);
			$table_data = $this->Supplier->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'last_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		else
		{
			$config['total_rows'] = $this->Supplier->count_all();
			$table_data = $this->Supplier->get_all($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'last_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		$config['base_url'] = site_url('suppliers/sorting');
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($this->configPagination($config['base_url'],$config['total_rows'],$config['per_page']));
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_supplier_manage_table_data_rows($table_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));	
	}
	
	
	/* added for excel expert */
	function excel_export() {
		$data = $this->Supplier->get_all()->result_object();
		$this->load->helper('report');
		$rows = array();
		$row = array("Company Name", "First Name", "Last Name", "E-Mail", "Phone Number", "Address 1", "Address 2", "City", "State", "Zip", "Country", "Comments", "Account Number");
		$rows[] = $row;
		foreach ($data as $r) {
			$row = array(
				$r->company_name,
				$r->first_name,
				$r->last_name,
				$r->email,
				$r->phone_number,
				$r->address_1,
				$r->address_2,
				$r->city,
				$r->state,
				$r->zip,
				$r->country,
				$r->comments,
				$r->account_number
			);
			$rows[] = $row;
		}
		
		$content = array_to_csv($rows);

		force_download('suppliers_export' . '.csv', $content);
		exit;
	}
	/*
	Returns supplier table data rows. This will be called with AJAX.
	*/
	function search()
	{
		$this->check_action_permission('search');
		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		$search_data=$this->Supplier->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'last_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		$config['base_url'] = site_url('suppliers/search');
		$config['total_rows'] = $this->Supplier->search_count_all($search);
		$config['per_page'] = $per_page ;
		$this->pagination->initialize($this->configPagination($config['base_url'],$config['total_rows'],$config['per_page']));				
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_supplier_manage_table_data_rows($search_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
		
	}
	/*
	Gives search suggestions based on what is being searched for
	*/
	function suggest()
	{
		$suggestions = $this->Supplier->get_search_suggestions($this->input->get('term'),100);
		echo json_encode($suggestions);
	}
	
	/*
	Loads the supplier edit form
	*/
	function view($supplier_id=-1)
	{
	$this->check_action_permission('add_update');		
		$data['person_info']=$this->Supplier->get_info($supplier_id);
		$this->load->view("suppliers/form",$data);
	}
	
	/*
	 Loads the supplier edit form upadte payment
	*/
	function payment($supplier_id=-1)
	{
		$this->check_action_permission('add_update');
		$data['person_info']=$this->Supplier->get_info($supplier_id);
		$this->load->view("suppliers/form-payment",$data);
	}
	
	function savepayment($supplier_id=-1){
		$amount = $this->input->post('amount');
		$comments = $this->input->post('comments');
		$balance = $this->Supplier->get_current_balence($supplier_id);
		$store_account_data =array(
				'supplier_id'=>$supplier_id,
				'receiving_id'=>null,
				'transaction_amount'=> ($amount * -1),
				'date'=>date('Y-m-d H:i:s'),
				'balance'=> ($balance - $amount),
				'comment'=>$comments
		);
		$company_name=$this->input->post('company_name');
		
		if($this->db->insert('store_accounts',$store_account_data))
		{
			echo json_encode(array('success'=>true,'message'=>lang('suppliers_successful_updating').' '.
						$company_name,'person_id'=>$supplier_id));
			
		}
		else//failure
		{
			echo json_encode(array('success'=>false,'message'=>lang('suppliers_error_adding_updating').' '.
					$company_name,'person_id'=>$supplier_id));
		}
	}
	
	/*
	Inserts/updates a supplier
	*/
	function save($supplier_id=-1)
	{
		$this->check_action_permission('add_update');		
		$person_data = array(
		'first_name'=>$this->input->post('first_name'),
		'last_name'=>$this->input->post('last_name'),
		'email'=>$this->input->post('email'),
		'phone_number'=>$this->input->post('phone_number'),
		'address_1'=>$this->input->post('address_1'),
		'address_2'=>$this->input->post('address_2'),
		'city'=>$this->input->post('city'),
		'state'=>$this->input->post('state'),
		'zip'=>$this->input->post('zip'),
		'country'=>$this->input->post('country'),
		'comments'=>$this->input->post('comments')
		);
		$supplier_data=array(
		'company_name'=>$this->input->post('company_name'),
		'account_number'=>$this->input->post('account_number')=='' ? null:$this->input->post('account_number'),
		);
		if($this->Supplier->save($person_data,$supplier_data,$supplier_id))
		{
			if ($this->config->item('mailchimp_api_key'))
			{
				$this->Person->update_mailchimp_subscriptions($this->input->post('email'), $this->input->post('first_name'), $this->input->post('last_name'), $this->input->post('mailing_lists'));
			}
			
			//New supplier
			if($supplier_id==-1)
			{
				echo json_encode(array('success'=>true,'message'=>lang('suppliers_successful_adding').' '.
				$supplier_data['company_name'],'person_id'=>$supplier_data['person_id']));
			}
			else //previous supplier
			{
				echo json_encode(array('success'=>true,'message'=>lang('suppliers_successful_updating').' '.
				$supplier_data['company_name'],'person_id'=>$supplier_id));
			}
		}
		else//failure
		{	
			echo json_encode(array('success'=>false,'message'=>lang('suppliers_error_adding_updating').' '.
			$supplier_data['company_name'],'person_id'=>-1));
		}
	}
	
	/*
	This deletes suppliers from the suppliers table
	*/
	function delete()
	{
		$this->check_action_permission('delete');
		$suppliers_to_delete=$this->input->post('ids');
		
		if($this->Supplier->delete_list($suppliers_to_delete))
		{
			echo json_encode(array('success'=>true,'message'=>lang('suppliers_successful_deleted').' '.
			count($suppliers_to_delete).' '.lang('suppliers_one_or_multiple')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>lang('suppliers_cannot_be_deleted')));
		}
	}
	
	/*
	Gets one row for a supplier manage table. This is called using AJAX to update one row.
	*/
	function get_row()
	{
		$person_id = $this->input->post('row_id');
		$data_row=get_supplier_data_row($this->Supplier->get_info($person_id),$this);
		echo $data_row;
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