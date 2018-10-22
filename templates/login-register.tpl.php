<?php 

	global $dbh;

	//variable for the Account class /Rasmus
	global $account;
	
	//takes a name ex. the inputs name="username" into the function so we can use it in our value="" tags so the username will stay put even if something was incorrectly typed and submitted /Rasmus
	function getInputValue($name) { 
		if(isset($_POST[$name])) {
			echo $_POST[$name];
		}
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" type="text/css" href="css/main_styles.css">
</head>
<body>

<div class="inputContainer">
		
		<!-- LOG IN -->
		
		<form class="loginForm" action="index.php?controller=login-register" method="POST"> 
			
			<h2>Logga in</h2>
			
			<p>
				<?php echo $account->getError(Constants::$loginFailed); ?>
				<label for="loginUsername">Epost</label>
				<input id="loginUsername" type="text" name="loginUsername" placeholder="Epost..." required> 
			</p>
			<p>
				<label for="loginPassword">Lösenord</label>
				<input id="loginPassword" type="password" name="loginPassword" required>
			</p>
			<button class="loginRegisterbutton" type="submit" name="loginButton">LOGGA IN</button>
			
			<!-- forgot password -->
			<a class="forgotPassword" href="index.php?controller=forgot-password">Glömt lösenord?</a>
		</form>
		
		<!-- REGISTER -->
			
		<form class="registerForm" action="index.php?controller=login-register" method="POST">
			
			<h2>Registrera</h2>
			
			<p>
				<?php echo $account->getError(Constants::$firstNameCharacters); ?>	
				<label for="firstName">Förnamn</label>
				<input id="firstName" type="text" name="firstName" placeholder="Förnamn..." value="<?php getInputValue('firstName') ?>" required>
			</p>	
			<p>
				<?php echo $account->getError(Constants::$lastNameCharacters); ?>
				<label for="lastName">Efternamn</label>
				<input id="lastName" type="text" name="lastName" placeholder="Efternamn..." value="<?php getInputValue('lastName') ?>"  required>
			</p>	
			<p>
				<?php echo $account->getError(Constants::$emailInvalid); ?>
				<?php echo $account->getError(Constants::$emailTaken); ?>
				<label for="email">Epost</label>
				<input id="email" type="email" name="email" placeholder="Epost..." value="<?php getInputValue('email') ?>" required>
			</p>			
			<p>
				<?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
				<?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
				<?php echo $account->getError(Constants::$passwordCharacters); ?>
				<label for="password">Lösenord</label>
				<input id="password" type="password" name="password" required>
			</p>
			<p>
				<label for="password2">Bekräfta lösenord</label>
				<input id="password2" type="password" name="password2" required>
			</p>
			<p>
						<?php echo $account->getError(Constants::$phoneInvalid1); ?>
				<label for="phone1">Telefonnummer</label>
				<input id="phone1" type="text" name="phone1" value="<?php getInputValue('phone1') ?>" placeholder="Telefonnummer...">
				
				<select id="phoneChoice1" type="text" name="phoneChoice1">
					<option value="mobile" <?php if(isset($_POST['phoneChoice1']) && $_POST['phoneChoice1'] == 'mobile'){ echo ' selected = "selected" ';} ?>>mobile</option>
				    <option value="home" <?php if(isset($_POST['phoneChoice1']) && $_POST['phoneChoice1'] == 'home'){ echo ' selected = "selected" ';} ?>>home</option>
    				<option value="work" <?php if(isset($_POST['phoneChoice1']) && $_POST['phoneChoice1'] == 'work'){ echo ' selected = "selected" ';} ?>>work</option></select>
			</p>
			<p>
				<?php echo $account->getError(Constants::$phoneInvalid2); ?>	
				<label for="phone2">Telefonnummer</label>
				<input id="phone2" type="text" name="phone2" value="<?php getInputValue('phone2') ?>" placeholder="Telefonnummer...">
				
				<select id="phoneChoice2" type="text" name="phoneChoice2">
					<option value="mobile" <?php if(isset($_POST['phoneChoice2']) && $_POST['phoneChoice2'] == 'mobile'){ echo ' selected = "selected" ';} ?>>mobile</option>
				    <option value="home" <?php if(isset($_POST['phoneChoice2']) && $_POST['phoneChoice2'] == 'home'){ echo ' selected = "selected" ';} ?>>home</option>
    				<option value="work" <?php if(isset($_POST['phoneChoice2']) && $_POST['phoneChoice2'] == 'work'){ echo ' selected = "selected" ';} ?>>work</option>
				</select>
			</p>
			
			<h3 class="padding10">Faktureringsadress</h3>
			
			<p>
				<label for="street">Gata</label>
				<input id="street" type="text" name="street" placeholder="Gata..." value="<?php getInputValue('street') ?>" required>
			</p>
			<p>
				<?php echo $account->getError(Constants::$zipInvalid); ?>
				<label for="zip">Postnummer</label>
				<input id="zip" type="text" name="zip" placeholder="Postnummer..." value="<?php getInputValue('zip') ?>" required>
			</p>
			<p>
				<label for="city">Ort</label>
				<input id="city" type="text" name="city" placeholder="Ort..." value="<?php getInputValue('city') ?>" required>
			</p>

			<h3 class="padding10">Leveransadress</h3>
			
			<p>
				<label for="deliveryStreet">Gata</label>
				<input id="deliveryStreet" type="text" name="deliveryStreet" placeholder="Gata..." value="<?php getInputValue('deliveryStreet') ?>" required>
			</p>
			<p>
				<?php echo $account->getError(Constants::$zipInvalid); ?>
				<label for="deliveryZip">Postnummer</label>
				<input id="deliveryZip" type="text" name="deliveryZip" placeholder="Postnummer..." value="<?php getInputValue('deliveryCity') ?>" required>
			</p>
			<p>
				<label for="deliveryCity">Ort</label>
				<input id="deliveryCity" type="text" name="deliveryCity" placeholder="Ort..." value="<?php getInputValue('deliveryCity') ?>" required>
			</p>
			
			<button class="loginRegisterbutton" type="submit" name="registerButton">REGISTRERA</button>
		
		</form>
	</div>
</body>