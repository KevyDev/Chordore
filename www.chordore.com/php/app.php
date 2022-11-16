<?php 

	require_once 'dbconnection.php';

	// Declaracion de funciones y generales
	date_default_timezone_set('America/Havana');
	session_start();

	class App extends DBConnection {
		public function __construct() {
			// Requisitos para crear una cuenta
			$this->fullNameMinC = 1;
			$this->fullNameMaxC = 30;
			$this->usernameMinC = 3;
			$this->usernameMaxC = 20;
			$this->emailMinC = 3;
			$this->emailMaxC = 50;
			$this->passwordMinC = 8;
			$this->passwordMaxC = 50;
			$this->bioMinC = 0;
			$this->bioMaxC = 1024;
			$this->locationMinC = 0;
			$this->locationMaxC = 255;
			$this->linkMinC = 0;
			$this->linkMaxC = 255;

			// Otros requisitos 
			$this->followsLimitPerDay = 500;

			// Requisitos para una publicacion y fotos
			$this->postComposeMaxC = 512;
			$this->postComposeMaxImgs = 4;
			$this->imgFormats = '.jpg, .png, .jpeg, .gif';
			$this->imgFormatsArray = array('image/png', 'image/jpeg', 'image/gif');
			$this->bannersMinResolution = array('width'=>320, 'height'=>64);
			$this->imgMaxPixels = 1280;
			
			// Urls generales
			$this->url = 'https://'.$_SERVER['SERVER_NAME'].'/';
			$this->filesLocation = 'files/';

			// Personalizando el usuario
			$this->language = $this->selectLanguage(); 
			$this->deviceInfo = $this->getDeviceInfo();
			$this->deviceIp = $this->getDeviceIp();
			$this->page = array();
			$this->page['name'] = '';
			$this->page['title'] = 'Chordore LLC';
			$this->page['scripts_v'] = '1';
			$this->page['scripts'] = array('app.js');
			$this->page['stylesh_v'] = '1';
			$this->page['stylesh'] = array('icons.css', 'style.css');

			// Coneccion a la base de datos
			$this->DBConnection = $this->DBConnect('localhost', 'chordore', 'root', '', 'utf8mb4');

			// Redireccionar a HTTPS
			if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off') {
				header('location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
				die();
			}

			// Iniciando la cuenta si hay una sesion activa
			if(isset($_SESSION['sessions'])) {
				$this->comprobeSessions();
				if(count($_SESSION['sessions']) > 0) {
					$session = $this->selectSessionActive();
					if($session) {
						$user = $this->selectUserFromSession($session);
						if($user) {
							$this->user = $this->userConfig($user['id'], $session);			
							if($this->user) {
								$this->userLastActivity();
							} else {
								$this->userLogout();
							}
						}
					}
				}
			} else {
				$_SESSION['sessions'] = array();
			}
		}

		/*********************************************************************/
		/*****                Funciones de personalizacion               *****/
		/*********************************************************************/

		// Obtener el ip del dispositivo del usuario
		private function getDeviceIp() { 
			if(getenv('HTTP_CLIENT_IP')) {
				$ip = getenv('HTTP_CLIENT_IP');
			} elseif(getenv('HTTP_X_FORWARDED_FOR')) {
				$ip = getenv('HTTP_X_FORWARDED_FOR');
			} elseif(getenv('HTTP_X_FORWARDED')) {
				$ip = getenv('HTTP_X_FORWARDED');
			} elseif(getenv('HTTP_FORWARDED_FOR')) {
				$ip = getenv('HTTP_FORWARDED_FOR');
			} elseif(getenv('HTTP_FORWARDED')) {
				$ip = getenv('HTTP_FORWARDED');
			} else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			return $ip;
		}

		// Obtener la informacion del dispositivo del usuario
		private function getDeviceInfo() { 
			$info = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : NULL;
			return $info;
		}

		// Funcion que selecciona el lenguaje del usuario
		public function selectLanguage() {
			if(isset($_SESSION['lang'])) {
				$userLang = $_SESSION['lang'];
			} else {
				$userLang = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : 'en';
				$_SESSION['lang'] = $userLang;
			}
			$language = array();
			switch($userLang) {
				case "es":
				$lang = 'es';
				require_once 'languages/es.php';
				break;
		
				case "en":
				$lang = 'en';
				require_once 'languages/en.php';
				break;

				case "pt":
				$lang = 'pt';
				require_once 'languages/pt.php';
				break;
		
				default:
				$lang = 'en';
				require_once 'languages/en.php';
				break;
			}
			$language['_LIST'] = array('es', 'en', 'pt');
			$language['_LIST2'] = array(
				'es'=>'Espa&ntilde;ol', 
				'en'=>'English', 
				'pt'=>'Portugu&ecirc;s'
			);
			$language['_SELECTED'] = $lang;
			return $language;
		}

		// Definir una pagina 
		public function setPage($page) {
			$this->page['name'] = $page;
			return true;
		}

		// Anadir variables a pagina 
		public function addToPage($var, $value) {
			$this->page[$var] = $value;
			return true;
		}

		// Verificar en que pagina esta el usuario
		public function detectPage($page) {
			return $page == $this->page['name'] ? true : false;
		}

		// Funcion para configurar la informacion del usuario con sesion activa
		public function userConfig($id, $session) {
			$query = $this->DBConnection->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
            $query->execute(['id'=>$id]);
            if($query->rowCount() == 0) {
                return false;
            } else {
				$user = $this->selectUserFromSession($session);
				if($user) {
					if($id == $user['id']) {
						$result2 = $this->selectUserInfo($user['id']);
						if($result2) {
							$result2['session'] = $session;
							return $result2;
						} else {
							return false;
						}
					} else {
						return false;
					}
				} else {
					return false;
				}
            }
		}

		/*********************************************************************/
		/*****               Registro e inicio de sesion                 *****/
		/*********************************************************************/

		// Funcion para registrarse 
		public function userSignup($name, $username, $email, $password, $re_password) {
			$comprobeName = $this->signupComprobeName($name);
			if($comprobeName['state'] == 0) return $comprobeName;
			
			$comprobeUsername = $this->signupComprobeUsername($username);
			if($comprobeUsername['state'] == 0) return $comprobeUsername;
			
			$comprobeEmail = $this->signupComprobeEmail($email);
			if($comprobeEmail['state'] == 0) return $comprobeEmail;
			
			$comprobePassword = $this->signupComprobePassword($password);
			if($comprobePassword['state'] == 0) return $comprobePassword;
			
			$comprobeRePassword = $this->signupComprobeRePassword($password, $re_password);
			if($comprobeRePassword['state'] == 0) return $comprobeRePassword;
			
            $pass_hash = $this->hashPassword($password);
            $token = $this->generateToken();
			$register = $this->DBConnection->prepare("INSERT INTO users (name, username, email, phone, password, photo_id, banner_id, token, bio, location, verified, joined_date, last_activity, ban) VALUES (:name, :username, :email, :phone, :password, :photo_id, :banner_id, :token, :bio, :location, :verified, NOW(), NOW(), :ban)");
			$register->execute(['name'=>$name, 'username'=>$username, 'email'=>$email, 'phone'=>'', 'password'=>$pass_hash, 'photo_id'=>0, 'banner_id'=>0, 'token'=>$token, 'bio'=>'', 'location'=>'', 'verified'=>0, 'ban'=>'']);
			$id = $this->selectIdFromUsername($username);
			if($id) {
				$token = $this->addSessionDB($id);
				$this->setSession($token);
				$this->user = $this->userConfig($id, $token);			
				$this->insertLog('set_name', 0, $name);
				$this->insertLog('set_username', 0, $username);
				$this->insertLog('set_email', 0, $email);
				$this->insertLog('set_pass', 0);
				return array('state'=>1);
            } else {
				return array('state'=>0, 'response'=>$this->language['ERROR']);
            }
		}
		
		// Funcion que aprueba el nombre ingresado por el usuario
		public function signupComprobeName($name) {
			if($this->isNull($name)) return array('state'=>0, 'response'=>$this->language['ENTERFULLNAME']);
			if($this->minC($this->fullNameMinC, $name)) return array('state'=>0, 'response'=>$this->language['NAMEMIN']);
			if($this->maxC($this->fullNameMaxC, $name)) return array('state'=>0, 'response'=>$this->language['NAMEMAX']);
			return array('state'=>1);
		}

		// Funcion que aprueba el nombre de usuario ingresado por el usuario
		public function signupComprobeUsername($username) {
			if($this->isNull($username)) return array('state'=>0, 'response'=>$this->language['ENTERUSERNAME']);
			if($this->minC($this->usernameMinC, $username)) return array('state'=>0, 'response'=>$this->language['USERNAMEMIN']);
			if($this->maxC($this->usernameMaxC, $username)) return array('state'=>0, 'response'=>$this->language['USERNAMEMAX']);
			if($this->comprobeUsername($username)) return array('state'=>0, 'response'=>$this->language['ENTERVALIDUSERNAME']);
			if($this->verifyUsernameExist($username)) return array('state'=>0, 'response'=>$this->language['USERNAMEEXIST']);
			return array('state'=>1);
		}

		// Funcion que aprueba el correo ingresado por el usuario
		public function signupComprobeEmail($email) {
			if($this->isNull($email)) return array('state'=>0, 'response'=>$this->language['ENTEREMAIL']);
			if($this->minC($this->emailMinC, $email)) return array('state'=>0, 'response'=>$this->language['EMAILMIN']);
			if($this->maxC($this->emailMaxC, $email)) return array('state'=>0, 'response'=>$this->language['EMAILMAX']);
			if($this->comprobeEmail($email)) return array('state'=>0, 'response'=>$this->language['ENTERVALIDEMAIL']);
			if($this->verifyEmailExist($email)) return array('state'=>0, 'response'=>$this->language['EMAILEXIST']);
			return array('state'=>1);
		}

		// Funcion que aprueba la contrasena ingresada por el usuario
		public function signupComprobePassword($password) {
			if($this->isNull($password)) return array('state'=>0, 'response'=>$this->language['ENTERPASSWORD']);
			if($this->minC($this->passwordMinC, $password)) return array('state'=>0, 'response'=>$this->language['PASSWORDMIN']);
			if($this->maxC($this->passwordMaxC, $password)) return array('state'=>0, 'response'=>$this->language['PASSWORDMAX']);
			return array('state'=>1);
		}

		// Funcion que aprueba la confirmacion de la contrasena ingresada por el usuario
		public function signupComprobeRePassword($password, $re_password) {
			if($this->isNull($re_password)) return array('state'=>0, 'response'=>$this->language['ENTERREPASSWORD']);
			if($this->verifyTexts($password, $re_password)) return array('state'=>0, 'response'=>$this->language['PASSWORDNOTIGUAL']);
			return array('state'=>1);
		}
		
		// Funcion para iniciar sesion 
		public function userLogin($username, $password) {
            if($this->isNull($username)) return array('state'=>0, 'response'=>$this->language['ENTERUSERNAME']);
			if(!$this->verifyUsernameExist($username)) return array('state'=>0, 'response'=>$this->language['USERNAMENOEXIST']);
			if($this->isNull($password)) return array('state'=>0, 'response'=>$this->language['ENTERPASSWORD']);	
			$id = $this->selectIdFromUsername($username);
            if($id) {
            	if($this->comprobePassword($id, $password)) {
                    if($this->userIsBan($id)) {
                        return $this->language['BAN'];
					} else {
						$token = $this->addSessionDB($id);
						$this->setSession($token);
               			return array('state'=>1);
               		}
            	} else {
                	return array('state'=>0, 'response'=>$this->language['PASSWORDNOTIS']);
            	}
            } else {
                return array('state'=>0, 'response'=>$this->language['ERROR']);
            }
		}

		// Funcion para cerrar sesion
		public function userLogout() {
			$session_active = $this->selectSessionActive();
			$this->closeSession($session_active);
            unset($this->user);	
            header('location: '.$this->url);
		}

		/*********************************************************************/
		/*****                      Editar Cuenta                        *****/
		/*********************************************************************/
		public function userEdit($name, $username, $email, $bio, $location, $link, $banner, $photo) {
			if($photo) {
				$image = array('name'=>$photo['name'], 'type'=>$photo['type'], 'tmp_name'=>$photo['tmp_name'], 'error'=>$photo['error'], 'size'=>$photo['size']);
				if($image['error'] == 1) {
					return array('state'=>0, 'response'=>$this->language['IMAGEERROR']);				
				} else {
					$img = $this->createFileImg($image, true);
					if($img['state'] == 0) {
						return array('state'=>0, 'response'=>$img['response']);
					} else {
						$photo_fl = $img['img'];
					}
				}
			}
			if($banner) {
				$image = array('name'=>$banner['name'], 'type'=>$banner['type'], 'tmp_name'=>$banner['tmp_name'], 'error'=>$banner['error'], 'size'=>$banner['size']);
				if($image['error'] == 1) {
					return array('state'=>0, 'response'=>$this->language['IMAGEERROR']);				
				} else {
					$img = $this->createFileImg($image);
					if($img['state'] == 0) {
						return array('state'=>0, 'response'=>$img['response']);
					} else {
						$banner_fl = $img['img'];
					}
				}
			}
			if($name !== $this->user['name']) {
				$comprobeName = $this->signupComprobeName($name);
				if($comprobeName['state'] == 0) return $comprobeName;
				$name_ch = true;
			}

			if($username !== $this->user['username']) {
				$comprobeUsername = $this->signupComprobeUsername($username);
				if($comprobeUsername['state'] == 0) return $comprobeUsername;
				$username_ch = true;
			} 

			if($email !== $this->user['email']) {
				$comprobeEmail = $this->signupComprobeEmail($email);
				if($comprobeEmail['state'] == 0) return $comprobeEmail;
				$email_ch = true;
			} 
			
			if($bio !== $this->user['bio']) {
				$bio = preg_replace(array('/  /', '/  /'), array(' ', ' '), trim($bio));
				if($this->maxC($this->bioMaxC, $bio)) return array('state'=>0, 'response'=>$this->language['BIOMAX']);
				if($this->minC($this->bioMinC, $bio)) return array('state'=>0, 'response'=>$this->language['BIOMIN']);
				$bio_ch = true;
			}

			if($location !== $this->user['location']) {
				$location = preg_replace(array('/  /', '/  /'), array(' ', ' '), trim($location));
				if($this->maxC($this->locationMaxC, $location)) return array('state'=>0, 'response'=>$this->language['LOCATIONMAX']);
				if($this->minC($this->locationMinC, $location)) return array('state'=>0, 'response'=>$this->language['LOCATIONMIN']);
				$location_ch = true;
			}

			if($link !== $this->user['link']) {
				$link = preg_replace('/ /', '', trim($link));
				if($this->maxC($this->linkMaxC, $link)) return array('state'=>0, 'response'=>$this->language['LINKMAX']);
				if($this->minC($this->linkMinC, $link)) return array('state'=>0, 'response'=>$this->language['LINKMIN']);
				$link_ch = true;
			}

			if((isset($photo_fl) || isset($banner_fl)) && !isset($this->FTPConnection)) $this->FTPConnection = $this->FTPConnect();
			if(isset($photo_fl)) { 
				$photo_id = $this->saveImg($photo_fl);
				$this->insertLog('set_photo', $photo_id);
				$query = $this->DBConnection->prepare('UPDATE users SET photo_id = :photo_id WHERE id = :user_id');
				$query->execute(['photo_id'=>$photo_id, 'user_id'=>$this->user['id']]);
			}
			if(isset($banner_fl)) { 
				$banner_id = $this->saveImg($banner_fl);
				$this->insertLog('set_banner', $banner_id);
				$query = $this->DBConnection->prepare('UPDATE users SET banner_id = :banner_id WHERE id = :user_id');
				$query->execute(['banner_id'=>$banner_id, 'user_id'=>$this->user['id']]);
			}
			if(isset($this->FTPConnection)) $this->FTPDisconnect();
			if(isset($name_ch)) $this->insertLog('set_name', 0, $name);
			if(isset($username_ch)) $this->insertLog('set_username', 0, $username);
			if(isset($email_ch)) $this->insertLog('set_email', 0, $email);
			if(isset($bio_ch)) $this->insertLog('set_bio', 0, $bio);
			if(isset($location_ch)) $this->insertLog('set_location', 0, $bio);
			if(isset($link_ch)) $this->insertLog('set_link', 0, $bio);
			$query = $this->DBConnection->prepare("UPDATE users SET name = :name, username = :username, email = :email, bio = :bio, location = :location, link = :link WHERE id = :user_id");
			$query->execute(['name'=>$name, 'username'=>$username, 'email'=>$email, 'bio'=>$bio, 'location'=>$location, 'link'=>$link, 'user_id'=>$this->user['id']]);
			$this->user['username'] = $username;
			return array('state'=>1);
		}

		/*********************************************************************/
		/*****                         Sesiones                          *****/
		/*********************************************************************/

		// Crea una sesion en la base de datos
		private function addSessionDB($id) {
			$token = $this->generateToken();
			$query2 = $this->DBConnection->prepare("INSERT INTO users_sessions (token, user_id, device_ip, device_info, start_date, end_date, active, user_ended) VALUES (:token, :user_id, :device_ip, :device_info, NOW(), '', 1, 0)");
			$query2->execute(['token'=>$token, 'user_id'=>$id, 'device_ip'=>$this->deviceIp, 'device_info'=>$this->deviceInfo]);
			return $token;
		}

		// Desactiva la sesion de la base de datos
		private function removeSessionDB($token, $byUser) {
			$query2 = $this->DBConnection->prepare("UPDATE users_sessions SET end_date = NOW(), active = 0, user_ended = :byuser WHERE token = :token");
			$query2->execute(['byuser'=>$byUser, 'token'=>$token]);
			return true;
		} 

		// Selecciona una sesion de la base de datos
		public function selectSessionDB($token) {
			$query = $this->DBConnection->prepare("SELECT * FROM users_sessions WHERE token = :token ORDER BY start_date DESC LIMIT 1");
			$query->execute(['token'=>$token]);
			if($query->rowCount() == 0) {
				return false;
			} else {
				$result = $query->fetch();
				$token = $result['token'];
				return $token;
			}
		}

		// Selecciona una sesion de las cookies
		public function selectSession($token) {
			$sessions = $_SESSION['sessions'];
			foreach($sessions as $session) {
				if($sesion['token'] == $token) {
					$selected = 1;
				} 
			}
			if(isset($selected)) {
				return true;
			} else {
				return false;
			}
		}

		// Selecciona o crea una sesion de los cookies
		private function setSession($token) {
			$result = array();
			$sessions = $_SESSION['sessions'];
			foreach($sessions as $session) {
				if($sesion['token'] == $token) {
					$session['active'] == 1;
					$selected = 1;
				} else {
					$session['active'] == 0;
				}
				$result[] = $session;
			}
			if(!isset($selected)) {
				$result[] = array('token'=>$token, 'active'=>1);
			}
			$_SESSION['sessions'] = $result;
		} 

		// Cierra una sesion de los cookies
		private function closeSession($token) {
			$result = array();
			$sessions = $_SESSION['sessions'];
			foreach($sessions as $session) {
				if($session['token'] == $token) {
					$session['active'] = 0;
				}
				$result[] = $session;
			}
			$_SESSION['sessions'] = $result;
		} 

		// Elimina una sesion de los cookies
		private function removeSession($token) {
			$result = array();
			$sessions = $_SESSION['sessions'];
			foreach($sessions as $session) {
				if($session['token'] !== $token) {
					$result[] = $session;
				}
			}
			$_SESSION['sessions'] = $result;
		} 

		// Selecciona la sesion activa de los cookies
		private function selectSessionActive() {
			$result = false;
			$sessions = $_SESSION['sessions'];
			foreach($sessions as $session) {
				if($session['active'] == 1) {
					$session_db = $this->selectSessionDB($session['token']);
					if($session_db) {
						$result = $session_db;
					}
				}
			}
			return $result;
		}

		// Hace un recorrido por las sesiones de las cookies y comprueba su actividad en la base de datos
		private function comprobeSessions() {
			$result = array();
			$sessions = $_SESSION['sessions'];
			foreach($sessions as $session) {
				$session_db = $this->selectSessionDB($session['token']);
				if($session_db) {
					$result[] = $session;
				}
			}
			$_SESSION['sessions'] = $result;
		}

		// Selecciona al usuario de una sesion
		private function selectUserFromSession($token) {
			$query = $this->DBConnection->prepare("SELECT * FROM users_sessions WHERE token = :token LIMIT 1");
			$query->execute(['token'=>$token]);
			if($query->rowCount() == 0) {
				return false;
			} else {
				$result = $query->fetch();
				$final_result = array('id'=>$result['user_id'], 'session'=>$token);
				return $final_result;
			}
		}

		// Saber si esta iniciada la sesion para redireccionar
		public function userNotLogued($url = '') {
			if(isset($this->user)) {
				header('location: '.$this->url.$url);
				die();
			}
		}

		// Saber si no esta iniciada la sesion para redireccionar
		public function userLogued($url = 'login') {
			if(!isset($this->user)) {
				header('location: '.$this->url.$url);
				die();
			}
		}

		/*********************************************************************/
		/******                        Usuarios                        *******/
		/*********************************************************************/

		// Seleccionar la informacion de un usuario mediante el id
		public function selectUserInfo($id) {
			$query = $this->DBConnection->prepare("SELECT * FROM users WHERE id = :id");
			$query->execute(['id'=>$id]);
			if($query->rowCount() == 0) {
				return false;
			} else {
				$result = $query->fetch();
				$result['photo'] = $this->selectFile($result['photo_id']);
				$result['banner'] = $this->selectFile($result['banner_id']);
				$result2 = array(
					"id"=>$result['id'],
					"name"=>$result['name'],
					"username"=>$result['username'],
					"email"=>$result['email'],
					"token"=>$result['token'],
					"photo"=>$result['photo'],
					"photo_id"=>$result['photo_id'],
					"banner"=>$result['banner'],
					"banner_id"=>$result['banner_id'],
					"bio"=>$result['bio'],
					"location"=>$result['location'],
					"link"=>$result['link'],
					"joined_date"=>$result['joined_date'],
					"ban"=>$result['ban'],
					"followers_num"=>$this->userFollowersNum($id),
					"followers_let"=>$this->formatNumsAndLetters($this->userFollowersNum($id)),
					"following_num"=>$this->userFollowingsNum($id),
					"following_let"=>$this->formatNumsAndLetters($this->userFollowingsNum($id)),
					"posts_num"=>$this->userPostsNum($id),
					"posts_let"=>$this->formatNumsAndLetters($this->userPostsNum($id))
				);
				return $result2;
			}
		}

		public function userDefault($username) {
			$result = array(
				"id"=>0,
				"name"=>'',
				"username"=>$username,
				"email"=>null,
				"token"=>'-',
				"photo"=>'default.png',
				"photo_id"=>0,
				"banner"=>'default.png',
				"banner_id"=>0,
				"bio"=>'',
				"location"=>'',
				"link"=>'',
				"joined_date"=>'',
				"ban"=>0,
				"followers_num"=>0,
				"followers_let"=>'0',
				"following_num"=>0,
				"following_let"=>'0',
				"posts_num"=>0,
				"posts_let"=>'0'
			);
			return $result;
		}
		
		// Cargar la informacion de un usuario por el nombre de usuario 
		public function userAccountLoad($username) {
			$id = $this->selectIdFromUsername($username);
			if($id == false) {
				return false;
			} else {	
				$userInfo = $this->selectUserInfo($id);
				if($userInfo == false) {
					return false;
				} else {
					if($id !== $this->user['id']) {
						$userInfo['user_following'] = $this->userFollowedBy($this->user['id'], $id) == 1 ? 'active' : 'inactive'; 
						$userInfo['user_friends'] = 'inactive';
						$userInfo['user_blocked'] = 'inactive';
					}
					return $userInfo;
				}
			}
		}

		// Verificar si un usuario esta baneado
		public function userIsBan($id) {
			$query = $this->DBConnection->prepare("SELECT * FROM users WHERE id = :id AND ban = 1");
			$query->execute(['id'=>$id]);
			if($query->rowCount() == 0) {
				return false;
			} else {
				return true;
			}
		}

		// Actualizar la actividad del usuario
		public function userLastActivity(){
            $query = $this->DBConnection->prepare("UPDATE users SET last_activity = NOW() WHERE id = :id");		
            $query->execute(['id'=>$this->user['id']]);
            $query2 = $this->DBConnection->prepare("UPDATE users_sessions SET last_activity = NOW() WHERE token = :token");		
            $query2->execute(['token'=>$this->user['session']]);
		}

		// Funcion que selecciona el id del usuario por su nombre de usuario
        public function selectIdFromUsername($username) {
			$query = $this->DBConnection->prepare("SELECT * FROM users WHERE username = :username");
			$query->execute(['username'=>$username]);
			if($query->rowCount() == 0) {
				return false;
			} else {
				$result = $query->fetch();
				return $result['id'];
			}
		}

		// Funcion que selecciona el id del usuario por su token
        public function selectIdFromToken($token) {
			$query = $this->DBConnection->prepare("SELECT * FROM users WHERE token = :token");
			$query->execute(['token'=>$token]);
			if($query->rowCount() == 0) {
				return false;
			} else {
				$result = $query->fetch();
				return $result['id'];
			}
		}
		
		// Comprobar la contrasena ingresada con la de un usuario
		public function comprobePassword($id, $password) {
			$query = $this->DBConnection->prepare("SELECT password FROM users WHERE id = :id");
			$query->execute(['id'=>$id]);
			if($query->rowCount() == 0) {
				return false;
			} else {
				$result = $query->fetch();
				if(password_verify($password, $result['password'])) {
					return true;
				} else {
					return false;
				}
			}
		}

		/*********************************************************************/
		/*****                       Otras funciones                     *****/
		/*********************************************************************/

		// Verificar si una cadena de texto esta vacia
		public function isNull($value) {
			if(strlen(trim($value)) < 1) {
				return true;
			}  else {
				return false;
			}
		}

		// Genera un token
		public function generateToken() {
			$token = md5(uniqid(mt_rand(), false));
			return $token;
		}

		// Encripta una contrasena
		public function hashPassword($password) {
			$hash = password_hash($password, PASSWORD_DEFAULT);
			return $hash;
		}

		// Comprueba si una cadena de texto se pasa del maximo de caracteres
		public function maxC($max, $value) {
			if(strlen(trim($value)) > $max) {
				return true;
			} else {
				return false;
			}
		}

		// Comprueba si una cadena de texto es menor del minimoo de caracteres
		public function minC($min, $value) {
			if(strlen(trim($value)) < $min) {
				return true;
			} else {
				return false;
			}
		}

		// Convertir numeros grandes a abreviaciones con letras
		public function formatNumsAndLetters($number) {
			if(is_int($number)) {
				$result = $number;
				if($number >= 1000) {
					$result = round($number / 1000, 2).'K';
				}
				if($number >= 1000000) {
					$result = round($number / 1000000, 2).'M';
				}
				if($number >= 1000000000) {
					$result = round($number / 1000000000, 2).'B';
				}
				if($number >= 1000000000000) {
					$result = round($number / 1000000000000, 2).'T';
				}
				return $result;
			} else {
				return false;
			}
		}

		// Convertir textos en enlaces 
		private function convertClickableLinks($text, $usertags = false) {
			$result = preg_replace(
				array(
					'/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))/', 
					// '/(^|[^a-zA-Z0-9_])@([a-zA-Z0-9_]+)/i', 
					'/(^|[^a-zA-Z0-9_])#([a-zA-Z0-9_]+)/i'), 
				array(
					'<a href="redirect?url=$1" target="_blank">$1</a>', 
					// '$1<a href="users/$2">@$2</a>', 
					'$1<a href="explore/hashtags/$2">#$2</a>'
				), $text);
			if($usertags) {
				foreach($usertags as $username) {
					$id = $this->selectIdFromUsername($username);
					if($id) {
						$result = preg_replace('/(^|[^a-zA-Z0-9_])@('.$username.')/i', '$1<a href="users/$2">@$2</a>', $result);
					}
				}
			}
			return $result;
		}

		// Obtener una fecha
		public function getDate($date) {
			$date = date("Y/m/d", strtotime($date));
			return $date;
		}

		// Obtener una fecha con hora
		public function getDateTime($date) {
			$date = date("g:ia", strtotime($date));
			return $date;
		}

		// Obtener el tiempo transcurrido entre dos fechas en numeros
		public function transcTime($date) {
			$date1 = date_create(date($date));
			$date2 = date_create(date("Y-m-d H:i:s"));
			$interval = date_diff($date1, $date2);
			$transc = array();
			foreach($interval as $value) {
				$transc[] = $value;
			}
			return $transc;
		}

		// Obtener el timpo transcurrido entre dos fechas con palabras
		public function transcTimeLang($date) {
			$date1 = date_create(date($date));
			$date2 = date_create(date("Y-m-d H:i:s"));
			$interval = date_diff($date1, $date2);
			$transc = array();
			foreach($interval as $value) {
				$transc[] = $value;
			}
			if($transc[0] == 0) {
				if($transc[1] == 0) {
					if($transc[2] == 0) {
						if($transc[3] == 0) {
							if($transc[4] == 0) {
								$transc = $this->language['MOMENT'];
							} else {
								$transc = languageTranscMinutes($transc[4]);
							}
						} else {
							$transc = languageTranscHours($transc[3]);
						}
					} else {
						$transc = languageTranscDays($transc[2]);
					}
				} else {
					$transc = languageTranscMonths($transc[1]);
				}
			} else {
				$transc = languageTranscYears($transc[0]);
			}
			return $transc;
		}

		// Verificar si dos cadenas de texto son iguales
		public function verifyTexts($text1, $text2) {
			if(strcmp($text1, $text2) !== 0) {
				return true;
			} else {
				return false;
			}
		}
		
		// Comprobar si el nombre de usuario es valido
		public function comprobeUsername($username) {
			$filter = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890_.";
			for($i = 0; $i < strlen($username); $i = $i + 1) {
				if(strpos($filter, substr($username, $i, 1)) === false) {
					return true;
				}
			}
			return false;
		}

		// Comprobar si un correo electronico es valido
		public function comprobeEmail($email) {
			if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
				return false;
			} else {
				return true;
			}
		}

		// Verificar si un nombre de usuario existe en la base de datos
		public function verifyUsernameExist($username) {
            $query = $this->DBConnection->prepare("SELECT * FROM users WHERE username = :username");
            $query->execute(['username'=>$username]);
            if($query->rowCount() == 0) {
                return false;
            } else {
                return true;
            }
        }

		// Verificar si un correo electronico existe en la base de datos
		public function verifyEmailExist($email) {
			$query = $this->DBConnection->prepare("SELECT id FROM users WHERE email = :email");
			$query->execute(['email'=>$email]);
			if($query->rowCount() == 0) {
				return false;
			} else {
				return true;
			}
		}

		// Insertar un log
		private function insertLog($action, $object_id, $comment = '') {
			$query = $this->DBConnection->prepare("INSERT INTO logs (user_id, action, object_id, comment, datetime) VALUES (:user_id, :action, :object_id, :comment, NOW())");
			$query->execute(['user_id'=>$this->user['id'], 'action'=>$action, 'object_id'=>$object_id, 'comment'=>$comment]);
			return true;
		}

		/*********************************************************************/
		/******                        Archivos                        *******/
		/*********************************************************************/

		// Crear coneccion con el ftp
		private function FTPConnect() {
			$connection = ftp_connect('files.chordore.com');
			$login = ftp_login($connection, "chordore", "kevinsito") or die("ERROR ".$connection);
			ftp_pasv($connection, true);
			return $connection;
		}

		// Desconectar con el ftp
		private function FTPDisconnect() {
			ftp_close($this->FTPConnection);
			unset($this->FTPConnection);
			return true;
		}

		// Seleccionar un archivo de la base de datos
		public function selectFile($id) {
			$query = $this->DBConnection->prepare("SELECT * FROM files WHERE id = :id");
			$query->execute(['id'=>$id]);
			if($query->rowCount() == 0) {
				return false;
			} else {
				$result = $query->fetch(); 
				$result2 = array(
					'location'=>$result['location'], 
					'name'=>$result['name'], 
					'type'=>$result['type'], 
					'size'=>$result['size'], 
					'url'=>'https://files.chordore.com/files/image?sc='.$result['location'].'&file='.$result['name']
				);
				return $result2;
			}
		}

		// Formatear y guardar un archivo de tipo imagen
		private function createFileImg($image, $p1x1 = false) {
			if(in_array($image['type'], $this->imgFormatsArray)) {
				$temporal = $image['tmp_name'];
				switch($image['type']) {
					case 'image/png':
					$original = imagecreatefrompng($temporal);
					break; 

					case 'image/jpeg':
					$original = imagecreatefromjpeg($temporal);
					break; 

					case 'image/gif':
					$original = imagecreatefromgif($temporal);
					break;
				}
				$file_width = imagesx($original);
				$file_height = imagesy($original);
				if($p1x1) {
					$resolution = 500;
					$new_width = round(($resolution / $file_height) * $file_width);
					$new_height = round(($resolution / $file_height) * $file_height);
					$position_x =  round(($resolution / 2) - ($new_width / 2));
					$position_y = round(($resolution / 2) - ($new_height / 2));
					$copy = imagecreatetruecolor($resolution, $resolution);
				} else {
					$max_size = $file_width > $file_height ? $file_width : $file_height;
					$p = $max_size > $this->imgMaxPixels ? $this->imgMaxPixels / $max_size : 1;
					$new_width = round($file_width * $p);
					$new_height = round($file_height * $p);
					$position_x = 0;
       				$position_y = 0;
					$copy = imagecreatetruecolor($new_width, $new_height);
				}
				if($image['type'] == 'image/png' || $image['type'] == 'image/gif') {
					imagecolortransparent($copy, imagecolorallocatealpha($copy, 0, 0, 0, 127));
					imagealphablending($copy, true);
				}
				imagecopyresampled($copy, $original, $position_x, $position_y, 0, 0, $new_width, $new_height, $file_width, $file_height);
				return array('state'=>1, 'img'=>$copy);
			} else {
				return array('state'=>0, 'response'=>$this->language['FORMATSNOTSUPPORTED']);
			}
		}

		private function saveImg($img) {
			$token = $this->generateToken();
			$filename = $token.'.jpeg';
			$fileUrl = 'tmp/'.$filename;
			$location = 'files/imgs-scKHPFIBV/'.$filename;
			imagejpeg($img, $fileUrl, 50);
			ftp_put($this->FTPConnection, $location, $fileUrl, FTP_BINARY);
			$size = filesize($fileUrl);
			$query = $this->DBConnection->prepare('INSERT INTO files (location, name, type, size, user_id, upload_date) VALUES (:location, :name, :type, :size, :user_id, NOW())');
			$query->execute(['location'=>'KHPFIBV', 'name'=>$filename, 'type'=>'image/jpeg', 'size'=>$size, 'user_id'=>$this->user['id']]);
			$query2 = $this->DBConnection->prepare('SELECT id FROM files WHERE name = :filename');
			$query2->execute(['filename'=>$filename]);
			unlink($fileUrl);
			return $query2->fetch()['id'];
		}

		/*********************************************************************/
		/******                      Publicacione                      *******/
		/*********************************************************************/

		// Crear una publicacion
		public function postCompose($text, $images, $privacy) {
			$files = array();
			$text = trim(strip_tags($text));
			if($images) {
				for($index = 0; $index < count($images['name']); $index++) {
					$image = array(
						'name'=>$images['name'][$index], 
						'type'=>$images['type'][$index],
						'tmp_name'=>$images['tmp_name'][$index],
						'error'=>$images['error'][$index],
						'size'=>$images['size'][$index]
					);
					if($image['error'] == 1) {
						return array('state'=>0, 'response'=>$this->language['IMAGEERROR']);
					} else {
						$createImage = $this->createFileImg($image);
						if($createImage['state'] == 0) {
							return array('state'=>0, 'response'=>$createImage['response']);
						} else {
							$files[] = $createImage['img'];
						}
					}
				}
			} else {
				if($this->isNull($text)) {
					return array('state'=>0, 'response'=>$this->language['POSTISNULL']); 
				}
			}
			if($this->maxC($this->postComposeMaxC, $text)) {
				return array('state'=>0, 'response'=>$this->language['POSTMAXC']);
			}
			$privacy = ($privacy !== '0' && $privacy !== '1' && $privacy !== '2') ? 1 : $privacy;
			$token = $this->generateToken();
			$files_id = array();
			if(count($files) > 0 && !isset($this->FTPConnection)) $this->FTPConnection = $this->FTPConnect();
			foreach($files as $file) {
				$files_id[] = $this->saveImg($file);
			}
			if(isset($this->FTPConnection)) $this->FTPDisconnect();
			$images_id = json_encode($files_id);
			$query = $this->DBConnection->prepare("INSERT INTO posts (token, text, publication_date, images_id, privacy, user_id) VALUES (:token, :text, NOW(), :images_id, :privacy, :user_id)");
			$query->execute(['token'=>$token, 'text'=>$text, 'images_id'=>$images_id, 'privacy'=>$privacy, 'user_id'=>$this->user['id']]);
			$query2 = $this->DBConnection->prepare("SELECT id FROM posts WHERE user_id = :user_id ORDER BY id DESC LIMIT 1");
			$query2->execute(['user_id'=>$this->user['id']]);
			$result2 = $query2->fetch();
			$post_id = $result2['id'];
			$hashtags = $this->postGetHashtags($text);
			if($hashtags) {
				foreach($hashtags as $hashtag) {
					$query3 = $this->DBConnection->prepare("INSERT INTO posts_hashtags (hashtag, post_id, created_date) VALUES (:hashtag, :post_id, NOW())");
					$query3->execute(['hashtag'=>$hashtag, 'post_id'=>$post_id]);
				}
			}
			$usertags = $this->postGetUsertags($text);
			if($usertags) {
				foreach($usertags as $usertag) {
					$query4 = $this->DBConnection->prepare("INSERT INTO posts_usertags (usertag, post_id, created_date) VALUES (:usertag, :post_id, NOW())");
					$query4->execute(['usertag'=>$usertag, 'post_id'=>$post_id]);
				}
			}
			return array('state'=>1, 'post'=>$this->visualPost($this->selectPost($token)));
		}

		// Obtener hashtags de un texto
		public function postGetHashtags($text) {
			preg_match_all('/(^|[^a-zA-Z0-9_])#([a-zA-Z0-9_]+)/i', $text, $matched_hashtags);
			$hashtags = array();
			if(count($matched_hashtags[0]) > 0) {
				 foreach($matched_hashtags[0] as $match) {
					 $hashtags[] = preg_replace("/[^a-z0-9]+/i", "", $match);
				 }
				 return $hashtags;
			} else {
				 return false;
			}
		}

		// Obtener usertags de un texto
		public function postGetUsertags($text) {
			preg_match_all('/(^|[^a-zA-Z0-9_])@([a-zA-Z0-9_]+)/i', $text, $matched_usertags);
			$usertags = array();
			if(count($matched_usertags[0]) > 0) {
				 foreach($matched_usertags[0] as $match) {
					 $usertags[] = preg_replace("/[^a-z0-9]+/i", "", $match);
				 }
				 return $usertags;
			} else {
				 return false;
			}
		}

		// Seleccionar una publicacion
		public function selectPost($token) {
			$query = $this->DBConnection->prepare("SELECT * FROM posts WHERE token = :token LIMIT 1");
			$query->execute(['token'=>$token]);
			if($query->rowCount() == 0) {
				return false;
			} else {
				$q_result = $query->fetch();
				$result = $this->renderPost($q_result);
				return $result;
			}
		}

		public function areFriends($user_id_1, $user_id_2) {
			return false;
		}

		// Seleccionar publicaciones de un usuario por paginas
		public function selectPostsByUserAccount($username, $page) {
			$user_id = $this->selectIdFromUsername($username);
			if($user_id) {
				if($this->userPostsNum($user_id) == 0) {
					return array('state'=>3, 'response'=>$this->language['NOPOSTS'], 'actual_page'=>$page);
				} else {
					$elementsInPage = 15;
					$lastElement = ($page - 1) * $elementsInPage;
					$next_page = $page + 1;
					if($user_id == $this->user['id']) {
						$query = $this->DBConnection->prepare("SELECT * FROM posts WHERE user_id = :user_id AND deleted = 0 ORDER BY id DESC LIMIT ".$lastElement.", ".$elementsInPage);
					} else {
						if($this->areFriends($user_id, $this->user['id'])) {
							$query = $this->DBConnection->prepare("SELECT * FROM posts WHERE user_id = :user_id AND privacy != 0 AND deleted = 0 ORDER BY id DESC LIMIT ".$lastElement.", ".$elementsInPage);
						} else {
							$query = $this->DBConnection->prepare("SELECT * FROM posts WHERE user_id = :user_id AND privacy != 0 AND privacy != 2 AND deleted = 0 ORDER BY id DESC LIMIT ".$lastElement.", ".$elementsInPage);
						}
					}
					$query->execute(['user_id'=>$user_id]);
					if($query->rowCount() == 0) {
						return array('state'=>3, 'response'=>$this->language['NOMOREPOSTS'], 'actual_page'=>$page);
					} else {
						$result = array('state'=>1, 'posts'=>array(), 'response'=>'', 'actual_page'=>$page);
						while($post = $query->fetch(PDO::FETCH_ASSOC)) {
							$result['posts'][] = $this->renderPost($post);
						}
						if(count($result['posts']) < $elementsInPage) {
							$result['state'] = 3;
							$result['response'] = $this->language['NOMOREPOSTS'];
						} else {
							$result['next_page'] = $next_page;
						}
						return $result;
					}
				}
			} else {
				return array('state'=>3, 'response'=>$this->language['USERNOEXIST'], 'actual_page'=>$page);
			}
		}

		// Seleccionar publicaciones del home del usuario por paginas
		public function selectPostsByUserHome($page) {
			$elementsInPage = 15;
			$lastElement = ($page - 1) * $elementsInPage;
			$next_page = $page + 1;
			$follows = $this->userGetAllFollowing($this->user['id']);
			$following = "'0', '0'";
			foreach($follows as $id) {
				$following = $following.", '".$id."'";
			}
			$friends = "'0', '0'";
			$query = $this->DBConnection->prepare("SELECT * FROM posts WHERE user_id = :user_id AND deleted = 0 OR user_id IN ($following) AND privacy = 1 AND deleted = 0 OR user_id IN ($friends) AND privacy = 2 AND deleted = 0 ORDER BY id DESC LIMIT ".$lastElement.", ".$elementsInPage);
			$query->execute(['user_id'=>$this->user['id']]);
			if($query->rowCount() == 0) {
				if($page == 1) {
					return array('state'=>3, 'response'=>$this->language['NOPOSTS'], 'actual_page'=>$page);
				} else {
					return array('state'=>3, 'response'=>$this->language['NOMOREPOSTS'], 'actual_page'=>$page);
				}
			} else {
				$result = array('state'=>1, 'posts'=>array(), 'response'=>'', 'actual_page'=>$page);
				while($post = $query->fetch(PDO::FETCH_ASSOC)) {
					$result['posts'][] = $this->renderPost($post);
				}
				if(count($result['posts']) < $elementsInPage) {
					$result['state'] = 3;
					$result['response'] = $this->language['NOMOREPOSTS'];
				} else {
					$result['next_page'] = $next_page;
				}
				return $result;
			}
		}

		// Valorar un post dependiendo de la privacidad y el usuario que lo esta cargando 
		private function ratePostPrivacy($post, $user_id) {
			if($post['user_id'] == $user_id) {
				return true;
			} else {
				if($post['privacy'] == 0) {
					return false;
				} elseif($post['privacy'] == 1) {
					return true;
				} elseif($post['privacy'] == 3) {
					return false;
				} else {
					return false;
				}
			}
		}

		// Renderizar un post de la base de datos
		private function renderPost($post) {
			$images = array();
			$images_id = json_decode($post['images_id']);
			foreach($images_id as $image) {
				$images[] = $this->selectFile($image);
			}
			$result = array(
				'token'=>$post['token'],
				'text'=>preg_replace('/\<br(\s*)?\/?\>/i', '\n', $this->convertClickableLinks($post['text'], $this->getAllPostUsertags($post['id']))),
				'date'=>$this->getDate($post['publication_date']),
				'date_time'=>$this->getDateTime($post['publication_date']),
				'time_transc'=>$this->transcTimeLang($post['publication_date']),
				'images'=>$images,
				'privacy'=>$post['privacy'],
				'likes_num'=>$this->getPostLikes($post['id']),
				'comments_num'=>$this->getPostComments($post['id']),
				'user_liked'=>$this->postLikedBy($post['id'], $this->user['id']),
				'user_info'=>$this->selectUserInfo($post['user_id'])
			);
			$result['likes_let'] = $this->formatNumsAndLetters($result['likes_num']);		
			$result['comments_let'] = $this->formatNumsAndLetters($result['comments_num']);
			$result['liked_class'] = $result['user_liked'] == 1 ? 'selected' : '';
			return $result;
		}

		// Seleccionar los likes de una publicacion
		public function getPostLikes($id) {
			$query = $this->DBConnection->prepare("SELECT * FROM posts_likes WHERE post_id = :post_id AND active = 1");
			$query->execute(['post_id'=>$id]);
			$result = $query->rowCount();
			return $result;
		}

		// Seleccionar los comentarios de una publicacion
		public function getPostComments($id) {
			$query = $this->DBConnection->prepare("SELECT * FROM posts_comments WHERE post_id = :post_id AND deleted = 0");
			$query->execute(['post_id'=>$id]);
			$result = $query->rowCount();
			return $result;
		}

		// Seleccionar los hashtags de una publicacion
		public function getAllPostHashtags($id) {
			$query = $this->DBConnection->prepare("SELECT * FROM posts_hashtags WHERE post_id = :post_id");
			$query->execute(['post_id'=>$id]);
			$result = array();
			while($tag = $query->fetch()) {
				$result[] = $tag['hashtag'];
			}
			return $result;
		}

		// Seleccionar los usertags de una publicacion
		public function getAllPostUsertags($id) {
			$query = $this->DBConnection->prepare("SELECT * FROM posts_usertags WHERE post_id = :post_id");
			$query->execute(['post_id'=>$id]);
			$result = array();
			while($tag = $query->fetch()) {
				$result[] = $tag['usertag'];
			}
			return $result;
		}

		// Obtener el id de un post desde su token 
		public function postGetIdFromToken($token) {
			$query = $this->DBConnection->prepare("SELECT * FROM posts WHERE token = :token LIMIT 1");
			$query->execute(['token'=>$token]);
			if($query->rowCount() == 1) {
				$result = $query->fetch();
				return $result['id'];
			} else {
				return false;
			}
		}

		// Saber si un usuario le dio like a una publicacion
		public function postLikedBy($post_id, $user_id) {
			$query = $this->DBConnection->prepare("SELECT * FROM posts_likes WHERE post_id = :post_id AND user_id = :user_id AND active = 1");
			$query->execute(['post_id'=>$post_id, 'user_id'=>$user_id]);
			if($query->rowCount() == 0) {
				return false;
			} else {
				return true;
			}
			return $query->rowCount();
		}

		// Darle like a una publicacion
		public function postInteractLike($post_id, $user_id) {
			$query = $this->DBConnection->prepare("SELECT * FROM posts_likes WHERE post_id = :post_id AND user_id = :user_id");
			$query->execute(['post_id'=>$post_id, 'user_id'=>$user_id]);	
			if($query->rowCount() == 0) {
				$query2 = $this->DBConnection->prepare("INSERT INTO posts_likes (post_id, user_id, liked_date, active) VALUES (:post_id, :user_id, NOW(), 1)");
				$query2->execute(['post_id'=>$post_id, 'user_id'=>$user_id]);
				$this->insertLog('like', $post_id);
				return true;
			} else {
				$result = $query->fetch();
				if($result['active'] == 0) {
					$query2 = $this->DBConnection->prepare("UPDATE posts_likes SET active = 1 WHERE post_id = :post_id AND user_id = :user_id");
					$query2->execute(['post_id'=>$post_id, 'user_id'=>$user_id]);
					$this->insertLog('like', $post_id);
					return true;
				} else {
					return true;
				}
			}
		}

		// Quitarle el like a una publicacion
		public function postInteractDisLike($post_id, $user_id) {
			$query = $this->DBConnection->prepare("SELECT * FROM posts_likes WHERE post_id = :post_id AND user_id = :user_id");
			$query->execute(['post_id'=>$post_id, 'user_id'=>$user_id]);	
			if($query->rowCount() == 0) {
				return true;
			} else {
				$result = $query->fetch();
				if($result['active'] == 0) {
					return true;
				} else {
					$query2 = $this->DBConnection->prepare("UPDATE posts_likes SET active = 0 WHERE post_id = :post_id AND user_id = :user_id");
					$query2->execute(['post_id'=>$post_id, 'user_id'=>$user_id]);
					$this->insertLog('dislike', $post_id);
					return true;
				}
			}
		}

		// Saber si un usuario sigue a otro
		public function userFollowedBy($from_user_id, $to_user_id) {
			$query = $this->DBConnection->prepare("SELECT * FROM users_follows WHERE from_user_id = :from_user_id AND to_user_id = :to_user_id AND active = 1");
			$query->execute(['from_user_id'=>$from_user_id, 'to_user_id'=>$to_user_id]);
			if($query->rowCount() == 0) {
				return false;
			} else {
				return true;
			}
		}

		// Seguir a un usuario
		public function userFollow($from_user_id, $to_user_id) {
			$query = $this->DBConnection->prepare("SELECT * FROM users_follows WHERE from_user_id = :from_user_id AND to_user_id = :to_user_id");
			$query->execute(['from_user_id'=>$from_user_id, 'to_user_id'=>$to_user_id]);
			if($query->rowCount() == 0) {
				$query = $this->DBConnection->prepare("INSERT INTO users_follows (from_user_id, to_user_id, follow_date, active) VALUES (:from_user_id, :to_user_id, NOW(), 1)");
				$query->execute(['from_user_id'=>$from_user_id, 'to_user_id'=>$to_user_id]);
				$this->insertLog('follow', $to_user_id);
				return true; 
			} else {
				$result = $query->fetch();
				if($result['active'] == 0) {
					$query2 = $this->DBConnection->prepare("UPDATE users_follows SET active = 1 WHERE from_user_id = :from_user_id AND to_user_id = :to_user_id");
					$query2->execute(['from_user_id'=>$from_user_id, 'to_user_id'=>$to_user_id]);
					$this->insertLog('follow', $to_user_id);
					return true; 
				} else {
					return true;
				}
			}
		}

		// Dejar de seguir a un usuario
		public function userUnfollow($from_user_id, $to_user_id) {
			$query = $this->DBConnection->prepare("SELECT * FROM users_follows WHERE from_user_id = :from_user_id AND to_user_id = :to_user_id");
			$query->execute(['from_user_id'=>$from_user_id, 'to_user_id'=>$to_user_id]);
			if($query->rowCount() == 0) {
				return true; 
			} else {
				$result = $query->fetch();
				if($result['active'] == 0) {
					return true; 
				} else {
					$query2 = $this->DBConnection->prepare("UPDATE users_follows SET active = 0 WHERE from_user_id = :from_user_id AND to_user_id = :to_user_id");
					$query2->execute(['from_user_id'=>$from_user_id, 'to_user_id'=>$to_user_id]);
					$this->insertLog('unfollow', $to_user_id);
					return true;
				}
			}
		}

		public function lastFollows($user_id) {
			$query = $this->DBConnection->prepare("SELECT * FROM logs WHERE user_id = :user_id AND action = 'follow' AND datetime > (NOW() - (60 * 60 * 24))");
			$query->execute(['user_id'=>$user_id]);
			$query2 = $this->DBConnection->prepare("SELECT * FROM logs WHERE user_id = :user_id AND action = 'unfollow' AND datetime > (NOW() - (60 * 60 * 24))");
			$query2->execute(['user_id'=>$user_id]);
			return $query->rowCount()+$query2->rowCount();
		}

		// Numero de seguidores de un usuario
		public function userFollowersNum($user_id) {
			$query = $this->DBConnection->prepare("SELECT * FROM users_follows WHERE to_user_id = :user_id AND active = 1");
			$query->execute(['user_id'=>$user_id]);
			return $query->rowCount();
		}

		// Lista de seguidores por paginas 
		public function userGetFollowers($username, $page) {
			$elementsInPage = 15;
			$next_page = $page + 1;
			$lastElement = ($page - 1) * $elementsInPage;
			$user_id = $this->selectIdFromUsername($username);
			$query = $this->DBConnection->prepare("SELECT * FROM users_follows WHERE to_user_id = :user_id AND active = 1 ORDER BY id DESC LIMIT ".$lastElement.", ".$elementsInPage);
			$query->execute(['user_id'=>$user_id]);
			$followers = array();
			while($follow = $query->fetch(PDO::FETCH_ASSOC)) {
				$follow_username = $this->selectUserInfo($follow['from_user_id'])['username'];
				$followers[] = $this->userAccountLoad($follow_username);
			}
			if(count($followers) == 0) {
				if($page == 1) {
					return array('state'=>3, 'users'=>'<span class="text-information">'.$this->language['NOFOLLOWERS'].'</span>');
				} else {
					return array('state'=>4, 'response'=>'');
				}
			} else {
				return array('state'=>1, 'users'=>$followers, 'actual_page'=>$page, 'next_page'=>$next_page);
			}
		}

		// Numero de seguidos de un usuario
		public function userFollowingsNum($user_id) {
			$query = $this->DBConnection->prepare("SELECT * FROM users_follows WHERE from_user_id = :user_id AND active = 1");
			$query->execute(['user_id'=>$user_id]);
			return $query->rowCount();
		}

		// Lista de seguidos por paginas 
		public function userGetFollowing($username, $page) {
			$elementsInPage = 15;
			$next_page = $page + 1;
			$lastElement = ($page - 1) * $elementsInPage;
			$user_id = $this->selectIdFromUsername($username);
			$query = $this->DBConnection->prepare("SELECT * FROM users_follows WHERE from_user_id = :user_id AND active = 1 ORDER BY id DESC LIMIT ".$lastElement.", ".$elementsInPage);
			$query->execute(['user_id'=>$user_id]);
			$following = array();
			while($follow = $query->fetch(PDO::FETCH_ASSOC)) {
				$follow_username = $this->selectUserInfo($follow['to_user_id'])['username'];
				$following[] = $this->userAccountLoad($follow_username);
			}
			if(count($following) == 0) {
				if($page == 1) {
					return array('state'=>3, 'users'=>'<span class="text-information">'.$this->language['NOFOLLOWING'].'</span>');
				} else {
					return array('state'=>4, 'response'=>'');
				}
			} else {
				return array('state'=>1, 'users'=>$following, 'actual_page'=>$page, 'next_page'=>$next_page);
			}
		}

		// Lista de seguidos por paginas 
		public function userGetAllFollowing($user_id) {
			$query = $this->DBConnection->prepare("SELECT to_user_id FROM users_follows WHERE from_user_id = :user_id AND active = 1");
			$query->execute(['user_id'=>$user_id]);
			$result = array();
			while($id = $query->fetch(PDO::FETCH_ASSOC)) {
				$result[] = $id['to_user_id'];
			}
			return $result;
		}

		// Numero de posts de un usuario
		public function userPostsNum($user_id) {
			$query = $this->DBConnection->prepare("SELECT * FROM posts WHERE user_id = :user_id AND deleted = 0");
			$query->execute(['user_id'=>$user_id]);
			return $query->rowCount();
		}

		// Seleccionar todas las conversaciones
		public function selectConversations() {
			$query = $this->DBConnection->prepare("SELECT * FROM users_conversations WHERE user_1_id = :user_id OR user_2_id = :user_id");
			$query->execute(['user_id'=>$this->user['id']]);
			$conversations = array();
			// foreach($this->selectUserGroups($this->user['id']) as $group) {
			// 	$conversations[] = $this->selectConversation($group['token']);
			// }
			while($conversation = $query->fetch()) {
				$conversations[] = $this->selectConversation($conversation['token']);
			}
			$lastMessages = array_column($conversations, 'last_message_code');
			$tokens = array_column($conversations, 'token');
			array_multisort($lastMessages, SORT_DESC, $tokens, SORT_ASC, $conversations);
			return $conversations;
		}

		// Seleccionar mensajes de una conversacion
		public function selectConversation($token) {
			$result = array();
			$query = $this->DBConnection->prepare("SELECT * FROM users_conversations WHERE token = :token LIMIT 1");
			$query->execute(['token'=>$token]);
			$conversation_type = 'user';
			if($query->rowCount() == 0) {
				$query = $this->DBConnection->prepare("SELECT * FROM groups_conversations WHERE token = :token LIMIT 1");
				$query->execute(['token'=>$token]);
				$conversation_type = 'group';
				if($query->rowCount() == 0) {
					return false;
				}
			} 
			$conversation = $query->fetch();
			$query2 = $this->DBConnection->prepare("SELECT * FROM messages WHERE conversation_token = :conversation_token ORDER BY datetime ASC");
			$query2->execute(['conversation_token'=>$token]);
			$result['id'] = $conversation['id'];
			$result['token'] = $conversation['token'];
			if($query2->rowCount() == 0) {
				$result['messages'] = array();
				$result['messages_num'] = 0;
				$result['not_readed_num'] = 0;
				$result['last_message'] = '';
				$result['last_message_date'] = $conversation['datetime'];
				$result['last_message_code'] = date('Ymdhis', strtotime($conversation['datetime']));
			} else {
				$result['messages'] = array();
				$result['not_readed_num'] = 0;
				while($message = $query2->fetch()) {
					$result['messages'][] = $this->renderMessage($message);
					$lastMessage = $this->renderMessage($message);
					$result['not_readed_num']++;
				}
				$result['messages_num'] = $query2->rowCount();
				$result['last_message'] = $lastMessage['text'];
				$result['last_message_date'] = $lastMessage['datetime'];
				$result['last_message_code'] = date('Ymdhis', strtotime($lastMessage['datetime']));
			}
			if($conversation_type == 'user') {
				if($conversation['user_1_id'] == $this->user['id']) {
					$user = $this->selectUserInfo($conversation['user_2_id']);
				} else {
					$user = $this->selectUserInfo($conversation['user_1_id']);
				}
				$result['conversation_info'] = array (
					'name' => $user['name'],
					'username' => $user['username'],
					'photo' => $user['photo']
				);
			}
			return $result;
		}

		// Renderizar un mensaje 
		public function renderMessage($message) {
			$result = array();
			$result['text'] = $message['text'];
			$result['datetime'] = $message['datetime'];
			return $result;
		}

		// Seleccionar aplicaciones 
		public function selectApps() {
			$query = $this->DBConnection->query("SELECT * FROM apps");
			$result2 = array();
			while($result = $query->fetch()) {
				$result2[] = array('name'=>$result['name'], 'token'=>$result['token'], 'photo'=>$this->selectFile($result['photo_id']));
			}
			return $result2;
		}

		// Mostrar un post (CODIGO HTML)
		public function visualPost($post) {
			$privacy_icon = $post['privacy'] == 0 ? 'icon-lock' : 'icon-earth';
			$privacy_icon = $post['privacy'] == 2 ? 'icon-users' : $privacy_icon;
			$result = '';
			$result = $result.'
				<div class="post-container new" id="'.$post['token'].'">
					<div class="user-info">
						<a href="users/'.$post['user_info']['username'].'">';
			if($post['user_info']['photo']) {
				$result = $result.'<img src="'.$post['user_info']['photo']['url'].'" class="photo" />';
			}		
			$result = $result.'</a>
						<div class="container">
							<span class="name">'.$post['user_info']['name'].'</span> 
							<span class="username">@'.$post['user_info']['username'].'</span>
						</div>
						<span class="icon-cog other-users-actions"></span>
					</div>
					<span class="post-text">'.$post['text'].'</span>';
			if(count($post['images']) > 0) {
				$result = $result.'<div class="post-images-container"> <div class="container">';
				foreach($post['images'] as $post_image) {
					$result = $result.'<img src="'.$post_image['url'].'" />';
				}
				$result = $result.'</div> </div>';
			}
			$result = $result.'
					<div class="post-info">
						<span class="date">'.$post['date'].'</span>
						<span class="dat-center">·</span>
						<span class="date">'.$post['date_time'].'</span>
						<span class="dat-center">·</span>
						<span class="time_transc">'.$post['time_transc'].'</span>
						<span class="dat-center">·</span>
						<span class="privacy '.$privacy_icon.'"></span> 
					</div>
					<div class="users-actions">
						<div class="container">
							<span class="icon-heart post-interactions-like icon '.$post['liked_class'].'"></span>
							<span class="num">'.$post['likes_let'].'</span>
						</div>
						<div class="container">
							<span class="icon-bubble2 post-comment icon"></span>
							<span class="num">'.$post['comments_let'].'</span>
						</div>	
						<div class="container">
							<span class="icon-share post-share icon"></span>
						</div>	
					</div>
				</div>
			'; 	
			return $result;	
		}

		public function visualUser($user) {
			$result = '';
			$result = $result.'
				<div class="follows-element">
					<a href="users/'.$user['username'].'" class="user-info">
						<img class="photo" src="'.$user['photo']['url'].'" />
						<div class="names">
							<span class="name">'.$user['name'].'</span>
							<span class="username">@'.$user['username'].'</span>
						</div>
					</a>';
			if($user['id'] !== $this->user['id']) {
				$result = $result.'
					<div class="user-interactions-follow '.$user['user_following'].'" id="'.$user['token'].'">
						<button class="user-interactions-follow-btn inactive" id="'.$user['username'].'">
							<span class="icon-user-plus icon"></span>
							<span class="text">'.$this->language['FOLLOW'].'</span>
						</button>

						<button class="user-interactions-follow-btn active" id="'.$user['username'].'">
							<span class="icon-user-minus icon"></span>
							<span class="text">'.$this->language['UNFOLLOW'].'</span>
						</button>
					</div>';
			}
			$result = $result.'</div>';
			return $result;
		}
	}

	$app = new App;

?>