<?php
/**
 * @var $this SiteController
 * @var $model PanelForm
 * @var $panels array
 * @var string $error
 */
$this->pageTitle = Yii::app()->name . ' - Create Event';
$sections = PanelHelper::getSections();
$types = PanelHelper::getTypes();
$boolData = array(0 => 'No', 1 => 'Yes');
?>

<div id="addpanel">
        <div class="form col-xs-6">
            <h3>Create Event</h3>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'panel-form',
                'enableClientValidation' => TRUE,
                'clientOptions' => array(
                    'validateOnSubmit' => TRUE,
                ),
            ));
            ?>

            <p class="note">
                Fields with <span class="required">*</span> are required.
            </p>

            <div class="form-group">
                <?php
                echo CHtml::activeLabelEx($model, 'name');
                echo CHtml::activeTextField($model, 'name', array('class' => 'form-control', 'maxlength' => 50, 'placeholder' => 'Panel Name'));
                echo CHtml::error($model, 'name');
                ?>
            </div>
            
            <div class="form-group">
                <?php
                echo CHtml::activeLabelEx($model, 'type');
                echo CHtml::activeDropDownList($model, 'type', $types, array('class' => 'form-control'));
                echo CHtml::error($model, 'type');
                ?>
            </div>

            <div class="form-group">
                <?php
                echo CHtml::activeLabelEx($model, 'section');
                echo CHtml::activeDropDownList($model, 'section', $sections, array('class' => 'form-control'));
                echo CHtml::error($model, 'section');
                ?>
            </div>

            <div class="form-group">
                <?php
                echo CHtml::activeLabelEx($model, 'av_requested');
                echo CHtml::activeDropDownList($model, 'av_requested', $boolData, array('class' => 'form-control'));
                echo CHtml::error($model, 'av');
                ?>
            </div>

            <div class="form-group">
                <?php
                echo CHtml::activeLabelEx($model, 'adult');
                echo CHtml::activeDropDownList($model, 'adult', $boolData, array('class' => 'form-control'));
                echo CHtml::error($model, 'adult');
                ?>
            </div>
            
            <div class="form-group">
                <?php
                echo CHtml::activeLabelEx($model, 'double_length');
                echo CHtml::activeDropDownList($model, 'double_length', $boolData, array('class' => 'form-control'));
                echo CHtml::error($model, 'double');
                ?>
            </div>

            <div class="form-group">
                <?php
                echo CHtml::activeLabelEx($model, 'description');
                echo CHtml::activeTextArea($model, 'description', array('class' => 'form-control', 'cols' => 50));
                echo CHtml::error($model, 'description');
                ?>
            </div>

            <div class="row buttons">
                <?php echo CHtml::submitButton('Create', array('class' => 'btn btn-success')); ?>
            </div>

            <?php
            $this->endWidget();
            ?>
        </div>
</div>
<script>
$('#PanelForm_section').change(function () {
  var selected = $(this).val();
  if (selected == 9) {
    $('#PanelForm_av_requested').val(1);
  }
});
</script>