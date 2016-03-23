// JavaScript Document

/*jQuery.validator.setDefaults({
  debug: true,
  success: "valid"
});*/
	


//Create cookies when submitting the form  
//instructions == add class "autofill" to form tag - submit button must be 'input[type="submit"]' or 'button.submit' - load form-autofill.js after the html form element - load "http://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.0/jquery.cookie.min.js" before autofill.js

//alert('form-autofill');

jQuery(document).ready(function($){

	$('.autofill input[type="submit"]').click(function(e){
		
		$('.autofill input').each(function(index, element) {
			var inputVal = $(this).val();
			//alert("inputVal = " + inputVal);
			$.cookie($(this).attr('ID'),inputVal,{ expires : 365 });
		});
		//e.preventDefault();
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
	//alert('userFormData = '+ userFormData);

	$('.autofill input').each(function(){
		for(n=0; n<userFormData.length; n++)
		{
			if($(this).attr('type') !== "hidden")
			//alert("cookie = " + $(this).val());
			{
				if($(this).attr('id') == userFormData[n][0])
				{
					$(this).val(userFormData[n][1])
					//alert("cookie = " + $(this).val(userFormData[n][1])); 
				}
			}
		};
	}); 

	//jQuery.cookie('Email','aubiera@randgroup.com',{ expires : 365 });

});//document ready
	
/*  JSON Cookie Unfinished
var formData = new Object();

formData.Email = $('.dm-form #Email').val();
formData.First_Name = $('.dm-form #First_Name').val();
formData.Phone = $('.dm-form #phone').val();
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
