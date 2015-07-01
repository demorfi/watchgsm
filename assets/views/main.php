<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <base href="<?php echo $this->pixie->basepath; ?>" />
    <title>Watchdog GSM<?php echo $title ? '|' . $title : ''; ?></title>
    <link href="bootstrap/stylesheets/bootstrap.min.css" rel="stylesheet" />
    <link href="bootstrap/stylesheets/font-awesome.min.css" rel="stylesheet" />
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
                    <li <?php $this->helper->hasActivePage($request, 'compose'); ?>>
                        <a href="<?php echo $this->pixie->router->get('default')->url(array('controller' => 'compose')); ?>">
                            <i class="fa fa-pencil"></i> Compose
                        </a>
                    </li>
                    <li <?php $this->helper->hasActivePage($request, 'inbox'); ?>>
                        <a href="<?php echo $this->pixie->router->get('default')->url(array('controller' => 'inbox')); ?>">
                            <i class="fa fa-inbox"></i> Inbox <span class="badge"></span>
                        </a>
                    </li>
                    <li <?php $this->helper->hasActivePage($request, 'turn'); ?>>
                        <a href="<?php echo $this->pixie->router->get('default')->url(array('controller' => 'turn')); ?>">
                            <i class="fa fa-upload"></i> Turn <span class="badge"></span>
                        </a>
                    </li>
                    <li <?php $this->helper->hasActivePage($request, 'sent'); ?>>
                        <a href="<?php echo $this->pixie->router->get('default')->url(array('controller' => 'sent')); ?>">
                            <i class="fa fa-envelope"></i> Sent <span class="badge"></span>
                        </a>
                    </li>
                    <li <?php $this->helper->hasActivePage($request, 'templates'); ?>>
                        <a href="<?php echo $this->pixie->router->get('default')->url(array('controller' => 'templates')); ?>">
                            <i class="fa fa-file-text"></i> SMS Templates
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="page-header"><h1><?php echo $title; ?></h1></div>
    <div class="alert alert-<?php echo $messageType; ?>">
        <strong><?php echo $messageType; ?>!</strong> <?php echo $messageText; ?>
    </div>
    <div id="main-content"><?php include($subview . '.php'); ?></div>
</div>
<footer>
    <p class="text-center">&copy; 2015 <a href="https://github.com/demorfi">demorfi</a></p>
</footer>
<script type="text/javascript" src="bootstrap/javascripts/jquery.min.js"></script>
<script type="text/javascript" src="bootstrap/javascripts/bootstrap.min.js"></script>
<script type="text/javascript" src="bootstrap/javascripts/main.js"></script>
</body>
</html>