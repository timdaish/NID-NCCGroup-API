<?php
	// NON-INTERACTIVE DASHBOARD - api_getxml.php
	// Tim Daish, NCC Group Web Performance
	//
	// Get the requested test data from the API for the selected accounts using the API Key
	//
	
	// reference the serial class if external serial communication is required
    require("php_serial.class2.php");
	
	// start a PHP session and set username and password session vars
	session_start();

	// set timeout	for PHP requests
	ini_set('max_execution_time', 60); //60 seconds = 1 minutes

	// set header type to xml
	header('Content-Type: application/xml');

	// set date timezone to UTC	
	date_default_timezone_set('UTC'); 
	
	// declare global variables
	$today = "";
	$time5minsago = "";
	$time5minsfuture = "";
	$keyisvalid = false;
	$keytimeisvalid = false;

	// set session variables
	$keytime = null;
	$keylastusedtime = null;
	$apikey = null;
	
	// check if session has already started
	if (!isset($_SESSION['keytime'])) {
		// new session
		$_SESSION['keytime'] = null;
		$_SESSION['keylastusedtime'] = null;
		$_SESSION['keyisvalid'] = "";
		$_SESSION['apikey'] = "";
		$keyisvalid = 0;

		$dt_keytime = new DateTime();
		$dt_keylastusedtime = new DateTime();
		
	} else
	{
    	// session has already started

		$keytime = $_SESSION['keytime'];
		$keylastusedtime = $_SESSION['keylastusedtime'];
		if ($_SESSION['keyisvalid'] != "1" || $_SESSION['apikey'] == "" )
			$keyisvalid = false;
		else
			$keyisvalid = true;
					
		$apikey = $_SESSION['apikey'];
	
		$username = $_SESSION['LoginSessionVar'];
		$password = $_SESSION['PasswordSessionVar'];
		$account = $_SESSION['AccountSessionVar'];
		$monitors = $_SESSION['MonitorsSessionVar'];
        $serport = $_SESSION['SerialPort'];

		if($monitors !="")
		{
			$monitors = "/Id/".$monitors."/";
		}
		else
		{
		$account = $account."/";
		}
		
		$dt_keytime = new DateTime($keytime);
		$dt_keylastusedtime = new DateTime($keylastusedtime);
	};
	
	GetDateTime();
	CheckIfKeyHasExpired();

	// get a new API key if it has to be renewed
	if ($keyisvalid == 0 OR $keytimeisvalid == false OR $apikey=="" ) {  //
		LookupAPIKey();
	}

	// save sesision var as API key remains valid
	$_SESSION['keyisvalid'] = $keyisvalid;
	
	//echo "key time : " . date_format($dt_keytime, 'Y-m-d H:i:s')."<br/>";
	//echo "last used: " . date_format($dt_keylastusedtime, 'Y-m-d H:i:s')."<br/>";
	//echo "api key: " . $apikey."<br/>";

	//  use a valid API key to request data
	if ($keyisvalid == 1)
	{
		RequestAPIData();
	}
	else
	{
		echo	"API key error";
	}
	
	
	// FUNCTIONS
	
	// function to get today's date and time
	function GetDateTime()
	{
		//echo "function GetDateTime called - setting date and time";
		global $today, $time5minsago,$time5minsfuture ;
		
		//echo "Date and time information...<br>"; 
		//echo "UTC: ".time(); 
		//echo "<br>"; 
		
		// set up request data vars
		$today = date("Y-m-d");
		$timestamp = strftime("%Y-%m-%d %H:%M:%S %Y");
		//echo "Date and time now = " . strftime("%Y-%m-%d %H:%M:%S", strtotime($timestamp))."<br/>";
		//echo '5 mins ago: '. date('Y-m-d H:i:s', strtotime('-5 minutes')) ."<br/><br/>";
		
		// calculate a 10-min time period around current time and allow for timezone difference to UTC
		$time5minsago = date('H:i:s', strtotime('+55 minutes'));
		$time5minsfuture = date('H:i:s', strtotime('+65 minutes'));
	
	} // end function GetDateTime
	
	
	// function to lookup an API key for the authorised user
	function LookupAPIKey()
	{
		//echo "function LookupAPIJey called - Retrieving current API key..."; 

		global $apikey,$keyisvalid,$keytime,$dt_keytime,$username,$password; 
	
		//create array of data to be posted
		$post_data['username'] = urlencode($username);
		$post_data['password'] = urlencode($password);
		//$post_data['Format'] = 'JSON';
		
		//traverse array and prepare data for posting (key1=value1)
		foreach ( $post_data as $key => $value)
		{
			$post_items[] = $key . '=' . $value;
		}
		
		//create the final string to be posted using implode()
		$post_string = implode ('&', $post_items);
		//echo "the data string to be posted is: " . $post_string ."<br />"; 
		
		//create cURL connection
		$curl_connection = curl_init('https://api.siteconfidence.co.uk/current/auth');
		
		//set cURL options
		curl_setopt($curl_connection, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($curl_connection, CURLOPT_POST, true);
		curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl_connection, CURLOPT_SSLVERSION,5);
		curl_setopt($curl_connection, CURLOPT_SSL_CIPHER_LIST,'SSLv3');  
		curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl_connection, CURLOPT_SSL_VERIFYHOST,  2);
		curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string);
		
		//perform CURL request
		$result = curl_exec($curl_connection);
		
		//show information regarding the request
		//print_r(curl_getinfo($curl_connection));
		//echo curl_errno($curl_connection) . '-' . curl_error($curl_connection) ."<br />";
		
		//close the connection
		curl_close($curl_connection);
		
	
		//echo "RESPONSE from API key lookup..."; 
		//var_dump(json_decode($result, true));
		// decode JSON string
		//echo "<pre>";
		//var_dump(json_decode($result, true));
		//echo "</pre><br />";
		
		// decode JSON response to sttring
		$my_array = json_decode($result, true);
		// extract the api key and save to session var
		$apikey = $my_array['Response']['ApiKey']['Value'];
		$_SESSION['apikey'] = $apikey;
		//echo "The current API Key is: " . $apikey ."<br /><br/>";
	
		// update session var values for key
		$keyisvalid = 1;
		$dt_keytime =  new DateTime( strftime("%Y-%m-%d %H:%M:%S %Y"));
		$_SESSION['keytime'] = $dt_keytime->format('Y-m-d H:i:s');
		$keytime = $dt_keytime->format('Y-m-d H:i:s');
		$_SESSION['keyisvalid'] = 1;
	
	} // end function LookupAPIKey
	
	
	// function to check if the api kay is still valid
	function CheckIfKeyHasExpired()
	{
		//echo "function CheckIfKeyHasExpired - checking for api key expiry<br/>";
		
		global $keytime,$keylastusedtime,$dt_keytime,$dt_keylastusedtime,$keyisvalid,$keytimeisvalid;
		
		// get time now
		$nowtime = new DateTime( strftime("%Y-%m-%d %H:%M:%S %Y"));
		//echo "time now : " . date_format($nowtime, 'Y-m-d H:i:s')."<br/>";
		//echo "key time : " . $dt_keytime->format('Y-m-d H:i:s')."<br/>";
		//echo "last used: " . $dt_keylastusedtime->format('Y-m-d H:i:s')."<br/>";
		//	echo "key time : " . $keytime."<br/>";
		//	echo "last used: " . $keylastusedtime."<br/>";
		
		// calc. interval between now and the time since the key was lsst used
		// allow for a 30 minute difference - if time since the key was lsst used > 30 mins, set key to invalid to force a refresh
		$interval = $dt_keylastusedtime->diff($nowtime);
		//echo " key time diff: " . $interval->format('%R%i minutes'). " = ".$interval->format('%i') ."<br/>";
		if (intval($interval->format('%i')) > 30){
			$keytimeisvalid = false;
			$_SESSION['keyisvalid'] = 0;
			//echo "keytime is invalid"."<br/>";
		}
		else
		{
			//echo "keytime is valid"."<br/>";
			$keytimeisvalid = true;
		}
		
	} // end function CheckIfKeyHasExpired
	
	
	// function to get the API data usting a valid API key
	function RequestAPIData()
	{
		//echo "function RequestAPIData called - get API data";
	
		global $today, $time5minsago,$time5minsfuture;
		global $apikey,$keylastusedtime,$dt_keylastusedtime;
		global $account, $monitors,$serport;
		// ---------------- request the data
		
		// set up the various parts of the URL
		$req_pt1 = "https://api.siteconfidence.co.uk/current/";
		$req_pt2 = $apikey;
		$req_pt3 = "/Return/[Account[AccountId,Name,Tz,TimeOffset,Pages[Page[Url,Label,Monitoring,LastTestLocalDateTime,LastTestLocalTimestamp,LastTestGmtDateTime,LastTestGmtTimestamp,LastTestDownloadSpeed,CurrentStatus,ResultCode,DownloadSpeed,SpeedKpi]],UserJourneys[UserJourney[Id,Label,Monitoring,OverallSpeedKPI,LastTestLocalDateTime,LastTestLocalTimestamp,LastTestGmtDateTime,LastTestGmtTimestamp,LastTestDownloadSpeed,CurrentStatus,ResultCode]],WebServices[WebService[Id,Label,Monitoring,OverallSpeedKPI,LastTestLocalDateTime,LastTestLocalTimestamp,LastTestGmtDateTime,LastTestGmtTimestamp,LastTestDownloadSpeed,CurrentStatus,ResultCode]]]]";
		
		$req_pt4 = "/AccountId/".$account.$monitors."StartDate/$today/EndDate/$today/LimitTestResults/1/";
		$data_url = $req_pt1.$req_pt2.$req_pt3.$req_pt4;
		//echo "REQUEST URL and data: " . $data_url ."<br />";
		
		//create CURL connection
		$curl_connection = curl_init($data_url);

		//set options
		curl_setopt($curl_connection, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($curl_connection, CURLOPT_POST, false);
		curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl_connection, CURLOPT_SSLVERSION,5);
		curl_setopt($curl_connection, CURLOPT_SSL_CIPHER_LIST,'SSLv3'); 
		curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl_connection, CURLOPT_SSL_VERIFYHOST,  2);
		curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, true);
		
		//perform cURL request
		$result = curl_exec($curl_connection);
		
		//show information regarding the request
		//print_r(curl_getinfo($curl_connection));
		//echo curl_errno($curl_connection) . '-' . curl_error($curl_connection) ."<br />";
		// check the HTTP response code
		$responsecode = curl_getinfo($curl_connection, CURLINFO_HTTP_CODE);
		
		//close the connection
		curl_close($curl_connection);
		
		//echo "<br />RESPONSE from API Data lookup..."; 
		//var_dump(json_decode($result, true));
		// decode JSON string
		//echo "<pre>";
		//var_dump(json_decode($result, true));
		//echo "</pre>";
		
		// update session vars for key used time
		$dt_keylastusedtime =  new DateTime( strftime("%Y-%m-%d %H:%M:%S %Y"));
		$_SESSION['keylastusedtime'] = $dt_keylastusedtime->format('Y-m-d H:i:s');
		$keylastusedtime = $dt_keylastusedtime->format('Y-m-d H:i:s');
		
		// return the resulting XML document to the calling function (in api_display.php)
		echo $result;


		// OPTIONAL: continue processing the XML document in PHP
		// XML Processing using SimpleXML
		$xml = simplexml_load_string($result);
		//print_r($xml);

		
		// OPTIONAL SECTION FOR SAVING TO LOCAL FILE OR DATABASE
		// file_put_contents("apidata.xml",$result);
		// Do any XML processing of the response here to save in local database
		/*
		   // save data to database, not written
		*/
		
		
		// OPTIONAL SECTION FOR SERIAL PORT COMMUNICATION TO EXTERNAL DEVICE, e.g Arduino
		// initialise status indicators for each of pages, user journeys and web services
		$pgstatusOK = false;
		$pgstatusWarn = false;
		$pgstatusProb = false;
		$pgstatusDown = false;
		$pgstatus = "O";
		$ujstatusOK = false;
		$ujstatusWarn = false;
		$ujstatusProb = false;
		$ujstatusDown = false;
		$ujstatus = "O";
        $wsstatusOK = false;
		$wsstatusWarn = false;
		$wsstatusProb = false;
		$wsstatusDown = false;
		$wsstatus = "O";
		$overallstatus = '';

		// For each account, Check the response severity for pages, user journeys and web services
		foreach ($xml->Response->Account as $account)
		{
			// pages
			if($account->Pages->count() > 0)
			{
				foreach ($account->Pages->Page as $page) {
					$url = (string)$page['Url'];
					$pgmon =(string)$page['Monitoring'];
					$pagestatus =(string)$page['CurrentStatus'];
					//print_r($url ."=" . $pgmon."<br/>");

					if($pgmon == "true")
					{
					   if( $pagestatus=="OK")
						   $pgstatusOK = true;
					   if( $pagestatus=="Warning")
						   $pgstatusWarn = true;
					   if( $pagestatus=="Problem")
						   $pgstatusProb = true;
					   if( $pagestatus=="Down")
						   $pgstatusDown = true;
					   }
				}// end for each page
				
				// set page severity
				if($pgstatusDown == true)
					$pgstatus = "D";
				else
					if($pgstatusProb == true)
						$pgstatus = "P";
					else
						if($pgstatusWarn == true)
							$pgstatus = "W";
			} // end for each page monitor

			// user journeys
			if($account->UserJourneys->count() > 0)
			{
				foreach ($account->UserJourneys->UserJourney as $uj) {
					//$url = (string)$uj['Url'];
					$ujmon =(string)$uj['Monitoring'];
					$ujstatus =(string)$uj['CurrentStatus'];
					//print_r($url ."=" . $ujmon."<br/>");

					if($ujmon == "true")
					{
					   if( $ujstatus=="OK")
						   $ujstatusOK = true;
					   if( $ujstatus=="Warning")
						   $ujstatusWarn = true;
					   if( $ujstatus=="Problem")
						   $ujstatusProb = true;
					   if( $ujstatus=="Down")
						   $ujstatusDown = true;
					   }
				}// end for each user journey
				
				// set user journey severity
				if($ujstatusDown == true)
					$ujstatus = "D";
				else
					if($ujstatusProb == true)
						$ujstatus = "P";
					else
						if($ujstatusWarn == true)
							$ujstatus = "W";

			} // end for each user journey

			// web services
			if($account->WebServices->count() > 0)
			{
				foreach ($account->WebServices->WebService as $ws) {
					//$url = (string)$uj['Url'];
					$wsmon =(string)$ws['Monitoring'];
					$wsstatus =(string)$ws['CurrentStatus'];
					//print_r($url ."=" . $ujmon."<br/>");

					if($wsmon == "true")
					{
					   if( $wsstatus=="OK")
						   $wsstatusOK = true;
					   if( $wsstatus=="Warning")
						   $wsstatusWarn = true;
					   if( $wsstatus=="Problem")
						   $wsstatusProb = true;
					   if( $wsstatus=="Down")
						   $wsstatusDown = true;
					   }
				}// end for each user journey
				
				// set web service severity
				if($wsstatusDown == true)
					$wsstatus = "D";
				else
					if($wsstatusProb == true)
						$wsstatus = "P";
					else
						if($wsstatusWarn == true)
							$wsstatus = "W";
			} // end for each web service

		 } // end for each account

		 // consolidate page, uj and webservices statuses
		 if($pgstatus == "D" or $ujstatus == "D" or $wsstatus == "D")
			$overallstatus = "D";
		 else
			if($pgstatus == "P" or $ujstatus == "P" or $wsstatus == "P")
				$overallstatus = "P";
			else
				if($pgstatus == "W" or $ujstatus == "W" or $wsstatus == "W")
					$overallstatus = "W";
				else
					$overallstatus = "O";

					
					
		// configure serial port and send the character representing the highest level of severity
		$serialport = "COM".$serport; // WINDOWS format - comment out is using LINUX
		//$serialport = "/dev/ttyS".$serport; // LINUX formatusing LINUX - comment out if using WINDOWS - UNTESTED ON LINUX
		$serial = new phpSerial();
		$serial->deviceSet($serialport);
		$serial->confParity("none");
		$serial->confCharacterLength(7);
		$serial->confStopBits(1);
		$serial->confFlowControl("none");
		$serial->confBaudRate(9600);
		$serial->deviceOpen('w+');
		sleep(1);
		$serial->sendMessage($overallstatus);
		$serial->deviceClose();
  
		
	} // end function RequestAPIData
?>