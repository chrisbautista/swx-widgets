// JavaScript Document

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
		phone: 
		{
			required: true,
			phoneUS:true
		}
	},
	messages: 
	{
		Email: 
		{
			required: "&nbsp;&nbsp; Please provide a valid email address",
			email: "&nbsp;&nbsp; Enter your email address in the proper format"
		},
		First_Name: "&nbsp;&nbsp; Please provide your first name",
		Last_Name: "&nbsp;&nbsp; Please provide your last name",
		Company_Name: "&nbsp;&nbsp; Please provide the name of your company",
		phone: 
		{
			required: "&nbsp;&nbsp; Please provide a phone number",
			phoneUS: "&nbsp;&nbsp; Enter 10 digits in consecutive or ###-###-#### format"
		}
	}
});
//optional - used for when styling sets input background to white.
/*$('.validator input').focus(function(){
	$(this).css('border','1px #cccccc dotted');
});
*/
	