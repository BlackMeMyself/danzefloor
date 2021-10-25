<div class="imagenfondo">
    <form class="form-l" id="signupform" method="POST">
        <input type="text" name="user" placeholder="NICKNAME" required>
        <input type="email" name="email" placeholder="E-MAIL" required>
        <input type="password" id="password" name="password" placeholder="PASSWORD" required>
        <!--<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>-->
        <input type="password" id="vpassword" placeholder="REPEAT PASSWORD" required>
        <!--<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>-->
        <button type="submitt">SIGN UP</button>
    </form>
</div>
<script>
    $(document).ready(function() {
        backurl.push("/signup");
        $("#signupform").submit(function(ev) {
            ev.preventDefault();
            if ($("#password").val() == $("#vpassword").val()) {
                var data = $("#signupform").serialize();
                $.post("/signup", data, function(res) {
                    res = JSON.parse(res);
                    if ($.isEmptyObject(res.msg)) {
                        loadPage(res.url);
                    } else {
                        for (var item in res.msg) {
                            $("#dialogmsg").html(res.msg[item]);
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
                })
            } else {
                $("#dialogmsg").html("THE PASSWORD DOES NOT MATCH");
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
        })
    })
</script>