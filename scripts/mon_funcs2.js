/* mon_funcs2.js
//
// Release: v2.0 July 2013
//
// Author: Tim Daish BA(Hons) MBCS CTAL-TM
//         Technical Consultant, NCC Group Web Performance
//
// Function Library for demo pages for API and Error Feeds in XML formats
//
*/

//
// COMMON FUNCTIONS
//


// function to update the clock every second
function updateClock() {
	var currentTime = new Date();
	var currentHours = currentTime.getHours();
	var currentMinutes = currentTime.getMinutes();
	var currentSeconds = currentTime.getSeconds();
	currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
	currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;
	var timeOfDay = (currentHours < 12) ? "AM" : "PM";
	currentHours = (currentHours == 0) ? 12 : currentHours;
	var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
	$('#jq4uclock').html(currentTimeString);
} // end function updateClock

// function to toggle Results By Exception display
function setRBE()
{
	RBEstatus = document.getElementById('rbe').checked;
	//alert ("filter status:" + status);
	if (RBEstatus==true)
	{

		 alert ("RBE filter will be applied at next refresh");
		
		//alert ("filter on");
	}
	else
	{

		 //document.getElementById("rbe").checked=false;
		
		alert ("RBE filter will be removed at next refresh");
	}
} // end function setRBE


// function to break a number down to the whole and decimal parts
function BreakNumber(num)
{
	return (FormattedNumberWhole(num) + "." + FormattedNumberDecimal(num));
} // end function BreakNumber

// function to break a number down and return the whole part
function FormattedNumberWhole(numw)
{ 
	digits =  parseInt(numw,10).toFixed();
	if (digits > 9)
		{
			return digits;
		}
	else
		{
			return "0" + parseInt(numw,10).toFixed();
		}
} // end function FormattedNumberWhole


// function to break a number down and return the whole part
function FormattedNumberDecimal(numd)
{ 
 digits =  parseInt(numd,10).toFixed();
 if (digits > 99)
	{
		return  (parseFloat(numd).toFixed(1)).substr(3,2);
	}
else
	{
	 if (digits > 9)
		{
			return  (parseFloat(numd).toFixed(1)).substr(2,2);
		}
	 else
		{
			 return  ( parseFloat(numd).toFixed(1)).substr(1,2);
		}
	}
}  // end function FormattedNumberDecimal


// function to check if a download speed meets kpi
function CheckKPIMet(speed,kpi)
{ 
	if (kpi == 0)
	{
		return (""); 
	}

		return  (Math.round(kpi-speed));

 }  // end function CheckKPIMet


