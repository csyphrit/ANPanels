<?php
/**
 * Menu widget
 */
$user = UserHelper::getCurrentUser();
$config = new Config();
$items = array();

if (!Yii::app()->user->isGuest && !is_object($user)) {
  header('location: http://anpanels.com/index.php/site/logout');
  exit;
} elseif (!Yii::app()->user->isGuest && is_object($user)) {
    if ($user->privilege >= 5) {
        $items = array(
            array(
                'label' => 'Home',
                'url' => array('/admin/index')
            ),
            array(
                'label' => 'Panels/Events',
                'url' => array('/admin/events'),
            ),
            array(
                'label' => 'Reports',
                'url' => array('/admin/reports'),
            ),
        );
        if ($user->privilege >= 7) {
            $items[] = array(
                'label' => 'Panelists',
                'url' => array('/admin/users'),
            );
        }
        if ($user->privilege >= 9) {
            $items[] = array(
                'label' => 'Admin',
                'url' => array('/manage/index'),
            );
        }
        
    } else {
        $items = array(
            array(
                'label' => 'Home',
                'url' => array('/site/index')
            ),
            array(
                'label' => 'Your Schedule',
                'url'=>array('/site/schedule')
            ),
            array(
                'label' => 'Update Profile',
                'url'=>array('/site/profile')
            ),
            array(
                'label' => 'Register Panels',
                'url' => array('/site/addpanel')
            ),
        );
        if (SiteSettings::getValue('GAMESHOWS')) {
        	$items[] = array(
        		'label' => 'Register Gameshow',
        		'url' => array('/site/addgameshow'),
        	);
        }
        if (SiteSettings::getValue('WORKSHOPS')) {
        	$items[] = array(
        		'label' => 'Register Workshop',
        		'url' => array('/site/addworkshop'),
        	);
        }
    }

    $items[] = array(
        'label' => 'Logout (' . Yii::app()->user->name . ')',
        'itemOptions' => array('class' => 'right'),
        'url'=>array('/site/logout')
    );
    if (Config::getValue('USE_FORUM')) {
        $items[] = array(
            'label' => 'Forums',
            'itemOptions' => array('class' => 'right'),
            'url' => $config->getValue('FORUM_WEBSITE'),
        );
    }
    if (Config::getValue('USE_FACEBOOK')) {
    	$items[] = array(
    	    'label' => 'Facebook',
    	    'itemOptions' => array('class' => 'right facebook'),
    	    'url' => $config->getValue('FACEBOOK'),
    	);
    }

    if ($user->privilege >= 5) {
        $items[] = array(
            'label' => 'Account Information',
            'itemOptions' => array('class' => 'right'),
            'url' => array('/site/profile')
        );
    }


} else {
    $items = array(
        array(
          'label' => 'Home',
          'url' => array('/site/index')
        )
     );
     if (Config::getValue('USE_FORUM')) {
        $itmes[] = array(
            'label' => 'Forums',
            'itemOptions' => array('class' => 'right'),
            'data' => $config->getValue('FORUM_WEBSITE'),
            'url' => array('#')
        );
    }
}

$this->widget('zii.widgets.CMenu',array(
    	'items' => $items
));
?>