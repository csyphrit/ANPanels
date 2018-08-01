<?php
/**
 * Events
 * @var Object $form
 * @var integer $section
 * @var Array $events
 */
$sections = PanelHelper::getSections(TRUE);
$types = PanelHelper::getTypes();
$types[''] = '';
$boolData = array('' => '', 0 => 'No', 1 => 'Yes');
$sorts = array('' => 'Panel Name', 'panelists' => 'Panelists', 'unconfirmed' => 'Unconfirmed');
$user = UserHelper::getCurrentUser();
?>
<p><b>Row Color Key:</b> <span class="label label-success">Public</span> <span class="label label-danger">AV Requested</span> <span class="label label-primary">Closed</span> <span class="label label-warning">Needs Scheduled</span> <span class="label label-default">Finalized</span></p>
<?php
if ($user->privilege >= 7) {
    echo '<ul class="nav nav-tabs panel event-nav">';
    echo '<li role="presentation"' . ($section ? '' : ' class="active"') . '><a class="button" href="' . Yii::app()->createUrl('/admin/events', array('section' => 0)) . '">View All</a></li>';
    foreach ($sections as $id => $sec) {
	echo '<li role="presentation"' . ($section == $id ? ' class="active"' : '') . '><a href="' . Yii::app()->createUrl('/admin/events', array('section' => $id)) . '">' .  $sec . '</a></li>';
    } 
    
    echo '</ul>';
}
?>
<div class="panel-group event-filters" id="accordion" role="tablist" aria-multiselectable="true">
  <?php echo CHtml::beginForm(); ?>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" class="pull-right filters-link" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Filters <span class="glyphicon glyphicon-chevron-down"></span>
        </a>
      </h4>
      <div class="form-inline">
  	<div class="form-group">
    	  <label class="sr-only" for="search">Event Name</label>
    	  <div class="input-group">
      	    <div class="input-group-addon"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></div>
      	    <?php echo CHtml::activeTextField($form, 'search', array('class' => 'form-control', 'placeholder' => 'Panel Name')) ?>
    	  </div>
  	</div>
  	<?php echo CHtml::submitButton('Search', array('class' => 'btn btn-primary')); ?>
  	<?php echo CHtml::activeLabelEx($form, 'sort'); ?>
  	<?php echo CHtml::activeDropDownList($form, 'sort', $sorts, array('class' => 'form-control')); ?>
  	<?php echo CHtml::submitButton('Sort', array('class' => 'btn btn-primary')); ?>
      </div>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body form">
        <div class="col-xs-6">
          <div class="form-group">
            <?php
                echo CHtml::activeLabelEx($form, 'type');
                echo CHtml::activeDropDownList($form, 'type', $types, array('class' => 'form-control'));
                ?>
          </div>
          <div class="form-group">
            <?php
            echo CHtml::activeLabelEx($form, 'closed');
            echo CHtml::activeDropDownList($form, 'closed', $boolData, array('class' => 'form-control'));
            ?>
          </div>
          <div class="form-group">
            <?php
            echo CHtml::activeLabelEx($form, 'contacted');
            echo CHtml::activeDropDownList($form, 'contacted', $boolData, array('class' => 'form-control'));
            ?>
          </div>
          <div class="form-group">
            <?php
            echo CHtml::activeLabelEx($form, 'desc_final');
            echo CHtml::activeDropDownList($form, 'desc_final', $boolData, array('class' => 'form-control'));
            ?>
          </div>
          <div class="form-group">
            <?php
            echo CHtml::activeLabelEx($form, 'scheduled');
            echo CHtml::activeDropDownList($form, 'scheduled', $boolData, array('class' => 'form-control'));
            ?>
          </div>
        </div>
        <div class="col-xs-6">
          <div class="form-group">
            <?php
            echo CHtml::activeLabelEx($form, 'av');
            echo CHtml::activeDropDownList($form, 'av', $boolData, array('class' => 'form-control'));
            ?>
          </div>
          <div class="form-group">
            <?php
            echo CHtml::activeLabelEx($form, 'av_requested');
            echo CHtml::activeDropDownList($form, 'av_requested', $boolData, array('class' => 'form-control'));
            ?>
          </div>
          <div class="form-group">
            <?php
            echo CHtml::activeLabelEx($form, 'public');
            echo CHtml::activeDropDownList($form, 'public', $boolData, array('class' => 'form-control'));
            ?>
          </div>
          <div class="form-group">
            <?php
            echo CHtml::activeLabelEx($form, 'double_length');
            echo CHtml::activeDropDownList($form, 'double_length', $boolData, array('class' => 'form-control'));
            ?>
          </div>
        </div>
		<div class="col-xs-12">
        	<?php
        	echo CHtml::submitButton('Filter', array('class' => 'btn btn-primary'));
        	echo CHtml::link('Clear Filters', array("admin/events"), array('class' => 'btn btn-primary pull-right'));
        	?>
		</div>
      </div>
    </div>
  </div>
  <?php echo CHtml::endForm(); ?>
</div>
<table class="table table-hover">
	<thead>
		<tr>
			<th>Name</th>
			<th>Panelists</th>
			<th>Unconfirmed</th>
			<th>Type</th>
			<th>Section</th>
			<th>AV</th>
			<th>Contacted</th>
			<th>Desc Final?</th>
		</tr>
	</thead>
	<tbody>
<?php
foreach ($events as $data) {
	$class = '';
	$name = $data["name"];
	if ($data['public']) {
		$class = 'success';
	}
	if ($data['closed']) {
		$class = 'primary';
	}
	if ($data['closed'] && !$data['scheduled']) {
		$class = 'warning';
	}
	if ($data['closed'] && $data['scheduled']) {
		$class = 'active';
	}
	if ($data['av_requested'] && !$data['av']) {
		$class = 'danger';
	}
	if ($data['adult']) {
		$name .= ' (18+)';
	}
	
	echo '<tr' . ($class ? ' class="' . $class . '"' : '') . '>';
	echo '<td>' . CHtml::link($name, array("admin/event", "id" => $data["id"])) . '</td>';
	echo '<td>' . $data['panelists'] . '</td>';
	echo '<td>' . $data['unconfirmed'] . '</td>';
	echo '<td>' . Yii::t("types", $data['type']) . '</td>';
	echo '<td>' . Yii::t("sections", $data['section']) . '</td>';
	echo '<td>' . ($data['av_requested'] && !$data['av'] ? date('n/j/y', strtotime($data['created'])) : Yii::t("boolean", $data['av'])) . '</td>';
	echo '<td>' . Yii::t("boolean", $data['contacted']) . '</td>';
	echo '<td>' . Yii::t("boolean", $data['desc_final']) . '</td>';
	echo '</tr>';
}
echo '</tbody></table>';

echo '<a class="btn btn-primary" href="' . Yii::app()->createUrl('/admin/addPanel') . '">Create Event</a>';
?>
