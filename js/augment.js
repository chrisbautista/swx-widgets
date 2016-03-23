// ######################################### //
// validation, UTMZ scrape, GEO IP functionality
// Version 2.1 - June, 2013
// ######################################### //

// function to search inside arrays
Array.prototype.find = function(searchStr) {
  var returnArray = false;
  for (i=0; i<this.length; i++) {
    if (typeof(searchStr) == 'function') {
      if (searchStr.test(this[i])) {
        if (!returnArray) { returnArray = [] }
        returnArray.push(i);
      }
    } else {
      if (this[i]===searchStr) {
        if (!returnArray) { returnArray = [] }
        returnArray.push(i);
      }
    }
  }
  return returnArray;
} 

// Jquery
jQuery(document).ready(function () {

        // setup countries where form is NOT blocked
        var validcountries = [ 'US','GB','AU','NZ','IE','CA','RU','SE','PT','NL','NO','MC','LU','IT','IS','HU','FR','FI','ES','DE','DK','CH','AT' ];
        var restrictMsg = "We're sorry this content is not available in your geographic location.";
        
        // setup variables used
        var sw = jQuery.noConflict();
        var hasloc = false;
        var city = '';
        var state = '';
        var country = '';
        var countrycode = '';
        var location = '';
        var region = "";
        var zip = "";
        
        // Which GEOIP database to use
        var bGoogle = false;       
        var bMaxMind =true;
		
		// Append iframe url or populate form?
        var bIframe = false;       
        var bform = true;

        // query GEOIP provider
        if (bGoogle)
         {
          if (google.loader.ClientLocation != null) {
              hasloc = true;
              city = google.loader.ClientLocation.address.city;
              region = google.loader.ClientLocation.address.region;
              location = google.loader.ClientLocation.latitude + ' ' + google.loader.ClientLocation.longitude;
          }
        }
        else
        {
            // maxmind
            // http://www.maxmind.com/app/javascript_city
            countrycode = geoip_country_code();
            country = geoip_country_name();
            city = geoip_city();
            state = geoip_region_name();
            region = geoip_region();
            location = geoip_latitude() + ' ' + geoip_longitude();
            zip = geoip_postal_code();
        }
      // Debug GEOIP
      //debugMsg = countrycode + ',' + country + ',' + city + ',' + state + ',' + region + ',' + location + ',' + zip;
      //alert(debugMsg);

        if (bform)
         {
			
								
			// Populate Form
			fillFormValue(sw, 'swcity', city ,'.');
			fillFormValue(sw, 'swcountry', country,'.');
			fillFormValue(sw, 'swstate', state,'.');
			fillFormValue(sw, 'swregion', region,'.');;
			fillFormValue(sw, 'swlocation', location,'.');
			fillFormValue(sw, 'swzip', zip,'.');
			fillFormValue(sw, 'utm_medium ', medium, '.');
			fillFormValue(sw, 'utm_source ', source,'.');
			fillFormValue(sw, 'utm_term ', term,'.');
			fillFormValue(sw, 'utm_content ', content,'.');
			fillFormValue(sw, 'utm_campaign ', campaign,'.');
			fillFormValue(sw, 'utm_gclid ', csegment,'.');
        }
        else 
        {

				/* original code
				  $("#salesfusion_variable").append('<IFRAME id="sfId_variable" width=400 height=750 >');
					// get the URL from the url attribute of div
					var urlDialog = $("#salesfusion_variable").attr('url');
					// var urlDialog = 'http://forms.omnivue.net/af2?LinkID=CH00095628eR00000037AD';
					var urlUTMZ = '&ga_source=' + source + '&ga_medium=' + medium + '&ga_term=' + term + '&ga_content=' + content + '&ga_campaign=' + campaign + '&ga_segment=' + csegment + '';	
					var url = urlDialog+''+urlUTMZ;
					$('iframe#sfId_variable').attr('src', url);
					$('iframe#sfId_variable').hide();
					$('iframe#sfId_variable').load(function() 
					{
						$("#salesfusion_offer_loading_variable").fadeOut(function () {
							 $('iframe#sfId_variable').show();
							$("#salesfusion_variable").fadeIn();
						});
						//callback(this);
					});
				*/
			
			
			// get the URL from the url attribute of div
			var urlDialog = sw("#pardotForm").attr('src');						
			// detect if ? exists in url already
			if(urlDialog) {
				if (urlDialog.indexOf("?") >= 0) {
					var urlJoin = '&';
				} else {
					var urlJoin = '?';
				}  
			}
			
			var urlUTMZ = 'utm_source=' + source + '&utm_medium=' + medium + '&utm_term=' + term + '&utm_content=' + content + '&utm_campaign=' + campaign + '&utm_gclid=' + csegment + '&city=' + city + '&state=' + state + '&country=' + country;	
			var urlFinal = urlDialog + urlJoin + urlUTMZ;			

			// check if there should be a redirect
			/*var redirect_to = sw("#pardotForm").attr('redirect_to');
			if(redirect_to) {
				var urlRedirect = '&redirect_to=' + redirect_to;
				var urlFinal = urlFinal + urlRedirect;
			}*/

			
		    sw('#pardotForm').attr('src', urlFinal);
			 
			// debug
			// dialog(urlDialog + '<br/>' + urlUTMZ + '<br/>' + url);
			

			
			
			
			
		
		}
	  
	  /* formData = readCookie('_formData');
	  if (formData !== false) {
		  formData = formData.split('_formData=');
		  formData = formData[1];
		  formData = formData.split(';');
		  formData = formData[0];
		  formData = formData.split(',');
		  for (var i = 0; i < formData.length; i++) {
			  formDataSplit = formData[i].split(':');
			  formFieldName = formDataSplit[0];
			  formFieldValue = formDataSplit[1];
			  fillFormValue(sw, formFieldName, formFieldValue,'#');
		  }
	  } */
      

      // Restrict Form Access to specific valid countrycodes
      // if a div with the id "swrestricted" exists on the page, then check for valid countries
      if (sw('#swrestricted').length > 0)
      {
        if(!validcountries.find(countrycode))
        {
            // hide content region
            // sw('.swvalidate').hide();
            // hide entire form
            sw('form').hide();
            // show custom restricted messsage
            // sw('#swrestricted').show();
            // // show default restriced message
            sw('#swrestricted').after("<span class=error>" + restrictMsg + "</span>");
        }
      }


	// Function to change other answers which are contigent on a primary question
	// Author: Vitaliy Isikov <visikov@gmail.com>
	//  So essentially, if user selects None in A (contingentPrimary) then the values for B and C (contingentSecondary) automatically switch to None (instantly) and the class “greyedOut” is added to B and C (contingentSecondary) 
	//  A will be “contingentPrimary”
	//  B and C will be “ContingentSecondary”
	// EAM
	

jQuery.noConflict();
});
/*
this.createCookie = function(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

this.readCookie = function(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}
*/


