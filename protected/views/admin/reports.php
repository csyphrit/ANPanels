<?php
$reports = Reports::getReports();
foreach ($reports as $report) {
	?>
	<a href="<?=Yii::app()->createUrl($report['url']); ?>">
	<div class="reportButton">
		<h3><?=$report['name']; ?></h3>
		<?=$report['description']; ?>
	</div>
	</a>
	 <?php
}
?>