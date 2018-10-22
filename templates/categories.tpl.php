<?php
/**
 * Created by PhpStorm.
 * User: albin
 * Date: 20/04/18
 * Time: 13:42
 */


//Hämta ut värdet från arrayen baserat på catID

$catName = $templateData['cat_name'] ?? null;


if (!isset($catName) && is_null($catName)) {
    echo "<div class='categoryListDiv tiles'>";
} else {
    echo "<div class='categoryListDiv'>";

}
echo "<ul class='categoryList'>";
foreach ($templateData['categories'] as $item) {

    printf("<a href='?controller=categories&categoryId=%s'><li>%s</li></a>", $item['category_id'], $item['category_name']);
}

echo "</ul>";
echo "</div>";

if (isset($catName)) {


    printf("<h2 class='selectedAlbumCategory'>Album med kategori: %s</h2>", $templateData['cat_name']);

//Album innom denna kategor
    echo "<ul>";

    // var_dump($templateData['cat_info']);
    if (!$templateData['cat_info'])
        echo "Inga resultat";
    foreach ($templateData['cat_info'] as $item) {

        printf("<a href=?controller=album&album_id=%s><li>%s - %s </li></a>", $item['album_id'], $item['album_title'], $item['artist_name']);

    }
    echo "</ul>";


    printf("<h2 class='selectedArtistCategory'>Artister med kategori: %s</h2>", $templateData['cat_name']);
    if (!$templateData['cat_info'])
        echo "Inga resultat";
    $shown = [];
    foreach ($templateData['cat_info'] as $item) {

        if (!in_array($item['artist_name'], $shown)) {
            printf("<a href=?controller=artist&name=%s><li>%s </li></a>", $item['artist_name'], $item['artist_name']);
            $shown[] = $item['artist_name'];
        }

    }


}





