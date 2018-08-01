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
    header("Content-Disposition: attachment;filename=excel_export_" . date("Y-m-d") . ".csv");
    header("Content-Transfer-Encoding: binary");

$friday = $saturday = $sunday = array();
$rooms = Rooms::getRooms();
foreach ($rooms as $room) {
	$events = Schedule::getRoomSchedule($room['id']);
	foreach ($events as $schedule) {
		$event = Event::searchBy('id', $schedule['event_id']);
		$schedule = Schedule::getEventSchedule($event['id']);
		$registration = Registration::getRegisteredEventCount($event['id'], 1);
		
		$name = $event['name'] . ($event['adult'] ? ' (18+)' : '')  . ' - ' . $registration;
		if ($event['av']) {
			$name .= ' (AV)';
		}
	
		if ($schedule['day'] == 'Friday') {
			$friday[$room['id']][$schedule['time']] = $name;
		} elseif ($schedule['day'] == 'Saturday') {
			$saturday[$room['id']][$schedule['time']] = $name;
		} elseif ($schedule['day'] == 'Sunday') {
			$sunday[$room['id']][$schedule['time']] = $name;
		}
	}
}
?>

Friday Afternoon
International Plaza
,Plaza C,Toronto,Montreal,Ottawa,Hamilton,Halton,Peel,Windsor,Mississauga
<?php
$room_order = array(31,5,8,4,3,9,44,2,14);
$times = array('1600' => '4:00pm', '1700' => '5:00pm', '1800' => '6:00pm', '1900' => '7:00pm', '2000' => '8:00pm');
foreach ($times as $key => $name) {
	echo $name . ',';
	foreach ($room_order as $room) {
		if (isset($friday[$room][$key])) {
			echo '"' . $friday[$room][$key] . '",';
		} else {
			echo ',';
		}
	}
	echo "\n";
}
?>
Sheraton
,Collingwood,Algonquin,Niagara
<?php
$s_room_order = array(6,7,1);
$times = array('1600' => '4:00pm', '1700' => '5:00pm', '1800' => '6:00pm', '1900' => '7:00pm', '2000' => '8:00pm');
foreach ($times as $key => $name) {
	echo $name . ',';
	foreach ($s_room_order as $room) {
		if (isset($friday[$room][$key])) {
			echo '"' . $friday[$room][$key] . '",';
		} else {
			echo ',';
		}
	}
	echo "\n";
}
?>

Friday Night
International Plaza
,Plaza C,Toronto,Montreal,Ottawa,Hamilton,Halton,Peel,Windsor,Mississauga
<?php
$times = array('2100' => '9:00pm', '2200' => '10:00pm', '2300' => '11:00pm', '2400' => 'midnight');
foreach ($times as $key => $name) {
	echo $name . ',';
	foreach ($room_order as $room) {
		if (isset($friday[$room][$key])) {
			echo '"' . $friday[$room][$key] . '",';
		} else {
			echo ',';
		}
	}
	echo "\n";
}
?>
Sheraton
,Collingwood,Algonquin,Niagara
<?php
$times = array('2100' => '9:00pm', '2200' => '10:00pm', '2300' => '11:00pm', '2400' => 'midnight');
foreach ($times as $key => $name) {
	echo $name . ',';
	foreach ($s_room_order as $room) {
		if (isset($friday[$room][$key])) {
			echo '"' . $friday[$room][$key] . '",';
		} else {
			echo ',';
		}
	}
	echo "\n";
}
?>

Saturday Morning
International Plaza
,Plaza C,Toronto,Montreal,Ottawa,Hamilton,Halton,Peel,Windsor,Mississauga
<?php
$times = array('1000' => '10:00am', '1100' => '11:00am', '1200' => '12:00pm', '1300' => '1:00pm', '1400' => '2:00pm');
foreach ($times as $key => $name) {
	echo $name . ',';
	foreach ($room_order as $room) {
		if (isset($saturday[$room][$key])) {
			echo '"' . $saturday[$room][$key] . '",';
		} else {
			echo ',';
		}
	}
	echo "\n";
}
?>
Sheraton
,Collingwood,Algonquin,Niagara
<?php
$times = array('1000' => '10:00am', '1100' => '11:00am', '1200' => '12:00pm', '1300' => '1:00pm', '1400' => '2:00pm');
foreach ($times as $key => $name) {
	echo $name . ',';
	foreach ($s_room_order as $room) {
		if (isset($saturday[$room][$key])) {
			echo '"' . $saturday[$room][$key] . '",';
		} else {
			echo ',';
		}
	}
	echo "\n";
}
?>

