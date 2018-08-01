<?php
/**
 * Class PanelHelper
 */
class PanelHelper {
    /**
     * @param bool $confirmed
     * @return array
     */
    public static function getUserPanels($confirmed = FALSE, $user = NULL) {
        $panels = array();
        if (!is_object($user)) {
            $user = UserHelper::getCurrentUser();
        }
        if (!is_object($user)) {
        	return array();
        }
        $registration = new Registration();

        $rows = $registration->getEventsByUser($user->id);
        foreach ($rows as $row) {
            if ($row['eventid'] > 0) {
                if (($confirmed && !$row['confirmed']) || (!$confirmed && $row['confirmed'])) {
                    continue;
                }

                $event = new Event();
                $data = $event->searchBy('id', $row['eventid']);
                $event->setData($data);
                $event->schedule = Schedule::getEventSchedule($row['eventid']);
                $panels[] = $event;
            }

        }
        return $panels;
    }
    
    public static function getUserUnavailablePanels($user = NULL) {
        $panels = array();
        if (!is_object($user)) {
            $user = UserHelper::getCurrentUser();
        }
        if (!is_object($user)) {
        	return array();
        }
        $attendance = new Attendance();

        $rows = $attendance->getEventsByUser($user->id);
        foreach ($rows as $row) {
            if ($row['eventid'] > 0) {
                $event = new Event();
                $data = $event->searchBy('id', $row['eventid']);
                $event->setData($data);
                $event->schedule = Schedule::getEventSchedule($row['eventid']);
                $panels[] = $event;
            }

        }
        return $panels;
    }

    public function getPanelistCount($eventid, $unconfirmed = FALSE) {
        $count = 0;
        $registration = new Registration();
        $rows = $registration->getUsersByEvent($eventid);
        foreach ($rows as $row) {
            if ($unconfirmed && $row['confirmed']) {
                continue;
            }

            $count++;
        }

        return $count;
    }

    /**
     * @param $name
     * @return Event|null
     */
    public static function getEventByName($name) {
        $event = NULL;
        $model = new Event();
        $row = $model->searchBy('name', $name);
        if (!empty($row)) {
            $model->setData($row);
            $event = $model;
        }

        return $event;
    }
    
        /**
     * @param $name
     * @return Event|null
     */
    public static function getEventById($id) {
        $event = NULL;
        $model = new Event();
        $row = $model->searchBy('id', $id);
        if (!empty($row)) {
            $model->setData($row);
            $event = $model;
        }

        return $event;
    }

    /**
     * @param bool $showAll
     * @return array
     */
    public static function getSections($showAll = FALSE) {
        $sections = array();
        $rows = Sections::getAll();
        foreach ($rows as $row) {
            if (!$showAll && !$row['visible']) {
                continue;
            }
            $sections[$row['id']] = $row['name'];
        }
        return $sections;
    }

    /**
     * @param $schedule
     * @return string
     */
    public static function formatSchedule($schedule) {
        if (empty($schedule)) {
            return '';
        }

        return $schedule['day'] . ' at ' . $schedule['time'] . ' (' . date('g:i a', strtotime($schedule['time'])) . ')';
    }

    public static function getTypes($visibleOnly = FALSE) {
        $types = Event::getTypes();
        $formatted = array();
        foreach ($types as $type) {
            if ($visibleOnly && $type['visible'] == 0) {
                continue;
            }

            $formatted[$type['id']] = $type['name'];
        }
        return $formatted;
    }

    public static function getEventGrid($section = NULL) {
        $events = Event::getEvents($section);
        $types = PanelHelper::getTypes();
        $formatted = array();

        foreach ($events as $event) {
            $formatted[] = array(
                'id' => $event['id'],
                'name' => $event['name'],
                'type' => $types[$event['type']]
            );
        }

        return $formatted;
    }

    public static function formatBoolean($value) {
        if ($value) {
            return 'Yes';
        } else {
            return 'No';
        }
    }
    
    public static function getSectionEmail($section) {
    	$email = Sections::getEmail($section);
    	if (empty($email)) {
    	    $email = Config::getValue('PANELMASTER_EMAIL');
    	}
    	return $email;
    }
} 