<?php
$config = Config::getValues();
echo '<form action="' . Yii::app()->baseUrl . '/index.php/manage/config" method="post">';
echo '<table>';
foreach ($config as $row) {
	echo '<tr><td><b>' . $row['token'] . '</b></td><td>';
	echo '<input name="' . $row['token'] . '" value="' . $row['param'] . '" size="100" /></td></tr>';
}

echo '</table>';
echo '<button type="submit">Save</button>';
echo '</form>';
?>