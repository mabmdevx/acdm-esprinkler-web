<?php

function moisture_sensor_reading_to_percent($moisture_sensor_reading)
{
	if($moisture_sensor_reading <= 192)
	{
		$moisture_reading_percent = 100;
	}
	elseif($moisture_sensor_reading > 192 && $moisture_sensor_reading <= 290)
	{
		$moisture_reading_percent = 90;
	}
	elseif($moisture_sensor_reading > 290 && $moisture_sensor_reading <= 330)
	{
		$moisture_reading_percent = 80;
	}
	elseif($moisture_sensor_reading > 330 && $moisture_sensor_reading <= 440)
	{
		$moisture_reading_percent = 50;
	}
	elseif($moisture_sensor_reading > 440 && $moisture_sensor_reading <= 655)
	{
		$moisture_reading_percent = 30;
	}
	elseif($moisture_sensor_reading > 655 && $moisture_sensor_reading <= 790)
	{
		$moisture_reading_percent = 20;
	}
	elseif($moisture_sensor_reading > 790 && $moisture_sensor_reading <= 850)
	{
		$moisture_reading_percent = 20;
	}
	elseif($moisture_sensor_reading > 850 && $moisture_sensor_reading <= 880)
	{
		$moisture_reading_percent = 10;
	}
	elseif($moisture_sensor_reading > 880)
	{
		$moisture_reading_percent = 0;
	}
	
	return $moisture_reading_percent;
}

function get_scheduler()
{
	global $dbObj;
	
	$piOperationQry="SELECT sc_sprinkler_scheduler_start_date,sc_sprinkler_scheduler_time_start1,sc_sprinkler_scheduler_time_end1,sc_sprinkler_scheduler_time_start2,sc_sprinkler_scheduler_time_end2,sc_sprinkler_scheduler_time_start3,sc_sprinkler_scheduler_time_end3,sc_sprinkler_scheduler_interval_day FROM settingsconfig WHERE sc_id = 1 ";
	$piOperationRes=$dbObj->fireQuery($piOperationQry);
	

	if(isset($piOperationRes) && count($piOperationRes)>0 && $piOperationRes!=false)
	{ 
	return $piOperationRes; 
	}
	
}

function get_moisture_level()
{
	global $dbObj;
	
	$settingsQry="select * from settingsconfig where sc_id = 1";
	$settingsRes=$dbObj->fireQuery($settingsQry);
	
	$sc_sprinkler_moisture_level="";
	if(isset($settingsRes) && count($settingsRes)>0 && $settingsRes!=false)
	{ 
	$sc_sprinkler_moisture_level=get_data($settingsRes[0]['sc_sprinkler_moisture_level']); 
	}
	
	return $sc_sprinkler_moisture_level;
}



function get_location_city()
{
	global $dbObj;
	
	$piOperationQry="SELECT sc_sprinkler_location_city FROM settingsconfig WHERE sc_id = 1 ";
	$piOperationRes=$dbObj->fireQuery($piOperationQry);
	
	$sc_sprinkler_location_city="";
	if(isset($piOperationRes) && count($piOperationRes)>0 && $piOperationRes!=false)
	{ 
	$sc_sprinkler_location_city=get_data($piOperationRes[0]['sc_sprinkler_location_city']); 
	}
	
	return $sc_sprinkler_location_city;
}

function get_location_state()
{
	global $dbObj;
	
	$piOperationQry="SELECT sc_sprinkler_location_state FROM settingsconfig WHERE sc_id = 1 ";
	$piOperationRes=$dbObj->fireQuery($piOperationQry);
	
	$sc_sprinkler_location_state="";
	if(isset($piOperationRes) && count($piOperationRes)>0 && $piOperationRes!=false)
	{ 
	$sc_sprinkler_location_state=get_data($piOperationRes[0]['sc_sprinkler_location_state']); 
	}
	
	return $sc_sprinkler_location_state;
}

