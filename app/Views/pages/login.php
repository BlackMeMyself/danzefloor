<div class="imagenfondo">
    <form class="form-l" id="login" method="POST">
        <input type="email" name="email" id="email" placeholder="EMAIL" required>
        <input type="password" name="password" id="password" placeholder="PASSWORD" required>
        <input class="forgotpass" type="button" value="FORGOT PASSWORD?" onclick="loadPage('/recovery')">
        <button type="submit">LOG IN</button>
    </form>
</div>
<script>
    $(document).ready(function() {
        backurl.push("/login");
        $("#login").submit(function(ev) {
            var email = $("#email").val();
            var password = $("#password").val();
            var data = {
                email: email,
                password: password
            };
            $.post("/login", data, function(res) {
                res = JSON.parse(res);
                if (res.url != "") {
                    logged = true;
                    $(".logged").append('<div class="loggedcheck hidden" id="loggedcheck"><i class="fa fa-user loggeduser" aria-hidden="true"></i><span class="userlogged" id="showUserName"><?php if (isset($_SESSION["user"])) echo $_SESSION["user"] ?></span><a href="javascript:logout(\'/logout/\')"><i class="fa fa-sign-out signout" aria-hidden="true"></i></a></div>')
                    toggleNav(logged);
                    try {
                        $("#showUserName").html(res.msg)
                    } catch (error) {}
                    loadPage(res.url);
                }else if (res.msg != "") {
                    logged = false;
                    toggleNav(logged);
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
            });
            ev.preventDefault();
        });
    });
</script>