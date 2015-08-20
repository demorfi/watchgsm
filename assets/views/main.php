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
    <link href="bootstrap/stylesheets/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="bootstrap/stylesheets/font-awesome.min.css" rel="stylesheet" />
    <link href="bootstrap/stylesheets/custom.css" rel="stylesheet" />
</head>
<body data-controller="<?php echo $this->request->param('controller'); ?>"
      data-action="<?php echo $this->request->param('action'); ?>">
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

                <?php if ($this->helper->has_smstools_var('outgoing')) { ?>
                    <li <?php $this->helper->has_active_page($request, 'compose'); ?>>
                        <a href="<?php echo $this->pixie->router->get('default')->url(
                            array('controller' => 'compose')
                        ); ?>">
                            <i class="fa fa-compose"></i> Compose
                        </a>
                    </li>
                <?php } ?>

                <?php if ($this->helper->has_smstools_var('incoming')) { ?>
                    <li <?php $this->helper->has_active_page($request, 'inbox'); ?>>
                        <a href="<?php echo $this->pixie->router->get('default')->url(
                            array('controller' => 'inbox')
                        ); ?>">
                            <i class="fa fa-inbox"></i> Inbox
                            <span class="badge"><?php echo $this->helper->get_count_messages('inbox', true); ?></span>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($this->helper->has_smstools_var('sent')) { ?>

                    <li <?php $this->helper->has_active_page($request, array('turn', 'sent', 'failed')); ?>>
                        <a href="<?php echo $this->pixie->router->get('default')->url(
                            array('controller' => 'sent')
                        ); ?>" data-toggle="dropdown" class="dropdown-toggle">
                            <i class="fa fa-share-square"></i> Dispatch <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">

                            <?php if ($this->helper->has_smstools_var('outgoing')) { ?>
                                <li <?php $this->helper->has_active_page($request, 'turn'); ?>>
                                    <a href="<?php echo $this->pixie->router->get('default')->url(
                                        array('controller' => 'turn')
                                    ); ?>">
                                        <span class="badge pull-right"><?php echo $this->helper->get_count_messages('turn', true); ?></span>
                                        <i class="fa fa-turn"></i> Turn
                                    </a>
                                </li>
                            <?php } ?>

                            <li <?php $this->helper->has_active_page($request, 'sent'); ?>>
                                <a href="<?php echo $this->pixie->router->get('default')->url(
                                    array('controller' => 'sent')
                                ); ?>">
                                    <span class="badge pull-right"><?php echo $this->helper->get_count_messages('sent', true); ?></span>
                                    <i class="fa fa-sent"></i> Sent
                                </a>
                            </li>

                            <li <?php $this->helper->has_active_page($request, 'failed'); ?>>
                                <a href="<?php echo $this->pixie->router->get('default')->url(
                                    array('controller' => 'failed')
                                ); ?>">
                                    <span class="badge pull-right"><?php echo $this->helper->get_count_messages('failed', true); ?></span>
                                    <i class="fa fa-failed"></i> Failed
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>

                <?php if ($this->helper->has_smstools_var('phonecalls')) { ?>
                    <li <?php $this->helper->has_active_page($request, 'phonecalls'); ?>>
                        <a href="<?php echo $this->pixie->router->get('default')->url(
                            array('controller' => 'phonecalls')
                        ); ?>">
                            <i class="fa fa-phonecalls"></i> Phone calls
                            <span class="badge"><?php echo $this->helper->get_count_messages('phonecalls', true); ?></span>
                        </a>
                    </li>
                <?php } ?>

                <li <?php $this->helper->has_active_page($request, 'templates'); ?>>
                    <a href="<?php echo $this->pixie->router->get('default')->url(
                        array('controller' => 'templates')
                    ); ?>">
                        <i class="fa fa-templates"></i> SMS Templates
                    </a>
                </li>

                <li <?php $this->helper->has_active_page($request, 'events'); ?>>
                    <a href="<?php echo $this->pixie->router->get('default')->url(
                        array('controller' => 'events')
                    ); ?>">
                        <i class="fa fa-events"></i> Events
                    </a>
                </li>

                <?php if ($this->helper->has_smstools_var('logfile')) { ?>
                    <li <?php $this->helper->has_active_page($request, 'logs'); ?>>
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
    <div class="page-header" data-id="<?php echo $subview; ?>">
        <h1><i class="fa fa-<?php echo $subview; ?>"></i> <?php echo $title; ?></h1>
    </div>
    <?php if (!empty($message_text)) { ?>
        <div class="alert <?php echo !empty($message_type) ? 'alert-' . $message_type : ''; ?>">
            <?php echo $message_text; ?>
        </div>
    <?php } ?>
    <div id="main-content"><?php include($subview . '.php'); ?></div>
</div>

<footer class="footer">
    <div class="container">
        <p class="text-muted">
            <a href="https://github.com/demorfi/watchgsm" target="_blank">
                <i class="fa fa-code"></i> with <i class="fa fa-heart"></i> in Siberia.
            </a>
        </p>
    </div>
</footer>

<script type="text/javascript" src="bootstrap/javascripts/jquery.min.js"></script>
<script type="text/javascript" src="bootstrap/javascripts/moment.min.js"></script>
<script type="text/javascript" src="bootstrap/javascripts/moment-timezone-with-data.min.js"></script>
<script type="text/javascript" src="bootstrap/javascripts/bootstrap.min.js"></script>
<script type="text/javascript" src="bootstrap/javascripts/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="bootstrap/javascripts/main.js"></script>
</body>
</html>