<?php
/**
 * EventSearchForm class.
 */
class EventSearchForm extends CFormModel {
    /**
     * @var string
     */
    public $search;
    
    /**
     * @var string
     */
    public $sort;
    
    /**
     * @var integer
     */
    public $type;
    
    /**
     * @var boolean
     */
    public $closed;
    
    /**
     * @var boolean
     */
    public $contacted;
    
    /**
     * @var boolean
     */
    public $av;
    
    /**
     * @var boolean
     */
    public $av_requested;
    
    /**
     * @var boolean
     */
    public $public;
    
    /**
     * @var boolean
     */
    public $double_length;
    
    /**
     * @var boolean
     */
    public $desc_final;

	/**
	 * @var boolean
	 */
	public $scheduled;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules() {
		return array();
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels() {
		return array(
			'search' => 'Panel Name',
			'sort' => 'Sort By',
			'type' => 'Event Type',
			'closed' => 'Closed',
			'contacted' => 'Contacted',
			'av' => 'Has AV',
			'av_requested' => 'AV Requested',
			'public' => 'Open/Public',
			'double_length' => '2+ Hour',
			'desc_final' => 'Description Finalized',
			'scheduled' => 'Scheduled',
		);
	}
}
