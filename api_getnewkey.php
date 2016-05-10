<?php
	// NON-INTERACTIVE DASHBOARD - api_getnewaccount.php
	// Tim Daish, NCC Group Web Performance
	//
	// Get a new API Key for the authorised user
	//
    // Release: v1.1 April 2016
    //

	// set header type to xml
	header('Content-Type: application/xml');
	
	// set date timezone to UTC	
	date_default_timezone_set('UTC'); 
    
    $serverName = 'http://'.$_SERVER['SERVER_NAME'];
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $windows = defined('PHP_WINDOWS_VERSION_MAJOR');
        //echo 'This is a server using Windows! '. $windows."<br/>";
        $OS = "Windows";
    }
    else {
        //echo 'This is a server not using Windows!'."<br/>";
        $OS = PHP_OS;
    }
    $filedate=date('Y-m-d');
    // Log errors to specified file.
    if($OS == "Windows")
        $debuglog = "c://temp//niddebuglog_" .$filedate . ".txt";
    else
        $debuglog = "nidlogs/niddebuglog_".$filedate;
    file_put_contents($debuglog, "Non-Interactive Dashboard Debug Log - getnewkey.php", FILE_APPEND);
    ini_set("log_errors", 1);
    ini_set("error_log", $debuglog);



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
	
    // session has already started
    	session_start();	

    // set vars from session vars
    $keytime = $_SESSION['keytime'];
    $keylastusedtime = $_SESSION['keylastusedtime'];
    if ($_SESSION['keyisvalid'] != "1" || $_SESSION['apikey'] == "" )
        $keyisvalid = false;
    else
        $keyisvalid = true;

    $username = $_SESSION['LoginSessionVar'];
    $password = $_SESSION['PasswordSessionVar'];

error_log($username.".");                
error_log("Requesting new API key");
    $apikey = $_SESSION['apikey'];
error_log("Old API Key: " . $apikey);

       
    $dt_keytime = new DateTime($keytime);
    $dt_keylastusedtime = new DateTime($keylastusedtime);
	
	
	
	GetDateTime();
    // force key to renew
	$keyisvalid == 0;

	// get a new API key if it has to be renewed
	if ($keyisvalid == 0 OR $keytimeisvalid == false OR $apikey=="" ) {  //
		LookupAPIKey();
	}

	// save session var as API key remains valid
	$_SESSION['keyisvalid'] = $keyisvalid;
	
	//  use a valid API key to request data
	if ($keyisvalid == 1)
	{
		RequestAPIData();
	}
	else
	{
        error_log("api key error - key is not valid"); 
	}

	
	// FUNCTIONS
	
	// function to get today's date and time
	function GetDateTime()
	{	
		global $today, $time5minsago,$time5minsfuture ;

		// set up request data vars
		$today = date("Y-m-d");
		$timestamp = strftime("%Y-%m-%d %H:%M:%S %Y");
	
	} // end function GetDateTime

	
	// function to lookup an API key for the authorised user
	function LookupAPIKey()
	{
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
		
		
		//create CURL connection
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
			
		// decode JSON response to string
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
        
error_log("New API Key: " . $apikey);
		
	} // end function LookupAPIKey
	

?>