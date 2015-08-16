<form method="POST" role="form">
    <div class="row">

        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <label class="control-label" for="apply_to">Apply to</label>
                <select name="event[apply_to]" id="apply_to" class="form-control">
                    <option value="inbox"
                        <?php echo $this->helper->has_selected($event->apply_to, 'inbox'); ?>>Inbox
                    </option>
                    <option value="phonecalls"
                        <?php echo $this->helper->has_selected($event->apply_to, 'phonecalls'); ?>>
                        Phone Calls
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label class="control-label" for="addressee">Addressee</label>
                <select name="event[addressee]" id="addressee" class="form-control" data-toggle-group="addressee">
                    <option value="any"
                        <?php echo $this->helper->has_selected($event->addressee, 'any'); ?>>Any
                    </option>
                    <option value="specified"
                        <?php echo $this->helper->has_selected($event->addressee, 'specified'); ?>>Specified
                    </option>
                </select>
            </div>

            <div class="form-group hidden" data-id="specified" data-group="addressee">
                <label class="control-label" for="addressee_from">From</label>
                <input type="text" name="event[addressee_from]" id="addressee_from" class="form-control required"
                       placeholder="79130000000;79130000001" value="<?php echo $event->addressee_from; ?>" required />

                <p class="help-block">Use the separator
                    <strong class="text-primary">;</strong> for multiple addressee.</p>
            </div>

            <div class="form-group">
                <label class="control-label" for="rule">Rule</label>
                <select name="event[rule]" id="rule" class="form-control" data-toggle-group="rule">
                    <option value="no_rule"
                        <?php echo $this->helper->has_selected($event->rule, 'no_rule'); ?>>No Rule
                    </option>
                    <option value="containing"
                        <?php echo $this->helper->has_selected($event->rule, 'containing'); ?>>Containing Text
                    </option>
                </select>
            </div>

            <div class="form-group" data-id="containing" data-group="rule">
                <label class="control-label" for="containing_text">Search Text</label>

                <div class="input-group">
                    <input name="event[search_text]" id="containing_text" class="form-control expression required"
                           placeholder="*" value="<?php echo $event->search_text; ?>" required autofocus />

                    <div class="input-group-btn">
                        <button class="btn btn-info" type="button"
                                data-toggle="modal" data-target="#expression_test">Test
                        </button>
                    </div>
                </div>
                <p class="help-block">You can use the rules of regular expressions.</p>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <label class="control-label" for="action">Action</label>
                <select name="event[action]" id="action" class="form-control" data-toggle-group="action">
                    <option value="no_action"
                        <?php echo $this->helper->has_selected($event->action, 'no_action'); ?>>No Action
                    </option>
                    <option value="run_script"
                        <?php echo $this->helper->has_selected($event->action, 'run_script'); ?>>Run Script
                    </option>
                    <option value="reply"
                        <?php echo $this->helper->has_selected($event->action, 'reply'); ?>>Reply
                    </option>
                    <option value="forward"
                        <?php echo $this->helper->has_selected($event->action, 'forward'); ?>>Forward
                    </option>
                </select>
            </div>

            <div class="form-group" data-group="action" data-id="run_script">
                <label class="control-label" for="script_path">Path to Script</label>
                <input type="text" name="event[script_path]" id="script_path" class="form-control required"
                       value="<?php echo $event->script_path; ?>" required />

                <p class="help-block">In the script will be transmitted
                    information of message through arguments call.</p>
            </div>

            <div class="form-group hidden" data-group="action" data-id="reply">
                <label class="control-label" for="action_reply">Reply Text</label>

                <div class="input-group">
                    <span class="input-group-addon" id="action_reply_length">160</span>
                    <textarea name="event[action_reply]" rows="3" class="form-control required counter"
                              id="action_reply" maxlength="160" placeholder="Enter message text"
                              data-output="#action_reply_length" required><?php echo $event->action_reply; ?></textarea>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="event[action_reply_voice]" class="use-voice"
                            <?php echo $this->helper->has_checked($event->action_reply_voice); ?> /> Use voice
                    </label>
                </div>
                <p class="help-block">After this there can be number and space,
                    which is number of times to repeat the tone sending.<br />
                    Supported tones are #,*,0...9 and the tone list must be comma separated.</p>
            </div>

            <div class="form-group hidden" data-group="action" data-id="forward">
                <label class="control-label" for="action_forward">Phone Number for Forwarding</label>
                <input type="text" name="event[action_forward]" id="action_forward" class="form-control required"
                       placeholder="79130000000" value="<?php echo $event->action_forward; ?>" required />
            </div>

            <div class="form-group hidden" data-group="action" data-id="run_script">
                <label class="control-label" for="result">Result of Script</label>
                <select name="event[result]" id="result" class="form-control" data-toggle-group="result">
                    <option value="ignore"
                        <?php echo $this->helper->has_selected($event->result, 'ignore'); ?>>Ignore
                    </option>
                    <option value="reply"
                        <?php echo $this->helper->has_selected($event->result, 'reply'); ?>>Reply
                    </option>
                    <option value="forward"
                        <?php echo $this->helper->has_selected($event->result, 'forward'); ?>>Forward
                    </option>
                </select>
            </div>

            <div class="form-group hidden" data-group="result" data-id="forward">
                <label class="control-label" for="result_forward">Phone Number for Forwarding</label>
                <input type="text" name="event[result_forward]" id="result_forward" class="form-control required"
                       placeholder="79130000000" value="<?php echo $event->result_forward; ?>" required />
            </div>
        </div>

        <div class="col-xs-12">
            <div class="form-group clearfix">
                <button type="reset" class="btn btn-default">Reset</button>
                <button type="submit" class="btn btn-primary pull-right">Save</button>
            </div>
        </div>

    </div>
</form>

<!-- Expression Test Modal -->
<div class="modal fade" id="expression_test" tabindex="-1" role="dialog" aria-labelledby="expression_test_label"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" role="form">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="expression_test_label">Regular Expression Test</h4>
            </div>
            <div class="modal-body">
                <div class="modal-open">
                    <div class="form-group">
                        <label class="control-label" for="expression_text">Text</label>
                        <input type="text" id="expression_text" class="form-control required" required />
                    </div>
                    <div class="form-group has-feedback">
                        <label class="control-label" for="expression_rule">Regular Expression</label>
                        <input type="text" id="expression_rule" class="form-control required" required />
                        <span class="glyphicon form-control-feedback"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-apply" data-dismiss="modal">Apply</button>
            </div>
        </div>
    </div>
</div>