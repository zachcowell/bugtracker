<?
class bugtracker extends CI_Model{
	
  	public function __construct()
	{
		$this->load->database();
	}
	
	public function loadIssue($id,$specifier){
	 	$this->db->select('i.*,l.short_tag as "short_tag",l.name as "listName", CB.firstname as "cbfirst",CB.lastname as "cblast",CB.email as "cbemail",AT.firstname as "atfirst",AT.lastname as "atlast",AT.email as "atemail"');
		$this->db->from('issue i');
		$this->db->join('user CB', 'CB.id = i.created_by', 'left');
		$this->db->join('user AT', 'AT.id = i.assigned_to', 'left');
		$this->db->join('lists l', 'l.id = i.list_id', 'left');
		$this->db->order_by('i.id','desc');
		$this->db->where($specifier,$id);
		
		return $this->db->get()->result_array();
	}
	
	public function loadListMeta($id){
		//$this->db->order_by("order", "asc"); 
		$query = $this->db->get_where('lists', array('id' => $id));
		return $query->row();
	}
	
	public function loadTags($issueId){
		$query = $this->db->get_where('tags',array('issue_id' => $issueId));
		return $query->result_array();
	}
	
	private function historicalIssue($id,$user){
		$this->db->query('INSERT into issue_historical select null, i.*,'.$user.',CURRENT_TIMESTAMP() FROM issue i where id ='.$id);
	}
	
	public function updateBug($data,$id,$user){
		$this->historicalIssue($id,$user);
		$this->db->where('id', $id);
		$this->db->update('issue', $data);
	}
	
	public function updateStatus($id,$data,$user){
		$toUpdate = array('status' => $data);
		$this->updateBug($toUpdate,$id,$user);
	}
	
	public function createBug($data){
		$this->db->insert('issue', $data);
		return $this->db->query('SELECT id FROM issue ORDER BY id DESC LIMIT 1')->row()->id;
	}
	
	public function createUser($data){
		$this->db->insert('user', $data);
	}
	
	public function createComment($data){
		$this->db->insert('comments', $data);
	}
	
	public function createList($data){
		$this->db->insert('lists', $data);
	}
	
	public function createTags($data){
		$this->db->insert_batch('tags', $data); 
	}
	
	public function getUsers(){
		return $this->db->get('user')->result_array();
	}
	
	public function loadListMetaByIssueId($issueId){
		$query = $this->db->query("select * from lists where id = (select list_id from issue where id=".$issueId." limit 1)");
		return $query->row();
	}
	
	public function loadComments($issueId){
		$query = $this->db->query("SELECT c.*,u.email, u.firstname,u.lastname FROM comments c JOIN user u ON u.id = c.user_id WHERE c.issue_id=".$issueId);
		return $query->result_array();
	}
	
	public function loadRecentHistory(){
		return $this->db->query("SELECT l.short_tag,issue_id, u.firstname,u.lastname,u.email, MAX(as_of) as as_of,ix.item 
		from issue_historical i
		JOIN user u on u.id = i.user_id
		JOIN lists l on l.id = i.list_id
		JOIN issue ix on ix.id = i.issue_id
		GROUP BY issue_id HAVING COUNT(*) >= 1  ORDER BY as_of desc LIMIT 5")->result_array();
	}
	
	public function loadIssueHistory($issueID){
		return $this->db->query("SELECT i.id,u.firstname, u.lastname, u.email, priority,item,estimated_time,status,
		description,reproduce,type,assigned_to,user_id,as_of 
		FROM issue_historical i
		JOIN user u on u.id = i.user_id WHERE issue_id = ".$issueID." ORDER BY as_of DESC")->result_array();
	}
	
	public function getRandomUser(){
		$query = $this->db->query("select id from user ORDER BY RAND() LIMIT 0,1;");
		return $query->row()->id;
	}
	
	public function countIssueTypes(){
		$query = $this->db->query("SELECT 
		(SELECT COUNT(*) FROM issue WHERE type = 'Bug') AS Bug,
		(SELECT COUNT(*) FROM issue WHERE type = 'Change Request') AS ChangeRequest,
		(SELECT COUNT(*) FROM issue WHERE type = 'Other') AS Other");
		return $query->row();
	}
}
?>