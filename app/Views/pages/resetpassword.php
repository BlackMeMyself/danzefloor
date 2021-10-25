<div class="imagenfondo">
    <form id="resetform">
        <input type="password" id="password" placeholder="NEW PASSWORD" required>
        <input type="password" id="cpassword" placeholder="CONFIRM PASSWORD" required>
        <input type="text" id="token" hidden value="<?php echo $token ?>">
        <button>RESET PASSWORD</button>
    </form>
</div>
<script>
    $(document).ready(function() {
        $("#resetform").submit(function(ev) {
            ev.preventDefault()
            var password = $("#password").val()
            var cpassword = $("#cpassword").val()
            var token = $("#token").val();
            if (password == cpassword) {
                var data = {
                    password: password,
                    token: token
                }
                $.post("/newpassword", data, function(res) {
                    res = JSON.parse(res)
                    loadPage(res.url)
                })
            } else {
                $("#dialogmsg").html("BOTH PASSWORD DOESN'T MATCH");
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