<?php
class Reports extends CActiveRecord {
    public $name;
    public $url;
    public $visible;

    public function attributeNames() {
        return array('name', 'url', 'visible');
    }

    public function relations() {
        return array();
    }

    public function rules() {
        return array(
            array('name', 'safe', 'on'=>'search'),
        );
    }

    public function attributeLabels() {
        return array();
    }

    public function tableName() {
        return "reports";
    }

    public function search() {
        $criteria       = new CDbCriteria;
        $sort           = new CSort;
        $sort->defaultOrder= array(
            'name'=>CSort::SORT_ASC,
        );
        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider($this, array(
            'pagination'=>array('pageSize'=>20),
            'criteria'=>$criteria,
            'sort'=>$sort,
        ));
    }

    /**
     * @param null $section
     * @return array
     */
    public static function getReports($visible = 1) {
        return Yii::app()->db->createCommand(array(
            'select' => '*',
            'from' => 'reports',
            'where' => 'visible=:vis',
            'params' => array(':vis' => $visible),
            'order' => 'name'
        ))->queryAll();
    }
}