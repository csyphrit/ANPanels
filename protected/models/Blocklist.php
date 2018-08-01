<?php
/**
 * Banlist
 */
class Blocklist extends CActiveRecord {
	public $ip;
	
	public function attributeNames() {
        	return array('ip');
    	}

	public function relations() {
		return array();
	}

	public function rules() {
		return array(
			array('ip', 'safe', 'on'=>'search'),
		);
	}

	public function attributeLabels() {
		return array(
			'ip' => 'IP Address',
		);
	}

	public function tableName() {
		return "ip_blocklist";
	}

	public function search() {
		$criteria       = new CDbCriteria;
		$sort           = new CSort;
		$sort->defaultOrder= array(
            		'ip' => CSort::SORT_ASC,
        	);
        	$criteria->compare('ip', $this->ip, true);

        	return new CActiveDataProvider($this, array(
            		'pagination'=>array('pageSize'=>20),
            		'criteria'=>$criteria,
            		'sort'=>$sort,
        	));
    	}
    	
    	public static function getBanlist() {
    		return Blocklist::model()->findAll(array(
    			'select' => 'ip',
		));
    	}
    	
    	public static function inBanlist($ip) {
    		$row = Yii::app()->db->createCommand(array(
    			'select' => 'ip',
    			'from' => 'ip_blocklist',
    			'where' => "ip=:ip",
    			'params' => array(':ip' => $ip)
    		))->queryRow();
    		return isset($row['ip']) ? TRUE : FALSE;
    	}
}
?>