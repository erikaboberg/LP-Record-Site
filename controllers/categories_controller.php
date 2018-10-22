<?php
/**
 * Created by PhpStorm.
 * User: albin
 * Date: 18/04/18
 * Time: 09:20
 */


global $dbh;
$catId = $_GET['categoryId'] ?? null;




//variabel som bestämmer vad sidan "heter" för att kunna sätta class=active på menyn så man ser vilken sida som besöks
$templateData['page'] = 'cat';

try {

//Hämta alla kategorier
    $sql = "SELECT * FROM category";
    $stmt = $dbh->query($sql);
    $templateData['categories'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Hitta kategorinamn baserat på getparam som är categori-id
  /*  $sql = "SELECT category_name FROM category WHERE category_id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(1, $catId);
    $stmt->execute();
    $templateData['cat_name'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
  */
    $label = "Not found";
    foreach ($templateData['categories'] as $cat) {

        if ($cat['category_id'] == $catId) {
            $templateData['cat_name'] = $cat['category_name'];
            break;
        }
    }



//hämta ut info baserat på catid

    $sql = "SELECT * FROM category_album
JOIN category ON category_album.category_id = category.category_id
JOIN album ON category_album.album_id = album.album_id
JOIN artist ON album.artist_id = artist.artist_id
WHERE category.category_id = ?";

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(1, $catId);
    $stmt->execute();

    $templateData['cat_info'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /* if (empty($templateData['cat_info'])) {

        $templateData['cat_info'] = "<h3>Inga resultat hittades...<h3>";

    }*/


} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();

}
$titleData[] = "Kategorier";
if (isset($templateData['cat_name'])) {
    $titleData[] =  $templateData['cat_name'];
} else {
    $titleData[] = "Alla";
}


$templateData['titleData'] = $titleData;

loadTemplate('categories', $templateData);

