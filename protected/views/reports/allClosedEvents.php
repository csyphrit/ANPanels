<h3>All Closed Events</h3>
<?php
$events = Event::getEvents();
foreach ($events as $event) {
	if (!$event['closed']) {
		continue;
	}
	$panelists = Registration::getUsersByEvent($event['id']);

	echo '<p>';
	echo '<b>' . $event['name'] . ($event['adult'] ? ' (18+)' : '') . '</b><br />';
	
	foreach ($panelists as $user) {
		if (!$user['confirmed']) {
			continue;
		}
		$user = Profile::search('userid', $user['userid']);
		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		echo $user['alias'] ? $user['alias'] : $user['name'];
		echo '<br />';
	}
	
	echo '</p>';
}
?>