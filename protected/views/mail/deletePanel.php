<?php
/**
 * @var Event $event
 * @var integer $userid
 */
$user = UserHelper::getUserById($userid);
$sections = PanelHelper::getSections();
?>
<html>
<head><title></title></head>
<body>
<?=$event->name; ?> has been cancelled due to lack of interest and/or time slots. If you believe there is reason to reverse this action, please contact us as soon as possible.
</body>
</html>