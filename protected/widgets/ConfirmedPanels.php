<?php
/**
 * Show current user's confirmed panels
 */

class ConfirmedPanels extends CWidget {
    public $admin = FALSE;
    public $user = NULL;

    /**
     * Create the widget
     */
    public function run() {
        $panels = PanelHelper::getUserPanels(TRUE, $this->user);
        echo '<div id="confirmedPanels" class="panel panel-info">';

        echo '<div class="panel-heading">Confirmed Panels</div><div class="panel-body">';
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
                    echo '</div><div class="panel-body">';
                    echo '<span class="description">' . $panel->description . '</span>';
                    echo '</div></div>';
                }
            }
        } else {
            echo 'You have no confirmed panels.';
        }

        echo '</div></div>';
    }
} 