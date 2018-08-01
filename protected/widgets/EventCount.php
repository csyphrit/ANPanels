<?php
/**
 * Show count of events/stats
 */

class EventCount extends CWidget {
    /**
     * Create the widget
     */
    public function run() {
        echo '<div id="stats" class="panel panel-info"><div class="panel-heading"><b>Stats</b></div><div class="panel-body">';
    
       $hours = Schedule::getScheduledHours();
       $closedPanels = Event::getCount(1, 1);
       $totalPanels = Event::getCount(1, 0);
       $workshops = Event::getCount(2, 0);
       $closedWorkshops = Event::getCount(2, 1);
       $contests = Event::getCount(6, 0);
       $closedContests = Event::getCount(6, 1);
       $panelists = Registration::getRegisteredCount(0);
       $confirmedPanelists = Registration::getRegisteredCount(1);
       $panelCount = Registration::getPanelCount();
       
       $sections = PanelHelper::getSections(TRUE);
       $closedSections = array();
       foreach ($sections as $id => $section) {
           $row = Event::getSectionCount($id, 1, 1);
           $closedSections[$section] = $row;
       }
       $openSections = array();
       foreach ($sections as $id => $section) {
           $row = Event::getSectionCount($id, 1, 0);
           $openSections[$section] = $row + $closedSections[$section];
       }
       
       $count = 0;
       $max = 0;
       $total = 0;
       foreach ($panelCount as $data) {
           $count++;
           $total += $data['total'];
           if ($data['total'] > $max) {
               $max = $data['total'];
           }
       }
       $avg = ($count > 0) ? $total / $count : 0;
       
       echo '<div class="col-xs-12 col-sm-6">';
       echo '<b>' . ($hours ? $hours : 0) . '</b> hours scheduled<br /><br />';
       
       echo '<b>' . ($totalPanels + $closedPanels) . '</b> panels suggested<br />';
       foreach ($openSections as $name => $total) {
           echo '<b>' . $total . '</b> in ' . $name . '<br />';
       }
       echo '<br />';
       
       echo '<b>' . $closedPanels . '</b> panels closed<br />';
       foreach ($closedSections as $name => $total) {
           echo '<b>' . $total . '</b> in ' . $name . '<br />';
       }
       echo '</div>';
       
       echo '<div class="col-xs-12 col-sm-6">';
       echo '<b>' . $panelists + $confirmedPanelists . '</b> panelists<br />';
       echo '<b>' . $confirmedPanelists . '</b> confirmed panelists<br />';
       echo '<b>' . $avg . '</b> average panels per person<br />';
       echo '<b>' . $max . '</b> maximum panels per person<br /><br />';
       
       echo '<b>' . $workshops + $closedWorkshops . '</b> workshops suggested<br />';
       echo '<b>' . $closedWorkshops . '</b> workshops closed<br /><br />';
       
       echo '<b>' . $contests + $closedContests . '</b> contests suggested<br />';
       echo '<b>' . $closedContests . '</b> contests closed<br />';
       echo '</div>';
       
       
       echo '</div></div>';
    }
} 