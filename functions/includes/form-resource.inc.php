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

<form id="<?php echo $id; ?>" class="dm-form validator autofill no-free-email phone-validator" action="<?php echo $form_url; ?>" method="post" accept-charset="UTF-8">
    <h5>Fill out the form to access this resource:</h5>

	<?php include('main-fields.inc.php'); ?>
 
    <p>  
    	 Are you looking for a new business solution? (Optional)<br/>
	<label class="radio-inline">
	  <input type="radio" name="swx_qualification" id="swx_qualification_1" value="Yes"> Yes
	</label>
	<label class="radio-inline">
	  <input type="radio" name="swx_qualification" id="swx_qualification_2" value="No"> No
	</label>
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
    
    <p class="submit">
    	<input type="submit" value="Download »" accesskey="s" class="btn btn-primary btn-large btn-contact">
    </p>
</form>



