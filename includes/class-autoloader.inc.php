<?php

//funktion för att ladda rätt class.
function class_autoloader($classname)
{

    //om inte classfilen finns så returnera false
    if (!is_file('includes/classes/' . $classname . '.class.php')) {
        return false;
        throw new Exception("No class file found");
    }
    //annars inkludera filen:
    require_once 'includes/classes/' . $classname . '.class.php';
}