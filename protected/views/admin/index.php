<?php
/**
 * Created by PhpStorm.
 * User: Christie
 * Date: 1/27/14
 * Time: 7:23 PM
 */
?>
<div class="col-xs-12 col-sm-6">
  <?php
  $this->widget('application.widgets.EventCount');
  ?>
</div>
<div class="col-xs-12 col-sm-6">
<?php
  $this->widget('application.widgets.RecentPanels');
  $this->widget('application.widgets.RecentClosedPanels');
  ?>
</div>