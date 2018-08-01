<?php
class ClosePanel extends CWidget {
    public $eventId = NULL;
    
    public function run() {
        echo '<div id="closePanel" class="panel panel-info"><div class="panel-heading"><b>Close Panel</b></div><div class="panel-body">';
        echo '<button name="closeSubmit" class="btn btn-primary" onclick="closePanel(' . $this->eventId . ');">Close Panel</button>';
        echo '</div></div>';
    }
}
?>