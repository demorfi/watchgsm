<form method="POST" role="form">
    <div class="panel panel-default">
        <div class="panel-heading">Total: <span><?php echo $total_messages; ?></span></div>
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
                    <th width="10%">Date & Time</th>
                    <th width="10%">To</th>
                    <th width="30%">Reason</th>
                    <th width="48%">Text</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($messages as $message) { ?>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="messagesId[]" value="<?php echo $message->id; ?>" />
                                </label>
                            </div>
                        </td>
                        <td data-timestamp="<?php echo $message->timestamp; ?>"
                            data-timezone="<?php echo $this->helper->timezone(); ?>">
                            <?php echo $this->helper->date_format($message->timestamp); ?>
                        </td>
                        <td><?php echo $message->to; ?></td>
                        <td><?php echo $message->reason; ?></td>
                        <td><?php echo $message->text; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="panel-footer">
            <button type="submit" name="delete" class="btn btn-danger btn-auto-active" disabled>Delete</button>
            <button type="submit" name="send" class="btn btn-primary btn-auto-active" disabled>Send again</button>
        </div>
    </div>
</form>