function get_moisture_sensor_reading()
{
	global $dbObj;
	
	$piOperationQry="SELECT sc_sprinkler_moisture_sensor_reading FROM settingsconfig WHERE sc_id = 1 ";
	$piOperationRes=$dbObj->fireQuery($piOperationQry);
	
	$sc_sprinkler_moisture_sensor_reading="";
	if(isset($piOperationRes) && count($piOperationRes)>0 && $piOperationRes!=false)
	{ 
	$sc_sprinkler_moisture_sensor_reading=get_data($piOperationRes[0]['sc_sprinkler_moisture_sensor_reading']); 
	}
	
	return $sc_sprinkler_moisture_sensor_reading;
}

function save_moisture_sensor_reading($moisture_sensor_reading)
{
	global $dbObj;
	
	$piUpdateQry="UPDATE settingsconfig SET sc_sprinkler_moisture_sensor_reading='".$moisture_sensor_reading."' WHERE sc_id = 1 ";
	$piUpdateRes=$dbObj->fireQuery($piUpdateQry,"update");
	
	return "true";
}

function set_moisture_level($moisturelevel)
{
	global $dbObj;

	$piUpdateQry="UPDATE settingsconfig SET sc_sprinkler_moisture_level='".$moisturelevel."' WHERE sc_id = 1 ";
	$piUpdateRes=$dbObj->fireQuery($piUpdateQry,"update");
	
	return "true";
}

function set_mode($mode)
{
	global $dbObj;

	$piUpdateQry="UPDATE settingsconfig SET sc_sprinkler_mode='".$mode."' WHERE sc_id = 1 ";
	$piUpdateRes=$dbObj->fireQuery($piUpdateQry,"update");
	
	return "true";
}

function set_location($location_city,$location_state)
{
	global $dbObj;
	
	$piUpdateQry="UPDATE settingsconfig SET sc_sprinkler_location_city='".$location_city."',sc_sprinkler_location_state='".$location_state."' WHERE sc_id = 1 ";
	$piUpdateRes=$dbObj->fireQuery($piUpdateQry,"update");
	
	return "true";
}

function check_auth($username,$password)
{
	global $dbObj;
	
	if( isset($username) && isset($password) && strlen($username)>0 && strlen($password)>0 )
	{

		$usersQry="select sysuser_id,sysuser_login,sysuser_password,sysuser_role,sysuser_email from sysuser where sysuser_login='".$username."' AND is_deleted = 'no' AND is_validated='yes' AND sysuser_status='active' ";
		$usersRes=$dbObj->fireQuery($usersQry);
	
	}
		
	if(isset($usersRes) && count($usersRes)>0 && $usersRes!=false)
	{
		if( ($usersRes[0]['sysuser_login']==$username)  && ($usersRes[0]['sysuser_password']==$password) )
		{
			return "true";
		}
	}
	
	return "false";
}

function get_sprinkler_intellisense_value($moisture_sensor_reading)
{
	$moisture_sensor_percent = moisture_sensor_reading_to_percent($moisture_sensor_reading);
	$moisture_level = get_moisture_level();
	$rain_pop = get_rain_pop();
	
	$responsibility_percent_sprinkler = (($moisture_level*(100-$rain_pop))/100);
	$responsibility_percent_rain = $moisture_level - $responsibility_percent_sprinkler;
	
	return $responsibility_percent_sprinkler;
}

function get_sprinkler_intellisense_operation($moisture_sensor_reading)
{
	$moisture_sensor_percent = moisture_sensor_reading_to_percent($moisture_sensor_reading);
	$moisture_level = get_moisture_level();
	$rain_pop = get_rain_pop();
	
	$responsibility_percent_sprinkler = (($moisture_level*(100-$rain_pop))/100);
	$responsibility_percent_rain = $moisture_level - $responsibility_percent_sprinkler;
	 
	 
	if($moisture_sensor_percent < $responsibility_percent_sprinkler)
	{
		$sprinkler_operation="on";
	}
	else
	{
		$sprinkler_operation="off";
	}
}


function get_sprinkler_manual_operation()
{
	global $dbObj;
	
	$piOperationQry="SELECT sc_sprinkler_manual_operation FROM settingsconfig WHERE sc_id = 1 ";
	$piOperationRes=$dbObj->fireQuery($piOperationQry);
	
	$sprinkler_operation="";
	if(isset($piOperationRes) && count($piOperationRes)>0 && $piOperationRes!=false)
	{ 
	$sprinkler_operation=get_data($piOperationRes[0]['sc_sprinkler_manual_operation']); 
	}
	
	return $sprinkler_operation;
}

