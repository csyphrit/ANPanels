<?php
/**
 * Show current user's confirmed panels
 */

class PanelistSchedule extends CWidget {
    public $user = NULL;

    /**
     * Create the widget
     */
    public function run() {
        $user = isset($this->user) ? $this->user : UserHelper::getCurrentUser();
        $panels = PanelHelper::getUserPanels(TRUE, $user);
        $rooms = Rooms::getRooms();
        
	$count = 0;
        foreach ($panels as $panel) {
            $schedule = $panel->schedule;
            if (empty($schedule)) {
                continue;
            }
            $count++;
                
            $room = $rooms[$schedule['room_id']];
            echo '<div class="panel panel-default">';
            echo '<div class="panel-heading">' . $panel->name;
            if ($panel->adult) {
                echo ' (18+)';
            }
            echo '</div><div class="panel-body">';
            echo '<span class="schedule"><strong>' . PanelHelper::formatSchedule($schedule) . '</strong> in ' . $room['name']. ' (' . $room['building'] . ')</span>';
            echo '<span class="description"><em>' . $panel->description . '</em></span>';
            echo '</div></div>';
        }
        
        if ($count == 0) {
            echo 'No schedule data available.';
        }
    }
} 