<?php
/**
 * Created by PhpStorm.
 * User: albin
 * Date: 20/04/18
 * Time: 13:42
 */
//classanrop för att skriva ut alphabetsmenyn
Alphabet::printAlphabet('artists', 'name');
echo "<hr>";
// echo "<h1>Artister</h1>";


//echo "<pre>";
//print_r($result);
print("<ul class='artistNames'>");

/*foreach ($templateData['specific-artist'] as $artists) {

    printf("<li><a href='?controller=artist&artist=%s'>%s</a>", $artists['artist_name'], $artists['artist_name'] . "</li>");

}*/
print("</ul>");
printf("<h2>%s</h2>", $templateData['specific-artist'][0]['artist_name']);

printf("<img src=%s>", $templateData['specific-artist'][0]['artist_img']);

printf("<h2>%s</h2>", $templateData['specific-artist'][0]['artist_desc']);

echo "<hr>";
echo "<h1>Album</h1>";
//echo $templateData['specific-artist']['artist_img'];
foreach ($templateData['specific-artist'] as $artist) {


    printf("<a href='?controller=album&album_id=%s'> <img class='albumImg' src=%s></a>",$artist['album_id'], $artist['album_img']);


}

echo "<pre>";

/*
$sql = "SELECT * FROM artist
JOIN album ON album.artist_id = artist.artist_id
WHERE artist.artist_name like ?;";

echo $sql;

$stmt = $dbh->prepare($sql);
$stmt->bindParam(1, $artistName );
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<pre>";

print_r($result);


foreach ($result as $row) {
    printf("<h2>%s</h2>", $row['artist_name']);
    echo $row['artist_desc'];
}*/




