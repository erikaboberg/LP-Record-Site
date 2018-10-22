<?php
/**
 * Created by PhpStorm.
 * User: albin
 * Date: 23/03/18
 * Time: 13:12
 */
global $dbh;
echo "search result controller";

$queryString = $_POST['search'];


//Söker efter artister
$sqlArtist = "SELECT artist_id, artist_name FROM artist WHERE artist_name LIKE ?";
$searchString = '%' . $queryString . '%';
$stmt = $dbh->prepare($sqlArtist);
$stmt->bindParam(1, $searchString);
$stmt->execute();

$templateData['searchResult']['artist'] = $stmt->fetchAll(PDO::FETCH_ASSOC);


//söker efter album
$sqlAlbum = "SELECT album_id, album_title FROM album WHERE album_title LIKE ?";
$searchString = $queryString . '%';
$stmt = $dbh->prepare($sqlAlbum);
$stmt->bindParam(1, $searchString);
$stmt->execute();

$templateData['searchResult']['album'] = $stmt->fetchAll(PDO::FETCH_ASSOC);


//söker efter låtar
//$sqlTrack = "SELECT track_id, track_name FROM track WHERE track_name LIKE ?";

$sqlTrack = "SELECT album.album_id , track.track_name 
FROM  album
JOIN album_track ON album.album_id = album_track.album_id
JOIN track ON album_track.track_id = track.track_id
WHERE track.track_name LIKE ?;";

$searchString = $queryString . '%';
$stmt = $dbh->prepare($sqlTrack);
$stmt->bindParam(1, $searchString);
$stmt->execute();

$templateData['searchResult']['track'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

loadTemplate('search-result', $templateData);














