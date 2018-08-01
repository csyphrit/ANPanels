<?php
/**
 * @var Event $event
 * @var array $users
 */
?>
<html>
<head><title></title></head>
<body>
<?=$event->name; ?> has passed the minimum qualifications for approval.<br /><br />

Current registered panelists are:<br />
<?php
foreach ($users as $row) {
    $user = UserHelper::getUserById($row['userid']);
    if (!is_object($user) || !is_object($user->profile)) {
    	continue;
    }
    
    if ($user->profile->alias) {
        echo $user->profile->alias;
    } else {
        echo $user->profile->name;
    }
    echo ' - ' . $user->profile->email;
    if ($row['moderator']) {
        echo ' [Moderator]';
    }
    echo '<br />';
}
?><br />
The current description is:<br />
<?=$event->description; ?><br /><br />

If you would like to change any of the above info, please email <?=Config::getValue('CORRECTION_EMAIL'); ?> as soon as possible.<br /><br />

<?php
$avDate = Config::getValue('AV_DATE');
if (!empty($avDate)) {
?>
PLEASE NOTE:<br />
If your project involves AV (powerpoint, multimedia, etc), the files must have been finalized by<?=Config::getValue('AV_DATE'); ?>.  This is to give us sufficient time to test and correct any issue cropping up in updates.. (Extensions CAN be granted under special circumstances.)
<?php
}
?>
</body>
</html>