// function to initialise gauges built with SteelSeries
function initgauges()
{
	// Define some sections
	var sections = Array(steelseries.Section(0, 3, 'rgba(84, 0, 0, 0.8)'), //red
					   steelseries.Section(3, 10, 'rgba(238, 154, 0, 0.8)'), //amber
					   steelseries.Section(10, 30, 'rgba(0, 0, 255, 0.3)'));  //green
					   
	var sections_page = Array(steelseries.Section(0, 7, 'rgba(0, 255, 0, 0.3)'), //green
					   steelseries.Section(7, 20, 'rgba(238, 154, 0, 0.8)'), // amber
						steelseries.Section(20, 30, 'rgba(84, 0, 0, 0.8)')); //red
					   
	var sections_uj =  Array(steelseries.Section(0, 30, 'rgba(0, 255, 0, 0.3)'), //green
					   steelseries.Section(30, 40, 'rgba(238, 154, 0, 0.8)'), // amber
						steelseries.Section(40, 60, 'rgba(84, 0, 0, 0.8)')); //red
					   
	var sections_ws =  Array(steelseries.Section(0, 1, 'rgba(0, 255, 0, 0.3)'), //green
					   steelseries.Section(1, 3, 'rgba(238, 154, 0, 0.8)'), // amber
						steelseries.Section(3, 10, 'rgba(84, 0, 0, 0.8)')); //red					   
					   
  
	// Define some areas
	var areas = Array(steelseries.Section(10, 40, 'rgba(0, 255,0, 0.3)'));
	var area_page = Array(steelseries.Section(0, 7, 'rgba(0, 255,0, 0.3)'));
	var area_uj = Array(steelseries.Section(0, 30, 'rgba(0, 255,0, 0.3)'));
	var area_ws = Array(steelseries.Section(0, 1, 'rgba(0, 255,0, 0.3)'));
			
	// Create three radial gauges for displaying time in seconds
	gauge1_ss = new steelseries.Radial( // page avg. time
					'canvas_ss_gauge1', {
					size: 300,
					section: sections_page,                      
					area: area_page,  
					minValue: 0,
					maxValue: 30,      
					threshold: 7,                      
					titleString: 'Page Average',
					unitString: 'seconds',                     
					frameDesign: steelseries.FrameDesign.STEEL,
					backgroundColor: steelseries.BackgroundColor.LIGHT_GRAY,
					pointerType: steelseries.PointerType.TYPE8, 
					pointerColor: steelseries.ColorDef.BLUE,
					lcdColor: steelseries.LcdColor.WHITE, 
					ledColor: steelseries.LedColor.YELLOW_LED,
					lcdDecimals: 1
					});                               

	gauge2_ss = new steelseries.Radial( // user journey avg. time
					'canvas_ss_gauge2', {
					size: 300,
					section: sections_uj,                      
					area: area_uj,  
					minValue: 0,
					maxValue: 60,      
					threshold: 30,                      
					titleString: 'UJ Average',
					unitString: 'seconds',                     
					frameDesign: steelseries.FrameDesign.STEEL,
					backgroundColor: steelseries.BackgroundColor.LIGHT_GRAY,
					pointerType: steelseries.PointerType.TYPE8, 
					pointerColor: steelseries.ColorDef.BLUE,
					lcdColor: steelseries.LcdColor.WHITE, 
					ledColor: steelseries.LedColor.YELLOW_LED,
					lcdDecimals: 1
					});                               

	gauge3_ss = new steelseries.Radial( // web service avg. time
					'canvas_ss_gauge3', {
					size: 300,
					section: sections_ws,                      
					area: area_ws,  
					minValue: 0,
					maxValue: 10,      
					threshold: 2,                      
					titleString: 'WS Average',
					unitString: 'seconds',                     
					frameDesign: steelseries.FrameDesign.STEEL,
					backgroundColor: steelseries.BackgroundColor.LIGHT_GRAY,
					pointerType: steelseries.PointerType.TYPE8, 
					pointerColor: steelseries.ColorDef.BLUE,
					lcdColor: steelseries.LcdColor.WHITE, 
					ledColor: steelseries.LedColor.YELLOW_LED,
					lcdDecimals: 1
					});                               

	// Create a radial bargraph gauge
	gauge4_ss = new steelseries.RadialBargraph(
					'canvas_ss_gauge4', {
					gaugeType: steelseries.GaugeType.TYPE3,
					titleString: "Not OK",                                
					unitString: "%", 
					threshold: 7,         
					frameDesign: steelseries.FrameDesign.STEEL,
					backgroundColor: steelseries.BackgroundColor.LIGHT_GRAY,
					valueColor: steelseries.ColorDef.RED,
					lcdColor: steelseries.LcdColor.WHITE,
					ledColor: steelseries.LedColor.RED_LED,
					lcdDecimals: 1,
					digitalFont: true
					});                                   


	// Create another radial gauge
	gauge5_ss = new steelseries.RadialBargraph(
					'canvas_ss_gauge5', {
					gaugeType: steelseries.GaugeType.TYPE3,
					titleString: "Missed KPI",                                
					unitString: "%", 
					threshold: 25,         
					frameDesign: steelseries.FrameDesign.STEEL,
					backgroundColor: steelseries.BackgroundColor.LIGHT_GRAY,
					valueColor: steelseries.ColorDef.RED,
					lcdColor: steelseries.LcdColor.WHITE,
					ledColor: steelseries.LedColor.RED_LED,
					lcdDecimals: 1,
					digitalFont: true
					});                                   


	gauge6_ss = new steelseries.Linear('canvas_ss_gauge6', {
					width: 600,
					height: 100,
					frameDesign: steelseries.FrameDesign.STEEL,
					backgroundColor: steelseries.BackgroundColor.LIGHT_GRAY,
					gaugeType: steelseries.GaugeType.TYPE5,
					titleString: "Number of Open Errors",
					unitString: "",
					threshold: 0,
					minValue: 0,
					maxValue: 10, 
					lcdVisible: true,
					lcdDecimals: 0
					});
	activeled_ss = new steelseries.Led('canvas_ss_activeled', {
					width: 50,
					height: 50,
					ledColor: steelseries.LedColor.GREEN_LED
					});
	activeled_ss.blink(true);

	errorled_ss = new steelseries.Led('canvas_ss_errorled', {
					width: 120,
					height: 120,
					ledColor: steelseries.LedColor.RED_LED
					});
	errorled_ss.blink(false);

	lastobs_ss = new steelseries.DisplaySingle('canvas_ss_lastobs', {
						width: 500,
						height: 40,
						lcdColor: steelseries.LcdColor.WHITE,
						value: "",
						autoScroll: true,
						valuesNumeric: false
						});
	gauge1avg_ss = new steelseries.DisplaySingle('canvas_ss_gauge1avg', {
						width: 100,
						height: 40,
						lcdColor: steelseries.LcdColor.WHITE,
						value: "",
						autoScroll: false,
						valuesNumeric: false,
						digitalFont: true
						});
	gauge1min_ss = new steelseries.DisplaySingle('canvas_ss_gauge1min', {
						width: 100,
						height: 40,
						lcdColor: steelseries.LcdColor.WHITE,
						value: "",
						autoScroll: false,
						valuesNumeric: false,
						digitalFont: true
						});
	gauge1max_ss = new steelseries.DisplaySingle('canvas_ss_gauge1max', {
						width: 100,
						height: 40,
						lcdColor: steelseries.LcdColor.WHITE,
						value: "",
						autoScroll: false,
						valuesNumeric: false,
						digitalFont: true
						});
	gauge2avg_ss = new steelseries.DisplaySingle('canvas_ss_gauge2avg', {
						width: 100,
						height: 40,
						lcdColor: steelseries.LcdColor.WHITE,
						value: "",
						autoScroll: false,
						valuesNumeric: false,
						digitalFont: true
						});
	gauge2min_ss = new steelseries.DisplaySingle('canvas_ss_gauge2min', {
						width: 100,
						height: 40,
						lcdColor: steelseries.LcdColor.WHITE,
						value: "",
						autoScroll: false,
						valuesNumeric: false,
						digitalFont: true
						});
	gauge2max_ss = new steelseries.DisplaySingle('canvas_ss_gauge2max', {
						width: 100,
						height: 40,
						lcdColor: steelseries.LcdColor.WHITE,
						value: "",
						autoScroll: false,
						valuesNumeric: false,
						digitalFont: true
						});


}  // end function initgauges


