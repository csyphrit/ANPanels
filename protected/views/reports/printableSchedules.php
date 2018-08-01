<style>
p {
  page-break-after: always;
}
</style>
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
	
		$html .= $event['name'] . ($event['adult'] ? ' (18+)' : '') . ' - ';
		$html .= $schedule['day'] . ' at ' . $schedule['time'] . ' in ' . $rooms[$schedule['room_id']]['name'] . ' (' . $rooms[$schedule['room_id']]['building'] . ')<br /><br /><br /><br /><br /><br />';
	}
	if ($count == 0) {
		continue;
	}
	
	echo '<p>';
	echo '<b>' . ($user['alias'] ? $user['alias'] : $user['name']) . '</b><br /><br />';
	echo 'If you have problems with your panels, Fingers can be reached via email or phone (647-688-2542).<br /><br />';
	echo $html;	
	echo '</p>';
}
?>