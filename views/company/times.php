<div id="times">
	<?php if ($schedule): ?>
		<div id="today" value="<?=date('Y-m-d'); ?>" style="display: none;"></div>
		<?php for ($i = 0; $i < count($newTimes); $i++): ?>
		<?php $today = date('Y-m-d') . ' ' . $newTimes[$i]; ?>
			<?php if (in_array($today, $times)): ?>
				<?php $key = array_search($today, $times); ?>
				<?php if ($schedule[$key]['booked'] == 1): ?>
					<div id="<?=$schedule[$key]['id']; ?>" class="timestamp booked" value="<?=date('H:i:s', strtotime($schedule[$key]['timestamp'])); ?>"><?=date('H:i:s', strtotime($schedule[$key]['timestamp'])); ?> <?=$schedule[$key]['first_name'] . ' ' . $schedule[$key]['last_name']; ?></div>
				<?php else: ?>
					<div id="<?=$schedule[$key]['id']; ?>" class="timestamp free" value="<?=date('H:i:s', strtotime($schedule[$key]['timestamp'])); ?>"><?=date('H:i:s', strtotime($schedule[$key]['timestamp'])); ?> <span class="ion-android-remove"></span></div>
				<?php endif; ?>
			<?php else: ?>
				<div class="timestamp" value="<?=$newTimes[$i]; ?>"><?=$newTimes[$i]; ?> <span class="ion-android-add"></span></div>
			<?php endif; ?>
		<?php endfor; ?>
	<?php else: ?>
		<div id="today" value="<?=date('Y-m-d'); ?>" style="display: none;"></div>
		<?php foreach($newTimes as $newTime): ?>
			<div class="timestamp" value="<?=$newTime; ?>"><?=$newTime; ?> <span class="ion-android-add"></span></div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
<div id="calendar"></div>