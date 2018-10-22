<?php
/**
 * Created by PhpStorm.
 * User: albin
 * Date: 23/03/18
 * Time: 13:13
 */

global $dbh;
$templateData['page'] = 'cart';

$titleData[] = "Kundvagn";
$templateData['titleData'] = $titleData;
//$action = $_POST['newCartItem']['btnChoice'];

if (isset($_GET['action']))
{$action = $_GET['action'];}
else if (isset($_POST['newCartItem']['btnChoice'])){
    $action = $_POST['newCartItem']['btnChoice'];
}




switch ($action ?? null) {
    case 'update':
    case 'add':
        $album_id = (integer)$_POST['newCartItem']['album_id'];
        $album_amount = (integer)$_POST['newCartItem']['album_amount'];

        if ($action === "add") {
            if (array_key_exists($album_id, $_SESSION['cart'])) {
                $album_amount = $album_amount + $_SESSION['cart'][$album_id];
            }
        }

        $_SESSION['cart'][$album_id] = $album_amount;
        //om antalet (album_amount) är mindre än 1 tas albumet bort ur sessionen
        if ($_SESSION['cart'][$album_id] < 1) {
            unset($_SESSION['cart'][$album_id]);
        }

        break;

     case "delete":
         $album_id = $_POST['newCartItem']['album_id'] ?? null;
        unset($_SESSION['cart'][$album_id]);
        break;



}


/* *
 * https://stackoverflow.com/questions/907806/passing-an-array-to-a-query-using-a-where-clause
 */

//loop för att spara om alla album_id i en ny array för att kunna använda i sql-frågan nedan
//castar till (int) för att ta bort ev. skadlig kod
if (!empty($_SESSION['cart'])){
foreach ($_SESSION['cart'] as $key => $item) {
    $arr[] = (int)$key;
}


//echo array_sum($_SESSION['cart']);

//$idInCart = array_keys($_SESSION['cart']);

//skapar en array/variabel med x antal ? i för att motverka SQL injection.
//$noOfParams = join(',', array_fill(0, count($arr), '?'));

//skapar en kommaseparerad sträng med värden för att använda som param till sql query
$params = implode(',', $arr);

//select fråga, använder IN för att skicka med multipla värden och här
$sql = "SELECT album_id, album_title, album_img, album_price FROM album WHERE album_id IN ($params)";
$stmt = $dbh->prepare($sql);

$stmt->execute();
//sparar resultatet från sql i templatedata
//loopar genom resultatet och skapar en nytt element som innehåller motsvarande antal som är sparade i $_SESSSION

while ($album = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $album['album_amount'] = $_SESSION['cart'][$album['album_id']];

   $templateData['cart'][] = $album;
}

}
//$amountInCart = array_sum($_SESSION['cart']);
//echo $amountInCart;


//echo "<pre>";
//print_r($_SESSION['cart']);
loadTemplate('shopping-cart', $templateData);