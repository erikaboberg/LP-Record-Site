
<body>
<div class="main_container">
    <header>

        <div class="topnav">
            <a href="?controller=default"> <img src="images/lp-logo.png" height="100px" alt="LP-logo"></a>
            <div class="search_container">
                <?php if (isset($_SESSION['userLoggedIn'])) {
                    echo "<a href=\"?controller=account\"><i class=\"far fa-user\"></i><span>Mitt konto</span></a>";
                } else {
                    echo "<a href=\"?controller=login-register\"><i class=\"far fa-user\"></i><span>Logga in/Registrera</span></a>";
                }


                ?>
                <a href="?controller=cart"><i class="fas fa-shopping-cart"></i><span>Varukorg</span><label
                            class="amount">(<?php if (isset($_SESSION['cart'])) echo array_sum($_SESSION['cart'] ?? null); ?>
                        )</label></a>

                <form action="?controller=search" method="post">
                    <input type="text" placeholder="sök artist, album eller låt..." name="search" class="type_in_field">

                </form>

            </div>

        </div>
        <nav class="main-nav">
            <ul>
                <li class="<?php if ($templateData['page'] == 'artists') {
                    echo 'active';
                } ?>"><a href="?controller=artists">artister</a></li>
                <li class="<?php if ($templateData['page'] == 'album') {
                    echo 'active';
                } ?>"><a href="?controller=albums">album</a></li>
                <li class="<?php if ($templateData['page'] == 'cat') {
                    echo 'active';
                } ?>"><a href="?controller=categories">kategorier</a></li>
                <li class="<?php if ($templateData['page'] == 'favo') {
                    echo 'active';
                } ?>"><a href="?controller=favorites">favoriter</a></li>
                <li class="<?php if ($templateData['page'] == 'about') {
                    echo 'active';
                } ?>"><a href="?controller=about">Om oss</a></li>
            </ul>
        </nav>
    </header>
    <div class="inner_container">

<?php //echo $_SESSION['userLoggedIn'] ?>