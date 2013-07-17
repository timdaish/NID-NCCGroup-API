NID-NCCGroup-API
================

Description
Non-Interactive Display using data pulled from the NCC Group Web Performance API.

These web pages have been developed as a front-of-office display running within an ops./devt. centre and aimed at providing a simple and easy-read overview of the availability and performance status of an organisation's web sites.

To be used for Proof-of-Concept, prototype and demonstration purposes by authorised customers of the NCC Group Web Performance API service.

Created through an agile and evolutionary development method and maintained on an ad-hoc basis.

Technologies
- HTML, JavaScript, jQuery, AJAX, PHP, XML, SteelSeries Javascript library.

Installation instructions
- Unzip all files into a web server directory

Installation Pre-Requisites
- PHP 5.2+ with PHP cURL installed

Operation instructions
- open "api_login2.htm" from the web server location
- enter your NCC Group Portal username and password
- click "Get accounts"
- select 1 or more accounts from the listbox
- click "Get data"

Browsers
- Google Chrome
- Mozilla Firefox
- Microsoft Internet Explorer (compatible, but others recommended)

Notes
- XML data is pulled back from the API by PHP pages using cURL
- each API call will count against your daily API call allowance
- these pages should only be used if you have not already developed a solution to pull bacj API data
- you may replace the call to the PHP page with the name of an already retrieved XML page if required
- refresh is set a default of 5 mins (300000 milleseconds) to align with the default user's allowance of 300 API calls per day
