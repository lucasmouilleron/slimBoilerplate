<?php require_once __DIR__."/api/libs/tools.php";?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>

    <title>slimBoilerplate</title>
    <meta name="description" content="">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png">
    <script src="assets/js/modernizr.js"></script>
    <link rel="stylesheet" href="assets/css/main.css">

</head>
<body>

    <div data-api-url="<?php echo getAPIURL();?>"></div>

    <!-- /////////////////////////////////////////////////////////////// -->
    <div class="container">
        <div class="jumbotron">
            <h1>slimBoilerplate</h1>
            <p>A simple Slim boilerplate with cache and authentication with JWT</p>
        </div>
    </div>

    <!-- /////////////////////////////////////////////////////////////// -->
    <div class="container">

    </div>

    <!-- /////////////////////////////////////////////////////////////// -->
    <div class="container">
        <h2>Login</h2>
        <p>
            <a href="#" class="btn btn-primary" id="login">Login</a>
            <a href="#" class="btn btn-danger" id="logout">Logout</a>
        </p>
        <div class="well">Token : <span id="token">No token</span></div>
    </div>

    <!-- /////////////////////////////////////////////////////////////// -->
    <div class="container">
        <h2>Operations</h2>
        <p>
            <a href="#" class="btn btn-primary" id="public-get">Public / Cached GET route</a>
            <a href="#" class="btn btn-primary" id="public-post">Public POST route</a>
            <a href="#" class="btn btn-warning" id="private-get">Private GET route</a>
            
        </p>
        <div class="well">Result : <span id="result"></span></div>
    </div>

</div>

<!-- /////////////////////////////////////////////////////////////// -->
<script id="public-template" type="text/x-handlebars-template">
  {{#each items}}
  <h3>{{data.title}}</h3>
  <p><a href="http://reddit.com/{{ data.permalink }}" target="_blank">http://reddit.com/{{ data.permalink }}</a></p>
  <img src=" {{ data.thumbnail }} "/>
  {{/each}}
</script>

<!--<script data-main="assets/js/scripts.min" src="assets/js/require.js"></script>-->
<script data-main="_dev/js/main" src="assets/js/require.js"></script>

</body>
</html>
