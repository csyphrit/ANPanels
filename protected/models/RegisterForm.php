<?php
/**
 * RegisterForm class.
 */
class RegisterForm extends CFormModel
{
	public $username;
	public $password;
	public $name;
    	public $regStatus;
    	public $alias;
    	public $forumName;
    	public $address;
    	public $city;
    	public $state;
    	public $zip;
    	public $country;
    	public $phone;
    	public $email;
    	public $age;
    	public $unavailable;
    	public $status;
    	public $prev_panelist;
    	public $prev_panels;
    	public $ocprev_panelist;
    	public $ocprev_panels;
    	public $prev_mod;
    	public $prev_mod_panels;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('password, name, regStatus, email, age', 'required'),
            		array('regStatus', 'in', 'range' => array('Y', 'W', 'N'), 'allowEmpty' => false),
            		array('email', 'email'),
            		array('age', 'in', 'range' => array('18+', '16-18', '15-0'), 'allowEmpty' => false),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
            		'name' => 'Registered Name',
            		'alias' => 'Alias',
            		'regStatus' => 'Registration Status',
            		'address' => 'Mailing Address',
			'state' => 'State/Province',
			'zip' => 'Postal Code',
            		'phone' => 'Phone Number',
            		'email' => 'Email Address',
            		'unavailable' => 'I will be unavailable for panels during',
            		'prev_panelist' => 'Have you done panels at ' . Config::getValue('CONVENTION_NAME') . ' before?',
            		'prev_panels' => Yii::t('site', 'PREV_PANELS'),
            		'ocprev_panelist' => 'Have you done panels at other cons before?',
            		'ocprev_panels' => Yii::t('site', 'OCPREV_PANELS'),
            		'prev_mod' => Yii::t('site', 'PREV_MOD'),
            		'prev_mod_panels' => Yii::t('site', 'PREV_MOD_PANELS'),
		);
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		$this->_identity = new UserIdentity($this->email, $this->password);
		$this->_identity->authenticate();

		if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
			$duration = isset($this->rememberMe) ? 3600 * 24 * 30 : 0; // 30 days
			Yii::app()->user->login($this->_identity, $duration);
			return true;
		}
		return false;
	}
}