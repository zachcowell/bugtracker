<div class="container">
	<div class="row">
		<div class="span10">
			<h2><?=$issue['short_tag']."-".$issue['id'] ?></h2>
			<p class="lead"><?=$issue['item'] ?></p>
			<hr />
		</div>
	</div>
	<div class="row">
		<div class="span8">	
			<dl class="dl-horizontal">
				<dt>Description</dt>
				<dd><?=$issue['description'] ? $issue['description'] : '<p class="muted">N/A</p>'; ?></dd>
				<dt>Steps to reproduce</dt>
				<dd> <?=$issue['reproduce'] ? $issue['reproduce'] : '<p class="muted">N/A</p>'; ?></dd>
				<dt>Type</dt>
				<dd> <?=$issue['type'] ? $issue['type'] : '<p class="muted">N/A</p>'; ?></dd>
				<dt>Priority</dt>
				<dd> <?=$issue['priority'] ? $issue['priority'] : '<p class="muted">N/A</p>'; ?></dd>
				<dt>Created by</dt>
				<dd><?=$createdBy; ?></dd>
				<dt>Assigned to</dt>
				<dd><?=$assignedTo; ?></dd>
				<dt>Tags</dt>
				<dd>
					<? foreach ($tagList as $t): ?>
						<p class="label label-info"><?=$t['tag_name'];?> </p>
					<? endforeach ?>
				</dd>
			</dl>
		
		</div>
		<div class="span2">
			<a href="<?=site_url('home/editIssue/').'/'.$issue['id']; ?>" class="btn btn-large btn-primary">
				Edit issue
			</a>
		</div>
	</div>
	
	<div class="row">
		<div class="span10">
		<hr />
		<h4>History</h4>
		</div>
	</div>
	
	<? foreach ($historyList as $h): ?>
		<div class="row">
			<div class="span10">
				<p><a href="mailto:<?=$h['email']; ?>"><?=$h['firstname']." ".$h['lastname']; ?></a> changed the <a href="#modal<?=$h['id']; ?>" role="button" data-toggle="modal"><strong><?=$h['column'];?></strong></a> on <?=$h['date']; ?></p>
			</div>
		</div>
		<!-- Modal -->
		<div id="modal<?=$h['id']; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="modallabel<?=$h['id']; ?>" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="modallabel<?=$h['id']; ?>">Change to <?=$h['column'];?></h3>
			</div>
				<div class="modal-body">
					<h4>Old value</h4>
					<p><?=$h['from']; ?></p>
					<hr />
					<h4>New value</h4>
					<p><?=$h['to']; ?></p>
				</div>
			<div class="modal-footer">
				<p class="pull-left"><i>Change made by <?=$h['firstname']." ".$h['lastname']; ?> on <?=$h['date']; ?></i></p>
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			</div>
		</div>
		
	<? endforeach ?>
	
	<div class="row">
		<div class="span10">
			<hr />
			<h4>Comments</h4>
		</div>
	</div>

		<? foreach ($comments as $q): ?>
			<div class="row">
				<div class="span5 pull-left"><a href="mailto:<?=$q['email']; ?>"><?=$q['firstname']." ".$q['lastname']; ?></a></div>
				<div class="span5 pull-right"><?=$q['cDate']; ?></div>
			</div>
			<div class="row">
				<div class="span10"><?=$q['comment']; ?>
					<br />
					<hr />	
				</div>
			</div>
		<? endforeach ?>
		<div class="row">
			<div class="span10">
			<?=form_open('home/createComment'); ?>
			<?=form_hidden('issueId',$issue['id']);?>
			<?
			$desc = array( 'name'=> 'comment', 'class' => 'span10', 'placeholder' => 'Enter new comment here...' );
				echo form_textarea($desc);
			?>
			<?= form_submit('commentMake', 'Submit Comment');?>
			<?= form_fieldset_close();?>
			<?= form_close();?>
			</div>
		</div>
		
</div>

<script>
	$('[name="commentMake"]').addClass('btn btn-primary');
	$('.modal').modal({
	show: false
	});
</script>