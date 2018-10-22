<?php
/**
 * Created by PhpStorm.
 * User: albin
 * Date: 23/03/18
 * Time: 13:12
 */
$templateData['alpbabet'] = $alphabet = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'Å', 'Ä', 'Ö');

$name = $_GET['name'];


//variabel som bestämmer vad sidan "heter" för att kunna sätta class=active på menyn så man ser vilken sida som besöks


/*
//$sql = "select * from artist where artist_name like '$artistLetter%' ";
$sql = "select artist_name from artist where artist_name like :artistLetter";

$searchString = $artistLetter .'%';
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":artistLetter", $searchString  );
$stmt->execute();
$templateData['artists'] = $stmt->fetchAll();

*/


$sql = "SELECT * FROM artist
JOIN album ON album.artist_id = artist.artist_id
WHERE artist.artist_name LIKE ?;";


$stmt = $dbh->prepare($sql);
$stmt->bindParam(1, $name);
$stmt->execute();
$templateData['specific-artist'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

$titleData[] = "Artister";
$titleData[] = $templateData['specific-artist'][0]['artist_name'];

$templateData['titleData'] = $titleData;
$templateData['page'] = 'artists';

loadTemplate('artist', $templateData);