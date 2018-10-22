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

<form id="resetPasswordForm" action="index.php?controller=reset-password" method="POST">
    <p>
        <label for="email">Lösenord</label>
        <input id="resetPassword" type="password" name="resetPassword" required>
    </p>
    <p>
        <label for="email">Bekfräfta lösenord</label>
        <input id="confirmPassword" type="password" name="confirmPassword" required>
    </p>
    <!-- Sets the resetkey /Rasmus -->
    <?php echo '
        <input type="hidden" name="q" value="';
        if (isset($_GET["q"])) {
        echo $_GET["q"];
        }
        
        echo '" /><input type="submit" class="forgotPasswordButton" name="ResetPasswordForm" value=" Ändra lösenordet " />';
    ?>
    
    
</form>

</body>
