<h3>Panels by Panelists</h3>
<?php
$users = Profile::getUsers();
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
		$count++;
		$event = Event::searchBy('id', $eventData['eventid']);
	
		$html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $event['name'] . '<br />';
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