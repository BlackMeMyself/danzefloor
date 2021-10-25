<div class="imagenfondo">
    <div class="searchresult">
        <?php if (count($users) > 0) {  ?>
            <h2 id="lang-artists"  class="mysets">ARTISTS</h2>
            <?php foreach ($users as $user) { ?>
                <div class="artist">
                    <a href="javascript:loadPage('/artist/<?php echo $user['user']; ?>')">
                        <?php if ($user['avatar'] == "") { ?>
                            <img src="public/img/artists/profile.png" alt="avatar">
                        <?php } else { ?>
                            <img src="<?php echo $user['avatar']; ?>" alt="avatar">
                        <?php } ?>
                        <h4><?php echo $user['user']; ?></h4>
                    </a>
                </div>
        <?php }
        } ?>
        <?php if (count($files) > 0) {  ?>
            <h2 id="lang-tracks" class="mysets">SETS/TRACKS</h2>
            <?php foreach ($files as $file) { ?>
                <div class="capsulamy">
                    <a href="javascript:playThis('<?php echo $file['name']; ?>',<?php echo $file["id_user"] ?>,<?php echo $file["type"] ?>,'<?php echo $file["image"] ?>','<?php echo $file["username"] ?>')"><i class="fa fa-play" aria-hidden="true"></i></a>
                    <?php if (isset($_SESSION["user"])) { ?>
                        <a href="javascript:addFavorites('<?php echo $file["id"] ?>','<?php echo $file["id_user"] ?>')"><i class="fa fa-heartbeat heart" aria-hidden="true"></i></a>
                    <?php } ?>
                    <a href="<?php if($file["type"] == 0) { echo "sets/".$file["id_user"]."/".$file["name"]; }else{ echo "tracks/".$file["id_user"]."/".$file["name"]; } ?>" download="<?php if($file["type"] == 0) { echo "sets/".$file["id_user"]."/".$file["name"]; }else{ echo "tracks/".$file["id_user"]."/".$file["name"]; } ?>"><i class="fa fa-download downl" aria-hidden="true"></i></a>
                    <h3><a href="javascript:loadPage('/track/<?php echo $file["id"] ?>')"><?php echo $file["name"] ?></a></h3>
                </div>
        <?php }
        } ?>
    </div>
</div>
<script>
  $(document).ready(function(){
        backurl.push("/search/<?php echo $keyword ?>");
    });
    
    function playThis(title, user, type, image,username) {
        if (type == 0) {
            type = 'sets';
        } else {
            type = 'tracks';
        }
        track_list = [{
            name: title,
            artist: username,
            image: image,
            path: type+'/'+user+'/'+title
        }]
        loadTrack(track_index);
        playTrack();
    }

</script>