<div id="containers">
<table id="item_list">
	<tbody>
	<? foreach ($items as $q): ?>
	<?='<tr id="item_' .$q['id'] . '">'; ?>
			<td><?=$q['item']; ?></td>
			</tr>
	<? endforeach ?>
	</tbody>
</table>
</div>