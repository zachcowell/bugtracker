<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main_controller extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('productivity');
		$this->load->helper(array('form','url'));
		$this->load->library(array('form_validation', 'session','javascript'));

		    // ensure user is signed in
	    if ( $this->session->userdata('login_state') == FALSE ) {
	      $this->load->view('login_view', $data);
	    }
	
	}
	
	public function index($list=1)
	{
		
		$data['items'] = $this->productivity->loadByListId($list);
		$data['lists'] = $this->productivity->loadByUserId(1);
		
		$data['library_src'] = $this->jquery->script();
		$data['script_head'] = $this->jquery->_compile();
		
		$this->form_validation->set_rules('item', 'Item', 'required');
		$this->form_validation->set_error_delimiters('<em>','</em>');
		
		if($this->input->post('submit') && $this->form_validation->run()) $this->todoSubmit($list);
		if($this->input->post('update')) $this->updateOrder($list);
		if($this->input->post('newlist')) $this->createList($list);
		
		
		$this->load->view('header',$data);
		$this->load->view('index_view', $data);
		$this->load->view('footer');
	}
	
	private function updateOrder($currentList){
		$item = $this->input->post('hiddenbox');
	   	parse_str($item);
		for ($i = 0; $i < count($item); $i++){
			$data = array(
			               'order' => ($i+1)
			            );
			$this->db->where('id', $item[$i]);
			$this->db->update('todo', $data);
		}
		redirect('/main_controller/index/');
		
	}
	
	private function createList($currentList){
		$item = $this->input->post('list');
	
		$data = array(
		   'name' => $item
		);

		$this->db->insert('lists', $data); 
		redirect('/main_controller/index/'.$currentList);
		
	}
	
	private function todoSubmit($currentList){
		
		$item = $this->input->post('item');
	
		$data = array(
		   'item' => $item,
			'list_id' => $currentList,
		);

		$this->db->insert('todo', $data); 
		redirect('/main_controller/index/'.$currentList);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */