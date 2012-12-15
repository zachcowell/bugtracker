<div class="container">
	<?php 
		echo form_open('home/updateIssue'); 
		echo form_fieldset('Edit issue');
		$title = array('name' => 'title', 'id' => 'title', 'class' => 'span10 deltas', 'placeholder' => 'Brief issue description','value'=> $issue['item']);
		$tags = array('name' => 'tags', 'id' => 'tags', 'class' => 'tags deltas', 'placeholder' => 'Brief issue description', 'value' => $tagVals );
		$desc = array( 'name'=> 'description', 'id' => 'description','class' => 'span10 deltas', 'placeholder' => 'Detailed issue descripton (optional)','value'=> $issue['description']);
		$repo = array( 'name'=> 'reproduction', 'id' => 'reproduction', 'class' => 'span10 deltas', 'placeholder' => 'Steps to reproduce (optional)','value'=> $issue['reproduce'] );

		echo form_hidden('issueId',$issue['id']);
		echo form_label('Issue title', 'title');
		echo form_input($title) . '<br />';

		echo form_label('Tags', 'tags');
		echo form_input($tags) . '<br />';

		$type = array( 'Bug'  => 'Bug', 'Change Request'    => 'Change request', 'Other'   => 'Other',);
		$priority = array( '1'  => '1 (Highest)', '2'  => '2', '3'   => '3 (Lowest)',);

		echo form_label('Type', 'type');
		echo form_dropdown('type', $type,$issue['type']). '<br />';
		
		echo form_label('Priority', 'priority');
		echo form_dropdown('priority', $priority, $issue['priority']). '<br />';
		
		echo form_label('Assign to', 'assign');
		echo form_dropdown('assign', $userdropdown,$issue['assigned_to']). '<br />';
		
		$status = array( 'Submitted' => 'Submitted', 'In Review' => 'In Review', 'Resolved' => 'Resolved','Postponed' => 'Postponed','Rejected' => 'Rejected');
		echo form_label('Status', 'status');
		echo form_dropdown('status', $status). '<br />';
		
		
		echo form_label('Description', 'description');
		echo form_textarea($desc). '<br />';
		echo form_label('Steps to reproduce', 'reproduce');
		echo form_textarea($repo). '<br />';
		echo form_submit('submit', 'Submit');
		echo form_fieldset_close();
		echo form_close();
	?>
</div>

<script>
	$('[name="submit"]').addClass('btn btn-primary');
	
	$('.tags').tags({
		'separator':','
	});
	$('#reproduction').val(function(i,val) {
	    return $('<div>').html(val).text();
	});
	$('#description').val(function(i,val) {
	    return $('<div>').html(val).text();
	});
</script>
