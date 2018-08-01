<?php
/**
 * @var $this SiteController
 * @var $model PanelForm
 * @var $panels array
 * @var string $error
 * @var boolean $regOpen
 */
$this->pageTitle = Yii::app()->name . ' - Register Panels';
$num = Config::getValue('MAX_PANELS') - count($panels);
$sections = PanelHelper::getSections();
$boolData = array(0 => 'No', 1 => 'Yes');

if ($regOpen) {
  if ($error) {
    echo '<span style="color: red; font-weight:bold;">' . $error . '</span><br /><br />';
  }
?>

<div id="addpanel">
    <?php
    if (count($panels) > 0) {
        $this->widget('application.widgets.RegisteredPanels');
    }
    
    if ($num > 0) {
    ?>
        <div class="form col-xs-6">
            <h3>Register Panels</h3>
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
                <?=Yii::t('site', 'PANEL_REFUND'); ?>
                <?php echo CHtml::errorSummary($model); ?>
            </p>

            <div class="form-group">
                <?php
                echo CHtml::activeLabelEx($model, 'name');
                echo CHtml::activeTextField($model, 'name', array('class' => 'form-control', 'maxlength' => 50, 'placeholder' => 'Panel Name'));
                echo CHtml::error($model, 'name');
                ?>
                <p class="hint">
                    <?=Yii::t('site', 'PANEL_NAME_HINT'); ?>
                </p>
            </div>

	<?php if (SiteSettings::getValue('SECTIONS')) { ?>
            <div class="form-group">
                <?php
                echo CHtml::activeLabelEx($model, 'section');
                echo CHtml::activeDropDownList($model, 'section', $sections, array('class' => 'form-control'));
                echo CHtml::error($model, 'section');
                ?>
            </div>
	<?php
	} else { 
		echo CHtml::activeHiddenField($model, 'section', array('value' => '1'));
	}
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
                <p class="hint">
                    <?=Yii::t('site', 'PANEL_DOUBLE_HINT'); ?>
                </p>
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
                	Using <span id="charNum">0</span>/150 characters. <?=Yii::t('site', 'PANEL_DESCRIPTION_HINT'); ?>
                </p>
            </div>
            
            <?php if (SiteSettings::getValue('JUSTIFICATION')) { ?>
             <div class="form-group">
                <?php
                echo CHtml::activeLabelEx($model, 'justification');
                echo CHtml::activeTextArea($model, 'justification', array('class' => 'form-control', 'cols' => 50));
                echo CHtml::error($model, 'justification');
                ?>
            </div>
            <?php
		} else { 
			echo CHtml::activeHiddenField($model, 'justification', array('value' => 'n/a'));
		}
	    ?>

            <div class="form-group">
                <?php
                echo CHtml::activeLabelEx($model, 'comments');
                echo CHtml::activeTextArea($model, 'comments', array('class' => 'form-control', 'cols' => 50));
                echo CHtml::error($model, 'comments');
                ?>
            </div>

            <div class="row buttons">
                <?php echo CHtml::submitButton('Register'); ?>
            </div>

            <?php
            $this->endWidget();
            ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel-group" id="sectionExplainer" role="tablist" aria-multiselectable="true">
  		<div class="panel panel-default">
    			<div class="panel-heading" role="tab" id="sectionExplainerHeading">
      				<h4 class="panel-title">
        				<a role="button" data-toggle="collapse" data-parent="#sectionExplainer" href="#sectionExplainations" aria-expanded="false" aria-controls="sectionExplainations">
          					What do the new sections mean?
        				</a>
      				</h4>
    			</div>
   			 <div id="sectionExplainations" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="sectionExplainerHeading">
      				<div class="panel-body">
      					<b>Fangasm Track</b> - General fan panels about favourite anime, manga, shows, series, genres.<br />
      					<b>Meta Track</b> - Panels about "real world" topics: creators, performers, production, careers in anime as well as fandom issues, history, current events<br />
                                        <b>Cosplay & Fashion Track</b> - Panels related to cosplaying and fashion.<br />
                                        <b>Culture Track</b> - Covers traditional Japanese arts, Japanese culture, language, and history.<br />
                                        <b>Military and Mecha Track</b> - Includes Gundam (models, anime, modelling discussions), military anime, and related topics.<br />
                                        <b>Presentations</b> - Expert, guest, and author presentations, usually involving A/V.<br />
                                        <b>Yaoi/Yuri North</b> - LGBTQ history/culture, yaoi and yuri anime/manga, and related fandom topics.<br />
                                        <b>Doll North</b> - Ball-jointed dolls and related topics.
      				</div>
    			</div>
  		</div>
  	</div>
    </div>
    <?php
    $this->widget('application.widgets.OpenPanels');
    }
    ?>  
</div>
<div class="modal fade" id="confirmDialog" tabindex="-1" role="dialog" aria-labelledby="confirmDialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="confirmLabel">Confirm Registration?</h4>
      </div>
      <div class="modal-body">
        Panel registration for <b><span id="confirmName"></span></b>:<br />
        <span class="text-danger" id="modalError">Please fill out all fields.</span><br /><br />
        Suggested description:<br />
        <textarea id="modalDesc" rows="2" cols="70"></textarea><br /><br />
        Why should I be on this panel?<br />
        <textarea id="modalWhy" rows="4" cols="70"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" id="confirmSubmit">Confirm</button>
      </div>
    </div>
  </div>
</div>
<?php
} else {
  echo 'Registration is currently closed.';
}
?>
<script>
$('#PanelForm_description').keyup(function () {
  var max = 150;
  var len = $(this).val().length;
  $('#charNum').text(len);
  if (len >= max) {
    $('#charNum').addClass('error');
  } else {
    $('#charNum').removeClass('error');
  }
});

$('#showOpenButton').on('click', function() {
	$('#showOpenButton').hide();
});

function register(userId, eventId, title) {
        title = title.replace(/\\/g, '');
	$('#confirmDialog').modal('show');
        $('#modalError').hide();
	$('#confirmName').html(title);
	$('#confirmSubmit').on('click', function() {
            var why = $('#modalWhy').val();
            var desc = $('#modalDesc').val();
console.log(why);
console.log(desc);
            if (why.length < 5 || desc.length < 5) {
                $('#modalError').show();
            } else {
		$('#register' + eventId).hide();
		$('#confirmDialog').modal('hide');
		$.ajax({
            		type: "POST",
            		url:    "<?php echo Yii::app()->createUrl('admin/addPanelist'); ?>",
            		data:  {
                		eventid: eventId,
                		userid: userId,
                                justification: why,
                                description: desc
            		},
            		success: function(msg){
                		location.reload();
            		},
            		error: function(xhr){
                		alert("Unable to register for panel");
            		}
        	});
            }
            return false;
        });
}
</script>