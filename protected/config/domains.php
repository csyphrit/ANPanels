<?php
/**
 * Valid Site IDs
 */
$allowed_sites = array('anpanels', 'ganime', 'yaoinorth', 'christiesyphrit', 'fanevents', 'bishounen');
$site = '';

/**
 * Valid domains
 */
$allowed_domains = array('yaoinorth', 'anpanels', 'christiesyphrit');

$matches = array();
//Check url and verify that it's a well-formed url (www.anpanels.com, etc)
$valid_domain = preg_match('/^((?<subdomain>[a-zA-Z]*)\.)?(?<domain>[a-zA-Z0-9]*)(\.com)$/', $_SERVER['SERVER_NAME'], $matches);
if (!$valid_domain || !isset($matches['domain'])) {
	header('location: http://www.anpanels.com/access_denied.php');
	exit;
}
	
//Verify that the domain is on the allowed domains list
$domain = strtolower($matches['domain']);
if (!in_array($domain, $allowed_domains)) {
	header('location: http://www.anpanels.com/access_denied.php');
	exit;
}

//Set site based on the subdomain. If the subdomain is not a valid site, default to the domain.
$subdomain = isset($matches['subdomain']) ? strtolower($matches['subdomain']) : '';
if (in_array($subdomain, $allowed_sites)) {
	$site = $subdomain;
}
elseif (in_array($domain, $allowed_sites))
{
	$site = $domain;
}
else
{
	header('location: http://www.anpanels.com/access_denied.php');
	exit;
}

$dbName = 'chris442_panels_dev';
$conName = 'Anime North';
$theme = 'animenorth';
switch ($site) {
	case 'anpanels':
		$dbName = 'chris442_panels';
		break;
	case 'fanevents':
		$dbName = 'chris442_fanevents';
		$conName = 'Fan Events Forum';
		$theme = 'fanevents';
		break;
	case 'ganime':
		$dbName = 'chris442_ganime';
		$conName = 'GAnime';
		$theme = 'ganime';
		break;
	case 'bishounen':
		$dbName = 'chris442_bishounen';
		$conName = 'BishounenCon';
		$theme = 'bishounen';
		break;
}