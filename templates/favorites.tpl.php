<!-- Erika Boberg -->


<div class="favoritePageContainer">

<div class="favoriteContainer" class="row">
       
        <h2> Våra favoriter </h2>
      	<?php
        $ourFavourites = getFavourites();

        foreach ($ourFavourites as $album) {
            printf("<a href='?controller=album&album_id=%s'> <img src=%s></a>", $album['album_id'], $album['album_img']);
            // printf("<span>%s</span>", $item['album_title']);
        }
  ?>

</div>

</div>


