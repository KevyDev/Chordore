document.addEventListener("DOMContentLoaded", () => {

	var formLoginSignup = document.getElementById('form-login-signup');

	formLoginSignup.addEventListener("submit", function(event) {
		event.preventDefault();
		var parameters = {};
		var name = document.getElementById('form-reset-password-input').name;
		parameters[name] = document.getElementById('form-reset-password-input').value;
		ajaxPetition('php/password_reset.php', JSON.stringify(parameters), function(data) {
			var data = JSON.parse(data);
			if(data.state == 1) {
				window.location.assign('login');
			} else if(data.state == 0) {
				document.getElementById('error-on-form').innerHTML = data.response;
			}
		});
	});

});