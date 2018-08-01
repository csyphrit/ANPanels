<?php
class Panelists extends CWidget {
    public $eventId;

    public function run() {
        $panelists = Registration::getUsersByEvent($this->eventId);
        echo '<div id="eventInfo" class="panel panel-info"><div class="panel-heading"><b>Panelists</b></div><div class="panel-body">';
        echo '<table>';

        $count = 0;
        foreach ($panelists as $panelist) {
            $user = Profile::search('userid', $panelist['userid']);
            if (!empty($user)) {
                $count++;
                
                echo '<tr><td>';

                if ($panelist['moderator']) {
                    echo '<b>';
                }
                echo '<a href="' . Yii::app()->baseUrl . '/index.php/admin/user/id/' . $user['userid'] . '">' . $user['name'];
                if (!empty($user['alias'])) {
                    echo ' (' . $user['alias'] . ')';
                }
                echo '</a>';
                if ($panelist['moderator']) {
                    echo '</b>';
                }
                echo '</td><td>';

                if ($panelist['confirmed']) {
                    echo ' <image onclick="unconfirmPanelist(' . $user['userid'] . ')" src="' . Yii::app()->baseUrl . '/themes/classic/images/remove.png" />';
                } else {
                    echo ' <image onclick="confirmPanelist(' . $user['userid'] . ')" src="' . Yii::app()->baseUrl . '/themes/classic/images/add.png" />';
                }

                echo '<image onclick="removePanelist(' . $user['userid'] . ')" src="' . Yii::app()->baseUrl . '/themes/classic/images/delete.png" />';

                if (!$panelist['moderator']) {
                    echo '<image onclick="promotePanelist(' . $user['userid'] . ')" src="' . Yii::app()->baseUrl . '/themes/classic/images/up.png" />';
                }
                echo '</td></tr>';
            }
        }

        if ($count == 0) {
            echo 'There are no panelists registered.';
        }

        echo '</table></div></div>';
    }
}
?>