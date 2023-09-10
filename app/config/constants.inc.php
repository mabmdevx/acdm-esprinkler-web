<?php
$config_app = parse_ini_file('../../config/app.ini');

// Site
define("SITE_NAME", $config_app['SITE_NAME']);
define("SITE_SHORT_NAME", $config_app['SITE_SHORT_NAME']);

// Site Mode
include_once("sitemode.inc.php");

// Database
switch($SITE_MODE)
{
	case "LOCAL":
	// http://localhost/xyz/
	define("DB_HOST", $config_app['DB_HOST_LOCAL']);
	define("DB_USER", $config_app['DB_USER_LOCAL']);
	define("DB_PASSWORD", $config_app['DB_PASSWORD_LOCAL']);
	define("DB_HOST_REPLICA","");
	define("DB_USER_REPLICA","");
	define("DB_PASSWORD_REPLICA","");
	define("DB_NAME", $config_app['DB_NAME_LOCAL']);
	break;

	case "DEV":
	// http://www.xyz.com
	define("DB_HOST", $config_app['DB_HOST_DEV']);
	define("DB_USER", $config_app['DB_USER_DEV']);
	define("DB_PASSWORD", $config_app['DB_PASSWORD_DEV']);
	define("DB_HOST_REPLICA","");
	define("DB_USER_REPLICA","");
	define("DB_PASSWORD_REPLICA","");
	define("DB_NAME", $config_app['DB_NAME_DEV']);
	break;

	case "LIVE":
	// http://esprinkler.1eko.com
	define("DB_HOST", $config_app['DB_HOST_LIVE']);
	define("DB_USER", $config_app['DB_USER_LIVE']);
	define("DB_PASSWORD", $config_app['DB_PASSWORD_LIVE']);
	define("DB_HOST_REPLICA","");
	define("DB_USER_REPLICA","");
	define("DB_PASSWORD_REPLICA","");
	define("DB_NAME", $config_app['DB_NAME_LIVE']);
	break;

	case "LIVE2":
	// http://esprinkler.bugs3.com
	define("DB_HOST", $config_app['DB_HOST_LIVE2']);
	define("DB_USER", $config_app['DB_USER_LIVE2']);
	define("DB_PASSWORD", $config_app['DB_PASSWORD_LIVE2']);
	define("DB_HOST_REPLICA","");
	define("DB_USER_REPLICA","");
	define("DB_PASSWORD_REPLICA","");
	define("DB_NAME", $config_app['DB_NAME_LIVE2']);
	break;

	case "LIVE3":
	// http://esprinkler.iwiin.com
	define("DB_HOST", $config_app['DB_HOST_LIVE3']);
	define("DB_USER", $config_app['DB_USER_LIVE3']);
	define("DB_PASSWORD", $config_app['DB_PASSWORD_LIVE3']);
	define("DB_HOST_REPLICA","");
	define("DB_USER_REPLICA","");
	define("DB_PASSWORD_REPLICA","");
	define("DB_NAME", $config_app['DB_NAME_LIVE3']);
	break;

	case "LIVE4":
	// http://esprinkler.wink.ws
	define("DB_HOST", $config_app['DB_HOST_LIVE4']);
	define("DB_USER", $config_app['DB_USER_LIVE4']);
	define("DB_PASSWORD", $config_app['DB_PASSWORD_LIVE4']);
	define("DB_HOST_REPLICA","");
	define("DB_USER_REPLICA","");
	define("DB_PASSWORD_REPLICA","");
	define("DB_NAME", $config_app['DB_NAME_LIVE4']);
	break;
}

