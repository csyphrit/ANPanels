<?php
/**
 * @var $this SiteController
 * @var $model RegisterForm
 */
$this->pageTitle = Yii::app()->name . ' - Register';
?>
<h2>User Registration Form</h2>

<div class="form-horizontal">
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

        <div class="panel-group" id="accountInfo">
  	    <div class="panel panel-default">
    	        <div class="panel-heading">
      		    <h4 class="panel-title">
        	        ANPanels Account Information
      		    </h4>
    		</div>
   		<div class="panel-body">
    	            <div class="form-group">
    		        <div class="col-sm-2">
        		    <?php echo CHtml::activeLabelEx($model, 'email', array('class' => 'control-label')); ?>
        	        </div>
        	        <div class="col-sm-7">
        		    <?php
        		    echo CHtml::activeTextField($model, 'email', array('size' => 50, 'class' => 'form-control', 'placeholder' => 'Email address'));
        		    echo CHtml::error($model, 'email');
        		    ?>
        	        </div>
                        <div class="col-sm-12">
                            <p class="help-block">
				This will serve as your username. Only one account per email address.<br />
            			NOTE: Your email will be used to contact you as needed to organize your participation in panels. It will be shared with the other panelists on your events. If this is a concern, please use a disposable email that you can check regularly.
			    </p>
                        </div>
    	            </div>

	            <div class="form-group">
		        <div class="col-sm-2">
			    <?php echo CHtml::activeLabelEx($model, 'password', array('class' => 'control-label')); ?>
        	        </div>
        	        <div class="col-sm-3">
        		    <?php
			    echo CHtml::activePasswordField($model, 'password', array('class' => 'form-control'));
			    echo CHtml::error($model, 'password');
			    ?>
		        </div>
	            </div>
    		</div>
  	    </div>
  	</div>

        <div class="panel-group" id="registrationInfo">
  	    <div class="panel panel-default">
    	        <div class="panel-heading">
      		    <h4 class="panel-title">
        	        Registration Information
      		    </h4>
    		</div>
   		<div class="panel-body">
	            <div class="form-group">
		        <div class="col-sm-2">
			    <?php echo CHtml::activeLabelEx($model, 'name', array('class' => 'control-label'));  ?>
        	        </div>
        	        <div class="col-sm-7">
        		    <?php
			    echo CHtml::activeTextField($model, 'name', array('class' => 'form-control', 'placeholder' => 'Your full, legal name as it appears on your ID and badge registration'));
			    echo CHtml::error($model, 'name');
			    ?>
		        </div>
                        <div class="col-sm-12">
                            <p class="help-block">
				This is required for panelist sign-in and panelist rewards including registration refunds and pre-registration for the following year. It will not be posted, shared, or made public.
			    </p>
                        </div>
	            </div>

	            <?php if (SiteSettings::getValue('REGSTATUS')) { ?>
	                <div class="form-group">
		            <div class="col-sm-2">
			        <?php echo CHtml::activeLabelEx($model, 'regStatus', array('class' => 'control-label'));  ?>
        	            </div>
        	            <div class="col-sm-9">
        		        <?php
			        echo CHtml::activeRadioButtonList($model, 'regStatus', array(
				    'Y' => 'I have pre-registered',
				    'W' => 'I will pre-register',
				    'N' => 'I will register at the door'
			        ), array('separator' => ' ', 'class' => 'radio-inline'));
			        echo CHtml::error($model, 'regStatus');
			        ?>
		            </div>
	                </div>
	            <?php
	            } else { 
		        echo CHtml::activeHiddenField($model, 'regStatus', array('value' => 'Y'));
	            }
	            ?>

	            <?php if (SiteSettings::getValue('AGE')) { ?>
	                <div class="form-group">
		            <div class="col-sm-2">
			        <?php echo CHtml::activeLabelEx($model, 'age', array('class' => 'control-label'));  ?>
        	            </div>
        	            <div class="col-sm-9">
        		        <?php
			        echo CHtml::activeRadioButtonList($model, 'age', array(
				    '18+' => '18+',
				    '16-18' => '16-18',
				    '15-0' => 'under 16'
			        ), array('separator' => ' ', 'class' => 'radio-inline'));
			        echo CHtml::error($model, 'age');
			        ?>
		            </div>
	                </div>
	            <?php
	            } else {
		        echo CHtml::activeHiddenField($model, 'age', array('value' => '18+'));
	            }
	            ?>


    		</div>
  	    </div>
  	</div>

        <div class="panel-group" id="refundInfo">
  	    <div class="panel panel-default">
    	        <div class="panel-heading">
      		    <h4 class="panel-title">
        	        Panelist Reward Information (Pre-Registration/Refunds)
      		    </h4>
    		</div>
   		<div class="panel-body">
	            <?php if (SiteSettings::getValue('ADDRESS')) { ?>
	                <div class="form-group">
		            <div class="col-sm-2">
			        <?php echo CHtml::activeLabelEx($model, 'address', array('class' => 'control-label'));  ?>
        	            </div>
        	            <div class="col-sm-7">
        		        <?php
			        echo CHtml::activeTextField($model, 'address', array('size' => 50, 'class' => 'form-control'));
			        echo CHtml::error($model, 'address');
			        ?>
		            </div>
	                </div>

	                <div class="form-group">
		            <div class="col-sm-2">
			        <?php echo CHtml::activeLabelEx($model, 'city', array('class' => 'control-label'));  ?>
        	            </div>
        	            <div class="col-sm-3">
        		        <?php
			        echo CHtml::activeTextField($model, 'city', array('class' => 'form-control'));
			        echo CHtml::error($model, 'city');
			        ?>
		            </div>
	                </div>

	                <div class="form-group">
		            <div class="col-sm-2">
			        <?php echo CHtml::activeLabelEx($model, 'state', array('class' => 'control-label'));  ?>
        	            </div>
        	            <div class="col-sm-3">
        		        <?php
			        echo CHtml::activeTextField($model, 'state', array('class' => 'form-control'));
			        echo CHtml::error($model, 'state');
			        ?>
		            </div>
	                </div>

	                <div class="form-group">
		            <div class="col-sm-2">
			        <?php echo CHtml::activeLabelEx($model, 'zip', array('class' => 'control-label'));  ?>
        	            </div>
        	            <div class="col-sm-3">
        		        <?php
			        echo CHtml::activeTextField($model, 'zip', array('class' => 'form-control'));
			        echo CHtml::error($model, 'zip');
			        ?>
		            </div>
	                </div>

	                <div class="form-group">
		            <div class="col-sm-2">
			        <?php echo CHtml::activeLabelEx($model, 'country', array('class' => 'control-label'));  ?>
        	            </div>
        	            <div class="col-sm-3">
        		        <?php
			        echo CHtml::activeTextField($model, 'country', array('class' => 'form-control'));
			        echo CHtml::error($model, 'country');
			        ?>
		            </div>
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
    		</div>
  	    </div>
  	</div>

        <div class="panel-group" id="optionalInfo">
  	    <div class="panel panel-default">
    	        <div class="panel-heading">
      		    <h4 class="panel-title">
        	        Optional Information
      		    </h4>
    		</div>
   		<div class="panel-body">
	            <?php if (SiteSettings::getValue('PHONE')) { ?>
	                <div class="form-group">
		            <div class="col-sm-2">
			        <?php echo CHtml::activeLabelEx($model, 'phone', array('class' => 'control-label'));  ?>
        	            </div>
        	            <div class="col-sm-5">
        		        <?php
			        echo CHtml::activeTextField($model, 'phone', array('class' => 'form-control'));
			        echo CHtml::error($model, 'phone');
			        ?>
		            </div>
                            <div class="col-sm-12">
                                <p class="help-block">
				    Used to contact you in case of emergency or changes in panel schedule at con.
			        </p>
                            </div>
	                </div>
	            <?php
	            } else { 
		        echo CHtml::activeHiddenField($model, 'phone', array('value' => 'N/A'));
	            }
	            ?>

	            <div class="form-group">
		        <div class="col-sm-2">
			    <?php echo CHtml::activeLabelEx($model, 'alias', array('class' => 'control-label'));  ?>
        	        </div>
        	        <div class="col-sm-3">
        		    <?php
			    echo CHtml::activeTextField($model, 'alias', array('class' => 'form-control', 'placeholder' => 'Fannish name (if applicable)'));
			    echo CHtml::error($model, 'alias')
			    ?>
			    
		        </div>
                        <div class="col-sm-12">
                            <p class="help-block">
				Name to be used in the program book, panel introductions, and communications, if different from your registered name.
			    </p>
                        </div>
	            </div>

	            <?php if (SiteSettings::getValue('FORUM')) { ?>
	                <div class="form-group">
		            <div class="col-sm-2">
			        <?php echo CHtml::activeLabelEx($model, 'forumName', array('class' => 'control-label'));  ?>
        	            </div>
        	            <div class="col-sm-3">
        		        <?php
			        echo CHtml::activeTextField($model, 'forumName', array('class' => 'form-control'));
			        echo CHtml::error($model, 'forumName');
			        ?>
		            </div>
	                </div>
	            <?php
	            } else { 
		        echo CHtml::activeHiddenField($model, 'forumName', array('value' => ''));
	            }
	            ?>
    		</div>
  	    </div>
  	</div>

        <div class="panel-group" id="panelistInfo">
  	    <div class="panel panel-default">
    	        <div class="panel-heading">
      		    <h4 class="panel-title">
        	        Panelist Experience
      		    </h4>
    		</div>
   		<div class="panel-body">
	            <?php if (SiteSettings::getValue('PREV_PANELS')) { ?>
	                <div class="form-group">
		            <div class="col-sm-4">
			        <?php echo CHtml::activeLabelEx($model, 'prev_panelist', array('class' => 'control-label'));  ?>
        	            </div>
        	            <div class="col-sm-8">
        		        <?php
			        echo CHtml::activeRadioButtonList($model, 'prev_panelist', array(
				    'Yes' => 'Yes',
				    'No' => 'No'
			        ), array('separator' => ' ', 'class' => 'radio-inline'));
			        echo CHtml::error($model, 'prev_panelist');
			        ?>
		            </div>
	                </div>
	
	                <div class="form-group">
		            <div class="col-sm-4">
			        <?php echo CHtml::activeLabelEx($model, 'prev_panels', array('class' => 'control-label'));  ?>
        	            </div>
        	            <div class="col-sm-8">
        		        <?php
			        echo CHtml::activeTextField($model, 'prev_panels', array('class' => 'form-control'));
			        echo CHtml::error($model, 'prev_panels');
			        ?>
		            </div>
	                </div>
	                <?php
	            } else { 
		        echo CHtml::activeHiddenField($model, 'prev_panelist', array('value' => 'No'));
		        echo CHtml::activeHiddenField($model, 'prev_panels', array('value' => ''));
	            }
	            ?>
	
	            <div class="form-group">
		        <div class="col-sm-4">
			    <?php echo CHtml::activeLabelEx($model, 'ocprev_panelist', array('class' => 'control-label'));  ?>
        	        </div>
        	        <div class="col-sm-8">
        		    <?php
			    echo CHtml::activeRadioButtonList($model, 'ocprev_panelist', array(
				'Yes' => 'Yes',
				'No' => 'No'
			    ), array('separator' => ' ', 'class' => 'radio-inline'));
			    echo CHtml::error($model, 'ocprev_panelist');
			    ?>
		        </div>
	            </div>
	
	            <div class="form-group">
		        <div class="col-sm-4">
			    <?php echo CHtml::activeLabelEx($model, 'ocprev_panels', array('class' => 'control-label'));  ?>
        	        </div>
        	        <div class="col-sm-8">
        		    <?php
			    echo CHtml::activeTextField($model, 'ocprev_panels', array('class' => 'form-control'));
			    echo CHtml::error($model, 'ocprev_panels');
			    ?>
		        </div>
	            </div>

	            <?php if (SiteSettings::getValue('PREV_MOD')) { ?>
	                <div class="form-group">
		            <div class="col-sm-4">
			        <?php echo CHtml::activeLabelEx($model, 'prev_mod', array('class' => 'control-label'));  ?>
        	            </div>
        	            <div class="col-sm-8">
        		        <?php
			        echo CHtml::activeRadioButtonList($model, 'prev_mod', array(
				    'Yes' => 'Yes',
				    'No' => 'No'
			        ), array('separator' => ' ', 'class' => 'radio-inline'));
			        echo CHtml::error($model, 'prev_mod');
			        ?>
		            </div>
	                </div>
	                <div class="form-group">
		            <div class="col-sm-4">
			        <?php echo CHtml::activeLabelEx($model, 'prev_mod_panels', array('class' => 'control-label'));  ?>
        	            </div>
        	            <div class="col-sm-8">
        		        <?php
			        echo CHtml::activeTextField($model, 'prev_mod_panels', array('class' => 'form-control'));
			        echo CHtml::error($model, 'prev_mod_panels');
			        ?>
		            </div>
	                </div>
	            <?php
	            } else { 
		        echo CHtml::activeHiddenField($model, 'prev_mod', array('value' => 'No'));
		        echo CHtml::activeHiddenField($model, 'prev_mod_panels', array('value' => ''));
	            }
	            ?>
    		</div>
  	    </div>
  	</div>
	
        <div class="panel-group" id="accountInfo">
  	    <div class="panel panel-default">
    	        <div class="panel-heading">
      		    <h4 class="panel-title">
        	        At-Con Availability
      		    </h4>
    		</div>
   		<div class="panel-body">
	            <div class="form-group">
		        <div class="col-sm-3">
			    <?php echo CHtml::activeLabelEx($model, 'unavailable', array('class' => 'control-label'));  ?>
        	        </div>
        	        <div class="col-sm-9">
        		    <?php
			    echo CHtml::activeTextArea($model, 'unavailable', array('cols' => 50, 'class' => 'form-control', 'placeholder' => 'Specify exact dates/times or events'));
			    echo CHtml::error($model, 'unavailable');
			    ?>
		        </div>
                        <div class="col-sm-12">
                            <p class="help-block">
				Please note if you are <b>arriving after 4pm on Friday or leaving before 6pm on Sunday</b>. Also note any major events you will be unavailable during (Masquerade, Cosplay Chess, AMV contest, etc.) as well as any specific day/time you will be unavailable during the convention.
			    </p>
                        </div>
	            </div>
    		</div>
  	    </div>
  	</div>



	<div class="form-group">
		<?php echo CHtml::submitButton('Register', array('class' => 'btn btn-success center-block')); ?>
	</div>

	<?php
	$this->endWidget();
	?>
</div>