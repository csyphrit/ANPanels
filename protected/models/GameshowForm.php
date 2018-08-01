<?php
/**
 * Gameshow Registration Form
 */
class GameshowForm extends CFormModel {
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
            array('closed, contacted, double_length, av, av_requested, adult, desc_final', 'boolean'),
            array('type', 'numerical'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'name' => 'Gameshow Name',
            'section' => 'Section',
            'av_requested' => 'Does your gameshow require a projector or other equipment?',
            'adult' => 'Does your gameshow contain adult content unsuitable for minors?',
            'double_length' => 'Is this gameshow longer than 1 hour?',
            'description' => 'Description',
            'justification' => 'Why should I run this gameshow?',
            'comments' => 'Comments',
        );
    }
} 