function get_sprinkler_scheduler_operation()
{
	global $dbObj;
	
	$sprinkler_operation = "off";
	
	$date_now=date("Y-m-d");
	$date_now_ts=time();

	$time_now=date('H:ia');
		
	$piOperationQry="SELECT * FROM settingsconfig WHERE sc_id = 1 ";
	$piOperationRes=$dbObj->fireQuery($piOperationQry);
	
	$scheduler_start_date="";
	$scheduler_time_start1="";
	$scheduler_time_end1="";
	$scheduler_time_start2="";
	$scheduler_time_end2="";
	$scheduler_time_start3="";
	$scheduler_time_end3="";
	$scheduler_interval_day="";
	
	if(isset($piOperationRes) && count($piOperationRes)>0 && $piOperationRes!=false)
	{ 
		$scheduler_start_date=get_data($piOperationRes[0]['sc_sprinkler_scheduler_start_date']); 
		$scheduler_time_start1=get_data($piOperationRes[0]['sc_sprinkler_scheduler_time_start1']); 
		$scheduler_time_end1=get_data($piOperationRes[0]['sc_sprinkler_scheduler_time_end1']); 
		$scheduler_time_start2=get_data($piOperationRes[0]['sc_sprinkler_scheduler_time_start2']); 
		$scheduler_time_end2=get_data($piOperationRes[0]['sc_sprinkler_scheduler_time_end2']); 
		$scheduler_time_start3=get_data($piOperationRes[0]['sc_sprinkler_scheduler_time_start3']); 
		$scheduler_time_end3=get_data($piOperationRes[0]['sc_sprinkler_scheduler_time_end3']); 
		$scheduler_interval_day=get_data($piOperationRes[0]['sc_sprinkler_scheduler_interval_day']); 
	}
	
	//$date_monday = date("Y-m-d",strtotime('monday this week'));
	
	$scheduler_start_date_ts = strtotime($scheduler_start_date);
	$day_gap = custom_date_diff_days($scheduler_start_date_ts,$date_now_ts)-1;
	
	//var_dump($day_gap);
	
	$interval_today = false;
	if($day_gap % $scheduler_interval_day==0)
	{
		$interval_today = true;
	}
	
	//var_dump($interval_today);

	if($interval_today==true)
	{
	
		$schx_time_start1 = $date_now." ".$scheduler_time_start1;
		$schx_time_start1_ts = strtotime($schx_time_start1);

		$schx_time_end1 = $date_now." ".$scheduler_time_end1;
		$schx_time_end1_ts = strtotime($schx_time_end1);
		
		if(strlen($scheduler_time_start2)>0 && strlen($scheduler_time_end2)>0)
		{
		$schx_time_start2 = $date_now." ".$scheduler_time_start2;
		$schx_time_start2_ts = strtotime($schx_time_start2);
		
		$schx_time_end2 = $date_now." ".$scheduler_time_end2;
		$schx_time_end2_ts = strtotime($schx_time_end2);
		}
		
		if(strlen($scheduler_time_start3)>0 && strlen($scheduler_time_end3)>0)
		{
		$schx_time_start3 = $date_now." ".$scheduler_time_start3;
		$schx_time_start3_ts = strtotime($schx_time_start3);
		
		$schx_time_end3 = $date_now." ".$scheduler_time_end3;
		$schx_time_end3_ts = strtotime($schx_time_end3);
		}
		
		//var_dump($date_now_ts);
		//var_dump($schx_time_end3_ts);
		
		if(($date_now_ts >= $schx_time_start1_ts) && ($date_now_ts <= $schx_time_end1_ts))
		{
			$sprinkler_operation = "on";
		}
		elseif(strlen($scheduler_time_start2)>0 && strlen($scheduler_time_end2)>0 && ($date_now_ts >= $schx_time_start2_ts) && ($date_now_ts <= $schx_time_end2_ts))
		{
			$sprinkler_operation = "on";
		}
		elseif(strlen($scheduler_time_start3)>0 && strlen($scheduler_time_end3)>0 && ($date_now_ts >= $schx_time_start3_ts) && ($date_now_ts <= $schx_time_end3_ts))
		{
			$sprinkler_operation = "on";
		}
	
	}

	//var_dump($sprinkler_operation); exit;
	
	return $sprinkler_operation;
}



