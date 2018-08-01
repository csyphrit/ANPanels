<?php
/**
 * RegisterForm class.
 */
class ProfileForm extends CFormModel
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
    public $salt;
    public $status;
    public $prev_panelist;
    	public $prev_panels;
    	public $ocprev_panelist;
    	public $ocprev_panels;
    	public $prev_mod;
    	public $prev_mod_panels;
    
        public function setData($data) {
        if (!is_array($data)) {
            return FALSE;
        }
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
        $this->regStatus = isset($data['regStatus']) ? $data['regStatus'] : ($data['reg_status'] ? $data['reg_status'] : 'N');
         $this->prev_panelist = isset($data['prev_panelist']) ? $data['prev_panelist'] : '0';
        $this->prev_panels = isset($data['prev_panels']) ? $data['prev_panels'] : '';
        $this->ocprev_panelist = isset($data['ocprev_panelist']) ? $data['ocprev_panelist'] : '0';
        $this->ocprev_panels = isset($data['ocprev_panels']) ? $data['ocprev_panels'] : '';
        $this->prev_mod = isset($data['prev_mod']) ? $data['prev_mod'] : '0';
        $this->prev_mod_panels = isset($data['prev_mod_panels']) ? $data['prev_mod_panels'] : '';
        $this->unavailable = isset($data['unavailable']) ? $data['unavailable'] : '';
    }

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('name, regStatus, email, age', 'required'),
            array('regStatus', 'in', 'range' => array('Y', 'W', 'N'), 'allowEmpty' => false),
            array('email', 'email'),
            array('age', 'in', 'range' => array('18+', '16-18', '0-15'), 'allowEmpty' => false),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
            'name' => 'Registered Name',
            'regStatus' => 'Registration Status',
            'address' => 'Mailing Address',
			'state' => 'State/Province',
			'zip' => 'Postal Code',
            'phone' => 'Phone Number',
            'email' => 'Email Address',
            'prev_panelist' => 'Have you done panels at ' . Config::getValue('CONVENTION_NAME') . ' before?',
            		'prev_panels' => Yii::t('site', 'PREV_PANELS'),
            		'ocprev_panelist' => 'Have you done panels at other cons before?',
            		'ocprev_panels' => Yii::t('site', 'OCPREV_PANELS'),
            		'prev_mod' => Yii::t('site', 'PREV_MOD'),
            		'prev_mod_panels' => Yii::t('site', 'PREV_MOD_PANELS'),
            'unavailable' => 'I will be unavailable for panels during'
		);
	}
}