<!-- Erika Boberg  -->

<div class="startPageContainer">

    <div class="artistContainer" class="row">
        <h2> Artister </h2>
        <?php
        $lastArtists = getArtists();

        foreach ($lastArtists as $artist) {
            printf("<a href='?controller=artist&name=%s'> <img src=%s></a>", $artist['artist_name'], $artist['artist_img']);
        }
        ?>
    </div>


    <div class="albumContainer" class="row">
        <h2> Senaste Albumen </h2>
        <?php

        $lastAlbums = getAlbums();

        foreach ($lastAlbums as $album) {
            printf("<a href='?controller=album&album_id=%s'> <img src=%s></a>", $album['album_id'], $album['album_img']);
        }
        ?>
    </div>


    <div class="favoriteContainer" class="row">
        <h2> Våra Favoriter </h2>
        <?php
        $ourFavourites = getFavourites();

        foreach ($ourFavourites as $album) {
            printf("<a href='?controller=album&album_id=%s'> <img src=%s></a>", $album['album_id'], $album['album_img']);
        }
        ?>
    </div>

</div>