/* this.createCookie = function(data,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = data+expires+"; path=/";
}

this.readCookie = function(name) {
	var ca = document.cookie;
	if (ca.search(name) !== -1) {
		return ca;
	}
	else {
		return false;
	}
}


function eraseCookie(name) {
	createCookie(name + "=",-1);
} */

function fillFormValue(sw, classid, value, type) {
	value = unescape(value);
	value = value.replace(/\+/g, ' ');
	/* if (classid == 'swmedium') {
		var valueArray = new Array('', '-', '(none)', 'Cpc', 'organic', 'Banner', 'Email', 'referral', 'dm');
		for (var i = 0; i < valueArray.length; i++) {
			var checkValue = valueArray[i].toLowerCase();
			var sentValue = value.toString().toLowerCase();
			// pass as integer 
			/* if (sentValue == checkValue) {
				if (i != 0) {
					value = i - 1;
				}
				else {
					value = i;
				}
			}
			// pass as eloqua GUID
			if (sentValue == '') {
				value = '20F2589F-A014-DD11-A161-005056B21571';
			}
			if (sentValue == '-') {
				value = '20F2589F-A014-DD11-A161-005056B21571';
			}
			if (sentValue == '(none)') {
				value = '20F2589F-A014-DD11-A161-005056B21571';
			}
			if (sentValue == 'cpc') {
				value = 'A92F67F4-E4F4-E011-86ED-005056B23E4A';
			}
			if (sentValue == 'organic') {
				value = '1C1C96B5-A014-DD11-A161-005056B21571';
			}
			if (sentValue == 'banner') {
				value = '754E7425-61F6-E011-86ED-005056B23E4A';
			}
			if (sentValue == 'email') {
				value = '691FE085-747A-E011-9E98-005056B23E4A';
			}
			if (sentValue == 'referral') {
				value = '6AAE062E-61F6-E011-86ED-005056B23E4A';
			}
			if (sentValue == 'dm') {
				value = 'DD269F37-61F6-E011-86ED-005056B23E4A';
			}
			
		}
	} */
	
	/*if (sw('select' + type + classid + ' option[value="' + value  + '"]').length > 0 ) {
		sw('select' + type + classid + ' option[value="' + value  + '"]').attr('selected','selected');
	}
	else {
		// city wasn't in th select list so lets add it.      
		sw('select' + type + classid ).append(sw("<option></option>").attr("value", value).text(value).attr("selected", true));
	}*/
  
	// modify to look inside <p class="xxx"><input></p>
	if(sw('input' + type + classid).length > 0 ) {
		sw('input' + type + classid).val(value);		
	}
}

