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
		echo $user['name'] . ($user['alias'] ? ' (' . $user['alias'] . ') - ' : ' - ') . $user['email'] . ' - ' . $user['phone'];
		echo '<br />';
	}
	
	echo '</p>';
}
?>