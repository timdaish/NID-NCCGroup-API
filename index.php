<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>TDSCL Dev Lab</title>
	<link href="styles/kestrel5.css" rel="stylesheet" type="text/css">
	<script src="SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
	<script type="text/javascript">
		function alertku(){
		 if(alertku.opt){
		  document.getElementById('alertku_span').firstChild.nodeValue = 'ON';
		  setTimeout(alertku, 600);
		 }
		 else
		 {
			 document.getElementById('alertku_span').firstChild.nodeValue = 'OFF';
		 }
		};
	</script>
	<link href="SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css">
	</head>
	<body>
    <div id="wrapper">
      <div id="content">
        <div id="logos"> </div>
        <h1>Development Laboratory</h1>
        These are the current Projects and Software Demonstration pages. (NB. real-time data is only shown when sensors or simulator are running):
        <div id="CollapsiblePanelGroup1" class="CollapsiblePanelGroup">
          
        <div class="CollapsiblePanel_full">
          <div class="CollapsiblePanelTab" tabindex="0"><a href="#">
            <h2>NCC Group API monitoring</h2>
            </a></div>
          <div class="CollapsiblePanelContent">
            <ul>
              <li><a href="error_login.htm" target="_blank">Error Feed - Generic</a></li>
              Error Feed - generic
            </ul>
            <ul>
              <li><a href="api_login.htm" target="_blank">API Monitor Generic</a></li>
              NCC Group Monitor - generic
            </ul>

          </div>
        </div>
        
        <div class="CollapsiblePanel_full">
            <div class="CollapsiblePanelTab" tabindex="0"><a href="#">
              <h2>demo SteelSeries Gauges</h2>
              </a></div>
            <div class="CollapsiblePanelContent">
              <ul>
                <li><a href="SteelSeries.htm" target="_blank">Gauge demo pages</a></li>
                SteelSeries Gauges demo pages with style selections
              </ul>
            </div>
          </div>
        </div>
        
      </div>
      <!-- end .content -->
      <div id="footer"> Prototype software developed by Tim Daish | NCC Group Web Performance </div>
      <!-- end .footer --> 
    </div>
    <!-- end .wrapper --> 
    <script type="text/javascript">
		var CollapsiblePanelGroup = new Spry.Widget.CollapsiblePanelGroup("CollapsiblePanelGroup1", { contentIsOpen: false });
    </script>
</body>
</html>