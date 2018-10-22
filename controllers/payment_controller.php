<!-- Gjord av Rasmus (mailfunktion Erika) -->

<?php

$titleData[] = 'Betalning';

$templateData['titleData'] = $titleData;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader /Erica
require 'vendor/autoload.php';

$templateData['page'] = 'payment';


function sanitizeFormString($inputText) {
	
    //strips a string from HTML, XML, and PHP tags. /Rasmus
    $inputText = strip_tags($inputText); 
    
    //Replace the strings spaces with no spaces /Rasmus
	$inputText = str_replace(" ", "", $inputText);
    
    //first it makes the string into lowercases then the first letter to uppercase /Rasmus 
	$inputText = ucfirst(strtolower($inputText)); 
	
    return $inputText;
}

function sanitizeFormString2($inputText) {
	$inputText = strip_tags($inputText);
	$inputText = ucfirst(strtolower($inputText));
	
    return $inputText;
}

function sanitizeFormNumbers($inputText) {
    //Removes illegal characters from a float number (+ and z are allowed) /Rasmus
	$inputText = filter_var($inputText, FILTER_SANITIZE_NUMBER_FLOAT); 
	
    return $inputText;
}

function sanitizeFormPassword($inputText) {
	$inputText = strip_tags($inputText);
	
    return $inputText;
}

//if the register button was pressed /Rasmus
if(isset($_POST['registerButton'])) { 
	
	//Fetches the data from the functions above combined with the data inserted in the form /Rasmus
	$firstName = sanitizeFormString($_POST['firstName']);	
	$lastName = sanitizeFormString($_POST['lastName']);	
	$email = sanitizeFormString($_POST['email']);
	$password = sanitizeFormPassword($_POST['password']);
	$password2 = sanitizeFormPassword($_POST['password2']);
	
    $street = sanitizeFormString2($_POST['street']);
	$zip = sanitizeFormNumbers($_POST['zip']);
	$city = sanitizeFormString2($_POST['city']);
    
    $deliveryStreet = sanitizeFormString2($_POST['deliveryStreet']);
    $deliveryZip = sanitizeFormNumbers($_POST['deliveryZip']);
    $deliveryCity = sanitizeFormString2($_POST['deliveryCity']);
	
    $phoneType1 = $_POST['phoneChoice1'];
	$phoneNumber1 = $_POST['phone1'];
	$phoneType2 = $_POST['phoneChoice2'];
	$phoneNumber2 = $_POST['phone2'];

	//Sets the wasSuccessful variable to the register function in the Account class with the values /Rasmus
	$wasSuccessful = $account->register(
		$firstName, $lastName, $email, $password, $password2, 
		$street, $zip, $city, 
        $deliveryStreet, $deliveryZip, $deliveryCity, 
        $phoneType1, $phoneNumber1, $phoneType2, $phoneNumber2
		); 
	
	//Calls the register function to see if it was true or false /Rasmus
	if($wasSuccessful == true) {
		$_SESSION['userLoggedIn'] = $email;
	}

	header('Location: index.php?controller=payment');
}

//If the login button was pressed /Rasmus
if(isset($_POST['loginButton'])) { 
	$email = $_POST['loginUsername'];
	$password = $_POST['loginPassword'];

	$result = $account->login($email, $password);
	
	//The session userloggedin will be set to the users email /Rasmus
	if($result == true) {
		$_SESSION['userLoggedIn'] = $email;
	}
	header('Location: index.php?controller=payment');
}

