<div class="container">
	<?php 
		echo form_open('home/userCreate'); 
		echo form_fieldset('New user');
		
		$user = array('name' => 'username',  'class' => 'span4', 'placeholder' => 'Username' );
		$pw = array('name' => 'password',  'class' => 'span4', 'placeholder' => 'Password', 'type' => 'password' );
		$first = array('name' => 'firstname',  'class' => 'span4', 'placeholder' => 'Name' );
		$last = array('name' => 'lastname',  'class' => 'span4', 'placeholder' => 'Name' );
		$email = array('name' => 'email', 'class' => 'span4', 'placeholder' => 'Example@gmail.com' );
		
		echo form_label('Username', 'username');
		echo form_input($user) . '<br />';
		echo form_label('Password', 'password');
		echo form_input($pw) . '<br />';
		echo form_label('First Name', 'firstname');
		echo form_input($first) . '<br />';
		echo form_label('Last Name', 'lastname');
		echo form_input($last) . '<br />';
		echo form_label('Email', 'email');
		echo form_input($email) . '<br />';
		
		echo form_submit('submit', 'Submit');
		echo form_fieldset_close();
		echo form_close();
	?>
</div>

<script>
	$('[name="submit"]').addClass('btn btn-primary');
	$('li').removeClass('active');
	$('#newUser').addClass('active');
</script>