// Misc
switch($SITE_MODE)
{
	case "LOCAL":
	// http://localhost/xyz/
	error_reporting(E_ALL);
	define("SYSPLATFORM","windows"); // windows | linux
	date_default_timezone_set("America/Chicago");
	$PROTOCOL = "http://";
	$SITE_DOMAIN = $_SERVER['SERVER_NAME']."/";
	$SITE_FOLDER = "esprinkler_web/"; // when goes to live set value to blank Eg. $SITE_FOLDER = "";
	$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
	$SITE_URL = $PROTOCOL.$SITE_DOMAIN.$SITE_FOLDER;
	$SITE_PATH = $DOC_ROOT.$SITE_FOLDER;
	break;

	case "DEV":
	// http://www.xyz.com
	define("SYSPLATFORM","linux"); // windows | linux
	date_default_timezone_set("America/Chicago");
	$PROTOCOL = "http://";
	$SITE_DOMAIN = $_SERVER['SERVER_NAME']."/";
	$SITE_FOLDER = ""; // when goes to live set value to blank Eg. $SITE_FOLDER = "";
	$DOC_ROOT = $_SERVER['DOCUMENT_ROOT']."/";
	$SITE_URL = $PROTOCOL.$SITE_DOMAIN.$SITE_FOLDER;
	$SITE_PATH = $DOC_ROOT.$SITE_FOLDER;
	break;

	case "LIVE":
	// http://www.xyz.com
	define("SYSPLATFORM","linux"); // windows | linux
	date_default_timezone_set("America/Chicago");
	$PROTOCOL = "http://";
	$SITE_DOMAIN = $_SERVER['SERVER_NAME']."/";
	$SITE_FOLDER = "/"; // when goes to live set value to blank Eg. $SITE_FOLDER = "";
	$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
	$SITE_URL = $PROTOCOL.$SITE_DOMAIN.$SITE_FOLDER;
	$SITE_PATH = $DOC_ROOT.$SITE_FOLDER;
	break;

	case "LIVE2":
	// http://www.xyz.com
	define("SYSPLATFORM","linux"); // windows | linux
	date_default_timezone_set("America/Chicago");
	$PROTOCOL = "http://";
	$SITE_DOMAIN = $_SERVER['SERVER_NAME']."/";
	$SITE_FOLDER = "/"; // when goes to live set value to blank Eg. $SITE_FOLDER = "";
	$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
	$SITE_URL = $PROTOCOL.$SITE_DOMAIN.$SITE_FOLDER;
	$SITE_PATH = $DOC_ROOT.$SITE_FOLDER;
	break;

	case "LIVE3":
	// http://www.xyz.com
	define("SYSPLATFORM","linux"); // windows | linux
	date_default_timezone_set("America/Chicago");
	$PROTOCOL = "http://";
	$SITE_DOMAIN = $_SERVER['SERVER_NAME']."/";
	$SITE_FOLDER = "/"; // when goes to live set value to blank Eg. $SITE_FOLDER = "";
	$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
	$SITE_URL = $PROTOCOL.$SITE_DOMAIN.$SITE_FOLDER;
	$SITE_PATH = $DOC_ROOT.$SITE_FOLDER;
	break;

	case "LIVE4":
	// http://www.xyz.com
	define("SYSPLATFORM","linux"); // windows | linux
	date_default_timezone_set("America/Chicago");
	$PROTOCOL = "http://";
	$SITE_DOMAIN = $_SERVER['SERVER_NAME']."/";
	$SITE_FOLDER = "/"; // when goes to live set value to blank Eg. $SITE_FOLDER = "";
	$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
	$SITE_URL = $PROTOCOL.$SITE_DOMAIN.$SITE_FOLDER;
	$SITE_PATH = $DOC_ROOT.$SITE_FOLDER;
	break;
}



// Site Settings from DB
$dbObj = new dbConnection();
$scQry="select * from settingsconfig where sc_id=1";
$scRes=$dbObj->fireQuery($scQry);

$sc_site_title="";
if(isset($scRes) && count($scRes)>0 && $scRes!=false)
{
	$sc_site_title=$scRes[0]['sc_site_title'];
}

// Site URL and Site Path
define("SITE_URL_CONST", $SITE_URL);
define("WEBSITE_URL", $SITE_URL);
define("WEBSITE_PATH", $SITE_PATH);

// Other
define("HOME_PAGE", "index.php");
define("RUN_CRON",1); // Turn On/Off Cron
define("LOG_ACCESS",1); // Turn On/Off Access Log
define("LOG_ACTIVITY",1); // Turn On/Off Activity Log

set_include_path(WEBSITE_PATH."lib/");

?>
