<?php
/**
 * Created by PhpStorm.
 * User: albin
 * Date: 18/04/18
 * Time: 15:12
 */

class alphabet
{

    public static $alphabet = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'Å', 'Ä', 'Ö');

    public static function printAlphabet($controller, $action)
    {
        print("<div class='alphabetDiv'><ul class='alphabet'>");
        foreach (self::$alphabet as $letter) {



            $elemclass = "";
            if (isset($_GET['first-letter']) && $letter == $_GET['first-letter']) {
                $elemclass = "active-letter";
            }
            printf("<li class='letter'><a href=?controller=$controller&$action=%s class='letter_link %s'>%s</a></li>", $letter, $elemclass, $letter);

        }
        print "<a class='letter_link letter' href=?controller=artists>Visa alla</a>";
        print("</ul></div>");

    }



}


// alphabet::printAlphabet('controller namn', "action get param");





