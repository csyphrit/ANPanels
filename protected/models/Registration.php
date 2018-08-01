<?php
/**
 * Registration class
 */
class Registration extends CModel {
    public $userid;
    public $eventid;
    public $description = '';
    public $justification = '';
    public $comments = '';
    public $added = 0;
    public $confirmed = 0;
    public $moderator = 0;

    /**
     * @param $userid
     * @return array
     */
    public static function getEventsByUser($userid) {
        $command = Yii::app()->db->createCommand("SELECT DISTINCT eventid, confirmed FROM registration r left join schedule s on s.event_id=r.eventid WHERE r.userid=" . $userid . " order by s.day, s.time");
        return $command->queryAll();
    }
    
    public static function getConfirmedEventsByUser($userid) {
        $command = Yii::app()->db->createCommand("SELECT DISTINCT eventid FROM registration r left join schedule s on s.event_id=r.eventid WHERE r.userid=" . $userid . " AND confirmed=1 order by s.day, s.time");
        return $command->queryAll();
    }

    /**
     * @param $eventId
     * @return array
     */
    public static function getUsersByEvent($eventId) {
        $command = Yii::app()->db->createCommand(array(
            'select' => '*',
            'from' => 'registration',
            'where' => 'eventid=:id',
            'order' => 'moderator DESC, confirmed DESC, added',
            'params' => array(':id' => $eventId)
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
        $this->justification = isset($data['justification']) ? $data['justification'] : '';
        $this->comments = isset($data['comments']) ? $data['comments'] : '';
        $this->confirmed = isset($data['confirmed']) ? $data['confirmed'] : FALSE;
        $this->moderator = isset($data['moderator']) ? $data['moderator'] : FALSE;
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
            'from' => 'registration',
            'where' => 'eventid=:id AND userid=:user',
            'params' => array(':id' => $this->eventid, ':user' => $this->userid)
        ));
        $rows = $command->queryAll();

	if (count($rows) < 1) {
       	    $command = Yii::app()->db->createCommand();
            $command->insert('registration', array(
                'userid' => $this->userid,
                'eventid' => $this->eventid,
                'description' => $this->description,
                'justification' => $this->justification,
                'comments' => $this->comments,
                'confirmed' => $this->confirmed,
                'moderator' => $this->moderator
            ));
        }

        return TRUE;
    }

    /**
     * @param $id
     * @param $merge
     * @return bool
     */
    public static function merge($id, $merge) {
        if ($id <= 0 || $merge <= 0) {
            return FALSE;
        }

        $command = Yii::app()->db->createCommand();
        $command->update('registration', array(
            'moderator' => 0
        ), 'eventid=:id', array(':id' => $merge));

        $command = Yii::app()->db->createCommand();
        $command->update('registration', array(
            'eventid' => $id
        ), 'eventid=:id', array(':id'=>$merge));

        return TRUE;
    }

    /**
     * @param $event
     * @param $user
     * @return bool
     */
    public static function confirm($event, $user) {
        if ($event <= 0 || $user <= 0) {
            return FALSE;
        }

        $command = Yii::app()->db->createCommand();
        $command->update('registration', array(
            'confirmed' => 1
        ), 'eventid=:id AND userid=:user', array(':id' => $event, ':user' => $user));

        return TRUE;
    }

    /**
     * @param $event
     * @param $user
     * @return bool
     */
    public static function unconfirm($event, $user) {
        if ($event <= 0 || $user <= 0) {
            return FALSE;
        }

        $command = Yii::app()->db->createCommand();
        $command->update('registration', array(
            'confirmed' => 0
        ), 'eventid=:id AND userid=:user', array(':id' => $event, ':user' => $user));

        return TRUE;
    }

    /**
     * @param $event
     * @param $user
     * @return bool
     */
    public static function promote($event, $user) {
        if ($event <= 0 || $user <= 0) {
            return FALSE;
        }

        $command = Yii::app()->db->createCommand();
        $command->update('registration', array(
            'moderator' => 0
        ), 'eventid=:id', array(':id' => $event));

        $command = Yii::app()->db->createCommand();
        $command->update('registration', array(
            'moderator' => 1,
            'confirmed' => 1
        ), 'eventid=:id AND userid=:user', array(':id' => $event, ':user' => $user));

        return TRUE;
    }

    /**
     * @return array
     */
    public function attributeNames() {
        return array('userid', 'eventid', 'description', 'justification', 'comments', 'confirmed', 'moderator', 'added');
    }

    /**
     * Delete the user registration
     */
    public function delete() {
        return Yii::app()->db->createCommand()->delete(
                'registration',
                'userid=:userid AND eventid=:eventid',
                array(':userid' => $this->userid, ':eventid' => $this->eventid)
            );
    }
    
    /**
     * Delete the user registration
     */
    public function deleteEvent($id) {
        return Yii::app()->db->createCommand()->delete(
                'registration',
                'eventid=:eventid',
                array(':eventid' => $id)
            );
    }
    
    public function deleteUser($id) {
        return Yii::app()->db->createCommand()->delete(
                'registration',
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
            'from' => 'registration',
            'where' => "$key=:val",
            'params' => array(':val' => $value),
        ))->queryAll();
    }

    /**
     * @param int $confirmed
     * @return int
     */
    public static function getRegisteredCount($confirmed = 0) {
      $rows = Yii::app()->db->createCommand(array(
            'select' => 'DISTINCT(userid)',
            'from' => 'registration',
            'where' => "confirmed=:val",
            'params' => array(':val' => $confirmed),
        ))->queryAll();
        return count($rows);
    }
    
    /**
     * @param int $confirmed
     * @return int
     */
    public static function getRegisteredEventCount($eventId, $confirmed = 0) {
      $rows = Yii::app()->db->createCommand(array(
            'select' => 'DISTINCT(userid)',
            'from' => 'registration',
            'where' => "confirmed=:val AND eventid=:id",
            'params' => array(':val' => $confirmed, ':id' => $eventId),
        ))->queryAll();
        return count($rows);
    }

    /**
     * @return array
     */
    public static function getPanelCount() {
    	return Yii::app()->db->createCommand("SELECT DISTINCT r1.userid, (SELECT COUNT(r2.eventid) FROM registration r2 WHERE r2.userid=r1.userid) as total FROM registration r1 WHERE confirmed=1 ORDER BY total DESC")->queryAll();
    }
} 