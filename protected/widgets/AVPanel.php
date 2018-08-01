<?php
class AVPanel extends CWidget {
    public $eventId = NULL;
    
    public function run() {
        $event = PanelHelper::getEventById($this->eventId);
        if ($event->av_requested) {
            echo '<div id="avPanel" class="panel panel-info"><div class="panel-heading"><b>Approve/Deny AV</b></div><div class="panel-body">';
            echo '<button name="approve" class="btn btn-success" onclick="approveAV(' . $this->eventId . ');">Approve</button>';
            echo '<button name="deny" class="btn btn-danger" onclick="deletePanel(' . $this->eventId . ');">Deny</button>';
            echo '</div></div>';
        }
    }
}
?>