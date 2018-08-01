<?php
/**
 * @var $this SiteController
 * @var $model RegisterForm
 */
$this->pageTitle = Yii::app()->name . ' - Register';
?>
<h2>User Registration Form</h2>

<div class="form">
	<?php
	$form = $this->beginWidget('CActiveForm', array(
		'id' => 'register-form',
		'enableClientValidation' => TRUE,
		'clientOptions' => array(
			'validateOnSubmit' => TRUE,
		),
	));
	?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

    <div class="row">
        <?php
        echo CHtml::activeLabelEx($model, 'email');
        echo CHtml::activeTextField($model, 'email', array('size' => 50));
        echo CHtml::error($model, 'email');
        ?>
        <p class="hint">
            This will serve as your username. Only one account per email address.
        </p>
    </div>

	<div class="row">
		<?php
			echo CHtml::activeLabelEx($model, 'password');
			echo CHtml::activePasswordField($model, 'password');
			echo CHtml::error($model, 'password');
		?>
	</div>

	<div class="row">
		<?php
			echo CHtml::activeLabelEx($model, 'name');
			echo CHtml::activeTextField($model, 'name');
			echo CHtml::error($model, 'name');
		?>
		<p class="hint">
			The name you will use to register for <?=Config::getValue('CONVENTION_NAME'); ?> admission. Your full, legal name.
		</p>
	</div>

	<div class="row radio">
		<?php
			echo CHtml::activeLabelEx($model, 'regStatus');
			echo CHtml::activeRadioButtonList($model, 'regStatus', array(
				'Y' => 'I have pre-registered',
				'W' => 'I will pre-register',
				'N' => 'I will register at the door'
			), array('separator' => ' '));
			echo CHtml::error($model, 'regStatus');
		?>
	</div>

	<div class="row">
		<?php
			echo CHtml::activeLabelEx($model, 'alias');
			echo CHtml::activeTextField($model, 'alias');
			echo CHtml::error($model, 'alias')
		?>
		<p class="hint">
			Name to be used in the program book, panel introductions, and communications, if different from your registered name.
		</p>
	</div>

	<?php if (SiteSettings::getValue('FORUM')) { ?>
	<div class="row">
		<?php
			echo CHtml::activeLabelEx($model, 'forumName');
			echo CHtml::activeTextField($model, 'forumName');
			echo CHtml::error($model, 'forumName');
		?>
	</div>
	<?php
	} else { 
		echo CHtml::activeHiddenField($model, 'forumName', array('value' => ''));
	}
	?>

<?php if (SiteSettings::getValue('ADDRESS')) { ?>
	<div class="row">
		<?php
			echo CHtml::activeLabelEx($model, 'address');
			echo CHtml::activeTextField($model, 'address', array('size' => 50));
			echo CHtml::error($model, 'address');
		?>
	</div>

	<div class="row">
		<?php
			echo CHtml::activeLabelEx($model, 'city');
			echo CHtml::activeTextField($model, 'city');
			echo CHtml::error($model, 'city');
		?>
	</div>

	<div class="row">
		<?php
			echo CHtml::activeLabelEx($model, 'state');
			echo CHtml::activeTextField($model, 'state');
			echo CHtml::error($model, 'state');
		?>
	</div>

	<div class="row">
		<?php
			echo CHtml::activeLabelEx($model, 'zip');
			echo CHtml::activeTextField($model, 'zip');
			echo CHtml::error($model, 'zip');
		?>
	</div>

	<div class="row">
		<?php
			echo CHtml::activeLabelEx($model, 'country');
			echo CHtml::activeTextField($model, 'country');
			echo CHtml::error($model, 'country');
		?>
	</div>
	<?php
	} else { 
		echo CHtml::activeHiddenField($model, 'address', array('value' => 'N/A'));
		echo CHtml::activeHiddenField($model, 'city', array('value' => 'N/A'));
		echo CHtml::activeHiddenField($model, 'state', array('value' => 'N/A'));
		echo CHtml::activeHiddenField($model, 'zip', array('value' => 'N/A'));
		echo CHtml::activeHiddenField($model, 'country', array('value' => 'N/A'));
	}
	?>

<?php if (SiteSettings::getValue('PHONE')) { ?>
	<div class="row">
		<?php
			echo CHtml::activeLabelEx($model, 'phone');
			echo CHtml::activeTextField($model, 'phone');
			echo CHtml::error($model, 'phone');
		?>
	</div>
	<?php
	} else { 
		echo CHtml::activeHiddenField($model, 'phone', array('value' => 'N/A'));
	}
	?>

	<div class="row radio">
		<?php
			echo CHtml::activeLabelEx($model, 'age');
			echo CHtml::activeRadioButtonList($model, 'age', array(
				'18+' => '18+',
				'16-18' => '16-18',
				'15-0' => 'under 16'
			), array('separator' => ' '));
			echo CHtml::error($model, 'age');
		?>
	</div>
	
	<div class="row radio">
		<?php
			echo CHtml::activeHiddenField($model, 'prev_panelist', array('value' => 'No'));
		?>
	</div>
	
	<div class="row">
		<?php
			echo CHtml::activeLabelEx($model, 'prev_panels');
			echo CHtml::activeTextField($model, 'prev_panels');
			echo CHtml::error($model, 'prev_panels');
		?>
	</div>
	
	<div class="row radio">
		<?php
			echo CHtml::activeHiddenField($model, 'ocprev_panelist', array('value' => 'No'));
		?>
	</div>
	
	<div class="row">
		<?php
			echo CHtml::activeLabelEx($model, 'ocprev_panels');
			echo CHtml::activeTextField($model, 'ocprev_panels');
			echo CHtml::error($model, 'ocprev_panels');
		?>
	</div>
	
	<div class="row radio">
		<?php
			echo CHtml::activeHiddenField($model, 'prev_mod', array('value' => 'No'));
		?>
	</div>
	
	<div class="row">
		<?php
			echo CHtml::activeLabelEx($model, 'prev_mod_panels');
			echo CHtml::activeTextField($model, 'prev_mod_panels');
			echo CHtml::error($model, 'prev_mod_panels');
		?>
	</div>
	
	<div class="row">
		<?php
			echo CHtml::activeLabelEx($model, 'unavailable');
			echo CHtml::activeTextArea($model, 'unavailable', array('cols' => 50));
			echo CHtml::error($model, 'unavailable');
		?>
		<p class="hint">
			Specify exact dates/times or events you will be unavailable during.
		</p>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Register'); ?>
	</div>

	<?php
	$this->endWidget();
	?>
</div>