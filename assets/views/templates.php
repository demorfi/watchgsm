<form method="POST" role="form">
    <div class="panel panel-default">
        <div class="panel-heading">Total: <span><?php echo $total_templates; ?></span></div>
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
            <button type="submit" name="delete" class="btn btn-danger btn-auto-active" disabled>Delete</button>
            <button type="submit" name="send" class="btn btn-primary btn-auto-active" disabled>Send</button>
            <button type="button" class="btn btn-info btn-auto-active"
                    data-toggle="modal" data-target="#schedule" disabled>Schedule
            </button>
        </div>
    </div>

    <!-- Schedule Modal -->
    <div class="modal fade" id="schedule" tabindex="-1" role="dialog" aria-labelledby="scheduleLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="scheduleLabel">Schedule Date</h4>
                </div>
                <div class="modal-body">
                    <div class="modal-open">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="datetimepicker" data-inline="true" data-side-by-side="true"
                                         data-format="DD-MM-YYYY HH:mm"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" name="schedule" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>