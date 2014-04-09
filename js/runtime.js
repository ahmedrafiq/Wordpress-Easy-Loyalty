jQuery(document).ready(function() {
	jQuery("#ss_le_register").validate({
		rules: {
			firstName: "required",
			lastName: "required",
			card_number: {
				required: true,
				minlength: 5
			},
			customer_password: {
				required: true,
				minlength: 6
			},
			customer_password2: {
				required: true,
				minlength: 6,
				equalTo: "#customer_password"
			},
			email: {
				required: true,
				email: true
			},
			email2: {
				required: true,
				email: true,
				equalTo: "#email"
			}
		},
		messages: {
			firstname: "Please enter your first name",
			lastname: "Please enter your last name",
			username: {
				required: "Please enter a card number",
				minlength: "Your card number must consist of at least 5 characters"
			},
			password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 6 characters long"
			},
			confirm_password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 6 characters long",
				equalTo: "Please enter the same password as above"
			},
			email: {
				required: "Please enter a valid email address",
				equalTo: "Please enter the same email as above"
			}
		}
	});
});
