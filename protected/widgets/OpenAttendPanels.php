<?php
/**
 * Show current public panels
 */

class OpenAttendPanels extends CWidget {
    public function run() {
        $panels = Event::getOpenEvents();
        $sections = PanelHelper::getSections();
        $userId = UserHelper::getCurrentUserId();
        
        $registered = array();
        $registeredPanels = PanelHelper::getUserPanels(FALSE, UserHelper::getCurrentUser());
        foreach ($registeredPanels as $panel) {
            $registered[] = $panel->id;
        }
        
        $unavailablePanels = PanelHelper::getUserUnavailablePanels(UserHelper::getCurrentUser());
        foreach ($unavailablePanels as $panel) {
            $registered[] = $panel->id;
        }
        
        echo '<div id="openPanels" class="containerDiv">';

        echo '<h3>Open Panels</h3>';
        if (count($panels)) {
            echo '<table><tr><th>Name</th><th>Section</th><th>Description</th><th></th></tr>';
            foreach ($panels as $panel) {
                    echo '<tr><td>' . $panel['name'];
                    if ($panel['adult']) {
                        echo ' (18+)';
                    }
                    echo '</td><td>' . $sections[$panel['section']] . '</td>';
                    echo '<td>' . $panel['description'] . '</td><td>';
                    
                    if (!in_array($panel['id'], $registered)) {
                        echo '<a class="button" id="register' . $panel['id'] . '" onclick="register(' . $userId . ',' . $panel['id'] . ');">Join as Panelist</a>';
                        echo '<a class="button" id="register' . $panel['id'] . '" onclick="register(' . $userId . ',' . $panel['id'] . ',1);">Join as Host</a>';
                        echo '<a class="button" id="attend' . $panel['id'] . '" onclick="attend(' . $userId . ',' . $panel['id'] . ');">Attend Panel</a>';
                    } else {
                       echo 'Registered';
                    }
                    
                    echo '</td>';
                    echo '</tr>';
            }
            echo '</table>';
        } else {
            echo 'There are no public open panels.';
        }

        echo '</div>';
        echo '<style>td { border-bottom: 1px solid black; }</style>';
    }
} 