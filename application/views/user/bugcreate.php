<div class="container">
	<?php 
		echo form_open('home/createIssue'); 
		echo form_fieldset('New issue');
		$title = array('name' => 'title', 'id' => 'title', 'class' => 'span10', 'placeholder' => 'Brief issue description' );
		$tags = array('name' => 'tags', 'id' => 'tags', 'class' => 'tags', 'placeholder' => 'Brief issue description' );
		$desc = array( 'name'=> 'description', 'class' => 'span10', 'placeholder' => 'Detailed issue descripton (optional)' );
		$repo = array( 'name'=> 'reproduction', 'class' => 'span10', 'placeholder' => 'Steps to reproduce (optional)' );
		echo form_hidden('listID',$listmeta->id);
		echo form_label('Issue title', 'title');
		echo form_input($title) . '<br />';

		echo form_label('Tags', 'tags');
		echo form_input($tags) . '<br />';

		$type = array( 'Bug'  => 'Bug', 'Change Request'    => 'Change request', 'Other'   => 'Other',);
		$priority = array( '1'  => '1 (Highest)', '2'  => '2', '3'   => '3 (Lowest)',);

		echo form_label('Type', 'type');
		echo form_dropdown('type', $type). '<br />';
		
		echo form_label('Priority', 'priority');
		echo form_dropdown('priority', $priority, 'two'). '<br />';
		
		echo form_label('Assign to', 'assign');
		echo form_dropdown('assign', $userdropdown). '<br />';
		
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
	
</script>
