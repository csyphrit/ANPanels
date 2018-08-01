<?php
/**
 * @var $this SiteController
 * @var $model RegisterForm
 * @var $key string
 */
$this->pageTitle = Yii::app()->name . ' - Update Profile';
?>
<style> .panel span { display: inline; }</style>
<div class="form col-xs-6">
	<div class="panel panel-info">
		<div class="panel-heading">Update Contact Information</div>
		<div class="panel-body">
<?php
	$form = $this->beginWidget('CActiveForm', array(
		'id' => 'profile-form',
		'enableClientValidation' => TRUE,
		'clientOptions' => array(
			'validateOnSubmit' => TRUE,
		),
	));
	?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

    <div class="form-group">
        <?php
        echo CHtml::activeLabelEx($model, 'email');
        echo CHtml::activeTextField($model, 'email', array('size' => 50, 'class' => 'form-control'));
        echo CHtml::error($model, 'email');
        ?>
        <p class="hint">
            This will serve as your username. Only one account per email address.
        </p>
    </div>

	<div class="form-group">
		<?php
			echo CHtml::activeLabelEx($model, 'name');
			echo CHtml::activeTextField($model, 'name', array('class' => 'form-control'));
			echo CHtml::error($model, 'name');
		?>
		<p class="hint">
			Your full, legal name as it appears on your badge registration.
		</p>
	</div>

        <?php if (SiteSettings::getValue('REGSTATUS')) { ?>
	<div class="form-group">
		<?php
			echo CHtml::activeLabelEx($model, 'regStatus');
			echo CHtml::activeRadioButtonList($model, 'regStatus', array(
				'Y' => 'I have pre-registered',
				'W' => 'I will pre-register',
				'N' => 'I will register at the door'
			), array('separator' => ' ', 'template' => '<div class="radio"><label>{input} {label}</label></div>'));
			echo CHtml::error($model, 'regStatus');
		?>
	</div>
	<?php
	} else { 
		echo CHtml::activeHiddenField($model, 'regStatus', array('value' => 'Y'));
	}
	?>

	<div class="form-group">
		<?php
			echo CHtml::activeLabelEx($model, 'alias');
			echo CHtml::activeTextField($model, 'alias', array('class' => 'form-control'));
			echo CHtml::error($model, 'alias')
		?>
		<p class="hint">
			Name to be used in the program book, panel introductions, and communications, if different from your registered name.
		</p>
	</div>

	<?php if (SiteSettings::getValue('FORUM')) { ?>
	<div class="form-group">
		<?php
			echo CHtml::activeLabelEx($model, 'forumName');
			echo CHtml::activeTextField($model, 'forumName', array('class' => 'form-control'));
			echo CHtml::error($model, 'forumName');
		?>
	</div>
	<?php
	} else { 
		echo CHtml::activeHiddenField($model, 'forumName', array('value' => ''));
	}
	?>

<?php if (SiteSettings::getValue('ADDRESS')) { ?>
	<div class="form-group">
		<?php
			echo CHtml::activeLabelEx($model, 'address');
			echo CHtml::activeTextField($model, 'address', array('size' => 50, 'class' => 'form-control'));
			echo CHtml::error($model, 'address');
		?>
	</div>

	<div class="form-group">
		<?php
			echo CHtml::activeLabelEx($model, 'city');
			echo CHtml::activeTextField($model, 'city', array('class' => 'form-control'));
			echo CHtml::error($model, 'city');
		?>
	</div>

	<div class="form-group">
		<?php
			echo CHtml::activeLabelEx($model, 'state');
			echo CHtml::activeTextField($model, 'state', array('class' => 'form-control'));
			echo CHtml::error($model, 'state');
		?>
	</div>

	<div class="form-group">
		<?php
			echo CHtml::activeLabelEx($model, 'zip');
			echo CHtml::activeTextField($model, 'zip', array('class' => 'form-control'));
			echo CHtml::error($model, 'zip');
		?>
	</div>

	<div class="form-group">
		<?php
			echo CHtml::activeLabelEx($model, 'country');
			echo CHtml::activeTextField($model, 'country', array('class' => 'form-control'));
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
	<div class="form-group">
		<?php
			echo CHtml::activeLabelEx($model, 'phone');
			echo CHtml::activeTextField($model, 'phone', array('class' => 'form-control'));
			echo CHtml::error($model, 'phone');
		?>
	</div>
	<?php
	} else { 
		echo CHtml::activeHiddenField($model, 'phone', array('value' => ''));
	}
	?>

	<div class="form-group">
		<?php
			echo CHtml::activeLabelEx($model, 'age');
			echo CHtml::activeRadioButtonList($model, 'age', array(
				'18+' => '18+',
				'16-18' => '16-18',
				'0-15' => 'under 16'
			), array('separator' => ' ', 'template' => '<div class="radio"><label>{input} {label}</label></div>'));
			echo CHtml::error($model, 'age');
		?>
	</div>

