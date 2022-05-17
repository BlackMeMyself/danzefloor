<div class="imagenfondo">
    <a class="acomEvents" href="javascript:loadPage('/events/<?php echo $user[0]["id"] ?>/<?php echo $user[0]["user"] ?>')">
        <h4 class="comEvents" id="comingev">COMING UP EVENTS</h4>
    </a>
    <div class="imgavatar">
        <?php if ($user[0]["avatar"] == "") { ?>
            <img class="avatar" id="avatarId" src="public/img/artists/profile.png" alt="avatar">
        <?php } else { ?>
            <img class="avatar" id="avatarId" src="<?php echo $user[0]["avatar"] ?>" alt="avatar">
        <?php } ?>
    </div>
    <h3 class="nickArtist"><?php echo $user[0]["user"] ?></h3>
    <div class="bioResult">
        <div><?php if ($user[0]["bio"] != "") { ?> <?php echo $user[0]["bio"];
                                                } ?></div>
        <div><?php if ($user[0]["genres"] != "") { ?>GENRES : <?php echo $user[0]["genres"];
                                                            } ?></div>
        <div><?php if ($user[0]["city"] != "") { ?>HOMETOWN : <?php echo $user[0]["city"];
                                                            } ?></div>
        <div><?php if ($user[0]["country"] != "") { ?>COUNTRY : <?php echo $user[0]["country"];
                                                            } ?></div>
        <div><?php if ($user[0]["debut"] != "0000-00-00") { ?>DEBUT : <?php echo $user[0]["debut"];
                                                                    } ?></div>
    </div>
    <div class="artistresults">
        <?php if (count($sets) > 0) { ?> <h3 id="lang-sets" class="setresults">SETS</h3><?php } ?>
        <?php foreach ($sets as $set) { ?>
            <form id="formimage<?php echo $set['id'] ?>" class="formimg">
                <div class="capsula">
                    <div class="imgcontainer">
                        <?php if (isset($_SESSION["user"])) if ($_SESSION["user"] == $user[0]["user"]) { ?>
                            <img src="/public/images/setrackimage.png" class="setrackimage" alt="" onclick="inputshow(<?php echo $set['id'] ?>)">
                        <?php } ?>
                        <img class="defaultimage zoomImage" src="<?php echo $set["image"] ?>" alt="">
                    </div>
                    <input type="file" accept="image/*" id="setimage<?php echo $set['id'] ?>" class="inputimg displaynone">
                    <a href="javascript:playThis('<?php echo $set['name']; ?>',<?php echo $set["id_user"] ?>,<?php echo $set["type"] ?>,'<?php echo $set["image"] ?>')"><i class="fa fa-play" aria-hidden="true"></i></a>
                    <?php if (isset($_SESSION["user"])) { ?>
                        <a href="javascript:addFavorites('<?php echo $set["id"] ?>','<?php echo $set["id_user"] ?>')"><i class="fa fa-heartbeat heart" aria-hidden="true"></i></a>
                    <?php } ?>
                    <a class="" href="<?php echo "sets/" . $set['id_user'] . "/" . $set['name']; ?>" download="<?php echo $set['name']; ?>"><i class="fa fa-download downl" aria-hidden="true"></i></a>
                    <?php if (isset($_SESSION["user"])) if ($_SESSION["user"] == $user[0]["user"]) { ?>
                        <a href="javascript:deletetrack(<?php echo $set["id"] ?>)"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    <?php } ?>
                    <div class="songname">
                        <a title="<?php echo $set['name']; ?>" href="javascript:loadPage('/track/<?php echo $set["id"] ?>')"><?php echo $set['name']; ?></a>
                    </div>

                </div>
            </form>
        <?php } ?>
        <?php if (count($tracks) > 0) { ?><h3 class="lang-tracks setresults" id="lang-tracks">TRACKS</h3><?php } ?>
        <?php foreach ($tracks as $track) { ?>
            <form id="formimage<?php echo $track['id'] ?>" class="formimg">
                <div class="capsula">
                    <div class="imgcontainer">
                        <?php if (isset($_SESSION["user"])) if ($_SESSION["user"] == $user[0]["user"]) { ?>
                            <img src="/public/images/setrackimage.png" class="setrackimage" alt="" onclick="inputshow(<?php echo $track['id'] ?>)">
                        <?php } ?>
                        <img class="defaultimage zoomImage" src="<?php echo $track["image"] ?>" alt="">
                    </div>
                    <input type="file" accept="image/*" id="setimage<?php echo $track['id'] ?>" class="inputimg displaynone">
                    <a href="javascript:playThis('<?php echo $track['name']; ?>',<?php echo $track["id_user"] ?>,<?php echo $track["type"] ?>,'<?php echo $track["image"] ?>')"><i class="fa fa-play" aria-hidden="true"></i></a>
                    <?php if (isset($_SESSION["user"])) { ?>
                        <a href="javascript:addFavorites('<?php echo $track["id"] ?>','<?php echo $track["id_user"] ?>')"><i class="fa fa-heartbeat heart" aria-hidden="true"></i></a>
                    <?php } ?>
                    <a class="" href="<?php echo "tracks/" . $track['id_user'] . "/" . $track['name']; ?>" download="<?php echo $track['name']; ?>"><i class="fa fa-download downl" aria-hidden="true"></i></a>
                    <?php if (isset($_SESSION["user"])) if ($_SESSION["user"] == $user[0]["user"]) { ?>
                        <a href="javascript:deletetrack(<?php echo $track["id"] ?>)"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    <?php } ?>
                    <div class="songname">
                        <a title="<?php echo $track['name']; ?>" href="javascript:loadPage('/track/<?php echo $track["id"] ?>')"><?php echo $track['name']; ?></a>
                    </div>

                </div>
            </form>
        <?php } ?>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("input.inputimg").change(function() {
            $("#formimage" + fileimg).submit()
        })
        $("form.formimg").submit(function(ev) {
            ev.preventDefault()
            var data = new FormData();
            $.each($("#setimage" + fileimg)[0].files, function(i, file) {
                data.append("avatar", file);
            });
            data.append("id", fileimg);
            $.ajax({
                url: "/updatefileimg",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: "POST",
                beforeSend: function() {
                    $("#spinner").removeClass("displaynone");
                },
                success: function(res) {
                    $("#spinner").addClass("displaynone");
                    res = JSON.parse(res);
                    if (res.error == 0) {
                        loadPage('/artist/<?php echo $user[0]["user"] ?>');
                    } else {
                        $("#dialogmsg").html(res.msg);
                        $("#dialog").dialog({
                            show: {
                                effect: "scale",
                                percent: 50,
                                duration: 200
                            },
                            hide: {
                                effect: "scale",
                                percent: 50,
                                duration: 200
                            }
                        });
                    }
                }
            });
        })
        backurl.push("/artist/<?php echo $artist; ?>");
    });

    function playThis(title, user, type, image) {
        if (type == 0) {
            type = 'sets';
        } else {
            type = 'tracks';
        }
        track_list = [{
            name: title,
            artist: '<?php echo $user[0]["user"] ?>',
            image: image,
            path: type + '/' + user + '/' + title
        }]
        loadTrack(track_index);
        playTrack();
    }

    function addFavorites(id, id_user) {
        var data = {
            id: id,
            id_user: id_user
        }
        jQuery.post("/addfavorites", data, function(res) {
            res = JSON.parse(res);
            if (res.error == "") {
                $("#dialogmsg").html(res.msg);
                $("#dialog").dialog({
                    show: {
                        effect: "scale",
                        percent: 50,
                        duration: 200
                    },
                    hide: {
                        effect: "scale",
                        percent: 50,
                        duration: 200
                    }
                });
            } else {
                if (res.error["id_file"] != undefined) {
                    $("#dialogmsg").html(res.error["id_file"]);
                } else {
                    $("#dialogmsg").html(res.msg);
                }

                $("#dialog").dialog({
                    show: {
                        effect: "scale",
                        percent: 50,
                        duration: 200
                    },
                    hide: {
                        effect: "scale",
                        percent: 50,
                        duration: 200
                    }
                });
            }
        });
    }

    function inputshow(id) {
        fileimg = id
        $("#setimage" + id).click()
    }

    function deletetrack(id) {
        $.ajax({
            url: "/delete/" + id,
            type: "GET",
            success: function(res) {
                res = JSON.parse(res);
                if (res.error == 1) {
                    $("#dialogmsg").html(res.msg);
                    $("#dialog").dialog({
                        show: {
                            effect: "scale",
                            percent: 50,
                            duration: 200
                        },
                        hide: {
                            effect: "scale",
                            percent: 50,
                            duration: 200
                        }
                    });
                } else {
                    loadPage(res.url);
                }
            }
        })
    }
</script>