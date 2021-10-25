<div class="imagenfondo">
    <form id="sharetrackform" enctype="multipart/form-data" method="POST">
        <label class="uploadbtn" for="file">CHOOSE FILE <i class="fa fa-upload" aria-hidden="true"></i></label>
        <h4 class="recommended">MAXIMUM SIZE : 64MB (M4A RECOMMENDED)</h4>
        <input type="file" id="file" name="music" class="displaynone" required>
        <audio id="audio"></audio>
        <div>
            <select name="genre">
                <option value="dubstep">DUBSTEP</option>
                <optgroup>
                    <option value="bassline">BASSLINE</option>
                    <option value="drumandbass">DRUM AND BASS</option>
                    <option value="jungle">JUNGLE</option>
                    <option value="ukgarage">UK GARAGE</option>
                    <option disabled class="odisabled"></option>
                </optgroup>
                <option value="electro">ELECTRO</option>
                <optgroup>
                    <option value="electronic">ELECTRONIC</option>
                    <option value="idm">IDM</option>
                    <option value="newwave">NEW WAVE</option>
                    <option value="postpunk">POST PUNK</option>
                    <option disabled class="odisabled"></option>
                </optgroup>
                <option value="hiphop">HIP HOP</option>
                <optgroup>
                    <option value="brokenbeat">BROKEN BEAT</option>
                    <option value="reggae">REGGAE</option>
                    <option value="triphop">TRIP HOP</option>
                    <option disabled class="odisabled"></option>
                </optgroup>
                <option value="house">HOUSE</option>
                <optgroup>
                    <option value="chicago">CHICAGO</option>
                    <option value="microhouse">MICRO HOUSE</option>
                    <option value="techhouse">TECH HOUSE</option>
                    <option value="tribalhouse">TRIBAL HOUSE</option>
                    <option disabled class="odisabled"></option>
                </optgroup>
                <option value="italodisco">ITALO DISCO</option>
                <optgroup>
                    <option value="disco">DISCO</option>
                    <option value="droneambient">DRONE AMBIENT</option>
                    <option value="space">SPACE</option>
                    <option value="synthpop">SYNTH POP</option>
                    <option disabled class="odisabled"></option>
                </optgroup>
                <option value="techno">TECHNO</option>
                <optgroup>
                    <option value="detroit">DETROIT</option>
                    <option value="dubtechno">DUB TECHNO</option>
                    <option value="ebm">EBM</option>
                    <option value="industrial">INDUSTRIAL</option>
                    <option value="minimal">MINIMAL</option>
                    <option value="uk">UK</option>
                    <option disabled class="odisabled"></option>
                    </optgroup>
            </select>
            <input type="text" id="duration" name="duration" placeholder="DURATION">
            <input type="text" id="filesize" name="filesize" placeholder="FILE SIZE" readonly>
            <input type="text" id="filetype" name="filetype" placeholder="FORMAT" readonly>
        </div>
        <button type="submit">UPLOAD</button>
    </form>
</div>
<script>
    var objectUrl;
    $("#audio").on("canplaythrough", function(ev) {
        var seconds = ev.currentTarget.duration;
        var duration = moment.duration(seconds, "seconds");
        var time = "";
        var hours = duration.hours();
        if (hours > 0 && hours < 10) {
            time = "0" + hours + ":";
        } else if (hours > 0 && hours >= 10) {
            time = hours + ":";
        }
        if (duration.minutes() < 10) {
            time = time + "0" + duration.minutes() + ":";
        } else {
            time = time + duration.minutes() + ":";
        }
        if (duration.seconds() < 10) {
            time = time + "0" + duration.seconds();
        } else {
            time = time + duration.seconds();
        }
        $("#duration").val(time);

        URL.revokeObjectURL(objectUrl);
    });

    $("#file").change(function(ev) {
        var file = ev.currentTarget.files[0];
        var formats = {
            "audio/mpeg": "MP3",
            "audio/wav": "WAV",
            "audio/x-m4a": "M4A",
            "audio/wma": "WMA",
            "audio/aiff": "AIFF",
            "audio/basic": "AU",
        };
        console.log(file.type);
        $("#filetype").val(formats[file.type]);
        $("#filesize").val((file.size / 1000000).toFixed(2) + "MB");
        objectUrl = URL.createObjectURL(file);
        $("#audio").prop("src", objectUrl);
    });
    $(document).ready(function() {
        backurl.push("/sharetrack");
        $("#sharetrackform").submit(function(ev) {
            var data = new FormData();
            $.each($("#file")[0].files, function(i, file) {
                data.append("music", file);
            });
            var otherData = $("#sharetrackform").serializeArray();
            $.each(otherData, function(key, input) {
                data.append(input.name, input.value);
            });
            $.ajax({
                url: "/sharetrack",
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
</script>