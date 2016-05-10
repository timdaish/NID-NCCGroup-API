<?php
	// NON-INTERACTIVE DASHBOARD - api_display.php
	// Tim Daish, NCC Group Web Performance
	//
    // Release: v1.1 April 2016
    //
	// Display data from NCC Group API on screen - NON-INTERACTIVE DISPLAY
	// JavaScript periodically runs to call api_getxml.php via AJAX and update display (in api_funcs.js)
	// - default update = 5mins
	//
	// Implements gauges from SteelSeries

	// check the required posted variables are provided
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
 
   if(empty($_POST['accounts']))
    {
        echo("Accounts are empty!");
        return false;
    }
    
  	// trim the posted variables and save them to variables
    $username = trim($_POST['username']);
    $password = trim($_POST['pw']);
    $monitors = trim($_POST['monitors']);
    $optAccounts = array ();
	$optAccounts = ($_POST['accounts']);
	$account = implode(",",$optAccounts);
    $serport = $_POST['sport']; // serial port for output

	// start a PHP session and set session vars
    session_start();
    $_SESSION['LoginSessionVar'] = $username;
    $_SESSION['PasswordSessionVar'] = $password;
	$_SESSION['AccountSessionVar'] = $account;
	$_SESSION['MonitorsSessionVar'] = $monitors;
    $_SESSION['SerialPort'] = $serport;
	 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Web Site Availability &amp; Performance (API demo)</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Website performance tip: load the CSS files first for better performance -->
<link href="styles/api.css" rel="stylesheet" type="text/css" />
</head>
<body onload="initgauges();">
<h1>Web Site Availability & Performance @ <span id="jq4uclock"></span></h1>
<table id="table_status">
  <!--<caption>
  Status Overview
  </caption> -->
  <tbody>
    <tr class="vm">
      <td>Polling<canvas id="canvas_ss_activeled"></canvas></td>
      <td class="green"><span id="cntok"></span></td>
      <td class="amber"><span id="cntwn"></span></td>
      <td class="red"><span id="cntpr"></span></td>
      <td class="black"><span id="cntdn"></span></td>
      <td>Error Ind.
        <canvas id="canvas_ss_errorled"></canvas></td>
    </tr>
  </tbody>
</table>
<br/>
<!-- table with id "table" is where the api monitor data will be appended - DO NOT DELETE-->
<table id="table">
  <tbody>
    <tr> </tr>
  </tbody>
</table>
<form>
  <input type="checkbox" id="rbe" name="rbe" onclick="setRBE()"/>
  Report by Exception
  <input type="checkbox" id="dis" name="dis" onclick="setDISABLED()"/>
  Show Disabled Monitors<br>
</form>
<hr/>
<!-- SteelSeries JavaScript gauges -->
<h2>Non-Interactive Dashboard</h2>
<h3>Average Download Times for all Monitors by Type</h3>
<table id="table_avgs">
 <tbody>
  <tr>
    <td width=33%><canvas id='canvas_ss_gauge1'> No canvas in your browser...sorry... </canvas></td>
    <td width=33%><canvas id='canvas_ss_gauge2'></canvas></td>
    <td width=33%><canvas id="canvas_ss_gauge3"></canvas></td>
  </tr>
 </tbody>
<table>
<h3>KPI and Errors</h3>
<table id="table_errors">
 <tbody>
  <tr>
    <td width=33%><canvas id='canvas_ss_gauge5'></canvas></td>
    <td width=33%><canvas id='canvas_ss_gauge4'></canvas></td>
    <td width=33%><canvas id="canvas_ss_gauge6"></canvas></td>
  </tr>
  </tbody>
</table>

<h3>Download Times for all Monitors by Type</h3>
<table id="table_summary">
 <tbody>
  <tr>
	<td width=10% class="left">
    </td>
    <td width=20% class="center"><span id="sp">Pages (s)</span>
    </td>
    <td width=20% class="center"><span id="sp">User Journeys (s)</span>
    </td>
  </tr>
    
  <tr>
    <td width=10% class="right">Min:
    </td>
    <td width=20% class="center">
        <canvas id="canvas_ss_gauge1min" width="120" height="50"></canvas>
    </td>
    <td width=20% class="center">
        <canvas id="canvas_ss_gauge2min" width="120" height="50"></canvas>
    </td>
  </tr>
    
  <tr>
    <td width=10% class="right">Avg:
    </td>
    <td width=20% class="center">
        <canvas id="canvas_ss_gauge1avg" width="120" height="50"></canvas>
    </td>
    <td width=20% class="center">
        <canvas id="canvas_ss_gauge2avg" width="120" height="50"></canvas>
    </td>
  </tr>
    
  <tr>
    <td width=10% class="right">Max:
    </td>
    <td width=20% class="center">
        <canvas id="canvas_ss_gauge1max" width="120" height="50"></canvas>
    </td>
    <td width=20% class="center">
        <canvas id="canvas_ss_gauge2max" width="120" height="50"></canvas>
    </td>
   </tr>
 </tbody>
</table>
<!-- SteelSeries scrolling information bar -->
<table>
 <tbody>
  <tr>
    <td><canvas id="canvas_ss_lastobs"></canvas></td>
  </tr>
 </tbody>
</table>
<!-- Website performance tip: load JavaScript files last for better performance -->
<!-- Website performance tip: externalise the JavaScript files last for better performance -->
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="../excanvas.min.js"></script><![endif]-->
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/api_funcs.js"></script>
<script type="text/javascript" src="scripts/steelseries.js"></script>
<script type="text/javascript" src="scripts/tween.js"></script>
</body>
</html>