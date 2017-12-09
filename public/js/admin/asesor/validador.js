$(document).ready(function(){
	$("#asesorCreate").validate({
  		rules: {
		    user: "required",
		    emailUser: {
				required: true,
				email: true
    		}
  		},
		messages: {
			user: "Please specify your name",
			emailUser: {
				required: "We need your email address to contact you",
				email: "Your email address must be in the format of name@domain.com"
			}
		}
	});
});
