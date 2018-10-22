<?php
/**
 * Created by PhpStorm.
 * User: albin
 * Date: 06/06/18
 * Time: 17:42
 */

if (isset($_SESSION['userLoggedIn'])) {
    echo '
    <ul class="adminSideNav">
        <li><a href="?controller=account&action=orders">Mina ordrar</a></li>
        <li><a href="?controller=account&action=edit-info">Ändra uppgifter</a></li>
        <li><a href="?controller=logout">Logga ut</a></li>
        <li class="pull-right"><a href="?controller=account&action=delete">Ta bort konto</a></li>
    </ul>';

    printf("<h1>Välkommen %s</h1>", $templateData['firstname']);
    if ($templateData['choice'] == 'orders') {

        /*
                $currentOrder = null;

                foreach ($templateData['order'] as $order) {
                    if ($order['order_id'] !== $currentOrder) {
                        print('<hr>');
                        printf('<h4>Order ID:  %s</h4>', $order['order_id']);
                        print('<p>Status:</p>');
                        printf('<form action="?controller=adminorders&action=update&oid=%s" method="POST">',$order['order_id']);
                        printf('<select name="statusOption[%s]">', $order['order_id']);
                        //för att visa statusar
                        /*foreach ($templateData['status'] as $status){
                            if($status['status_id'] == $order['status']) {
                                $selected = 'selected';
                            } else {
                                $selected = "";
                            }

                            printf('<option value="%s" %s>%s</option>', $status['status_id'], $selected, $status['status_name']);
                        }
                        print(' </select>');

                     //   printf('<button type="submit" name="%s">Ändra status</button>',$order['order_id']);
                        printf('<p>Orderdatum:  %s</p>', $order['timestamp']);
                        printf('<p>Namn:  %s</p>', $order['firstname']. " " .$order['lastname']);
                        printf('<p>Email:  %s</p>', $order['email']);
                        printf('<p>Leveransadress:  %s</p>', $order['deliveryadress']);
                        printf('<p>Betalningssätt:  %s</p>', $order['payment_type']);
                        $currentOrder = $order['order_id'];
                    }
                    printf('<p>Produkt:  %s, %s x %s</p> ', $order['product_titel'], $order['colour'], $order['amount']);
                    printf('<p>Produkt pris ex vat:  %s</p>', $order['product_price_ex_vat']);
                }
                print('<hr>');
                print('</div>');
                print('<a class="goBackLink" href="?controller=admin">Gå Tillbaka</a>');

















                ?>
                <table>
                    <tr>
                        <th>Order ID</th>
                        <th>Datum</th>
                        <th>Artist</th>
                        <th>Album</th>
                        <th>Antal</th>
                        <th>Styckpris</th>
                        <th>Orderstatus</th>
                        <th>Leveransadress</th>
                        <th>Fakturaadress</th>
                        <th>Totalpris</th>
                    </tr>
                    <?php

                    $totalprice = "en miljon";

                    $invoiceAddress = "Coming soon";

                    foreach ($templateData['order'] as $order) {
                        printf("<tr>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        </tr>",
                            $order['order_id'], $order['order_timestamp'], $order['artist_name'], $order['album_title'], $order['amount'],
                            $order['price'], $order['status_order'],
                            $order['delivery_street'] . ", " .
                            $order['delivery_zip'] . ", " .
                            $order['delivery_city'],
                            $invoiceAddress, $totalprice );
                    }

                    ?>
                </table>
                <?php
         */
        echo "<table>
            <tr>
                <th>Order ID</th>
                <th>Datum</th>
                <th>Orderstatus</th>
                <th>Leveransadress</th>
                <th>Fakturaadress</th>
                <th>Totalpris</th>
                <th>Mer information</th>
              
            </tr>";

        $currentOrder = null;

        foreach ($templateData['order'] as $order) {

            if ($order['order_id'] !== $currentOrder) {
                print('<tr>');

                printf("<td>%s</td>", $order['order_id']);
                printf("<td>%s</td>", $order['order_timestamp']);
                printf("<td>%s</td>", $order['status_order']);
                printf("<td>%s</td>", $order['delivery_street'] . ", " .
                    $order['delivery_zip'] . ", " .
                    $order['delivery_city']);
                printf("<td>%s</td>", $order['address_street'] . ", " .
                    $order['address_zip'] . ", " .
                    $order['address_city']);
                foreach ($templateData['totalPrices'] as $key => $totalPrice) {
                    if ($order['order_id'] == $key) {
                        printf("<td>%s</td>", $totalPrice);
                    }
                }
                printf("<td class='th_td_last'><a href='?controller=account&action=more-info&id=%s'><i class='fas fa-list-alt delete'></i></a></td>", $order['order_id']);

                print("</tr>");


            }
            $currentOrder = $order['order_id'];


/*
            print("<tr>");

            print ('<td colspan="10">');

            echo "<table>
            <th>Produkt</th>
                <th>Antal</th>
                                <th>Styckpris</th>
";
            foreach ($templateData['order']  as $orders) {

                echo "<tr>";
                printf("<td>%s</td>", $orders['artist_name'] . " - " . $orders['album_title']);
                printf("<td>%s</td>", $orders['amount']);
                printf("<td>%s</td>", $orders['price']);
                echo "</tr>";
            }

            echo "</table>";

            print("</tr>");
*/
            $currentOrder = $order['order_id'];


            // printf('<form action="?controller=adminorders&action=update&oid=%s" method="POST">',$order['order_id']);
            //printf('<select name="statusOption[%s]">', $order['order_id']);
            //för att visa statusar
            /*   foreach ($templateData['status'] as $status){
                   if($status['status_id'] == $order['status']) {
                       $selected = 'selected';
                   } else {
                       $selected = "";
                   }*/

            // printf('<option value="%s" %s>%s</option>', $status['status_id'], $selected, $status['status_name']);

            // print(' </select>');
            //   printf('<button type="submit" name="%s">Ändra status</button>',$order['order_id']);
            /*  printf('<p>Orderdatum:  %s</p>', $order['timestamp']);
              printf('<p>Namn:  %s</p>', $order['firstname'] . " " . $order['lastname']);
              printf('<p>Email:  %s</p>', $order['email']);
              printf('<p>Leveransadress:  %s</p>', $order['deliveryadress']);
              printf('<p>Betalningssätt:  %s</p>', $order['payment_type']);

          printf('<p>Produkt:  %s, %s x %s</p> ', $order['product_titel'], $order['colour'], $order['amount']);
          printf('<p>Produkt pris ex vat:  %s</p>', $order['product_price_ex_vat']);
            */
            //   $currentOrder = $order['order_id'];

            //}
            //  print('<hr>');
            // print('</div>');
            // print('<a class="goBackLink" href="?controller=admin">Gå Tillbaka</a>');
            //   echo "<table>";

        }
    }

    if ($templateData['choice'] == 'more-info') {
        $currentOrder = null;
        foreach ($templateData['specific-orders'] as $order) {
            if ($order['order_id'] !== $currentOrder) {
                print('<hr>');
                printf('<h4>Order ID:  %s</h4>', $order['order_id']);
                printf('<p><b>Status: %s</b></p>', $order['status_order']);
                printf('<p>Orderdatum:  %s</p>', $order['order_timestamp']);
                printf('<p>Namn:  %s</p>', $order['person_firstname'] . " " . $order['person_lastname']);
                printf('<p>Email:  %s</p>', $order['person_email']);
                printf('<p>Leveransadress:  %s</p>', $order['delivery_street'] . ", " .
                    $order['delivery_zip'] . ", " .
                    $order['delivery_city']);
                printf('<p>Fakturaadress:  %s</p>', $order['address_street'] . ", " .
                    $order['address_zip'] . ", " .
                    $order['address_city']);
                $currentOrder = $order['order_id'];


            }

            printf('<p>Produkt:  %s - %s x %s</p> ', $order['artist_name'], $order['album_title'], $order['amount']);
            printf('<p>Styckpris:  %s</p>', $order['price']);
        }

        print('<hr>');
        print('</div>');
        print("<a href='?controller=account&action=orders'>Gå tillbaka</a>");
    }
    if ($templateData['choice'] == 'edit-info') {

        echo "<form method='post' action='?controller=account&action=save'>";
        printf("<label>Förnamn </label><input class='type_in_field' type='text' name='editUserInfo[fName]' value='%s'><br>", $templateData['user-info'][0]['person_firstname']);
        printf("<label>Efternamn </label><input class='type_in_field' type='text' name='editUserInfo[lName]' value='%s'><br>", $templateData['user-info'][0]['person_lastname']);
        printf("<label>Email </label><input class='type_in_field' type='text' name='editUserInfo[email]' value='%s'><br>", $templateData['user-info'][0]['person_email']);
        print("<label>Lösenord </label><input  class='type_in_field' type='text' name='editUserInfo[pass]'><br>");
        echo "<button type='submit' class='type_in_button'>Spara ändringar</button>";
        echo "</form>";

        echo "<pre>";
        print_r($templateData['user-info']);
    }

    if ($templateData['choice'] == 'delete') {
        echo "<form method='post' action='?controller=account&action=confirm-delete'>";
        echo "<button type='submit'>Klicka för att radera ditt konto!</button>";
        echo "</form>";
    }

} else {

    header("Location: ?controller=default");

}

