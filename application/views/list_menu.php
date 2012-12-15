<div>
	<ul class="nav nav-pills">
	<? foreach ($lists as $L): ?>
		<li><?='<a href="'. site_url("home/index/".$L['id'] ."") .'">'. $L['name'] .'</a>'; ?></li>
	<? endforeach ?>
	</ul>
</div>