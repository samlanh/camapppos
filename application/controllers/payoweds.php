<?php
require_once ("person_controller.php");

class Payoweds extends Person_controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Payowed');
		$this->load->library('sale_lib');
	}

	function view($id=-1)
	{			
		$data['owed_info'] = $owed_info = $this->Payowed->get_info_by_id($id);
	    $data['person_info']=$this->Customer->get_info($owed_info->customer_id);
	   	    
		$this->load->view("pay_owed/form_payment",$data);
	}
	
	function view_payowed()
	{			
		$customer_id = $this->session->userdata('customer');
		$data['payment_owed'] = $this->Payowed->get_info($customer_id);
	    $data['person_info']=$this->Customer->get_info($customer_id);
	    $data['total']=$this->sale_lib->get_total();
		$this->load->view("pay_owed/form",$data);
	}

	public function save($id=-1)
	{
		$payowed_before_hidden =  $this->input->post('payowed_before_hidden');
		$payment_amount = $this->input->post('payment_amount');
		$total_payment_amount = $payowed_before_hidden + $payment_amount;
		$this->db->trans_begin();
		try {
			$owed_date = $this->Payowed->get_info_by_id($id)->owed_date;
		// save payment owed		
			$dataOwed = array(
							'total_amount' => $this->input->post('total_amount_hidden'),
							'payment_amount' => $total_payment_amount,
							'remain_balance' => $this->input->post('remain_balance'),
							'owed_date' => $owed_date,
							'payment_date' => date('Y-m-d H:i:s'),
							'sale_id' => $this->input->post('sale_id'),
							'customer_id' => $this->input->post('customer_id'),
							'employee_id' => $this->Employee->get_logged_in_employee_info()->person_id,
				 			);
			$payowed_id = $this->Payowed->save($dataOwed);

			$this->Payowed->update_old_owed($id);

		} catch (Exception $e) {
		  $this->db->trans_rollback();    
        }      
        $this->db->trans_commit();
		         
        echo json_encode(array('success'=>true,'message'=>'payment owed is successfully!','id'=>$payowed_id));
	}

	function excel_export() {
		$data = $this->Payowed->get_all()->result_object();
		$this->load->helper('report');
		$rows = array();
		$row = array('Sale ID', 'Customer', 'Date', 'Total Amount', 'Payment Amount', 'Remain Balance');
		$rows[] = $row;
		foreach ($data as $r) {
			$row = array(
				'POS'.$r->sale_id,
				$this->Customer->get_customer_fullname($r->customer_id),
				date(get_date_format().'-'.get_time_format(), strtotime($r->payment_date)),
				to_currency($r->total_amount),
				to_currency($r->payment_amount),
				to_currency($r->remain_balance)
			);
			$rows[] = $row;
		}
		
		$content = chr(239).chr(187).chr(191).array_to_csv($rows);
		force_download('payment_owed_export' . '.csv', $content);
		exit;
	}


	public function delete()
	{
		# code...
	}

	//finish sales
	function save_payowed()
	{	
		$this->db->trans_begin();
        try {
		$data['cart']=$this->sale_lib->get_cart();
		$data['subtotal']=$this->sale_lib->get_subtotal();
		$data['taxes']=$this->sale_lib->get_taxes();
		$data['total']=$this->sale_lib->get_total();
		$data['receipt_title'] = lang('sales_receipt');
		$data['transaction_time'] = date(get_date_format().' '.get_time_format());
		$customer_id=$this->sale_lib->get_customer();
		$employee_id=$this->Employee->get_logged_in_employee_info()->person_id;
		$comment = $this->sale_lib->get_comment();
		$emp_info=$this->Employee->get_info($employee_id);
		$data['payments']=$this->sale_lib->get_payments();
		$data['amount_change']=$this->sale_lib->get_amount_due() * -1;
		$data['employee']=$emp_info->first_name.' '.$emp_info->last_name;
		$data['receive_payment_sale'] = $this->sale_lib->get_receive_payment_sale();

		if($customer_id!=-1)
		{
			$cust_info=$this->Customer->get_info($customer_id);
			$data['customer']=$cust_info->first_name.' '.$cust_info->last_name.($cust_info->company_name==''  ? '' :' ('.$cust_info->company_name.')');
		}

		//SAVE sale to database
		$data['sale_id'] = $this->Sale->save($data['cart'], $customer_id,$employee_id,$comment,$data['payments'], $this->sale_lib->get_suspended_sale_id(), 0);
		if ($data['sale_id'] == '-1')
		{
			$data['error_message'] = lang('sales_transaction_failed');
		}
		else
		{				
			// save payment owed		
			$dataOwed = array('total_amount' => $this->input->post('total_amount_hidden'),
							'payment_amount' => $this->input->post('payment_amount'),
							'remain_balance' => $this->input->post('remain_balance'),
							'owed_date' => date('Y-m-d H:i:s'),
							'payment_date' => date('Y-m-d H:i:s'),
							'sale_id' => $data['sale_id'],
							'customer_id' => $customer_id,
							'employee_id' => $this->Employee->get_logged_in_employee_info()->person_id,
				 			);
			$this->Payowed->save($dataOwed);
			//end
		}

		} catch (Exception $e) {
       $this->db->trans_rollback();      
        }
        $this->sale_lib->clear_all(); 
        $this->db->trans_commit();    
            
        echo json_encode(array('success'=>true,'sale_id'=>$data['sale_id']));
		//$this->load->view("sales/receipt",$data);	
	}

	/*
	get the width for the add/edit form
	*/
	function get_form_width()
	{			
		return 750;
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

		public function index()
		{	
				
	//$this->check_action_permission('search');
		$config['base_url'] = site_url('customers/sorting');
		$config['total_rows'] = $this->Payowed->count_all();
		$config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20; 

		$data['total_rows'] = $this->Payowed->count_all();
		$this->pagination->initialize($this->configPagination($config['base_url'],$config['total_rows'],$config['per_page']));
			
		$data['pagination'] = $this->pagination->create_links();
		$data['controller_name']=strtolower(get_class());		
		$data['form_width']=$this->get_form_width();
		$data['per_page'] = $config['per_page'];

		$data['manage_table']=get_payowed_manage_table($this->Payowed->get_all($data['per_page']),$this);
       $this->load->view('pay_owed/manage',$data);
}

public function search()
{
	//$this->check_action_permission('search');
		$search=$this->input->post('search');
		$per_page= $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20; 
		$search_data=$this->Payowed->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'sale_id' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		$config['base_url'] = site_url('payoweds/search');
		$config['total_rows'] = $this->Payowed->search_count_all($search);
		$config['per_page'] = $per_page ;
		
		$this->pagination->initialize($this->configPagination($config['base_url'],$config['total_rows'],$config['per_page']));			
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_payowed_manage_table_data_rows($search_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
}

public function suggest()
	{
		$suggestions = $this->Payowed->get_search_suggestions($this->input->get('term'),100);
		echo json_encode($suggestions);
	}


	public function receipt($id)
	{
		$data['receipt_title']=lang('sales_receipt');
		$data['owed_info'] = $owed_info = $this->Payowed->get_info_by_id($id);
		$data['transaction_time']= date(get_date_format().' '.get_time_format(), strtotime($owed_info->payment_date));	
		$cust = $this->Customer->get_info($owed_info->customer_id);
		$emp = $this->Employee->get_logged_in_employee_info();
		$data['customer'] = $cust->first_name.' '.$cust->last_name;
		$data['employee'] = $emp->first_name.' '.$emp->last_name;  
		$this->load->view("pay_owed/receipt",$data);
	}

	function get_row()
	{
		$id = $this->input->post('id');
		$data_row = get_payowed_data_row($this->Payowed->get_info($id),$this);
		echo $data_row;
	}
	 

	function sorting()
	{

		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		if ($search)
		{
			$config['total_rows'] = $this->Payowed->search_count_all($search);
			$table_data = $this->Payowed->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'sale_id' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		else
		{
			$config['total_rows'] = $this->Exchange->count_all();
			$table_data = $this->Payowed->get_all($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'sale_id' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		$config['base_url'] = site_url('payoweds/sorting');
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($this->configPagination($config['base_url'],$config['total_rows'],$config['per_page']));
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_payowed_manage_table_data_rows($table_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));	
	}

}


?>