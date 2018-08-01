<?php
/**
 * Schedule Model
 */
class Schedule extends CActiveRecord {
    public $eventid;
    public $room;
    public $day;
    public $time;
    public $hours;
    public $locked = 0;

    public function attributeNames() {
        return array('eventid', 'room', 'day', 'time', 'hours', 'locked');
    }

    public function relations() {
        return array(
        	'event' => array(self::HAS_MANY, 'Event', 'id')
        );
    }

    public function rules() {
        return array(
            array('eventid', 'safe', 'on'=>'search'),
        );
    }

    public function attributeLabels() {
        return array();
    }

    public function tableName() {
        return "schedule";
    }

    public static function clearEvents($eventid) {
         return Yii::app()->db->createCommand()->delete('schedule', 'event_id=:id', array(':id' => $eventid));
    }

    public function save() {
        Yii::app()->db->createCommand()->insert('schedule', array(
            'event_id' => $this->eventid,
            'room_id' => $this->room,
            'day' => $this->day,
            'time' => ($this->time == '900') ? '0900' : $this->time,
            'hours' => $this->hours,
            'locked' => $this->locked
        ));
    }

    public static function getRoomSchedule($room){
        $command = Yii::app()->db->createCommand(array(
            'select' => '*',
            'from' => 'schedule',
            'where' => 'room_id=:id',
            'order' => 'day, time',
            'params' => array(':id' => $room)
        ));
        return $command->queryAll();
    }
    
    public static function getEventsByTime(){
        $command = Yii::app()->db->createCommand(array(
            'select' => '*',
            'from' => 'schedule',
            'order' => 'day, time',
        ));
        return $command->queryAll();
    }

    public static function getEventSchedule($eventId){
        $command = Yii::app()->db->createCommand(array(
            'select' => '*',
            'from' => 'schedule',
            'where' => 'event_id=:id',
            'order' => 'day, time',
            'params' => array(':id' => $eventId)
        ));
        return $command->queryRow();
    }
    
    public static function getScheduledHours() {
    	$row = Yii::app()->db->createCommand(array(
    		'select' => 'SUM(hours) as total',
    		'from' => 'schedule'
    	))->queryRow();
    	return $row['total'];
    }
} 