<?php
class Announcements extends CActiveRecord {
	public $id;
	public $userid;
	public $message;
	public $time;
	public $public;
	
	public function attributeNames() {
        	return array('id', 'userid', 'message', 'time', 'public');
    	}

	public function relations() {
		return array();
	}

	public function rules() {
		return array(
			array('id', 'safe', 'on'=>'search'),
		);
	}

	public function attributeLabels() {
		return array(
			'id' => 'Message Id',
			'userid' => 'Poster',
			'message' => 'Message Text',
			'time' => 'Time Posted',
			'public' => 'Is Public?',
		);
	}

	public function tableName() {
		return "announcements";
	}

	public function search() {
		$criteria       = new CDbCriteria;
		$sort           = new CSort;
		$sort->defaultOrder= array(
            		'id'=>CSort::SORT_DESC,
        	);
        	$criteria->compare('id', $this->id, true);

        	return new CActiveDataProvider($this, array(
            		'pagination'=>array('pageSize'=>20),
            		'criteria'=>$criteria,
            		'sort'=>$sort,
        	));
    	}
    	
    	public static function addAnnouncement($subject, $message) {
    		$command = Yii::app()->db->createCommand();
        	$command->insert('announcements', array(
            		'subject' => $subject,
            		'message' => $message
        	));
    	}
}
?>