<?php
/**
 * Created by PhpStorm.
 * User: albin
 * Date: 18/04/18
 * Time: 13:28
 */
global $dbh;
$templateData['alphabet'] = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'Å', 'Ä', 'Ö');
$templateData['page'] = 'album';


if (isset($_GET['first-letter'])){

$firstLetter = $_GET['first-letter'];
}

//visar alla album om det inte finns någn get param.
if (!isset($_GET['first-letter'])) {
    $sql = " SELECT * FROM  album
JOIN artist ON album.artist_id = artist.artist_id";

    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $templateData['album'] = $result;

} else {


    $sql = "SELECT * FROM  album
JOIN artist ON album.artist_id = artist.artist_id
WHERE album.album_title LIKE ?;";

    $searchString = $firstLetter . '%';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(1, $searchString);
    $stmt->execute();
    $templateData['album'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$titleData[] = "Album";
if (isset($firstLetter)) {
    $titleData[] = $firstLetter;
} else {
    $titleData[] = "Alla";
}

$templateData['titleData'] = $titleData;

loadTemplate('albums', $templateData);