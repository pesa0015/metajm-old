<h1>Tider</h1>
<div id="calendar"></div>
<div id="times">
	<input type="hidden" id="today" value="<?=date('Y-m-d'); ?>">
	<?php if ($schedule): ?>
		<?php for ($i = 0; $i < count($newTimes); $i++): ?>
		<?php $today = date('Y-m-d') . ' ' . $newTimes[$i]; ?>
			<?php if (in_array($today, $times)): ?>
				<?php $key = array_search($today, $times); ?>
				<?php if ($schedule[$key]['booked'] == 1): ?>
					<div id="<?=$schedule[$key]['id']; ?>" class="timestamp minus booked" value="<?=date('H:i:s', strtotime($schedule[$key]['timestamp'])); ?>"><?=date('H:i', strtotime($schedule[$key]['timestamp'])); ?> <?=$schedule[$key]['first_name'] . ' ' . $schedule[$key]['last_name']; ?></div>
				<?php else: ?>
					<div id="<?=$schedule[$key]['id']; ?>" class="timestamp minus free" value="<?=date('H:i:s', strtotime($schedule[$key]['timestamp'])); ?>"><?=date('H:i', strtotime($schedule[$key]['timestamp'])); ?> <span class="ion-android-remove"></span></div>
				<?php endif; ?>
			<?php else: ?>
				<div class="timestamp plus" value="<?=$newTimes[$i]; ?>"><?=substr($newTimes[$i],0,5); ?> <span class="ion-ios-plus-outline"></span></div>
			<?php endif; ?>
		<?php endfor; ?>
	<?php else: ?>
		<?php foreach($newTimes as $newTime): ?>
			<div class="timestamp plus" value="<?=$newTime; ?>"><?=date('H:i', $newTime); ?> <span class="ion-ios-plus-outline"></span></div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>