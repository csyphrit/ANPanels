<?php
class AddPanelist extends CWidget {
    public function run() {
        $panelists = Profile::getUsers();
        echo '<div class="panel panel-info"><div class="panel-heading"><b>Add Panelists</b></div><div class="panel-body form" id="addPanelist">';
        echo '<select name="userid" class="form-control"><option value=0></option>';
        foreach ($panelists as $panelist) {
            echo '<option value=' . $panelist['userid'] . '>' . $panelist['name'] .  ' (' . $panelist['email'] . ')</option>';
        }
        echo '</select> ';
        echo '<button name="addSubmit" class="btn btn-primary" onclick="addPanelist();">Add</button>';
        echo '</div></div>';
    }
}
?>