//
// API DATA FUNCTIONS
//


// function to read the result code labels
function readRClabels() {
	// console.log ("reading resultcode xml" );

	$.ajax({
		type: "GET",
		url: "ResultCodes.xml",
		dataType: "xml",
		success: parseRCXml,
		error: function (xhr, ajaxOptions, thrownError)
			{
				console.log ("xml rc error");
			}
	});

} // end function readRClabel

// function to load the result codes into an array
function parseRCXml(xml) {
	
	var RCid = "";
	var RCsev = "";
	var RCdesc = "";
	$(xml).find("code").each(function() {
		
		$(this).find("id").each(function(){
			RCid = $(this).text();
		});
		$(this).find("severity").each(function(){
			RCsev = $(this).text();
		});
		$(this).find("description").each(function(){
			RCdesc = $(this).text();
		});

		aResultCodes[Number(RCid)] = RCdesc;
		//console.log(RCid + ": " + RCsev + " " + RCdesc);
	});
	
	// override code 0 so "Test in Progress" text is not shown
	aResultCodes[0] = "";
	// override code 1 so "Site OK" text is not shown - remove if wanted 
	aResultCodes[1] = "";
} // end function readRClabel

// functioon to parse the returned XML data
function parseXml(xml) {

	// global variables
	// reset the counts for each test result severity
	countOK = 0;
	countProblem = 0;
	countWarning = 0;
	countDown = 0;

	// declare local variables
	var tag = "";
	var tag_a = "";
	var aMonitorTimes = new Array();
	aMonitorTimes[0] = new Array(3); // page times, min avg max
	aMonitorTimes[1] = new Array(3); // uj times, min avg max
	aMonitorTimes[2] = new Array(3); // ws times, min avg max
	var iMonTimeTotal = 0;
	var iMonTimeAvg = 0;
	var iMonTimeMin = 0;
	var iMonTimeMax = 0
	var iMonTypeCount = 0;
	var iPctOkMonitors = 0;
	var iMonKPIMet = 0;
	var iMonKPIMissed = 0;
	var iPctKPIMissed = 0;
	var sRC = "";
	var iRC = "";

	var now = new Date();
	
	obstext = "Last poll time:" + now;
	// empty the table contents ready for the updated ones
	$("#table#table tbody").empty();
	
	//console.log ("checking Response" );
	//console.log (xml);
	
	// set poll led to red
	activeled_ss.setLedColor(steelseries.LedColor.RED_LED);
	$(xml).find("Response").each(function() {
			var responseStatus = $(this).attr('Status');
			var responseCode = $(this).attr('Code');
			var responseMessage = $(this).attr('Message');
			
			//console.log ("Response: " + responseStatus+" "+responseCode+" "+responseMessage);
			// set poll led to green if all is ok
			if (responseStatus =="Ok")
			{
				activeled_ss.blink(true);
				activeled_ss.setLedColor(steelseries.LedColor.GREEN_LED);
				obstext = obstext + "; Polling every 5 minutes";
			}
			else
			{
				obstext = obstext + "; Polling stopped - no connection to NCC Group API";	
			}
			
	});
	
	lastobs_ss.setValue(obstext);
	
	// reset vars for all monitors
	iMonKPIMet = 0;
	iMonKPIMissed = 0;		
	// loop for each type of monitor to be reported upon
	for (var i=1;i<=3;i++)
	{ 
		// set the tag to the type of monitor being read
		switch (i)
		{
			case 1:
				tag = "Page";
				tag_a = "pg";
				break;
			case 2:
				tag = "UserJourney";
				tag_a = "uj"
				break;
			case 3:
				tag = "WebService";
				tag_a = "ws";
				break;
		}  // end switch
		//console.log ("getting " + tag + " monitors");
		
		// reset vars for this monitor type
		iMonTimeTotal = 0;
		iMonTimeAvg = 0;
		iMonTimeMin = 10000;
		iMonTimeMax = 0;
		iMonTypeCount = 0;
		iMonTypeCount = 0;
		
		// GET EACH MONITOR BY TYPE
		$(xml).find(tag).each(function() {
				//find each instance of the switched monitor type in xml file
				var label = $(this).attr('Label');
				//if blank, hide row
				if (label == "") {
				  $("table#table tbody tr").hide();
				} else
				{
					//else add tr and td tags and the colour class for status

					sSpeed = $(this).attr('LastTestDownloadSpeed');
					sLTDSW = FormattedNumberWhole($(this).attr('LastTestDownloadSpeed'));
					sLTDSD = FormattedNumberDecimal($(this).attr('LastTestDownloadSpeed'));
														
					tst_status = $(this).attr('CurrentStatus');
					//console.log('status = ' + tst_status);
					switch (tst_status)
						{					
							case 'OK':
							sRowColor = 'green';
							sFontSize = "big";
							sImage = "mon_ok.png";
							iRC = $(this).attr('ResultCode');
							sRC = "";
							countOK = countOK + 1;
							break;
							
							case 'Warning':
							sRowColor = 'amber';
							sFontSize = "big";
							sImage = "mon_warning.png";
							iRC = $(this).attr('ResultCode');
							sRC = iRC + ": ";
							countWarning = countWarning + 1;
							break;
							
							case 'Problem':
							sRowColor = 'red';
							sFontSize = "big";
							sImage = "mon_problem.png";
							iRC = $(this).attr('ResultCode');
							sRC= iRC + ": ";
							countProblem = countProblem + 1;
							break;
							
							case 'Down':
							sRowColor = 'black';
							sFontSize = "big";
							sImage = "mon_down.png";
							iRC = $(this).attr('ResultCode');
							sRC = iRC + ": ";
							countDown = countDown + 1;
							break;
							
							default:
							sRowColor = 'amber';
						} // end switch
			
						// add this monitor's time to total and increment the monitor count
						iMonTimeTotal = Number(iMonTimeTotal) + Number($(this).attr('LastTestDownloadSpeed'));
						iMonTypeCount = Number(iMonTypeCount) + 1;
						
						// update min and max times for this monitor type
						if (Number($(this).attr('LastTestDownloadSpeed')) < Number(iMonTimeMin))
							iMonTimeMin = Number($(this).attr('LastTestDownloadSpeed'));
						if (Number($(this).attr('LastTestDownloadSpeed')) > Number(iMonTimeMax))
							iMonTimeMax = Number($(this).attr('LastTestDownloadSpeed'));
					
						// check this monitor's latest download time against kpi
						sSpeedKpi = $(this).attr('SpeedKpi');
						if (sSpeedKpi > 0)
						{
							kpi_diff = CheckKPIMet(sSpeed,sSpeedKpi);
							if (kpi_diff >= 0)
							{
								iMonKPIMet = Number(iMonKPIMet) + 1;
								sKpi = "<img src=\"images/plus.png\" width=\"32\" height=\"32\" title=\"KPI met\" alt=\"KPI met\" />" + String(Math.abs(kpi_diff) + " s");
								//console.log($(this).attr('Label') + " speed = " + sSpeed + " ; kpi = " + sSpeedKpi + "; kpi missed = " + kpi_diff);
							}
							else
							{
								iMonKPIMissed = Number(iMonKPIMissed) + 1;
								sKpi = "<img src=\"images/minus.png\" width=\"32\" height=\"32\" title=\"KPI met\" alt=\"KPI missed\" />" + String(Math.abs(kpi_diff)) + " s";
								//console.log($(this).attr('Label') + " speed = " + sSpeed + " ; kpi = " + sSpeedKpi + "; kpi missed = " + kpi_diff);
							}
						}
						else
						{
							sKpi = "";
							//console.log($(this).attr('Label') + " speed = " + sSpeed + " ; kpi = " + sSpeedKpi);
						}
	
						// create table row and append						
						sRow = "<tr class=\"" + sRowColor + "\">"
						 + "<td width=\"40%\"class=\"" + sFontSize + " left\">" + " <span class=\"right\"><img src=\"images/mon_" + tag_a + "64.png\" width=\"64\" height=\"64\" title=\"" + tag + "\" /></span>" + $(this).attr('Label') + "</td>"
						 + "<td width=\"15%\" class=\"" + sFontSize + " left\"> <img src=\"images/" + sImage + "\" width=\"64\" height=\"64\" title=\"" + tst_status + "\" />"  + $(this).attr('CurrentStatus') + "</td>"
						 + "<td  width=\"25%\"class=\"" + "med" + " right\"> " + sRC + aResultCodes[Number(iRC)] + "</td>" //sRC = result code + colon , aResultCodes[Number(sRC) = description
						 + "<td class=\"right\"><span class=\"big\">" + sLTDSW + "</span>" + "<span class=\"med\">" + sLTDSD + " s</span></td>"
						 + "<td class=\"" + "" + "\">" + $(this).attr('LastTestLocalDateTime') + "</td>"
						 + "<td class=\"" + "" + "\" right>" + sKpi + "</td>"
						 + "</tr>";
						
						if (RBEstatus==false || ( RBEstatus==true && tst_status !="OK" ) )
						{
							$("table#table tbody").append(sRow);
						}			
				} // else

			 }); // end for each monitor type tag


		// calc avg. for monitor type
		//console.log ("calculating average time for monitor type: " + tag + "; total time: " + iMonTimeTotal + "; count: " + iMonTypeCount);
		iMonTimeAvg = (iMonTimeTotal / iMonTypeCount).toFixed(3);
		
		// save monitor counts away, using the loop counter -1 to vary the array pointer
		aMonitorTimes[i-1][0] = iMonTimeMin; // page times, min
		aMonitorTimes[i-1][1] = iMonTimeAvg; // page times, avg
		aMonitorTimes[i-1][2] = iMonTimeMax; // page times, max
		//console.log (tag + ": Min: " + iMonTimeMin + ": Avg: " + iMonTimeAvg + ": Max: " + iMonTimeMax);
	} // end for each monitor type
		 
	// Calulate and update summary and statistics
	// update summary of severity counts
	document.getElementById('cntok').innerHTML = "OK: " + countOK.toString();
	document.getElementById('cntwn').innerHTML = "Warning: " + countWarning.toString();
	document.getElementById('cntpr').innerHTML = "Problem: " + countProblem.toString();
	document.getElementById('cntdn').innerHTML = "Down: " + countDown.toString();
	 
	// update page severity totals
	iNoofMonitorsInError = countProblem + countDown;
	sNoofMonitorsInError = iNoofMonitorsInError.toString();

	// update calculated min, avg & max times for each types of monitor
	// added from array - first dimension 0 = page, 1 = user jounrney, 2 = web service (not shown)
	//                    second dimension 0 = min, 1 = avg, 2 = max
	gauge1min_ss.setValue(aMonitorTimes[0][0]);
	gauge1avg_ss.setValue(aMonitorTimes[0][1]);
	gauge1max_ss.setValue(aMonitorTimes[0][2]);
	gauge2min_ss.setValue(aMonitorTimes[1][0]);
	gauge2avg_ss.setValue(aMonitorTimes[1][1]);
	gauge2max_ss.setValue(aMonitorTimes[1][2]);
	
	// calculate percentage of monitors with issues
	iPctOkMonitors = 100 - countOK/(countOK+ countWarning +countProblem+countDown) * 100;
	iPctKPIMissed = (iMonKPIMissed / (iMonKPIMissed + iMonKPIMet)) * 100;
	//console.log ("missed: " + String(iMonKPIMissed) + " met: " + String(iMonKPIMet));
	
	// update steelseries gauge values
	gauge1_ss.setValue(aMonitorTimes[0][1]);  // page average time in seconds
	gauge2_ss.setValue(aMonitorTimes[1][1]); // uj average time in seconds
	gauge3_ss.setValue(aMonitorTimes[2][1]); // we average time in seconds
	gauge4_ss.setValueAnimated(iPctOkMonitors);
	gauge5_ss.setValueAnimated(iPctKPIMissed);
	gauge6_ss.setValue(iNoofMonitorsInError);
	

	// set the flashing status of the error led if any of the monitors are in error
	if ( iNoofMonitorsInError > 0) 
	{
		//turn led on and flash
		errorled_ss.blink(true);
		errorled_ss.setLedColor(steelseries.LedColor.RED_LED);
		errorled_ss.repaint;
	}
	else
	{
		// turn led off and stop flashing
		errorled_ss.blink(false);
		//errorled_ss.setLedColor(steelseries.LedColor.RED_LED); // reset
		errorled_ss.resetLed;
		errorled_ss.repaint;
	}
	 
		 
} // end function parseXml


