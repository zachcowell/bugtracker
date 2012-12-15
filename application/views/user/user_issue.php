<?= form_open(); ?>
<?=form_fieldset('New issue');?>

		<?=form_label('Item', 'item');?>
		<?
		
		$data = array(
		    'name'        => 'item',
		    'id'          => 'item',
		    );
		echo form_input($data);?>


        <?=form_submit('submit', 'Submit');?>

 <?=form_fieldset_close();?>
<?=form_close();?>