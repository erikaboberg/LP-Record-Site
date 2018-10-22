<?php 

class Constants {
 	
 	//Regiser errors /Rasmus
	public static $passwordsDoNotMatch = "Lösenorden matchar inte";
	public static $passwordNotAlphanumeric = "Lösenordet kan bara innehålla nummer och bokstäver";
	public static $passwordCharacters = "Lösennorden kan måste innehålla 5 till 30 tecken";
	public static $emailInvalid = "Ogiltig email";
	public static $emailTaken = "Den inskrivna emailen finns redan registrerad";
	public static $lastNameCharacters = "Efternamnet måste innehålla mellan 2 och 25 bostäver";
	public static $firstNameCharacters = "Förnamnet måste innehålla mellan 2 och 25 bostäver";
	public static $zipInvalid = "Postnumret kan bara innehålla bokstäver";
	public static $phoneInvalid1 = "Telefonnumret kan bara innehålla + och nummer";
	public static $phoneInvalid2 = "Telefonnumret kan bara innehålla + och nummer";


	//Login errors /Rasmus
	public static $loginFailed = "Fel användarnamn eller lösenord";

}


?>	