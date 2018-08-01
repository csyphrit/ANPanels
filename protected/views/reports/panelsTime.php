<h3>Panels by time</h3>
<?php
$rooms = Rooms::getRooms();
$events = Schedule::getEventsByTime();
$day = '';
$time = '';
foreach ($events as $schedule) {
	if ($schedule['day'] != $day) {
		$day = $schedule['day'];
		$time = '';
		echo '<h3>' . $day . '</h3>';
	}
	if ($schedule['time'] != $time) {
		$time = $schedule['time'];
		echo '<h4>' . $time . '</h4>';
	}

	$event = Event::searchBy('id', $schedule['event_id']);
	
	echo '<p>';
	echo '<b>' . $event['name'] . '</b><br />';
	echo $rooms[$schedule['room_id']]['building'] . ' - ' .$rooms[$schedule['room_id']]['name'] . '<br />';
	echo $event['description'];
	echo '</p>';
}
?>