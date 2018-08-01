<?php
class Config extends CActiveRecord {
    public $token;
    public $param;

    public function attributeNames() {
        return array('token', 'param');
    }

    public function relations() {
        return array();
    }

    public function rules() {
        return array(
            array('token', 'safe', 'on'=>'search'),
        );
    }

    public function attributeLabels() {
        return array();
    }

    public function tableName() {
        return "config";
    }

    public function search() {
        $criteria       = new CDbCriteria;
        $sort           = new CSort;
        $sort->defaultOrder= array(
            'token'=>CSort::SORT_ASC,
        );
        $criteria->compare('token', $this->token, true);

        return new CActiveDataProvider($this, array(
            'pagination'=>array('pageSize'=>20),
            'criteria'=>$criteria,
            'sort'=>$sort,
        ));
    }

    public static function getValue($key) {
    	$row = Yii::app()->db->createCommand(array(
    		'select' => 'param',
    		'from' => 'config',
    		'where' => "token=:key",
    		'params' => array(':key' => $key)
    	))->queryRow();
    	return $row['param'];
    }
    
    public static function getValues() {
    	return Yii::app()->db->createCommand(array(
    		'select' => '*',
    		'from' => 'config'
    	))->queryAll();
    }
    
    public function setValue($key, $value) {
        $command = Yii::app()->db->createCommand();
        $command->update('config', array(
            'param' => $value
        ), 'token=:id', array(':id'=> $key));
    }
} 