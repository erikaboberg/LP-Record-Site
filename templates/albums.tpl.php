<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/album-css.css">
    <link rel="stylesheet" href="css/artist-css.css">
    <title>Document</title>
</head>
<body>

</body>
</html>


<?php
/**
 * Created by PhpStorm.
 * User: albin
 * Date: 18/04/18
 * Time: 13:27
 */

Alphabet::printAlphabet('albums', 'first-letter');

//echo "<pre>";
//print_r($templateData['album']);

foreach ($templateData['album'] as $item) {

    echo "<div class=contentSmall>";
    printf("<a href=?controller=album&album_id=%s>", $item['album_id']);
    printf("<img src=%s class=''>" , $item['album_img']);
    printf("<span>%s</span>", $item['album_title']);
    printf("<span>%s</span>", $item['artist_name']);
    echo "</a>";
    echo "</div>";
}



