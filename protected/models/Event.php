<?php
class Event extends CActiveRecord {
    public $id;
    public $name;
    public $type;
    public $description;
    public $section;
    public $closed;
    public $contacted;
    public $av;
    public $av_requested;
    public $adult;
    public $desc_final;
    public $last_updated;
    public $schedule;
    public $double_length;
    public $public;
    public $scheduled;
    public $unconfirmed;
    public $panelists;
    public $pageSize = 50;

    public function setData($data) {
        $this->id = isset($data['id']) ? $data['id'] : NULL;
        $this->name = isset($data['name']) ? $data['name'] : '';
        $this->type = isset($data['type']) ? $data['type'] : 1;
        $this->description = isset($data['description']) ? $data['description'] : '';
        $this->section = isset($data['section']) ? $data['section'] : 1;
        $this->closed = isset($data['closed']) ? $data['closed'] : 0;
        $this->contacted = isset($data['contacted']) ? $data['contacted'] : 0;
        $this->av = isset($data['av']) ? $data['av'] : 0;
        $this->av_requested = isset($data['av_requested']) ? $data['av_requested'] : 0;
        $this->adult = isset($data['adult']) ? $data['adult'] : 0;
        $this->desc_final = isset($data['desc_final']) ? $data['desc_final'] : 0;
        $this->double_length = isset($data['double_length']) ? $data['double_length'] : 0;
        $this->scheduled = isset($data['scheduled']) ? $data['scheduled'] : 0;
        $this->panelists = isset($data['panelists']) ? $data['panelists'] : 0;
        $this->public = 0;
    }

    public function attributeNames() {
        return array('id', 'name', 'type', 'description', 'section', 'closed', 'contacted', 'av', 'av_requested', 'adult', 'desc_final', 'public', 'double_length', 'scheduled', 'panelists');
    }

    public function relations() {
        return array(
        	'schedule' => array(self::HAS_MANY, 'Schedule', 'eventid')
        );
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
        return "events";
    }

    public function search() {
        $sort = new CSort;
        $sort->defaultOrder= array(
            'name'=>CSort::SORT_ASC,
        );
        $sort->attributes = array(
        	'unconfirmed' => array(
                    'asc'=>'(select count(*) from registration r where r.eventid = t.id AND r.confirmed=0) ASC',
                    'desc'=>'(select count(*) from registration r where r.eventid = t.id AND r.confirmed=0) DESC',
                ),
                '*',
        );
        
        $criteria = new CDbCriteria;
        $criteria->compare('name', $this->name, true);
        if ($this->section > 0) {
            $criteria->condition = 'section=:section';
            $criteria->params = array(':section' => $this->section);
        }
        $criteria->select = array(
        	'*',
        	"(select count(*) from registration r where r.eventid = t.id AND r.confirmed=0) as unconfirmed"
        );

        return new CActiveDataProvider($this, array(
            'pagination'=>array('pageSize'=>$this->pageSize),
            'criteria'=>$criteria,
            'sort'=>$sort,
        ));
    }

    /**
     * Save user data
     */
    public function create() {
        $command = Yii::app()->db->createCommand();
        $command->insert('events', array(
            'name' => $this->name,
            'type' => $this->type,
            'description' => $this->description,
            'section' => $this->section,
            'closed' => $this->closed,
            'contacted' => $this->contacted,
            'av' => $this->av,
            'av_requested' => $this->av_requested,
            'adult' => $this->adult,
            'desc_final' => $this->desc_final,
            'public' => $this->public,
            'double_length' => $this->double_length,
            'scheduled' => $this->scheduled,
            'panelists' => $this->panelists
        ));
        $this->id = Yii::app()->db->getLastInsertId('events');
    }

    /**
     * Save user data
     */
    public function save() {
        $command = Yii::app()->db->createCommand();
        $command->update('events', array(
            'name' => $this->name,
            'type' => $this->type,
            'description' => $this->description,
            'section' => $this->section,
            'closed' => $this->closed,
            'contacted' => $this->contacted,
            'av' => $this->av,
            'av_requested' => $this->av_requested,
            'adult' => $this->adult,
            'desc_final' => $this->desc_final,
            'public' => $this->public,
            'double_length' => $this->double_length,
            'scheduled' => $this->scheduled,
            'panelists' => $this->panelists
        ), 'id=:id', array(':id'=> $this->id));
    }
    
    public function close() {
    	$command = Yii::app()->db->createCommand();
        $command->update('events', array(
            'closed' => 1
        ), 'id=:id', array(':id'=> $this->id));
    }
    
