<?php
/**
 * Class UserHelper
 */
class UserHelper {
    public static function getCurrentUserId() {
        return Yii::app()->user->id;
    }

    /**
     * @return User
     */
    public static function getCurrentUser() {
        $user = new User();
        $row = $user->search('id', Yii::app()->user->id);
        if (empty($row)) {
            return NULL;
        }
        $user->setData($row);

        $profile = new Profile();
        $row = $profile->search('userid', $user->id);
        $profile->setData($row);
        $user->profile = $profile;

        return $user;
    }

    /**
     * @param $name
     * @return null|User
     */
    public static function getUserByName($name) {
        if (empty($name)) {
            return NULL;
        }

        $user = new User();
        $row = $user->search('username', $name);
        if (empty($row)) {
            return NULL;
        }

        $user->setData($row);
        return $user;
    }

    /**
     * @param $email
     * @return null|User
     */
    public static function getUserByEmail($email) {
        $user = new User();
        if (empty($email)) {
            return NULL;
        }

        $profile = new Profile();
        $row = $profile->search('email', $email);
        if (empty($row)) {
            return NULL;
        }
        $profile->setData($row);
        
        $row = $user->search('id', $profile->userid);
        if (empty($row)) {
            return NULL;
        }
        $user->setData($row);
        $user->profile = $profile;

        return $user;
    }
    
    public static function getUserById($id) {
        $user = new User();
        $row = $user->search('id', $id);
        if (empty($row)) {
            return $user;
        }
        $user->setData($row);

        $profile = new Profile();
        $row = $profile->search('userid', $id);
        if (empty($row)) {
            $user->profile = $profile;
            return $user;
        }
        $profile->setData($row);
        $user->profile = $profile;

        return $user;
    }
    
    public static function getTypes() {
        $types = User::getTypes();
        $formatted = array();
        foreach ($types as $type) {
            $formatted[$type['id']] = $type['name'];
        }
        return $formatted;
    }
}
?>
