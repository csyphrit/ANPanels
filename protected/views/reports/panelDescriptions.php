<h3>Panel Descriptions</h3>
<?php
$events = Event::getEvents();
$rooms = Rooms::getRooms();
foreach ($events as $event) {
	if (!$event['closed']) {
		continue;
	}
	$schedule = Schedule::getEventSchedule($event['id']);

	echo '<p>';
	echo '<b>' . $event['name'] . ($event['adult'] ? ' (18+)' : '') . '</b><br />';
	if (!empty($schedule)) {
            echo $schedule['day'] . ' at ' . $schedule['time'] . ' in ' . $rooms[$schedule['room_id']]['name'] . ' (' . $rooms[$schedule['room_id']]['building'] . ')<br />';
        }
	echo $event['description'];	
	echo '</p>';
}
?>