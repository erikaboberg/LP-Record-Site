<?php
/**
 * Created by PhpStorm.
 * User: albin
 * Date: 06/06/18
 * Time: 17:41
 */

//$fullName =
$userEmail = $_SESSION['userLoggedIn'];
$action = $_GET['action'] ?? null;

$templateData['choice'] ="" ?? null;

$sql = "SELECT person_id, person_firstname, person_lastname, person_email FROM person WHERE person_email = ?";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(1, $userEmail);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$templateData['firstname'] = $result[0]['person_firstname'];
$templateData['user-info'] = $result;
$person_id = $result[0]['person_id'];

if ($action == 'orders') {
    $templateData['choice'] = 'orders';
    $sql = "SELECT * FROM `order`
 JOIN order_album ON `order`.order_id = order_album.order_id
 JOIN album ON album.album_id = order_album.album_id
 JOIN delivery ON delivery.delivery_id = `order`.delivery_id
 JOIN artist ON artist.artist_id = album.artist_id
 JOIN address on `order`.person_id = address.person_id
 WHERE `order`.person_id = $person_id;
 ";


    $stmt = $dbh->query($sql);
    //$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $templateData['order'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $price = array();
    foreach ($templateData['order'] as $order) {
        $price[$order['order_id']] += $order['price'] * $order['amount'];
    }

    $templateData['totalPrices'] = $price;
    //echo "<pre>";
 //   print_r($templateData['totalPrices']);

    /*   $result = array();
       foreach ($data as $element) {
           $result[$element['order_id']][] = $element;
       } */
    //print_r($templateData['order']);
    //print_r($_SESSION);

}

if ($action == 'edit-info') {
    $templateData['choice'] = 'edit-info';
}

if ($action == 'more-info') {
    $order_id = $_GET['id'];



    $sql = "SELECT * FROM `order` 
 JOIN order_album ON `order`.order_id = order_album.order_id
 JOIN album ON album.album_id = order_album.album_id
 JOIN delivery ON delivery.delivery_id = `order`.delivery_id
 JOIN artist ON artist.artist_id = album.artist_id
 JOIN person ON person.person_id =  `order`.person_id
JOIN address on person.person_id =  address.person_id
 WHERE `order`.order_id = $order_id;";

    $stmt = $dbh->query($sql);
    $templateData['specific-orders'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $templateData['choice'] = 'more-info';


}


if ($action == 'save') {
    //  echo "<pre>";
    print_r($_POST);
    $sql = "UPDATE person 
SET person_firstname = ?, person_lastname = ?, person_email = ?, person_password  = ?
WHERE person_id = $person_id";

    $pw = md5($_POST['editUserInfo']['pass']);

    echo $_POST['editUserInfo']['fName'];

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(1, $_POST['editUserInfo']['fName']);
    $stmt->bindParam(2, $_POST['editUserInfo']['lName']);
    $stmt->bindParam(3, $_POST['editUserInfo']['email']);
    $stmt->bindParam(4, $pw);
    $stmt->execute();

}
if ($action == 'delete') {
    $templateData['choice'] = 'delete';
}

if ($action == 'confirm-delete') {

    $sql = "DELETE FROM person WHERE person_id = $person_id";
    $stmt = $dbh->query($sql);
    unset($_SESSION['userLoggedIn']);
    header("location: ?controller=default");


}
$titleData[] = 'Mitt Konto';


$templateData['titleData'] = $titleData;

loadTemplate('account', $templateData);