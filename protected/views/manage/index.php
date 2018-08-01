<?php
/**
 * Manage Site
 */
 ?>
<a href="<?=Yii::app()->createUrl('manage/config'); ?>">
	<div class="reportButton">
		<h3>Config Manager</h3>
		Edit site configuration such as convention name, emails, and urls.
	</div>
</a>
<a href="<?=Yii::app()->createUrl('manage/settings'); ?>">
	<div class="reportButton">
		<h3>Site Settings</h3>
		Set which portions of the panel and user registration are visible.
	</div>
</a>
<a href="<?=Yii::app()->createUrl('manage/rooms'); ?>">
	<div class="reportButton">
		<h3>Manage Rooms</h3>
		Edit available rooms.
	</div>
</a>
<a href="<?=Yii::app()->createUrl('manage/sections'); ?>">
	<div class="reportButton">
		<h3>Manage Sections</h3>
		Edit available sections.
	</div>
</a>
<a href="<?=Yii::app()->createUrl('manage/types'); ?>">
	<div class="reportButton">
		<h3>Manage Event Types</h3>
		Edit available types.
	</div>
</a>
<a href="<?=Yii::app()->createUrl('manage/reports'); ?>">
	<div class="reportButton">
		<h3>Manage Reports</h3>
		Edit available reports.
	</div>
</a>
<a href="<?=Yii::app()->createUrl('manage/banlist'); ?>">
	<div class="reportButton">
		<h3>Manage IP Banlist</h3>
		Add/remove IPs to/from the banlist.
	</div>
</a>
<a href="<?=Yii::app()->createUrl('manage/log'); ?>">
	<div class="reportButton">
		<h3>View Log</h3>
		View the site log.
	</div>
</a>