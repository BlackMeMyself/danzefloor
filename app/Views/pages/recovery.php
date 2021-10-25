<div class="imagenfondo">
    <form action="" id="recoveryform">
        <input id="recovery" class="recovery" name="email" type="email" placeholder="EMAIL" required>
        <button>RECOVERY PASSWORD</button>
    </form>
</div>
<script>
    $(document).ready(function() {
        backurl.push("/recovery");
        $("#recoveryform").submit(function(event) {
            event.preventDefault()
            data = {
                email: $("#recovery").val()
            }
            $.post("/sendrecovery", data, function(res) {
                console.log(res);
                res = JSON.parse(res)
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
                }else{
                    loadPage(res.url)

                }
            })
        });
    });
</script>