function rpi_turn_on_manual_db()
{
	global $dbObj;
	
	$mysqlnow=date('Y-m-d H:i:s');
	
	$piOperationUpdateQry="UPDATE settingsconfig SET sc_sprinkler_manual_operation='on', sc_sprinkler_manual_lmdate='".$mysqlnow."' WHERE sc_id = 1 ";
	$piOperationUpdateRes=$dbObj->fireQuery($piOperationUpdateQry,"update");
	
	return true;
}

function rpi_turn_off_manual_db()
{
	global $dbObj;
	
	$mysqlnow=date('Y-m-d H:i:s');
	
	$piOperationUpdateQry="UPDATE settingsconfig SET sc_sprinkler_manual_operation='off', sc_sprinkler_manual_lmdate='".$mysqlnow."' WHERE sc_id = 1 ";
	$piOperationUpdateRes=$dbObj->fireQuery($piOperationUpdateQry,"update");
	
	return true;
}

function scheduler_db($scheduler_start_date,$scheduler_time_start1,$scheduler_time_end1,$scheduler_time_start2,$scheduler_time_end2,$scheduler_time_start3,$scheduler_time_end3,$scheduler_interval_day)
{
	global $dbObj;
	
	$mysqlnow=date('Y-m-d H:i:s');
	
	$piOperationUpdateQry="UPDATE settingsconfig SET 
	sc_sprinkler_scheduler_start_date='".$scheduler_start_date."', 
	sc_sprinkler_scheduler_time_start1='".$scheduler_time_start1."',
	sc_sprinkler_scheduler_time_end1='".$scheduler_time_end1."', 
	sc_sprinkler_scheduler_time_start2='".$scheduler_time_start2."',
	sc_sprinkler_scheduler_time_end2='".$scheduler_time_end2."', 
	sc_sprinkler_scheduler_time_start3='".$scheduler_time_start3."',
	sc_sprinkler_scheduler_time_end3='".$scheduler_time_end3."',
	sc_sprinkler_scheduler_interval_day='".$scheduler_interval_day."',
	sc_sprinkler_scheduler_lmdate='".$mysqlnow."' 
	WHERE sc_id = 1 ";
	
	$piOperationUpdateRes=$dbObj->fireQuery($piOperationUpdateQry,"update");
	
	return "true";
}

function get_weather_info_status()
{
	$weatherCurrentXml = get_weather_current_xml();
	$weather_icon_url = $weatherCurrentXml->current_observation->weather;
	return $weather_icon_url;
}

function get_weather_icon()
{
	$weatherCurrentXml = get_weather_current_xml();
	$weather_icon_url = $weatherCurrentXml->current_observation->icon_url;
	return $weather_icon_url;
}

function get_rain_pop()
{
	$weatherForecastXml = get_weather_forecast_xml();
	$weather_rain_pop = $weatherForecastXml->hourly_forecast->forecast[0]->pop;
	return $weather_rain_pop;
}

function get_rain_current()
{
	$weatherCurrentXml = get_weather_current_xml();
	$weather_rain_current = $weatherCurrentXml->current_observation->precip_1hr_string;	
	return $weather_rain_current;
}

function get_rain_today()
{
	$weatherCurrentXml = get_weather_current_xml();
	$weather_rain_current = $weatherCurrentXml->current_observation->precip_today_string;	
	return $weather_rain_current;
}

