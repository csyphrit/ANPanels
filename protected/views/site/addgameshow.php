<?php
/**
 * @var $this SiteController
 * @var $model GameshowForm
 * @var string $error
 */
$this->pageTitle = Yii::app()->name . ' - Register Gameshow';
$boolData = array(0 => 'No', 1 => 'Yes');

if (Config::getValue('REGISTRATION_OPEN')) {
  if ($error) {
    echo '<span style="color: red; font-weight:bold;">' . $error . '</span><br /><br />';
  }
?>

<div id="addgameshow">
        <div class="form col-xs-6">
            <h3>Sign Up For Gameshows</h3>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'gameshow-form',
                'enableClientValidation' => TRUE,
                'clientOptions' => array(
                    'validateOnSubmit' => TRUE,
                ),
            ));
            ?>

            <p class="note">
                Fields with <span class="required">*</span> are required.
                <?php echo CHtml::errorSummary($model); ?>
            </p>

            <div class="form-group">
                <?php
                echo CHtml::activeLabelEx($model, 'name');
                echo CHtml::activeTextField($model, 'name', array('class' => 'form-control', 'maxlength' => 50, 'placeholder' => 'Gameshow Name'));
                echo CHtml::error($model, 'name');
                ?>
                <p class="hint">
                    <?=Yii::t('site', 'PANEL_NAME_HINT'); ?>
                </p>
            </div>

	<?php
		echo CHtml::activeHiddenField($model, 'section', array('value' => 17));
	?>
	
	<?php if (SiteSettings::getValue('AV')) { ?>
            <div class="form-group">
                <?php
                echo CHtml::activeLabelEx($model, 'av_requested');
                echo CHtml::activeDropDownList($model, 'av_requested', $boolData, array('class' => 'form-control'));
                echo CHtml::error($model, 'av');
                ?>
                <p class="hint">
                    <?=Yii::t('site', 'PANEL_AV_HINT'); ?>
                </p>
            </div>
        <?php
	} else { 
		echo CHtml::activeHiddenField($model, 'av_requested', array('value' => 0));
	}
	?>

	<?php if (SiteSettings::getValue('ADULT')) { ?>
            <div class="form-group">
                <?php
                echo CHtml::activeLabelEx($model, 'adult');
                echo CHtml::activeDropDownList($model, 'adult', $boolData, array('class' => 'form-control'));
                echo CHtml::error($model, 'adult');
                ?>
            </div>
        <?php
	} else { 
		echo CHtml::activeHiddenField($model, 'adult', array('value' => 0));
	}
	?>
            
	<?php if (SiteSettings::getValue('DOUBLE')) { ?>
            <div class="form-group">
                <?php
                echo CHtml::activeLabelEx($model, 'double_length');
                echo CHtml::activeDropDownList($model, 'double_length', $boolData, array('class' => 'form-control'));
                echo CHtml::error($model, 'double_length');
                ?>
            </div>
        <?php
	} else { 
		echo CHtml::activeHiddenField($model, 'double_length', array('value' => 0));
	}
	?>

            <div class="form-group">
                <?php
                echo CHtml::activeLabelEx($model, 'description');
                echo CHtml::activeTextArea($model, 'description', array('class' => 'form-control', 'cols' => 50));
                echo CHtml::error($model, 'description');
                ?>
                <p class="hint">
                	Using <span id="charNum">0</span>/150 characters.
                </p>
            </div>
            
            <?php
		echo CHtml::activeHiddenField($model, 'justification', array('value' => 'n/a'));
	    ?>

            <div class="form-group">
                <?php
                echo CHtml::activeLabelEx($model, 'comments');
                echo CHtml::activeTextArea($model, 'comments', array('class' => 'form-control', 'cols' => 50));
                echo CHtml::error($model, 'comments');
                ?>
            </div>

            <div class="row buttons">
                <?php echo CHtml::submitButton('Register', array('class' => 'btn btn-success')); ?>
            </div>

            <?php
            $this->endWidget();
            ?>
        </div>
    </div>  
</div>
<?php
} else {
  echo 'Registration is currently closed.';
}
?>
<script>
$('#GameshowForm_description').keyup(function () {
  var max = 150;
  var len = $(this).val().length;
  $('#charNum').text(len);
  if (len >= max) {
    $('#charNum').addClass('error');
  } else {
    $('#charNum').removeClass('error');
  }
});
</script>