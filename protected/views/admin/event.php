<?php
/**
 * @var integer $eventId
 * @var string $error
 */
$event = Event::searchBy('id', $eventId);
$types = PanelHelper::getTypes();
$sections = PanelHelper::getSections(true);
$boolean = array('1' => 'Yes', '0' => 'No');
?>
<div class="col-xs-12 col-sm-6">
    <input type="hidden" id="eventId" name="eventId" value="<?=$eventId; ?>"/>
    <div id="eventInfo" class="panel panel-info">
        <div class="panel-heading">
        	<b><?=$event['name'] . ($event['adult'] ? ' (18+)' : ''); ?></b>
        	<span class="glyphicon glyphicon-pencil pull-right" onclick="edit()"></span>
        </div><div class="panel-body">
        	<span class="error"><?=$error; ?></span>
        	<p>
            	<b>Type:</b> <?=$types[$event['type']]; ?><br />
            	<b>Section:</b> <?=$sections[$event['section']]; ?><br />
            	<b>Closed:</b> <?=PanelHelper::formatBoolean($event['closed']); ?><br />
            	<b>Contacted:</b> <?=PanelHelper::formatBoolean($event['contacted']); ?><br />
            	<b>AV Approved:</b> <?=PanelHelper::formatBoolean($event['av']); ?><br />
            	<b>AV Requested:</b> <?=PanelHelper::formatBoolean($event['av_requested']); ?><br />
            	<b>Description Final:</b> <?=PanelHelper::formatBoolean($event['desc_final']); ?><br />
            	<b>Public:</b> <?=PanelHelper::formatBoolean($event['public']); ?><br />
            	<b>Two Hour:</b> <?=PanelHelper::formatBoolean($event['double_length']); ?>
        	</p>
        	<p><?=$event['description']; ?></p>
        </div>
    </div>
    
    <div id="eventEdit" class="panel panel-info">
    	<form name="EventEdit" method="post" action="<?=Yii::app()->baseUrl . '/index.php/admin/event/' . $event['id']; ?>">
        <div class="panel-heading">
        	<b><?=$event['name'] . ($event['adult'] ? ' (18+)' : ''); ?></b>
        	<span class="glyphicon glyphicon-ok pull-right" onclick="save()"></span>
        </div><div class="panel-body form">
        	<input type="hidden" id="eventId" name="eventId" value="<?=$event['id']; ?>"/>
        	<p>
            		<b>Name:</b> <?=CHtml::textField('name', $event['name'], array('class' => 'form-control')); ?><br />
            		<b>Type:</b> <?=CHtml::dropDownList('type', $event['type'], $types, array('class' => 'form-control')); ?><br />
            		<b>Section:</b> <?=CHtml::dropDownList('section', $event['section'], $sections, array('class' => 'form-control')); ?><br />
            		<b>Adult:</b> <?=CHtml::dropDownList('adult', $event['adult'], $boolean, array('class' => 'form-control')); ?><br />
            		<b>Closed:</b> <?=CHtml::dropDownList('closed', $event['closed'], $boolean, array('class' => 'form-control')); ?><br />
            		<b>Contacted:</b> <?=CHtml::dropDownList('contacted', $event['contacted'], $boolean, array('class' => 'form-control')); ?><br />
            		<b>AV Approved:</b> <?=CHtml::dropDownList('av', $event['av'], $boolean, array('class' => 'form-control')); ?><br />
            		<b>AV Requested:</b> <?=CHtml::dropDownList('av_requested', $event['av_requested'], $boolean, array('class' => 'form-control')); ?><br />
            		<b>Description Final:</b> <?=CHtml::dropDownList('desc_final', $event['desc_final'], $boolean, array('class' => 'form-control')); ?><br />
            		<b>Public:</b> <?=CHtml::dropDownList('public', $event['public'], $boolean, array('class' => 'form-control')); ?><br />
            		<b>Two Hour:</b> <?=CHtml::dropDownList('double_length', $event['double_length'], $boolean, array('class' => 'form-control')); ?><br />
            		<b>Description:</b> <?=CHtml::textArea('description', $event['description'], array('cols' => 50, 'rows' => 5, 'class' => 'form-control')); ?><br />
        	</p>
        </div>
        </form>
    </div>

    <?php
    $this->widget('application.widgets.Panelists', array('eventId' => $eventId));
    ?>
