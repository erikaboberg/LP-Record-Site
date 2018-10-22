<?php
/**
 * Created by PhpStorm.
 * User: albin
 * Date: 20/04/18
 * Time: 13:42
 */

echo "<div class=aboutDiv>";
foreach ($templateData['about'] as $about) {
    printf("<h2>%s</h2>", $about['content_header']);
    printf("<p>%s</p>",$about['content_para_1']);
    printf("<p>%s</p>",$about['content_para_2']);
    printf("<img src='%s'>",$about['image']);

}
echo "</div>";


//echo "<pre>";
//print_r($templateData['about']);