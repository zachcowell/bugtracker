<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('bugtracker');
		$this->load->helper(array('form','url','date'));
		$this->load->library(array('form_validation', 'session','javascript','typography'));
		date_default_timezone_set('US/Eastern');
	}

	public function say($item){
		echo "<script>alert('".$item."');</script>";
	}

	function index()
	{
		//$this->issueList();
		$this->viewDashboard();
	}
	
	function issueList(){
		$data = $this->loadHead();
		if (isset($data['username'])) {
			$data['issues'] = $this->bugtracker->loadIssue($data['defaultlist'],'l.id');
			$data['issues'] = $this->labelStatus($data['issues']);
			$this->load->view('user/user_list',$data);
			$this->session->set_flashdata('message', 'Hint: As a superuser, you can quickly change the <strong>status</strong> of a ticket just by clicking on it in the issue list view.');
		}
		else redirect('home/index');
		$this->load->view('common/footer');
	}
	
	function labelStatus($issueList){
		for ($i=0; $i< count($issueList); $i++){
			$pClass='';
			switch ($issueList[$i]['status']) {
			    case "Resolved":
			        $pClass='label-success';
			        break;
			    case "Rejected":
			        $pClass='label-important';
			        break;
			    case "In Review":
			        $pClass='label-warning';
			        break;
				case "Postponed":
		        	$pClass='label-info';
			        break;
				default:
					$pClass='';
					break;
			}
			$issueList[$i]['statuslabel'] = $pClass;
		}
		return $issueList;
	}
	
	//Header
	function loadHead(){
		$session_data = $this->session->userdata('logged_in') ? $this->session->userdata('logged_in') : null;
		$data['library_src'] = $this->jquery->script();
		$data['script_head'] = $this->jquery->_compile();
		$data['hidemode']= isset($session_data) ? "visitor" : "loggedin";
		$data['username']= isset($session_data) ? $session_data['username'] : null;
		$data['defaultlist']= isset($session_data) ? $session_data['defaultlist'] : null;
		$data['uid'] = isset($session_data) ? $session_data['id'] : null;
		$this->load->view('common/header',$data);
		$this->load->view('common/navbar',$data);
		
		return $data;
	}

	function issueCreation($type="Bug"){
		if ($this->session->userdata('logged_in')){
			$data = $this->loadHead();
			$data['listmeta'] = $this->bugtracker->loadListMeta($data['defaultlist']);
			$data['userdropdown'] = $this->userDdl();
			$this->load->view('user/bugcreate',$data);
		}
		else redirect('home/issueList');
	}
	
	function createComment(){
		if ($this->session->userdata('logged_in') && $this->input->post('commentMake')){
			$session_data=$this->session->userdata('logged_in');
			$data = array(
				'issue_id' => $this->input->post('issueId'),
				'comment' => $this->input->post('comment'),
				'user_id' => $session_data['id']
			);
			$this->bugtracker->createComment($data);
			redirect('home/viewIssue/'.$this->input->post('issueId') );
		}
		else redirect('home/index');
	}

	function viewDashboard(){
		$this->loadHead();
		if ($this->session->userdata('logged_in')){
			$issueTypes = $this->bugtracker->countIssueTypes();
			$data['counts'] ="[
				['Bug',".$issueTypes->Bug."],['Change Request',".$issueTypes->ChangeRequest."],['Other',".$issueTypes->Other."]
			];";
			//$history[$i]['as_of']
			$history = $this->bugtracker->loadRecentHistory();
			for ($i=0; $i<count($history); $i++){
				$history[$i]['fullname'] = $history[$i]['firstname']. ' '. $history[$i]['lastname'];
				$history[$i]['time'] = timespan(mysql_to_unix($history[$i]['as_of']),now());
			}
			
			$data['edits'] = $history;
			$this->load->view('user/dashboardview',$data);
		}
		//else redirect('home/index');
	}
	
	function userCreate(){
		$session_data = $this->session->userdata('logged_in') ? $this->session->userdata('logged_in') : null;
		if ($this->input->post('submit')) {
			$data = array(
				'username' => $this->input->post('username'),
				'pw' => md5($this->input->post('password')),
				'firstname' => $this->input->post('firstname'),
				'lastname' => $this->input->post('lastname'),
				'email' => $this->input->post('email')
			);
			$this->bugtracker->createUser($data);
		}
			$this->session->set_flashdata('message', 'User <strong>'.$this->input->post('username'). '</strong> successfully created.');
			redirect('home/index/');
	}
	
	function listCreate(){
		$session_data = $this->session->userdata('logged_in') ? $this->session->userdata('logged_in') : null;
		if ($this->input->post('submit')) {
			$data = array(
				'name' => $this->input->post('projname'),
				'description' => $this->input->post('desc'),
				'short_tag' => $this->input->post('shorttag'),
			);
			$this->bugtracker->createList($data);
		}
			//$this->session->set_flashdata('message', 'User <strong>'.$this->input->post('username'). '</strong> successfully created.');
			redirect('home/index/');
	}
	
	function createProject(){
		if ($this->session->userdata('logged_in')){
			$this->loadHead();
			$this->load->view('user/projectcreate');
		}
		
	}
	
	function userDdl(){
		$dataSource = $this->bugtracker->getUsers();
		$arr = array();
		$arr[-999] = 'Auto assign';
		foreach ($dataSource as $row)
		{
		    $arr[$row['id']] = $row['firstname'] . ' ' . $row['lastname'];
		}
		return $arr;
	}

	function newUser(){
		if ($this->session->userdata('logged_in')){
			$this->loadHead();
			$this->load->view('user/usercreate');
		}
		else redirect('home/index');
	}

	function statusChange($id){
		$session_data= $this->session->userdata('logged_in');
		if ($session_data){
			$this->bugtracker->updateStatus($id,$_POST['value'],$session_data['id']);
		}
	}
	
	function createIssue(){
		//if($this->input->post('submit') && $this->form_validation->run()) $this->todoSubmit($list);
		$session_data = $this->session->userdata('logged_in') ? $this->session->userdata('logged_in') : null;
		if ($this->input->post('submit')) {
			$data = array(
				'list_id' => $this->input->post('listID'),
				'priority' => $this->input->post('priority'),
				'item' => $this->input->post('title'),
				'status' => 'Submitted',
				'description' => $this->typography->auto_typography($this->input->post('description')),
				'reproduce' => $this->typography->auto_typography($this->input->post('reproduction')),
				'assigned_to' => $this->input->post('assign') != -999 ? $this->input->post('assign') : $this->bugtracker->getRandomuser(),
				'type' => $this->input->post('type'),
				'created_by' => $session_data['id']
			);
			$newID = $this->bugtracker->createBug($data);
			
			if ($this->input->post('tags')) $this->createTags($newID);

		}
		$this->session->set_flashdata('message', '<strong>Success!</strong> Issue successfully reported.');
		redirect('home/issueList/');
	}
	
	function updateIssue(){
		//if($this->input->post('submit') && $this->form_validation->run()) $this->todoSubmit($list);
		$session_data = $this->session->userdata('logged_in') ? $this->session->userdata('logged_in') : null;
		if ($this->input->post('submit')) {
			$data = array(
				'priority' => $this->input->post('priority'),
				'item' => $this->input->post('title'),
				'status' => $this->input->post('status'),
				'description' => $this->typography->auto_typography($this->input->post('description')),
				'reproduce' => $this->typography->auto_typography($this->input->post('reproduction')),
				'assigned_to' => $this->input->post('assign') != -999 ? $this->input->post('assign') : $this->bugtracker->getRandomuser(),
				'type' => $this->input->post('type')
			);
			
			$this->bugtracker->updateBug($data,$this->input->post('issueId'),$session_data['id']);
			
			//if ($this->input->post('tags')) $this->createTags($newID);

		}
		$this->session->set_flashdata('message', 'Issue successfully edited.');
		redirect('home/viewIssue/'.$this->input->post('issueId'));
	}
	
	function editIssue($id){
		if ($this->session->userdata('logged_in')){
			$sdata = $this->loadHead();
			$issue=$this->bugtracker->loadIssue($id,'i.id');
			$tags = $this->bugtracker->loadTags($issue[0]['id']);
			
			$tagString = '';
			foreach ($tags as $t){
				$tagString .= $t['tag_name'] . ',';
			}
			
			$data['issue'] = $issue[0];
			$data['userdropdown'] = $this->userDdl();
			$data['tagVals'] = $tagString;
			$this->load->view('user/bugedit',$data);
		}
		else redirect('home/issueList');
	}
	
	function createTags($id){
		$tagInsert = array();
		$tagArray = explode(',',$this->input->post('tags'));
		foreach ($tagArray as $t){
			array_push($tagInsert,array('issue_id' => $id, 'tag_name' => $t));
		}
		$this->bugtracker->createTags($tagInsert);
	}
	
	function fullName ($first,$last,$email=''){
		return '<a href="mailto:'.$email.'">'.$first.' '.$last.'</a>';
	}
		
	function testCase(){
		$this->loadHead();
		$this->load->view('user/testcase');
	}
		
	function viewIssue($issueId){
		//if($this->input->post('submit') && $this->form_validation->run()) $this->todoSubmit($list);
		
		$issue = $this->bugtracker->loadIssue($issueId,'i.id');
		$comments = $this->bugtracker->loadComments($issueId);
		$tags = $this->bugtracker->loadTags($issueId);
		$createdBy = $this->fullName($issue[0]['cbfirst'],$issue[0]['cblast'],$issue[0]['cbemail']);
		$assignedTo = $this->fullName($issue[0]['atfirst'],$issue[0]['atlast'],$issue[0]['atemail']);
		
		
		$tagString = '';
		foreach ($tags as $t){
			$tagString .= $t['tag_name'];
		}
		
		for($i=0; $i<count($comments); $i++){
			$comments[$i]['cDate'] = date('D, d M Y H:i:s',strtotime($comments[$i]['date_added']));
		}
		
		$historyDeltas = $this->historyDelta($issue[0]);
		
		$data = array(
			'issue' => $issue[0],
			'comments' => $comments,
			'createdBy' => $createdBy,
			'assignedTo' => $assignedTo,
			'tagsValue' => $tagString,
			'tagList' => $tags,
			'historyList' => $historyDeltas
		);
		
		$this->loadHead();
		$this->load->view('user/bugview',$data);
	}
	
	function historyDelta($issue){
		$delta = array();
		$fieldset = $this->getDeltaColumns();
		$historicals = $this->bugtracker->loadIssueHistory($issue['id']);
		
		if (count($historicals) > 0){
			for ($i=0; $i< count($fieldset); $i++){
				if ($historicals[0][$fieldset[$i]] != $issue[$fieldset[$i]]){
					array_push($delta,$this->historicalInstance($fieldset[$i],$issue,$historicals[0]));
				}
			}
		}
		
		if (count($historicals) > 1){
			for ($j=0; $j< count($historicals); $j++){
				for ($i=0; $i< count($fieldset); $i++){
					if ($j+1 != count($historicals) && $historicals[$j][$fieldset[$i]] != $historicals[$j+1][$fieldset[$i]]){
						array_push($delta,$this->historicalInstance($fieldset[$i],$historicals[$j],$historicals[$j+1]));
					}
				}
			}
		}
		
		return $delta;
		
	}
	
	function historicalInstance($fieldname,$old,$new){
		return array(
			"column" => $fieldname,
			"edit_user" => $new['user_id'],
			"firstname" => $new['firstname'],
			"lastname" => $new['lastname'],
			"email" => $new['email'],
			"from" => $old[$fieldname],
			"id" => $new['id'],
			"to" => $new[$fieldname],
			"date" => date('D, d M Y H:i:s',strtotime($new['as_of']))
			);
	}
	
	//Hardcoded list of fields that I want to examine
	function getDeltaColumns(){
		$fieldset = array();
		$fieldset[0] = "priority";
		$fieldset[1] = "item";
		$fieldset[2] = "estimated_time";
		$fieldset[3] = "status";
		$fieldset[4] = "description";
		$fieldset[5] = "reproduce";
		$fieldset[6] = "type";
		$fieldset[7] = "assigned_to";
		return $fieldset;
	}
	
	
	function logout()
	{
	  $this->session->unset_userdata('logged_in');
	  session_destroy();
	  redirect('home/index');
	}

}

?>
