<?= form_open(); ?>
<?=form_fieldset('New list');?>

		<?=form_label('List', 'list');?>
		<?

		$data = array(
		    'name'        => 'list',
		    'id'          => 'list',
		    );
		echo form_input($data);?>


        <?=form_submit('newlist', 'Create');?>

 <?=form_fieldset_close();?>
<?=form_close();?>