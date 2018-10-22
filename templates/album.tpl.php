<?php
/**
 * Created by PhpStorm.
 * User: albin
 * Date: 20/04/18
 * Time: 13:42
 */


//TODO: kontrollera att album_id finns i db, annars skicka tillbaka användaren till alla skivor/startsidan.
//classanrop för att skriva ut alphabetsmenyn
Alphabet::printAlphabet('albums', 'first-letter');
?>

<hr>
<h2>Album</h2>



<div class="mainInfoDiv col-12">
<div class="imgDiv col-3">
    <img src=' <?php echo $templateData['albumInfo'][0]['album_img'] ?> ' alt="album image">


</div>
<div class="albumInfo col-8">
    <?php


    echo "<form method='post' action='?controller=cart&action=add'>";
    echo "<button type=submit>Lägg till i varukorgen</button>";
    echo "<input type=text name='newCartItem[album_amount]'>";
    printf("<p>%s</p>", $templateData['albumInfo'][0]['album_title']);
    printf("<input type=hidden value=%s name=newCartItem[album_id]",$templateData['albumInfo'][0]['album_id'] );
    printf("<a href=#>%s</a>", $templateData['albumInfo'][0]['artist_name'] ,$templateData['albumInfo'][0]['artist_name']);
    printf("<p>%s:-</p>", $templateData['albumInfo'][0]['album_price']);
    printf("<p>%s</p>", $templateData['albumInfo'][0]['album_desc']);
    printf("<p>%s</p>", $templateData['albumInfo'][0]['category_name']);
    $count = 1;
    foreach ($templateData['albumInfo'] as $row) {
        printf("<ul class='trackList'><li>%s</li></ul>",$count . ". " . $row['track_name']);
        $count ++;

    }
    echo "</form>";


    ?>


</div>





<div class="moreOfSameArtist">
    <?php

    //echo "<pre>";
    //print_r($result);
    foreach ($templateData['moreAlbum'] as $row) {

        printf('<a href="?controller=album&album_id=%s"> 
            <img class="moreSameArtistImge" src=%s alt="album-image">     
               </a>', $row['album_id'], $row['album_img']);
    }


    ?>


</div>


