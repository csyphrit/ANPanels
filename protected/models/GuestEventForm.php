<?php
/**
 * Guest Event Registration Form
 */
class GuestEventForm extends CFormModel {
    public $eventid;
    public $name;
    public $description;
    public $justification;
    public $section;
    public $type;
    public $closed;
    public $contacted;
    public $av;
    public $av_requested;
    public $adult;
    public $desc_final;
    public $double_length;
    public $comments;
    public $moderator;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array('name, description', 'required'),
            array('closed, contacted, av, av_requested, double_length, adult, desc_final', 'boolean'),
            array('section, type', 'numerical'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'name' => 'Event Name',
            'section' => 'Section',
            'av_requested' => 'Does your event require a projector or other equipment?',
            'adult' => 'Does your event contain adult content unsuitable for minors?',
            'double_length' => 'Is this event longer than 1 hour?',
            'description' => 'Description',
            'justification' => 'Why should I run this event?',
            'comments' => 'Comments',
        );
    }
} 