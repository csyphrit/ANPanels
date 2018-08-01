<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app()->name . ' - Login';
?>

<h2>Login</h2>

<div class="form-horizontal">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id' => 'login-form',
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
)); ?>

	<div class="row">
	    <div class="col-sm-2">
		<?php echo $form->labelEx($model,'username', array('class' => 'control-label')); ?>
	    </div>
	    <div class="col-sm-5">
		<?php echo $form->textField($model,'username', array('class' => 'form-control', 'placeholder' => 'Email Address')); ?>
	    </div>
	    <div class="col-sm-12">
		<?php echo $form->error($model,'username'); ?>
	    </div>
	</div>

	<div class="row">
	    <div class="col-sm-2">
		<?php echo $form->labelEx($model,'password', array('class' => 'control-label')); ?>
	    </div>
	    <div class="col-sm-5">
		<?php echo $form->passwordField($model,'password', array('class' => 'form-control', 'placeholder' => 'Password')); ?>
	    </div>
	    <div class="col-sm-12">
		<?php echo $form->error($model,'password'); ?>
	    </div>
	</div>

	<div class="row">
	    <div class="col-sm-5 col-sm-offset-2 checkbox">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe', array('class' => 'control-label')); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	    </div>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Login', array('class' => 'btn btn-success center-block')); ?>
	</div>
<?php $this->endWidget(); ?>

    <p><?php echo CHtml::link('Register for a new account', array('site/register')); ?></p>
    <p><?php echo CHtml::link('Forgot your password?', array('site/forgotPassword')); ?></p>
</div><!-- form -->