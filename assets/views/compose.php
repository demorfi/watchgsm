<form class="form-horizontal" method="POST" role="form">
    <div class="form-group">
        <label class="col-sm-2 control-label" for="number">To Number:</label>

        <div class="col-sm-10">
            <input type="text" name="number" class="form-control" id="number"
                   placeholder="79130000000" required />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="message">Message:</label>

        <div class="col-sm-10">
            <div class="input-group">
                <span class="input-group-addon" id="message-length">160</span>
                <textarea name="message" rows="3" class="form-control counter" id="message" maxlength="160"
                          placeholder="Enter message text" data-output="#message-length" required></textarea>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="use_voice" class="use-voice" /> Use voice
                </label>
            </div>
            <p class="help-block">After this there can be number and space,
                which is number of times to repeat the tone sending.<br />
                Supported tones are #,*,0...9 and the tone list must be comma separated.</p>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary">Send</button>
            <button type="submit" class="btn btn-default" name="save-template">Save as Template</button>
        </div>
    </div>
</form>