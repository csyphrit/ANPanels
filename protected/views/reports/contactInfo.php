<?php
// disable caching
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    // force download  
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename=guidebook_export_" . date("Y-m-d") . ".csv");
    header("Content-Transfer-Encoding: binary");
?>
Name,Alias,Forum ID,Email,Phone
<?php
$users = Profile::getUsers();
foreach ($users as $user) {
	$reg = Registration::getConfirmedEventsByUser($user['userid']);
	if (empty($reg)) {
		continue;
	}
	echo '"' . $user['name'] . '","' . $user['alias'] . '",' . $user['teahouseid'] . ',' . $user['email'] . ',' . $user['phone'] .  "\n";
}
?>