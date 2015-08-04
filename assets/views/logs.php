<ul class="nav nav-pills">
    <li class="active <?php echo empty($log_daemon) ? 'disabled' : ''; ?>">
        <a href="#daemon" data-toggle="pill">Daemon</a>
    </li>
    <li class="<?php echo empty($log_regular_run) ? 'disabled' : ''; ?>">
        <a href="#regular-run" data-toggle="pill">Regular run <?php echo $device; ?></a>
    </li>
</ul>

<div class="tab-content navbar-btn">
    <div class="tab-pane active" id="daemon">
        <div class="well"><?php echo nl2br($log_daemon); ?></div>
    </div>
    <div class="tab-pane" id="regular-run">
        <div class="well"><?php echo nl2br($log_regular_run); ?></div>
    </div>
</div>
