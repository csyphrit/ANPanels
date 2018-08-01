<?php
/**
 * Show current public panels
 */

class OpenPanels extends CWidget {
    public function run() {
        $panels = Event::getOpenEvents();
        $sections = PanelHelper::getSections();
        $userId = UserHelper::getCurrentUserId();
        
        $registered = array();
        $registeredPanels = PanelHelper::getUserPanels(FALSE, UserHelper::getCurrentUser());
        foreach ($registeredPanels as $panel) {
            $registered[] = $panel->id;
        }
        
        if (count($panels)) {
            echo '<div class="col-xs-12"><div id="openPanels" class="panel panel-info">';
            echo '<div class="panel-heading">' . Yii::t('site', 'OPEN_PANELS') . '</div><div class="panel-body">';
            echo '<a class="btn btn-default" role="button" data-toggle="collapse" id="showOpenButton" href="#showOpen" aria-expanded="false" aria-controls="showOpen">Click to view</a><div class="collapse" id="showOpen"><table class="table table-hover"><thead><th class="col-xs-3">Name</th><th class="col-xs-2">Section</th><th class="col-xs-6">Description</th><th class="col-xs-1"></th></thead><tbody>';
            foreach ($panels as $panel) {
                    echo '<tr><td>' . $panel['name'];
                    if ($panel['adult']) {
                        echo ' (18+)';
                    }
                    echo '</td><td>' . $sections[$panel['section']] . '</td>';
                    echo '<td>' . $panel['description'] . '</td><td>';
                    
                    if (!in_array($panel['id'], $registered)) {
                        echo '<a class="btn btn-default" id="register' . $panel['id'] . '" onclick="register(' . $userId . ',' . $panel['id'] . ',\'' . addslashes($panel['name']) . '\');">Register</a>';
                    } else {
                       echo 'Registered';
                    }
                    echo '</td>';
                    echo '</tr>';
            }
            echo '</tbody></table></div>';
            echo '</div></div></div>';
        }
    }
} 