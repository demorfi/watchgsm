<ul class="nav nav-pills">
    <li class="active <?php echo empty($logDaemon) ? 'disabled' : ''; ?>">
        <a href="#daemon" data-toggle="pill">Daemon</a>
    </li>
    <li class="<?php echo empty($logRegularRun) ? 'disabled' : ''; ?>">
        <a href="#regular-run" data-toggle="pill">Regular run <?php echo $device; ?></a>
    </li>
</ul>

<div class="tab-content navbar-btn">
    <div class="tab-pane active" id="daemon">
        <div class="well"><?php echo nl2br($logDaemon); ?></div>
    </div>
    <div class="tab-pane" id="regular-run">
        <div class="well"><?php echo nl2br($logRegularRun); ?></div>
    </div>
</div>
