function saveplayercookies(trackinfo) {
    data = {
        name: trackinfo.name,
        artist: trackinfo.artist,
        image: trackinfo.image,
        path: trackinfo.path
    }
    $.ajax({
        url: "/saveplayercookies",
        method: "POST",
        data: data,
        success: function(res) {
            console.log(res)
        }
    })
}