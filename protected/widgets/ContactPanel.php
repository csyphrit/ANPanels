<?php
class ContactPanel extends CWidget {
    public $eventId;

    public function run() {
        $count = 0;
        $emails = '';
        $panelists = Registration::getUsersByEvent($this->eventId);
        echo '<div id="contactPanel" class="panel panel-info"><div class="panel-heading"><b>Contact Panel</b></div><div class="panel-body">';

        foreach ($panelists as $panelist) {
            $user = Profile::search('userid', $panelist['userid']);
            if (!empty($user)) {
            	if (!$panelist['confirmed']) {
            		continue;
            	}
            	
                $count++;
                $emails .= $user['email'] . ', ';
            }
        }

        if ($count == 0) {
            echo 'There are no panelists confirmed.';
        } else {
           echo '<textarea cols="49" rows="5" class="form-control">' . $emails . '</textarea>';
        }
        echo '</div></div>';
    }
}
?>