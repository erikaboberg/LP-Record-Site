<?php
/**
 * Created by PhpStorm.
 * User: albin
 * Date: 05/04/18
 * Time: 13:15
 */
global $dbh;
//variabel som bestämmer vad sidan "heter" för att kunna sätta class=active på menyn så man ser vilken sida som besöks


$templateData['alpbabet'] = $alphabet = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'Å', 'Ä', 'Ö');

if (!isset($_GET['first-letter'])) {
    $sql = "SELECT artist_name, artist_img FROM artist";
} else {

    $sql = "SELECT artist_name, artist_img FROM artist WHERE artist_name LIKE ?";
    $firstLetter = $_GET['first-letter'];
    $searchString = $firstLetter . '%';
}


$stmt = $dbh->prepare($sql);
$stmt->bindParam(1, $searchString);
$stmt->execute();
$templateData['letter'] = $stmt->fetchAll(PDO::FETCH_ASSOC);


$titleData[] = "Artister";

if (isset($firstLetter)) {
    $titleData[] = $firstLetter;
} else {
    $titleData[] = "Alla";
}

$templateData['titleData'] = $titleData;
$templateData['page'] = 'artists';


loadTemplate('artists', $templateData);
