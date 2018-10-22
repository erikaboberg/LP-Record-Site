<?php
/**
 * Created by PhpStorm.
 * User: albin
 * Date: 06/06/18
 * Time: 17:55
 */


Account::logout();
header("Location: ?controller=default");
