<?php if ($times): ?>
	<div id="today" value="<?=date('Y-m-d', strtotime($times[0]['timestamp'])); ?>" style="display: none;"></div>
	<?php foreach($times as $time): ?>
		<div id="<?=$time['id']; ?>" class="timestamp"><?=date('H:i:s', strtotime($time['timestamp'])); ?></div>
	<?php endforeach; ?>
<?php endif; ?>