<?php
/**
 * Created by PhpStorm.
 * User: albin
 * Date: 20/04/18
 * Time: 13:42
 *
 */
$templateData['page'] = 'about';
$titleData[] = "Om oss";
$templateData['titleData'] = $titleData;

global $dbh;
$sql = "SELECT * FROM content";

$stmt = $dbh->query($sql);
$stmt->execute();
$templateData['about'] = $stmt->fetchAll(PDO::FETCH_ASSOC);



loadTemplate('about', $templateData);

