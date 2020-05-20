$(document).ready(function () {
    if (("Notification" in window)) {
    if (Notification.permission != "granted") {
        Notification.requestPermission(function (permission) {
            // If the user accepts, let's create a notification
            if (permission === "granted") {
                var notification = new Notification("Hi there!", {icon: 'fly.png'});
            }
        });
    }
    }

    $("button").click(function () {
        console.log("sdsd");
        $.post("https://chat.birdwatch.bruegger.sg/add", {message: $("#message").val()})
            .done(function (data) {
                console.log("done");

                $("#message").val("")
            });

    })
    poll()

    function poll() {
        setTimeout(function () {
            $("body").css("background-image", `url("https://birdwatch.bruegger.sg/images/cam.jpg?time=${new Date().getTime()}")`);
            $.ajax({
                url: "https://chat.birdwatch.bruegger.sg/get", success: function (result) {
                    $.each(result, function (i, item) {
                        if ($("#" + this["id"]).length == 0) {
                            $("chat").prepend("<div class='uk-card uk-card-default uk-card-body uk-margin animated fadeIn' id='" + this["id"] + "'>" + this["message"] + "<br><small>" + this["datetime_created"] + "</small></div>");
                            new Notification(this["message"], {icon: 'fly.png'});
                        }
                    });
                    poll();
                }
            });
        }, 5000);
    }

    $.ajax({
        url: "https://chat.birdwatch.bruegger.sg/get", success: function (result) {
            $.each(result, function (i, item) {
                if ($("#" + this["id"]).length == 0) {
                    $("chat").prepend("<div class='uk-card uk-card-default uk-card-body uk-margin animated fadeIn' id='" + this["id"] + "'>" + this["message"] + "<br><small>" + this["datetime_created"] + "</small></div>");
                }
            });
            poll();
        }
    });

})