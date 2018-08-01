<h3>Open YN Panels</h3>
<?php
$events = Event::getEvents(6);
foreach ($events as $event) {
	if ($event['closed']) {
		continue;
	}
	$panelists = Registration::getUsersByEvent($event['id']);
	
	if (count($panelists) >= 4) {
		continue;
	}

	echo '<p>';
	echo '<b>' . $event['name'] . '</b><br />';
	echo $event['description'];	
	echo '</p>';
}
?>