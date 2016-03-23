
$( document ).ready( function(){

	function phoneValidate(inputtxt)  
	{  
	  var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;  
	  if(inputtxt.value.match(phoneno))  
		 {  
		   return true;        
		 }  
	   else  
		 {  
		   alert("Not a valid 10-digit phone number");  
		   return false;  
		 }  
	}

});