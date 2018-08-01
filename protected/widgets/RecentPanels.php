<?php
/**
 * Show five most recent panels
 */

class RecentPanels extends CWidget {
    /**
     * Create the widget
     */
    public function run() {
        $panels = Event::getMostRecentPanels();
        echo '<div id="recentPanels" class="panel panel-info"><div class="panel-heading"><b>Most Recent Suggested Panels</b></div><div class="panel-body">';
        if (count($panels)) {
            foreach ($panels as $panel) {
                echo '<a href="' . Yii::app()->baseUrl . '/index.php/admin/event/' . $panel['id'] . '">' . $panel['name'] . '</a><br />';
            }
        } else {
            echo 'No panels available.';
        }
        echo '</div></div>';
    }
} 