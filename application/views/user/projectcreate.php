<div class="container">
	<?php 
		echo form_open('home/listCreate'); 
		echo form_fieldset('New project');
		
		$proj = array('name' => 'projname',  'class' => 'span4', 'placeholder' => 'Full Project Name' );
		$desc = array('name' => 'desc',  'class' => 'span4', 'placeholder' => 'Short description' );
		$short = array('name' => 'shorttag',  'class' => 'span4', 'placeholder' => 'E.g., ABCD' );

		echo form_label('Project Name', 'projname');
		echo form_input($proj) . '<br />';
		echo form_label('Description', 'desc');
		echo form_input($desc) . '<br />';
		echo form_label('Short Tag', 'shorttag');
		echo form_input($short) . '<br />';
	
		echo form_submit('submit', 'Submit');
		echo form_fieldset_close();
		echo form_close();
	?>
</div>

<script>
	$('[name="submit"]').addClass('btn btn-primary');
</script>
