<?php
/**
 * @var $this Admin Controller
 */
$this->pageTitle = Yii::app()->name . ' - Mass Mail';
?>

<div id="massmail">
        <h3>Mass Mail</h3>
        <div class="form">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'mail-form',
                'enableClientValidation' => TRUE,
                'clientOptions' => array(
                    'validateOnSubmit' => TRUE,
                ),
            ));
            ?>
            
            <div class="row">
            Send to All? <?=CHtml::checkBox('all', false); ?>
            </div>
            
            <div class="row">
            Subject: 
                <?php
                echo CHtml::textField('subject', '');
                ?>
            </div>

            <div class="row">
                <?php
                echo CHtml::textArea('content', '', array('cols' => 50));
                ?>
            </div>

            <div class="row buttons">
                <?php echo CHtml::submitButton('Send'); ?>
            </div>

            <?php
            $this->endWidget();
            ?>
        </div>
</div>