<!-- Erika Boberg -->

<!DOCTYPE html>
<html>
	<head>
		<title>LP</title>
		<meta charset="utf-8"/>
	</head>
	<body>

<h1>Start</h1>

 	<!-- Navigation --> 

	<div class ="navigation">
		<a href="#Artist">Artister</a>
	  	<a href="#Album">Album</a>
	  	<a href="#Favorites">Favoriter</a>
	</div>

	<!--Sökfält -->

	<form action="#" method="POST">
		<input type="text" name"search" placeholder"Sök">
		<button type="sumbit" name="submit-search">Sök</button>
	</form>

  


    <!--Album/Artister/Favoriter i boxar--> 
	
	<div class="defaultPageContainer">
		<div id="artistContainer" class="row"></div>
		<p> Artister </p>
		<!-- <?php // echo $album->artist; ?> -->
	</div> 

	<div class="defaultPageContainer">
		<div id="albumContainer" class="row"></div>
		<p> Senaste Albumen </p>
		<!-- <?php // echo $album->album; ?> -->
	</div> 

	<div class="defaultPageContainer">
		<div id="favoriteContainer" class="row"></div>
		<p> Våra Favoriter </p>
		

		<img src="../Adele.jpg" width=""> <img src="images/Lana.jpg" width="">
		<img src="images/Mumford.jpg" width=""> 
		
	</div> 


	<!--Footer -->

	<div class="footer">
	 © LP 
	</div>

</body>
</html>