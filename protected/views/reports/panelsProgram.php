<?php
$rooms = Rooms::getRooms();
$day = '';
foreach ($rooms as $room) {
	$events = Schedule::getRoomSchedule($room['id']);
	if (count($events) < 1) {
		continue;
	}

	echo '<h3>' . $room['name'] . ' (' . $room['building'] . ')</h3>';

	foreach ($events as $schedule) {
		if ($schedule['day'] != $day) {
			$day = $schedule['day'];
			echo '<h4>' . $day . '</h4>';
		}
	
		$event = Event::searchBy('id', $schedule['event_id']);
		echo '<p>';
		$time = $schedule['time'];
		echo  DATE("g:i a", STRTOTIME($time)) . ' <b>' . $event['name'] . ($event['adult'] ? ' (18+)' : '') . '</b><br />';
		echo $event['description'];
		echo '</p>';
	}
	
	echo '</p>';
}
?>