<?= form_open(); ?>
<?=form_hidden('hiddenbox','') ?>
	<?
	$data = array(
	    'name'        => 'update',
		'value'			=> 'Update!',
	    'id'          => 'update',
		'disabled'	  => 'disabled',
	    );
	echo form_submit($data);
	?>
<?=form_close();?>

<div id="newTask">
<?= form_open(); ?>
<?=form_fieldset('New task');?>

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
</div>

<script>
$(document).ready(function() {
	//$("#item").focus();

	$("#item_list tbody").sortable({stop:function(i) {
			var linkOrder= $("#item_list tbody").sortable("serialize")
			$('input[name="hiddenbox"]').val(linkOrder);
			$('#update').removeAttr("disabled");       
	}
	});
});
</script>
