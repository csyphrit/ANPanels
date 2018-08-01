<?php
$theme = array();
$themeFile = __DIR__ . '/' . Yii::app()->theme->name . '.php';
if (file_exists($themeFile)) {
	require_once($themeFile);
}
$site = array(
	'PANEL_REFUND' => 'Each panel submission must include a one or two sentence description of the panel topic. You must participate in at least five panels to get your full registration price back.',
	'LOGIN_MESSAGE' => 'Login has changed. If you have not already done so, please use the Forgot Your Password link below to reset your password. You only need to do this once. Your new username is your email address.',
	'PREV_PANELS' => 'Previous Panels',
	'OCPREV_PANELS' => 'Previous Conventions and Panels',
	'PREV_MOD' => 'Have you been a moderator before?',
	'PREV_MOD_PANELS' => 'Panels Previously Moderated',
	'PANEL_NAME_HINT' => '1 to 5 words long. Do not add the year to the title.',
	'PANEL_AV_HINT' => 'Please specify needs and justification in comments. All files are due at the time of submission. See the forum for rules.',
	'OPEN_PANELS' => 'Yaoi/Yuri North Open Panels',
        'PANEL_DOUBLE_HINT' => 'All panels are 1 hour unless requested otherwise. 2 hour slots are not guaranteed.',
        'PANEL_DESCRIPTION_HINT' => 'Descriptions should be 1 medium sentence or 2 short sentences. Submitted descriptions may be edited for space, grammar, or any other reason.',
);
return array_merge($site, $theme);
?>