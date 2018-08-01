<h3>Compact Schedules</h3>
<?php
$users = Profile::getUsers();
$rooms = Rooms::getRooms();
foreach ($users as $user) {
	$events = Registration::getEventsByUser($user['userid']);
	if (count($events) < 1) {
		continue;
	}
	
	$html = '';
	$count = 0;
	foreach ($events as $eventData) {
		if (!$eventData['confirmed']) {
			continue;
		}
		$event = Event::searchBy('id', $eventData['eventid']);
		$schedule = Schedule::getEventSchedule($event['id']);
		if (empty($schedule)) {
			continue;
		}
		$count++;
	
		$html .= '<p>' . $event['name'] . ($event['adult'] ? ' (18+)' : '') . '<br />';
		$html .= $schedule['day'] . ' at ' . $schedule['time'] . ' in ' . $rooms[$schedule['room_id']]['name'] . ' (' . $rooms[$schedule['room_id']]['building'] . ')<br />';
		$html .= $event['description'] . '</p>';
	}
	if ($count == 0) {
		continue;
	}
	
	echo '<p>';
	echo '<b>' . ($user['alias'] ? $user['alias'] : $user['name']) . '</b><br />';
	echo $html;	
	echo '</p>';
}
?>