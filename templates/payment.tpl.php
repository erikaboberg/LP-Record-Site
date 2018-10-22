
<?php 

    global $dbh;
    
    //variable for the Account class /Rasmus
    global $account;

    //Sets the login session to a variiable /Rasmus
    if(isset($_SESSION['userLoggedIn'])) {
        $userLoggedIn = $_SESSION['userLoggedIn']; 
    }
    
    //takes a name ex. the inputs name="username" into the function so we can use it in our value="" tags so the username will stay put even if something was incorrectly typed and submitted /Rasmus
    function getInputValue($name) { 
        if(isset($_POST[$name])) {
            echo $_POST[$name];
        }
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/main_styles.css">
    <title>Betalning</title>
</head>
<body>

<div class="inputContainer">

<?php

//Sets the sum of the cart to a variable /Rasmus
if (!$_SESSION['totalPrice']) {
$totalPrice = "0";
}

else {
$totalPrice = $_SESSION['totalPrice']; 
}

//Fetches the logged in users data if logged in /Rasmus
if($_SESSION['userLoggedIn'] == true) {
            
$sth1 = $dbh->prepare("
    SELECT person_firstname, person_lastname, person_email, delivery_street, delivery_zip, delivery_city 
    FROM person, delivery, phone 
    WHERE person.person_id = delivery.person_id 
    AND person.person_id = phone.person_id
    AND person.person_email = :person_value
    ");

    $sth1->bindParam(":person_value", $_SESSION['userLoggedIn'], PDO::PARAM_STR);
            
    $sth1->execute();

    $result = $sth1->fetch(PDO::FETCH_ASSOC); 
            
?>

<!-- Prints the totalPrice from the session /Rasmus -->
<h2>Totalt att betala inkl. gratis frakt: <?php echo $totalPrice; ?></h2>

<h3 class="padding10" >Leveransadress</h3>

<form id="orderDetails" action="index.php?controller=payment" method="POST">
    <p>

    <!-- fetches the error from our Constants class /Rasmus -->
    <?php echo $account->getError(Constants::$firstNameCharacters); ?>  
        <label for="firstName">Förnamn</label>

        <!-- value = Sends the logged in persons data to the corresponding value in the value section /Rasmus-->
        <input id="firstName" type="text" name="firstName" placeholder="Förnamn..." value="<?php echo $result['person_firstname'] ?>" required>
    </p>    
    <p>
    <?php echo $account->getError(Constants::$lastNameCharacters); ?>
        <label for="lastName">Efternamn</label>
        <input id="lastName" type="text" name="lastName" placeholder="Efternamn..." value="<?php echo $result['person_lastname'] ?>"  required>
    </p>    
    <p>
    <?php echo $account->getError(Constants::$emailInvalid); ?>
    <?php echo $account->getError(Constants::$emailTaken); ?>
        <label for="email">Epost</label>
        <input id="email" type="email" name="email" placeholder="Epost..." value="<?php echo $result['person_email'] ?>" required>
    </p>                
    <p>
        <label for="street">Gata</label>
        <input id="street" type="text" name="delivery_street" placeholder="Gata..." value="<?php echo $result['delivery_street'] ?>" required>            
    </p>
    
    <p>        
    <?php echo $account->getError(Constants::$zipInvalid); ?>
        <label for="zip">Postnummer</label>
        <input id="zip" type="text" name="delivery_zip" placeholder="Postnummer..." value="<?php echo $result['delivery_zip'] ?>" required>
    </p>
    <p>
        <label for="city">Ort</label>
        <input id="city" type="text" name="delivery_city" placeholder="Ort..." value="<?php echo $result['delivery_city'] ?>" required>
    </p>

    <p>

        <label for="betalningsmetod">Betalningsmetod</label>
        <select id="betalningsmetod" type="text" name="betalningsmetod">
            <option value="betalkort" <?php 
            
            if(isset($_POST['betalkort']) && $_POST['betalkort'] == 'betalkort'){ echo ' selected = "selected" ';} 
            
            ?> 
            
            >Betalkort</option>

            <option value="postforskott" <?php 
            
            if(isset($_POST['postforskott']) && $_POST['postforskott'] == 'postforskott'){ echo ' selected = "selected" ';} 
            
            ?> 
            
            >Postförskott</option>
 
        </select>
    </p>



    <button class="loginRegisterbutton" type="submit" name="orderButton">Skicka order</button>


</form>

<?php 
        //If the user is not logged in add a login/register form /Rasmus
        } else {
    ?>          
    <div class="inputContainer">
            
            <h2>
            Totalt att betala inkl. frakt: 
            <?php 
            echo $totalPrice; 
            ?> 
            </h2>
        <form class="loginForm" action="index.php?controller=payment" method="POST"> 
            
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

            <a class="forgotPassword" href="index.php?controller=forgot-password">Glömt lösenord?</a>
        </form>      
  
        <form class="registerForm" action="index.php?controller=payment" method="POST">
            
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

        <?php 
            } //Ends the php /Rasmus
        ?>

    </div>