//If order button is pressed /Rasmus
if(isset($_POST['orderButton'])) {

    //Fetch the signed in users id /Rasmus
    $sth1 = $dbh->prepare("
     	SELECT person_id 
        FROM person 
        WHERE person_email = :person_value_id 
        ");

        $sth1->bindParam(":person_value_id", $_SESSION['userLoggedIn'], PDO::PARAM_STR);
                
        $sth1->execute();

        $result1 = $sth1->fetch(PDO::FETCH_ASSOC); 
        
    //Sets the timestamp when the order was placed (GMT -1) /Rasmus
    $orderTimestamp = date('Y-m-d H:i:s');
    
    //Sets the orderstatus to processing /Rasmus
    $statusOrder = "processing";

    
    //Fetches the delivery id /Rasmus
        $sth2 = $dbh->prepare("
        SELECT delivery_id 
        FROM delivery 
        WHERE person_id = :person_id 
        ");
                    
        $sth2->bindParam(":person_id", $result1['person_id'], PDO::PARAM_STR);
        
        $sth2->execute();

        $result2 = $sth2->fetch(PDO::FETCH_ASSOC); 
    
    //Sets the payment method to a variable /Rasmus
    $paymentMethod = $_POST['betalningsmetod'];
    
    //Sends the session order into the "order" table /Rasmus
    $sth3 = $dbh->prepare("
        INSERT INTO 
        `order` (order_timestamp, delivery_id, person_id, status_order, payment_method) 
        VALUES 
        (:order_timestamp, :delivery_id, :person_id, :status_order, :payment_method)
        ");
                    
        $sth3->bindParam(":order_timestamp", $orderTimestamp, PDO::PARAM_STR);
        $sth3->bindParam(":delivery_id", $result2['delivery_id'], PDO::PARAM_STR);
        $sth3->bindParam(":person_id", $result1['person_id'], PDO::PARAM_STR);
        $sth3->bindParam(":status_order", $statusOrder, PDO::PARAM_STR);
        $sth3->bindParam(":payment_method", $paymentMethod, PDO::PARAM_STR);

        $sth3->execute();

        //Fetches the last inserted id so we dont get a collision with primary keys /Rasmus
		$id = $dbh->lastInsertId();

    //Updates the delivery address in the "delivery" table if they want to change it in the checkout /Rasmus
    $sth4 = $dbh->prepare("
        UPDATE 
        delivery 
        SET delivery_street = :delivery_street, delivery_zip = :delivery_zip, delivery_city = :delivery_city
        WHERE person_id = :person_id 
        ");
                    
        $sth4->bindParam(":delivery_street", $_POST['delivery_street'], PDO::PARAM_STR);
        $sth4->bindParam(":delivery_zip", $_POST['delivery_zip'], PDO::PARAM_STR);
        $sth4->bindParam(":delivery_city", $_POST['delivery_city'], PDO::PARAM_STR);
        $sth4->bindParam(":person_id", $result1['person_id'], PDO::PARAM_STR);
                    
        $sth4->execute();

    //Sends the session order product specifics to the database table "order_album" /Rasmus
    foreach ($_SESSION['cartAllInfo']['cart'] as $orderInfo) {
                
        $albumId = $orderInfo['album_id'];
        $albumAmount = $orderInfo['album_amount'];
        $albumPrice = $orderInfo['album_price'];
        
        $sth5 = $dbh->prepare("
	        INSERT INTO 
	        order_album (order_id, album_id, amount, price) 
	        VALUES 
	        (:order_id, :album_id, :amount, :price)
	        ");
	                    
	        $sth5->bindParam(":order_id", $id, PDO::PARAM_STR);
	        $sth5->bindParam(":album_id", $albumId, PDO::PARAM_STR);
	        $sth5->bindParam(":amount", $albumAmount, PDO::PARAM_STR);
	        $sth5->bindParam(":price", $albumPrice, PDO::PARAM_STR);
	                    
	        $sth5->execute();
    }

    //Removes the sessions so you can start creating a new order /Rasmus
    unset($_SESSION['cartAllInfo']);
    unset($_SESSION['cart']);
    unset($_SESSION['totalPrice']);


//Connects the emailer and sends the mail //Erica
$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    
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


    $body ='<p><strong>Hej</strong>Tack för din order!</p>';
   

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'test email';
   
    $mail->Body    = $body;
    $mail->AltBody = strip_tags($body);

    $mail->send();
    echo 'Message has been sent';

} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}



    header('Location: index.php?controller=thanks-order');
}

loadTemplate('payment', $templateData);