// ######################################### //
// padding hidden fields to pardot iframe
// http://www.pardot.com/faqs/forms/passing-a-redirect-url-to-a-form-as-a-hidden-field/
// Version 2.1 - June, 2013
// ######################################### //

/*

setTimeout(function(){
	function getUrlParameter(parameterName) {
		var queryString = document.URL;
		var parameterName = parameterName + "=";
		if (queryString.length > 0) {
			var begin = queryString.indexOf(parameterName);
		if (begin != -1) {
			begin += parameterName.length;
			var end = queryString.indexOf( "&" , begin);
			if (end == -1) {
				end = queryString.length
				}
			return unescape(queryString.substring(begin, end));
			}
		}
	return null;
}
 
var Url = getUrlParameter("requested_url");
if(Url != null) {
	top.location=Url;
} else {
	top.location="%%requested_url%%";
}},200);
*/



/*  ############# FORM VALIDATION AUTO-FILL AND NO FREE EMAIL FUNCTIONS  ##############  */

// JavaScript Document - FORM VALIDATION

//validates forms
//instructions == add class "validator" to form tag - add rules for input elements under rules by name attribute - add custom error messages per input in messages - load form-validate.js after the html form element - load http://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.js  and http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/additional-methods.min.js before loading form-validate.js
//uses jQuery Validation plugin at http://bassistance.de/jquery-plugins/jquery-plugin-validation/. Documentation at http://jqueryvalidation.org/documentation

/*jQuery.validator.setDefaults({
  debug: true,
  success: "valid"
});*/


$(".validator").validate({
	rules: 
	{
		Email: 
		{
			required: true,
			email: true
		},
		First_Name: "required",
		Last_Name: "required",
		Company_Name: "required",
		Phone: "required" 
	},
	messages: 
	{
		Email: 
		{
			required: "Please provide a valid email address",
			email: "Not a valid email address"
		},
		First_Name: "Please provide your first name",
		Last_Name: "Please provide your last name",
		Company_Name: "Please provide your company's name",
		Phone: "Please provide a valid phone number"
	}
});
//optional - used for when styling sets input background to white.
$('.validator input').focus(function(){
	$(this).css('border','1px #cccccc dotted');
});
	
	

	
	
// JavaScript Document - FORM AUTO-FILL

/*jQuery.validator.setDefaults({
  debug: true,
  success: "valid"
});*/
	


