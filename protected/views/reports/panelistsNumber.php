<h3>Panelists by Number of Panels</h3>
<?php
$users = Profile::getUsers();
$ordered = array();
foreach ($users as $user) {
	$events = Registration::getEventsByUser($user['userid']);
	$count = count($events);
	if ($count < 1) {
		continue;
	}
	
	$ordered[$count][] = $user['alias'] ? $user['alias'] : $user['name'];
}
ksort($ordered);
foreach ($ordered as $num => $people) {
	echo '<b>' . $num . ' Panels</b> - ' . count($people) . '<br />';
	foreach ($people as $name) {
		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $name . '<br />';
	}
	echo '<br />';
}
?>