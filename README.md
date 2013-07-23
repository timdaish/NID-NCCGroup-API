NID-NCCGroup-API
================

Description:
Non-Interactive Display using data pulled from the NCC Group Web Performance API.

These web pages have been developed as a front-of-office display running within an ops./devt. centre and aimed at providing a simple and easy-read overview of the availability and performance status of an organisation's web sites.

To be used for Proof-of-Concept, prototype and demonstration purposes by authorised customers of the NCC Group Web Performance API service.

Created through an agile and evolutionary development method and maintained on an ad-hoc basis.

Technologies:
- HTML 5 canvas, JavaScript, jQuery, AJAX, PHP, XML, SteelSeries Javascript library.

Installation instructions:
- Unzip all files into a web server directory

Installation Pre-Requisites:
- PHP 5.3+ with PHP cURL installed (PHP v5.2 won't work correctly)

Operation instructions:
- open "api_login.htm" from the web server location
- enter your NCC Group Portal username and password
- click "Get accounts"
- select 1 or more accounts from the listbox
- optionally enter a list of comma separate monitor ids - normally leave blank to view all monitors
- click "Get data"
- once displayed:
    -  optionally select the RBE filter to Report by Exception (hides monitors in OK status)
    -  optionally select the view disabled monitor filter
- use window zoom to best present display

Browsers:
- Google Chrome
- Mozilla Firefox
- Microsoft Internet Explorer 10 (earlier versions may not work as expected)
- Tablets partially supported (media types added):
    - 1280x800 resolution screens (typical Android tablets)
    - 1024x768 resolution screens (iPad)

Notes:
- XML data is pulled back from the API by PHP pages using cURL
- each API call will count against your daily API call allowance
- these pages should only be used if you have not already developed a solution to pull back API data
- you may replace the call to the PHP page with the name of an already retrieved XML page if required
- refresh is set a default of 5 mins (300000 milleseconds) to align with the default user's allowance of 300 API calls per day


Copyright (c) 2013 Tim Daish BA(Hons) MBCS CTAL-TM

    Permission is hereby granted, free of charge, to any person obtaining
    a copy of this software and associated documentation files (the "Software")
    the rights to use, copy, modify, merge, publish and distribute copies of the Software,
    and to permit persons to whom the Software is furnished to do so.
    The Software may not be sold or rented. Modification is encouraged to meet individual needs.
    Support from the Author will only be provided against the original Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
    EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
    OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
    IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
    CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
    TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE
    OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
