<?php
/**
 * Created by PhpStorm.
 * User: albin
 * Date: 20/04/18
 * Time: 13:42
 */

//classanrop för att skriva ut alphabetsmenyn
Alphabet::printAlphabet('artists', 'first-letter');
echo "<hr>";
echo "<h1>Artister</h1>";

//echo "<pre>";
//print_r($templateData['letter']);
foreach ($templateData['letter'] as $artist) {

    $templateData['pageTab'] = $artist['artist_name'];
    //printf("<li><a href='?controller=artist&name=%s'>%s</a>",$artist['artist_name'], $artist['artist_name'] . "</li>");

    echo "<div class=contentSmall>";
    printf("<a href=?controller=artist&name=%s>", $artist['artist_name']);
    printf("<img src=%s class='albumImg'>", $artist['artist_img']);
    printf("<span>%s</span>", $artist['artist_name']);
    echo "</a>";
    echo "</div>";


}
