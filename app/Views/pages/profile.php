<div class="imagenfondo">
    <div class="chooseAvatar">
        <?php if ($_SESSION['avatar'] == "") {  ?>
            <img id="displayAvatar" class="avatar" src="public/img/artists/profile.png" alt="avatar">
        <?php } else { ?>
            <img id="displayAvatar" class="avatar" src="<?php echo $_SESSION['avatar']; ?>" alt="avatar">
        <?php } ?>
        <img class="setprofileimg" src="/public/images/setrackimage.png" onclick="inputshow('avatar')" alt="">
    </div>

    <ul class="profilemessage">
        <li>• CHOOSE YOUR AVATAR</li>
        <li>• ADD AN IMAGE FOR YOUR SETS AND TRACKS</li>
        <li>• SHARE WITH YOUR FANS YOUR NEXT SHOW</li>
        <li>• ANYTIME</li>
    </ul>
    <div class="profile-navbar">
        <ul>
            <li id="skipprofile" class="navitem-active" onclick="skipwindow('navbar-profile','skipprofile')">Profile</li>
            <li id="skipbio" onclick="skipwindow('navbar-bio','skipbio')">Bio</li>
            <li id="skipevents" onclick="skipwindow('navbar-events','skipevents')">Events</li>
        </ul>
        <div class="navbar-item navbar-active" id="navbar-profile">
            <form id="chooseAvatar">
                <input type="file" class="displaynone inputimg" name="avatar" id="avatar">
            </form>
            <form class="proform" enctype="multipart/form-data" id="profileform" method="post">
                <input class="nickn" type="text" name="user" value="<?php echo $_SESSION['user'] ?>" placeholder="UPDATE NICKNAME" id="user">
                <input type="password" class="nickn" name="currentpassword" placeholder="CURRENT PASSWORD">
                <input type="password" class="nickn" name="password" placeholder="NEW PASSWORD">

                <button id="lang-savech">SAVE CHANGES</button>
            </form>
        </div>
        <div class="navbar-item" id="navbar-bio">
            <form id="bioForm">
                <textarea name="bio" id="bio" rows="10" placeholder="BIO"><?php echo $user[0]['bio'] ?></textarea>
                <input type="text" id="genrebio" value="<?php echo $user[0]['genres'] ?>" placeholder="GENRES">
                <input type="text" id="citybio" value="<?php echo $user[0]['city'] ?>" placeholder="CITY">
                <input type="text" id="countrybio" value="<?php echo $user[0]['country'] ?>" placeholder="COUNTRY">
                <input type="date" id="datebio" value="<?php echo $user[0]['debut'] ?>" placeholder="DEBUT DATE">
                <button class="savebio" id="savebio">SAVE BIO</button>
            </form>
        </div>
        <div class="navbar-item" id="navbar-events">
            <form id="formEvents">
                <h4 id="lang-addnew"> ADD NEW EVENT</h4>
                <input type="text" id="place" placeholder="PLACE" required>
                <input type="datetime-local" id="time" required>
                <button class="subButton" id="lang-envnuevo">SUBMIT</button>
            </form>
            <div>
                <h3 class="updComEv" id="comingev">COMING EVENTS :</h3>
                <div class="comingUp">
                    <?php $i = 0;
                    foreach ($events as $event) {
                        $i++ ?>
                        <div class="comingUpInfo <?php if ($i % 2 == 0) {
                                                        echo "proxEvent";
                                                    } ?>">

                            <div><a href="javascript:deleteEvent('<?php echo $event["id"] ?>')"><i class="fa fa-trash" aria-hidden="true"></i></a> <?php echo $event["place"] ?> </div>
                            <div><?php echo $event["time"] ?> </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        backurl.push("/profile");
        $("input.inputimg").change(function() {
            $("#chooseAvatar").submit()
        })
        $("#chooseAvatar").submit(function(ev) {
            ev.preventDefault()
            var data = new FormData();
            $.each($("#avatar")[0].files, function(i, file) {
                data.append("avatar", file);
            });
            data.append("id", <?php echo $_SESSION["id"] ?>);
            $.ajax({
                url: "/chooseAvatar",
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
                        $("#displayAvatar").attr("src", res.path);
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
        $("#bioForm").submit(function(ev) {
            ev.preventDefault()
            var bio = $("#bio").val();
            var genres = $("#genrebio").val();
            var city = $("#citybio").val();
            var country = $("#countrybio").val();
            var debut = $("#datebio").val();
            data = {
                bio: bio,
                genres: genres,
                city: city,
                country: country,
                debut: debut
            }
            $.post("/savebio", data, function(res) {
                res = JSON.parse(res)
                loadPage(res.url)
            })
        })
        $("#formEvents").submit(function(ev) {
            ev.preventDefault()
            var place = $("#place").val();
            var timeev = $("#time").val();
            var data = {
                place: place,
                time: timeev
            }
            $.post("/addevent", data, function(res) {
                res = JSON.parse(res)
                loadPage(res.url)
            })
        })
        $("#profileform").submit(function(ev) {
            var data = new FormData();
            var otherData = $("#profileform").serializeArray();
            $.each(otherData, function(key, input) {
                data.append(input.name, input.value);
            });
            $.ajax({
                url: "/profile",
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
                        $("#showUserName").html(res.msg)
                        loadPage(res.url);
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
            ev.preventDefault();
        });
    });

    function skipwindow(id, idli) {
        $("#navbar-profile").removeClass("navbar-active")
        $("#navbar-bio").removeClass("navbar-active")
        $("#navbar-events").removeClass("navbar-active")
        $("#" + id).addClass("navbar-active")
        $("#skipprofile").removeClass("navitem-active")
        $("#skipbio").removeClass("navitem-active")
        $("#skipevents").removeClass("navitem-active")
        $("#" + idli).addClass("navitem-active")
    }

    function inputshow(id) {
        $("#" + id).click()
    }

    function deleteEvent(id) {
        $.get("/deleteevent/" + id, function(res) {
            loadPage("/profile")
        })
    }
</script>