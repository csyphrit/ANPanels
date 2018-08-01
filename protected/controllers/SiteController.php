<?php
/**
 * Class SiteController
 */
class SiteController extends Controller {
	/**
	 * Declares class-based actions.
	 */
	public function actions() {
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha' => array(
				'class' => 'CCaptchaAction',
				'backColor' => 0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page' => array(
				'class' => 'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex() {
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$model = new LoginForm;
		$this->verifyLogin($model);
        	$user = UserHelper::getCurrentUser();
        	if (is_object($user) && $user->privilege >= 5) {
			$this->render('/admin/index', array('model' => $model));
		} else {
        		
			$this->render('index', array('model' => $model));
		}
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError() {
		if ($error = Yii::app()->errorHandler->error) {
			if (Yii::app()->request->isAjaxRequest) {
				echo $error['message'];
           		} else {
				$this->render('error', $error);
			}
		}
	}

    /**
     * Create a new panel
     */
    public function actionAddPanel() {
        $panels = PanelHelper::getUserPanels();
        $user = UserHelper::getCurrentUser();
        $model = new PanelForm();
        $error = '';
        $regOpen = Config::getValue('REGISTRATION_OPEN');
        if ($user->privilege > 6) {
            $regOpen = true;
        }

        if (isset($_POST['PanelForm'])) {
            $data = $_POST['PanelForm'];
            $model->attributes = $data;
            $model->comments = $data['comments'];
            $data['name'] = ucwords(trim($data['name']));
            $data['name'] = rtrim($data['name'], ' ' + date('Y'));

            if ($model->validate()) {
                $event = PanelHelper::getEventByName($data['name']);
                if ($event == NULL) {
                    $event = new Event();
                    $event->setData($data);
                    $event->create();
                    $model->moderator = 1;
                } else {
                    $model->moderator = 0;
                }
                $model->eventid = $event->id;
                
                if (!$event->closed) {
                	$registration = new Registration();
                	$registration->setData($model->attributes);
                	$registration->create();
                	$sections = PanelHelper::getSections();
                	$comments = '';
                	
                	if (is_object($user->profile)) {               	
                		$mail = new YiiMailer('panel', array('event' => $event, 'userid' => $registration->userid, 'comments' => $registration->comments));
                		$mail->setFrom('webmaster@anpanels.com', 'ANPanels');
				$mail->setReplyTo($user->profile->email);
				$mail->setTo(PanelHelper::getSectionEmail($event->section));
				$mail->setSubject(Config::getValue('CONVENTION_NAME') . ' - New Panel Registration - ' . $event->name);
				if (!$mail->send()) {
			   		Log::set($row['userid'], 'email error', $mail->getError());
				}
				unset($mail);
		
				$mail = new YiiMailer('panel', array('event' => $event, 'userid' => $registration->userid, 'comments' => $registration->comments));
				$mail->setFrom('webmaster@anpanels.com', 'ANPanels');
				$mail->setTo($user->profile->email);
				$mail->setReplyTo(PanelHelper::getSectionEmail($event->section));
				$mail->setSubject(Config::getValue('CONVENTION_NAME') . ' - New Panel Registration - ' . $event->name);
				if (!$mail->send()) {
			   		Log::set($row['userid'], 'email error', $mail->getError());
				}
				unset($mail);
			}
		
			Log::set($event->id, 'panel registration', '');
			
			$max = Config::getValue('MAX_PANELISTS');
               		if ($max > 0) {
                		$panelists = Registration::getUsersByEvent($event->id);
                		if (count($panelists) >= $max) {
                			$event->close();
                		}
                	}

                	$this->redirect(Yii::app()->user->returnUrl);
                } else {
                	$error = 'The event you registered for is closed.';
                }
                
                
            }
        }

        $this->render('addpanel', array('panels' => $panels, 'model' => $model, 'error' => $error, 'regOpen' => $regOpen));
    }

    /**
     * Create a new gameshow
     */
    public function actionAddGameshow() {
        $model = new GameshowForm();
        $error = '';
        $user = UserHelper::getCurrentUser();
        $regOpen = Config::getValue('REGISTRATION_OPEN');
        if ($user->privilege > 6) {
            $regOpen = true;
        }

        if (isset($_POST['GameshowForm'])) {
            $data = $_POST['GameshowForm'];
            $model->attributes = $data;
            $model->comments = $data['comments'];
            $data['name'] = ucwords(trim($data['name']));
            $data['name'] = rtrim($data['name'], ' ' + date('Y'));

            if ($model->validate()) {
                $event = PanelHelper::getEventByName($data['name']);
                if ($event == NULL) {
                    $event = new Event();
                    $event->setData($data);
                    $event->create();
                    $model->moderator = 1;
                } else {
                    $model->moderator = 0;
                }
                $model->eventid = $event->id;
                
                if (!$event->closed) {
                	$registration = new Registration();
                	$registration->setData($model->attributes);
                	$registration->create();
                	$sections = PanelHelper::getSections();
                	$comments = '';
                	$user = UserHelper::getCurrentUser();
                	
                	if (is_object($user->profile)) {               	
                		$mail = new YiiMailer('panel', array('event' => $event, 'userid' => $registration->userid, 'comments' => $registration->comments));
                		$mail->setFrom('webmaster@anpanels.com', 'ANPanels');
				$mail->setReplyTo($user->profile->email);
				$mail->setTo(PanelHelper::getSectionEmail($event->section));
				$mail->setSubject(Config::getValue('CONVENTION_NAME') . ' - New Gameshow Registration - ' . $event->name);
				if (!$mail->send()) {
			   		Log::set($row['userid'], 'email error', $mail->getError());
				}
				unset($mail);
		
				$mail = new YiiMailer('panel', array('event' => $event, 'userid' => $registration->userid, 'comments' => $registration->comments));
				$mail->setFrom('webmaster@anpanels.com', 'ANPanels');
				$mail->setTo($user->profile->email);
				$mail->setReplyTo(PanelHelper::getSectionEmail($event->section));
				$mail->setSubject(Config::getValue('CONVENTION_NAME') . ' - New Gameshow Registration - ' . $event->name);
				if (!$mail->send()) {
			   		Log::set($row['userid'], 'email error', $mail->getError());
				}
				unset($mail);
			}
		
			Log::set($event->id, 'gameshow registration', '');

                	$this->redirect(Yii::app()->user->returnUrl);
                } else {
                	$error = 'The event you registered for is closed.';
                }
                
                
            }
        }

        $this->render('addgameshow', array('model' => $model, 'error' => $error, 'regOpen' => $regOpen));
    }
    
    /**
     * Create a new workshop
     */
    public function actionAddWorkshop() {
        $model = new WorkshopForm();
        $error = '';
        $user = UserHelper::getCurrentUser();
        $regOpen = Config::getValue('REGISTRATION_OPEN');
        if ($user->privilege > 6) {
            $regOpen = true;
        }

        if (isset($_POST['WorkshopForm'])) {
            $data = $_POST['WorkshopForm'];
            $model->attributes = $data;
            $model->comments = $data['comments'];
            $data['type'] = 2;
            $data['name'] = ucwords(trim($data['name']));
            $data['name'] = rtrim($data['name'], ' ' + date('Y'));

            if ($model->validate()) {
                $event = PanelHelper::getEventByName($data['name']);
                if ($event == NULL) {
                    $event = new Event();
                    $event->setData($data);
                    $event->create();
                    $model->moderator = 1;
                } else {
                    $model->moderator = 0;
                }
                $model->eventid = $event->id;
                
                if (!$event->closed) {
                	$registration = new Registration();
                	$registration->setData($model->attributes);
                	$registration->create();
                	$sections = PanelHelper::getSections();
                	$comments = '';
                	$user = UserHelper::getCurrentUser();
                	
                	if (is_object($user->profile)) {               	
                		$mail = new YiiMailer('panel', array('event' => $event, 'userid' => $registration->userid, 'comments' => $registration->comments));
                		$mail->setFrom('webmaster@anpanels.com', 'ANPanels');
				$mail->setReplyTo($user->profile->email);
				$mail->setTo(PanelHelper::getSectionEmail($event->section));
				$mail->setSubject(Config::getValue('CONVENTION_NAME') . ' - New Workshop Registration - ' . $event->name);
				if (!$mail->send()) {
			   		Log::set($row['userid'], 'email error', $mail->getError());
				}
				unset($mail);
		
				$mail = new YiiMailer('panel', array('event' => $event, 'userid' => $registration->userid, 'comments' => $registration->comments));
				$mail->setFrom('webmaster@anpanels.com', 'ANPanels');
				$mail->setTo($user->profile->email);
				$mail->setReplyTo(PanelHelper::getSectionEmail($event->section));
				$mail->setSubject(Config::getValue('CONVENTION_NAME') . ' - New Workshop Registration - ' . $event->name);
				if (!$mail->send()) {
			   		Log::set($row['userid'], 'email error', $mail->getError());
				}
				unset($mail);
			}
		
			Log::set($event->id, 'workshop registration', '');

                	$this->redirect(Yii::app()->user->returnUrl);
                } else {
                	$error = 'The event you registered for is closed.';
                }
                
                
            }
        }

        $this->render('addworkshop', array('model' => $model, 'error' => $error, 'regOpen' => $regOpen));
    }
    
    /**
     * Create a new workshop
     */
    public function actionAddGuestEvent() {
        $model = new GuestEventForm();
        $error = '';
        $user = UserHelper::getCurrentUser();
        $regOpen = Config::getValue('REGISTRATION_OPEN');
        if ($user->privilege > 6) {
            $regOpen = true;
        }

        if (isset($_POST['GuestEventForm'])) {
            $data = $_POST['GuestEventForm'];
            $model->attributes = $data;
            $model->comments = $data['comments'];
            $data['type'] = 4;
            $data['name'] = ucwords(trim($data['name']));
            $data['name'] = rtrim($data['name'], ' ' + date('Y'));

            if ($model->validate()) {
                $event = PanelHelper::getEventByName($data['name']);
                if ($event == NULL) {
                    $event = new Event();
                    $event->setData($data);
                    $event->create();
                    $model->moderator = 1;
                } else {
                    $model->moderator = 0;
                }
                $model->eventid = $event->id;
                
                if (!$event->closed) {
                	$registration = new Registration();
                	$registration->setData($model->attributes);
                	$registration->create();
                	$sections = PanelHelper::getSections();
                	$comments = '';
                	$user = UserHelper::getCurrentUser();
                	
                	if (is_object($user->profile)) {               	
                		$mail = new YiiMailer('panel', array('event' => $event, 'userid' => $registration->userid, 'comments' => $registration->comments));
                		$mail->setFrom('webmaster@anpanels.com', 'ANPanels');
				$mail->setReplyTo($user->profile->email);
				$mail->setTo(PanelHelper::getSectionEmail($event->section));
				$mail->setSubject(Config::getValue('CONVENTION_NAME') . ' - New Guest Event - ' . $event->name);
				if (!$mail->send()) {
			   		Log::set($row['userid'], 'email error', $mail->getError());
				}
				unset($mail);
		
				$mail = new YiiMailer('panel', array('event' => $event, 'userid' => $registration->userid, 'comments' => $registration->comments));
				$mail->setFrom('webmaster@anpanels.com', 'ANPanels');
				$mail->setTo($user->profile->email);
				$mail->setReplyTo(PanelHelper::getSectionEmail($event->section));
				$mail->setSubject(Config::getValue('CONVENTION_NAME') . ' - New Guest Event - ' . $event->name);
				if (!$mail->send()) {
			   		Log::set($row['userid'], 'email error', $mail->getError());
				}
				unset($mail);
			}
		
			Log::set($event->id, 'guest event registration', '');

                	$this->redirect(Yii::app()->user->returnUrl);
                } else {
                	$error = 'The event you registered for is closed.';
                }
                
                
            }
        }

        $this->render('addguestevent', array('model' => $model, 'error' => $error, 'regOpen' => $regOpen));
    }
    
	/**
	 * Displays the contact page
	 */
	public function actionRegister() {
        $model = new RegisterForm();
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'register-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if (isset($_POST['RegisterForm'])) {
        	$user = UserHelper::getUserByEmail($_POST['RegisterForm']['email']);
        	if ($user !== NULL) {
           		$model->addError('email', 'Email address already in use.');
        	} else {
		   	    $model->attributes = $_POST['RegisterForm'];
			    if ($model->validate()) {
               			$user = new User();
               			$user->setData($model->attributes, TRUE);
               			$user->create();
               			$userid = $user->id;

               			$profile = new Profile();
               			$profile->setData(array_merge(array('userid' => $userid), $_POST['RegisterForm']), TRUE);
               			$profile->create();
               			$user->profile = $profile;

		   	        $mail = new YiiMailer('registration', array('profile' => $profile));
		   	        $mail->setFrom('webmaster@anpanels.com', 'ANPanels');
		   	        $mail->setTo($_POST['RegisterForm']['email']);
		   	        $mail->setReplyTo(Config::getValue('PANELMASTER_EMAIL'));
		   	        $mail->setSubject(Config::getValue('CONVENTION_NAME') . ' - New User Registration');
		   	        $mail->send();
		   	        unset($mail);

               			$model->login();
               			
               			Log::set(0, 'new user registration', '');
               			$this->redirect(Yii::app()->user->returnUrl);
           		    }
			}
		}
		$this->render('register', array('model' => $model));
	}

