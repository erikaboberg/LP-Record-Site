<?php

$templateData['page'] = 'reset-password';

global $dbh;

    
//If reset password was submitted /Rasmus
if (isset($_POST["ResetPasswordForm"])) {
	
	//Gathers the session for email /Rasmus
	$email = $_SESSION['email'];

	//Gathers the post data /Rasmus
	$password = $_POST["password"];
	$confirmpassword = $_POST["confirmpassword"];
	$hash = $_POST["q"];

	//Generate the reset key /Rasmus
	$resetkey = hash('sha512', $salt.$email);

	//Checks if the resetkey matches the old one /Rasmus
	if ($resetkey == $hash) {

		//if the passwords matches /Rasmus
		if ($password == $confirmpassword) {
			
			//hash to secrure the password /Rasmus
			$password = md5($password);

			//Updates the user's password /Rasmus
			$sth = $dbh->prepare('UPDATE person SET person_password = :password WHERE person_email = :email');
			$sth->bindParam(':password', $password);
			$sth->bindParam(':email', $email);
			$sth->execute();
			$dbh = null;
			
			unset($_SESSION['email']);
		
			echo "Ditt lösenord har nu ändrats";
			}
		else
			echo "Lösenorden matchar inte";
	}
	else
		echo "Din session för återställning av lösenord är ej giltigt.";
}

loadTemplate('reset-password', $templateData);
