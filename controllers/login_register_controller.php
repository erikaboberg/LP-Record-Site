<?php

$templateData['page'] = 'login-register';

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
	$city = sanitizeFormString2($_POST['city'])	;
	
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
		header('Location: index.php');
	}
}

//If the login button was pressed /Rasmus
if(isset($_POST['loginButton'])) { 
	$email = $_POST['loginUsername'];
	$password = $_POST['loginPassword'];

	$result = $account->login($email, $password);
	
	//The session userloggedin will be set to the users email /Rasmus
	if($result == true) {
		$_SESSION['userLoggedIn'] = $email;
		header('Location: index.php'); 
	}
}


loadTemplate('login-register', $templateData);
?>