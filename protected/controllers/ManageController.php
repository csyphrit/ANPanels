<?php
/**
 * Class ManageController
 */
class ManageController extends Controller {
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
		$this->render('index');
	}

	public function actionConfig() {
		if (!empty($_POST)) {
			$values = Config::getValues();
			foreach ($values as $row) {
			    if (isset($_POST[$row['token']]) && $_POST[$row['token']] != $row['param']) {
			        Config::setValue($row['token'], $_POST[$row['token']]);
			    }
			}
		}
	
		$this->render('config');
	}
	
	public function actionSettings() {
		if (!empty($_POST)) {
			$values = SiteSettings::getValues();
			foreach ($values as $row) {
			    if (isset($_POST[$row['token']]) && $_POST[$row['token']] != $row['param']) {
			        SiteSettings::setValue($row['token'], $_POST[$row['token']]);
			    }
			}
		}
	
		$this->render('settings');
	}
	
	public function actionLog() {
	
	}
}