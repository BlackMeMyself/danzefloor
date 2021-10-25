<div class="imagenfondo">
    <H2>ARTISTS</H2>
    <div class="artists">
        <?php if (isset($artists)) foreach ($artists as $item) { ?>
            <div class="artist">
                <a href="javascript:loadPage('/artist/<?php echo $item['user']; ?>')">
                    <?php if ($item['avatar'] == "") { ?>
                        <img src="public/img/artists/profile.png" alt="avatar">
                    <?php } else { ?>
                        <img src="<?php echo $item['avatar']; ?>" alt="avatar">
                    <?php } ?>
                    <h4><?php echo $item['user']; ?></h4>
                </a>
            </div>
        <?php } ?>
    </div>
</div>
<script>
    $(document).ready(function() {
        backurl.push("/artists");
    });
</script>