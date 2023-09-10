<?php

if($_SERVER['SERVER_NAME']!="localhost")
{
	if($_SERVER['SERVER_NAME']=="esprinkler.1eko.com")
	{
		$SITE_MODE="LIVE";
	}
	elseif($_SERVER['SERVER_NAME']=="esprinkler.bugs3.com")
	{
		$SITE_MODE="LIVE2";
	}
	elseif($_SERVER['SERVER_NAME']=="esprinkler.iwiin.com")
	{
		$SITE_MODE="LIVE3";
	}
	elseif($_SERVER['SERVER_NAME']=="esprinkler.wink.ws")
	{
		$SITE_MODE="LIVE4";
	}	
}
else
{
//Site Mode
$SITE_MODE="LOCAL"; 	// LOCAL | DEVTEST | DEV | LIVETEST | LIVE 
//Site Mode END
}
?>