//Create cookies when submitting the form  
//instructions == add class "autofill" to form tag - submit button must be 'input[type="submit"]' or 'button.submit' - load form-autofill.js after the html form element - load "http://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.0/jquery.cookie.min.js" before autofill.js
jQuery(document).ready(function($){

	$('.autofill input[type="submit"]').click(function(){
		
		$('.autofill input').each(function(index, element) {
			var inputVal = $(this).val();
			//alert("inputVal = " + inputVal);
			$.cookie($(this).attr('ID'),inputVal,{ expires : 365 });
		});
			
	});
		
	var getCookies = function(){
		
		var pairs = document.cookie.split("; ");
		var cookie = [];
		var cookies = [];
		
		for (var i=0; i<pairs.length; i++)
		{
			var pair = pairs[i].split("=");
			cookie.push(unescape(pair[0]))
			cookie.push(unescape(pair[1]));
			cookies.push(cookie);
			cookie = [];
		}
		
		return cookies;
	}

	var userFormData = [];
	var userFormData = getCookies();

	$('.autofill input').each(function(){
		for(n=0; n<userFormData.length; n++)
		{
			if($(this).attr('type') !== "hidden")
			{
				if($(this).attr('id') == userFormData[n][0])
				{
					$(this).val(userFormData[n][1])
				}
			}
		};
	});    

}); 

//populate hidden Topic field for CRM Lead topic field
$(document).ready(function(){

	var concatTopic = function()
	{
		return $('#Company_Name').val() + ' - ' + $('#First_Name').val() + ' ' + $('#Last_Name').val() + ' - ' + $('input[name=offer_category]').val();
	}; 
				
	$('.dm-form').find('input[type="submit"], button.submit').click(function (e) {

		if($('#topic'))
		{
			
			$('#topic').val(concatTopic());
			//alert(concatTopic());
			//console.log("concatTopic() = " + concatTopic()) ;
			//e.preventDefault();
		};

	});

});
	
/*  JSON Cookie Unfinished
var formData = new Object();

formData.Email = $('.dm-form #Email').val();
formData.First_Name = $('.dm-form #First_Name').val();
formData.Phone = $('.dm-form #Phone').val();
//formData.email = $('.dm-form #Email').val();
//formData.email = $('.dm-form #Email').val();
//formData.email = $('.dm-form #Email').val();

//alert("formData = " + formData);
data = "formData = " + JSON.stringify(formData);

createCookie(data,365);

$('.dm-form input').each(function(index, element) {
	var inputVal = $(this).val();
	createCookie(inputVal,365);
});


	
//var formUserdata = JSON.parse($.cookie('formData'));
var formUserdata = JSON.parse($.cookie('formData'));
alert("formUserdata = " + formUserdata);

var userDataPair =[];
var userDataArray = [];
for(n = 0; n < 50 n+2) 
{
	userDataPair.push(formUserdata[n+1]);
	userDataArray.push(userDataPair);
}

//alert("userDataArray = " + userDataArray);

$('.dm-form input').each(function(i){
//alert("$(this) = " + $(this));
if($(this).attr('ID') == userDataArray[i])
{
	//alert("input ID = " + $(this).attr('ID'));
	//alert("formUserdata[i] = " + formUserdata[i]);
	$(this).val(userDataArray[i]);
}
});
*/


// JavaScript Document - FORM NO FREE EMAIL

/*jQuery.validator.setDefaults({
  debug: true,
  success: "valid"
});*/
	

//checks value of domain in email field against list of free email providers and returns error when finding a match - 
//instructions == add class "no-free-email" to form tag - change id of email input field to "Email" (e.g. <input id="Email"> - add label element with class "email errors" after email input field load form-autofill.js after the html form element - submit button must be 'input[type="submit"]' or 'button.submit' - add free email domains to "emails" array in format "@domain.com"
validateFreeEmail = function() {
    var emails = ["@gmail.com", "@hotmail.com", "@aol.com", "@outlook.com", "@live.com", "@msn.com", "@yahoo.com", "@aol.com", "@mail.com", "@inbox.com", "@fastmail.com", "@lycos.com", "@zoho.com", "@126.com", "@yandex.com"]; //your email array
    
    jQuery.each(emails, function(index, value) {
      var email = $('.no-free-email input#Email').val(); //get the value from a textbox
      email = email.substr(email.indexOf('@'));
	   if(email === value){
		 errEmails = "Please use your office email address.";
		 return false;
	   }
      else {
		errEmails ='';
      }
   });
  };
  


