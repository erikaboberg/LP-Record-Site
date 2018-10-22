<?php

// Erika Boberg

global $dbh;


//echo "Nu körs default controller";
$templateData['page'] = 'start';
$titleData[] = "Start";
$templateData['titleData'] = $titleData;


// Visa 5 artister

	function getArtists($count = 5) { 
	    global $dbh;
		$sql = "SELECT artist_name, artist_id, artist_img FROM artist LIMIT $count";
 		$stmt = $dbh->query($sql);
 		return $stmt->fetchAll(PDO::FETCH_ASSOC);		
 	
 	}

// Visa våra 5 senaste album

	function getAlbums($count = 5) { 
		global $dbh;
		$sql = "SELECT * FROM lp.album ORDER BY album_id DESC LIMIT $count";
 		$stmt = $dbh->query($sql);
 		return $stmt->fetchAll(PDO::FETCH_ASSOC);	

 	}

 // Visa 5 favoriter

 	function getFavourites($count = 5) { 

 		global $dbh;
		$sql = "SELECT * FROM favourites, album WHERE favourites.favourites_id = album.album_id 
		LIMIT $count";
 		$stmt = $dbh->query($sql);
 		return $stmt->fetchAll(PDO::FETCH_ASSOC);
 		

 		/* var_dump($resultFavourites);
 		foreach ($resultFavourites as $row) {

        echo $row['album_img']; 
   
		} */ 
 	}


loadTemplate('default', $templateData);