Saturday Afternoon
International Plaza
,Plaza C,Toronto,Montreal,Ottawa,Hamilton,Halton,Peel,Windsor,Mississauga
<?php
$times = array('1500' => '3:00pm', '1600' => '4:00pm', '1700' => '5:00pm', '1800' => '6:00pm', '1900' => '7:00pm');
foreach ($times as $key => $name) {
	echo $name . ',';
	foreach ($room_order as $room) {
		if (isset($saturday[$room][$key])) {
			echo '"' . $saturday[$room][$key] . '",';
		} else {
			echo ',';
		}
	}
	echo "\n";
}
?>
Sheraton
,Collingwood,Algonquin,Niagara
<?php
$times = array('1500' => '3:00pm', '1600' => '4:00pm', '1700' => '5:00pm', '1800' => '6:00pm', '1900' => '7:00pm');
foreach ($times as $key => $name) {
	echo $name . ',';
	foreach ($s_room_order as $room) {
		if (isset($saturday[$room][$key])) {
			echo '"' . $saturday[$room][$key] . '",';
		} else {
			echo ',';
		}
	}
	echo "\n";
}
?>

Saturday Night
International Plaza
,Plaza C,Toronto,Montreal,Ottawa,Hamilton,Halton,Peel,Windsor,Mississauga
<?php
$times = array('2000' => '8:00pm', '2100' => '9:00pm', '2200' => '10:00pm', '2300' => '11:00pm', '2400' => 'midnight');
foreach ($times as $key => $name) {
	echo $name . ',';
	foreach ($room_order as $room) {
		if (isset($saturday[$room][$key])) {
			echo '"' . $saturday[$room][$key] . '",';
		} else {
			echo ',';
		}
	}
	echo "\n";
}
?>
Sheraton
,Collingwood,Algonquin,Niagara
<?php
$times = array('2000' => '8:00pm', '2100' => '9:00pm', '2200' => '10:00pm', '2300' => '11:00pm', '2400' => 'midnight');
foreach ($times as $key => $name) {
	echo $name . ',';
	foreach ($s_room_order as $room) {
		if (isset($saturday[$room][$key])) {
			echo '"' . $saturday[$room][$key] . '",';
		} else {
			echo ',';
		}
	}
	echo "\n";
}
?>

Sunday Morning
International Plaza
,Plaza C,Toronto,Montreal,Ottawa,Hamilton,Halton,Peel,Windsor,Mississauga
<?php
$times = array('900' => '9:00am', '1000' => '10:00am', '1100' => '11:00am', '1200' => '12:00pm', '1300' => '1:00pm');
foreach ($times as $key => $name) {
	echo $name . ',';
	foreach ($room_order as $room) {
		if (isset($sunday[$room][$key])) {
			echo '"' . $sunday[$room][$key] . '",';
		} else {
			echo ',';
		}
	}
	echo "\n";
}
?>
Sheraton
,Collingwood,Algonquin,Niagara
<?php
$times = array('900' => '9:00am', '1000' => '10:00am', '1100' => '11:00am', '1200' => '12:00pm', '1300' => '1:00pm');
foreach ($times as $key => $name) {
	echo $name . ',';
	foreach ($s_room_order as $room) {
		if (isset($sunday[$room][$key])) {
			echo '"' . $sunday[$room][$key] . '",';
		} else {
			echo ',';
		}
	}
	echo "\n";
}
?>

Sunday Afternoon
International Plaza
,Plaza C,Toronto,Montreal,Ottawa,Hamilton,Halton,Peel,Windsor,Mississauga
<?php
$times = array('1400' => '2:00pm', '1500' => '3:00pm', '1600' => '4:00pm', '1700' => '5:00pm', '1800' => '6:00pm');
foreach ($times as $key => $name) {
	echo $name . ',';
	foreach ($room_order as $room) {
		if (isset($sunday[$room][$key])) {
			echo '"' . $sunday[$room][$key] . '",';
		} else {
			echo ',';
		}
	}
	echo "\n";
}
?>
Sheraton
,Collingwood,Algonquin,Niagara
<?php
$times = array('1400' => '2:00pm', '1500' => '3:00pm', '1600' => '4:00pm', '1700' => '5:00pm', '1800' => '6:00pm');
foreach ($times as $key => $name) {
	echo $name . ',';
	foreach ($s_room_order as $room) {
		if (isset($sunday[$room][$key])) {
			echo '"' . $sunday[$room][$key] . '",';
		} else {
			echo ',';
		}
	}
	echo "\n";
}
?>