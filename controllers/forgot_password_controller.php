<?php

$templateData['page'] = 'forgot-password';

global $dbh;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader /Erica
require 'vendor/autoload.php';

//If the send email button was pressed /Rasmus
if (isset($_POST["forgotPasswordButton"])) {

	//Fetches the submitted e-mail address /Rasmus
	if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
		
		$email = $_POST["email"];	
	}

	else {
		
		echo "Emailadressen kan ej hittas.";
		exit;
	}

	//Check to see if a user exists with the input e-mail /Rasmus
	$sth = $dbh->prepare('SELECT person_email FROM person WHERE person_email = :person_email');
	$sth->bindParam(':person_email', $email);
	$sth->execute();
	$userExists = $sth->fetch(PDO::FETCH_ASSOC);
	
	if ($userExists["person_email"]) {

		$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
		
		try {
		    
		    $mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
		    //Server settings
		    $mail->SMTPDebug = 1;                                 // Enable verbose debug output
		    $mail->isSMTP();                                      // Set mailer to use SMTP
		    $mail->Host = 'smtp.sendgrid.net';                   // Specify main and backup SMTP servers
		    $mail->SMTPAuth = true;                               // Enable SMTP authentication
		    $mail->Username = 'eboberg';                          // SMTP username
		    $mail->Password = 'Hejhej123';                       // SMTP password
		    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		    $mail->Port = 587;                                    // TCP port to connect to

		    //Recipients
		    $mail->setFrom('erika.boberg91@gmail.com');
		    $mail->addAddress('erika.boberg91@gmail.com');     // Add a recipient


			//Create a salt for the request /Rasmus
			$salt = "4567bb81";
				
			//Creates the request key /Rasmus
			$password = hash('sha512', $salt . $userExists["person_email"]);

			//Create a link which will direct them to reset their password /Rasmus
			$pwUrl = "http://localhost/lp-project/index.php?controller=reset-password?q=" . $password;
				
			//Sets an email with the key /Rasmus
			$body = "Du får detta mail för en förfrågan att ändra lösenord har begärts, \r\n om detta inte är något du har vetskap om vänligen ignorera detta. \r\n " . $pwUrl . " \r\n Vänligen, LP-teamet";
				
		    //Content
		    $mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = 'test email';
		   
		    $mail->Body = $body;
		    $mail->AltBody = strip_tags($body);
			$mail->send();

		    echo "Din nyckel för återställning av lösenord har skickats till din emailadress: ";

		    //Sets the email to a session /Rasmus
			$_SESSION['email'] = $email;
			echo $_SESSION['email'];
		}
		
		catch (Exception $e) {
		   	echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
		}
	}
	
	else {
		echo "Emailadressen kan ej hittas.";
	}
}
}


<<<<<<< HEAD
if (isset($q)) {
	echo "hej";
	# code...
=======
>>>>>>> 6fcf6a3574d049df290a6c64241258142c511003
loadTemplate('forgot-password', $templateData);
