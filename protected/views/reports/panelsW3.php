<h3>Open Events With 3 Panelists</h3>
<?php
$events = Event::getEvents();
foreach ($events as $event) {
	if ($event['closed']) {
		continue;
	}
	$panelists = Registration::getUsersByEvent($event['id']);
	
	if (count($panelists) != 3) {
		continue;
	}

	echo '<p>';
	echo '<b>' . $event['name'] . '</b><br />';
	
	foreach ($panelists as $user) {
		$user = Profile::search('userid', $user['userid']);
		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		echo $user['alias'] ? $user['alias'] : $user['name'];
		echo '<br />';
	}
	
	echo '</p>';
}
?>