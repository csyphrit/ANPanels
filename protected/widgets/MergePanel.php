<?php
class MergePanel extends CWidget {
    public function run() {
        $panels = Event::getEvents();
        echo '<div id="mergePanel" class="panel panel-info"><div class="panel-heading"><b>Merge Panels</b></div><div class="panel-body form" id="mergePanel">';
        echo '<select name="mergeId" class="form-control"><option values=""></option>';
        foreach ($panels as $panel) {
            echo '<option value=' . $panel['id'] . '>' . $panel['name'] . '</option>';
        }
        echo '</select>';
        echo '<button class="btn btn-primary" name="mergeSubmit" onclick="mergePanel();">Merge</button>';
        echo '</div></div>';
    }
}
?>