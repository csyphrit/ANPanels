<?php
class SchedulePanel extends CWidget {
    public $eventId;

    public function run() {
        $rooms = Rooms::getRooms();
        echo '<div id="schedulePanel" class="panel panel-info"><div class="panel-heading"><b>Schedule Panel</b></div><div class="panel-body form">';

        $schedule = Schedule::getEventSchedule($this->eventId);
        if (!empty($schedule)) {
            echo $schedule['day'] . ' at ' . date("g:i a", strtotime($schedule['time'])) . ' (' . $schedule['time'] .  ')' . ' in ' . $rooms[$schedule['room_id']]['name'];
        }

        echo '<form action="' . Yii::app()->baseUrl . '/index.php/admin/schedule" method="post">';
        echo '<input type="hidden" name="eventId" value="' . $this->eventId . '" />';
        echo '<b>Hours:</b> <input type="text" class="form-control" name="hours" value="' . (isset($schedule['hours']) ? $schedule['hours'] : 1) . '" /><br />';
        echo '<b>Room:</b> <select name="roomId" class="form-control">';
        foreach ($rooms as $room) {
            echo '<option value=' . $room['id'] . '>' . $room['name'] .  ' (' . $room['building'] . ')</option>';
        }
        echo '</select><br />';
        echo '<button type="submit" class="btn btn-primary" name="scheduleSubmit">Schedule</button>';

        echo '</form></div></div>';
    }
}
?>