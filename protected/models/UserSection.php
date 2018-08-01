<?php
class UserSection extends CActiveRecord {
    public $section;
    public $userid;

    public function attributeNames() {
        return array('section', 'userid');
    }

    public function relations() {
        return array();
    }

    public function rules() {
        return array();
    }

    public function attributeLabels() {
        return array();
    }

    public function tableName() {
        return "user_section";
    }

    public function search() {
        $criteria       = new CDbCriteria;
        $sort           = new CSort;
        $sort->defaultOrder= array(
            'token'=>CSort::SORT_ASC,
        );
        $criteria->compare('section', $this->section, true);

        return new CActiveDataProvider($this, array(
            'pagination'=>array('pageSize'=>20),
            'criteria'=>$criteria,
            'sort'=>$sort,
        ));
    }

    public static function getSection($userid) {
    	$row = Yii::app()->db->createCommand(array(
    		'select' => 'section',
    		'from' => 'user_section',
    		'where' => "userid=:key",
    		'params' => array(':key' => $userid)
    	))->queryRow();
    	return $row['section'];
    }
} 