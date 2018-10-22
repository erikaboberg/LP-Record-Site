<?php
/**
 * Created by PhpStorm.
 * User: albin
 * Date: 23/03/18
 * Time: 12:57
 */

echo "<h1>Artist</h1>";
//echo "<pre>";

if ($templateData['searchResult']['artist'] == null) {
    echo "<h3> Inga sökresultat </h3>";
} else {
    foreach ($templateData['searchResult']['artist'] as $artist) {

        printf("<a href=?controller=artist&name=%s>%s</a>", $artist['artist_name'], $artist['artist_name'] . "<br>");
    }
}


echo "<h1>Album</h1>";

if ($templateData['searchResult']['album'] == null) {
    echo "<h3> Inga sökresultat </h3>";
} else {
    foreach ($templateData['searchResult']['album'] as $album) {

        printf("<a href=?controller=album&album_id=%s>%s</a>", $album['album_id'], $album['album_title'] . "<br>");

    }
}


echo "<h1>Låtar</h1>";
//echo "<pre>";
//print_r($templateData['searchResult']['track']);

if ($templateData['searchResult']['track'] == null) {
    echo "<h3> Inga sökresultat </h3>";
} else {
    foreach ($templateData['searchResult']['track'] as $track) {

        printf("<a href=?controller=album&album_id=%s>%s</a>", $track['album_id'], $track['track_name'] . "<br>");

    }
}









