<?php
/**
 * Class User
 */
class User extends CActiveRecord {
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $ip;

    /**
     * @var integer
     */
    public $privilege;

    /**
     * @var integer
     */
    public $type;

    /**
     * @var boolean
     */
    public $active;

    /**
     * @var boolean
     */
    public $first_login;

    /**
     * @var boolean
     */
    public $added;

    /**
     * @var Profile
     */
    public $profile;

    /**
     * @return array
     */
    public function rules() {
        return array(
            array('username, password', 'required'),
            array('username', 'email'),
        );
    }

    public function attributeNames() {
        return array();
    }

    public function relations() {
        return array();
    }

    public function attributeLabels() {
        return array();
    }

    public function tableName() {
        return "users";
    }

    /**
     * @param $data
     * @param bool $initial
     */
    public function setData($data, $initial = FALSE) {
        $this->id = $initial ? NULL : $data['id'];
        $this->username = isset($data['username']) && !empty($data['username']) ? $data['username'] : $data['email'];
        $this->password = $initial ? md5($data['password']) : $data['pass'];
        $this->ip = $initial ? $_SERVER['REMOTE_ADDR'] : $data['ip'];
        $this->privilege = $initial ? 0 : $data['priv'];
        $this->type = $initial ? 1 : $data['type'];
        $this->active = $initial ? 0 : (isset($data['active']) ? 1 : 0);
        $this->first_login = $initial ? 0 : $data['first_login'];
        $this->added = $initial ? date("Y-m-d H:i:s", time()) : $data['added'];
    }

    /**
     * Save user data
     */
    public function create() {
        $command = Yii::app()->db->createCommand();

        if ($this->id === NULL) {
            $command->insert('users', array(
                'username' => $this->username,
                'pass' => $this->password,
                'ip' => $this->ip,
                'priv' => $this->privilege,
                'type' => $this->type,
                'active' => $this->active,
                'first_login' => $this->first_login,
                'added' => $this->added
            ));
            $this->id = Yii::app()->db->getLastInsertId('user');
        }
    }

    /**
     * Save user data
     */
    public function save() {
        $command = Yii::app()->db->createCommand();
        $command->update('users', array(
            'username' => $this->username,
            'pass' => $this->password,
            'ip' => $this->ip,
            'priv' => $this->privilege,
            'type' => $this->type,
            'active' => $this->active,
            'first_login' => $this->first_login,
            'added' => $this->added
        ), 'id=:id', array(':id'=> $this->id));
    }

    public static function login($id) {
        $command = Yii::app()->db->createCommand();
        $command->update('users', array(
            'first_login' => 0,
            'last_active' => date('Y-m-d H:i:s'),
        ), 'id=:id', array(':id'=> $id));
    }

    public static function savePassword($password, $id){
        $command = Yii::app()->db->createCommand();
        $command->update('users', array(
            'pass'=> $password
        ), 'id=:id', array(':id'=> $id));
    }

    /**
     * Delete the user
     */
    public function delete() {
        Yii::app()->db->createCommand()->delete('users', 'id=:id', array(':id' => $this->id));
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public static function search($key, $value) {
        return Yii::app()->db->createCommand(array(
            'select' => '*',
            'from' => 'users',
            'where' => "$key=:val",
            'params' => array(':val' => $value),
        ))->queryRow();
    }
    
    public static function getTypes() {
      return Yii::app()->db->createCommand(array(
          'select' => '*',
          'from' => 'user_types'
      ))->queryAll();
    }
} 