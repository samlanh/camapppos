<?php
require_once ("secure_area.php");
class Mail extends Secure_area 
{
	function __construct()
	{
		parent::__construct();	
	}
	
 public function form($id)
  {
  	$this->db->from('people');		
	$this->db->where('person_id',$id);
	$query = $this->db->get();
	$query->first_row();
  	$data['mail'] = $query->first_row()->email;
  	$this->load->view("mail/form", $data);
  }

  public function send(){
    	$this->load->library('email'); 
    	 $this->email->from($this->config->item('email_send'), $this->config->item('company'));
		$this->email->to($this->input->post('email')); 		
		$this->email->subject($this->input->post('subject'));
		$this->email->message($this->input->post('comment'));	
		$this->email->send();
		echo json_encode(array('success'=>true));		
  }

}
?>