<?php
/**
 * Admin Controller
 */
class AdminController extends Controller {
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        $this->render('index');
    }
    
    /**
     * Render reports page
     */
    public function actionReports() {
        $this->render('reports');
    }

    public function actionMail() {
        if (isset($_POST['content'])) {
             //TODO: Send to mailing list
             Announcements::addAnnouncement($_POST['subject'], $_POST['content']);
        }
        $this->render('mail');
    }

    /**
     * Render event grid
     * @param $section
     */
    public function actionEvents($section = NULL) {    
        $model = new Event();
        $form = new EventSearchForm();
        $model->updateGrid();
        $items = array();
        
        $user = UserHelper::getCurrentUser();
		if ($user->privilege < 7) {
			$section = UserSection::getSection($user->id);
		}
		$search = NULL;
		$sort = NULL;
		$params = array();
		if (count($_POST) > 1 && isset($_POST['EventSearchForm']) && is_array($_POST['EventSearchForm'])) {
			$params = $_POST['EventSearchForm'];
			if (isset($_POST['EventSearchForm']['search'])) {
				$search = $_POST['EventSearchForm']['search'];
				$form->search = $search;
			}
			if (isset($_POST['EventSearchForm']['sort'])) {
				$sort = $_POST['EventSearchForm']['sort'];
				$form->sort = $sort;
			}
		}
		$items = $model->getEventList($section, $search, $params, $sort);
    	
        $this->render('events', array('form' => $form, 'section' => $section, 'events' => $items));
    }
    
    /**
     * Render panelist grid
     */
    public function actionUsers() {
        $model = new Profile('search');
        $model->unsetAttributes();
        if (isset($_GET['Profile'])) {
            $model->attributes = $_GET['Profile'];
        }
        $this->render('panelists', array('model' => $model));
    }

    /**
     * Render an event page
     * @param $id
     */
     public function actionEvent($id) {
        if ($id <= 0) {
            $this->render('error', array('code' => '1', 'message' => 'Invalid event id'));
        }
        
        $error = '';
        $model = new PanelForm();
        if (isset($_POST['eventId'])) {
            $model->attributes = $_POST;
            $model->justification = 'admin';

            if ($model->validate()) {
                $event = PanelHelper::getEventById($_POST['eventId']);
                
                if (!$event->closed && $_POST['closed']) {
                    $users = Registration::getUsersByEvent($_POST['eventId']);
                    foreach ($users as $row) {
                	$user = UserHelper::getUserById($row['userid']);
                	
                	$mail = new YiiMailer('closePanel', array('event' => $event, 'users' => $users));
			$mail->setFrom('webmaster@anpanels.com', 'ANPanels');
			$mail->setReplyTo(Config::getValue('PANELMASTER_EMAIL'));
			$mail->setTo($user->profile->email);
			$mail->setSubject(Config::getValue('CONVENTION_NAME') . ' - Panel Approved - ' . $event->name);
			if (!$mail->send()) {
			   Log::set($row['userid'], 'email error', $mail->getError());
			}
			unset($mail);
                    }
                    
                    $closeEmail = Config::getValue('CLOSE_EMAIL');
        	    if (!empty($closeEmail)) {
        	        $mail = new YiiMailer('closePanel', array('event' => $event, 'users' => $users));
			$mail->setFrom('webmaster@anpanels.com', 'ANPanels');
			$mail->setReplyTo(Config::getValue('PANELMASTER_EMAIL'));
			$mail->setTo($closeEmail);
			$mail->setSubject(Config::getValue('CONVENTION_NAME') . ' - Panel Approved - ' . $event->name);
			if (!$mail->send()) {
			   Log::set(0, 'email error', $mail->getError());
			}
			unset($mail);
        	    }
                }
                
                if (is_object($event)) {
                    $event->name = $_POST['name'];
                    $event->type = $_POST['type'];
                    $event->description = $_POST['description'];
                    $event->section = $_POST['section'];
                    $event->closed = $_POST['closed'];
                    $event->contacted = $_POST['contacted'];
                    $event->av = $_POST['av'];
                    $event->av_requested = $_POST['av_requested'];
                    $event->adult = $_POST['adult'];
                    $event->desc_final = $_POST['desc_final'];
                    $event->public = $_POST['public'];
                    $event->double_length = $_POST['double_length'];
                    $event->save();
                } else {
                    $error = 'Unable to locate event';
                }
            } else {
                $error = 'Invalid form data';
            }
        }

        $this->render('event', array('eventId' => $id, 'error' => $error));
    }
    
    public function actionClosePanel() {
    	$event = PanelHelper::getEventById($_POST['eventId']);
    	if (is_object($event)) {
                $event->closed = 1;
                $event->contacted = 1;
                $event->save();
                
        	$users = Registration::getUsersByEvent($_POST['eventId']);
        	foreach ($users as $row) {
                	$user = UserHelper::getUserById($row['userid']);
                	if (!is_object($user) || !is_object($user->profile)) {
                	  Log::set($row['userid'], 'user error', 'Cannot find user with given id.');
                	  continue;
                	}
                	Registration::confirm($_POST['eventId'], $row['userid']);
                	
                	$mail = new YiiMailer('closePanel', array('event' => $event, 'users' => $users));
			$mail->setFrom('webmaster@anpanels.com', 'ANPanels');
			$mail->setReplyTo(Config::getValue('PANELMASTER_EMAIL'));
			$mail->setTo($user->profile->email);
			$mail->setSubject(Config::getValue('CONVENTION_NAME') . ' - Panel Approved - ' . $event->name);
			if (!$mail->send()) {
			   Log::set($row['userid'], 'email error', $mail->getError());
			}
			unset($mail);
        	}
        	
        	$closeEmail = Config::getValue('CLOSE_EMAIL');
        	if (!empty($closeEmail)) {
        		$mail = new YiiMailer('closePanel', array('event' => $event, 'users' => $users));
			$mail->setFrom('webmaster@anpanels.com', 'ANPanels');
			$mail->setTo($closeEmail);
			$mail->setReplyTo(Config::getValue('PANELMASTER_EMAIL'));
			$mail->setSubject(Config::getValue('CONVENTION_NAME') . ' - Panel Approved - ' . $event->name);
			if (!$mail->send()) {
			   Log::set(0, 'email error', $mail->getError());
			}
			unset($mail);
        	}
        	
            echo CJSON::encode(array('status'=>'ok'));
        } else {
            echo CJSON::encode(array('status'=>'error'));
        }
    }
    
    /**
     * Render an user page
     * @param $id
     */
    public function actionUser($id) {
        if ($id <= 0) {
            $this->render('error', array('code' => '1', 'message' => 'Invalid user id'));
        }

        $this->render('user', array('userId' => $id));
    }
    
    public function actionDeleteUser() {
        $userId = $_POST['userid'];
        if ($userId <= 0) {
            echo CJSON::encode(array('status'=>'error'));
        } else {
            $user = UserHelper::getUserById($userId);
            if (is_object($user)) {
                Registration::deleteUser($userId);
		$user->profile->delete();
                $user->delete();
                
                Log::set($userId, 'user deleted', '');
                
                echo CJSON::encode(array('status'=>'ok'));
            } else {
                echo CJSON::encode(array('status'=>'error'));
            }
        }
    }

    /**
     * Ajax request to merge two events
     */
    public function actionMerge() {
        $eventId = $_POST['eventid'];
        $mergeId = $_POST['mergeid'];
        if ($eventId <= 0 || $mergeId <= 0 || ($eventId == $mergeId)) {
            echo CJSON::encode(array('status'=>'error'));
        } else {
            $status = Registration::merge($eventId, $mergeId);
            if ($status) {
                $event = new Event();
                $event->id = $mergeId;
                $event->delete();
                
                Log::set($eventId, 'events merged', "Event $mergeId was merged into $eventId");

                echo CJSON::encode(array('status'=>'ok'));
            } else {
                echo CJSON::encode(array('status'=>'error'));
            }
        }
    }
    
    /**
     * Ajax request to delete event
     */
    public function actionDeletePanel() {
        $eventId = $_POST['eventid'];
        if ($eventId <= 0) {
            echo CJSON::encode(array('status'=>'error'));
        } else {
            $event = PanelHelper::getEventById($eventId);
            if (is_object($event)) {
                $body = $event->name . ' has been cancelled due to lack of interest and/or time slots. If you believe there is reason to reverse this action, please contact us as soon as possible.';
            
                $users = Registration::getUsersByEvent($eventId);
                foreach ($users as $row) {
                	$user = UserHelper::getUserById($row['userid']);
                	
                	if (is_object($user) && is_object($user->profile)) {
                		$mail = new YiiMailer('deletePanel', array('event' => $event, 'userid' => $row['userid']));
                		$mail->setFrom('webmaster@anpanels.com', Config::getValue('CONVENTION_NAME'));
				$mail->setTo($user->profile->email);
				$mail->setReplyTo(Config::getValue('PANELMASTER_EMAIL'));
				$mail->setSubject(Config::getValue('CONVENTION_NAME') . ' - Panel Deleted - ' . $event->name);
				if (!$mail->send()) {
			   		Log::set(0, 'email error', $mail->getError());
				}
				unset($mail);
			}
                }
            
                Registration::deleteEvent($eventId);
                Schedule::clearEvents($eventId);
                $event->delete();
                
                Log::set($eventId, 'panel deleted', '');
                
                echo CJSON::encode(array('status'=>'ok'));
            } else {
                echo CJSON::encode(array('status'=>'error'));
            }
        }
    }

    /**
     * Ajax request to confirm panelist
     */
    public function actionConfirm() {
        $eventId = $_POST['eventid'];
        $userId = $_POST['userid'];
        if ($eventId <= 0 || $userId <= 0) {
            echo CJSON::encode(array('status'=>'error'));
        } else {
            $status = Registration::confirm($eventId, $userId);
            if ($status) {
                echo CJSON::encode(array('status'=>'ok'));
            } else {
                echo CJSON::encode(array('status'=>'error'));
            }
        }
    }

    /**
     * Ajax request to unconfirm panelist
     */
    public function actionUnconfirm() {
        $eventId = $_POST['eventid'];
        $userId = $_POST['userid'];
        if ($eventId <= 0 || $userId <= 0) {
            echo CJSON::encode(array('status'=>'error'));
        } else {
            $status = Registration::unconfirm($eventId, $userId);
            if ($status) {
                echo CJSON::encode(array('status'=>'ok'));
            } else {
                echo CJSON::encode(array('status'=>'error'));
            }
        }
    }

    /**
     * Ajax request to promote panelist
     */
    public function actionPromote() {
        $eventId = $_POST['eventid'];
        $userId = $_POST['userid'];
        if ($eventId <= 0 || $userId <= 0) {
            echo CJSON::encode(array('status'=>'error'));
        } else {
            $status = Registration::promote($eventId, $userId);
            if ($status) {
                echo CJSON::encode(array('status'=>'ok'));
            } else {
                echo CJSON::encode(array('status'=>'error'));
            }
        }
    }

    /**
     * Ajax request to remove panelist from panel
     */
    public function actionRemovePanelist() {
        $eventId = $_POST['eventid'];
        $userId = $_POST['userid'];
        if ($eventId <= 0 || $userId <= 0) {
            echo CJSON::encode(array('status'=>'error'));
        } else {
            $reg = new Registration();
            $reg->userid = $userId;
            $reg->eventid = $eventId;
            $status = $reg->delete();
            
            $user = UserHelper::getUserById($userId);
            $event = PanelHelper::getEventById($eventId);
            
            $body = 'You have been removed as a panelist from ' . $event->name . ' due to either overstaffing or personal request. If you believe there is reason to reverse this action, please contact us as soon as possible.';
            
            $mail = new YiiMailer('removePanelist', array('event' => $event));
            $mail->setFrom('webmaster@anpanels.com', Config::getValue('CONVENTION_NAME'));
	    $mail->setTo($user->profile->email);
	    $mail->setReplyTo(Config::getValue('PANELMASTER_EMAIL'));
	    $mail->setSubject(Config::getValue('CONVENTION_NAME') . ' - Panelist Removed - ' . $event->name);
	    if (!$mail->send()) {
	    	Log::set(0, 'email error', $mail->getError());
	    }
	    unset($mail);
	    
	    Log::set($eventId, 'panelist removed', "$userId was removed from $eventId");

            if ($status) {
                echo CJSON::encode(array('status'=>'ok'));
            } else {
                echo CJSON::encode(array('status'=>'error'));
            }
        }
    }

    /**
     * Ajax request to add panelist to panel
     */
    public function actionAddPanelist() {
        $eventId = $_POST['eventid'];
        $userId = $_POST['userid'];
        $host = isset($_POST['host']) ? $_POST['host'] : 0;
        if ($eventId <= 0 || $userId <= 0) {
            echo CJSON::encode(array('status'=>'error'));
        } else {
            $reg = new Registration();
            $reg->userid = $userId;
            $reg->eventid = $eventId;
            $reg->moderator = $host;
            $reg->description = isset($_POST['description']) ? $_POST['description'] : '';
            $reg->justification = isset($_POST['justification']) ? $_POST['justification'] : 'Admin add';
            $status = $reg->create();
            
            $user = UserHelper::getUserById($userId);
            $profile = $user->profile;
            $event = PanelHelper::getEventById($eventId);
            
            $body = 'You have been added as a panelist for ' . $event->name . '. If you believe there is reason to reverse this action, please contact us as soon as possible.';
            
            $mail = new YiiMailer('addPanelist', array('event' => $event));
            $mail->setFrom('webmaster@anpanels.com', Config::getValue('CONVENTION_NAME'));
	    $mail->setTo($user->profile->email);
	    $mail->setReplyTo(Config::getValue('PANELMASTER_EMAIL'));
	    $mail->setSubject(Config::getValue('CONVENTION_NAME') . ' - Panelist Added - ' . $event->name);
	    if (!$mail->send()) {
		Log::set(0, 'email error', $mail->getError());
	    }
	    unset($mail);
	    
	    if ($event->closed) {
	        $body = $profile->name . ' (' . $profile->email . ')' . ' has been added as a panelist for ' . $event->name . '. If you believe there is reason to reverse this action, please contact us as soon as possible.';
	        $users = Registration::getUsersByEvent($eventId);
        	foreach ($users as $row) {
                	$user = UserHelper::getUserById($row['userid']);
                	
                	$mail = new YiiMailer('panelistAdded', array('event' => $event, 'profile' => $profile));
                	$mail->setFrom('webmaster@anpanels.com', Config::getValue('CONVENTION_NAME'));
	        	$mail->setTo($user->profile->email);
	        	$mail->setReplyTo(Config::getValue('PANELMASTER_EMAIL'));
	        	$mail->setSubject(Config::getValue('CONVENTION_NAME') . ' - Panelist Added - ' . $event->name);
	        	if (!$mail->send()) {
		    		Log::set(0, 'email error', $mail->getError());
	        	}
	        	unset($mail);
        	}
	    }
	    
	    Log::set($eventId, 'panelist added', "$userId was added to $eventId");

            if ($status) {
                echo CJSON::encode(array('status'=>'ok'));
            } else {
                echo CJSON::encode(array('status'=>'error'));
            }
        }
    }

    /**
     * Scheduler
     */
    public function actionSchedule() {
        if ($_POST['eventId'] <= 0 || $_POST['roomId'] <= 0) {
            $this->render('error', array('code' => '1', 'message' => 'Invalid user id'));
        }
        $this->render('schedule', array('eventId' => $_POST['eventId'], 'roomId' => $_POST['roomId'], 'hours' => $_POST['hours']));
    }

    /**
     * Ajax request to schedule to panel
     */
    public function actionSchedulePanel() {
        $eventId = $_POST['eventid'];
        $roomId = $_POST['roomid'];
        $day = $_POST['day'];
        $time = $_POST['time'];
        $hours = $_POST['hours'];
        if ($eventId <= 0 || $roomId <= 0) {
            echo CJSON::encode(array('status'=>'error'));
        } else {
            Schedule::clearEvents($eventId);
            if ($hours > 1) {
               for ($i = 0; $i < $hours; $i++) {
                   $sched = new Schedule();
                   $sched->eventid = $eventId;
                   $sched->room = $roomId;
                   $sched->day = $day;
                   $sched->time = $time + (100 * $i);
                   $sched->hours = $hours;
                   
                   if ($sched->time > 2400) {
                       $sched->time = $sched->time - 2400;
                   }
                   
                   $status = $sched->save();
               }
            } else {
                        $sched = new Schedule();
            $sched->eventid = $eventId;
            $sched->room = $roomId;
            $sched->day = $day;
            $sched->time = $time;
            $sched->hours = $hours;
            $status = $sched->save();
            }

            if ($status) {
                echo CJSON::encode(array('status'=>'ok'));
            } else {
                echo CJSON::encode(array('status'=>'error'));
            }
        }
    }

    /**
     * Show error page
     */
    public function actionError() {
        $this->render('site/error');
    }
    
    public function actionApproveAV() {
    	$eventId = $_POST['eventid'];
    	if ($eventId <= 0) {
            echo CJSON::encode(array('status'=>'error'));
        } else {
            $event = PanelHelper::getEventById($eventId);
            $event->av = 1;
            $event->av_requested = 0;
            $status = $event->save();
            
            $body = $event->name . ' has been approved for the use of AV. Unless other arrangements have been made, your files will be located on the desktop of the computer in the panel room, most likely in a folder called "Your Files are here". Please warn the panel staff if any changes need to be made before the convention.';
            
            $users = Registration::getUsersByEvent($eventId);
            foreach ($users as $row) {
                	$user = UserHelper::getUserById($row['userid']);
                	
                	$mail = new YiiMailer('approveAV', array('event' => $event));
                	$mail->setFrom('webmaster@anpanels.com', Config::getValue('CONVENTION_NAME'));
	        	$mail->setTo($user->profile->email);
	        	$mail->setReplyTo(Config::getValue('PANELMASTER_EMAIL'));
	        	$mail->setSubject(Config::getValue('CONVENTION_NAME') . ' - AV Approved - ' . $event->name);
	        	if (!$mail->send()) {
		    		Log::set(0, 'email error', $mail->getError());
	        	}
	        	unset($mail);
            }

            if ($status) {
                echo CJSON::encode(array('status'=>'ok'));
            } else {
                echo CJSON::encode(array('status'=>'error'));
            }
        }
    }
    
   public function actionAddPanel() {
        $model = new PanelForm();
        $error = '';

        if (isset($_POST['PanelForm'])) {
            $model->attributes = $_POST['PanelForm'];
            $model->justification = 'admin';

            if ($model->validate()) {
                $event = PanelHelper::getEventByName($_POST['PanelForm']['name']);
                if ($event == NULL) {
                    $event = new Event();
                    $event->setData($_POST['PanelForm']);
                    $event->create();
                    
                    Log::set($event->id, 'panel registration', '');
                    
                    $this->redirect(Yii::app()->createUrl('/admin/event', array('id' => $event->id)));
                } else {
                    $error = 'This panel already exists.';
                }
            }
        }

        $this->render('addpanel', array('model' => $model, 'error' => $error));
    }
} 
