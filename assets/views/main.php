<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <base href="<?php echo $this->pixie->basepath; ?>" />
    <title>Watchdog GSM<?php echo $title ? ' | ' . $title : ''; ?></title>
    <link href="bootstrap/stylesheets/bootstrap.min.css" rel="stylesheet" />
    <link href="bootstrap/stylesheets/font-awesome.min.css" rel="stylesheet" />
    <link href="bootstrap/stylesheets/custom.css" rel="stylesheet" />
</head>
<body>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#top-navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo $this->pixie->basepath; ?>">WatchGSM</a>
        </div>
        <div class="collapse navbar-collapse" id="top-navbar">
            <ul class="nav navbar-nav">

                <?php if ($this->helper->hasConfigVariable('outgoing')) { ?>
                    <li <?php $this->helper->hasActivePage($request, 'compose'); ?>>
                        <a href="<?php echo $this->pixie->router->get('default')->url(
                            array('controller' => 'compose')
                        ); ?>">
                            <i class="fa fa-compose"></i> Compose
                        </a>
                    </li>
                <?php } ?>

                <?php if ($this->helper->hasConfigVariable('incoming')) { ?>
                    <li <?php $this->helper->hasActivePage($request, 'inbox'); ?>>
                        <a href="<?php echo $this->pixie->router->get('default')->url(
                            array('controller' => 'inbox')
                        ); ?>">
                            <i class="fa fa-inbox"></i> Inbox <span class="badge"></span>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($this->helper->hasConfigVariable('outgoing')) { ?>
                    <li <?php $this->helper->hasActivePage($request, 'turn'); ?>>
                        <a href="<?php echo $this->pixie->router->get('default')->url(
                            array('controller' => 'turn')
                        ); ?>">
                            <i class="fa fa-turn"></i> Turn <span class="badge"></span>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($this->helper->hasConfigVariable('sent')) { ?>
                    <li <?php $this->helper->hasActivePage($request, 'sent'); ?>>
                        <a href="<?php echo $this->pixie->router->get('default')->url(
                            array('controller' => 'sent')
                        ); ?>">
                            <i class="fa fa-sent"></i> Sent <span class="badge"></span>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($this->helper->hasConfigVariable('phonecalls')) { ?>
                    <li <?php $this->helper->hasActivePage($request, 'phonecalls'); ?>>
                        <a href="<?php echo $this->pixie->router->get('default')->url(
                            array('controller' => 'phonecalls')
                        ); ?>">
                            <i class="fa fa-phonecalls"></i> Phone calls <span class="badge"></span>
                        </a>
                    </li>
                <?php } ?>

                <li <?php $this->helper->hasActivePage($request, 'templates'); ?>>
                    <a href="<?php echo $this->pixie->router->get('default')->url(
                        array('controller' => 'templates')
                    ); ?>">
                        <i class="fa fa-templates"></i> SMS Templates
                    </a>
                </li>

                <li <?php $this->helper->hasActivePage($request, 'events'); ?>>
                    <a href="<?php echo $this->pixie->router->get('default')->url(
                        array('controller' => 'events')
                    ); ?>">
                        <i class="fa fa-events"></i> Events
                    </a>
                </li>

                <?php if ($this->helper->hasConfigVariable('logfile')) { ?>
                    <li <?php $this->helper->hasActivePage($request, 'logs'); ?>>
                        <a href="<?php echo $this->pixie->router->get('default')->url(
                            array('controller' => 'logs')
                        ); ?>">
                            <i class="fa fa-logs"></i> Logs
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <div class="page-header">
        <h1><i class="fa fa-<?php echo $subview; ?>"></i> <?php echo $title; ?>
            <small></small>
        </h1>
    </div>
    <?php if (!empty($messageText)) { ?>
        <div class="alert <?php echo !empty($messageType) ? 'alert-' . $messageType : ''; ?>">
            <?php echo $messageText; ?>
        </div>
    <?php } ?>
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