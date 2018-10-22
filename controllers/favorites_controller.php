<?php

// Erika Boberg 

global $dbh;
$templateData['page'] = 'favo';


$titleData[] = "Våra favoriter";
$templateData['titleData'] = $titleData;



 	function getFavourites() { 

 		global $dbh;
		$sql = "SELECT * FROM favourites, album WHERE favourites.favourites_id = album.album_id ";
 		$stmt = $dbh->query($sql);
 		return $stmt->fetchAll(PDO::FETCH_ASSOC);
 		
 	}



loadTemplate('favorites', $templateData);

 ?>