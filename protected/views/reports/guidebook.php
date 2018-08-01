<?php
// disable caching
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    // force download  
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename=guidebook_export_" . date("Y-m-d") . ".csv");
    header("Content-Transfer-Encoding: binary");
?>

Session Title,Date,Time Start,Time End,Room/Location,Schedule Track (Optional),Description (Optional)
<?php
$events = Event::getEvents();
$rooms = Rooms::getRooms();
$sections = PanelHelper::getSections(TRUE);
$data = array();
foreach ($events as $event) {
	if (!$event['closed']) {
		continue;
	}
	$schedule = Schedule::getEventSchedule($event['id']);
	if (empty($schedule)) {
		continue;
	}
	
	$date = '';
	switch ($schedule['day']) {
		case 'Friday':
			$date = '5/27/2016';
			break;
		case 'Saturday':
			$date = '5/28/2016';
			break;
		case 'Sunday':
			$date = '5/29/2016';
			break;
	}
	$time = $schedule['time'];
	$start = date('h:i:s A', strtotime($time));
	
	$time += ($schedule['hours'] * 100);
	$time = ($time > 2400) ? $time - 2400 : $time;
	$time = ($time < 1000) ? '0' . $time : $time;
	$end = date('h:i:s A', strtotime($time));
		
	$room = $rooms[$schedule['room_id']];
	echo '"' . $event['name'] . ($event['adult'] ? ' (18+)' : '') . '",' . $date . ',' . $start . ',' . $end . ',' . $room['name'] . ',' . $sections[$event['section']] . ',"' . $event['description'] . '"' . "\n";
}
?>