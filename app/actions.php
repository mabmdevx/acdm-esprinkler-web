<?php




switch($page)
{
case "login":
$pageRtn=include_once("pages/login.php");
break;

case "logout":
$pageRtn=include_once("pages/logout.php");
break;

case "dashboard":
$pageRtn=include_once("pages/dashboard.php");
break;

case "user_profile":
$pageRtn=include_once("pages/user_profile.php");
break;

case "settings":
$pageRtn=include_once("pages/settings.php");
break;

case "manage_users":
$pageRtn=include_once("pages/manage_users.php");
break;

case "set_location":
$pageRtn=include_once("pages/set_location.php");
break;

case "set_mode":
$pageRtn=include_once("pages/set_mode.php");
break;

case "set_moisture_level":
$pageRtn=include_once("pages/set_moisture_level.php");
break;

case "status":
$pageRtn=include_once("pages/status.php");
break;

case "weather":
$pageRtn=include_once("pages/weather.php");
break;

case "manual_control":
$pageRtn=include_once("pages/manual_control.php");
break;

case "scheduler":
$pageRtn=include_once("pages/scheduler.php");
break;

default:
$pageRtn=include_once("pages/404page.php");
break;
}




if($pageRtn==false)
{
include_once("pages/404page.php");
}




?>
