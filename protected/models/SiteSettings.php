<?php
class SiteSettings extends CActiveRecord {
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
        return "site_settings";
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
    		'from' => 'site_settings',
    		'where' => "token=:key",
    		'params' => array(':key' => $key)
    	))->queryRow();
    	return $row['param'];
    }
    
    public static function getValues() {
    	return Yii::app()->db->createCommand(array(
    		'select' => '*',
    		'from' => 'site_settings'
    	))->queryAll();
    }
    
    public function setValue($key, $value) {
        $command = Yii::app()->db->createCommand();
        $command->update('site_settings', array(
            'param' => $value
        ), 'token=:id', array(':id'=> $key));
    }
} 