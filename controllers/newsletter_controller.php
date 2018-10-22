<?php 

// Erika Boberg

if (isset($_GET['action']) && $_GET['action'] === 'signup') {
	captureEmail();
}

function captureEmail () {

	   	global $dbh;

	   	$table = "newsletter";


		if (isset($_POST['email'])) {

		
		$email = $_POST['email'];

		$query = "SELECT count(*) FROM $table WHERE subscriber_email = :email";
		$stmt = $dbh->prepare($query);
		$stmt->bindParam(':email', $email);
		$stmt->execute();


		if($stmt->fetchColumn() > 0) {
 				$_SESSION['newsletterStatus'] = 2;
  		 
 		} else {


             	$stmt = $dbh->prepare("INSERT INTO $table(subscriber_email) VALUES (:email)");
				$stmt->bindParam(':email', $email);
				if ($stmt->execute()) {
					// Det gick att spara!
					$_SESSION['newsletterStatus'] = 1;
					//echo 'Du är nu registrerad för nyhetsbrev!';
				} else {
					$_SESSION['newsletterStatus'] = 2;
					//echo "Det gick inte att registrera adressen";
				}
  				
		}
	}
}

header('Location: '.$_SERVER['HTTP_REFERER']."#reg_newsletter");