<!--<link type="text/css" href="styles-cdform.css" rel="stylesheet" />-->
<style type="text/css">
	.error, .email-errors, .phone-errors
	{
		color:#FF0000;
		font-size:12px;
		font-weight:normal;
	}
	input
	{
		border:1px #cccccc solid;
	}
</style>

<form id="<?php echo $id; ?>" class="dm-form validator autofill no-free-email phone-validator newsletter" action="<?php echo $form_url; ?>" method="post" accept-charset="UTF-8">
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12">
		<h3>Insights Newsletter Signup</h3>
		<p>Fill in your details  and submit the form to receive your monthly BDO Solutions Insights newsletter.</p>
		<br/>
	</div>
</div>
<div class="row">
	<div class="col-lg-4 col-md-4 col-sm-4">
		<p>
			<label for="Email" class="field-label">Office Email</label><br>
			<input type="text" onchange="" maxlength="255" size="30" class="form-control text" value="" id="Email" name="Email">
		</p>
		<p>      
			<br>
			<label for="Company_Name" class="field-label"  >Company Name </label><br>
			<input type="text" onchange="" maxlength="32" size="30" class="form-control text" value="" id="Company_Name" name="Company_Name" >
		</p>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-4">
		<p>      
			<label for="First_Name" class="field-label"  >First Name </label><br>
			<input type="text" onchange="" maxlength="32" size="30" class="form-control text" value="" id="First_Name" name="First_Name" >
		</p>
		<p>      
			<br>
			<label for="Last_Name" class="field-label"  >Last Name </label><br>
			<input type="text" onchange="" maxlength="32" size="30" class="form-control text" value="" id="Last_Name" name="Last_Name" >
		</p>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-4">
		<p>
			<label for="Phone" class="field-label">Phone</label>
			<br>
			<input type="text" onchange="" maxlength="32" size="30" class="form-control text" value="" id="Phone" name="Phone"> 
		</p>
		<p class="mrkt-comms">
		<input type="hidden" value="do not send" id="mrkt_comms_hidden" name="mrkt_comms">
		<input type="checkbox" class="checkbox" value="" id="mrkt_comms" name="mrkt_comms"><label for="mrkt_comms" class="mrkt-comms-txt">I agree to receive marketing communications from BDO Solutions. You may withdraw your consent at any time.</label>
		</p>
	
    <!-- SW Fields -->
    
    
    <input type="hidden"  class="swcity" name="swcity">
    
    <input type="hidden"  class="swcountry" name="swcountry">
    
    <input type="hidden"  class="swstate" name="swstate">
    
    <input type="hidden"  class="swregion" name="swregion">
    
    <input type="hidden"  class="swlocation" name="swlocation">
          
    <input type="hidden"  class="swzip" name="swzip">
     
    <input type="hidden"  class="utm_source" name="utm_source">
     
    <input type="hidden"  class="utm_term" name="utm_term">
     
    <input type="hidden"  class="utm_content" name="utm_content">
     
    <input type="hidden"  class="utm_campaign" name="utm_campaign">
     
    <input type="hidden"  class="utm_gclid" name="utm_gclid">
     
    <input type="hidden"  class="utm_medium" name="utm_medium">
    
    <input type="hidden"  class="page_url" name="page_url" value="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
    
    <input type="hidden"  class="referrer_url" name="referrer_url" value="<?php echo $_SERVER[HTTP_REFERER]; ?>">
    
    <input type="hidden"  class="redirect_to" name="redirect_to" value="<?php echo $redirect_to; ?>">
     
    <input type="hidden"  class="offer_name" name="offer_name" value="<?php echo $offer_name; ?>">
     
    <input type="hidden"  class="offer_category" name="offer_category" value="<?php echo $offer_category; ?>">
    
    <input type="hidden"  id="topic" name="topic" value="">		
        
    <!-- forces IE5-8 to correctly submit UTF8 content  -->
    <input name="_utf8" type="hidden" value="☃">
    
    <p class="submit">
        <input type="submit" class="btn btn-primary btn-large btn-contact" accesskey="s" value="Submit »">
    </p>
	</div>
</div>
</form>