//Validate for free email on clicking the submit button -- submit button must be 'input[type="submit"]' or 'button.submit'
$('.no-free-email').find('input[type="submit"], button.submit').click(function (e) {
	validateFreeEmail();
	if (errEmails != '') 
	{
		$('.email-errors').html(errEmails);
		e.preventDefault();
	}
	else 
	{
		$(this).parent('form.no-free-email').submit();
	}	
}); 

//Validate for free email on changing focus from the email field
$('.no-free-email input#Email').blur(function (e) {
	validateFreeEmail();
	if (errEmails != '') 
	{
		$('.email-errors').html(errEmails);
	}
	else 
	{
		$('.email-errors').html('');
	}		
}); 


//Validate for 10-digit US/Canada phone format 

//var errPhone ='';
//alert('errPhone = '+ errPhone);
function validatePhone(inputtxt)
{  
	
	var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;  
	
	//alert('inputtxt = '+ inputtxt);
	//alert('String(inputtxt.value) = '+ String(inputtxt.value));
	//(String(inputtxt.value).match(/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/)
	if(inputtxt.match(phoneno) || inputtxt=='')  
	{  
		//alert('errphone = match/empty')
		errPhone ='';     
	}  
	else  
	{  
		//alert('errphone = Not a valid...');
		errPhone ='Not a valid 10-digit phone number';   	
	}  
	
};

//Validate for phone on clicking the submit button -- submit button must be 'input[type="submit"]' or 'button.submit'
$(document).ready(function(){

	$('.phone-validator').find('input[type="submit"], button.submit').click(function (e) {
	
		//alert('alert = ');
		var phoneVal = $('input#Phone').val();
		//alert('phoneVal = '+ phoneVal);
		validatePhone(phoneVal);
		//alert('errPhone outside if = '+ errPhone);
		
		if (errPhone != '') 
		{
			//alert('errPhone inside if = '+ errPhone);
			$('.phone-errors').html(errPhone);
			e.preventDefault();
			return false;
		}
		else 
		{
			//alert('alert = ');
			$(this).parent('form.phone-validator').submit();
		}
		
	}); 
	
}); 

//Validate for phone on changing focus from the email field
$('.phone-validator input#Phone').blur(function (e) {

	var phoneVal = $('input#Phone').val();
	//alert('phoneVal = '+ phoneVal);
	validatePhone(phoneVal);
	//alert('errPhone = '+ errPhone);
	
	if (errPhone != '') 
	{
		//alert('errPhone = '+ errPhone);
		$('.phone-errors').html(errPhone);
	}
	else 
	{
		//alert('errphone = empty');
		$('.phone-errors').html('');
	}		
}); 

/* $('.validator input.btn-download').click(function (e) 
{  
	alert("You clicked on me!");
	var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;  
	
	var inputtxt = $('input#Phone').val();
	
	if(inputtxt.length > 0) 
	{
		if(String(inputtxt.value).match(phoneno))  
		{  
			$(this).parent('form.validator').submit();       
		}  
		else  
		{  
			$('input#Phone').after('<label for="phone" class="error"><strong>Not a valid 10-digit phone number</strong></label>' );  
			e.preventDefault();
		}  
	}
	else
	{
		$(this).parent('form.validator').submit();
	}
}); */

//$('.validator input.btn-download').click(phoneValidate(inputtxt));
//$('input#Phone').blur(phoneValidate(inputtxt));


//Change value of Marketing Communications checkbox
$(document).ready(function(){

	$('input#mrkt_comms').val('do not send');

	$('input#mrkt_comms').bind('change', function() {
		if(this.checked) 
		{
			$('input#mrkt_comms_hidden').remove();
			$('input#mrkt_comms').val('send');
		}
		else 
		{
			$('input#mrkt_comms').val('');
			$('input#mrkt_comms').before('<input type="hidden" value="do not send" id="mrkt_comms_hidden" name="mrkt_comms">');
		}
	});
	
});
