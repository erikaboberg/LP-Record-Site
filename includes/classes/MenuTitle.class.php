<?php
/**
 * Created by PhpStorm.
 * User: albin
 * Date: 23/04/18
 * Time: 09:52
 */

//definerar en konstant som är LP - och visas alltid i tabben på webbläsaren
define("TAB_TITLE_PREFIX", "LP - ");

class MenuTitle
{

    public static function getTitle($currentPage)
    {
            $returnData = TAB_TITLE_PREFIX ;
            $returnData .= implode(" - ", $currentPage);

        return $returnData;



    }


}