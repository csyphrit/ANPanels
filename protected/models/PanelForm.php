<?php
/**
 * Panel Registration Form
 */
class PanelForm extends CFormModel {
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
            array('name, description, justification', 'required'),
            array('closed, contacted, av, double_length, av_requested, adult, desc_final', 'boolean'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'name' => 'Panel Name',
            'section' => 'Section',
            'av_requested' => 'Does your panel/presentation require a projector or other equipment?',
            'adult' => 'Does your panel/presentation contain adult content unsuitable for minors?',
            'double_length' => 'Is this a 2 hour panel?',
            'description' => 'Description',
            'justification' => 'Why should I be on this panel?',
            'comments' => 'Comments',
        );
    }
} 