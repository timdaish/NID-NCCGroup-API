/* api_login_funcs.js
//
// Release: v1.0 July 2013
//
// Author: Tim Daish BA(Hons) MBCS CTAL-TM
//         Technical Consultant, NCC Group Web Performance
//
// Function Library for demo pages for API in XML format
//
*/

if ( ! window.console ) console = { log: function(){} };	
	// declare variables
	var acntid, acntname;  // account id and account name
				
	// disable submit button
	$("input[type=submit]").attr("disabled", "disabled");
		
	// jquery function to check that at least one account is selected before allowing submit for display
	// called when the login form's submit button is clicked
	$(function(){
		$("#login").submit(function(){
	
			// count the number of accounts selected
			var noof_OptSel=0;
			noof_OptSel = $('#optAccounts :selected').length;
			
			if(noof_OptSel > 0){
				//alert(valid + " options have been selected");
				return true;
			}
			else {
				alert("error: Please select at least account");
				return false;
			}
		});
	});  // end jquery function upon submit of login form
	
	
	// function to get the list of accounts
	// called when 'Get Accounts' button is clicked
	function getAccounts(form){
		  
		//console.log("get accounts called");
		var request;
		var un = login.elements["username"].value;
		var pw = login.elements["pw"].value;
		var urlstring = "api_getaccounts.php"
		//console.log(urlstring);  
		var $form = $(login);
		// select and cache all the fields
    	var $inputs = $form.find("input");
		// serialize all the form inputs		  
		var serializedData = $form.serialize();
  		//console.log("sdata = " + serializedData);
		
		// disable the inputs for the duration of the ajax request
    	$inputs.prop("disabled", true);
		
		// post the data to the PHP page to lookup and return the user's accounts
		request = $.ajax({
			type: "POST",
			url: urlstring,
			data: serializedData
			});	
			
		  	// callback handler that will be called on success
			request.done(function (response, textStatus, jqXHR){
			// log a message to the console
			//console.log("data received = " + response);
			parseXml(response);
		});
	
		// callback handler that will be called on failure
		request.fail(function (jqXHR, textStatus, errorThrown){
			// log the error to the console
			console.error("The following error occured: "+textStatus, errorThrown);
		});
	
		// callback handler that will be called regardless
		// if the request failed or succeeded
		request.always(function () {
			// re-enable the inputs
			$inputs.prop("disabled", false);
		});
	
		// prevent default posting of form
		event.preventDefault();
							
	} // end function getData


	// function to parse the returned XML
	// extract each account id and account name and append them using jquery to the optAccounts list
	function parseXml(xml) {

		//console.log("accounts parseXML called");
		//console.log(xml);

		// Removes all options for the select box
		$('#optAccounts option').remove();	
		
		$(xml).find("Account").each(function() {
		   	acntid = $(this).attr('AccountId');
		   	acntname = 	$(this).attr('Name');
		   	//console.log(acntid + " " + acntname);

			$('#optAccounts').append($('<option>', { 
				value: acntid,
				text : acntid + " " + acntname 
			}));

			 }); // end for each account
			
		$("input[type=submit]").removeAttr("disabled");  
	}	// end function parseXml	