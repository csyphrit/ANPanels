<?php
/**
 * @var Event $event
 * @var integer $userid
 * @var string $commnets
 */
$user = UserHelper::getUserById($userid);
$sections = PanelHelper::getSections();
?>
<html>
<head><title></title></head>
<body>
The user <?=$user->profile->name; ?> has been added to a panel.<br /><br />

Name: <?=$user->profile->name; ?><br />
Alias: <?=$user->profile->alias; ?><br />
Email: <?=$user->username; ?><br />
Address: <?=$user->profile->address; ?>, <?=$user->profile->city; ?>, <?=$user->profile->state; ?> <?=$user->profile->zip; ?> <?=$user->profile->country; ?><br />
Phone: <?=$user->profile->phone; ?><br />
<?php if (Config::getValue('USE_FORUM')) { ?>
Forum Name: <?=$user->profile->forumName; ?><br />
<?php } ?>
Age: <?=$user->profile->age; ?><br />
<?php if (SiteSettings::getValue('PREV_PANELS')) { ?>
Previous Panelist: <?=$user->profile->prev_panelist; ?><br />
<?php } ?>
<?=Yii::t('site', 'PREV_PANELS'); ?> <?=$user->profile->prev_panels; ?><br />
<?php if (SiteSettings::getValue('PREV_PANELS')) { ?>
Previous Panelist at Other Cons: <?=$user->profile->ocprev_panelist; ?><br />
<?php } ?>
<?=Yii::t('site', 'OCPREV_PANELS'); ?> <?=$user->profile->ocprev_panels; ?><br />
<?php if (SiteSettings::getValue('PREV_PANELS')) { ?>
Previous Moderator: <?=$user->profile->prev_mod; ?><br />
<?php } ?>
<?=Yii::t('site', 'PREV_MOD_PANELS'); ?> <?=$user->profile->prev_mod_panels; ?><br />

Unavailable: <?=$user->profile->unavailable; ?><br /><br />

<?=$event->name; ?><br />
Section: <?=$sections[$event->section]; ?><br />
Description: <?=$event->description; ?><br />
Comments: <?=$comments; ?>
</body>
</html>