var logged = false;
var toggle = false;
var backurl = ["/home"];
var ftback = true;
var fileimg = 0

function back() {
    try {
        if (ftback) {
            backurl.splice(backurl.length - 1, 1)
            loadPage(backurl[backurl.length - 1]);
            ftback = false;
        } else {
            backurl.splice(backurl.length - 2, 2)
            loadPage(backurl[backurl.length - 1]);
        }
    } catch {}
}

function loadPage(url, id) {
    id = id || "volume";
    $.ajax({
        url: url,
        method: "get",
        success: function(res) {
            toggleNav(logged);
            var estilosfooter = document.getElementById("estilosfooter");
            var estilosfooter1 = document.getElementById("estilosfooter1");
            estilosfooter.classList.remove("displayblock");
            estilosfooter1.classList.remove("displayblock");
            $("#container").html(res);
            getTags();
            if (id != "") {
                $('html, body').animate({
                        scrollTop: $("#idheader").offset().top
                    },
                    250);
            }
        }
    });
}

function getTags() {
    $.ajax({
        url: "/gettags",
        method: "get",
        success: function(res) {
            res = JSON.parse(res);
            var tags = [];
            for (i in res.user) {
                tags.push(res.user[i].user);
            }
            for (i in res.files) {
                tags.push(res.files[i].name);
            }
            $("#isearch").autocomplete({
                source: tags,
                select: function(e, ui) {
                    loadPage("/search/" + ui.item.value);
                }
            });
        }
    });
}

function logout(url) {
    $.ajax({
        url: url,
        method: "get",
        success: function(res) {
            logged = false;
            toggleNav(logged);
            $("#container").html(res);

        }
    });
}

function toggleNav(status) {
    if (status) {
        $("#loggedcheck").removeClass("hidden");
        $("#signup").addClass("displaynone");
        $("#loginl").addClass("displaynone");
        $("#shareset").removeClass("displaynone");
        $("#sharetrack").removeClass("displaynone");
        $("#mysets").removeClass("displaynone");
        $("#mytracks").removeClass("displaynone");
        $("#profile").removeClass("displaynone");
    } else {
        $("#loggedcheck").addClass("hidden");
        $("#signup").removeClass("displaynone");
        $("#loginl").removeClass("displaynone");
        $("#shareset").addClass("displaynone");
        $("#sharetrack").addClass("displaynone");
        $("#mysets").addClass("displaynone");
        $("#mytracks").addClass("displaynone");
        $("#profile").addClass("displaynone");
    }
}