<?php
class Rooms extends CActiveRecord {
    public $id;
    public $name;
    public $building;
    public $section;
    public $has_av;

    public function setData($data) {
        $this->id = isset($data['id']) ? $data['id'] : NULL;
        $this->name = isset($data['name']) ? $data['name'] : '';
        $this->building = isset($data['building']) ? $data['building'] : '';
        $this->section = isset($data['section']) ? $data['section'] : 1;
        $this->has_av = isset($data['has_av']) ? $data['has_av'] : 0;
    }

    public function attributeNames() {
        return array('id', 'name', 'building', 'section', 'has_av');
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
        return "rooms";
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
     * Save user data
     */
    public function create() {
        $command = Yii::app()->db->createCommand();
        $command->insert('rooms', array(
            'name' => $this->name,
            'building' => $this->building,
            'section' => $this->section,
            'has_av' => $this->has_av
        ));
        $this->id = Yii::app()->db->getLastInsertId('rooms');
    }

    /**
     * Save user data
     */
    public function save() {
        $command = Yii::app()->db->createCommand();
        $command->update('rooms', array(
            'name' => $this->name,
            'building' => $this->building,
            'section' => $this->section,
            'has_av' => $this->has_av
        ), 'id=:id', array(':id'=> $this->id));
    }

    /**
     * Delete the user
     */
    public function delete() {
        $command = Yii::app()->db->createCommand();
        $command->delete('rooms', 'id=:id', array(':id' => $this->id));
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public static function searchBy($key, $value) {
        return Yii::app()->db->createCommand(array(
            'select' => '*',
            'from' => 'rooms',
            'where' => "$key=:val",
            'params' => array(':val' => $value),
        ))->queryRow();
    }

    /**
     * @param null $section
     * @return array
     */
    public static function getRooms($section = NULL) {
        $rooms = Yii::app()->db->createCommand(array(
            'select' => '*',
            'from' => 'rooms',
            'order' => 'building, name'
        ))->queryAll();
        $roomData = array();
        foreach($rooms as $room) {
            $roomData[$room['id']] = $room;
        }
        return $roomData;
    }
}