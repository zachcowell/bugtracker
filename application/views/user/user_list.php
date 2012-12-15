<div class="container">

	<div class="row">
		<div class="span12">
		<h2><?=count($issues)>0 ? $issues[0]['listName'] : ''; ?></h2>
	<table class="table table-hover">
	<thead><tr>
		<th>ID</th><th>Issue</th><th>Status</th><th>Issue type</th><th>Assigned</th>
	</tr></thead>
		<tbody>
		<? foreach ($issues as $q): ?>
			<?='<tr id="item_' .$q['id'] . '">'; ?>
				<td><a href="<?=site_url('home/viewIssue/').'/'.$q['id']; ?>"><?=$q['short_tag']."-". $q['id']; ?></a></td>
				<td><?=$q['item']; ?></td>
				<td><a href="#" data-value="<?=$q['status']; ?>" class="label <?=$q['statuslabel']; ?>" data-url="<?=site_url('home/statusChange/').'/'.$q['id'];?>" id="statusLink<?=$q['id'];?>"><?=$q['status']; ?></a></td>
				<td><?=$q['type']; ?></td>
				
				<td><a href="mailto:<?=$q['atemail']; ?>"><?=$q['atfirst']." ".$q['atlast'][0]."."; ?></a></td>
				
			</tr>
		<? endforeach ?>
		</tbody>
	</table>
	</div>
	</div>
</div>


<script>
	$('li').removeClass('active');
	$('#home').addClass('active');
	$(".alert").alert();
	$('[id^=statusLink]').editable({
	    pk: 1,
		type: 'select',
		source: '{"Submitted": "Submitted", "Resolved":"Resolved", "Rejected": "Rejected", "Postponed": "Postponed", "In Review" : "In Review"}',
		autotext: 'always'
    });

    $('[id^=statusLink]').on('save', function(e, params) {
	    var labelz = new Array();
		labelz["Submitted"] = "label";
		labelz["Resolved"] = "label label-success";
		labelz["Rejected"] = "label label-important";
		labelz["Postponed"] = "label label-info";
		labelz["In Review"] = "label label-warning";
		
		var ident = $(this).attr('id');
	    $('#'+ident).removeClass();
		$('#'+ident).addClass(labelz[params.newValue]);
		
    });

</script>
