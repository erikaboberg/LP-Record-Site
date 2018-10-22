<div class="cartContainer">
    <div class="cartInfo">
        <?php

        //        print_r($templateData['cart']);
        //echo "<pre>";
        //print_r($_SESSION['cart']);

        $totalPrice = 0;
        if (isset($templateData['cart'])) {


            foreach ($templateData['cart'] ?? null as $info) {
                echo "<form method='post' action='?controller=cart'>";

                echo "<div class='cartInfoAlbumImg'>";
                printf("<a href='?controller=album&album_id=%s'> <img src=%s></a>", $info['album_id'], $info['album_img']);
                printf("<label>%s </label>", $info['album_title']);
                printf("<label>%s:-</label>", $info['album_price']);
                printf("<label>Antal:</label><input type='number' name='newCartItem[album_amount]' value='%s'>", $info['album_amount']);
                printf("<input type=hidden name='newCartItem[album_id]' value=%s>", $info['album_id']);

                printf("<button type='submit' name='newCartItem[btnChoice]' value='update'>Uppdatera </button>");

                printf("<button type=submit name='newCartItem[btnChoice]' value='delete'>Ta bort</button>");
                $totalPrice += $info['album_price'] * $info['album_amount'];


                echo "</div></form>";
            }
        }

        ?>

        <hr>
        <div class="overView">
            <h2>Översikt</h2>
            <form action="?controller=payment" method="post">
                <label class="totalPrice">Totalt pris: <?php echo $totalPrice ?> </label>
                <label class="shippingLabel">Frakt: Gratis! </label>
                <button type="submit">Till betalning</button>
            </form>
        </div>
    </div>

</div>
<?php

// $templateData['cart']['totalPrice'] = $totalPrice;
// $_SESSION['cart']['totalPrice'] = $totalPrice;
// echo $_SESSION['totalPrice'];
// echo $totalPrice;

// echo "<pre>";
// echo "session";
// print_r($_SESSION['cart']);
// echo "<hr>";
// print_r($templateData); 

//sets the required info for the checkout as sessions /Rasmus
$_SESSION['totalPrice'] = $totalPrice;
$_SESSION['cartAllInfo'] = $templateData;

?>


