<div class="imagenfondo">
    <h2 class="mysets">MY SETS</h2>
    <div class="playall"><span onclick="playall()">PLAY ALL</span><span onclick="random()">RANDOM</span></div>
    <?php foreach ($sets as $set) { ?>
        <div id="capsulamy" class="capsulamy">
            <a href="javascript:playThis('<?php echo $set['name']; ?>',<?php echo $set["id_artist"] ?>,<?php echo $set["type"] ?>,'<?php echo $set["image"] ?>','<?php echo $set["username"] ?>')"><i class="fa fa-play" aria-hidden="true"></i></a>
            <a href="javascript:deleteFavorites('<?php echo $set["id"] ?>')"><i class="fa fa-trash" aria-hidden="true"></i></a>
            <h3><a href="javascript:loadPage('/track/<?php echo $set["id_file"] ?>')" title="<?php echo $set["name"] ?>"><?php echo $set["name"] ?></a></h3>
            <a class="push" href="<?php echo $set["path"] ?>" download="<?php echo $set["path"] ?>"><i class="fa fa-download downl" aria-hidden="true"></i></a>
        </div>
    <?php } ?>
</div>
<script>
    function deleteFavorites(id){
        $.get("/deleteFavorites/"+id,function(res){
            loadPage("/mysets")
        })
    }
    function random() {
        <?php
        $new = [];
        $keys = array_keys($sets);
        shuffle($keys);
        foreach ($keys as $key) {
            $new[] = $sets[$key];
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
        var data = JSON.parse(' <?php echo json_encode($sets); ?>');
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
        loadTrack(track_index);
        playTrack();
    }

    $(document).ready(function() {
        backurl.push("/mysets");
    });
</script>