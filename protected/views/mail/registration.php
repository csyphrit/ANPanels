<?php
/**
 * @var Profile $profile
 */
?>
<html>
<head><title></title></head>
<body>
A new account has been created for you on the <?=Config::getValue('CONVENTION_NAME'); ?> Panelist Registration site. Your username is as follows: <?=$profile->email; ?><br /><br />

You may login and register for panels at <?=Config::getValue('URL'); ?>
</body>
</html>