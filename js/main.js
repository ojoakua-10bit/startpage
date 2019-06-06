setInterval(() => {
    function padTime(t) {
        return t < 10 ? '0' + t : t;
    }

    let now = new Date();
    let h = padTime(now.getHours());
    let m = padTime(now.getMinutes());
    let s = padTime(now.getSeconds());

    $("#time").text(h + ":" + m + ":" + s);
}, 500);