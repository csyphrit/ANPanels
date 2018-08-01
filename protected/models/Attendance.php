<?php
/**
 * Attendance class
 */
class Attendance extends CModel {
    public $userid;
    public $eventid;
    public $added = 0;

    /**
     * @param $userid
     * @return array
     */
    public static function getEventsByUser($userid) {
        $command = Yii::app()->db->createCommand("SELECT DISTINCT eventid FROM attendance r left join schedule s on s.event_id=r.eventid WHERE r.userid=" . $userid . " order by s.day, s.time");
        return $command->queryAll();
    }

    /**
     * @param $eventId
     * @return array
     */
    public static function getUsersByEvent($eventId) {
        $command = Yii::app()->db->createCommand(array(
            'select' => '*',
            'from' => 'attendance',
            'where' => 'eventid=:id',
            'order' => 'added',
            'params' => array(':id' =>$eventId)
        ));
        return $command->queryAll();
    }

    /**
     * @param $data
     */
    public function setData($data) {
        $this->userid = isset($data['userid']) ? $data['userid'] : UserHelper::getCurrentUserId();
        $this->eventid = $data['eventid'];
        $this->description = isset($data['description']) ? $data['description'] : '';
        $this->comments = isset($data['comments']) ? $data['comments'] : '';
    }

    /**
     * Save user data
     * @return boolean
     */
    public function create() {
        if (!isset($this->userid) || !isset($this->eventid)) {
            return FALSE;
        }
        
        $command = Yii::app()->db->createCommand(array(
            'select' => '*',
            'from' => 'attendance',
            'where' => 'eventid=:id AND userid=:user',
            'params' => array(':id' => $this->eventid, ':user' => $this->userid)
        ));
        $rows = $command->queryAll();

	if (count($rows) < 1) {
       	    $command = Yii::app()->db->createCommand();
            $command->insert('attendance', array(
                'userid' => $this->userid,
                'eventid' => $this->eventid
            ));
        }

        return TRUE;
    }

    /**
     * @return array
     */
    public function attributeNames() {
        return array('userid', 'eventid', 'added');
    }

    /**
     * Delete the user registration
     */
    public function delete() {
        return Yii::app()->db->createCommand()->delete(
                'attendance',
                'userid=:userid AND eventid=:eventid',
                array(':userid' => $this->userid, ':eventid' => $this->eventid)
            );
    }
    
    /**
     * Delete the user registration
     */
    public function deleteEvent($id) {
        return Yii::app()->db->createCommand()->delete(
                'attendance',
                'eventid=:eventid',
                array(':eventid' => $id)
            );
    }
    
    public function deleteUser($id) {
        return Yii::app()->db->createCommand()->delete(
                'attendance',
                'userid=:id',
                array(':id' => $id)
            );
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function search($key, $value) {
        return Yii::app()->db->createCommand(array(
            'select' => '*',
            'from' => 'attendance',
            'where' => "$key=:val",
            'params' => array(':val' => $value),
        ))->queryAll();
    }
} 