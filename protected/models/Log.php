<?php
class Log extends CActiveRecord {
    public $id;
    public $userid;
    public $eventid;
    public $action;
    public $time;
    public $details;

    public function attributeNames() {
        return array('id', 'userid', 'eventid', 'action', 'time', 'details');
    }

    public function relations() {
        return array();
    }

    public function rules() {
        return array(
            array('action', 'safe', 'on'=>'search'),
        );
    }

    public function attributeLabels() {
        return array();
    }

    public function tableName() {
        return "log";
    }

    public function search() {
        $criteria       = new CDbCriteria;
        $sort           = new CSort;
        $sort->defaultOrder= array(
            'id'=>CSort::SORT_ASC,
        );
        $criteria->compare('id', $this->id, true);

        return new CActiveDataProvider($this, array(
            'pagination'=>array('pageSize'=>20),
            'criteria'=>$criteria,
            'sort'=>$sort,
        ));
    }

    public static function set($eventid, $action, $details) {
    	$id = UserHelper::getCurrentUserId();
    	$command = Yii::app()->db->createCommand();
        $command->insert('log', array(
            'userid' => $id ? $id : 0,
            'eventid' => $eventid,
            'action' => $action,
            'details' => $details
        ));
    }
} 