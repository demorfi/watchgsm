<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Watchdog GSM</title>
    <link href="bootstrap/stylesheets/bootstrap.min.css" rel="stylesheet" />
    <link href="bootstrap/stylesheets/custom.css" rel="stylesheet" />
</head>
<body>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo $this->pixie->basepath; ?>">WatchGSM</a>
        </div>
        <div class="navbar-collapse collapse">
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="<?php echo $this->pixie->basepath; ?>compose">Compose</a>
                    </li>
                    <li class="active">
                        <a href="<?php echo $this->pixie->basepath; ?>inbox">Inbox <span class="badge"></span></a>
                    </li>
                    <li>
                        <a href="<?php echo $this->pixie->basepath; ?>turn">Turn <span class="badge"></span></a>
                    </li>
                    <li>
                        <a href="<?php echo $this->pixie->basepath; ?>sent">Sent <span class="badge"></span></a>
                    </li>
                    <li>
                        <a href="<?php echo $this->pixie->basepath; ?>templates">SMS Templates</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<footer>
    <p class="text-center">&copy; 2015 <a href="https://github.com/demorfi">demorfi</a></p>
</footer>
<script type="text/javascript" src="bootstrap/javascripts/jquery.min.js"></script>
<script type="text/javascript" src="bootstrap/javascripts/bootstrap.min.js"></script>
<script type="text/javascript" src="bootstrap/javascripts/main.js"></script>
</body>
</html>