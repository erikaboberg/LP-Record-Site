<?php
	class Account {

		private $dbh;
		private $errorArray;
		private $info;


		public static function logout(){
            unset($_SESSION['userLoggedIn']);
        }

        public static function getUserInfo($email){
		    global $dbh;
		    $sql = "SELECT * FROM person WHERE person_email = ?";
		    $stmt = $dbh->prepare($sql);
		    $stmt->bindParam(1, $email);
		    $stmt->execute();
		    return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
		//The constructor is called as soon as or object of this class is created 
		//ex. register.php calls the Account class. In this case $dbh will be called everytime an object is created /Rasmus
		public function __construct($dbh) { 
			$this->dbh = $dbh; 
			$this->errorArray = array(); 
		}
		//Login funtion /Rasmus
		public function login($un, $pw) {
			//Hashing /Rasmus
			$pw = md5($pw);

			//Looks through the database if the emal and passwordinput checks with the database /Rasmus
			$sth = $this->dbh->prepare("
				SELECT * FROM person 
				WHERE person_email=:person_email 
				AND person_password=:person_password
				"); 	
            $sth->bindParam(":person_email", $un, PDO::PARAM_STR);
            $sth->bindParam(":person_password", $pw, PDO::PARAM_STR);
           
			$sth->execute();
			
			//If a match is found return true /Rasmus
           	if ($sth->fetchAll() == true) { 
                return true;
			}
			//If a match is NOT found return an error from our Constants class /Rasmus
			else {
				array_push($this->errorArray, Constants::$loginFailed);
				return false;
			}
		}	

		//Register function that gets the values from the input (from the controller) /Rasmus
		public function register($fn, $ln, $em, $pw, $pw2, $street, $zip, $city, $deliveryStreet, $deliveryZip, $deliveryCity, $pType1, $pNumber1, $pType2, $pNumber2) {
			$this->validateFirstName($fn);
			$this->validateLastName($ln);
			$this->validateEmails($em);
			$this->validatePasswords($pw, $pw2);
			$this->validateZip($zip);
			$this->validateDeliveryZip($deliveryZip);
			$this->validatePhone1($pNumber1);
			//$this->validatePhone2($pNumber2);

			if(empty($this->errorArray) == true) { 
				//if there are no errors included in the register function, insert user details into database /Rasmus
				return $this->insertUserDetails($fn, $ln, $em, $pw, $street, $zip, $city, $deliveryStreet, $deliveryZip, $deliveryCity, $pType1, $pNumber1, $pType2, $pNumber2);
			}
			else {
				return false;
			}
		}

		//Checks if there are any errors /Rasmus
		public function getError($error) {
			
			//Looks for errors in errorArray. in_array will ckeck if the parameter $error is in the errorArray /Rasmus
			if(!in_array($error, $this->errorArray)) 
				$error = "";
		
			return "<span class='errorMessage'>$error</span>";
		}

		//Binds the input details from the register function and inserts the data into the database /Rasmus
		private function insertUserDetails($fn, $ln, $em, $pw, $street, $zip, $city, $deliveryStreet, $deliveryZip, $deliveryCity, $pType1, $pNumber1, $pType2, $pNumber2) {
				$encryptedPw = md5($pw);
		
				//Sets the user type. 1 = user 2 = admin. /Rasmus
				$type = 1;
				
				//Inserts the users details into database /Rasmus
				$sth1 = $this->dbh->prepare("
					INSERT INTO 
					person (person_firstname, person_lastname, person_email, person_type, person_password) 
					VALUES 
					(:person_firstname, :person_lastname, :person_email, :person_type, :person_password)
					");
				
				$sth1->bindParam(":person_firstname", $fn, PDO::PARAM_STR);
            	$sth1->bindParam(":person_lastname", $ln, PDO::PARAM_STR);
            	$sth1->bindParam(":person_email", $em, PDO::PARAM_STR);
            	$sth1->bindParam(":person_type", $type, PDO::PARAM_STR);
            	$sth1->bindParam(":person_password", $encryptedPw, PDO::PARAM_STR);
            	
            	$sth1->execute();

            	//Fetches the person_id /Rasmus
            	$pid = $this->dbh->lastInsertId();

 				//Inserts address into database /Rasmus
 				$sth2 = $this->dbh->prepare("
					INSERT INTO 
					address (address_street, address_zip, address_city, person_id) 
					VALUES 
					(:address_street, :address_zip, :address_city, :person_id)
				");

				$sth2->bindParam(":address_street", $street, PDO::PARAM_STR);
            	$sth2->bindParam(":address_zip", $zip, PDO::PARAM_INT);
            	$sth2->bindParam(":address_city", $city, PDO::PARAM_STR);
            	$sth2->bindParam(":person_id", $pid, PDO::PARAM_INT);
            	
            	$sth2->execute();
				
				//Inserts the delivery address into database /Rasmus            
            	$sth3 = $this->dbh->prepare("
					INSERT INTO 
					delivery (delivery_street, delivery_zip, delivery_city, person_id) 
					VALUES 
					(:delivery_street, :delivery_zip, :delivery_city, :person_id)
				");

				$sth3->bindParam(":delivery_street", $deliveryStreet, PDO::PARAM_STR);
            	$sth3->bindParam(":delivery_zip", $deliveryZip, PDO::PARAM_INT);
            	$sth3->bindParam(":delivery_city", $deliveryCity, PDO::PARAM_STR);
            	$sth3->bindParam(":person_id", $pid, PDO::PARAM_INT);
            	
            	$sth3->execute();

				//Inserts the first phone values into the database /Rasmus
				$sth4 = $this->dbh->prepare("
					INSERT INTO 
					phone (phone_type, phone_number, person_id) 
					VALUES 
					(:phone_type, :phone_number, :person_id)
					");
				$sth4->bindParam(":phone_type", $pType1, PDO::PARAM_STR);
            	$sth4->bindParam(":phone_number", $pNumber1, PDO::PARAM_STR);
            	$sth4->bindParam(":person_id", $pid, PDO::PARAM_INT);
            	
            	$sth4->execute();
 				
            	//Inserts the second phone values into the database /Rasmus
 				$sth5 = $this->dbh->prepare("
					INSERT INTO 
					phone (phone_type, phone_number, person_id) 
					VALUES 
					(:phone_type, :phone_number, :person_id)
					");
				$sth5->bindParam(":phone_type", $pType2, PDO::PARAM_STR);
            	$sth5->bindParam(":phone_number", $pNumber2, PDO::PARAM_STR);
            	$sth5->bindParam(":person_id", $pid, PDO::PARAM_INT);
            	
            	$sth5->execute();
            	

            	if(true) {
            		return true;
				}
				else {
					return false;
				}
			}

		/*------------------------------------VALIDATION SPECIFICS FOR REGISTER-----------------------------------------------*/

								/*--------first name---------*/
		private function validateFirstName($fn) {
			if(strlen($fn) > 25 || strlen($fn) < 2) {
				array_push($this->errorArray, Constants::$firstNameCharacters); 
				return;
			}
		}
								/*--------last name---------*/
		private function validateLastName($ln) {

			//Checks the length of the string /Rasmus
			if(strlen($ln) > 25 || strlen($ln) < 2) { 
				array_push($this->errorArray, Constants::$lastNameCharacters); 
				return;
			}
		}
								/*--------email---------*/
		private function validateEmails($em) {

			//Checks if the email is NOT in the correct format /Rasmus
			if(!filter_var($em, FILTER_VALIDATE_EMAIL)) { 
				array_push($this->errorArray, Constants::$emailInvalid); 
				return;
			}
			
			//Checks if the email is already registered in the database /Rasmus
			$sth = $this->dbh->prepare("SELECT person_email FROM person WHERE person_email=:person_email"); 	
            $sth->bindParam(":person_email", $em, PDO::PARAM_STR);
            $sth->execute();
            
            if ($sth->fetchAll() == true) { 
                array_push($this->errorArray, Constants::$emailTaken);
                return;
            }
		}
								/*--------password---------*/
		private function validatePasswords($pw, $pw2) {
			if($pw != $pw2) {
				array_push($this->errorArray, Constants::$passwordsDoNotMatch); 
				return;
			}
			if(preg_match('/[^A-Za-z0-9!?_@#$%]/', $pw)) {
				array_push($this->errorArray, Constants::$passwordNotAlphanumeric); 
				return;
			}
			if(strlen($pw) > 30 || strlen($pw) < 5) { 
				array_push($this->errorArray, Constants::$passwordCharacters);
				return;
			}
		}

								/*--------address---------*/
		private function validateZip($zip) {
			if(!filter_var($zip, FILTER_SANITIZE_NUMBER_FLOAT)) {
				array_push($this->errorArray, Constants::$zipInvalid); 
				return;
			}
		}
		private function validateDeliveryZip($deliveryZip) {
			if(!filter_var($deliveryZip, FILTER_SANITIZE_NUMBER_FLOAT)) {
				array_push($this->errorArray, Constants::$zipInvalid); 
				return;
			}
		}
								/*--------phone---------*/		
		private function validatePhone1($pNumber1) {
			if(!filter_var($pNumber1, FILTER_SANITIZE_NUMBER_FLOAT)) {
				array_push($this->errorArray, Constants::$phoneInvalid1); 
				return;
			}
		}
		
		private function validatePhone2($pNumber2) {
			if(!filter_var($pNumber2, FILTER_SANITIZE_NUMBER_FLOAT)) {
				array_push($this->errorArray, Constants::$phoneInvalid2); 
				return;
			}
		}
	}
?>