<?php
class Profile extends CActiveRecord {
    public $id;
    public $userid;
    public $name;
    public $alias;
    public $address;
    public $city;
    public $state;
    public $zip;
    public $country;
    public $phone;
    public $email;
    public $age;
    public $forumName;
    public $regStatus;
    public $prev_panelist;
    public $prev_panels;
    public $ocprev_panelist;
    public $ocprev_panels;
    public $prev_mod;
    public $prev_mod_panels;
    public $comments;
    public $unavailable;

    public function setData($data) {
        if (!is_array($data)) {
            return FALSE;
        }
           
        $this->userid = isset($data['userid']) ? $data['userid'] : UserHelper::getCurrentUserId();
        $this->name = $data['name'];
        $this->alias = isset($data['alias']) ? $data['alias'] : '';
        $this->address = isset($data['address']) ? $data['address'] : '';
        $this->city = isset($data['city']) ? $data['city'] : '';
        $this->state = isset($data['state']) ? $data['state'] : '';
        $this->zip = isset($data['zip']) ? $data['zip'] : '';
        $this->country = isset($data['country']) ? $data['country'] : '';
        $this->phone = isset($data['phone']) ? $data['phone'] : '';
        $this->email = isset($data['email']) ? $data['email'] : '';
        $this->age = isset($data['age']) ? $data['age'] : '';
        $this->forumName = isset($data['forumName']) ? $data['forumName'] : '';
        $this->regStatus = isset($data['reg_status']) ? $data['reg_status'] : (isset($data['regStatus']) ? $data['regStatus'] : 'N');
        $this->prev_panelist = isset($data['prev_panelist']) ? $data['prev_panelist'] : '0';
        $this->prev_panels = isset($data['prev_panels']) ? $data['prev_panels'] : '';
        $this->ocprev_panelist = isset($data['ocprev_panelist']) ? $data['ocprev_panelist'] : '0';
        $this->ocprev_panels = isset($data['ocprev_panels']) ? $data['ocprev_panels'] : '';
        $this->prev_mod = isset($data['prev_mod']) ? $data['prev_mod'] : '0';
        $this->prev_mod_panels = isset($data['prev_mod_panels']) ? $data['prev_mod_panels'] : '';
        $this->comments = isset($data['comments']) ? $data['comments'] : '';
        $this->unavailable = isset($data['unavailable']) ? $data['unavailable'] : '';
    }

    public function attributeNames() {
        return array('userid', 'name', 'alias', 'address', 'city', 'state', 'zip', 'country', 'phone', 'email', 'age', 'forumName', 'regStatus', 'comments', 'unavailable', 'prev_panelist', 'prev_panels', 'ocprev_panelist', 'ocprev_panels', 'prev_mod', 'prev_mod_panels');
    }
    
    public function relations() {
        return array();
    }

    public function rules() {
        return array(
            array('name, alias, email', 'safe', 'on'=>'search'),
        );
    }

    public function attributeLabels() {
        return array();
    }

    public function tableName() {
        return "profiles";
    }

    public function create() {
        Yii::app()->db->createCommand()->insert('profiles', array(
            'userid' => $this->userid,
            'name' => $this->name,
            'alias' => $this->alias,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip' => $this->zip,
            'country' => $this->country,
            'phone' => $this->phone,
            'email' => $this->email,
            'age' => $this->age,
            'teahouseid' => $this->forumName,
            'reg_status' => $this->regStatus,
            'prev_panelist' => $this->prev_panelist,
            'prev_panels' => $this->prev_panels,
            'ocprev_panelist' => $this->ocprev_panelist,
            'ocprev_panels' => $this->ocprev_panels,
            'prev_mod' => $this->prev_mod,
            'prev_mod_panels' => $this->prev_mod_panels,
            'comments' => $this->comments,
            'unavailable' => $this->unavailable
        ));
    }

    public function save() {
        Yii::app()->db->createCommand()->update('profiles', array(
            'userid' => $this->userid,
            'name' => $this->name,
            'alias' => $this->alias,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip' => $this->zip,
            'country' => $this->country,
            'phone' => $this->phone,
            'email' => $this->email,
            'age' => $this->age,
            'teahouseid' => $this->forumName,
            'reg_status' => $this->regStatus,
            'prev_panelist' => $this->prev_panelist,
            'prev_panels' => $this->prev_panels,
            'ocprev_panelist' => $this->ocprev_panelist,
            'ocprev_panels' => $this->ocprev_panels,
            'prev_mod' => $this->prev_mod,
            'prev_mod_panels' => $this->prev_mod_panels,
            'comments' => $this->comments,
            'unavailable' => $this->unavailable
        ), 'userid=:id', array(':id'=> $this->userid));
    }

    public function searchGrid() {
        $criteria       = new CDbCriteria;
        $sort           = new CSort;
        $sort->defaultOrder= array(
            'name'=>CSort::SORT_ASC,
        );
        $criteria->compare('name', $this->name, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('email', $this->email, true);
        $criteria->select = array(
        	'*'
        );

        return new CActiveDataProvider($this, array(
            'pagination'=>array('pageSize'=>'40'),
            'criteria'=>$criteria,
            'sort'=>$sort,
        ));
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public static function search($key, $value) {
        return Yii::app()->db->createCommand(array(
            'select' => '*, teahouseid as forumName',
            'from' => 'profiles',
            'where' => "$key=:val",
            'params' => array(':val' => $value),
        ))->queryRow();
    }

    public function delete() {
        Yii::app()->db->createCommand()->delete('profiles', 'userid=:id', array(':id'=> $this->userid));
    }

    /**
     * @return array
     */
    public static function getUsers() {
        return Yii::app()->db->createCommand(array(
            'select' => '*',
            'from' => 'profiles',
            'order' => 'name'
        ))->queryAll();
    }
    
    public static function getAllEmails() {
    	return Yii::app()->db->createCommand(array(
    		'select' => 'userid, email',
    		'from' => 'profiles',
    		'where' => 'receiveEmail=1'
    	))->queryAll();
    }
} 