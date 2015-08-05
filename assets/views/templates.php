<form method="POST" role="form">
    <div class="panel panel-default">
        <div class="panel-heading">Total: <?php echo sizeof($templates); ?></div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th width="2%">#</th>
                    <th width="10%">To</th>
                    <th width="88%">Text</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($templates as $template) { ?>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="templatesId[]" value="<?php echo $template->id; ?>" />
                                </label>
                            </div>
                        </td>
                        <td><?php echo $template->to; ?></td>
                        <td><?php echo $template->text; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="panel-footer">
            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
            <button type="submit" name="send" class="btn btn-primary">Send</button>
        </div>
    </div>
</form>