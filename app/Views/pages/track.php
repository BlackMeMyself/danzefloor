<div class="imagenfondo">
    <div class="track">
        <?php if ($user['avatar'] == "") { ?>
            <img src="public/img/artists/profile.png" alt="avatar">
        <?php } else { ?>
            <img src="<?php echo $user['avatar']; ?>" alt="avatar">
        <?php } ?>
        <div class="trackinfo">
            <h3><span>NAME: </span><?php echo $track["name"]?></h3>
            <h3><span>ARTIST: </span><?php echo $user["user"]?></h3>
            <h3><span>GENRE: </span><?php echo $track["genre"]?></h3>
            <h3><span>FORMAT: </span><?php echo $track["format"]?></h3>
            <h3><span>DATE: </span><?php echo $track["upload_date"]?></h3>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        backurl.push("/track/<?php echo $id ?>")
    });

</script>