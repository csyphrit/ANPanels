<h3>Panels by Room</h3>
<?php
$rooms = Rooms::getRooms();
foreach ($rooms as $room) {
	echo '<p>';
	echo '<b>' . $room['name'] . ' (' . $room['building'] . ')</b><br />';

	$events = Schedule::getRoomSchedule($room['id']);
	foreach ($events as $schedule) {
		$event = Event::searchBy('id', $schedule['event_id']);
		$schedule = Schedule::getEventSchedule($event['id']);
	
		echo $event['name'] . ' - ' . $schedule['day'] . ' at ' . $schedule['time'] . '<br />';
	}
	
	echo '</p>';
}
?>