<?php if (SiteSettings::getValue('PREV_PANELS')) { ?>
<div class="form-group">
		<?php
			echo CHtml::activeLabelEx($model, 'prev_panelist');
			echo CHtml::activeRadioButtonList($model, 'prev_panelist', array(
				'Yes' => 'Yes',
				'No' => 'No'
			), array('separator' => ' ', 'template' => '<div class="radio"><label>{input} {label}</label></div>'));
			echo CHtml::error($model, 'prev_panelist');
		?>
	</div>
<?php } else { 
		echo CHtml::activeHiddenField($model, 'prev_panelist', array('value' => 'No'));
	} ?>
	
	<div class="form-group">
		<?php
			echo CHtml::activeLabelEx($model, 'prev_panels');
			echo CHtml::activeTextField($model, 'prev_panels', array('class' => 'form-control'));
			echo CHtml::error($model, 'prev_panels');
		?>
	</div>
	
<?php if (SiteSettings::getValue('PREV_PANELS')) { ?>
	<div class="form-group">
		<?php
			echo CHtml::activeLabelEx($model, 'ocprev_panelist');
			echo CHtml::activeRadioButtonList($model, 'ocprev_panelist', array(
				'Yes' => 'Yes',
				'No' => 'No'
			), array('separator' => ' ', 'template' => '<div class="radio"><label>{input} {label}</label></div>'));
			echo CHtml::error($model, 'ocprev_panelist');
		?>
	</div>
<?php } else { 
		echo CHtml::activeHiddenField($model, 'ocprev_panelist', array('value' => ''));
	} ?>
	
	<div class="form-group">
		<?php
			echo CHtml::activeLabelEx($model, 'ocprev_panels');
			echo CHtml::activeTextField($model, 'ocprev_panels', array('class' => 'form-control'));
			echo CHtml::error($model, 'ocprev_panels');
		?>
	</div>
	
<?php if (SiteSettings::getValue('PREV_PANELS')) { ?>
	<div class="form-group">
		<?php
			echo CHtml::activeLabelEx($model, 'prev_mod');
			echo CHtml::activeRadioButtonList($model, 'prev_mod', array(
				'Yes' => 'Yes',
				'No' => 'No'
			), array('separator' => ' ', 'template' => '<div class="radio"><label>{input} {label}</label></div>'));
			echo CHtml::error($model, 'prev_mod');
		?>
	</div>
<?php } else { 
		echo CHtml::activeHiddenField($model, 'prev_mod', array('value' => '', 'class' => 'form-control'));
	} ?>
	
	<div class="form-group">
		<?php
			echo CHtml::activeLabelEx($model, 'prev_mod_panels');
			echo CHtml::activeTextField($model, 'prev_mod_panels', array('class' => 'form-control'));
			echo CHtml::error($model, 'prev_mod_panels');
		?>
	</div>

	<div class="form-group">
		<?php
			echo CHtml::activeLabelEx($model, 'unavailable');
			echo CHtml::activeTextArea($model, 'unavailable', array('cols' => 50, 'class' => 'form-control'));
			echo CHtml::error($model, 'unavailable');
		?>
		<p class="hint">
			Specify exact dates/times or events you will be unavailable during.
		</p>
	</div>

	<div class="form-group buttons">
		<?php echo CHtml::submitButton('Save', array('class' => 'btn btn-success')); ?>
	</div>
	<?php
    $this->endWidget();
    ?>
    		</div>
	</div>
</div>
<div class="form col-xs-6">
	<div class="panel panel-info">
		<div class="panel-heading">Change Password</div>
		<div class="panel-body">
	<?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'password-form',
    ));
	?>

    <div class="form-group">
        <?php
        echo CHtml::activeLabelEx($model, 'password');
        echo CHtml::activePasswordField($model, 'password', array('class' => 'form-control'));
        echo CHtml::error($model, 'password');
        ?>
    </div>

    <div class="form-group buttons">
        <?php echo CHtml::submitButton('Change Password', array('class' => 'btn btn-success')); ?>
    </div>

    <?php
    $this->endWidget();
    ?>
    		</div>
	</div>
</div>