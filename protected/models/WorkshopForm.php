<?php
/**
 * Workshop Registration Form
 */
class WorkshopForm extends CFormModel {
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
            array('section, type', 'numerical'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'name' => 'Workshop Name',
            'section' => 'Section',
            'av_requested' => 'Does your workshop require a projector or other equipment?',
            'adult' => 'Does your workshop contain adult content unsuitable for minors?',
            'double_length' => 'Is this workshop longer than 1 hour?',
            'description' => 'Description',
            'justification' => 'Why should I run this workshop?',
            'comments' => 'Comments',
        );
    }
} 