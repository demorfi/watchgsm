<form method="POST" role="form">
    <div class="panel panel-default">
        <div class="panel-heading">Total: <?php echo sizeof($calls); ?></div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th width="2%" class="text-center">#</th>
                    <th width="10%">Date & Time</th>
                    <th width="10%">From</th>
                    <th width="78%">Text</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($calls as $call) { ?>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="name[]" value="<?php echo $call['name']; ?>" />
                                </label>
                            </div>
                        </td>
                        <td><?php echo $call['datetime']; ?></td>
                        <td><?php echo $call['from']; ?></td>
                        <td><?php echo $call['text']; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="panel-footer">
            <button type="submit" class="btn btn-danger">Delete</button>
        </div>
    </div>
</form>