    public static function updateGrid() {
       $command = Yii::app()->db->createCommand("UPDATE events t SET panelists=(select count(*) from registration r where r.eventid = t.id)")->execute();
       $command = Yii::app()->db->createCommand("UPDATE events t SET scheduled=(select 1 from schedule s where s.event_id = t.id limit 1)")->execute();
       $command = Yii::app()->db->createCommand("UPDATE events t SET unconfirmed=(select count(*) from registration r where r.eventid = t.id AND r.confirmed=0)")->execute();
    }

    /**
     * Delete the user
     */
    public function delete() {
        $command = Yii::app()->db->createCommand();
        $command->delete('events', 'id=:id', array(':id' => $this->id));
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public static function searchBy($key, $value) {
        return Yii::app()->db->createCommand(array(
            'select' => '*',
            'from' => 'events',
            'where' => "$key=:val",
            'params' => array(':val' => $value),
        ))->queryRow();
    }

    /**
     * @param null $section
     * @return array
     */
    public static function getEvents($section = NULL) {
        if ($section) {
        	return Yii::app()->db->createCommand(array(
			'select' => '*',
			'from' => 'events',
			'order' => 'name',
			'where' => 'section=:section',
			'params' => array(':section' => $section)
		))->queryAll();
        } else {
		return Yii::app()->db->createCommand(array(
			'select' => '*',
			'from' => 'events',
			'order' => 'name'
		))->queryAll();
        }
    }
    
    /**
     * @param null $section
     * @return array
     */
    public static function getEventList($section = NULL, $search = NULL, $filters = NULL, $sort = NULL) {
    	$params = array();
    	$where = '';
    	if ($sort == 'panelists') {
    		$sort = $sort . ' desc';
    	} elseif ($sort == 'unconfirmed') {
    		$sort = $sort . ' asc';
    	} else {
    		$sort = 'name asc';
    	}
    	$options = array('type', 'closed', 'contacted', 'av', 'av_requested', 'public', 'double_length', 'desc_final', 'scheduled');
    	if ($section) {
    		$where = 'section=:section';
        	$params[':section'] = $section;
        }
        if ($filters && is_array($filters) && count($filters) > 0) {
        	foreach ($options as $key) {
        		if (isset($filters[$key]) && $filters[$key] != '') {
        			$where = ($where == '') ? $key . '=:' . $key : $where . ' AND ' . $key . '=:' . $key;
        			$params[':' . $key] = $filters[$key];
        		}
        	}
        }
        if ($search) {
        	$where = ($where == '') ? array('like', 'name', '%' . $search . '%') : array('and', $where, array('like', 'name', '%' . $search . '%'));
        }

        return Yii::app()->db->createCommand()
    		->select('*')
    		->from('events')
    		->where($where, $params)
    		->order($sort)
    		->queryAll();
    }
    
    /**
     * @return array
     */
    public static function getOpenEvents() {
        return Yii::app()->db->createCommand(array(
            'select' => '*',
            'from' => 'events',
            'where' => 'closed=0 AND public=1',
            'order' => 'name'
        ))->queryAll();
    }

    public static function getTypes() {
        return Yii::app()->db->createCommand(array(
            'select' => '*',
            'from' => 'event_types'
        ))->queryAll();
    }
    
    public static function getCount($type = 1, $closed = 0) {
    	$row = Yii::app()->db->createCommand(array(
    		'select' => 'count(id) as total',
    		'from' => 'events',
    		'where' => 'type=:type AND closed=:closed',
    		'params' => array(':type' => $type, ':closed' => $closed)
    	))->queryRow();
    	return $row['total'];
    }
    
    public static function getSectionCount($section = 1, $type = 1, $closed = 0) {
    	$row = Yii::app()->db->createCommand(array(
    		'select' => 'count(id) as total',
    		'from' => 'events',
    		'where' => 'section=:section AND type=:type AND closed=:closed',
    		'params' => array(':section' => $section, ':type' => $type, ':closed' => $closed)
    	))->queryRow();
    	return $row['total'];
    }
    
    public static function getMostRecentPanels() {
    	return Yii::app()->db->createCommand(array(
    		'select' => 'id, name',
    		'from' => 'events',
    		'order' => 'id DESC',
    		'limit' => 5
    	))->queryAll();
    }
    
    public static function getMostRecentClosedPanels() {
    	return Yii::app()->db->createCommand(array(
    		'select' => 'id, name',
    		'from' => 'events',
    		'where' => 'closed=1',
    		'order' => 'id DESC',
    		'limit' => '5'
    	))->queryAll();
    }
} 
