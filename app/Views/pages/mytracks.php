<div class="imagenfondo">
    <h2 class="mytracks">MY TRACKS</h2>
    <div class="playall"><span onclick="playall()">PLAY ALL</span><span onclick="random()">RANDOM</span></div>
    <?php foreach ($tracks as $track) { ?>
        <div id="capsulamy" class="capsulamy">
            <a href="javascript:playThis('<?php echo $track['name']; ?>',<?php echo $track["id_artist"] ?>,<?php echo $track["type"] ?>,'<?php echo $track["image"] ?>','<?php echo $track["username"] ?>')"><i class="fa fa-play" aria-hidden="true"></i></a>
            <a href="javascript:deleteFavorites('<?php echo $track["id"] ?>')"><i class="fa fa-trash" aria-hidden="true"></i></a>
            <h3><a href="javascript:loadPage('/track/<?php echo $track["id_file"] ?>')" title="<?php echo $track["name"] ?>"><?php echo $track["name"] ?></a></h3>
            <a class="push" href="<?php echo $track["path"] ?>" download="<?php echo $track["path"] ?>"><i class="fa fa-download downl" aria-hidden="true"></i></a>
        </div>
    <?php } ?>
</div>
<script>
    function deleteFavorites(id){
        $.get("/deleteFavorites/"+id,function(res){
            loadPage("/mytracks")
        })
    }
    function random() {
        <?php
        $new = [];
        $keys = array_keys($tracks);
        shuffle($keys);
        foreach ($keys as $key) {
            $new[] = $tracks[$key];
        }
        $random = $new;
        ?>
        var data = JSON.parse('<?php echo json_encode($random); ?>');
        console.log(data);
        var sets = [];
        for (i in data) {
            if (data[i].type == 0) {
                type = 'sets';
            } else {
                type = 'tracks';
            }
            var set = {
                name: data[i].name,
                artist: data[i].username,
                image: data[i].image,
                path: type + '/' + data[i].id_artist + '/' + data[i].name
            }
            sets.push(set);
        }
        track_list = sets;
        loadTrack(track_index);
        playTrack();
    }

    function playall() {
        var data = JSON.parse(' <?php echo json_encode($tracks); ?>');
        var sets = [];
        for (i in data) {
            if (data[i].type == 0) {
                type = 'sets';
            } else {
                type = 'tracks';
            }
            var set = {
                name: data[i].name,
                artist: data[i].username,
                image: data[i].image,
                path: type + '/' + data[i].id_artist + '/' + data[i].name
            }
            sets.push(set);
        }
        track_list = sets;
        loadTrack(track_index);
        playTrack();
    }


    function playThis(title, user, type, image, artist) {
        if (type == 0) {
            type = 'sets';
        } else {
            type = 'tracks';
        }
        track_list = [{
            name: title,
            artist: artist,
            image: image,
            path: type + '/' + user + '/' + title
        }]
        console.log(type + '/' + user + '/' + title)
        loadTrack(track_index);
        playTrack();
    }
    $(document).ready(function(){
        backurl.push("/mytracks");
    });
</script>