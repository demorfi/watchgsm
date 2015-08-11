<ul class="list-inline">

    <!-- daemon logs -->
    <li>
        <fieldset <?php echo empty($log_daemon) ? ' disabled ' : ''; ?>>
            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-target="#daemon" data-toggle="pill">Daemon</button>
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Options</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="<?php echo $this->pixie->router->get('default')->url(
                            array('controller' => 'logs')
                        ); ?>?clear=daemon"><i class="fa fa-trash"></i> Clear log file</a>
                    </li>
                </ul>
            </div>
        </fieldset>
    </li>

    <!-- regular run logs -->
    <li>
        <fieldset <?php echo empty($log_regular_run) ? ' disabled ' : ''; ?>>
            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-target="#regular-run"
                        data-toggle="pill">Regular run <?php echo $device; ?></button>
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Options</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="<?php echo $this->pixie->router->get('default')->url(
                            array('controller' => 'logs')
                        ); ?>?clear=regular-run"><i class="fa fa-trash"></i> Clear log file</a>
                    </li>
                </ul>
            </div>
        </fieldset>
    </li>
</ul>

<div class="tab-content navbar-btn">
    <div class="tab-pane active" id="daemon">
        <div class="well"><?php echo empty($log_daemon) ? 'Empty' : nl2br($log_daemon); ?></div>
    </div>
    <div class="tab-pane" id="regular-run">
        <div class="well"><?php echo empty($log_regular_run) ? 'Empty' : nl2br($log_regular_run); ?></div>
    </div>
</div>
