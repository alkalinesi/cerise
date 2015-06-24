function showError(error_message) { 
	if( typeof error_message == 'undefined' ) error_message = 'Sorry, there was a problem submitting the form. Please try again later.';
	
	$('.error-message').html(error_message).show();
	
}

function guestUpdate() {
	
	if ($('input[name="guest"]:checked').val() == 'yes') {
		
		$('input[name="guest_first_name"]').prop('required', true);
		$('input[name="guest_last_name"]').prop('required', true);
		$('.guest-fields').show();
		
	} else {
	
		$('input[name="guest_first_name"]').prop('required', false);
		$('input[name="guest_last_name"]').prop('required', false);
		$('.guest-fields').hide();
		
	}
	
}

$(function() { 

	
	$('.rsvp-form')
		.parsley({
			errorsWrapper: '<div class="field-error"></div>',
			errorTemplate: '<span></span>'
		});
		
	guestUpdate();
		
	$('input[name=guest]').on('change', guestUpdate);
		
	
	$('.rsvp-form')	
		.submit(function(event) { 
		
			event.preventDefault();
			
			var form = $(this);
			
			$.ajax({
				data: form.serialize(),
				dataType: 'json',
				url: form.attr('action'),
				type: form.attr('method') || 'POST',
				success: function(data, message) { 
					
					if(data.success) {
						$('.sign-up').hide();
						$('.thank-you').show();
					} else {
						showError();
					}
					
					if( typeof ga != 'undefined' ) ga('send', 'pageview', {
						'page': '/rsvp/thank-you',
						'title': 'Grand Opening RSVP Thank You'
					});
					
				},
				error: function() { 
					showError();
					
					if( typeof ga != 'undefined' ) ga('send', 'pageview', {
						'page': '/rsvp/error',
						'title': 'Grand Opening RSVP Error'
					});
					
				}
			})
			
			return false;	
		});
	
});