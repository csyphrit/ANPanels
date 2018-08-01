<?php
/**
 * Show current user's registered panels
 */

class AttendingPanels extends CWidget {
    public $admin = FALSE;
    public $user = NULL;
    
    public function run() {
        $panels = PanelHelper::getUserUnavailablePanels($this->user);
        echo '<div class="panel panel-info"><div class="panel-heading"><b>Attending Panels</b></div><div class="panel-body">';
        if (count($panels)) {
            foreach ($panels as $panel) {
            if ($this->admin) {
                    echo '<a href="' . Yii::app()->baseUrl . '/index.php/admin/event/id/' . $panel->id . '">' . $panel->name . '</a><br />';
                } else {
                    echo '<div class="panel panel-default">';
                    echo '<div class="panel-heading">' . $panel->name;
                    if ($panel->adult) {
                        echo ' (18+)';
                    }
                    echo '</div><div class="panel-body">' . $panel->description . '</span>';
                    echo '</div></div>';
                }
            }
        } else {
            echo 'You are not listed as attending any panels.';
        }

        echo '</div></div>';
    }
} 