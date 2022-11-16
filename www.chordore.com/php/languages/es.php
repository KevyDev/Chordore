<?php
	
	if(isset($language)) {
	
		$language['MONTHS'] = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
		$language['DAYS'] = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");
		
		$language['JOINED'] = "Se uni&oacute;";
		$language['MOMENT'] = "hace un momento";
		
		$language['SESSIONISSET'] = "Ya hay una sesi&oacute;n activa.";

		$language['NEXT'] = "Siguiente";
		$language['REGISTER'] = "Registrarme";
		$language['LOGIN'] = "Iniciar Sesi&oacute;n";
		$language['LOGOUT'] = "Cerrar Sesi&oacute;n";
		$language['NAME'] = "Nombre Completo";
		$language['USERNAME'] = "Nombre de Usuario";
		$language['EMAIL'] = "Correo Electr&oacute;nico";
		$language['BIO'] = "Biograf&iacute;a";
		$language['LOCATION'] = "Locaci&oacute;n";
		$language['LINK'] = "Enlace";
		$language['PASSWORD'] = "Contrase&ntilde;a";
		$language['REPASSWORD'] = "Confirmar Contrase&ntilde;a";
		$language['HOMETEXT'] = "Reg&iacute;strate para ver las creaciones de tus amigos.";

		$language['OR'] = "O";
		$language['EXAMPLECOMP'] = "Ej";
		$language['HAVEACCOUNT'] = "¿Ya tienes una cuenta?";
		$language['DONTHAVEACCOUNT'] = "¿No tienes cuenta?";
		$language['FORGOTPASSWORD'] = "¿Olvidaste la contrase&ntilde;a?";
		$language['RESETPASSWORD'] = "Restablecer la contrase&ntilde;a";
		$language['SEARCHBYUSERNAME'] = "Buscar tu cuenta por tu nombre de usuario.";
		$language['SEARCHBYEMAIL'] = "Buscar tu cuenta por tu correo electr&oacute;nico.";
		$language['SEARCHACCOUNT'] = "Buscar Cuenta";

		$language['ENTERFULLNAME'] = "Debes ingresar tu nombre completo.";
		$language['ENTERUSERNAME'] = "Debes ingresar un nombre de usuario.";
		$language['ENTEREMAIL'] = "Debes ingresar un correo electr&oacute;nico.";
		$language['ENTERPASSWORD'] = "Debes ingresar una contrase&ntilde;a.";
		$language['ENTERREPASSWORD'] = "Debes confirmar la contrase&ntilde;a.";
		$language['ENTERVALIDEMAIL'] = "Debes ingresar un correo electr&oacute;nico v&aacute;lido.";
		$language['ENTERVALIDUSERNAME'] = "Debes ingresar un nombre de usuario v&aacute;lido.";
		$language['ENTERRESETEMAIL'] = "Debes ingresar el correo electr&oacute;nico adjuntado a tu cuenta.";
		$language['ENTERRESETEUSERNAME'] = "Debes ingresar el nombre de usuario adjuntado a tu cuenta.";
		$language['NAMEMAX'] = "Debe ingresar un nombre completo con un m&aacute;ximo de ".$this->fullNameMaxC." car&aacute;cteres.";
		$language['USERNAMEMAX'] = "Debe ingresar un nombre de usuario con un m&aacute;ximo de ".$this->usernameMaxC." car&aacute;cteres.";
		$language['EMAILMAX'] = "Debe ingresar un correo electr&oacute;nico con un m&aacute;ximo de ".$this->emailMaxC." car&aacute;cteres.";
		$language['PASSWORDMAX'] = "Debe ingresar una contrase&ntilde;a con un m&aacute;ximo de ".$this->passwordMaxC." car&aacute;cteres.";
		$language['BIOMAX'] = "Debe ingresar una biograf&iacute;a con un m&aacute;ximo de ".$this->bioMaxC." car&aacute;cteres.";
		$language['NAMEMIN'] = "Debe ingresar un nombre completo con un m&iacute;nimo de ".$this->fullNameMinC." car&aacute;cter.";
		$language['USERNAMEMIN'] = "Debe ingresar un nombre de usuario con un m&iacute;nimo de ".$this->usernameMinC." car&aacute;cteres.";
		$language['EMAILMIN'] = "Debe ingresar un correo electr&oacute;nico con un m&iacute;nimo de".$this->emailMinC."3 car&aacute;cteres.";
		$language['PASSWORDMIN'] = "Debe ingresar una contrase&ntilde;a con un m&iacute;nimo de ".$this->passwordMinC." car&aacute;cteres.";
		$language['BIOMIN'] = "Debe ingresar una biograf&iacute;a con un m&iacute;nimo de ".$this->bioMinC." car&aacute;cteres.";
		$language['PASSWORDNOTIGUAL'] = "Las contrase&ntilde;as no coinciden.";
		$language['USERNAMEEXIST'] = "El nombre de usuario ingresado ya existe en la base de datos.";
		$language['EMAILEXIST'] = "El correo electr&oacute;nico ingresado ya existe en la base de datos.";
		$language['USERNAMENOEXIST'] = "El nombre de usuario ingresado no existe en la base de datos.";
		$language['EMAILNOEXIST'] = "El correo electr&oacute;nico ingresado no existe en la base de datos.";
		$language['PASSWORDNOTIS'] = "La contrase&ntilde;a ingresada no coincide con la base de datos.";
		$language['BAN'] = "Su cuenta ha sido baneada temporalmente.";
		$language['CHANGELANGUAGE'] = "Cambiar Lenguaje";
		$language['ERROR'] = "Ha ocurrido un error en el servidor.";
		$language['USERNOEXIST'] = "El usuario no existe en la base de datos.";
		$language['NOFOLLOWERS'] = "No tiene seguidores.";
		$language['NOFOLLOWING'] = "No sigue a nadie.";

		$language['HOME'] = "Inicio";
		$language['EXPLORE'] = "Explorar";
		$language['NOTIFICATIONS'] = "Notificaciones";
		$language['CONVERSATIONS'] = "Conversaciones";
		$language['PROFILE'] = "Perfil";
		$language['CONFIGURATION'] = "Configuraci&oacute;n";
		$language['SPANEL'] = "Panel de Estad&iacute;sticas";
		$language['VIEW'] = "Ver";
		$language['EDITPROFILE'] = "Editar Perfil";
		$language['FOLLOW'] = "Seguir";
		$language['UNFOLLOW'] = "Dejar de Seguir";
		$language['ADDTOFRIENDS'] = "A&ntilde;adir a Amigos";
		$language['FRIENDS'] = "Amigos";
		$language['PUBLIC'] = "P&uacute;blico";
		$language['PRIVATE'] = "Privado";
		$language['WAITINGRESPONSE'] = "Esperando respuesta...";
		$language['CHAT'] = "Charla";
		$language['BLOCK'] = "Bloquear";
		$language['BLOCKED'] = "Bloqueado";
		$language['REPORT'] = "Reportar";

		$language['FOLLOWING'] = "Siguiendo";
		$language['FOLLOWERS'] = "Seguidores";
		$language['POSTS'] = "Publicaciones";
		$language['CREATIONS'] = "Creaciones";

		$language['POSTCOMPOSE'] = "Escribe una publicaci&oacute;n...";
		$language['POSTENV'] = "Publicar";
		$language['POSTNOTFOUND'] = "Publicaci&oacute;n no encontrada, puede que ha sido eliminada o ha ocurrido un error.";
		$language['POSTMAXC'] = "Debes ingresar un texto con un m&iacute;nimo de ".$this->postComposeMaxC." car&aacute;cteres.";
		$language['POSTISNULL'] = "Debes ingresar un texto.";
		
		$language['NOPOSTS'] = "Por ahora no hay publicaciones.";
		$language['NOMOREPOSTS'] = "No hay m&aacute;s publicaciones.";
		$language['SOMEISWRONG'] = "Algo est&aacute; mal aqu&iacute;.";

		$language['FORMATSNOTSUPPORTED'] = "El formato de la imagen no es soportado.";
		$language['IMAGEERROR'] = "Ha ocurrido un error guardando la imagen.";

		$language['SAVECHANGES'] = "Guardar Cambios";

		function languageTranscYears($years) {
			if($years == 1) {
				return "hace un a&ntilde;o";
			} else {
				return "hace ".$years." a&ntilde;os";
			}
		}

		function languageTranscMonths($months) {
			if($months == 1) {
				return "hace un mes";
			} else {
				return "hace ".$months." meses";
			}
		}

		function languageTranscDays($days) {
			if($days == 1) {
				return "hace un d&iacute;a";
			} else {
				return "hace ".$days." d&iacute;as";
			}
		}

		function languageTranscHours($hours) {
			if($hours == 1) {
				return "hace una hora";
			} else {
				return "hace ".$hours." horas";
			}
		}

		function languageTranscMinutes($minutes) {
			if($minutes == 1) {
				return "hace un minuto";
			} else {
				return "hace ".$minutes." minutos";
			}
		}

	}

?>