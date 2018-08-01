<?php
class PanelComments extends CWidget {
    public $eventId;

    public function run() {
        $panelists = Registration::getUsersByEvent($this->eventId);
        echo '<div id="panelists" class="panel panel-info"><div class="panel-heading"><b>Comments</b></div><div class="panel-body">';
        echo '<table>';

        $count = 0;
        foreach ($panelists as $panelist) {
            if (empty($panelist['comments'])) {
            	continue;
            }
            $user = Profile::search('userid', $panelist['userid']);
            if (!empty($user)) {
                $count++;
                
                echo '<tr><td>';

                echo '<b>' . $user['name'];
                if (!empty($user['alias'])) {
                    echo ' (' . $user['alias'] . ')';
                }
                echo '</b>';
                echo '</td><td>';
		echo $panelist['comments'];
                echo '</td></tr>';
            }
        }
        if ($count == 0) {
        	echo 'No comments';
        }

        echo '</table></div></div>';
    }
}
?>