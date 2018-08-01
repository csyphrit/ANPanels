<h3>Panelist Unavailability</h3>
<?php
$events = Event::getEvents();
foreach ($events as $event) {
	if (!$event['closed']) {
		continue;
	}
	
	$panelists = Registration::getUsersByEvent($event['id']);

	echo '<p>';
	echo '<b>' . $event['name'] . '</b><br />';
	
	foreach ($panelists as $user) {
		if (!$user['confirmed']) {
			continue;
		}
		$user = Profile::search('userid', $user['userid']);
		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		echo $user['alias'] ? $user['alias'] : $user['name'];
		if ($user['unavailable']) {
			echo ' - <i>' . $user['unavailable'] . '</i>';
		}
		echo '<br />';
	}
	
	echo '</p>';
}
?>