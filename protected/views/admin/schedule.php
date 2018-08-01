<?php
/**
 * @var integer $eventId
 * @var integer $roomId
 * @var integer $hours
 */
$panelists = Registration::getUsersByEvent($eventId);
$schedule = array();
$pschedule = array();
$rooms = Rooms::getRooms();
$days = array('Friday', 'Saturday', 'Sunday');
?>
<b>Unavailability:</b><br />
<div class="unavailable">
    <table>
        <?php
        foreach ($panelists as $panelist) {
            $user = UserHelper::getUserById($panelist['userid']);
            if (!is_object($user) || !is_object($user->profile)) {
                continue;
            }
            echo '<tr><td><b>' . $user->profile->name . '</b></td><td>' . $user->profile->unavailable . '</td></tr>';
            $panels = PanelHelper::getUserPanels(TRUE, $user);
            foreach ($panels as $panel) {
                $sched = Schedule::getEventSchedule($panel->id);
                if (empty($sched)) {
                    continue;
                }
                $pschedule[$sched['day']][$sched['time']] = $user->profile->name;

            }
        }
        ?>
    </table>
</div>

<div class="rooms">
    <?php
    $building = '';
    foreach ($rooms as $room) {
        $roomSchedule = Schedule::getRoomSchedule($room['id']);
        foreach ($roomSchedule as $sched) {
            $schedule[$room['id']][$sched['day']][$sched['time']] = $sched['event_id'];
        }
        if ($room['building'] != $building) {
            $building = $room['building'];
            echo '<div style="clear:both"></div><br /><a onclick="showBuilding(\'' . $building . '\');">Show ' . $building . '</a>';
        }
        
        echo '<a';
        if ($room['id'] == $roomId) {
        	echo ' class="selected"';
        }
        echo ' id="room' . $room['id']. '" onclick="switchRoom(' . $room['id'] . ');">' . $room['name'] . ' (' . $room['building'] . ')</a>';
    }
    ?>
    <div style="clear:both"></div><br />
    <a onclick="showAll();">Show All</a>
    <div style="clear:both"></div><br />
</div>
<?php
foreach ($rooms as $room) {
    echo '<div id="' . $room['id'] . '" class="room ' . $room['building'] . '"><h3 align="center">' . $room['name'] . ' (' . $room['building'] . ')</h3>';
    echo '<table border=1><tr><th></th><th>Friday</th><th>Saturday</th><th>Sunday</th><th></th></tr>';
    for ($i = 9; $i <= 24; $i++) {
    	$time = $i > 9 ? $i . '00' : '0' . $i . '00';
    	$time2 = $i > 9 ? $i . '30' : '0' . $i . '30';
		$j = $i - 1;
    	$time3 = $j > 9 ? $j . '30' : '0' . $j . '30';
        echo '<tr><td><b>' . date("g:i a", strtotime($time)) . ' (' . $time .  ')' . '</b></td>';
        foreach ($days as $day) {
            echo '<td>';
            if (isset($schedule[$room['id']][$day][$time])) {
                $event = PanelHelper::getEventById($schedule[$room['id']][$day][$time]);
                if (is_object($event)) {
                   echo $event->name;
                } else {
                    echo 'ERROR: ' . $schedule[$room['id']][$day][$time];
                }
            } elseif (isset($schedule[$room['id']][$day][$time3])) {
                $event = PanelHelper::getEventById($schedule[$room['id']][$day][$time3]);
                if (is_object($event)) {
                   echo $event->name;
                } else {
                    echo 'ERROR: ' . $schedule[$room['id']][$day][$time3];
                }
            } elseif (isset($pschedule[$day][$time3])) {
                echo $pschedule[$day][$time3];
            } elseif (isset($pschedule[$day][$time])) {
                echo $pschedule[$day][$time];
            } elseif (($day == 'Friday' && $i > 13) || ($day == 'Saturday') || ($day == 'Sunday' && $i < 18)) {
               echo '<a class="button" onclick="scheduleEvent(' . $eventId . ',' . $room['id'] . ",'" . $day . "','" . ($i < 10 ? '0' : '') . $i . '00\',' . $hours . ');">Schedule</a>';
            }
            echo '</td>';
        }
        echo '<td><b>' . date("g:i a", strtotime($time)) . ' (' . $time .  ')' . '</b></td>';
        echo '</tr>';
        echo '<tr><td><b>' . date("g:i a", strtotime($time2)) . ' (' . $time2 .  ')' . '</b></td>';
        foreach ($days as $day) {
            echo '<td>';
            if (isset($schedule[$room['id']][$day][$time2])) {
                $event = PanelHelper::getEventById($schedule[$room['id']][$day][$time2]);
                if (is_object($event)) {
                   echo $event->name;
                } else {
                    echo 'ERROR: ' . $schedule[$room['id']][$day][$time2];
                }
            } elseif (isset($schedule[$room['id']][$day][$time])) {
                $event = PanelHelper::getEventById($schedule[$room['id']][$day][$time]);
                if (is_object($event)) {
                   echo $event->name;
                } else {
                    echo 'ERROR: ' . $schedule[$room['id']][$day][$time];
                }
            } elseif (isset($pschedule[$day][$time])) {
                echo $pschedule[$day][$time];
            } elseif (isset($pschedule[$day][$time2])) {
                echo $pschedule[$day][$time2];
            } elseif (($day == 'Friday' && $i > 13) || ($day == 'Saturday') || ($day == 'Sunday' && $i < 18)) {
               echo '<a class="button" onclick="scheduleEvent(' . $eventId . ',' . $room['id'] . ",'" . $day . "','" . ($i < 10 ? '0' : '') . $i . '30\',' . $hours . ');">Schedule</a>';
            }
            echo '</td>';
        }
        echo '<td><b>' . date("g:i a", strtotime($time2)) . ' (' . $time2 .  ')' . '</b></td>';
        echo '</tr>';
    }
    echo '</table></div>';
}
?>
<script>
    function switchRoom(id) {
        $('.room').hide();
        $('a').removeClass('selected');
        $('#' + id).show();
        $('#room' + id).addClass('selected');
    }
    function showAll() {
        $('.room').show();
        $('a').removeClass('selected');
    }
    function showBuilding(building) {
        $('.room').hide();
        $('a').removeClass('selected');
        $('.' + building).show();
    }
    function scheduleEvent(eventId, roomId, day, time, hours) {
        $.ajax({
            type: "POST",
            url:    "<?php echo Yii::app()->createUrl('admin/schedulePanel'); ?>",
            data:  {
                eventid: eventId,
                roomid: roomId,
                day: day,
                time: time,
                hours: hours
            },
            success: function(){
                window.location = '<?php echo Yii::app()->createUrl('admin/event/', array('id' => $eventId)); ?>';
            },
            error: function(){
                alert("Unable to schedule event");
            }
        });
        return false;
    }
    $(document).ready(function() {
        switchRoom(<?=$roomId; ?>);
    });
</script>
