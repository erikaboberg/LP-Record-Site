<?php
//funktion för att inkludera templatefiler
//$templateData skickas som en variabel för att lösa problemet med scope i funktionen
//dessutom gör det att templatedatan finns tillgänglig under samma variabelnamn i ALLA templates
function loadTemplate($templateName, $templateData){

    require ('templates/head.tpl.php');
   require ('templates/menu.tpl.php');
    require('templates/'.$templateName.'.tpl.php');
   require ('templates/footer.tpl.php');
}