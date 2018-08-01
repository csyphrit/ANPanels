<?php
return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
        // autoloading model and component classes
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
			'db'=>array(
                'connectionString' => 'mysql:host=localhost;dbname=panel_test',
			),
		),
	)
);
?>