<h1>Dagens händelser</h1>
<div id="card-container">
	<?php if ($todos): ?>
		<?php $i = 0; ?>
		<?php foreach($todos as $todo): ?>
			<div class="card card-<?=($i % 2 == 0) ? 'even' : 'odd'; ?>">
				<div class="card-top">
					<div class="service-name"><?=$todo['name']; ?></div>
					<div class="time">
						<i class="ion-ios-clock-outline"></i>
						<span><?=date('H:i', strtotime($todo['start'])) . ' - ' . date('H:i', strtotime($todo['end'])); ?></span>
					</div>
					<div class="style-info">
						<div class="stylists">
							<div><i class="ion-person"></i></div>
							<div><?=$todo['stylists_f_name'] . ' ' . $todo['stylists_l_name']; ?></div>
						</div>
					</div>
				</div>
				<div class="card-bottom">
					<div class="customer">
						<div class="customer-name">
							<div><i class="ion-android-happy"></i><span><?=$todo['customer_f_name'] . ' ' . $todo['customer_l_name']; ?></span></div>
						</div>
						<div class="customer-mail">
							<div><i class="ion-ios-email"></i></div>
							<div><?=$todo['mail']; ?></div>
						</div>
						<div class="customer-tel">
							<div><i class="ion-ios-telephone"></i></div>
							<div><?=$todo['tel']; ?></div>
						</div>
					</div>
				</div>
			</div>
		<?php $i++; ?>
		<?php endforeach; ?>
	<?php else: ?>
		<h3>Det finns inga bokningar idag.</h3>
	<?php endif; ?>
</div>