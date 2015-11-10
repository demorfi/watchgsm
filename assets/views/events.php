<form method="POST" role="form">
    <div class="panel panel-default">
        <div class="panel-heading">Total: <span><?php echo $total_events; ?></span></div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th width="2%">
                        <div class="checkbox input-group-btn">
                            <label>
                                <input type="checkbox" class="checker" />
                            </label>
                        </div>
                    </th>
                    <th width="8%">Apply to</th>
                    <th width="15%">Addressee</th>
                    <th width="15%">Rule</th>
                    <th width="45%">Action</th>
                    <th width="10%">Last Run</th>
                    <th width="5%"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($events as $event) { ?>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="eventsId[]" value="<?php echo $event->id; ?>" />
                                </label>
                            </div>
                        </td>
                        <td><?php
                            switch ($event->apply_to) {
                                case('inbox'):
                                    echo 'Inbox';
                                    break;
                                case('phonecalls'):
                                    echo 'Phone Calls';
                            }
                            ?></td>
                        <td><?php
                            switch ($event->addressee) {
                                case('any'):
                                    echo 'Any';
                                    break;
                                case('specified'):
                                    echo implode('<br />', $this->helper->explode(';', $event->addressee_from));
                                    break;
                            }
                            ?></td>
                        <td><?php
                            switch ($event->rule) {
                                case('no_rule'):
                                    echo 'No Rule';
                                    break;
                                case('containing'):
                                    echo 'Containing Text';
                                    break;
                            }
                            ?></td>
                        <td><?php
                            switch ($event->action) {
                                case('no_action'):
                                    echo 'No Action';
                                    break;
                                case('run_script'):
                                    echo 'Run Script ' . $event->script_path;
                                    break;
                                case('reply'):
                                    echo 'Reply';
                                    break;
                                case('forward'):
                                    echo 'Forward ' . $event->action_forward;
                                    break;
                            }
                            ?></td>
                        <td data-timestamp="<?php echo $event->last_run; ?>"><?php
                            echo empty($event->last_run) ? 'Never' : $this->helper->date_format($event->last_run);
                            ?></td>
                        <td>
                            <a href="<?php echo $this->pixie->router->get('default')->url(
                                array('controller' => 'events', 'action' => 'edit', 'id' => $event->id)
                            ); ?>" class="btn btn-info">Edit</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="panel-footer">
            <button type="submit" name="delete" class="btn btn-danger btn-auto-active" disabled>Delete</button>
            <a href="<?php echo $this->pixie->router->get('default')->url(
                array('controller' => 'events', 'action' => 'add')
            ); ?>" class="btn btn-primary">New Event</a>
        </div>
    </div>
</form>