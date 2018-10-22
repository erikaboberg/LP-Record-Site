<?php

$settings['db']['user'] ='root';
$settings['db']['password'] ='root';
$settings['db']['host'] ='localhost';
$settings['db']['database'] ='lp';

//ansluter till DB med referenser från settings.inc.php
//Sätter ett error-meddelenaden.
$dsn='mysql:dbname='.$settings['db']['database'].';host='.$settings['db']['host'];

//testar och ser om det funkar att koppla till databasen
try {
    $dbh = new PDO($dsn, $settings['db']['user'],$settings['db']['password']);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//om det blir fel så kommer ett lättläsligt felmeddelanden som vi kan styra själva
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
}

global $dbh;