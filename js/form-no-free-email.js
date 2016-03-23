
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