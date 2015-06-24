<?php 
	
	//ini_set('display_errors', 1);
	//error_reporting(-1);
	
	require_once('inc/inc.php');
	
	function asset_url($file, $return = false) {
		
		global $cdn_url;
		
		if( $cdn_url != '' ) $url = $cdn_url.$file;
		else $url = $file;
		
		if( $return ) return $url;
		else echo $url;
		
	}
	
	function door_panel($count = 1, $style = '', $display = 'show-for-medium-up') { 
				
		if( $style == '' ) $style = 'red-door';
		
		for($count; $count>0; $count--) {
			
			echo '<div class="panel-1 door-panel '.$style.' '.$display.'"></div>';
			
		}
		
	}
	
	$thank_you = isset($_GET['thank-you']);
/*
	$valid_code = true;
	$plus_one = false;
	$redeemed = false;
	$rsvp_code = '';
	
	if( isset($_GET['rsvp_code']) ) {
		$rsvp_code = $_GET['rsvp_code'];
	
		$found_code = find_code($rsvp_code, $mysqli);
			
		if( $found_code == 'redeemed' ) {
			
			$redeemed = true;
			
		} else if( $found_code ) {
			//$valid_code = true;
			$plus_one = $found_code['guest'];
		}
					
	}
*/
	
	/*
	if( $thank_you ) {
		$valid_code = true;
	}
	*/
	
?>

<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>RSVP To Virgin Hotels Chicago Grand Opening</title>
        <meta name="description" content="RSVP To Virgin Hotels Chicago Grand Opening">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="robots" content="NOINDEX, NOFOLLOW">
				
		<!-- Typekit -->    
	    <script type="text/javascript" src="//use.typekit.net/xdw6gxo.js"></script>
		<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
	    <!-- End Typekit -->
		
        <link rel="stylesheet" href="<?php asset_url('css/rsvp.virginhotels.css'); ?>">
        <script src="<?php asset_url('js/modernizr.min.js'); ?>"></script>
    </head>
    <body>
        
        
        
        
        
        <div class="row door-pattern">
	        
	        
	        	        
	        <div class="panel main-content">
		        
		        
		        <h1>The Grand Opening of Cerise</h1>
		        
		        <p class="date">April 25, 2015 <span class="remove_mobile">&bull; </span>8PM</p>
		        
		        <p>You&rsquo;re not far from a new point of view atop Chicago&rsquo;s historic loop district. <span class="mobile_break"></span>Dig in. We&rsquo;ll meet you up top.</p>
		        
		        
		        
		        <div class="sign-up <?php if($thank_you) echo 'hide'; ?>">
		        
			        
			        
			        <form action="process.php" method="POST" class="rsvp-form">
				        
				        <input type="hidden" name="rsvp_code" value="<?php echo $rsvp_code; ?>" />
				        
				        <div class="input-holder">
				        	<input type="text" name="first_name" placeholder="First Name" required data-parsley-error-message="Please provide your first name." class="half">
				        </div>
				        <div class="input-holder right">
				        	<input type="text" name="last_name" placeholder="Last Name" required data-parsley-error-message="Please provide your last name." class="half right">
				        </div>			        
				        <input type="text" name="email_address" placeholder="Email Address" required data-parsley-type="email" data-parsley-required-message="Please provide your email address." >
				        
				        <div class="checkboxes">
				        	
					        <div>
						        Plus 1?
							  <input id="guest_yes" type="radio" name="guest" value="yes" checked="checked">
							  <label for="guest_yes"><span><span></span></span>YES</label>
							  
							  <input id="guest_no" type="radio" name="guest" value="no">
							  <label for="guest_no"><span><span></span></span>NO</label>
							</div>
						    
						    
<!-- 							<input type="checkbox" name="answer" value="No" > <label for="squaredOne"></label> No -->
				        </div>				        
				        <div class="guest-fields">
					        <div class="input-holder">
					        	<input type="text" name="guest_first_name" placeholder="First Name" required data-parsley-error-message="Please provide your guest's first name." class="half">
					        </div>
					        <div class="input-holder right">
					        	<input type="text" name="guest_last_name" placeholder="Last Name" required data-parsley-error-message="Please provide your guest's last name." class="half right">
					        </div>
				        </div>
				        

						
						<input type="submit" value="Click To RSVP">
				        
			        </form>
		        
					<div class="error-message"></div>
		        
		        </div>
		        

		        
		        <div class="thank-you <?php if($thank_you) echo 'show'; ?>">
			        
			        <h2><sm>You're headed to the rooftop for</sm> THE GRAND OPENING OF CERISE <sm>We'll meet you there</sm></h2>
			        
			        <p class="address">203 North Wabash Avenue<br>26th Floor<br>Chicago, IL 60601</p>
			        
<!--
			        <div class="event-date clearfix">
				        <span class="month">April</span> <span class="day">25</span> <span class="year">2015</span> <span class="time">8PM</span>				        
			        </div>
-->
			        
			        <div class="questions">
				        Any questions? Please email: <a href="mailto:rsvpchicago@virginhotels.com?subject=Cerise Grand Opening">rsvpchicago@virginhotels.com</a>
			        </div>
			        
			        <a href="http://virginhotels.com/" target="_blank" class="show-for-medium-up"><img class="logo" alt="Virgin Hotels" src="<?php asset_url('images/logo-vh.png'); ?>"></a>
			       
					<div class="vh-social">
						<a class="vh-home" href="http://virginhotels.com/" target="_blank">virginhotels.com</a>
						
						<a class="icon icon-VH-facebook-01" href="https://facebook.com/virginhotels" target="_blank"><span>Facebook</span></a>
						<a class="icon icon-VH-twitter2-01" href="https://twitter.com/virginhotels" target="_blank"><span>Twitter</span></a>
						<a class="icon icon-VH-linkedin-01" href="http://www.linkedin.com/company/virgin-hotels" target="_blank"><span>LinkedIn</span></a>
						<a class="icon icon-VH-instagram-01" href="http://instagram.com/virginhotels" target="_blank"><span>Instagram</span></a>
						<a class="icon icon-VH-google-01" href="https://plus.google.com/115998220325599130607" target="_blank"><span>Google+</span></a>
					</div>
			        
		        </div>
		        
	        </div>
	        
	        
	        
        </div>
                
        <script src="<?php asset_url('js/jquery.min.js'); ?>"></script>
        <script src="<?php asset_url('js/placeholders.min.js'); ?>"></script>
        <script src="<?php asset_url('js/rsvp.virginhotels.min.js'); ?>"></script>

        <script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		  //ga('create', 'UA-55537445-1', 'auto');
		  ga('require', 'displayfeatures');
		  ga('send', 'pageview');
		
		</script>
        
    </body>
</html>