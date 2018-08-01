<?php
/**
 * @var $this Controller
 * @var $content string
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	
	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/theme.css" />

    <script src="http://www.christiesyphrit.com/jquery/jquery-3.1.0.min.js" ></script>
    <script src="http://www.christiesyphrit.com/bootstrap/js/bootstrap.min.js"></script>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
    
    <div class="container" id="page">

	<div id="header">
		<div id="logo"></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->renderPartial('//layouts/_menu'); ?>
	</div><!-- mainmenu -->

 <?php
    $banned = Blocklist::inBanlist($_SERVER['REMOTE_ADDR']);
    if ($banned) {
    	echo 'Your IP address has been flagged for spam. Please contact webmaster@anpanels.com if you feel this is in error.';
    } elseif (Yii::app()->user->isGuest && !($this->action->id === 'register' || $this->action->id === 'forgotPassword')) {
        echo '<div id="content">';
        $this->renderPartial("//site/login", array("model" => new LoginForm()));
        echo '</div>';
    } else {
        echo $content;
    }
    ?>

	<div class="clear"></div>

	<div id="footer">
        Copyright © <?=date('Y'); ?> <?=Config::getValue('CONVENTION_NAME'); ?>. All Rights Reserved.<br /><br />
        <?php
        $facebook = Config::getValue('FACEBOOK');
        if (!empty($facebook)) {
            ?>
            <div id="fb-root"></div>

            <div class="fb-like" data-href="<?=$facebook; ?>" data-layout="button" data-action="like" data-show-faces="false" data-share="true"></div>&nbsp;
            <?php
        }
        $twitter = Config::getValue('TWITTER');
        if (!empty($twitter)) {
            ?>
            <a href="https://twitter.com/<?=Config::getValue('TWITTER_NAME'); ?>" class="twitter-follow-button" data-show-count="false" data-lang="en">Follow @<?=Config::getValue('TWITTER_NAME'); ?></a>
            <a href="https://twitter.com/share?text=I signed up for panels at <?=Config::getValue('CONVENTION_NAME'); ?>&via=<?=Config::getValue('TWITTER_NAME'); ?>&url=<?=Config::getValue('CONVENTION_WEBSITE'); ?>"
            class="twitter-share-button" data-lang="en">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
            <?php
        }
        ?><br /><br />
        <a href="mailto:webmaster@anpanels.com">Technical Support</a> | <a href="mailto:<?=Config::getValue('PANELMASTER_EMAIL'); ?>">Contact Us </a>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>