<?php
	//
	// Get the list of accounts from the API for the authorised user
	//
	
	// set header type to xml
	header('Content-Type: application/xml');
	
	// set date timezone to UTC	
	date_default_timezone_set('UTC'); 

	// check the posted parameters to ensure usename and password are set
    if(empty($_POST['username']))
    {
        echo("UserName is empty!");
        return false;
    }
     
    if(empty($_POST['pw']))
    {
        echo("Password is empty!");
        return false;
    }
	
	// copy the posted parameters to variavles
	$username = trim($_POST['username']);
    $password = trim($_POST['pw']);	
	//echo $username." ".$password;

	// start a PHP sression and set username and password session vars
	session_start();
    $_SESSION['LoginSessionVar'] = $username;
    $_SESSION['PasswordSessionVar'] = $password;	
	

	// set global variables for API key
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
    	// echo "new session<br/>";
		//echo $username." ".$password." ".$account." ".$monitors; 		
		
		// set new sessiono vars
		$_SESSION['keytime'] = null;
		$_SESSION['keylastusedtime'] = null;
		$_SESSION['keyisvalid'] = "";
		$_SESSION['apikey'] = "";
		$keyisvalid = 0;
		
		//echo "session vars: <br/>";
		//echo "key time : " . $keytime."<br/>";
		//echo "last used: " . $keylastusedtime."<br/>";
		//echo "key state : " . $keyisvalid."<br/>";
		//echo "api key : " . $apikey."<br/><br/>";
		
		$dt_keytime = new DateTime();
		$dt_keylastusedtime = new DateTime();
		
	} else
	{
    	// session has started	
		//echo "in session<br/>";

		// set vars from session vars
		$keytime = $_SESSION['keytime'];
		$keylastusedtime = $_SESSION['keylastusedtime'];
		if ($_SESSION['keyisvalid'] != "1" || $_SESSION['apikey'] == "" )
			$keyisvalid = false;
		else
			$keyisvalid = true;
					
		$apikey = $_SESSION['apikey'];
	
		$username = $_SESSION['LoginSessionVar'];
		$password = $_SESSION['PasswordSessionVar'];
		
		//echo "session vars: <br/>";
		//echo "key time : " . $keytime."<br/>";
		//echo "last used: " . $keylastusedtime."<br/>";
		//echo "key state : " . $keyisvalid."<br/>";
		//echo "api key : " . $apikey."<br/><br/>";
		
		$dt_keytime = new DateTime($keytime);
		$dt_keylastusedtime = new DateTime($keylastusedtime);
	};
	
	

	// function to get today's date and time
	function GetDateTime()
	{	
		//echo "function GetDateTime called - setting date and time";
		global $today, $time5minsago,$time5minsfuture ;
		
		//echo "Date and time information...<br>"; 
		//echo "UTC: ".time()."<br/>"; 
		
		// set up request data vars
		$today = date("Y-m-d");
		$timestamp = strftime("%Y-%m-%d %H:%M:%S %Y");
	
	} // end function GetDateTime

	
	// function to lookup an API key for the authorised user
	function LookupAPIKey()
	{
		//echo "function LookupAPIJey called - Retrieving current API key..."; 
		
		global $apikey,$keyisvalid,$keytime,$dt_keytime,$username,$password; 
	 
		//create array of data to be posted
		$post_data['username'] = urlencode($username);
		$post_data['password'] = urlencode($password); 
		$post_data['Format'] = 'JSON';
		
		//traverse array and prepare data for posting (key1=value1)
		foreach ( $post_data as $key => $value)
		{
			$post_items[] = $key . '=' . $value;
		}
		
		//create the final string to be posted using implode()
		$post_string = implode ('&', $post_items);
		
		//echo "the data string to be poseted is: " . $post_string ."<br />"; 
		
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
		
		//perform request
		$result = curl_exec($curl_connection);
		
		//show information regarding the request
		//print_r(curl_getinfo($curl_connection));
		//echo curl_errno($curl_connection) . '-' . curl_error($curl_connection) ."<br />";
		
		//close the connection
		curl_close($curl_connection);
		
		//echo "RESPONSE from API key lookup..."; 
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
		global $account, $monitors;	
		// ---------------- request the data
		
		// set up the various parts of the URL
		$req_pt1 = "https://api.siteconfidence.co.uk/current/";
		$req_pt2 = $apikey;
		$data_url = $req_pt1.$req_pt2;
		//echo "REQUEST URL and data: " . $data_url ."<br />";

		//create cURL connection
		$curl_connection = curl_init($data_url);
		
		//set cURL options
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
		
		//close the connection
		curl_close($curl_connection);
		
		//echo "<br />RESPONSE from API Data lookup..."; 
		//var_dump(json_decode($result, true));
		// decode JSON string
		//echo "<pre>";
		//var_dump(json_decode($result, true));
		//echo "</pre>";
		
	
		// nupdate session vars for key used time
		$dt_keylastusedtime =  new DateTime( strftime("%Y-%m-%d %H:%M:%S %Y"));
		$_SESSION['keylastusedtime'] = $dt_keylastusedtime->format('Y-m-d H:i:s');
		$keylastusedtime = $dt_keylastusedtime->format('Y-m-d H:i:s');
	
		echo $result;
		
	} // end function RequestAPIData



	//-----------------------------------------------------------------
	// MAIN LINE
	// 
	
	GetDateTime();
	CheckIfKeyHasExpired();

	//echo "<br/>main vars<br/>";
	//echo "key state = " .$keyisvalid."<br/>" ;
	
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

?>

