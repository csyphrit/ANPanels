<?php
class DeletePanel extends CWidget {
    public $eventId = NULL;
    
    public function run() {
        echo '<div id="deletePanel" class="panel panel-info"><div class="panel-heading"><b>Delete Panel</b></div><div class="panel-body">';
        echo '<button class="btn btn-danger" name="deleteSubmit" onclick="deletePanel(' . $this->eventId . ');">Delete Panel</button>';
        echo '</div></div>';
    }
}
?>