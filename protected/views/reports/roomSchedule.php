<?php
$schedule = array();
$rooms = Rooms::getRooms();
$days = array('Friday', 'Saturday', 'Sunday');

    foreach ($rooms as $room) {
        $roomSchedule = Schedule::getRoomSchedule($room['id']);
        foreach ($roomSchedule as $sched) {
            $schedule[$room['id']][$sched['day']][$sched['time']] = $sched['event_id'];
        }
    }

foreach ($rooms as $room) {
    echo '<div id="' . $room['id'] . '" class="room ' . $room['building'] . '"><h3 align="center">' . $room['name'] . ' (' . $room['building'] . ')</h3>';
    echo '<table border=1><tr><th></th><th>Friday</th><th>Saturday</th><th>Sunday</th></tr>';
    for ($i = 9; $i <= 24; $i++) {
    	$time = ($i > 9) ? $i . '00' : '0' . $i . '00';
        echo '<tr><td><b>' . $time . '</b></td>';
        foreach ($days as $day) {
            echo '<td>';
            if (isset($schedule[$room['id']][$day][$time])) {
                $event = PanelHelper::getEventById($schedule[$room['id']][$day][$time]);
                if (is_object($event)) {
                   echo $event->name . ($event['adult'] ? ' (18+)' : '');
                } 
            }
            echo '</td>';
        }
        echo '</tr>';
    }
    echo '</table></div>';
}
?>
<style>
table {
  page-break-after: always;
}
</style>