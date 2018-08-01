<?php
/**
 * Section model
 */
class Sections extends CActiveRecord{
    public $id;
    public $name;
    public $visible;
    public $email;

    public static function getAll() {
        $command = Yii::app()->db->createCommand(array(
            'select' => '*',
            'from' => 'sections'
        ));
        return $command->queryAll();
    }

    public function tableName() {
        return 'sections';
    }
    
    public static function getEmail($section) {
        $row = Yii::app()->db->createCommand(array(
    		'select' => 'email',
    		'from' => 'sections',
    		'where' => 'id=:id',
    		'params' => array(':id' => $section)
    	))->queryRow();
    	return $row['email'];
    }
} 