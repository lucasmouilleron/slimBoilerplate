/////////////////////////////////////////////////////////////////////
// REQUIREJS CONFIG
/////////////////////////////////////////////////////////////////////
require.config({
    paths: {
        "jquery": "libs/vendor/jquery/dist/jquery",
        "bootstrap": "libs/vendor/bootstrap/dist/js/bootstrap.min",
        "console": "libs/vendor/console/console.min",
        "throbber": "libs/vendor/throbber.js/throbber",
        "cookies": "libs/vendor/cookies-js/dist/cookies.min",
        "handlebars": "libs/vendor/handlebars/handlebars",
        "notify": "libs/vendor/notifyjs/dist/notify",
        "notify-bootstrap": "libs/vendor/notifyjs/dist/styles/bootstrap/notify-bootstrap",
        "tools": "libs/tools"
    },
    shim: {
        "bootstrap": ["jquery"],
        "throbber": ["jquery"],
        "notify": ["jquery"],
        "notify-bootstrap": ["notify"],
        "tools": ["jquery", "console"]
    }
});

/////////////////////////////////////////////////////////////////////
// ENTRY POINT
/////////////////////////////////////////////////////////////////////
require(["jquery", "tools", "cookies", "handlebars", "bootstrap", "notify-bootstrap"], function($, tools, Cookies, Handlebars) {
    $(function() {
        apiURL = $("div[data-api-url]").data("api-url");
        
        updateToken();

        $("#login").click(function() {
            tools.displayMainLoader();
            $.post(apiURL+"/login", {username:"test", password:"test2"}, function(data) {
                updateToken(data.token);
                $.notify("You loged in", "success");
            }).fail(function(data) {
                $.notify("Error while loging in : "+JSON.stringify(data), "error");
            })
            .complete(function() {
                tools.hideMainLoader();
            });
        });

        $("#logout").click(function() {
            updateToken(-1);
            $.notify("You loged out", "warn");
        });

        $("#public-get").click(function() {
            tools.displayMainLoader();
            $.get(apiURL+"/reddits")
            .done(function(data) {
                $.notify("Request succeded", "success");
                var template = Handlebars.compile($("#public-template").html());
                $("#result").html(template({items:data}));
            })
            .fail(function(data) {
                $("#result").html(JSON.stringify(data));
            })
            .complete(function() {
                tools.hideMainLoader();
            });
        });

        $("#public-post").click(function() {
            tools.displayMainLoader();
            $.post(apiURL+"/post/lucas", {key1: "value1", key2: "value2", })
            .done(function(data) {
                $.notify("Request succeded", "success");
            })
            .fail(function(data) {
                $.notify("Request failed", "error");
            })
            .complete(function(data) {
                $("#result").html(JSON.stringify(data));
                tools.hideMainLoader();
            });
        });

        $("#private-get").click(function() {
            tools.displayMainLoader();
            $.get(apiURL+"/private/lucas", {token: Cookies.get("token")})
            .done(function(data) {
                $.notify("Request succeded", "success");
            })
            .fail(function(data) {
                $.notify("Request failed", "error");
            })
            .complete(function(data) {
                $("#result").html(JSON.stringify(data));
                tools.hideMainLoader();
            });
        });

        function updateToken(token) {
            if(token !== undefined) {
                Cookies.set("token", token);
            }
            token = Cookies.get("token");
            if(Cookies.get("token") !== "-1") {
                $("#login").hide();
                $("#logout").show();
            }
            else {
                $("#login").show();
                $("#logout").hide();
            }
            $("#token").html(token);
        }
    });
});