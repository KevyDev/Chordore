document.addEventListener("DOMContentLoaded", () => {
	login_signup = {};
	login_signup.form = document.getElementById('form-login-signup');
	login_signup.form_inputs = login_signup.form.querySelectorAll('.form-input');

	// Evento onsubmit en el form 
	login_signup.onSubmit = function (event) {
		event.preventDefault();
		var data = '';
		var count = 0;
		login_signup.form_inputs.forEach(input => {
			count++;
			if (count > 1) {
				data += '&';
			}
			data += input.name + '=' + input.value;
		});
		app.ajaxPetition(login_signup.form.action, login_signup.form.method, data, login_signup.renderData);
	}

	// Recibir los datos
	login_signup.renderData = function (data) {
		if (data.state == 1) {
			window.location.assign(data.redirect);
		} else {
			document.getElementById('error-warn-text').innerHTML = data.response;
		}
	}

	// Evento onsubmit en el form 
	if (login_signup.form) {
		login_signup.form.addEventListener('submit', login_signup.onSubmit);
	}
});