<!-- Erika Boberg -->

<fieldset id="reg_newsletter"> 
		<legend>Prenumerera på vårt nyhetsbrev</legend> 
		<form action="?controller=newsletter&action=signup" method="post"> 
		<br>  
		<input type="email" name="email" placeholder ="Din e-postadress" required /><br><br>
		<input type="submit" name=submit value="Registrera dig nu"/>
		<?php 
			$status = $_SESSION['newsletterStatus'] ?? null;
			unset($_SESSION['newsletterStatus']);
			switch ($status) {
				case 1:
				echo "Du är nu sregistrerad";
				break;
				case 2:
				echo "epostadressen finns redan";
				break;
			}
			?>
	</form> 
	</fieldset>