</div>
<div class="col-xs-12 col-sm-6">
    <?php
    $this->widget('application.widgets.MergePanel');
    $this->widget('application.widgets.AddPanelist');
    $this->widget('application.widgets.AVPanel', array('eventId' => $eventId));
    if (!$event['closed']) {
    	$this->widget('application.widgets.ClosePanel', array('eventId' => $eventId));
    }
    $this->widget('application.widgets.SchedulePanel', array('eventId' => $eventId));
    $this->widget('application.widgets.PanelDescriptions', array('eventId' => $eventId));
    $this->widget('application.widgets.PanelComments', array('eventId' => $eventId));
    $this->widget('application.widgets.PanelJustifications', array('eventId' => $eventId));
    $this->widget('application.widgets.ContactPanel', array('eventId' => $eventId));
    $this->widget('application.widgets.DeletePanel', array('eventId' => $eventId));
    ?>
</div>


<script>
    function mergePanel() {
        $.ajax({
            type: "POST",
            url:    "<?php echo Yii::app()->createUrl('admin/merge'); ?>",
            data:  {
                eventid: $('#eventId').val(),
                mergeid: $('#mergePanel select').val()
            },
            success: function(msg){
                location.reload();
            },
            error: function(xhr){
                alert("Unable to merge panels");
            }
        });
        return false;
    }
    function deletePanel() {
        $.ajax({
            type: "POST",
            url:    "<?php echo Yii::app()->createUrl('admin/deletePanel'); ?>",
            data:  {
                eventid: $('#eventId').val(),
            },
            success: function(msg){
                window.location = '<?=Yii::app()->createUrl('/'); ?>';
            },
            error: function(xhr){
                alert("Unable to delete panel");
            }
        });
        return false;
    }
    function closePanel() {
        $.ajax({
            type: "POST",
            url:    "<?php echo Yii::app()->createUrl('admin/closePanel'); ?>",
            data:  {
                eventId: $('#eventId').val(),
            },
            success: function(msg){
                location.reload();
            },
            error: function(xhr){
                alert("Unable to close panel");
            }
        });
        return false;
    }
    function approveAV() {
        $.ajax({
            type: "POST",
            url:    "<?php echo Yii::app()->createUrl('admin/approveAV'); ?>",
            data:  {
                eventid: $('#eventId').val(),
            },
            success: function(msg){
                location.reload();
            },
            error: function(xhr){
                alert("Unable to approve AV");
            }
        });
        return false;
    }
    function addPanelist() {
        $.ajax({
            type: "POST",
            url:    "<?php echo Yii::app()->createUrl('admin/addPanelist'); ?>",
            data:  {
                eventid: $('#eventId').val(),
                userid: $('#addPanelist select').val()
            },
            success: function(msg){
                location.reload();
            },
            error: function(xhr){
                alert("Unable to add panelists");
            }
        });
        return false;
    }
    function confirmPanelist($id) {
        $.ajax({
            type: "POST",
            url:    "<?php echo Yii::app()->createUrl('admin/confirm'); ?>",
            data:  {
                eventid: $('#eventId').val(),
                userid: $id
            },
            success: function(msg){
                location.reload();
            },
            error: function(xhr){
                alert("Unable to confirm panelist");
            }
        });
        return false;
    }
    function unconfirmPanelist($id) {
        $.ajax({
            type: "POST",
            url:    "<?php echo Yii::app()->createUrl('admin/unconfirm'); ?>",
            data:  {
                eventid: $('#eventId').val(),
                userid: $id
            },
            success: function(msg){
                location.reload();
            },
            error: function(xhr){
                alert("Unable to unconfirm panelist");
            }
        });
        return false;
    }
    function removePanelist($id) {
        $.ajax({
            type: "POST",
            url:    "<?php echo Yii::app()->createUrl('admin/removePanelist'); ?>",
            data:  {
                eventid: $('#eventId').val(),
                userid: $id
            },
            success: function(msg){
                location.reload();
            },
            error: function(xhr){
                alert("Unable to remove panelist");
            }
        });
        return false;
    }
    function promotePanelist($id) {
        $.ajax({
            type: "POST",
            url:    "<?php echo Yii::app()->createUrl('admin/promote'); ?>",
            data:  {
                eventid: $('#eventId').val(),
                userid: $id
            },
            success: function(msg){
                location.reload();
            },
            error: function(xhr){
                alert("Unable to promote panelist");
            }
        });
        return false;
    }
    function edit() {
        $('#eventInfo').hide();
        $('#eventEdit').show();
    }
    function save() {
        $('#eventEdit form').submit();
    }
</script>