    /**
     * Displays the profile edit
     */
    public function actionProfile() {
        $model = new ProfileForm();
        $profile = new Profile();

        // collect user input data
        if (isset($_POST['ProfileForm'])) {
            if (isset($_POST['ProfileForm']['password'])) {
                User::savePassword(md5($_POST['ProfileForm']['password']), UserHelper::getCurrentUserId());
            } else {
                $model->setData($_POST['ProfileForm']);
                if ($model->validate()) {
                    $profile->setData(array_merge(array('userid' => UserHelper::getCurrentUserId()), $_POST['ProfileForm']), TRUE);
                    $profile->save();
                }
            }
            
            $this->redirect(Config::getValue('URL'));
        }
        	$user = UserHelper::getCurrentUser();
        	$model->setData($user->profile->attributes);
        	$model->regStatus = $user->profile->regStatus;

        $this->render('profile', array('model' => $model));
    }

    /**
     * Show the user's schedule
     */
    public function actionSchedule() {
        $this->render('schedule');
    }

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model = new LoginForm;
		$this->verifyLogin($model);
		// display the login form
		$this->render('login', array('model' => $model));
	}

	/**
	 * @param $model LoginForm
	 */
	protected function verifyLogin($model) {
		// if it is ajax validation request
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if (isset($_POST['LoginForm'])) {
			$model->attributes = $_POST['LoginForm'];
			
			// validate user input and redirect to the previous page if valid
			if ($model->validate() && $model->login()) {
				User::login(UserHelper::getCurrentUserId());
				$this->redirect(Yii::app()->user->returnUrl);
			} else {
				$model->addError('password', 'Incorrect username or password.');
			}
		}
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout() {
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	/**
	 * Recover forgotten password
	 */
	public function actionForgotPassword() {
		$this->render('forgotPassword');
	}
	
	/**
	 * Reset user's password
	 */
	 public function actionResetPassword() {
	   $email = $_POST['email'];
	   if (empty($email)) {
		echo CJSON::encode(array('status'=>'error'));
           }
	   
	   $user = UserHelper::getUserByEmail($email);
	   if (is_object($user)) {
	     	$password = $this->getRandomWord(6) . rand(0, 9999);
	     	$user->savePassword(md5($password), $user->id);
	   
	   	$mail = new YiiMailer('forgotpassword', array('password' => $password));
		$mail->setFrom('webmaster@anpanels.com', 'ANPanels');
		$mail->setTo($email);
		$mail->setReplyTo('webmaster@anpanels.com', 'ANPanels');
		$mail->setSubject(Config::getValue('CONVENTION_NAME') . ' - Password Reset Notification');
		$mail->send();
		unset($mail);
	     	Log::set(0, 'forgot password', $email . ' - ' . $password);
	   
	     	echo CJSON::encode(array('status'=>'ok'));
	   } else {
	     	echo CJSON::encode(array('status'=>'error'));
	   }
	 }
	 
	 public function getRandomWord($len = 10) {
		$word = array_merge(range('a', 'z'), range('A', 'Z'));
		shuffle($word);
		return substr(implode($word), 0, $len);
	 }
	 
    public function actionAddAttendee() {
        $eventId = $_POST['eventid'];
        $userId = $_POST['userid'];
        $host = isset($_POST['host']) ? $_POST['host'] : 0;
        if ($eventId <= 0 || $userId <= 0) {
            echo CJSON::encode(array('status'=>'error'));
        } else {
            $reg = new Attendance();
            $reg->userid = $userId;
            $reg->eventid = $eventId;
            $status = $reg->create();
	    
	    Log::set($eventId, 'attendee added', "$userId was added to $eventId");

            if ($status) {
                echo CJSON::encode(array('status'=>'ok'));
            } else {
                echo CJSON::encode(array('status'=>'error'));
            }
        }
    }
}