//
// RSS ERROR FEED FUNCTIONS
//

// Our callback function, for when a feed is loaded.
function feedLoaded(result) {
	var d=new Date();
	var n=d.toLocaleTimeString();
	//console.log("feed loaded --> reading xml @ " + n);
	
	
	// clear down table
	$("#table#table tbody").empty();
			
	if (!result.error) 
	{
		// Get and clear our content div.
		var content = document.getElementById('content');
		content.innerHTML = '';
	
	   // Loop through our items
		var channel = $('channel', result).eq(0);
		var items = [];		
		$('item', result).each( function()
		{
			var item = {};
		
			item.title = $(this).find('title').eq(0).text();
			item.link = $(this).find('link').eq(0).text();
			item.description = $(this).find('description').eq(0).text();
			item.updated = $(this).find('pubDate').eq(0).text();
			item.id = $(this).find('guid').eq(0).text();
			items.push(item);
	
		 });  // end each loop to populate items array
	
		// items array holds all details
		//console.dir(items);
	
		var iErrorCountOpen = 0;
		var iErrorCountClosed = 0;
	
		// loop through the array to look for each item
		$('item', result).each( function()
		{
			var item = {};
			
			// break XML RSS item down by attribute
			item.title = $(this).find('title').eq(0).text();
			item.link = $(this).find('link').eq(0).text();
			item.description = $(this).find('description').eq(0).text();
			item.updated = $(this).find('pubDate').eq(0).text();
			item.id = $(this).find('guid').eq(0).text();
			
			var str=item.title;
			var n=str.search("Open:");
			
			// check if the error is denoted as being open
			if (n > 0)
			{
				// open error found
				iErrorCountOpen = iErrorCountOpen + 1;
			
				// title
				// break title down
				var itemerrno = item.title.substring(0,n-1);
				
				// extract name of site and the title
				var f=str.search(" for ");
				var itemerrsite = item.title.substring(f+4);
				var itemerrtitle = item.title.substring(n+6,f);
				
				// break description down and extract the error code
				var rc1=item.description.indexOf("result code") - 1;
				var desc_s = item.description.substring(rc1);
				var rc2= desc_s.indexOf(".");
				var itemrc = desc_s.substring(12,rc2-1); // remove brackets
			   
				//console.log("desc = " + item.description);
				//console.log("desc_s = " + desc_s);
				//console.log("rc1 = " + rc1);
				//console.log("rc2 = " + rc2);
				//console.log("rc = " + itemrc);

				// prep variables
				sRowColor = "open";
				sFontSize = "med";
		
				var errorduration = "";
				var errortimeopen= item.updated;
				var errortimeclosed = "";
				var itemstatus = "Open";
				var errorisclosed = new Boolean();
				
				//console.log ("item:" + i);
				//console.log (items[i]);
				
				// look for a corresponding close error item for an open error item
				for (var j=0;j<items.length; j++) 
				{
					// get error title
					errtitle = (items[j].title);
					
					// compare the open error number against that of the closed error
					//console.log("checking: " + errtitle);
					var p = errtitle.indexOf(itemerrno)
					if (p == 0)
					{
						// error numbers match - a close error item has been found for the open error
						//console.log("record match found for: " + itemerrno);
						if ( errtitle.indexOf("Closed") > 0)
						{
							errorisclosed = true;
							//console.log("CLOSED match found for: " + itemerrno);
							iErrorCountClosed = iErrorCountClosed + 1;
							break;
						}
					}  // end if this is a closed error item
					
				}  // end for loop looking for a closed record
				
				// declare variables to calculate error duration 
				var sDates = "";
				var sDtOpen = ""
				var sDtClosed = ""
				var dt_Open = new Date();
				var dt_Closed = new Date();
				
				// adjust errortimeopen values for localtime - expressed in Feed as GMT						
				dt_Open = Date.parse(errortimeopen) + currentTimeZoneOffsetInHours;
				var sDtOpen = dateFormat(dt_Open, "isoDateTime");
				sDates = sDtOpen;
				
				// save the latest error open date away for use later if it's later than the one held
				if (dt_Open > dt_LastOpen)
				{
					dt_LastOpen = dt_Open;
					//console.log (" new error last open datetime set: " + dt_LastOpen);
					//console.log ("dt_LastOpen: " + dt_LastOpen + "; dt_Open: " + dt_Open );
				}
				//console.log ("dt_LastOpen: " + dt_LastOpen + "; dt_Open: " + dt_Open );	
				
				// append the error row to the table, different colours and info. for closed and open errors
				if (errorisclosed == true)
				{
					// display a closed error
					sRowColor = "closed";
					itemstatus = "Closed";
					errorduration = "tbc";
					
					// calculate time different betweeb error open time and error close time
					errortimeclosed = (items[j].updated);
					// adjust errortimeclosed values for localtime - expressed in Feed as GMT

					dt_Closed = Date.parse(errortimeclosed) + currentTimeZoneOffsetInHours;
					errorduration = Math.abs(dt_Closed - dt_Open); // difference
					sDtClosed = dateFormat(dt_Closed, "isoDateTime");
					
					var diff=dt_Closed-dt_Open,sign=diff<0?-1:1,milliseconds,seconds,minutes,hours,days;
					diff/=sign; // or diff=Math.abs(diff);
					diff=(diff-(milliseconds=diff%1000))/1000;
					diff=(diff-(seconds=diff%60))/60;
					diff=(diff-(minutes=diff%60))/60;
					days=(diff-(hours=diff%24))/24;

					//console.info(sign===1?"Elapsed: ":"Remains: ",
					//			 days+" days, ",
					//			 hours+" hours, ",
					//			 minutes+" minutes, ",
					//			 seconds+" seconds, ",
					//			 milliseconds+" milliseconds.");
					
					var sDays = " day ";
					if (days == 0)
					{
						//errorduration = hours+" hrs, " + minutes+" mins, " + seconds+" secs";								
						errorduration = hours +"h " + minutes+"m " + seconds+"s";	
					}
					else
					{
						//errorduration = days+sDays + hours+" hrs, " + minutes+" mins, " + seconds+" secs";								
						errorduration = days+ "d " + hours+"h " + minutes+"m " + seconds+ "s";	
					}
					
					sDates = sDates + "<br>" + sDtClosed;							
				}
				else
				{
					// display an open error
					
					// calculate how long the error has been open
					var dt_now = new Date();
					var diff=dt_now-dt_Open,sign=diff<0?-1:1,milliseconds,seconds,minutes,hours,days;
					diff/=sign; // or diff=Math.abs(diff);
					diff=(diff-(milliseconds=diff%1000))/1000;
					diff=(diff-(seconds=diff%60))/60;
					diff=(diff-(minutes=diff%60))/60;
					days=(diff-(hours=diff%24))/24;
				
					var sDays = "d ";
					if (days == 0)
					{
						//errorduration = hours+" hrs, " + minutes+" mins, " + seconds+" secs";								
						errorduration = hours +"h " + minutes+"m " + seconds + "s";	
					}
					else
					{
						//errorduration = days+sDays + hours+" hrs, " + minutes+" mins, " + seconds+" secs";								
						errorduration = days+"d " + hours+"h " + minutes+"m " + seconds + "s";	
					}
					
					sDates = sDates;	
				
				}  // if error is closed or still open
		
				//console.log("matching upon: " + itemerrno + " = " + errorisclosed);	 
				if ((iErrorCountOpen - iErrorCountClosed > 0 && RBEstatus == true) || (RBEstatus == false))
				{
					// write out the table row
					var sRow = "<tr class=\"" + sRowColor + "\">"
					 + "<td width=\"8%\"class=\"" + sFontSize + " left\">" + itemerrno + "</td>"
					 + "<td width=\"30%\"class=\"" + sFontSize + " left\">" + itemerrsite + "</td>"
					 + "<td class=\"" + sFontSize + " right\">" + itemerrtitle + "</td>"
					 + "<td class=\"" + sFontSize + " right\"> " + itemrc + "</td>"
					 + "<td class=\"" + "" + "\">" + sDates + "</td>"
					 + "<td class=\"" + "" + "\" right>" + itemstatus + "</td>"
					 + "<td class=\"" + "" + "\" right>" + errorduration + "</td>"
					 + "</tr>";
		
					if (RBEstatus == false || (RBEstatus == true && itemstatus != "Closed"))
					{
						$("table#table tbody").append(sRow);	
					}					
				
				}
				else
				{

				}
			}  // end if an open error is found
	
		 });  // end loop
		
		// check if there no open errors; if none, display "no errors" information
		//console.log("open" + iErrorCountOpen + " - closed: " + iErrorCountClosed);
		if (iErrorCountOpen - iErrorCountClosed == 0)
		{
			sRowColor = "noerrors";
			var sRow = "<tr class=\"" + sRowColor + "\">"
			 + "<td width=\"100%\"class=\"" + sFontSize + " center\">"  + "No Recent Open Errors" + "</td>"
			 + "</tr>";
			if (RBEstatus == true )
			{
				$("table#table tbody").append(sRow);	
			}
		
			// calculate time since last error was raised
			var dt_now = new Date();
			var diff=dt_now-dt_LastOpen,sign=diff<0?-1:1,milliseconds,seconds,minutes,hours,days;
			diff/=sign; // or diff=Math.abs(diff);
			diff=(diff-(milliseconds=diff%1000))/1000;
			diff=(diff-(seconds=diff%60))/60;
			diff=(diff-(minutes=diff%60))/60;
			days=(diff-(hours=diff%24))/24;
		
			var sDays = " day ";
			if (days == 0)
			{
				//errorduration = hours+" hrs, " + minutes+" mins, " + seconds+" secs";								
				errorduration = hours +"h " + minutes+"m";	
			}
			else
			{
				if (days > 1)
				{
				sDays = " days "
				}
				//errorduration = days+sDays + hours+" hrs, " + minutes+" mins, " + seconds+" secs";								
				errorduration = days+ "d " + hours+"h " + minutes+"m";	
			}
			sRow = "<tr class=\"" + "" + "\">"
			 + "<td width=\"100%\"class=\"" + sFontSize + " center\">"  + "time since last error: " + errorduration + "</td>"
			 + "</tr>";
			if (RBEstatus == true )
			{
				$("table#table tbody").append(sRow);	
			}
		
		}  // end if no open errors
		
	
	} // end if result
	else
	{
		  console.log("xml load error");
	}
	
} // end function feedLoaded