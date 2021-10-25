<div class="imagenfondo" id="genresContainer">
    <!-- <h2 class="genreM"><?php echo $genrename; ?></h2> -->
    <?php foreach ($info as $key => $artists) { ?>
        <h3 id="genreTitle" class="genreTitle"><?php echo $key; ?></h3>
        <div class="artists">
            <?php foreach ($artists as $artist) { ?>
                <div class="artist">
                    <a href="javascript:loadPage('/artist/<?php echo $artist['user']; ?>')">
                        <?php if ($artist['avatar'] == "") { ?>
                            <img src="public/img/artists/profile.png" alt="avatar">
                        <?php } else { ?>
                            <img src="<?php echo $artist['avatar']; ?>" alt="avatar">
                        <?php } ?>
                        <h4><?php echo $artist['user']; ?></h4>
                    </a>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>