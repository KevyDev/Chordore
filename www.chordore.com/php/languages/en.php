<?php
	
	if(isset($language)) {

		$language['MONTHS'] = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
		$language['DAYS'] = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
		
		$language['JOINED'] = "Joined";
		$language['MOMENT'] = "a moment ago";

		$language['SESSIONISSET'] = "There is already an active session.";

		$language['NEXT'] = "Next";
		$language['REGISTER'] = "Sign Up";
		$language['LOGIN'] = "Log In";
		$language['LOGOUT'] = "Log Out";
		$language['NAME'] = "Full Name";
		$language['USERNAME'] = "Username";
		$language['EMAIL'] = "Email";
		$language['BIO'] = "Biography";
		$language['LOCATION'] = "Location";
		$language['LINK'] = "Link";
		$language['PASSWORD'] = "Password";
		$language['REPASSWORD'] = "Confirm Password";
		$language['HOMETEXT'] = "Sign up to see creations from your friends.";
 		
		$language['OR'] = "OR";
		$language['EXAMPLECOMP'] = "Ex";
		$language['HAVEACCOUNT'] = "You do have an account?";
		$language['DONTHAVEACCOUNT'] = "Don't have an account?";
		$language['FORGOTPASSWORD'] = "Forgot password?";
		$language['RESETPASSWORD'] = "Reset password";
		$language['SEARCHBYUSERNAME'] = "Search your account by username.";
		$language['SEARCHBYEMAIL'] = "Search your account by email.";
		$language['SEARCHACCOUNT'] = "Search Account";
		
		$language['ENTERFULLNAME'] = "You must enter your full name.";
		$language['ENTERUSERNAME'] = "You must enter an username";
		$language['ENTEREMAIL'] = "You must enter an email.";
		$language['ENTERPASSWORD'] = "You must enter a password.";
		$language['ENTERREPASSWORD'] = "You must confirm your password.";
		$language['ENTERVALIDEMAIL'] = "You must enter a valid email.";
		$language['ENTERVALIDUSERNAME'] = "You must enter a valid username.";
		$language['ENTERRESETEMAIL'] = "You must enter the email attached to your account.";
		$language['ENTERRESETEUSERNAME'] = "You must enter the username attached to your account.";
		$language['NAMEMAX'] = "You must enter a full name with a maximum of ".$this->fullNameMaxC." characters.";
		$language['USERNAMEMAX'] = "You must enter a username with a maximum of ".$this->usernameMaxC." characters.";
		$language['EMAILMAX'] = "You must enter an email with a maximum of ".$this->emailMaxC." characters.";
		$language['PASSWORDMAX'] = "You must enter a password with a maximum of ".$this->passwordMaxC." characters.";
		$language['BIOMAX'] = "You must enter a bio with a maximum of ".$this->bioMaxC." characters.";
		$language['NAMEMIN'] = "You must enter a full name with a minimum of ".$this->fullNameMinC." characters.";
		$language['USERNAMEMIN'] = "You must enter a username with a minimum of ".$this->usernameMinC." characters.";
		$language['EMAILMIN'] = "You must enter a email with a minimum of ".$this->emailMinC." characters.";
		$language['PASSWORDMIN'] = "You must enter a password with a minimum of ".$this->passwordMinC." characters.";
		$language['BIOMAX'] = "You must enter a bio with a minimum of ".$this->bioMinC." characters.";
		$language['PASSWORDNOTIGUAL'] = "Passwords do not match.";
		$language['USERNAMEEXIST'] = "The username entered already exists in the database.";
		$language['EMAILEXIST'] = "E-mail entered already exists in the database.";
		$language['USERNAMENOEXIST'] = "The username entered does not exist in the database.";
		$language['EMAILNOEXIST'] = "E-mail entered does not exist in the database.";
		$language['PASSWORDNOTIS'] = "The password entered does not match the database.";
		$language['BAN'] = "Your account is still banned temporarily.";
		$language['CHANGELANGUAGE'] = "Change Language";
		$language['ERROR'] = "An server error has occurred.";
		$language['USERNOEXIST'] = "The user does not exist in the database.";
		$language['NOFOLLOWERS'] = "You don't have followers.";
		$language['NOFOLLOWING'] = "You don't follow anybody.";

		$language['HOME'] = "Home";
		$language['EXPLORE'] = "Explore";
		$language['NOTIFICATIONS'] = "Notifications";
		$language['CONVERSATIONS'] = "Conversations";
		$language['PROFILE'] = "Profile";
		$language['CONFIGURATION'] = "Configuration";
		$language['SPANEL'] = "Stadistics Panel";
		$language['VIEW'] = "View";
		$language['EDITPROFILE'] = "Edit Profile";
		$language['FOLLOW'] = "Follow";
		$language['UNFOLLOW'] = "Unfollow";
		$language['ADDTOFRIENDS'] = "Add to Friends";
		$language['FRIENDS'] = "Friends";
		$language['PUBLIC'] = "Public";
		$language['PRIVATE'] = "Private";
		$language['WAITINGRESPONSE'] = "Waiting response...";
		$language['CHAT'] = "Chat";
		$language['BLOCK'] = "Block";
		$language['BLOCKED'] = "Blocked";
		$language['REPORT'] = "Report";
		
		$language['FOLLOWING'] = "Following";
		$language['FOLLOWERS'] = "Followers";
		$language['POSTS'] = "Posts";
		$language['CREATIONS'] = "Creations";

		$language['POSTCOMPOSE'] = "Write a publication...";
		$language['POSTENV'] = "Post";
		$language['POSTNOTFOUND'] = "Post not found, this is because has removed or an error has ocurred.";
		$language['POSTMAXC'] = "You must enter a text with a minimum of ".$this->postComposeMaxC." characters.";
		$language['POSTISNULL'] = "You must enter a text.";

		$language['NOPOSTS'] = "Right now, there isn't posts.";
		$language['NOMOREPOSTS'] = "There isn't more posts.";
		$language['SOMEISWRONG'] = "Something is wrong here.";

		$language['FORMATSNOTSUPPORTED'] = "Image's format is not supported.";
		$language['IMAGEERROR'] = "An error has ocurred saving the image.";

		$language['SAVECHANGES'] = "Save Changes";

		function languageTranscYears($years) {
			if($years == 1) {
				return "a year ago";
			} else {
				return $years." years ago";
			}
		}

		function languageTranscMonths($months) {
			if($months == 1) {
				return "a month ago";
			} else {
				return $months." months ago";
			}
		}

		function languageTranscDays($days) {
			if($days == 1) {
				return "a day ago";
			} else {
				return $days." days ago";
			}
		}

		function languageTranscHours($hours) {
			if($hours == 1) {
				return "a hour ago";
			} else {
				return $hours." hours ago";
			}
		}

		function languageTranscMinutes($minutes) {
			if($minutes == 1) {
				return "a minute ago";
			} else {
				return $minutes." minutes ago";
			}
		}

	}

?>