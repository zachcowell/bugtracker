<?= form_open(); ?>
<table>
	<thead><tr><td>List name</td><td>Public</td><td> </td></tr></thead><tbody>
	<? foreach ($lists as $L): ?>
		<tr>
			<td><?= $L['name']; ?></td>
			<td><input name="publicLists[]" type="checkbox" value="<?=$L['id']; ?>" <?=$L['public']==1? 'checked="checked"': '';?> /></td>
			<td><a href="<?=site_url("home/dellist/".$L['id']); ?>"><img src="<?=base_url();?>img/del.png"></a></td>
		</tr>
	<? endforeach ?>
	</tbody>
</table>

<?=form_submit('listConfig', 'Submit');?>

<?=form_close();?>

<script>
	$('li').removeClass('active');
	$('#listconfig').addClass('active');
</script>