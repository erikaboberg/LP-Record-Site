<?php
/**
 * Created by PhpStorm.
 * User: albin
 * Date: 23/03/18
 * Time: 13:12
 */
global $dbh;
//variabel som bestämmer vad sidan "heter" för att kunna sätta class=active på menyn så man ser vilken sida som besöks
$templateData['page'] = 'album';

$templateData['alphabet'] = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','Å','Ä','Ö');
$album_id = (integer)$_GET['album_id'];


//VISA ALLA ALBUM
/*if (!isset($_GET['first-letter'])){
    $sql = " SELECT * FROM  album
JOIN album_track ON album.album_id = album_track.album_id
JOIN artist ON album.artist_id = artist.artist_id";

    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll();
    $templateData['album'] = $result;
}*/

$sql = "
SELECT * FROM  album
JOIN album_track ON album.album_id = album_track.album_id
JOIN track ON album_track.track_id = track.track_id
JOIN artist ON album.artist_id = artist.artist_id
JOIN category_album ON album.album_id = category_album.album_id
JOIN category ON category_album.category_id = category.category_id
WHERE album.album_id = '$album_id';
";

$stmt = $dbh->query($sql);
$result = $stmt->fetchAll();
$templateData['albumInfo'] = $result;
//echo "<pre>";
//var_dump( $templateData['albumInfo']) ;

$artist_id = $templateData['albumInfo'][0]['artist_id'];
//echo $artist_id;

$sql = "SELECT album_id, album_img FROM album WHERE album.artist_id = ?;";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(1 ,$artist_id );
$stmt->execute();
$templateData['moreAlbum'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($templateData['moreAlbum']);
$firstLetter = $_GET['first-letter'] ?? null;

$titleData[] = 'Album';
$titleData[] = $templateData['albumInfo'][0]['artist_name'];
$titleData[] = $templateData['albumInfo'][0]['album_title'];

$templateData['titleData'] = $titleData;




loadTemplate('album',$templateData);