function get_weather_forecast_xml()
{
	global $dbObj;
	
	$settingsQry="select * from settingsconfig where sc_id = 1";
	$settingsRes=$dbObj->fireQuery($settingsQry);
	
	$sc_sprinkler_location_city="";
	$sc_sprinkler_location_state="";
	
	if(isset($settingsRes) && count($settingsRes)>0 && $settingsRes!=false)
	{ 
		$sc_sprinkler_location_city=get_data($settingsRes[0]['sc_sprinkler_location_city']); 
		$sc_sprinkler_location_state=get_data($settingsRes[0]['sc_sprinkler_location_state']); 
	}
	
	//$weather_api_url = "http://api.openweathermap.org/data/2.5/weather?q=".$sprinkler_location."&mode=xml&type=accurate&units=imperial";
	//echo $weather_api_url; echo "<br/>";
	
	$weather_api_key = "5032bb1d11b26cbf";
	$weather_api_url = "http://api.wunderground.com/api/".$weather_api_key."/hourly/q/".$sc_sprinkler_location_state."/".$sc_sprinkler_location_city.".xml";
	
	//$weather_api_url = WEBSITE_URL."/weather_samples/Richardson_Hourly.xml";
	
	$xml = @simplexml_load_file($weather_api_url) or log_activity("url not loading : ".$weather_api_url);
	
	if(isset($xml) && ($xml!==FALSE))
	{
		return $xml;
	}
	else
	{
		return false;
	}
}


function get_weather_current_xml()
{
	global $dbObj;
	
	$settingsQry="select * from settingsconfig where sc_id = 1";
	$settingsRes=$dbObj->fireQuery($settingsQry);
	
	$sc_sprinkler_location_city="";
	$sc_sprinkler_location_state="";
	
	if(isset($settingsRes) && count($settingsRes)>0 && $settingsRes!=false)
	{ 
		$sc_sprinkler_location_city=get_data($settingsRes[0]['sc_sprinkler_location_city']); 
		$sc_sprinkler_location_state=get_data($settingsRes[0]['sc_sprinkler_location_state']); 
	}
	
	//$weather_api_url = "http://api.openweathermap.org/data/2.5/weather?q=".$sprinkler_location."&mode=xml&type=accurate&units=imperial";
	//echo $weather_api_url; echo "<br/>";
	
	$weather_api_key = "5032bb1d11b26cbf";
	$weather_api_url = "http://api.wunderground.com/api/".$weather_api_key."/conditions/q/".$sc_sprinkler_location_state."/".$sc_sprinkler_location_city.".xml";
	
	//$weather_api_url = WEBSITE_URL."/weather_samples/Richardson_Conditions.xml";
	
	$xml = @simplexml_load_file($weather_api_url) or log_activity("url not loading : ".$weather_api_url);
	
	if(isset($xml) && ($xml!==FALSE))
	{
		return $xml;
	}
	else
	{
		return false;
	}
}


function get_sprinkler_location()
{
	global $dbObj;
	
	$settingsQry="select * from settingsconfig where sc_id = 1";
	$settingsRes=$dbObj->fireQuery($settingsQry);
	
	$sprinkler_location="";
	if(isset($settingsRes) && count($settingsRes)>0 && $settingsRes!=false)
	{ 
	$sprinkler_location=get_data($settingsRes[0]['sc_sprinkler_location_city']).", ".get_data($settingsRes[0]['sc_sprinkler_location_state']); 
	}
	
	return $sprinkler_location;
}

function get_sprinkler_mode()
{
	global $dbObj;
	
	$settingsQry="select * from settingsconfig where sc_id = 1";
	$settingsRes=$dbObj->fireQuery($settingsQry);
	
	$sprinkler_mode="";
	if(isset($settingsRes) && count($settingsRes)>0 && $settingsRes!=false)
	{ 
	$sprinkler_mode=get_data($settingsRes[0]['sc_sprinkler_mode']); 
	}
	
	return $sprinkler_mode;
}

function cleanData($value)
{
	$value = str_replace('"','',$value);
	return trim(mysql_real_escape_string($value));
}

function cleanData2($value)
{	
	$value = convert_smart_quotes($value);
	$value = preg_replace('/[^(\x20-\x7F)]*/','', $value);
	return trim(mysql_real_escape_string($value));
}

function custom_date_diff_days($date_start,$date_end)
{
	$date_diff = $date_end-$date_start;
	$date_diff_days = floor($date_diff/86400);
	return $date_diff_days;
}

function get_global_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
 
    return $ipaddress;
}

function curl_get_file_contents($URL)
{
	$c = curl_init();
	//curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($c, CURLOPT_URL, $URL);
	$contents = curl_exec($c);
	curl_close($c);
	
	if ($contents) return $contents;
	else return FALSE;
}

?>